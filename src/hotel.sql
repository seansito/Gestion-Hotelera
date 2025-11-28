-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 05:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

-- CREATE TABLE `admin` (
--   `id` int(11) NOT NULL,
--   `nombre` varchar(255) NOT NULL,
--   `email` varchar(255) NOT NULL,
--   `contraseña` varchar(255) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id` int(11) NOT NULL,
  `precio` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL COMMENT '0 ocupada, 1 desocupada',
  `nombre_habitacion` varchar(255) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `capacidad` varchar(255) NOT NULL,
  `tamaño` varchar(255) NOT NULL,
  `camas` varchar(255) NOT NULL,
  `wifi` tinyint(1) NOT NULL DEFAULT 1,
  `ducha` tinyint(1) NOT NULL DEFAULT 1,
  `desayuno` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `habitaciones`
--

INSERT INTO `habitaciones` (`id`, `precio`, `estado`, `nombre_habitacion`, `descripcion`, `capacidad`, `tamaño`, `camas`, `wifi`, `ducha`, `desayuno`, `imagen`) VALUES
(1, '3500', 1, 'Habitación Moderna', 'Habitación con estilo artístico y contemporáneo, equipada con una cama de dos plazas, decoración moderna y detalles únicos. Ofrece un ambiente luminoso, elegante y diseñado para un descanso cómodo e inspirador.', '1 / 2', ' 24', 'Cama Queen', 1, 1, 1, 'Dormitorio moderno con toques vintage.png'),
(2, '2000', 1, 'Habitación Estandar', 'Habitación cómoda y funcional con una cama de dos plazas, decoración sencilla y todos los servicios esenciales para una estadía confortable. Ideal para viajeros solos o parejas que buscan una opción práctica y accesible.', '1 / 2', '20', 'Cama King', 1, 1, 1, 'Habitación elegante con paredes florales.png'),
(3, '2500', 1, 'Habitación Twin', 'Espacio confortable con dos camas individuales, ideal para amigos o viajeros que comparten estadía manteniendo independencia. Ambiente moderno, luminoso y equipado con ropa de cama premium, Smart TV 43” y wifi de alta velocidad.', '2', '28', 'Camas gemelas', 1, 1, 1, 'Habitación con camas gemelas y arte moderno.png'),
(4, '3000', 1, 'Habitación Clásica Confort', 'Espacio acogedor y elegante equipado con una cama de dos plazas, iluminación cálida y detalles decorativos que crean un ambiente ideal para descansar. Su estilo clásico y armonioso la convierte en una opción perfecta para viajeros que buscan comodidad y tranquilidad durante su estadía.', '2', '20-22', 'Cama King', 1, 1, 1, 'Galería de arte con geodas y pintura.png');

-- --------------------------------------------------------

--
-- Table structure for table `recordar_token`
--

CREATE TABLE `recordar_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_hash` varchar(255) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_expiracion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cedula` int(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` int(30) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `token_verificacion` text NOT NULL,
  `estado_verificacion` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0; no, 1; si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
-- ALTER TABLE `admin`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recordar_token`
--
ALTER TABLE `recordar_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recordar_tokens` (`user_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
-- ALTER TABLE `admin`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recordar_token`
--
ALTER TABLE `recordar_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
  

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recordar_token`
--
ALTER TABLE `recordar_token`
  ADD CONSTRAINT `fk_recordar_tokens` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    habitacion_id INT NOT NULL,
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    estado ENUM('pendiente','confirmada','cancelada') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (habitacion_id) REFERENCES habitaciones(id) ON DELETE CASCADE
);

COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
