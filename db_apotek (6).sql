-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2020 pada 11.25
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_apotek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `apotek_profile`
--

CREATE TABLE `apotek_profile` (
  `id_apotek` int(11) NOT NULL,
  `nama_apotek` varchar(128) NOT NULL,
  `alamat_apotek` text NOT NULL,
  `no_hp` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `apotek_profile`
--

INSERT INTO `apotek_profile` (`id_apotek`, `nama_apotek`, `alamat_apotek`, `no_hp`, `image`) VALUES
(1, 'Apotek Kita Harus Sehat', 'Jalan cinta gg kasih sayang kecamatan bersama selamanya no 90', '061-506120', '1575197093images(2).jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_rusak`
--

CREATE TABLE `barang_rusak` (
  `id_barang_rusak` varchar(20) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `jam_transaksi` varchar(128) NOT NULL,
  `total_barangrusak` double NOT NULL,
  `kasir` varchar(128) NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_rusak`
--

INSERT INTO `barang_rusak` (`id_barang_rusak`, `tanggal_transaksi`, `jam_transaksi`, `total_barangrusak`, `kasir`, `created_datetime`, `modified_datetime`) VALUES
('BROK201912160001', '2019-12-20', '05:41:48', 50, 'ariyozi', '1576471344', '1576471344');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_rusak_detail`
--

CREATE TABLE `barang_rusak_detail` (
  `id_barang_rusak_detail` varchar(20) NOT NULL,
  `id_barang_rusak` varchar(20) NOT NULL,
  `id_obat` varchar(20) NOT NULL,
  `jumlah_rusak` double NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_rusak_detail`
--

INSERT INTO `barang_rusak_detail` (`id_barang_rusak_detail`, `id_barang_rusak`, `id_obat`, `jumlah_rusak`, `created_datetime`, `modified_datetime`) VALUES
('BROD201912160001', 'BROK201912160001', 'OBAT201911220001', 50, '1576471344', '1576471344');

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga_obat`
--

CREATE TABLE `harga_obat` (
  `id_obat` varchar(20) NOT NULL,
  `id_satuan` varchar(20) NOT NULL,
  `jumlah` double NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `harga_obat`
--

INSERT INTO `harga_obat` (`id_obat`, `id_satuan`, `jumlah`, `harga`) VALUES
('OBAT201911220001', 'TYPE201911190002', 1, 600),
('OBAT201911220001', 'TYPE201911190002', 10, 550),
('OBAT201911220001', 'TYPE201911190004', 1, 5000),
('OBAT201911220001', 'TYPE201911190004', 10, 45000),
('OBAT201911220002', 'TYPE201911240001', 2, 3500),
('OBAT201911250006', 'TYPE201911190001', 1, 600),
('OBAT201912050001', 'TYPE201911190001', 1, 500),
('OBAT201912050001', 'TYPE201911190002', 1, 4500),
('OBAT201912050001', 'TYPE201911230003', 1, 500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_obat`
--

CREATE TABLE `kategori_obat` (
  `id_kategori` varchar(20) NOT NULL,
  `nama_kategori_obat` varchar(128) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori_obat`
--

INSERT INTO `kategori_obat` (`id_kategori`, `nama_kategori_obat`, `is_active`, `created_datetime`, `modified_datetime`) VALUES
('TYPE201911190001', 'Obat Cair', 1, '1574140159', '1574140275'),
('TYPE201911190002', 'Obat Keras', 1, '1574143135', '1574143139'),
('CATE201911220001', 'Obat Generik', 1, '1574391863', '1574391863');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id_obat` varchar(20) NOT NULL,
  `nama_obat` varchar(128) NOT NULL,
  `id_kategori` varchar(20) NOT NULL,
  `id_satuan` varchar(20) NOT NULL,
  `id_satuan_konversi_1` varchar(20) NOT NULL,
  `jumlah_konversi_1` double NOT NULL,
  `id_satuan_konversi_2` varchar(20) NOT NULL,
  `jumlah_konversi_2` double NOT NULL,
  `id_satuan_konversi_3` varchar(20) NOT NULL,
  `jumlah_konversi_3` double NOT NULL,
  `min_stok` double NOT NULL,
  `max_stok` double NOT NULL,
  `stok` double NOT NULL,
  `tanggal_expired` date NOT NULL,
  `nomor_beds` varchar(128) NOT NULL,
  `image` varchar(300) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `id_kategori`, `id_satuan`, `id_satuan_konversi_1`, `jumlah_konversi_1`, `id_satuan_konversi_2`, `jumlah_konversi_2`, `id_satuan_konversi_3`, `jumlah_konversi_3`, `min_stok`, `max_stok`, `stok`, `tanggal_expired`, `nomor_beds`, `image`, `is_active`, `created_datetime`, `modified_datetime`) VALUES
('OBAT201911220001', 'Bodrek Flu dan Batuk', 'CATE201911220001', 'TYPE201911190002', 'TYPE201911190004', 10, '', 0, '', 0, 100, 0, 2, '0000-00-00', '', 'defaultObat.jpg', 1, '1575763284', '1575763284'),
('OBAT201911220002', 'Oralit', 'CATE201911220001', 'TYPE201911240001', '', 0, '', 0, '', 0, 0, 0, 60, '0000-00-00', '', '1574604725download(4).jpeg', 1, '1574604725', '1574604725'),
('OBAT201911250001', 'Paracetamol', 'CATE201911220001', 'TYPE201911190002', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655055', '1574655055'),
('OBAT201911250002', 'Sanmol 500mg Tablet', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655075', '1574655075'),
('OBAT201911250003', 'Grantusif', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655092', '1574655092'),
('OBAT201911250004', 'Asam Mafenamat', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655456', '1574655456'),
('OBAT201911250005', 'Mixagrip', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655128', '1574655128'),
('OBAT201911250006', 'Antalgin', 'CATE201911220001', 'TYPE201911190001', '', 0, '', 0, '', 0, 1000, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1575946137', '1575946137'),
('OBAT201911250007', 'Salbutamol', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655151', '1574655151'),
('OBAT201911250008', 'GG Tablet', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655164', '1574655164'),
('OBAT201911250009', 'Dexamethason  0,5 mg', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655177', '1574655177'),
('OBAT201911250010', 'Methyl prednisolon', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655189', '1574655189'),
('OBAT201911250011', 'Ibuprofen 400 mg', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655202', '1574655202'),
('OBAT201911250012', 'Amoksisilin 500 mg', 'TYPE201911190001', 'TYPE201911190001', 'TYPE201911190002', 10, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1575763297', '1575763297'),
('OBAT201911250013', 'levofloksasi', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655236', '1574655236'),
('OBAT201911250014', 'Inpepsa 100 ml', 'TYPE201911190001', 'TYPE201911190003', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655251', '1574655251'),
('OBAT201911250015', 'Sucralfat 100 ml', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655262', '1574655262'),
('OBAT201911250016', 'Sucralfat 200 ml', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655271', '1574655271'),
('OBAT201911250017', 'Transpulmin kids', 'CATE201911220001', 'TYPE201911230002', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655287', '1574655287'),
('OBAT201911250018', 'Transpulmin baby', 'TYPE201911190001', 'TYPE201911190001', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655298', '1574655298'),
('OBAT201911250019', 'Gentamisin salep', 'TYPE201911190001', 'TYPE201911230002', '', 0, '', 0, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1574655995', '1574655995'),
('OBAT201912050001', 'New Obat With Konversi', 'CATE201911220001', 'TYPE201911190001', 'TYPE201911190002', 100, 'TYPE201911230003', 1000, '', 0, 0, 0, 0, '0000-00-00', '', 'defaultObat.jpg', 1, '1575521370', '1575521370');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` varchar(20) NOT NULL,
  `id_supplier` varchar(20) NOT NULL,
  `nama_pembeli` varchar(128) NOT NULL,
  `total_pembelian` double NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `jam_pembelian` varchar(128) NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_supplier`, `nama_pembeli`, `total_pembelian`, `tanggal_pembelian`, `jam_pembelian`, `created_datetime`, `modified_datetime`) VALUES
('PURC201912160001', 'SUPL201911190001', 'ariyozi', 700000, '2019-12-16', '04:33:24', '1576467238', '1576467238');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id_pembelian_detail` varchar(20) NOT NULL,
  `id_pembelian` varchar(20) NOT NULL,
  `id_obat` varchar(20) NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `harga_beli` double NOT NULL,
  `expired_date` date NOT NULL,
  `nomor_batch` varchar(128) NOT NULL,
  `ppn` double NOT NULL,
  `diskon` double NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id_pembelian_detail`, `id_pembelian`, `id_obat`, `jumlah_beli`, `harga_beli`, `expired_date`, `nomor_batch`, `ppn`, `diskon`, `created_datetime`, `modified_datetime`) VALUES
('PDET201912160001', 'PURC201912160001', 'OBAT201911220001', 1000, 500000, '2022-12-16', '125125125', 0, 0, '1576467238', '1576467238'),
('PDET201912160002', 'PURC201912160001', 'OBAT201911220002', 100, 200000, '2022-12-16', '125125124', 0, 0, '1576467238', '1576467238');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` varchar(20) NOT NULL,
  `nama_pembeli` varchar(128) NOT NULL,
  `total_penjualan` double NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `jam_penjualan` varchar(128) NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `nama_pembeli`, `total_penjualan`, `tanggal_penjualan`, `jam_penjualan`, `created_datetime`, `modified_datetime`) VALUES
('INVO201912180001', 'ariyozi', 4050000, '2019-12-18', '07:26:32', '1576650395', '1576650395'),
('INVO201912180002', 'ariyozi', 455500, '2019-12-18', '07:56:14', '1576652193', '1576652193'),
('INVO201912180003', 'ariyozi', 80000, '2019-12-18', '08:54:33', '1576655866', '1576655866'),
('INVO201912180004', 'ariyozi', 45000, '2019-12-18', '08:59:57', '1576656031', '1576656031'),
('INVO201912180005', 'ariyozi', 5000, '2019-12-18', '09:00:59', '1576656086', '1576656086'),
('INVO201912180006', 'ariyozi', 600, '2019-12-18', '09:07:40', '1576656471', '1576656471'),
('INVO201912180007', 'ariyozi', 600, '2019-12-18', '09:08:07', '1576656501', '1576656501'),
('INVO201912180008', 'ariyozi', 600, '2019-12-18', '09:09:14', '1576656567', '1576656567'),
('INVO201912180009', 'ariyozi', 600, '2019-12-18', '09:10:20', '1576656632', '1576656632'),
('INVO201912180010', 'ariyozi', 4800, '2019-12-18', '09:16:41', '1576657016', '1576657016');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id_penjualan_detail` varchar(20) NOT NULL,
  `id_penjualan` varchar(20) NOT NULL,
  `id_obat` varchar(20) NOT NULL,
  `id_satuan` varchar(20) NOT NULL,
  `jumlah_jual` double NOT NULL,
  `harga_jual` double NOT NULL,
  `ppn` double NOT NULL,
  `diskon` double NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id_penjualan_detail`, `id_penjualan`, `id_obat`, `id_satuan`, `jumlah_jual`, `harga_jual`, `ppn`, `diskon`, `created_datetime`, `modified_datetime`) VALUES
('INVD201912180001', 'INVO201912180001', 'OBAT201911220001', 'TYPE201911190004', 90, 45000, 0, 0, '1576650395', '1576650395'),
('INVD201912180002', 'INVO201912180002', 'OBAT201911220001', 'TYPE201911190004', 10, 45000, 0, 0, '1576652193', '1576652193'),
('INVD201912180003', 'INVO201912180002', 'OBAT201911220001', 'TYPE201911190002', 10, 550, 0, 0, '1576652193', '1576652193'),
('INVD201912180004', 'INVO201912180003', 'OBAT201911220002', 'TYPE201911240001', 20, 2000, 0, 0, '1576655866', '1576655866'),
('INVD201912180005', 'INVO201912180003', 'OBAT201911220002', 'TYPE201911240001', 20, 2000, 0, 0, '1576655866', '1576655866'),
('INVD201912180006', 'INVO201912180004', 'OBAT201911220001', 'TYPE201911190004', 9, 5000, 0, 0, '1576656031', '1576656031'),
('INVD201912180007', 'INVO201912180005', 'OBAT201911220001', 'TYPE201911190004', 1, 5000, 0, 0, '1576656086', '1576656086'),
('INVD201912180008', 'INVO201912180006', 'OBAT201911220001', 'TYPE201911190002', 1, 600, 0, 0, '1576656471', '1576656471'),
('INVD201912180009', 'INVO201912180007', 'OBAT201911220001', 'TYPE201911190002', 1, 600, 0, 0, '1576656501', '1576656501'),
('INVD201912180010', 'INVO201912180008', 'OBAT201911220001', 'TYPE201911190002', 1, 600, 0, 0, '1576656567', '1576656567'),
('INVD201912180011', 'INVO201912180009', 'OBAT201911220001', 'TYPE201911190002', 1, 600, 0, 0, '1576656632', '1576656632'),
('INVD201912180012', 'INVO201912180010', 'OBAT201911220001', 'TYPE201911190002', 8, 600, 0, 0, '1576657016', '1576657016');

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur_pembelian`
--

CREATE TABLE `retur_pembelian` (
  `id_retur` varchar(20) NOT NULL,
  `id_pembelian` varchar(20) NOT NULL,
  `id_pembelian_detail` varchar(20) NOT NULL,
  `id_obat` varchar(20) NOT NULL,
  `jumlah_retur` double NOT NULL,
  `tanggal_retur` date NOT NULL,
  `jam_retur` varchar(128) NOT NULL,
  `kasir` varchar(128) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `retur_pembelian`
--

INSERT INTO `retur_pembelian` (`id_retur`, `id_pembelian`, `id_pembelian_detail`, `id_obat`, `jumlah_retur`, `tanggal_retur`, `jam_retur`, `kasir`, `keterangan`) VALUES
('RETR201912160001', 'PURC201912160001', 'PDET201912160001', 'OBAT201911220001', 10, '2019-12-16', '05:28:07', 'ariyozi', 'Customer minta ganti obat yg expirednya masi lama soalnya mau distok dia\n                        ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur_penjualan`
--

CREATE TABLE `retur_penjualan` (
  `id_retur` varchar(20) NOT NULL,
  `id_penjualan` varchar(20) NOT NULL,
  `id_penjualan_detail` varchar(20) NOT NULL,
  `id_obat` varchar(20) NOT NULL,
  `jumlah_retur` double NOT NULL,
  `tanggal_retur` date NOT NULL,
  `jam_retur` varchar(128) NOT NULL,
  `kasir` varchar(128) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `retur_penjualan`
--

INSERT INTO `retur_penjualan` (`id_retur`, `id_penjualan`, `id_penjualan_detail`, `id_obat`, `jumlah_retur`, `tanggal_retur`, `jam_retur`, `kasir`, `keterangan`) VALUES
('RETR201912160001', 'INVO201912160001', 'INVD201912160001', 'OBAT201911220001', 10, '2019-12-16', '05:27:36', 'ariyozi', 'Obat yang dibeli ada cacad secara fisik\n                        ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan_obat`
--

CREATE TABLE `satuan_obat` (
  `id_satuan` varchar(20) NOT NULL,
  `nama_satuan_obat` varchar(128) NOT NULL,
  `kode_satuan_obat` varchar(128) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `satuan_obat`
--

INSERT INTO `satuan_obat` (`id_satuan`, `nama_satuan_obat`, `kode_satuan_obat`, `is_active`, `created_datetime`, `modified_datetime`) VALUES
('TYPE201911190001', 'Piece', 'Pcs', 1, '1574134912', '1574134912'),
('TYPE201911190002', 'Tablet', 'Tab', 1, '1574135349', '1574496106'),
('TYPE201911190003', 'Botol', 'Btl', 1, '1574135355', '1574135355'),
('TYPE201911190004', 'Papan', 'Papan', 1, '1574135366', '1574136165'),
('TYPE201911230001', 'Strip', 'Strip', 1, '1574496128', '1574496128'),
('TYPE201911230002', 'Tube', 'Tube', 1, '1574496139', '1574496139'),
('TYPE201911230003', 'Box', 'Box', 1, '1574496370', '1574496370'),
('TYPE201911230004', 'Ball', 'Ball', 1, '1574496383', '1574496383'),
('TYPE201911230005', 'Kotak', 'Kotak', 1, '1574496394', '1574496394'),
('TYPE201911240001', 'Sachet', 'Sachet', 1, '1574604681', '1574604681');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` varchar(20) NOT NULL,
  `nama_supplier` varchar(128) NOT NULL,
  `kota_supplier` varchar(128) NOT NULL,
  `telp_supplier` varchar(128) NOT NULL,
  `email_supplier` varchar(128) NOT NULL,
  `alamat_supplier` text NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_datetime` varchar(128) NOT NULL,
  `modified_datetime` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `kota_supplier`, `telp_supplier`, `email_supplier`, `alamat_supplier`, `is_active`, `created_datetime`, `modified_datetime`) VALUES
('SUPL201911190001', 'PT Konimex', 'Medan', '08214121241', 'konimex@gmail.com', 'Jalan bamboe', 1, '1574149699', '1574149699'),
('SUPL201911190002', 'PT Antalgin', 'Medan', '', '', 'Jalan panjaitan', 1, '1574149724', '1574149727'),
('SUPL201911250001', 'Supplier Umum', 'Medan', '-', '-', 'Umum', 1, '1574650121', '1574650121'),
('SUPL201912050001', 'Stok Awal Obat', '-', '-', '-', '-', 1, '1575518371', '1575518371'),
('SUPL201912090001', 'Retur Obat', '-', '-', '-', '-', 1, '1575865535', '1575865535');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` varchar(20) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `created_datetime` text NOT NULL,
  `modified_datetime` text NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `image`, `created_datetime`, `modified_datetime`, `role_id`, `is_active`) VALUES
('USER201910080001', 'ariyozi', '$2y$10$qFyV6Muzm6N47w5DBt06.OX9AKeTC/4GIxsLsjzyT3UxJ58dx/WIC', 'defaultimage.png', '1570507247', '1574069838', 1, 1),
('USER201910290001', 'asisten', '$2y$10$Mn3hZ4V.N2rI1iWNfPFMqOnWgB3z2/T8O1qNxDkJZ2TpI6sHHFWVi', 'defaultimage.png', '1572322641', '1574069583', 3, 1),
('USER201911180001', 'apoteker', '$2y$10$3jhURwIBCn2Tq1NngK.Ev.h2ffxU7D1zOuWNY0irX3pAu8/kkPiWy', 'defaultimage.png', '1574069538', '1574069847', 2, 1),
('USER201911290001', 'rama', '$2y$10$u0oU0QJjMWqlHnvACWiSPuVbxn5EuNjTIwLaWoyHeiubJtfaLOPVm', 'defaultimage.png', '1575000698', '1575000698', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Apoteker'),
(3, 'Asisten');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `apotek_profile`
--
ALTER TABLE `apotek_profile`
  ADD PRIMARY KEY (`id_apotek`);

--
-- Indeks untuk tabel `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD PRIMARY KEY (`id_barang_rusak`);

--
-- Indeks untuk tabel `barang_rusak_detail`
--
ALTER TABLE `barang_rusak_detail`
  ADD PRIMARY KEY (`id_barang_rusak_detail`);

--
-- Indeks untuk tabel `harga_obat`
--
ALTER TABLE `harga_obat`
  ADD PRIMARY KEY (`id_obat`,`id_satuan`,`jumlah`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id_pembelian_detail`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id_penjualan_detail`);

--
-- Indeks untuk tabel `retur_pembelian`
--
ALTER TABLE `retur_pembelian`
  ADD PRIMARY KEY (`id_retur`);

--
-- Indeks untuk tabel `retur_penjualan`
--
ALTER TABLE `retur_penjualan`
  ADD PRIMARY KEY (`id_retur`);

--
-- Indeks untuk tabel `satuan_obat`
--
ALTER TABLE `satuan_obat`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
