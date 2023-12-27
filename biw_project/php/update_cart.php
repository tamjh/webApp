<?php
// update_cart.php

// Include necessary files
require_once "database.php"; // Make sure to include session_start.php or handle sessions appropriately
require_once "cart_function.php";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get product ID and new quantity from the AJAX request
    $productId = isset($_POST['productId']) ? $_POST['productId'] : null;
    $newQuantity = isset($_POST['newQuantity']) ? $_POST['newQuantity'] : null;

    if ($productId !== null && $newQuantity !== null) {
        // Call the function to update the cart
        updateCartQuantity($productId, $newQuantity);

        // You can optionally send a response back to the client
        echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
    } else {
        // Invalid parameters, send an error response
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
} else {
    // Invalid request method, send an error response
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
