<?php
require "../../functions.php";
if(isset($_POST['submit'])) {
    if($_POST['newPlan'] == "70") {
        $needs = 70;
        $wants = 20;
        $saving = 10;
    } else if($_POST['newPlan'] == "50") {
        $needs = 50;
        $wants = 30;
        $saving = 20;
    } else {
        $needs = $_POST['needs'];
        $wants = $_POST['wants'];
        $saving = $_POST['saving'];
    }
    if(($needs + $wants + $saving) !== 100){
        alert('Jumlahnya harus 100%. Jangan sampai ada dana ghoib');
    } else if($needs < 45) {
        alert('Batas minimum untuk kebutuhan adalah 45%');
    } else if($needs > 85) {
        alert('Batas maksimum untuk kebutuhan adalah 85%');
    } else if($wants < 10) {
        alert('Batas minimum untuk keinginan adalah 10%. Jangan lupa healing');
    } else if($wants > 45) {
        alert('Batas maksimum untuk keinginan adalah 45%. Kurangi healingnya');
    } else if($saving < 5) {
        alert('Batas minimum untuk tabungan adalah 5%');
    } else {
        if(updatePlan($needs, $wants, $saving)){
            alert('Rencanamu sudah dibuat. Selamat datang di kept');
            jumpTo('../');
        }
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
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/style.css">
    <title>NEW ACCOUNT</title>
</head>
<body class="ms-3 text-center">
    <h1 class="jdlstartplan">NEW ACCOUNT</h1>
    <p>Ini adalah halaman untuk memasukkan rencana finansial kamu. Kamu dapat merubahnya satu bulan sekali.</p>
    <p>Rekomendasi kami:<br> <br>
        Anak kos: <br>Kebutuhan 70%, Keinginan 20%, Tabungan 10% <br>
        Tinggal Bersama Orang Tua: <br>Kebutuhan 50%, Keinginan 30%, Tabungan 20%
    </p>
    <form action="" method="post">
        <div class="new">
            <label for="new-plan">Rencanamu</label><br>
            <select name="newPlan" id="new-plan" required>
                <option value="70" selected>70 : 20 : 10</option>
                <option value="50">50 : 30 : 20</option>
                <option value="custom">Custom</option>
            </select>
        </div><br>
        <div id="new-plan-custom">
            
        </div>
        <button type="submit" name="submit" id="submit">ENTER</button>
    </form>
    <script src="script.js"></script>
    <script src="../../src/script/bootstrap.bundle.min.js"></script>
</body>
</html>