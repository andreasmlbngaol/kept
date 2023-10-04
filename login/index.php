<?php
require "../functions.php";
session_start();
$_SESSION['temp'] = NULL;
if(isset($_POST['submit'])) {
    if(login($_POST) == true) {
        jumpTo("../app/");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN IN</title>
</head>
<body>
    <nav id="home-header">
        <a href="" class="home-header-list" id="home-header-logo-container"><img src="../src/img/logo.png" alt=""  id="home-header-logo"></a>
        <a href="" class="home-header-list">FAQ'S</a>
        <a href="" class="home-header-list">PRODUCT</a>
    </nav>
    <h1>SIGN IN</h1>
    <form action="" method="post">
        <div>
            <input type="text" name="username" id="username" autocomplete="off" value="<?php echo $_SESSION['temp'] ?>" placeholder="Email/Username" required>
        </div>
        <div>
            <input type="password" name="password" id="password" autocomplete="off" placeholder="Password" required>
        </div>
        <p>Are you new here? <a href="../register/">Sign Up</a></p>
        <p>Can't Remember Your Password? <a href="../forgetpassword/">Forget Password</a></p>
        <button type="submit" name="submit">SIGN IN</button>
    </form>
</body>
</html>