-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2015 at 12:55 AM
-- Server version: 5.5.41
-- PHP Version: 5.4.45-0+deb7u1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'SoftUni'),
(2, 'Books'),
(3, 'Hardware'),
(4, 'Software'),
(5, 'Stuff');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`) VALUES
(1, 'T-Shirt', 'Cool SoftUni shirt.', 10, 10),
(2, 'Nakovs Book', 'New Introduction to programming with C#. Very cheap!', 1000, 249),
(3, 'Cool picture', 'Very cool picture! Must have.', 1200, 1),
(4, 'Old PC', 'My old PC, it is very powerfull - over 9000!', 2321, 1),
(5, 'New PC', 'My new PC, it is ever powerfull than the old one.', 3000, 1),
(6, 'Visual studio', 'Well its pirated version.', 0, 9996),
(7, 'PHP Storm', 'Very cool tool to write some cool shit in PHP', 15, 9976),
(8, 'NonExisting', 'Something not showing!', 100, 0),
(16, ' <script> alert("I am an alert box!"); </script>', ' <script> alert("I am an alert box!"); </script>', 0, 1),
(19, 'some', 'some', 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_categories`
--

CREATE TABLE IF NOT EXISTS `products_categories` (
  `productId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_categories`
--

INSERT INTO `products_categories` (`productId`, `categoryId`) VALUES
(1, 1),
(2, 2),
(3, 5),
(4, 3),
(5, 3),
(6, 4),
(7, 4),
(8, 1),
(16, 5),
(19, 5);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `productId` int(11) NOT NULL,
  `percentage` double NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `productId`, `percentage`, `endDate`) VALUES
(9, 'some', 19, 12.5, '2015-10-20'),
(10, 'nakovs book', 2, 60, '2015-10-15'),
(11, 'T-Shirt', 1, 100, '2014-10-03');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `message`, `userId`, `productId`) VALUES
(4, 'Edited', 4, 2),
(5, 'Some shit', 4, 1),
(6, 'dfdsfdsfsdf', 19, 1),
(7, 'Some whti', 19, 3),
(8, 'cool shit bro', 19, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Cash` decimal(10,0) NOT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT '0',
  `isEditor` tinyint(11) NOT NULL DEFAULT '0',
  `isModerator` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `Cash`, `isAdmin`, `isEditor`, `isModerator`) VALUES
(4, 'Kamigawa', 'PAy5RnxtBhJVg', 389, 1, 0, 0),
(19, 'User', 'PAy5RnxtBhJVg', 10000, 0, 1, 1),
(21, 'Kamigawa12', 'PAy5RnxtBhJVg', 10000, 1, 0, 0),
(22, 'Kamigawa123', 'PA0p7AqB.Otts', 10000, 0, 0, 1),
(23, 'Kamigawa1111', 'PAbtegnDyZxhg', 10000, 0, 0, 0),
(24, 'Kamigawa1234', 'PAy5RnxtBhJVg', 10000, 0, 0, 0),
(25, 'Kamigawa1', 'PAy5RnxtBhJVg', 10000, 0, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
