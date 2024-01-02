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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/homepage_style.css">
    <title>Product Page</title>
</head>

<body>
<header class="navbar navbar-expand-lg navbar-light bg-light" style="font-size: 2rem; padding: 2rem 9%;">
        <div class="container-fluid">

            <a href="#" class="navbar-brand" style="font-size: 3rem">
                <span><img src="/project/biw_project/image/icon/logo.png" alt="Inspirasi Sejahtera" style="width: 100px; height: auto;"></span>
            </a>
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
                                    $_SESSION['usertype'] = "customer";
                                    echo "<button type='submit' name='logout' class='logout'><i class='fa-solid fa-right-to-bracket'></i>Login</button>";
                                } else {
                                    echo "<button type='submit' name='logout' class='logout'>
                
                Logout
            </button>";
                                }
                                ?>
                            </form>


                        </div>
                    </div>
                </div>
                <div class="account_box" style="padding: 10px; font-size:2rem;">
                    <?php
                    if ($_SESSION['usertype'] == "admin") {
                        echo "<a href='admin_dashboard.php' style='text-decoration:none;'><p style='color:white;'>Back To Dashboard</p></a>";
                    } else if ($_SESSION['usertype'] == "customer") {
                        echo "<p>Hello, <span>{$_SESSION['customer_name']}</span></p>";
                    }
                    ?>
                </div>

            </div>
        </div>
    </header>

    <div class="container">
        <div class="shadow-lg my-3 w-100 mx-auto rounded c1">
            <div id="ad" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner pb-5 ">

                    <!-- add product page hyperlink for the images -->

                    <div class="carousel-item active ">
                        <a href="#"><img src="../image/image/ad1.jpg" class="d-block mx-auto img-fluid rounded  " alt="Ad cannot be displayed"></a>
                    </div>

                    <div class="carousel-item">
                        <a href="#"><img src="../image/image/ad2.jpg" class="d-block mx-auto img-fluid rounded  " alt="Ad cannot be displayed"></a>
                    </div>

                    <div class="carousel-item">
                        <a href="#"><img src="../image/image/ad3.jpg" class="d-block mx-auto img-fluid rounded  " alt="Ad cannot be displayed"></a>
                    </div>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#ad" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#ad" data-bs-slide="next">
                    <span class="carousel-control-next-icon " aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>


                <div class="carousel-indicators ">
                    <button type="button" data-bs-target="#ad" data-bs-slide-to="0" class="active "></button>
                    <button type="button" data-bs-target="#ad" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#ad" data-bs-slide-to="2"></button>
                </div>

            </div>

        </div>

        <!--  -->

        <section class="feature" style="margin: 20px 0px;">

            <h1 class="display-6 text-center g-0 py-3 py-md-4 fea">Why Choose Us</h1>
            <div class="icons">
                <img src="../image/image/f3.png">
                <div class="info">
                    <h3>Free Delivery</h3>
                </div>

            </div>

            <div class="icons">
                <img src="../image/image/f1.jpg">
                <div class="info">
                    <h3>24/7 Service</h3>
                </div>

            </div>
            <div class="icons">
                <img src="../image/image/f2.jpg">
                <div class="info">
                    <h3>Secure Payment</h3>
                </div>

            </div>

            <div class="icons">
                <img src="../image/image/f4.jpg">
                <div class="info">
                    <h3>Cost Effective</h3>
                </div>

            </div>
        </section>

        <!--  -->

        <div class="row book my-5 p-2 p-md-4  rounded g-5 mx-5 h-100">
            <div class="display-6 text-center g-0 py-3 py-md-4 books">Categories</div>

            <div class="text-center d-flex flex-column flex-md-row justify-content-between overflow-auto w-auto h-auto  b-im">
                <a class="m-3 mb-5 a1 " href=" shop.php?search=&category_filter[]=1">
                    <img class="img-book " src="../image/image/n3.jpg">
                    <p class="shop">Novel</p>
                </a>
                <a class="m-3 mb-5 a1 " href=" shop.php?search=&category_filter[]=5">
                    <img class="img-book " src="../image/image/a1.jpg">
                    <p class="shop">Primary School</p>
                </a>
                <a class="m-3 mb-5 a1 " href="shop.php">
                    <img class="img-book " src="../image/image/a8.jpg">
                    <p class="shop">High School</p>
                </a>

                <a class="m-3 mb-5 a1 " href=" shop.php?search=&category_filter[]=3">
                    <img class="img-book " src="../image/image/c1.jpg">
                    <p class="shop">Children Book</p>
                </a>



            </div>

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