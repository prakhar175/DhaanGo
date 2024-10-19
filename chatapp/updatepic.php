<?php
require "dbh.inc.php";
session_start();

if (!isset($_SESSION['unique_id'])) {
    die("User is not logged in.");
}

$unique_id = $_SESSION['unique_id'];

if (isset($_FILES['image']['name']) && $_FILES['image']['name'] !== '') {
    $image_name = $_FILES['image']['name'];
    $tmpname = $_FILES['image']['tmp_name'];
    $explode = explode('.', $image_name);
    $imgex = strtolower(end($explode)); // Ensure extension is lowercase
    $allowed_extensions = ['jpeg', 'jpg', 'png'];

    if (in_array($imgex, $allowed_extensions)) {
        $newimagename = time() . "_" . basename($image_name); // Use basename to prevent directory traversal
        $uploadPath = "images/" . $newimagename;

        if (move_uploaded_file($tmpname, $uploadPath)) {
            $query = "UPDATE users_main SET img = :img WHERE unique_id = :unique_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":img", $newimagename); // Use new image name
            $stmt->bindParam(":unique_id", $unique_id, PDO::PARAM_INT);

            try {
                $stmt->execute();
                echo json_encode(["status" => "success"]); // Return JSON response
            } catch (PDOException $e) {
                echo json_encode(["status" => "error", "message" => $e->getMessage()]); // Return JSON error message
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to move uploaded file."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid file extension."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No image uploaded."]);
}
?>
