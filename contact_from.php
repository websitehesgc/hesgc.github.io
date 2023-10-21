<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Create the email message
    $to = "your@example.com"; // Change this to your email address
    $subject = "Contact Form Submission: $subject";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    // Send the email
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "Message sent successfully.";
    } else {
        echo "Failed to send the message. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>
