<?php

require_once('config.php');

include "connectDB.php";

include "common.php";

//header('Content-Type: application/json');

$lang = 3;

$response = new stdClass();

//Location
$location_data = array();
$stmt1 = $GLOBALS['conn']->prepare($selectLocationList); 
$stmt1->execute();
$result1 = $stmt1->get_result();
while ($row1 = $result1->fetch_assoc()) {
    $tempData = new stdClass();
    $locationCode = $row1['LocationCode'];
    $tempData->locationCode = $locationCode;

    $stmt2 = $GLOBALS['conn']->prepare($selectLocationDetail); 
    $stmt2->bind_param("ss", $locationCode, $lang);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $locationArea = $row2['LocationArea'];
        $tempData->locationArea = $locationArea;
    }
    array_push($location_data,$tempData);
}
$response->location_data = $location_data;

//Bird
$bird_data = array();
$stmt1 = $GLOBALS['conn']->prepare($selectBirdList); 
$stmt1->execute();
$result1 = $stmt1->get_result();
while ($row1 = $result1->fetch_assoc()) {
    $tempData = new stdClass();
    $birdID = $row1['BirdID'];
    $tempData->birdID = $birdID;

    $stmt2 = $GLOBALS['conn']->prepare($selectBirdDetail); 
    $stmt2->bind_param("ss", $birdID, $lang);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $name = $row2['Name'];
        $tempData->name = $name;

        $description = $row2['Description'];
        $tempData->description = $description;

        $habit = $row2['Habit'];
        $tempData->habit = $habit;
    }
    array_push($bird_data,$tempData);
}
$response->bird_data = $bird_data;

//NumOfBird
$numOfBirds_data = array();
$stmt1 = $GLOBALS['conn']->prepare($selectNumberOfBirdsList); 
$stmt1->execute();
$result1 = $stmt1->get_result();
while ($row1 = $result1->fetch_assoc()) {
    $tempData = new stdClass();
    $numberOfBirdsID = $row1['NumberOfBirdsID'];
    $tempData->numberOfBirdsID = $numberOfBirdsID;

    $stmt2 = $GLOBALS['conn']->prepare($selectNumberOfBirdsDetail); 
    $stmt2->bind_param("ss", $numberOfBirdsID, $lang);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $description = $row2['Description'];
        $tempData->description = $description;
    }
    array_push($numOfBirds_data,$tempData);
}
$response->numOfBirds_data = $numOfBirds_data;

echo json_encode($response);

if ($GLOBALS['conn']) {
    mysqli_close($GLOBALS['conn']);
    //echo "Database connection closed.";
}
?>