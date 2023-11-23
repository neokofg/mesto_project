import React, { useEffect, useState } from "react";
import "./App.css";
import SinglePanorama from "./components/scenes/SinglePanorama";

function App() {
  const [url, setUrl] = useState(undefined);
  useEffect(() => {
    console.log("import.meta.env.BASE_URL", import.meta.env.BASE_URL);
  });
  const [rezident, setRezident] = useState("OOO Rezident");
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
    formData.append("rezident", rezident);
    await fetch("http://localhost:3000/api/upload", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => setUrl(data.url))
      .then(() => console.log("url", url))
      .catch((error) => console.error(error));
  };

  return (
    <>
      <form onSubmit={uploadImage}>
        <input onChange={handleSelectFile} type="file" id="file" name="file" />
        <input
          onChange={(e: React.ChangeEvent<HTMLInputElement>) =>
            setRezident(e.target.value)
          }
          value={rezident}
        />
        <button type="submit">Добавить</button>
      </form>
      <SinglePanorama url={url} />
    </>
  );
}

export default App;
