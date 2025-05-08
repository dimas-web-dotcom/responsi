<?php
include '../db.php';
$id = $_GET['id'];

$sql = "CALL hapus_penumpang_dan_tiket('$id')";
if ($conn->query($sql)) {
    echo "<script>alert('Data penumpang dan tiket berhasil dihapus'); location.href='../index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data: " . $conn->error . "');</script>";
}
?>

