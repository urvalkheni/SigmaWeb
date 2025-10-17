<?php
/**
 * Assignment 10: PHP Sessions & Cookies - Logout Handler
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * Simple logout script that destroys session and redirects to login
 */

// Start session
session_start();

// Destroy all session data
session_destroy();

// Clear any remember me cookies
if (isset($_COOKIE['remember_email'])) {
    setcookie('remember_email', '', time() - 3600, '/');
}

// Redirect to login page
header('Location: login.php');
exit();
?>
