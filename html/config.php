<?php

$server = "localhost";
$user = "yudisial";
$password = "yudisial";
$nama_database = "komisi_yudisial";

if($db == null){
    $db = mysqli_connect($server, $user, $password, $nama_database);
}

if( !$db ){
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}

?>

