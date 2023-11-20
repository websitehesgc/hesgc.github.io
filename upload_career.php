<?php
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process file upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["resume"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if file is a valid document type
    $allowedTypes = array("pdf", "doc", "docx");
    if (in_array($fileType, $allowedTypes)) {
        // Upload file
        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFilePath)) {
            // Insert data into database
            $sql = "INSERT INTO resumes (file_name) VALUES ('$fileName')";
            if ($conn->query($sql) === TRUE) {
                echo "Resume uploaded successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type. Please upload a PDF, DOC, or DOCX file.";
    }
}

// Close connection
$conn->close();
?>
