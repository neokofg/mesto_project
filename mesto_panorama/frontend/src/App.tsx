import React, { useState } from "react";
import "./App.css";
import SinglePanorama from "./components/scenes/SinglePanorama";

function App() {
  const [url, setUrl] = useState(undefined);
  const [imageFile, setImageFile] = React.useState<File>();

  const handleSelectFile = (event: React.ChangeEvent<HTMLInputElement>) => {
    if (event.target.files) {
      var file = event.target.files[0];
      setImageFile(file);
    }
  };

  const uploadImage = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!imageFile) return;
    const formData = new FormData();
    formData.append("file", imageFile);
    await fetch("/api/upload", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => setUrl(data.url))
      .catch((error) => console.error(error));
    console.log(url);
  };

  return (
    <>
      <form onSubmit={uploadImage}>
        <input onChange={handleSelectFile} type="file" id="file" name="file" />
        <button type="submit">Добавить</button>
      </form>
      <SinglePanorama url={url} />
    </>
  );
}

export default App;
