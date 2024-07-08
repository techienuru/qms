<?php
session_start();
include "../includes/connect.php";
include "../includes/classes.php";

$object = new doctor_consultations($connect);

if (isset($_SESSION["doctor_id"])) {
    $user_id = $_SESSION["doctor_id"];
    $object->collectUserDetail($user_id);

    // If the consultation is done (i.e if the doctor clicks "done" button)
    if (isset($_GET["queue_id"])) {
        $object->markPatientAsDone();
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
        .personal-card {
            max-width: 800px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .personal-card .card-body {
            padding: 20px;
        }

        .personal-card .card-title {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .info-row h6 {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
        }

        .info-row p {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
            /* to make the name bold */
        }

        .truncated {
            max-width: 180px;
            /* Adjust the max-width as needed */
            overflow: hidden;
            /* text-overflow: ellipsis; */
            white-space: wrap;
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

                    <div class="d-none d-md-flex gap-5 px-5" id="modified_navigation_section">
                        <a href="./dashboard.php" class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Dashboard
                        </a>

                        <a href="./queue.php" class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            Queue
                        </a>

                        <a href="./consultations.php" class="d-flex flex-column justify-content-center align-items-center active">
                            <i class="fa fa-stethoscope" aria-hidden="true"></i>
                            Consultations
                        </a>
                    </div>

                    <!-- Hamburger Start -->
                    <div class="d-md-none position-relative" id="hamburger">
                        <div></div>
                        <div></div>
                        <div></div>
                        <ul class="position-absolute p-3" id="hamburger-dropdown">
                            <li><a href="./dashboard.php">Dashboard</a></li>
                            <li><a href="./queue.php">Queue</a></li>
                            <li><a href="./consultations.php">Consultations</a></li>
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

            <div class="container w-100 mb-5">
                <h3 class="text-center mb-3">The Patient you called</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Queue Id</th>
                                <th>Patient Name</th>
                                <th>Reason for visit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $object->selectQueue();
                            $number = 1;
                            while ($result = $sql->fetch_assoc()) {
                                $queue_id = $result["queue_id"];
                                $patient_fullname = $result["patient_fullname"];
                                $reason = $result["reason"];
                                echo '
                                    <tr>
                                        <td>' . $number . '</td>
                                        <td>' . $queue_id . '</td>
                                        <td>' . $patient_fullname . '</td>
                                        <td>' . $reason . '</td>
                                        <td>
                                            <a href="consultations.php?queue_id=' . $queue_id . '" class="btn text-white js-call-patient" title="Mark Patient as done" style="background-color:#00c896;">Done</a>
                                        </td>
                                    </tr>  
                                ';
                                $number++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container w-100">
                <h3 class="text-center mb-3">Previous Consultations</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Queue Id</th>
                                <th>Patient Name</th>
                                <th>Reason for visit</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $object->selectConsultations();
                            $number = 1;
                            while ($result = $sql->fetch_assoc()) {
                                $queue_id = $result["queue_id"];
                                $patient_fullname = $result["patient_fullname"];
                                $reason = $result["reason"];
                                $status = $result["status"];
                                $date_time = $result["date_time"];
                                echo '
                                    <tr>
                                        <td>' . $number . '</td>
                                        <td>' . $queue_id . '</td>
                                        <td>' . $patient_fullname . '</td>
                                        <td>' . $reason . '</td>
                                        <td>' . $status . '</td>
                                        <td>' . $date_time . '</td>
                                    </tr>  
                                ';
                                $number++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


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