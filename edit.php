<?php 
  require_once("sqlcon.php");
  require_once("json.php");
  include_once("bootstrap.php");
  ?>
<br>
<div class="container">
  <?php
  # sanitize
  $id = mysqli_real_escape_string($sqlcon, $_GET['id']);
  $getcomputer = "SELECT * FROM computers WHERE id = '$id'";
  $getcomputer = mysqli_query($sqlcon, $getcomputer);
    while ($row = $getcomputer->fetch_assoc()) {
    echo "
    <form action='?id=$row[id]' method='POST'>
    <table class='table-default'>
    <tr><th>Hostname</th><td><input type='text' name='hostname' value='$row[hostname]' class='form-control'></td></tr>
    <tr><th>IP</th><td><input type='text' name='ip' value='$row[ip]' class='form-control'></td><tr>
    <tr><th>MAC-address</th><td><input type='text' name='mac' value='$row[mac]' class='form-control'></td></tr>
    </table>
    <hr>
    <input type='submit' class='btn btn-secondary' value='Save'>
    <a href='index.php' class='btn btn-secondary'>Back</a>
    <hr>
    <a href='delete.php?id=$row[id]' class='btn btn-danger'>Delete</a>
    </form>";
    }

    # change
    if (isset($_POST['hostname']) && isset($_POST['mac']) && isset($_POST['ip'])) {
      $hostname = mysqli_real_escape_string($sqlcon, $_POST['hostname']);
      $mac = mysqli_real_escape_string($sqlcon, $_POST['mac']);
      $ip = mysqli_real_escape_string($sqlcon, $_POST['ip']);
      $updatecomputer = "UPDATE computers SET hostname = '$hostname', ip = '$ip', mac = '$mac' WHERE id = '$id'";
      $updatecomputer = mysqli_query($sqlcon, $updatecomputer);
      if (!$updatecomputer) {
        echo "<div class='alert alert-danger'>Failed to update computer.</div>";
      } else {
        echo "<div class='alert alert-success'>Computer <b>$hostname</b> updated!</div>";
      }
    }
?>
</div>