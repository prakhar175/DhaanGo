<?php

require "../dbh.inc.php";

session_start();
$message=$_POST['message'];
$sender_id=$_SESSION['unique_id'];
// echo $sender;
$query="INSERT INTO commitee (sender_id,message) VALUES (:sender_id,:message)";
$stmt=$pdo->prepare($query);
$stmt->bindParam(":sender_id",$sender_id);
$stmt->bindParam(":message",$message);
// $stmt->execute();
if($stmt->execute()){
    echo "done";
}