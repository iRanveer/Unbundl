-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2026 at 11:22 AM
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
-- Database: `unbundl`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `banner_title` varchar(100) NOT NULL,
  `banner_subtitle` varchar(100) NOT NULL,
  `banner_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `banner_title`, `banner_subtitle`, `banner_image`) VALUES
(3, 'Get Your Dream Car', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e9224b1afe1.62053477.jpg'),
(4, 'Best Car For Rent', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e927729d6a6.20038775.jpg'),
(5, 'Find Your Ideal Car', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e9334e8e4d7.43244833.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `car_title` varchar(100) NOT NULL,
  `car_subtitle` varchar(100) NOT NULL,
  `car_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `car_title`, `car_subtitle`, `car_image`) VALUES
(2, 'BMW ', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e953195b488.19956685.jpg'),
(3, 'Mercedes', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e9562c14fe9.80399845.jpg'),
(4, 'Land Rover', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e956f447841.28047029.jpg'),
(5, 'Jeep', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e95859768d3.18793556.jpg'),
(6, 'Ford (Mustang)', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e95aa5560e5.23103273.jpg'),
(7, 'Porsche', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e95d0c17666.40376078.jpg'),
(8, 'Chevrolet', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis iste nesciunt libero ex neque placeat', 'Img-694e9600a14aa6.54678376.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `cars_option` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `number`, `email`, `address`, `cars_option`) VALUES
(1, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'on, on'),
(2, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'on, on'),
(3, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'on, on'),
(4, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'Sedan'),
(5, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'Sedan, SUV'),
(6, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'Sedan'),
(7, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'Sedan'),
(8, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'Sedan'),
(9, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'Sedan'),
(10, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'Sedan'),
(11, 'test', '6367205305', 'info@gmail.com', 'Murray Bridge', 'Sedan, SUV');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
