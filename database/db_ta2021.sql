-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 29 Jul 2021 pada 14.12
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ta2021`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Admin1', '0', '$2y$10$YI6aecZF56IqnT9vIOKXb.IVmxssMHhOZjInfbtXwQvNS/q2WSj3u'),
(2, 'Admin2', 'admin2', '$2y$10$GK6a8Eh4I1l5gf8e.iNq5OGQHkQO4xs7ifPr2YpX89od.WpfyqKNS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_officer`
--

CREATE TABLE `tb_officer` (
  `nik` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `tipe` enum('Loket','GA','Finance') NOT NULL,
  `password` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_officer`
--

INSERT INTO `tb_officer` (`nik`, `nama`, `email`, `no_telp`, `tipe`, `password`, `gambar`) VALUES
(990123451, 'Loket', 'loket1@loket.com', '0851000001', 'Loket', '$2y$10$hRuKasR5O3zVK7jJCcBFoejdzlKFbY0DzDLOCffuN.PTh9ChuyhJW', 'b336172690f7b3b8d354e5e323342989.png'),
(990123452, 'GA', 'ga@ga.com', '0861000000', 'GA', '$2y$10$YI6aecZF56IqnT9vIOKXb.IVmxssMHhOZjInfbtXwQvNS/q2WSj3u', '3ca38463cab0114f96a714ced5b7ba23.png'),
(990123453, 'Finance', 'fin@fin.com', '0871000000', 'Finance', '$2y$10$YI6aecZF56IqnT9vIOKXb.IVmxssMHhOZjInfbtXwQvNS/q2WSj3u', '2ef352d817744b390f9a7c8039f6185f.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `alamat` text,
  `password` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_supplier`
--

INSERT INTO `tb_supplier` (`id`, `nama`, `email`, `no_telp`, `alamat`, `password`, `gambar`, `status`) VALUES
(1, 'Supplier1', 'supplier1@supplier.com', '081000000', 'Alamat Supplier1', '$2y$10$.JcP2syYdS/Y8nyJi.4zTOrUOBRzPLvMKmSXJMENFW4BS5brHGRm2', 'f1f39011a75392c58b0007add1cc3b43.png', NULL),
(2, 'Supplier2', 'supplier2@supplier.com', '082000000', 'Alamat Supplier2', '$2y$10$YI6aecZF56IqnT9vIOKXb.IVmxssMHhOZjInfbtXwQvNS/q2WSj3u', '4f3df2b66a823ff65334bef3cdfb671c.png', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tagihan`
--

CREATE TABLE `tb_tagihan` (
  `id` int(11) NOT NULL,
  `no_faktur` varchar(50) DEFAULT NULL,
  `id_supplier` int(11) NOT NULL,
  `nik_loket` int(11) DEFAULT NULL,
  `nik_fin` int(11) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `biaya` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_tagihan` date NOT NULL,
  `tgl_input` datetime NOT NULL,
  `tgl_transfer` date DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status_faktur` enum('Menunggu','Diterima','Ditolak') NOT NULL,
  `status_ga` enum('Menunggu','Diterima','Ditolak') NOT NULL,
  `status_fin` enum('Menunggu','Diterima','Ditolak','Selesai') NOT NULL,
  `status` enum('Menunggu Acc Loket','Menunggu Acc GA','Menunggu Acc Finance','Diterima Finance','Ditolak Loket','Ditolak GA','Ditolak Finance','Selesai') NOT NULL,
  `ket_status` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_tagihan`
--

INSERT INTO `tb_tagihan` (`id`, `no_faktur`, `id_supplier`, `nik_loket`, `nik_fin`, `nama`, `biaya`, `keterangan`, `tgl_tagihan`, `tgl_input`, `tgl_transfer`, `bukti_transfer`, `status_faktur`, `status_ga`, `status_fin`, `status`, `ket_status`) VALUES
(1, 'TG-2907210001', 1, 990123451, 990123453, 'Tes Tagihan1', 3000000, 'tes tagihan 1', '2021-07-18', '2021-07-29 18:15:47', '2021-08-05', NULL, 'Diterima', 'Diterima', 'Diterima', 'Diterima Finance', NULL),
(2, 'TG-2907210002', 2, 990123451, NULL, 'Tes Tagihan 2', 2500000, 'tes tagihan 2', '2021-07-25', '2021-07-29 18:22:17', '2021-07-30', NULL, 'Diterima', 'Diterima', 'Menunggu', 'Menunggu Acc Finance', NULL),
(3, 'TG-2907210003', 1, 990123451, NULL, 'Tes Tagihan3', 50000, 'tes tagihan 3', '2021-07-26', '2021-07-29 19:04:07', NULL, NULL, 'Diterima', 'Ditolak', 'Menunggu', 'Ditolak GA', 'Tolak GA'),
(5, NULL, 1, 990123451, NULL, 'Tes Tagihan4', 200000, 'tes tagihan 4', '2021-07-25', '2021-07-28 12:54:31', NULL, NULL, 'Ditolak', 'Menunggu', 'Menunggu', 'Ditolak Loket', 'tolak loket'),
(6, NULL, 1, NULL, NULL, 'Tes Input', 2500000, 'tes input', '2021-07-28', '2021-07-29 19:07:23', NULL, NULL, 'Menunggu', 'Menunggu', 'Menunggu', 'Menunggu Acc Loket', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_officer`
--
ALTER TABLE `tb_officer`
  ADD PRIMARY KEY (`nik`);

--
-- Indeks untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_telp` (`no_telp`);

--
-- Indeks untuk tabel `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_faktur` (`no_faktur`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `nik_loket` (`nik_loket`),
  ADD KEY `nik_fin` (`nik_fin`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD CONSTRAINT `tb_tagihan_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `tb_supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_tagihan_ibfk_2` FOREIGN KEY (`nik_loket`) REFERENCES `tb_officer` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_tagihan_ibfk_3` FOREIGN KEY (`nik_fin`) REFERENCES `tb_officer` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
