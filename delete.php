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
        $delete = "DELETE FROM computers WHERE id = '$id'";
        $delete = mysqli_query($sqlcon, $delete);
        if ($delete) {
            echo "<div class='alert alert-success'>Computer with ID $id was deleted.</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to delete computer</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>This computer does not exist, or it matches more than one.</div>";
    }
    echo "<hr><a href='index.php' class='btn btn-secondary'>Back</a>";
}
?>
</div>