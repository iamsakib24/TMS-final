SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 8979555556, 'adminuser@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2026-03-04 06:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `tblsubjects` (
  `ID` int(10) NOT NULL,
  `Subject` varchar(120) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `tblsubjects` (`ID`, `Subject`, `CreationDate`) VALUES
(1, 'Mathmetics', '2026-03-07 06:11:06'),
(2, 'Physics', '2026-03-07 06:11:19'),
(3, 'Chemistry', '2026-03-07 06:11:32'),
(4, 'Biology', '2026-03-07 06:11:41'),
(5, 'Hindi', '2026-03-07 06:11:49'),
(6, 'English', '2026-03-07 06:11:56'),
(7, 'Science', '2026-03-07 06:12:06'),
(8, 'Social Science', '2026-03-07 06:12:19'),
(9, 'Accounts', '2026-03-07 06:12:32'),
(10, 'Arts', '2026-03-07 06:12:44'),
(11, 'Musics', '2026-03-07 06:12:53'),
(12, 'Sanskrit', '2026-03-07 06:13:08'),
(13, 'Operating System (OS)', '2026-03-13 19:00:22');

-- --------------------------------------------------------

--
-- Table structure for table `tblteacher`
--

CREATE TABLE `tblteacher` (
  `ID` int(10) NOT NULL,
  `Name` varchar(120) DEFAULT NULL,
  `Picture` varchar(200) NOT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Qualifications` varchar(120) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `TeacherSub` varchar(120) DEFAULT NULL,
  `JoiningDate` varchar(120) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblteacher`
--

INSERT INTO `tblteacher` (`ID`, `Name`, `Picture`, `Email`, `MobileNumber`, `Qualifications`, `Address`, `TeacherSub`, `JoiningDate`, `RegDate`) VALUES
(1, 'vaskor', '7fdc1a630c238af0815181f9faa190f51570433828.jpg', 'abir@gmail.com', 4654654646, 'M.Tech(IT)', 'Flat No=646, Mayur Vihar Phase 1 New Delhi', 'Mathmetics', '2026-03-07', '2026-03-07 07:37:08'),
(2, 'sakib', 'e9db84d0e11b5c26723e9951e4f7204b1570445433.jpg', 'gyan@gmail.com', 8989898988, 'B.TECH', 'H.No=B 3/4 Shivala Varanasi 221001', 'Accounts', '2026-03-02', '2026-03-07 07:45:52'),
(3, 'Nikhil Singh', '2d99ae9e904f880eef8feb4e61882b791570445365.jpg', 'nik@gmail.com', 1213123213, 'B.ED(Commerce)', 'JK block H.no 3156 Laxmi Nagar', 'Arts', '2026-03-01', '2026-03-07 07:47:20'),
(4, 'Anuj Kumar', '3640809ea9da2fb83a3f8ac12432d8551570993351.png', 'phpgurukulofficial@gmail.com', 9864723742, 'B.Tech, MBA', 'New Delhi India 110091', 'Operating System (OS)', '2026-03-01', '2026-03-13 19:01:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblteacher`
--
ALTER TABLE `tblteacher`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblteacher`
--
ALTER TABLE `tblteacher`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
