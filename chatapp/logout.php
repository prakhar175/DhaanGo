<?php
session_start();
require "dbh.inc.php";

if (isset($_SESSION['unique_id'])) {
    $id = $_GET['user_id'];

    if (isset($id)) {
        // Get current timestamp and modify for logout time
        $logout_time = time();
        $logout_time_mod = date("Y-m-d H:i:s", $logout_time); // Format suitable for MySQL datetime
        $date = new DateTime();
        $hoursadd = 3;
        $minutesadd = 30;
        $date->modify("+$hoursadd hours +$minutesadd minutes");
        $formattedDate = $date->format('Y-m-d H:i:s'); // Format suitable for MySQL datetime

        $status = "Offline now";

        // Update the user status and logout time in the database
        $query = "UPDATE users_main SET status = :status, logout_time = :logout_time WHERE unique_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":logout_time", $formattedDate);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Successfully updated, destroy session and redirect to login
            session_unset();
            session_destroy();
            header("Location: ./login.php");
            exit();
        } else {
            // Redirect to users.php if update failed
            header("Location: ./users.php");
            exit();
        }
    } else {
        // Handle case where $id is not set
        header("Location: ./users.php");
        exit();
    }
} else {
    // Redirect to login.php if session unique_id is not set
    header("Location: ./login.php");
    exit();
}
?>
