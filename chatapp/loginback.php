<?php

require "dbh.inc.php";
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
if (!empty($email) && !empty($password)) {
    $logout_time = time();
    $logout_time_mod = date("Y-m-d H:i:s", $logout_time); // Format suitable for MySQL datetime
    $date = new DateTime();
    $hoursadd = 3;
    $minutesadd = 30;
    $date->modify("+$hoursadd hours +$minutesadd minutes");
    $formattedDate = $date->format('Y-m-d H:i:s');

    $query = "SELECT * FROM users_main WHERE email=:email AND password=:password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $_SESSION['unique_id'] = $result['unique_id'];
        // echo $result['unique_id'];
        // echo "<br>";

        $querytime="UPDATE users_main SET login_time=:formattedDate WHERE email=:email";
        $stmttime = $pdo->prepare($querytime);
        $stmttime->bindParam(":formattedDate",$formattedDate);
        $stmttime->bindParam(":email",$email);
        $stmttime->execute();
        echo "success";

    } else {
        echo "Email or Password is incorrect";


    }
} else {
    echo " email or password is empty";
}

