-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2023 at 09:17 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `student_login`
--

CREATE TABLE `student_login` (
  `id` varchar(80) NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_login`
--

INSERT INTO `student_login` (`id`, `first_name`, `last_name`, `email_id`, `password`, `password_hash`, `profile_pic`) VALUES
('63bd9a9a7ca52', 'Vinay', 'Shetye', 'vinay.shetye.personal@gmail.com', '$YN\"b9aK', '$2y$12$mZAQQpK1N5HIbW3h77JANebCMI12eCHXfOwVn1lcumSi9AsOli/u6', 'VINAY_SHETYE_9A7CA52.PNG'),
('63bd9b1fc4a12', 'Vivek', 'Shetye', 'shetye.vivek@hotmail.com', '#UC^{5c8', '$2y$12$qcUxu0xkDTW45EZeoRMMBu6ZhQd8Jna1ZVt2bST1EH8JMMcuPEFC.', 'VIVEK_SHETYE_1FC4A12.PNG'),
('63bebbd092078', 'Dhruv', 'Joshi', 'dhruv.joshi@vi.com', 'N2<^6Et]c', '$2y$12$sc3Znnlfd7Rz1WQCGlv1lOo16RMNRS8s9S48xtAeRozA01ineWN22', 'DHRUV_JOSHI_D092078.PNG'),
('63bf0d47d9b37', 'Prabhat', 'Banerjee', 'prabhat.banarjee@konda.in', 'Kz^4S4KZ', '$2y$12$7BzZnvFMkPjNiH07kvEV3uaYnKgd4LZT68YksDESZycyCS4qQwufG', 'PRABHAT_BANERJEE_47D9B37.PNG'),
('63bf0f3946a21', 'Niyati', 'Deshpande', 'deshpande.niya563@yahoo.com', '*K4g9d-Z', '$2y$12$fNHd5E7S4Q5MMS2V4/5z1uDBVu/HKnHVHuF7shDP9EuM6a6eQjYNi', 'NIYATI_DESHPANDE_3946A21.PNG'),
('63bf88fe9dfe3', 'Vikas', 'Yadav', 'vikas.yadav@meriot.com', '8Z+m~YK^', '$2y$12$xQnYnH/wStF1KqnGgb0fyOCCNR4ojE1NbDaIWaPGixjMBDxTb4vje', 'VIKAS_YADAV_FE9DFE3.PNG'),
('63c1037e4cae3', 'Naisha', 'Jain', 'nisha.jain32@outlook.com', 't4@N8x?J', '$2y$12$pE9VHw6Lbq4goUdWT2KCm.Orvtw3avHT7jNxGSZtw1pD0lR3FA02i', 'NAISHA_JAIN_7E4CAE3.PNG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_login`
--
ALTER TABLE `student_login`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
