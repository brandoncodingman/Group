<?php
// actions/logout.php - Dedicated logout handler

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Delete session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session (this clears all session data)
session_destroy();

// Redirect to login page (go up one directory since we're in /actions/)
header('Location: ../login_register.php');
exit();
?>