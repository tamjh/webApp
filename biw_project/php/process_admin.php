<?php

include_once "database.php";

if (isset($_POST['btn-submit'])) {
    $admin_name = $_POST["name"];
    $email = $_POST["email"];
    
    // Hash the password using Bcrypt
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $phone = $_POST["phone"];
    $usertype = "admin";

    // SQL query to insert data into the users table with prepared statement
    $sql = "INSERT INTO users (full_name, email, password, phone_number, usertype) VALUES (?, ?, ?, ?, ?)";
    
    // Initialize statement
    $stmt = mysqli_stmt_init($conn);

    // Prepare the statement
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

    if ($prepareStmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "sssss", $admin_name, $email, $password, $phone, $usertype);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            header("Location: view_acc.php");
            exit(); // Make sure to exit after redirection
        } else {
            echo "Error executing statement: " . mysqli_stmt_error($stmt);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
