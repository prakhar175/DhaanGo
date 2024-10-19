<?php
require "../dbh.inc.php";
session_start();

$unique_id = $_SESSION['unique_id'];

$query = "SELECT * FROM commitee";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    $sender_id = $row['sender_id'];
    $message_time = date("h:i A", strtotime($row['time']));

    if ($sender_id == $unique_id) {
        // Current user message
        echo '<div class="message sent">
                <div class="meta-info">You, ' . $message_time . '</div>
                <div class="message-box">' . htmlspecialchars($row['message']) . '</div>
              </div>';
    } else {
        // Other user message
        $queryUser = "SELECT * FROM users_main WHERE unique_id=:unique_id";
        $stmtUser = $pdo->prepare($queryUser);
        $stmtUser->bindParam(":unique_id", $sender_id);
        $stmtUser->execute();
        $sender = $stmtUser->fetch(PDO::FETCH_ASSOC);

        $sender_name = htmlspecialchars($sender['fname']) . " " . htmlspecialchars($sender['lname']);
        echo '<div class="message received">
                <div class="meta-info">' . $sender_name . ', ' . $message_time . '</div>
                <div class="message-box">' . htmlspecialchars($row['message']) . '</div>
              </div>';
    }
}
?>
