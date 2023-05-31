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

    $username = "";
    $password = "";
    
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
        $response->status = RETURN_FAIL_STATUS;
    }else if (!checkPassword($password)) {
        $success = false;
        $response->status = RETURN_FAIL_STATUS;
    }

    if($success){
        $status = 0;
        $foundSalt = false;
        $stmt1 = $GLOBALS['conn']->prepare($loginFindSalt); 
        $stmt1->bind_param("s", $username);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        if ($result1->num_rows > 0) {

            $row1 = $result1->fetch_assoc();

            $foundSalt = true;

            $salt = $row1['Salt'];
            $memberId = $row1['MemberID'];
            $adminID = $row1['AdminID'];
            $saltPassword = $row1['Password'];

            $stmt2 = $GLOBALS['conn']->prepare($sha2SaltPassword); 
            $stmt2->bind_param("sss",$salt,$salt,$password);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $hashedPassword = $row2["hashed_password"];
                #$response->test1 = $salt;
                #$response->test2 = $saltPassword;
                #$response->test3 = $hashedPassword;
                if($saltPassword == $hashedPassword){

                    $_SESSION['username'] = $username;
                    $_SESSION['memberID'] = $memberId;
                    if($adminID == 1 || $adminID == 2){
                        $_SESSION['adminID'] = $adminID;
                        $_SESSION['is_admin'] = true;
                    }else{
                        $_SESSION['is_admin'] = false;
                    }
                    createLoginStatus($memberId,1);
                    $response->status = RETURN_SUCCESS_STATUS;
                }else{
                    createLoginStatus($memberId,0);
                    $success = false;
                    session_destroy();
                    $response->status = RETURN_FAIL_STATUS;
                    $response->error = RETURN_USERNAME_PASSWORD_NOT_CORRECT;  
                }
            }
        }

        if(!$foundSalt){
            $success = false;
            session_destroy();
            $response->status = RETURN_FAIL_STATUS;
            $response->error = RETURN_USERNAME_PASSWORD_NOT_CORRECT;
        }
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

function createLoginStatus($__memberID, $__status){

    global $loginStatus;

    $stmt = $GLOBALS['conn']->prepare($loginStatus);
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt->bind_param("sis", $__memberID, $__status, $ip);
    
    $stmt->execute();
    
    $stmt->close();
}

?>