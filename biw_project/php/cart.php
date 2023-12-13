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
require_once "cart_function.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/cart_style.css">
    <title>Cart</title>
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






    <h1 class="title">My cart</h1>
    <br><br>
    <hr>

    <div class="page">
        <div class="cart">
            <div class="card">
                <table>


                    <tbody>
                        <?php
                        $no = 1; // Initialize the $no variable
                        $total = 0;
                        $final = 0;
                        if (isset($_SESSION['cart'])) {
                            // echo '<pre>';
                            // print_r($_SESSION['cart']);
                            // echo '</pre>';
                            // $imagePath = '/project/biw_project/image/coverpage/sheclock.jpg';
                            // echo "<img src='$imagePath' alt='Test Image'>";
                            foreach ($_SESSION['cart'] as $key => $value) {
                                // Check if the key exists before trying to access it
                                $productImage = isset($value['productimage']) ? $value['productimage'] : '';
                                $total = (float)$value['productquantity'] * (float)$value['productprice'];

                                $final += $total;
                                echo "
                            
                                    <form action='cart_function.php' method='POST'>
                                    <tr>

                                    <td><img src='{$value['productimage']}' class='pimg'></td>


                                    <td class='ctr-name'>{$value['productname']}</td>
                                    
                                    <td>RM {$value['productprice']}</td>
                                    
                                    <td class='btn-q'>
                                    <span class='decre'><button type='button' class='q1'>-</button></span>
                                    <input type='number' id='quantity' name='Pquantity' class='inputQuantity' value='{$value['productquantity']}'></input>
                                    <span class='incre'><button type='button' class='q2'>+</button></span></td>
                                    
                                    <td><button name='update'>Update</button></td>
                                    <td><button name='remove'>Remove</button></td>
                                    <input type='hidden' name='item' value='{$value['productname']}'>
                                    </tr>
                                    </form>
                                    ";
                                $no++;
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="total">
            <div class="sum">


                <h1>Order Details</h1><br>
                <h2>Subtotal (<?= (int)$no ?>): </h2>
                <h2>RM <?= number_format($final, 2) ?></h2>
                <h2>Shipping fee: </h2>
                <form action="cart_function.php" method="POST">
                    <button type="submit" name="payment" class="btn btn-checkout">Checkout</button>
                </form>
                <a href="shop.php"><button>Continue shopping</button></a>
            </div>
        </div>
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