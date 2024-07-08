<?php
session_start();
include "../includes/connect.php";
include "../includes/classes.php";

$object = new doctor($connect);

if (isset($_SESSION["doctor_id"])) {
  $user_id = $_SESSION["doctor_id"];
  $object->collectUserDetail($user_id);
  $object->setUnattendedToNotattended();
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

  <title>QMS - Welcome Dr. <?php echo $object->lastname; ?> </title>

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

    @media all and (width <=400px) {

      .personal-card .card-body {
        padding: 5px;
      }
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
            <a href="./dashboard.php" class="d-flex flex-column justify-content-center align-items-center active">
              <i class="fa fa-home" aria-hidden="true"></i>
              Dashboard
            </a>

            <a href="./queue.php" class="d-flex flex-column justify-content-center align-items-center">
              <i class="fa fa-user" aria-hidden="true"></i>
              Queue
            </a>

            <a href="./consultations.php" class="d-flex flex-column justify-content-center align-items-center">
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
  <div class="container-fluid pt-4 px-sm-4 mb-5" id="inner-section">
    <div class="text-center rounded p-sm-4">

      <div class="container w-100">
        <div class="card personal-card">
          <div class="card-body w-100">
            <h4 class="card-title mb-4">Personal Information</h4>

            <div class="info-row">
              <h6 class="mb-0">First Name</h6>
              <p class="mb-0 text-truncate"><?php echo $object->firstname; ?></p>
            </div>

            <div class="info-row">
              <h6 class="mb-0">Last Name</h6>
              <p class="mb-0 text-truncate"><?php echo $object->lastname; ?></p>
            </div>

            <div class="info-row">
              <h6 class="mb-0">Other Name</h6>
              <p class="mb-0 text-truncate"><?php echo $object->othername; ?></p>
            </div>

            <div class="info-row">
              <h6 class="mb-0 me-3">Email Address</h6>
              <p class="mb-0 text-sm-truncate"><?php echo $object->user_email; ?></p>
            </div>

            <div class="info-row">
              <h6 class="mb-0 me-3">Specialization</h6>
              <p class="mb-0 text-sm-truncate"><?php echo $object->specialization; ?></p>
            </div>

          </div>
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