<?php
session_start();
include("config.php");

$whereClause = '';
if($_GET['id'] != ''){
    $whereClause = $whereClause . " where idHakim = ".$_GET['id'];
}

$queryHakim = mysqli_query($db, "select * from hakim".$whereClause);

$rowCount = mysqli_num_rows($queryHakim);



?>