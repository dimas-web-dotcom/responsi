<?php
    include 'db.php';

    // Query untuk mendapatkan data keuntungan per hari
    $sql = "SELECT 
                DAY(t.tanggal_pesan) as hari,
                SUM(r.harga_tiket) as total
            FROM tiket t
            JOIN jadwal j ON t.id_jadwal = j.id_jadwal
            JOIN rute r ON j.id_rute = r.id_rute
            WHERE t.status_pembayaran = 'Lunas'
            GROUP BY DAY(t.tanggal_pesan)
            ORDER BY hari";

    $result = $conn->query($sql);

    $daysNames = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
    $profitData = array_fill(0, 31, 0); // Inisialisasi array 31 hari dengan nilai 0

    while ($row = $result->fetch_assoc()) {
        $dayIndex = $row['hari'] - 1; // Konversi hari (1-31) ke index array (0-30)
        $profitData[$dayIndex] = $row['total'] / 1000000; // Konversi ke juta Rupiah
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUSHY-APP</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="desc">
            <img src="images/bus.jpg" alt="" srcset="" width="100%" height="300">
            <h2>BUSHY-APP</h2>
            <p>BUSHY-APP adalah sebuah sistem manajemen transportasi bus yang dirancang untuk memudahkan pengelolaan operasional perusahaan bus, mulai dari pendataan penumpang, penjadwalan rute, penjualan tiket, hingga pemantauan keberangkatan dan kedatangan bus. Aplikasi ini menyediakan solusi terintegrasi bagi operator bus untuk mengoptimalkan efisiensi operasional, meningkatkan pelayanan kepada penumpang, dan menganalisis performa bisnis melalui visualisasi data.</p>
        </div>

        <div class="marginGross">
            <h2>Grafik Keuntungan</h2>
            <div class="graph-container">
                <canvas id="profitChart"></canvas>
            </div>
        </div>

        <div class="tech-stack">
            <h2>Technology Stack</h2>
            <div class="tech-container">
                <!-- HTML Card -->
                <div class="tech-card">
                    <div class="tech-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732212.png" alt="HTML5 Logo">
                    </div>
                    <div class="tech-name">HTML5</div>
                </div>
                
                <!-- CSS Card -->
                <div class="tech-card">
                    <div class="tech-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732190.png" alt="CSS3 Logo">
                    </div>
                    <div class="tech-name">CSS3</div>
                </div>
                
                <!-- JavaScript Card -->
                <div class="tech-card">
                    <div class="tech-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/5968/5968292.png" alt="JavaScript Logo">
                    </div>
                    <div class="tech-name">JavaScript</div>
                </div>
                
                <!-- MySQL Card -->
                <div class="tech-card">
                    <div class="tech-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/1199/1199128.png" alt="MySQL Logo">
                    </div>
                    <div class="tech-name">MySQL</div>
                </div>

                <!-- PHP Card -->
                <div class="tech-card">
                    <div class="tech-icon">
                        <img src="https://img.icons8.com/?size=100&id=XNQU0Xcm2I9s&format=png&color=000000" alt="PHP Logo">
                    </div>
                    <div class="tech-name">PHP</div>
                </div>
            </div>
        </div>

    </div>

    <footer>
        <p>© 2025 BUSHY-APP - Dimas Setiawan - All Rights Reserved</p>
        <a href="https://www.instagram.com/mylife.re_d/">
            <img src="https://img.icons8.com/?size=100&id=32292&format=png&color=ffffff" alt="instagram" width="25px">
        </a>        
    </footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profitData = {
            labels: <?php echo json_encode($daysNames); ?>,
            datasets: [{
                label: 'Keuntungan (dalam juta Rp)',
                data: <?php echo json_encode($profitData); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: profitData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Keuntungan Harian BUSHY-APP'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah (juta Rp)'
                        }
                    }
                }
            },
        };

        const profitChart = new Chart(
            document.getElementById('profitChart'),
            config
        );
    });
</script>
</body>
</html>