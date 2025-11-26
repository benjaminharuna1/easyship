<?php
// Core initialization file

// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../functions.php';

// Fetch settings from the database
$settings_stmt = mysqli_prepare($con, "SELECT * FROM setting WHERE id = 1");
mysqli_stmt_execute($settings_stmt);
$settings_result = mysqli_stmt_get_result($settings_stmt);
$settings = mysqli_fetch_assoc($settings_result);

// Check if the site is in maintenance mode
if ($settings['maintenance_mode'] == 1) {
    // Determine if the current page is part of the admin panel
    $isAdminPage = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;

    // Check if the user is a logged-in admin
    $isAdmin = isset($_SESSION['ADMIN_LOGIN']);

    // If maintenance mode is on, and the user is not an admin, and they are not on an admin page, redirect them.
    if (!$isAdmin && !$isAdminPage) {
        // Prevent redirect loop if already on maintenance page
        if (basename($_SERVER['PHP_SELF']) != 'maintenance.php') {
            header('Location: /maintenance.php');
            exit();
        }
    }
}
