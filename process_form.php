<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gname = $_POST['gname'];
    $gmail = $_POST['gmail'];
    $cname = $_POST['cname'];
    $cage = $_POST['cage'];
    $message = $_POST['message'];

    // Construct the email message
    $to = 'your@example.com'; // Replace with your email address
    $subject = 'Form Submission';
    $body = "Guardian Name: $gname\nGuardian Email: $gmail\nChild Name: $cname\nChild Age: $cage\nMessage:\n$message";

    // Send the email
    mail($to, $subject, $body);

    // Redirect or display a thank you message
    header('Location: thank_you.html'); // Redirect to a thank you page
    exit();
}
?>
