<?php include 'db.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM penumpang WHERE id_penumpang='$id'")->fetch_assoc();

if ($_POST) {
  $sql = "UPDATE penumpang SET nama='{$_POST['nama']}', no_ktp='{$_POST['ktp']}', jenis_kelamin='{$_POST['jk']}', no_telp='{$_POST['telp']}' WHERE id_penumpang='$id'";
  if ($conn->query($sql)) {
    echo "<script>alert('Data diupdate'); location.href='index.php';</script>";
  }
}
?>
<form method="post">
  <h3>Edit Penumpang</h3>
  Nama: <input name="nama" value="<?= $data['nama'] ?>"><br>
  No KTP: <input name="ktp" value="<?= $data['no_ktp'] ?>"><br>
  Jenis Kelamin:
  <select name="jk">
    <option <?= $data['jenis_kelamin']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
    <option <?= $data['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
  </select><br>
  No Telp: <input name="telp" value="<?= $data['no_telp'] ?>"><br>
  <button type="submit">Update</button>
</form>
