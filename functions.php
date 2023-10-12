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
    return date('Y-m-d');
}


// function untuk menampilkan tanggal dan waktu
function showDateTime() {
    echo date('Y-m-d H:i:s');
}


// function untuk menampilkan  waktu
function showTime() {
    echo date('H:i:s');
}

function totalDay($date1, $date2) {
    $diff = abs(strtotime($date2) - strtotime($date1));
    $day = (int) floor($diff / (60 * 60 * 24));
    return $day;
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
    session_start();
    $email = strtolower($post['email']);

    // mengecek ada gak '@' di email
    if(stristr($email, '@') === false) {
        alert("Email invalid");
        $_SESSION['email'] = NULL;
        session_abort();
        return false;
    }

    $_SESSION['email'] = $email;
    
    $query = "SELECT username FROM account WHERE email = '$email'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    
    if($result) {
        alert("Email is already used.");
        $_SESSION['email'] = NULL;
        session_abort();
        return false;
    }
    session_abort();
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
    session_abort();
    return true;
}

// function untuk menyamakan password
function checkPassword($post) {
    session_start();
    $password = $post['password'];
    $_SESSION['password'] = $password;
    $confirmPassword = $post['confirmPassword'];
    if($password !== $confirmPassword) {
        alert('Different Password. Try again!');
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
    $username = $session['username'];
    $email = $session['email'];
    $password = password_hash($session['password'], PASSWORD_DEFAULT);
    $name = $session['name'];
    $nickname = $session['nickname'];
    $birthday = $session['birthday'];
    $registerDate = dateNow();

    // memasukkan data ke database
    $query = "INSERT INTO account VALUES(NULL, '$registerDate', '$username', '$email', '$password', '$name', '$nickname', '$birthday', 1, 0, 0, NULL, 'icon.png')";
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

function verifyPassword($password, $confirmPassword) {
    if(!password_verify($password, $confirmPassword)) {
        alert('Incorrect Password :)');
        return false;
    }
    return true;
}

// function untuk login
function login($post) {
    global $conn;
    $temp = strtolower($post['username']);
    $_SESSION['temp'] = $temp;
    $password = $post['password'];

    $query = "SELECT password, username, id FROM account WHERE username = '$temp' OR email = '$temp'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    session_abort();
    if(!$result) {
        alert('Your username is not in our database. Please sign up first.');
        return false;
    }
    
    $confirmPassword = $result['password'];
    if(!verifyPassword($password, $confirmPassword)) {
        return false;
    }
    session_unset();
    session_start();
    $_SESSION['loginId'] = $result['id'];
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
function fetch($request, $table = 'account', $id = false) {
    global $conn;
    if ($id === false) {
        session_start();
        $id = $_SESSION['loginId'];
        session_abort();
    }
    $query = "SELECT $request FROM $table WHERE id = '$id'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $result = $result["$request"];
    return $result;
}

function logout() {
    session_unset();
}

function dateDate($date) {
    return $date[8].$date[9];
}

function dateMonth($date) {
    $month = $date[5].$date[6];
    $name = NULL;
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
        return $name;
    }
    
    function dateYear($date) {
        return $date[0].$date[1].$date[2].$date[3];
    }

    function showDate($date) {
        $dateDate = dateDate($date);
        $dateMonth = dateMonth($date);
        $dateYear = dateYear($date);
        if($dateDate[0] == '0') {
            $dateDate = $dateDate[1];
        }
        echo $dateDate.' '.$dateMonth.' '.$dateYear;
    }

    function money($money) {
        return number_format($money, 0, ',', '.');
    }

    function percentage($percentage) {
        return number_format($percentage, 2, ',', '.');
    }
    
    function totalIncome($db) {
    global $conn;
    $today = dateNow();
    $dateMonth = dateMonth($today);
    $query = "SELECT * FROM $db WHERE class='income'";
    $values = query($query);
    $total = 0;
    foreach ($values as $value) {
        if(dateMonth($value['date']) == $dateMonth) {
            $total += (int) $value['value'];
        }
    }
    return $total;
}

function totalSpending($db) {
    global $conn;
    $today = dateNow();
    $dateMonth = dateMonth($today);
    $query = "SELECT * FROM $db WHERE class='spending'";
    $values = query($query);
    $total = 0;
    foreach ($values as $value) {
        if(dateMonth($value['date']) == $dateMonth) {
            $total += (int) $value['value'];
        }
    }
    return $total;
}

function additionalIncome($db) {
    global $conn;
    $today = dateNow();
    $dateMonth = dateMonth($today);
    $query = "SELECT * FROM $db WHERE class='income' AND category='additional' AND username='additional'";
    $values = query($query);
    $total = 0;
    foreach ($values as $value) {
        if(dateMonth($value['date']) == $dateMonth) {
            $total += (int) $value['value'];
        }
    }
    return $total;
}

function routineIncome($db) {
    global $conn;
    $today = dateNow();
    $dateMonth = dateMonth($today);
    $query = "SELECT * FROM $db WHERE class='income' AND category='routine' AND username='routine'";
    $values = query($query);
    $total = 0;
    foreach ($values as $value) {
        if(dateMonth($value['date']) == $dateMonth) {
            $total += (int) $value['value'];
        }
    }
    return $total;
}

function additionalIncomeToday($db) {
    global $conn;
    $today = dateNow();
    $dateDate = dateDate($today);
    $dateMonth = dateMonth($today);
    $query = "SELECT * FROM $db WHERE class='income' AND category='additional' AND username='additional'";
    $values = query($query);
    $total = 0;
    foreach ($values as $value) {
        if((dateDate($value['date']) == $dateDate) AND (dateMonth($value['date']) == $dateMonth)) {
            $total += (int) $value['value'];
        }
    }
    return $total;
}

function needsSpending($db) {
    global $conn;
    $today = dateNow();
    $dateMonth = dateMonth($today);
    $query = "SELECT * FROM $db WHERE class='spending' AND category='needs'";
    $values = query($query);
    $total = 0;
    foreach ($values as $value) {
        if(dateMonth($value['date']) == $dateMonth) {
            $total += (int) $value['value'];
        }
    }
    return $total;
}

function listSpending($list, $db) {
    global $conn;
    $today = dateNow();
    $dateMonth = dateMonth($today);
    $result = [];
    foreach($list as $item) {
        $query = "SELECT * FROM $db WHERE class='spending' AND username='$item'";
        $values = query($query);
        $total = 0;
        foreach ($values as $value) {
            if(dateMonth($value['date']) == $dateMonth) {
                $total += (int) $value['value'];
            }
        }
        array_push($result, $total);
    }
    return $result;
}

function wantsSpending($db) {
    global $conn;
    $today = dateNow();
    $dateMonth = dateMonth($today);
    $query = "SELECT * FROM $db WHERE class='spending' AND category='wants'";
    $values = query($query);
    $total = 0;
    foreach ($values as $value) {
        if(dateMonth($value['date']) == $dateMonth) {
            $total += (int) $value['value'];
        }
    }
    return $total;
}

function categoryList($identifier, $value) {
    global $conn;
    $query = "SELECT * FROM flow WHERE $identifier = '$value'";
    $result = query($query);
    return $result;
}

function listItem($identifier, $value, $info) {
    $tempList = array();
    $tempCategories = categoryList($identifier, $value);
    foreach ($tempCategories as $category) {
        if(!in_array($category[$info], $tempList)) {
            array_push($tempList, $category[$info]);
        }
    }
    return $tempList;
}

function changeName($post) {
    global $conn;
    $id = fetch('id');
    $name = $post['name'];
    $query = "UPDATE account SET name = '$name' WHERE id = $id";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        alert('Failed');
        return false;
    }
    return true;
}

function changeUsername($post) {
    global $conn;
    $id = fetch('id');
    $oldTable = fetch('username').'_keep';
    $username = strtolower(stripslashes($post['username']));
    $query = "UPDATE account SET username = '$username' WHERE id = $id";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        alert('Failed');
        return false;
    }

    $newTable = $username.'_keep';
    $query = "RENAME TABLE $oldTable TO $newTable";
    keepConn();
    if(!mysqli_query($conn, $query)){
        alert('Failed');
        keptConn();
        return false;
    }
    keptConn();
    return true;
}

function changeBio($post) {
    global $conn;
    $id = fetch('id');
    $bio = $post['bio'];
    $query = "UPDATE account SET bio = '$bio' WHERE id = $id";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        return false;
    }
    return true;
}

