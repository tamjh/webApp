<?php
session_start();

// Initialize the cart session variable if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['add_to_cart'])) {
    $productName = $_POST['Pname'];
    $productPrice = $_POST['Pprice'];
    $quantity = $_POST['quantity'];
    $figure = $_POST['Pimage']; // Assuming this is the product image information

    $check_product = array_column($_SESSION['cart'], 'productname');

    if (in_array($productName, $check_product)) {
        echo "
            <script>
            alert('Product already in cart!');
            window.location.href = 'shop.php';
            </script>";
    } else {
        $_SESSION['cart'][] = array(
            'productname' => $productName,
            'productprice' => $productPrice,
            'productquantity' => $quantity,
            'productimage' => "/project/biw_project/image/coverpage/" . $figure
        );

        header("Location: cart.php");
    }
}

if (isset($_POST['remove'])) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['productname'] === $_POST['item']) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
                header("Location: cart.php");
                exit(); 
            }
        }
    }
}

if (isset($_POST['update'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['productname'] === $_POST['item']) {
            // Update the quantity
            $_SESSION['cart'][$key]['productquantity'] = $_POST['Pquantity'];
            header("Location: cart.php");
            exit();
        }
    }
}

?>
