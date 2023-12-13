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
</head>

<body>
<header>
        <a href="#" class="logo">Inspirasi<span>.</span></a>

        <nav class="navbar">
            <a href="homepage.html">home</a>
            <a href="about us.html">about us</a>
            <a href="ProductPage.html">products</a>
            <a href="contact website.html">contact</a>
            <a href="Billing.html">order form</a>
        </nav>

        <div class="icons">
            <a href="#" class="fas fa-search"></a>
            <a href="#" class="fas fa-cart-plus"></a>
            <div class="dropdown">
                <a href="#" class="fas fa-user" onclick="myFunction()"></a>
                <div id="myDropdown" class="menu">
                    <div class="account_box">
                        <p>Username: <span><?= $_SESSION['customer_name']; ?></span></p>
                    </div>
                    <p>account</p>
                    <form method="post">
                        <button type="submit" name="logout" class="logout">Logout</button>
                    </form>

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