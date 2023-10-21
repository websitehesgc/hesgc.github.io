<?php
session_start(); // Start the session

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Assume you have a database connection
    // Replace these with your actual database connection details
    $servername = "your_servername";
    $dbusername = "your_username";
    $dbpassword = "your_password";
    $dbname = "your_database_name";

    // Create a connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query to check credentials
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful, set session variables
        $_SESSION["username"] = $username;

        // Redirect to a welcome page or any other page after login
        header("Location: welcome.php");
        exit();
    } else {
        // Invalid credentials, redirect to login page with an error message
        header("Location: index.php?error=1");
        exit();
    }

    $conn->close(); // Close the database connection
}
?>
