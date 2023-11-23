package main

import (
	"log"
	"net/http"
	"panorama/internal/images"
)

func main() {
	mux := http.NewServeMux()
	// Frontend
	mux.Handle("/", http.FileServer(http.Dir("frontend/dist")))
	// upload images
	fs := http.FileServer(http.Dir("uploads"))
	mux.Handle("/uploads/", http.StripPrefix("/uploads/", fs))
	mux.HandleFunc("/api/upload", images.UploadHandler)

	if err := http.ListenAndServe(":8080", mux); err != nil {
		log.Fatal(err)
	}
}
