<?php
include '../db.php';

// Mendapatkan ID petugas kedatangan dari URL
$id = $_GET['id'];

// Query untuk mendapatkan data petugas kedatangan berdasarkan ID
$sql = "SELECT pk.id, pk.tugas, pk.id_petugas, pk.id_kedatangan, p.nama AS nama_petugas, k.status AS status_kedatangan
        FROM petugas_kedatangan pk
        JOIN petugas p ON pk.id_petugas = p.id_petugas
        JOIN kedatangan k ON pk.id_kedatangan = k.id_kedatangan
        WHERE pk.id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit;
}

// Proses update data jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tugas = $_POST['tugas'];
    $id_petugas = $_POST['id_petugas'];
    $id_kedatangan = $_POST['id_kedatangan'];
    $status = $_POST['status']; // Mengambil status dari form

    $update_sql = "UPDATE petugas_kedatangan SET tugas = '$tugas', id_petugas = '$id_petugas', id_kedatangan = '$id_kedatangan' WHERE id = '$id'";
    $update_status_sql = "UPDATE kedatangan SET status = '$status' WHERE id_kedatangan = '$id_kedatangan'";

    if ($conn->query($update_sql) === TRUE && $conn->query($update_status_sql) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui.'); window.location.href='../daftar_petugas.php';</script>";
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Petugas Kedatangan - BUSHY-APP</title>
    <style>
        /* Reset & Base Styles */
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

        /* Navigation */
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

        /* Main Content */
        main {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        h2 {
            color: #6e48aa;
            margin: 1.5rem 0;
            font-size: 1.8rem;
            font-weight: 600;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        /* Form */
        form {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #6e48aa;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
        }

        input[type="submit"]:hover {
            background-color: #5a3e91;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            nav {
                padding: 1rem;
                text-align: center;
            }

            nav a {
                display: inline-block;
                margin: 0.25rem;
                padding: 0.5rem;
                font-size: 0.9rem;
            }

            main {
                padding: 0 1rem;
            }
        }

        @media (max-width: 480px) {
            nav a {
                display: block;
                margin: 0.5rem 0;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="../index.php">Home</a> |
        <a href="../daftar_petugas.php">Kembali ke Petugas Keberangkatan</a>
    </nav>

    <main>
        <h2>Edit Petugas Kedatangan</h2>
        
        <form action="" method="post">
            <label for="tugas">Tugas:</label>
            <input type="text" id="tugas" name="tugas" value="<?php echo htmlspecialchars($row['tugas']); ?>" required>

            <label for="id_petugas">ID Petugas:</label>
            <input type="text" id="id_petugas" name="id_petugas" value="<?php echo htmlspecialchars($row['id_petugas']); ?>" required>

            <label for="id_kedatangan">ID Kedatangan:</label>
            <input type="text" id="id_kedatangan" name="id_kedatangan" value="<?php echo htmlspecialchars($row['id_kedatangan']); ?>" required>

            <label for="status">Status Kedatangan:</label>
            <select id="status" name="status" required>
                <option value="">Pilih Status</option>
                <option value="Tiba" <?php echo ($row['status_kedatangan'] == 'Tiba') ? 'selected' : ''; ?>>Tiba</option>
                <option value="Dalam Proses" <?php echo ($row['status_kedatangan'] == 'Dalam Proses') ? 'selected' : ''; ?>>Dalam Proses</option>
                <option value="Delay" <?php echo ($row['status_kedatangan'] == 'Delay') ? 'selected' : ''; ?>>Delay</option>
                <option value="Dibatalkan" <?php echo ($row['status_kedatangan'] == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
            </select>

            <input type="submit" value="Simpan Perubahan">
        </form>
    </main>
</body>
</html>