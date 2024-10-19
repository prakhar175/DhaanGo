<?php

require "dbh.inc.php";
$unique_id=$_SESSION['unique_id'];
$query="SELECT * FROM users WHERE unique_id=:unique_id";
