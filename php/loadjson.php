<?php

require_once('config.php');

include "connectDB.php";

header('Content-Type: application/json');

//$response = array();
$response = new stdClass();
$img_data = array();

//$response[0]->test = pingDatabase();
//$response[0]->status = '';

//$palette = Palette::fromFilename("test.jpg");
$user_id = $json_data['user_id'];
if($user_id == "")$user_id = 1;


$stmt1 = $conn->prepare($selectUploadIdDB); 
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
while ($row1 = $result1->fetch_assoc()) {
    $upload_id = $row1['upload_id'];

    $tempData = new stdClass();
    $tempData->date = $row1['created_at'];
    $tempData->device_id = $row1['device_id'];
    $tempData->pid = $upload_id;
    
    $img_id = array();

    $stmt2 = $conn->prepare($selectPhotoGalleryDB); 
    $stmt2->bind_param("s", $upload_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $color_extractor = $row2['color_extractor'];
        array_push($img_id,$row2['img_id']);
    }

    $tempData->color_extractor = $color_extractor;

    $tempData->img_id = $img_id;

    array_push($img_data,$tempData);
}
$response->img_data = $img_data;
echo json_encode($response);

if ($GLOBALS['conn']) {
    mysqli_close($GLOBALS['conn']);
    //echo "Database connection closed.";
}
?>