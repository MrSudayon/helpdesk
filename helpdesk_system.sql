-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 08:03 AM
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
(6, 'Accounting', 1),
(7, 'IBU', 1);

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
  `dateresolved` varchar(250) NOT NULL,
  `last_reply` int(11) NOT NULL,
  `user_read` int(11) NOT NULL,
  `admin_read` int(11) NOT NULL,
  `resolved` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hd_tickets`
--

INSERT INTO `hd_tickets` (`id`, `uniqid`, `user`, `createdfor`, `title`, `init_msg`, `department`, `date`, `dateresolved`, `last_reply`, `user_read`, `admin_read`, `resolved`) VALUES
(1, '67106bf24361c', 5, 'Pat Labay', '5', 'Computer lagging, Hang issue', 1, '1728345600', '1728518400', 5, 0, 1, 1),
(2, '67106d8c2aa74', 5, 'Norizza', '1', 'Gdrive syncing and storage was unintentionally misused.', 2, '1728345600', '1728518400', 5, 0, 1, 1),
(3, '67106dc8a0e14', 5, 'Arlene', '4', 'Cannot print and internet connectivity', 2, '1728345600', '1728518400', 5, 0, 1, 1),
(4, '67106e020a8f3', 5, 'Sauber Office', '6', 'Access Point having trouble providing stable internet', 2, '1728432000', '1728518400', 5, 0, 1, 1),
(5, '67106e31085ee', 5, 'Philip Cruz', '1', 'Microsoft malfunction, excel cannot be open.', 5, '1728432000', '1728518400', 5, 0, 1, 1),
(6, '67106e922144b', 5, 'Tina', '6', 'LAN cable connectivity damaged.', 6, '1728518400', '1729296000', 5, 0, 1, 1),
(7, '67106ee48bd0e', 5, 'Jhoanna', '1', 'File corruption due to OS Malfunction', 6, '1728518400', '1729036800', 5, 0, 1, 1),
(8, '67106efbbd6c5', 5, 'Rocky', '1', 'PC BSOD', 1, '1728777600', '1728950400', 5, 0, 1, 1),
(9, '67106f5c5ec0f', 5, 'Gilbert Asor', '2', 'Laptop Screen Flex', 1, '1728864000', '1729209600', 5, 0, 1, 1),
(10, '67106f7935b9b', 5, 'Gilbert Asor', '1', 'Keyboard & Microsoft Office', 1, '1728950400', '1728950400', 5, 0, 1, 1),
(11, '67106f905a3e7', 5, 'Jerry D', '1', 'Microsoft Office', 1, '1728950400', '1729036800', 5, 0, 1, 1),
(12, '67106fb07c263', 5, 'Mary Jane', '1', 'Microsoft Office & OS Repair', 1, '1729036800', '1729036800', 5, 0, 1, 1),
(13, '671995b17539f', 5, 'Jhen Piol', '2', 'Laptop charger repair', 7, '1729729969', 'On Progress', 5, 0, 0, 0),
(14, '6719a6f4d003e', 5, 'Jerry D', '1', 'Support for Microsoft Word protected file', 1, '1729734388', '1729734388', 5, 0, 1, 1),
(15, '6719d80f6edb6', 5, 'Sauber', '6', 'Give internet access to sauber storage @ liberty office for DVR/CCTV and other purpose', 2, '1729209600', 'On Progress', 5, 0, 1, 0),
(16, '671b2d364e6ce', 4, 'Gennia ', '2', 'Printer head defective EPSON G2020', 6, '1727740800', 'On Progress', 0, 0, 0, 0),
(17, '671b2da5a26c5', 4, 'Shella Pioquinto', '1', 'Modify PO form', 3, '1729468800', '1729834481', 4, 0, 1, 1),
(18, '671b330667d82', 4, 'Nadja Gonzales', '1', 'Microsoft office reactivation', 3, '1729835782', 'On Progress', 0, 0, 0, 0);

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
(12, 5, 'Reactivate office and OS.', '12', '1729133467', 0),
(13, 5, 'update: replaced Desktop with Mary Joyce Bueno ', '6', '1729729769', 0),
(14, 5, 'Remove protected file thru info settings on the Application', '14', '1729734415', 0),
(15, 5, 'Lay a cable from Sauber office up to sauber storage using PVC, Flexible Hose, and atleast 70 meters cable thru the bldg ceiling.', '15', '1729747067', 0),
(16, 4, 'Removed word \"Oxychem Corporation\" and update PO Form', '17', '1729834431', 0);

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
(1, 'user1', '24c9e15e52afc47c225b757e7bee1f9d', '2024-10-17 14:31:33', 'user1', 'user', 1),
(2, 'user2', '7e58d63b60197ceb55a1c487989a3720', '2024-10-17 14:31:50', 'user2', 'user', 1),
(3, 'user3', '92877af70a45fd6a2ed7fe81e1236b78', '2024-10-17 14:32:05', 'user3', 'user', 1),
(4, 'esantos', '21232f297a57a5a743894a0e4a801fc3', '2024-10-17 14:32:19', 'Ezekiel Santos', 'admin', 1),
(5, 'fsudayon', 'e00cf25ad42683b3df678c61f42c6bda', '2024-10-17 14:32:35', 'Fernando Sudayon', 'admin', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hd_subjects`
--
ALTER TABLE `hd_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hd_tickets`
--
ALTER TABLE `hd_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hd_ticket_replies`
--
ALTER TABLE `hd_ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `hd_users`
--
ALTER TABLE `hd_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
