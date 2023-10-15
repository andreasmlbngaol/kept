<?php
require "../functions.php";
session_start();
$_SESSION['username'] = NULL;
$_SESSION['email'] = NULL;
if(isset($_POST['submit'])) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['email'] = $_POST['email'];
    if(checkUsername($_POST) && checkEmail($_POST) && checkPassword($_POST)) {
        $email = $_SESSION['email'];
        $code = strval(rand(10000, 99999));
        $_SESSION['code'] = $code;
        if(sendEmail($email, "Verification Code", codeTextHTML($code), codeTextNotHTML($code))) {
            jumpTo("codeverification/");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <title>SIGN UP</title>
</head>
<body>
    <nav id="home-header">
        <a href="../" class="home-header-list" id="home-header-logo-container"><img src="../src/img/logo.png" alt="logo.png"  id="home-header-logo"></a>
        <a href="" class="home-header-list">FAQ'S</a>
        <a href="" class="home-header-list">PRODUCT</a>
    </nav>
    <h1>Daftar</h1>
    <form action="" method="post">
        <div>
            <input type="text" name="email" id="email" autocomplete="off" value="<?php echo $_SESSION['email'] ?>" placeholder="Email" required>
        </div>
        <div>
            <input type="text" name="username" id="username" autocomplete="off" value="<?php echo $_SESSION['username'] ?>" placeholder="Username" required>
        </div>
        <div>
            <input type="password" name="password" id="password" autocomplete="off" placeholder="Password" required>
        </div>
        <div>
            <input type="password" name="confirmPassword" id="confirmPassword" autocomplete="off" placeholder="Repeat Password" required>
        </div>
        <p>Sudah Punya Akun? <a href="../login/">Masuk</a></p>
        <button type="submit" name="submit" id="submit">SELANJUTNYA</button>
    </form>
</body>
</html>