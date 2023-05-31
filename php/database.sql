CREATE TABLE IF NOT EXISTS  `Language_List` (
  `LangID` int(2) NOT NULL AUTO_INCREMENT,
  `WebDisplay` varchar(100) NOT NULL,
  `URL` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Flag` int(1) DEFAULT 1,
  `Default` int(1) DEFAULT 0,
  PRIMARY KEY (`LangID`),
  CONSTRAINT Language_WebDisplay UNIQUE (WebDisplay),
  CONSTRAINT Language_URL UNIQUE (URL)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- 資料表結構 `Admin_Position`
--

CREATE TABLE IF NOT EXISTS  `Admin_Position` (
  `AdminID` int(2) NOT NULL AUTO_INCREMENT,
  `PositionCode` varchar(100) NOT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `Member_List` (
  `MemberID` int(10) NOT NULL AUTO_INCREMENT,
  `Username` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Flag` int(1) DEFAULT 0,
  `AdminID` int(2) DEFAULT 0,
  `Password` varchar(512) NOT NULL,
  `Salt` varchar(64) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`MemberID`),
  FOREIGN KEY (AdminID) REFERENCES Admin_Position(AdminID),
  CONSTRAINT users_username UNIQUE (Username),
  CONSTRAINT users_email UNIQUE (Email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 資料表結構 `Bird_List`
--

CREATE TABLE IF NOT EXISTS  `Bird_List` (
  `BirdID` int(20) NOT NULL AUTO_INCREMENT,
  `Flag` int(1) DEFAULT 1,
  PRIMARY KEY (`BirdID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `Bird_Detail`
--


CREATE TABLE IF NOT EXISTS  `Bird_Detail` (
  `Bird_DetailID` int(10) NOT NULL AUTO_INCREMENT,
  `BirdID` int(10) NOT NULL,
  `LangID` int(2) NOT NULL,
  `Name` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Habit` text DEFAULT NULL,
  PRIMARY KEY (`Bird_DetailID`),
  UNIQUE KEY `bird_uniq_id` (`BirdID`,`LangID`),
  FOREIGN KEY (BirdID) REFERENCES Bird_List(BirdID),
  FOREIGN KEY (LangID) REFERENCES Language_List(LangID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 資料表結構 `Location`
--

CREATE TABLE IF NOT EXISTS  `Location_List` (
  `LocationCode` int(10) NOT NULL AUTO_INCREMENT,
  `Flag` int(1) DEFAULT 0,
  PRIMARY KEY (`LocationCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `Location_Detail` (
  `DetailID` int(10) NOT NULL AUTO_INCREMENT,
  `LocationCode` int(10) NOT NULL,
  `LangID` int(2) NOT NULL,
  `LocationArea` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`DetailID`),
  UNIQUE KEY `Location_uniq_id` (`LocationCode`,`LangID`),
  FOREIGN KEY (LocationCode) REFERENCES Location_List(LocationCode),
  FOREIGN KEY (LangID) REFERENCES Language_List(LangID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `MemberLoginTime`
--

CREATE TABLE IF NOT EXISTS  `MemberLoginStatus` (
  `MemLoginID` int(20) NOT NULL AUTO_INCREMENT,
  `MemberID` int(10) NOT NULL,
  `LoginTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `Flag` int(1) DEFAULT 0,
  `IP_address` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`MemLoginID`),
  FOREIGN KEY (MemberID) REFERENCES Member_List(MemberID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `Member_Approval`
--

CREATE TABLE IF NOT EXISTS  `Member_Approval` (
  `MemAppID` int(10) NOT NULL AUTO_INCREMENT,
  `MemberID` int(10) NOT NULL,
  `AdminMemberID` int(10) NOT NULL,
  `MemAppTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` int(1) NOT NULL,
  PRIMARY KEY (`MemAppID`),
  UNIQUE KEY `AppID` (`MemberID`,`AdminMemberID`),
  FOREIGN KEY (MemberID) REFERENCES Member_List(MemberID),
  FOREIGN KEY (AdminMemberID) REFERENCES Member_List(MemberID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `NumberOfBirds`
--

CREATE TABLE IF NOT EXISTS  `NumberOfBirds_List` (
  `NumberOfBirdsID` int(10) NOT NULL AUTO_INCREMENT,
  `Flag` int(1) DEFAULT 1,
  PRIMARY KEY (`NumberOfBirdsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `NumberOfBirds_Detail` (
  `DetailID` int(10) NOT NULL AUTO_INCREMENT,
  `NumberOfBirdsID` int(10) NOT NULL,
  `LangID` int(2) NOT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`DetailID`),
  UNIQUE KEY `NumberOfBirds_uniq_id` (`NumberOfBirdsID`,`LangID`),
  FOREIGN KEY (NumberOfBirdsID) REFERENCES NumberOfBirds_List(NumberOfBirdsID),
  FOREIGN KEY (LangID) REFERENCES Language_List(LangID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `Gallery` (
  `GalleryID` int(10) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `Description` text NOT NULL,
  `MemberID` int(10) NOT NULL,
  `BirdID` int(10) NOT NULL,
  `LangID` int(2) NOT NULL,
  `NumberOfBirdsID` int(10) NOT NULL,
  `LocationCode` int(10) NOT NULL,
  `Flag` int(1) NOT NULL DEFAULT 0,
  `Status` int(1) NOT NULL DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminMemberID` int(10) NOT NULL,
  `SurveyDate` VARCHAR(100) NOT NULL,
  `IP_address` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`GalleryID`),
  FOREIGN KEY (MemberID) REFERENCES Member_List(MemberID),
  FOREIGN KEY (LocationCode) REFERENCES Location_List(LocationCode),
  FOREIGN KEY (AdminMemberID) REFERENCES Member_List(MemberID),
  FOREIGN KEY (NumberOfBirdsID) REFERENCES NumberOfBirds_List(NumberOfBirdsID),
  FOREIGN KEY (BirdID) REFERENCES Bird_List(BirdID),
  FOREIGN KEY (LangID) REFERENCES Language_List(LangID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 資料表結構 `Photo`
--

CREATE TABLE IF NOT EXISTS  `Media_List` (
  `MediaID` int(10) NOT NULL AUTO_INCREMENT,
  `BirdsID` int(10),
  `GalleryID` int(10),
  `Type` int(1) NOT NULL,
  `Filename` varchar(100) NOT NULL,
  `Flag` int(1) DEFAULT 1,
  PRIMARY KEY (`MediaID`),
  CONSTRAINT Gallery_filename UNIQUE (Filename)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `Language_List`(`WebDisplay`, `URL`, `Description`,`Default`) VALUES ("Eng","en","English","1");
INSERT INTO `Language_List`(`WebDisplay`, `URL`, `Description`,`Default`) VALUES ("繁","tc","Simplified Chinese","0");
INSERT INTO `Language_List`(`WebDisplay`, `URL`, `Description`,`Default`) VALUES ("简","sc","Traditional Chinese","0");


INSERT INTO `Admin_Position`(`PositionCode`) VALUES ("");
INSERT INTO `Admin_Position`(`PositionCode`) VALUES ("Admin");
INSERT INTO `Admin_Position`(`PositionCode`) VALUES ("Super Admin");

INSERT INTO `Member_List`(`Username`, `FirstName`, `LastName`, `Email`, `Flag`, `AdminID`, `Password`, `Salt`) VALUES ("adminS1212","admin","admin","admin@test.com",1,2,"$6$N6IefR67Z5XL3wBuYoOmpV5jsksdO2OWTtCEay7JppNYn1HrABfFvWrtG3YmcMw1$E39F83C57E509B465047960E862B0F9701D20539701AF7A2039720EAB3FE010EF72CA06E26E1B449967868E93FCF11BFB2DF0705F83AEABB1887342066B39C6A","N6IefR67Z5XL3wBuYoOmpV5jsksdO2OWTtCEay7JppNYn1HrABfFvWrtG3YmcMw1");
INSERT INTO `Member_List`(`Username`, `FirstName`, `LastName`, `Email`, `Flag`, `AdminID`, `Password`, `Salt`) VALUES ("admin1234","admin","admin","admin@test.com",1,1,"$6$D74WXpsKCvpb4rBxh1hispT79vlFfGkd4O0LkhsVNQGN8zQ3aMaZkvCD7ECiqzjW$34091EA880923DB3B94A1F9863959E3911DEA5D3BB811EDABAB4449033728729522072604EC60150500E941A928D75F828E480C5A272436682539794D518F64A","D74WXpsKCvpb4rBxh1hispT79vlFfGkd4O0LkhsVNQGN8zQ3aMaZkvCD7ECiqzjW");

INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);
INSERT INTO `Location_List`(`Flag`) VALUES (1);

INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("1","3","Central and Western");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("1","1","中西區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("2","3","Eastern");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("2","1","東區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("3","3","Islands");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("3","1","離島區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("4","3","Kowloon City");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("4","1","九龍城區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("5","3","Kwai Tsing");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("5","1","葵青區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("6","3","Kwun Tong");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("6","1","觀塘區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("7","3","North");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("7","1","北區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("8","3","Sai Kung");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("8","1","西貢區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("9","3","Sha Tin");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("9","1","沙田區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("10","3","Sham Shui Po");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("10","1","深水埗區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("11","3","Southern");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("11","1","南區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("12","3","Tai Po");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("12","1","大埔區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("13","3","Tsuen Wan");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("13","1","荃灣區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("14","3","Tuen Mun");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("14","1","屯門區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("15","3","Wan Chai");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("15","1","灣仔區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("16","3","Wong Tai Sin");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("16","1","黃大仙區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("17","3","Yau Tsim Mong");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("17","1","油尖旺區");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("18","3","Yuen Long");
INSERT INTO `Location_Detail`(`LocationCode`, `LangID`, `LocationArea`) VALUES ("18","1","元朗區");

INSERT INTO `NumberOfBirds_List`(`Flag`) VALUES (1);
INSERT INTO `NumberOfBirds_List`(`Flag`) VALUES (1);
INSERT INTO `NumberOfBirds_List`(`Flag`) VALUES (1);
INSERT INTO `NumberOfBirds_List`(`Flag`) VALUES (1);

INSERT INTO `NumberOfBirds_Detail`(`NumberOfBirdsID`, `LangID`, `Description`) VALUES (1,3,"Single");
INSERT INTO `NumberOfBirds_Detail`(`NumberOfBirdsID`, `LangID`, `Description`) VALUES (2,3,"Pair");
INSERT INTO `NumberOfBirds_Detail`(`NumberOfBirdsID`, `LangID`, `Description`) VALUES (3,3,"Family");
INSERT INTO `NumberOfBirds_Detail`(`NumberOfBirdsID`, `LangID`, `Description`) VALUES (4,3,"Group");

-- --------------------------------------------------------

--
-- 資料表結構 `Member_List`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ObservationTime`
--

CREATE TABLE IF NOT EXISTS  `ObservationTime` (
  `ObservationTimeCode` int(10) NOT NULL,
  `ObservationTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- 資料表結構 `Position`
--

CREATE TABLE IF NOT EXISTS  `Position` (
  `PositionCode` int(10) NOT NULL,
  `PositionName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `Transactions_Approval`
--

CREATE TABLE IF NOT EXISTS  `Transactions_Approval` (
  `TransactionsAppID` int(10) NOT NULL,
  `TransactionsID` int(10) NOT NULL,
  `AdminID` int(10) NOT NULL,
  `TranAppTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `TranApproval` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `Video`
--

CREATE TABLE IF NOT EXISTS  `Video` (
  `VideoID` int(10) NOT NULL,
  `BirdsID` int(10) NOT NULL,
  `VideoPath` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `VisitorTransaction`
--

CREATE TABLE IF NOT EXISTS  `VisitorTransaction` (
  `TransactionsID` int(10) NOT NULL,
  `TransactionsTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `MemberID` int(10) NOT NULL,
  `BirdsID` int(10) NOT NULL,
  `Location` int(10) NOT NULL,
  `PhotoSubmission` varchar(1000) DEFAULT NULL,
  `VoiceSubmission` varchar(1000) DEFAULT NULL,
  `VideoSubmission` varchar(1000) DEFAULT NULL,
  `NumberOfBirds` int(10) DEFAULT NULL,
  `Date` date NOT NULL,
  `ObservationTime` int(10) DEFAULT NULL,
  `ObservationNote` varchar(4000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `Voice`
--

CREATE TABLE IF NOT EXISTS  `Voice` (
  `VoiceID` int(10) NOT NULL,
  `BirdsID` int(10) NOT NULL,
  `VoicePath` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;