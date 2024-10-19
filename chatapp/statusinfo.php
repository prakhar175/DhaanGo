<?php
require "dbh.inc.php"; // Ensure the database connection file is included
session_start();

$unique_id = $_SESSION['unique_id'];

// Check if user is authenticated
if (!isset($unique_id)) {
    echo "User not authenticated";
    exit; // Stop script execution if user is not authenticated
}

// Ensure the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve status message from POST data
    $statusmessage = isset($_POST['statusmessage']) ? $_POST['statusmessage'] : null;
    $statusnote = isset($_POST['statusmessage1']) ? $_POST['statusmessage1'] : null;
    $message = !empty($statusmessage) ? $statusmessage : $statusnote;
    $color = isset($_POST['color']) ? $_POST['color'] : null; // Retrieve color from POST data

    // Check if a status message is provided and not empty
    
        // Handle image upload if an image file is present
        if (!empty($_FILES['image']['name'])) {
            $img_extensions = ["jpeg", "jpg", "png"];
            $image = $_FILES['image']['name'];
            $tmpname = $_FILES['image']['tmp_name'];
            $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            // Validate image format
            if (in_array($image_extension, $img_extensions)) {
                $newimagename = time() . '_' . basename($image);
                $uploadpath = "images/" . $newimagename;

                // Ensure 'images' directory exists or create it
                if (!file_exists("images/")) {
                    mkdir("images", 0777, true);
                }

                // Move uploaded image to 'images' directory
                if (move_uploaded_file($tmpname, $uploadpath)) {
                    // Insert message with image into database
                    $query = "INSERT INTO status (unique_id, status, statusmessage, color) VALUES (:unique_id, :image, :message, :color)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":unique_id", $unique_id, PDO::PARAM_STR);
                    $stmt->bindParam(":image", $newimagename, PDO::PARAM_STR);
                    $stmt->bindParam(":message", $message, PDO::PARAM_STR);
                    $stmt->bindParam(":color", $color, PDO::PARAM_STR);
                    if ($stmt->execute()) {
                        echo "success";
                    } else {
                        echo "Failed to insert image and status into database";
                    }
                } else {
                    echo "Failed to upload image. Please try again.";
                }
            } else {
                echo "Invalid image format. Please upload JPEG, JPG, or PNG";
            }
        } else {
            // Insert message without image into database
            $query = "INSERT INTO status (unique_id, status, statusmessage, color) VALUES (:unique_id, NULL, :message, :color)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":unique_id", $unique_id, PDO::PARAM_STR);
            $stmt->bindParam(":message", $message, PDO::PARAM_STR);
            $stmt->bindParam(":color", $color, PDO::PARAM_STR);
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Failed to insert status into database";
            }
        }
    // }
} else {
    echo "Invalid request method";
}
?>
