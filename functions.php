<?php
//digunakan untuk mengirim email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

//membuat zona waktu jadi WIB
date_default_timezone_set('Asia/Jakarta');

// connect dengan sql server
$conn = mysqli_connect("sql209.infinityfree.com", "if0_34962067", "aITkeptflow3", "if0_34962067_keptdb");

function keepConn() {
    global $conn;
    $conn = mysqli_connect("sql209.infinityfree.com", "if0_34962067", "aITkeptflow3", "if0_34962067_keepdb");
}

function keptConn() {
    global $conn;
    $conn = mysqli_connect("sql209.infinityfree.com", "if0_34962067", "aITkeptflow3", "if0_34962067_keptdb");

}

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
function dateNow() {
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

// function untuk mengecek nomor HP
function checkHpNum($post) {
    session_start();
    global $conn;
    $hpnum = $post['hpnum'];
    $len = strlen($hpnum);
    $_SESSION['hpnum'] = $hpnum;
    
    if($hpnum[0] != '0' || $len < 10 || $len > 13) {
        alert("Nomor HP nya gak rill cuy");
        $_SESSION['hpnum'] = NULL;
        return false;
    }
    
    $query = "SELECT username FROM account WHERE hpnum = '$hpnum'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    
    if($result) {
        alert("Nomornya dah kepake. Buat Lupa Password aja di Menu Login");
        $_SESSION['hpnum'] = NULL;
        return false;
    }

    return true;
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
        $_SESSION['username'] = NULL;
        return false;
    }
    return true;
}

// function untuk mengecek ketersediaan email
function checkEmail($post) {
    session_start();
    global $conn;
    $email = strtolower($post['email']);

    // mengecek ada gak '@' di email
    if(stristr($email, '@') === false) {
        alert("Email salah");
        $_SESSION['email'] = NULL;
        return false;
    }

    $_SESSION['email'] = $email;
    
    $query = "SELECT username FROM account WHERE email = '$email'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    
    if($result) {
        alert("Email nya dah kepake. Lupa password aja kalau gak ingat yang kemarin");
        $_SESSION['email'] = NULL;
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
    $_SESSION['emailrenew'] = $_SESSION['email'];
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

// function untuk memperbarui password
function renewPassword($post) {
    session_start();
    global $conn;
    $password = $post['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_SESSION['emailrenew'];
    $query = "UPDATE account SET password = '$password' WHERE email = '$email'";
    mysqli_query($conn, $query);

    if(mysqli_affected_rows($conn) <= 0) {
        alert('Gagal wkwkwk');
        return false;
    }

    session_unset();
    return true;
}

// function untuk menambahkan seluruh data ke database
function register($session) {
    global $conn;
    session_start();
    $username = $session['username'];
    $email = $session['email'];
    $password = password_hash($session['password'], PASSWORD_DEFAULT);
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

    keepConn();

    // membuat tabel log untuk user
    $query = "CREATE TABLE {$username}_keep ( 
        `id` INT NULL DEFAULT NULL AUTO_INCREMENT , 
        `date` DATE NULL DEFAULT NULL , 
        `class` VARCHAR(31) NULL DEFAULT NULL , 
        `category` VARCHAR(31) NULL DEFAULT NULL , 
        `username` VARCHAR(31) NULL DEFAULT NULL , 
        `name` VARCHAR(64) NULL DEFAULT NULL , 
        `detail` VARCHAR(256) NULL DEFAULT NULL , 
        `value` INT NULL DEFAULT NULL , 
        PRIMARY KEY (`id`))";
    if(!mysqli_query($conn, $query)) {
        alert("error cuy");
    }

    keptConn();

    // menghapus semua variabel session
    session_unset();

    // menghentikan session
    session_destroy();
    return true;
}

// function untuk login
function login($post) {
    session_start();
    global $conn;
    $temp = strtolower($post['username']);
    $_SESSION['temp'] = $temp;
    $password = $post['password'];

    $query = "SELECT password, username FROM account WHERE username = '$temp' OR hpnum = '$temp' OR email = '$temp'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    session_unset();
    if(!$result) {
        alert("Akun ghoib. Dah daftar belum?");
        return false;
    }

    $confirmPassword = $result['password'];
    if(!password_verify($password, $confirmPassword)) {
        alert('Password salah sayang :v');
        return false;
    }
    session_start();
    $_SESSION['usernamelogin'] = $result['username'];
    $_SESSION['temp'] = NULL;
    return true;
}

// function untuk lupa password
function forgetPassword($post) {
    session_start();
    global $conn;
    $temp = $post['username'];

    $query = "SELECT password, email FROM account WHERE username = '$temp' OR hpnum = '$temp' OR email = '$temp'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if(!$result) {
        alert("Gak ada akun kek gitu");
        return false;
    }
    $email = $result['email'];
    $password = $result['password'];
    $code = strval(rand(100000,999999));
    $_SESSION['code'] = $code;
    $_SESSION['email'] = $email;
    $emailDomain = stristr($email, '@');
    $usernameLen = strlen($email) - strlen($emailDomain);
    $censoredEmail = "";
    for ($i = 0; $i < $usernameLen - 2; $i++) {
        $censoredEmail .= "*";
    }
    $_SESSION['privateEmail'] = $email[0].$email[1].$censoredEmail.stristr($email, '@');

    if(sendEmail($email, "Kode Lupa Password", "Kodenya <b>$code</b>. Gaskeun.") == true) {
        return true;
    }
}

// function untuk mengambil data dari database
function fetch($request, $username = false) {
    global $conn;
    if ($username === false) {
        session_start();
        $username = $_SESSION['usernamelogin'];
    }
    $query = "SELECT $request FROM account WHERE username = '$username'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $result = $result["$request"];
    return $result;
}

function logout() {
    session_unset();
}

?>