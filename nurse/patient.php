<?php
session_start();
include "../includes/connect.php";
include "../includes/classes.php";

$object = new nurse_patient($connect);

if (isset($_SESSION["nurse_id"])) {
    $user_id = $_SESSION["nurse_id"];
    $object->collectUserDetail($user_id);

    // If Nurse add a patient (i.e cicks on "submit" button)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $object->collectInputs();
        if (!$object->checkIfEmailExist()) {
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

    <title>QMS - Add new Patient</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="../Bootstrap/bootstrap.css" />

    <!-- font awesome style -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/custom.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="../css/responsive.css" rel="stylesheet" />
</head>

<body>
    <div class="hero_area" style="background-color: #222831">
        <header class="header_section">
            <div class="container">
                <nav class="navbar navbar-expand justify-content-between text-white custom_nav-container">
                    <a class="navbar-brand" href="./dashboard.php">
                        <span> QMS </span>
                    </a>

                    <div class="d-none d-md-flex gap-5 px-5" id="modified_navigation_section">
                        <a href="./dashboard.php" class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Dashboard
                        </a>

                        <a href="./patient.php" class="d-flex flex-column justify-content-center align-items-center active">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            Patient
                        </a>

                        <a href="./consultation.php" class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fa fa-stethoscope" aria-hidden="true"></i>
                            Consultation
                        </a>
                    </div>

                    <!-- Hamburger Start -->
                    <div class="d-md-none position-relative" id="hamburger">
                        <div></div>
                        <div></div>
                        <div></div>
                        <ul class="position-absolute p-3" id="hamburger-dropdown">
                            <li><a href="./dashboard.php">Dashboard</a></li>
                            <li><a href="./patient.php">Patient</a></li>
                            <li><a href="./consultation.php">Consultation</a></li>
                            <li><a href="./logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <!-- Hamburger End -->

                    <div class="d-none d-md-block nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-sm-inline-flex">
                                <?php echo $object->user_email; ?>
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

            <div class="container w-100">
                <div class="d-flex justify-content-end">
                    <button class="btn text-white mb-3" data-bs-toggle="modal" data-bs-target="#add-patient" title="Add new patient" style="background-color: #00c896;">+ Add Patient</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Patient Name</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Date of Birth</th>
                                <th>Home address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $object->selectPatients();
                            $number = 1;
                            while ($result = $sql->fetch_assoc()) {
                                $patient_fullname = $result["patient_fullname"];
                                $patient_email = $result["patient_email"];
                                $patient_phone_no = $result["patient_phone_no"];
                                $patient_dob = $result["patient_dob"];
                                $patient_address = $result["patient_address"];
                                $patient_gender = $result["patient_gender"];

                                echo '
                                    <tr>
                                        <td>' . $number . '</td>
                                        <td>' . $patient_fullname . '</td>
                                        <td>' . $patient_gender . '</td>
                                        <td>' . $patient_email . '</td>
                                        <td>' . $patient_phone_no . '</td>
                                        <td>' . $patient_dob . '</td>
                                        <td>' . $patient_address . '</td>
                                    </tr>
                                ';
                                $number++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Patient Modal Start -->
            <div class="modal fade" id="add-patient">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add New Patient</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="fullname" id="title" placeholder="Enter fullname" required>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" name="email" id="author" placeholder="Ex: example@gmail.com" required>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" name="phone_number" placeholder="Ex: 08012345678" required>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="date" class="form-control" name="dob" id="author" placeholder="Ex: example@gmail.com" required>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="address" id="title" placeholder="Enter address" required>
                                </div>

                                <div class="form-group mb-3">
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">-- Select gender --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Add Patient Modal End -->

        </div>
    </div>

    <!-- Inner section End -->


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