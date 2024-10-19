<?php
session_start();
require "../dbh.inc.php"; // Ensure your database connection is correct

error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable error reporting

// Check if session variables are set
if (!isset($_SESSION['unique_id'])) {
    header("Location: ../login.php");
    exit;
}

// $fname = $_SESSION['fname'];
// $lname = $_SESSION['lname'];
$unqiue_id=$_SESSION['unique_id'];
// Prepare SQL query
$query = "SELECT * FROM users WHERE unique_id=:unique_id";
$stmt = $pdo->prepare($query);
// $stmt->bindParam(':fname', $fname);
// $stmt->bindParam(':lname', $lname);
$stmt->bindParam(":unique_id",$unique_id);
if ($stmt->execute()) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Handle query execution error
    echo "Error executing query.";
    exit;
}

// Logout functionality
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
//     session_destroy();
//     header("Location: ../login.php");
//     exit;
// }

// Profile update functionality (basic example)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $email = $_POST['email'];
    // Here, you would add validation and sanitization for the input.

    $updateQuery = "UPDATE users SET email = :email WHERE fname = :fname AND lname = :lname";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':fname', $fname);
    $updateStmt->bindParam(':lname', $lname);

    if ($updateStmt->execute()) {
        $successMessage = "Profile updated successfully.";
    } else {
        $errorMessage = "Error updating profile.";
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

        h2 {
            margin-left: 34%;
            font-size: 49px;
        }
        a{
            text-decoration: none;
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
        <a href="../">
            <h2>DhaanGo</h2>
        </a>
        <?php if ($result): ?>
            <h3 class="text-center">Welcome <?= htmlspecialchars($fname) . " " . htmlspecialchars($lname) ?></h3>
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
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($result['email']) ?>"
                        required>
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
            <div class="alert alert-warning">User not found in the database. Redirecting to the login page in 5 seconds.
            </div>
            <?php header("refresh:5;url=../login/login.php"); ?>
        <?php endif; ?>
    </div>

    <script src="script.js"></script>
    <script>
        setInterval(() => {
            window.location.href="../"
        }, 2000);
    </script>
</body>

</html>