<?php 
  require_once("sqlcon.php");
  require_once("json.php");
  include_once("bootstrap.php");
?>
<div class="container">
<form action="" method="POST">
<table class='table-default'>
    <tr><th>Hostname</th><td><input type='text' name='hostname' class='form-control'></td></tr>
    <tr><th>IP</th><td><input type='text' name='ip' class='form-control'></td><tr>
    <tr><th>MAC-address</th><td><input type='text' name='mac' class='form-control'></td></tr>
    </table>
    <hr>
    <input type='submit' class='btn btn-secondary' value='Save'>
    <a href='index.php' class='btn btn-secondary'>Back</a>
</form>

<?php
# create
    if (isset($_POST['hostname']) && isset($_POST['mac']) && isset($_POST['ip'])) {
      $hostname = mysqli_real_escape_string($sqlcon, $_POST['hostname']);
      $mac = mysqli_real_escape_string($sqlcon, $_POST['mac']);
      $ip = mysqli_real_escape_string($sqlcon, $_POST['ip']);
      # Check if ip or mac exists
      $checkduplicate = "SELECT * FROM computers WHERE ip = '$ip' OR mac = '$mac'";
      $checkduplicate = mysqli_query($sqlcon, $checkduplicate);
      if ($checkduplicate->num_rows > 0) {
        die("IP or MAC address already exists.");
      }
      $createcomputer = "INSERT INTO computers (hostname, ip, mac) VALUES ('$hostname', '$ip', '$mac')";
      $createcomputer = mysqli_query($sqlcon, $createcomputer);
      if (!$createcomputer) {
        echo "<div class='alert alert-danger'>Failed to create computer.</div>";
      } else {
        echo "<div class='alert alert-success'>Computer <b>$hostname</b> created!</div>";
      }
    }
?>