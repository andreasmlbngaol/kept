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
    <link rel="stylesheet" href="../../style.css">
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
<body>
    <nav id="app-header">
        <a href="../" class="app-header-list" id="app-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../keep/" class="app-header-list notranslate">KEEP</a>
        <a href="../detail/" class="app-header-list">DETAIL</a>
        <a href="../history/" class="app-header-list">RIWAYAT</a>
        <a href="../profile/" class="app-header-list active"><img src="../../src/img/profilepicture/<?php echo fetch('picture') ?>" alt="Profile Picture" style="height: 50px;"></a>
        <a href="../logout.php" class="app-header-list">KELUAR</a>
    </nav>
    <br><br>
    <h1><?php echo $username ?></h1>
    <br>
    <div id="info">
        <!-- <img src="https://drive.google.com/uc?id=14qoFeqx54p3mdI-nkMTpMqh_-JIpVIjJ" alt="Profile Picture"> -->
        <a href="../../src/img/profilepicture/<?php echo $picture ?>" target="_blank"><img src="../../src/img/profilepicture/<?php echo $picture ?>" alt="Profile Picture" id="profile-picture"></a>
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
</body>
</html>