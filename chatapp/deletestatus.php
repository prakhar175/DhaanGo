<?php
require "dbh.inc.php";
session_start();

if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    
    try {
        $query = "DELETE FROM status WHERE unique_id = :unique_id LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":unique_id", $unique_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "success", "message" => "Status deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "No status found to delete."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error deleting status: " . $e->getMessage()]);
    }
} 
