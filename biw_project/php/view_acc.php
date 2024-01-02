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

$sql = "SELECT u.id, u.full_name, u.phone_number, u.usertype,
                CONCAT(ad.unit, ' ', ad.street, ' ', ad.postcode, ' ', ad.city, ' ', ad.state) AS full_address,
                COUNT(o.id) as order_count
        FROM users u
        LEFT JOIN orders o ON u.id = o.customer_id
        LEFT JOIN address ad ON u.id = ad.customer_id
        GROUP BY u.id";


$result = mysqli_query($conn, $sql);

$cus = array();

while ($row = mysqli_fetch_assoc($result)) {
    $cus[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/view_acc.css">

</head>

<body>
    <div class="cover" id="cover"></div>
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
                    <a href="homepage.php" class="web">
                        <p class="web">View Website</p>
                    </a>
                </div>
            </div>
        </div>
    </header>




    <h1 class="im">Account Mangement</h1>
    <div class="separate">
        <button class="btn btn-sep">Customer</button>
        <button class="btn btn-sep">Admin</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Number of Orders</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($cus as $customer) {
                if ($customer['usertype'] == "customer") {
                    echo "<tr>";
                    echo "<td>{$count}</td>";
                    echo "<td>{$customer['full_name']}</td>";
                    echo "<td>" . ($customer['phone_number'] ? $customer['phone_number'] : 'N/A') . "</td>";
                    echo "<td>" . ($customer['full_address'] ? $customer['full_address'] : 'N/A') . "</td>";
                    echo "<td>{$customer['order_count']}</td>";
                    echo "</tr>";
                    $count++;
                } else {

                }
            }
            ?>


        </tbody>
    </table>

    <a href="#" class="top"><i class="fa-solid fa-arrow-up"></i></a>
    <button class="plus btn" onclick="appear();">Add Admin</i></button>

    <!--pop out form-->
    <div id="popup_new_admin" class="popup-form formnone" style="text-transform:none;">
        <form method="post" action="process_admin.php"> <!-- Replace with the actual processing script -->
            <h2>Add New Admin</h2>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone number:</label>
                <input type="phone" id="phone" name="phone" required>
            </div>
            <div class="btn-group">
                <button type="submit" name="btn-submit" class="btn-submit btn">Add Admin</button>

                <button class="btn" style="margin-left: 10px;" onclick="closePopup()">Close</button>
            </div>
        </form>

    </div>
    <!---->

    <!--    ******************************************************************************************************************* -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        function appear() {
            console.log("Appear function called");
            document.getElementById("cover").style.display = "block";
            document.getElementById("popup_new_admin").style.display = "block";
        }

        function closePopup() {
            console.log("Close popup function called");
            document.getElementById("cover").style.display = "none";
            document.getElementById("popup_new_admin").style.display = "none";
        }
    </script>
</body>

</html>