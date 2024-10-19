<?php

require "../../dbh.inc.php";

session_start();
$unique_id = $_SESSION['unique_id'];

$query = "SELECT * FROM products WHERE unique_id = :unique_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':unique_id', $unique_id);
$stmt->execute();
$result = $stmt->fetchAll();

// Loop through and display product information
$data="";
foreach ($result as $row) {
    $data.= "<h2>" . htmlspecialchars($row['name']) . "</h2>";
    $data.= "<p>Price: Rs. " . htmlspecialchars($row['price']) . "</p>";
    $data.="<p>Quantity: " . htmlspecialchars($row['quantity']) . "</p>";
    $data.="<p>Description: " . htmlspecialchars($row['description']) . "</p>";
    
    $data.="<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'><br><br>";
}
echo $data;
