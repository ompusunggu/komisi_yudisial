<?php
session_start();
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
    $num_results = mysqli_num_rows($result);


    // apakah query simpan berhasil?
    if($num_results == 1){
        $_SESSION[$username] = $hashedPassword;
        $location = "Location: daftarHakim.php?data=$query";
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        header($location);
    } else {
        echo "gagal";
        // kalau gagal alihkan ke halaman indek.php dengan status=gagal
        header("Location: index.php?status=gagal&data=$num_results");
    }


} else {
    echo "gagal2";
    die("Akses dilarang...");
}

?>

