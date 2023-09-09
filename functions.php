<?php
//digunakan untuk mengirim email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

//membuat zona waktu jadi WIB
date_default_timezone_set('Asia/Jakarta');

// connect dengan sql server
$conn = mysqli_connect("sql209.infinityfree.com", "if0_34962067", "PMLbfabCfgyBhf", "if0_34962067_keptdb");

// function untuk membuat script dengan cepat
function script($script) {
    echo "
<script>
    $script;
</script>
    ";
}

// function untuk redirect ke halaman lain
function jumpTo($destination) {
    script('window.location.href = "'.$destination.'";');
}

// function untuk menampilkan alert
function alert($alert) {
    echo "
<script>
    window.alert('$alert')
</script>
";}

// function mengambil data
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// function untuk menampilkan tanggal dalam Tahun-bulan-hari
function showDate() {
    echo date('Y-m-d');
}


// function untuk menampilkan tanggal dan waktu
function showDateTime() {
    echo date('Y-m-d H:i:s');
}


// function untuk menampilkan  waktu
function showTime() {
    echo date('H:i:s');
}

// function untuk mengecek ketersediaan username
function checkUsername($post) {
    session_start();
    global $conn;
    $username = strtolower(stripslashes($post['username']));
    $_SESSION['username'] = $username;
    
    $query = "SELECT username FROM account WHERE username = '$username'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));

    if($result) {
        alert("Usernamenya dah kepake. Ayo dong cari yang lain yang kreatif");
        return false;
    }
    return true;
}

// function untuk mengecek ketersediaan email
function checkEmail($post) {
    session_start();
    global $conn;
    $email = strtolower($post['email']);
    $_SESSION['email'] = $email;
    
    $query = "SELECT username FROM account WHERE email = '$email'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    
    if($result) {
        alert("Email nya dah kepake. Lupa password aja kalau gak ingat yang kemarin");
        return false;
    }
    return true;
}

// function template pesan kode verifikasi dalam HTML
function codeTextHTML($code) {
    return "Kode Verifikasinya ini ya:<br><b>$code</b>";
}

// function template pesan kode verifikasi non HTML
function codeTextNotHTML($code) {
    return "Kode verifikasinnya ini ya: $code";
}

// function untuk mengirimkan email
function sendEmail($to, $subject, $textHTML, $textNotHTML = "") {
    $mail = new PHPMailer(true);
    
    // server
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'keptflow@gmail.com';
    $mail->Password   = 'ukgaqxlmcmdvyloa';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // penerima
    $mail->setFrom('keptflow@gmail.com', 'kept');
    $mail->addAddress("$to");
    $mail->addReplyTo('keptflow@gmail.com', 'kept');

    // lampiran
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    // isi
    $mail->isHTML(true);
    $mail->Subject = "$subject";
    $mail->Body    = "$textHTML";
    $mail->AltBody = "$textNotHTML";

    // kirim
    if($mail->send() == true) {
        return true;
    }
    return false;
}

// function untuk menyamakan code
function checkCode($post) {
    session_start();
    $code = $_SESSION['code'];
    $confirmCode = $post['confirmCode'];
    if($code != $confirmCode) {
        alert("Kodenya salah. Padahal tinggal copas lo");
        return false;
    }
    return true;
}

// function untuk menyamakan password
function checkPassword($post) {
    session_start();
    $password = $post['password'];
    $_SESSION['password'] = $password;
    $confirmPassword = $post['confirmPassword'];
    if($password !== $confirmPassword) {
        alert('Kata sandinya gak sama. Ulangin deh');
        return false;
    }
    return true;
}

// function untuk menambahkan seluruh data ke database
function register($session) {
    global $conn;
    session_start();
    $username = $session['username'];
    $email = $session['email'];
    $password = $session['password'];
    $hpnum = $session['hpnum'];
    $name = $session['name'];
    $nickname = $session['nickname'];
    $birthday = $session['birthday'];

    // memasukkan data ke database
    $query = "INSERT INTO account VALUES(NULL, '$username', '$email', '$password', '$hpnum', '$name', '$nickname', '$birthday', 1, 0)";
    mysqli_query($conn, $query);

    if(mysqli_affected_rows($conn) <= 0) {
        alert('Gagal wkwkwk');
        return false;
    }

    // mengirim data lengkap nya ke email
    sendEmail($email, "Informasi Akun", "Username: <br>
    $username <br>
    <br>
    Email: <br>
    $email <br>
    <br>
    Password: <br>
    $password <br>
    <br>
    No. HP: <br>
    $hpnum <br>
    <br>
    Nama Lengkap: <br>
    $name <br>
    <br>
    Nama Panggilan: <br>
    $nickname <br>
    <br>
    Tanggal lahir: <br>
    $birthday");

    // menghapus semua variabel session
    session_unset();

    // menghentikan session
    session_destroy();
    return true;
}



function login($post) {
    global $conn;
    $username = strtolower($post['username']);
    $password = $post['password'];

    $query = "SELECT password FROM account WHERE username = '$username'";
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
    $query = "SELECT * FROM account WHERE username = '$username'";
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
?>