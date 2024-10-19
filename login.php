<?php

require "dbh.inc.php";

session_start();
// echo $_SESSION ['unique_id'];
$query="SELECT * FROM users WHERE unique_id=:unique_id";
$stmt=$pdo->prepare($query);
$stmt->bindParam(':unique_id', $_SESSION['unique_id']);
$stmt->execute();
$result=$stmt->fetch();
if ($result){
    echo "user_f";
    exit();
}
$query2="SELECT * FROM users WHERE unique_id=:unique_id";
$stmt1=$pdo->prepare($query2);
$stmt1->bindParam(':unique_id', $_SESSION['unique_id']);
$stmt1->execute();
$result3=$stmt1->fetch();
if ($result3){
    echo "user_b";
}
else{
    echo "nooo";
}