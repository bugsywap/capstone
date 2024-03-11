<?php

session_start();

// Set the session timeout period to 1 hour (3600 seconds)
$sessionTimeout = 900;

// Check if the user is authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Check if the session has expired
    if (isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity']) > $sessionTimeout) {
        // Destroy the session and redirect to the login page
        session_destroy();
        header("Location: login.php");
        exit();
    }

    // Update the last activity time for the session
    $_SESSION['lastActivity'] = time();
} else {
    // Redirect to the login page
    header("Location: login.php");
    exit();

    //add warning that user has been idle for an hour
}