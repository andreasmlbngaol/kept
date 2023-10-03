<?php
require "../../../functions.php";
$isincome = $_GET['isincome'];
$selector = "income";
if($isincome == "true"){
    $query = "SELECT * FROM flowcategory WHERE class = '$selector' ORDER BY id";
} else if($isincome == "false"){
    $query = "SELECT * FROM flowcategory WHERE class <> '$selector' ORDER BY id";
}
$result = query($query);
script("console.log(".var_dump($result).")");
?>
<option value="" selected>Pilih</option>
<?php foreach($result as $class) : ?>
<option value="<?php echo $class['category'] ?>"><?php echo $class['name']; ?></option>
<?php endforeach; ?>