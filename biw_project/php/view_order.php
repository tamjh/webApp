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

//connect others php file
require_once "database.php";
require_once "books_function.php";
require_once "update_info.php";

//call function for books_function.php
$books = get_all_books($conn);
if (!is_array($books)) {
    $books = array();
}
$categories = get_all_categories($conn);
$publishers = get_all_publisher($conn);


$sql = "SELECT
            o.created,
            o.order_number,
            u.full_name,
            u.phone_number,
            CONCAT(a.unit, ', ', a.street, ', ', a.postcode, ', ', a.city, ', ', a.state) AS full_address,
            o.grand_total,
            o.status
        FROM orders o
        JOIN users u ON o.customer_id = u.id
        JOIN address a ON o.customer_id = a.customer_id ORDER BY created DESC" ;
$result = mysqli_query($conn, $sql);

$orders = array();

while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

mysqli_free_result($result);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["order_id"]) && isset($_POST["new_status"])) {
    $orderId = $_POST["order_id"];
    $newStatus = $_POST["new_status"];

    $updateSql = "UPDATE orders SET status = ? WHERE order_number = ?";
    $stmt = mysqli_prepare($conn, $updateSql);

    mysqli_stmt_bind_param($stmt, "is", $newStatus, $orderId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("Location: " . $_SERVER['PHP_SELF']);
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
                    <a href="homepage.php" class="web"><p class="web">View Website</p></a>
                </div>
            </div>
        </div>
    </header>
    <section class="container mt-5">
        <h1 class="mb-4 p-title">Customer Orders</h1>

        <table class="table table-bordered">
            
                <tr>
                    <th>Date</th>
                    <th>Order Number</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Total</th>
                    <th>Items</th>
                    <th>Status</th>
                
                </tr>
            
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= $order['created'] ?></td>
                        <td><?= $order['order_number'] ?></td>
                        <td><?= $order['full_name'] ?></td>
                        <td><?= $order['phone_number'] ?></td>
                        <td><?= $order['full_address'] ?></td>
                        <td>RM <?= number_format($order['grand_total'],2) ?></td>
                        <td><a href="order_list.php?order_number=<?= $order['order_number'] ?>">View Order List</a></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?= $order['order_number'] ?>">
                                <select class="dropdown_status" name="new_status" onchange="updateStatus(this)">
                                    <option value="1"  <?= $order['status'] == 1 ? 'selected' : '' ?> class="pending">Pending</option>
                                    <option value="2" <?= $order['status'] == 2 ? 'selected' : '' ?> class="shipping">Shipping</option>
                                    <option value="3" <?= $order['status'] == 3 ? 'selected' : '' ?> class="complete">Completed</option>
                                </select>
                                <button type="submit" style="display: none;"></button>
                            </form>

                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <a href="#" class="top"><i class="fa-solid fa-arrow-up"></i></a>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function updateStatus(select) {
        var form = select.parentNode; // Get the parent form element
        form.querySelector('button').click(); // Trigger the form submission using the hidden button
    }
</script>


</html>