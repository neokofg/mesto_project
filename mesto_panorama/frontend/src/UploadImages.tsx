const UploadImages = () => {
  return (
    <form action="/api/upload" method="POST" encType="multipart/form-data">
      <input type="file" id="file" name="file" />
      <button type="submit">Добавить</button>
    </form>
  );
};

export default UploadImages;
