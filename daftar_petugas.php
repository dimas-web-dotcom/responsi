<?php
include 'db.php';

// Query untuk mendapatkan data petugas
$sql = "SELECT * FROM vw_daftar_petugas";
$result = $conn->query($sql);

// Query untuk data petugas keberangkatan
$sql0 = "SELECT * FROM vw_petugas_keberangkatan";
$result0 = $conn->query($sql0);

$sql1 = "SELECT * FROM vw_petugas_kedatangan";
$result1 = $conn->query($sql1);

// Proses hapus petugas
if (isset($_GET['hapus_petugas'])) {
    $id = $_GET['hapus_petugas'];
    $hapus = "DELETE FROM petugas WHERE id_petugas = '$id'";
    if ($conn->query($hapus) === TRUE) {
        header("Location: daftar_petugas.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Proses hapus petugas keberangkatan
if (isset($_GET['hapus_keberangkatan'])) {
    $id = $_GET['hapus_keberangkatan'];
    $hapus = "DELETE FROM petugas_keberangkatan WHERE id = '$id'";
    if ($conn->query($hapus) === TRUE) {
        header("Location: daftar_petugas.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Proses hapus petugas kedatangan
if (isset($_GET['hapus_kedatangan'])) {
    $id = $_GET['hapus_kedatangan'];
    $hapus = "DELETE FROM petugas_kedatangan WHERE id = '$id'";
    if ($conn->query($hapus) === TRUE) {
        header("Location: daftar_petugas.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Petugas</title>
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
        .container {
            max-width: 1200px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0 3rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        th {
            background-color: #6e48aa;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        tr {
            transition: all 0.2s ease;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f1f0ff;
        }

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
            max-width: 1200px;
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

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0 3rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        th {
            background-color: #6e48aa;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tr {
            transition: all 0.2s ease;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #f1f0ff;
        }

        /* Status Badges */
        td[data-status="Berangkat"] {
            color: #28a745;
            font-weight: 600;
        }

        td[data-status="Delay"] {
            color: #ffc107;
            font-weight: 600;
        }

        td[data-status="Dibatalkan"] {
            color: #dc3545;
            font-weight: 600;
        }

        /* Action Buttons */
        .action-btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .edit-btn {
            background-color: #ffc107;
            color: #212529;
        }

        .edit-btn:hover {
            background-color: #e0a800;
            transform: translateY(-1px);
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #a71d2a;
            transform: translateY(-1px);
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

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                padding: 8px 10px;
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
        <a href="index.php">Home</a> |
        <a href="jadwalRute.php">Jadwal dan Rute</a> |
        <a href="dataPenumpang.php">Data Penumpang</a> |
        <a href="tiket.php">Tiket</a> |
        <a href="keberangkatan.php">Keberangkatan</a> |
        <a href="kedatangan.php">Kedatangan</a> |
        <a href="daftar_petugas.php">Daftar Petugas</a>
    </nav>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2>Daftar Petugas</h2>
            <a href="petugas/tambah_petugas.php" class="action-btn" style="background-color: #28a745; color: white;">Tambah Petugas</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID Petugas</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Shift</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_petugas']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['jabatan']) ?></td>
                    <td><?= htmlspecialchars($row['shift']) ?></td>
                    <td><?= htmlspecialchars($row['no_telp']) ?></td>
                    <td>
                        <a href="petugas/edit_petugas.php?id=<?= $row['id_petugas'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="?hapus_petugas=<?= $row['id_petugas'] ?>" class="action-btn delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <main>
        <h2>Petugas Keberangkatan</h2>
        <a href="petugas/tambah_petugas_keberangkatan.php" class="action-btn" style="background-color: #28a745; color: white; margin-bottom: 1rem;">Tambah Petugas</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Petugas</th>
                    <th>Tugas</th>
                    <th>ID Keberangkatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result0->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['tugas']) ?></td>
                    <td><?= htmlspecialchars($row['id_keberangkatan']) ?></td>
                    <td data-status="<?= htmlspecialchars($row['status']) ?>">
                        <?= htmlspecialchars($row['status']) ?>
                    </td>
                    <td>
                        <a href="petugas/edit_petugas_keberangkatan.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="?hapus_keberangkatan=<?= $row['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <main>
        <h2>Petugas Kedatangan</h2>
        <a href="petugas/tambah_petugas_kedatangan.php" class="action-btn" style="background-color: #28a745; color: white; margin-bottom: 1rem;">Tambah Petugas</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Petugas</th>
                    <th>Tugas</th>
                    <th>ID Kedatangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result1->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['tugas']) ?></td>
                    <td><?= htmlspecialchars($row['id_kedatangan']) ?></td>
                    <td data-status="<?= htmlspecialchars($row['status']) ?>">
                        <?= htmlspecialchars($row['status']) ?>
                    </td>
                    <td>
                        <a href="petugas/edit_petugas_kedatangan.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="?hapus_kedatangan=<?= $row['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>