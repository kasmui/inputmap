-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 07 Okt 2023 pada 05.38
-- Versi server: 10.2.44-MariaDB-cll-lve
-- Versi PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabg8378_mtpdm23`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `datamasjid`
--

CREATE TABLE `datamasjid` (
  `id` int(11) NOT NULL,
  `noidmasjid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `takmir` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hptakmir` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pcm` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prm` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdm` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pwm` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkmap` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qibla` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bj` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tZone` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasfoto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_dokumen` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `datamasjid`
--

INSERT INTO `datamasjid` (`id`, `noidmasjid`, `nama`, `takmir`, `hptakmir`, `alamat`, `pcm`, `prm`, `pdm`, `pwm`, `linkmap`, `qibla`, `lin`, `bj`, `h`, `tZone`, `pasfoto`, `file_dokumen`, `keterangan`) VALUES
(1, '', 'Masjid At-Taqwa Wonodri', '', '', 'Jl. Wonodri Baru Raya', 'Semarang Selatan', '', 'Kota Semarang', 'Jawa Tengah', 'https://www.google.com/maps/@-7.00154,110.42795,300m/data=!3m1!1e3', '294.50', '-7.00154', '110.42795', '12', '7', 'taqwawonodri.png', '', ''),
(2, '01.4.14.33.12.000148', 'Masjid At-Taqwa Patemon', 'Prof. Dr. Masrukhi, M.Pd', '089659123505', 'Jl. Raya Patemon RT 05 RW 03 Gunungpati, Kota Semarang, Jawa Tengah', 'Gunungpati 2', 'Patemon', 'Kota Semarang', 'Jawa Tengah', 'https://www.google.com/maps/@-7.06562,110.39579,300m/data=!3m1!1e3', '294.53', '-7.06562', '110.39579', '226', '7', 'kartu id masjid.jpg', 'SK Takmir At-Taqwa.pdf', 'Sekretariat PCM Gunungpati 2'),
(3, '', 'Masjid Riyadush Shalihin', 'Ustadz Nur Hamid', '085641793215', 'Sabrangan', 'Gunungpati 1', 'Sabrangan', 'Kota Semarang', 'Jawa Tengah', 'https://www.google.com/maps/@-7.08706,110.37120,500m/data=!3m1!1e3', '294.54', '-7.08706', '110.37120', '270', '7', 'masjid-RS.png', '', 'Sekretariat PCM Gunungpati 1'),
(4, '', 'Masjid At-Taqwa Bandarharjo ', '', '', 'Jl. Cumu-cumi Raya Bandarharjo Semarang Utara', 'Semarang Utara', 'Bandarharjo ', 'Kota Semarang', 'Jawa Tengah', 'https://www.google.com/maps/@-6.95902,110.41917,300m/data=!3m1!1e3', '294.49', '-6.95902', '110.41917', '3', '7', 'attawqa bandarharjo.png', '', ''),
(5, '', 'Masjid At-Taqwa Petompon', '', '', 'Jl. Kelud Raya No.47, Petompon, Kec. Gajahmungkur, Kota Semarang, Jawa Tengah 50237', 'Gajahmungkur', 'Petompon', 'Kota Semarang', 'Jawa Tengah', 'https://www.google.com/maps/@-7.00020,110.40213,300m/data=!3m1!1e3', '294.51', '-7.00020', '110.40213', '13', '7', 'attaqwapetompon.png', '', ''),
(6, '', 'Masjid Muhammadiyah Jatisari', '', '', 'Jl. Bulungan 1, Jatisari, Kec. Mijen, Kota Semarang, Jawa Tengah 50275', 'Mijen', 'Jatisari', 'Kota Semarang', 'Jawa Tengah', 'https://www.google.com/maps/@-7.06502,110.31071,300m/data=!3m1!1e3', '294.55', '-7.06502', '110.31071', '244', '7', 'masjidmu jatisari.png', '', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `datamasjid`
--
ALTER TABLE `datamasjid`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `datamasjid`
--
ALTER TABLE `datamasjid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
