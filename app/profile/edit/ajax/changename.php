<?php
require "../../../../functions.php";
$value = $_GET['name'];
?>

<div id="profile-name">
    <form action="" method="post">
        <label for="name">Name</label><br>
        <input type="text" value="<?php echo $value ?>" id="profile-name-input" name="name" autocomplete="off">
        <button type="submit" name="submitname">SAVE</button>
    </form>
</div>