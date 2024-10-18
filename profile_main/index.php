<?php
session_start();
require "../dbh.inc.php"; // Ensure your database connection is correct

error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable error reporting

// Check if session variables are set
if (!isset($_SESSION['fname'], $_SESSION['lname'])) {
    header("Location: ../login.php");
    exit;
}

$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];

// Prepare SQL query
$query = "SELECT * FROM users WHERE fname = :fname AND lname = :lname";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':fname', $fname);
$stmt->bindParam(':lname', $lname);

if ($stmt->execute()) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        // User is found, display welcome message and profile photo
        echo "<div>Welcome " . htmlspecialchars($fname) . " " . htmlspecialchars($lname) . "</div>";
        echo "<div>Email: " . htmlspecialchars($result['email']) . "</div>";
        echo "<img src='" . htmlspecialchars($result['profile_photo']) . "' alt='Profile Photo'>";
    } else {
        // User not found in database
        echo "User not found in the database. Redirecting to the login page in 5 seconds.";
        header("refresh:5;url=../login.php");
        exit;
    }
} else {
    // Handle query execution error
    echo "Error executing query.";
}
?>
