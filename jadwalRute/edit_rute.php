<?php
include '../db.php';

// Get route ID from URL
$id = $_GET['id'];

// Fetch route data
$route = $conn->query("SELECT * FROM rute WHERE id_rute = '$id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $kota_asal = $conn->real_escape_string($_POST['kota_asal']);
    $kota_tujuan = $conn->real_escape_string($_POST['kota_tujuan']);
    $jarak_km = $conn->real_escape_string($_POST['jarak_km']);
    $estimasi_waktu = $conn->real_escape_string($_POST['estimasi_waktu']);
    $harga_tiket = $conn->real_escape_string($_POST['harga_tiket']);

    // Update query
    $sql = "UPDATE rute SET 
            kota_asal = '$kota_asal',
            kota_tujuan = '$kota_tujuan',
            jarak_km = '$jarak_km',
            estimasi_waktu = '$estimasi_waktu',
            harga_tiket = '$harga_tiket'
            WHERE id_rute = '$id'";

    if ($conn->query($sql)) {
        header("Location: ../jadwalRute.php?success=Rute berhasil diupdate");
        exit();
    } else {
        $error = "Gagal mengupdate rute: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rute - BUSHY-APP</title>
    <link rel="stylesheet" href="../style/edit_rute.css">
</head>
<body>
    <nav>
        <a href="../index.php">Home</a> |
        <a href="../jadwalRute.php">Kembali ke Rute</a>
    </nav>

    <div class="form-container">
        <form method="post">
            <h2>Edit Data Rute</h2>
            
            <?php if(isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="kota_asal">Kota Asal:</label>
                <input type="text" id="kota_asal" name="kota_asal" 
                       value="<?= htmlspecialchars($route['kota_asal']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="kota_tujuan">Kota Tujuan:</label>
                <input type="text" id="kota_tujuan" name="kota_tujuan" 
                       value="<?= htmlspecialchars($route['kota_tujuan']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="jarak_km">Jarak (km):</label>
                <input type="text" id="jarak_km" name="jarak_km" step="0.1"
                       value="<?= htmlspecialchars($route['jarak_km']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="estimasi_waktu">Estimasi Waktu:</label>
                <input type="text" id="estimasi_waktu" name="estimasi_waktu" 
                       value="<?= htmlspecialchars($route['estimasi_waktu']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="harga_tiket">Harga Tiket:</label>
                <input type="number" id="harga_tiket" name="harga_tiket" 
                       value="<?= htmlspecialchars($route['harga_tiket']) ?>" required>
            </div>
            
            <button type="submit" class="submit-btn">Update Rute</button>
        </form>
    </div>
</body>
</html>