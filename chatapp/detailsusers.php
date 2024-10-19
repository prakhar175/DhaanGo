<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit; // Add an exit here to stop further execution

} else {
    require "dbh.inc.php";
    $unique_id = $_SESSION['unique_id'];
    // echo $unique_id;
    $query = "SELECT * FROM users_main WHERE unique_id=:unique_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":unique_id", $unique_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $username = $result['fname'];
        $last=$result['lname'];
        // $bio=$result['bio'];
        // $userphoto=$result['img'];
        // $hobbies=$result['hobbies'];
        // $movies=$result['movies'];
        // $tvshows=$result['tvshows'];
        // $music=$result['music'];
        // $book=$result['book'];
    } else {
        $username = "no username";
    }
    $status = "Active now";
    $query1 = "UPDATE users_main SET status='{$status}' WHERE unique_id=:unique_id";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(":unique_id", $unique_id);
    $stmt1->execute();
}


?>