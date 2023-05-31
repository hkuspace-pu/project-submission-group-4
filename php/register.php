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
    // Get the JSON data
    $json_data = json_decode(file_get_contents("php://input"), true);

    $firstname = "";
    $lastname = "";
    $email = "";
    $username = "";
    $password = "";
    $flag = 1;
    $adminID = 4;
    if (isset($json_data["firstname"])) {
        $firstname = $json_data["firstname"];
    }
    
    if (isset($json_data["lastname"])) {
        $lastname = $json_data["lastname"];
    }

    if (isset($json_data["email"])) {
        $email = $json_data["email"];
    }

    if (isset($json_data["username"])) {
        $username = $json_data["username"];
    }

    if (isset($json_data["password"])) {
        $password = $json_data["password"];
    }

    #$response->username = $json_data["username"];
    #$response->password = $json_data["password"];

    $success = true;
    #$response->testing = "Testing";

    if (!checkUsername($username)) {
        $success = false;
    }else if (!checkPassword($password)) {
        $success = false;
    }else if ($firstname == "") {
        $success = false;
    }else if ($lastname == "") {
        $success = false;
    }else if ($email == "") {
        $success = false;
    }

    if($success){

        $status = 0;
        $foundSalt = false;
        $stmt1 = $GLOBALS['conn']->prepare($checkRegister); 
        $stmt1->bind_param("ss", $username,$email);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        if ($result1->num_rows > 0) {
            $success = false;
            $row1 = $result1->fetch_assoc();
            if($row1['Email'] == $email){
                $response->status = RETURN_FAIL_STATUS;
                $response->error = RETURN_EMAIL_ALREADY;  
            }else if($row1['Username'] == $username){
                $response->status = RETURN_FAIL_STATUS;
                $response->error = RETURN_USERNAME_ALREADY;
            }
        }

        if($success){
            $salt = generateRandomString(64);

            $stmt2 = $GLOBALS['conn']->prepare($sha2SaltPassword); 
            $stmt2->bind_param("sss",$salt,$salt,$password);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $hashedPassword = $row2["hashed_password"];

                $stmt3 = $GLOBALS['conn']->prepare($memberRegister);
                $stmt3->bind_param("ssssssii", $username, $firstname,$lastname,$email, $hashedPassword,$salt,$flag,$adminID);
                #$response->test1 = bind_values_to_string($memberRegister,$username, $firstname,$lastname,$email, $hashedPassword,$salt);
                #$response->test2 = $memberRegister;
                $stmt3->execute();
                $stmt3->close();
                $response->status = RETURN_SUCCESS_STATUS;
            }
        }
    }else{
        $response->status = RETURN_FAIL_STATUS;
    }
    echo json_encode($response);
}else{
    header("Location: ../index.php");
    session_destroy();
}

if ($GLOBALS['conn']) {
    mysqli_close($GLOBALS['conn']);
    //echo "Database connection closed.";
}

?>