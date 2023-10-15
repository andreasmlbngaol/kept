<?php
require "../../../functions.php";
if(isset($_POST['submitpicture'])) {
    if(uploadPicture($_FILES)) {
        alert('Profile Picture is changed');
    }
}

$id = fetch('id');
$name = fetch('name');
$nickname = fetch('nickname');
$username = fetch('username');
$bio = fetch('bio');
$picture = fetch('picture');

if(isset($_POST['submitname'])) {
    if($_POST['name'] != $name) {
        changeName($_POST);
        $name = fetch('name');
    }
}

if(isset($_POST['submitnickname'])) {
    if($_POST['nickname'] != $nickname) {
        changeNickname($_POST);
        $nickname = fetch('nickname');
    }
}

if(isset($_POST['submitusername'])) {
    if($_POST['username'] != $username) {
        if(checkUsername($_POST)) {
            changeUsername($_POST);
            $username = fetch('username');
        }
    }
}

if(isset($_POST['submitbio'])) {
    if($_POST['bio'] != $name) {
        changeBio($_POST);
        $bio = fetch('bio');
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style.css">
    <link rel="shortcut icon" href="../../../src/img/icon.png" type="image/x-icon">
    <title>EDIT PROFILE</title>
    <style>
        #profile-picture {
            height: 100px;
        }
    </style>
</head>
<body>
    <nav id="app-header">
        <a href="../../" class="app-header-list" id="app-header-logo-container"><img src="../../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../../keep/" class="app-header-list notranslate">KEEP</a>
        <a href="../../detail/" class="app-header-list">DETAIL</a>
        <a href="../../history/" class="app-header-list">RIWAYAT</a>
        <a href="../../profile/" class="app-header-list"><img src="../../../src/img/profilepicture/<?php echo fetch('picture') ?>" alt="Profile Picture" style="height: 50px;"></a>
        <a href="../../logout.php" class="app-header-list">KELUAR</a>
    </nav>
    <br><br>
    <h1>Edit Profil</h1>
    <br>
    <a href="../">KEMBALI</a><br><br>
    <div>
        <!-- <img src="https://drive.google.com/uc?id=14qoFeqx54p3mdI-nkMTpMqh_-JIpVIjJ" alt="Profile Picture"> -->
        <a href="../../../src/img/profilepicture/<?php echo $picture ?>" target="_blank"><img src="../../../src/img/profilepicture/<?php echo $picture ?>" alt="Profile Picture" id="profile-picture"></a><br>
        <div id="profile-picture-change">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" id="profile-picture-input" name="picture"><br>
                <button type="submit" id="submitpicture" name="submitpicture">Ubah Foto Profil</button>
            </form>
        </div>            
    </div>
    <br>
    <div>
        <div id="profile-username">
            <label for="username">Username</label><br>
            <input type="text" value="<?php echo $username ?>" id="profile-username-input">
        </div>
        <br>
        <div id="profile-name">
            <label for="name">Nama</label><br>
            <input type="text" value="<?php echo $name ?>" id="profile-name-input">
        </div>
        <br>
        <div id="profile-nickname">
            <label for="nickname">Nama Panggilan</label><br>
            <input type="text" value="<?php echo $nickname ?>" id="profile-nickname-input">
        </div>
        <br>
        <div id="profile-bio">
            <label for="bio">Bio</label><br>
            <input type="text" value="<?php echo $bio ?>" id="profile-bio-input">
        </div>
    </div>
    <br>
    <div>
        <a href="../private/email/">Ubah Email</a>
        <br>
        <a href="../private/password/">Ubah Password</a>
    </div>
    <script src="script.js"></script>
</body>
</html>