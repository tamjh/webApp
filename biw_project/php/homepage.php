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


                    <div class="carousel-indicators ">
                        <button type="button" data-bs-target="#ad" data-bs-slide-to="0" class="active "></button>
                        <button type="button" data-bs-target="#ad" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#ad" data-bs-slide-to="2"></button>
                    </div>

                </div>

            </div>

            <!--  -->

            <section class="feature" style="margin: 20px 0px;">
            
                <h1 class="display-6 text-center g-0 py-3 py-md-4 fea">Our feature</h1>
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
                    <a class="m-3 mb-5 a1 " href="shop.php">
                        <img class="img-book " src="../image/image/n3.jpg">
                        <p class="shop">Novel</p>
                    </a>
                    <a class="m-3 mb-5 a1 " href="shop.php">
                        <img class="img-book " src="../image/image/a1.jpg">
                        <p class="shop">Primary School</p>
                    </a>
                    <a class="m-3 mb-5 a1 " href="shop.php">
                        <img class="img-book " src="../image/image/a8.jpg">
                        <p class="shop">Secondary School</p>
                    </a>

                    <a class="m-3 mb-5 a1 " href="shop.php">
                        <img class="img-book " src="../image/image/c1.jpg">
                        <p class="shop">Children Book</p>
                    </a>



                </div>

            </div>
    </div>



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
</script>

</html>