<?php
// SQL-connection
$host = "127.0.0.1"; // Your SQL server
$user = "kriss"; // Your username
$pass = "Garrysmod1!"; // Your password
$db = "wol"; // Your database name

$sqlcon = mysqli_connect($host, $user, $pass, $db);

if (!$sqlcon) {
  die("MySQL connection failed.".mysqli_err($sqlcon));
}
 ?>
