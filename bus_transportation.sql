-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 04:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus_transportation`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_penumpang_dan_tiket` (IN `p_id_penumpang` VARCHAR(50))   BEGIN
    DELETE FROM tiket WHERE id_penumpang = p_id_penumpang;
    DELETE FROM penumpang WHERE id_penumpang = p_id_penumpang;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_jadwal` (IN `p_id_bus` VARCHAR(50), IN `p_tanggal` DATE, IN `p_berangkat` TIME, IN `p_tiba` TIME, IN `p_rute` VARCHAR(50))   BEGIN
    DECLARE new_id VARCHAR(50);
    
    -- Generate ID otomatis
    SET new_id = generate_id_jadwal();
    
    INSERT INTO jadwal (id_jadwal, id_bus, tanggal_berangkat, jam_berangkat, jam_tiba, id_rute)
    VALUES (new_id, p_id_bus, p_tanggal, p_berangkat, p_tiba, p_rute);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_penumpang` (IN `p_nama` VARCHAR(100), IN `p_ktp` VARCHAR(20), IN `p_jk` VARCHAR(10), IN `p_telp` VARCHAR(20))   BEGIN
    DECLARE new_id VARCHAR(50);
    
    -- Generate ID otomatis
    SET new_id = generate_penumpang_id();
    
    INSERT INTO penumpang (id_penumpang, nama, no_ktp, jenis_kelamin, no_telp)
    VALUES (new_id, p_nama, p_ktp, p_jk, p_telp);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_petugas` (IN `p_nama` VARCHAR(100), IN `p_jabatan` VARCHAR(50), IN `p_shift` VARCHAR(20), IN `p_no_telp` VARCHAR(20))   BEGIN 
    DECLARE new_id VARCHAR(50);
    SET new_id = generate_id_petugas();
    
    INSERT INTO petugas (id_petugas, nama, jabatan, shift, no_telp)
    VALUES (new_id, p_nama, p_jabatan, p_shift, p_no_telp);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_petugas_keberangkatan` (IN `p_id_petugas` VARCHAR(50), IN `p_tugas` VARCHAR(100), IN `p_id_keberangkatan` VARCHAR(50))   BEGIN
    DECLARE new_id VARCHAR(50);
    
    -- Generate ID otomatis
    SET new_id = generate_id_petugas_keberangkatan();
    
    -- Insert data baru
    INSERT INTO petugas_keberangkatan (id, id_petugas, tugas, id_keberangkatan)
    VALUES (new_id, p_id_petugas, p_tugas, p_id_keberangkatan);
    
    -- Update status keberangkatan jika perlu
    UPDATE keberangkatan SET status = 'Dalam Proses' 
    WHERE id_keberangkatan = p_id_keberangkatan;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_petugas_kedatangan` (IN `p_id_petugas` VARCHAR(50), IN `p_tugas` VARCHAR(100), IN `p_id_kedatangan` VARCHAR(50))   BEGIN
    DECLARE new_id VARCHAR(50);
    
    -- Generate ID otomatis
    SET new_id = generate_id_petugas_kedatangan();
    
    -- Insert data baru
    INSERT INTO petugas_kedatangan (id, id_petugas, tugas, id_kedatangan)
    VALUES (new_id, p_id_petugas, p_tugas, p_id_kedatangan);
    
    -- Update status kedatangan jika perlu
    UPDATE kedatangan SET status = 'Dalam Proses' 
    WHERE id_kedatangan = p_id_kedatangan;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_rute` (IN `p_kota_asal` VARCHAR(100), IN `p_kota_tujuan` VARCHAR(100), IN `p_jarak_km` VARCHAR(50), IN `p_estimasi_waktu` VARCHAR(50), IN `p_harga_tiket` FLOAT)   BEGIN
    DECLARE new_id VARCHAR(50);
    
    -- Generate ID otomatis
    SET new_id = generate_id_rute();
    
    INSERT INTO rute (id_rute, kota_asal, kota_tujuan, jarak_km, estimasi_waktu, harga_tiket)
    VALUES (new_id, p_kota_asal, p_kota_tujuan, p_jarak_km, p_estimasi_waktu, p_harga_tiket);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_bus_info` (IN `p_id_bus` VARCHAR(50), IN `p_polisi` VARCHAR(20), IN `p_kapasitas` INT, IN `p_tipe` VARCHAR(50))   BEGIN
    UPDATE bus
    SET nomor_polisi = p_polisi,
        kapasitas = p_kapasitas,
        tipe_bus = p_tipe
    WHERE id_bus = p_id_bus;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_status_pembayaran` (IN `p_id_tiket` VARCHAR(50), IN `p_status` VARCHAR(20))   BEGIN
    UPDATE tiket SET status_pembayaran = p_status WHERE id_tiket = p_id_tiket;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_jadwal` () RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(50);

    -- Mencari ID jadwal terbesar yang ada
    SELECT IFNULL(MAX(CAST(SUBSTRING(id_jadwal, 2) AS UNSIGNED)), 0) INTO max_id
    FROM jadwal
    WHERE id_jadwal REGEXP '^J[0-9]+$';
    
    -- Menambahkan 1 ke ID terbesar
    SET max_id = max_id + 1;
    
    -- Format ID baru dengan leading zeros
    SET new_id = CONCAT('J', LPAD(max_id, 3, '0'));
    
    RETURN new_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_keberangkatan` () RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(50);

    SELECT IFNULL(MAX(CAST(SUBSTRING(id_keberangkatan, 2) AS UNSIGNED)), 0) INTO max_id
    FROM keberangkatan
    WHERE id_keberangkatan REGEXP '^K[0-9]+$';
    
    SET max_id = max_id + 1;
    
    SET new_id = CONCAT('K', LPAD(max_id, 3, '0'));
    
    RETURN new_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_petugas` () RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(50);

    -- Mencari ID petugas terbesar yang ada
    SELECT IFNULL(MAX(CAST(SUBSTRING(id_petugas, 3) AS UNSIGNED)), 0) INTO max_id
    FROM petugas
    WHERE id_petugas REGEXP '^PT[0-9]+$';
    
    -- Menambahkan 1 ke ID terbesar
    SET max_id = max_id + 1;
    
    -- Format ID baru dengan leading zeros
    SET new_id = CONCAT('PT', LPAD(max_id, 3, '0'));
    
    RETURN new_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_petugas_keberangkatan` () RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(50);

    -- Mencari ID petugas keberangkatan terbesar yang ada
    SELECT IFNULL(MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)), 0) INTO max_id
    FROM petugas_keberangkatan
    WHERE id REGEXP '^PK[0-9]+$';
    
    -- Menambahkan 1 ke ID terbesar
    SET max_id = max_id + 1;
    
    -- Format ID baru dengan leading zeros
    SET new_id = CONCAT('PK', LPAD(max_id, 3, '0'));
    
    RETURN new_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_petugas_kedatangan` () RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(50);

    -- Mencari ID petugas kedatangan terbesar yang ada
    SELECT IFNULL(MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)), 0) INTO max_id
    FROM petugas_kedatangan
    WHERE id REGEXP '^PD[0-9]+$';
    
    -- Menambahkan 1 ke ID terbesar
    SET max_id = max_id + 1;
    
    -- Format ID baru dengan leading zeros
    SET new_id = CONCAT('PD', LPAD(max_id, 3, '0'));
    
    RETURN new_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_rute` () RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(50);

    -- Mencari ID rute terbesar yang ada
    SELECT IFNULL(MAX(CAST(SUBSTRING(id_rute, 2) AS UNSIGNED)), 0) INTO max_id
    FROM rute
    WHERE id_rute REGEXP '^R[0-9]+$';
    
    -- Menambahkan 1 ke ID terbesar
    SET max_id = max_id + 1;
    
    -- Format ID baru dengan leading zeros
    SET new_id = CONCAT('R', LPAD(max_id, 3, '0'));
    
    RETURN new_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_tiket` () RETURNS VARCHAR(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE new_id VARCHAR(10);
    DECLARE last_id VARCHAR(10);
    DECLARE last_num INT;

    SELECT id_tiket INTO last_id
    FROM tiket
    WHERE id_tiket LIKE 'TK%'
    ORDER BY id_tiket DESC
    LIMIT 1;

    IF last_id IS NULL THEN
        SET last_num = 1;
    ELSE
        SET last_num = CAST(SUBSTRING(last_id, 3) AS UNSIGNED) + 1;
    END IF;

    SET new_id = CONCAT('TK', LPAD(last_num, 3, '0'));
    RETURN new_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_penumpang_id` () RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(50);

