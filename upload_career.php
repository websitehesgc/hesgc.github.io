<?php
echo "Welcome to the career upload page <br>";

$servername = "localhost";
$username = "root";
$password = "";
$database = "upload_career";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Sorry, we failed to connect: " . mysqli_connect_error());
} else {
    echo "Connection was successful <br>";
}

// Check if the table 'resume' already exists
$table_check_query = "SHOW TABLES LIKE 'resume'";
$table_check_result = mysqli_query($conn, $table_check_query);

if ($table_check_result->num_rows == 0) {
    // Table doesn't exist, so we create it
// Create a table in the database
$sql = "CREATE TABLE `resume` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `file_name` VARCHAR(255) NOT NULL,
    `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "The table was created successfully!<br>";
} else {
    echo "The table was not created successfully because of this error ---> " . mysqli_error($conn);
}
} else {
echo "The table 'resume' already exists.<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["resume"]["name"]);

    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFile)) {
        // File uploaded successfully, now send an email with the file as an attachment
        $to = "danishreza2010@gmail.com";  // Replace with the recipient's email address
        $subject = "Resume Submission";
        $message = "A new resume has been submitted.\n";

        $headers = "From: Resume Uploader\r\n";
        $headers .= "Reply-To: no-reply@example.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

        $body = "--boundary\r\n";
        $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message . "\r\n\r\n";

        $body .= "--boundary\r\n";
        $body .= "Content-Type: application/octet-stream; name=\"" . basename($targetFile) . "\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment\r\n\r\n";
        $body .= chunk_split(base64_encode(file_get_contents($targetFile))) . "\r\n";

        $body .= "--boundary--";

        // Send the email
        mail($to, $subject, $body, $headers);

        // Display a success message
        echo "Resume uploaded successfully. An email has been sent with the resume as an attachment.";
    } else {
        echo "Sorry, there was an error uploading your resume.";
    }
}
?>
