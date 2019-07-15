<?php
require_once("sqlcon.php");
if (isset($_GET['ip'])) {
  # Verbose?
  if (isset($_GET['verbose'])) {
    $verbose = $_GET['verbose'];
  } else {
    $verbose = 0;
  }
  $ip = mysqli_real_escape_string($sqlcon, $_GET['ip']);
  $checkifexists = "SELECT * FROM computers WHERE ip = '$ip'";
  $checkifexists = mysqli_query($sqlcon, $checkifexists);
  if ($checkifexists->num_rows > 0) {
// //$port = "80";
// //if (! $sock=@fsockopen($ip, $port, $num, $error, 0.25)) {
// if (! $shell = @exec("start /b ping $ip -n 1")) {
//   echo "<font color='red'>$shell</font>";
// } else {
//   echo "<font color='green'>$shell</font>";
// }
$shell = shell_exec('ping -c 1 -W 1 '.$ip);
if ($shell) {
  if (!strpos($shell, "Unreachable") !== false
   && !strpos($shell, "100% packet loss") !== false
   && !strpos($shell, "0 received") !== false
   && !strpos($shell, "+1 errors") !== false) {
    echo "<font color='green'><b>Online</b><br>";
    if ($verbose == 1) {
    echo "<pre style='color: green;'>$shell</pre></font>";
    }
  } else {
    echo "<font color='red'><b>Offline</b><br>";
    if ($verbose == 1) {
    echo "<pre style='color: red;'>$shell</pre></font>";
    }
  }
} else {
  echo "<font color='red'><b>Error</b> Unable to ping.</font>";
}
} else {
  die("Modified IP.");
}
} else {
  // die("No IP given.");
}

?>