-- Mencari ID penumpang terbesar yang ada
SELECT IFNULL(MAX(CAST(SUBSTRING(id_penumpang, 2) AS UNSIGNED)), 0) INTO max_id
FROM penumpang
WHERE id_penumpang REGEXP '^P[0-9]+$';
    
-- Menambahkan 1 ke ID terbesar
SET max_id = max_id + 1;
    
-- Format ID baru dengan leading zeros
SET new_id = CONCAT('P', LPAD(max_id, 3, '0'));
    
    RETURN new_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_pendapatan_jadwal` (`p_jadwal` VARCHAR(50)) RETURNS FLOAT DETERMINISTIC BEGIN
    DECLARE pendapatan FLOAT;
    SELECT COUNT(*) * r.harga_tiket INTO pendapatan
    FROM tiket t
    JOIN jadwal j ON t.id_jadwal = j.id_jadwal
    JOIN rute r ON j.id_rute = r.id_rute
    WHERE t.id_jadwal = p_jadwal;
    RETURN pendapatan;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `id_bus` varchar(50) NOT NULL,
  `nomor_polisi` varchar(20) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `id_perusahaan` varchar(50) DEFAULT NULL,
  `tipe_bus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`id_bus`, `nomor_polisi`, `kapasitas`, `id_perusahaan`, `tipe_bus`) VALUES
