<?php
session_start();
require "../functions.php";
$_SESSION['name'] = NULL;
$_SESSION['nickname'] = NULL;
$_SESSION['birthday'] = NULL;
$_SESSION['hpnum'] = NULL;
if(isset($_POST['submit'])) {
    session_start();
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['nickname'] = $_POST['nickname'];
    $_SESSION['birthday'] = $_POST['birthday'];
    if(checkHpNum($_POST)) {
        jumpTo('createusername.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pribadi</title>
</head>
<body>
    <h1>Ini Halaman Daftar 1</h1>
    <form action="" method="post">
        <div>
            <label for="name">Nama Lengkap</label><br>
            <input type="text" id="name" name="name" autocomplete="off" value="<?php echo $_SESSION['name'] ?>" required>
        </div>
        <div>
            <label for="nickname">Nama Panggilan</label><br>
            <input type="text" id="nickname" name="nickname" autocomplete="off" value="<?php echo $_SESSION['nickname'] ?>" required>
        </div>
        <div>
            <label for="hpnum">No. HP:</label><br>
            <input type="text" id="hpnum" name="hpnum" autocomplete="off" placeholder="Contoh: 081234567890" value="<?php echo $_SESSION['hpnum'] ?>" required>
        </div>
        <div>
            <label for="birthday">Tanggal Lahir</label><br>
            <input type="date" id="birthday" name="birthday" autocomplete="off" value="<?php echo $_SESSION['birthday'] ?>" required>
        </div>
        <button type="submit" name="submit" id="submit">Lanjut</button>
    </form>
</body>
</html>