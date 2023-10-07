<?php
//digunakan untuk mengirim email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

//membuat zona waktu jadi WIB
date_default_timezone_set('Asia/Jakarta');

$keptPassword = "";
$keptUsername = "root";
$keptHost = "localhost";
$keptdb = "keptdb";
$keepdb = "keepdb";

// connect dengan sql server
$conn = mysqli_connect($keptHost, $keptUsername, $keptPassword, $keptdb);

function keepConn() {
    global $conn;
    global $keptPassword;
    global $keptUsername;
    global $keptHost;
    global $keptdb;
    global $keepdb;
    $conn = mysqli_connect($keptHost, $keptUsername, $keptPassword, $keepdb);
}

function keptConn() {
    global $conn;
    global $keptPassword;
    global $keptUsername;
    global $keptHost;
    global $keptdb;
    global $keepdb;
    $conn = mysqli_connect($keptHost, $keptUsername, $keptPassword, $keptdb);

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
    global $conn;
    $hpnum = $post['hpnum'];
    $len = strlen($hpnum);
    $_SESSION['hpnum'] = $hpnum;
    
    if($hpnum[0] != '0' || $len < 10 || $len > 13) {
        alert("Phone number invalid. Start with \"08\"");
        $_SESSION['hpnum'] = NULL;
        return false;
    }
    
    $query = "SELECT username FROM account WHERE hpnum = '$hpnum'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    
    if($result) {
        alert("Phone number is used.");
        $_SESSION['hpnum'] = NULL;
        return false;
    }

    return true;
}

// function untuk mengecek ketersediaan username
function checkUsername($post) {
    global $conn;
    $username = strtolower(stripslashes($post['username']));
    $_SESSION['username'] = $username;
    
    $query = "SELECT username FROM account WHERE username = '$username'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));

    if($result) {
        alert("Username is not available. Be more creative!");
        $_SESSION['username'] = NULL;
        return false;
    }
    return true;
}

// function untuk mengecek ketersediaan email
function checkEmail($post) {
    global $conn;
    $email = strtolower($post['email']);

    // mengecek ada gak '@' di email
    if(stristr($email, '@') === false) {
        alert("Email invalid");
        $_SESSION['email'] = NULL;
        return false;
    }

    $_SESSION['email'] = $email;
    
    $query = "SELECT username FROM account WHERE email = '$email'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    
    if($result) {
        alert("Email is already used.");
        $_SESSION['email'] = NULL;
        return false;
    }
    return true;
}

// function template pesan kode verifikasi dalam HTML
function codeTextHTML($code) {
    return "Verification Code:<br><b>$code</b><br>Keep it secret from anyone besides you to avoid issues.";
}

// function template pesan kode verifikasi non HTML
function codeTextNotHTML($code) {
    return "Verification Code: $code . Keep it secret from anyone besides you to avoid issues.";
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
        alert("The Code is wrong.");
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
        alert('The password doesn\'t match. Try again!');
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
        alert('We\'re sorry, we have some error. We really appreciate it if you are willing to report this bug');
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
        alert('We\'re sorry, we have some error. We really appreciate it if you are willing to report this bug');
        return false;
    }

    // mengirim data lengkap nya ke email
    sendEmail($email, "Account Information", "Username: <br>
    $username <br>
    <br>
    Email: <br>
    $email <br>
    <br>
    Phone Number: <br>
    $hpnum <br>
    <br>
    Full Name: <br>
    $name <br>
    <br>
    Nickname: <br>
    $nickname <br>
    <br>
    Birthday Date: <br>
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
    global $conn;
    $temp = strtolower($post['username']);
    $_SESSION['temp'] = $temp;
    $password = $post['password'];

    $query = "SELECT password, username FROM account WHERE username = '$temp' OR hpnum = '$temp' OR email = '$temp'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    session_abort();
    if(!$result) {
        alert('Your username is not in our database. Please sign up first.');
        return false;
    }
    
    $confirmPassword = $result['password'];
    if(!password_verify($password, $confirmPassword)) {
        alert('Incorrect Password. Forget password if you forget :)');
        return false;
    }
    session_unset();
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
        alert("Your username is not in our database. Please sign up first.");
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

    if(sendEmail($email, "Forget Password Code", "The Code: <b>$code</b>. We suggest you to write your new password somewhere this time.") == true) {
        return true;
    }
}

// function untuk mengambil data dari database
function fetch($request, $username = false) {
    global $conn;
    if ($username === false) {
        session_start();
        $username = $_SESSION['usernamelogin'];
        session_abort();
    }
    $query = "SELECT $request FROM account WHERE username = '$username'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $result = $result["$request"];
    return $result;
}

function logout() {
    session_unset();
}

function monthName($birthday) {
    $month = $birthday[5].$birthday[6];
    $date = $birthday[8].$birthday[9];
    $year = $birthday[0].$birthday[1].$birthday[2].$birthday[3];
    switch ($month) {
        case '01':
            $name = 'January';
            break;
        case '02':
            $name = 'February';
            break;
        case '03':
            $name = 'March';
            break;
        case '04':
            $name = 'April';
            break;
        case '05':
            $name = 'May';
            break;
        case '06':
            $name = 'June';
            break;
        case '07':
            $name = 'July';
            break;
        case '08':
            $name = 'August';
            break;
        case '09':
            $name = 'September';
            break;
        case '10':
            $name = 'October';
            break;
        case '11':
            $name = 'November';
            break;
        case '12':
            $name = 'December';
            break;
    }
    return $date.' '.$name.' '.$year;
}
?>