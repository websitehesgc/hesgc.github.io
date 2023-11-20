<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file is selected
    if (isset($_FILES["file"])) {
        $category = $_POST["category"];
        $uploadDirectory = "uploads/";

        // Create the upload directory if it doesn't exist
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $fileName = basename($_FILES["file"]["name"]);
        $targetPath = $uploadDirectory . $fileName;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

        // Check if the file already exists
        if (file_exists($targetPath)) {
            echo "Sorry, the file already exists.";
            $uploadOk = 0;
        }

        // Check file size (you can adjust the size limit as needed)
        if ($_FILES["file"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file types (you can customize this list)
        $allowedFileTypes = array("pdf", "doc", "docx", "txt");
        if (!in_array($fileType, $allowedFileTypes)) {
            echo "Sorry, only PDF, DOC, DOCX, and TXT files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Move the file to the specified directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
                // Insert file details into the database (you need to have a database set up)
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

                // Create a table if it doesn't exist
                $sql = "CREATE TABLE IF NOT EXISTS files (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    category VARCHAR(255) NOT NULL,
                    file_name VARCHAR(255) NOT NULL,
                    file_path VARCHAR(255) NOT NULL,
                    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

                if ($conn->query($sql) === TRUE) {
                    // Insert file details into the table
                    $insertSql = "INSERT INTO files (category, file_name, file_path) VALUES ('$category', '$fileName', '$targetPath')";
                    if ($conn->query($insertSql) === TRUE) {
                        echo "The file " . htmlspecialchars($fileName) . " has been uploaded and details are stored in the database.";
                    } else {
                        echo "Error: " . $insertSql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error creating table: " . $conn->error;
                }

                $conn->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Please select a file.";
    }
}
?>
