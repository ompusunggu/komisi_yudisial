
<script>
  function loginFailed() {
    alert("Login Gagal, Username atau Password salah");
  }

  function pleaseLogin(){
    alert("Mohon Login terlebih dahulu");
  }

  function loggedOut(){
    alert("Berhasil Logout, Terima kasih");
  }
</script>

<?php

include("config.php");
include("clear-login.php");

if(isset($_GET['status'])){
  $status = $_GET['status'];
    if($status == "gagal"){
        echo '<script type="text/javascript">loginFailed()</script>';
    }
    if($status == "login"){
        echo '<script type="text/javascript">pleaseLogin()</script>';
    }
    if($status == "logout"){
        echo '<script type="text/javascript">loggedOut()</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">

</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <form action="proses-login.php" method="POST">
        <div class="login-container">
          <div class="logo-ky"></div>
          <div class="title-login">Sistem Informasi<br>Monitoring Data Hakim</div>
          <div class="form-container">
            <div class="input-wrapper">
              <input type="text" name="username" placeholder="username" id="username">
            </div>
            <div class="input-wrapper">
              <input type="password" name="password" placeholder="password" id="password">
            </div>
          </div>
          <div class="container-submit-btn">
            <button value="Login" name="login">Submit</button>
          </div>
        </div>
    </form>


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
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
