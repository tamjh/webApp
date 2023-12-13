<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    // Unset and destroy the session
    session_unset();
    session_destroy();
    header("Location: login.php"); // Redirect to the login page after logout
    exit();
}

//connect others php file
require_once "database.php";
require_once "books_function.php";
require_once "update_info.php";

//call function for books_function.php
$books = get_all_books($conn);
if (!is_array($books)) {
    $books = array();
}
$categories = get_all_categories($conn);
$publishers = get_all_publisher($conn);
$delete_function = delete_inventory($conn);
$update_info = update_info($conn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/project/biw_project/css/view_order_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Orders</title>
</head>

<body>
<header class="navbar navbar-expand-lg navbar-light bg-light" style="font-size: 2rem; padding: 2rem 9%;">
    <div class="container-fluid">

        <a href="#" class="navbar-brand" style="font-size: 3rem">Inspirasi<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto" style="margin-right: 20px; gap: 10px;">
                <li class="nav-item">
                    <a class="nav-link" href="homepage.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about us.html">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ProductPage.html">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact website.html">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Billing.html">Order Form</a>
                </li>
            </ul>

            <div class="icons" style="text-decoration: none; font-size: 2.5rem; display: flex;">
                <a href="#" class="fas fa-search" style="text-decoration: none;"></a>
                <a href="#" class="fas fa-cart-plus" style="text-decoration: none;"></a>
                <div class="dropdown">
                    <a href="#" class="fas fa-user" onclick="myFunction()" style="text-decoration: none;"></a>
                    <div id="myDropdown" class="menu" style="padding: 20px; font-size: 1rem;">
                        <div class="account_box" style="padding: 10px; font-size:2rem;">
                            <p>Username: <span><?= $_SESSION['customer_name']; ?></span></p>
                        </div>
                        <p style="font-size:2rem;">Account</p>
                        <form method="post">
                            <button type="submit" name="logout" class="logout">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

    <section>
        <h1>Customer order</h1>

        
    </section>

</body>
<script>
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
    </script>

</html>