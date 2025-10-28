-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 23, 2025 at 04:54 PM
-- Server version: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pegawai_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `idx` bigint(8) NOT NULL,
  `id` bigint(8) NOT NULL,
  `tanggal1` date NOT NULL,
  `tanggal2` date NOT NULL,
  `kode` varchar(2) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_apel`
--

CREATE TABLE `absen_apel` (
  `apel_id` bigint(20) NOT NULL,
  `apel_nama` varchar(100) NOT NULL,
  `apel_tanggal` date NOT NULL,
  `apel_mulai` time NOT NULL,
  `apel_selesai` time NOT NULL,
  `lokasi_id` int(11) NOT NULL,
  `apel_aktif` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_data`
--

CREATE TABLE `absen_data` (
  `ad_id` int(11) NOT NULL,
  `waktu_id` int(1) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `tanggal` date NOT NULL,
  `masuk` time DEFAULT '00:00:00',
  `keluar` time DEFAULT '00:00:00',
  `masuk_unit` varchar(10) DEFAULT NULL,
  `keluar_unit` varchar(10) DEFAULT NULL,
  `waktu` varchar(5) DEFAULT '0',
  `target` varchar(5) NOT NULL DEFAULT '0',
  `kode` varchar(10) DEFAULT NULL,
  `excp_id` int(11) DEFAULT NULL,
  `pengurangan_masuk` float NOT NULL DEFAULT 0,
  `pengurangan_keluar` float NOT NULL DEFAULT 0,
  `pengurangan_lainnya` float NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `ad_rekam` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_excp`
--

CREATE TABLE `absen_excp` (
  `excp_id` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `kode` varchar(10) NOT NULL,
  `keterangan` text NOT NULL,
  `idx` int(11) NOT NULL,
  `cek` int(1) NOT NULL DEFAULT 0,
  `sppd_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_excp_backup`
--

CREATE TABLE `absen_excp_backup` (
  `excp_id` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `kode` varchar(10) NOT NULL,
  `keterangan` text NOT NULL,
  `idx` int(11) NOT NULL,
  `cek` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_hari`
--

CREATE TABLE `absen_hari` (
  `hari_id` int(2) NOT NULL,
  `hari_nama` varchar(20) NOT NULL,
  `masuk` time NOT NULL DEFAULT '08:00:00',
  `istirahat` time NOT NULL DEFAULT '12:00:00',
  `kembali` time NOT NULL DEFAULT '13:00:00',
  `pulang` time NOT NULL DEFAULT '16:00:00',
  `hari_waktu` int(11) NOT NULL DEFAULT 420
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_lokasi`
--

CREATE TABLE `absen_lokasi` (
  `lokasi_id` int(11) NOT NULL,
  `lokasi_nama` varchar(100) NOT NULL,
  `lokasi_alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_mesinerror`
--

CREATE TABLE `absen_mesinerror` (
  `me_id` int(11) NOT NULL,
  `unit_id` varchar(11) NOT NULL,
  `me_mulai` date NOT NULL,
  `me_akhir` date NOT NULL,
  `me_keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_ramadhan`
--

CREATE TABLE `absen_ramadhan` (
  `ramadhan_id` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `ramadhan_mulai` date NOT NULL,
  `ramadhan_akhir` date NOT NULL,
  `ramadhan_cek` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_waktu`
--

CREATE TABLE `absen_waktu` (
  `waktu_id` int(1) NOT NULL,
  `waktu_nama` varchar(20) NOT NULL,
  `waktu_masuk` time NOT NULL,
  `waktu_keluar` time NOT NULL,
  `waktu_masuk_awal` time NOT NULL,
  `waktu_masuk_akhir` time NOT NULL,
  `waktu_keluar_awal` time NOT NULL,
  `waktu_keluar_akhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absen_waktu_ramadhan`
--

CREATE TABLE `absen_waktu_ramadhan` (
  `waktu_id` int(1) NOT NULL,
  `waktu_nama` varchar(20) NOT NULL,
  `waktu_masuk` time NOT NULL,
  `waktu_keluar` time NOT NULL,
  `waktu_masuk_awal` time NOT NULL,
  `waktu_masuk_akhir` time NOT NULL,
  `waktu_keluar_awal` time NOT NULL,
  `waktu_keluar_akhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` varchar(3) NOT NULL,
  `bank_nama` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_keluarga`
--

CREATE TABLE `daftar_keluarga` (
  `nip` varchar(18) NOT NULL,
  `kel_id` varchar(21) NOT NULL,
  `kel_nama` varchar(50) NOT NULL,
  `kel_hub` varchar(20) NOT NULL,
  `kel_jk` varchar(1) NOT NULL,
  `kel_t4l` varchar(20) NOT NULL,
  `kel_tgl` date NOT NULL,
  `kel_agama` varchar(20) NOT NULL,
  `kel_akta_no` varchar(30) NOT NULL,
  `kel_akta_tgl` date NOT NULL,
  `kel_nip` varchar(18) NOT NULL,
  `kel_tanggung` tinyint(1) NOT NULL,
  `kel_pekerjaan` varchar(50) NOT NULL,
  `kel_nikah_tgl` date DEFAULT NULL,
  `kel_15` int(11) DEFAULT NULL,
  `kel_16` int(11) DEFAULT NULL,
  `kel_17` int(11) DEFAULT NULL,
  `kel_18` int(11) DEFAULT NULL,
  `kel_19` int(11) DEFAULT NULL,
  `kel_ver` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `directory`
--

CREATE TABLE `directory` (
  `dir_id` int(3) NOT NULL,
  `dir_kode` varchar(5) NOT NULL,
  `dir_lokasi` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_files`
--

CREATE TABLE `document_files` (
  `id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(500) NOT NULL,
  `size` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_history`
--

CREATE TABLE `document_history` (
  `id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `status` enum('draft','submitted','approved','rejected') NOT NULL,
  `catatan` text DEFAULT NULL,
  `nip` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_review_history`
--

CREATE TABLE `document_review_history` (
  `id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `action` enum('approved','rejected','returned') NOT NULL,
  `catatan` text DEFAULT NULL,
  `alasan` varchar(255) DEFAULT NULL,
  `reviewer_nip` varchar(18) NOT NULL,
  `reviewer_nama` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_submissions`
--

CREATE TABLE `document_submissions` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `tahun` year(4) NOT NULL,
  `status` enum('draft','submitted','approved','rejected') DEFAULT 'draft',
  `catatan` text DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `reviewed_nip` varchar(18) DEFAULT NULL,
  `alasan_penolakan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_types_`
--

CREATE TABLE `document_types_` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekin_konfigurasi_api`
--

CREATE TABLE `ekin_konfigurasi_api` (
  `config_id` int(11) NOT NULL,
  `environment_name` varchar(50) NOT NULL,
  `address_kinerja` varchar(255) NOT NULL,
  `address_sso` varchar(255) DEFAULT NULL,
  `address_report_api` varchar(255) DEFAULT NULL,
  `token` text NOT NULL,
  `token_user_nip` varchar(18) DEFAULT NULL,
  `token_generated_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekin_laporan_penilaian`
--

CREATE TABLE `ekin_laporan_penilaian` (
  `skp_penilaian_id` varchar(36) NOT NULL,
  `id_pegawai` varchar(36) DEFAULT NULL,
  `nip` varchar(18) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tahun_skp` int(11) DEFAULT NULL,
  `periode_id` varchar(36) DEFAULT NULL,
  `jenis_pegawai` varchar(50) DEFAULT NULL,
  `golru` varchar(10) DEFAULT NULL,
  `skp_id` varchar(36) DEFAULT NULL,
  `skp_jabatan` varchar(255) DEFAULT NULL,
  `skp_unor` varchar(255) DEFAULT NULL,
  `skp_unor_induk` varchar(255) DEFAULT NULL,
  `skp_jenis_jabatan` varchar(10) DEFAULT NULL,
  `is_skp_plt_plh_pjb` tinyint(1) DEFAULT NULL,
  `hasil_kerja` varchar(50) DEFAULT NULL,
  `perilaku_kerja` varchar(50) DEFAULT NULL,
  `hasil_akhir` varchar(50) DEFAULT NULL,
  `pegawai_atasan_nip` varchar(18) DEFAULT NULL,
  `pegawai_atasan_nama` varchar(255) DEFAULT NULL,
  `pegawai_atasan_jabatan` varchar(255) DEFAULT NULL,
  `waktu_dinilai` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekin_laporan_skp`
--

CREATE TABLE `ekin_laporan_skp` (
  `skp_id` varchar(36) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `jenis_pegawai` varchar(50) DEFAULT NULL,
  `skp_status` varchar(50) DEFAULT NULL,
  `skp_model` varchar(50) DEFAULT NULL,
  `skp_unor` varchar(255) DEFAULT NULL,
  `skp_unor_atasan` varchar(255) DEFAULT NULL,
  `skp_unor_induk` varchar(255) DEFAULT NULL,
  `periode_awal` date DEFAULT NULL,
  `periode_akhir` date DEFAULT NULL,
  `is_plt_plh` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekin_ref_periode`
--

CREATE TABLE `ekin_ref_periode` (
  `id` varchar(36) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `periode_awal` varchar(10) DEFAULT NULL,
  `periode_akhir` varchar(10) DEFAULT NULL,
  `batas_pengisian` varchar(10) DEFAULT NULL,
  `jenis_periode` varchar(50) DEFAULT NULL,
  `tipe_periodik` varchar(50) DEFAULT NULL,
  `angka_periodik` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_kgb`
--

CREATE TABLE `form_kgb` (
  `unit_id` varchar(6) NOT NULL,
  `kgb_no` varchar(50) DEFAULT NULL,
  `kgb_tujuan` varchar(100) DEFAULT NULL,
  `kgb_tujuan_tempat` varchar(50) DEFAULT NULL,
  `kgb_dasar` varchar(200) DEFAULT NULL,
  `kgb_tembusan` text DEFAULT NULL,
  `kgb_07` int(11) DEFAULT NULL,
  `kgb_08` int(11) DEFAULT NULL,
  `kgb_09` int(11) DEFAULT NULL,
  `kgb_10` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gaji_ampra`
--

CREATE TABLE `gaji_ampra` (
  `ampra_id` varchar(22) NOT NULL,
  `ampra_tgl` date NOT NULL,
  `nip` varchar(18) NOT NULL,
  `statuskepegawaian` varchar(10) NOT NULL,
  `pangkat_id` varchar(2) NOT NULL,
  `eselon_id` varchar(2) NOT NULL,
  `fungsional_id` varchar(3) NOT NULL,
  `jml_istri` varchar(1) NOT NULL,
  `jml_anak` varchar(1) NOT NULL,
  `mkg_tahun` varchar(2) NOT NULL,
  `dgaji` year(4) DEFAULT NULL,
  `unit_id` varchar(6) DEFAULT NULL,
  `gapok` varchar(15) DEFAULT NULL,
  `tunjanganistri` varchar(15) DEFAULT NULL,
  `tunjangananak` varchar(15) DEFAULT NULL,
  `tunjanganjabatan` varchar(15) DEFAULT NULL,
  `tunjanganfungsional` varchar(15) DEFAULT NULL,
  `tunjanganumum` varchar(15) DEFAULT NULL,
  `tunjanganberas` varchar(15) DEFAULT NULL,
  `iwp` varchar(15) DEFAULT NULL,
  `taperum` varchar(15) DEFAULT NULL,
  `pembulatan` varchar(15) DEFAULT NULL,
  `pph` varchar(15) DEFAULT NULL,
  `askesda` varchar(15) DEFAULT NULL,
  `ampra_25` varchar(15) DEFAULT NULL,
  `ampra_26` varchar(15) DEFAULT NULL,
  `ampra_27` varchar(15) DEFAULT NULL,
  `jmlkotor` varchar(15) DEFAULT NULL,
  `jmlpotongan` varchar(15) DEFAULT NULL,
  `jmlbayar` varchar(15) DEFAULT NULL,
  `ampra_31` varchar(15) DEFAULT NULL,
  `ampra_32` varchar(15) DEFAULT NULL,
  `ampra_33` varchar(15) DEFAULT NULL,
  `ampra_34` varchar(15) DEFAULT NULL,
  `ampra_35` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gaji_gapok`
--

CREATE TABLE `gaji_gapok` (
  `dgaji_tahun` year(4) NOT NULL,
  `pangkat_id` int(11) NOT NULL,
  `mkg` varchar(2) NOT NULL,
  `gapok` varchar(10) DEFAULT NULL,
  `dgaji_05` int(11) DEFAULT NULL,
  `dgaji_06` int(11) DEFAULT NULL,
  `dgaji_07` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gaji_tabel`
--

CREATE TABLE `gaji_tabel` (
  `dgaji_id` int(3) NOT NULL,
  `dgaji_tahun` year(4) NOT NULL,
  `dgaji_reg_no` varchar(50) NOT NULL,
  `dgaji_reg_tgl` date DEFAULT NULL,
  `dgaji_05` int(11) DEFAULT NULL,
  `dgaji_06` int(11) DEFAULT NULL,
  `dgaji_07` int(11) DEFAULT NULL,
  `dgaji_08` int(11) DEFAULT NULL,
  `dgaji_09` int(11) DEFAULT NULL,
  `dgaji_10` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gis_kategori`
--

CREATE TABLE `gis_kategori` (
  `kategori_id` varchar(3) NOT NULL,
  `kategori_nama` varchar(100) NOT NULL,
  `kategori_induk` varchar(3) NOT NULL,
  `kategori_icon` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gis_lokasi`
--

CREATE TABLE `gis_lokasi` (
  `lokasi_id` int(8) NOT NULL,
  `lokasi_nama` varchar(200) NOT NULL,
  `lokasi_kategori` varchar(3) NOT NULL,
  `lokasi_alamat` varchar(256) NOT NULL,
  `lokasi_desa` varchar(256) NOT NULL,
  `kecamatan_id` varchar(6) NOT NULL,
  `lokasi_lat` varchar(9) NOT NULL,
  `lokasi_long` varchar(10) NOT NULL,
  `lokasi_ket` text NOT NULL,
  `unit_id` varchar(11) NOT NULL,
  `lokasi_zindex` int(5) DEFAULT NULL,
  `lokasi_panoramio` varchar(30) DEFAULT NULL,
  `lokasi_slug` varchar(256) DEFAULT NULL,
  `lokasi_13` varchar(2) DEFAULT NULL,
  `lokasi_14` varchar(2) DEFAULT NULL,
  `lokasi_15` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gis_titik`
--

CREATE TABLE `gis_titik` (
  `titik_id` int(5) NOT NULL,
  `titik_nama` varchar(200) NOT NULL,
  `titik_kategori` varchar(2) NOT NULL,
  `titik_alamat` varchar(256) NOT NULL,
  `titik_desa` varchar(10) NOT NULL,
  `titik_lat` varchar(20) NOT NULL,
  `titik_long` varchar(20) NOT NULL,
  `titik_ket` text NOT NULL,
  `unit_id` varchar(11) NOT NULL,
  `titik_10` varchar(2) DEFAULT NULL,
  `titik_11` varchar(2) DEFAULT NULL,
  `titik_12` varchar(2) DEFAULT NULL,
  `titik_13` varchar(2) DEFAULT NULL,
  `titik_14` varchar(2) DEFAULT NULL,
  `titik_15` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gis_user`
--

CREATE TABLE `gis_user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `level` int(1) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `harilibur`
--

CREATE TABLE `harilibur` (
  `id` int(2) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hukdis_data`
--

CREATE TABLE `hukdis_data` (
  `hukdis_id` int(11) NOT NULL,
  `nip` int(11) NOT NULL,
  `hukdis_kd` int(11) NOT NULL,
  `hukdis_mulai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id` int(3) NOT NULL,
  `instansi` text NOT NULL,
  `kepala` text NOT NULL,
  `nip` decimal(20,0) NOT NULL,
  `sn` varchar(20) NOT NULL,
  `nosurat` int(11) NOT NULL,
  `merk` int(2) NOT NULL,
  `lokasi_id` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_data`
--

CREATE TABLE `jabatan_data` (
  `jabatan_id` int(10) NOT NULL,
  `unit_id` varchar(7) NOT NULL,
  `jabatan_nama` varchar(300) NOT NULL,
  `jabatan_grup` varchar(300) NOT NULL,
  `jabatan_jenis_id` int(2) DEFAULT NULL,
  `jabatan_nip` varchar(18) DEFAULT NULL,
  `jabatan_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `jabatan_atasan_id` varchar(10) DEFAULT NULL,
  `jabatan_pjs_nip` int(10) DEFAULT NULL,
  `jabatan_tupoksi` text DEFAULT NULL,
  `jabatan_kelas` int(2) NOT NULL DEFAULT 0,
  `jabatan_nilai` varchar(5) NOT NULL DEFAULT '0',
  `jabatan_kondisi_kerja` int(3) NOT NULL DEFAULT 0,
  `jabatan_kelangkaan_profesi` int(3) NOT NULL DEFAULT 0,
  `jabatan_tunjangan_obyektif` bigint(12) NOT NULL DEFAULT 0,
  `admin_unit` tinyint(1) NOT NULL DEFAULT 0,
  `admin_kabupaten` tinyint(1) NOT NULL DEFAULT 0,
  `tpp` tinyint(1) NOT NULL DEFAULT 1,
  `persen_prestasi_kerja` int(11) NOT NULL DEFAULT 0 COMMENT 'mulai di 2022',
  `kondisi_kerja` int(11) NOT NULL DEFAULT 0 COMMENT 'mulai di 2022',
  `kelangkaan_profesi` int(11) NOT NULL DEFAULT 0 COMMENT 'mulai di 2022',
  `tunjangan_objektif_lainnya` int(11) NOT NULL DEFAULT 0 COMMENT 'mulai di 2022',
  `persen_beban_kerja` int(11) NOT NULL DEFAULT 0,
  `persen_kondisi_kerja` int(11) NOT NULL DEFAULT 0,
  `persen_kelangkaan_profesi` int(11) NOT NULL DEFAULT 0,
  `persen_tunjangan_objektif_lainnya` int(11) NOT NULL DEFAULT 0,
  `jabatan_status` enum('Definitif','Pjb','Plt','Plh') NOT NULL DEFAULT 'Definitif'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_data1`
--

CREATE TABLE `jabatan_data1` (
  `jabatan_id` int(10) NOT NULL,
  `unit_id` varchar(7) NOT NULL,
  `jabatan_nama` varchar(300) NOT NULL,
  `jabatan_grup` varchar(300) NOT NULL,
  `jabatan_jenis_id` int(2) DEFAULT NULL,
  `jabatan_nip` varchar(18) DEFAULT NULL,
  `jabatan_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `jabatan_atasan_id` varchar(10) DEFAULT NULL,
  `jabatan_pjs_nip` int(10) DEFAULT NULL,
  `jabatan_tupoksi` text DEFAULT NULL,
  `jabatan_nilai` varchar(5) NOT NULL DEFAULT '0',
  `jabatan_kondisi_kerja` int(3) NOT NULL DEFAULT 0,
  `jabatan_kelangkaan_profesi` int(3) NOT NULL DEFAULT 0,
  `jabatan_tunjangan_obyektif` bigint(12) NOT NULL DEFAULT 0,
  `admin_unit` tinyint(1) NOT NULL DEFAULT 0,
  `admin_kabupaten` tinyint(1) NOT NULL DEFAULT 0,
  `tpp` tinyint(1) NOT NULL DEFAULT 1,
  `persen_prestasi_kerja` int(11) NOT NULL DEFAULT 0 COMMENT 'mulai di 2022',
  `kondisi_kerja` int(11) NOT NULL DEFAULT 0 COMMENT 'mulai di 2022',
  `kelangkaan_profesi` int(11) NOT NULL DEFAULT 0 COMMENT 'mulai di 2022',
  `tunjangan_objektif_lainnya` int(11) NOT NULL DEFAULT 0 COMMENT 'mulai di 2022',
  `persen_beban_kerja` int(11) NOT NULL DEFAULT 0,
  `persen_kondisi_kerja` int(11) NOT NULL DEFAULT 0,
  `persen_kelangkaan_profesi` int(11) NOT NULL DEFAULT 0,
  `persen_tunjangan_objektif_lainnya` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_kelas`
--

CREATE TABLE `jabatan_kelas` (
  `jabatan_kelas_id` int(2) NOT NULL,
  `jabatan_kelas_max` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_harian`
--

CREATE TABLE `kegiatan_harian` (
  `kh_id` int(10) NOT NULL,
  `kb_id` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `kh_uraian` text NOT NULL,
  `kh_tanggal` date DEFAULT NULL,
  `kh_waktu` varchar(3) DEFAULT NULL COMMENT 'jam',
  `kh_rekam` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kinerja_bulanan`
--

CREATE TABLE `kinerja_bulanan` (
  `kb_id` int(10) NOT NULL,
  `kt_id` int(11) NOT NULL,
  `kb_uraian` varchar(200) NOT NULL DEFAULT '-',
  `kb01` varchar(50) NOT NULL DEFAULT '0',
  `kb02` varchar(50) NOT NULL DEFAULT '0',
  `kb03` varchar(50) NOT NULL DEFAULT '0',
  `kb04` varchar(50) NOT NULL DEFAULT '0',
  `kb05` varchar(50) NOT NULL DEFAULT '0',
  `kb06` varchar(50) NOT NULL DEFAULT '0',
  `kb07` varchar(50) NOT NULL DEFAULT '0',
  `kb08` varchar(50) NOT NULL DEFAULT '0',
  `kb09` varchar(50) NOT NULL DEFAULT '0',
  `kb10` varchar(50) NOT NULL DEFAULT '0',
  `kb11` varchar(50) NOT NULL DEFAULT '0',
  `kb12` varchar(50) NOT NULL DEFAULT '0',
  `kb_satuan` varchar(50) NOT NULL,
  `kb_keterangan` text DEFAULT NULL,
  `create` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kinerja_bulanan_realisasi`
--

CREATE TABLE `kinerja_bulanan_realisasi` (
  `kbr_id` int(10) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `kb_id` int(10) NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `kbr_realisasi` varchar(50) NOT NULL DEFAULT '0',
  `kbr_keterangan` text NOT NULL,
  `kbr_ver` varchar(4) NOT NULL DEFAULT '0',
  `kbr_tolak` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kinerja_tahunan`
--

CREATE TABLE `kinerja_tahunan` (
  `kt_id` int(10) NOT NULL,
  `kt_atasan_id` int(10) DEFAULT 0,
  `jabatan_id` int(10) NOT NULL,
  `kt_uraian` text NOT NULL,
  `tahun` year(4) DEFAULT NULL,
  `kt_target` int(50) DEFAULT NULL,
  `kt_satuan` varchar(50) NOT NULL,
  `ktr_target` int(50) DEFAULT NULL,
  `kt_waktu` varchar(3) DEFAULT NULL,
  `kt_kualitas` int(3) DEFAULT NULL,
  `kt_biaya` int(20) DEFAULT NULL,
  `kt_ak` varchar(4) DEFAULT NULL,
  `ktr_waktu` varchar(3) DEFAULT NULL,
  `ktr_kualitas` int(3) DEFAULT NULL,
  `ktr_biaya` int(20) DEFAULT NULL,
  `ktr_ak` varchar(4) DEFAULT NULL,
  `create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kinerja_tahunan_realisasi`
--

CREATE TABLE `kinerja_tahunan_realisasi` (
  `ktr_id` int(10) NOT NULL,
  `kt_id` int(10) NOT NULL,
  `nip` int(10) NOT NULL,
  `ktr_target` int(50) DEFAULT NULL,
  `ktr_waktu` varchar(3) DEFAULT NULL,
  `ktr_kualitas` int(3) DEFAULT NULL,
  `ktr_biaya` int(20) DEFAULT NULL,
  `ktr_ak` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kodeabsen`
--

CREATE TABLE `kodeabsen` (
  `simbol` varchar(2) NOT NULL,
  `arti` varchar(100) NOT NULL,
  `non_tpp` int(1) NOT NULL DEFAULT 1,
  `pengurangan` float NOT NULL DEFAULT 0,
  `simbol_induk` varchar(5) NOT NULL,
  `aktif` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_cuti`
--

CREATE TABLE `kode_cuti` (
  `cuti_id` int(3) NOT NULL,
  `cuti_nama` varchar(50) NOT NULL,
  `cuti_keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_diklat`
--

CREATE TABLE `kode_diklat` (
  `diklat_kode_id` int(3) NOT NULL,
  `diklat_kode_nama` varchar(30) NOT NULL,
  `diklat_kode_keterangan` text DEFAULT NULL,
  `diklat_05` int(11) DEFAULT NULL,
  `diklat_06` int(11) DEFAULT NULL,
  `diklat_07` int(11) DEFAULT NULL,
  `diklat_08` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_eselon`
--

CREATE TABLE `kode_eselon` (
  `eselon_id` int(2) NOT NULL,
  `eselon_nama` varchar(5) NOT NULL,
  `eselon_tunjangan` varchar(11) NOT NULL,
  `eselon_05` int(11) DEFAULT NULL,
  `eselon_06` int(11) DEFAULT NULL,
  `eselon_07` int(11) DEFAULT NULL,
  `eselon_08` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_fungsional`
--

CREATE TABLE `kode_fungsional` (
  `fungsional_id` int(4) NOT NULL,
  `fungsional_nama` varchar(50) NOT NULL,
  `fungsional_rumpun_id` int(3) NOT NULL,
  `fungsional_instansi_pembina` varchar(50) DEFAULT NULL,
  `fungsional_regulasi` varchar(50) DEFAULT NULL,
  `fungsional_06` int(11) DEFAULT NULL,
  `fungsional_07` int(11) DEFAULT NULL,
  `fungsional_08` int(11) DEFAULT NULL,
  `fungsional_09` int(11) DEFAULT NULL,
  `fungsional_10` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_fungsional_jabatan`
--

CREATE TABLE `kode_fungsional_jabatan` (
  `fungsional_jabatan_id` varchar(6) NOT NULL,
  `fungsional_jabatan_nama` varchar(60) DEFAULT NULL,
  `fungsional_jabatan_tingkat` varchar(50) DEFAULT NULL,
  `fungsional_id` int(5) DEFAULT NULL,
  `fungsional_jabatan_kredit` int(7) DEFAULT NULL,
  `fungsional_jabatan_tunjangan` varchar(8) DEFAULT NULL,
  `fungsional_jabatan_bup` int(2) DEFAULT NULL,
  `pangkat_id_min` varchar(10) DEFAULT NULL,
  `fungsional_jabatan_09` varchar(10) DEFAULT NULL,
  `fungsional_jabatan_10` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_fungsional_rumpun`
--

CREATE TABLE `kode_fungsional_rumpun` (
  `fungsional_rumpun_id` int(3) NOT NULL,
  `fungsional_rumpun_nama` varchar(50) NOT NULL,
  `fungsional_rumpun_04` int(11) DEFAULT NULL,
  `fungsional_rumpun_05` int(11) DEFAULT NULL,
  `fungsional_rumpun_06` int(11) DEFAULT NULL,
  `fungsional_rumpun_07` int(11) DEFAULT NULL,
  `fungsional_rumpun_08` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_hukdis`
--

CREATE TABLE `kode_hukdis` (
  `hukdis_kd` int(11) NOT NULL,
  `hukdis_nama` int(11) NOT NULL,
  `hukdis_uraian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_jabatan`
--

CREATE TABLE `kode_jabatan` (
  `jabatan_jenis_id` int(2) NOT NULL,
  `jabatan_jenis_nama` varchar(50) NOT NULL,
  `jabatan_jenis_eselon` varchar(5) DEFAULT NULL,
  `jabatan_jenis_tunjangan` varchar(11) NOT NULL,
  `indeks_jabatan_struktural` decimal(10,2) DEFAULT NULL,
  `indeks_penyeimbang` decimal(10,2) DEFAULT NULL COMMENT '1.2 diberikan kepada jabatan non struktural dan jabatan fungsional yang berada pada kelas jabatan 3-7',
  `eselon_07` int(11) DEFAULT NULL,
  `eselon_08` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_kabupaten`
--

CREATE TABLE `kode_kabupaten` (
  `kabupaten_id` varchar(4) NOT NULL,
  `kabupaten_nama` varchar(50) NOT NULL,
  `propinsi_id` varchar(2) NOT NULL,
  `nama_bupati` varchar(50) NOT NULL,
  `nama_wabup` varchar(50) NOT NULL,
  `nip_sekda` varchar(18) NOT NULL,
  `kabupaten_logo` varchar(100) DEFAULT NULL,
  `kabupaten_ibukota` varchar(50) DEFAULT NULL,
  `kabupaten_09` int(11) DEFAULT NULL,
  `kabupaten_10` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_kecamatan`
--

CREATE TABLE `kode_kecamatan` (
  `kecamatan_id` varchar(6) NOT NULL,
  `kecamatan_nama` varchar(50) NOT NULL,
  `kabupaten_id` varchar(4) NOT NULL,
  `nama_camat` varchar(50) NOT NULL,
  `kecamatan_polygon` text DEFAULT NULL,
  `kecamatan_slug` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_pangkat`
--

CREATE TABLE `kode_pangkat` (
  `pangkat_id` int(2) NOT NULL,
  `pangkat_golruang` varchar(5) NOT NULL,
  `pangkat_nama` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_pangkat_jenis`
--

CREATE TABLE `kode_pangkat_jenis` (
  `pangkat_jenis_id` int(3) NOT NULL,
  `pangkat_jenis_nama` varchar(50) NOT NULL,
  `pangkat_jenis_03` int(11) DEFAULT NULL,
  `pangkat_jenis_04` int(11) DEFAULT NULL,
  `pangkat_jenis_05` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_pendidikan`
--

CREATE TABLE `kode_pendidikan` (
  `pendidikantk_id` varchar(3) NOT NULL,
  `pendidikantk_nama` varchar(30) NOT NULL,
  `pendidikantk_keterangan` varchar(50) DEFAULT NULL,
  `pendidikantk_05` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_pensiun`
--

CREATE TABLE `kode_pensiun` (
  `pensiun_id` int(3) NOT NULL,
  `pensiun_nama` varchar(30) NOT NULL,
  `pensiun_keterangan` text DEFAULT NULL,
  `pensiun_04` int(11) DEFAULT NULL,
  `pensiun_05` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_propinsi`
--

CREATE TABLE `kode_propinsi` (
  `propinsi_id` varchar(2) NOT NULL,
  `propinsi_nama` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_del`
--

CREATE TABLE `log_del` (
  `del_id` bigint(11) NOT NULL,
  `del_tabel` varchar(200) NOT NULL,
  `del_user` varchar(20) NOT NULL,
  `del_tgl` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_url` varchar(200) NOT NULL,
  `del_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `del_restore` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maskel`
--

CREATE TABLE `maskel` (
  `id` int(1) NOT NULL,
  `masuk` time NOT NULL,
  `keluar` time NOT NULL,
  `tolmasuk` decimal(4,0) NOT NULL,
  `tolkeluar` decimal(4,0) NOT NULL,
  `mskos` decimal(4,0) NOT NULL,
  `klkos` decimal(4,0) NOT NULL,
  `istirahat` time NOT NULL,
  `kembali` time NOT NULL,
  `tiskem` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_utama`
--

CREATE TABLE `menu_utama` (
  `menu_id` int(3) NOT NULL,
  `menu_nama` varchar(20) NOT NULL,
  `menu_url` varchar(100) NOT NULL,
  `menu_level` int(11) NOT NULL,
  `menu_parent` int(11) NOT NULL,
  `menu_06` int(11) DEFAULT NULL,
  `menu_07` int(11) DEFAULT NULL,
  `menu_08` int(11) DEFAULT NULL,
  `menu_09` int(11) DEFAULT NULL,
  `menu_10` int(11) DEFAULT NULL,
  `menu_11` int(11) DEFAULT NULL,
  `menu_12` int(11) DEFAULT NULL,
  `menu_13` int(11) DEFAULT NULL,
  `menu_14` int(11) DEFAULT NULL,
  `menu_15` int(11) DEFAULT NULL,
  `menu_16` int(11) DEFAULT NULL,
  `menu_17` int(11) DEFAULT NULL,
  `menu_18` int(11) DEFAULT NULL,
  `menu_19` int(11) DEFAULT NULL,
  `menu_20` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(10) UNSIGNED NOT NULL,
  `user_id_from` varchar(18) DEFAULT NULL,
  `user_id_to` varchar(10) DEFAULT NULL,
  `folder_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `priority` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `subject` text NOT NULL,
  `message` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `no` int(2) NOT NULL,
  `nip` decimal(20,0) NOT NULL,
  `nama` text NOT NULL,
  `skpd` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_atasan`
--

CREATE TABLE `pegawai_atasan` (
  `nip` varchar(18) NOT NULL,
  `jabatan_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_data`
--

CREATE TABLE `pegawai_data` (
  `nip` varchar(18) NOT NULL,
  `nip_lama` varchar(9) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nomor_hp` varchar(15) NOT NULL,
  `unit_id_` varchar(8) NOT NULL,
  `pangkat_id` int(2) DEFAULT NULL,
  `pangkat_tmt` date DEFAULT NULL,
  `pangkat_mk_thn` int(2) DEFAULT NULL,
  `pangkat_mk_bln` int(2) DEFAULT NULL,
  `npwp` varchar(15) DEFAULT NULL,
  `rekening` varchar(17) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `_admin_kabupaten` tinyint(1) NOT NULL DEFAULT 0,
  `_admin_unit` tinyint(1) NOT NULL DEFAULT 0,
  `status_pns` varchar(3) NOT NULL DEFAULT '1',
  `session_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_data_lama`
--

CREATE TABLE `pegawai_data_lama` (
  `nip` varchar(18) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `unit_id` varchar(11) NOT NULL,
  `statuskepegawaian` varchar(10) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `agama` varchar(10) DEFAULT NULL,
  `gol_darah` varchar(2) DEFAULT NULL,
  `karpeg` varchar(20) DEFAULT NULL,
  `askes` varchar(20) DEFAULT NULL,
  `taspen` varchar(20) DEFAULT NULL,
  `npwp` varchar(20) DEFAULT NULL,
  `sim` varchar(20) DEFAULT NULL,
  `dosir` varchar(20) DEFAULT NULL,
  `jamkesda` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sf` varchar(10) DEFAULT NULL,
  `pensiun` int(5) DEFAULT NULL,
  `peg_20` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_foto`
--

CREATE TABLE `pegawai_foto` (
  `nip` varchar(18) NOT NULL,
  `foto_nama` varchar(50) NOT NULL,
  `foto_type` varchar(20) NOT NULL,
  `foto_size` varchar(10) NOT NULL,
  `foto_path` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_kp4`
--

CREATE TABLE `pegawai_kp4` (
  `nip` varchar(18) NOT NULL,
  `kp4_penghasilan` varchar(100) NOT NULL,
  `kp4_penghasilan_gaji` varchar(10) NOT NULL,
  `kp4_tgl` date NOT NULL,
  `kp4_pensiun` varchar(10) DEFAULT NULL,
  `kp4_06` int(11) DEFAULT NULL,
  `kp4_07` int(11) DEFAULT NULL,
  `kp4_08` int(11) DEFAULT NULL,
  `kp4_09` int(11) DEFAULT NULL,
  `kp4_ver` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_rekening`
--

CREATE TABLE `pegawai_rekening` (
  `rekening_id` varchar(21) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `rekening_no` varchar(30) NOT NULL,
  `bank_id` varchar(3) NOT NULL,
  `rekening_gaji` tinyint(1) NOT NULL,
  `rekening_06` int(11) DEFAULT NULL,
  `rekening_07` int(11) DEFAULT NULL,
  `rekening_08` int(11) DEFAULT NULL,
  `rekening_09` int(11) DEFAULT NULL,
  `rekening_10` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `tgl` date NOT NULL,
  `pagi` varchar(10) DEFAULT NULL,
  `siang` varchar(10) DEFAULT NULL,
  `sore` varchar(10) DEFAULT NULL,
  `jam_pagi` time DEFAULT NULL,
  `jam_siang` time DEFAULT NULL,
  `jam_sore` time DEFAULT NULL,
  `keterangan` varchar(10) DEFAULT NULL,
  `sync` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_unit`
--

CREATE TABLE `qr_unit` (
  `qr_id` int(5) NOT NULL,
  `qr_nama` varchar(50) NOT NULL,
  `unit_id` varchar(11) NOT NULL,
  `qr_kode` varchar(11) NOT NULL,
  `qr_lat` varchar(25) NOT NULL,
  `qr_lon` varchar(25) NOT NULL,
  `qr_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekap_absen`
--

CREATE TABLE `rekap_absen` (
  `ra_id` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `ra_bobot` varchar(5) NOT NULL,
  `manual` int(11) NOT NULL DEFAULT 0,
  `H` int(11) NOT NULL DEFAULT 0,
  `I` int(11) NOT NULL DEFAULT 0,
  `S` int(11) NOT NULL DEFAULT 0,
  `CT` int(11) NOT NULL DEFAULT 0,
  `TK` int(11) NOT NULL DEFAULT 0,
  `HK` int(11) NOT NULL DEFAULT 0,
  `tpp_persen` int(3) NOT NULL DEFAULT 100,
  `tpp_ket` varchar(100) NOT NULL DEFAULT ' ',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekap_absen1`
--

CREATE TABLE `rekap_absen1` (
  `ra_id` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `HADIR` varchar(15) DEFAULT NULL,
  `IZIN` varchar(15) DEFAULT NULL,
  `SAKIT` varchar(15) DEFAULT NULL,
  `DL` varchar(15) DEFAULT NULL,
  `CA` varchar(15) DEFAULT NULL,
  `CB` varchar(15) DEFAULT NULL,
  `TK` varchar(15) DEFAULT NULL,
  `TOT` varchar(15) DEFAULT NULL,
  `ra_bobot` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekap_kinerja`
--

CREATE TABLE `rekap_kinerja` (
  `rk_id` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `rk_bobot` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_cuti`
--

CREATE TABLE `riwayat_cuti` (
  `cuti_riw_id` varchar(30) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `cuti_id` int(3) NOT NULL,
  `cuti_tahun` varchar(10) NOT NULL,
  `cuti_lama` varchar(10) NOT NULL,
  `cuti_mulai` date NOT NULL,
  `cuti_selesai` date NOT NULL,
  `cuti_sk_pejabat` varchar(100) NOT NULL,
  `cuti_sk_no` varchar(30) NOT NULL,
  `cuti_sk_tgl` date NOT NULL,
  `cuti_11` int(11) DEFAULT NULL,
  `cuti_12` int(11) DEFAULT NULL,
  `cuti_13` int(11) DEFAULT NULL,
  `cuti_14` int(11) DEFAULT NULL,
  `cuti_ver` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_diklat`
--

CREATE TABLE `riwayat_diklat` (
  `diklat_id` varchar(30) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `diklat_kode_id` varchar(30) DEFAULT NULL,
  `diklat_nama` varchar(100) NOT NULL,
  `diklat_tahun` varchar(10) NOT NULL,
  `diklat_lembaga` varchar(100) DEFAULT NULL,
  `diklat_ijazah` varchar(100) DEFAULT NULL,
  `diklat_lama` varchar(30) DEFAULT NULL,
  `diklat_gelar` varchar(10) DEFAULT NULL,
  `diklat_gelar_posisi` varchar(10) DEFAULT NULL,
  `diklat_ijazah_tanggal` date DEFAULT NULL,
  `diklat_12` int(11) DEFAULT NULL,
  `diklat_13` int(11) DEFAULT NULL,
  `diklat_14` int(11) DEFAULT NULL,
  `diklat_ver` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_dp3`
--

CREATE TABLE `riwayat_dp3` (
  `dp3_id` varchar(21) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `dp3_tgl` date NOT NULL,
  `dp3_kesetiaan` varchar(3) NOT NULL,
  `dp3_prestasikerja` varchar(3) NOT NULL,
  `dp3_tanggungjawab` varchar(3) NOT NULL,
  `dp3_ketaatan` varchar(3) NOT NULL,
  `dp3_kejujuran` varchar(3) NOT NULL,
  `dp3_kerjasama` varchar(3) NOT NULL,
  `dp3_prakarsa` varchar(3) NOT NULL,
  `dp3_kepemimpinan` varchar(3) NOT NULL,
  `dp3_tgl2` date DEFAULT NULL,
  `dp3_tgl3` date DEFAULT NULL,
  `dp3_14` int(11) DEFAULT NULL,
  `dp3_15` int(11) DEFAULT NULL,
  `dp3_16` int(11) DEFAULT NULL,
  `dp3_17` int(11) DEFAULT NULL,
  `dp3_18` int(11) DEFAULT NULL,
  `dp3_19` int(11) DEFAULT NULL,
  `dp3_ver` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_fungsional`
--

CREATE TABLE `riwayat_fungsional` (
  `fungsional_riw_id` int(11) NOT NULL,
  `nip` int(18) NOT NULL,
  `fungsional_id` int(11) NOT NULL,
  `fungsional_sk_no` varchar(20) NOT NULL,
  `fungsional_sk_tgl` date NOT NULL,
  `fungsional_ver` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_jabatan`
--

CREATE TABLE `riwayat_jabatan` (
  `jabatan_riw_id` varchar(21) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `jabatan_nama` varchar(100) NOT NULL,
  `eselon_id` int(2) DEFAULT NULL,
  `jabatan_tmt` date DEFAULT NULL,
  `jabatan_sk_no` varchar(30) DEFAULT NULL,
  `jabatan_sk_tgl` date DEFAULT NULL,
  `jabatan_sk_pejabat` varchar(100) DEFAULT NULL,
  `fungsional_jabatan_id` int(11) DEFAULT NULL,
  `sf` varchar(11) DEFAULT NULL,
  `fungsional_jabatan_kredit` decimal(6,3) DEFAULT NULL,
  `jabatan_12` int(11) DEFAULT NULL,
  `jabatan_13` int(11) DEFAULT NULL,
  `jabatan_14` int(11) DEFAULT NULL,
  `jabatan_ver` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_kgb`
--

CREATE TABLE `riwayat_kgb` (
  `kgb_id` varchar(21) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `pangkat_id` int(2) NOT NULL,
  `kgb_sk_no` varchar(30) NOT NULL,
  `kgb_sk_tgl` date NOT NULL,
  `kgb_tmt` date NOT NULL,
  `kgb_gapok` varchar(10) NOT NULL,
  `mkg` varchar(5) DEFAULT NULL,
  `kgb_09` int(11) DEFAULT NULL,
  `kgb_10` int(11) DEFAULT NULL,
  `kgb_11` int(11) DEFAULT NULL,
  `kgb_12` int(11) DEFAULT NULL,
  `kgb_13` int(11) DEFAULT NULL,
  `kgb_14` int(11) DEFAULT NULL,
  `kgb_ver` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_organisasi`
--

CREATE TABLE `riwayat_organisasi` (
  `organisasi_id` varchar(21) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `organisasi_nama` varchar(50) NOT NULL,
  `organisasi_jabatan` varchar(30) NOT NULL,
  `organisasi_periode` varchar(20) NOT NULL,
  `organisasi_sk_no` varchar(30) NOT NULL,
  `organisasi_sk_tgl` date NOT NULL,
  `organisasi_pimpinan` varchar(30) NOT NULL,
  `organisasi_ver` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pangkat`
--

CREATE TABLE `riwayat_pangkat` (
  `pangkat_riw_id` varchar(21) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `pangkat_id` int(2) NOT NULL,
  `pangkat_tmt` date NOT NULL,
  `pangkat_jenis_id` varchar(50) NOT NULL,
  `pangkat_sk_pejabat` varchar(100) NOT NULL,
  `pangkat_sk_no` varchar(30) NOT NULL,
  `pangkat_sk_tgl` date NOT NULL,
  `pangkat_gapok` varchar(10) NOT NULL,
  `mkg` varchar(5) DEFAULT NULL,
  `pangkat_11` int(11) DEFAULT NULL,
  `pangkat_12` int(11) DEFAULT NULL,
  `pangkat_13` int(11) DEFAULT NULL,
  `pangkat_14` int(11) DEFAULT NULL,
  `pangkat_ver` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pendidikan`
--

CREATE TABLE `riwayat_pendidikan` (
  `pendidikan_id` varchar(21) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `pendidikan_tahun` year(4) NOT NULL,
  `pendidikan_tingkat` varchar(10) NOT NULL,
  `pendidikan_lembaga` varchar(100) NOT NULL,
  `pendidikan_pimpinan` varchar(100) DEFAULT NULL,
  `pendidikan_jurusan` varchar(100) DEFAULT NULL,
  `pendidikan_gelar` varchar(10) DEFAULT NULL,
  `pendidikan_gelar_posisi` varchar(10) DEFAULT NULL,
  `pendidikan_ijazah_no` varchar(100) DEFAULT NULL,
  `pendidikan_ijazah_tanggal` date DEFAULT NULL,
  `pendidikan_12` int(11) DEFAULT NULL,
  `pendidikan_13` int(11) DEFAULT NULL,
  `pendidikan_14` int(11) DEFAULT NULL,
  `pendidikan_ver` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_tjasa`
--

CREATE TABLE `riwayat_tjasa` (
  `tjasa_id` varchar(21) NOT NULL,
  `tjasa_nama` varchar(100) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `tjasa_tingkat` varchar(20) NOT NULL,
  `tjasa_sk_pejabat` varchar(100) NOT NULL,
  `tjasa_sk_no` varchar(50) NOT NULL,
  `tjasa_sk_tgl` date NOT NULL,
  `tjasa_ver` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skp_data`
--

CREATE TABLE `skp_data` (
  `skp_penilaian_id` varchar(255) NOT NULL,
  `skp_id` varchar(50) NOT NULL,
  `jenis` varchar(2) DEFAULT NULL,
  `id` varchar(50) DEFAULT NULL,
  `nip` varchar(18) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `periode_awal_skp` date DEFAULT NULL,
  `periode_akhir_skp` date DEFAULT NULL,
  `skp_unor_id` varchar(50) DEFAULT NULL,
  `skp_unor` varchar(100) DEFAULT NULL,
  `skp_unor_induk_id` varchar(50) DEFAULT NULL,
  `skp_unor_induk` varchar(100) DEFAULT NULL,
  `skp_jabatan` varchar(100) DEFAULT NULL,
  `skp_jenis_jabatan` varchar(2) DEFAULT NULL,
  `is_skp_plt_plh_pjb` tinyint(1) DEFAULT NULL,
  `hasil_kerja` varchar(50) DEFAULT NULL,
  `perilaku_kerja` varchar(50) DEFAULT NULL,
  `hasil_akhir` varchar(50) DEFAULT NULL,
  `pegawai_atasan_id` varchar(50) DEFAULT NULL,
  `pegawai_atasan_nip` varchar(18) DEFAULT NULL,
  `pegawai_atasan_nama` varchar(100) DEFAULT NULL,
  `pegawai_atasan_unor_id` varchar(50) DEFAULT NULL,
  `pegawai_atasan_unor` varchar(100) DEFAULT NULL,
  `pegawai_atasan_jabatan` varchar(100) DEFAULT NULL,
  `pegawai_atasan_golru` varchar(10) DEFAULT NULL,
  `waktu_dinilai` datetime DEFAULT NULL,
  `pegawai_penilai_id` varchar(50) DEFAULT NULL,
  `tahun_skp` varchar(4) DEFAULT NULL,
  `periode_id` varchar(50) DEFAULT NULL,
  `golru` varchar(10) DEFAULT NULL,
  `jenis_pegawai` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_sync_siasn` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skp_konversi_nilai`
--

CREATE TABLE `skp_konversi_nilai` (
  `id` int(11) NOT NULL,
  `tanggal_berlaku` date NOT NULL,
  `nilai_akhir` varchar(100) NOT NULL,
  `pengurang_bobot` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skp_periode`
--

CREATE TABLE `skp_periode` (
  `periode_id` varchar(50) NOT NULL,
  `skp_bulan` varchar(2) DEFAULT NULL,
  `skp_tahun` varchar(4) DEFAULT NULL,
  `skp_keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TABLE 96`
--

CREATE TABLE `TABLE 96` (
  `COL 1` bigint(14) DEFAULT NULL,
  `COL 2` varchar(19) DEFAULT NULL,
  `COL 3` int(4) DEFAULT NULL,
  `COL 4` int(1) DEFAULT NULL,
  `COL 5` int(1) DEFAULT NULL,
  `COL 6` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_device`
--

CREATE TABLE `tb_device` (
  `No` int(11) NOT NULL,
  `server_IP` text NOT NULL,
  `server_port` text NOT NULL,
  `device_sn` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_foto_absen`
--

CREATE TABLE `tb_foto_absen` (
  `idf` bigint(20) NOT NULL,
  `pin` varchar(10) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `tanggalz` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_instansi`
--

CREATE TABLE `tb_instansi` (
  `id` int(2) NOT NULL,
  `sn` varchar(20) NOT NULL,
  `namainstansi` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_mesin`
--

CREATE TABLE `tb_mesin` (
  `idm` int(2) NOT NULL,
  `merek` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `pin` bigint(8) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` bigint(30) NOT NULL,
  `instansi` int(7) NOT NULL,
  `manual` int(5) NOT NULL DEFAULT 0,
  `aktif` int(3) NOT NULL DEFAULT 1,
  `jenis` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai_ba`
--

CREATE TABLE `tb_pegawai_ba` (
  `pin` bigint(8) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `instansi` int(7) NOT NULL,
  `manual` int(5) NOT NULL,
  `aktif` int(3) NOT NULL,
  `jenis` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai_backup`
--

CREATE TABLE `tb_pegawai_backup` (
  `pin` bigint(8) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `instansi` int(7) NOT NULL,
  `manual` int(5) NOT NULL,
  `aktif` int(3) NOT NULL,
  `jenis` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai_bck_2509`
--

CREATE TABLE `tb_pegawai_bck_2509` (
  `pin` bigint(8) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `instansi` int(7) NOT NULL,
  `manual` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_qr`
--

CREATE TABLE `tb_qr` (
  `idq` bigint(10) NOT NULL,
  `pin` varchar(10) NOT NULL,
  `tanggals` datetime NOT NULL,
  `lat` varchar(25) NOT NULL,
  `lon` varchar(25) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_scanlog`
--

CREATE TABLE `tb_scanlog` (
  `sn` text NOT NULL,
  `scan_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pin` text NOT NULL,
  `verifymode` int(11) NOT NULL,
  `iomode` int(11) NOT NULL,
  `workcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_scanlog6`
--

CREATE TABLE `tb_scanlog6` (
  `sn` text NOT NULL,
  `scan_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pin` text NOT NULL,
  `verifymode` int(11) NOT NULL,
  `iomode` int(11) NOT NULL,
  `workcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_scanlog_30-03-2019`
--

CREATE TABLE `tb_scanlog_30-03-2019` (
  `sn` text NOT NULL,
  `scan_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pin` text NOT NULL,
  `verifymode` int(11) NOT NULL,
  `iomode` int(11) NOT NULL,
  `workcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_scanlog_ars`
--

CREATE TABLE `tb_scanlog_ars` (
  `id` bigint(15) NOT NULL,
  `sn` text NOT NULL,
  `scan_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `pin` text NOT NULL,
  `verifymode` int(11) NOT NULL DEFAULT 0,
  `iomode` int(11) NOT NULL DEFAULT 0,
  `workcode` int(11) NOT NULL DEFAULT 0,
  `waktu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_scanlog_ars2`
--

CREATE TABLE `tb_scanlog_ars2` (
  `sn` text NOT NULL,
  `scan_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pin` text NOT NULL,
  `verifymode` int(11) NOT NULL,
  `iomode` int(11) NOT NULL,
  `workcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_scanlog_ars6`
--

CREATE TABLE `tb_scanlog_ars6` (
  `sn` text NOT NULL,
  `scan_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `pin` text NOT NULL,
  `verifymode` int(11) NOT NULL,
  `iomode` int(11) NOT NULL,
  `workcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_template`
--

CREATE TABLE `tb_template` (
  `pin` text NOT NULL,
  `finger_idx` int(11) NOT NULL,
  `alg_ver` int(11) NOT NULL,
  `template` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tpp_data`
--

CREATE TABLE `tpp_data` (
  `tpp_id` int(11) NOT NULL,
  `unit_id` int(10) NOT NULL DEFAULT 0,
  `nip` varchar(18) NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `pangkat` varchar(100) NOT NULL,
  `jabatan` varchar(300) NOT NULL,
  `tpp_nilai` varchar(20) NOT NULL,
  `pph_persen` varchar(10) NOT NULL,
  `tpp_pph` varchar(20) NOT NULL,
  `tpp_diterima` varchar(20) NOT NULL,
  `tpp_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tpp_rekam` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tpp_indeks`
--

CREATE TABLE `tpp_indeks` (
  `indeks_id` int(11) NOT NULL,
  `indeks_regulasi` varchar(50) NOT NULL,
  `indeks_tpp` double NOT NULL,
  `indeks_harga_jabatan` varchar(20) NOT NULL,
  `indeks_reformasi_birokrasi` varchar(20) NOT NULL,
  `kemampuan_keuangan_daerah` varchar(10) NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tpp_indeks_jabatan`
--

CREATE TABLE `tpp_indeks_jabatan` (
  `indeks_jabatan_id` int(11) NOT NULL,
  `indeks_id` int(11) NOT NULL,
  `jabatan_jenis_id` int(2) NOT NULL,
  `indeks_jabatan_struktural` varchar(20) NOT NULL,
  `indeks_penyeimbang` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tpp_indeks_kelas_jabatan`
--

CREATE TABLE `tpp_indeks_kelas_jabatan` (
  `indeks_kb` int(11) NOT NULL,
  `indeks_id` int(11) NOT NULL,
  `jabatan_kelas_id` int(11) NOT NULL,
  `rp_bpk` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_data`
--

CREATE TABLE `unit_data` (
  `unit_id` varchar(11) NOT NULL,
  `kabupaten_id` varchar(4) DEFAULT NULL,
  `unit_kode` varchar(50) NOT NULL,
  `unit_nama` varchar(100) NOT NULL,
  `unit_alamat` text NOT NULL,
  `unit_telepon` varchar(15) DEFAULT NULL,
  `unit_fax` varchar(15) DEFAULT NULL,
  `unit_email` varchar(100) DEFAULT NULL,
  `unit_web` varchar(50) DEFAULT NULL,
  `unit_facebook` int(11) DEFAULT NULL,
  `unit_instagram` int(11) DEFAULT NULL,
  `unit_twitter` int(11) DEFAULT NULL,
  `unit_koordinat` varchar(100) DEFAULT NULL,
  `unit_kategori_id` varchar(3) DEFAULT NULL,
  `unit_induk` varchar(11) DEFAULT NULL,
  `pimpinan_jabatan_id` int(11) DEFAULT NULL,
  `bendahara_jabatan_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_kategori`
--

CREATE TABLE `unit_kategori` (
  `unit_kategori_id` varchar(3) NOT NULL,
  `unit_kategori_nama` varchar(100) NOT NULL,
  `unit_kategori_03` int(11) DEFAULT NULL,
  `unit_kategori_04` int(11) DEFAULT NULL,
  `unit_kategori_05` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_sub`
--

CREATE TABLE `unit_sub` (
  `unit_sub_id` varchar(50) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_sub_rumpun_id` varchar(11) NOT NULL,
  `unit_sub_kode` varchar(50) NOT NULL,
  `unit_sub_nama` varchar(100) NOT NULL,
  `unit_sub_alamat` text NOT NULL,
  `kecamatan_id` int(10) DEFAULT NULL,
  `unit_sub_pimpinan_nip` varchar(18) DEFAULT NULL,
  `unit_sub_pimpinan_jabatan` varchar(100) DEFAULT NULL,
  `unit_sub_telepon` varchar(15) DEFAULT NULL,
  `unit_sub_fax` varchar(15) DEFAULT NULL,
  `unit_sub_email` varchar(100) DEFAULT NULL,
  `sub_unit_koordinat` varchar(100) DEFAULT NULL,
  `unit_sub_14` int(11) DEFAULT NULL,
  `unit_sub_15` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_terkini`
--

CREATE TABLE `unit_terkini` (
  `unit_id` int(11) NOT NULL,
  `kabupaten_id` varchar(4) NOT NULL,
  `unit_terkini03` int(4) DEFAULT NULL,
  `unit_terkini04` int(4) DEFAULT NULL,
  `unit_terkini05` int(4) DEFAULT NULL,
  `unit_terkini06` int(4) DEFAULT NULL,
  `unit_terkini07` int(4) DEFAULT NULL,
  `unit_terkini08` int(4) DEFAULT NULL,
  `unit_terkini09` int(4) DEFAULT NULL,
  `unit_terkini10` int(4) DEFAULT NULL,
  `unit_terkini11` int(4) DEFAULT NULL,
  `unit_terkini12` int(4) DEFAULT NULL,
  `unit_terkini13` int(4) DEFAULT NULL,
  `unit_terkini14` int(4) DEFAULT NULL,
  `unit_terkini15` int(4) DEFAULT NULL,
  `unit_terkini16` int(4) DEFAULT NULL,
  `unit_terkini17` int(4) DEFAULT NULL,
  `unit_terkini18` int(4) DEFAULT NULL,
  `unit_terkini19` int(4) DEFAULT NULL,
  `unit_terkini20` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upacara`
--

CREATE TABLE `upacara` (
  `id` int(2) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL,
  `mesin` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_nip` varchar(18) NOT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_telp` varchar(20) DEFAULT NULL,
  `tglregister` datetime DEFAULT NULL,
  `tglterakhir` datetime DEFAULT NULL,
  `createdby` varchar(18) DEFAULT NULL,
  `admin_super` tinyint(1) DEFAULT NULL,
  `admin_kabupaten` varchar(4) DEFAULT NULL,
  `admin_unit` tinyint(1) DEFAULT NULL,
  `admin_kepegawaian` tinyint(1) DEFAULT NULL,
  `admin_perencanaan` tinyint(1) DEFAULT NULL,
  `admin_keuangan` tinyint(1) DEFAULT NULL,
  `admin_inventaris` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_admin` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_editor` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_confirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `user_level_id` varchar(3) NOT NULL,
  `user_level_nama` varchar(30) DEFAULT NULL,
  `user_level_ket` text DEFAULT NULL,
  `admin_kepegawaian` tinyint(1) DEFAULT NULL,
  `admin_perencanaan` tinyint(1) DEFAULT NULL,
  `admin_keuangan` tinyint(1) DEFAULT NULL,
  `admin_inventaris` tinyint(1) DEFAULT NULL,
  `level_08` int(11) DEFAULT NULL,
  `level_09` int(11) DEFAULT NULL,
  `level_10` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`idx`);

--
-- Indexes for table `absen_apel`
--
ALTER TABLE `absen_apel`
  ADD PRIMARY KEY (`apel_id`);

--
-- Indexes for table `absen_data`
--
ALTER TABLE `absen_data`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `absen_excp`
--
ALTER TABLE `absen_excp`
  ADD PRIMARY KEY (`excp_id`);

--
-- Indexes for table `absen_excp_backup`
--
ALTER TABLE `absen_excp_backup`
  ADD PRIMARY KEY (`excp_id`);

--
-- Indexes for table `absen_hari`
--
ALTER TABLE `absen_hari`
  ADD PRIMARY KEY (`hari_id`);

--
-- Indexes for table `absen_lokasi`
--
ALTER TABLE `absen_lokasi`
  ADD PRIMARY KEY (`lokasi_id`);

--
-- Indexes for table `absen_mesinerror`
--
ALTER TABLE `absen_mesinerror`
  ADD PRIMARY KEY (`me_id`);

--
-- Indexes for table `absen_ramadhan`
--
ALTER TABLE `absen_ramadhan`
  ADD PRIMARY KEY (`ramadhan_id`);

--
-- Indexes for table `absen_waktu`
--
ALTER TABLE `absen_waktu`
  ADD PRIMARY KEY (`waktu_id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD UNIQUE KEY `bank_id` (`bank_id`),
  ADD KEY `bank_nama` (`bank_nama`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `daftar_keluarga`
--
ALTER TABLE `daftar_keluarga`
  ADD PRIMARY KEY (`kel_id`),
  ADD KEY `nip` (`nip`),
  ADD KEY `kel_hub` (`kel_hub`);

--
-- Indexes for table `directory`
--
ALTER TABLE `directory`
  ADD PRIMARY KEY (`dir_id`);

--
-- Indexes for table `document_files`
--
ALTER TABLE `document_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `document_history`
--
ALTER TABLE `document_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`);

--
-- Indexes for table `document_review_history`
--
ALTER TABLE `document_review_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`),
  ADD KEY `reviewer_nip` (`reviewer_nip`);

--
-- Indexes for table `document_submissions`
--
ALTER TABLE `document_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_unit_bulan_tahun` (`unit_id`,`bulan`,`tahun`),
  ADD KEY `reviewed_nip` (`reviewed_nip`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_types_`
--
ALTER TABLE `document_types_`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ekin_konfigurasi_api`
--
ALTER TABLE `ekin_konfigurasi_api`
  ADD PRIMARY KEY (`config_id`),
  ADD UNIQUE KEY `environment_name` (`environment_name`);

--
-- Indexes for table `ekin_laporan_penilaian`
--
ALTER TABLE `ekin_laporan_penilaian`
  ADD PRIMARY KEY (`skp_penilaian_id`),
  ADD KEY `idx_nip` (`nip`),
  ADD KEY `idx_skp_id` (`skp_id`);

--
-- Indexes for table `ekin_laporan_skp`
--
ALTER TABLE `ekin_laporan_skp`
  ADD PRIMARY KEY (`skp_id`),
  ADD KEY `idx_nip` (`nip`);

--
-- Indexes for table `ekin_ref_periode`
--
ALTER TABLE `ekin_ref_periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_kgb`
--
ALTER TABLE `form_kgb`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `gaji_ampra`
--
ALTER TABLE `gaji_ampra`
  ADD PRIMARY KEY (`ampra_id`),
  ADD KEY `ampra_tgl` (`ampra_tgl`),
  ADD KEY `nip` (`nip`),
  ADD KEY `statuskepegawaian` (`statuskepegawaian`),
  ADD KEY `pangkat_id` (`pangkat_id`),
  ADD KEY `eselon_id` (`eselon_id`),
  ADD KEY `fungsional_id` (`fungsional_id`),
  ADD KEY `jmlkotor` (`jmlkotor`),
  ADD KEY `jmlpotongan` (`jmlpotongan`),
  ADD KEY `jmlbayar` (`jmlbayar`);

--
-- Indexes for table `gaji_gapok`
--
ALTER TABLE `gaji_gapok`
  ADD KEY `dgaji_id` (`dgaji_tahun`),
  ADD KEY `pangkat_id` (`pangkat_id`),
  ADD KEY `mkg` (`mkg`);

--
-- Indexes for table `gaji_tabel`
--
ALTER TABLE `gaji_tabel`
  ADD PRIMARY KEY (`dgaji_id`),
  ADD UNIQUE KEY `dgaji_tahun` (`dgaji_tahun`);

--
-- Indexes for table `gis_kategori`
--
ALTER TABLE `gis_kategori`
  ADD UNIQUE KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `gis_lokasi`
--
ALTER TABLE `gis_lokasi`
  ADD PRIMARY KEY (`lokasi_id`);

--
-- Indexes for table `gis_titik`
--
ALTER TABLE `gis_titik`
  ADD PRIMARY KEY (`titik_id`);

--
-- Indexes for table `gis_user`
--
ALTER TABLE `gis_user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `harilibur`
--
ALTER TABLE `harilibur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hukdis_data`
--
ALTER TABLE `hukdis_data`
  ADD PRIMARY KEY (`hukdis_id`);

--
-- Indexes for table `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `snunik` (`sn`);

--
-- Indexes for table `jabatan_data`
--
ALTER TABLE `jabatan_data`
  ADD PRIMARY KEY (`jabatan_id`);

--
-- Indexes for table `jabatan_data1`
--
ALTER TABLE `jabatan_data1`
  ADD PRIMARY KEY (`jabatan_id`);

--
-- Indexes for table `jabatan_kelas`
--
ALTER TABLE `jabatan_kelas`
  ADD PRIMARY KEY (`jabatan_kelas_id`);

--
-- Indexes for table `kegiatan_harian`
--
ALTER TABLE `kegiatan_harian`
  ADD PRIMARY KEY (`kh_id`);

--
-- Indexes for table `kinerja_bulanan`
--
ALTER TABLE `kinerja_bulanan`
  ADD PRIMARY KEY (`kb_id`);

--
-- Indexes for table `kinerja_bulanan_realisasi`
--
ALTER TABLE `kinerja_bulanan_realisasi`
  ADD PRIMARY KEY (`kbr_id`);

--
-- Indexes for table `kinerja_tahunan`
--
ALTER TABLE `kinerja_tahunan`
  ADD PRIMARY KEY (`kt_id`);

--
-- Indexes for table `kinerja_tahunan_realisasi`
--
ALTER TABLE `kinerja_tahunan_realisasi`
  ADD PRIMARY KEY (`ktr_id`);

--
-- Indexes for table `kodeabsen`
--
ALTER TABLE `kodeabsen`
  ADD UNIQUE KEY `simbol` (`simbol`);

--
-- Indexes for table `kode_cuti`
--
ALTER TABLE `kode_cuti`
  ADD UNIQUE KEY `cuti_id` (`cuti_id`);

--
-- Indexes for table `kode_diklat`
--
ALTER TABLE `kode_diklat`
  ADD UNIQUE KEY `diklat_id` (`diklat_kode_id`);

--
-- Indexes for table `kode_eselon`
--
ALTER TABLE `kode_eselon`
  ADD UNIQUE KEY `eselon_id` (`eselon_id`);

--
-- Indexes for table `kode_fungsional`
--
ALTER TABLE `kode_fungsional`
  ADD UNIQUE KEY `fungsional_id` (`fungsional_id`);

--
-- Indexes for table `kode_fungsional_rumpun`
--
ALTER TABLE `kode_fungsional_rumpun`
  ADD UNIQUE KEY `fungsional_rumpun_id` (`fungsional_rumpun_id`);

--
-- Indexes for table `kode_hukdis`
--
ALTER TABLE `kode_hukdis`
  ADD PRIMARY KEY (`hukdis_kd`);

--
-- Indexes for table `kode_jabatan`
--
ALTER TABLE `kode_jabatan`
  ADD UNIQUE KEY `eselon_id` (`jabatan_jenis_id`);

--
-- Indexes for table `kode_kabupaten`
--
ALTER TABLE `kode_kabupaten`
  ADD UNIQUE KEY `kabupaten_id` (`kabupaten_id`);

--
-- Indexes for table `kode_kecamatan`
--
ALTER TABLE `kode_kecamatan`
  ADD PRIMARY KEY (`kecamatan_id`);

--
-- Indexes for table `kode_pangkat`
--
ALTER TABLE `kode_pangkat`
  ADD UNIQUE KEY `pangkat_id` (`pangkat_id`);

--
-- Indexes for table `kode_pangkat_jenis`
--
ALTER TABLE `kode_pangkat_jenis`
  ADD UNIQUE KEY `pangkat_jenis_id` (`pangkat_jenis_id`);

--
-- Indexes for table `kode_pendidikan`
--
ALTER TABLE `kode_pendidikan`
  ADD UNIQUE KEY `pendidikantk_id` (`pendidikantk_id`),
  ADD UNIQUE KEY `pendidikantk_id_2` (`pendidikantk_id`);

--
-- Indexes for table `kode_pensiun`
--
ALTER TABLE `kode_pensiun`
  ADD UNIQUE KEY `pensiun_id` (`pensiun_id`);

--
-- Indexes for table `kode_propinsi`
--
ALTER TABLE `kode_propinsi`
  ADD UNIQUE KEY `propinsi_id` (`propinsi_id`);

--
-- Indexes for table `log_del`
--
ALTER TABLE `log_del`
  ADD PRIMARY KEY (`del_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `pegawai_atasan`
--
ALTER TABLE `pegawai_atasan`
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `pegawai_data`
--
ALTER TABLE `pegawai_data`
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `pegawai_data_lama`
--
ALTER TABLE `pegawai_data_lama`
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `pegawai_foto`
--
ALTER TABLE `pegawai_foto`
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `pegawai_kp4`
--
ALTER TABLE `pegawai_kp4`
  ADD UNIQUE KEY `nip_2` (`nip`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `pegawai_rekening`
--
ALTER TABLE `pegawai_rekening`
  ADD UNIQUE KEY `rekening_id` (`rekening_id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `rekening` (`rekening_no`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`nip`,`tgl`);

--
-- Indexes for table `qr_unit`
--
ALTER TABLE `qr_unit`
  ADD PRIMARY KEY (`qr_id`);

--
-- Indexes for table `rekap_absen`
--
ALTER TABLE `rekap_absen`
  ADD PRIMARY KEY (`ra_id`);

--
-- Indexes for table `rekap_absen1`
--
ALTER TABLE `rekap_absen1`
  ADD PRIMARY KEY (`ra_id`);

--
-- Indexes for table `rekap_kinerja`
--
ALTER TABLE `rekap_kinerja`
  ADD PRIMARY KEY (`rk_id`);

--
-- Indexes for table `riwayat_cuti`
--
ALTER TABLE `riwayat_cuti`
  ADD UNIQUE KEY `cuti_riw_id` (`cuti_riw_id`),
  ADD KEY `nip` (`nip`),
  ADD KEY `cuti_id` (`cuti_id`);

--
-- Indexes for table `riwayat_diklat`
--
ALTER TABLE `riwayat_diklat`
  ADD PRIMARY KEY (`diklat_id`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `riwayat_dp3`
--
ALTER TABLE `riwayat_dp3`
  ADD UNIQUE KEY `dp3_id` (`dp3_id`),
  ADD KEY `nip` (`nip`),
  ADD KEY `dp3_tahun` (`dp3_tgl`);

--
-- Indexes for table `riwayat_fungsional`
--
ALTER TABLE `riwayat_fungsional`
  ADD PRIMARY KEY (`fungsional_riw_id`),
  ADD KEY `fungsional_id` (`fungsional_id`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  ADD PRIMARY KEY (`jabatan_riw_id`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `riwayat_kgb`
--
ALTER TABLE `riwayat_kgb`
  ADD PRIMARY KEY (`kgb_id`),
  ADD KEY `nip` (`nip`),
  ADD KEY `kgb_tmt` (`kgb_tmt`);

--
-- Indexes for table `riwayat_organisasi`
--
ALTER TABLE `riwayat_organisasi`
  ADD PRIMARY KEY (`organisasi_id`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `riwayat_pangkat`
--
ALTER TABLE `riwayat_pangkat`
  ADD UNIQUE KEY `pangkat_riw_id` (`pangkat_riw_id`),
  ADD KEY `nip` (`nip`),
  ADD KEY `pangkat_id` (`pangkat_id`);

--
-- Indexes for table `riwayat_pendidikan`
--
ALTER TABLE `riwayat_pendidikan`
  ADD PRIMARY KEY (`pendidikan_id`),
  ADD KEY `nip` (`nip`),
  ADD KEY `pend_jurusan` (`pendidikan_jurusan`),
  ADD KEY `gelar` (`pendidikan_gelar`);

--
-- Indexes for table `riwayat_tjasa`
--
ALTER TABLE `riwayat_tjasa`
  ADD UNIQUE KEY `tjasa_id` (`tjasa_id`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `skp_data`
--
ALTER TABLE `skp_data`
  ADD PRIMARY KEY (`skp_penilaian_id`);

--
-- Indexes for table `skp_konversi_nilai`
--
ALTER TABLE `skp_konversi_nilai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tanggal_berlaku` (`tanggal_berlaku`,`nilai_akhir`);

--
-- Indexes for table `skp_periode`
--
ALTER TABLE `skp_periode`
  ADD PRIMARY KEY (`periode_id`);

--
-- Indexes for table `tb_foto_absen`
--
ALTER TABLE `tb_foto_absen`
  ADD PRIMARY KEY (`idf`);

--
-- Indexes for table `tb_mesin`
--
ALTER TABLE `tb_mesin`
  ADD PRIMARY KEY (`idm`);

--
-- Indexes for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`pin`);

--
-- Indexes for table `tb_qr`
--
ALTER TABLE `tb_qr`
  ADD PRIMARY KEY (`idq`);

--
-- Indexes for table `tb_scanlog_ars`
--
ALTER TABLE `tb_scanlog_ars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scan_date` (`scan_date`);

--
-- Indexes for table `tpp_data`
--
ALTER TABLE `tpp_data`
  ADD PRIMARY KEY (`tpp_id`),
  ADD UNIQUE KEY `CEGAHDOBEL` (`nip`,`tahun`,`bulan`,`jabatan`) USING BTREE;

--
-- Indexes for table `tpp_indeks`
--
ALTER TABLE `tpp_indeks`
  ADD PRIMARY KEY (`indeks_id`);

--
-- Indexes for table `tpp_indeks_jabatan`
--
ALTER TABLE `tpp_indeks_jabatan`
  ADD PRIMARY KEY (`indeks_jabatan_id`);

--
-- Indexes for table `tpp_indeks_kelas_jabatan`
--
ALTER TABLE `tpp_indeks_kelas_jabatan`
  ADD PRIMARY KEY (`indeks_kb`),
  ADD KEY `indeks_id` (`indeks_id`,`jabatan_kelas_id`);

--
-- Indexes for table `unit_data`
--
ALTER TABLE `unit_data`
  ADD UNIQUE KEY `unit_id` (`unit_id`);

--
-- Indexes for table `unit_kategori`
--
ALTER TABLE `unit_kategori`
  ADD PRIMARY KEY (`unit_kategori_id`);

--
-- Indexes for table `unit_sub`
--
ALTER TABLE `unit_sub`
  ADD UNIQUE KEY `unit_sub_id` (`unit_sub_id`);

--
-- Indexes for table `unit_terkini`
--
ALTER TABLE `unit_terkini`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `upacara`
--
ALTER TABLE `upacara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD UNIQUE KEY `user_id` (`user_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `idx` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absen_apel`
--
ALTER TABLE `absen_apel`
  MODIFY `apel_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absen_data`
--
ALTER TABLE `absen_data`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absen_excp`
--
ALTER TABLE `absen_excp`
  MODIFY `excp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absen_excp_backup`
--
ALTER TABLE `absen_excp_backup`
  MODIFY `excp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absen_mesinerror`
--
ALTER TABLE `absen_mesinerror`
  MODIFY `me_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absen_ramadhan`
--
ALTER TABLE `absen_ramadhan`
  MODIFY `ramadhan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `directory`
--
ALTER TABLE `directory`
  MODIFY `dir_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_files`
--
ALTER TABLE `document_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_history`
--
ALTER TABLE `document_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_review_history`
--
ALTER TABLE `document_review_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_submissions`
--
ALTER TABLE `document_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_types_`
--
ALTER TABLE `document_types_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ekin_konfigurasi_api`
--
ALTER TABLE `ekin_konfigurasi_api`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gaji_tabel`
--
ALTER TABLE `gaji_tabel`
  MODIFY `dgaji_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gis_lokasi`
--
ALTER TABLE `gis_lokasi`
  MODIFY `lokasi_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gis_titik`
--
ALTER TABLE `gis_titik`
  MODIFY `titik_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `harilibur`
--
ALTER TABLE `harilibur`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hukdis_data`
--
ALTER TABLE `hukdis_data`
  MODIFY `hukdis_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan_data`
--
ALTER TABLE `jabatan_data`
  MODIFY `jabatan_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan_data1`
--
ALTER TABLE `jabatan_data1`
  MODIFY `jabatan_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatan_harian`
--
ALTER TABLE `kegiatan_harian`
  MODIFY `kh_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kinerja_bulanan`
--
ALTER TABLE `kinerja_bulanan`
  MODIFY `kb_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kinerja_bulanan_realisasi`
--
ALTER TABLE `kinerja_bulanan_realisasi`
  MODIFY `kbr_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kinerja_tahunan`
--
ALTER TABLE `kinerja_tahunan`
  MODIFY `kt_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kinerja_tahunan_realisasi`
--
ALTER TABLE `kinerja_tahunan_realisasi`
  MODIFY `ktr_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_diklat`
--
ALTER TABLE `kode_diklat`
  MODIFY `diklat_kode_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_eselon`
--
ALTER TABLE `kode_eselon`
  MODIFY `eselon_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_fungsional`
--
ALTER TABLE `kode_fungsional`
  MODIFY `fungsional_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_fungsional_rumpun`
--
ALTER TABLE `kode_fungsional_rumpun`
  MODIFY `fungsional_rumpun_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_hukdis`
--
ALTER TABLE `kode_hukdis`
  MODIFY `hukdis_kd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_jabatan`
--
ALTER TABLE `kode_jabatan`
  MODIFY `jabatan_jenis_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_pangkat_jenis`
--
ALTER TABLE `kode_pangkat_jenis`
  MODIFY `pangkat_jenis_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_pensiun`
--
ALTER TABLE `kode_pensiun`
  MODIFY `pensiun_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_del`
--
ALTER TABLE `log_del`
  MODIFY `del_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qr_unit`
--
ALTER TABLE `qr_unit`
  MODIFY `qr_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekap_absen`
--
ALTER TABLE `rekap_absen`
  MODIFY `ra_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekap_absen1`
--
ALTER TABLE `rekap_absen1`
  MODIFY `ra_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekap_kinerja`
--
ALTER TABLE `rekap_kinerja`
  MODIFY `rk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_fungsional`
--
ALTER TABLE `riwayat_fungsional`
  MODIFY `fungsional_riw_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skp_konversi_nilai`
--
ALTER TABLE `skp_konversi_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_foto_absen`
--
ALTER TABLE `tb_foto_absen`
  MODIFY `idf` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_mesin`
--
ALTER TABLE `tb_mesin`
  MODIFY `idm` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_qr`
--
ALTER TABLE `tb_qr`
  MODIFY `idq` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_scanlog_ars`
--
ALTER TABLE `tb_scanlog_ars`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tpp_data`
--
ALTER TABLE `tpp_data`
  MODIFY `tpp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tpp_indeks`
--
ALTER TABLE `tpp_indeks`
  MODIFY `indeks_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tpp_indeks_jabatan`
--
ALTER TABLE `tpp_indeks_jabatan`
  MODIFY `indeks_jabatan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tpp_indeks_kelas_jabatan`
--
ALTER TABLE `tpp_indeks_kelas_jabatan`
  MODIFY `indeks_kb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upacara`
--
ALTER TABLE `upacara`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document_files`
--
ALTER TABLE `document_files`
  ADD CONSTRAINT `document_files_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `document_submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_files_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `document_types_` (`id`);

--
-- Constraints for table `document_history`
--
ALTER TABLE `document_history`
  ADD CONSTRAINT `document_history_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `document_submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `document_review_history`
--
ALTER TABLE `document_review_history`
  ADD CONSTRAINT `review_history_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `document_submissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
