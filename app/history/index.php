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
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>KEPT</title>
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

      </style>
   </head>
   <body class="sb-nav-fixed">
      <nav class="sb-topnav navbar navbar-expand navbar-dark custom-bg">
         <!-- Navbar Brand-->
         <a class="navbar-brand ps-3" href="index.html">KEPT</a>
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
                  <h1 class="mt-4">Riwayat</h1>
                  <ol class="breadcrumb mb-4">
                     <li class="breadcrumb-item active">Riwayat</li>
                  </ol>
                  <div class="container">
                  <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Pendapatan</h2>
                    </div>
                    <div class="card-body">
                    <?php if($income != NULL) { ?>
                        <table id="incomeTable" class="table table-striped table-bordered">
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
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Pengeluaran</h2>
                    </div>
                    <div class="card-body">
                    <?php if($spending != NULL) { ?>
                        <table id="expensesTable" class="table table-striped table-bordered">
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
                    </div>
                </div>
            </div>
        </div>
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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/js/scripts.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/assets/demo/chart-area-demo.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/assets/demo/chart-bar-demo.js"></script>
      <script src="https://cdn.harkovnet.biz.id/sbadmin1/js/datatables-simple-demo.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
      </script>
    <script>
    $(document).ready(function() {
        $('#incomeTable').DataTable();
        $('#expensesTable').DataTable();
    });
    </script>
    </body>
</html>