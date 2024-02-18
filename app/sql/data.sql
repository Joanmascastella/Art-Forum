-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jan 11, 2024 at 09:00 PM
-- Server version: 11.2.2-MariaDB-1:11.2.2+maria~ubu2204
-- PHP Version: 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
                         `AdminID` int(11) NOT NULL,
                         `AdminUsername` varchar(255) NOT NULL,
                         `AdminPassword` varchar(255) NOT NULL,
                         `AdminRole` varchar(50) NOT NULL,
                         `AdminEmail` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`AdminID`, `AdminUsername`, `AdminPassword`, `AdminRole`, `AdminEmail`) VALUES
    (1, 'root', '$2y$10$Ns6ZmQC5VdPxO7SSXjigee/AlcdNCT6aEigYm/R8eOfmtW.kIgNF2', 'admin', 'stonksforjoan@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
                            `CommentID` int(11) NOT NULL,
                            `PostID` int(11) NOT NULL,
                            `UserID` int(11) NOT NULL,
                            `CommentText` varchar(255) NOT NULL,
                            `CommentDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`CommentID`, `PostID`, `UserID`, `CommentText`, `CommentDate`) VALUES
                                                                                           (77, 109, 18, 'Nice I love the color', '2024-01-11 20:49:04'),
                                                                                           (78, 110, 42, 'I love how you captured the moment', '2024-01-11 20:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `Posts`
--

CREATE TABLE `Posts` (
                         `PostID` int(11) NOT NULL,
                         `UserID` int(11) NOT NULL,
                         `Title` varchar(255) NOT NULL,
                         `Description` text DEFAULT NULL,
                         `PostDate` datetime DEFAULT current_timestamp(),
                         `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Posts`
--

INSERT INTO `Posts` (`PostID`, `UserID`, `Title`, `Description`, `PostDate`, `picture`) VALUES
                                                                                            (109, 42, 'Cool photo of a bird', 'This is a photo that I am really proud of that I took in Helsinki', '2024-01-11 20:48:47', '/img/post-images/1705006127_1704999162_1704989051_Screenshot 2023-04-19 132257.png'),
                                                                                            (110, 18, 'Adventure at Angkor Wat', '', '2024-01-11 20:49:35', '/img/post-images/1705006175_1704999533_1704997379_1704916290_Screenshot 2023-04-19 132128.png');

-- --------------------------------------------------------

--
-- Table structure for table `PostTags`
--

CREATE TABLE `PostTags` (
                            `TagID` int(11) NOT NULL,
                            `PostID` int(11) NOT NULL,
                            `TagName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PostTags`
--

INSERT INTO `PostTags` (`TagID`, `PostID`, `TagName`) VALUES
                                                          (50, 109, 'Photography'),
                                                          (51, 110, 'Photography'),
                                                          (52, 111, 'Photography');

-- --------------------------------------------------------

--
-- Table structure for table `Ratings`
--

CREATE TABLE `Ratings` (
                           `RatingID` int(11) NOT NULL,
                           `PostID` int(11) NOT NULL,
                           `UserID` int(11) NOT NULL,
                           `LikeStatus` int(255) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Ratings`
--

INSERT INTO `Ratings` (`RatingID`, `PostID`, `UserID`, `LikeStatus`) VALUES
                                                                         (229, 109, 18, 1),
                                                                         (230, 110, 42, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
                         `UserID` int(11) NOT NULL,
                         `Username` varchar(255) NOT NULL,
                         `Email` varchar(255) NOT NULL,
                         `Password` varchar(255) NOT NULL,
                         `ProfilePicture` varchar(255) DEFAULT NULL,
                         `Bio` text DEFAULT NULL,
                         `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Email`, `Password`, `ProfilePicture`, `Bio`, `role`) VALUES
                                                                                                     (18, 'Kart', 'kart@gmail.com', '$2y$10$717Jt9skI0X1S3RPuAyMIOe4B1lmPaUNQt976ogcbuKPsT2CGwPGC', '/img/profiles/1705006013_image_2024-01-11_214652378.png', 'Hi my name is asdasd', 'user'),
                                                                                                     (42, 'joan', 'joan.idevelop@gmail.com', '$2y$10$EqDsZGsuKxPC/8scZmqRPuEX5YxDYsNa4oLgd5nBPDeD9438vBY9u', NULL, NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
    ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
    ADD PRIMARY KEY (`CommentID`);

--
-- Indexes for table `Posts`
--
ALTER TABLE `Posts`
    ADD PRIMARY KEY (`PostID`);

--
-- Indexes for table `PostTags`
--
ALTER TABLE `PostTags`
    ADD PRIMARY KEY (`TagID`);

--
-- Indexes for table `Ratings`
--
ALTER TABLE `Ratings`
    ADD PRIMARY KEY (`RatingID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
    ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
    MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
    MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `Posts`
--
ALTER TABLE `Posts`
    MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `PostTags`
--
ALTER TABLE `PostTags`
    MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `Ratings`
--
ALTER TABLE `Ratings`
    MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
    MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
