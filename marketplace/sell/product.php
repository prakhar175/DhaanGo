<?php

session_start();

require "../../dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $unique_id = $_SESSION['unique_id'];

    // Check if the file has been uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        
        $target_dir = "uploads/"; // Directory where images will be saved
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Create directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (limit: 5MB)
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only specific image formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
            $uploadOk = 0;
        }

        // Proceed with the file upload if everything is OK
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                
                // Insert product data into the database
                try {
                    $query = "INSERT INTO products (name, price, quantity, image, unique_id, description) 
                              VALUES (:name, :price, :quantity, :image, :unique_id, :description)";
                    $stmt = $pdo->prepare($query);

                    // Bind parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':image', $target_file); // Save image path
                    $stmt->bindParam(':unique_id', $unique_id);
                    $stmt->bindParam(':description', $description);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "Product registered successfully!";
                    } else {
                        echo "Failed to register the product.";
                    }

                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, your file was not uploaded.";
        }

    } else {
        echo "No file was uploaded or there was an error uploading the file.";
    }
}
?>
