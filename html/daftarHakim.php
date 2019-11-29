<script>
  function notFound(){
    alert("Detail hakim yang anda cari tidak ditemukan");
  }
</script>

<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php?status=login");
}

$status = $_GET['status'];
if($status == "404"){
    echo '<script type="text/javascript">notFound()</script>';
}


$whereClause = '';
if ($_POST['nama'] != '') {
    $namaHakim = $_POST['nama'];
    $whereClause = $whereClause . " where namaHakim = '$namaHakim'";
}

if ($_POST['pengadilan'] != '') {
    if ($whereClause != '') {
        $whereClause = $whereClause . " and ";
    } else {
        $whereClause = $whereClause . " where ";

    }
    $namaBadanPeradilan = $_POST['pengadilan'];
    $whereClause = $whereClause . "namaBadanPeradilan = '$namaBadanPeradilan'";

}
if ($_POST['provinsi'] != '') {
    if ($whereClause != '') {
        $whereClause = $whereClause . " and ";
    } else {
        $whereClause = $whereClause . " where ";

    }
    $provinsi = $_POST['provinsi'];
    $whereClause = $whereClause . "namaProvinsi = '$provinsi'";

}
if ($_POST['jabatan'] != '') {
    if ($whereClause != '') {
        $whereClause = $whereClause . " and ";
    } else {
        $whereClause = $whereClause . " where ";

    }
    $jabatanHakim = $_POST['jabatan'];
    $whereClause = $whereClause . "jabatanHakim = '$jabatanHakim'";

}


$sql = "select h.idHakim as idHakim, h.nip as nip, h.namaHakim as namaHakim, bp.namaBadanPeradilan as namaBadanPeradilan, 
p2.namaProvinsi as namaProvinsi, jh.jabatanHakim as jabatanHakim
  from hakim h
  inner join(
    select * from pekerjaan pk1
      inner join (
        SELECT pk.idHakim hakimId, MIN(pk.idBadanPeradilan) badanPeradilan
        FROM   pekerjaan pk GROUP BY hakimId
      ) pInner on hakimId = pk1.idHakim and badanPeradilan = pk1.idBadanPeradilan
    ) p on h.idHakim = p.idHakim
  inner join badan_peradilan bp on p.idBadanPeradilan = bp.idBadanPeradilan
  inner join provinsi p2 on bp.idProvinsi = p2.idProvinsi
  inner join jabatan_hakim jh on p.idJabatanHakim = jh.idJabatanHakim" . $whereClause;
$query = mysqli_query($db, $sql);

$queryProvince = mysqli_query($db, "select * from provinsi");
$queryPengadilan = mysqli_query($db, "select namaBadanPeradilan from badan_peradilan");
$queryHakim = mysqli_query($db, "select namaHakim from hakim");
$queryJabatanHakim = mysqli_query($db, "select jabatanHakim from jabatan_hakim");
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Daftar Hakim</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
      <div class="logo-ky-container">
        <img src="img/Logo_KY.jpg">
        <div class="sidebar-brand-text">SI MONITORING DATA HAKIM</div>
      </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Tables -->
    <li class="nav-item active">
      <a class="nav-link" href="daftarHakim.php">
        <i class="fas fa-fw fa-table"></i>
        <span>List Hakim</span></a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="daftarHakim.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Cari Hakim</span></a>
    </li>


    <!-- Nav Item - Charts -->
    <li class="nav-item">
      <a class="nav-link" href="grafikHakim.php">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Grafik Hakim</span></a>
    </li>


  </ul>
  <!-- End of Sidebar -->

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

      <!-- Begin Page Content -->
      <div class="container-fluid">

        <div class="header-content row">
          <div class="col-md-5">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">List Data Hakim</h1>
          </div>
          <div class="col-md-7">
            <!-- Topbar Search -->

            <!-- <div class="input-group" id="search-top">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div> -->

          </div>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="table-responsive">
              <form action="daftarHakim.php" method="POST">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                  <tr>
                    <th>
                      <select name="nip">
                          <?php
                          echo "<option value='' selected>Select</option>";
                          ?>
                      </select>
                    </th>
                    <th>
                      <select name="nama">
                        <?php
                            echo "<option value='' selected>Select</option>";
                        while ($hakimSelector = mysqli_fetch_array($queryHakim)) {
                            echo "<option value='".$hakimSelector['namaHakim']."'>".$hakimSelector['namaHakim']."</option>";
                        }
                        ?>
                      </select>
                    </th>
                    <th>
                      <select name="pengadilan">
                          <?php
                              echo "<option value='' selected>Select</option>";
                          while ($badanPeradilan = mysqli_fetch_array($queryPengadilan)) {
                              echo "<option value='".$badanPeradilan['namaBadanPeradilan']."'>".$badanPeradilan['namaBadanPeradilan']."</option>";
                          }
                          ?>
                      </select>
                    </th>
                    <th>
                      <select name="provinsi">
                        <?php
                            echo "<option value='' selected>Select</option>";
                        while ($prov = mysqli_fetch_array($queryProvince)) {
                            echo "<option value='".$prov['namaProvinsi']."'>".$prov['namaProvinsi']."</option>";
                        }
                        ?>
                      </select>
                    </th>
                    <th>
                      <select name="jabatan">
                          <?php
                              echo "<option value='' selected>Select</option>";
                          while ($jabatanHakim = mysqli_fetch_array($queryJabatanHakim)) {
                              echo "<option value='".$jabatanHakim['jabatanHakim']."'>".$jabatanHakim['jabatanHakim']."</option>";
                          }
                          ?>
                      </select>
                    </th>
                    <th>
                      <button value="Cari" name="cari">Cari</button>
                    </th>
                  </tr>
                  <tr>
                    <th>NIP</th>
                    <th>Nama Hakim</th>
                    <th>Pengadilan</th>
                    <th>Provinsi</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php

                  while ($hakim = mysqli_fetch_array($query)) {
                      echo "<tr>";

                      echo "<td>" . $hakim['nip'] . "</td>";
                      echo "<td>" . $hakim['namaHakim'] . "</td>";
                      echo "<td>" . $hakim['namaBadanPeradilan'] . "</td>";
                      echo "<td>" . $hakim['namaProvinsi'] . "</td>";
                      echo "<td>" . $hakim['jabatanHakim'] . "</td>";

                      echo "<td>";
                      echo "<a href='profilHakim.php?id=" . $hakim['idHakim'] . "' class='btn btn-primary'>View Detail</a>";
                      echo "</td>";

                      echo "</tr>";
                  }
                  ?>

                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; Komisi Yudisial 2019</span>
        </div>
      </div>
    </footer>
    <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="index.php">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>

</body>

</html>
