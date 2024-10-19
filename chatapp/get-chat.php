<?php

session_start();
require "dbh.inc.php";

$outgoing_id = $_POST['outgoing_id'];
$incoming_id = $_POST['incoming_id'];
$output = "";

// Corrected the query to properly handle the AND/OR condition with parentheses
$query = "SELECT * FROM messages 
          LEFT JOIN users_main ON users_main.unique_id = messages.incoming_msg_id 
          WHERE (outgoing_msg_id = :outgoing_id AND incoming_msg_id = :incoming_id) 
          OR (outgoing_msg_id = :incoming_id AND incoming_msg_id = :outgoing_id) 
          ORDER BY msg_id ASC";

$stmt = $pdo->prepare($query);
$stmt->bindParam(":outgoing_id", $outgoing_id);
$stmt->bindParam(":incoming_id", $incoming_id);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query3 = "SELECT * FROM users_main WHERE unique_id = :incoming_id";
$stmt3 = $pdo->prepare($query3);
$stmt3->bindParam(":incoming_id", $incoming_id);
$stmt3->execute();
$result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
$img = htmlspecialchars($result3['img']);  // Sanitizing output

$img_extensions = ['jpeg', 'jpg', 'png', 'gif'];

foreach ($result as $row) {
    $message = htmlspecialchars($row['message']);  // Sanitizing message output
    $imageexplode = explode('.', $row['message']);
    $imgex = strtolower(end($imageexplode));

    if ($row['outgoing_msg_id'] === $outgoing_id) {
        if (in_array($imgex, $img_extensions)) {
            $output .= "<div class='chat outgoing'>
                        <div class='details'>
                        <img src='images/" . $message . "' alt='Image' class='image'>
                        </div></div>";
        } else {
            $output .= '<div class="chat outgoing">
                        <div class="details">
                        <p>' . $message . '</p></div></div>';
        }
    } else {
        if (in_array($imgex, $img_extensions)) {
            $output .= "<div class='chat incoming'>
                        <a href='profile.php'><img src='images/" . $img . "' alt='User Image' class='profile-img'></a>
                        <div class='details'>
                        <img src='images/" . $message . "' alt='Image' class='image'>
                        </div></div>";
        } else {
            $output .= '<div class="chat incoming">
                        <img src="images/' . $img . '" alt="User Image" class="profile-img">
                        <div class="details">
                        <p>' . $message . '</p></div></div>';
        }
    }
}

echo $output;

