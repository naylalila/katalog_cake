<?php
// Session configuration
session_start();

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current logged in user
function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}

// Login user
function loginUser($user_id, $user_data) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user'] = $user_data;
}

// Logout user
function logoutUser() {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Redirect if not logged in
function requireLogin() {
    if(!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

// Redirect if logged in
function requireLogout() {
    if(isLoggedIn()) {
        header("Location: landingpage.php");
        exit;
    }
}

?>
