<?php
require "../../functions.php";
$id = fetch('id');
$registerDate = fetch('date');
$username = fetch('username');
$bio = fetch('bio');
$name = fetch('name');
$nickname = fetch('nickname');
$picture = fetch('picture');
$keptDay = totalDay(dateNow(), $registerDate) + 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/style.css">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <title>PROFILE</title>
    <style>
        #info {
            display: flex;
        }

        .info-item-value {
            text-align: center;
        }

        .info-item {
            margin: 10px;
        }

        #profile-picture {
            height: 100px;
        }

        #bio {
            background-color: #E5C3A6;
            width: 500px;
            height: 250px;
            color: #15253f;
        }

        #account-name {
            color: #E5C3A6;
        }
    </style>
</head>
<body class="ms-3">
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue mb-0">
        <div class="container-fluid">
            <div class="navbar-item dropdown">
                <a class="navbar-brand bg-keptskin nav-link rounded color-keptskin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../src/img/logo.png" alt="Logo Kept" id="navbar-brand">
                </a>
                <ul class="dropdown-menu dropdown-menu-start bg-keptskin">
                    <li><a class="dropdown-item" href="../">Home</a></li>
                    <li><a class="dropdown-item" href="../keep/">Keep</a></li>
                    <li><a class="dropdown-item" href="../detail/">Detail</a></li>
                    <li><a class="dropdown-item" href="../history/">Riwayat</a></li>
                    <!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
                </ul>
            </div>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
                    <a class="nav-link color-keptskin fw-bold" href="../">FAQ</a>
					<a class="nav-link color-keptskin fw-bold" href="../">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle" style="height: 50px;">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="../profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="../profile/private/">Pengaturan Privasi</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="../logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </nav>
    <h1><?php echo $username ?></h1>
    <br>
    <div id="info">
        <!-- <img src="https://drive.google.com/uc?id=14qoFeqx54p3mdI-nkMTpMqh_-JIpVIjJ" alt="Profile Picture"> -->
        <a href="../../src/img/profilepicture/<?php echo $picture ?>" target="_blank"><img class="border rounded-circle" src="../../src/img/profilepicture/<?php echo $picture ?>" alt="Profile Picture" id="profile-picture"></a>
        <div class="info-item"  title="Urutan Pendaftaran kamu adalah <?php echo $id ?>">
            <h4 class="info-item-value"><?php echo $id ?></h4>
            <p>User ID</p>
        </div>
        <div class="info-item"  title="kept Day adalah total hari sejak kamu join kept">
            <h4 class="info-item-value"><?php echo $keptDay ?></h4>
            <p>kept Day</p>
        </div>
    </div>
    <div id="account">    
        <h3 id="account-name"><?php echo $name ?></h3>
        <h4><?php echo $nickname ?></h4><br>
        <h3>Bio:</h3>
        <p id="bio"><?php echo $bio ?></p>
    </div>
    <form action="edit/" method="post">
        <button id="edit-profile" name="edit">Edit Profil</button>
    </form>
    <script src="../../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>