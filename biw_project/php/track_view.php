<?php
// track-view.php

// Include your database connection
require_once "database.php";

// Start or resume the session
session_start();

// Get data from the request
$requestData = json_decode(file_get_contents('php://input'), true);

// Validate data
if (isset($requestData['page'])) {
    $page = mysqli_real_escape_string($conn, $requestData['page']);

    // Check if the page view has already been tracked in this session
    if (!isset($_SESSION['page_views'][$page])) {
        // If not tracked, track the view, set a session variable to mark it as tracked, and insert into the database
        $_SESSION['page_views'][$page] = true;

        // Insert data into the database (you may need to create a table for this purpose)
        $insertQuery = "INSERT INTO page_views (page, view_date) VALUES ('$page', NOW())";
        mysqli_query($conn, $insertQuery);
    }

    // Return the count of daily views for the current page
    $countQuery = "SELECT COUNT(*) AS daily_views FROM page_views WHERE page = '$page' AND DATE(view_date) = CURDATE()";
    $countResult = mysqli_query($conn, $countQuery);
    $count = mysqli_fetch_assoc($countResult)['daily_views'];

    echo json_encode(['daily_views' => $count]);
} else {
    // If 'page' key is not present in the request data, return an error response
    http_response_code(400);
    echo json_encode(['error' => 'Missing page key in the request']);
}
