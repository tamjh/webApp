<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['customer_name'])) {
  $_SESSION['customer_name'] = "user";
}


if (isset($_POST['logout'])) {
  // Unset and destroy the session
  session_unset();
  session_destroy();

  // Redirect to the login page after logout
  header("Location: login.php");
  exit(); // Make sure to exit after a header redirect
}

require_once "database.php";



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=ZCOOL+QingKe+HuangYou&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Diphylleia&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="/project/biw_project/css/about_us.css">


  <title>About Us</title>

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
                        <a class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about_us.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                </ul>

                <div class="icons" style="text-decoration: none; font-size: 2.5rem; display: flex;">
                    <a href="cart.php" class="fas fa-cart-plus" style="text-decoration: none;">
                        <span id="cartItemCount" class="cart-item-count">(<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0' ?>)</span>
                    </a>
                    <div class="dropdown">
                        <a href="#" class="fas fa-user" onclick="myFunction()" style="text-decoration: none;"></a>
                        <div id="myDropdown" class="menu" style="padding: 20px; font-size: 1rem;">
                            <p onclick="redirectToAccount()" style="font-size:2rem;">Account</p>
                            <form method="post">
                                <?php
                                if ($_SESSION['customer_name'] == "user") {
                                    $_SESSION['usertype'] = "customer";
                                    echo "<button type='submit' name='logout' class='logout'><i class='fa-solid fa-right-to-bracket'></i>Login</button>";
                                } else {
                                    echo "<button type='submit' name='logout' class='logout'>
                
                Logout
            </button>";
                                }
                                ?>
                            </form>


                        </div>
                    </div>
                </div>
                <div class="account_box" style="padding: 10px; font-size:2rem;">
                    <?php
                    if ($_SESSION['usertype'] == "admin") {
                        echo "<a href='admin_dashboard.php' style='text-decoration:none;'><p style='color:white;'>Back To Dashboard</p></a>";
                    } else if ($_SESSION['usertype'] == "customer") {
                        echo "<p>Hello, <span>{$_SESSION['customer_name']}</span></p>";
                    }
                    ?>
                </div>

            </div>
        </div>
    </header>

  <div class="intro-text">
    <h1 class="title">ABOUT US</h1>
  </div>

  <section>

    <div class="contact-box">
      <h2>Contact:</h2><br>
      
      <p><img src="/project/biw_project/image/icon/phone.png" style="width:30px; height:30px; margin-right:5px;"></span>Phone:<span> 07-688 3363</p>

      <br><br>
      <i class="fa-solid fa-envelope" style="font-size:30px;"></i>
      <h2>Email:</h2>
      <a href="mailto:inspirasi@gmail.com">
        <p style="color:black;">inspirasi@gmail.com</p>
      </a>

      <div class="visi">
        <br>
        <h2>VISION</h2>
        <p>Menjadi Asas yang kukuh di dalam dunia perniagaan untuk generasi keluarga yang akan datang</p>
        <br>
        <h2>MISION</h2>
        <P>Menyediakan bantuan dan infrastruktur yang sewajarnya kepada lapisan perwaris agar perniagaan yang sedia ada dapat berkembang dengan lebih pesat</P>

      </div>
    </div>

    <div class="address-box">
      <img src="/project/biw_project/image/icon/location.png" style="width:30px; height:30px;"></span>
      <h2>Address:</h2>
      <p>55 & 56, Aras Bawah, Bangunan Baitulmal, Jalan Delima, Pusat Perdagangan Pontian, Pontian, 82000, Pontian, Johor, 82000</p>
      <h2>Location:</h2>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.4903956892713!2d103.38874387581622!3d1.4782906611477762!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d0a29dc1aa78fd%3A0xaeb693ae1b909655!2sKedai%20Buku%20%26%20Alat%20Tulis%20Inspirasi!5e0!3m2!1sen!2smy!4v1702446068375!5m2!1sen!2smy" width="550" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      <a href="https://www.google.com/maps/place/1.47827,103.39129" target="_blank" rel="noreferrer nofollow">View on Google Map</a>
    </div>

    </div>
  </section>

  <footer>
    <div class="container-fluid ft px-5 py-2">
      <div class="row p-5 g-4 h2">
        <div class="col-sm-12 col-md-4 col-lg-3">
          <div class="pb-2 h2">Contact Number</div>
          <div class="row px-3">
            <div class="col-1 px-0 bi-telephone w-auto "></div>
            <div class="col-11 h3">07-6883363</div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-3">
          <div class="pb-2">Email</div>
          <div class="row px-3">
            <div class="col-1 px-0 bi-envelope w-auto "></div>
            <div class="col-11 h3">inspirasi@gmail.com</div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-6">
          <div class="pb-2">Address</div>
          <div class="row px-3">
            <div class="col-1 px-0 bi-geo-alt w-auto"></div>
            <div class="col-11 h3">55 & 56, Aras Bawah, Bangunan Baitulmal, Jalan Delima, Pusat Perdagangan Pontian, 82000, Pontian, Johor, Malaysia.</div>
          </div>
        </div>
      </div>

      <div class="row px-5 pb-2">
        <div class="col text-center "><span class="bi-c-circle pe-1"></span>2023 Inspirasi Bookstore. All Rights Reserved</div>
      </div>

    </div>
  </footer>

</body>
<script>
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  function redirectToAccount() {
    // Redirect to cus_acc.php when the "Account" word is clicked
    window.location.href = 'cus_acc.php';
  }
</script>

</html>