package images

import (
	"fmt"
	"io"
	"log"
	"net/http"
	"os"
	"panorama/internal/storage"
	"path/filepath"
	"time"

	"github.com/joho/godotenv"
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

func UploadHandler(w http.ResponseWriter, r *http.Request) {
	err := godotenv.Load()
	if err != nil {
		log.Fatal("Error loading .env file")
	}
	if r.Method != "POST" {
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
		return
	}

	file, fileHeader, err := r.FormFile("file")
	if err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	name := r.FormValue("rezident")
	if name == "" {
		http.Error(w, "where is rezident?", http.StatusBadRequest)
		log.Fatal("rezident == nil")
		return
	}

	defer file.Close()

	buff := make([]byte, 512)
	_, err = file.Read(buff)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	filetype := http.DetectContentType(buff)
	if filetype != "image/jpeg" && filetype != "image/png" {
		http.Error(w, "The provided file format is not allowed. Please upload a JPEG or PNG image", http.StatusBadRequest)
		return
	}

	_, err = file.Seek(0, io.SeekStart)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Create the uploads folder if it doesn't
	// already exist
	err = os.MkdirAll("./uploads", os.ModePerm)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Create a new file in the uploads directory
	filename := fmt.Sprintf("%s-%d", name, time.Now().UnixNano())
	filename_with_ext := fmt.Sprintf("%s%s", filename, filepath.Ext(fileHeader.Filename))
	destination := fmt.Sprintf("./uploads/%s", filename_with_ext)
	dst, err := os.Create(destination)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	defer dst.Close()

	_, err = io.Copy(dst, file)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	destination_resize := fmt.Sprintf("./uploads/resized-%s", filename_with_ext)
	ResizeImage(destination, destination_resize)

	aws := storage.Init()
	_ = aws

	inImage, ext, err := ReadImage(destination_resize)
	if err != nil {
		log.Fatal(err)
	}

	canvases := ConverEquirectangularToCubemap(1024, inImage)

	all, err := WriteImage(canvases, fmt.Sprintf("./uploads/%s", filename), ext)
	if err != nil {
		log.Fatal(err)
	}
	log.Print(all)
	_ = all
	var results []interface{}
	for i := 0; i < 6; i++ {
		switch i {
		case 0:
			results = append(results, fmt.Sprintf("%suploads/%s", os.Getenv("API_URL"), filename+"-px."+ext))
		case 1:
			results = append(results, fmt.Sprintf("%suploads/%s", os.Getenv("API_URL"), filename+"-nx."+ext))
		case 2:
			results = append(results, fmt.Sprintf("%suploads/%s", os.Getenv("API_URL"), filename+"-py."+ext))
		case 3:
			results = append(results, fmt.Sprintf("%suploads/%s", os.Getenv("API_URL"), filename+"-ny."+ext))
		case 4:
			results = append(results, fmt.Sprintf("%suploads/%s", os.Getenv("API_URL"), filename+"-pz."+ext))
		case 5:
			results = append(results, fmt.Sprintf("%suploads/%s", os.Getenv("API_URL"), filename+"-nz."+ext))
		}
	}

	jsonData := []byte(fmt.Sprintf(`{"url": %s}`, fmt.Sprintf("[\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"]", results...)))

	w.Write([]byte(jsonData))
}
