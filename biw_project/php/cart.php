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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=ZCOOL+QingKe+HuangYou&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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





    <div class="title">
        <h1 class="c_title">My Cart</h1>
    </div>
    <br><br>
    

    <div class="page">
        <div class="cart">
            <div class="card">
                <table>


                    <tbody>
                        <?php
                        $no = 1; // Initialize the $no variable
                        $total = 0;
                        $_SESSION['total'] = 0;
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

                                $_SESSION['total'] += $total;
                                echo "
                            
                                    <form action='cart_function.php' method='POST'>
                                    <tr>

                                    <td><img src='{$value['productimage']}' class='pimg'></td>


                                    <td class='ctr-name'>{$value['productname']}</td>
                                    
                                    <td>RM ". number_format($value['productprice'],2) ."</td>
                                    
                                    <td class='btn-q'>
                    <span class='decre'><button type='button' class='q1' onclick='decreaseQuantity({$no})'><i class='fa-solid fa-minus'></i></button></span>
                    <input type='number' id='quantity_{$no}' name='Pquantity' class='inputQuantity' value='{$value['productquantity']}'></input>
                    <span class='incre'><button type='button' class='q2' onclick='increaseQuantity({$no})'><i class='fa-solid fa-plus'></i></button></span>
                </td>
                                    
                                    <td><button name='update'><span class='material-symbols-outlined'>
                                    update
                                    </span></button></td>
                                    <td><button name='remove'><span class='material-symbols-outlined'>
                                    delete
                                    </span></button></td>
                                    <input type='hidden' name='item' value='{$value['productname']}'>
                                    </tr>
                                    </form>
                                    ";
                                $no++;
                            }

                            // Calculate shipping fee based on the total
                            if ($_SESSION['total'] > 20) {
                                $_SESSION['shipping'] = 0; // Free shipping if total is more than 20
                            } else {
                                $_SESSION['shipping'] = 5; // Set shipping fee to 5 if total is 20 or less
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
                <h2 class="totalPrice">RM <?= number_format($_SESSION['total'], 2) ?></h2>
                <h2>Shipping fee: </h2>
                <h2>RM <?= number_format($_SESSION['shipping'], 2) ?></h2>
                <?php
                $_SESSION['final'] = $_SESSION['total'] + $_SESSION['shipping'];
                ?>
                <form action="shipping_info.php" method="POST">
                    <button type="submit" name="payment" class="btn btn-checkout">Checkout</button>
                </form>
                <a href="shop.php"><button>Continue shopping</button></a>
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
<script src="numberkey.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    function increaseQuantity(index) {
        var inputQuantity = document.getElementById("quantity_" + index);
        inputQuantity.stepUp();
    }

    function decreaseQuantity(index) {
        var inputQuantity = document.getElementById("quantity_" + index);
        inputQuantity.stepDown();
    }

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
    function redirectToAccount() {
        // Redirect to cus_acc.php when the "Account" word is clicked
        window.location.href = 'cus_acc.php';
    }
</script>

</html>