<?php

require "../dbh.inc.php";
session_start(); // Start the session before accessing session variables

$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];


// Check if unique_id is set in session
if (!isset($_SESSION['unique_id'])) {
    echo "Unique ID is not set in the session.<br>";
    exit();
}

$unique_id = $_SESSION['unique_id']; // Get unique_id from the session

// Prepare the query for updating latitude and longitude
$query = "UPDATE users SET latitude = :latitude, longitude = :longitude WHERE unique_id = :unique_id";
$stmt = $pdo->prepare($query);

// Bind parameters
$stmt->bindParam(':unique_id', $unique_id);
$stmt->bindParam(':longitude', $longitude);
$stmt->bindParam(':latitude', $latitude);

try {
    $stmt->execute();
    if ($stmt) {
        echo "Succ";
    } else {
        echo "fail";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Display error message
}
?>
