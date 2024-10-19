<?php
require "dbh.inc.php";
session_start();

$unique_id = $_SESSION['unique_id']; // Current user's unique ID

// Sanitize the input to prevent SQL injection
$search = '%' . $_POST['searchTerm'] . '%';

// Corrected query to include both first names and last names, and to exclude the current user
$query = "SELECT * FROM users_main WHERE (fname LIKE :search OR lname LIKE :search) AND unique_id != :unique_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':search', $search, PDO::PARAM_STR);
$stmt->bindParam(':unique_id', $unique_id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";

if ($result) {
    foreach ($result as $row) {
        $user_id = $row['unique_id'];
        $status = ($row['status'] == "Offline now") ? "offline" : "online";
        $timefinal = "none"; // Initialize timefinal variable
$hour=0;$minute=0;
        // Fetch the latest message between the current user and this user
        try {
            $queryMessage = "SELECT * FROM messages 
                             WHERE (incoming_msg_id = :incoming_id AND outgoing_msg_id = :outgoing_id) 
                                OR (incoming_msg_id = :outgoing_id AND outgoing_msg_id = :incoming_id) 
                             ORDER BY msg_id DESC LIMIT 1";
            $stmtMessage = $pdo->prepare($queryMessage);
            $stmtMessage->bindParam(":incoming_id", $unique_id, PDO::PARAM_STR);
            $stmtMessage->bindParam(":outgoing_id", $user_id, PDO::PARAM_STR);
            $stmtMessage->execute();
            $resultMessage = $stmtMessage->fetch(PDO::FETCH_ASSOC);

            if ($resultMessage) {
                $message = htmlspecialchars($resultMessage['message']);
                $message = (strlen($message) > 25) ? substr($message, 0, 25) . "..." : $message;
                $you = ($unique_id == $resultMessage['outgoing_msg_id']) ? "You: " : "";

                // Check if the message is an image
                $imgextensions = ['jpg', 'jpeg', 'gif', 'png'];
                $imgexplode = explode('.', $resultMessage['message']);
                $image = strtolower(end($imgexplode));
                if (in_array($image, $imgextensions)) {
                    $message = '<div class="recent">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image-fill" viewBox="0 0 16 16">
                                        <path d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                                    </svg> Image
                                </div>';
                }

                if (isset($resultMessage['timestamp'])) {
                    $time = new DateTime($resultMessage['timestamp'],new DateTimeZone('UTC'));
                    $hour=$time->modify('+5 hours');
                    $minute=$time->modify('+30 minutes');
                    $hour=$time->format('H');
                    $minute=$time->format('i');
                }
            } else {
                $message = "Start a chat";
                $you = "";
            }
        } catch (PDOException $e) {
            echo "Error fetching message: " . $e->getMessage();
        }

        // Generate the HTML output for each user
        $output .= '<a href="chat.php?incoming_id=' . htmlspecialchars($user_id) . '">
                        <div class="profilesearch">
                            <div class="profile-image">
                                <img src="images/' . htmlspecialchars($row['img']) . '" alt="Profile Image">
                            </div>
                            <div class="contentsearch">
                                <span>' . htmlspecialchars($row['fname']) . ' ' . htmlspecialchars($row['lname']) . '</span>
                                <div class="message">
                                    <p>' . $you . '</p><p>' . $message . '</p>
                                </div>
                            </div>
                            <div class="statusphone">
                                <div>' . $hour ." : ".$minute. '</div>
                                <div class="' . $status . '"></div>
                            </div>
                        </div>
                    </a>';
    }
} else {
    $output .= "No searches found for your search";
}

echo $output;
?>
