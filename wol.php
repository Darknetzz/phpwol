<?php
require_once("sqlcon.php");
if (isset($_GET['mac'])) {
  $mac = mysqli_real_escape_string($sqlcon, $_GET['mac']);
  $checkmac = "SELECT * FROM computers WHERE mac = '$mac'";
  $checkmac = mysqli_query($sqlcon, $checkmac);
  if ($checkmac->num_rows > 0) {
  $wake = exec("wakeonlan $mac");
  if ($wake) {
  echo "<div class='alert alert-success'><!--WOL packet sent to $mac<br>-->
  <i>$wake</i></div>";
} else {
  echo "<div class='alert alert-danger'>Failed to send WOL packet. Did you do <i><a href='?do=installwol'>apt-get install wakeonlan</a></i>?<br>
  <i>$wake</i></div>";
}
} else {
  echo "<div class='alert alert-danger'>Modified MAC-address.</div>";
}
}
?>
