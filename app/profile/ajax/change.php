<?php
require "../../../functions.php";
$value = $_GET['value'];
$default = fetch($value);
session_start();
$_SESSION['value'] = $value;
if($value == "birthday") {
    $type = 'date';
} else {
    $type = 'text';
}
switch($value) {
    case 'name':
        $fieldName = "Full Name";
        break;
    case 'nickname':
        $fieldName = "Nickname";
        break;
    case 'email':
        $fieldName = "Email";
        break;
    case 'hpnum':
        $fieldName = "Phone Number";
        break;
    case 'username':
        $fieldName = "Username";
        break;
    case 'birthday':
        $fieldName = "Birthday";
        break;
}
?>

<form action="" method="post">
    <label for="<?php echo $value ?>"><?php echo $fieldName ?>: </label>
    <input type="<?php echo $type ?>" id="<?php echo $value ?>" name="<?php echo $value ?>" value="<?php echo $default ?>" autocomplete="off" required>
    <button type="submit" id="submit" name="submit">SAVE</button>
</form>