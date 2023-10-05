<?php
require "../../../functions.php";
$isincome = $_GET['isincome'];
$selector = "income";
if($isincome == "true"){
    $query = "SELECT * FROM flow WHERE class = '$selector' ORDER BY id";
} else if($isincome == "false"){
    $query = "SELECT * FROM flow WHERE class <> '$selector' ORDER BY id";
}
$result = query($query);
?>
<option value="" selected>Choose</option>
<?php foreach($result as $class) : ?>
<option value="<?php echo $class['username'] ?>"><?php echo $class['name']; ?></option>
<?php endforeach; ?>