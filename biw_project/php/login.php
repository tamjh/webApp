<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik Bubbles">
    <link rel="stylesheet" type="text/css" href="/project/biw_project/css/style.css">

</head>

<body>

    <?php
    session_start();

    if (isset($_SESSION["user"])) {
        header("Location: homepage.php");
        exit();
    }

    $error = [];

    if (isset($_POST["login"])) {
        $uemail = htmlspecialchars($_POST["uemail"]);
        $upassword = $_POST["upassword"];
        require_once "database.php";

        $sql = "SELECT id, full_name, email, phone_number, usertype, password FROM users WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uemail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $user = mysqli_fetch_assoc($result);

            if ($user) {
                if (password_verify($upassword, $user["password"])) {
                    $_SESSION["user"] = true;
                    $_SESSION["usertype"] = $user["usertype"];
                    $_SESSION['customer_name'] = $user['full_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['phone'] = $user['phone_number'];

                    $addressSql = "SELECT * FROM address WHERE customer_id = ?";
                    $addressStmt = mysqli_prepare($conn, $addressSql);
                    mysqli_stmt_bind_param($addressStmt, "i", $_SESSION['uid']);
                    mysqli_stmt_execute($addressStmt);
                    $addressResult = mysqli_stmt_get_result($addressStmt);

                    if ($addressResult) {
                        $address = mysqli_fetch_assoc($addressResult);

                        // Store address information in the session
                        if ($address) {
                            $_SESSION['unit'] = $address['unit'];
                            $_SESSION['street'] = $address['street'];
                            $_SESSION['postcode'] = $address['postcode'];
                            $_SESSION['city'] = $address['city'];
                            $_SESSION['state'] = $address['state'];
                        }
                    }

                    if ($user["usertype"] === "admin") {
                        $_SESSION['uid'] = $user['id'];
                        header("Location: admin_dashboard.php");
                    } else {
                        $_SESSION['uid'] = $user['id'];
                        header("Location: homepage.php");
                    }
                    exit();
                } else {
                    $error[] = "Password not match";
                }
            } else {
                $error[] = "User does not exist";
            }
        } else {
            $error[] = "Query failed";
        }
    }
    ?>

    <form action="" method="post">
        <div class="hello-box">
            <p>Welcome to Inspirasi Sejahtera Bookstore</p>
        </div>
        <h2>Login</h2>

        <?php
        if (count($error) > 0) {
            foreach ($error as $err) {
                echo "<div class='alert alert-danger'>$err</div>";
            }
        }
        ?>


        <input type="text" class="form-control" name="uemail" placeholder="Enter email">


        <div class="input-container">
            <input type="password" class="form-control" name="upassword" placeholder="Enter password">
            <img src="/project/biw_project/image/icon/eye_closed.png" id="eye-icon" alt="Toggle Password Visibility" title="Toggle Password Visibility">
        </div>

          
          <input type="submit" name="login" class="btn2" value="Login">
        



        <br><br>
        <div class="register-link">
                <img src="/project/biw_project/image/icon/register.png" alt="Register Icon">
                <a href="register.php" class="connect_register">Haven't registered?</a>
            </div>
    </form>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        const passwordField = document.querySelector('input[name="upassword"]');
        const eyeIcon = document.getElementById('eye-icon');

        eyeIcon.addEventListener('click', function() {
            let jenis = passwordField.getAttribute('type');
            if (passwordField.getAttribute('type') === 'password') {
                passwordField.setAttribute('type', 'text');
                eyeIcon.src = '/project/biw_project/image/icon/eye_open.png'; // Change to your open-eye image
            } else {
                passwordField.setAttribute('type', 'password');
                eyeIcon.src = '/project/biw_project/image/icon/eye_closed.png'; // Change to your closed-eye image
            }
        });
    </script>

</body>

</html>