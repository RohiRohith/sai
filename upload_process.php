<!-- upload_process.php -->
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION['user_id'];
  $image = $_FILES['image'];

  // Check if the file is an image
  $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
  $file_type = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

  if (!in_array($file_type, $allowed_types)) {
    echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
    exit();
  }

  // Check if the file size is less than 2MB
  if ($image['size'] > 2 * 1024 * 1024) {
    echo "File size must be less than 2MB.";
    exit();
  }

  // Process the image upload and save to the database
  $conn = new mysqli("localhost", "root", "", "test");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Use prepared statements to prevent SQL injection
  $sql = $conn->prepare("INSERT INTO image_table (user_id, image_data) VALUES (?, ?)");
  $sql->bind_param("is", $user_id, $image_data);

  // Read image data
  $image_data = file_get_contents($image['tmp_name']);

  // Execute the statement
  if ($sql->execute() === TRUE) {
    echo "Image uploaded successfully.";
  } else {
    echo "Error uploading image: " . $sql->error;
  }

  // Close the prepared statement
  $sql->close();
  $conn->close();
}
?>
