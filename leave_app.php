<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
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

    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $leaveType = $_POST["leaveType"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $reason = $_POST["reason"];

    // File upload handling
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["documents"]["name"]);
    move_uploaded_file($_FILES["documents"]["tmp_name"], $targetFile);

    // Insert data into database
    $sql = "INSERT INTO leave_applications (name, email, leave_type, start_date, end_date, reason, document_path) VALUES ('$name', '$email', '$leaveType', '$startDate', '$endDate', '$reason', '$targetFile')";

    if ($conn->query($sql) === TRUE) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
