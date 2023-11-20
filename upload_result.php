<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/"; // Create a directory named 'uploads' to store the files
    $targetFile = $targetDir . basename($_FILES["result"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, the file already exists.";
        $uploadOk = 0;
    }

    // Check file size (adjust the limit as needed)
    if ($_FILES["result"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedFormats = ["pdf", "doc", "docx"];
    if (!in_array($fileType, $allowedFormats)) {
        echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, upload the file and store the information in the database
        if (move_uploaded_file($_FILES["result"]["tmp_name"], $targetFile)) {
            $filename = basename($_FILES["result"]["name"]);
            $sql = "INSERT INTO results (filename) VALUES ('$filename')";

            if ($conn->query($sql) === TRUE) {
                echo "The file " . $filename . " has been uploaded and the information has been stored in the database.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
