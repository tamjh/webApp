<?php
function get_all_books($conn){
    // SQL query to select all rows from the 'books' table, ordered by id in descending order
    $sql = "SELECT * FROM books ORDER BY id DESC";

    // Prepare the SQL statement for execution
    $stmt = $conn->prepare($sql);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        // If there are rows, fetch all rows as an associative array
        $books = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // If there are no rows, set $books to 0
        $books = 0;
    }

    // Return the result (either an associative array of books or 0)
    return $books;
}


function get_all_categories($conn){
    $sql  = "SELECT * FROM category"; // Fixed table name
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $categories = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $categories = []; // Changed default value to an empty array
    }

    return $categories;
}

function get_all_publisher($conn){
    $sql  = "SELECT * FROM publisher"; 
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $publishers = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $publishers = []; // Changed default value to an empty array
    }

    return $publishers;
}

function get_all_status($conn){
    $sql = "SELECT * FROM status";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $statuses = $result->fetch_all(MYSQLI_ASSOC);
    }else{
        $statuses = [];
    }

    return $statuses;

}

function delete_book($conn) {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id); 
        if ($stmt->execute()) {
            echo '<script>alert("Data deleted");</script>';
            header("Location: product.php");
            exit;
        } else {
            echo '<script>alert("Data not deleted");</script>';
        }
    }
}

function edit_book($conn)
{
    if (isset($_POST['edit'])) {
        $id = $_POST['edit_book_id'];
        $name = $_POST['bookName'];
        $year = $_POST['Year'];
        $description = $_POST['description'];
        $price = $_POST['Price'];
        $promotion = $_POST['promotion'];
        
        $sql = "UPDATE books SET name=?, year=?, description=?, price=?, promotion=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $name, $year, $description, $price, $promotion, $id);

        if ($stmt->execute()) {
            header('Location: product.php');
            exit;
        } else {
            die(mysqli_error($conn));
        }
    }
}

function delete_inventory($conn) {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id); 
        if ($stmt->execute()) {
            echo '<script>alert("Data deleted");</script>';
            header("Location: inventory.php");
            exit;
        } else {
            echo '<script>alert("Data not deleted");</script>';
        }
    }
}

?>


