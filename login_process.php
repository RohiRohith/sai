<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "", "test");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $login_query = "SELECT * FROM testingregistration1 WHERE fname = ? AND pass = ?";
    $login_stmt = $conn->prepare($login_query);
    $login_stmt->bind_param("ss", $username, $password);

    $login_stmt->execute();
    $login_result = $login_stmt->get_result();

    if ($login_result->num_rows > 0) {
        // Successful login
        $user_data = $login_result->fetch_assoc();
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['fname'];
        header("Location: profile.php");
        exit();
    } else {
        // Invalid login
        echo "Invalid username or password. Please try again.";
    }

    $login_stmt->close();
    $conn->close();
}
?>
