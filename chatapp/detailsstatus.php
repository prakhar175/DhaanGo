<?php
session_start();
require "dbh.inc.php"; // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['unique_id'])) {
    die("User is not logged in.");
}

// Sanitize and validate the user ID from the GET request
$id = filter_input(INPUT_GET, 'userid', FILTER_SANITIZE_NUMBER_INT);
if ($id === null || $id === false) {
    die("Invalid user ID.");
}

$unique_id = $_SESSION['unique_id'];

// Query to fetch status from the database
$query = "SELECT * FROM status WHERE unique_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);

try {
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {

            
            // echo "<div>jlnljnjln</div>";
            // echo $row['status'];
            if ($row['status']) {
                
                $class = "image";
                // echo "moopd";
                echo "<div class='status-slide'>";
                echo "<img src='images/" . htmlspecialchars($row['status']) . "' alt='Status Image'>";
                echo "<p class='{$class}'>" . htmlspecialchars($row['statusmessage']) . "</p>";
            } else {
                $class = "statustext";
            
                echo "<div class='status-slide' style='background-color: {$row['color']};'>";
                echo "<p class='{$class}'>" . htmlspecialchars($row['statusmessage']) . "</p>";
            }
            
            if ($row['unique_id'] != $unique_id) {
                echo "
                
                <div>
                        <form class='reply-form' action='insertchat.php' method='post'>
                            <input type='hidden' name='outgoing_id' value='" . htmlspecialchars($unique_id) . "'>
                            <input type='hidden' name='incoming_id' value='" . htmlspecialchars($id) . "'>
                            <input type='text' name='statusmessage' placeholder='Reply' class='statusmessage' required>
                            <button type='submit'>Send</button>
                        </form>
                      </div>";
            }
            echo "</div>"; // Close status-slide div
        }
    } else {
        echo "<p>No status found for this user.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
