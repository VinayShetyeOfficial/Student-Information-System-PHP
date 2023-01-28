-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2023 at 09:16 AM
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
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `id` varchar(80) NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `father_name` varchar(80) NOT NULL,
  `mother_name` varchar(80) NOT NULL,
  `gender` int(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `pincode` int(11) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`id`, `first_name`, `last_name`, `father_name`, `mother_name`, `gender`, `date_of_birth`, `email_id`, `address`, `pincode`, `state`, `city`, `password`, `password_hash`, `profile_pic`, `website`, `github`, `twitter`, `instagram`, `facebook`) VALUES
('63bd9a9a7ca52', 'Vinay', 'Shetye', 'Vishwanath B. Shetye', 'Mohini V. Shetye', 1, '1997-08-13', 'vinay.shetye.personal@gmail.com', 'Mpt Colony Bldg No. 211 2/1 B Type Headland Sada', 403804, 'Goa', 'Vasco Da Gama', '$YN\"b9aK', '$2y$12$mZAQQpK1N5HIbW3h77JANebCMI12eCHXfOwVn1lcumSi9AsOli/u6', 'VINAY_SHETYE_9A7CA52.PNG', 'blogpoint.ga', 'VinayShetyeOfficial', 'VinayShetye_', 'rapid_dealstore', 'profile.php?id=100088659774266'),
('63bd9b1fc4a12', 'Vivek', 'Shetye', 'Vishwanath B. Shetye', 'Mohini V. Shetye', 1, '1996-02-12', 'shetye.vivek@hotmail.com', 'Mpt Colony Bldg No. 211 2/1 B Type Headland Sada', 403804, 'Goa', 'Vasco Da Gama', '#UC^{5c8', '$2y$12$qcUxu0xkDTW45EZeoRMMBu6ZhQd8Jna1ZVt2bST1EH8JMMcuPEFC.', 'VIVEK_SHETYE_1FC4A12.PNG', '---', '---', '---', '---', '---'),
('63bebbd092078', 'Dhruv', 'Joshi', 'Vipul R. Joshi', 'Vaishnavi V. Joshi', 1, '1993-02-03', 'dhruv.joshi@vi.com', 'St 1, Opp Shilp Building, C G Road', 380009, 'Manipur', 'Wangjing', 'N2<^6Et]c', NULL, 'DHRUV_JOSHI_D092078.PNG', '---', '---', '---', '---', '---'),
('63bf0d47d9b37', 'Prabhat', 'Banerjee', 'Mohan K. Banerjee', 'Ritika M. Banerjee', 1, '1993-07-16', 'prabhat.banarjee@konda.in', 'Darpan Appt., Nr Hotel Express', 390007, 'Gujarat', 'Vadodara', 'Kz^4S4KZ', NULL, 'PRABHAT_BANERJEE_47D9B37.PNG', '---', '---', '---', '---', '---'),
('63bf0f3946a21', 'Niyati', 'Deshpande', 'Siddharth S. Deshpande', 'Nisha S. Deshpande', 2, '1998-08-15', 'deshpande.niya563@yahoo.com', '450, 450,avnrdblr-2, Avenue Road', 560002, 'Karnataka', 'Bangalore Urban', '*K4g9d-Z', NULL, 'NIYATI_DESHPANDE_3946A21.PNG', '---', '---', '---', '---', '---'),
('63bf88fe9dfe3', 'Vikas', 'Yadav', 'Suraj M. Yadav', 'Sheetal S. Jadav', 1, '1993-09-09', 'vikas.yadav@meriot.com', '29, 1 Cross 1st Cross, Srirampuram', 560021, 'Karnataka', 'Bangalore Rural', '8Z+m~YK^', NULL, 'VIKAS_YADAV_FE9DFE3.PNG', '---', '---', '---', '---', '---'),
('63c1037e4cae3', 'Naisha', 'Jain', 'Satish M. Jain', 'Radhika S. Jain', 2, '1997-08-13', 'nisha.jain32@outlook.com', 'Sheetla Mata Road, Near Crpf Camp, Gurgaon, Gurgaon', 122001, 'Maharashtra', 'Basmat', 't4@N8x?J', '$2y$12$pE9VHw6Lbq4goUdWT2KCm.Orvtw3avHT7jNxGSZtw1pD0lR3FA02i', 'NAISHA_JAIN_7E4CAE3.PNG', '---', '---', '---', '---', '---');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
