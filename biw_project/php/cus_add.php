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

if (isset($_POST['update_address'])) { // Updated to 'update_address'
    $id = $_SESSION['uid'];

    $newUnit = $_POST['unit'];
    $newStreet = $_POST['street'];
    $newPostcode = $_POST['postcode'];
    $newCity = $_POST['city'];
    $newState = $_POST['state'];

    $sql = "UPDATE address SET unit = ?, street = ?, postcode = ?, city = ?, state = ? WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $newUnit, $newStreet, $newPostcode, $newCity, $newState, $id);
    $stmt->execute();

    if ($stmt->execute()) {
        // Update session variables after successful update
        $_SESSION['unit'] = $newUnit;
        $_SESSION['street'] = $newStreet;
        $_SESSION['postcode'] = $newPostcode;
        $_SESSION['city'] = $newCity;
        $_SESSION['state'] = $newState;

        echo "Update successful!";
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
    <h1 class="title">Address Information</h1>
    <div class="page">
        <div class="side">
            <div class="side-bar">
                <input type="submit" class="side-btn" value="Account"><br>
                <input type="submit" class="side-btn" value="Contact and Address"><br>
                <input type="submit" class="side-btn" value="Order History">
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

                        <div class="row mx-sm-2 mx-md-3 mx-xl-4">
                            <div class="col-12 col-md-4 col-xl-2">
                                <div class="form-group">
                                    <label for="postcode">Postcode</label>
                                    <input type="text" name="postcode" id="postcode" class="border rounded-2 px-2 w-100" value="<?= isset($_SESSION['postcode']) ? $_SESSION['postcode'] : '' ?>" placeholder="<?= empty($_SESSION['postcode']) ? 'postcode' : '' ?>">
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
                                    <input type="text" name="state" id="state" class="border rounded-2 px-2 w-100" value="<?= isset($_SESSION['state']) ? $_SESSION['state'] : '' ?>" placeholder="<?= empty($_SESSION['state']) ? 'state' : '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end"> <!-- Add this container for button alignment -->
                        <button type="submit" class="btn btn-update" name="update_address">Update</button>
                    </div>
                </form>
            </div>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
</script>

</html>