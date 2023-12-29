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
    $promotion = $_POST['promotion'];

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
                // Perform database insert using prepared statement
                $stmt = $conn->prepare("INSERT INTO `books` (`name`, `year`, `publisher`, `price`, `cover`, `description`, `category`, `inventory`, `promotion`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Bind the parameters
                $stmt->bind_param("sssssssss", $title, $year, $publisher, $price, $cover_name, $description, $category, $inventory, $promotion);

                // Execute the statement
                $result = $stmt->execute();

                if ($result) {
                    // Query executed successfully
                    header("Location: inventory.php");
                } else {
                    // Query failed
                    echo "Error: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
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

if (isset($_POST['submit_new_category'])) {
    $cat_name = $_POST["category_name"];

    // Using prepared statement to prevent SQL injection
    $sql = "INSERT INTO `category` (`category_name`) VALUES (?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "s", $cat_name);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Query executed successfully
            // You can redirect or perform other actions here
            header("Location: inventory.php");
        } else {
            // Query failed
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Statement preparation failed
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['submit_new_publisher'])) {
    $pub_name = $_POST["pub_name"];

    // Using prepared statement to prevent SQL injection
    $sql = "INSERT INTO `publisher` (`publisher_name`) VALUES (?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "s", $pub_name);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Query executed successfully
            // You can redirect or perform other actions here
            header("Location: inventory.php");
        } else {
            // Query failed
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Statement preparation failed
        echo "Error: " . mysqli_error($conn);
    }
}
?>
