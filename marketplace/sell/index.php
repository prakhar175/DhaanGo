<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <style>
        /* CSS styles for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background: #007bff;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-size: 24px;
        }

        .main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="file"],
        form input[type="submit"] {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
        }

        h2 {
            margin-top: 20px;
            color: #007bff;
        }

        p {
            margin: 5px 0;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <a href="../../">DhaanGo</a>
    </header>
    <div class="main">
        <form action="product.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" placeholder="Product Price" required>
            <input type="number" name="quantity" placeholder="Enter the quantity of the product you want to sell" required>
            <input type="text" name="description" placeholder="Enter the description of the product" required>
            <input type="file" name="image" required>
            <input type="submit" value="Register">
        </form>

        <?php
        session_start(); // Ensure the session is started to access unique_id
        require "../../dbh.inc.php";

        // Check if the unique_id is set in the session
        if (isset($_SESSION['unique_id'])) {
            $unique_id = $_SESSION['unique_id'];
            $query = "SELECT * FROM products WHERE unique_id = :unique_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':unique_id', $unique_id);
            $stmt->execute();
            $result = $stmt->fetchAll();

            // Loop through and display product information
            if ($result) {
                foreach ($result as $row) {
                    echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                    echo "<p>Price: Rs. " . htmlspecialchars($row['price']) . "</p>";
                    echo "<p>Quantity: " . htmlspecialchars($row['quantity']) . "</p>";
                    echo "<p>Description: " . htmlspecialchars($row['description']) . "</p>";
                    echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'><br><br>";
                }
            } else {
                echo "<p>No products found.</p>"; // Handle case with no products
            }
        } else {
            echo "<p>Please log in to see your products.</p>"; // Handle case with no unique_id
        }
        ?>
    </div>
</body>
</html>
