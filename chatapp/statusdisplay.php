<?php
require "dbh.inc.php";
session_start();

$output = "";
$id = $_SESSION['unique_id'];

try {
    // Fetch current user's image
    $query2 = "SELECT img FROM users WHERE unique_id = :id";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute([':id' => $id]);
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $img = htmlspecialchars($result2['img']);

    // Fetch other users' statuses excluding the current user
    $query = "
        SELECT u.unique_id, u.img, u.fname
        FROM users u
        JOIN (
            SELECT DISTINCT unique_id
            FROM status
            WHERE unique_id != :id
        ) s ON u.unique_id = s.unique_id
        ORDER BY s.unique_id DESC
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output .= "<div class='status-container'>";
    $output .= "<div class='current-user'><a href='statusview.php?userid=" . htmlspecialchars($id) . "'><img src='images/" . htmlspecialchars($img) . "' alt='Current User Image' class='user-img'></a></div>";

    if (count($result) > 0) {
        foreach ($result as $row) {
            $unique_id = htmlspecialchars($row['unique_id']);
            $user_img = htmlspecialchars($row['img']);
            $user_name = htmlspecialchars($row['fname']);
            
            $output .= "<a href='statusview.php?userid=" . $unique_id . "'>";
            $output .= "<img src='images/" . $user_img . "' alt='User Image' class='status-img' id='statusimage'>";
            $output .= "<p>" . $user_name . "</p>";
            $output .= "</a>";
        }
    } else {
        $output .= "<div class='no-status'>No active status</div>";
    }
    $output .= "</div>"; // Close status-container
} catch (PDOException $e) {
    // Handle database errors
    $output = "<div class='error'>Database Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo $output;
?>
