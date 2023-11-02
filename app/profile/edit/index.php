<?php
require "../../../functions.php";
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
    <link rel="stylesheet" href="../../../src/css/cropper.min.css">
    <title>SUNTING PROFIL</title>
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
                    <a class="nav-link color-keptskin fw-bold" href="../../help/">Bantuan</a>
					<a class="nav-link color-keptskin fw-bold" href="../../report/">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle navbar-picture">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="../../profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="../../plan/">Ubah Rencana</a></li>
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
                <img src="../../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle" style="height: 100px;">
                <br>
                <label for="upload" role="button" id="upload-button">Ubah Foto Profil</label><br>
                <input type="file" id="upload" name="picture" accept=".jpg, .jpeg, .png, .webp"><br>
            </form>
        </div>            
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Potong Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close" class="close-button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">  
                                <!--  default image where we will set the src via jquery-->
                                <img id="image">
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="preview"></div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-button" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="crop">Ubah</button>
                </div>
            </div>
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
    <script src="../../../src/script/bootstrap.bundle.min.js"></script>
    <script src="../../../src/script/jquery-3.5.1.min.js"></script>  
    <script src="../../../src/script/cropper.min.js"></script>
    <script src="script.js"></script>
    <script>
        var bs_modal = $('#modal');
        var image = document.getElementById('image');
        var cropper,reader,file;


        $("body").on("change", "#upload", function(e) {
            var files = e.target.files;
            // alert(e.target.type);
            // console.log(files[0].type);
            var done = function(url) {
                image.src = url;
                // console.log(url);
                bs_modal.modal('show');
            };

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        bs_modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'none'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        $(".close-button").click(function() {
            bs_modal.modal('hide');
        });

        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    //alert(base64data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "ajax/changephoto.php",
                        data: {image: base64data},
                        success: function(data) { 
                            bs_modal.modal('hide');
                            alert("Ubah Foto Profil Berhasil. Tekan \"Ctrl + F5\" untuk me refresh halaman");
                            window.location.reload(true);
                        }
                    });
                };
            });
        });
    </script>
</body>
</html>