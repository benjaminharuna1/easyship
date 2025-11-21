<?php
session_start();
include '../db.php';
include '../functions.php';

if(!isset($_SESSION['ADMIN_LOGIN'])){
    header('location:login.php');
    die();
}
?>