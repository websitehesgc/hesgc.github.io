<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
</head>

<body>
    <div>
        <h1>Appointment Details</h1>

        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $guardianName = isset($_POST["gname"]) ? $_POST["gname"] : "";
            $guardianEmail = isset($_POST["gmail"]) ? $_POST["gmail"] : "";
            $childName = isset($_POST["cname"]) ? $_POST["cname"] : "";
            $childAge = isset($_POST["cage"]) ? $_POST["cage"] : "";
            $message = isset($_POST["message"]) ? $_POST["message"] : "";

            // Display submitted details
            echo "<p><strong>Guardian Name:</strong> $guardianName</p>";
            echo "<p><strong>Guardian Email:</strong> $guardianEmail</p>";
            echo "<p><strong>Child Name:</strong> $childName</p>";
            echo "<p><strong>Child Age:</strong> $childAge</p>";
            echo "<p><strong>Message:</strong> $message</p>";
        } else {
            // If form is not submitted, display a message
            echo "<p>No form submission data available.</p>";
        }
        ?>
    </div>
</body>

</html>
