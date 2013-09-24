-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.1.37 - Source distribution
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-06-12 07:24:44
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for dbalumnipolitel
CREATE DATABASE IF NOT EXISTS `dbalumnipolitel` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbalumnipolitel`;


-- Dumping structure for table dbalumnipolitel.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `level_id` int(10) DEFAULT NULL,
  `blokir` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `email` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `created_by` varchar(8) COLLATE latin1_general_ci DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_field` (`username`,`nama_lengkap`),
  KEY `FK_admin_level_admin` (`level_id`),
  CONSTRAINT `FK_admin_level_admin` FOREIGN KEY (`level_id`) REFERENCES `level_admin` (`id_level`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table dbalumnipolitel.admin: ~2 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`, `level_id`, `blokir`, `email`, `created_by`, `ts`) VALUES
	(1, 'divisi_tik', '2083d6c9c264edef1f08b527840d0086', 'Divisi TIK', 1, 'N', 'tik@ia-politel.org', '30107126', '2012-10-31 09:06:19'),
	(5, 'sekre_iap', '5db0db9acd0c663572e7ae7574257ae7', 'Sekretaris IAP', 2, 'N', 'tes@tes.com', 'divisi_t', '2012-10-31 13:27:29');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.data_alumni
CREATE TABLE IF NOT EXISTS `data_alumni` (
  `nim` varchar(8) NOT NULL,
  `prodi_id` int(10) NOT NULL,
  `divisi_id` int(10) NOT NULL,
  `angkatan` varchar(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` tinytext NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `id_kota` int(10) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `no_telp1` varchar(15) NOT NULL,
  `no_telp2` varchar(15) NOT NULL,
  `email_1` varchar(50) NOT NULL,
  `email_2` varchar(50) NOT NULL,
  `foto` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `yahoo_messanger` varchar(50) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `twitter` varchar(50) NOT NULL,
  `bool_lanjut_kuliah` int(11) NOT NULL,
  `nama_institusi` varchar(50) NOT NULL,
  `bool_kerja` int(11) NOT NULL,
  `nama_perusahaan` varchar(50) NOT NULL,
  `alamat_perusahaan` tinytext NOT NULL,
  `posisi` varchar(50) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `modified_by` varchar(20) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`nim`),
  KEY `FK_data_alumni_provinsi` (`id_provinsi`),
  KEY `FK_data_alumni_kabupaten_kota` (`id_kota`),
  KEY `FK_data_alumni_divisi` (`divisi_id`),
  KEY `FK_data_alumni_program_studi` (`prodi_id`),
  CONSTRAINT `FK_data_alumni_divisi` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_data_alumni_program_studi` FOREIGN KEY (`prodi_id`) REFERENCES `program_studi` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.data_alumni: ~20 rows (approximately)
/*!40000 ALTER TABLE `data_alumni` DISABLE KEYS */;
INSERT INTO `data_alumni` (`nim`, `prodi_id`, `divisi_id`, `angkatan`, `nama`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_provinsi`, `id_kota`, `kode_pos`, `no_telp1`, `no_telp2`, `email_1`, `email_2`, `foto`, `username`, `password`, `yahoo_messanger`, `facebook`, `twitter`, `bool_lanjut_kuliah`, `nama_institusi`, `bool_kerja`, `nama_perusahaan`, `alamat_perusahaan`, `posisi`, `created_by`, `modified_by`, `ts`) VALUES
	('30107014', 1, 9, '2007', 'Afif Mudrik', '', '0000-00-00', '', 0, 0, '', '085719662297', '', 'afif.mudrik@gmail.com', 'afm_betterthanflying@yahoo.com', '', '30107014', '30107014', 'afm_betterthanflying', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 13:03:21'),
	('30107016', 1, 5, '2007', 'Arya Bisma', '', '0000-00-00', '', 0, 0, '', '+60163825227', '', 'arya.bisma@gmail.com', 'valkyrie_mrya@yahoo.com', '', '30107016', '30107016', 'valkyrie_mrya', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:33:47'),
	('30107028', 1, 4, '2007', 'Ahmad Syarifudin Anshori', '', '0000-00-00', '', 0, 0, '', '085691441843\r\n', '', 'arif@Politekniktelkom.ac.id\r\n', 'a.s.anshori@windowslive.com\r\n', '', '30107028\r\n', '30107028\r\n', 'ief_arief\r\n', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:20:32'),
	('30107043', 1, 8, '2007', 'Donny Merdhika', '', '0000-00-00', '', 0, 0, '', '085252289123', '', 'idontpunk@gmail.com', 'donnyvarium@gmail.com', '', '30107043', '30107043', 'don3660_drummer', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 13:00:00'),
	('30107095', 1, 2, '2007', 'Priska Bina Puspita', '', '0000-00-00', '', 0, 0, '', '081220456699', '', 'priska.bp@gmail.com', 'priska_bp@yahoo.com', '', '30107095', '30107095', 'priska_bp', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-29 23:17:29'),
	('30107118', 1, 6, '2007', 'Gisthi Gandari', '', '0000-00-00', '', 0, 0, '', '085624114545', '', 'gisthi.gandari@gmail.com', 'mimo_347@yahoo.com', '', '30107118', '30107118', 'mimo_347', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:49:43'),
	('30107126', 1, 5, '2007', 'Yagi Anggar Prahara', 'Bandung', '1989-03-23', '', 0, 0, '', '085693079553', '', 'yagi.anggar@gmail.com', 'yagi_anggar23@yahoo.com', '', '30107126', '30107126', 'yagi_anggar23', '', 'yagi_anggar', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:27:53'),
	('30107140', 1, 6, '2007', 'Praditya Andryani', '', '0000-00-00', '', 0, 0, '', '081905057031', '', 'praditya.andryani@gmail.com', '', '', '30107140', '30107140', 'praditya.andryani', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:48:04'),
	('30107148', 1, 6, '2007', 'Nita Suryani', '', '0000-00-00', '', 0, 0, '', '082124360357', '', 'thanutha@gmail.com', '', '', '30107148', '30107148', 'neta_curlyy', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:39:37'),
	('30107152', 1, 1, '2007', 'Barsyah Dwi Idestio', '', '0000-00-00', '', 0, 0, '', '085693602060', '02276192061', 'barsyah.dwi@gmail.com', 'bscrew_syah@yahoo.com', '', '30107152', '30107152', 'bscrew_syah', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-29 23:15:17'),
	('30107175', 1, 8, '2007', 'Irvandias Anggriawan', '', '0000-00-00', '', 0, 0, '', '085659983191', '081315906379', 'dias.irvan@gmail.com', 'irvand_a@yahoo.co.id', '', '30107175', '30107175', 'irvand_a', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 13:00:10'),
	('30107188', 1, 5, '2007', 'Rendy Trizaurrochim', '', '0000-00-00', '', 0, 0, '', '085720104710', '', 'rendymokletz@gmail.com', 'rendy_mokletz@yahoo.com', '', '30107188', '30107188', 'rendy.trizaurochim', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:35:15'),
	('30107205', 1, 5, '2007', 'Yuliano', '', '0000-00-00', '', 0, 0, '', '081220330340', '', 'ino_itkonsultan@yahoo.co.id', '', '', '30107205', '30107205', 'it_konsultant', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:30:59'),
	('30107217', 1, 3, '2007', 'Puspita Mustika', 'Bandung', '2012-10-06', '', 0, 0, '', '085624657277', '', 'pipiet0612@gmail.com', 'pipiet06@yahoo.com', '', '30107217', '30107217', 'pipiet06', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-29 23:46:22'),
	('30108117', 1, 2, '2008', 'Bella Citra Larastia', 'Ciamis', '0000-00-00', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', 0, '', 0, '', '', '', '', '', '2013-06-12 02:23:52'),
	('30207001', 2, 8, '2007', 'Hadrian Febriyansah', '', '0000-00-00', '', 0, 0, '', '085722158580', '', 'hadrian.febri@gmail.com', 'harian_cne@yahoo.com', '', '30207001', '30207001', 'febry_funk', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 13:00:06'),
	('30207022', 2, 8, '2007', 'Ika Sagita Damayanti', '', '0000-00-00', '', 0, 0, '', '081910200552', '081392072552', 'yukihime90@gmail.com', 'yukihime_90@yahoo.com', '', '30207022', '30207022', 'yukihime_90', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 13:01:09'),
	('30207044', 2, 4, '2007', 'Gunawan', '', '0000-00-00', '', 0, 0, '', '085311650494', '', 'satriadigital@gmail.com', '', '', '30207044', '30207044', 'ghoen_naone', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:22:58'),
	('30207052', 2, 4, '2007', 'Irfan Irawan', '', '0000-00-00', '', 0, 0, '', '085224655699', '02171125634', 'irfan_rwn@yahoo.com', '', '', '30207052', '30207052', 'irfan_rwn', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:24:44'),
	('30208337', 2, 2, '2008', 'Ajeng Anggraeni', '', '0000-00-00', '', 0, 0, '', '08816169093', '', 'anggraeni.ajeng@gmail.com', '', '', '30208337', '30208337', 'jengaah_chubby', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-29 23:44:04'),
	('30307005', 3, 10, '2007', 'Lutfhi Zulfikri', 'Jakarta', '0000-00-00', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', 0, '', 0, '', '', '', '30107126', '', '2013-06-12 02:21:52'),
	('30307023', 3, 7, '2007', 'Novi Sri Lestari', '', '0000-00-00', '', 0, 0, '', '085646477654', '', 'nophcie@yahoo.co.id', '', '', '30307023', '30307023', 'nophcie', '', '', 0, '', 0, '', '', '', '30107126', '', '2012-10-30 12:51:30');
/*!40000 ALTER TABLE `data_alumni` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.divisi
CREATE TABLE IF NOT EXISTS `divisi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_divisi` varchar(20) DEFAULT NULL,
  `created_by` varchar(8) DEFAULT NULL,
  `modified_by` varchar(20) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_field` (`nama_divisi`),
  KEY `FK_divisi_data_alumni` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.divisi: ~10 rows (approximately)
/*!40000 ALTER TABLE `divisi` DISABLE KEYS */;
INSERT INTO `divisi` (`id`, `nama_divisi`, `created_by`, `modified_by`, `ts`) VALUES
	(1, 'Ketua IAP', '30107126', NULL, '2012-10-29 22:50:55'),
	(2, 'Sekretaris Umum', '30107126', NULL, '2012-10-29 22:51:09'),
	(3, 'Bendahara Umum', '30107126', NULL, '2012-10-29 22:51:33'),
	(4, 'Koordinator Wilayah', '30107126', NULL, '2012-10-29 22:51:45'),
	(5, 'Teknologi Informasi ', '30107126', NULL, '2012-10-29 22:52:01'),
	(6, 'SDMPBK', '30107126', NULL, '2012-10-29 22:52:16'),
	(7, 'Sponsorship', '30107126', NULL, '2012-10-29 22:52:34'),
	(8, 'Event Organizer', '30107126', NULL, '2012-10-29 22:52:50'),
	(9, 'Keorganisasian', '30107126', NULL, '2012-10-29 22:53:10'),
	(10, 'Anggota', '30107126', NULL, '2012-10-29 23:02:34');
/*!40000 ALTER TABLE `divisi` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.hasil_voting
CREATE TABLE IF NOT EXISTS `hasil_voting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nim_pemilih` varchar(8) NOT NULL,
  `kandidat` varchar(8) NOT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim_pemilih` (`nim_pemilih`),
  KEY `FK_hasil_voting_kandidat_ketua` (`kandidat`),
  CONSTRAINT `FK_hasil_voting_data_alumni` FOREIGN KEY (`nim_pemilih`) REFERENCES `data_alumni` (`nim`) ON DELETE CASCADE,
  CONSTRAINT `FK_hasil_voting_kandidat_ketua` FOREIGN KEY (`kandidat`) REFERENCES `kandidat_ketua` (`nim`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.hasil_voting: ~6 rows (approximately)
/*!40000 ALTER TABLE `hasil_voting` DISABLE KEYS */;
/*!40000 ALTER TABLE `hasil_voting` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.jawaban_komentar
CREATE TABLE IF NOT EXISTS `jawaban_komentar` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pertanyaan_id` int(10) DEFAULT NULL,
  `nim` varchar(8) DEFAULT NULL,
  `komentar` text,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK__pertanyaan_kuesioner` (`pertanyaan_id`),
  KEY `FK_jawaban_komentar_data_alumni` (`nim`),
  CONSTRAINT `FK_jawaban_komentar_data_alumni` FOREIGN KEY (`nim`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE,
  CONSTRAINT `FK__pertanyaan_kuesioner` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan_kuesioner` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.jawaban_komentar: ~3 rows (approximately)
/*!40000 ALTER TABLE `jawaban_komentar` DISABLE KEYS */;
INSERT INTO `jawaban_komentar` (`id`, `pertanyaan_id`, `nim`, `komentar`, `ts`) VALUES
	(1, 35, '30107126', 'ffff', '2012-11-04 15:54:20'),
	(2, 31, '30107126', 'tttt', '2012-11-04 15:54:20'),
	(3, 32, '30107126', 'rrr', '2012-11-04 15:54:20');
/*!40000 ALTER TABLE `jawaban_komentar` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.jawaban_kuesioner
CREATE TABLE IF NOT EXISTS `jawaban_kuesioner` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pertanyaan_id` int(11) NOT NULL,
  `nim` varchar(8) NOT NULL,
  `jawaban` text NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_jawaban_kuesioner_pertanyaan_kuesioner` (`pertanyaan_id`),
  KEY `FK_jawaban_kuesioner_data_alumni` (`nim`),
  CONSTRAINT `FK_jawaban_kuesioner_data_alumni` FOREIGN KEY (`nim`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE,
  CONSTRAINT `FK_jawaban_kuesioner_pertanyaan_kuesioner` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan_kuesioner` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.jawaban_kuesioner: ~25 rows (approximately)
/*!40000 ALTER TABLE `jawaban_kuesioner` DISABLE KEYS */;
INSERT INTO `jawaban_kuesioner` (`id`, `pertanyaan_id`, `nim`, `jawaban`, `ts`) VALUES
	(1, 11, '30107126', 'sts', '2012-11-04 15:54:20'),
	(2, 12, '30107126', 'ts', '2012-11-04 15:54:20'),
	(3, 13, '30107126', 'cs', '2012-11-04 15:54:20'),
	(4, 14, '30107126', 's', '2012-11-04 15:54:20'),
	(5, 15, '30107126', 'ss', '2012-11-04 15:54:20'),
	(6, 16, '30107126', 'ss', '2012-11-04 15:54:20'),
	(7, 17, '30107126', 'ts', '2012-11-04 15:54:20'),
	(8, 18, '30107126', 'cs', '2012-11-04 15:54:20'),
	(9, 19, '30107126', 'tetes', '2012-11-04 15:54:20'),
	(10, 20, '30107126', 'ts', '2012-11-04 15:54:20'),
	(11, 21, '30107126', 'terer', '2012-11-04 15:54:20'),
	(12, 33, '30107126', 'tttt', '2012-11-04 15:54:20'),
	(13, 34, '30107126', 'sts', '2012-11-04 15:54:20'),
	(14, 35, '30107126', 'cs', '2012-11-04 15:54:20'),
	(15, 22, '30107126', 'cs', '2012-11-04 15:54:20'),
	(16, 23, '30107126', 'cs', '2012-11-04 15:54:20'),
	(17, 24, '30107126', 's', '2012-11-04 15:54:20'),
	(18, 25, '30107126', 'ss', '2012-11-04 15:54:20'),
	(19, 26, '30107126', 'ts', '2012-11-04 15:54:20'),
	(20, 27, '30107126', 'cs', '2012-11-04 15:54:20'),
	(21, 28, '30107126', 'cs', '2012-11-04 15:54:20'),
	(22, 29, '30107126', 's', '2012-11-04 15:54:20'),
	(23, 30, '30107126', 'ts', '2012-11-04 15:54:20'),
	(24, 31, '30107126', 'cs', '2012-11-04 15:54:20'),
	(25, 32, '30107126', 'ts', '2012-11-04 15:54:20');
/*!40000 ALTER TABLE `jawaban_kuesioner` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.jenis_menu
CREATE TABLE IF NOT EXISTS `jenis_menu` (
  `id` varchar(2) NOT NULL,
  `jenis` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.jenis_menu: ~3 rows (approximately)
/*!40000 ALTER TABLE `jenis_menu` DISABLE KEYS */;
INSERT INTO `jenis_menu` (`id`, `jenis`) VALUES
	('NP', 'News Page'),
	('PP', 'Picture Page'),
	('SP', 'Static Page');
/*!40000 ALTER TABLE `jenis_menu` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.kandidat_ketua
CREATE TABLE IF NOT EXISTS `kandidat_ketua` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nim` varchar(8) DEFAULT '0',
  `visi` varchar(150) DEFAULT NULL,
  `misi` varchar(150) DEFAULT NULL,
  `foto_kandidat_ketua` varchar(20) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim` (`nim`),
  CONSTRAINT `FK__data_alumni` FOREIGN KEY (`nim`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.kandidat_ketua: ~4 rows (approximately)
/*!40000 ALTER TABLE `kandidat_ketua` DISABLE KEYS */;
INSERT INTO `kandidat_ketua` (`id`, `nim`, `visi`, `misi`, `foto_kandidat_ketua`, `ts`) VALUES
	(13, '30107095', 'fsdfsd', 'dsfsdf', 'priska.jpg', '2013-06-12 02:19:14'),
	(14, '30107152', 'sdfdf', 'sdfdf', 'barsyah.jpg', '2013-06-12 02:19:43'),
	(15, '30307005', 'dfsdf', 'sdfd', 'luthfi.jpg', '2013-06-12 02:22:29'),
	(16, '30108117', 'sdfd', 'dfd', 'bella_citra.jpg', '2013-06-12 02:24:49');
/*!40000 ALTER TABLE `kandidat_ketua` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.kategori_berita
CREATE TABLE IF NOT EXISTS `kategori_berita` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(20) DEFAULT NULL,
  `created_by` varchar(20) NOT NULL,
  `modified_by` varchar(20) NOT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.kategori_berita: ~2 rows (approximately)
/*!40000 ALTER TABLE `kategori_berita` DISABLE KEYS */;
INSERT INTO `kategori_berita` (`id`, `nama_kategori`, `created_by`, `modified_by`, `ts`) VALUES
	(1, 'Umum', '', '', '2012-09-21 01:28:02'),
	(2, 'Event', '', '', '2012-09-21 01:28:51');
/*!40000 ALTER TABLE `kategori_berita` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.kategori_kuesioner
CREATE TABLE IF NOT EXISTS `kategori_kuesioner` (
  `id` char(3) NOT NULL,
  `kategori` varchar(20) DEFAULT NULL,
  `active` char(1) DEFAULT NULL,
  `created_by` varchar(8) DEFAULT NULL,
  `modified_by` varchar(8) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_kategori_kuesioner_data_alumni` (`created_by`),
  KEY `FK_kategori_kuesioner_data_alumni_2` (`modified_by`),
  CONSTRAINT `FK_kategori_kuesioner_data_alumni` FOREIGN KEY (`created_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE,
  CONSTRAINT `FK_kategori_kuesioner_data_alumni_2` FOREIGN KEY (`modified_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.kategori_kuesioner: ~2 rows (approximately)
/*!40000 ALTER TABLE `kategori_kuesioner` DISABLE KEYS */;
INSERT INTO `kategori_kuesioner` (`id`, `kategori`, `active`, `created_by`, `modified_by`, `ts`) VALUES
	('EXT', 'External', 'N', '30107126', NULL, '2012-10-31 09:10:15'),
	('INT', 'Internal', 'Y', '30107126', NULL, '2012-10-31 09:10:18');
/*!40000 ALTER TABLE `kategori_kuesioner` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.kategori_organisasi
CREATE TABLE IF NOT EXISTS `kategori_organisasi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) DEFAULT NULL,
  `created_by` varchar(8) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_field` (`kategori`) USING BTREE,
  KEY `FK_kategori_organisasi_data_alumni` (`created_by`),
  CONSTRAINT `FK_kategori_organisasi_data_alumni` FOREIGN KEY (`created_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.kategori_organisasi: ~3 rows (approximately)
/*!40000 ALTER TABLE `kategori_organisasi` DISABLE KEYS */;
INSERT INTO `kategori_organisasi` (`id`, `kategori`, `created_by`, `ts`) VALUES
	(7, 'Visi dan Misi', '30107126', '2012-10-31 09:26:53'),
	(8, 'Program Kerja', '30107126', '2012-10-31 09:26:56'),
	(10, 'Struktur Organisasi', '30107126', '2012-10-31 09:26:59');
/*!40000 ALTER TABLE `kategori_organisasi` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.level_admin
CREATE TABLE IF NOT EXISTS `level_admin` (
  `id_level` int(10) NOT NULL AUTO_INCREMENT,
  `level` varchar(20) NOT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.level_admin: ~2 rows (approximately)
/*!40000 ALTER TABLE `level_admin` DISABLE KEYS */;
INSERT INTO `level_admin` (`id_level`, `level`) VALUES
	(1, 'Super Administrator'),
	(2, 'Administrator');
/*!40000 ALTER TABLE `level_admin` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` varchar(10) DEFAULT NULL,
  `jenis_id` varchar(2) NOT NULL,
  `nama_menu` varchar(50) DEFAULT NULL,
  `isi` text,
  `gambar` varchar(50) DEFAULT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `link` varchar(100) NOT NULL,
  `tipe` varchar(10) DEFAULT NULL,
  `created_by` varchar(8) DEFAULT NULL,
  `modified_by` varchar(8) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_field` (`nama_menu`) USING BTREE,
  KEY `FK_menu_jenis_menu` (`jenis_id`),
  KEY `FK_menu_data_alumni` (`created_by`),
  KEY `FK_menu_data_alumni_2` (`modified_by`),
  CONSTRAINT `FK_menu_data_alumni` FOREIGN KEY (`created_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE,
  CONSTRAINT `FK_menu_data_alumni_2` FOREIGN KEY (`modified_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE,
  CONSTRAINT `FK_menu_jenis_menu` FOREIGN KEY (`jenis_id`) REFERENCES `jenis_menu` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.menu: ~6 rows (approximately)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `parent_id`, `jenis_id`, `nama_menu`, `isi`, `gambar`, `desc`, `urutan`, `link`, `tipe`, `created_by`, `modified_by`, `ts`) VALUES
	(1, '-', 'SP', 'Organisasi', NULL, NULL, 'It\'s all about organisasi', 1, '#', 'parent', '30107126', NULL, '2012-10-31 09:28:10'),
	(2, '1', 'SP', 'Visi dan Misi', '<p>tes visi dan misi yah :D weeeasdasd</p>', NULL, 'It\'s all about visi', 1, '#', 'child', '30107126', '30107126', '2012-10-31 09:28:15'),
	(3, '1', 'SP', 'Program Kerja', '<p><strong><span style="font-size: medium;">Testestes Ajahaaaaa</span></strong></p>\r\n<ul>\r\n<li>sfsdf</li>\r\n<li>sdf</li>\r\n<li>sdf</li>\r\n<li>sdf</li>\r\n<li>sdf</li>\r\n</ul>\r\n<p><img title="tes" src="../../../../portal_assets/admin/tinymcpuk/gambar/image/struktur_iap.JPG" alt="tes" width="500" height="325" /></p>', NULL, 'program kerja', 2, '#', 'child', '30107126', '30107126', '2012-10-31 09:28:15'),
	(4, '1', 'SP', 'Struktur Organisasi', '<p>TEsss</p>', NULL, 'struktur organisasi', 3, '#', 'child', '30107126', '30107126', '2012-10-31 09:28:16'),
	(5, '-', 'NP', 'Berita', NULL, NULL, 'berita', 2, '#', 'parent', '30107126', NULL, '2012-10-31 09:28:14'),
	(6, '5', 'NP', 'IA Politel', NULL, NULL, 'IA Politel News', 1, '#', 'child', '30107126', NULL, '2012-10-31 09:28:14');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.pertanyaan_kuesioner
CREATE TABLE IF NOT EXISTS `pertanyaan_kuesioner` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tipe_id` char(2) NOT NULL,
  `variable_id` int(10) NOT NULL,
  `pertanyaan` text,
  `created_by` varchar(8) DEFAULT NULL,
  `modified_by` varchar(8) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_pertanyaan_kuesioner_tipe_kuesioner` (`tipe_id`),
  KEY `FK_pertanyaan_kuesioner_variable_kuesioner` (`variable_id`),
  KEY `FK_pertanyaan_kuesioner_data_alumni` (`created_by`),
  KEY `FK_pertanyaan_kuesioner_data_alumni_2` (`modified_by`),
  CONSTRAINT `FK_pertanyaan_kuesioner_data_alumni` FOREIGN KEY (`created_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pertanyaan_kuesioner_data_alumni_2` FOREIGN KEY (`modified_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pertanyaan_kuesioner_tipe_kuesioner` FOREIGN KEY (`tipe_id`) REFERENCES `tipe_kuesioner` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pertanyaan_kuesioner_variable_kuesioner` FOREIGN KEY (`variable_id`) REFERENCES `variable_kuesioner` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.pertanyaan_kuesioner: ~25 rows (approximately)
/*!40000 ALTER TABLE `pertanyaan_kuesioner` DISABLE KEYS */;
INSERT INTO `pertanyaan_kuesioner` (`id`, `tipe_id`, `variable_id`, `pertanyaan`, `created_by`, `modified_by`, `ts`) VALUES
	(11, 'R', 1, 'Saya turut serta bergabung menjadi pengurus IAP karena keikhlasan hati dan loayality terhadap almameter saya serta tidak adanya paksaan dari pihak lain', '30107126', NULL, '2012-10-31 10:05:30'),
	(12, 'R', 1, 'Saya giat dalam berorganiasasi ini karena kepedulian Saya terhadap almamater', '30107126', NULL, '2012-10-31 10:06:30'),
	(13, 'R', 1, 'Saya bangga menjadi pengurus IAP dan merasakan kesolid-an antara pengurus IAP satu sama lain', '30107126', NULL, '2012-10-31 10:11:16'),
	(14, 'R', 1, 'Saya hadir dalam setiap kesempatan rapat dan atau event IAP', '30107126', '30107126', '2012-10-31 10:11:50'),
	(15, 'R', 1, 'Saya merasa senang dapat membantu permasalahan pada divisi lain, karena kesadaran diri sendiri bahwa organisasi memang sedang dalam tahap berkembang', '30107126', '30107126', '2012-10-31 10:12:03'),
	(16, 'R', 1, 'Orang-orang yang berorganisasi dengan Saya memberi dukungan yang cukup kepada Saya', '30107126', '30107126', '2012-10-31 10:13:25'),
	(17, 'R', 2, 'Program-program yang telah di laksanakan oleh IAP telah sesuai dengan tujuan IAP', '30107126', NULL, '2012-10-31 10:13:46'),
	(18, 'R', 2, 'Saya telah memberikan kontribusi dalam mengembangkan IAP ke arah yang lebih baik', '30107126', NULL, '2012-10-31 10:14:14'),
	(19, 'K', 2, 'Harapan untuk IAPsss', '30107126', '30107126', '2012-10-31 10:14:30'),
	(20, 'R', 3, 'Keanggotaan yang berasal dari berbagai macam jurusan dan angkatan dapat membangun IAP menjadi lebih solid dan mencapai cita-cita IAP', '30107126', NULL, '2012-10-31 10:17:54'),
	(21, 'K', 3, 'Program yang ingin saya lakukan selama masa kepengurusan saya di IAP', '30107126', NULL, '2012-10-31 10:18:23'),
	(22, 'R', 4, 'Selama bergabung dalam kepungurusan IAP, kegiatan-kegiatan didalam kepengurusan tidak mengganggu waktu kuliah dan bekerja saya', '30107126', NULL, '2012-10-31 10:19:25'),
	(23, 'R', 4, 'Perbedaan tempat setiap anggota pengurus, tidak menjadi hambatan untuk bisa melakukan pertemuan secara tatap muka', '30107126', NULL, '2012-10-31 10:19:36'),
	(24, 'R', 4, 'Saya merasa nyaman dan betah menjadi pengurus IAP', '30107126', NULL, '2012-10-31 10:19:48'),
	(25, 'R', 4, 'Saya mempunyai beban tanggungjawab yang berlebihan', '30107126', NULL, '2012-10-31 10:21:36'),
	(26, 'R', 4, 'Jumlah anggota untuk melaksanakan keperluan organisasi kurang', '30107126', NULL, '2012-10-31 10:21:55'),
	(27, 'R', 4, 'Saya sering kali harus bertanggung jawab terhadap yang bukan ruang lingkup Saya', '30107126', NULL, '2012-10-31 10:22:14'),
	(28, 'R', 5, 'Dalam hal koordinasi, komunikasi, diskusi dan menyampaikan aspirasi antar anggota (termasuk PJ) per divisi masing-masing dapat dilakukan dengan baik sehingga sangat membantu aktifitas keorganiasasian', '30107126', NULL, '2012-10-31 10:22:37'),
	(29, 'R', 5, 'Dalam hal koordinasi, komunikasi, diskusi dan menyampaikan aspirasi dengan antar anggota beda divisi maupun pengurus inti dapat dilakukan dengan baik  sehingga sangat membantu aktifitas keorganiasasian', '30107126', NULL, '2012-10-31 10:22:48'),
	(30, 'R', 5, 'IAP telah menjadi organisasi yang menyediakan wadah bagi para alumni dan memenuhi segala kebutuhan alumni', '30107126', NULL, '2012-10-31 10:23:00'),
	(31, 'RK', 5, 'Dalam berkomunikasi dengan seluruh anggota pengurus, saya tidak merasakan adanya kendala', '30107126', NULL, '2012-10-31 10:23:13'),
	(32, 'RK', 5, 'Cara Berkomunikasi dan metode komunikasi antara pengurus IAP sudah baik', '30107126', NULL, '2012-10-31 10:23:23'),
	(33, 'K', 3, 'test komentar1', '30107126', '30107126', '2012-10-31 14:41:01'),
	(34, 'R', 3, 'test rating 1', '30107126', '30107126', '2012-10-31 14:41:20'),
	(35, 'RK', 3, 'test rating komentar 1', '30107126', NULL, '2012-10-31 14:41:31');
/*!40000 ALTER TABLE `pertanyaan_kuesioner` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.program_studi
CREATE TABLE IF NOT EXISTS `program_studi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(30) NOT NULL,
  `created_by` varchar(8) DEFAULT NULL,
  `modified_by` varchar(8) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_field` (`nama_prodi`),
  KEY `FK_program_studi_data_alumni` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.program_studi: ~3 rows (approximately)
/*!40000 ALTER TABLE `program_studi` DISABLE KEYS */;
INSERT INTO `program_studi` (`id`, `nama_prodi`, `created_by`, `modified_by`, `ts`) VALUES
	(1, 'Manajemen Informatika', '30107126', '', '2012-10-29 23:06:49'),
	(2, 'Teknik Komputer', '30107126', '', '2012-10-29 23:07:08'),
	(3, 'Komputerisasi Akuntansi', '30107126', '', '2012-10-29 23:07:24');
/*!40000 ALTER TABLE `program_studi` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.tipe_kuesioner
CREATE TABLE IF NOT EXISTS `tipe_kuesioner` (
  `id` char(2) NOT NULL,
  `tipe` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.tipe_kuesioner: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipe_kuesioner` DISABLE KEYS */;
INSERT INTO `tipe_kuesioner` (`id`, `tipe`) VALUES
	('K', 'Komentar'),
	('R', 'Rating'),
	('RK', 'Rating & Komentar');
/*!40000 ALTER TABLE `tipe_kuesioner` ENABLE KEYS */;


-- Dumping structure for table dbalumnipolitel.variable_kuesioner
CREATE TABLE IF NOT EXISTS `variable_kuesioner` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `variable` varchar(20) DEFAULT NULL,
  `created_by` varchar(8) DEFAULT NULL,
  `modified_by` varchar(8) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_variable_kuesioner_data_alumni` (`created_by`),
  KEY `FK_variable_kuesioner_data_alumni_2` (`modified_by`),
  CONSTRAINT `FK_variable_kuesioner_data_alumni` FOREIGN KEY (`created_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE,
  CONSTRAINT `FK_variable_kuesioner_data_alumni_2` FOREIGN KEY (`modified_by`) REFERENCES `data_alumni` (`nim`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table dbalumnipolitel.variable_kuesioner: ~5 rows (approximately)
/*!40000 ALTER TABLE `variable_kuesioner` DISABLE KEYS */;
INSERT INTO `variable_kuesioner` (`id`, `variable`, `created_by`, `modified_by`, `ts`) VALUES
	(1, 'Motivasi', '30107126', NULL, '2012-10-31 09:34:40'),
	(2, 'Harapan', '30107126', NULL, '2012-10-31 09:34:41'),
	(3, 'Keinginan', '30107126', NULL, '2012-10-31 09:34:44'),
	(4, 'Kendala', '30107126', NULL, '2012-10-31 09:34:44'),
	(5, 'Komunikasi', '30107126', NULL, '2012-10-31 09:34:45');
/*!40000 ALTER TABLE `variable_kuesioner` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
