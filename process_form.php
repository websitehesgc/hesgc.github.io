<?php
// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gname = $_POST["gname"];
    $gmail = $_POST["gmail"];
    $cname = $_POST["cname"];
    $cage = $_POST["cage"];
    $message = $_POST["message"];

    // Insert data into the table
    $sql = "INSERT INTO appointment (gurdian_name, gurdian_email, child_name, child_age, message) VALUES ('$gname', '$gmail', '$cname', '$cage', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>