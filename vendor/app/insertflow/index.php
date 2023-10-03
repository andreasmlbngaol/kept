<?php
    
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Untuk Memasuk-masukkan</title>
</head>
<body>
    <form action="" method="post">
        <div>
            <label for="input-isincome">Mau ngapain dek1?:</label>
            <select name="input-isincome" id="input-isincome">
                <option value="" disabled selected>Pilih</option>
                <option value="true">Pemasukan</option>
                <option value="false">Pengeluaran</option>
            </select>
        </div>

        <div>
            <label for="input-class">Mau ngapain dek2?:</label>
            <select name="input-class" id="input-class">
            </select>
        </div>

        <div id="input-type">
            <label for="input-name">Mau ngapain dek3?:</label>
            <select name="input-name" id="input-name">
            </select>
        </div>
    </form>
    <script src="script.js"></script>
</body>
</html>