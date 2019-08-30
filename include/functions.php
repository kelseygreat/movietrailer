<?php
//Email already exist Check function//
function emailCheck($conn, $email){
    $sql = "SELECT email FROM admin_panel WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query)>0){
        return  true;
    }else{
        return false;
    }
}
//Username already exist Check function//
function usernameCheck($conn, $username){
    $sql = "SELECT username FROM admin_panel WHERE username = '$username'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query)>0){
        return  true;
    }else{
        return false;
    }
}
//password encryption function
function Password_Encryption($password){
    $blowfish_hash_format = "$2y$12$";
    $salt_length = 22;
    $salt = generate_salt($salt_length);
    $formatting_blowfish_with_salt = $blowfish_hash_format.$salt;
    $hash = crypt($password, $formatting_blowfish_with_salt);
    return $hash;
}

//generate password salt function
function generate_salt($length){
    $unique_random_string = md5(uniqid(mt_rand(), true));
    $base64_string = base64_encode($unique_random_string);
    $modified_base64_string = str_replace('+', '_', $base64_string);
    $salt = substr($modified_base64_string, 0, $length);
    return $salt;

}


//password check function//

function password_check($password, $existing_hash){
    $hash = crypt($password, $existing_hash);
    if($hash === $existing_hash){
        return true;
    }else{
        return false;
    }
}

//login check//

function loginCheck($conn, $email, $password){
    global $user_email;
    $sql = "SELECT * FROM admin_panel WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);
    $user_email  = mysqli_fetch_array($query);
    //check if email was found in database
    if($user_email){
        global  $existing_hash;
        $existing_hash = $user_email['password'];//password already in database
         //check for password associated with same email
        if(password_check($password, $existing_hash)){
            return $user_email;
        }
    }else {
        return null;
    }
}

//function to check account active status

function checkUserAccountActiveStatus($conn, $email){
    $sql = "SELECT * FROM admin_panel WHERE active = 'on' && email = '$email'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query)>0){
        return  true;
    }else{
        return false;
    }
}
