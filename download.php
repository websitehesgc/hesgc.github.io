<?php
// Function to display files of a specific category
function displayFiles($category) {
    // Replace with your upload directory path
    $uploadDirectory = "uploads/";

    // Check if the category is valid (circular, datesheet, notice)
    if ($category !== "circular" && $category !== "datesheet" && $category !== "notice") {
        echo "Invalid category.";
        return;
    }

    $categoryPath = $uploadDirectory . $category . '/';
    
    if (is_dir($categoryPath)) {
        $files = scandir($categoryPath);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                echo "<a href='$categoryPath$file' download>$file</a><br>";
            }
        }
    } else {
        echo "Category not found.";
    }
}

// Check if category is provided in the URL
if(isset($_GET['category'])) {
    $category = $_GET['category'];
    displayFiles($category);
} else {
    echo "Category not specified.";
}
?>
