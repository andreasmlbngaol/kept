<?php
require "../../../../functions.php";
$value = $_GET['name'];
?>

<div id="profile-name">
    <form action="" method="post">
        <label for="name">Nama</label><br>
        <input type="text" value="<?php echo $value ?>" id="profile-name-input" name="name" autocomplete="off" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
        <button type="submit" name="submitname">UBAH</button>
    </form>
</div>