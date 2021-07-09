<?php 
  require_once("sqlcon.php");
  require_once("json.php");
  include_once("bootstrap.php");
?>
<div class="container">
<h1>Wake on lan</h3>
  <p>What server do you want to wake up?</p>
  <p><button onClick="updateAll();">Update</button>
  <?php echo $DarkThemeOnOff; ?>
  <?php echo $VerbosePingOnOff; ?>
<div id='wol'>
<?php
if (isset($_GET['do']) && $_GET['do'] == "installwol") {
  $_GET['do'] = "";
  unset($_GET['do']);
  $shell = shell_exec('sudo apt install wakeonlan');
  if ($shell) {
    echo "<div class='alert alert-success'>Wakeonlan was installed!</div>";
  } else {
    echo "<div class='alert alert-danger'>Wakeonlan was not installed. You must do it manually.";
  }
}
?>
</div>
    <table class="table table-default">
      <tr><th>Hostname</th>
          <th>IP</th>
          <th>MAC-address</th>
          <th>Status</th>
          <th>Action</th>
      </tr>
      <?php
      $getcomputers = "SELECT * FROM computers ORDER BY ip ASC";
      $getcomputers = mysqli_query($sqlcon, $getcomputers);
      if ($VerbosePing == true) {
        echo "<script>console.log('VerbosePing set to TRUE')</script>";
        $urlAppend = "&verbose=1";
      } else {
        echo "<script>console.log('VerbosePing set to FALSE')</script>";
        $urlAppend = "&verbose=0";
      }
      $scriptappend = ""; # Set the scriptappend variable, avoids undefined error.
      while ($row = $getcomputers->fetch_assoc()) {
        echo "<tr>
        <td><a href='edit.php?id=$row[id]'>$row[hostname]</a></td>
        <td>$row[ip]</td>
        <td>$row[mac]</td>
        <td id='status$row[id]'></td>
        <td><a href='#' onClick='wake$row[id]();' class='btn btn-sm btn-secondary'>Wake</a> <a href='delete.php?id=$row[id]' class='btn btn-sm btn-danger'>Delete</a></td>
        </tr>";
        echo "
        <script>
        function serverChecker$row[id](){
        $('#status$row[id]').html('Checking...');
        $(document).ready(function() {
          function checkserver$row[id]() {
          $.ajax({
            type: 'GET',
            dataType: 'html',
            url: 'serverchecker.php?ip=$row[ip]$urlAppend',
            async: true,
            success:
            function(data) {
              return $('#status$row[id]').html(data);
            }
          });
        }
        checkserver$row[id]();
        });
        }

        setInterval(serverChecker$row[id](), 5000);
        </script>

        <script>
        function wake$row[id](){
        $('#wol').html(\"<div class='alert alert-info'>Sending magic packet to $row[ip]...</div>\");
        $(document).ready(function() {
          function wol$row[id]() {
          $.ajax({
            type: 'GET',
            dataType: 'html',
            url: 'wol.php?mac=$row[mac]',
            async: true,
            success:
            function(data) {
              return $('#wol').html(data);
            }
          });
        }
        wol$row[id]();
        });
        }
        </script>";
        $scriptappend = "serverChecker$row[id]();
        ".$scriptappend;
      }
      echo "<script>
      function updateAll() {
      $scriptappend
      }
    //   setInterval(function (){
    //   updateAll();  // Something you want delayed.
    // }, 3000); // How long do you want the delay to be (in milliseconds)?
      </script>";
      ?>
    </table>
      <a href="add.php" class="btn btn-secondary">New device</a>
</div>
