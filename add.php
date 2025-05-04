<?php
include 'db.php';
if ($_POST) {
  $id   = $_POST['id'];
  $nama = $_POST['nama'];
  $ktp  = $_POST['ktp'];
  $jk   = $_POST['jk'];
  $telp = $_POST['telp'];

  $sql = "CALL tambah_penumpang('$id', '$nama', '$ktp', '$jk', '$telp')";
  if ($conn->query($sql)) {
    echo "<script>alert('Data berhasil ditambahkan'); location.href='index.php';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan data: " . $conn->error . "');</script>";
  }
}
?>
<form method="post">
  <h3>Tambah Penumpang</h3>
  ID: <input name="id" required><br>
  Nama: <input name="nama" required><br>
  No KTP: <input name="ktp" required><br>
  Jenis Kelamin:
  <select name="jk">
    <option value="Laki-laki">Laki-laki</option>
    <option value="Perempuan">Perempuan</option>
  </select><br>
  No Telp: <input name="telp" required><br>
  <button type="submit">Simpan</button>
</form>
