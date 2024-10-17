-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 05:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `hd_departments`
--

CREATE TABLE `hd_departments` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hd_departments`
--

INSERT INTO `hd_departments` (`id`, `name`, `status`) VALUES
(1, 'SME', 1),
(2, 'Sauber', 1),
(3, 'Operation', 1),
(4, 'Finance', 1),
(5, 'Logistics', 1),
(6, 'Accounting', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hd_subjects`
--

CREATE TABLE `hd_subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hd_subjects`
--

INSERT INTO `hd_subjects` (`id`, `name`, `status`) VALUES
(1, 'Software Issue', 1),
(2, 'Hardware Issue', 1),
(3, 'Device Internal/External', 1),
(4, 'Printer / Drivers', 1),
(5, 'OS', 1),
(6, 'Server / Network', 1),
(7, 'Accounting', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hd_tickets`
--

CREATE TABLE `hd_tickets` (
  `id` int(11) NOT NULL,
  `uniqid` varchar(20) NOT NULL,
  `user` int(11) NOT NULL,
  `createdfor` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `init_msg` text NOT NULL,
  `department` int(11) NOT NULL,
  `date` varchar(250) NOT NULL,
  `last_reply` int(11) NOT NULL,
  `user_read` int(11) NOT NULL,
  `admin_read` int(11) NOT NULL,
  `resolved` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hd_tickets`
--

INSERT INTO `hd_tickets` (`id`, `uniqid`, `user`, `createdfor`, `title`, `init_msg`, `department`, `date`, `last_reply`, `user_read`, `admin_read`, `resolved`) VALUES
(1, '67106bf24361c', 5, 'Pat Labay', '5', 'Computer lagging, Hang issue', 1, '1728345600', 5, 0, 1, 1),
(2, '67106d8c2aa74', 5, 'Norizza', '1', 'Gdrive syncing and storage was unintentionally misused.', 2, '1728345600', 5, 0, 1, 1),
(3, '67106dc8a0e14', 5, 'Arlene', '4', 'Cannot print and internet connectivity', 2, '1728345600', 5, 0, 1, 1),
(4, '67106e020a8f3', 5, 'Sauber Office', '6', 'Access Point having trouble providing stable internet', 2, '1728432000', 5, 0, 1, 1),
(5, '67106e31085ee', 5, 'Philip Cruz', '1', 'Microsoft malfunction, excel cannot be open.', 5, '1728432000', 5, 0, 1, 1),
(6, '67106e922144b', 5, 'Tina', '6', 'LAN cable connectivity damaged.', 6, '1728518400', 5, 0, 1, 1),
(7, '67106ee48bd0e', 5, 'Jhoanna', '1', 'File corruption due to OS Malfunction', 6, '1728518400', 5, 0, 1, 1),
(8, '67106efbbd6c5', 5, 'Rocky', '1', 'PC BSOD', 1, '1728777600', 5, 0, 1, 1),
(9, '67106f5c5ec0f', 5, 'Gilbert Asor', '2', 'Laptop Screen Flex', 1, '1728864000', 5, 0, 1, 0),
(10, '67106f7935b9b', 5, 'Gilbert Asor', '1', 'Keyboard & Microsoft Office', 1, '1728950400', 5, 0, 1, 1),
(11, '67106f905a3e7', 5, 'Jerry D', '1', 'Microsoft Office', 1, '1728950400', 5, 0, 1, 1),
(12, '67106fb07c263', 5, 'Mary Jane', '1', 'Microsoft Office & OS Repair', 1, '1729036800', 5, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hd_ticket_replies`
--

CREATE TABLE `hd_ticket_replies` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `text` text NOT NULL,
  `ticket_id` text NOT NULL,
  `date` varchar(20) NOT NULL,
  `user_read` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hd_ticket_replies`
--

INSERT INTO `hd_ticket_replies` (`id`, `user`, `text`, `ticket_id`, `date`, `user_read`) VALUES
(1, 5, '*Reformat PC\r\n*Reinstall needed Applications/Program', '1', '1729132901', 0),
(2, 5, 'Unbind gdrive to the device and uninstall the program as user request', '2', '1729132985', 0),
(3, 5, 'Reconfigure printer connection, and internet connectivity', '3', '1729133038', 0),
(4, 5, 'Reinstall Office and activation', '5', '1729133059', 0),
(5, 5, 'Replaced AP from Cisco to DECO. Cisco pulled out.', '4', '1729133098', 0),
(6, 5, 'Trace internet cable and recrimp.', '6', '1729133157', 0),
(7, 5, 'Recover needed files, reformat device and downgrade from Win 11 to Win 10', '7', '1729133208', 0),
(8, 5, 'Downgrade to win 10, Install needed applications and give access to ebt using VPN', '8', '1729133245', 0),
(9, 5, 'Tried reseating flex cable (didn\'t work), endorsed to external technician for further repair.', '9', '1729133342', 0),
(10, 5, 'Reactivate office (crack) and provided alternative external keyboard', '10', '1729133427', 0),
(11, 5, 'Reactivate Office', '11', '1729133439', 0),
(12, 5, 'Reactivate office and OS.', '12', '1729133467', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hd_users`
--

CREATE TABLE `hd_users` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(250) NOT NULL,
  `user_type` enum('admin','user') NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hd_users`
--

INSERT INTO `hd_users` (`id`, `email`, `password`, `create_date`, `name`, `user_type`, `status`) VALUES
(1, 'ezekiel@oxc.com', '4297f44b13955235245b2497399d7a93', '2021-10-25 23:24:33', 'Ezekiel Santos', 'admin', 1),
(2, 'smithuser', '202cb962ac59075b964b07152d234b70', '2021-10-25 23:24:46', 'Jhon Smith', 'user', 1),
(5, 'fsudayon', '4297f44b13955235245b2497399d7a93', '2024-03-06 11:11:32', 'Fernando Sudayon', 'admin', 1),
(6, 'test', '098f6bcd4621d373cade4e832627b4f6', '2024-10-09 08:53:23', 'test', 'admin', 1),
(7, 'test', ' ', '2024-10-17 08:47:15', 'test', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hd_departments`
--
ALTER TABLE `hd_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hd_subjects`
--
ALTER TABLE `hd_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hd_tickets`
--
ALTER TABLE `hd_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hd_ticket_replies`
--
ALTER TABLE `hd_ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hd_users`
--
ALTER TABLE `hd_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hd_departments`
--
ALTER TABLE `hd_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hd_subjects`
--
ALTER TABLE `hd_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hd_tickets`
--
ALTER TABLE `hd_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hd_ticket_replies`
--
ALTER TABLE `hd_ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hd_users`
--
ALTER TABLE `hd_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
