<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="/project/biw_project/css/style.css">
</head>

<body>
    <?php
    session_start(); // Start the PHP session
    $success = false;

    // Check for form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $errors = array(); // Initialize the errors array

        $uname = $_POST["uname"];
        $uemail = $_POST["uemail"];
        $upassword = $_POST["upassword"];
        $repeat_password = $_POST["repeat_password"];
        $contact_number = $_POST["uphone"];

        $passwordHash = password_hash($upassword, PASSWORD_DEFAULT);

        // Validation checks
        if (empty($uname) || empty($uemail) || empty($upassword) || empty($repeat_password) || empty($contact_number)) {
            $errors[] = "All fields are required";
        }

        if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email is not valid";
        }

        if ($upassword !== $repeat_password) {
            $errors[] = "Passwords do not match";
        }

        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = '$uemail'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            $errors[] = "Email already exists";
        }

        if (count($errors) > 0) {
            $_SESSION['error_messages'] = $errors; // Store errors in session
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            require_once "database.php";
            $sql = "INSERT INTO users (full_name, email, password, phone_number) VALUES (?, ?, ?, ?)";
            $stmt  = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $uname, $uemail, $passwordHash, $contact_number);
                mysqli_stmt_execute($stmt);
                $user_id = mysqli_insert_id($conn);  // Get the last inserted user ID
                $_SESSION['uid'] = $user_id;  // Store the user ID in the session
                $success = true;
            } else {
                die("Something went wrong");
            }
        }
    }
    ?>

    <div class="container">
        <form action="" method="post">
            <h2>Register</h2>
            <?php
            if (isset($_SESSION['error_messages'])) {
                $errors = $_SESSION['error_messages'];
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }

                unset($_SESSION['error_messages']); // Clear the error messages
            } elseif ($success == true) {
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
                if ($success) {
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'insert_address.php';
                        }, 3000);
                    </script>";
                }
                unset($success); // Clear the success messages
            }
            ?>

            <div class="form-group">
                <label>User Name:</label>
                <input type="text" class="form-control" name="uname" placeholder="Please enter name">
            </div>
            <div class="form-group">
                <label>User email:</label>
                <input type="text" class="form-control" name="uemail" placeholder="Please enter email">
            </div>
            <div class="form-group">
                <label>Contact Number:</label>
                <input type="text" class="form-control" name="uphone" placeholder="Please enter contact number">
            </div>

            <div class="form-group">
                <label>User password:</label>
                <div class="input-container">
                    <input type="password" class="form-control" name="upassword" placeholder="Enter password">
                    <img src="/project/biw_project/image/icon/eye_closed.png" id="eye-icon" alt="Toggle Password Visibility">
                </div>
            </div>
            <div class="form-group">
                <label>Re-enter password:</label>
                <div class="input-container">
                    <input type="password" class="form-control" name="repeat_password" placeholder="Please enter password again">
                    <img src="/project/biw_project/image/icon/eye_closed.png" id="eye-icon" alt="Toggle Password Visibility">
                </div>
            </div>
            <input type="submit" class="btn1" name="submit" value="Next">
            <br><br><br>
            <a href="login.php" class="connect_login">Already have an account?</a>
        </form>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Function to clear form after successful submission
        function clearForm() {
            document.querySelector("form").reset();
        }

        const passwordField = document.querySelector('input[name="upassword"]');
        const eyeIcon = document.getElementById('eye-icon');

        eyeIcon.addEventListener('click', function () {
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
