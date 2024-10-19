<?php

session_start();
require "dbh.inc.php";
$unique_id=$_SESSION['unique_id'];
// Query to get the count of users
$query = "SELECT COUNT(*) AS count FROM users_main";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$output = "";
if ($result['count'] == 1) {
    $output .= "no users available";
} else if ($result['count'] > 1) {
    // Query to get all users
    

    include "data.php";
}

// Echo the output
echo $output;

?>
