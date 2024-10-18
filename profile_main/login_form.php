<?php
session_start();
require "../dbh.inc.php";

if (!isset($_SESSION['unique_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$unique_id = $_SESSION['unique_id'];

// Prepare SQL query
$query = "SELECT * FROM users WHERE unique_id = :unique_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":unique_id", $unique_id);

if ($stmt->execute()) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Error executing query.";
    exit;
}

// Handle email update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $newEmail = $_POST['email'];
    
    $updateQuery = "UPDATE users SET email = :email WHERE unique_id = :unique_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':email', $newEmail);
    $updateStmt->bindParam(':unique_id', $unique_id);

    if ($updateStmt->execute()) {
        $successMessage = "Email updated successfully.";
        // Optionally, refresh the user's session email
        $_SESSION['email_address'] = $newEmail;
    } else {
        $errorMessage = "Error updating email.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
            max-width: 600px;
        }
        .alert {
            margin-bottom: 15px;
        }
        .profile-photo {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .location {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .logout {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <?php if ($result): ?>
            <h3 class="text-center">Welcome <?= htmlspecialchars($result['fname']) . " " . htmlspecialchars($result['lname']) ?></h3>
            <div class="text-center">
                <img src="<?= htmlspecialchars($result['profile_photo']) ?>" alt="Profile Photo" class="profile-photo">
            </div>
            <div class="text-center mb-3">
                <strong>Email:</strong> <span id="email-display"><?= htmlspecialchars($result['email']) ?></span>
            </div>

            <!-- Profile Update Form -->
            <form method="POST">
                <div class="form-group">
                    <label for="email">Update Email:</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($result['email']) ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>

            <form method="POST" class="logout-form" action="logout.php">
                <button type="submit" name="logout" class="btn btn-danger btn-block logout">Logout</button>
            </form>

            <div class="location">
                <h5>Enter Your Location</h5>
                <p>Click the button below to share your current location:</p>
                <button class="btn btn-primary buttonloc">Click here to enter your location</button>
                <div id="location" class="mt-3"></div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">User not found in the database. Redirecting to the login page in 5 seconds.</div>
            <?php header("refresh:5;url=../login/login.php"); ?>
        <?php endif; ?>
    </div>

    <script src="script.js"></script>
</body>

</html>
