<?php
require "../../../../functions.php";
$value = $_GET['nickname'];
?>

<div id="profile-nickname">
    <form action="" method="post">
        <label for="nickname">Nama Panggilan</label><br>
        <input type="text" value="<?php echo $value ?>" id="profile-nickname-input" name="nickname" autocomplete="off">
        <button type="submit" name="submitnickname">UBAH</button>
    </form>
</div>