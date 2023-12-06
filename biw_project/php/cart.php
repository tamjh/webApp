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
require_once "books_function.php";
require_once "books_function.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/project/biw_project/css/cart_style.css">
    <title>Cart</title>
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

    <h1 class="title">My cart</h1>
    <br><br>
    <hr>

    <div class="page">
        <div class="cart">
            <table>


                <tbody>
                    <?php
                    $no = 1; // Initialize the $no variable
                    $total = 0;
                    $final = 0;
                    if (isset($_SESSION['cart'])) {
                        echo '<pre>';
                        print_r($_SESSION['cart']);
                        echo '</pre>';
                        $imagePath = '/project/biw_project/image/coverpage/sheclock.jpg';
                        echo "<img src='$imagePath' alt='Test Image'>";
                        foreach ($_SESSION['cart'] as $key => $value) {
                            // Check if the key exists before trying to access it
                            $productImage = isset($value['productimage']) ? $value['productimage'] : '';
                            $total = $value['productquantity'] * $value['productprice'];
                            $final += $total;
                            echo "
                            
                                    <form action='cart_function.php' method='POST'>
                                    <tr>

                                    <td><img src='{$value['productimage']}'></td>


                                    <td>{$value['productname']}</td>
                                    
                                    <td>{$value['productprice']}</td>
                                    <td><input type='number' name='Pquantity' value='{$value['productquantity']}'></input></td>
                                    <td><button name='update'>Update</button></td>
                                    <td><button name='remove'>Remove</button></td>
                                    <td><input type='hidden' name='item' value='{$value['productname']}'></td>
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
        <div class="total">
            <h1>Order Details</h1><br>
            <h2>Subtotal (<?=$no?>): </h2>
            <h2>RM <?= number_format($final, 2) ?></h2>
            <h2>Shipping fee: </h2>

        </div>
    </div>

</body>

</html>
