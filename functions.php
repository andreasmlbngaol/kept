<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
date_default_timezone_set('Asia/Jakarta');

$conn = mysqli_connect("sql209.infinityfree.com", "if0_34962067", "PMLbfabCfgyBhf", "if0_34962067_keptdb");

//Load Composer's autoloader
// function for making script
function script($script) {
    echo "
<script>
    $script;
</script>
    ";
}

function jumpTo($destination) {
    script('window.location.href = "'.$destination.'";');
}

// function for showing alert
function alert($alert) {
    echo "
<script>
    window.alert('$alert')
</script>
";}

// function for query
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function showDate() {
    echo date('Y-m-d');
}

function showDateTime() {
    echo date('Y-m-d H:i:s');
}

function showTime() {
    echo date('H:i:s');
}

function checkUsernameAndPassword($post) {
    session_start();
    global $conn;
    # stripslashes mencegah garis miring
    $username = strtolower(stripslashes($post['username']));
    $_SESSION['username'] = $username;
    $password = $post['password'];
    $_SESSION['password'] = $password;
    $confirmPassword = $post['confirmPassword'];

    // cek username 
    $query = "SELECT username FROM account_list WHERE username = '$username'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if($result) {
        alert("Username tidak tersedia");
        return false;
    }
    
    // cek konfirmasi password
    if($password !== $confirmPassword) {
        alert("Password tidak sesuai");
        return false;
    }    

    return true;
}

function register($post) {
    global $conn;
    session_start();
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $name = $post['name'];
    $nickname = $post['nickname'];
    $email = strtolower($post['email']);
    $birthday = $post['birthday'];
    $quest = $post['quest'];
    $ans = strtolower($post['ans']);
    $clue = $post['clue'];

    // mengecek email
    $query = "SELECT username FROM account_list WHERE email = '$email'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if($result) {
        alert("Email udah kepake");
        return false;
    }

    // memasukkan data ke database
    $query = "INSERT INTO account_list VALUES(NULL, '$username', '$name', '$nickname', '$password', '$email', '$birthday', '$quest', '$ans', '$clue', 1, 0)";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function login($post) {
    global $conn;
    $username = strtolower($post['username']);
    $password = $post['password'];

    $query = "SELECT password FROM account_list WHERE username = '$username'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if(!$result) {
        alert("username tidak tersedia");
        return false;
    }

    $confirmPassword = $result['password'];
    if($password !== $confirmPassword) {
        alert('Password salah sayang');
        return false;
    }
    session_start();
    $_SESSION['username'] = $username;
    return true;
}

function fetchUserData($username) {
    global $conn;
    $query = "SELECT * FROM account_list WHERE username = '$username'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $_SESSION['id'] == $result['id'];
    $_SESSION['name'] = $result['name'];
    $_SESSION['nickname'] = $result['nickname'];
    $_SESSION['password'] = $result['password'];
    $_SESSION['birthday'] = $result['birthday'];
    $_SESSION['quest'] = $result['quest'];
    $_SESSION['ans'] = $result['ans'];
    $_SESSION['clue'] = $result['clue'];
    $_SESSION['isnew'] = $result['isnew'];
    $_SESSION['ispremium'] = $result['ispremium'];
}

function sendEmail($code, $to) {
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
    //Server settings
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'keptflow@gmail.com';                     //SMTP username
$mail->Password   = 'ukgaqxlmcmdvyloa';                               //SMTP password
$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//Recipients
$mail->setFrom('keptflow@gmail.com', 'kept');
$mail->addAddress("$to");               //Name is optional
$mail->addReplyTo('keptflow@gmail.com', 'kept');

//Attachments
// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Kode Verifikasi';
$mail->Body    = "Kode Verifikasi Anda adalah <b>$code</b>";
$mail->AltBody = "TKode Verifikasi Anda adalah $code";

$mail->send();
return true;
}

?>