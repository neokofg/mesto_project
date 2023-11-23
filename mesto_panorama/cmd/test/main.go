package main

import (
	"log"
	"panorama/internal/images"
)

func main() {
	inImage, ext, err := images.ReadImage("./output.jpg")
	if err != nil {
		log.Fatal(err)
	}

	canvases := images.ConverEquirectangularToCubemap(1024, inImage)

	if err := images.WriteImage(canvases, ".", ext); err != nil {
		log.Fatal(err)
	}
}
