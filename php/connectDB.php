<?php
// Set the database connection details
$loginFindSalt = "SELECT `Salt`,`Password`,`MemberID`,`AdminID` FROM `Member_List` WHERE `Username` = ? and Flag = 1";
$sha2SaltPassword = "SELECT CONCAT('$6$', ?, '$', UPPER(SHA2(CONCAT(?, ?), 512))) AS hashed_password";
$loginStatus = "INSERT INTO `MemberLoginStatus`(`MemberID`, `Flag`, `IP_address`) VALUES (?,?,?)";
$checkRegister = "SELECT `Email`,`Username` FROM `Member_List` WHERE `Username` = ? or `Email`=?";
$memberRegister = "INSERT INTO `Member_List`(`Username`, `FirstName`, `LastName`, `Email`,`Password`, `Salt`, `Flag`, `AdminID`) VALUES (?,?,?,?,?,?,?,?)";
$selectLocationList = "SELECT `LocationCode` FROM `Location_List` WHERE `Flag` = 1";
$selectLocationDetail = "SELECT `LocationArea`,`Description` FROM `Location_Detail` WHERE `LocationCode` = ? and `LangID`= ?";
$selectBirdList = "SELECT `BirdID` FROM `Bird_List` WHERE `Flag` = 1";
$selectBirdDetail = "SELECT `Name`, `Description`, `Habit` FROM `Bird_Detail` WHERE `BirdID` = ? and `LangID` = ?";
$selectNumberOfBirdsList = "SELECT `NumberOfBirdsID` FROM `NumberOfBirds_List` WHERE `Flag` = 1";
$selectNumberOfBirdsDetail = "SELECT `Description` FROM `NumberOfBirds_Detail` WHERE `NumberOfBirdsID` = ? and `LangID` = ?";
$insertSurveyForm = "INSERT INTO `Gallery`(`title`, `Description`, `MemberID`, `BirdID`, `NumberOfBirdsID`, `LocationCode`, `AdminMemberID`, `SurveyDate`, `IP_address`, `LangID`, `Flag`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
$insertMedia = "INSERT INTO `Media_List`(`BirdsID`, `GalleryID`, `Filename`, `Type`) VALUES (?,?,?,?)";
$selectMedia = "SELECT `Filename` FROM `Media_List` WHERE `GalleryID` = ? and `Flag` = 1";
$selectPhotoOfToday = "SELECT `GalleryID`, `title`, `Description`, `MemberID`, `BirdID`, `NumberOfBirdsID`, `LocationCode`, `AdminMemberID`, `SurveyDate`, `IP_address`, `Flag` FROM `Gallery` WHERE `Flag` = 1 ORDER BY RAND() LIMIT 6";
$selectMyPhoto = "SELECT `GalleryID`, `title`, `Description`, `MemberID`, `BirdID`, `NumberOfBirdsID`, `LocationCode`, `AdminMemberID`, `SurveyDate`, `IP_address`, `Flag` FROM `Gallery` WHERE `MemberID` = ? ORDER BY `GalleryID`";
$selectGalleryIDPhoto = "SELECT `GalleryID`, `title`, `Description`, `MemberID`, `BirdID`, `NumberOfBirdsID`, `LocationCode`, `AdminMemberID`, `SurveyDate`, `IP_address`,`Flag` FROM `Gallery` WHERE `GalleryID` = ?";
$selectPhotoByLocation = "SELECT `GalleryID`, `title`, `Description`, `MemberID`, `BirdID`, `NumberOfBirdsID`, `LocationCode`, `AdminMemberID`, `SurveyDate`, `IP_address` FROM `Gallery` WHERE `LocationCode` = ? ORDER BY `GalleryID`";
$selectPhotoByBird = "SELECT `GalleryID`, `title`, `Description`, `MemberID`, `BirdID`, `NumberOfBirdsID`, `LocationCode`, `AdminMemberID`, `SurveyDate`, `IP_address` FROM `Gallery` WHERE `BirdID` = ? ORDER BY `GalleryID`";
$selectMemberDetail = "SELECT `FirstName`, `LastName`, `Email`, `Flag` FROM `Member_List` WHERE `MemberID` = ?";
$selectLocationDetail = "SELECT `LocationArea`, `Description` FROM `Location_Detail` WHERE `LocationCode` = ? and `LangID` = ?";
$selectBirdDetail = "SELECT `Name`, `Description`, `Habit` FROM `Bird_Detail` WHERE `BirdID` = ? and `LangID` = ?";
$selectNumberOfBirdsDetail = "SELECT `Description` FROM `NumberOfBirds_Detail` WHERE `NumberOfBirdsID` = ? and `LangID` = ?";

$GLOBALS = array();
// Create a connection to the database
$GLOBALS['conn'] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

//echo DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME;

// Check the connection
if (!$GLOBALS['conn']) {
    die("Connection failed: " . mysqli_connect_error());
}

function pingDatabase(){
    return (mysqli_ping($GLOBALS['conn']) ? "Database connection is active." : "Database connection is lost.");
}

// Perform database operations here
// ...

// Close the connection
//mysqli_close($GLOBALS['conn']);
?>