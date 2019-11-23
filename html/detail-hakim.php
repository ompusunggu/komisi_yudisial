<?php
session_start();
include("config.php");

$whereClause = '';
if($_GET['id'] != ''){
    $whereClause = $whereClause . " where idHakim = ".$_GET['id'];
    echo $whereClause;
}

$queryHakim = mysqli_query($db, "select * from hakim".$whereClause);

while ($hakim = mysqli_fetch_array($queryHakim)) {
    echo "<tr>";

    echo "<td>" . $hakim['namaHakim'] . "</td>";
    echo "<td>" . $hakim['nip'] . "</td>";
    echo "<td>" . $hakim['gelarHakim'] . "</td>";
    echo "<td>" . $hakim['tempatLahir'] . "</td>";

    echo "</tr>";
}
?>
?>