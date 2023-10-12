<?php
require "../../functions.php";
$id = fetch('id');
$registerDate = fetch('date');
$username = fetch('username');
$bio = fetch('bio');
$name = fetch('name');
$picture = fetch('picture');
$keptDay = totalDay(dateNow(), $registerDate);
?>

<!DOCTYPE html>
<html lang="en">
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

        #account-username {
            color: #E5C3A6;
        }
    </style>
</head>
<body>
    <nav id="app-header">
        <a href="../" class="app-header-list" id="app-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../keep/" class="app-header-list">KEEP</a>
        <a href="" class="app-header-list">PROFILE</a>
        <a href="../logout.php" class="app-header-list">LOGOUT</a>
    </nav>
    <br><br>
    <div id="info">
        <!-- <img src="https://drive.google.com/uc?id=14qoFeqx54p3mdI-nkMTpMqh_-JIpVIjJ" alt="Profile Picture"> -->
        <a href="../../src/img/profilepicture/<?php echo $picture ?>" target="_blank"><img src="../../src/img/profilepicture/<?php echo $picture ?>" alt="Profile Picture" id="profile-picture"></a>
        <div class="info-item"  title="This means your registration order is <?php echo $id ?>">
            <h4 class="info-item-value"><?php echo $id ?></h4>
            <p>User ID</p>
        </div>
        <div class="info-item"  title="kept Day is total day from the first time you register">
            <h4 class="info-item-value"><?php echo $keptDay ?></h4>
            <p>kept Day</p>
        </div>
    </div>
    <div id="account">    
        <h3 id="account-username"><?php echo $username ?></h3>
        <h4><?php echo $name ?></h4><br>
        <p id="bio"><?php echo $bio ?></p>
    </div>
    <form action="edit/" method="post">
        <button id="edit-profile" name="edit">Edit Profile</button>
    </form>
</body>
</html>