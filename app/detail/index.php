<?php
require "../../functions.php";
session_start();
if(!isset($_SESSION['loginId'])) {
    jumpTo("../../");
}
session_abort();

$name = fetch('nickname');
$db = fetch('username').'_keep';
keepConn();

$totalIncome = totalIncome($db);
$routineIncome = routineIncome($db);
$additionalIncome = additionalIncome($db);
$totalSpending = totalSpending($db);
$prioritySpending = prioritySpending($db);
$needsSpending = needsSpending($db);
$wantsSpending = wantsSpending($db);
if($totalIncome != 0) {
    $routineIncomePercentage = ($routineIncome * 100 / $totalIncome);
    $additionalIncomePercentage = ($additionalIncome * 100 / $totalIncome);
} else {
    $routineIncomePercentage = 0;
    $additionalIncomePercentage = 0;
}

$incomeDataPoints = array( 
    array("label"=>"Rutin", "y"=>$routineIncomePercentage),
    array("label"=>"Tambahan", "y"=>$additionalIncomePercentage),
);

keptConn();
$realIncome = $totalIncome - $prioritySpending;

$needsPlan = (float) fetch('needs');
$wantsPlan = (float) fetch('wants');
$savingPlan = (float) fetch('saving');
$invest = ((float) fetch('saving')/100) * $realIncome;
if($realIncome != 0) {
    $needsSpendingPercentage = ($needsSpending * 100 / $realIncome);
    $wantsSpendingPercentage = ($wantsSpending * 100 / $realIncome);
    $prioritySpendingPercentage = ($prioritySpending * 100) / $totalIncome;
} else {
    $needsSpendingPercentage = 0;
    $wantsSpendingPercentage = 0;
    $prioritySpendingPercentage = 0;
}

$saving = $totalIncome - $totalSpending;
if($totalIncome != 0) {
    $spendingPercentage = ($totalSpending * 100 / $totalIncome);
    $savingPercentage = ($saving * 100/$realIncome);
    $savingPercentage2 = ($saving - $invest) * 100/ $totalIncome;
} else {
    $spendingPercentage = 0;
    $savingPercentage = 0;
    $savingPercentage2 = 0;
}


$today = dateNow();
$dateMonth = dateMonth($today);
$dateYear = dateYear($today);
keptConn();
$priorityName = listItem('category', 'priority', 'name');
$needsName = listItem('category', 'needs', 'name');
$wantsName = listItem('category', 'wants', 'name');
$priorityUsername = listItem('category', 'priority', 'username');
$needsUsername = listItem('category', 'needs', 'username');
$wantsUsername = listItem('category', 'wants', 'username');
keepConn();
$priorityDetail = listSpending($priorityUsername, $db);
$needsDetail = listSpending($needsUsername, $db);
$wantsDetail = listSpending($wantsUsername, $db);
$healthy = true;
keptConn();
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>KEPT</title>
      <link rel="shortcut icon" href="../../src/img/icon.png" type="image/x-icon">
      <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
      <link href="https://cdn.harkovnet.biz.id/sbadmin1/css/styles.css" rel="stylesheet" />
      <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
      
      <style>
         .custom-bg {
         background-color: #2E4374 !important;
         }
         .custom-sidenav {
         background-color: #2E4374 !important;
         color: #E5C3A6 !important;
         }
         .sb-nav-link-icon {
         color: #E5C3A6 !important;
         }
         .nav-link {
         color: #E5C3A6 !important;
         }
         .custom-card {
         background-color: #2E4374 !important;
         color: #E5C3A6 !important;
         }
         .text-white {
         color: #E5C3A6 !important;
         }
         .btn-custom {
         background-color: #2E4374;
         color: white;
         }

         .background-putih {
    background-color: white;
}

h1 {
    color: black;
}

.app-h2{
    color: black;

}

.detail-container{
    background-color: #2E4374;

}

