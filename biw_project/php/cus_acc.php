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

if (isset($_POST['update_phone'])) {
    $id = $_SESSION['uid'];

    $newName = $_POST['c_name'];
    $newemail = $_POST['c_email'];
    $newPhoneNumber = $_POST['c_phone'];


    $sql = "UPDATE users SET full_name = ?, email = ?, phone_number = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $newName, $newemail, $newPhoneNumber, $id);
    $stmt->execute();

    if ($stmt->execute()) {
        // Update session variables after successful update
        $_SESSION['customer_name'] = $newName;
        $_SESSION['email'] = $newemail;
        $_SESSION['phone'] = $newPhoneNumber;

        
    } else {
        echo "Error: " . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=ZCOOL+QingKe+HuangYou&display=swap">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/cus_app_style.css">
    <title>My account</title>
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
    <h1 class="title">My Account</h1>
    <div class="page">
        <div class="side">
            <div class="side-bar">
            <input type="button" class="side-btn" value="Account" onclick="redirectToAccount()"><br>
    <input type="button" class="side-btn" value="Contact and Address" onclick="redirectToContactAndAddress()"><br>
    <input type="button" class="side-btn" value="Order History" onclick="redirectToOrderHistory()">
            </div>
        </div>
        <div class="box-container">
            <div class="container">
                <form action="" method="post" class="acc">
                    <h1 class="mb-4 info">Account Information</h1>

                    <div class="mb-5">
                        <label for="name" class="form-label">Full Name:</label>
                        <input type="text" class="form-control" id="name" name="c_name" value="<?= $_SESSION['customer_name'] ?>">
                    </div>

                    <div class="mb-5">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="email" name="c_email" value="<?= $_SESSION['email'] ?>">
                    </div>

                    <div class="mb-5">
                        <label for="phone" class="form-label">Contact Number:</label>
                        <input type="text" class="form-control" id="phone" name="c_phone" value="<?= $_SESSION['phone'] ?>">
                    </div>

                    <button type="submit" class="btn btn-update" name="update_phone">Update</button>
                </form>
            </div>
        </div>
    </div>



</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function redirectToAccount() {
        // Redirect to cus_acc.php when the "Account" word is clicked
        window.location.href = 'cus_acc.php';
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