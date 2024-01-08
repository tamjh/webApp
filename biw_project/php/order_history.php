<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    // Unset and destroy the session
    session_unset();
    session_destroy();
    header("Location: login.php"); // Redirect to the login page after logout
    exit();
}

if (isset($_POST['function'])) {
    header("Location: #");
    exit();
}
require_once "database.php";
require_once "books_function.php";

$statuses = get_all_status($conn);

$customerId = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;

$sql = "SELECT * FROM orders WHERE customer_id = ? ORDER BY created DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $customerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=ZCOOL+QingKe+HuangYou&display=swap">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/order_history_style.css">
    <title>Order history</title>
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
                        <a class="nav-link" href="index.php">Home</a>
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

    <h1 class="title">Order History</h1>
    <div class="page">
        <div class="side">
            <div class="side-bar">
                <input type="button" class="side-btn" value="Account" onclick="redirectToAccount()"><br>
                <input type="button" class="side-btn" value="Contact and Address" onclick="redirectToContactAndAddress()"><br>
                <input type="button" class="side-btn" value="Order History" onclick="redirectToOrderHistory()">
            </div>
        </div>
        <div class="box-container">
            <?php
            if (empty($orders)) {
                echo "
                <div class='forempty'>
                <p class='empty'>Haven't bought anything yet.</p>
                </div>
                ";
            } else {
                foreach ($orders as $order) {
                    echo "
        <div class='box'>
            <div class='container'>
                <div class='info'>
                    <p>Order Number: {$order['order_number']}</p>
                    <p>Order Date: " . substr($order['created'], 0, 10) . "</p>
                    ";

                    if ($statuses == 0 || empty($statuses)) {
                        echo "Undefined";
                    } else {
                        $statusfound = false;
                        foreach ($statuses as $status) {
                            if ($status['id'] == $order['status']) {
                                echo "<p class='scondition'>Order Status: <span class='applying'>{$status['condition']}</span></p>";
                                $statusfound = true;
                                break;
                            }
                        }
                        if (!$statusfound) {
                            echo "Undefined";
                        }
                    }

                    echo "
                <p class='highlight'>Total Price: RM " . number_format($order['grand_total'], 2) . "</p>
                </div>
            <div class='img-container'>
    ";

                    // Fetch and display order items for each order
                    $orderItemId = $order['id'];
                    $orderItemsSql = "SELECT * FROM order_items WHERE order_id = ?";
                    $orderItemsStmt = mysqli_prepare($conn, $orderItemsSql);
                    mysqli_stmt_bind_param($orderItemsStmt, 'i', $orderItemId);
                    $orderItemsStmt->execute();
                    $orderresult = mysqli_stmt_get_result($orderItemsStmt);
                    $orderItems = mysqli_fetch_all($orderresult, MYSQLI_ASSOC);

                    foreach ($orderItems as $orderItem) {
                        $productId = $orderItem['product_id'];

                        // Fetch book details based on product_id
                        $bookDetailsSql = "SELECT * FROM books WHERE id = ?";
                        $bookDetailsStmt = mysqli_prepare($conn, $bookDetailsSql);
                        mysqli_stmt_bind_param($bookDetailsStmt, 'i', $productId);
                        $bookDetailsStmt->execute();
                        $bookResult = mysqli_stmt_get_result($bookDetailsStmt);
                        $bookDetails = mysqli_fetch_assoc($bookResult);

                        echo "
            <div class='img1'>
                <img class='img' src='/project/biw_project/image/coverpage/{$bookDetails['cover']}' alt='{$bookDetails['name']}'><br>
                <p class='img1p'>(x{$orderItem['quantity']})</p>
            </div>
        ";
                    }

                    echo "
            </div>
        </div>
    </div>
    ";
                }
            }
            ?>
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
    let statusElements = document.getElementsByClassName("applying");
    for (let i = 0; i < statusElements.length; i++) {
        let status = statusElements[i].textContent;
        if (status === "Preparing") {
            statusElements[i].style.backgroundColor = "#EEE8AA";
        } else if (status === "Shipping") {
            statusElements[i].style.backgroundColor = "#ADD8E6";
        } else {
            statusElements[i].style.backgroundColor = "#90EE90";
        }
    }



    function redirectToAccount() {
        // Redirect to cus_acc.php when "Account" button is clicked
        window.location.href = 'cus_acc.php';
    }

    function redirectToContactAndAddress() {
        // Redirect to cus_add.php when "Contact and Address" button is clicked
        window.location.href = 'cus_add.php';
    }

    function redirectToOrderHistory() {
        // Redirect to order_history.php when "Order History" button is clicked
        window.location.href = 'order_history.php';
    }
</script>


</html>