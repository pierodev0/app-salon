-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 08:56 PM
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
-- Database: `appsalon_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `citas`
--

INSERT INTO `citas` (`id`, `fecha`, `hora`, `usuarioId`) VALUES
(35, '2006-10-21', '12:04:00', 10),
(41, '2025-02-05', '13:46:00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `citasservicios`
--

CREATE TABLE `citasservicios` (
  `id` int(11) NOT NULL,
  `citaId` int(11) DEFAULT NULL,
  `servicioId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `citasservicios`
--

INSERT INTO `citasservicios` (`id`, `citaId`, `servicioId`) VALUES
(29, NULL, NULL),
(30, NULL, 2),
(31, NULL, 4),
(32, 35, NULL),
(33, 35, 2),
(34, 35, 3),
(35, 35, 4),
(36, NULL, 3),
(37, NULL, 2),
(38, NULL, NULL),
(39, NULL, 2),
(40, NULL, 3),
(41, NULL, NULL),
(42, NULL, NULL),
(43, NULL, 2),
(44, NULL, NULL),
(45, 41, 2),
(46, 41, NULL),
(47, 41, 4);

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `precio`) VALUES
(2, 'Corte de cabello para mujeres', 120.00),
(3, 'Corte de cabello para niños', 90.00),
(4, 'Corte de barba y bigote', 100.00),
(5, 'Afeitado clásico con navaja', 100.00),
(6, 'Coloración de cabello', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `apellido` varchar(60) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `admin`, `confirmado`, `token`) VALUES
(7, 'Susan Shaw', 'Oneil', 'user1@correo.com', '$2y$10$ypvireKBXPtaPjz.ILcFEe23haUbUcYZmnO1qmmkBbGMisFRPfnfi', '934978063', 0, 1, ''),
(8, 'Admin', 'Super', 'admin@admin.com', '$2y$10$cmQrahO33x/SbYpCm1h.0.851qRoQ3uFejjU.q4zuEeXAPdjtUmYy', '907208162', 1, 1, NULL),
(9, 'Juan', 'Perez', 'user2@correo.com', '$2y$10$GtV8p2z7JhHnxv.enn41eud6hN5u9HuMEw9mbaH0nDp232h/PTWrC', '987654321', 0, 1, NULL),
(10, 'Mario', 'Cart', 'user3@correo.com', '$2y$10$eTQ1XLiNabrA/qC7UsidjuM4zwWRZpGY37hG4Gcp3eX93WH2jVc5K', '978563421', 0, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_usuarios_idx` (`usuarioId`);

--
-- Indexes for table `citasservicios`
--
ALTER TABLE `citasservicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citaId_idx` (`citaId`),
  ADD KEY `servicioId_idx` (`servicioId`);

--
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `citasservicios`
--
ALTER TABLE `citasservicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_usuarios` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `citasservicios`
--
ALTER TABLE `citasservicios`
  ADD CONSTRAINT `citasServicios_ibfk_1` FOREIGN KEY (`citaId`) REFERENCES `citas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `citasServicios_ibfk_2` FOREIGN KEY (`servicioId`) REFERENCES `servicios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
