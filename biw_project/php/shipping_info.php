<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit(); // Make sure to exit after a header redirect
}

if (isset($_POST['logout'])) {
    // Unset and destroy the session
    session_unset();
    session_destroy();

    // Redirect to the login page after logout
    header("Location: login.php");
    exit(); // Make sure to exit after a header redirect
}

require_once "database.php";

    // Fetch user address data from the database
    $userId = $_SESSION['uid'];
    $addressQuery = "SELECT * FROM address WHERE customer_id = ?";
    $addressStmt = $conn->prepare($addressQuery);
    $addressStmt->bind_param("i", $userId);
    $addressStmt->execute();
    $addressResult = $addressStmt->get_result();

    if ($addressResult->num_rows > 0) {
        $addressData = $addressResult->fetch_assoc();

        // Store address data in session for later use
        $_SESSION['unit'] = $addressData['unit'];
        $_SESSION['street'] = $addressData['street'];
        $_SESSION['postcode'] = $addressData['postcode'];
        $_SESSION['city'] = $addressData['city'];
        $_SESSION['state'] = $addressData['state'];
    }
    $addressStmt->close();

if (isset($_POST['submit'])) {
    
    $name = $_POST['name'];
    $contactNumber = $_POST['contactNumber'];
    $unit = $_POST['unit'];
    $street = $_POST['street'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $_SESSION['comment'] = $_POST['comment'];

    // Fetch existing address from the database
    $id = $_SESSION['uid'];
    $addressQuery = "SELECT * FROM address WHERE customer_id = ?";
    $addressStmt = $conn->prepare($addressQuery);
    $addressStmt->bind_param("i", $id);
    $addressStmt->execute();
    $result = $addressStmt->get_result();
    $existingAddress = $result->fetch_assoc();

    // Check if there are changes
    if (
        $name !== $_SESSION['customer_name'] ||
        $contactNumber !== $_SESSION['phone'] ||
        $unit !== $existingAddress['unit'] ||
        $street !== $existingAddress['street'] ||
        $postcode !== $existingAddress['postcode'] ||
        $city !== $existingAddress['city'] ||
        $state !== $existingAddress['state']
    ) {
        // Update the database
        $updateUserQuery = "UPDATE users SET full_name = ?, phone_number = ? WHERE id = ?";
        $updateUserStmt = $conn->prepare($updateUserQuery);
        $updateUserStmt->bind_param("ssi", $name, $contactNumber, $id);
        $updateUserStmt->execute();

        $updateAddressQuery = "UPDATE address SET unit = ?, street = ?, postcode = ?, city = ?, state = ? WHERE customer_id = ?";
        $updateAddressStmt = $conn->prepare($updateAddressQuery);
        $updateAddressStmt->bind_param("sssssi", $unit, $street, $postcode, $city, $state, $id);
        $updateAddressStmt->execute();

        if ($updateUserStmt->execute() && $updateAddressStmt->execute()) {
            // Update session variables after successful update
            $_SESSION['customer_name'] = $name;
            $_SESSION['phone'] = $contactNumber;

            header("Location:payment.php");
        } else {
            echo "Error: " . $updateUserStmt->error . " " . $updateAddressStmt->error;
        }
    } else {
        echo "No changes to update.";
        header("Location:payment.php");
    }
}
?>

<!-- The rest of your HTML code remains unchanged -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Information</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/project/biw_project/css/shippingInfo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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


    </header>
    <div class="container px-0 px-md-2 px-lg-5  my-4 w-75">
        <h1 class="text-center pb-4 display-4 ">Shipping Information</h1>

        <form action="#" method="post" class="container shadow-lg border border-dark rounded-3 p-3 p-sm-4 p-md-5">
            <div class="container bg-light p-2 border rounded-4 mb-3 p-3 p-md-4">
                <div class="display-6 pb-1 pb-md-3">Recipient</div>
                <div class="row mx-sm-2 mx-md-3 mx-xl-4 mb-5">
                    <div class="my-1 my-md-2 col-sm-12 col-md-6 col-lg-7 ">
                        <label class="py-1 py-md-2" for="name">Name</label><br>
                        <input type="text" name="name" id="name" class="border rounded-2 px-2 w-100 " value="<?= isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : 'Name' ?>">
                    </div>
                    <div class="my-1 my-md-2 col-sm-12 col-md-6 col-lg-5 ">
                        <label class="py-1 py-md-2" for="contactNumber">Contact Number</label><br>
                        <input type="tel" name="contactNumber" id="contactNumber" class="border rounded-2 px-2 w-100 " value="<?= isset($_SESSION['phone']) ? $_SESSION['phone'] : 'Contact Number' ?>">
                    </div>
                </div>
            </div>


            <div class="container bg-light p-2 border rounded-4 mb-3 p-3 p-md-4">
                <div class="display-6 pb-1 pb-md-3">Address</div>
                <div class="row mx-sm-2 mx-md-3 mx-xl-4 mb-3">
                    <div cla#ss="col-12 col-md-4">
                        <label class="py-1 py-md-2" for="unit">Unit</label><br>
                        <input type="text" name="unit" id="unit" class="border rounded-2 px-2 w-100 " value="<?= isset($_SESSION['unit']) ? $_SESSION['unit'] : 'Unit' ?>">
                    </div>
                    <div class="col-12 col-md-8">
                        <label class="py-1 py-md-2" for="street">Street</label><br>
                        <input type="text" name="street" placeholder="Street" id="street" class="border rounded-2 px-2 w-100 " value="<?= isset($_SESSION['street']) ? $_SESSION['street'] : 'Street' ?>">
                    </div>
                </div>

                <div class="row mx-sm-2 mx-md-3 mx-xl-4 ">
                    <div class="col-12 col-md-4 col-xl-2">
                        <label class="py-1 py-md-2" for="postcode">Postcode</label><br>
                        <input type="text" name="postcode" placeholder="Postcode" id="postcode" class="border rounded-2 px-2 w-100 " value="<?= isset($_SESSION['postcode']) ? $_SESSION['postcode'] : 'Postcode' ?>">
                    </div>
                    <div class="col-12 col-md-4 col-xl-5">
                        <label class="py-1 py-md-2" for="city">City</label><br>
                        <input type="text" name="city" placeholder="City" id="city" class="border rounded-2 px-2 w-100 " value="<?= isset($_SESSION['city']) ? $_SESSION['city'] : 'City' ?>">
                    </div>
                    <div class="col-12 col-md-4 col-xl-5">
                        <label class="py-1 py-md-2" for="state">State</label><br>
                        <input type="text" name="state" placeholder="State" id="state" class="border rounded-2 px-2 w-100  " value="<?= isset($_SESSION['state']) ? $_SESSION['state'] : 'State' ?>">
                    </div>
                </div>

            </div>

            <div class="container bg-light p-2 border rounded-4 mb-3 p-3 p-md-4 ">
                <div class="display-6 pb-1 pb-md-3">Comment</div>
                <div class="row mx-sm-2 mx-md-3 mx-xl-4 mb-3">
                    <div class="col-12 col-md-8">
                        <label class="py-1 py-md-2" for="comment">Your Comment</label><br>
                        <textarea name="comment" id="comment" class="border rounded-2 px-2 w-100 h-75 "></textarea>
                    </div>
                </div>

            </div>

            <div class="text-end">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary ">
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