<?php
require "../../../../functions.php";
$value = $_GET['username'];
?>

<div id="profile-username">
    <form action="" method="post">
        <label for="username">Username</label><br>
        <input type="text" value="<?php echo $value ?>" id="profile-username-input" name="username" autocomplete="off">
        <button type="submit" name="submitusername">SAVE</button>
    </form>
</div>