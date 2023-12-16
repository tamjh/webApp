<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/project/biw_project/css/insert_address_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Insert Address</title>
</head>

<body>
    <?php
    session_start();
    $success = false; // Initialize $success at the beginning

    if (isset($_POST['register'])) {
        $add_errors = array();
        $unit = $_POST['unit'];
        $street = $_POST['street'];
        $postcode = $_POST['postcode'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        if (empty($unit) || empty($street) || empty($postcode) || empty($city) || empty($state)) {
            $add_errors[] = "All fields are required";
        }

        if (count($add_errors) > 0) {
            $_SESSION['error_messages'] = $add_errors;
        } else {
            require_once "database.php";
            $sql = "INSERT INTO address (customer_id, unit, street, postcode, city, state) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt  = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "dsssss", $_SESSION['uid'], $unit, $street, $postcode, $city, $state);
                mysqli_stmt_execute($stmt);
                $success = true;
            } else {
                die("Something went wrong");
            }
        }
    }
    ?>

    <div class="container-fluid h-100 d-flex align-items-center justify-content-center">
        <form class="container bg-light p-2 border rounded-4 mb-3 p-3 p-md-4" method="post">
            <div class="display-6 pb-1 pb-md-3">Address</div>
            <?php
            if (isset($_SESSION['error_messages'])) {
                $errors = $_SESSION['error_messages'];
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                unset($_SESSION['error_messages']);
            } elseif ($success == true) {
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
                if ($success) {
                    echo "<script>
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 3000);
        </script>";
                }
                unset($success);
            }
            ?>
            <div class="row mx-sm-2 mx-md-3 mx-xl-4 mb-3">
                <div class="col-12 col-md-4">
                    <label class="py-1 py-md-2" for="unit">Unit</label><br>
                    <input type="text" name="unit" placeholder="Unit" id="unit" class="border rounded-2 px-2 w-100">
                </div>
                <div class="col-12 col-md-8">
                    <label class="py-1 py-md-2" for="street">Street</label><br>
                    <input type="text" name="street" placeholder="Street" id="street" class="border rounded-2 px-2 w-100">
                </div>
            </div>

            <div class="row mx-sm-2 mx-md-3 mx-xl-4 ">
                <div class="col-12 col-md-4 col-xl-2">
                    <label class="py-1 py-md-2" for="postcode">Postcode</label><br>
                    <input type="text" name="postcode" placeholder="Postcode" id="postcode" class="border rounded-2 px-2 w-100">
                </div>
                <div class="col-12 col-md-4 col-xl-5">
                    <label class="py-1 py-md-2" for="city">City</label><br>
                    <input type="text" name="city" placeholder="City" id="city" class="border rounded-2 px-2 w-100">
                </div>
                <div class="col-12 col-md-4 col-xl-5">
                    <label class="py-1 py-md-2" for="state">State</label><br>
                    <select name="state" id="state" class="border rounded-2 px-2 w-100">
                        <option value="" selected disabled>Select State</option>
                        <option value="Johor">Johor</option>
                        <option value="Kedah">Kedah</option>
                        <option value="Kelantan">Kelantan</option>
                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                        <option value="Labuan">Labuan</option>
                        <option value="Melaka">Melaka</option>
                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                        <option value="Pahang">Pahang</option>
                        <option value="Penang">Penang</option>
                        <option value="Perak">Perak</option>
                        <option value="Perlis">Perlis</option>
                        <option value="Putrajaya">Putrajaya</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Terengganu">Terengganu</option>
                    </select>

                    </select>
                </div>
            </div>

            <div class="text-end" style="margin-top:50px;">
                <input type="submit" name="register" value="Submit" class="btn btn-primary ">
            </div>
        </form>
    </div>
</body>

</html>