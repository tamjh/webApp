<?php
session_start();

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
if(!is_array($books)){
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
    <link rel="stylesheet" type="text/css" href="/project/biw_project/css/productstyle.css">
    

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



    <h4>All Books</h4>
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
                <td><?= $i?></td>
                <td><?= $book['name'] ?></td>
                <td>
					<img width="100" src="/project/biw_project/image/coverpage/<?=$book['cover']?>" >
				</td>
                <td><?= $book['description'] ?></td>
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
                    
                        if($publishers ==0 || empty($publishers)){
                            echo "Undefined";
                        }
                        else{
                            $publisherfound = false;
                            foreach ($publishers as $publisher) {
                                if ($publisher['id'] == $book['publisher']) {
                                    echo $publisher['publisher_name'];
                                    $publisherfound = true;
                                    break;
                                }
                            }
                            if(!$publisherfound){
                                echo "Undefined";
                            }
                        }
                    ?>
                </td>
                <td>RM<?= $book['price'] ?></td>
                <td>
                    <div class="btn-container">
                        <button class="btn btn-edit" onclick="pop_up_edit('<?= $book['id'] ?>')">edit</button>
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
                <div class="button-row">
                    <input type="submit" name="edit" class="btn-submit" value="Submit">
                    <button type="button" class="btn-cancel" onclick="close_edit_popup(<?= $book['id'] ?>)">Cancel</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>


</body>

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
