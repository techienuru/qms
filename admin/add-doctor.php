<?php
session_start();
include "../includes/connect.php";
include "../includes/classes.php";

$object = new add_doctor($connect);

if (isset($_SESSION["admin_id"])) {
    $admin_id = $_SESSION["admin_id"];
    $object->collectUserDetail($admin_id);

    // If the admin adds a new Doctor (i.e clicks on "add Doctor" button)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $object->collectUserInputs();
        if (!$object->checkIfEmailExist()) {
            $object->hashPassword();
            $object->insertIntoDB();
        }
    }
} else {
    $object->redirectToLogin();
}

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="../images/favicon.png" type="" />

    <title>QMS - Nurse Dashboard</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="../Bootstrap/bootstrap.css" />

    <!-- font awesome style -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/custom.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="../css/responsive.css" rel="stylesheet" />

    <style>
        #inner-container {
            margin-top: 50px;
            max-width: 600px;
        }

        .card {
            border: 1px solid rgba(128, 128, 128, 0.445);
            border-radius: 10px;
        }

        .card-header {
            background-color: #518071;
            color: #fff;
            font-size: 1.5em;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
        }

        .form-group label {
            color: #518071;
        }

        .form-control {
            border: 1px solid #b4acacab;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #00c896;
            border-color: #00c896;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #518071;
            border-color: #518071;
        }
    </style>
</head>

<body>
    <div class="hero_area" style="background-color: #222831">
        <header class="header_section">
            <div class="container">
                <nav class="navbar navbar-expand justify-content-between text-white custom_nav-container">
                    <a class="navbar-brand" href="./dashboard.php">
                        <span> QMS </span>
                    </a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-sm-inline-flex">
                                <?php echo $object->admin_email; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
    </div>

    <!-- Inner section Start -->
    <div class="container-fluid pt-4 px-4 mb-5" id="inner-section">
        <div class="text-center rounded p-4">

            <div class="container" id="inner-container">
                <div id="add-book" class="book-section">
                    <div class="card">
                        <div class="card-header">
                            Add a new Doctor
                        </div>
                        <div class="card-body">
                            <!-- Form for adding new book -->
                            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="firstname" class="float-start">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="lastname" class="float-start">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="othername" class="float-start">Other Name</label>
                                    <input type="text" class="form-control" id="othername" name="othername" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email" class="float-start">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="float-start">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="specialization" class="float-start">Select Specialization</label>
                                    <select class="form-control" id="specialization" name="specialization" required>
                                        <option value="">-- Select specialization --</option>
                                        <option value="ENT">ENT</option>
                                        <option value="Surgeon">Surgeon</option>
                                        <option value="Physical Medicine and Rehabilitation">Physical Medicine and Rehabilitation</option>
                                        <option value="Veterinary">Veterinary</option>
                                        <option value="Pharmacist">Pharmacist</option>
                                        <option value="Lab Technician">Lab Technician</option>
                                    </select>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary w-100">Add Doctor</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Inner section End -->

    <!-- footer section -->
    <footer class="navigation_section">
        <div class="container">
            <div class="d-flex justify-content-between px-0 px-sm-5">
                <a href="./dashboard.php" class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Dashboard
                </a>

                <a href="./add-doctor.php" class="d-flex flex-column justify-content-center align-items-center active">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    Add Doctor
                </a>

                <a href="./add-nurse.php" class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    Add Nurse
                </a>

                <a href="./users.php" class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Users
                </a>
            </div>
        </div>
    </footer>
    <!-- footer section -->

    <!-- jQery -->
    <script src="../js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- bootstrap js -->
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
    <!-- custom js -->
    <script src="../js/custom.js"></script>
</body>

</html>