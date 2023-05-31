<?php

require_once('config.php');

include "connectDB.php";

include "common.php";

header('Content-Type: application/json');

$pid = 0;
if (isset($_GET['pid'])){
    $pid = $_GET['pid'];
}
if (!is_numeric($pid)){
    $pid = 0;
}

$birdid = 0;
if (isset($_GET['birdid'])){
    $birdid = $_GET['birdid'];
}
if (!is_numeric($birdid)){
    $birdid = 0;
}

$locationcode = 0;
if (isset($_GET['locationcode'])){
    $locationcode = $_GET['locationcode'];
}
if (!is_numeric($locationcode)){
    $locationcode = 0;
}


$lang = 3;

//$response = array();
$response = new stdClass();

if($birdid > 0){
    $response->photosJson = loadPhotos(2, $birdid);
}else if($locationcode > 0){
    $response->photosJson = loadPhotos(3,$locationcode);
}else{
    $response->photosJson = loadPhotos(1);
}

if($pid != 0){
    $response->photoJson = loadPhotos(4, $pid);
}

echo json_encode($response);

if ($GLOBALS['conn']) {
    mysqli_close($GLOBALS['conn']);
    //echo "Database connection closed.";
}

function loadPhotos($__type = 0, $__id = 0){

    global $selectPhotoOfToday, $selectGalleryIDPhoto, $selectPhotoByBird, $selectPhotoByLocation;
    $photosJson = array();

    switch($__type){
        case 1:
            $stmt1 = $GLOBALS['conn']->prepare($selectPhotoOfToday); 
            break;
        case 2:
            $stmt1 = $GLOBALS['conn']->prepare($selectPhotoByBird); 
            $stmt1->bind_param("s",$__id);
            break;
        case 3:
            $stmt1 = $GLOBALS['conn']->prepare($selectPhotoByLocation); 
            $stmt1->bind_param("s",$__id);
            break;
        case 4:
            $stmt1 = $GLOBALS['conn']->prepare($selectGalleryIDPhoto); 
            $stmt1->bind_param("s",$__id);
            break;
    }

    $stmt1->execute();
    $result1 = $stmt1->get_result();
    while ($row1 = $result1->fetch_assoc()) {
        $tempData = new stdClass();
        $galleryID = $row1['GalleryID'];
        $title = $row1['title'];
        $description = $row1['Description'];
        $memberID = $row1['MemberID'];
        $birdID = $row1['BirdID'];
        $numberOfBirdsID = $row1['NumberOfBirdsID'];
        $locationCode = $row1['LocationCode'];
        $surveyDate = $row1['SurveyDate'];
        $IP_address = $row1['IP_address'];

        $row2 = loadMemberDetail($memberID);
        $name = $row2['LastName'] . " " . $row2['FirstName'];
        $email = $row2['Email'];
        
        $row3 = loadLocationDetail($locationCode);
        $location = $row3['LocationArea'];

        $row4 = loadBirdDetail($birdID);
        $bird_type = $row4['Name'];
        $bird_description = $row4['Description'];
        $bird_habit = $row4['Habit'];

        $row5 = loadNumberOfBirdsDetail($numberOfBirdsID);
        $numberOfBirds = $row5['Description'];

        $row6 = loadMedia($galleryID);

        $tempData -> pid = $galleryID;
        $tempData -> name = $name;
        $tempData -> birdID = $birdID;
        $tempData -> bird_type = $bird_type;
        $tempData -> bird_description = $bird_description;
        $tempData -> bird_habit = $bird_habit;
        $tempData -> numberOfBirdsID = $numberOfBirdsID;
        $tempData -> numberOfBirds = $numberOfBirds;
        $tempData -> thumbnail = $row6;
        $tempData -> picture = $row6;
        $tempData -> date = $surveyDate;
        $tempData -> title = $title;
        $tempData -> content = $description;
        $tempData -> email = $email;
        $tempData -> location = $location;
        $tempData -> locationID = $locationCode;
        $tempData -> IP_address = $IP_address;

        array_push($photosJson,$tempData);
    }

    return $photosJson;
}

function loadMemberDetail($_memberID){
    global $selectMemberDetail;

    $stmt = $GLOBALS['conn']->prepare($selectMemberDetail); 
    $stmt->bind_param("s",$_memberID);

    $stmt->execute();
    $result = $stmt->get_result();
    $row;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $stmt->close();
    return $row;
}

function loadLocationDetail($_locationCode){
    global $selectLocationDetail;
    global $lang;

    $stmt = $GLOBALS['conn']->prepare($selectLocationDetail); 
    $stmt->bind_param("ss",$_locationCode,$lang);
    $stmt->execute();
    $result = $stmt->get_result();
    $row;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $stmt->close();

    return $row;
}

function loadBirdDetail($_birdID){
    global $selectBirdDetail;
    global $lang;

    $stmt = $GLOBALS['conn']->prepare($selectBirdDetail); 
    $stmt->bind_param("ss",$_birdID,$lang);
    $stmt->execute();
    $result = $stmt->get_result();
    $row;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $stmt->close();
    return $row;
}

function loadNumberOfBirdsDetail($_numberOfBirdsID){
    global $selectNumberOfBirdsDetail;
    global $lang;

    $stmt = $GLOBALS['conn']->prepare($selectNumberOfBirdsDetail); 
    $stmt->bind_param("ss",$_numberOfBirdsID,$lang);
    $stmt->execute();
    $result = $stmt->get_result();
    $row;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $stmt->close();
    return $row;
}

function loadMedia($_galleryID){
    global $selectMedia;

    $stmt = $GLOBALS['conn']->prepare($selectMedia); 
    $stmt->bind_param("s",$_galleryID);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        array_push($data,"/php/uploads/".$row['Filename']);
    }
    $stmt->close();
    return $data;
}

?>