<?php
session_start();
require '../../vendor/autoload.php';
require "../../dbh.inc.php"; // Ensure your database connection is correct

// Clear any existing session
session_unset();
session_destroy();
session_start();

// Init Google OAuth configuration
$clientID = '157238251101-hdjlpufk6nrm50e360g4hu3bmk4qeaiq.apps.googleusercontent.com'; // Your client ID
$clientSecret = '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'; // Your client secret
$redirectUri = 'http://localhost/hackathon/profile';

// Create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Generate a random unique ID for the user
function generateRandomNumber()
{
    return rand(100000, 999999); // Random number between 100000 and 999999
}

if (isset($_GET['code'])) {
    // Fetch token with authorization code
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    // Check for token error
    if (array_key_exists('error', $token)) {
        echo "Error fetching token: " . htmlspecialchars($token['error']);
        exit;
    }

    // Set access token for future requests
    $client->setAccessToken($token['access_token']);

    // Get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();

    // Store user information in session
    $_SESSION['fname'] = htmlspecialchars($google_account_info->given_name);
    $_SESSION['lname'] = htmlspecialchars($google_account_info->family_name);
    $_SESSION['email_address'] = htmlspecialchars($google_account_info->email);
    $_SESSION['profile_photo'] = htmlspecialchars($google_account_info->picture); // Get profile photo

    // Insert or update user information in the database
    $randomNumber = generateRandomNumber();
    $stmt = $pdo->prepare("INSERT INTO users (unique_id, fname, lname, email, profile_photo) 
                            VALUES (?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE fname = VALUES(fname), lname = VALUES(lname), profile_photo = VALUES(profile_photo)");
    $stmt->execute([
        $randomNumber,
        $_SESSION['fname'],
        $_SESSION['lname'],
        $_SESSION['email_address'],
        $_SESSION['profile_photo']
    ]);
    $query1 = "INSERT INTO users_main (unique_id, fname, lname, number, email, password) VALUES (:unique_id, :fname, :lname, :number, :email, :password)";
    $stmt1 = $pdo->prepare($query1);
    
    $stmt1->bindParam(':unique_id', $unique_id);
    $stmt1->bindParam(':fname', $fname);
    $stmt1->bindParam(':lname', $lname);
    $stmt1->bindParam(':number', $number);
    $stmt1->bindParam(':email', $email);
    $stmt1->bindParam(':password', $hashed_password); // Use hashed password

    // Execute the second insert
    if (!$stmt1->execute()) {
        throw new Exception("Error inserting into users_main table.");
    }

    // Check for successful insertion
    if ($stmt->rowCount() > 0) {
        // Store unique ID in the session
        $_SESSION['unique_id'] = $randomNumber;
        header('Location: ../profile_main'); // Redirect to your profile page
        exit;
    } else {
        // Fetch existing user information if insertion fails
        $query = "SELECT * FROM users WHERE fname = :fname AND lname = :lname";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':fname', $_SESSION['fname']);
        $stmt->bindParam(':lname', $_SESSION['lname']);
        $stmt->execute();

        if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['unique_id'] = $result['unique_id'];
            header('Location: ../'); // Redirect to your profile page
            exit;
        } else {
            echo "User not found after insertion attempt. Please try logging in again.";
            exit;
        }
    }
} else {
    // Show Google Login link with button styling
    // echo "<a href='" . htmlspecialchars($client->createAuthUrl()) . "' class='google-login-button'>Login with Google</a>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .google-login-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4285F4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            width: 90%;
            margin-bottom: 20px;
        }

        .google-login-button:hover {
            background-color: #357ae8;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"] {
            width: 94%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        img {
            width: 50px;
            height: 40px
        }

        .container a {
            display: flex;
            flex-direction: row;
            justify-content: center;
            text-align: Center;
            align-items: center;
        }

        div {
            margin-left: 48%;
            font-weight: bold;

        }

        a div {
            margin-left: 10%
        }

        h3 {
            margin-left: 34%
        }

        a {
            text-decoration: none;
            color: black;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="../../">
            <h1>DhaanGo</h1>
        </a>
        <h3>Sign Up/Log In</h3>
        <form action="signup.php" method="post">
            <input type="text" name="fname" placeholder="Enter your first name" required>
            <input type="text" name="lname" placeholder="Enter your last name" required>
            <input type="number" name="number" placeholder="Enter your number" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Submit</button>
        </form>
        <br>
        <div>or</div>
        <br>
        <a href="<?php echo htmlspecialchars($client->createAuthUrl()); ?>" class="google-login-button">
            <div><img src="../../images/googlelogomain'.png" alt=""></div>
            <div>Login /SignUp with Google</div>
        </a>
    </div>
</body>

</html>