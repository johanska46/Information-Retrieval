-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2018 at 02:44 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nbc`
--

-- --------------------------------------------------------

--
-- Table structure for table `datatraining`
--

CREATE TABLE `datatraining` (
  `no` int(11) NOT NULL,
  `id_doc` int(11) DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `loc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datatraining`
--

INSERT INTO `datatraining` (`no`, `id_doc`, `term`, `loc`) VALUES
(1, 0, 'bermain', 2),
(2, 1, 'bermain', 3),
(3, 0, 'bola', 3),
(4, 1, 'bola', 0),
(5, 0, 'budi', 0),
(6, 0, 'budi', 1),
(7, 1, 'mau', 2),
(8, 1, 'tidak', 1),
(9, 2, 'huujan', 0),
(10, 2, 'ini', 1),
(11, 2, 'membunuhku', 2);

-- --------------------------------------------------------

--
-- Table structure for table `data_uji`
--

CREATE TABLE `data_uji` (
  `no_docuji` int(11) NOT NULL,
  `id_uji` varchar(20) NOT NULL,
  `term_uji` varchar(1000) NOT NULL,
  `loc_uji` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_uji`
--

INSERT INTO `data_uji` (`no_docuji`, `id_uji`, `term_uji`, `loc_uji`) VALUES
(9, '0', 'bermain', '2'),
(10, '0', 'bola', '3'),
(11, '0', 'budi', '0'),
(12, '0', 'budi', '1');

-- --------------------------------------------------------

--
-- Table structure for table `doc_uji`
--

CREATE TABLE `doc_uji` (
  `no_doc_uji` int(11) NOT NULL,
  `judul` varchar(1000) NOT NULL,
  `dosen_pembimbing` varchar(500) DEFAULT NULL,
  `dosen_co_pembimbing` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doc_uji`
--

INSERT INTO `doc_uji` (`no_doc_uji`, `judul`, `dosen_pembimbing`, `dosen_co_pembimbing`) VALUES
(1, 'Budi Budi bermain bola', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dosen_pembimbing`
--

CREATE TABLE `dosen_pembimbing` (
  `id_dosenP` int(11) NOT NULL,
  `nama_dosen` varchar(70) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen_pembimbing`
--

INSERT INTO `dosen_pembimbing` (`id_dosenP`, `nama_dosen`, `status`) VALUES
(1, 'Dr. Eva Handriyantini, S.Kom.,M.MT', 1),
(2, 'Sugeng Widodo.,M.Kom', 1),
(3, 'Diah Arifah P, S.Kom.,M.T', 1),
(4, 'Anita, S.Kom, M.T.', 1),
(5, 'Koko Wahyu Prasetyo, S.Kom.,M.T.I', 1),
(6, 'Subari, M.Kom', 1),
(7, 'Evy Poerbaningtyas, S.Si.,M.T', 1),
(8, 'Jozua F. Palandi., M.Kom', 1),
(9, 'Laila Isyriyah.,M.Kom', 1),
(10, 'Dr. Eva Handriyantini, S.Kom.,M.MT', 1),
(11, 'Evy Poerbaningtyas, S.Si.,M.T', 1),
(12, 'Daniel Rudiaman S, ST., M.Kom', 1),
(13, 'Chaulina Alfianti Oktavia, S.Kom., M.T ', 2),
(14, 'Johan Ericka W P, M.Kom\r\n', 2),
(15, 'Yekti Asmoro Kanthi, S.Si., M.A.B\r\n', 2),
(16, 'Meivi Kartikasari, S.Kom., M.T\r\n', 2),
(17, 'Rakhmad Maulidi, M.Kom\r\n', 2),
(18, 'Subari, M.Kom\r\n', 2),
(19, 'Go Frendi Gunawan, M.Kom\r\n', 2);

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id_doc` int(11) NOT NULL,
  `abstraksi` varchar(3000) NOT NULL,
  `dosen_pembimbing` varchar(100) NOT NULL,
  `co_dosen_pembimbing` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id_doc`, `abstraksi`, `dosen_pembimbing`, `co_dosen_pembimbing`) VALUES
(1, 'Budi Budi bermain bola', 'budiii', NULL),
(2, 'bola tidak mau bermain', 'suloyo', NULL),
(3, 'huujan ini membunuhku', 'willy', 'kulitpisang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datatraining`
--
ALTER TABLE `datatraining`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `data_uji`
--
ALTER TABLE `data_uji`
  ADD PRIMARY KEY (`no_docuji`);

--
-- Indexes for table `doc_uji`
--
ALTER TABLE `doc_uji`
  ADD PRIMARY KEY (`no_doc_uji`);

--
-- Indexes for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  ADD PRIMARY KEY (`id_dosenP`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id_doc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datatraining`
--
ALTER TABLE `datatraining`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `data_uji`
--
ALTER TABLE `data_uji`
  MODIFY `no_docuji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `doc_uji`
--
ALTER TABLE `doc_uji`
  MODIFY `no_doc_uji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  MODIFY `id_dosenP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id_doc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
