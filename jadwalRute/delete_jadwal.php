<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id_jadwal = $_GET['id'];
    
    // Hapus data terkait di tabel tiket terlebih dahulu
    $sql_delete_tiket = "DELETE FROM tiket WHERE id_jadwal = '$id_jadwal'";
    $conn->query($sql_delete_tiket);
    
    // Hapus data terkait di tabel keberangkatan
    $sql_delete_keberangkatan = "DELETE FROM keberangkatan WHERE id_jadwal = '$id_jadwal'";
    $conn->query($sql_delete_keberangkatan);
    
    // Hapus data terkait di tabel kedatangan
    $sql_delete_kedatangan = "DELETE FROM kedatangan WHERE id_jadwal = '$id_jadwal'";
    $conn->query($sql_delete_kedatangan);
    
    // Baru hapus jadwal
    $sql = "DELETE FROM jadwal WHERE id_jadwal = '$id_jadwal'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../jadwalRute.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: ../jadwalRute.php");
    exit();
}
?>