<?php

require "../../../dbh.inc.php";

session_start();

$unique_id=$_SESSION['unique_id'];
$query="SELECT * FROM buisness_users WHERE unique_id=:unique_id";
$stmt=$pdo->prepare($query);
$stmt->bindParam(':unique_id',$unique_id);
$stmt->execute();
$result=$stmt->fetch(PDO::FETCH_ASSOC);

?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-container img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        h1 {
            margin-top: 20px;
            font-size: 28px;
            color: #333;
        }

        .profile-details {
            margin-top: 20px;
        }

        .profile-details div {
            margin-bottom: 10px;
        }

        .profile-details span {
            font-weight: bold;
            color: #555;
        }

        .profile-details .email,
        .profile-details .number {
            font-size: 18px;
            color: #777;
        }

        .logout-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <!-- Display profile photo -->
        <img src="<?php echo $result['profile_photo']; ?>" alt="images/logo.png">

        <!-- Display full name -->
        <h1><?php echo $result['fname'] . " " . $result['lname']; ?></h1>

        <!-- Display additional profile details -->
        <div class="profile-details">
            <div class="email"><span>Email:</span> <?php echo $result['email']; ?></div>
            <div class="number"><span>Phone Number:</span> <?php echo $result['number']; ?></div>
        </div>

        <!-- Logout Button (optional) -->
        <form action="../../../profile_main/logout.php" method="post">
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</body>

</html>
