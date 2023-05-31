<?php

require_once('config.php');

include "connectDB.php";

include "common.php";

header('Content-Type: application/json');

// Start a new or resume an existing session

$response = new stdClass();

$expirationTime = 24 * 60 * 60; // 1 day in seconds
ini_set('session.gc_maxlifetime', $expirationTime);
session_set_cookie_params($expirationTime);

session_start();

// Check if the user is already logged in
#if (isset($_SESSION['username'])) {
    // Redirect to the user dashboard
    #header("Location: dashboard.php");
#}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $json_data = json_decode(file_get_contents("php://input"), true);

    $title = "";
    $description = "";
    $survey_date = "";
    $survey_location = "";
    $survey_numberOfBirds = "";
    $survey_bird = "";
    $photoBase64 = [];
    $flag = 1;
    $success = true;

    if (isset($json_data["title"])) {
        $title = $json_data["title"];
    }
    
    if (isset($json_data["description"])) {
        $description = $json_data["description"];
    }

    if (isset($json_data["survey_date"])) {
        $survey_date = $json_data["survey_date"];
    }

    if (isset($json_data["survey_location"])) {
        $survey_location = $json_data["survey_location"];
    }

    if (isset($json_data["survey_numberOfBirds"])) {
        $survey_numberOfBirds = $json_data["survey_numberOfBirds"];
    }

    if (isset($json_data["survey_bird"])) {
        $survey_bird = $json_data["survey_bird"];
    }

    if (isset($json_data["photoBase64"])) {
        $photoBase64 = $json_data["photoBase64"];
    }

    if (!isset($_SESSION['username'])) {
        $success = false;
    }else if ($title == "") {
        $success = false;
    }else if ($description == "") {
        $success = false;
    }else if ($survey_date == "") {
        $success = false;
    }else if ($survey_location == "") {
        $success = false;
    }else if ($survey_numberOfBirds == "") {
        $success = false;
    }else if ($survey_bird == "") {
        $success = false;
    }else if (count($photoBase64) == 0) {
        $success = false;
    }



    if($success){

        $flag = 0;
        $memberID;
        $adminMemberID = "";
        $lang = 3;
        $ip = $_SERVER['REMOTE_ADDR'];

        if (isset($_SESSION['memberID'])){
            $memberID = $_SESSION["memberID"];
        }

        if (isset($_SESSION["is_admin"])){
            if ($_SESSION["is_admin"]){
                $flag = 1;
                $adminMemberID = $memberID;
            }
        }

        $stmt1 = $GLOBALS['conn']->prepare($insertSurveyForm);
        $stmt1->bind_param("sssssssssss", $title, $description,$memberID,$survey_bird, $survey_numberOfBirds, $survey_location, $adminMemberID, $survey_date, $ip,$lang,$flag);
        $stmt1->execute();
        $insertedID = $stmt1->insert_id;
        $stmt1->close();

        foreach ($photoBase64 as $_orgData) {
            $dataUrlParts = explode(",", $_orgData);

            $dataMimeType = '';
            $type = 0;
            if (count($dataUrlParts) == 2) {
                $dataPrefix = explode(';', $dataUrlParts[0]);
                if (count($dataPrefix) == 2) {
                    $dataImageType = explode('/', $dataPrefix[0]);
                    if (count($dataImageType) == 2) {
                        $dataMimeType = strtolower($dataImageType[1]);
                    }
                }
            }

            if($dataMimeType == "jpeg" || $dataMimeType == ""){
                $dataMimeType = "jpg";
            }

            switch($dataImageType){
                case "jpg":
                case "png":
                    $type = 1;
                    break;
            }

            $decodedImage = base64_decode($dataUrlParts[1]);
            $uniqid = generateRandomString(64);
            $fileName = $uniqid . "." . $dataMimeType;
            $filePath = IMAGE_UPLOAD_PATH . $fileName;
            $successUpload = file_put_contents($filePath, $decodedImage);

            if($successUpload){
                $temp = 0;
                $stmt2 = $GLOBALS['conn']->prepare($insertMedia);
                $stmt2->bind_param("ssss", $temp,$insertedID,$fileName,$type);
                #$response->test1 = bind_values_to_string($insertMedia,$temp,$insertedID,$fileName,$type);
                #$response->test2 = $insertMedia;
                $stmt2->execute();
                $stmt2->close();
            }
        }

        $response->insertedID = $insertedID;
        $response->status = RETURN_SUCCESS_STATUS;
    }else{
        $response->status = RETURN_FAIL_STATUS;
    }
    echo json_encode($response);
}else{
    header("Location: ../index.php");
}

if ($GLOBALS['conn']) {
mysqli_close($GLOBALS['conn']);
//echo "Database connection closed.";
}

?>