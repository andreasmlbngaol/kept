<?php
require "../../../../functions.php";
$value = $_GET['bio'];
?>

<div id="profile-bio">
    <form action="" method="post">
        <label for="bio">Bio</label><br>
        <input type="text" value="<?php echo $value ?>" id="profile-bio-input" name="bio" autocomplete="off">
        <button type="submit" name="submitbio">UBAH</button>
    </form>
</div>