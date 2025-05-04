<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head><title>Data Keberangkatan</title><link rel="stylesheet" href="style.css"></head>
<body>
    <nav>
        <a href="index.php">Data Penumpang</a> |
        <a href="jadwal.php">Lihat Jadwal</a> |
        <a href="rute.php">Lihat Rute</a> |
        <a href="tiket.php">Lihat Tiket</a> |
        <a href="keberangkatan.php">Lihat Keberangkatan</a> |
        <a href="kedatangan.php">Lihat Kedatangan</a>
    </nav>
<h2>Data Keberangkatan</h2>
<table border="1">
<tr><th>ID</th><th>Terminal</th><th>Jadwal</th></tr>
<?php
$sql = "SELECT k.*, t.nama_terminal, j.jam_berangkat 
        FROM keberangkatan k
        JOIN terminal t ON k.id_terminal = t.id_terminal
        JOIN jadwal j ON k.id_jadwal = j.id_jadwal";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()):
?>
<tr>
<td><?= $row['id_keberangkatan'] ?></td>
<td><?= $row['nama_terminal'] ?></td>
<td><?= $row['jam_berangkat'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</body></html>
