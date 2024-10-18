<?php



session_abort();
session_unset();
session_destroy();

if (!isset($_SESSION['unique_id'])){
    header("location: ../");
}
else{
    header("Location: index.php");
}