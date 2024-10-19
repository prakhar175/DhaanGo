<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Status</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file -->
    <style>
        /* Add your custom styles for status view */
        .status-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer; /* Add cursor pointer for clickable effect */
        }
        .status-item .status-img {
            width: 50px; /* Adjust size as needed */
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            float: left;
        }
        .status-item .status-text {
            margin: 0;
            display: none; /* Hide status text initially */
        }
    </style>
</head>
<body>
    <div class="status-container">
        <?php
        session_start();
        require "dbh.inc.php";

        $id = $_SESSION['unique_id'];

        try {
            // Fetch current user's image
            $query2 = "SELECT img FROM users WHERE unique_id = :id";
            $stmt2 = $pdo->prepare($query2);
            $stmt2->execute([':id' => $id]);
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $img = htmlspecialchars($result2['img']);

            // Fetch other users' statuses excluding the current user
            $query = "SELECT DISTINCT users_main.unique_id, users_main.img, status.statusmessage FROM users_main INNER JOIN status ON users_main.unique_id = status.unique_id WHERE users_main.unique_id != :id ORDER BY status.id DESC";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                foreach ($result as $row) {
                    $unique_id = $row['unique_id'];
                    $status_message = htmlspecialchars($row['statusmessage']);

                    echo "<div class='status-item' onclick='showStatus(this)'>";
                    echo "<img src='images/" . htmlspecialchars($row['img']) . "' alt='User Image' class='status-img'>";
                    echo "<p class='status-text'>" . $status_message . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<div class='no-status'>No active status</div>";
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "<div class='error'>Database Error: " . $e->getMessage() . "</div>";
        }
        ?>
    </div>

    <script>
        function showStatus(element) {
            // Toggle display of status text
            let statusText = element.querySelector('.status-text');
            statusText.style.display = (statusText.style.display === 'block') ? 'none' : 'block';
        }
    </script>
</body>
</html>
