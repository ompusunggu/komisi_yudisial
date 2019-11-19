<?php

include("config.php");
echo isset($_POST['login']);
// cek apakah tombol daftar sudah diklik atau blum?
if (isset($_POST['login'])) {

    // ambil data dari formulir
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = hash("sha256", $password, false);

    echo $username;
    echo $password;
    echo $hashedPassword;

    // buat query
    $sql = "SELECT * from user where username = '$username' and password =  '$hashedPassword'";
    echo $sql;
    $query = mysqli_query($db, $sql);
    $_SESSION[$username] = $hashedPassword;
    echo $query;

    // apakah query simpan berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        echo $query;
        header('Location: index.php?status=sukses');
    } else {
        // kalau gagal alihkan ke halaman indek.php dengan status=gagal
        header('Location: index.php?status=gagal');
    }


} else {
    die("Akses dilarang...");
}

?>

