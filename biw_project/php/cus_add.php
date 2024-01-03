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

$id = $_SESSION['uid'];

// Retrieve user's existing address
$selectSql = "SELECT * FROM address WHERE customer_id = ?";
$selectStmt = $conn->prepare($selectSql);
$selectStmt->bind_param("i", $id);
$selectStmt->execute();
$result = $selectStmt->get_result();

if ($result !== false) {
    if ($result->num_rows > 0) {
        // User has an existing address, retrieve the data
        $addressData = $result->fetch_assoc();

        // Set the session variables for the address (optional)
        $_SESSION['unit'] = $addressData['unit'];
        $_SESSION['street'] = $addressData['street'];
        $_SESSION['postcode'] = $addressData['postcode'];
        $_SESSION['city'] = $addressData['city'];
        $_SESSION['state'] = $addressData['state'];
    }
}

// Handle the form submission
if (isset($_POST['update_address'])) {
    $newUnit = $_POST['unit'];
    $newStreet = $_POST['street'];
    $newPostcode = $_POST['postcode'];
    $newCity = $_POST['city'];
    $newState = $_POST['state'];

    // If no existing address, insert a new one
    if ($result->num_rows === 0) {
        $insertSql = "INSERT INTO address (customer_id, unit, street, postcode, city, state) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("isssss", $id, $newUnit, $newStreet, $newPostcode, $newCity, $newState);
        $insertStmt->execute();
    } else {
        // Update the existing address
        $updateSql = "UPDATE address SET unit = ?, street = ?, postcode = ?, city = ?, state = ? WHERE customer_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssssi", $newUnit, $newStreet, $newPostcode, $newCity, $newState, $id);
        $updateStmt->execute();
    }

    // Update session variables after successful update or insert
    $_SESSION['unit'] = $newUnit;
    $_SESSION['street'] = $newStreet;
    $_SESSION['postcode'] = $newPostcode;
    $_SESSION['city'] = $newCity;
    $_SESSION['state'] = $newState;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=ZCOOL+QingKe+HuangYou&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/cus_app_style.css">
    <title>My account</title>
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
    <h1 class="title">Address Information</h1>
    <div class="page">
        <div class="side">
            <div class="side-bar">
                <input type="button" class="side-btn" value="Account" onclick="redirectToAccount()"><br>
                <input type="button" class="side-btn" value="Contact and Address" onclick="redirectToContactAndAddress()"><br>
                <input type="button" class="side-btn" value="Order History" onclick="redirectToOrderHistory()">
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <form action="" method="post">
                    <div class="container bg-light p-2 border rounded-4 mb-3 p-3 p-md-4">
                        <div class="display-6 pb-1 pb-md-3">Address</div>
                        <div class="row mx-sm-2 mx-md-3 mx-xl-4 mb-3">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <input type="text" name="unit" id="unit" class="border rounded-2 px-2 w-100" value="<?= isset($_SESSION['unit']) ? $_SESSION['unit'] : '' ?>" placeholder="<?= empty($_SESSION['unit']) ? 'unit' : '' ?>">

                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input type="text" name="street" id="street" class="border rounded-2 px-2 w-100" value="<?= isset($_SESSION['street']) ? $_SESSION['street'] : '' ?>" placeholder="<?= empty($_SESSION['street']) ? 'street' : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row mx-sm-2 mx-md-3 mx-xl-4 sb">
                            <div class="col-12 col-md-4 col-xl-2 sb">
                                <div class="form-group">
                                    <label for="postcode">Postcode</label>
                                    <input type="text" name="postcode" id="postcode" class="border rounded-2 px-2 w-100" style="width:20px;" value="<?= isset($_SESSION['postcode']) ? $_SESSION['postcode'] : '' ?>" placeholder="<?= empty($_SESSION['postcode']) ? 'postcode' : '' ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-xl-5">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="border rounded-2 px-2 w-100" value="<?= isset($_SESSION['city']) ? $_SESSION['city'] : '' ?>" placeholder="<?= empty($_SESSION['city']) ? 'city' : '' ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-xl-5">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <select name="state" id="state" class="border rounded-2 px-2 w-100">
                                        <?php
                                        $selectedState = isset($_SESSION['state']) ? $_SESSION['state'] : '';

                                        $states = ["Johor", "Kedah", "Kelantan", "Kuala Lumpur", "Labuan", "Melaka", "Negeri Sembilan", "Pahang", "Penang", "Perak", "Perlis", "Putrajaya", "Sabah", "Sarawak", "Selangor", "Terengganu"];

                                        foreach ($states as $state) {
                                            echo "<option value=\"$state\"";
                                            if ($state === $selectedState) {
                                                echo " selected";
                                            }
                                            echo ">$state</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end"> <!-- Add this container for button alignment -->
                            <button type="submit" class="btn btn-update" name="update_address">Update</button>
                        </div>
                    </div>

                </form>
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