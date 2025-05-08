<?php
include '../db.php';
if ($_POST) {
  $nama = $conn->real_escape_string($_POST['nama']);
  $ktp  = $conn->real_escape_string($_POST['ktp']);
  $jk   = $conn->real_escape_string($_POST['jk']);
  $telp = $conn->real_escape_string($_POST['telp']);

  $sql = "CALL tambah_penumpang('$nama', '$ktp', '$jk', '$telp')";
  if ($conn->query($sql)) {
    echo "<script>alert('Data berhasil ditambahkan'); location.href='../dataPenumpang.php';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan data: " . addslashes($conn->error) . "');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Penumpang - BUSHY-APP</title>
  <link rel="stylesheet" href="../style/dpAdd.css">
</head>
<body>

  <nav>
        <a href="../index.php">Home</a> |
        <a href="../dataPenumpang.php">Data Penumpang</a> |
        <a href="../jadwalRute.php">Jadwal dan Rute</a> |
        <a href="../tiket.php">Lihat Tiket</a> |
        <a href="../keberangkatan.php">Lihat Keberangkatan</a> |
        <a href="../kedatangan.php">Lihat Kedatangan</a>
        <a href="../daftar_petugas.php">Petugas</a>
    </nav>

  <div class="form-container">
    <form method="post">
      <h3>Tambah Penumpang</h3>
            
      <div class="form-group">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" name="nama" required>
      </div>
      
      <div class="form-group">
        <label for="ktp">Nomor KTP:</label>
        <input type="text" id="ktp" name="ktp" required>
      </div>
      
      <div class="form-group">
        <label for="jk">Jenis Kelamin:</label>
        <select id="jk" name="jk" required>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="telp">Nomor Telepon:</label>
        <input type="text" id="telp" name="telp" required>
      </div>
      
      <button type="submit" class="submit-btn">Simpan Data</button>
    </form>
  </div>
</body>
</html>