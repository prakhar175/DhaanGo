<?php
require "dbh.inc.php";
session_start();

if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];

    
    // Start transaction


    // Delete from messages
    $queryMessages = "DELETE FROM messages WHERE outgoing_msg_id = :unique_id OR incoming_msg_id=:unique_id";
    $stmtMessages = $pdo->prepare($queryMessages);
    $stmtMessages->bindParam(":unique_id", $unique_id);
    $stmtMessages->execute();

    // Delete from users
    $queryUsers = "DELETE FROM users_main WHERE unique_id = :unique_id";
    $stmtUsers = $pdo->prepare($queryUsers);
    $stmtUsers->bindParam(":unique_id", $unique_id);
    $stmtUsers->execute();

    // Commit transaction
    if ($stmtMessages && $stmtUsers) {



        // Log out user
        session_destroy();
        header("Location: ./login.php");
        exit();
    } else {
        header("Location: ./users.php");
    }

} else {
    header("Location: ./login.php");
    exit();
}
?>