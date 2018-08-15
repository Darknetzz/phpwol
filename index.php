<?php require_once("sqlcon.php"); ?>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<title>Wake-on-lan</title>

<div class="container">
<h1>Wake on lan</h3>
  <p>What server do you want to wake up?</p>
  <p><button onClick="updateAll();">Update</button>
<div id='wol'></div>
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
            url: 'serverchecker.php?ip=$row[ip]',
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
      </script>";
      ?>
    </table>

</div>
