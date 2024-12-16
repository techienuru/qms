-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 03:13 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$TwRMhaCJiuZV79YIICBrtOFZq4VJmMq7zfqA9WMb5qIck5q0Wcs/W');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `queue_id` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`queue_id`, `patient_id`, `reason`, `status`, `date_time`) VALUES
('CONS0719083', 3, 'Preventive Care', 'Was not attended', '2024-07-07 18:35:08'),
('CONS07194', 4, 'Injury Evaluation', 'Was not attended', '2024-07-07 18:33:53'),
('CONS0719462', 2, 'Ear, Nose, and Throat Issues', 'Was not attended', '2024-07-07 18:36:46'),
('CONS0720115', 5, 'Skin Conditions', 'Done', '2024-07-07 19:47:11'),
('CONS0720296', 6, 'Allergies Management', 'Was not attended', '2024-07-07 19:45:29'),
('CONS0813167', 7, 'Diagnosis', 'Done', '2024-07-08 12:05:16'),
('CONS1614163', 3, 'Therapy', 'On queue', '2024-08-16 13:53:16'),
('CONS1614191', 1, 'Diagnosis', 'called', '2024-08-16 13:50:19'),
('CONS1614435', 5, 'Surgery recommendation', 'On queue', '2024-08-16 13:53:43'),
('CONS1615164', 4, 'Eye pain', 'On queue', '2024-08-16 14:01:16'),
('CONS1615287', 7, 'sample reason', 'On queue', '2024-08-16 14:01:28'),
('CONS20114', 4, 'Lab Test Results Review', 'Done', '2024-07-07 18:20:11'),
('CONS20511', 1, 'Mental Health Concerns', 'called', '2024-07-07 18:20:51'),
('CONS22321', 1, 'Severe headache and stomach pain', 'Was not attended', '2024-07-06 12:22:32'),
('CONS48022', 2, 'Routine Check-up', 'Done', '2024-07-07 12:48:02'),
('CONS57053', 3, 'Mental Health Concerns', 'Done', '2024-07-07 16:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `patient_fullname` varchar(255) DEFAULT NULL,
  `patient_email` varchar(255) DEFAULT NULL,
  `patient_phone_no` varchar(255) DEFAULT NULL,
  `patient_dob` varchar(255) DEFAULT NULL,
  `patient_address` varchar(255) DEFAULT NULL,
  `patient_gender` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `patient_fullname`, `patient_email`, `patient_phone_no`, `patient_dob`, `patient_address`, `patient_gender`, `timestamp`) VALUES
(1, 'Ibrahim Nurudeen', 'patientnur@gmail.com', '08062585624', '2024-06-06', 'Akwanga by-pass, Keffi', 'Male', '2024-07-07 11:03:53'),
(2, 'Jeremiah Jacob', 'jacs@gmail.com', '08056432876', '2024-01-01', 'Oju eta, Lagos State', 'Male', '2024-07-07 11:28:56'),
(3, 'Fatima Isa Abdullahi', 'fatee@gmail.com', '08099999999', '2010-01-01', 'Behind old barawo Transformer, Angwan Tudu, Keffi, Nasarawa state', 'Female', '2024-07-07 11:32:22'),
(4, 'Mark Mathew Orogu', 'mark@gmail.com', '08087654321', '2024-06-01', 'Behind CPC transormer, dadin kowa, Keffi, Nasarawa State', 'Male', '2024-07-07 18:19:15'),
(5, 'Jibrin Abdullahi Jibrin ', 'jb@gmail.com', '07092564321', '2000-04-01', 'Lowcost, Keffi, Nasarawa State', 'Male', '2024-07-07 19:44:01'),
(6, 'Homo Sapien', 'sapien@gmail.com', '09000000000', '1111-01-01', 'Am not on earth', 'Other', '2024-07-07 19:44:54'),
(7, 'Sample Patient', 'patient@gmail.com', '08034678956', '2003-04-01', 'New York', 'Female', '2024-07-08 12:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `date_and_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `othername`, `email`, `password`, `specialization`, `role`, `date_and_time`) VALUES
(2, 'Ibrahim', 'Nurudeen', 'Shehu', 'nursenur@gmail.com', '$2y$10$zGQ2n/bcnbjVLPG7/Sz7WuzdTBwCbCNJNxkVfaS4dXNfCzkmRj9K6', NULL, 'Nurse', '2024-07-06 11:11:55'),
(3, 'Ibrahim', 'Nurudeen', 'Shehu', 'doctor@gmail.com', '$2y$10$yJFk7obVxELlassiF9GXk.kPVJSNjvnrvfP.zJOMkf2tU53EQ/jw2', 'Pharmacist', 'Doctor', '2024-07-08 10:29:09'),
(4, 'Ibrahim', 'Nurudeen', 'Shehu', 'nurse@gmail.com', '$2y$10$73xv7EOR5xtOjlAbwvw4xu2xPuF4nbFiTFYZ3/SwAV5aLGGuuUFg.', NULL, 'Nurse', '2024-07-08 10:35:21'),
(10, 'Ibrahim', 'Nurudeen', 'Shehu', 'docnur@gmail.com', '$2y$10$KqvA2MoYGgf2duUmR/jg1uiA9gN.L2d6aiwADlaEMU9iibSaFd7YO', 'Physical Medicine and Rehabilitation', 'Doctor', '2024-07-08 11:42:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`queue_id`),
  ADD KEY `patient_id_join` (`patient_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `patient_id_join` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
