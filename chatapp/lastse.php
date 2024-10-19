<?php

require "dbh.inc.php";
session_start();
$unique_id = $_SESSION['unique_id'];
$query = "SELECT lastse FROM users_main WHERE unique_id=:unique_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":unique_id", $unique_id);
$stmt->execute();
$result = $stmt->fetch();
$lastse = "";
if ($result['lastse'] == "Active") {
    $lastse = "Inactive";
} else {
    $lastse = "Active";
}
$querystatus = "UPDATE users_main SET lastse=:lastse WHERE unique_id=:unique_id";
$stmtstatus = $pdo->prepare($querystatus);
$stmtstatus->bindParam(":unique_id", $unique_id);
$stmtstatus->bindParam(":lastse", $lastse);
$stmtstatus->execute();
