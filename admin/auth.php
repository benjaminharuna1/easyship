<?php
session_start();
// The functions file includes the database connection.
// It should be included before the login check.
include '../functions.php';

// if user is not logged in, redirect to login page
if (!isset($_SESSION['ADMIN_LOGIN'])) {
    header('location:login.php');
    die();
}
?>