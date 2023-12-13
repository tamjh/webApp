<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: login.php");
    exit();
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

//connect others php file
require_once "database.php";
require_once "books_function.php";
require_once "update_info.php";

//call function for books_function.php
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
    <link rel="stylesheet" href="/project/biw_project/css/inventory_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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



    <h4>Inventory Management</h4>
    <table>
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
            ?>
                <tr>
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
                            <button class="btn btn-edit" onclick="pop_up_edit(<?= $book['id'] ?>)">edit</button>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                <input type="submit" name="delete" class="btn btn-delete" value="delete">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <button type="button" class="btn btn-new" onclick="new_book()">Add new book</button>

    <!--    ******************************************************************************************************************* -->
    <!-- Pop up form for edit -->
    <?php
    foreach ($books as $book) {
    ?>
        <form action="#" method="post">
            <div class="popup" id="popup<?= $book['id'] ?>">
                <div class="a">
                    <input type="hidden" name="edit_id" id="edit_id<?= $book['id'] ?>" value="<?= $book['id'] ?>">
                    <h4>Book stock</h4>
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
                <input type="number" name="price">
                <label for="inventory">Inventory: </label>
                <input type="number" name="inventory">
                <button type="submit" name="submit_new" class="btn">Submit</button>
                <button type="button" class="btn" onclick="closed_popup_new()">Cancel</button>
            </div>
        </div>
    </form>

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
        }

        function new_book() {
            console.log("yes");
            document.querySelector(".popup_new").style.display = "flex";
        }

        function closed_popup_new() {
            document.querySelector(".popup_new").style.display = "none";
        }
    </script>
</body>

</html>