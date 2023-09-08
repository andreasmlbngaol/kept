<?php
require "../functions.php";
$code = strval(100000,999999);
if(sendEmail("$code", "andreaspremium006@gmail.com") == true) {
    alert('Sukses');
    jumpTo('../index.php');
}
?>