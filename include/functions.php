<?php
function Password_Encryption($password){
    $blowfish_hash_format = "$2y$12$00ok";
    $salt_length = 22;
    $salt = generate_salt($salt_length);
    $formatting_blowfish_with_salt = $blowfish_hash_format.$salt;
    $hash = crypt($password, $formatting_blowfish_with_salt);
    return $hash;
}

//generate salt function
function generate_salt(){
    global $salt_length;
    $unique_random_string = md5(uniqid(mt_rand(), true));
    $base64_string = base64_encode($unique_random_string);
    $modified_base64_string = str_replace('+', '_', $base64_string);
    $salt = substr($modified_base64_string, 0, $salt_length);
    return $salt;

}

//password check function//

function password_check(){
    $hash = crypt($password, $existing_hash);
    if($hash === $existing_hash){
        return true;
    }else{
        return false;
    }
}

