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
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background: #007bff;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-size: 28px;
            font-weight: bold;
        }

        .main {
            max-width: 900px;
            margin: 30px auto;
            padding: 25px;
            background: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="file"],
        form input[type="submit"] {
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
        }

        h2 {
            margin-top: 20px;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        p {
            margin: 5px 0;
            font-size: 18px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .no-products {
            text-align: center;
            font-size: 20px;
            color: #888;
        }

        @media (max-width: 600px) {
            .main {
                padding: 15px;
            }

            h2 {
                font-size: 24px;
            }

            form input[type="text"],
            form input[type="number"] {
                font-size: 14px;
            }

            form input[type="submit"] {
                font-size: 16px;
            }
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
            $query = "SELECT * FROM products WHERE unique_id = :unique_id ORDER BY id DESC";
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
                echo "<p class='no-products'>No products found.</p>"; // Handle case with no products
            }
        } else {
            echo "<p class='no-products'>Please log in to see your products.</p>"; // Handle case with no unique_id
        }
        ?>
    </div>
</body>
</html>
