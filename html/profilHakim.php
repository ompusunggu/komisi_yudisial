<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php?status=login");
}
$idHakim = "";
if($_GET['id'] != ''){
    $whereClause = $whereClause . " where h.idHakim = ".$_GET['id'];
    $idHakim = $_GET['id'];
}

$sql = "select h.idHakim as idHakim, h.nip as nip, h.namaHakim as namaHakim, h.npwp,
h.tglLahir, jk.jenisKelamin, a.namaAgama, sp.statusPerkawinan,
bp.namaBadanPeradilan as namaBadanPeradilan,
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
  inner join jabatan_hakim jh on p.idJabatanHakim = jh.idJabatanHakim
	inner join jenis_kelamin jk on h.idJenisKelamin = jk.idJenisKelamin
	inner join agama a on h.idAgama = a.idAgama
	inner join status_perkawinan sp on h.idStatusPerkawinan = sp.idStatusPerkawinan" . $whereClause;

$queryHakim = mysqli_query($db, $sql);

$sqlPendidikan  = "select p.namaSekolah, p.tahunLulus, pf.namaPendidikanFormal from pendidikan p
	inner join pendidikan_formal pf on p.idPendidikanFormal = pf.idPendidikanFormal
where p.idHakim = ".$idHakim;

$queryPendidikan = mysqli_query($db, $sqlPendidikan);

$sqlPekerjaan = "select p.TMT, bp.namaBadanPeradilan, jh.jabatanHakim from pekerjaan p
	inner join badan_peradilan bp on p.idBadanPeradilan = bp.idBadanPeradilan
	inner join jabatan_hakim jh on p.idJabatanHakim = jh.idJabatanHakim 
where p.idHakim = ".$idHakim;

$queryPekerjaan = mysqli_query($db, $sqlPekerjaan);

$sqlHubunganKeluarga = "select ak.namaAnggotaKeluarga, ak.pekerjaan, ak.alamat, a.namaAgama, jk.jenisKelamin, hk.hubunganKeluarga, ak.tglLahir
from anggota_keluarga ak
	inner join hubungan_keluarga hk on ak.idHubKeluarga = hk.idHubKeluarga
	inner join jenis_kelamin jk on ak.idJenisKelamin = jk.idJenisKelamin
	inner join agama a on ak.idAgama = a.idAgama
where ak.idHakim = ".$idHakim;


