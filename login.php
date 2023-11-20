<?php
// Database connection parameters
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a connection to the database
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitizeInput($input) {
    global $conn;
    return $conn->real_escape_string($input);
}

// Function to validate and process login
function loginUser($username, $password) {
    global $conn;

    // Sanitize user input
    $username = sanitizeInput($username);
    $password = sanitizeInput($password);

    // Query to check if the user exists
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // User found, login successful
        return true;
    } else {
        // User not found or invalid credentials
        return false;
    }
}

// Check if the login form is submitted
if (isset($_POST['login'])) {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and process login
    if (loginUser($username, $password)) {
        echo "Login successful!";
        // Redirect to the desired page after successful login
        // header("Location: dashboard.php");
        header("Location: upload.php");
    } else {
        echo "Invalid username or password.";
    }
}

// Close the database connection
$conn->close();
?>