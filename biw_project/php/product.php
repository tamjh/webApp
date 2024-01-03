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
    header("Location: login.php");
    exit();
}

//connect others php file
require_once "database.php";
require_once "books_function.php";

//call function for books_function.php
$books = get_all_books($conn);
if (!is_array($books)) {
    $books = array();
}
$categories = get_all_categories($conn);
$publishers = get_all_publisher($conn);
$delete_function = delete_book($conn);
$edit_function = edit_book($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/project/biw_project/css/productstyle.css">


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
                    <a href="index.php" class="web">
                        <p class="web">View Website</p>
                    </a>
                </div>
            </div>
        </div>
    </header>



    <h4 class="p_title">All Product</h4>

    

    <table class="details">
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Cover Page</th>
            <th>Desription</th>
            <th>Year</th>
            <th>Category</th>
            <th>Publisher</th>
            <th>Price</th>
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
                    <td class="long-name"><?= $book['name'] ?></td>
                    <td>
                        <img width="100" src="/project/biw_project/image/coverpage/<?= $book['cover'] ?>">
                    </td>
                    <td class="long-description"><?= $book['description'] ?></td>
                    <td><?= $book['year'] ?></td>
                    <td>
                        <?php
                        if ($categories == 0 || empty($categories)) {
                            echo "Undefined";
                        } else {
                            $categoryFound = false;
                            foreach ($categories as $category) {
                                if ($category['id'] == $book['category']) {
                                    echo $category['category_name'];
                                    $categoryFound = true;
                                    break;
                                }
                            }
                            if (!$categoryFound) {
                                echo "Undefined";
                            }
                        }
                        ?>
                    <td>
                        <?php

                        if ($publishers == 0 || empty($publishers)) {
                            echo "Undefined";
                        } else {
                            $publisherfound = false;
                            foreach ($publishers as $publisher) {
                                if ($publisher['id'] == $book['publisher']) {
                                    echo $publisher['publisher_name'];
                                    $publisherfound = true;
                                    break;
                                }
                            }
                            if (!$publisherfound) {
                                echo "Undefined";
                            }
                        }
                        ?>
                    </td>
                    <!-- Modify the price display in your PHP loop -->
                    <td>
                        <?php if ($book['promotion'] != 0) : ?>
                            <?php
                            $discountedPrice = $book['price'] - ($book['price'] * ($book['promotion'] / 100));
                            ?>
                            <span class="original-price">
                                RM<?= number_format($book['price'], 2) ?>
                            </span>
                            <br>
                            <span class="discounted-price">
                                RM<?= number_format($discountedPrice, 2) ?>
                            </span>
                        <?php else : ?>
                            RM<?= number_format($book['price'], 2) ?>
                        <?php endif; ?>
                    </td>



                    <td>
                        <div class="btn-container">
                            <button class="btn btn-edit" onclick="pop_up_edit('<?= $book['id'] ?>')">
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


                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>

    <?php foreach ($books as $book) { ?>
        <div class="popup" id="popup<?= $book['id'] ?>">
            <div class="popup_content">
                <h4>Book's information</h4>
                <form action="" method="post">
                    <input type="hidden" name="edit_book_id" value="<?= $book['id'] ?>">
                    <div class="form-row">
                        <label for="BookName">Book Name:</label>
                        <input type="text" name="bookName" value="<?= $book['name'] ?>">
                    </div>
                    <div class="form-row">
                        <label for="Description">Description:</label>
                        <input type="text" name="description" value="<?= $book['description'] ?>">
                    </div>
                    <div class="form-row">
                        <label for="year">Year:</label>
                        <input type="text" name="Year" value="<?= $book['year'] ?>">
                    </div>
                    <div class="form-row">
                        <label for="price">Price:</label>
                        <input type="text" name="Price" value="<?= $book['price'] ?>">
                    </div>
                    <div class="form-row">
                        <label for="promotion">Promotion percentage (%):</label>
                        <input type="number" name="promotion" value="<?= $book['promotion'] ?>">
                    </div>
                    <div class="button-row">
                        <input type="submit" name="edit" class="btn-submit" value="Submit">
                        <button type="button" class="btn-cancel" onclick="close_edit_popup(<?= $book['id'] ?>)">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <a href="#" class="top"><i class="fa-solid fa-arrow-up"></i></a>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function pop_up_edit(bookID) {
        var popup = document.getElementById("popup" + bookID);
        popup.style.display = "flex";

        // Set the value only for the corresponding form
        var editForm = popup.querySelector("form");
        editForm.querySelector("input[name='edit_book_id']").value = bookID;
    }


    function close_edit_popup(bookID) {
        var popup = document.getElementById("popup" + bookID);
        popup.style.display = "none";
    }

   
</script>

</html>