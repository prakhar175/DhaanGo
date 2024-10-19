<?php

require "../../dbh.inc.php"; // Include your database connection

// Start the session
session_start();

// Get data from POST request
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$number = $_POST['number'];
$email = $_POST['email'];
$password = $_POST['password'];
$unique_id = rand(100000, 999999);

// Prepare the SQL query for inserting user data
$query = "INSERT INTO buisness_users (unique_id, fname, lname, number, email, password) VALUES (:unique_id, :fname, :lname, :number, :email, :password)";
$stmt = $pdo->prepare($query);

$stmt->bindParam(':unique_id', $unique_id);
$stmt->bindParam(':fname', $fname);
$stmt->bindParam(':lname', $lname);
$stmt->bindParam(':number', $number);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password); 

if ($stmt->execute()) {
    
    $_SESSION['unique_id'] = $unique_id;
    header("Location: ../../"); 
    exit();
} else {
    echo "Error: Could not register user. Please try again.";
    exit();
}
?>
