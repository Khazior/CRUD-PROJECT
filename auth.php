<?php
// central authentication helper
session_start();

/**
 * Ensure a user is logged in. Redirects to login.php if not.
 */
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Ensure the currently logged in user has the admin role.
 * If not logged in or not admin, sends to media.php (the default page).
 */
function require_admin() {
    require_login();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: media.php");
        exit();
    }
}
