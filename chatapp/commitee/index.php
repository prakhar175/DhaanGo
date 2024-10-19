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
    <title>Chat Interface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .message-container {
            width: 60%;
            height: 400px; /* Fixed height */
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow-y: auto; /* Enable vertical scrolling */
            scrollbar-width: thin; /* Firefox */
            scrollbar-color: #888 #e0e0e0;
        }

        .message-container::-webkit-scrollbar {
            width: 8px; /* Scrollbar width */
        }

        .message-container::-webkit-scrollbar-track {
            background: #e0e0e0;
        }

        .message-container::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .message {
            margin-bottom: 10px;
        }

        .message.sent {
            text-align: right;
        }

        .message.received {
            text-align: left;
        }

        .message.sent .message-box {
            background-color: #000;
            color: #fff;
            display: inline-block;
            padding: 10px;
            border-radius: 15px 15px 0 15px;
            max-width: 60%;
            word-wrap: break-word;
        }

        .message.received .message-box {
            background-color: #fff;
            color: #000;
            display: inline-block;
            padding: 10px;
            border-radius: 15px 15px 15px 0;
            max-width: 60%;
            word-wrap: break-word;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .message .meta-info {
            font-size: 12px;
            margin-bottom: 5px;
            color: gray;
        }

        form {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        input[type="text"] {
            width: 30%;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ccc;
            margin-left:30%
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin-right:auto;
            margin-left:6%
        }

        button:hover {
            background-color: #0056b3;
        }
        header a {
            font-weight:600;
            font-size: 40px;
            text-decoration: underline;
            color:grey;
            margin-left:44%
        }
    </style>
</head>

<body>
    <header>
        <a href="../../">DhaanGo</a>
    </header>
    <div class="message-container" id="messageContainer">
        <!-- Messages will be dynamically loaded here -->
    </div>

    <form id="messageForm" action="commitee.php" method="post">
        <input type="text" name="message" placeholder="Enter your message" required>
        <button type="submit">Submit</button>
    </form>

    <script>
        const messageContainer = document.getElementById("messageContainer");
        const form = document.getElementById("messageForm");

        // Function to load messages
        function loadMessages() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "messages.php", true);
            xhr.onload = () => {
                if (xhr.status === 200) {
                    messageContainer.innerHTML = xhr.responseText;
                    messageContainer.scrollTop = messageContainer.scrollHeight; // Scroll to bottom
                }
            };
            xhr.send();
        }

        // Call loadMessages every 500ms
        setInterval(loadMessages, 500);

        // Handle message form submission
        form.onsubmit = (e) => {
            e.preventDefault();

            const xhr = new XMLHttpRequest();
            const formData = new FormData(form);

            xhr.open("POST", "commitee.php", true);
            xhr.onload = () => {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    form.reset(); // Clear input field
                    loadMessages(); // Reload messages after submission
                } else {
                    console.error("Error submitting form");
                }
            };
            xhr.send(formData);
        };

        // Load messages on page load
        window.onload = () => {
            loadMessages();
        };
    </script>
</body>

</html>
