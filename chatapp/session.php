<?php
session_start();
require "../dbh.inc.php";
echo $_SESSION['unique_id'];
