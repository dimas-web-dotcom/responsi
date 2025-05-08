<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tiket = $conn->real_escape_string($_POST['id_tiket']);
    $status = $conn->real_escape_string($_POST['status_pembayaran']);

    // Panggil stored procedure untuk update status
    $sql = "CALL update_status_pembayaran('$id_tiket', '$status')";
    
    if ($conn->query($sql)) {
        echo "<script>alert('Status pembayaran berhasil diupdate'); window.location.href='../tiket.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate status: " . addslashes($conn->error) . "'); window.history.back();</script>";
    }
} else {
    header("Location: ../tiket.php");
}
?>