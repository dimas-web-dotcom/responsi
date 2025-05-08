<?php include '../db.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM penumpang WHERE id_penumpang='$id'")->fetch_assoc();

if ($_POST) {
  $nama = $conn->real_escape_string($_POST['nama']);
  $ktp = $conn->real_escape_string($_POST['ktp']);
  $jk = $conn->real_escape_string($_POST['jk']);
  $telp = $conn->real_escape_string($_POST['telp']);
  
  $sql = "UPDATE penumpang SET nama='$nama', no_ktp='$ktp', jenis_kelamin='$jk', no_telp='$telp' WHERE id_penumpang='$id'";
  if ($conn->query($sql)) {
    echo "<script>alert('Data diupdate'); location.href='../index.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Penumpang - BUSHY-APP</title>
  <link rel="stylesheet" href="../style/dpEdit.css">
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
      <h3>Edit Penumpang</h3>
      <div class="form-group">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>">
      </div>
      
      <div class="form-group">
        <label for="ktp">No KTP:</label>
        <input type="text" id="ktp" name="ktp" value="<?= htmlspecialchars($data['no_ktp']) ?>">
      </div>
      
      <div class="form-group">
        <label for="jk">Jenis Kelamin:</label>
        <select id="jk" name="jk">
          <option value="Laki-laki" <?= $data['jenis_kelamin']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
          <option value="Perempuan" <?= $data['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="telp">No Telp:</label>
        <input type="text" id="telp" name="telp" value="<?= htmlspecialchars($data['no_telp']) ?>">
      </div>
      
      <button type="submit">Update Data</button>
    </form>
  </div>
</body>
</html>