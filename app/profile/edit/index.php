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
    <link rel="stylesheet" href="../../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../src/css/style.css">
    <link rel="shortcut icon" href="../../../src/img/icon.png" type="image/x-icon">
    <title>EDIT PROFILE</title>
    <style>
        #profile-picture {
            height: 100px;
        }
    </style>
</head>
<body class="ms-3">
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue mb-0">
        <div class="container-fluid">
            <div class="navbar-item dropdown">
                <a class="navbar-brand bg-keptskin nav-link rounded color-keptskin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../../src/img/logo.png" alt="Logo Kept" id="navbar-brand">
                </a>
                <ul class="dropdown-menu dropdown-menu-start bg-keptskin">
                    <li><a class="dropdown-item" href="../../">Home</a></li>
                    <li><a class="dropdown-item" href="../../keep/">Keep</a></li>
                    <li><a class="dropdown-item" href="../../detail/">Detail</a></li>
                    <li><a class="dropdown-item" href="../../history/">Riwayat</a></li>
                    <!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
                </ul>
            </div>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
                    <a class="nav-link color-keptskin fw-bold" href="../../">FAQ</a>
					<a class="nav-link color-keptskin fw-bold" href="../../">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle" style="height: 50px;">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="../../profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="../../profile/private/">Pengaturan Privasi</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="../../logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </nav>
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
    <script src="../../../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>