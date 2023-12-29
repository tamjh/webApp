<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$formSubmitted = isset($_GET['search']);

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

// Number of products per page
$productsPerPage = 12;

// Initialize filtered books array
$filteredBooks = array();

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Check if filters are applied
if (isset($_GET['category_filter']) || isset($_GET['publisher_filter']) || $formSubmitted || !empty($searchQuery)) {
    // Loop through all books
    foreach ($books as $book) {
        // Check if the book matches the search query
        $searchMatches = empty($searchQuery) || stripos($book['name'], $searchQuery) !== false;

        // Check if the book matches the selected category filters
        $categoryMatches = empty($_GET['category_filter']) || in_array($book['category'], $_GET['category_filter']);

        // Check if the book matches the selected publisher filters
        $publisherMatches = empty($_GET['publisher_filter']) || in_array($book['publisher'], $_GET['publisher_filter']);

        // If search, category, and publisher match, add the book to the filtered array
        if ($searchMatches && $categoryMatches && $publisherMatches) {
            $filteredBooks[] = $book;
        }
    }
} else {
    // No filters applied, use all books
    $filteredBooks = $books;
}

// Calculate the total number of pages based on the count of filtered books
$totalPages = ceil(count($filteredBooks) / $productsPerPage);

// Get the current page number from the URL
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Calculate the starting index for displaying products on the current page
$startIndex = ($currentPage - 1) * $productsPerPage;

// Get the subset of books to display on the current page
$displayedBooks = array_slice($filteredBooks, $startIndex, $productsPerPage);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=ZCOOL+QingKe+HuangYou&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/shop_style.css">
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

    <h1 class="s_title">All products</h1>

    <div class="page">
        <div class="filter">
            <div class="fbox">
                <form action="" method="get">
                    <div class="search-box">
                        <div class="search-container">
                            <input type="text" name="search" class="searching" placeholder="Search..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" autocomplete="off">
                            <button type="submit" class="icon"><i class="fa fa-search"></i></button>
                        </div>
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
                $isOutOfStock = false;

                foreach ($displayedBooks as $book) {
                    if ($book['inventory'] <= 0) {
                        $isOutOfStock = true;
                    }
                    echo "<div class='product-card'>";
                    echo "<div class='product-image'>";
                    echo "<img src='/project/biw_project/image/coverpage/{$book['cover']}' alt='{$book['name']}'>";
                    echo "</div>";
                    echo "<p>{$book['name']}</p>";

                    if ($book['promotion'] != 0) {
                        $originalPrice = $book['price']; // Store the original price
                        $book['price'] = $book['price'] - ($book['price'] * ($book['promotion'] / 100));
                        echo "<div class='price-container'>";
                        echo "<p class='discounted-price'>RM " . number_format($book['price'], 2) . "</p>";
                        echo "<p class='original-price' style='text-decoration: line-through;'>RM " . number_format($originalPrice, 2) . "</p>";
                        echo "</div>";
                    } else {
                        echo "<p>RM " . number_format($book['price'], 2) . "</p>";
                    }
                    

                    // Your code for displaying book details goes here
                    echo "<form action='cart_function.php' method='post'>";
                    echo "<input type='hidden' name='book_id' value='{$book['id']}'>";
                    echo "<input type='hidden' name='Pimage' value='{$book['cover']}'>";
                    echo "<input type='number' name='quantity' value='1' min='1' class='invisible-input'>";
                    echo "<input type='hidden' name='Pname' value='{$book['name']}'>";
                    echo "<input type='hidden' name='Pprice' value='{$book['price']}'>";
                    echo "<div class='btn-class'>";
                    echo "<input type='submit' class='btn btn-custom addToCartBtn' name='add_to_cart' value='Add to cart' data-inventory='{$book['inventory']}'>";
                    echo "</form>";
                    echo "<a href='details.php?book_id={$book['id']}' class='btn btn-custom'>View details</a>";
                    echo "</div>";
                    echo "</div>";

                }
                ?>

            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php echo $currentPage == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
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
                        <div class="col-11 h3">inspirasi@gmail.com</div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

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

        const addToCartBtns = document.querySelectorAll('.addToCartBtn');
        addToCartBtns.forEach(function(btn) {
            if (btn.getAttribute('data-inventory') <= 0) {
                btn.value = 'Out Of Stock';
                btn.disabled = true;
                btn.style.backgroundColor = "grey";
                btn.style.color = "white";
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        console.log("Script is running");

        // Send a request to the server to track the view
        fetch('track_view.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    page: 'homepage', // Add the 'page' key with the page name
                    // You can include additional information if needed
                }),
            })
            .then(response => {
                console.log("Response status:", response.status);
                return response.json();
            })
            .then(data => {
                console.log("Data received:", data);
                // Update the UI with the daily views count
                document.getElementById('daily-views').innerText = data.daily_views;
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
    });

    function redirectToAccount() {
        // Redirect to cus_acc.php when the "Account" word is clicked
        window.location.href = 'cus_acc.php';
    }
</script>

</html>