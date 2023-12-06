<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        $uname = htmlspecialchars($_POST["uname"]);
        $upassword = $_POST["upassword"];
        require_once "database.php";

        $sql = "SELECT * FROM users WHERE full_name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user) {
            if (password_verify($upassword, $user["password"])) {
                $_SESSION["user"] = true;
                $_SESSION["usertype"] = $user["usertype"];
                if ($user["usertype"] === "admin") {
                    $_SESSION['uname'] = $user['full_name'];
                    header("Location: admin_dashboard.php");
                } else {
                    $_SESSION['uid'] = $user['id'];
                    $_SESSION['customer_name'] = $user['full_name'];
                    header("Location: homepage.php");
                }
                exit();
            } else {
                $error[] = "Password not match";
            }
        } else {
            $error[] = "User does not exist";
        }
    }
    ?>

    <form action="" method="post">
        <h2>Login</h2>

        <?php
        if (count($error) > 0) {
            foreach ($error as $err) {
                echo "<div class='alert alert-danger'>$err</div>";
            }
        }
        ?>

        <label>User name: </label>
        <input type="text" class="form-control" name="uname" placeholder="Enter name">
        <label>User password: </label>

        <div class="input-container">
            <input type="password" class="form-control" name="upassword" placeholder="Enter password">
            <img src="/project/biw_project/image/icon/eye_closed.png" id="eye-icon" alt="Toggle Password Visibility" title="Toggle Password Visibility">
        </div>

        <input type="submit" name="login" class="btn2" value="Login">
        <br><br>
        <a href="register.php" class="connect_register">Haven't registered?</a>
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