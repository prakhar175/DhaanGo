<?php
require "../dbh.inc.php"; // Include your database connection

// Start the session
session_start();

// Get data from POST request
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$number = $_POST['number'];
$email = $_POST['email'];
$password = $_POST['password'];
$unique_id = rand(100000, 999999);

// Hash the password before storing
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    // Begin a transaction
    $pdo->beginTransaction();

    // Prepare the SQL query for inserting user data into the users table
    $query = "INSERT INTO users (unique_id, fname, lname, number, email, password) VALUES (:unique_id, :fname, :lname, :number, :email, :password)";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(':unique_id', $unique_id);
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':number', $number);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password); // Use hashed password

    // Execute the first insert
    if (!$stmt->execute()) {
        throw new Exception("Error inserting into users table.");
    }

    // Prepare the SQL query for inserting user data into the users_main table
    $query1 = "INSERT INTO users_main (unique_id, fname, lname, number, email, password) VALUES (:unique_id, :fname, :lname, :number, :email, :password)";
    $stmt1 = $pdo->prepare($query1);
    
    $stmt1->bindParam(':unique_id', $unique_id);
    $stmt1->bindParam(':fname', $fname);
    $stmt1->bindParam(':lname', $lname);
    $stmt1->bindParam(':number', $number);
    $stmt1->bindParam(':email', $email);
    $stmt1->bindParam(':password', $hashed_password); // Use hashed password

    // Execute the second insert
    if (!$stmt1->execute()) {
        throw new Exception("Error inserting into users_main table.");
    }

    // Commit the transaction
    $pdo->commit();

    // Set session variable and redirect
    $_SESSION['unique_id'] = $unique_id;
    header("Location: ../"); 
    exit();

} catch (Exception $e) {
    // Roll back the transaction if something failed
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
    exit();
}
?>
