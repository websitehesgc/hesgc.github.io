<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resumes</title>
</head>

<body>
    <h1>View Resumes</h1>

    <?php
    $resumeDirectory = "uploads/";

    // Get a list of all resumes in the directory
    $resumes = scandir($resumeDirectory);

    // Exclude "." and ".." from the list
    $resumes = array_diff($resumes, array(".", ".."));

    if (count($resumes) > 0) {
        echo "<ul>";
        foreach ($resumes as $resume) {
            echo "<li><a href='$resumeDirectory/$resume' download>$resume</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No resumes available.</p>";
    }
    ?>
</body>

</html>
