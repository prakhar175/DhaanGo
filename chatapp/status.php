<?php

require "dbh.inc.php";
$incoming_id = $_POST['incoming_id'];
$query = "SELECT * FROM users_main WHERE unique_id=:incoming_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":incoming_id", $incoming_id);
$stmt->Execute();
$result = $stmt->fetch();
$lastseen = "";
if ($result['status'] == "Active now") {
    // if ($result['lastse'] == "Active") {
        // echo "gooff";
        // if($result[''])
        echo "Online";
    // }
    
        // echo "Offline";
    // }
} else {
    if($result['lastse']=="Active"){
    echo "Last seen at " . substr($result['logout_time'], 0, 8);}
    else{
        echo "Offline";
    }
    // $lastseen = "Offline now";
}
echo $lastseen;