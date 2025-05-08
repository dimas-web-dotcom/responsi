<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id_rute = $_GET['id'];
    
    // Cek apakah rute digunakan di jadwal
    $sql_check = "SELECT COUNT(*) as total FROM jadwal WHERE id_rute = '$id_rute'";
    $result = $conn->query($sql_check);
    $row = $result->fetch_assoc();
    
    if ($row['total'] > 0) {
        echo "<script>
                alert('Tidak dapat menghapus rute karena sudah digunakan di jadwal!');
                window.location.href = '../jadwalRute.php';
              </script>";
        exit();
    }
    
    // Hapus rute jika tidak digunakan
    $sql = "DELETE FROM rute WHERE id_rute = '$id_rute'";
    
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