('B001', 'B1234CD', 50, 'PR001', 'Eksekutif'),
('B002', 'B2345EF', 45, 'PR002', 'Bisnis'),
('B003', 'B3456GH', 40, 'PR003', 'Ekonomi'),
('B004', 'B4567IJ', 55, 'PR004', 'Eksekutif'),
('B005', 'B5678KL', 50, 'PR005', 'Bisnis'),
('B006', 'B6789MN', 45, 'PR006', 'Ekonomi'),
('B007', 'B7890OP', 60, 'PR007', 'Eksekutif'),
('B008', 'B8901QR', 55, 'PR008', 'Bisnis'),
('B009', 'B9012ST', 50, 'PR009', 'Ekonomi'),
('B010', 'B0123UV', 45, 'PR010', 'Eksekutif');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` varchar(50) NOT NULL,
  `id_bus` varchar(50) DEFAULT NULL,
  `tanggal_berangkat` date DEFAULT NULL,
  `jam_berangkat` time DEFAULT NULL,
  `jam_tiba` time DEFAULT NULL,
  `id_rute` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_bus`, `tanggal_berangkat`, `jam_berangkat`, `jam_tiba`, `id_rute`) VALUES
('J001', 'B001', '2025-05-01', '08:00:00', '11:00:00', 'R001'),
('J002', 'B002', '2025-06-01', '10:00:00', '18:00:00', 'R002'),
('J003', 'B003', '2025-06-02', '09:00:00', '16:00:00', 'R003'),
('J004', 'B004', '2025-06-02', '07:00:00', '14:00:00', 'R004'),
('J005', 'B005', '2025-06-03', '06:00:00', '15:00:00', 'R005'),
('J006', 'B006', '2025-06-03', '08:00:00', '18:00:00', 'R006'),
('J007', 'B007', '2025-06-04', '07:00:00', '13:00:00', 'R007'),
('J008', 'B008', '2025-06-04', '09:00:00', '17:00:00', 'R008'),
('J009', 'B009', '2025-06-05', '10:00:00', '22:00:00', 'R009'),
('J010', 'B010', '2025-06-05', '08:00:00', '11:00:00', 'R010');

-- --------------------------------------------------------

--
-- Table structure for table `keberangkatan`
--

