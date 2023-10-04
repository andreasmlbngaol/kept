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
        if(sendEmail($email, "Kode Verifikasi", codeTextHTML($code), codeTextNotHTML($code))) {
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
    <title>Buat username</title>
</head>
<body>
    <h1>Ini Halaman Daftar 2</h1>
    <form action="" method="post">
        <div>
            <label for="username">Buat username</label>
            <input type="text" name="username" id="username" autocomplete="off" value="<?php echo $_SESSION['username'] ?>" required>
        </div>
        <div>
            <label for="email">Masukin email</label>
            <input type="text" name="email" id="email" autocomplete="off" value="<?php echo $_SESSION['email'] ?>" required>
        </div>
        <div>
            <label for="password">Buat Password</label>
            <input type="password" name="password" id="password" autocomplete="off" required>
        </div>
        <div>
            <label for="confirmPassword">Ulangin Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword" autocomplete="off" required>
        </div>
        <button>Akready have an account? <a href="../login/">Sign in</a></button>
        <button type="submit" name="submit" id="submit">Lanjut</button>
    </form>
</body>
</html>