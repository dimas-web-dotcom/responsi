<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penumpang = $_POST['id_penumpang'];
    $nomor_kursi = $_POST['nomor_kursi'];
    $status_pembayaran = $_POST['status_pembayaran'];
    $tanggal_pesan = $_POST['tanggal_pesan'];
    $id_jadwal = $_POST['id_jadwal'];
    
    $sql = "INSERT INTO tiket (
                id_tiket, id_penumpang, nomor_kursi, status_pembayaran, tanggal_pesan, id_jadwal
            ) VALUES (
                generate_id_tiket(), '$id_penumpang', '$nomor_kursi', '$status_pembayaran', '$tanggal_pesan', '$id_jadwal'
            )";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../tiket.php");
        exit();
    } else {
        header("Location: tiket.php?error=Gagal menambahkan tiket: " . $conn->error);
        exit();
    }
} else {
    header("Location: tiket.php");
    exit();
}
?>