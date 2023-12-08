<?php
   require "../functions.php";
   $today = dateNow();
   session_start();
   if(!isset($_SESSION['loginId'])) {
       jumpTo("../");
   }
   session_abort();
   if(fetch('new') == 1) {
       jumpTo("new/");
   }
   $name = fetch('nickname');
   $db = fetch('username').'_keep';
   keepConn();
   
   $totalIncome = totalIncome($db);
   $totalSpending = totalSpending($db);
   $prioritySpending = prioritySpending($db);
   $needsSpending = needsSpending($db);
   $wantsSpending = wantsSpending($db);
   $dailySpending = dailySpending($db);
   keptConn();
   $needsPlan = (float) fetch('needs');
   $wantsPlan = (float) fetch('wants');
   $savingPlan = (float) fetch('saving');
   $realIncome = $totalIncome - $prioritySpending;
   $needsWallet = ($needsPlan/100) * $realIncome- $needsSpending;
   $wantsWallet = ($wantsPlan/100) * $realIncome - $wantsSpending;
   $savingWallet = ($savingPlan/100) * $realIncome;
   $saving = $needsWallet + $wantsWallet + $savingWallet;
   if($needsWallet < 0) {
       $wantsWallet += $needsWallet;
       $needsWallet = 0;
   }
   if($wantsWallet < 0) {
       $savingWallet += $wantsWallet;
       $wantsWallet = 0;
   }
   if($savingWallet < 0) {
       $needsWallet += $savingWallet;
       $savingWallet = 0;
   }
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
   }
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
      <link rel="shortcut icon" href="../src/img/icon.png" type="image/x-icon">

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
      </style>
   </head>
   <body class="sb-nav-fixed">
      <nav class="sb-topnav navbar navbar-expand navbar-dark custom-bg">
         <!-- Navbar Brand-->
         <a class="navbar-brand ps-3" href="./">KEPT</a>
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
                  <li><a class="dropdown-item " href="profile/">Profil</a></li>
                  <li><a class="dropdown-item" href="plan/">Ubah Rencana</a></li>
                  <!-- <li><a class="dropdown-item" href="">Another action</a></li> -->
                  <li>
                     <hr class="dropdown-divider">
                  </li>
                  <li><a href="logout.php" class="dropdown-item color-keptblue">Keluar</a></li>
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
                     <a class="nav-link" href="">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Home
                     </a>
                     <a class="nav-link" href="keep/">
                        <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                        Keep
                     </a>
                     <a class="nav-link" href="detail/">
                        <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                        Detail
                     </a>
                     <a class="nav-link" href="history/">
                        <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                        Riwayat
                     </a>
                     <a class="nav-link" href="help/">
                        <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
                        Bantuan
                     </a>
                     <a class="nav-link" href="report/">
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
                  <h1 class="mt-4">Home</h1>
                  <ol class="breadcrumb mb-4">
                     <li class="breadcrumb-item active">Home</li>
                  </ol>
                  <?php if ($totalIncome != 0) { ?>
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                           <div class="card custom-card text-white h-100">
                              <div class="card-header">Kept Score</div>
                              <div class="card-body"><?= $keptScore ?></div>
                              <div class="card-footer d-flex align-items-center justify-content-between">
                                 <a class="small text-white stretched-link" href="detail/#kept-score">View Details</a>
                                 <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                           <div class="card custom-card text-white h-100">
                              <div class="card-header">Pendapatan</div>
                              <div class="card-body">Rp. <?php echo money($totalIncome) ?></div>
                              <div class="card-footer d-flex align-items-center justify-content-between">
                                 <a class="small text-white stretched-link" href="detail/">Detail</a>
                                 <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                           <div class="card custom-card text-white h-100">
                              <div class="card-header">Pengeluaran</div>
                              <div class="card-body">Rp. <?php echo money($totalSpending) ?></div>
                              <div class="card-footer d-flex align-items-center justify-content-between">
                                 <a class="small text-white stretched-link" href="detail/">Detail</a>
                                 <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                           <div class="card custom-card text-white h-100">
                              <div class="card-header">Transaksi</div>
                              <div class="card-body"><a class="text-white" href="keep/">Masukkan Transaksi</a></div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                           <div class="card custom-card text-white h-100">
                              <div class="card-header">Dompetmu</div>
                              <div class="card-body">
                                 <p>Kebutuhan: Rp. <?php echo money($needsWallet) ?></p>
                                 <p>Keinginan: Rp. <?php echo money($wantsWallet) ?></p>
                                 <p>Tabungan: Rp. <?php echo money($savingWallet) ?></p>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                           <div class="card custom-card text-white h-100">
                              <div class="card-header">Riwayat</div>
                              <div class="card-body"><a class="text-white" href="history/">Lihat Transaksi</a></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php } else { ?>
                  <div class="jumbotron">
                     <h1 class="display-4">Selamat Datang di Kept!</h1>
                     <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                     <hr class="my-4">
                     <a class="btn btn-primary btn-lg" href="keep/" role="button">Masukkan Transaksi Pertamamu</a>
                  </div>
                  <?php } ?>
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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/js/scripts.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/assets/demo/chart-area-demo.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/assets/demo/chart-bar-demo.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/js/datatables-simple-demo.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
   </body>
</html>