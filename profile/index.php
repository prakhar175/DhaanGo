<?php
// session_start(); // Start session to access session variables
require "../login/login.php";
// Debugging: check if session data exists
if (isset($_SESSION['fname']) && isset($_SESSION['lname']) && isset($_SESSION['email_address'])) {
    echo "<h1>User Profile</h1>";
    echo "<p><strong>First Name:</strong> " . $_SESSION['fname'] . "</p>";
    echo "<p><strong>Last Name:</strong> " . $_SESSION['lname'] . "</p>";
    echo "<p><strong>Email Address:</strong> " . $_SESSION['email_address'] . "</p>";
} else {
    echo "<p>No user information found. Please <a href='../login/login.php'>log in again</a>.</p>";
}
// echo $_GET['code'];