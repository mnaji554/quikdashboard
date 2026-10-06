<?php
// Define base URL for assets using absolute paths from web root
$css = '/company/assets/css/';
$js = '/company/assets/js/';

function checkLogin() {
    session_start();
    if (!isset($_SESSION['login_user'])) {
        header("Location: /company/login.php");
        exit();
    }
}

// Exclude these pages from session check
$public_pages = array('login.php');

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// If not a public page, check for login
if (!in_array($current_page, $public_pages)) {
    checkLogin();
}
?>