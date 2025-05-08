<?php include 'db.php';
$sql = "SELECT t.*, p.nama, j.tanggal_berangkat 
        FROM tiket t 
        JOIN penumpang p ON t.id_penumpang = p.id_penumpang 
        JOIN jadwal j ON t.id_jadwal = j.id_jadwal";
$result = $conn->query($sql); 

$sql2 = "SELECT * FROM vw_tiket_dan_penumpang";
$result2 = $conn->query($sql2);

// Get passengers and schedules for dropdowns
$passengers = $conn->query("SELECT id_penumpang, nama FROM penumpang");
// Benar: ambil dari tabel jadwal, dan JOIN ke rute untuk tampilkan info rutenya
$schedules = $conn->query("
    SELECT j.id_jadwal, CONCAT(r.kota_asal, ' - ', r.kota_tujuan, ' | ', j.tanggal_berangkat) AS detail 
    FROM jadwal j 
    JOIN rute r ON j.id_rute = r.id_rute
");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tiket - BUSHY-APP</title>
    <link rel="stylesheet" href="style/tiket.css">
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
        <button class="add-btn" onclick="openModal()">+ Tambah Tiket Baru</button>
        
        <h2>Data Tiket Penumpang</h2>
        <!-- Pada file tiket.php, ganti bagian tabel pertama dengan ini -->
        <table>
            <thead>
                <tr>
                    <th>ID Tiket</th>
                    <th>Penumpang</th>
                    <th>Tanggal Pesan</th>
                    <th>No Kursi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_tiket']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_pesan']) ?></td>
                    <td><?= htmlspecialchars($row['nomor_kursi']) ?></td>
                    <td data-status="<?= htmlspecialchars($row['status_pembayaran']) ?>">
                        <?= htmlspecialchars($row['status_pembayaran']) ?>
                    </td>
                    <td>
                        <button class="edit-btn" onclick="openEditModal('<?= $row['id_tiket'] ?>', '<?= $row['status_pembayaran'] ?>')">
                            Edit Status
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Data Tiket dan Penumpang</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Tiket</th>
                    <th>Nama Penumpang</th>
                    <th>Nomor Kursi</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Keberangkatan</th>
                    <th>Rute</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result2->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_tiket']) ?></td>
                    <td><?= htmlspecialchars($row['nama_penumpang']) ?></td>
                    <td><?= htmlspecialchars($row['nomor_kursi']) ?></td>
                    <td data-status="<?= htmlspecialchars($row['status_pembayaran']) ?>">
                        <?= htmlspecialchars($row['status_pembayaran']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['tanggal_berangkat']) ?></td>
                    <td><?= htmlspecialchars($row['kota_asal']) ?> - <?= htmlspecialchars($row['kota_tujuan']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Add Ticket Modal -->
    <div id="addTicketModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Tambah Tiket Baru</h2>
            <form action="tiketFunction/add_ticket.php" method="POST">
                <div class="form-group">
                    <label for="penumpang">Penumpang:</label>
                    <select id="penumpang" name="id_penumpang" required>
                        <option value="">Pilih Penumpang</option>
                        <?php while ($passenger = $passengers->fetch_assoc()): ?>
                        <option value="<?= $passenger['id_penumpang'] ?>"><?= htmlspecialchars($passenger['nama']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="jadwal">Rute:</label>
                    <select id="jadwal" name="id_jadwal" required>
                        <option value="">Pilih Rute</option>
                        <?php while ($schedule = $schedules->fetch_assoc()): ?>
                        <!-- Sesuai foreign key: value = id_jadwal -->
                        <option value="<?= $schedule['id_jadwal'] ?>"><?= htmlspecialchars($schedule['detail']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tanggal_pesan">Tanggal Pesan:</label>
                    <input type="datetime-local" id="tanggal_pesan" name="tanggal_pesan" required>
                </div>
                
                <div class="form-group">
                    <label for="nomor_kursi">Nomor Kursi:</label>
                    <input type="text" id="nomor_kursi" name="nomor_kursi" required>
                </div>
                
                <div class="form-group">
                    <label for="status_pembayaran">Status Pembayaran:</label>
                    <select id="status_pembayaran" name="status_pembayaran" required>
                        <option value="Lunas">Lunas</option>
                        <option value="Pending">Pending</option>
                        <option value="Batal">Batal</option>
                    </select>
                </div>
                
                <button type="submit" class="submit-btn">Simpan Tiket</button>
            </form>
        </div>
    </div>

    <!-- Edit Status Modal -->
    <div id="editStatusModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Status Pembayaran</h2>
            <form action="tiketFunction/update_status.php" method="POST">
                <input type="hidden" id="edit_tiket_id" name="id_tiket">
                
                <div class="form-group">
                    <label for="edit_status">Status Pembayaran:</label>
                    <select id="edit_status" name="status_pembayaran" required>
                        <option value="Lunas">Lunas</option>
                        <option value="Pending">Pending</option>
                        <option value="Batal">Batal</option>
                    </select>
                </div>
                
                <button type="submit" class="submit-btn">Update Status</button>
            </form>
        </div>
    </div>
    
    <script>
        // Modal functions
        function openModal() {
            document.getElementById('addTicketModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('addTicketModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('addTicketModal');
            if (event.target == modal) {
                closeModal();
            }
        }


        // Fungsi untuk membuka modal edit
        function openEditModal(tiketId, currentStatus) {
            document.getElementById('edit_tiket_id').value = tiketId;
            document.getElementById('edit_status').value = currentStatus;
            document.getElementById('editStatusModal').style.display = 'block';
        }

        // Fungsi untuk menutup modal edit
        function closeEditModal() {
            document.getElementById('editStatusModal').style.display = 'none';
        }

        // Tambahkan di window.onclick untuk menutup modal edit
        window.onclick = function(event) {
            var modal = document.getElementById('addTicketModal');
            var editModal = document.getElementById('editStatusModal');
            
            if (event.target == modal) {
                closeModal();
            }
            if (event.target == editModal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>