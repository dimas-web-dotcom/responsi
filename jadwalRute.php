<?php
include 'db.php';

// Query untuk data jadwal
$sql_jadwal = "SELECT * FROM vw_detail_jadwal";
$result_jadwal = $conn->query($sql_jadwal);

// Query untuk data rute
$sql_rute = "SELECT * FROM rute";
$result_rute = $conn->query($sql_rute);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal dan Rute Bus - BUSHY-APP</title>
  <link rel="stylesheet" href="style/jadwalRute.css">
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

  <main class="container">
    <section class="section">
      <h2>Detail Jadwal Bus</h2>
      <table>
        <thead>
          <tr>
            <th>ID Jadwal</th>
            <th>Nomor Polisi</th>
            <th>Asal</th>
            <th>Tujuan</th>
            <th>Tanggal Berangkat</th>
            <th>Jam Berangkat</th>
            <th>Jam Tiba</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result_jadwal->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id_jadwal']) ?></td>
            <td><?= htmlspecialchars($row['nomor_polisi']) ?></td>
            <td><?= htmlspecialchars($row['kota_asal']) ?></td>
            <td><?= htmlspecialchars($row['kota_tujuan']) ?></td>
            <td><?= htmlspecialchars($row['tanggal_berangkat']) ?></td>
            <td><?= htmlspecialchars($row['jam_berangkat']) ?></td>
            <td><?= htmlspecialchars($row['jam_tiba']) ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </section>

    <section class="section">
      <h2>Data Rute</h2>
      <table>
        <thead>
          <tr>
            <th>ID Rute</th>
            <th>Kota Asal</th>
            <th>Kota Tujuan</th>
            <th>Jarak (km)</th>
            <th>Estimasi Waktu</th>
            <th>Harga Tiket</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result_rute->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id_rute']) ?></td>
            <td><?= htmlspecialchars($row['kota_asal']) ?></td>
            <td><?= htmlspecialchars($row['kota_tujuan']) ?></td>
            <td><?= htmlspecialchars($row['jarak_km']) ?></td>
            <td><?= htmlspecialchars($row['estimasi_waktu']) ?></td>
            <td>Rp<?= number_format(htmlspecialchars($row['harga_tiket']), 0, ',', '.') ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>