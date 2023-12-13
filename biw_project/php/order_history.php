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
    <link rel="stylesheet" href="/project/biw_project/css/order_history_style.css">
    <title>Order history</title>
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
    <h1>Order History</h1>
    <div class="page">
        <div class="side">
            <input type="submit" class="btn" value="Account"><br>
            <input type="submit" class="btn" value="Contact and Address"><br>
            <input type="submit" class="btn" value="Order History">
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
                        <div class='img-container'>
                            <img class='img' src='/project/biw_project/image/coverpage/{$bookDetails['cover']}' alt='{$bookDetails['name']}'><br>
                            <p>(x{$orderItem['quantity']})</p>
                        </div>
                    ";
                }

                // Remove the closing </div> tag from here
                echo "
                    </div>
                </div>
                ";
            }
            ?>
        </div>
    </div>
</body>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
    let statusElements = document.getElementsByClassName("applying");
    for (let i = 0; i < statusElements.length; i++) {
        let status = statusElements[i].textContent;
        if(status === "Preparing"){
            statusElements[i].style.backgroundColor = "yellow";
        }
        else if(status === "Shipping"){
            statusElements[i].style.backgroundColor = "blue";
        }
        else{
            statusElements[i].style.backgroundColor = "green";
        }
    }
</script>


</html>