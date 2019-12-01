<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php?status=login");
}
$color = array('#7a9397', '#79a7a5', '#75b69e', '#6dc49c', '#70d462', '#6b878c', '#6a9d9b', '#66ae93', '#5dbe91', '#60cf51', '#5d7b81', '#5c9492', '#57a689', '#4db886', '#51cb40');

$sqlGrafikByPengadilan = "select bp.namaBadanPeradilan as namaBadanPeradilan, count(bp.namaBadanPeradilan) as jumlah
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
group by namaBadanPeradilan";

$queryGrafik = mysqli_query($db, $sqlGrafikByPengadilan);
$index = 0;
while ($badanPeradilanCount = mysqli_fetch_array($queryGrafik)) {

    $index = $index + 1;
    $label[] = $badanPeradilanCount['namaBadanPeradilan'];
    $data [] = $badanPeradilanCount['jumlah'];
    $chartColor [] = $color[$index];
}

$sqlGrafikByProvinsi = "select p2.namaProvinsi as namaProvinsi, count(p2.namaProvinsi) as jumlah
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
group by namaProvinsi";

$queryGrafikByProvinsi = mysqli_query($db, $sqlGrafikByProvinsi);
$maxByProvinsi = 0;
while ($provinsiCount = mysqli_fetch_array($queryGrafikByProvinsi)) {
    $labelProvinsi[] = $provinsiCount['namaProvinsi'];
    $dataProvinsi [] = $provinsiCount['jumlah'];
    if ($provinsiCount['jumlah'] > $maxByProvinsi) {
        $maxByProvinsi = $provinsiCount['jumlah'];
    }
}

$maxByProvinsi = $maxByProvinsi * 2;
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
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
    <li class="nav-item">
      <a class="nav-link" href="cariDataHakim.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Cari Hakim</span></a>
    </li>


    <!-- Nav Item - Charts -->
    <li class="nav-item active">
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
            <h1 class="h3 mb-2 text-gray-800">Grafik Data Hakim</h1>
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

        <div class="row">
          <div class="col-xl-8 col-lg-7">

            <!-- Bar Chart -->
            <div class="card mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Provinsi</h6>
              </div>
              <div class="card-body">
                <div class="chart-bar">
                  <canvas id="myBarChart"></canvas>
                </div>

              </div>
            </div>

          </div>

          <!-- Donut Chart -->
          <div class="col-xl-4 col-lg-5">
            <div class="card mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Tingkat Pengadilan</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <div class="chart-pie pt-4">
                  <canvas id="myPieChart"></canvas>
                </div>

              </div>
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
          <span>Copyright &copy; Your Website 2019</span>
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

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script>
  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  // Pie Chart Example
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: <?php echo json_encode($label)?>,
      datasets: [{
        data: <?php echo json_encode($data)?> ,
        backgroundColor: <?php echo json_encode($chartColor)?> ,
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 0,
    },
  });
</script>
<script>
  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

  // Bar Chart Example
  var ctx = document.getElementById("myBarChart");
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($labelProvinsi)?> ,
      datasets: [{
        label: "Jumlah",
        backgroundColor: "#009E37",
        hoverBackgroundColor: "#009E37",
        borderColor: "#009E37",
        data: <?php echo json_encode($dataProvinsi)?> ,
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'month'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 6
          },
          maxBarThickness: 25,
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: <?php echo json_encode($maxByProvinsi)?> ,
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              return number_format(value);
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ':' + number_format(tooltipItem.yLabel);
          }
        }
      },
    }
  });

</script>

</body>

</html>
