<?php

session_start();
$unique_id= $_SESSION['unique_id'];
$login=false;
if (isset($_SESSION['unique_id'])){
    $login=true;
}
if(!$login){
    header("location: ../../");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1.0, initial-scale=1.0">
    <title>Marketplace</title>
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

    </div>
</body>
</html>