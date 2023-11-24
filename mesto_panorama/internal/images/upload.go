package images

import (
	"errors"
	"fmt"
	"log"
	"os"
	"panorama/internal/storage"
	"path/filepath"
	"strings"

	"github.com/gofiber/fiber/v2"
	"github.com/joho/godotenv"

	iuliia "github.com/mehanizm/iuliia-go"
)

const MAX_UPLOAD_SIZE = 1024 * 1024 * 20

type Progress struct {
	TotalSize int64
	BytesRead int64
}

func (pr *Progress) Write(p []byte) (n int, err error) {
	n, err = len(p), nil
	pr.BytesRead += int64(n)
	pr.Print()
	return
}

func (pr *Progress) Print() {
	if pr.BytesRead == pr.TotalSize {
		fmt.Println("DONE!")
		return
	}

	fmt.Printf("File upload in progress: %d\n", pr.BytesRead)
}

var Counter = 0

func UploadHandler(c *fiber.Ctx) error {
	err := godotenv.Load()
	if err != nil {
		log.Fatal("Error loading .env file")
		return err
	}

	file, err := c.FormFile("file")
	if err != nil {
		c.Status(fiber.StatusBadRequest).SendString(err.Error())
		return err
	}

	name := iuliia.Wikipedia.Translate(c.FormValue("rezident"))
	if name == "" {
		c.Status(fiber.StatusBadRequest).SendString(name)
		log.Fatal("rezident == nil")
		return errors.New("name === rezident")
	}

	filetype := filepath.Ext(file.Filename)
	if filetype != ".jpg" && filetype != ".jpeg" && filetype != ".png" {
		c.Status(fiber.StatusBadRequest).SendString("wt")
		return errors.New(filetype)
	}
	err = os.MkdirAll("./frontend/dist/uploads", os.ModePerm)
	if err != nil {
		c.Status(fiber.StatusBadRequest).SendString(err.Error())
		return err
	}

	dry_filename := name
	filename := strings.ReplaceAll(dry_filename, " ", "_")

	filename_with_ext := fmt.Sprintf("%s%s", filename, filepath.Ext(file.Filename))
	destination := fmt.Sprintf("./frontend/dist/uploads/%s", filename_with_ext)

	err = c.SaveFile(file, destination)
	if err != nil {
		return c.Status(fiber.StatusInternalServerError).SendString("Failed to save image")
	}

	destination_resize := fmt.Sprintf("./frontend/dist/uploads/resized-%s", filename_with_ext)
	ResizeImage(destination, destination_resize)

	aws := storage.Init()
	_ = aws

	inImage, ext, err := ReadImage(destination_resize)
	if err != nil {
		log.Fatal(err)
	}

	canvases := ConverEquirectangularToCubemap(1024, inImage)

	all, err := WriteImage(canvases, fmt.Sprintf("./frontend/dist/uploads/%s", filename), ext)
	if err != nil {
		log.Fatal(err)
	}
	log.Print(all)
	_ = all
	var results []URL
	for i := 0; i < 6; i++ {
		switch i {
		case 0:
			results = append(results, fmt.Sprintf("%sfrontend/dist/uploads/%s", os.Getenv("API_URL"), filename+"-px."+ext))
		case 1:
			results = append(results, fmt.Sprintf("%sfrontend/dist/uploads/%s", os.Getenv("API_URL"), filename+"-nx."+ext))
		case 2:
			results = append(results, fmt.Sprintf("%sfrontend/dist/uploads/%s", os.Getenv("API_URL"), filename+"-py."+ext))
		case 3:
			results = append(results, fmt.Sprintf("%sfrontend/dist/uploads/%s", os.Getenv("API_URL"), filename+"-ny."+ext))
		case 4:
			results = append(results, fmt.Sprintf("%sfrontend/dist/uploads/%s", os.Getenv("API_URL"), filename+"-pz."+ext))
		case 5:
			results = append(results, fmt.Sprintf("%sfrontend/dist/uploads/%s", os.Getenv("API_URL"), filename+"-nz."+ext))
		}
	}

	c.JSON(URLResponse{
		URL: results,
	})
	return nil
}

type URL interface{}

type URLResponse struct {
	URL []URL `json:"url"`
}
