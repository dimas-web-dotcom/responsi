<?php
include '../db.php';

// Get ID from URL
$id = $_GET['id'];

// Fetch petugas keberangkatan data
$data = $conn->query("SELECT * FROM petugas_keberangkatan WHERE id = '$id'")->fetch_assoc();

// Fetch petugas for dropdown
$petugas = $conn->query("SELECT id_petugas, nama FROM petugas");

// Fetch keberangkatan for dropdown
$keberangkatan = $conn->query("SELECT id_keberangkatan FROM keberangkatan");

// Fetch status for dropdown
$status_options = ['Berangkat', 'Dalam Proses', 'Delay', 'Dibatalkan'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id_keberangkatan = $conn->real_escape_string($_POST['id_keberangkatan']);
    $tugas = $conn->real_escape_string($_POST['tugas']);
    $id_petugas = $conn->real_escape_string($_POST['id_petugas']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update query
    $sql = "UPDATE petugas_keberangkatan SET 
            id_keberangkatan = '$id_keberangkatan',
            tugas = '$tugas',
            id_petugas = '$id_petugas'
            WHERE id = '$id'";

    $update_status_sql = "UPDATE keberangkatan SET status = '$status' WHERE id_keberangkatan = '$id_keberangkatan'";

    if ($conn->query($sql) && $conn->query($update_status_sql)) {
        header("Location: ../daftar_petugas.php?success=Data petugas berhasil diupdate");
        exit();
    } else {
        $error = "Gagal mengupdate data: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Petugas Keberangkatan - BUSHY-APP</title>
    <style>
        /* Same styling as petugas_keberangkatan.php */
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
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
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
        <a href="../daftar_petugas.php">Kembali ke Petugas Keberangkatan</a>
    </nav>

    <div class="form-container">
        <form method="post">
            <h2>Edit Petugas Keberangkatan</h2>
            
            <?php if(isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="id_keberangkatan">ID Keberangkatan:</label>
                <select id="id_keberangkatan" name="id_keberangkatan" required>
                    <?php while($kb = $keberangkatan->fetch_assoc()): ?>
                        <option value="<?= $kb['id_keberangkatan'] ?>" <?= $kb['id_keberangkatan'] == $data['id_keberangkatan'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kb['id_keberangkatan']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tugas">Tugas:</label>
                <input type="text" id="tugas" name="tugas" 
                       value="<?= htmlspecialchars($data['tugas']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="id_petugas">Petugas:</label>
                <select id="id_petugas" name="id_petugas" required>
                    <?php while($pt = $petugas->fetch_assoc()): ?>
                        <option value="<?= $pt['id_petugas'] ?>" <?= $pt['id_petugas'] == $data['id_petugas'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pt['nama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="status">Status Keberangkatan:</label>
                <select id="status" name="status" required>
                    <?php 
                    // Ambil status saat ini dari tabel keberangkatan
                    $current_status = $conn->query("SELECT status FROM keberangkatan WHERE id_keberangkatan = '".$data['id_keberangkatan']."'")->fetch_assoc()['status'];
                    
                    foreach($status_options as $status_option): 
                        $selected = ($status_option == $current_status) ? 'selected' : '';
                    ?>
                        <option value="<?= htmlspecialchars($status_option) ?>" <?= $selected ?>>
                            <?= htmlspecialchars($status_option) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="submit-btn">Update Data</button>
        </form>
    </div>
</body>
</html>