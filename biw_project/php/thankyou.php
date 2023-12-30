<?php
session_start();



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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/project/biw_project/css/thankyou.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

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
                    <a href="cart.php" class="fas fa-cart-plus" style="text-decoration: none;"></a>
                    <div class="dropdown">
                        <a href="#" class="fas fa-user" onclick="myFunction()" style="text-decoration: none;"></a>
                        <div id="myDropdown" class="menu" style="padding: 20px; font-size: 1rem;">
                            <p  onclick="redirectToAccount()" style="font-size:2rem;">Account</p>
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

    <div class="container-2">
        <div class="con">
            <div class="row mt-5">
                <div class="col thank-you display-1 ">THANK YOU!</div>
            </div>
            <div class="row my-2 fade-in-left">
                <div class="col display-3 " style="font-weight: bold;">We've received your orders <span class="bi bi-truck"></span></div>
            </div>

            <div class="row my-4 appear-and-enlarge">
                <div class="col">
                    <span class="bi bi-check2 display-1 "></span>
                </div>
            </div>

            <div class="row py-3 appear-and-enlarge2">
    <div class="col">
        <a href="homepage.php" class="btn btn-primary">
            <span class="bi bi-house"> Home</span>
        </a>
    </div>
</div>

        </div>

    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function redirectToAccount() {
        // Redirect to cus_acc.php when the "Account" word is clicked
        window.location.href = 'cus_acc.php';
    }
</script>

</html>