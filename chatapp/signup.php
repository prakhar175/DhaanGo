<?php
require "dbh.inc.php";
session_start();

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

// Image Upload
if (isset($_FILES['image'])) {
    $imagename = $_FILES['image']['name'];
    $tmpname = $_FILES['image']['tmp_name'];
    $imgexplode = explode('.', $imagename);
    $imgex = strtolower(end($imgexplode));
    $extensions = ['jpeg', 'jpg', 'png'];
    
    if (in_array($imgex, $extensions)) {
        $newimgname = time() . '_' . $imagename; // Adding timestamp to make it unique
        $uploadPath = "images/" . $newimgname; // Specify the upload directory
        
        // Check if the directory exists, if not, create it
        if (!file_exists("images/")) {
            mkdir("images/");
        }
        
        if (!move_uploaded_file($tmpname, $uploadPath)) {
            echo "Failed to move uploaded file.";
            exit();
        }
    } else {
        echo "Please select a valid image file (JPEG, JPG, PNG).";
        exit();
    }
} else {
    echo "Please select an image file.";
    exit();
}

// Check for duplicate email
$query = "SELECT * FROM users_main WHERE email = :email OR (fname = :fname AND lname = :lname)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':fname', $fname);
$stmt->bindParam(':lname', $lname);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    if ($result['email'] == $email) {
        echo "Email already exists.";
    } elseif ($result['fname'] == $fname && $result['lname'] == $lname) {
        echo "Name already exists.";
    }
    exit(); // Stop execution if email or name already exists
}  

// Hash the password before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$status = "Active now";
$randomid = rand(time(), 10000000);
$lastse = "Active";

// Insert the user into the database
$query = "INSERT INTO users_main (unique_id, fname, lname, email, password, img, status, lastse) VALUES (:randomid, :fname, :lname, :email, :hashedPassword, :newimgname, :status, :lastse)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':randomid', $randomid);
$stmt->bindParam(':fname', $fname);
$stmt->bindParam(':lname', $lname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':hashedPassword', $hashedPassword);
$stmt->bindParam(':newimgname', $newimgname);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':lastse', $lastse);

if ($stmt->execute()) {
    $_SESSION['unique_id'] = $randomid;
    echo "User registered successfully.";
} else {
    echo "An unknown error occurred. Please try again.";
}
?>
