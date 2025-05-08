<?php
include '../db.php';

// Get schedule ID from URL
$id = $_GET['id'];

// Fetch schedule data
$schedule = $conn->query("SELECT * FROM jadwal WHERE id_jadwal = '$id'")->fetch_assoc();

// Fetch buses for dropdown
$buses = $conn->query("SELECT id_bus, nomor_polisi FROM bus");

// Fetch routes for dropdown
$routes = $conn->query("SELECT id_rute FROM rute");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id_bus = $conn->real_escape_string($_POST['id_bus']);
    $id_rute = $conn->real_escape_string($_POST['id_rute']);
    $tanggal_berangkat = $conn->real_escape_string($_POST['tanggal_berangkat']);
    $jam_berangkat = $conn->real_escape_string($_POST['jam_berangkat']);
    $jam_tiba = $conn->real_escape_string($_POST['jam_tiba']);

    // Update query
    $sql = "UPDATE jadwal SET 
            id_bus = '$id_bus',
            id_rute = '$id_rute',
            tanggal_berangkat = '$tanggal_berangkat',
            jam_berangkat = '$jam_berangkat',
            jam_tiba = '$jam_tiba'
            WHERE id_jadwal = '$id'";

    if ($conn->query($sql)) {
        header("Location: ../jadwalRute.php?success=Jadwal berhasil diupdate");
        exit();
    } else {
        $error = "Gagal mengupdate jadwal: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal - BUSHY-APP</title>
    <link rel="stylesheet" href="../style/edit_jadwal.css">
</head>
<body>
    <nav>
        <a href="../index.php">Home</a> |
        <a href="../jadwalRute.php">Kembali ke Jadwal</a>
    </nav>

    <div class="form-container">
        <form method="post">
            <h2>Edit Jadwal Bus</h2>
            
            <?php if(isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="id_bus">Bus (Nomor Polisi):</label>
                <select id="id_bus" name="id_bus" required>
                    <?php while($bus = $buses->fetch_assoc()): ?>
                        <option value="<?= $bus['id_bus'] ?>" <?= $bus['id_bus'] == $schedule['id_bus'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($bus['nomor_polisi']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="id_rute">Rute (ID):</label>
                <select id="id_rute" name="id_rute" required>
                    <?php while($route = $routes->fetch_assoc()): ?>
                        <option value="<?= $route['id_rute'] ?>" <?= $route['id_rute'] == $schedule['id_rute'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($route['id_rute']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tanggal_berangkat">Tanggal Berangkat:</label>
                <input type="date" id="tanggal_berangkat" name="tanggal_berangkat" 
                       value="<?= htmlspecialchars($schedule['tanggal_berangkat']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="jam_berangkat">Jam Berangkat:</label>
                <input type="time" id="jam_berangkat" name="jam_berangkat" 
                       value="<?= htmlspecialchars($schedule['jam_berangkat']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="jam_tiba">Jam Tiba:</label>
                <input type="time" id="jam_tiba" name="jam_tiba" 
                       value="<?= htmlspecialchars($schedule['jam_tiba']) ?>" required>
            </div>
            
            <button type="submit" class="submit-btn">Update Jadwal</button>
        </form>
    </div>
</body>
</html>