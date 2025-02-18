-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 18, 2025 at 02:20 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kuningan_runners`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

DROP TABLE IF EXISTS `akses`;
CREATE TABLE IF NOT EXISTS `akses` (
  `id_akses` int(10) NOT NULL AUTO_INCREMENT,
  `nama_akses` text NOT NULL,
  `kontak_akses` varchar(20) DEFAULT NULL,
  `email_akses` text NOT NULL,
  `password` text NOT NULL,
  `image_akses` text,
  `akses` varchar(20) NOT NULL,
  `datetime_daftar` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  PRIMARY KEY (`id_akses`),
  KEY `akses` (`akses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_entitas`
--

DROP TABLE IF EXISTS `akses_entitas`;
CREATE TABLE IF NOT EXISTS `akses_entitas` (
  `uuid_akses_entitas` varchar(32) NOT NULL,
  `akses` varchar(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`uuid_akses_entitas`),
  KEY `akses` (`akses`),
  KEY `uuid_akses_entitas` (`uuid_akses_entitas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_fitur`
--

DROP TABLE IF EXISTS `akses_fitur`;
CREATE TABLE IF NOT EXISTS `akses_fitur` (
  `id_akses_fitur` int(11) NOT NULL AUTO_INCREMENT,
  `kode` char(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_ijin`
--

