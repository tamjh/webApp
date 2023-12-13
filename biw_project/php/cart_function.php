<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "database.php";

// Initialize the cart session variable if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['book_id'];
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
            'productid' => $productId,
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

if (isset($_POST['payment'])) {
    $orderNumber = 'ORD' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
    $customerId = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;

    // Calculate the total grand total
    $final = 0;

    foreach ($_SESSION['cart'] as $cartItem) {
        $final += $cartItem['productquantity'] * $cartItem['productprice'];
    }

    // Insert the order into the orders table with the correct grand total
    $insertOrderQuery = "INSERT INTO orders (order_number, customer_id, grand_total, created) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertOrderQuery);
    $stmt->bind_param("sdd", $orderNumber, $customerId, $final);
    $stmt->execute();
    $stmt->close();

    // Get the generated order ID
    $orderId = $conn->insert_id;

    // Insert items into the order_items table with the obtained order ID
    foreach ($_SESSION['cart'] as $cartItem) {
        $insertItemQuery = "INSERT INTO order_items (order_id, order_number, product_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertItemQuery);
        $stmt->bind_param("dsdsdd", $orderId, $orderNumber, $cartItem['productid'], $cartItem['productname'], $cartItem['productprice'], $cartItem['productquantity']);
        $stmt->execute();
        $stmt->close();
    }

    // Clear the cart after successful checkout
    $_SESSION['cart'] = array();

    header("location:success.php");
}
