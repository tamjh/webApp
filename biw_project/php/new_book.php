<?php

include "database.php"; 

if (isset($_POST['submit_new'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $publisher = $_POST['publisher'];
    $inventory = $_POST['inventory'];
    $cover = $_FILES['cover'];

    $cover_name = $_FILES['cover']['name'];
    $cover_tmp = $_FILES['cover']['tmp_name'];
    $cover_size = $_FILES['cover']['size'];
    $cover_error = $_FILES['cover']['error'];
    $cover_type = $_FILES['cover']['type'];

    $fileExt = explode('.', $cover_name);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileActualExt, $allowed)) {
        if ($cover_error === 0) {
            $targetDirectory = '../image/coverpage/';

            // Check if the target directory exists, if not, create it
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            $fileDestination = $targetDirectory . $cover_name;

            // Move the uploaded file to the destination
            if (move_uploaded_file($cover_tmp, $fileDestination)) {
                // Perform database insert or any other operations here
                mysqli_query($conn, "INSERT INTO `books`(`name`, `year`, `publisher`, `price`, `cover`, `description`, `category`, `inventory`) VALUES ('$title','$year','$publisher','$price','$cover_name','$description','$category','$inventory')");
                header("Location: inventory.php");
            } else {
                echo "Error uploading file!";
            }
        } else {
            echo "Error: " . $cover_error;
        }
    } else {
        echo "Invalid file type!";
    }
}
?>
