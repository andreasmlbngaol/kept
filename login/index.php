<?php
require "../functions.php";
session_start();
$_SESSION['temp'] = NULL;
if(isset($_POST['submit'])) {
    if(login($_POST) == true) {
        jumpTo("../app/index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ini Menu Login</title>
</head>
<body>
    <h1>Ini Halaman Login</h1>
    <form action="" method="post">
        <div>
            <label for="username">Username/Email/No.HP</label><br>
            <input type="text" name="username" id="username" autocomplete="off" value="<?php echo $_SESSION['temp'] ?>" required>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" autocomplete="off" required>
        </div>
        <div>
            <a href="forgetpassword.php">Anda Pikun? Lupa Password aja...</a>
        </div>
        <button type="submit" name="submit">Masuk</button>
    </form>
</body>
</html>