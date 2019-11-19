<?php

include("config.php");

// cek apakah tombol daftar sudah diklik atau blum?
if (isset($_POST['login'])) {

    // ambil data dari formulir
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = hash("sha256", $password, false);

    // buat query
    $sql = "SELECT * from user where username = '$username' and password =  '$hashedPassword'";
    $query = mysqli_query($db, $sql);
    $_SESSION[$username] = $hashedPassword;

    // apakah query simpan berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        header('Location: index.php?status=sukses');
    } else {
        // kalau gagal alihkan ke halaman indek.php dengan status=gagal
        header('Location: index.php?status=gagal');
    }


} else {
    die("Akses dilarang...");
}

?>

