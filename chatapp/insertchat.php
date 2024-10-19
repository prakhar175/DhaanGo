<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['unique_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated.']);
    exit;
}

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require "dbh.inc.php"; // Database connection file
    // Sanitize and validate incoming data
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = htmlspecialchars($_POST['incoming_id']);
    $messagechat = $_POST['text']; // Text message
    // echo $message;
    $img_extensions = ['jpg', 'jpeg', 'png']; // Allowed image extensions
    $statusmessage = $_POST['statusmessage'];
    if (!empty($statusmessage)) {
        $message = "Reacted to the status : " . $statusmessage;
    } else {
        $message = $messagechat;
    }
    // Check if an image file was uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmpname = $_FILES['image']['tmp_name'];
        $imgexplode = explode('.', $image);
        $imgex = strtolower(end($imgexplode));

        // Validate the image file extension
        if (in_array($imgex, $img_extensions)) {
            $newimagename = time() . '_' . $image;
            $uploadpath = "images/" . $newimagename;

            // Ensure the 'images' directory exists
            if (!file_exists("images/")) {
                mkdir("images", 0777, true);
            }

            // Move uploaded image to 'images' directory
            if (move_uploaded_file($tmpname, $uploadpath)) {
                // Insert message with image into database  
                $query = "INSERT INTO messages (outgoing_msg_id, incoming_msg_id, message) VALUES (:outgoing_id, :incoming_id, :image)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":outgoing_id", $outgoing_id, PDO::PARAM_STR);
                $stmt->bindParam(":incoming_id", $incoming_id, PDO::PARAM_STR);
                $stmt->bindParam(":image", $newimagename, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo "success";

                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload image. Please try again.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Only image files (jpg, jpeg, png) are allowed.']);
        }
    } elseif (!empty($message)) {
        // Insert text message into database if no image is uploaded

        $query = "INSERT INTO messages (outgoing_msg_id, incoming_msg_id, message) VALUES (:outgoing_id, :incoming_id, :message)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":outgoing_id", $outgoing_id, PDO::PARAM_STR);
        $stmt->bindParam(":incoming_id", $incoming_id, PDO::PARAM_STR);
        $stmt->bindParam(":message", $message, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Text message sent successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert message into database.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Either message or image is required.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>