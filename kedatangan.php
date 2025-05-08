<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kedatangan - BUSHY-APP</title>
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
        td[data-status="Tepat Waktu"] {
            color: #28a745;
            font-weight: 600;
        }

        td[data-status="Terlambat"] {
            color: #dc3545;
            font-weight: 600;
        }

        td[data-status="Dalam Perjalanan"] {
            color: #ffc107;
            font-weight: 600;
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

    <main>
        <h2>Data Kedatangan Bus</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Kedatangan</th>
                    <th>ID Jadwal</th>
                    <th>Terminal Tujuan</th>
                    <th>Waktu Kedatangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM vw_status_kedatangan";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_kedatangan']) ?></td>
                    <td><?= htmlspecialchars($row['id_jadwal']) ?></td>
                    <td><?= htmlspecialchars($row['nama_terminal']) ?></td>
                    <td><?= htmlspecialchars($row['waktu_kedatangan']) ?></td>
                    <td data-status="<?= htmlspecialchars($row['status']) ?>">
                        <?= htmlspecialchars($row['status']) ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>