.app-h2-custom{
    color: white;

}
         
      </style>
   </head>
   <body class="background-putih sb-nav-fixed">
      <nav class="sb-topnav navbar navbar-expand navbar-dark custom-bg">
         <!-- Navbar Brand-->
         <a class="navbar-brand ps-3" href="../">KEPT</a>
         <!-- Sidebar Toggle-->
         <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
         <!-- Navbar Search-->
         <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
            </div>
         </form>
         <!-- Navbar-->
         <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
               <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item " href="../profile/">Profil</a></li>
                  <li><a class="dropdown-item" href="../plan/">Ubah Rencana</a></li>
                  <!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
                  <li>
                     <hr class="dropdown-divider">
                  </li>
                  <li><a href="../logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
               </ul>
            </li>
         </ul>
      </nav>
      <div id="layoutSidenav">
         <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion custom-sidenav" id="sidenavAccordion">
               <div class="sb-sidenav-menu">
                  <div class="nav">
                     <div class="sb-sidenav-menu-heading">Menu</div>
                     <a class="nav-link" href="../">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Home
                     </a>
                     <a class="nav-link" href="../keep/">
                        <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                        Keep
                     </a>
                     <a class="nav-link" href="../detail/">
                        <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                        Detail
                     </a>
                     <a class="nav-link" href="../history/">
                        <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                        Riwayat
                     </a>
                     <a class="nav-link" href="../help/">
                        <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
                        Bantuan
                     </a>
                     <a class="nav-link" href="../report/">
                        <div class="sb-nav-link-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        Lapor
                     </a>
                  </div>
               </div>
               <div class="sb-sidenav-footer">
                  <?php
                     error_reporting(E_ALL & ~E_WARNING);
                     echo greeting();
                     ?>
                  <a class="nav-link color-white fw-light"><?php echo dayName(dateNow()).', '; showDate(dateNow())?></a>
               </div>
            </nav>
         </div>
         <div id="layoutSidenav_content">
            <main>
               <div class="container-fluid px-4">
                  <h1 class="mt-4">Detail Grafik</h1>
                  <ol class="breadcrumb mb-4">
                     <li class="breadcrumb-item active">Detail Grafik</li>
                  </ol>
                  <div class="container">
                  <link rel="stylesheet" href="../../src/css/style.css">
                  <?php if($totalIncome != 0) {?>
    <div class="page bb-1">
        <h1 class="mt-0 ms-3 text-center text-decoration-underline" id="chart">Grafik</h1>
        <div class="d-flex ms-auto me-auto flex-wrap">
            <div class="chart ms-auto me-auto bg-keptblue border rounded mt-2 mb-2" id="incomeChart"></div>
            <div class="chart ms-auto me-auto bg-keptblue border rounded mt-2 mb-2" id="walletChart"></div>
            <?php if($totalSpending != 0) {?>
                <div class="chart ms-auto me-auto bg-keptblue border rounded mt-2 mb-2" id="spendingChart"></div>
            <?php } ?>
            <?php if($needsSpending != 0) {?>
                <div class="chart ms-auto me-auto bg-keptblue border rounded mt-2 mb-2" id="needsChart"></div>
            <?php } ?>
            <?php if($prioritySpending != 0) {?>
                <div class="chart ms-auto me-auto bg-keptblue border rounded mt-2 mb-2" id="priorityChart"></div>
            <?php } ?>
            <?php if($wantsSpending != 0) {?>
                <div class="chart ms-auto me-auto bg-keptblue border rounded mt-2 mb-2" id="wantsChart"></div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <div class="page mb-0">
        <h1 class="text-center text-decoration-underline" id="more-detail">Rincian</h1>
        <div class="container detail-container p-0">
            <div class="item text-center">
                <h2 class="color-keptskin app-h2-custom">Pendapatan</h2>
                <hr>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Total</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($totalIncome) ?></p>
                </div>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Rutin</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($routineIncome) ?></p>
                    <p class="detail-p"><?php echo '('.percentage($routineIncomePercentage).' % dari Total)'?></p>
                </div>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Tambahan</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($additionalIncome)?></p>
                    <p class="detail-p"><?php echo '('.percentage($additionalIncomePercentage).' % dari Total)'?></p>
                </div>
                
            </div>
            <div class="item text-center">
                <h2 class="color-keptskin app-h2-custom">Pengeluaran</h2>
                    <hr>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Total</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($totalSpending) ?></p>
                </div>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Prioritas</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($prioritySpending)?></p>
                    <!-- <p><?php //echo '('.percentage($prioritySpendingPercentage).' % of Spending)'?> or <?php //echo '('.percentage($prioritySpendingPercentage * $spendingPercentage / 100).' % of Income)' ?></p> -->
                </div>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Kebutuhan</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($needsSpending)?></p>
                    <!-- <p><?php //echo '('.percentage($needsSpendingPercentage).' % dari Pendapatan Nyata)'?></p> -->
                    <!-- <p><?php //echo '('.percentage($needsSpendingPercentage).' % of Spending)'?> or <?php //echo '('.percentage($needsSpendingPercentage * $spendingPercentage / 100).' % of Income)' ?></p> -->
                </div>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Keinginan</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($wantsSpending)?></p>
                    <!-- <p><?php //echo '('.percentage($wantsSpendingPercentage).' % dari Pendapatan Nyata)'?></p> -->
                    <!-- <p><?php //echo '('.percentage($wantsSpendingPercentage).' % of Spending'?> or <?php //echo percentage($wantsSpendingPercentage * $spendingPercentage / 100).' % of Income' ?></p> -->
                </div>
            </div>
            <div class="item text-center">
                <h2 class="color-keptskin app-h2-custom">Dompetmu</h2>
                <hr>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Pendapatan Nyata</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($realIncome)?></p>
                    <p class="mb-0">Total - Prioritas</p>
                    <p class="detail-p">(Rp. <?php echo money($totalIncome) ?> - Rp. <?php echo money($prioritySpending) ?>)</p>
                </div>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Sisa Uang</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($saving) ?></p>
                    <!-- <h2 class="value fw-bolder">Rp. <?php //echo money($saving)?></h2> -->
                    <p class="detail-p"><?php echo '('.percentage($savingPercentage).' % dari Pendapatan Nyata)' ?></p>
                </div>
                <div class="mt-3">
                    <h3 class="text-decoration-underline mb-0 app-h3">Setelah Menabung</h3>
                    <p class="value fw-bolder mb-0">Rp. <?php echo money($saving - $invest)?></p>
                    <!-- <p><?php //echo '('.percentage(($saving - $invest) * 100 / $realIncome).' % dari Pendapatan Nyata)' ?></p> -->
                </div>

            </div>
        </div>
    </div>
    <div class="page bb-1">
        <div class="container detail-container p-0">
            <div class="item text-center">
                <h2 class="color-keptskin app-h2-custom">Prioritas</h2>
                <hr>
                <div class="mt-3">
                    <?php for($i = 0; $i < count($priorityUsername); $i++) { ?>
                        <div>
                            <h3 class="text-decoration-underline mb-0 app-h3"><?php echo $priorityName[$i] ?></h3>
                            <p class="value fw-bolder mb-0">Rp. <?php echo money($priorityDetail[$i]) ?></p>
                            <?php if($prioritySpending != 0) { ?>
                            <p class="detail-p"><?php echo'('.percentage((($priorityDetail[$i]/$prioritySpending) * $prioritySpendingPercentage)).' % dari Total Pendapatan)' ?></p>
                            <?php } else {?>
                            <p class="detail-p">Rp. <?php echo money($priorityDetail[$i]).' (0 % dari Total Pendapatan)' ?></p>
                            <?php } ?>
                        </div>
                        <?php } ?>
                </div>
            </div>
            <div class="item text-center">
                <h2 class="color-keptskin app-h2-custom">Kebutuhan</h2>
                <hr>
                <div>
                    <?php for($i = 0; $i < count($needsUsername); $i++) { ?>
                        <div>
                            <h3 class="text-decoration-underline mb-0 app-h3"><?php echo $needsName[$i] ?></h3>
                            <p class="value fw-bolder mb-0">Rp. <?php echo money($needsDetail[$i])?></p>
                            <?php if($needsSpending != 0) { ?>
                            <p class="detail-p"><?php echo '('.percentage((($needsDetail[$i]/$needsSpending) * $needsSpendingPercentage)).' % dari Pendapatan Nyata)'?></p>
                            <?php } else {?>
                            <p class="detail-p"><?php echo '(0 % dari Pendapatan Nyata)' ?></p>
                            <?php } ?>
                        </div>
                        <?php } ?>
                </div>
            </div>
            <div class="item text-center">
                <h2 class="color-keptskin app-h2-custom">Keinginan</h2>
                <hr>
                <div>
                    <?php for($i = 0; $i < count($wantsUsername); $i++) { ?>
                        <div>
                            <h3 class="text-decoration-underline mb-0 app-h3"><?php echo $wantsName[$i] ?></h3>
                            <p class="value fw-bolder mb-0">Rp. <?php echo money($wantsDetail[$i]) ?></p>
                            <?php if($wantsSpending != 0) { ?>
                            <p class="detail-p"><?php echo '('.percentage(($wantsDetail[$i]/$wantsSpending) * $wantsSpendingPercentage).' % dari Pendapatan Nyata)' ?></p>
                            <?php } else { ?>
                            <p class="detail-p"><?php echo '(0 % dari Pendapatan Nyata)' ?></p>
                            <?php } ?>
                        </div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="page text-center align-middle" id="score">
        <div id="kept-score">
            <h1 class="text-decoration-underline">Kept Score</h1>
        <?php 
        if($totalIncome > 0) {
            $needsSpendingPercentage = $needsSpending * 100 / $realIncome;
            $wantsSpendingPercentage = $wantsSpending * 100 / $realIncome;
            $savingPercentage = $saving * 100 / $realIncome;
        } else {
            $needsSpendingPercentage = 0;
            $wantsSpendingPercentage = 0;
            $savingPercentage = 0;
        }

        $keptScore = 100;
        if($needsSpendingPercentage > $needsPlan) $keptScore -= 10;
        if($wantsSpendingPercentage > (($wantsPlan + $needsPlan)/2)) $keptScore -= 20;
        else if($wantsSpendingPercentage > $wantsPlan) $keptScore -= 10;
        if($wantsSpending > $needsSpending) $keptScore -= 10;
        if($totalIncome != 0) {
            if($savingPercentage < -$needsPlan) {
                $keptScore -= 70;
            } else if($savingPercentage < -$wantsPlan) {
                $keptScore -= 60;
            } else if($savingPercentage < -($savingPlan + $wantsPlan)) {
                $keptScore -= 50;
            } else if($savingPercentage < -$savingPlan) {
                $keptScore -= 40;
            } else if($savingPercentage < 0) {
                $keptScore -= 30;
            } else if($savingPercentage < ($savingPlan / 2)) {
                $keptScore -= 20;
            } else if($savingPercentage < $savingPlan) {
                $keptScore -= 10;
            }
        } ?>
            <h1 class="kept-score mb-4 mt-3"><?php echo $keptScore ?></h1>
        <?php if($keptScore === 100) { ?>
            <h2 class="app-h2">Keuanganmu sesuai perencanaan</h2>
        <?php } ?>
        <?php if($needsSpendingPercentage > $needsPlan) {?>
            <h2 class="app-h2">Kebutuhan lebih besar dari <?php echo $needsPlan ?> % (-10 poin)</h2>
        <?php } ?>
        <?php if($wantsSpendingPercentage > (($wantsPlan + $needsPlan)/2)){ ?>
            <h2 class="app-h2">Keinginan lebih besar dari <?php echo (($wantsPlan + $needsPlan)/2) ?> % (-20 poin) </h2>
        <?php } else if($wantsSpendingPercentage > $wantsPlan) { ?>
            <h2 class="app-h2">Keinginan lebih besar dari <?php echo $wantsPlan ?> % (-10 poin) </h2>
        <?php } ?>
        <?php if($wantsSpending > $needsSpending) { ?>
            <h2 class="app-h2">Keinginan lebih besar dari kebutuhan (-10 poin) </h2>
        <?php }
        if($totalIncome != 0) {
            if($savingPercentage < -$needsPlan) { ?>
                <h2 class="app-h2">Pengeluaran <?php echo (100 + $needsPlan) ?> % dari pemasukan (-70 poin)</h2>
            <?php } else if($savingPercentage < -$wantsPlan) { ?>
                <h2 class="app-h2">Pengeluaran <?php echo (100 + $wantsPlan) ?> % dari pemasukan (-60 poin)</h2>
            <?php } else if($savingPercentage < -($savingPlan + $wantsPlan)) { ?>
                <h2 class="app-h2">Pengeluaran <?php echo (100 + ($savingPlan + $wantsPlan)) ?> % dari pemasukan (-50 poin)</h2>
            <?php } else if($savingPercentage < -$savingPlan) { ?>
                <h2 class="app-h2">Pengeluaran <?php echo (100 + $savingPlan) ?> % dari pemasukan (-40 poin)</h2>
            <?php } else if($savingPercentage < 0) { ?>
                <h2 class="app-h2">Pengeluaran lebih besar dari pemasukan (-30 poin)</h2>
            <?php } else if($savingPercentage < ($savingPlan / 2)) { ?>
                <h2 class="app-h2">Tabungan lebih kecil dari <?php echo ($savingPlan / 2) ?> % dari pemasukan (-20 poin)</h2>
            <?php } else if($savingPercentage < $savingPlan) { ?>
                <h2 class="app-h2">Tabungan lebih kecil dari <?php echo ($savingPlan) ?> % dari pemasukan (-10 poin)</h2>
            <?php }
        } 
        ?>
    </div>
               </div>

            </main>
            <footer class="py-4 bg-light mt-auto">
               <div class="container-fluid px-4">
                  <div class="d-flex align-items-center justify-content-between small">
                     <div class="text-muted">Copyright &copy; KEPT 2023</div>
                     <div>
                        <a href="https://harkovnet.biz.id/">Developer Info</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                     </div>
                  </div>
               </div>
            </footer>
         </div>
      </div>
      <script>
        window.onload = function() {
            CanvasJS.addColorSet("wantsPalette",
                [//colorSet Array
                    "#f4cf4c",
                    "#f4894c",
                    "#f5ee9e",
                    "#f49e4c",
                    "#ab3428",
                ]);
            CanvasJS.addColorSet("needsPalette",
                [//colorSet Array
                    "#447604",
                    "#6cc551",
                    "#9ffcdf",
                    "#52ad9c",
                    "#47624f",
                ]);
            CanvasJS.addColorSet("incomePalette",
                [//colorSet Array
                    "#6cc551",
                    "#f49e4c",
                ]);
            var incomeChart = new CanvasJS.Chart("incomeChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "incomePalette",
                // zoomEnabled: true,
                // zoomType: "x",
                theme: "dark2",
                backgroundColor: "#7C81AD",
                title: {
                    text: "Pendapatan"
                },
                subtitles: [{
                    text: "<?php echo dateMonth(dateNow()).', '.dateYear(dateNow()) ?>"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php if($routineIncome != 0) {?>
                        {label: "Rutin", y: <?php echo $routineIncomePercentage ?>},
                        <?php } ?>
                        <?php if($additionalIncome != 0) {?>
                        {label: "Tambah", y: <?php echo $additionalIncomePercentage ?>},
                        <?php } ?>
                    ]
                }]
            });
            var spendingChart = new CanvasJS.Chart("spendingChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "wantsPalette",
                // zoomEnabled: true,
                // zoomType: "x",
                theme: "dark2",
                backgroundColor: "#7C81AD",
                title: {
                    text: "Pengeluaran"
                },
                subtitles: [{
                    text: "<?php echo dateMonth(dateNow()).', '.dateYear(dateNow()) ?>"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php if($prioritySpending != 0) {?>
                        {label: "Prioritas", y: <?php echo $prioritySpending * 100 / $totalSpending ?>},
                        <?php } ?>
                        <?php if($needsSpending != 0) {?>
                        {label: "Kebutuhan", y: <?php echo $needsSpending * 100 / $totalSpending ?>},
                        <?php } ?>
                        <?php if($wantsSpending != 0) {?>
                        {label: "Keinginan", y: <?php echo $wantsSpending * 100 / $totalSpending ?>},
                        <?php } ?>
                    ]
                }]
            });
            var walletChart = new CanvasJS.Chart("walletChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "needsPalette",
                // zoomEnabled: true,
                // zoomType: "x",
                theme: "dark2",
                backgroundColor: "#7C81AD",
                title: {
                    text: "Dompetmu"
                },
                subtitles: [{
                    text: "<?php echo dateMonth(dateNow()).', '.dateYear(dateNow()) ?>"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php if($totalIncome != 0) {?>
                        {label: "Sisa Uang", y: <?php echo $savingPercentage2 ?>},
                        <?php } ?>
                        <?php if($totalIncome != 0) {?>
                        {label: "Tabungan", y: <?php echo $invest * 100 / $totalIncome ?>},
                        <?php } ?>
                        <?php if($totalIncome != 0) {?>
                        {label: "Terpakai", y: 100 - <?php echo $savingPercentage2?> - <?php echo ($invest * 100 / $totalIncome) ?>},
                        <?php } ?>
                    ]
                }]
            });
            var needsChart = new CanvasJS.Chart("needsChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "needsPalette",
                theme: "dark2",
                backgroundColor: "#7C81AD",
                title: {
                    text: "Kebutuhan",
                    cornerRadius: 4,
                },
                subtitles: [{
                    text: "<?php echo dateMonth(dateNow()).', '.dateYear(dateNow()) ?>"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php for($i = 0; $i < count($needsUsername); $i++) { 
                            if($needsDetail[$i] == 0) {
                                continue;
                            }?>
                            {label: "<?php echo $needsName[$i] ?>", y: <?php echo ($needsDetail[$i]/$needsSpending) * 100 ?>},
                        <?php } ?>
                    ]
                }]
            });
            var wantsChart = new CanvasJS.Chart("wantsChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "wantsPalette",
                theme: "dark2",
                backgroundColor: "#7C81AD",
                title: {
                    text: "Keinginan"
                },
                subtitles: [{
                    text: "<?php echo dateMonth(dateNow()).', '.dateYear(dateNow()) ?>"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php for($i = 0; $i < count($wantsUsername); $i++) { 
                            if($wantsDetail[$i] == 0) {
                                continue;
                            }?>
                            {label: "<?php echo $wantsName[$i] ?>", y: <?php echo ($wantsDetail[$i]/$wantsSpending) * 100?>},
                        <?php } ?>
                    ]
                }]
            });
            var priorityChart = new CanvasJS.Chart("priorityChart", {
                animationEnabled: true,
                animationDuration: 500,
                colorSet: "wantsPalette",
                theme: "dark2",
                backgroundColor: "#7C81AD",
                title: {
                    text: "Prioritas"
                },
                subtitles: [{
                    text: "<?php echo dateMonth(dateNow()).', '.dateYear(dateNow()) ?>"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: [
                        <?php for($i = 0; $i < count($priorityUsername); $i++) { 
                            if($priorityDetail[$i] == 0) {
                                continue;
                            }?>
                            {label: "<?php echo $priorityName[$i] ?>", y: <?php echo ($priorityDetail[$i]/$prioritySpending) * 100?>},
                        <?php } ?>
                    ]
                }]
            });

            <?php if($totalIncome != 0) {?>
                incomeChart.render();
                walletChart.render();
            <?php } ?>
            <?php if($needsSpending != 0) {?>
                needsChart.render();
            <?php } ?>
            <?php if($wantsSpending != 0) {?>
                wantsChart.render();
            <?php } ?>
            <?php if($prioritySpending != 0) {?>
                priorityChart.render();
            <?php } ?>
            <?php if($totalSpending != 0) {?>
                spendingChart.render();
            <?php } ?>
        }
    </script>
      <script src="../../src/script/canvasjs.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/js/scripts.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/assets/demo/chart-area-demo.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/assets/demo/chart-bar-demo.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/js/datatables-simple-demo.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
   </body>
</html>
