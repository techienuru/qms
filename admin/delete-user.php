<?php
session_start();
include "../includes/connect.php";
include "../includes/classes.php";

$object = new users($connect);

if (isset($_SESSION["admin_id"])) {
    $admin_id = $_SESSION["admin_id"];
    $object->collectUserDetail($admin_id);

    // If a user_id is passed
    $object->processDeleteUser();
} else {
    $object->redirectToLogin();
}
