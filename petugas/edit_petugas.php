<?php
include '../db.php';

// Ambil data petugas berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM petugas WHERE id_petugas = '$id'";
    $result = $conn->query($sql);
    $petugas = $result->fetch_assoc();
}

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_petugas = $_POST['id_petugas'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $shift = $_POST['shift'];
    $no_telp = $_POST['no_telp'];
    
    $sql = "UPDATE petugas SET 
            nama = '$nama',
            jabatan = '$jabatan',
            shift = '$shift',
            no_telp = '$no_telp'
            WHERE id_petugas = '$id_petugas'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../daftar_petugas.php");
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
    <title>Edit Petugas</title>
    <style>
        /* Same styling as edit_jadwal.php */
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
        <a href="../daftar_petugas.php">Kembali ke Daftar Petugas</a>
    </nav>

    <div class="form-container">
        <h2>Edit Petugas</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($petugas)): ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="id_petugas">ID Petugas:</label>
                <input type="text" id="id_petugas" name="id_petugas" value="<?= $petugas['id_petugas'] ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?= $petugas['nama'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="jabatan">Jabatan:</label>
                <input type="text" id="jabatan" name="jabatan" value="<?= $petugas['jabatan'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="shift">Shift:</label>
                <select id="shift" name="shift" required>
                    <option value="Pagi" <?= $petugas['shift'] == 'Pagi' ? 'selected' : '' ?>>Pagi</option>
                    <option value="Siang" <?= $petugas['shift'] == 'Siang' ? 'selected' : '' ?>>Siang</option>
                    <option value="Malam" <?= $petugas['shift'] == 'Malam' ? 'selected' : '' ?>>Malam</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="no_telp">No. Telepon:</label>
                <input type="text" id="no_telp" name="no_telp" value="<?= $petugas['no_telp'] ?>" required>
            </div>
            
            <button type="submit" class="submit-btn">Simpan Perubahan</button>
        </form>
        <?php else: ?>
            <p>Data petugas tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>
</html>