function insertKeep($post) {
    global $conn;
    $date = $post['date'];
    if($post['input-isincome'] == 'true'){
        $class = "income";
    } else {
        $class = "spending";
    }
    $username = $post['input-class'];
    $query = "SELECT category, name FROM flow WHERE username = '$username'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $category = $result['category'];
    $nominal = (int) $post['nominal'];
    if($nominal <= 0) {
        alert('Invalid Nominal');
        return false;
    }
    $name = $result['name'];
    $desc = $post['desc'];
    $table = fetch('username').'_keep';
    $query = "INSERT INTO $table VALUES(NULL, '$date', '$class', '$category', '$username', '$name', '$desc', $nominal)";
    keepConn();
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        alert('Failed');
        return false;
    }
    keptConn();
    return true;
}

function uploadPicture($files) {
    global $conn;
    $id = fetch('id');
    $maxSize = 1572864;
    $maxSizeMB = $maxSize/(1024 * 1024);
    $pictureName = $files['picture']['name'];
    $pictureSize = $files['picture']['size'];
    $pictureError = $files['picture']['error'];
    $pictureDir = $files['picture']['tmp_name'];
    if($pictureError === 4) {
        alert('Upload image first! :)');
        return false;
    }

    $validPictureExt = ['jpg', 'jpeg', 'png'];
    $pictureExt = explode('.', $pictureName);
    $pictureExt = strtolower(end($pictureExt));

    if(!in_array($pictureExt, $validPictureExt)) {
        alert('Only upload jpg, jpeg, or png');
        return false;
    }

    if($pictureSize > $maxSize) {
        alert("Your file is too big. Max size is $maxSizeMB");
        return false;
    }

    $pictureName = uniqid().'.'.$pictureExt;
    if(!move_uploaded_file($pictureDir, '../../../src/img/profilepicture/'.$pictureName)) {
        alert('Sorry, we have some error. We really appreciate it if you are willing to report this bug');
        return false;
    }
    $query = "UPDATE account SET picture = '$pictureName' WHERE id = $id";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        alert('Sorry, we have some error. We really appreciate it if you are willing to report this bug');
        return false;
    }
    return true;
}

function changePassword($newPassword) {
    global $conn;
    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $id = fetch('id');

    $query = "UPDATE account SET password = '$newPassword' WHERE id = $id";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        alert('Sorry, we have some error. We really appreciate it if you are willing to report this bug');
        return false;
    }
    return true;
}

function changeEmail($newEmail) {
    global $conn;
    $id = fetch('id');

    $query = "UPDATE account SET email = '$newEmail' WHERE id = $id";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        alert('Sorry, we have some error. We really appreciate it if you are willing to report this bug');
        return false;
    }
    return true;
}
?>