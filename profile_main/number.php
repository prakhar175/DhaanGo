<?php

require "../dbh.inc.php"; // Database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST['number'];
    $unique_id = $_SESSION['unique_id'];

    // Check if user exists
    $query1 = "SELECT * FROM users WHERE unique_id = :unique_id";
    $stmt = $pdo->prepare($query1);
    $stmt->bindParam(':unique_id', $unique_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // User found, update the number in the users table
        $query = "UPDATE users SET number = :number WHERE unique_id = :unique_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":unique_id", $unique_id);
        $stmt->bindParam(":number", $number);
        $stmt->execute();

        // Set a session variable to show the alert message
        $_SESSION['message'] = 'Mobile number updated';
    } else {
        // User not found, update the number in business_users table
        $query = "UPDATE business_users SET number = :number WHERE unique_id = :unique_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":unique_id", $unique_id);
        $stmt->bindParam(":number", $number);
        $stmt->execute();

        $_SESSION['message'] = 'Number updated in business users table.';
    }

    // Redirect to the form page to show the alert
    header("Location: login_form.php"); // Change this to your actual form page
    exit();
} else {
    echo "No form submission detected.";
}
