<?php
require "../../../../functions.php";
$value = $_GET['username'];
?>

<div id="profile-username">
    <form action="" method="post">
        <label for="username">Username</label><br>
        <input type="text" value="<?php echo $value ?>" id="profile-username-input" name="username" autocomplete="off" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
        <button type="submit" name="submitusername">UBAH</button>
    </form>
</div>