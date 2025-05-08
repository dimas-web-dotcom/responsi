<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Keberangkatan - BUSHY-APP</title>
    <link rel="stylesheet" href="style/keberangkatan.css">
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
        <h2>Data Keberangkatan</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Terminal</th>
                    <th>Jam Berangkat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT k.*, t.nama_terminal, j.jam_berangkat 
                        FROM keberangkatan k
                        JOIN terminal t ON k.id_terminal = t.id_terminal
                        JOIN jadwal j ON k.id_jadwal = j.id_jadwal";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_keberangkatan']) ?></td>
                    <td><?= htmlspecialchars($row['nama_terminal']) ?></td>
                    <td><?= htmlspecialchars($row['jam_berangkat']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>