<?php

// Start the session to ensure the session functions work
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the homepage or login page after the session is destroyed
header("Location: ../");  // Redirect to the parent directory (login/home page) after logout
exit();  // Ensure no further code is executed
