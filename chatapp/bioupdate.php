<?php

require "dbh.inc.php"; // Include your database connection file
session_start();

// Check if the user is logged in and if POST data exists
if (isset($_SESSION['unique_id']) && !empty($_POST)) {
    $user_id = $_SESSION['unique_id'];
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : null;
    $hobbies = isset($_POST['hobbies']) ? trim($_POST['hobbies']) : null;
    $book = isset($_POST['book']) ? trim($_POST['book']) : null;
    $music = isset($_POST['music']) ? trim($_POST['music']) : null;
    $tvshows = isset($_POST['tvshows']) ? trim($_POST['tvshows']) : null;
    $movies = isset($_POST['movies']) ? trim($_POST['movies']) : null;

    // Prepare update query with only non-empty fields
    $query = "UPDATE users SET ";
    $updateFields = [];
    if (!empty($bio)) {
        $updateFields[] = "bio = :bio";
    }
    if (!empty($hobbies)) {
        $updateFields[] = "hobbies = :hobbies";
    }
    if (!empty($book)) {
        $updateFields[] = "book = :book";
    }
    if (!empty($music)) {
        $updateFields[] = "music = :music";
    }
    if (!empty($tvshows)) {
        $updateFields[] = "tvshows = :tvshows";
    }
    if (!empty($movies)) {
        $updateFields[] = "movies = :movies";
    }

    // Check if any fields are to be updated
    if (!empty($updateFields)) {
        $query .= implode(", ", $updateFields);
        $query .= " WHERE unique_id = :user_id";

        // Prepare and execute the update query
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        if (!empty($bio)) {
            $stmt->bindParam(':bio', $bio);
        }
        if (!empty($hobbies)) {
            $stmt->bindParam(':hobbies', $hobbies);
        }
        if (!empty($book)) {
            $stmt->bindParam(':book', $book);
        }
        if (!empty($music)) {
            $stmt->bindParam(':music', $music);
        }
        if (!empty($tvshows)) {
            $stmt->bindParam(':tvshows', $tvshows);
        }
        if (!empty($movies)) {
            $stmt->bindParam(':movies', $movies);
        }

        if ($stmt->execute()) {
            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                echo "Success";
            } else {
                echo "No changes made"; // Optional message if no rows were updated
            }
        } else {
            echo "Error occurred, couldn't update the bio. Please try again.";
        }
    } else {
        echo "No valid fields to update."; // Optional message if no valid fields were found
    }
} else {
    echo "Invalid session or form data.";
}
?>