DROP TABLE IF EXISTS `akses_ijin`;
CREATE TABLE IF NOT EXISTS `akses_ijin` (
  `id_akses` int(10) NOT NULL,
  `id_akses_fitur` int(12) NOT NULL,
  `kode` varchar(32) NOT NULL,
  `nama` text NOT NULL,
  `kategori` text NOT NULL,
  KEY `id_akses` (`id_akses`),
  KEY `id_akses_fitur` (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_login`
--

DROP TABLE IF EXISTS `akses_login`;
CREATE TABLE IF NOT EXISTS `akses_login` (
  `id_akses` int(10) NOT NULL,
  `kategori` varchar(10) NOT NULL COMMENT 'Anggota/Pengurus',
  `token` varchar(32) NOT NULL,
  `date_creat` datetime NOT NULL,
  `date_expired` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_referensi`
--

DROP TABLE IF EXISTS `akses_referensi`;
CREATE TABLE IF NOT EXISTS `akses_referensi` (
  `id_akses_referensi` int(12) NOT NULL AUTO_INCREMENT,
  `uuid_akses_entitas` varchar(32) NOT NULL,
  `id_akses_fitur` int(12) NOT NULL,
  PRIMARY KEY (`id_akses_referensi`),
  KEY `uuid_akses_entitas` (`uuid_akses_entitas`),
  KEY `id_akses_fitur` (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akses_validasi`
--

DROP TABLE IF EXISTS `akses_validasi`;
CREATE TABLE IF NOT EXISTS `akses_validasi` (
  `id_akses_validasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_akses` int(11) NOT NULL,
  `kode_rahasia` char(12) NOT NULL COMMENT '12 digit (md5)',
  `datetime_creat` datetime NOT NULL,
  `datetime_expired` datetime NOT NULL,
  `ussed` tinyint(1) NOT NULL COMMENT '1: Sudah digunakan\r\n0: Belum',
  PRIMARY KEY (`id_akses_validasi`),
  KEY `to_akses` (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_raja_ongkir`
--

DROP TABLE IF EXISTS `api_raja_ongkir`;
CREATE TABLE IF NOT EXISTS `api_raja_ongkir` (
  `id_api_raja_ongkir` int(11) NOT NULL AUTO_INCREMENT,
  `base_url` varchar(255) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `origin_label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_api_raja_ongkir`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_session`
--

DROP TABLE IF EXISTS `api_session`;
CREATE TABLE IF NOT EXISTS `api_session` (
  `id_api_session` int(12) NOT NULL AUTO_INCREMENT,
  `id_setting_api_key` int(12) NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `datetime_expired` datetime NOT NULL,
  `xtoken` char(36) NOT NULL,
  PRIMARY KEY (`id_api_session`),
  KEY `id_setting_api_key` (`id_setting_api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(50) NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `dimensi` json NOT NULL COMMENT 'Berat (Kg), Panjang, Lebar, Tinggi (cm)',
  `deskripsi` text,
  `foto` char(37) NOT NULL,
  `varian` json NOT NULL COMMENT 'nama_varian, harga, foto',
  `marketplace` json DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id_event` char(36) NOT NULL,
  `tanggal_mulai` datetime NOT NULL COMMENT 'Y-m-d H:i',
  `tanggal_selesai` datetime NOT NULL COMMENT 'Y-m-d H:i',
  `mulai_pendaftaran` datetime NOT NULL COMMENT 'Y-m-d H:i',
  `selesai_pendaftaran` datetime NOT NULL COMMENT 'Y-m-d H:i',
  `nama_event` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `poster` varchar(37) NOT NULL COMMENT 'image file',
  `rute` varchar(37) DEFAULT NULL COMMENT 'gpx file',
  `sertifikat` json NOT NULL COMMENT 'atribut setting sertifikat',
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_assesment`
--

DROP TABLE IF EXISTS `event_assesment`;
CREATE TABLE IF NOT EXISTS `event_assesment` (
  `id_event_assesment` int(11) NOT NULL AUTO_INCREMENT,
  `id_event_assesment_form` char(36) DEFAULT NULL,
  `id_event_peserta` char(36) NOT NULL,
  `assesment_value` text,
  `status_assesment` text COMMENT '{\r\n  "status_assesment":"Valid/Pending/Refisi",\r\n  "komentar":"Perbaiki file yang anda upload"\r\n}',
  PRIMARY KEY (`id_event_assesment`),
  KEY `id_event_peserta` (`id_event_peserta`),
  KEY `to_assesment_form` (`id_event_assesment_form`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_assesment_form`
--

DROP TABLE IF EXISTS `event_assesment_form`;
CREATE TABLE IF NOT EXISTS `event_assesment_form` (
  `id_event_assesment_form` char(36) NOT NULL,
  `id_event` char(36) NOT NULL,
  `form_name` varchar(50) NOT NULL COMMENT 'Ex: Jenis Kelamin',
  `form_type` varchar(13) NOT NULL COMMENT 'text, textarea, checkbox, radio, select_option, file_foto, file_pdf',
  `mandatori` char(6) NOT NULL COMMENT 'true, false',
  `alternatif` json DEFAULT NULL COMMENT '[\r\n    {\r\n        "value": "L",\r\n        "display": "Laki-Laki"\r\n    },\r\n    {\r\n        "value": "P",\r\n        "display": "Perempuan"\r\n    }\r\n]',
  `komentar` text,
  `kategori_list` json NOT NULL,
  PRIMARY KEY (`id_event_assesment_form`),
  KEY `id_event` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_kategori`
--

DROP TABLE IF EXISTS `event_kategori`;
CREATE TABLE IF NOT EXISTS `event_kategori` (
  `id_event_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` char(36) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `deskripsi` text,
  `biaya_pendaftaran` int(11) DEFAULT NULL COMMENT 'Rp',
  PRIMARY KEY (`id_event_kategori`),
  KEY `event_to_kategori` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_peserta`
--

DROP TABLE IF EXISTS `event_peserta`;
CREATE TABLE IF NOT EXISTS `event_peserta` (
  `id_event_peserta` char(36) NOT NULL COMMENT 'uuid',
  `id_event` char(36) NOT NULL COMMENT 'uuid',
  `id_event_kategori` int(11) NOT NULL,
  `id_member` char(36) NOT NULL COMMENT 'uuid',
  `nama` varchar(100) NOT NULL COMMENT 'nama_member',
  `email` varchar(100) NOT NULL COMMENT 'email member',
  `biaya_pendaftaran` int(11) DEFAULT NULL,
  `datetime` datetime NOT NULL COMMENT 'Keterangan waktu pendaftaran',
  `status` varchar(20) NOT NULL COMMENT 'Lunas, Pending',
  PRIMARY KEY (`id_event_peserta`),
  KEY `id_event` (`id_event`),
  KEY `id_member` (`id_member`),
  KEY `event_peserta_to_kategori` (`id_event_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_sertifikat`
--

DROP TABLE IF EXISTS `event_sertifikat`;
CREATE TABLE IF NOT EXISTS `event_sertifikat` (
  `id_event_sertifikat` char(36) NOT NULL,
  `id_event` char(36) NOT NULL,
  `id_event_peserta` char(36) DEFAULT NULL COMMENT 'Terisi Apabila dari peserta',
  `datetime_creat` datetime NOT NULL,
  `raw_peserta` json NOT NULL COMMENT 'nama,email,kontak, dll',
  `group_sertifikat` varchar(50) NOT NULL COMMENT 'Peserta, Panitia, Sponsor, dll',
  `status` char(7) NOT NULL COMMENT 'Publish, Draft',
  PRIMARY KEY (`id_event_sertifikat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

DROP TABLE IF EXISTS `help`;
CREATE TABLE IF NOT EXISTS `help` (
  `id_help` int(12) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  `status` varchar(15) NOT NULL COMMENT 'Publish, Draft',
  PRIMARY KEY (`id_help`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id_log` int(10) NOT NULL AUTO_INCREMENT,
  `id_akses` int(10) DEFAULT NULL,
  `datetime_log` varchar(25) NOT NULL,
  `kategori_log` varchar(20) NOT NULL,
  `deskripsi_log` varchar(100) NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `id_akses` (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_api`
--

DROP TABLE IF EXISTS `log_api`;
CREATE TABLE IF NOT EXISTS `log_api` (
  `id_log_api` int(11) NOT NULL AUTO_INCREMENT,
  `id_setting_api_key` int(11) DEFAULT NULL,
  `title_api_key` varchar(50) DEFAULT NULL,
  `service_name` text NOT NULL,
  `response_code` int(3) NOT NULL,
  `response_text` text NOT NULL,
  `datetime_log` datetime NOT NULL,
  PRIMARY KEY (`id_log_api`),
  KEY `id_setting_api_key` (`id_setting_api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_email`
--

DROP TABLE IF EXISTS `log_email`;
CREATE TABLE IF NOT EXISTS `log_email` (
  `id_log_email` int(11) NOT NULL AUTO_INCREMENT,
  `nama` text,
  `email` text NOT NULL,
  `subjek` text NOT NULL,
  `pesan` text NOT NULL,
  `datetime` text NOT NULL,
  PRIMARY KEY (`id_log_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lupa_password`
--

DROP TABLE IF EXISTS `lupa_password`;
CREATE TABLE IF NOT EXISTS `lupa_password` (
  `id_lupa_password` int(10) NOT NULL AUTO_INCREMENT,
  `id_akses` int(10) NOT NULL,
  `tanggal_dibuat` varchar(25) NOT NULL,
  `tanggal_expired` varchar(25) NOT NULL,
  `code_unik` text NOT NULL,
  PRIMARY KEY (`id_lupa_password`),
  KEY `id_akses` (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `id_member` char(36) NOT NULL COMMENT 'uuid',
  `nama` varchar(100) NOT NULL COMMENT 'Max 100 char',
  `kontak` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL COMMENT 'Max 100 char',
  `email_validation` char(9) DEFAULT NULL COMMENT 'Kode unik',
  `password` text NOT NULL COMMENT 'password_hash',
  `provinsi` varchar(50) NOT NULL,
  `kabupaten` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `desa` varchar(50) NOT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `rt_rw` varchar(50) DEFAULT NULL,
  `datetime` datetime NOT NULL COMMENT 'Waktu member mendaftar',
  `status` varchar(10) NOT NULL COMMENT 'Status validasi email \r\n(Pending, Active)',
  `sumber` char(7) NOT NULL COMMENT 'Website, Manual',
  `foto` char(37) DEFAULT NULL,
  PRIMARY KEY (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_login`
--

DROP TABLE IF EXISTS `member_login`;
CREATE TABLE IF NOT EXISTS `member_login` (
  `id_member_login` char(36) NOT NULL,
  `id_member` char(36) NOT NULL,
  `datetime_login` datetime NOT NULL,
  `datetime_expired` datetime NOT NULL,
  PRIMARY KEY (`id_member_login`),
  KEY `id_member` (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_lp_pass`
--

DROP TABLE IF EXISTS `member_lp_pass`;
CREATE TABLE IF NOT EXISTS `member_lp_pass` (
  `id_member_lp_pass` char(36) NOT NULL,
  `id_member` char(36) NOT NULL,
  `kode` char(36) NOT NULL,
  `status` char(6) NOT NULL COMMENT 'Active, None',
  PRIMARY KEY (`id_member_lp_pass`),
  KEY `reset_pass_to_member` (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_api_key`
--

DROP TABLE IF EXISTS `setting_api_key`;
CREATE TABLE IF NOT EXISTS `setting_api_key` (
  `id_setting_api_key` int(11) NOT NULL AUTO_INCREMENT,
  `datetime_creat` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  `title_api_key` varchar(50) NOT NULL,
  `description_api_key` varchar(255) NOT NULL,
  `user_key_server` char(36) NOT NULL,
  `password_server` varchar(255) NOT NULL COMMENT 'password_hash',
  `limit_session` int(11) NOT NULL COMMENT 'Limit waktu expired (Milisecond) ketika generate x-token',
  `status` char(5) NOT NULL COMMENT 'Aktif, None',
  PRIMARY KEY (`id_setting_api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_email_gateway`
--

DROP TABLE IF EXISTS `setting_email_gateway`;
CREATE TABLE IF NOT EXISTS `setting_email_gateway` (
  `id_setting_email_gateway` int(10) NOT NULL AUTO_INCREMENT,
  `email_gateway` text,
  `password_gateway` varchar(20) DEFAULT NULL,
  `url_provider` text,
  `port_gateway` varchar(10) DEFAULT NULL,
  `nama_pengirim` varchar(25) DEFAULT NULL,
  `url_service` text NOT NULL,
  `validasi_email` varchar(10) NOT NULL,
  `redirect_validasi` text NOT NULL,
  `pesan_validasi_email` text NOT NULL,
  PRIMARY KEY (`id_setting_email_gateway`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_general`
--

DROP TABLE IF EXISTS `setting_general`;
CREATE TABLE IF NOT EXISTS `setting_general` (
  `id_setting_general` int(10) NOT NULL AUTO_INCREMENT,
  `title_page` varchar(20) NOT NULL,
  `kata_kunci` text NOT NULL,
  `deskripsi` text NOT NULL,
  `alamat_bisnis` text NOT NULL,
  `email_bisnis` text NOT NULL,
  `telepon_bisnis` varchar(15) NOT NULL,
  `favicon` text NOT NULL,
  `logo` text NOT NULL,
  `base_url` text NOT NULL,
  PRIMARY KEY (`id_setting_general`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_payment`
--

DROP TABLE IF EXISTS `setting_payment`;
CREATE TABLE IF NOT EXISTS `setting_payment` (
  `id_setting_payment` int(10) NOT NULL AUTO_INCREMENT,
  `api_payment_url` text,
  `urll_call_back` text,
  `url_status` text NOT NULL,
  `api_key` text,
  `id_marchant` text,
  `client_key` text,
  `server_key` text,
  `snap_url` text,
  `production` varchar(10) NOT NULL,
  `aktif_payment_gateway` varchar(10) NOT NULL COMMENT 'Ya,Tidak',
  PRIMARY KEY (`id_setting_payment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_transaksi`
--

DROP TABLE IF EXISTS `setting_transaksi`;
CREATE TABLE IF NOT EXISTS `setting_transaksi` (
  `kategori` char(15) NOT NULL COMMENT 'Pendaftaran, Penjualan',
  `ppn_pph` decimal(11,2) DEFAULT NULL,
  `biaya_layanan` int(11) DEFAULT NULL,
  `potongan_lainnya` json DEFAULT NULL COMMENT 'list potongan',
  `biaya_lainnya` json DEFAULT NULL COMMENT 'list biaya',
  `expired_time` int(11) NOT NULL COMMENT 'Satuan Jam',
  `pengiriman` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `kode_transaksi` char(36) NOT NULL,
  `id_member` char(36) NOT NULL,
  `raw_member` json NOT NULL,
  `kategori` char(12) NOT NULL COMMENT 'Pendaftaran, Pembelian',
  `datetime` datetime NOT NULL,
  `tagihan` int(11) DEFAULT NULL COMMENT 'Biaya pendaftaran atau jumlah pembelian',
  `ongkir` int(11) DEFAULT NULL COMMENT 'Dari transaksi pengiriman',
  `ppn_pph` int(11) DEFAULT NULL COMMENT 'Dari setting_transaksi',
  `biaya_layanan` int(11) DEFAULT NULL COMMENT 'Dari setting_transaksi',
  `biaya_lainnya` json DEFAULT NULL COMMENT 'List Biaya Lain',
  `potongan_lainnya` json DEFAULT NULL COMMENT 'List Potongan Lain',
  `jumlah` int(11) DEFAULT NULL COMMENT 'jumlah total tagihan',
  `pengiriman` varchar(20) DEFAULT NULL COMMENT 'di kirim / di ambil ke toko',
  `status` varchar(20) NOT NULL COMMENT 'Lunas, Pending, Menunggu',
  PRIMARY KEY (`kode_transaksi`),
  KEY `id_member` (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_keranjang`
--

DROP TABLE IF EXISTS `transaksi_keranjang`;
CREATE TABLE IF NOT EXISTS `transaksi_keranjang` (
  `id_transaksi_keranjang` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `id_member` char(36) NOT NULL,
  `id_varian` char(36) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id_transaksi_keranjang`),
  KEY `to_barang` (`id_barang`),
  KEY `id_member` (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Record ini akan terhapus apabila sudah masuk ke transaksi';

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_payment`
--

DROP TABLE IF EXISTS `transaksi_payment`;
CREATE TABLE IF NOT EXISTS `transaksi_payment` (
  `id_transaksi_payment` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transaksi` char(36) NOT NULL,
  `order_id` char(36) DEFAULT NULL,
  `snap_token` text,
  `datetime` datetime NOT NULL,
  `status` char(20) NOT NULL COMMENT 'Pending, Lunas',
  PRIMARY KEY (`id_transaksi_payment`),
  KEY `kode_transaksi` (`kode_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pengiriman`
--

DROP TABLE IF EXISTS `transaksi_pengiriman`;
CREATE TABLE IF NOT EXISTS `transaksi_pengiriman` (
  `id_transaksi_pengiriman` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transaksi` char(36) NOT NULL,
  `no_resi` char(36) DEFAULT NULL,
  `kurir` varchar(30) DEFAULT NULL COMMENT 'Nama Perusahaan Kurir',
  `asal_pengiriman` text,
  `tujuan_pengiriman` text,
  `berat` int(11) DEFAULT NULL,
  `status_pengiriman` char(10) NOT NULL COMMENT 'Pending, Batal, Proses, Selesai',
  `datetime_pengiriman` datetime DEFAULT NULL,
  `ongkir` int(11) DEFAULT NULL,
  `link_pengiriman` text COMMENT 'Untuk pelacakan',
  PRIMARY KEY (`id_transaksi_pengiriman`),
  KEY `pengiriman_transaksi` (`kode_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_rincian`
--

DROP TABLE IF EXISTS `transaksi_rincian`;
CREATE TABLE IF NOT EXISTS `transaksi_rincian` (
  `id_transaksi_rincian` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transaksi` char(36) DEFAULT NULL,
  `id_member` char(36) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `varian` json DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi_rincian`),
  KEY `rincian_transaksi` (`kode_transaksi`),
  KEY `transaksi_member` (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_faq`
--

DROP TABLE IF EXISTS `web_faq`;
CREATE TABLE IF NOT EXISTS `web_faq` (
  `id_web_faq` int(11) NOT NULL AUTO_INCREMENT,
  `urutan` int(11) NOT NULL,
  `pertanyaan` varchar(100) NOT NULL,
  `jawaban` text NOT NULL,
  PRIMARY KEY (`id_web_faq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_galeri`
--

DROP TABLE IF EXISTS `web_galeri`;
CREATE TABLE IF NOT EXISTS `web_galeri` (
  `id_web_galeri` int(11) NOT NULL AUTO_INCREMENT,
  `id_web_galeri_album` char(36) NOT NULL,
  `album` varchar(50) NOT NULL,
  `nama_galeri` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `file_galeri` char(37) NOT NULL,
  PRIMARY KEY (`id_web_galeri`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_galeri_album`
--

DROP TABLE IF EXISTS `web_galeri_album`;
CREATE TABLE IF NOT EXISTS `web_galeri_album` (
  `id_web_galeri_album` char(36) NOT NULL,
  `album` varchar(50) NOT NULL,
  PRIMARY KEY (`id_web_galeri_album`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_log`
--

DROP TABLE IF EXISTS `web_log`;
CREATE TABLE IF NOT EXISTS `web_log` (
  `id_web_log` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `page_url` text NOT NULL,
  `ip_viewer` varchar(45) DEFAULT NULL,
  `os_viewer` varchar(100) DEFAULT NULL,
  `browser_viewer` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_web_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_medsos`
--

DROP TABLE IF EXISTS `web_medsos`;
CREATE TABLE IF NOT EXISTS `web_medsos` (
  `id_web_medsos` int(11) NOT NULL AUTO_INCREMENT,
  `nama_medsos` varchar(100) NOT NULL,
  `url_medsos` varchar(255) NOT NULL,
  `logo` char(37) NOT NULL,
  PRIMARY KEY (`id_web_medsos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_setting`
--

DROP TABLE IF EXISTS `web_setting`;
CREATE TABLE IF NOT EXISTS `web_setting` (
  `id_web_setting` int(11) NOT NULL AUTO_INCREMENT,
  `base_url` varchar(255) NOT NULL,
  `pavicon` char(37) NOT NULL,
  `icon` char(37) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  PRIMARY KEY (`id_web_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_tentang`
--

DROP TABLE IF EXISTS `web_tentang`;
CREATE TABLE IF NOT EXISTS `web_tentang` (
  `id_web_tentang` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) NOT NULL,
  `tentang` text NOT NULL,
  PRIMARY KEY (`id_web_tentang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_testimoni`
--

DROP TABLE IF EXISTS `web_testimoni`;
CREATE TABLE IF NOT EXISTS `web_testimoni` (
  `id_web_testimoni` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_member` char(36) NOT NULL,
  `nik_name` varchar(100) NOT NULL,
  `penilaian` tinyint(3) UNSIGNED DEFAULT NULL,
  `testimoni` text,
  `foto_profil` mediumtext,
  `sumber` char(8) NOT NULL COMMENT 'Manual, Website',
  `datetime` datetime NOT NULL,
  `status` enum('Publish','Draft') DEFAULT 'Draft',
  PRIMARY KEY (`id_web_testimoni`),
  KEY `web_testimoni_to_member` (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_tos`
--

DROP TABLE IF EXISTS `web_tos`;
CREATE TABLE IF NOT EXISTS `web_tos` (
  `id_web_tos` int(11) NOT NULL AUTO_INCREMENT,
  `privacy_policy` mediumtext,
  `term_of_service` mediumtext,
  PRIMARY KEY (`id_web_tos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_vidio`
--

DROP TABLE IF EXISTS `web_vidio`;
CREATE TABLE IF NOT EXISTS `web_vidio` (
  `id_web_vidio` char(36) NOT NULL,
  `sumber_vidio` char(5) NOT NULL COMMENT 'Embed, Url, Local',
  `title_vidio` varchar(100) NOT NULL COMMENT 'Judul Vidio',
  `deskripsi` text NOT NULL,
  `vidio` text NOT NULL COMMENT 'Embed Code, URL, File Name',
  `datetime` datetime NOT NULL,
  `thumbnail` char(40) DEFAULT NULL,
  PRIMARY KEY (`id_web_vidio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

DROP TABLE IF EXISTS `wilayah`;
CREATE TABLE IF NOT EXISTS `wilayah` (
  `id_wilayah` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) NOT NULL,
  `propinsi` varchar(50) DEFAULT NULL,
  `kabupaten` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `desa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_wilayah`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akses`
--
ALTER TABLE `akses`
  ADD CONSTRAINT `akses_ibfk_1` FOREIGN KEY (`akses`) REFERENCES `akses_entitas` (`akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akses_ijin`
--
ALTER TABLE `akses_ijin`
  ADD CONSTRAINT `akses_ijin_ibfk_1` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `akses_ijin_ibfk_2` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akses_referensi`
--
ALTER TABLE `akses_referensi`
  ADD CONSTRAINT `akses_referensi_ibfk_1` FOREIGN KEY (`uuid_akses_entitas`) REFERENCES `akses_entitas` (`uuid_akses_entitas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `akses_referensi_ibfk_2` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akses_validasi`
--
ALTER TABLE `akses_validasi`
  ADD CONSTRAINT `to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `api_session`
--
ALTER TABLE `api_session`
  ADD CONSTRAINT `api_session_ibfk_1` FOREIGN KEY (`id_setting_api_key`) REFERENCES `setting_api_key` (`id_setting_api_key`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_assesment`
--
ALTER TABLE `event_assesment`
  ADD CONSTRAINT `to_assesment_form` FOREIGN KEY (`id_event_assesment_form`) REFERENCES `event_assesment_form` (`id_event_assesment_form`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_event_peserta` FOREIGN KEY (`id_event_peserta`) REFERENCES `event_peserta` (`id_event_peserta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_assesment_form`
--
ALTER TABLE `event_assesment_form`
  ADD CONSTRAINT `assesment_to_event` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_kategori`
--
ALTER TABLE `event_kategori`
  ADD CONSTRAINT `event_to_kategori` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_peserta`
--
ALTER TABLE `event_peserta`
  ADD CONSTRAINT `event_peserta_to_event` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_peserta_to_kategori` FOREIGN KEY (`id_event_kategori`) REFERENCES `event_kategori` (`id_event_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_peserta_to_member` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `log_api`
--
ALTER TABLE `log_api`
  ADD CONSTRAINT `log_api_ibfk_1` FOREIGN KEY (`id_setting_api_key`) REFERENCES `setting_api_key` (`id_setting_api_key`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lupa_password`
--
ALTER TABLE `lupa_password`
  ADD CONSTRAINT `lupa_password_ibfk_1` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_login`
--
ALTER TABLE `member_login`
  ADD CONSTRAINT `login_member_to_member` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_lp_pass`
--
ALTER TABLE `member_lp_pass`
  ADD CONSTRAINT `reset_pass_to_member` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_to_member` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_keranjang`
--
ALTER TABLE `transaksi_keranjang`
  ADD CONSTRAINT `keranjang_to_member` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_payment`
--
ALTER TABLE `transaksi_payment`
  ADD CONSTRAINT `transaksi_payment` FOREIGN KEY (`kode_transaksi`) REFERENCES `transaksi` (`kode_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_pengiriman`
--
ALTER TABLE `transaksi_pengiriman`
  ADD CONSTRAINT `pengiriman_transaksi` FOREIGN KEY (`kode_transaksi`) REFERENCES `transaksi` (`kode_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_rincian`
--
ALTER TABLE `transaksi_rincian`
  ADD CONSTRAINT `rincian_transaksi` FOREIGN KEY (`kode_transaksi`) REFERENCES `transaksi` (`kode_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_member` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `web_testimoni`
--
ALTER TABLE `web_testimoni`
  ADD CONSTRAINT `web_testimoni_to_member` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
