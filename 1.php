<html>
  <head>
    <title></title>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <label for="fname">FirstName</label>
      <input type="text" name="name" required><br>
      <label for="email">Email</label>
      <input type="email" name="email" required><br>
      <label for="password">Password (min. 6 characters)</label>
      <input type="password" name="password" required minlength="6"><br>
      <input type="submit">
    </form>

    <?php
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      // Check if the password meets the minimum length requirement
      if (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
        // You might want to redirect the user back to the form or handle this differently.
        exit();
      }

      $conn = new mysqli("localhost", "root", "", "test");

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Check if the username already exists in the database
      $check_username_sql = "SELECT * FROM testingregistration1 WHERE fname = '$name'";
      $result2=mysqli_query($conn,$check_username_sql);
      

      if (mysqli_num_rows($result2) > 0) {
        echo "Username already exists. Please choose a different username.";
        exit();
      }

      // Use prepared statements to prevent SQL injection
      $query="INSERT INTO testingregistration1 (fname, email, pass) VALUES ('$name', '$email', '$password')";
      $result = mysqli_query($conn,$query);
       
      if ($result>0) {
        $last_id = $conn->insert_id;
        $_SESSION['user_id'] = $last_id;
        echo "New record created successfully. Last inserted ID is: " . $last_id;
        header("Location: login.php");
        exit();

      } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
      }

      

      $insert_sql->close();
      // $check_username_sql->close();
      $conn->close();
    }
    ?>
  </body>
</html>
