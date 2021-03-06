<?php
session_start();
include("config.php");
if (!isset($_SESSION['username'])) {
    header("Location: index.php?status=login");
}
?>

<?php
$whereClause = "";
if ($_POST['filter'] === "nama") {
    $namaHakim = strtolower( $_POST['keyword']);
    $whereClause = $whereClause . " where lower(namaHakim) like '%$namaHakim%'";
}

if ($_POST['filter'] === "nip") {
    $nip = $_POST['keyword'];
    $whereClause = $whereClause . " where nip = '$nip'";
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

$rowCount = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistem Informasi Monitoring Data Hakim - Cari Data Hakim</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="daftarHakim.php">
        <div class="logo-ky-container">
          <img src="img/Logo_KY.jpg">
          <div class="sidebar-brand-text">SI Monitoring Data Hakim</div>
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="daftarHakim.php">
          <i class="fas fa-fw fa-table"></i>
          <span>List Hakim</span></a>
      </li>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="cariDataHakim.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Cari Hakim</span></a>
      </li>


      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="grafikHakim.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Grafik Hakim</span></a>
      </li>

      <!-- LOGOUT -->
      <li class="nav-item">
        <a class="nav-link" href="index.php?status=logout">
          <span>LOGOUT</span></a>
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
              <h1 class="h3 mb-2 text-gray-800">Cari Data Hakim</h1>
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
          <div class="card">
            <div class="card-body">
              <form action="cariDataHakim.php" method="POST">
              <div class="search-custom-container">
                <div class="berdasarkan-nip">
                  <span>Cari berdasarkan</span>
                  <select name = "filter">
                    <option value = "nip">NIP</option>
                    <option value = "nama">Nama Hakim</option>
                  </select>
                </div>
                <div class="keyword">
                  <span>Keyword</span>
                  <input type="text" name="keyword" placeholder="Nama Hakim">
                </div>
                <div class="search-btn-container">
                  <button class="btn btn-primary">Cari Data Hakim</button>
                </div>
                </form>

              </div>
            </div>
          </div>
          <div class="card hasil-pencarian">
            <div class="card-body">
              <span class="title-hasil-pencarian"><?php echo $rowCount;?> hasil pencarian ditemukan:</span>
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Np</th>
                      <th>Name</th>
                      <th>NIP</th>
                      <th>Badan Peradilan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $indexHakim = 1;
                  while ($hakim = mysqli_fetch_array($query)) {
                      echo "<tr>";

                      echo "<td>" . $indexHakim . "</td>";
                      echo "<td>" . $hakim['namaHakim'] . "</td>";
                      echo "<td>" . $hakim['nip'] . "</td>";
                      echo "<td>" . $hakim['namaBadanPeradilan'] . "</td>";

                      echo "<td>";
                      echo "<a href='profilHakim.php?id=" . $hakim['idHakim'] . "' class='btn btn-primary'>View Detail</a>";
                      echo "</td>";

                      echo "</tr>";
                      $indexHakim = $indexHakim + 1;
                  }
                  ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->

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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
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
