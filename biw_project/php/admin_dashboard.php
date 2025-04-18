<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: login.php");
    exit();
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
$ordersQuery = "SELECT orders.*, users.full_name, status.condition 
                FROM orders 
                JOIN users ON orders.customer_id = users.id
                JOIN status ON orders.status = status.id
                ORDER BY orders.created DESC
                LIMIT 30";
$ordersResult = mysqli_query($conn, $ordersQuery);

// Check if the query was successful
if ($ordersResult) {
    $orders = mysqli_fetch_all($ordersResult, MYSQLI_ASSOC);
} else {
    $orders = []; // Empty array if there's an error
}

function getStatusColorClass($status)
{
    switch ($status) {
        case 'Preparing':
            return 'bg-blue'; // Add a class for a blue background
        case 'Shipping':
            return 'bg-yellow'; // Add a class for a yellow background
        case 'Complete':
            return 'bg-green'; // Add a class for a green background
        default:
            return '';
    }
}

$recentCustomersQuery = "SELECT * FROM users WHERE usertype = 'customer'";
$recentCustomersResult = mysqli_query($conn, $recentCustomersQuery);

// Check if the query was successful
if ($recentCustomersResult) {
    $recentCustomers = mysqli_fetch_all($recentCustomersResult, MYSQLI_ASSOC);
} else {
    $recentCustomers = []; // Empty array if there's an error
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/admin_dashboard.css">
    <title>Document</title>
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
                        <a class="nav-link" href="admin_dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_order.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_acc.php">Account</a>
                    </li>

                </ul>

                <div class="icons" style="text-decoration: none; font-size: 2.5rem; display: flex;">

                    <div class="dropdown">
                        <div id="myDropdown" class="menu" style="padding: 20px; font-size: 1rem;">

                            <p style="font-size:2rem;">Account</p>
                            <form method="post">
                                <button type="submit" name="logout" class="logout">Logout</button>
                            </form>
                        </div>
                    </div>
                    <a href="index.php" class="web">
                        <p class="web">View Website</p>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="page">

        <!-- ======================= Cards ================== -->
        <div class="cardBox">


            <div class="card">
                <div class="cardContent">
                    <div class="numbers">
                    <span id="daily-views">
                        <?php
                        $countQuery = "SELECT COUNT(*) AS daily_views FROM page_views WHERE DATE(view_date) = CURDATE()";
                        $countResult = mysqli_query($conn, $countQuery);
                        
                        if ($countResult) {
                            $countData = mysqli_fetch_assoc($countResult);
                            $dailyViews = $countData['daily_views'];
                        } else {
                            $dailyViews = 0;
                        }
                        echo "$dailyViews";
                        ?>
                        Visits
                    </span>
                    </div>
                    <div class="cardName">Daily Views</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="cardContent">
                    <div class="numbers">
                    <?php
                        $num = 0;
                        $select_pending = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                        if (mysqli_num_rows($select_pending) > 0) {
                            while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                                
                                $num++;
                            };
                        };
                        ?>
                        <?php echo $num; ?>
                        Orders
                    </div>
                    <div class="cardName">Monthly Sales</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cart-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="cardContent">
                    <div class="numbers">
                    RM
                    <?php
                        $total_pendings = 0;
                        $select_pending = mysqli_query($conn, "SELECT grand_total FROM `orders`") or die('query failed');
                        if (mysqli_num_rows($select_pending) > 0) {
                            while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                                $total_price = $fetch_pendings['grand_total'];
                                $total_pendings += $total_price;
                            };
                        };
                        ?>
                        <?php echo $total_pendings; ?>
                    </div>
                    <div class="cardName">Monthly Earning</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div>
            </div>
        </div>
        <!-- ================ Order Details List ================= -->
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Recent Orders</h2>
                    <a href="view_order.php" class="btn" style="font-size:15px;">View All</a>
                </div>

                <table>
                    <thead>
                        <tr class="text-center">
                            <td>Date</td>
                            <td>Order Number</td>
                            <td>Customer Name</td>
                            <td>Grand Total</td>
                            <td>Payment</td>
                            <td>Status</td>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        <?php foreach ($orders as $order) { ?>
                            <tr class="whitte">

                                <td><?= $order['created'] ?></td>
                                <td class="orderNumber"><a href="order_list.php?order_number=<?= $order['order_number'] ?>"><?= $order['order_number'] ?></a></td>
                                <td><?= $order['full_name'] ?></td>
                                <td>RM <?= number_format($order['grand_total'], 2) ?></td>
                                <td>Paid</td>
                                <td class="text-center status <?= getStatusColorClass($order['condition']) ?>">
                                    <?= $order['condition'] ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <!-- ================= New Customers ================ -->
            <div class="recentCustomers">
                <div class="cardHeader customer-head">
                    <h2 style="margin-bottom: 0;">Recent Customers</h2>
                </div>

                <table>
                    <?php foreach ($recentCustomers as $customer) { ?>
                        <tr>
                            <td>
                                <h4><?= $customer['full_name'] ?> <br>
                                    <span><?= $customer['email'] ?></span>
                                </h4>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // add hovered class to selected list item
    let list = document.querySelectorAll(".navigation li");

    function activeLink() {
        list.forEach((item) => {
            item.classList.remove("hovered");
        });
        this.classList.add("hovered");
    }

    list.forEach((item) => item.addEventListener("mouseover", activeLink));

    // Menu Toggle
    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main");

    toggle.onclick = function() {
        navigation.classList.toggle("active");
        main.classList.toggle("active");
    };




</script>

</html>