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
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
</head>

<body>
    <div>
        <h1>Contact Form Submission Details</h1>

        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $name = isset($_POST["name"]) ? $_POST["name"] : "";
            $email = isset($_POST["email"]) ? $_POST["email"] : "";
            $subject = isset($_POST["subject"]) ? $_POST["subject"] : "";
            $message = isset($_POST["message"]) ? $_POST["message"] : "";

            // Display submitted details
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Subject:</strong> $subject</p>";
            echo "<p><strong>Message:</strong> $message</p>";
        } else {
            // If form is not submitted, display a message
            echo "<p>No form submission data available.</p>";
        }
        ?>
    </div>
</body>

</html>
