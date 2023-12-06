<?php
session_start();
$formSubmitted = isset($_GET['search']);

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit(); // Make sure to exit after a header redirect
}

if (isset($_POST['logout'])) {
    // Unset and destroy the session
    session_unset();
    session_destroy();

    // Redirect to the login page after logout
    header("Location: login.php");
    exit(); // Make sure to exit after a header redirect
}

require_once "database.php";
require_once "books_function.php";
require_once "cart_function.php";
$books = get_all_books($conn);

if (!is_array($books)) {
    $books = array();
}

// Sort the books array by name in ascending order
usort($books, function ($a, $b) {
    return strcmp($a['name'], $b['name']);
});

$categories = get_all_categories($conn);
$publishers = get_all_publisher($conn);

$customerId = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/project/biw_project/css/shop_style.css">
    <title>Product Page</title>
</head>

<body>
    <header>
        <a href="#" class="logo">Inspirasi<span>.</span></a>

        <nav class="navbar">
            <a href="homepage.html">home</a>
            <a href="about us.html">about us</a>
            <a href="ProductPage.html">products</a>
            <a href="contact website.html">contact</a>
            <a href="Billing.html">order form</a>
        </nav>

        <div class="icons">
            <a href="#" class="fas fa-search"></a>
            <a href="#" class="fas fa-cart-plus"></a>
            <div class="dropdown">
                <a href="#" class="fas fa-user" onclick="myFunction()"></a>
                <div id="myDropdown" class="menu">
                    <div class="account_box">
                        <p>Username: <span><?= $_SESSION['customer_name']; ?></span></p>
                    </div>
                    <p>account</p>
                    <form method="post">
                        <button type="submit" name="logout" class="logout">Logout</button>
                    </form>

                </div>
            </div>
        </div>

    </header>
    <h1>All products</h1>

    <div class="page">
        <div class="filter">
            <div class="fbox">
                <form action="" method="get">
                    <div class="search-box">
                        <input type="text" name="search" class="searching" placeholder="Search..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" autocomplete="off">
                        <button type="submit" class="icon"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="filter-checkbox">
                        <h4>Category: </h4>
                        <hr>
                        <?php
                        foreach ($categories as $category) {
                            $checked = (isset($_GET['category_filter']) && is_array($_GET['category_filter']) && in_array($category['id'], $_GET['category_filter'])) ? 'checked' : '';
                        ?>
                            <input type="checkbox" name="category_filter[]" value="<?= $category['id'] ?>" <?= $checked ?> />
                            <?= $category['category_name'] ?>
                            <br>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="filter-checkbox">
                        <h4>Publisher: </h4>
                        <hr>
                        <?php
                        foreach ($publishers as $publisher) {
                            $checked = (isset($_GET['publisher_filter']) && is_array($_GET['publisher_filter']) && in_array($publisher['id'], $_GET['publisher_filter'])) ? 'checked' : '';
                        ?>
                            <input type="checkbox" name="publisher_filter[]" value="<?= $publisher['id'] ?>" <?= $checked ?> />
                            <?= $publisher['publisher_name'] ?>
                            <br>
                        <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="product">
            <div class="product-container">
                <?php

                if (isset($_GET['category_filter']) || isset($_GET['publisher_filter']) || $formSubmitted) {
                    $filteredBooks = array(); // Create an array to store filtered books

                    // Loop through all books
                    foreach ($books as $book) {
                        // Check if the book matches the selected category filters
                        $categoryMatches = empty($_GET['category_filter']) || in_array($book['category'], $_GET['category_filter']);

                        // Check if the book matches the selected publisher filters
                        $publisherMatches = empty($_GET['publisher_filter']) || in_array($book['publisher'], $_GET['publisher_filter']);

                        // If both category and publisher match, add the book to the filtered array
                        if ($categoryMatches && $publisherMatches) {
                            $filteredBooks[] = $book;
                        }
                    }

                    // Loop through the filtered books and display them
                    foreach ($filteredBooks as $book) {
                        echo "<div class='product-card'>";
                        echo "<div class='product-image'>";
                        echo "<img src='/project/biw_project/image/coverpage/{$book['cover']}' alt='{$book['name']}'>";
                        echo "</div>";
                        echo "<p>{$book['name']}</p>";
                        echo "<p>{$book['price']}</p>";

                        // Your code for displaying book details goes here

                        echo "<form action='cart_function.php' method='post'>";
                        echo "<input type='number' name='quantity' value='1' min='1'>";
                        echo "<input type='hidden'name='Pname' value='{$book['name']}'>";
                        echo "<input type='hidden' name='Pprice' value='{$book['price']}'>";
                        echo "<input type='hidden' name='book_id' value='{$book['id']}'>";
                        echo "<input type='submit' class='btn btn-buy addToCartBtn' name='add_to_cart' value='Add to cart'>";
                        echo "</form>";
                        echo "<a href='details.php?book_id={$book['id']}' class='btn btn-buy'><button class='btn btn-buy'>View details</button></a>";
                        echo "</div>";
                    }
                } else {
                    // Handle the case when no filters are set
                    // Loop through all books
                    foreach ($books as $book) {
                        echo "<div class='product-card'>";
                        echo "<div class='product-image'>";
                        echo "<img src='/project/biw_project/image/coverpage/{$book['cover']}' alt='{$book['name']}'>";
                        echo "</div>";
                        echo "<p>{$book['name']}</p>";
                        echo "<p>{$book['price']}</p>";

                        // Your code for displaying book details goes here
                        echo "<form action='cart_function.php' method='post'>";
                        echo "<input type='hidden' name='Pimage' value='/project/biw_project/image/coverpage/{$book['cover']}'>";
                        echo "<input type='number' name='quantity' value='1' min='1'>";
                        echo "<input type='hidden'name='Pname' value='{$book['name']}'>";
                        echo "<input type='hidden' name='Pprice' value='{$book['price']}'>";
                        echo "<input type='hidden' name='book_id' value='{$book['id']}'>";
                        echo "<input type='submit' class='btn btn-buy addToCartBtn' name='add_to_cart' value='Add to cart'>";
                        echo "</form>";
                        echo "<a href='details.php?book_id={$book['id']}' class='btn btn-buy'><button class='btn btn-buy'>View details</button></a>";
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                this.form.submit();
            });
        });
    });
    hello;
</script>

</html>
