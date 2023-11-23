package images

import (
	"fmt"
	"image"
	"image/color"
	"log"

	"github.com/disintegration/imaging"
	"github.com/nfnt/resize"
)

func ResizeImage(imagePath, outputPath string) {
	srcImage, err := imaging.Open(imagePath)
	if err != nil {
		log.Fatalf("failed to open image: %v", err)
	}
	resizedImage := resize.Resize(uint(1024*8), uint(1024*4), srcImage, resize.Lanczos3)

	blurredImage := applyBlur(resizedImage, 80)
	err = imaging.Save(blurredImage, outputPath)
	if err != nil {
		log.Fatalf("failed to save image: %v", err)
	}
	fmt.Printf("Processed image saved to %s\n", outputPath)
}

func applyBlur(img image.Image, blurAmount int) image.Image {
	bounds := img.Bounds()
	width, height := bounds.Dx(), bounds.Dy()
	blurredImg := imaging.New(width, height, color.RGBA{0, 0, 0, 0})
	blurHeight := height / 5
	resizedImage := resize.Resize(uint(1024*8), uint(4096-blurHeight*2), img, resize.Lanczos3)
	blurredImg = imaging.Paste(blurredImg, resizedImage, image.Pt(0, blurHeight))
	topBlurArea := image.Rect(0, 0, width, blurHeight)
	bottomBlurArea := image.Rect(0, height-blurHeight, width, height)
	blurredImgTop := imaging.Crop(blurredImg, topBlurArea)
	topBlurred := imaging.Blur(blurredImgTop, float64(blurAmount))
	blurredImg = imaging.Paste(blurredImg, topBlurred, image.Pt(0, 0))
	blurredImgBottom := imaging.Crop(blurredImg, bottomBlurArea)
	bottomBlurred := imaging.Blur(blurredImgBottom, float64(blurAmount))
	blurredImg = imaging.Paste(blurredImg, bottomBlurred, image.Pt(0, height-blurHeight))
	return blurredImg
}
