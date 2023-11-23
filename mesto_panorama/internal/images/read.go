package images

import (
	"errors"
	"image"
	"os"
)

func ReadImage(imagePath string) (image.Image, string, error) {
	if _, err := os.Stat(imagePath); os.IsNotExist(err) {
		return nil, "", err
	}

	imgFile, _ := os.Open(imagePath)
	defer imgFile.Close()

	imgIn, ext, err := image.Decode(imgFile)
	if err != nil {
		return nil, "", err
	}

	if ext == "jpeg" || ext == "png" {
		return imgIn, ext, nil
	}

	return nil, "", errors.New("We do not support this format : " + ext)
}
