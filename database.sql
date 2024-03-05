-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 05, 2024 at 07:47 AM
-- Server version: 10.5.23-MariaDB-cll-lve
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maus6546_hasillautacn`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `idBarang` int(11) NOT NULL,
  `barKode` varchar(255) NOT NULL,
  `idSatuanBarang` int(11) NOT NULL,
  `namaBarang` varchar(255) NOT NULL,
  `hargaJual` int(11) NOT NULL,
  `hargaBeliPcs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`idBarang`, `barKode`, `idSatuanBarang`, `namaBarang`, `hargaJual`, `hargaBeliPcs`) VALUES
(1, '', 2, 'LYK', 40000, 32000),
(2, '', 2, 'Tawes', 48000, 34000),
(3, '', 2, 'Petek', 36000, 23000),
(4, '', 2, 'Buyer', 36000, 22000),
(5, '', 2, 'KBB Jumbo', 48000, 38000),
(6, '', 2, 'Cucut PK', 48000, 37000),
(7, '', 2, 'Lemet', 36000, 27500),
(8, '', 2, 'Betok', 48000, 33000),
(9, '', 2, 'Tambakang Kecil', 48000, 33000),
(10, '', 2, 'Gabus', 100000, 74000),
(11, '', 2, 'Pari', 48000, 32000),
(12, '', 2, 'Tapis Halus', 36000, 21000),
(13, '', 2, 'Tapis Sedang', 32000, 20000),
(14, '', 2, 'Siro', 36000, 25000),
(15, '', 2, 'Jp Belitung', 48000, 45000),
(16, '', 2, 'Lesi', 48000, 33000),
(17, '', 2, 'Keriting/ KRT', 48000, 36000),
(18, '', 2, 'Bandeng Belah', 36000, 19000),
(19, '', 2, 'Bandeng Bulet', 32000, 20000),
(20, '', 2, 'Koro', 36000, 22000),
(21, '', 2, 'Selar B4', 36000, 21000),
(22, '', 2, 'Jambrong Patau', 48000, 33000),
(23, '', 2, 'Jambrong Tiongbut', 48000, 33000),
(24, '', 2, 'Sepat JMB', 100000, 75000),
(25, '', 2, 'Sepat SSBB', 80000, 58000),
(26, '', 2, 'Jaer', 24000, 15000),
(27, '', 2, 'Teri Nasi', 100000, 73000),
(28, '', 2, 'Jengki B1', 60000, 42000),
(29, '', 2, 'Jengki Super Hitam/ Kecil', 48000, 36000),
(30, '', 2, 'Jengki Super Jawa/ Besar', 48000, 29000),
(31, '', 2, 'Jengki Thailand', 60000, 48000),
(32, '', 2, 'Jengki Belah', 72000, 39000),
(33, '', 2, 'Jengki Okang', 60000, 45000),
(34, '', 2, 'Jengki Madura', 60000, 48000),
(35, '', 2, 'Teri Pais', 36000, 25000),
(36, '', 2, 'Rebon Hepi', 52000, 40000),
(37, '', 2, 'Rebon Jeruk', 40000, 30000),
(38, '', 2, 'Rebon H', 32000, 18500),
(39, '', 2, 'Rebon HH', 30000, 17500),
(40, '', 2, 'Rebon HS', 36000, 19500),
(41, '', 2, 'Rebon GE', 40000, 20500),
(42, '', 2, 'Rebon GEE', 40000, 21500),
(43, '', 2, 'Tembang', 15000, 13500),
(44, '', 2, 'Belo', 13000, 9000),
(45, '', 2, 'Dengdeng', 36000, 23000),
(46, '', 2, 'COLEK TERASI', 20000, 17000),
(47, '', 4, 'PANANJUNG TERASI', 74000, 68000),
(48, '', 4, '69 TERASI', 74000, 68000),
(49, '', 4, 'Piring 69 TERASI', 105000, 98000),
(50, '', 2, 'Sotong', 100000, 85000),
(51, '', 2, 'Jambal Roti', 140000, 95000),
(53, '', 2, '2L MINYAK KITA', 25000, 24000),
(54, '', 3, '1L MINYAK KITA', 13000, 12000),
(55, '', 2, '1 TOP KBB', 45000, 42000),
(56, '', 2, 'SUPER JUMBO KBB', 48000, 40000),
(57, '', 2, 'Tambakang Besar', 52000, 45000),
(58, '', 2, 'Julung', 44000, 33000),
(59, '', 2, 'Kapasan', 72000, 51000),
(60, '', 2, 'Remis', 40000, 29000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang_masuk`
--

CREATE TABLE `tb_barang_masuk` (
  `idMasuk` int(11) NOT NULL,
  `tanggalMasuk` datetime NOT NULL,
  `noRef` int(11) NOT NULL,
  `idSupplier` int(11) NOT NULL,
  `ppn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_barang_masuk`
--

INSERT INTO `tb_barang_masuk` (`idMasuk`, `tanggalMasuk`, `noRef`, `idSupplier`, `ppn`) VALUES
(1, '2022-09-20 14:49:04', 0, 0, 0),
(2, '2022-09-29 09:04:54', 0, 0, 0),
(3, '2022-09-29 09:07:16', 0, 0, 0),
(4, '2022-09-29 09:07:59', 0, 5, 0),
(5, '2022-09-29 09:09:54', 0, 5, 0),
(6, '2022-09-29 09:11:53', 0, 5, 0),
(7, '2022-09-29 09:12:59', 0, 5, 0),
(8, '2022-09-29 09:14:06', 0, 5, 0),
(9, '2022-09-29 09:26:47', 0, 5, 0),
(10, '2022-09-29 09:29:11', 0, 0, 0),
(11, '2022-09-29 09:41:44', 0, 0, 0),
(12, '2022-09-29 09:45:08', 0, 5, 0),
(13, '2022-09-29 09:52:09', 0, 0, 0),
(14, '2022-09-29 09:57:33', 0, 5, 0),
(15, '2022-09-29 10:01:33', 0, 0, 0),
(16, '2022-09-29 10:05:53', 0, 5, 0),
(17, '2022-09-29 10:24:52', 0, 5, 0),
(18, '2022-09-29 10:27:56', 0, 0, 0),
(19, '2022-09-29 10:29:29', 0, 6, 0),
(20, '2022-09-29 10:30:59', 0, 1, 0),
(21, '2022-09-29 10:35:45', 0, 0, 0),
(22, '2022-09-29 10:39:05', 0, 3, 0),
(23, '2022-09-29 11:11:09', 0, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_discount`
--

CREATE TABLE `tb_discount` (
  `idDiscount` int(11) NOT NULL,
  `idMasuk` int(11) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_discount`
--

INSERT INTO `tb_discount` (`idDiscount`, `idMasuk`, `discount`) VALUES
(2, 4, 0),
(3, 5, 0),
(4, 6, 0),
(5, 7, 0),
(6, 8, 0),
(8, 9, 0),
(9, 12, 0),
(10, 14, 0),
(11, 16, 0),
(12, 17, 0),
(13, 19, 0),
(14, 20, 0),
(15, 22, 0),
(16, 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_history_bayar`
--

CREATE TABLE `tb_history_bayar` (
  `idHistory` int(11) NOT NULL,
  `idMasuk` int(11) NOT NULL,
  `tanggalBayar` date NOT NULL,
  `telahBayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_history_bayar`
--

INSERT INTO `tb_history_bayar` (`idHistory`, `idMasuk`, `tanggalBayar`, `telahBayar`) VALUES
(1, 4, '2022-09-29', 1584000),
(2, 5, '2022-09-29', 573500),
(3, 6, '2022-09-29', 1820000),
(4, 7, '2022-09-29', 1364000),
(5, 8, '2022-09-29', 812000),
(6, 9, '2022-09-29', 2000000),
(7, 12, '2022-09-29', 3748000),
(8, 14, '2022-09-29', 14247000),
(9, 16, '2022-09-29', 14584000),
(10, 17, '2022-09-29', 1293000),
(11, 19, '2022-09-29', 1440000),
(12, 20, '2022-09-29', 10161000),
(13, 22, '2022-09-29', 3000000),
(14, 23, '2022-09-29', 11865000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jual`
--

CREATE TABLE `tb_jual` (
  `idJual` int(11) NOT NULL,
  `idTransaksi` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `qty` double NOT NULL,
  `hargaSatuan` double NOT NULL,
  `discount` int(11) NOT NULL,
  `totalHarga` double NOT NULL,
  `hargaBeliPcs` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kredit_bayar`
--

CREATE TABLE `tb_kredit_bayar` (
  `idKredit` int(11) NOT NULL,
  `idTransaksi` int(11) NOT NULL,
  `tanggalBayar` date NOT NULL,
  `telahBayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_list_masuk`
--

CREATE TABLE `tb_list_masuk` (
  `idList` int(11) NOT NULL,
  `idMasuk` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `qtyMasuk` double NOT NULL,
  `hargaBeliPcs` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_list_masuk`
--

INSERT INTO `tb_list_masuk` (`idList`, `idMasuk`, `idBarang`, `qtyMasuk`, `hargaBeliPcs`) VALUES
(2, 4, 20, 72, 22000),
(3, 5, 38, 31, 18500),
(4, 6, 39, 104, 17500),
(5, 7, 2, 44, 31000),
(6, 8, 30, 28, 29000),
(8, 9, 5, 20, 38000),
(9, 9, 56, 10, 40000),
(10, 9, 55, 20, 42000),
(11, 12, 16, 10, 28000),
(12, 12, 21, 38, 21000),
(13, 12, 43, 66, 13500),
(14, 12, 45, 22, 23000),
(15, 12, 18, 67, 19000),
(16, 14, 47, 116, 68000),
(17, 14, 49, 30, 98000),
(18, 14, 48, 15, 67000),
(19, 14, 46, 142, 17000),
(20, 16, 50, 24, 85000),
(21, 16, 40, 20, 19500),
(22, 16, 37, 24, 30000),
(23, 16, 36, 7, 40000),
(24, 16, 57, 10, 45000),
(25, 16, 15, 4, 35000),
(26, 16, 16, 52, 28000),
(27, 16, 1, 19, 32000),
(28, 16, 11, 3, 32000),
(29, 16, 10, 11, 75000),
(30, 16, 9, 20, 33000),
(31, 16, 19, 9, 20000),
(32, 16, 12, 14, 21000),
(33, 16, 13, 6, 20000),
(34, 16, 6, 47, 37000),
(35, 16, 26, 16, 15000),
(36, 16, 2, 3, 31000),
(37, 16, 25, 6, 50000),
(38, 16, 34, 8, 46000),
(39, 16, 28, 3, 42000),
(40, 16, 30, 3, 36000),
(41, 16, 33, 6, 45000),
(42, 16, 32, 5, 39000),
(43, 16, 35, 3, 27000),
(44, 16, 4, 9, 22000),
(45, 16, 22, 79, 33000),
(46, 17, 58, 10, 33000),
(47, 17, 59, 11, 51000),
(48, 17, 51, 3, 105000),
(49, 17, 60, 3, 29000),
(50, 19, 53, 60, 24000),
(51, 20, 35, 26, 25000),
(52, 20, 43, 44, 13500),
(53, 20, 1, 100, 32000),
(54, 20, 14, 20, 25000),
(55, 20, 44, 45, 9000),
(56, 20, 8, 46, 33000),
(57, 20, 30, 36, 29000),
(58, 20, 33, 50, 45000),
(59, 22, 31, 60, 46000),
(60, 22, 14, 10, 24000),
(61, 23, 7, 273, 25000),
(62, 23, 3, 252, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `idPelanggan` int(11) NOT NULL,
  `namaPelanggan` varchar(100) NOT NULL,
  `noTelponPelanggan` varchar(15) NOT NULL,
  `noTelponPelangganAlternatif` varchar(20) DEFAULT NULL,
  `noKtp` varchar(100) DEFAULT NULL,
  `noKk` varchar(100) DEFAULT NULL,
  `alamatPelanggan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`idPelanggan`, `namaPelanggan`, `noTelponPelanggan`, `noTelponPelangganAlternatif`, `noKtp`, `noKk`, `alamatPelanggan`) VALUES
(1, ' Eceran toko', ' 0266', ' ', ' ', ' ', ' sukabumi'),
(2, ' ACN', ' 0266', ' ', ' ', ' ', ' '),
(3, ' PA ARGA', ' ', ' ', ' ', ' ', ' CIKOTOK'),
(4, ' HAJI IQBAL', ' ', ' ', ' ', ' ', ' CIKOTOK'),
(5, ' HAJI TUMIN', ' ', ' ', ' ', ' ', ' LENGKONG JAMPANG'),
(6, ' PA AGUS', ' ', ' ', ' ', ' ', ' PASAWAHAN CIANJUR'),
(7, ' PA USMADA', ' ', ' ', ' ', ' ', ' PASAWAHAN'),
(8, ' PA USMAN', ' ', ' ', ' ', ' ', ' PASAWAHAN'),
(9, ' PA ENAI', ' ', ' ', ' ', ' ', ' CIKOTOK'),
(10, ' PA BERLIN', ' ', ' ', ' ', ' ', ' CIKOTOK'),
(11, ' PA KURNIA', ' ', ' ', ' ', ' ', ' CIKOTOK'),
(12, ' PA OCIT', ' ', ' ', ' ', ' ', 'PASAWAHAN'),
(13, ' PA DEDI', ' ', ' ', ' ', ' ', ' PASAWAHAN'),
(14, ' OM HENGKI ( SALES )', ' ', ' ', ' ', ' ', ' TIPAR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_satuan_barang`
--

CREATE TABLE `tb_satuan_barang` (
  `id` int(11) NOT NULL,
  `namaSatuan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_satuan_barang`
--

INSERT INTO `tb_satuan_barang` (`id`, `namaSatuan`) VALUES
(2, 'KILO GRAM'),
(3, 'LITER'),
(4, 'DUS');

-- --------------------------------------------------------

--
-- Table structure for table `tb_suplier`
--

CREATE TABLE `tb_suplier` (
  `idSupplier` int(11) NOT NULL,
  `namaSupplier` varchar(255) NOT NULL,
  `noTelponSupplier` varchar(20) NOT NULL,
  `alamatSupplier` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_suplier`
--

INSERT INTO `tb_suplier` (`idSupplier`, `namaSupplier`, `noTelponSupplier`, `alamatSupplier`) VALUES
(1, 'AJ', '0266', 'Benteng'),
(2, 'HJ', '0266', 'CIKONDANG'),
(3, 'BC', '0266', 'STATION'),
(4, 'ASEP', '0857', 'PLARA'),
(5, 'ACN', '0266', 'STATION'),
(6, 'PD JUJUR', '0266- 221830', 'JL STATSIUN SUKABUMI'),
(7, 'ALING', '0266', 'JL STATSIUN SUKABUMI');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `idTransaksi` int(11) NOT NULL,
  `tanggalTransaksi` datetime NOT NULL,
  `idPelanggan` int(11) NOT NULL,
  `hDiscount` int(11) NOT NULL,
  `jenisTransaksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`idTransaksi`, `tanggalTransaksi`, `idPelanggan`, `hDiscount`, `jenisTransaksi`) VALUES
(1, '2022-09-20 14:56:19', 0, 0, 0),
(2, '2022-09-20 15:04:19', 0, 0, 0),
(3, '2022-09-24 16:19:22', 0, 0, 0),
(4, '2022-09-24 16:24:27', 0, 0, 0),
(5, '2022-09-29 10:42:54', 0, 0, 0),
(6, '2022-09-29 10:43:37', 0, 0, 0),
(7, '2022-09-29 14:41:59', 0, 0, 0),
(8, '2022-09-29 14:44:12', 0, 0, 0),
(9, '2022-09-29 14:46:09', 0, 0, 0),
(10, '2022-10-12 07:22:28', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `idUser` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`idUser`, `level`, `username`, `password`) VALUES
(1, 1, 'admin', 'b9a01cea77639bd4a9b648ca26cec696'),
(2, 1, 'superadmin', '17c4520f6cfd1ab53d8745e84681eb49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`idBarang`);

--
-- Indexes for table `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD PRIMARY KEY (`idMasuk`);

--
-- Indexes for table `tb_discount`
--
ALTER TABLE `tb_discount`
  ADD PRIMARY KEY (`idDiscount`);

--
-- Indexes for table `tb_history_bayar`
--
ALTER TABLE `tb_history_bayar`
  ADD PRIMARY KEY (`idHistory`),
  ADD KEY `idMasuk` (`idMasuk`);

--
-- Indexes for table `tb_jual`
--
ALTER TABLE `tb_jual`
  ADD PRIMARY KEY (`idJual`),
  ADD KEY `idTransaksi` (`idTransaksi`),
  ADD KEY `idBarang` (`idBarang`);

--
-- Indexes for table `tb_kredit_bayar`
--
ALTER TABLE `tb_kredit_bayar`
  ADD PRIMARY KEY (`idKredit`);

--
-- Indexes for table `tb_list_masuk`
--
ALTER TABLE `tb_list_masuk`
  ADD PRIMARY KEY (`idList`),
  ADD KEY `idMasuk` (`idMasuk`),
  ADD KEY `idBarang` (`idBarang`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`idPelanggan`);

--
-- Indexes for table `tb_satuan_barang`
--
ALTER TABLE `tb_satuan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_suplier`
--
ALTER TABLE `tb_suplier`
  ADD PRIMARY KEY (`idSupplier`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`idTransaksi`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `idBarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  MODIFY `idMasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tb_discount`
--
ALTER TABLE `tb_discount`
  MODIFY `idDiscount` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_history_bayar`
--
ALTER TABLE `tb_history_bayar`
  MODIFY `idHistory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_jual`
--
ALTER TABLE `tb_jual`
  MODIFY `idJual` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kredit_bayar`
--
ALTER TABLE `tb_kredit_bayar`
  MODIFY `idKredit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_list_masuk`
--
ALTER TABLE `tb_list_masuk`
  MODIFY `idList` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `idPelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_satuan_barang`
--
ALTER TABLE `tb_satuan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_suplier`
--
ALTER TABLE `tb_suplier`
  MODIFY `idSupplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `idTransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_history_bayar`
--
ALTER TABLE `tb_history_bayar`
  ADD CONSTRAINT `tb_history_bayar_ibfk_1` FOREIGN KEY (`idMasuk`) REFERENCES `tb_barang_masuk` (`idMasuk`) ON DELETE CASCADE;

--
-- Constraints for table `tb_jual`
--
ALTER TABLE `tb_jual`
  ADD CONSTRAINT `tb_jual_ibfk_1` FOREIGN KEY (`idTransaksi`) REFERENCES `tb_transaksi` (`idTransaksi`) ON DELETE CASCADE;

--
-- Constraints for table `tb_list_masuk`
--
ALTER TABLE `tb_list_masuk`
  ADD CONSTRAINT `tb_list_masuk_ibfk_1` FOREIGN KEY (`idMasuk`) REFERENCES `tb_barang_masuk` (`idMasuk`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_list_masuk_ibfk_2` FOREIGN KEY (`idBarang`) REFERENCES `tb_barang` (`idBarang`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
