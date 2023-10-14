<?php
require "../../../functions.php";
$plan = $_GET['newPlan'];
if($plan == 'custom') {
?>
<form action="" method="post">
    <div>
        <label for="needs">Kebutuhan:</label><br>
        <input type="number" name="needs" id="needs" placeholder="Angka tanpa Persen" required>
    </div>
    <br>
    <div>
        <label for="needs">Keinginan:</label><br>
        <input type="number" name="wants" id="wants" placeholder="Angka tanpa Persen" required>
    </div>
    <br>
    <div>
        <label for="needs">Tabungan:</label><br>
        <input type="number" name="saving" id="saving" placeholder="Angka tanpa Persen" required>
    </div>
    <br>
</form>

<?php } ?>