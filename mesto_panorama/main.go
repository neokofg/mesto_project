package main

import (
	"log"
	"panorama/internal/images"

	rice "github.com/GeertJohan/go.rice"
	"github.com/gobuffalo/packr/v2"
	"github.com/gofiber/fiber/v2"
	"github.com/gofiber/fiber/v2/middleware/cors"
	"github.com/gofiber/fiber/v2/middleware/filesystem"
)

func main() {
	app := fiber.New(fiber.Config{
		BodyLimit: 100 * 1024 * 1024, // this is the default limit of 100MB
	},
	)
	app.Use(cors.New(cors.Config{
		AllowOrigins: "",
		AllowHeaders: "Origin, Content-Type, Accept",
	}))

	app.Get("/*", filesystem.New(filesystem.Config{
		Root: rice.MustFindBox("frontend/dist").HTTPBox(),
	}))
	app.Use("/uploads/", filesystem.New(filesystem.Config{
		Root: packr.New("Uploads", "/uploads"),
	}))

	app.Post("/api/upload/", images.UploadHandler)

	log.Fatal(app.Listen(":3000"))
	// mux := http.NewServeMux()
	// // Frontend
	// mux.Handle("/", http.FileServer(http.Dir("frontend/dist")))
	// // upload images
	// fs := http.FileServer(http.Dir("uploads"))
	// mux.Handle("/uploads/", http.StripPrefix("/uploads/", fs))
	// mux.HandleFunc("/api/upload", images.UploadHandler)
	//
	// if err := http.ListenAndServe(":3000", mux); err != nil {
	// 	log.Fatal(err)
	// }
}
