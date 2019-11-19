<?php
session_start();

$server = "localhost";
$user = "yudisial";
$password = "yudisial";
$nama_database = "komisi_yudisial";

$db = mysqli_connect($server, $user, $password, $nama_database);

if( !$db ){
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}

?>

