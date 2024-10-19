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
        }.container {
    max-width: 600px; /* Center container */
    margin: auto; /* Center the container */
    padding: 20px; /* Add padding */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Soft shadow */
    background-color: #ffffff; /* Background color */
}

.profile-photo {
    border: 2px solid #007bff; /* Border for profile photo */
}

.btn {
    font-size: 16px; /* Increase button font size */
    padding: 10px; /* Button padding */
}

h3 {
    color: #007bff; /* Heading color */
}

.alert {
    margin-bottom: 20px; /* Spacing for alerts */
}

.location {
    border: 1px solid #007bff; /* Border around location section */
    border-radius: 8px; /* Rounded corners */
    padding: 15px; /* Padding for location section */
    background-color: #f8f9fa; /* Light background */
}
.profile-photo {
    border: 3px solid #007bff; /* Blue border for the profile photo */
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.3); /* Soft shadow */
    transition: transform 0.3s ease; /* Transition for hover effect */
}

.profile-photo:hover {
    transform: scale(1.05); /* Slightly enlarge on hover */
}

    </style>
</head>

<body>
<div class="container mt-5">
    <a href="../">DhaanGo</a>
    <!-- Success and Error Messages -->
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <!-- User Profile Section -->
    <?php if ($result): ?>
        <!-- <a href="../images/logo.png">qfadfdfd</a> -->
        <h3 class="text-center mb-4">Welcome, <?= htmlspecialchars($result['fname']) . " " . htmlspecialchars($result['lname']) ?></h3>
        <div class="text-center mb-4">
        <img src="<?= !empty($result['profile_photo']) ? htmlspecialchars($result['profile_photo']) : '../images/mm.jpg'; ?>" 
     alt="Profile Photo of <?= htmlspecialchars($result['fname']) . ' ' . htmlspecialchars($result['lname']) ?>" 
     class="profile-photo rounded-circle" style="width: 150px; height: 150px;">

</div>

        <div class="text-center mb-3">
            <strong>Email:</strong> <span id="email-display"><?= htmlspecialchars($result['email']) ?></span>
        </div>

        <!-- Profile Update Form -->
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label for="email">Update Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($result['email']) ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary btn-block">Update</button>
        </form>

        <!-- Logout Form -->
        <form method="POST" class="logout-form mb-4" action="logout.php">
            <button type="submit" name="logout" class="btn btn-danger btn-block">Logout</button>
        </form>

        <!-- Location Section -->
        <div class="location text-center mb-4">
            <h5>Enter Your Location</h5>
            <p>Click the button below to share your current location:</p>
            <button class="btn btn-primary buttonloc">Click here to enter your location</button>
            <div id="location" class="mt-3"></div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">User not found in the database. Redirecting to the login page in 5 seconds.</div>
        <?php header("refresh:5;url=../login/login.php"); ?>
    <?php endif; ?>

    <!-- Phone Number Submission Form -->
    <form action="number.php" method="post" class="mb-4">
        <div class="form-group">
            <label for="number">Enter Your Phone Number:</label>
            <input type="number" name="number" class="form-control" placeholder="Enter your number" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </form>
</div>

    <?php
    // Display the alert if there's a message
    if (isset($_SESSION['message'])) {
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']); // Clear the message after displaying it
    }
    ?>
    <script src="script.js"></script>
</body>

</html>