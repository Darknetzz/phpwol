<?php 
  require_once("sqlcon.php");
  require_once("json.php");
  # sanitize
  $id = mysqli_real_escape_string($sqlcon, $_GET['id']);
  $getcomputer = "SELECT * FROM computers WHERE id = '$id'";
  $getcomputer = mysqli_query($sqlcon, $getcomputer);
?>