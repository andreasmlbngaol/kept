<?php
date_default_timezone_set('Asia/Jakarta');
$conn = mysqli_connect("sql209.infinityfree.com", "if0_34962067", "PMLbfabCfgyBhf", "if0_34962067_keptdb");

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
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $name = $_POST['name'];
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $quest = $_POST['quest'];
    $ans = $_POST['ans'];
    $clue = $_POST['clue'];

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

?>