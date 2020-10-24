<?php 
  require_once("sqlcon.php");
  require_once("json.php");
  # sanitize
  $id = mysqli_real_escape_string($sqlcon, $_GET['id']);
  $getcomputer = "SELECT * FROM computers WHERE id = '$id'";
  $getcomputer = mysqli_query($sqlcon, $getcomputer);
    while ($row = $getcomputer->fetch_assoc()) {
    echo "
    <table class='table-default'>
    <tr><th>Hostname</th><th>IP</th><th>MAC-address</th></th></tr>
    <tr>
        <td><input type='text' name='hostname' value='$row[hostname]' class='form-control'></td>
        <td><input type='text' name='ip' value='$row[ip]' class='form-control'></td>
        <td><input type='text' name='mac' value='$row[mac]' class='form-control'></td>
    </table>";
    }

?>