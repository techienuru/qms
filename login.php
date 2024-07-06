<?php
session_start();
include_once 'includes/connect.php';
include_once 'includes/classes.php';

// Create login object
$login_object = new login($connect);

if (isset($_POST["submit"])) {
    $login_object->collectUserInputs();

    // If email is correct, the function returns the hashed password
    $isEmailCorrect = $login_object->checkAdminEmail();
    $isPasswordCorrect = $login_object->checkAdminPassword($isEmailCorrect);

    if ($isEmailCorrect && $isPasswordCorrect) {
        $login_object->redirection();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>QMS - Login with your credentials</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.png" type="" />

    <!-- Font awesome Link -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./Bootstrap/bootstrap.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="./css/login.css" rel="stylesheet">
    <style>
        .success-message {
            z-index: 999;
            background-color: black;
        }
    </style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row 100vh align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="rounded p-4 p-sm-5 my-4 mx-3" id="inner-container">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <a href="./" class="text-decoration-none">
                                    <h3></i>QMS</h3>
                                </a>
                                <h3 class="text-white">LOGIN</h3>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control text-white" id="floatingInput" name="email" placeholder="name@example.com" required>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control text-white" id="floatingPassword" name="password" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <button type="submit" name="submit" class="btn py-3 w-100 mb-4">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/mine.js"></script>

</body>

</html>