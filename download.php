<?php
// Check if the file parameter is set
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Define the path to the directory where the files are stored
    $directory = 'uploads/';

    // Combine the directory path and file name to get the full path
    $filepath = $directory . $file;

    // Check if the file exists
    if (file_exists($filepath)) {
        // Set the appropriate headers for the file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));

        // Read the file and output it to the browser
        readfile($filepath);

        // Exit the script
        exit;
    } else {
        // If the file does not exist, you can handle the error accordingly
        echo "File not found.";
    }
} else {
    // If the file parameter is not set, you can handle the error accordingly
    echo "Invalid request.";
}
?>
