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
    <link rel="shortcut icon" href="../../../src/img/icon.png" type="image/x-icon">
    <link href="../../../src/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../src/css/style.css">
    <link rel="stylesheet" href="../../../src/css/croppie.css">
    <script src="../../../src/script/jquery-3.5.1.min.js"></script>  
    <script src="../../../src/script/croppie.js"></script>
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
        <div class="justify-content-start" id="upload-input"></div>
        <div id="upload-result-container"></div>
        <div id="uploaded-input"></div>
        <div id="profile-picture-change">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" id="upload" name="picture" accept=".jpg, .jpeg, .png, .webp"><br>
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
    <script type="text/javascript">

        $('#upload').on('change', function () { 
            $uploadCrop = $('#upload-input').croppie({
                enableExif: true,
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                },
                boundary: {
                    width: 300,
                    height: 300
                }
            });
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
                
            }
            button = '<button class="upload-result">Potong Gambar</button>';
            $("#upload-result-container").html(button);
            reader.readAsDataURL(this.files[0]);
            $('.upload-result').on('click', function (ev) {
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    $.ajax({
                        url: "ajax/changephoto.php",
                        type: "POST",
                        data: {"image":resp},
                        success: function (data) {
                            html = '<img style="margin: 20px;" src="' + resp + '" />';
                            $("#uploaded-input").html(html);
                        }
                    });
                });
            });
        });


        
    </script>
</body>
</html>