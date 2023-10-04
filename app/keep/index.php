<?php
require "../../functions.php";
if(isset($_POST['submit'])) {
    script("console.log(".$_POST['nominal'].");");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Untuk Memasuk-masukkan</title>
    <style>
        .input {
            width: 200px;
        }
    </style>
</head>
<body>
    <form action="" method="post" style="display: flex">
        <div class="input">
            <label for="input-isincome">Masukin apa Ngeluarin?:</label><br>
            <select name="input-isincome" id="input-isincome" required>
                <option value="" selected>Pilih</option>
                <option value="true">Pemasukan</option>
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
            <label for="nominal">Nominal:</label><br>
            <input type="number" name="nominal" id="nominal" required>
        </div>
        <button type="submit" id="submit" name="submit">Masukin Mas!</button>
    </form>
    <script src="script.js"></script>
</body>
</html>