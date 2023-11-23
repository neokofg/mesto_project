package storage

import (
	"context"
	"fmt"
	"log"
	"os"

	"github.com/aws/aws-sdk-go-v2/aws"
	"github.com/aws/aws-sdk-go-v2/config"
	"github.com/aws/aws-sdk-go-v2/credentials"
	"github.com/aws/aws-sdk-go-v2/service/s3"
	smithyendpoints "github.com/aws/smithy-go/endpoints"
	"github.com/joho/godotenv"
)

type resolverV2 struct{}

func (*resolverV2) ResolveEndpoint(ctx context.Context, params s3.EndpointParameters) (
	smithyendpoints.Endpoint, error,
) {
	fmt.Printf("The endpoint provided in config is %s\n", *params.Endpoint)
	return s3.NewDefaultEndpointResolverV2().ResolveEndpoint(ctx, params)
}

type BucketBasics struct {
	S3Client *s3.Client
	S3Bucket string
}

func Init() *BucketBasics {
	err := godotenv.Load()
	if err != nil {
		log.Fatal("Error loading .env file")
	}
	key := os.Getenv("AWS_ACCESS_KEY_ID")
	secret := os.Getenv("AWS_SECRET_ACCESS_KEY")
	s3bucket := os.Getenv("AWS_BUCKET")
	cfg, err := config.LoadDefaultConfig(context.TODO(), config.WithCredentialsProvider(credentials.NewStaticCredentialsProvider(key, secret, "")))
	if err != nil {
		log.Fatal(err)
	}

	endpoint := os.Getenv("AWS_ENDPOINT")

	client := s3.NewFromConfig(cfg, func(o *s3.Options) {
		o.BaseEndpoint = aws.String(endpoint)
		o.EndpointResolverV2 = &resolverV2{}
	})

	return &BucketBasics{
		S3Client: client,
		S3Bucket: s3bucket,
	}
}

func (basics BucketBasics) UploadFile(objectKey string, fileName string) error {
	file, err := os.Open(fileName)
	if err != nil {
		log.Printf("Couldn't open file %v to upload. Here's why: %v\n", fileName, err)
	} else {
		defer file.Close()
		_, err = basics.S3Client.PutObject(context.TODO(), &s3.PutObjectInput{
			Bucket: aws.String(basics.S3Bucket),
			Key:    aws.String(objectKey),
			Body:   file,
		})
		if err != nil {
			log.Printf("Couldn't upload file %v to %v:%v. Here's why: %v\n",
				fileName, basics.S3Bucket, objectKey, err)
		}
	}
	return err
}
