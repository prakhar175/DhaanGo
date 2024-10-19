<?php
// Include your database connection file
require "dbh.inc.php";

// Check if POST data exists and is not empty
if (isset($_POST['bio']) && isset($_POST['user_id'])) {
    $bio = $_POST['bio'];
    $user_id = $_POST['user_id'];

    // Prepare SQL query to update user's bio
    $query = "UPDATE users_main SET bio=:bio WHERE unique_id=:user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":bio", $bio);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    // Check if update was successful
    if ($stmt->rowCount() > 0) {
        echo json_encode(array("status" => "success"));
        header("Location: ./profile.php?user_id=$user_id");

    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to update bio."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Missing bio or user_id parameter."));
}
?>
