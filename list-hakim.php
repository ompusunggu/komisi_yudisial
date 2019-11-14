<?php include("config.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Siswa Baru | SMK Coding</title>
</head>

<body>
    <header>
        <h3>Siswa yang sudah mendaftar</h3>
    </header>

    <nav>
        <a href="form-daftar.php">[+] Tambah Baru</a>
    </nav>

    <br>

    <table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>nip</th>
            <th>npwp</th>
            <th>Agama</th>
            <th>gelar hakim</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $sql = "SELECT * FROM hakim";
        $query = mysqli_query($db, $sql);

        while($hakim = mysqli_fetch_array($query)){
            echo "<tr>";

            echo "<td>".$hakim['idHakim']."</td>";
            echo "<td>".$hakim['namaHakim']."</td>";
            echo "<td>".$hakim['nip']."</td>";
            echo "<td>".$hakim['npwp']."</td>";
            echo "<td>".$hakim['idAgama']."</td>";
            echo "<td>".$hakim['gelarHakim']."</td>";

            echo "<td>";
            echo "<a href='detail-hakim.php?id=".$hakim['idHakim']."'>Edit</a> | ";
            echo "</td>";

            echo "</tr>";
        }
        ?>

    </tbody>
    </table>

    <p>Total: <?php echo mysqli_num_rows($query) ?></p>

    </body>
</html>

