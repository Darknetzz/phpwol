<?php
  require_once("sqlcon.php");
  require_once("json.php");
  include_once("bootstrap.php");
?>

<div class='container'>
<?php
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($sqlcon, $_GET['id']);
    $select = "SELECT * FROM computers WHERE id = '$id'";
    $select = mysqli_query($sqlcon, $select);
    if ($select->num_rows === 1) {
        if (!isset($_GET['confirm'])) {
        while ($row = $select->fetch_assoc()) {
        echo "<div class='alert alert-danger'>Are you sure you want to delete computer <b>$row[hostname]</b> ($row[ip])?</div>
        <a href='?id=$row[id]&confirm=1' class='btn btn-danger'>Confirm</a> <a href='index.php' class='btn btn-secondary'>Cancel</a>";
        }
    } elseif ($_GET['confirm'] == 1) {
        $delete = "DELETE FROM computers WHERE id = '$id'";
        $delete = mysqli_query($sqlcon, $delete);
        if ($delete) {
            die("<div class='alert alert-success'>Computer with ID $id was deleted.</div>
            <script>
            setTimeout(function(){
                window.location.href = 'index.php';
             }, 3000);
            </script>");
        } else {
            echo "<div class='alert alert-danger'>Failed to delete computer</div>";
        }
    }
    } else {
        echo "<div class='alert alert-danger'>This computer does not exist, or it matches more than one.</div>";
    }
}
echo "<hr><a href='index.php' class='btn btn-secondary'>Back</a>";
?>
</div>