CREATE TABLE `keberangkatan` (
  `id_keberangkatan` varchar(50) NOT NULL,
  `id_jadwal` varchar(50) DEFAULT NULL,
  `waktu_keberangkatan` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `id_terminal` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keberangkatan`
--

INSERT INTO `keberangkatan` (`id_keberangkatan`, `id_jadwal`, `waktu_keberangkatan`, `status`, `id_terminal`) VALUES
('K001', 'J001', '2023-06-01 07:45:00', 'Berangkat', 'T001'),
('K002', 'J002', '2023-06-01 09:45:00', 'Berangkat', 'T002'),
('K003', 'J003', '2023-06-02 08:45:00', 'Berangkat', 'T003'),
('K004', 'J004', '2023-06-02 06:45:00', 'Berangkat', 'T004'),
('K005', 'J005', '2023-06-03 05:45:00', 'Berangkat', 'T005'),
('K006', 'J006', '2023-06-03 07:45:00', 'Berangkat', 'T006'),
('K007', 'J007', '2023-06-04 06:45:00', 'Berangkat', 'T007'),
('K008', 'J008', '2023-06-04 08:45:00', 'Berangkat', 'T008'),
('K009', 'J009', '2023-06-05 09:45:00', 'Berangkat', 'T009'),
('K010', 'J010', '2023-06-05 07:45:00', 'Berangkat', 'T010');

-- --------------------------------------------------------

--
-- Table structure for table `kedatangan`
--

CREATE TABLE `kedatangan` (
  `id_kedatangan` varchar(50) NOT NULL,
  `id_jadwal` varchar(50) DEFAULT NULL,
  `id_terminal` varchar(50) DEFAULT NULL,
  `waktu_kedatangan` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kedatangan`
--

INSERT INTO `kedatangan` (`id_kedatangan`, `id_jadwal`, `id_terminal`, `waktu_kedatangan`, `status`) VALUES
('D001', 'J001', 'T002', '2025-05-08 11:15:00', 'Tiba'),
('D002', 'J002', 'T003', '2023-06-01 18:15:00', 'Tiba'),
('D003', 'J003', 'T004', '2023-06-02 16:15:00', 'Tiba'),
('D004', 'J004', 'T005', '2023-06-02 14:15:00', 'Tiba'),
('D005', 'J005', 'T006', '2023-06-03 15:15:00', 'Tiba'),
('D006', 'J006', 'T003', '2023-06-03 18:15:00', 'Tiba'),
('D007', 'J007', 'T008', '2023-06-04 13:15:00', 'Tiba'),
('D008', 'J008', 'T007', '2023-06-04 17:15:00', 'Tiba'),
('D009', 'J009', 'T006', '2023-06-05 22:15:00', 'Tiba'),
('D010', 'J010', 'T008', '2023-06-05 11:15:00', 'Tiba');

-- --------------------------------------------------------

--
-- Table structure for table `penumpang`
--

CREATE TABLE `penumpang` (
  `id_penumpang` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_ktp` varchar(20) DEFAULT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penumpang`
--

INSERT INTO `penumpang` (`id_penumpang`, `nama`, `no_ktp`, `jenis_kelamin`, `no_telp`) VALUES
('P001', 'Budi Santoso', '1234567890123456', 'Laki-laki', '081234567890'),
('P002', 'Ani Wijaya', '2345678901234567', 'Perempuan', '082345678901'),
('P003', 'Citra Dewi', '3456789012345678', 'Perempuan', '083456789012'),
('P004', 'Dodi Pratama', '4567890123456789', 'Laki-laki', '084567890123'),
('P005', 'Eka Putri', '5678901234567890', 'Perempuan', '085678901234'),
('P006', 'Fajar Nugroho', '6789012345678901', 'Laki-laki', '086789012345'),
('P007', 'Gita Sari', '7890123456789012', 'Perempuan', '087890123456'),
('P008', 'Hadi Susanto', '8901234567890123', 'Laki-laki', '088901234567'),
('P009', 'Indah Permata', '9012345678901234', 'Perempuan', '089012345678'),
('P010', 'Joko Widodo', '0123456789012345', 'Laki-laki', '080123456789');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` varchar(50) NOT NULL,
  `nama_perusahaan` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `nama_perusahaan`, `alamat`, `no_telp`, `email`) VALUES
('PR001', 'Sinar Jaya', 'Jl. Merdeka No.12, Jakarta', '0211234567', 'sinarjaya@bus.com'),
('PR002', 'Pahala Kencana', 'Jl. Sudirman No.45, Bandung', '0222345678', 'pahala@bus.com'),
('PR003', 'Rosalia Indah', 'Jl. Pemuda No.78, Surabaya', '0313456789', 'rosalia@bus.com'),
('PR004', 'Handoyo', 'Jl. Gatot Subroto No.34, Semarang', '0244567890', 'handoyo@bus.com'),
('PR005', 'Safari Dharma Raya', 'Jl. Pahlawan No.56, Yogyakarta', '0275678901', 'safari@bus.com'),
('PR006', 'Kramat Djati', 'Jl. Asia Afrika No.89, Bandung', '0226789012', 'kramat@bus.com'),
('PR007', 'Lorena', 'Jl. Diponegoro No.23, Semarang', '0247890123', 'lorena@bus.com'),
('PR008', 'Budiman', 'Jl. Ahmad Yani No.67, Surabaya', '0318901234', 'budiman@bus.com'),
('PR009', 'Efisiensi', 'Jl. Thamrin No.90, Jakarta', '0219012345', 'efisiensi@bus.com'),
('PR010', 'Haryanto', 'Jl. Malioboro No.11, Yogyakarta', '0270123456', 'haryanto@bus.com');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `shift` varchar(20) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama`, `jabatan`, `shift`, `no_telp`) VALUES
('PT001', 'Ahmad Fauzi', 'Manager', 'Pagi', '08111222333'),
('PT002', 'Bambang Sutrisno', 'Supervisor', 'Siang', '08222333444'),
('PT003', 'Cindy Angelina', 'Staff', 'Malam', '08333444555'),
('PT004', 'Dewi Kusuma', 'Staff', 'Pagi', '08444555666'),
('PT005', 'Eko Prasetyo', 'Driver', 'Siang', '08555666777'),
('PT006', 'Fitriani', 'Staff', 'Malam', '08666777888'),
('PT007', 'Gunawan', 'Security', 'Pagi', '08777888999'),
('PT008', 'Hesti Rahayu', 'Staff', 'Siang', '08888999000'),
('PT009', 'Irfan Maulana', 'Driver', 'Malam', '08999000111'),
('PT010', 'Joko Susilo', 'Cleaning Service', 'Pagi', '08000111222');

-- --------------------------------------------------------

--
-- Table structure for table `petugas_keberangkatan`
--

CREATE TABLE `petugas_keberangkatan` (
  `id` varchar(50) NOT NULL,
  `id_keberangkatan` varchar(50) DEFAULT NULL,
  `tugas` varchar(100) DEFAULT NULL,
  `id_petugas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas_keberangkatan`
--

INSERT INTO `petugas_keberangkatan` (`id`, `id_keberangkatan`, `tugas`, `id_petugas`) VALUES
('PK001', 'K001', 'Pengecekan tiket', 'PT001'),
('PK002', 'K002', 'Pengecekan bagasi', 'PT002'),
('PK003', 'K003', 'Panduan penumpang', 'PT003'),
('PK004', 'K004', 'Pengecekan tiket', 'PT004'),
('PK005', 'K005', 'Pengecekan bagasi', 'PT005'),
('PK006', 'K006', 'Panduan penumpang', 'PT006'),
('PK007', 'K007', 'Pengecekan tiket', 'PT007'),
('PK008', 'K008', 'Pengecekan bagasi', 'PT008'),
('PK009', 'K009', 'Panduan penumpang', 'PT009'),
('PK010', 'K010', 'Pengecekan tiket', 'PT010');

-- --------------------------------------------------------

--
-- Table structure for table `petugas_kedatangan`
--

CREATE TABLE `petugas_kedatangan` (
  `id` varchar(50) NOT NULL,
  `id_kedatangan` varchar(50) DEFAULT NULL,
  `tugas` varchar(100) DEFAULT NULL,
  `id_petugas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas_kedatangan`
--

INSERT INTO `petugas_kedatangan` (`id`, `id_kedatangan`, `tugas`, `id_petugas`) VALUES
('PD001', 'D001', 'Penyambutan penumpang', 'PT001'),
('PD002', 'D002', 'Penanganan bagasi', 'PT002'),
('PD003', 'D003', 'Panduan penumpang', 'PT003'),
('PD004', 'D004', 'Penyambutan penumpang', 'PT004'),
('PD005', 'D005', 'Penanganan bagasi', 'PT005'),
('PD006', 'D006', 'Panduan penumpang', 'PT006'),
('PD007', 'D007', 'Penyambutan penumpang', 'PT007'),
('PD008', 'D008', 'Penanganan bagasi', 'PT008'),
('PD009', 'D009', 'Panduan penumpang', 'PT009'),
('PD010', 'D010', 'Penyambutan penumpang', 'PT010');

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `id_rute` varchar(50) NOT NULL,
  `kota_asal` varchar(100) DEFAULT NULL,
  `kota_tujuan` varchar(100) DEFAULT NULL,
  `jarak_km` varchar(50) DEFAULT NULL,
  `estimasi_waktu` varchar(50) DEFAULT NULL,
  `harga_tiket` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`id_rute`, `kota_asal`, `kota_tujuan`, `jarak_km`, `estimasi_waktu`, `harga_tiket`) VALUES
('R001', 'Jakarta', 'Bandung', '150 km', '3 jam', 100000),
('R002', 'Bandung', 'Yogyakarta', '400 km', '8 jam', 250000),
('R003', 'Yogyakarta', 'Surabaya', '325 km', '7 jam', 200000),
('R004', 'Surabaya', 'Semarang', '350 km', '7 jam', 220000),
('R005', 'Semarang', 'Jakarta', '450 km', '9 jam', 300000),
('R006', 'Jakarta', 'Yogyakarta', '550 km', '10 jam', 350000),
('R007', 'Bandung', 'Semarang', '300 km', '6 jam', 180000),
('R008', 'Yogyakarta', 'Bandung', '400 km', '8 jam', 250000),
('R009', 'Surabaya', 'Jakarta', '700 km', '12 jam', 400000),
('R010', 'Semarang', 'Yogyakarta', '100 km', '3 jam', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `terminal`
--

CREATE TABLE `terminal` (
  `id_terminal` varchar(50) NOT NULL,
  `nama_terminal` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `jumlah_peron` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal`
--

INSERT INTO `terminal` (`id_terminal`, `nama_terminal`, `kota`, `alamat`, `no_telp`, `jumlah_peron`) VALUES
('T001', 'Terminal Kampung Rambutan', 'Jakarta', 'Jl. Raya Bogor KM 12', '021112233', 15),
('T002', 'Terminal Leuwipanjang', 'Bandung', 'Jl. Soekarno Hatta No. 1', '022445566', 12),
('T003', 'Terminal Giwangan', 'Yogyakarta', 'Jl. Imogiri Timur KM 5', '027778899', 10),
('T004', 'Terminal Purabaya', 'Surabaya', 'Jl. Ahmad Yani No. 2', '031112233', 18),
('T005', 'Terminal Mangkang', 'Semarang', 'Jl. Raya Semarang-Kendal', '024445566', 14),
('T006', 'Terminal Kalideres', 'Jakarta', 'Jl. Daan Mogot KM 12', '021778899', 16),
('T007', 'Terminal Cicaheum', 'Bandung', 'Jl. Jend. H. Amir Machmud', '022112233', 11),
('T008', 'Terminal Jombor', 'Yogyakarta', 'Jl. Magelang KM 5', '027445566', 9),
('T009', 'Terminal Joyoboyo', 'Surabaya', 'Jl. Raya Darmo', '031778899', 13),
('T010', 'Terminal Terboyo', 'Semarang', 'Jl. Raya Terboyo', '024112233', 15);

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` varchar(50) NOT NULL,
  `id_penumpang` varchar(50) DEFAULT NULL,
  `nomor_kursi` varchar(10) DEFAULT NULL,
  `status_pembayaran` varchar(20) DEFAULT NULL,
  `tanggal_pesan` date DEFAULT NULL,
  `id_jadwal` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`id_tiket`, `id_penumpang`, `nomor_kursi`, `status_pembayaran`, `tanggal_pesan`, `id_jadwal`) VALUES
('TK001', 'P001', 'A1', 'Lunas', '2025-04-25', 'J001'),
('TK002', 'P002', 'B2', 'Lunas', '2025-04-25', 'J002'),
('TK003', 'P003', 'C3', 'Lunas', '2025-04-26', 'J003'),
('TK004', 'P004', 'D4', 'Lunas', '2025-04-26', 'J004'),
('TK005', 'P005', 'E5', 'Lunas', '2025-04-27', 'J005'),
('TK006', 'P006', 'F6', 'Lunas', '2025-04-27', 'J006'),
('TK007', 'P007', 'G7', 'Lunas', '2025-04-27', 'J007'),
('TK008', 'P008', 'H8', 'Lunas', '2025-04-27', 'J008'),
('TK009', 'P009', 'I9', 'Lunas', '2025-04-27', 'J009'),
('TK010', 'P010', 'J10', 'Lunas', '2025-04-27', 'J010'),
('TK012', 'P004', 'B5', 'Lunas', '2025-05-01', 'J008'),
('TK013', 'P001', 'B5', 'Lunas', '2025-05-09', 'J009');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_daftar_petugas`
-- (See below for the actual view)
--
CREATE TABLE `vw_daftar_petugas` (
`id_petugas` varchar(50)
,`nama` varchar(100)
,`jabatan` varchar(50)
,`shift` varchar(20)
,`no_telp` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_detail_jadwal`
-- (See below for the actual view)
--
CREATE TABLE `vw_detail_jadwal` (
`id_jadwal` varchar(50)
,`nomor_polisi` varchar(20)
,`kota_asal` varchar(100)
,`kota_tujuan` varchar(100)
,`tanggal_berangkat` date
,`jam_berangkat` time
,`jam_tiba` time
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_petugas_keberangkatan`
-- (See below for the actual view)
--
CREATE TABLE `vw_petugas_keberangkatan` (
`id` varchar(50)
,`nama` varchar(100)
,`tugas` varchar(100)
,`id_keberangkatan` varchar(50)
,`status` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_petugas_kedatangan`
-- (See below for the actual view)
--
CREATE TABLE `vw_petugas_kedatangan` (
`id` varchar(50)
,`nama` varchar(100)
,`tugas` varchar(100)
,`id_kedatangan` varchar(50)
,`status` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_status_kedatangan`
-- (See below for the actual view)
--
CREATE TABLE `vw_status_kedatangan` (
`id_kedatangan` varchar(50)
,`id_jadwal` varchar(50)
,`nama_terminal` varchar(100)
,`waktu_kedatangan` datetime
,`status` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_tiket_dan_penumpang`
-- (See below for the actual view)
--
CREATE TABLE `vw_tiket_dan_penumpang` (
`id_tiket` varchar(50)
,`nama_penumpang` varchar(100)
,`nomor_kursi` varchar(10)
,`status_pembayaran` varchar(20)
,`tanggal_berangkat` date
,`kota_asal` varchar(100)
,`kota_tujuan` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_total_tiket_per_penumpang`
-- (See below for the actual view)
--
CREATE TABLE `vw_total_tiket_per_penumpang` (
`id_penumpang` varchar(50)
,`nama` varchar(100)
,`total_tiket` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_daftar_petugas`
--
DROP TABLE IF EXISTS `vw_daftar_petugas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_daftar_petugas`  AS SELECT `petugas`.`id_petugas` AS `id_petugas`, `petugas`.`nama` AS `nama`, `petugas`.`jabatan` AS `jabatan`, `petugas`.`shift` AS `shift`, `petugas`.`no_telp` AS `no_telp` FROM `petugas` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_detail_jadwal`
--
DROP TABLE IF EXISTS `vw_detail_jadwal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_jadwal`  AS SELECT `j`.`id_jadwal` AS `id_jadwal`, `b`.`nomor_polisi` AS `nomor_polisi`, `r`.`kota_asal` AS `kota_asal`, `r`.`kota_tujuan` AS `kota_tujuan`, `j`.`tanggal_berangkat` AS `tanggal_berangkat`, `j`.`jam_berangkat` AS `jam_berangkat`, `j`.`jam_tiba` AS `jam_tiba` FROM ((`jadwal` `j` join `bus` `b` on(`j`.`id_bus` = `b`.`id_bus`)) join `rute` `r` on(`j`.`id_rute` = `r`.`id_rute`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_petugas_keberangkatan`
--
DROP TABLE IF EXISTS `vw_petugas_keberangkatan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_petugas_keberangkatan`  AS SELECT `pk`.`id` AS `id`, `pg`.`nama` AS `nama`, `pk`.`tugas` AS `tugas`, `k`.`id_keberangkatan` AS `id_keberangkatan`, `k`.`status` AS `status` FROM ((`petugas_keberangkatan` `pk` join `petugas` `pg` on(`pk`.`id_petugas` = `pg`.`id_petugas`)) join `keberangkatan` `k` on(`pk`.`id_keberangkatan` = `k`.`id_keberangkatan`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_petugas_kedatangan`
--
DROP TABLE IF EXISTS `vw_petugas_kedatangan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_petugas_kedatangan`  AS SELECT `pk`.`id` AS `id`, `pg`.`nama` AS `nama`, `pk`.`tugas` AS `tugas`, `k`.`id_kedatangan` AS `id_kedatangan`, `k`.`status` AS `status` FROM ((`petugas_kedatangan` `pk` join `petugas` `pg` on(`pk`.`id_petugas` = `pg`.`id_petugas`)) join `kedatangan` `k` on(`pk`.`id_kedatangan` = `k`.`id_kedatangan`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_status_kedatangan`
--
DROP TABLE IF EXISTS `vw_status_kedatangan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_status_kedatangan`  AS SELECT `kd`.`id_kedatangan` AS `id_kedatangan`, `j`.`id_jadwal` AS `id_jadwal`, `t`.`nama_terminal` AS `nama_terminal`, `kd`.`waktu_kedatangan` AS `waktu_kedatangan`, `kd`.`status` AS `status` FROM ((`kedatangan` `kd` join `jadwal` `j` on(`kd`.`id_jadwal` = `j`.`id_jadwal`)) join `terminal` `t` on(`kd`.`id_terminal` = `t`.`id_terminal`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_tiket_dan_penumpang`
--
DROP TABLE IF EXISTS `vw_tiket_dan_penumpang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tiket_dan_penumpang`  AS SELECT `t`.`id_tiket` AS `id_tiket`, `p`.`nama` AS `nama_penumpang`, `t`.`nomor_kursi` AS `nomor_kursi`, `t`.`status_pembayaran` AS `status_pembayaran`, `j`.`tanggal_berangkat` AS `tanggal_berangkat`, `r`.`kota_asal` AS `kota_asal`, `r`.`kota_tujuan` AS `kota_tujuan` FROM (((`tiket` `t` join `penumpang` `p` on(`t`.`id_penumpang` = `p`.`id_penumpang`)) join `jadwal` `j` on(`t`.`id_jadwal` = `j`.`id_jadwal`)) join `rute` `r` on(`j`.`id_rute` = `r`.`id_rute`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_total_tiket_per_penumpang`
--
DROP TABLE IF EXISTS `vw_total_tiket_per_penumpang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_total_tiket_per_penumpang`  AS SELECT `p`.`id_penumpang` AS `id_penumpang`, `p`.`nama` AS `nama`, count(`t`.`id_tiket`) AS `total_tiket` FROM (`penumpang` `p` left join `tiket` `t` on(`p`.`id_penumpang` = `t`.`id_penumpang`)) GROUP BY `p`.`id_penumpang`, `p`.`nama` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id_bus`),
  ADD KEY `id_perusahaan` (`id_perusahaan`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_bus` (`id_bus`),
  ADD KEY `id_rute` (`id_rute`);

--
-- Indexes for table `keberangkatan`
--
ALTER TABLE `keberangkatan`
  ADD PRIMARY KEY (`id_keberangkatan`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_terminal` (`id_terminal`);

--
-- Indexes for table `kedatangan`
--
ALTER TABLE `kedatangan`
  ADD PRIMARY KEY (`id_kedatangan`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_terminal` (`id_terminal`);

--
-- Indexes for table `penumpang`
--
ALTER TABLE `penumpang`
  ADD PRIMARY KEY (`id_penumpang`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `petugas_keberangkatan`
--
ALTER TABLE `petugas_keberangkatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_keberangkatan` (`id_keberangkatan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `petugas_kedatangan`
--
ALTER TABLE `petugas_kedatangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kedatangan` (`id_kedatangan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id_rute`);

--
-- Indexes for table `terminal`
--
ALTER TABLE `terminal`
  ADD PRIMARY KEY (`id_terminal`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `id_penumpang` (`id_penumpang`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bus`
--
ALTER TABLE `bus`
  ADD CONSTRAINT `bus_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`);

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_bus`) REFERENCES `bus` (`id_bus`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_rute`) REFERENCES `rute` (`id_rute`);

--
-- Constraints for table `keberangkatan`
--
ALTER TABLE `keberangkatan`
  ADD CONSTRAINT `keberangkatan_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`),
  ADD CONSTRAINT `keberangkatan_ibfk_2` FOREIGN KEY (`id_terminal`) REFERENCES `terminal` (`id_terminal`);

--
-- Constraints for table `kedatangan`
--
ALTER TABLE `kedatangan`
  ADD CONSTRAINT `kedatangan_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`),
  ADD CONSTRAINT `kedatangan_ibfk_2` FOREIGN KEY (`id_terminal`) REFERENCES `terminal` (`id_terminal`);

--
-- Constraints for table `petugas_keberangkatan`
--
ALTER TABLE `petugas_keberangkatan`
  ADD CONSTRAINT `petugas_keberangkatan_ibfk_1` FOREIGN KEY (`id_keberangkatan`) REFERENCES `keberangkatan` (`id_keberangkatan`),
  ADD CONSTRAINT `petugas_keberangkatan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);

--
-- Constraints for table `petugas_kedatangan`
--
ALTER TABLE `petugas_kedatangan`
  ADD CONSTRAINT `petugas_kedatangan_ibfk_1` FOREIGN KEY (`id_kedatangan`) REFERENCES `kedatangan` (`id_kedatangan`),
  ADD CONSTRAINT `petugas_kedatangan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`id_penumpang`) REFERENCES `penumpang` (`id_penumpang`),
  ADD CONSTRAINT `tiket_ibfk_2` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