$queryHubunganKeluarga = mysqli_query($db, $sqlHubunganKeluarga);

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="logo-ky-container">
          <img src="img/Logo_KY.jpg">
          <div class="sidebar-brand-text">SI Monitoring Data Hakim</div>
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Tables -->
      <li class="nav-item active">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>List Hakim</span></a>
      </li>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Cari Hakim</span></a>
      </li>


      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
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
          
            </div>
          </div>

                   <!-- DataTales Example -->
          <div class="card">
            <div class="card-body">
              <div class="foto-hakim" style="background-image: url(https://www.pa-jakartaselatan.go.id/simpeg/foto/pegawai/C0619630308%20198903%201%20004.jpg);"></div>
              <div class="container-biodata">
                <?php
                while ($hakim = mysqli_fetch_array($queryHakim)) {

                    echo "<div class='nama-hakim'>" .$hakim['namaHakim']. "</div>";
                    echo "<div class='jabatan-hakim'>" .$hakim['jabatanHakim']. "</div>";

                    echo "<div class='container-biodata-detail'>";
                  echo "<div class='biodata-left'>";
                    echo "<div>";
                      echo "<div class='nama-atribut'>NIP</div>";
                      echo "<div class='isi-atribut'>".$hakim['nip']."</div>";
                    echo "</div>";
                    echo "<div>";
                      echo "<div class='nama-atribut'>NPWP</div>";
                      echo "<div class='isi-atribut'>".$hakim['npwp']."</div>";
                    echo "</div>";
                    echo "<div>";
                      echo "<div class='nama-atribut'>TTL</div>";
                      echo "<div class='isi-atribut'>".$hakim['tglLahir']."</div>";
                    echo "</div>";
                  echo "</div>";
                  echo "<div class='biodata-right'>";
                    echo "<div>";
                      echo "<div class='nama-atribut'>Jenis Kelamin</div>";
                      echo "<div class='isi-atribut'>".$hakim['jenisKelamin']."</div>";
                    echo "</div>";
                    echo "<div>";
                      echo "<div class='nama-atribut'>Agama</div>";
                      echo "<div class='isi-atribut'>".$hakim['namaAgama']."</div>";
                    echo "</div>";
                    echo "<div>";
                      echo "<div class='nama-atribut'>Status</div>";
                      echo "<div class='isi-atribut'>".$hakim['statusPerkawinan']."</div>";
                    echo "</div>";
                  echo "</div>";
                echo "</div>";
                  }
                ?>



                <div class="data-pendidikan">
                  <h2>Data Pendidikan</h2>
                  <table class="table">

                    <tr>
                      <th>No</th>
                      <th>Jenjang</th>
                      <th>Institusi</th>
                      <th>Tahun Lulus</th>
                    </tr>
                    <?php
                    $indexPendidikan = 1;
                    while ($pendidikanHakim = mysqli_fetch_array($queryPendidikan)) {
                        echo "<tr>";

                        echo "<td>" . $indexPendidikan ."</td>";
                        echo "<td>" . $pendidikanHakim['namaPendidikanFormal'] . "</td>";
                        echo "<td>" . $pendidikanHakim['namaSekolah'] . "</td>";
                        echo "<td>" . $pendidikanHakim['tahunLulus'] . "</td>";

                        echo "</tr>";
                        $indexPendidikan = $indexPendidikan + 1;
                    }
                    ?>
                  </table>
                </div>
                <div class="data-pekerjaan">
                  <h2>Data Pekerjaan</h2>
                  <table class="table">
                    <tr>
                      <th>No</th>
                      <th>Jabatan</th>
                      <th>Pengadilan</th>
                      <th>Tahun Masuk</th>
                    </tr>
                      <?php
                      $queryHubunganKeluarga;
                      $indexPekerjaan = 1;
                      while ($pekerjaanHakim = mysqli_fetch_array($queryPekerjaan)) {
                          echo "<tr>";

                          echo "<td>" . $indexPekerjaan ."</td>";
                          echo "<td>" . $pekerjaanHakim['jabatanHakim'] . "</td>";
                          echo "<td>" . $pekerjaanHakim['namaBadanPeradilan'] . "</td>";
                          echo "<td>" . $pekerjaanHakim['TMT'] . "</td>";

                          echo "</tr>";
                          $indexPekerjaan = $indexPekerjaan + 1;
                      }
                      ?>
                  </table>
                </div>
                <div class="data-anggota-keluarga">
                  <h2>Data Anggota Keluarga</h2>
                  <table class="table">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Hubungan</th>
                      <th>Jenis Kelamin</th>
                      <th>Agama</th>
                      <th>Tanggal Lahir</th>
                      <th>Pekerjaan</th>
                      <th>Alamat</th>
                    </tr>
                      <?php
                      $indexHubunganKeluarga = 1;
                      while ($hubunganKeluarga = mysqli_fetch_array($queryHubunganKeluarga)) {
                          echo "<tr>";

                          echo "<td>" . $indexHubunganKeluarga ."</td>";
                          echo "<td>" . $hubunganKeluarga['namaAnggotaKeluarga'] . "</td>";
                          echo "<td>" . $hubunganKeluarga['hubunganKeluarga'] . "</td>";
                          echo "<td>" . $hubunganKeluarga['jenisKelamin'] . "</td>";
                          echo "<td>" . $hubunganKeluarga['namaAgama'] . "</td>";
                          echo "<td>" . $hubunganKeluarga['tglLahir'] . "</td>";
                          echo "<td>" . $hubunganKeluarga['pekerjaan'] . "</td>";
                          echo "<td>" . $hubunganKeluarga['alamat'] . "</td>";

                          echo "</tr>";
                          $indexHubunganKeluarga = $indexHubunganKeluarga + 1;
                      }
                      ?>
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
  </div>
</body>

</html>
