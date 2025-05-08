<?php
include '../db.php';

// Ambil data bus dan rute untuk dropdown
$sql_bus = "SELECT id_bus, nomor_polisi FROM bus";
$result_bus = $conn->query($sql_bus);

$sql_rute = "SELECT id_rute, CONCAT(kota_asal, ' - ', kota_tujuan) AS nama_rute FROM rute";
$result_rute = $conn->query($sql_rute);

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menggunakan stored procedure untuk menambah jadwal
    $id_bus = $_POST['id_bus'];
    $tanggal_berangkat = $_POST['tanggal_berangkat'];
    $jam_berangkat = $_POST['jam_berangkat'];
    $jam_tiba = $_POST['jam_tiba'];
    $id_rute = $_POST['id_rute'];
    
    $sql = "CALL tambah_jadwal('$id_bus', '$tanggal_berangkat', '$jam_berangkat', '$jam_tiba', '$id_rute')";
    
    if ($conn->query($sql)) {
        header("Location: ../jadwalRute.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Bus</title>
    <style>
        /* Same styling as jadwalRute.php */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        nav {
            background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%);
            padding: 1.2rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        h2 {
            color: #6e48aa;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #6e48aa;
            outline: none;
            box-shadow: 0 0 0 3px rgba(110, 72, 170, 0.1);
        }
        .submit-btn {
            background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .submit-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .error {
            color: #dc3545;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav>
        <a href="../index.php">Home</a> |
        <a href="../jadwalRute.php">Kembali ke Rute</a>
    </nav>
    <div class="form-container">
        <h2>Tambah Jadwal Bus</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="" method="POST">
            <div class="form-group">
                <label for="id_bus">Bus:</label>
                <select id="id_bus" name="id_bus" required>
                    <option value="">Pilih Bus</option>
                    <?php while ($row = $result_bus->fetch_assoc()): ?>
                        <option value="<?= $row['id_bus'] ?>"><?= $row['nomor_polisi'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tanggal_berangkat">Tanggal Berangkat:</label>
                <input type="date" id="tanggal_berangkat" name="tanggal_berangkat" required>
            </div>
            
            <div class="form-group">
                <label for="jam_berangkat">Jam Berangkat:</label>
                <input type="time" id="jam_berangkat" name="jam_berangkat" required>
            </div>
            
            <div class="form-group">
                <label for="jam_tiba">Jam Tiba:</label>
                <input type="time" id="jam_tiba" name="jam_tiba" required>
            </div>
            
            <div class="form-group">
                <label for="id_rute">Rute:</label>
                <select id="id_rute" name="id_rute" required>
                    <option value="">Pilih Rute</option>
                    <?php while ($row = $result_rute->fetch_assoc()): ?>
                        <option value="<?= $row['id_rute'] ?>"><?= $row['nama_rute'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <button type="submit" class="submit-btn">Simpan</button>
        </form>
    </div>
</body>
</html>