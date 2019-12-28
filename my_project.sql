-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2018 at 12:45 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Cat_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Parent` int(11) NOT NULL,
  `Ordering` int(11) NOT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Cat_ID`, `Name`, `Description`, `Parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Computing', 'All Item Is Computer', 0, 1, 0, 0, 0),
(2, 'Electronic', 'Electronic Tools', 0, 2, 1, 1, 1),
(3, 'Tools', 'All Tools', 0, 3, 0, 1, 0),
(4, 'Hand Made', 'The Product Is Made By My Hand', 0, 4, 0, 0, 0),
(5, 'Nokia', 'Nokia Phone', 1, 1, 0, 0, 0),
(6, 'Network', 'Network Component', 1, 2, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '0',
  `Comment_Date` date NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All Comment';

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `Status`, `Comment_Date`, `Item_ID`, `User_ID`) VALUES
(4, 'Thank Ahmed ', 1, '2018-01-09', 1, 3),
(5, 'Welcome   Mohamed ', 1, '2018-01-01', 3, 2),
(6, 'Very Nice Very Nice Very Nice ', 1, '2018-01-09', 4, 1),
(7, 'Ahmed ', 1, '2018-02-06', 6, 1),
(8, 'Welcome  To Ahmed', 0, '2018-02-06', 6, 1),
(10, 'Wo Woooo ', 1, '2018-02-06', 6, 4),
(11, 'Wo Woooo ', 0, '2018-02-06', 6, 4),
(12, 'This  Mobile is Very Nice', 1, '2018-02-25', 6, 1),
(13, 'محمد صلي الله عليه وسلم ', 1, '2018-02-25', 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` varchar(255) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Cat_ID`, `Member_ID`, `Approve`, `Tags`) VALUES
(1, 'Keyboard', 'Electronic Tools  Electronic Tools ', '12', '2018-01-14', 'US', '404386_430310-das-keyboard-prime-13.jpg', '2', '', 1, 1, 1, 'Computer, Component'),
(3, 'Mouse', 'Tools of Computer', '11', '2018-01-16', 'Egypt', '403036_141479_4.jpg', '2', '', 1, 3, 1, ''),
(4, 'Network LAN 300', 'Network Component', '40', '2018-01-21', 'US', '277814_Kebidu-USB-2-0-WiFi-Network-Lan-Card-300-Mbps-Wireless-2-4G-Wifi-Adapter-With.jpg_640x640.jpg', '1', '', 1, 4, 1, ''),
(5, 'Printer', 'Printer Hp 3303h 35p', '600', '2018-01-21', 'US', '217458_c02949305.png', '1', '', 1, 3, 1, ''),
(6, 'Hauwai Mate 10 Lite  ', 'Hauwai Mate 10 Lite  Mobile phone', '123', '2018-01-31', 'US', '511288_Huawei-Mate-10-Lite-2.jpg', '1', '', 1, 2, 1, ''),
(7, 'Mate Ten Lite ', 'Mobile Phone Mobile Phone Mobile Phone Mobile Phone Mobile PhoneMobile PhoneMobile PhoneMobile Phone  Mobile Phone', '120', '2018-02-06', 'Indya', '309900_2017_11_13_16_57_2_633.jpg', '1', '', 2, 4, 1, ''),
(8, 'Cable Network Rj 45', 'Network Connection', '3', '2018-02-06', 'US', '880583_nEY7iKW.jpg', '1', '', 1, 4, 1, ''),
(9, 'Keyboard And Smart Mouse', 'My New Item', '21', '2018-02-10', 'US', '786426_7332059_sd.jpg', '2', '', 3, 1, 1, 'Clothing , Made'),
(10, 'My Item ', 'My New Item', '21', '2018-02-10', 'US', '989310_mouton-boat-m90-refresh-gallery-image.png', '2', '', 3, 1, 1, 'Clothing, Hand , Made'),
(11, 'ggfgrdg', 'fghghhhhhhhn', '1', '2018-02-12', 'US', '134490_kk403-burgandy_2.jpg', '1', '', 3, 1, 1, 'Clothing, Hand , Made'),
(12, 'T-shirt', 'clothing Made', '30', '2018-02-14', 'US', '321711_catalog_detail_image_large.jpg', '1', '', 4, 5, 1, 'Clothing, Hand , Made'),
(13, 'key 1', 'electronic keys ', '3', '2018-02-14', 'US', '809856_1(01).JPG', '1', '', 3, 1, 1, 'us, tools, key, new,electronic'),
(14, 'Ahmedfff', 'Electronic Tools  Electronic Tools ', '124', '2018-02-24', 'US', '955008_1285591278_business-cards-01.jpg', '2', '', 4, 6, 1, 'sdsad,dffdsf'),
(15, 'ddsdsdsd', 'dddddddddds', '1244', '2018-02-24', 'gfh', '966302858 (1).jpg', '2', '', 4, 1, 1, 'Clothing, Hand , Made');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Gender` tinyint(4) NOT NULL,
  `Group_ID` tinyint(4) NOT NULL DEFAULT '0',
  `Regstatus` tinyint(4) NOT NULL DEFAULT '0',
  `Date` date NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Image_Profile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users and Admin';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Username`, `Password`, `Email`, `FullName`, `Gender`, `Group_ID`, `Regstatus`, `Date`, `Phone`, `Image_Profile`) VALUES
(1, 'Ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Ahmedmohamedeid@gmail.com', 'Ahmed Mohamed', 0, 1, 1, '2017-12-20', '01012650056', '584898_img1442489844801.jpg'),
(2, 'ali1990', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'a@a.c', 'Ali Mohamed', 0, 0, 0, '2017-01-13', '01555898760', ''),
(3, 'mohamed', 'fe5fe4af3281ec07715498f052a7350c26c151c0', 'Ahmedmohamed@gmail.com', 'Mohamed Ali', 0, 0, 1, '2017-12-13', '012457538324', ''),
(4, 'Hend', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'amera701@yahoo.com', 'Hend Mohamed', 0, 0, 1, '2018-01-20', '01245673844', ''),
(5, 'shimaa', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Ah@ah.com', 'Shimaa', 0, 0, 1, '2018-01-26', '01245575824', '601901_img1442474377492.jpg'),
(6, 'AboAli', '442248d5746a3d4d1b7854a6bb19cf4bedd356e8', 'as@gg.com', 'Abo Ali', 0, 0, 1, '2018-02-22', '01245575824', '608131_7873_162422233938685_261525570_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Cat_ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `Items_Comments` (`Item_ID`),
  ADD KEY `Users_Comments` (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Cat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Items_Comments` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Users_Comments` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`Cat_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
