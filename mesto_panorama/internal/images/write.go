package images

import (
	"errors"
	"image"
	"image/jpeg"
	"image/png"
	"os"
	"path/filepath"
)

const faceLen = 6

var faceMap = map[int]string{
	0: "pz",
	1: "px",
	2: "nz",
	3: "nx",
	4: "py",
	5: "ny",
}

func WriteImage(canvases []*image.RGBA, writeDirPath, imgExt string) error {
	if len(canvases) != faceLen {
		return errors.New("wrong face size")
	}

	if _, err := os.Stat(writeDirPath); os.IsNotExist(err) {
		if err := os.MkdirAll(writeDirPath, os.ModePerm); err != nil {
			return err
		}
	}

	for i := 0; i < faceLen; i++ {
		path := filepath.Join(writeDirPath, faceMap[i]+"."+imgExt)
		newFile, _ := os.Create(path)

		switch imgExt {
		case "jpeg":
			if err := jpeg.Encode(newFile, canvases[i], nil); err != nil {
				return err
			}
		case "png":
			if err := png.Encode(newFile, canvases[i]); err != nil {
				return err
			}
		default:
			return errors.New("Wrong image file format : " + imgExt)
		}
	}
	return nil
}
