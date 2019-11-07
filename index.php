<!DOCTYPE html>
<html>
<head>
  <title>Pendaftaran Siswa Baru | SMK Coding</title>
</head>

<body>
<header>
  <h3>Sistem informasi monitoring data hakim</h3>
  <h1>Komisi Yudisial Jakarta</h1>
</header>

<h4>Menu</h4>
<nav>
  <ul>
    <li><a href="form-daftar.php">Daftar Baru</a></li>
    <li><a href="list-siswa.php">Pendaftar</a></li>
    <li><a href="form-daftar.php">Daftar Akun Baru</a></li>
    <li><a href="list-siswa.php">Login</a></li>
  </ul>
</nav>
<?php if (isset($_GET['status'])): ?>
  <p>
      <?php
      if ($_GET['status'] == 'sukses') {
          echo "Pendaftaran siswa baru berhasil!";
      } else {
          echo "Pendaftaran gagal!";
      }
      ?>
  </p>
<?php endif; ?>
</body>
</html>

