<?php
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function checkUsername($username){
    return preg_match('/^[a-zA-Z0-9_]{8,16}$/', $username);
}

function checkPassword($password){
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=<>?]).{8,24}$/', $password);
}

function checkEmail($email){
    $pattern = "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/";
    return preg_match($pattern, $email);
}


function bind_values_to_string(&$string, ...$values) {
    $bindString = '';
    
    foreach ($values as $value) {
        if (is_int($value) || is_float($value)) {
            $bindString .= 'i';
        } elseif (is_string($value)) {
            $bindString .= 's';
            $value = "'" . addslashes($value) . "'";
        } else {
            $bindString .= 's';
            $value = "NULL";
        }
        
        $string = preg_replace('/\?/', $value, $string, 1);
    }
    
    return $bindString;
}

?>