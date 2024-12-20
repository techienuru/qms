<?php
session_start();
include "../includes/connect.php";
include "../includes/classes.php";

$object = new dashboard($connect);

if (isset($_SESSION["admin_id"])) {
  $admin_id = $_SESSION["admin_id"];
  $object->collectUserDetail($admin_id);
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
      <div class="container mt-5">
        <div class="row">
          <div class="col-md-6">
            <div class="card mb-3 p-3 p-3">
              <div class="card-body">
                <h5 class="card-title"> Total Doctors</h5>
                <p class="card-text">
                  <?php
                  $object->calcNoOfDoctors();
                  echo $object->noOfDoctors;
                  ?>
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card mb-3 p-3 p-3">
              <div class="card-body">
                <h5 class="card-title"> Total Nurses</h5>
                <p class="card-text">
                  <?php
                  $object->calcNoOfNurses();
                  echo $object->noOfNurses;
                  ?>
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card mb-3 p-3 p-3">
              <div class="card-body">
                <h5 class="card-title"> Authorized Users</h5>
                <p class="card-text">
                  <?php
                  $object->calcNoOfAuthorizedUsers();
                  echo $object->noOfAuthorizedUsers;
                  ?>
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card mb-3 p-3 p-3">
              <div class="card-body">
                <h5 class="card-title"> Patients In Queue</h5>
                <p class="card-text">
                  <?php
                  $object->calcNoOfPatientInQueue();
                  echo $object->noOfPatientInQueue;
                  ?>
                </p>
              </div>
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
        <a href="./dashboard.php" class="d-flex flex-column justify-content-center align-items-center active">
          <i class="fa fa-home" aria-hidden="true"></i>
          Dashboard
        </a>

        <a href="./add-doctor.php" class="d-flex flex-column justify-content-center align-items-center">
          <i class="fa fa-user" aria-hidden="true"></i>
          Add Doctor
        </a>

        <a href="./add-nurse.php" class="d-flex flex-column justify-content-center align-items-center">
          <i class="fa fa-stethoscope" aria-hidden="true"></i>
          Add Nurse
        </a>

        <a href="./users.php" class="d-flex flex-column justify-content-center align-items-center">
          <i class="fa fa-stethoscope" aria-hidden="true"></i>
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