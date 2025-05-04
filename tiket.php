<?php include 'db.php';
$sql = "SELECT t.*, p.nama, j.tanggal_berangkat 
        FROM tiket t 
        JOIN penumpang p ON t.id_penumpang = p.id_penumpang 
        JOIN jadwal j ON t.id_jadwal = j.id_jadwal";
$result = $conn->query($sql); 

$sql2 = "SELECT * FROM vw_tiket_dan_penumpang";
$result2 = $conn->query($sql2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tiket - BUSHY-APP</title>
    <link rel="stylesheet" href="style/tiket.css">
</head>
<body>
    <nav>
      <a href="index.php">Home</a> |
      <a href="DataPenumpang.php">Data Penumpang</a> |
      <a href="jadwalRute.php">Jadwal dan Rute</a> |
      <a href="tiket.php">Lihat Tiket</a> |
      <a href="keberangkatan.php">Lihat Keberangkatan</a> |
      <a href="kedatangan.php">Lihat Kedatangan</a>
    </nav>

    <div class="container">
        <h2>Data Tiket Penumpang</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Tiket</th>
                    <th>Penumpang</th>
                    <th>Tanggal Pesan</th>
                    <th>No Kursi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_tiket']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_pesan']) ?></td>
                    <td><?= htmlspecialchars($row['nomor_kursi']) ?></td>
                    <td data-status="<?= htmlspecialchars($row['status_pembayaran']) ?>">
                        <?= htmlspecialchars($row['status_pembayaran']) ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Data Tiket dan Penumpang</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Tiket</th>
                    <th>Nama Penumpang</th>
                    <th>Nomor Kursi</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Keberangkatan</th>
                    <th>Rute</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result2->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_tiket']) ?></td>
                    <td><?= htmlspecialchars($row['nama_penumpang']) ?></td>
                    <td><?= htmlspecialchars($row['nomor_kursi']) ?></td>
                    <td data-status="<?= htmlspecialchars($row['status_pembayaran']) ?>">
                        <?= htmlspecialchars($row['status_pembayaran']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['tanggal_berangkat']) ?></td>
                    <td><?= htmlspecialchars($row['kota_asal']) ?> - <?= htmlspecialchars($row['kota_tujuan']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>