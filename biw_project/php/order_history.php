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

$sql = "SELECT * FROM orders WHERE customer_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $customerId); // 'i' represents integer type
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/order_history_style.css">
    <title>Order history</title>
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

    <h1>Order History</h1>
    <div class="page">
        <div class="side">
            <div class="side-bar">
                <input type="submit" class="side-btn" value="Account"><br>
                <input type="submit" class="side-btn" value="Contact and Address"><br>
                <input type="submit" class="side-btn" value="Order History">
            </div>
        </div>
        <div class="box-container">
            <?php
            foreach ($orders as $order) {
                echo "
        <div class='box'>
            <div class='container'>
                <div class='info'>
                    <p>Order Number: {$order['order_number']}</p>
                    <p>Order Date: {$order['created']}</p>
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
                <p>Total Price: RM {$order['grand_total']}</p>
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
                <p>(x{$orderItem['quantity']})</p>
            </div>
        ";
                }

                echo "
            </div>
        </div>
    </div>
    ";
            }
            ?>
        </div>
    </div>
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
            statusElements[i].style.backgroundColor = "yellow";
        } else if (status === "Shipping") {
            statusElements[i].style.backgroundColor = "blue";
        } else {
            statusElements[i].style.backgroundColor = "green";
        }
    }
</script>


</html>