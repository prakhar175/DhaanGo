<?php
// / Uncomment if using sessions

require "dbh.inc.php";

if (!isset($_SESSION['unique_id'])) {
    header("Location: login.php");
    exit;
}

$unique_id = $_SESSION['unique_id'];
$output = "";

try {
    $query1 = "SELECT users_main.*, 
                      (SELECT timestamp FROM messages WHERE (incoming_msg_id = users_main.unique_id OR outgoing_msg_id = users_main.unique_id) ORDER BY timestamp DESC LIMIT 1) as ts 
               FROM users_main
               WHERE unique_id != :unique_id 
               ORDER BY ts DESC";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(":unique_id", $unique_id, PDO::PARAM_STR);
    $stmt1->execute();
    $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result1 as $row) {
        $user_id = $row['unique_id'];

        $query2 = "SELECT * FROM messages 
                   WHERE (incoming_msg_id = :incoming_id AND outgoing_msg_id = :outgoing_id) 
                      OR (incoming_msg_id = :outgoing_id AND outgoing_msg_id = :incoming_id) 
                   ORDER BY msg_id DESC LIMIT 1";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->bindParam(":incoming_id", $unique_id, PDO::PARAM_STR);
        $stmt2->bindParam(":outgoing_id", $user_id, PDO::PARAM_STR);
        $stmt2->execute();
        $resultmessage = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($resultmessage) {
            $message = htmlspecialchars($resultmessage['message']);
            $message = (strlen($message) > 25) ? substr($message, 0, 25) . "..." : $message;
            $you = ($unique_id == $resultmessage['outgoing_msg_id']) ? "You: " : "";

            $imgextensions = ['jpg', 'jpeg', 'gif', 'png'];
            $imgexplode = explode('.', $resultmessage['message']);
            $image = strtolower(end($imgexplode));
            if (in_array($image, $imgextensions)) {
                $message = '<div class="recent">
                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image-fill" viewBox="0 0 16 16">
                                   <path d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                               </svg> Image
                           </div>';
            }
        } else {
            $message = "Start a chat";
            $you = "";
        }

        $status = ($row['status'] == "Offline now") ? "offline" : "online";
        $timefinal = "none";
        $minutes = "none";
        $hour = "none";
        if ($hour == "none") {
            $minutes = "";
        }
        if ($resultmessage && isset($resultmessage['timestamp'])) {
            $time = new DateTime($resultmessage['timestamp'], new DateTimeZone('UTC')); // Adjust timezone as per your application
            // $time->modify('+5 hours');
            // $time->modify('+30 minutes');
            $hour = $time->format('H');
            $minutes = $time->format('i');
        }

        $output .= '<a href="chat.php?incoming_id=' . htmlspecialchars($user_id) . '">
                        <div class="content" id="content">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                            <div class="details">
                                <span>' . htmlspecialchars($row['fname']) . ' ' . htmlspecialchars($row['lname']) . '</span>
                                <div class="mess">
                                    <p>' . $you . '</p><p> ' . $message . '</p>
                                </div>
                            </div>
                            <div class="statusphone">
                                <p>' . $hour . ':' . $minutes . '</p>
                                <div class="' . $status . '"></div>
                            </div>
                        </div>
                    </a>';
    }

     // Output the generated HTML

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
