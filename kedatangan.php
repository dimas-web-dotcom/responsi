<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kedatangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Data Penumpang</a> |
        <a href="jadwal.php">Lihat Jadwal</a> |
        <a href="rute.php">Lihat Rute</a> |
        <a href="tiket.php">Lihat Tiket</a> |
        <a href="keberangkatan.php">Lihat Keberangkatan</a> |
        <a href="kedatangan.php">Lihat Kedatangan</a>
    </nav>

<h2>Data Kedatangan Bus</h2>
<table border="1">
<tr>
    <th>ID Kedatangan</th>
    <th>ID Jadwal</th>
    <th>Terminal Tujuan</th>
    <th>Waktu Kedatangan</th>
    <th>Status</th>
</tr>
<?php
$sql = "SELECT * FROM vw_status_kedatangan";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()):
?>
<tr>
    <td><?= $row['id_kedatangan'] ?></td>
    <td><?= $row['id_jadwal'] ?></td>
    <td><?= $row['nama_terminal'] ?></td>
    <td><?= $row['waktu_kedatangan'] ?></td>
    <td><?= $row['status'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
