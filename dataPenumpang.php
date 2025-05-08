<?php 
include 'db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Penumpang</title>
  <link rel="stylesheet" href="style/dataPenumpang.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a> |
        <a href="jadwalRute.php">Jadwal dan Rute</a> |
        <a href="dataPenumpang.php">Data Penumpang</a> |
        <a href="tiket.php">Tiket</a> |
        <a href="keberangkatan.php">Keberangkatan</a> |
        <a href="kedatangan.php">Kedatangan</a> |
        <a href="daftar_petugas.php">Daftar Petugas</a>
    </nav>
  <main>
    <h2>Data Penumpang</h2>
    <a class="button" href="dataPenumpang/add.php">Tambah Penumpang</a>
    
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>No KTP</th>
          <th>Jenis Kelamin</th>
          <th>No Telp</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM penumpang");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($row['id_penumpang']) ?></td>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['no_ktp']) ?></td>
          <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
          <td><?= htmlspecialchars($row['no_telp']) ?></td>
          <td>
            <a href="dataPenumpang/edit.php?id=<?= $row['id_penumpang'] ?>">Edit</a> |
            <a href="dataPenumpang/delete.php?id=<?= $row['id_penumpang'] ?>" 
               onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</body>
</html>