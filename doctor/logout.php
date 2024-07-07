<?php
session_start();

if (isset($_SESSION["doctor_id"])) {
    session_unset();
    session_destroy();
    header("location:../login.php");
}
