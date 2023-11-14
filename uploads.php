<!-- upload.php -->
<html>
  <head>
    <title>Image Upload</title>
  </head>
  <body>
    <form method="post" action="upload_process.php" enctype="multipart/form-data">
      <label for="image">Upload Image (max 2MB)</label>
      <input type="file" name="image" accept="image/*" required><br>
      <input type="submit" value="Upload Image">
    </form>
  </body>
</html>
