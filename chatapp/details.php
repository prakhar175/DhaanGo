<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
    header("Location: login.php");
    exit;
}

require "dbh.inc.php";
$unique_id = $_GET['incoming_id'];

try {
    $query = "SELECT * FROM users_main WHERE unique_id = :unique_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":unique_id", $unique_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $username = htmlspecialchars($result['fname']);
        $last = $result['lname'];
        $lastseen = $result['lastse'];
        $bio = $result['bio'];
        $userphoto = $result['img'];

        // Handle movies
        $movies = isset($result['movies']) && !empty($result['movies']) ? $result['movies'] : "No movies listed";

        // Handle tvshows
        $tvshows = isset($result['tvshows']) && !empty($result['tvshows']) ? $result['tvshows'] : "No TV shows listed";

        // Handle book
        $book = isset($result['book']) && !empty($result['book']) ? $result['book'] : "No books listed";

        // Handle music
        $music = isset($result['music']) && !empty($result['music']) ? $result['music'] : "No music listed";
        $hobbies = isset($result['hobbies']) && !empty($result['hobbies']) ? $result['hobbies'] : "No books listed";

        $status = $result['status'];
        $userImg = htmlspecialchars($result['img']);
    } else {
        exit; // or handle error condition
    }
} catch (PDOException $e) {
    exit; // or handle database error
}

if (!isset($_GET['incoming_id']) || empty($_GET['incoming_id'])) {
    // header("Location: error.php");
    exit;
}

// Pass data to JavaScript
?>
