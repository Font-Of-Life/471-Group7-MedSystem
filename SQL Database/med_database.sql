-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 14, 2021 at 08:46 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `med_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `can_have`
--

CREATE TABLE `can_have` (
  `Ingredient_Name` varchar(56) NOT NULL,
  `Gov_HealthCard_Num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dependent`
--

CREATE TABLE `dependent` (
  `First_Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Last_Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Parent_HealthCard_Num` int(11) NOT NULL,
  `Relationship` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `Doctor_LicenseNum` int(11) NOT NULL,
  `First_Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Last_Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Phone` int(11) NOT NULL,
  `Signature_Photo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Office_Address` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Practice_Province` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drug/ingredient_allergies`
--

CREATE TABLE `drug/ingredient_allergies` (
  `Ingredient_Name` varchar(56) NOT NULL,
  `Drug/Ingredient_Alt` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Drug/Ingredient_Usage` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drug_prescription`
--

CREATE TABLE `drug_prescription` (
  `Patient_HealthCard_Num` int(11) NOT NULL,
  `PharmLicense_Num` int(11) NOT NULL,
  `PharmID` int(11) NOT NULL,
  `DocLicense_Num` int(11) NOT NULL,
  `Prescriber_Name` varchar(56) NOT NULL,
  `DIN` int(11) NOT NULL,
  `RX_Number` int(11) NOT NULL,
  `Fill_Status` int(11) NOT NULL,
  `Date_Recieved` varchar(128) NOT NULL,
  `Instruction` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Date_Last_Filled` varchar(128) NOT NULL,
  `Amount_Last_Filled` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drug_profile`
--

CREATE TABLE `drug_profile` (
  `DIN` int(11) NOT NULL,
  `Drug_Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Drug_Generic_Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Pack_Size` int(11) NOT NULL,
  `Sell_Price` int(11) NOT NULL,
  `Bought_Price` int(11) NOT NULL,
  `Current_Inventory` int(11) NOT NULL,
  `Supplier` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Drug_Image` int(11) NOT NULL,
  `Schedule` varchar(128) COLLATE utf8_bin NOT NULL,
  `Strength` int(11) NOT NULL,
  `Date_Created` varchar(128) COLLATE utf8_bin NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_plan`
--

CREATE TABLE `insurance_plan` (
  `Policy_Number` int(11) DEFAULT NULL,
  `Policy_Holder_Health_Num` int(11) NOT NULL,
  `Company` varchar(56) DEFAULT NULL,
  `Start_Date` varchar(128) DEFAULT NULL,
  `End_Date` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_profile`
--

