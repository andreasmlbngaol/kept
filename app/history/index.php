<?php
require "../../functions.php";
if(fetch('id') == NULL) {
    jumpTo('../../');
}
$table = fetch('username').'_keep';
keepConn();
if(isset($_POST['delete'])) {
    $transactionId = $_POST['delete'];
    $query = "DELETE FROM $table WHERE id = $transactionId";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) <= 0) {
        alert('We\'re sorry, we have some error. We really appreciate it if you are willing to report this bug');
        die;
    }
}
$query1 = "SELECT * FROM $table WHERE class='income' AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) ORDER BY date DESC";
$query2 = "SELECT * FROM $table WHERE class='spending' AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())  ORDER BY date DESC";
$income = query($query1);
$spending = query($query2);
keptConn();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/style.css">
    <title>HISTORY</title>
    <style>
        table {
            text-align: center;
            border-color: #E5C3A6;
            background-color: black;
            color: #E5C3A6;
        }
        #value {
            text-align: right;
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
                    <a class="nav-link color-keptskin fw-bold" href="../help/">Bantuan</a>
					<a class="nav-link color-keptskin fw-bold" href="../report/">Lapor</a>
					<!-- <a class="nav-link color-keptskin" href="history/">Riwayat</a> -->
                    <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
                </div>
                <div class="navbar-nav me-4">
                    <div class="navbar-item dropdown">
                        <button class="nav-link color-keptskin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a><?php echo greeting()?></a>
                            <img src="../../src/img/profilepicture/<?php echo fetch('picture'); ?>" alt="Profile Picture" class="border border-light rounded-circle navbar-picture">
                        </button>
						<ul class="dropdown-menu dropdown-menu-end bg-keptskin">
                            <li><a class="dropdown-item " href="../profile/">Profil</a></li>
                            <li><a class="dropdown-item" href="../plan/">Ubah Rencana</a></li>
							<!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
							<li><hr class="dropdown-divider"></li>
							<li><a href="../logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </nav>
    <h1 class="text-center text-decoration-underline">Riwayat</h1>
    <br>
    <h2>Pendapatan</h2>
    <?php if($income != NULL) { ?>
    <table class="history-table" border="1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Jumlah (Rp)</th>
            <th colspan="2">Detail</th>
        </tr>
        <?php $i = 1; foreach ($income as $transaction) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo dayName($transaction['date']) ?>, <?php showDate($transaction['date']) ?></td>
            <td><?php echo $transaction['name'] ?></td>
            <td id="value"><?php echo money($transaction['value']) ?></td>
            <td><?php echo $transaction['detail'] ?></td>
            <td>
                <form action="" method="post">
                    <button type="submit" name="delete" id="delete" value="<?php echo $transaction['id'] ?>">Hapus</button>
                </form>
            </td>
        </tr>
        <?php $i++; } ?>
    </table>
    <?php } else {?>
    <h2>Belum ada transaksi!</h2>
    <?php } ?>
    <br>
    <h2>Pengeluaran</h2>
    <?php if($spending != NULL) { ?>
    <table class="history-table" border="1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Kategori</th>
            <th>Jumlah (Rp)</th>
            <th colspan="2">Detail</th>
        </tr>
        <?php $i = 1; foreach ($spending as $transaction) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo dayName($transaction['date']) ?>, <?php showDate($transaction['date']) ?></td>
            <td>
                <?php if($transaction['category'] === 'priority') {
                    echo 'Prioritas';
                } else if($transaction['category'] === 'needs') {
                    echo 'Kebutuhan';
                } else {
                    echo 'Keinginan';
                }?>
            </td>
            <td><?php echo $transaction['name'] ?></td>
            <td id="value"><?php echo money($transaction['value']) ?></td>
            <td><?php echo $transaction['detail'] ?></td>
            <td>
                <form action="" method="post">
                    <button type="submit" name="delete" id="delete" value="<?php echo $transaction['id'] ?>">Hapus</button>
                </form>
            </td>
        </tr>
        <?php $i++; } ?>
    </table>
    <?php } else {?>
    <h2>Belum ada transaksi!</h2>
    <?php } ?>
    <script src="../../src/script/bootstrap.bundle.min.js"></script>
    <script>
        const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

        const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
            v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
            )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

        // do the work...
        document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
            const table = th.closest('table');
            Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
                .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
                .forEach(tr => table.appendChild(tr) );
        })));
    </script>
</body>