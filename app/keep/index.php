<?php
require "../../functions.php";
$today = dateNow();
if(fetch('id') == NULL) {
    jumpTo('../../');
}
if(isset($_POST['submit'])) {
    if(insertKeep($_POST)) {
        alert('Success');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">
    <title>keep</title>
    <style>
        .input {
            width: 200px;
        }
    </style>
</head>
<body>
    <nav id="app-header">
        <a href="../" class="app-header-list" id="app-header-logo-container"><img src="../../src/img/logo.png" alt="logo.png"  id="app-header-logo"></a>
        <a href="../keep/" class="app-header-list notranslate active">KEEP</a>
        <a href="../detail/" class="app-header-list">DETAIL</a>
        <a href="../history/" class="app-header-list">RIWAYAT</a>
        <a href="../profile/" class="app-header-list"><img src="../../src/img/profilepicture/<?php echo fetch('picture') ?>" alt="Profile Picture" style="height: 50px;"></a>
        <a href="../logout.php" class="app-header-list">KELUAR</a>
    </nav>
    <br><br>
    <h1>Keep</h1>
    <br>
    <form action="" method="post">
        <div class="input" id="input-date">
            <label for="date">Tanggal:</label><br>
            <input type="date" name="date" id="date" value="<?php echo $today?>" required>
        </div>

        <div class="input">
            <label for="input-isincome">Tipe:</label><br>
            <select name="input-isincome" id="input-isincome" required>
                <option value="" selected>Pilih</option>
                <option value="true">Pendapatan</option>
                <option value="false">Pengeluaran</option>
            </select>
        </div>

        <div class="input">
            <label for="input-class">Kategori:</label><br>
            <select name="input-class" id="input-class" required>
                <option value="" selected>Pilih</option>
            </select>
        </div>

        <div class="input" id="input-type">
            <label for="nominal">Jumlah (Rp.):</label><br>
            <input type="number" name="nominal" id="nominal" required>
        </div>
        
        <div class="input" id="input-desc">
            <label for="desc">Komentar:</label><br>
            <input type="text" name="desc" id="desc" autocomplete="off" required>
        </div>
        <button type="submit" id="submit" name="submit">KEEP</button>
    </form>
    <script src="script.js"></script>
</body>
</html>