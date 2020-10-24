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