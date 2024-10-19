<?php

require "../dbh.inc.php";
session_start();

$unique_id = $_SESSION['unique_id'];

$query = "SELECT * FROM users_main WHERE unique_id=:unique_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':unique_id', $unique_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="message">
        <?php
        $query = "SELECT * FROM commitee";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {

            if ($row['sender_id'] == $unique_id) {
                echo "You: " . htmlspecialchars($row['message']);
            } else {
                $sender_id = $row['sender_id'];
                $query = "SELECT * FROM users_main WHERE unique_id=:unique_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":unique_id", $sender_id);
                $stmt->execute();
                $sender = $stmt->fetch(PDO::FETCH_ASSOC);
                $sender_name = htmlspecialchars($sender['fname']) . " " . htmlspecialchars($sender['lname']);
                echo $sender_name . " : " . htmlspecialchars($row['message']);
            }
            echo "<br>";
        }
        ?>
    </div>

    <form id="messageForm" action="commitee.php" method="post">
        <input type="text" name="message" placeholder="Enter your message" required>
        <button type="submit">Submit</button>
    </form>

    <script>
        const form = document.getElementById("messageForm");
        form.onsubmit = (e) => {
            e.preventDefault(); 

            const xhr = new XMLHttpRequest();
            const formData = new FormData(form); 

            xhr.open("POST", "commitee.php", true);
            xhr.onload = () => {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    document.querySelector(".message").innerHTML += "You: " + formData.get("message") + "<br>";
                    form.reset(); 
                } else {
                    console.error("Error submitting form");
                }
            };
            xhr.send(formData); // Send the form data
        };
    </script>
</body>

</html>
