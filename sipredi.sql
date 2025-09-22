-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 22 Sep 2025 pada 09.47
-- Versi server: 10.11.13-MariaDB-log
-- Versi PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipredi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `status` enum('hadir','izin','sakit','alpha') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `siswa_id`, `tanggal`, `jam`, `status`, `keterangan`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 13, '2025-09-18', '16:01:28', 'sakit', NULL, NULL, '2025-09-18 09:01:28', '2025-09-18 09:44:33'),
(2, 12, '2025-09-20', '19:24:32', 'hadir', NULL, NULL, '2025-09-20 12:24:32', '2025-09-20 12:24:32'),
(3, 7, '2025-09-20', '19:25:38', 'hadir', NULL, NULL, '2025-09-20 12:25:38', '2025-09-20 12:25:38'),
(4, 1, '2025-09-20', '19:25:51', 'hadir', NULL, NULL, '2025-09-20 12:25:51', '2025-09-20 12:25:51'),
(5, 4, '2025-09-20', '19:25:57', 'hadir', NULL, NULL, '2025-09-20 12:25:57', '2025-09-20 12:25:57'),
(6, 10, '2025-09-20', '19:26:04', 'hadir', NULL, NULL, '2025-09-20 12:26:04', '2025-09-20 12:26:04'),
(7, 5, '2025-09-20', '19:26:11', 'hadir', NULL, NULL, '2025-09-20 12:26:11', '2025-09-20 12:26:11'),
(8, 2, '2025-09-20', '19:26:15', 'alpha', NULL, NULL, '2025-09-20 12:26:15', '2025-09-20 12:26:15'),
(9, 13, '2025-09-20', '19:26:22', 'hadir', NULL, NULL, '2025-09-20 12:26:22', '2025-09-20 12:26:22'),
(10, 6, '2025-09-20', '19:26:27', 'hadir', NULL, NULL, '2025-09-20 12:26:27', '2025-09-20 12:26:27'),
(11, 3, '2025-09-20', '19:26:30', 'hadir', NULL, NULL, '2025-09-20 12:26:30', '2025-09-20 12:26:30'),
(12, 11, '2025-09-20', '19:26:35', 'hadir', NULL, NULL, '2025-09-20 12:26:35', '2025-09-20 12:26:35'),
(13, 9, '2025-09-20', '19:26:41', 'hadir', NULL, NULL, '2025-09-20 12:26:41', '2025-09-20 12:26:41'),
(14, 14, '2025-09-20', '19:26:47', 'hadir', NULL, NULL, '2025-09-20 12:26:47', '2025-09-20 12:26:47'),
(15, 8, '2025-09-20', '19:26:53', 'hadir', NULL, NULL, '2025-09-20 12:26:53', '2025-09-20 12:26:53'),
(16, 1, '2025-09-21', '19:58:21', 'hadir', NULL, NULL, '2025-09-21 12:58:21', '2025-09-21 12:58:21'),
(17, 2, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(18, 3, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(19, 4, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(20, 5, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(21, 6, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(22, 7, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(23, 8, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(24, 9, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(25, 10, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(26, 11, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(27, 12, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(28, 13, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00'),
(29, 14, '2025-09-21', '09:00:00', 'alpha', 'Otomatis Alpha karena tidak absen sampai jam 9', NULL, '2025-09-21 13:11:00', '2025-09-21 13:11:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `barang_id` int(11) NOT NULL,
  `kantin_id` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_barang` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `nama`, `nip`, `no_hp`, `email`, `alamat`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Guru', '123', '0876', 'guru@gmail.com', 'Patik', 'aktif', '2025-09-20 13:09:27', '2025-09-20 13:09:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kantin`
--

CREATE TABLE `kantin` (
  `kantin_id` int(11) NOT NULL,
  `nama_kantin` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'VII A', '2025-08-22 20:59:50', '2025-09-01 09:17:24'),
(2, 'VII B', '2025-08-22 20:59:50', '2025-08-22 20:59:50'),
(3, 'VIII A', '2025-08-22 20:59:50', '2025-08-22 20:59:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_08_11_000000_create_absensi_tables', 1),
(4, '2025_08_11_045217_create_sessions_table', 2),
(5, '2025_08_11_072822_create_absensis_table', 3),
(6, '2025_08_21_042922_create_personal_access_tokens_table', 3),
(7, '2025_08_23_000000_create_guru_table', 4),
(8, '2025_08_23_100000_create_rombel_siswa_table', 5),
(9, '2025_08_23_110000_drop_kelas_tahun_from_siswa_table', 5),
(10, '2025_08_23_111000_drop_tahun_from_kelas_table', 5),
(11, '2025_08_23_112000_drop_wali_kelas_from_kelas_table', 6),
(12, '2025_08_28_032103_create_reports_table', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_id` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `stateid` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reports`
--

INSERT INTO `reports` (`id`, `message_id`, `target`, `message`, `status`, `state`, `stateid`, `created_at`, `updated_at`) VALUES
(1, '121572963', '6287842949212', 'tes', 'pending', NULL, NULL, '2025-09-21 12:56:43', '2025-09-21 12:56:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rombel_siswa`
--

CREATE TABLE `rombel_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `nomor_absen` int(11) DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rombel_siswa`
--

INSERT INTO `rombel_siswa` (`id`, `siswa_id`, `nomor_absen`, `kelas_id`, `tahun_ajaran_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(2, 1, 2, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(3, 5, 3, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(4, 12, 4, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(5, 3, 5, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(6, 10, 6, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(7, 6, 7, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(8, 13, 8, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(9, 14, 9, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(10, 11, 10, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(11, 2, 11, 3, 3, '2025-09-18 09:13:47', '2025-09-18 09:22:13'),
(12, 9, 1, 2, 3, '2025-09-18 09:13:47', '2025-09-18 09:16:34'),
(13, 7, 2, 2, 3, '2025-09-18 09:13:47', '2025-09-18 09:16:34'),
(14, 8, 3, 2, 3, '2025-09-18 09:13:47', '2025-09-18 09:16:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `saldo`
--

CREATE TABLE `saldo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `saldo` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8NxSRN9CskzXk2HRkzaoetTFmvMe3brC6jQXTKWu', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMzdpbjhpQjRMbDhEdUlUMkF2MmpPdHlQZUl6ZEFmWjljeXExbnJxUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zaXN3YSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==', 1758464184),
('dsHNKiqTi1Edw9Pd3kwveXnz5xJApg5EKGtn8EP8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiazE5SXF6a1Nsb3RBM04zdzVjaExsSEQzTnNoajhuQVVMcVZFWWRGZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yZWthcC9wZGY/a2VsYXM9MyZwZXJpb2Q9MjAyNS0wOSI7fX0=', 1758445975),
('Kxwq0nJzXQT4gX1wOCAUysyIrUmRzmTG7vhrajlW', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOEY2V24xYXJoNmZtM1JMbWtSUm96ZEVGMnJuclBpRXFCWlhzbDhhTSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTt9', 1758449083);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nis` varchar(30) NOT NULL,
  `no_hp_ortu` varchar(20) NOT NULL,
  `rfid` varchar(32) NOT NULL,
  `status` enum('aktif','lulus','keluar') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `no_hp_ortu`, `rfid`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Andi Pratama', '10001', '6287842949212', '4a6bd4c8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(2, 'Raka Putra', '10002', '6287842949213', '1a8990c9', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(3, 'Dimas Arya', '10003', '6287842949214', 'cafc3cc8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(4, 'Aldi Saputra', '10004', '6287842949215', '5aa8f1c8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(5, 'Bayu Kurnia', '10005', '6287842949216', '8aea4dc8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(6, 'Fajar Hidayat', '10006', '6287842949217', 'fa96bec8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(7, 'Reza Maulana', '10007', '6287842949218', '5ab150c8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(8, 'Sinta Dewi', '10008', '6287842949219', 'ba974ec8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(9, 'Rani Amelia', '10009', '6287842949220', '3a211c8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(10, 'Dina Safira', '10010', '6287842949221', '9afa67c8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(11, 'Putri Ayu', '10011', '6287842949222', '2679f63', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(12, 'Citra Lestari', '10012', '6287842949223', '252f73', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(13, 'Lila Kartika', '10013', '6287842949224', '3a4314c8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07'),
(14, 'Nia Rahma', '10014', '6287842949225', 'aa3eb6c8', 'aktif', '2025-09-14 03:28:07', '2025-09-14 03:28:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(20) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `nama`, `aktif`, `created_at`, `updated_at`) VALUES
(3, '2025/2026', 0, '2025-08-22 21:42:36', '2025-09-20 13:07:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `topup`
--

CREATE TABLE `topup` (
  `topup_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `waktu` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `kantin_id` int(11) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_item`
--

CREATE TABLE `transaksi_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('superadmin','admin','guru') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(9, 'Super', 'superadmin@gmail.com', '$2y$12$G27HK1OzEuQwFzTlSKSBQuyI4hLMbiOA1SJmYX2Pw5TeZbWCt7if2', 'superadmin', NULL, '2025-09-20 13:08:27', '2025-09-20 13:08:27'),
(10, 'Admin', 'admin@gmail.com', '$2y$12$aZnHgkgrWKmtR1k8oPTyruM3/Km3PffDTKqU8uDfrwwG6Mtbssm42', 'admin', NULL, '2025-09-20 13:08:55', '2025-09-20 13:08:55'),
(11, 'Guru', 'guru@gmail.com', '$2y$12$eDE/jkXaB5XyU1zW9r5rfuq2xdy18jBHlJVrs6Ybmlz3Uto/.n6RK', 'guru', NULL, '2025-09-20 13:09:27', '2025-09-20 13:11:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensi_siswa_id_foreign` (`siswa_id`),
  ADD KEY `absensi_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`),
  ADD KEY `kantin_id` (`kantin_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kantin`
--
ALTER TABLE `kantin`
  ADD PRIMARY KEY (`kantin_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reports_message_id_unique` (`message_id`);

--
-- Indeks untuk tabel `rombel_siswa`
--
ALTER TABLE `rombel_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rombel_siswa_siswa_id_foreign` (`siswa_id`),
  ADD KEY `rombel_siswa_kelas_id_foreign` (`kelas_id`),
  ADD KEY `rombel_siswa_tahun_ajaran_id_foreign` (`tahun_ajaran_id`);

--
-- Indeks untuk tabel `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_nis_unique` (`nis`),
  ADD UNIQUE KEY `siswa_rfid_unique` (`rfid`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`topup_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kantin_id` (`kantin_id`);

--
-- Indeks untuk tabel `transaksi_item`
--
ALTER TABLE `transaksi_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kantin`
--
ALTER TABLE `kantin`
  MODIFY `kantin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rombel_siswa`
--
ALTER TABLE `rombel_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `topup`
--
ALTER TABLE `topup`
  MODIFY `topup_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi_item`
--
ALTER TABLE `transaksi_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`kantin_id`) REFERENCES `kantin` (`kantin_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rombel_siswa`
--
ALTER TABLE `rombel_siswa`
  ADD CONSTRAINT `rombel_siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rombel_siswa_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rombel_siswa_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `saldo`
--
ALTER TABLE `saldo`
  ADD CONSTRAINT `saldo_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `topup`
--
ALTER TABLE `topup`
  ADD CONSTRAINT `topup_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`kantin_id`) REFERENCES `kantin` (`kantin_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_item`
--
ALTER TABLE `transaksi_item`
  ADD CONSTRAINT `transaksi_item_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_item_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
