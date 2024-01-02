<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in or is not an admin, redirect to login
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    // Unset and destroy the session
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Include other PHP files
require_once "database.php";
require_once "books_function.php";
require_once "update_info.php";

// Call functions from books_function.php
$books = get_all_books($conn);
if (!is_array($books)) {
    $books = array();
}
$categories = get_all_categories($conn);
$publishers = get_all_publisher($conn);
$delete_function = delete_inventory($conn);
$update_info = update_info($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/project/biw_project/css/inventory_style.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="view_acc.php">Account</a>
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
    <div id="cover" class="cover"></div>



    <h1 class="im">Inventory Management</h1>
    
    <table class="t-search">
        <tr>
            <th>No.</th>
            <th>Book name</th>
            <th>Cover page</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        <tbody>
            <?php
            $i = 0;
            foreach ($books as $book) {
                $i++;
                $rowBackgroundColor = $book['inventory'] == 0 ? 'background-color: pink;' : '';

                // Start a new row with the specified background color
                echo "<tr style='$rowBackgroundColor'>";
            ?>
                <td><?= $i ?></td>
                <td><?= $book['name'] ?></td>
                <td>
                    <img width="100" src="/project/biw_project/image/coverpage/<?= $book['cover'] ?>">
                </td>
                <td>
                    <?= $book['inventory'] ?>
                </td>
                <td>
                    <div class="btn-container">
                        <button class="btn btn-edit" onclick="pop_up_edit(<?= $book['id'] ?>)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">

                            <button type="submit" name="delete" class="btn btn-delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            <?php
                // End the row
                echo "</tr>";
            }
            ?>
        </tbody>

    </table>

    <button class="plus btn" onclick="appear();"><i class="fa-solid fa-plus" style="font-size:2rem;"></i></button>
    <table class="btn-t">
        <tr>
            <td><button type="button" class="btn btn-new" onclick="new_book()">Add book</button></td>
        </tr>
        <tr>
            <td><button type="button" class="btn btn-new" onclick="new_category()">Add category</button></td>
        </tr>
        <tr>
            <td><button type="button" class="btn btn-new" onclick="new_publisher()">Add publisher</button></td>
        </tr>
    </table>


    <!--    ******************************************************************************************************************* -->
    <!-- Pop up form for edit -->
    <?php
    foreach ($books as $book) {
    ?>
        <form action="#" method="post">
            <div class="popup" id="popup<?= $book['id'] ?>">
                <div class="popup_content_new">
                    <input type="hidden" name="edit_id" id="edit_id<?= $book['id'] ?>" value="<?= $book['id'] ?>">
                    <h3>Edit Book Stock</h3>
                    <label for="stock">Stock number:</label>
                    <div class="number-input-container">
                        <input type="number" name="stock" value="<?= $book['inventory'] ?>">
                    </div>
                    <button type="submit" name="edit_stock" class="btn">Submit</button>
                    <button type="button" class="btn" onclick="closed_popup(<?= $book['id'] ?>)">Cancel</button>
                </div>
            </div>
        </form>
    <?php
    }
    ?>
    <!--   ******************************************************************************************************************-->

    <!--    ******************************************************************************************************************* -->
    <!-- Pop up form for new -->
    <form action="new_book.php" method="post" enctype="multipart/form-data">
        <div class="popup_new">
            <div class="popup_content_new">
                <h3>New Book</h3>
                <label for="title">Title:</label>
                <input type="text" name="title"><br>
                <label for="file">Cover Page:</label>
                <input type="file" name="cover"><br>

                <label for="description">Description: </label>
                <textarea name="description" id="" cols="40" rows="5"></textarea>

                <label for="year">Year:</label>
                <input type="text" name="year"><br>
                <label for="category">Category:</label>
                <select name="category">
                    <option value="0">Select category</option>
                    <?php
                    foreach ($categories as $category) {
                    ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['category_name'] ?>
                        </option>
                    <?php } ?>
                </select>
                <label for="publisher">Publisher:</label>
                <select name="publisher">
                    <option value="0">Select publisher</option>
                    <?php
                    foreach ($publishers as $publisher) {
                    ?>
                        <option value="<?= $publisher['id'] ?>">
                            <?= $publisher['publisher_name'] ?>
                        </option>
                    <?php } ?>
                </select>
                <label for="price">Price: RM</label>
                <input type="number" name="price" step="0.01" min="0" max="100000000">
                <label for="inventory">Inventory: </label>
                <input type="number" name="inventory">
                <label for="number" name="promotion">% of discount</label>
                <input type="number" name="promotion">
                <button type="submit" name="submit_new" class="btn">Submit</button>
                <button type="button" class="btn" onclick="closed_popup_new()">Cancel</button>
            </div>
        </div>
    </form>

    <!-- Pop-up form for new category -->
    <form action="new_book.php" method="post">
        <div class="popup_new" id="popup_new_category">
            <div class="popup_content_new">
                <h3>New Category</h3>
                <label for="category_name">Category Name:</label>
                <input type="text" name="category_name" required><br>
                <button type="submit" name="submit_new_category" class="btn">Submit</button>
                <button type="button" class="btn" onclick="closed_popup_new_category()">Cancel</button>
            </div>
        </div>
    </form>

    <!-- Pop-up form for new publisher -->
    <form action="new_book.php" method="post">
        <div class="popup_new" id="popup_new_publisher">
            <div class="popup_content_new">
                <h3>New Publisher</h3>
                <label for="publisher_name">Publisher Name:</label>
                <input type="text" name="publisher_name" required><br>
                <button type="submit" name="submit_new_publisher" class="btn">Submit</button>
                <button type="button" class="btn" onclick="closed_popup_new_publisher()">Cancel</button>
            </div>
        </div>
    </form>
    <a href="#" class="top"><i class="fa-solid fa-arrow-up"></i></a>

    <!--    ******************************************************************************************************************* -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function pop_up_edit(bookID) {
        console.log(bookID);
        document.getElementById("edit_id" + bookID).value = bookID;
        document.getElementById("popup" + bookID).style.display = "flex";
    }

    function closed_popup(bookID) {
        document.getElementById("popup" + bookID).style.display = "none";
        hideBtnT();
    }

    function new_book() {
        document.querySelector(".popup_new").style.display = "flex";
    }

    function closed_popup_new() {
        console.log("Cancel button clicked");
        document.getElementById("cover").style.display = "none";
        document.querySelector(".popup_new").style.display = "none";

        // Hide btn-t
        hideBtnT();
    }

    function new_category() {
        document.getElementById("popup_new_category").style.display = "flex";
    }

    function closed_popup_new_category() {
        document.getElementById("popup_new_category").style.display = "none";
        hideBtnT();
    }

    function new_publisher() {
        document.getElementById("popup_new_publisher").style.display = "flex";
    }

    function closed_popup_new_publisher() {
        document.getElementById("popup_new_publisher").style.display = "none";
        hideBtnT();
    }

    var isBtnVisible = false;

    function appear() {
        let cover = document.getElementById("cover");
        let plus = document.getElementsByClassName("plus")[0];
        let btnT = document.getElementsByClassName("btn-t")[0];

        if (!isBtnVisible) {
            cover.style.display = "block";
            btnT.style.display = "flex";

            isBtnVisible = true;
        } else {
            cover.style.display = "none";
            btnT.style.display = "none";

            isBtnVisible = false;
        }
    }

    function hideBtnT() {
        let cover = document.getElementById("cover");
        let btnT = document.getElementsByClassName("btn-t")[0];

        cover.style.display = "none";
        btnT.style.display = "none";

        isBtnVisible = false;
    }



</script>

</body>

</html>