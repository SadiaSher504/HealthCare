-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2025 at 05:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_branch`
--

CREATE TABLE `account_branch` (
  `id` int(11) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_reg` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_branch`
--

INSERT INTO `account_branch` (`id`, `full_name`, `username`, `password`, `status`, `profile`, `gender`, `email`, `date_reg`, `role`) VALUES
(14, 'jhon abraham', 'jhon_abraham24', 'jhon_abraham54', '', '', '', 'jhon_abraham@gmail.com', '', 'account_branch'),
(16, 'fgfg', 'asdf', 'adsf', '', '', '', 'asf', '', 'ipd/opd'),
(18, 'milan', 'manager', 'admin', 'approved', 'photo_2024-08-28_14-03-58.jpg', '', 'milan@hms', '', 'ipd/opd');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL,
  `admin_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `phone`, `username`, `gender`, `password`, `profile`, `status`, `admin_status`) VALUES
(3, 'admin', 'admin@gmail.com', '41488', 'admin12', 'male', '1234', '1.jpg', 'approved', 'main admin'),
(22, 'Rimsha Aamir', 'rimshaaamir926@gmail.com', '123456789', 'admin', 'male', 'admin', '', 'pending', ''),
(24, '', '', '', 'admin', '', '1234', '1.jpg', 'approved', ''),
(25, 'Aatif Aamir', 'atif@gmail.com', '12345678', 'admin', 'Male', '1234', '1.jpg', 'approved', 'Moderator');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `appointment_date` varchar(255) NOT NULL,
  `date_booked` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `symptoms` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `full_name` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `department` varchar(55) NOT NULL,
  `salary` varchar(30) NOT NULL,
  `role` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `full_name`, `email`, `department`, `salary`, `role`, `username`, `password`, `status`, `gender`) VALUES
(1, 'Dr. Monica Bambroo', 'drjulieofficial@gmail.com', 'Dermatology', '10000', '', 'arif', 'admin', 'approved', 'Female'),
(2, 'Dr. Rahul Gupta', 'Dr.Jhon@gmail.com', 'Neurology', '2500', '', 'jhon', 'admin', 'approved', 'Male'),
(3, 'Dr.Ariful Islam', 'dr.ariful@gmail.com', 'Orthopedics', '3500', '', 'doctor2', 'admin', 'approved', 'Male'),
(4, 'hossain arif', 'hossainarif@gmail.com', 'Cardiology', '2300', '', 'hussainasif', '1234', 'rejected', 'Male'),
(5, 'sdfgsdfg', 'sdfgdfsg@gmail.com', 'Orthopedics', '25000', '', '', '', 'approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `date_reg` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `date_join` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `full_name`, `email`, `username`, `password`, `date_reg`, `profile`, `role`, `gender`, `date_join`, `status`) VALUES
(25, 'Sharmin Akter', 'employee@hms.com', 'staff', 'admin', '22/10/2024', 'admin.jpeg', 'employee', 'female', '', 'approved'),
(26, 'employee2', 'employee@hms.com', 'eployee2', 'admin', '', 'asdfsdfprocoder.jpg', 'employee', '', '', 'pending'),
(27, 'employee3', 'employee3@hms.com', 'employee3', 'employee3', '', 'doctor_1.jpg', 'employee', '', '', ''),
(28, 'shs', 'asdfgasdf', 'sdfg', 'fdgdsfg', '', '4654567487sdfasd.jpg', 'staff', '', '', ''),
(29, '', '', '', '', '', '4654567487sdfasd.jpg', 'staff', '', '', ''),
(30, '1654654', 'sdfg', 'sdfg', 'sdfgsdfg', '', '', 'staff', '', '', ''),
(31, 'sdgfg', 'sfdgsfg@gmail.com', 'sdfg', 'sfg', '', '', 'staff', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `general_appointment`
--

CREATE TABLE `general_appointment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `district` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `doctor` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` enum('approved','denied','pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_appointment`
--

INSERT INTO `general_appointment` (`id`, `name`, `phone`, `district`, `department`, `doctor`, `date`, `status`) VALUES
(1, 'John Doe', '1234567890', 'Rawalpindi', 'Cardiology', 'Dr. Smith', '2025-02-22', 'approved'),
(2, 'Alice Johnson', '0987654321', 'Lahore', 'Neurology', 'Dr. Brown', '2025-02-25', 'denied'),
(3, 'Michael Khan', '03211234567', 'Karachi', 'Orthopedics', 'Dr. Ahmed', '2025-03-01', 'approved'),
(4, 'Rimsha Khan', '0123456789', 'Karachi', 'Orthopedics', 'Dr. Ahmed', '2025-03-01', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `id` int(100) NOT NULL,
  `doctor` varchar(100) NOT NULL,
  `patient` varchar(100) NOT NULL,
  `date_discharge` varchar(100) NOT NULL,
  `amount_paid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`id`, `doctor`, `patient`, `date_discharge`, `amount_paid`) VALUES
(1, 'Dr.John', 'Asif', '10-12-2024', '10,000'),
(2, 'Dr.John', 'Asif', '10-12-2024', '10,000'),
(3, 'Dr.John', 'Arif', '10-11-2024', '5,000');

-- --------------------------------------------------------

--
-- Table structure for table `link_visibility`
--

CREATE TABLE `link_visibility` (
  `id` int(11) NOT NULL,
  `visible` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `link_visibility`
--

INSERT INTO `link_visibility` (`id`, `visible`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `emergency_contact` varchar(20) NOT NULL,
  `refNumber` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `dob` date NOT NULL,
  `religion` varchar(50) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `username` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Others') NOT NULL,
  `division` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patient` (`id`, `full_name`, `phone`, `email`, `emergency_contact`, `refNumber`, `age`, `dob`, `religion`, `marital_status`, `blood_group`, `username`, `gender`, `division`, `district`, `password`) VALUES
(1, 'john doe', '1234567890', 'john@gmail.com', '1234567890', '', 20, '2015-03-11', 'cristian', 'UnMarried', 'B+', 'johndoe', 'Male', 'Lahore', 'Lahore', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `data_send` text NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `report` (`id`, `username`, `data_send`, `fullname`, `created_at`) VALUES
(1, 'john_doe', 'This is a sample report data.', 'John Doe', '2025-03-01 14:54:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_branch`
--
ALTER TABLE `account_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_appointment`
--
ALTER TABLE `general_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_visibility`
--
ALTER TABLE `link_visibility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `refNumber` (`refNumber`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `reports`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_branch`
--
ALTER TABLE `account_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `general_appointment`
--
ALTER TABLE `general_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `link_visibility`
--
ALTER TABLE `link_visibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
