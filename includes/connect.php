<?php
$connect = new mysqli("localhost", "root", "1234567890", "qms");

if (!$connect) {
    die("<b>Error while connecting to database:</b> " . $connect->connect_errno);
}