CREATE TABLE `patient_profile` (
  `Gov_HealthCard_Num` int(11) NOT NULL,
  `First_Name` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Last_Name` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `COVID_Test_Result` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Weight` varchar(11) NOT NULL,
  `Height` varchar(11) NOT NULL,
  `Preferred_Language` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Sex` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Phone_Number` int(11) NOT NULL,
  `Address` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Provider_Notes` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Day_Of_Birth` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient_profile`
--

INSERT INTO `patient_profile` (`Gov_HealthCard_Num`, `First_Name`, `Last_Name`, `COVID_Test_Result`, `Weight`, `Height`, `Preferred_Language`, `Sex`, `Phone_Number`, `Address`, `Provider_Notes`, `Email`, `Day_Of_Birth`, `UserID`) VALUES
(1, 'Teni', 'Fen', 'Pending', '150lb', '172cm', 'English', 'Male', 131231231, 'adasdasdasdasdasdasdsd', NULL, NULL, 'January 21 1995', 13),
(12312, 'qewq', 'da', 'Pending', 'asdsd', 'asda', 'asda', 'Male', 5787123, 'sdad', '', '', 'adasd', 13),
(42534, 'qeqwe', 'qeqe', 'Pending', 'qweqeda', 'dasdasd', 'asdasda', 'Male', 886643431, 'adasd', '', '', 'qeqesdas', 13),
(123123, 'qeqwe', 'eqwe', 'Pending', 'adas', 'asdas', 'adasd', 'Female', 98766412, 'aasds', 'asdfg', 'dadfbgnh', 'asdfgh', 13),
(1332123, 'E', 'q', 'Positive', 'adasd', 'asdasd', 'adasdasd', 'adasd', 1231231, 'adadasd', NULL, NULL, 'adadadasd', 123),
(4353461, 'Daren', 'Fargit', 'Negative', '150lb', '165cm', 'English', 'Male', 231231343, 'ASDASDASCZXCDSF', NULL, NULL, 'Feb 23 1995', 123),
(123123567, 'adad', 'adasd', 'Positive', 'adad', 'ada', '24sdasd', 'Male', 231311, 'adad', 'asdd', 'dadad', 'sasdsa', 13),
(123131237, 'qweq', 'afdgfdg', 'Positive', '161lbs', '180cm', 'English', 'Female', 1213211312, 'qewedsaffdgfddfg', NULL, NULL, 'gfhfhfgsdfsfg', 123);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacist`
--

CREATE TABLE `pharmacist` (
  `PharmLicense_Num` int(11) NOT NULL,
  `PharmID` int(11) NOT NULL,
  `First_Name` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Last_Name` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Phone` int(11) NOT NULL,
  `Password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Office_Address` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Practice_Province` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Photo_Signature` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pharmacist`
--

INSERT INTO `pharmacist` (`PharmLicense_Num`, `PharmID`, `First_Name`, `Last_Name`, `Phone`, `Password`, `Office_Address`, `Practice_Province`, `Photo_Signature`) VALUES
(123123, 123, 'wqe', 'qw', 123123, '123', 'qweqweqw', 'qwewq', '13123qeqw');

-- --------------------------------------------------------

--
-- Table structure for table `prescribed_to`
--

CREATE TABLE `prescribed_to` (
  `DIN` int(11) NOT NULL,
  `Gov_HealthCard_Num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescriber`
--

CREATE TABLE `prescriber` (
  `DocLicenseNum` int(11) NOT NULL,
  `PharmLicenseNum` int(11) NOT NULL,
  `PharmID` int(11) NOT NULL,
  `Prescriber_Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `technican`
--

CREATE TABLE `technican` (
  `TechID` int(11) NOT NULL,
  `First_Name` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Last_Name` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Phone` int(11) NOT NULL,
  `Password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `technican`
--

INSERT INTO `technican` (`TechID`, `First_Name`, `Last_Name`, `Phone`, `Password`) VALUES
(13, 'wq', 'eq', 123123, '123');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `First_Name` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Last_Name` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Phone` int(11) NOT NULL,
  `Password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `First_Name`, `Last_Name`, `Phone`, `Password`) VALUES
(13, 'wq', 'eq', 123123, '123'),
(123, 'wqe', 'qw', 123123, '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `can_have`
--
ALTER TABLE `can_have`
  ADD KEY `Can_Have_GovHealth_Num_FK` (`Gov_HealthCard_Num`),
  ADD KEY `Can_Have_IngredientName_FK` (`Ingredient_Name`);

--
-- Indexes for table `dependent`
--
ALTER TABLE `dependent`
  ADD KEY `dependent_parent_healthNum_FK` (`Parent_HealthCard_Num`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`Doctor_LicenseNum`),
  ADD UNIQUE KEY `Doctor_LicenseNum` (`Doctor_LicenseNum`);

--
-- Indexes for table `drug/ingredient_allergies`
--
ALTER TABLE `drug/ingredient_allergies`
  ADD PRIMARY KEY (`Ingredient_Name`);

--
-- Indexes for table `drug_prescription`
--
ALTER TABLE `drug_prescription`
  ADD PRIMARY KEY (`RX_Number`),
  ADD KEY `Drug_Prescription_Health_Num_FK` (`Patient_HealthCard_Num`),
  ADD KEY `Drug_Prescription_Pharm_LicenseNum_FK` (`PharmLicense_Num`),
  ADD KEY `Drug_Prescription_PharmID_FK` (`PharmID`),
  ADD KEY `Drug_Prescription_Doc_LicenseNum_FK` (`DocLicense_Num`),
  ADD KEY `Drug_Prescription_DIN_FK` (`DIN`),
  ADD KEY `Drug_Prescription_PrescriberName_FK` (`Prescriber_Name`);

--
-- Indexes for table `drug_profile`
--
ALTER TABLE `drug_profile`
  ADD PRIMARY KEY (`DIN`),
  ADD KEY `Drug_Profile_UserID_FK` (`UserID`);

--
-- Indexes for table `insurance_plan`
--
ALTER TABLE `insurance_plan`
  ADD UNIQUE KEY `Policy_Number` (`Policy_Number`),
  ADD KEY `InsurancePlan_HealthNum_FK` (`Policy_Holder_Health_Num`);

--
-- Indexes for table `patient_profile`
--
ALTER TABLE `patient_profile`
  ADD PRIMARY KEY (`Gov_HealthCard_Num`),
  ADD UNIQUE KEY `Gov_HealthCard_Num` (`Gov_HealthCard_Num`),
  ADD KEY `Patient_Profile_UserID_FK` (`UserID`);

--
-- Indexes for table `pharmacist`
--
ALTER TABLE `pharmacist`
  ADD PRIMARY KEY (`PharmLicense_Num`),
  ADD UNIQUE KEY `PharmID` (`PharmID`),
  ADD UNIQUE KEY `PharmLicense_Num` (`PharmLicense_Num`);

--
-- Indexes for table `prescribed_to`
--
ALTER TABLE `prescribed_to`
  ADD KEY `Prescribed_To_DIN_FK` (`DIN`),
  ADD KEY `Prescribed_To_HealthCard_FK` (`Gov_HealthCard_Num`);

--
-- Indexes for table `prescriber`
--
ALTER TABLE `prescriber`
  ADD UNIQUE KEY `Prescriber_Name` (`Prescriber_Name`),
  ADD KEY `Prescriber_DocLicenseNum_FK` (`DocLicenseNum`),
  ADD KEY `Prescriber_PharmID_FK` (`PharmID`),
  ADD KEY `Prescriber_PharmLicenseNum_FK` (`PharmLicenseNum`);

--
-- Indexes for table `technican`
--
ALTER TABLE `technican`
  ADD PRIMARY KEY (`TechID`),
  ADD UNIQUE KEY `TechID` (`TechID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `can_have`
--
ALTER TABLE `can_have`
  ADD CONSTRAINT `Can_Have_GovHealth_Num_FK` FOREIGN KEY (`Gov_HealthCard_Num`) REFERENCES `patient_profile` (`Gov_HealthCard_Num`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Can_Have_IngredientName_FK` FOREIGN KEY (`Ingredient_Name`) REFERENCES `drug/ingredient_allergies` (`Ingredient_Name`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dependent`
--
ALTER TABLE `dependent`
  ADD CONSTRAINT `dependent_parent_healthNum_FK` FOREIGN KEY (`Parent_HealthCard_Num`) REFERENCES `patient_profile` (`Gov_HealthCard_Num`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `drug_prescription`
--
ALTER TABLE `drug_prescription`
  ADD CONSTRAINT `Drug_Prescription_DIN_FK` FOREIGN KEY (`DIN`) REFERENCES `drug_profile` (`DIN`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Drug_Prescription_Doc_LicenseNum_FK` FOREIGN KEY (`DocLicense_Num`) REFERENCES `doctor` (`Doctor_LicenseNum`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Drug_Prescription_Health_Num_FK` FOREIGN KEY (`Patient_HealthCard_Num`) REFERENCES `patient_profile` (`Gov_HealthCard_Num`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Drug_Prescription_PharmID_FK` FOREIGN KEY (`PharmID`) REFERENCES `pharmacist` (`PharmID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Drug_Prescription_Pharm_LicenseNum_FK` FOREIGN KEY (`PharmLicense_Num`) REFERENCES `pharmacist` (`PharmLicense_Num`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Drug_Prescription_PrescriberName_FK` FOREIGN KEY (`Prescriber_Name`) REFERENCES `prescriber` (`Prescriber_Name`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `drug_profile`
--
ALTER TABLE `drug_profile`
  ADD CONSTRAINT `Drug_Profile_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `insurance_plan`
--
ALTER TABLE `insurance_plan`
  ADD CONSTRAINT `InsurancePlan_HealthNum_FK` FOREIGN KEY (`Policy_Holder_Health_Num`) REFERENCES `patient_profile` (`Gov_HealthCard_Num`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `patient_profile`
--
ALTER TABLE `patient_profile`
  ADD CONSTRAINT `Patient_Profile_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `prescribed_to`
--
ALTER TABLE `prescribed_to`
  ADD CONSTRAINT `Prescribed_To_DIN_FK` FOREIGN KEY (`DIN`) REFERENCES `drug_profile` (`DIN`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Prescribed_To_HealthCard_FK` FOREIGN KEY (`Gov_HealthCard_Num`) REFERENCES `patient_profile` (`Gov_HealthCard_Num`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `prescriber`
--
ALTER TABLE `prescriber`
  ADD CONSTRAINT `Prescriber_DocLicenseNum_FK` FOREIGN KEY (`DocLicenseNum`) REFERENCES `doctor` (`Doctor_LicenseNum`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Prescriber_PharmID_FK` FOREIGN KEY (`PharmID`) REFERENCES `pharmacist` (`PharmID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Prescriber_PharmLicenseNum_FK` FOREIGN KEY (`PharmLicenseNum`) REFERENCES `pharmacist` (`PharmLicense_Num`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
