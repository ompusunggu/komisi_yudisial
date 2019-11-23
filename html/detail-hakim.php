<?php
session_start();
include("config.php");

$whereClause = '';
if($_GET['id'] != ''){
    $whereClause = $whereClause . " where namaHakim = ".$_GET['id'];
}

$queryHakim = mysqli_query($db, "select * from hakim".$whereClause);
$hakim = mysqli_fetch_array($queryHakim);
echo $hakim;
?>