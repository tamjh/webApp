<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in as an admin
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Check if the user is logged in
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

// Connect to other PHP files
require_once "database.php";
require_once "books_function.php";
require_once "update_info.php";

// Fetch order_number from the URL
if (!empty($_GET['order_number'])) {
    $orderNumber = $_GET['order_number'];

    // Fetch order details
    $orderSql = "SELECT * FROM orders WHERE order_number = ?";
    $orderStmt = mysqli_prepare($conn, $orderSql);
    mysqli_stmt_bind_param($orderStmt, "s", $orderNumber);
    mysqli_stmt_execute($orderStmt);
    $orderResult = mysqli_stmt_get_result($orderStmt);
    $order = mysqli_fetch_assoc($orderResult);

    $comment = $order['comment'];

    mysqli_free_result($orderResult);
    mysqli_stmt_close($orderStmt);

    // Fetch items based on the order_number
    $itemsSql = "SELECT oi.product_id, oi.quantity, b.name, b.cover FROM order_items oi
                JOIN books b ON oi.product_id = b.id
                WHERE oi.order_number = ?";
    $itemsStmt = mysqli_prepare($conn, $itemsSql);
    mysqli_stmt_bind_param($itemsStmt, "s", $orderNumber);
    mysqli_stmt_execute($itemsStmt);
    $itemsResult = mysqli_stmt_get_result($itemsStmt);

    $orderItems = array();
    while ($row = mysqli_fetch_assoc($itemsResult)) {
        $orderItems[] = $row;
    }

    mysqli_free_result($itemsResult);
    mysqli_stmt_close($itemsStmt);
} else {
    // Redirect or handle the case when order_number is not provided
    header("Location: some_error_page.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/view_order_style.css">
    <title>Orders</title>
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

    <section>
        <h1>Order List</h1>

        <table>
            <thead>
                <th>No.</th>
                <th>Name</th>
                <th>Image</th>
                <th>Quantity</th>
            </thead>

            <tbody class="t-body">
                <?php foreach ($orderItems as $index => $item) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><img src="/project/biw_project/image/coverpage/<?= $item['cover'] ?>" alt="Product Image" width="30%;"></td>
                        <td><?= $item['quantity'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="comment-area">
            <label for="content">Comment:</label>
            <textarea name="comment" id="content" rows="auto"><?= $comment ?></textarea>
        </div>

    </section>

    <button onclick="backfunction();" class="btn btn-back btn-primary" style="padding:1rem; font-size:2rem">Back</button>



</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function backfunction() {
        window.location = "view_order.php";
    }
</script>

</html>