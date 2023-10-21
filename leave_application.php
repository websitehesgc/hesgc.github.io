<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $leaveType = $_POST["leaveType"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $reason = $_POST["reason"];

    // Handle file upload
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["documents"]["name"]);

    if (move_uploaded_file($_FILES["documents"]["tmp_name"], $targetFile)) {
        // File uploaded successfully, now send an email with the file as an attachment
        $to = "your-email@example.com";  // Replace with the recipient's email address
        $subject = "Leave Application Form Submission";
        $message = "Name: $name\n";
        $message .= "Email: $email\n";
        $message .= "Leave Type: $leaveType\n";
        $message .= "Start Date: $startDate\n";
        $message .= "End Date: $endDate\n";
        $message .= "Reason for Leave:\n$reason";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
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
        echo "Form submitted successfully. An email has been sent with the form data and uploaded document.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Application Form</title>
</head>
<body>

<h1>Leave Application Form</h1>

<form action="#" method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="leaveType">Leave Type:</label>
    <select id="leaveType" name="leaveType" required>
        <option value="sick">Sick Leave</option>
        <option value="vacation">Vacation Leave</option>
        <option value="personal">Personal Leave</option>
    </select><br><br>

    <label for="startDate">Start Date:</label>
    <input type="date" id="startDate" name="startDate" required><br><br>

    <label for="endDate">End Date:</label>
    <input type="date" id="endDate" name="endDate" required><br><br>

    <label for="reason">Reason for Leave:</label><br>
    <textarea id="reason" name="reason" rows="4" cols="50" required></textarea><br><br>


    <label for="documents">Upload Documents (if required):</label>
    <input type="file" id="documents" name="documents"><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
