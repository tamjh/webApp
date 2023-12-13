<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


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

$books = get_all_books($conn);

if (!is_array($books)) {
    $books = array();
}

$categories = get_all_categories($conn);
$publishers = get_all_publisher($conn);

$bookId = isset($_GET['book_id']) ? $_GET['book_id'] : null;

// Validate and sanitize the input if needed
$bookId = filter_var($bookId, FILTER_VALIDATE_INT);

// Check if a valid book ID is provided
if ($bookId !== false && $bookId !== null) {
    $sql_query = "SELECT * FROM books WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_query);

    // Bind the book ID parameter
    mysqli_stmt_bind_param($stmt, "i", $bookId);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the book details
    $bookData = mysqli_fetch_assoc($result);

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Invalid book ID provided

    exit(); // Exit script after displaying the error
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/details_style.css">
    <title>Product Page</title>
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




    <div class="container">
        <?php if (isset($bookData) && $bookData) : ?>
            <!-- Display book details -->
            <div class="image">
                <img src="../image/coverpage/<?= $bookData['cover']; ?>">
            </div>
            <div class="text">
                <!-- Display other book details using $bookData -->
                <div class="name"><?= $bookData['name'] ?></div>
                <div class="container2">
                    <div class="publish">
                        <span class="publisher">
                            <?php
                            if ($publishers == 0 || empty($publishers)) {
                                echo "Undefined";
                            } else {
                                $publisherFound = false;
                                foreach ($publishers as $publisher) {
                                    if ($publisher['id'] == $bookData['publisher']) {
                                        echo $publisher['publisher_name'];
                                        $publisherFound = true;
                                        break;
                                    }
                                }
                                if (!$publisherFound) {
                                    echo "Undefined";
                                }
                            }
                            ?></span>

                    </div>
                    <span class="publish-year"><?= $bookData['year'] ?></span>
                    <span class="category">
                        <?php
                        if ($categories == 0 || empty($categories)) {
                            echo "Undefined";
                        } else {
                            $categoryFound = false;
                            foreach ($categories as $category) {
                                if ($category['id'] == $bookData['category']) {
                                    echo $category['category_name'];
                                    $categoryFound = true;
                                    break;
                                }
                            }
                            if (!$categoryFound) {
                                echo "Undefined";
                            }
                        }
                        ?>
                    </span>
                </div>
                <div class="price">RM<span><?= $bookData['price'] ?></span></div>


                <form action="" class="quantity">
                    <div class="quantity-container">
                        <label for="quantity" class="label">Quantity</label>
                        <div class="input-button">
                            <span class="decre"><button class="q1">-</button></span>
                            <input type="number" id="quantity" name="quantity" value="1" class="inputQuantity">
                            <span class="incre"><button class="q2">+</button></span>
                        </div>
                    </div>

                    <div class="button">
                        <button class="cart purchase">Add to Cart</button>
                        <button class="buy purchase">Buy Now</button>
                    </div>
                </form>
            <?php else : ?>
                <!-- Book not found or error message -->
                <p>Error: Book not found or invalid book ID.</p>
            <?php endif; ?>
            </div>

    </div>

    <div class="description-box">
        <h6>Description</h6><br>
        <hr>
        <p class="des-box"><?= $bookData['description'] ?></p>
    </div>
</body>
<script src="numberkey.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
            function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
</script>
</html>