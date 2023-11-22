package images

import (
	"fmt"
	"image"
	"image/color"
	"log"

	"github.com/disintegration/imaging"
	"github.com/nfnt/resize"
)

func ResizeImage(imagePath string) {
	// Загрузка изображения из файла
	srcImage, err := imaging.Open(imagePath)
	if err != nil {
		log.Fatalf("failed to open image: %v", err)
	}

	log.Print("hello")
	// Изменение размера изображения до 2:1
	resizedImage := resize.Resize(uint(1024*8), uint(1024*4), srcImage, resize.Lanczos3)

	log.Print("hello")
	// Применение размытия сверху и снизу
	blurredImage := applyBlur(resizedImage, 80) // Измените значение аргумента для управления степенью размытия

	log.Print("hello")
	// Сохранение результата в новый файл
	outputPath := "output.jpg"
	err = imaging.Save(blurredImage, outputPath)
	if err != nil {
		log.Fatalf("failed to save image: %v", err)
	}

	log.Print("hello")
	fmt.Printf("Processed image saved to %s\n", outputPath)
}

// applyBlur применяет размытие сверху и снизу к изображению
func applyBlur(img image.Image, blurAmount int) image.Image {
	bounds := img.Bounds()
	width, height := bounds.Dx(), bounds.Dy()

	// Создание нового изображения с применением размытия
	blurredImg := imaging.New(width, height, color.RGBA{0, 0, 0, 0})
	//
	// // Вычисление высоты области для размытия (1/8 от высоты изображения)
	blurHeight := height / 5
	resizedImage := resize.Resize(uint(1024*8), uint(4096-blurHeight*2), img, resize.Lanczos3)
	//
	// // Создание верхней и нижней области для размытия
	blurredImg = imaging.Paste(blurredImg, resizedImage, image.Pt(0, blurHeight))
	topBlurArea := image.Rect(0, 0, width, blurHeight)
	bottomBlurArea := image.Rect(0, height-blurHeight, width, height)
	//
	// // Применение размытия к верхней и нижней областям
	// blurredImg = imaging.Blur(blurredImg, float64(blurAmount))
	blurredImgTop := imaging.Crop(blurredImg, topBlurArea)
	topBlurred := imaging.Blur(blurredImgTop, float64(blurAmount))
	blurredImg = imaging.Paste(blurredImg, topBlurred, image.Pt(0, 0))
	//
	blurredImgBottom := imaging.Crop(blurredImg, bottomBlurArea)
	bottomBlurred := imaging.Blur(blurredImgBottom, float64(blurAmount))
	blurredImg = imaging.Paste(blurredImg, bottomBlurred, image.Pt(0, height-blurHeight))
	//
	return blurredImg
}
