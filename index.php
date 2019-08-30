<?php require_once("sqlcon.php"); ?>
<?php
 # Set default settings
 $DarkTheme = false;
 $VerbosePing = false;
 # Get settings from JSON file.
 $jsonfile = "settings.json";
 if (file_exists($jsonfile)) {
   echo "<script>console.log('$jsonfile found')</script>";
   $json = json_decode(file_get_contents($jsonfile), true);
   # For later use, to update settings:
   # file_put_contents($jsonfile, json_encode($json));
   # Construct write to json function
   function writeToJSON($jsonfile, $array) {
     file_put_contents($jsonfile, json_encode($array));
   }
   # Check if settings are being edited
   if (isset($_GET['verboseping'])) {
     if ($_GET['verboseping'] == 0) {
       $json['VerbosePing'] = false;
       writeToJSON($jsonfile, $json);
     } elseif ($_GET['verboseping'] == 1) {
       $json['VerbosePing'] = true;
       writeToJSON($jsonfile, $json);
     }
   } elseif (isset($_GET['darkmode'])) {
     if ($_GET['darkmode'] == 0) {
       $json['DarkTheme'] = false;
       writeToJSON($jsonfile, $json);
     } elseif ($_GET['darkmode'] == 1) {
       $json['DarkTheme'] = true;
       writeToJSON($jsonfile, $json);
     }
   }
 } else {
   echo "<script>console.log('Settings JSON file not found, using defaults')</script>";
 }
 if (!isset($DarkTheme) || !isset($VerbosePing)) {
   # Error 4 - bad formatted JSON - just make sure you don't put a "," at the last line
   die("Something is wrong with your settings... ".json_last_error());
 }
 # Get the settings
 $DarkTheme = $json['DarkTheme'];
 $DarkThemeOnOff = ($DarkTheme == true) ? "<p>Dark mode <a href='?darkmode=1'><b>ON</b></a> <a href='?darkmode=0'>OFF</a></p>" : "<p>Dark mode <a href='?darkmode=1'>ON</a> <a href='?darkmode=0'><b>OFF</b></a></p>";
 $VerbosePing = $json['VerbosePing'];
 $VerbosePingOnOff = ($VerbosePing == true) ? "<p>Verbose ping <a href='?verboseping=1'><b>ON</b></a> <a href='?verboseping=0'>OFF</a></p>" : "<p>Verbose ping <a href='?verboseping=1'>ON</a> <a href='?verboseping=0'><b>OFF</b></a></p>";

 
  # Set dark theme
  if ($DarkTheme == true) {
    echo "<body style='background:black;'><!-- Dark theme on -->";
  } elseif ($DarkTheme == false) {
    echo "<body style='background:white;'><!-- Dark theme off -->";
  }
 ?>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<title>Wake-on-lan</title>

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
          <th>Wake</th>
      </tr>
      <?php
      $getcomputers = "SELECT * FROM computers";
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
        <td>$row[hostname]</td>
        <td>$row[ip]</td>
        <td>$row[mac]</td>
        <td id='status$row[id]'></td>
        <td><a href='#' onClick='wake$row[id]();'>Wake</a></td>
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

</div>
