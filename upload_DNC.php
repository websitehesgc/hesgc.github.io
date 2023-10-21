<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Replace with your upload directory path
$uploadDirectory = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"];

    // Check if the category is valid (circular, datesheet, notice)
    if ($category !== "circular" && $category !== "datesheet" && $category !== "notice") {
        echo "Invalid category.";
        exit();
    }

    $file = $_FILES["file"];

    // Check if file was uploaded without errors
    if ($file["error"] === UPLOAD_ERR_OK) {
        $fileName = basename($file["name"]);
        $targetPath = $uploadDirectory . $category . '/' . $fileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            echo "File uploaded successfully!";
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Error: " . $file["error"];
    }
}
?>
