package images

import (
	"errors"
	"fmt"
	"image"
	"image/jpeg"
	"image/png"
	"os"
)

const faceLen = 6

var FaceMap = map[int]string{
	0: "pz",
	1: "px",
	2: "nz",
	3: "nx",
	4: "py",
	5: "ny",
}

func WriteImage(canvases []*image.RGBA, writeDirPath, imgExt string) ([]string, error) {
	if len(canvases) != faceLen {
		return nil, errors.New("wrong face size")
	}

	if _, err := os.Stat(writeDirPath); os.IsNotExist(err) {
		if err := os.MkdirAll(writeDirPath, os.ModePerm); err != nil {
			return nil, err
		}
	}
	for i := 0; i < faceLen; i++ {
		path := fmt.Sprintf("%s-%s", writeDirPath, FaceMap[i]+"."+imgExt)
		newFile, _ := os.Create(path)

		switch imgExt {
		case "jpeg":
			if err := jpeg.Encode(newFile, canvases[i], nil); err != nil {
				return nil, err
			}
		case "png":
			if err := png.Encode(newFile, canvases[i]); err != nil {
				return nil, err
			}
		default:
			return nil, errors.New("Wrong image file format : " + imgExt)
		}
	}
	return nil, nil
}
