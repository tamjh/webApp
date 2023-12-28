<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['customer_name'])) {
    $_SESSION['customer_name'] = "user";
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
                        <a class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about_us.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                </ul>

                <div class="icons" style="text-decoration: none; font-size: 2.5rem; display: flex;">
                    <a href="cart.php" class="fas fa-cart-plus" style="text-decoration: none;">
                        <span id="cartItemCount" class="cart-item-count">(<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0' ?>)</span>
                    </a>
                    <div class="dropdown">
                        <a href="#" class="fas fa-user" onclick="myFunction()" style="text-decoration: none;"></a>
                        <div id="myDropdown" class="menu" style="padding: 20px; font-size: 1rem;">
                            <p onclick="redirectToAccount()" style="font-size:2rem;">Account</p>
                            <form method="post">
                                <?php
                                if ($_SESSION['customer_name'] == "user") {
                                    echo "<button type='submit' name='logout' class='logout'>Log In</button>";
                                } else {
                                    echo "<button type='submit' name='logout' class='logout'>Logout</button>";
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="account_box" style="padding: 10px; font-size:2rem;">
                    <p>Hello, <span><?= $_SESSION['customer_name']; ?></span></p>
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
                    <table>
                        <tr>
                            <td class="change">Publisher</td>
                            <td class="colom">:</td>
                            <td>
                                <div class="publisher-box">

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
                            </td>
                        </tr>
                        <tr>
                            <td class="change">Year</td>
                            <td class="colom">:</td>
                            <td>
                                <div class="year-box">

                                    <span class="publish-year"><?= $bookData['year'] ?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="change">Category</td>
                            <td class="colom">:</td>
                            <td>
                                <div class="category-box">
                                    
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
                            </td>
                        </tr>
                    </table>



                </div>


            <div class="price">RM<span><?= $bookData['price'] ?></span></div>


            <form action="cart_function.php" method="post" class="quantity">
                <input type='hidden' name='book_id' value='<?= $bookData['id'] ?>'>
                <input type='hidden' name='Pimage' value='<?= $bookData['cover'] ?>'>
                <input type='hidden' name='Pname' value='<?= $bookData['name'] ?>'>
                <input type='hidden' name='Pprice' value='<?= $bookData['price'] ?>'>
                <div class="quantity-container">
                    <label for="quantity" class="label">Quantity</label>
                    <div class="input-button">
                        <span class="decre"><button class="q1"><i class="fa-solid fa-minus"></i></button></span>
                        <input type="number" id="quantity" name="quantity" value="1" class="inputQuantity" class="number">
                        <span class="incre"><button class="q2"><i class="fa-solid fa-plus"></i></button></span>
                    </div>
                </div>
                <div class="button">
                    <button name="add_to_cart" class="cart purchase">Add to Cart</button>
                    <button name="buy_now" class="buy purchase">Buy Now</button>
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
    <footer>
            <div class="container-fluid ft px-5 py-2">
                <div class="row p-5 g-4 h2">
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="pb-2 h2">Contact Number</div>
                        <div class="row px-3">
                            <div class="col-1 px-0 bi-telephone w-auto "></div>
                            <div class="col-11 h3">07-6883363</div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="pb-2">Email</div>
                        <div class="row px-3">
                            <div class="col-1 px-0 bi-envelope w-auto "></div>
                            <div class="col-11 h3">abc123@gmail.com</div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-6">
                        <div class="pb-2">Address</div>
                        <div class="row px-3">
                            <div class="col-1 px-0 bi-geo-alt w-auto"></div>
                            <div class="col-11 h3">55 & 56, Aras Bawah, Bangunan Baitulmal, Jalan Delima, Pusat Perdagangan Pontian, 82000, Pontian, Johor, Malaysia.</div>
                        </div>
                    </div>
                </div>

                <div class="row px-5 pb-2">
                    <div class="col text-center "><span class="bi-c-circle pe-1"></span>2023 Inspirasi Bookstore. All Rights Reserved</div>
                </div>

            </div>
        </footer>

        <a href="#" class="top"><i class="fa-solid fa-arrow-up"></i></a>
    
</body>
<script src="numberkey.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
    document.addEventListener("DOMContentLoaded", function() {
        const addToCartBtns = document.querySelectorAll('.addToCartBtn');
        addToCartBtns.forEach(function(btn) {
            if (btn.getAttribute('data-inventory') <= 0) {
                btn.value = 'Out Of Stock';
                btn.disabled = true;
                btn.style.backgroundColor = "red";
                btn.style.color = "white"; // Set the font color to white
            }
        });
    });
</script>

</html>