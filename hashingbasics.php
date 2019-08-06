<?php

//Hashing Basics: blow Fish and salt

$password = "KelseyGreat";
$blowfish_hash_format = "$2y$12$00ok";
$salt = "MYNameisOkeregodsPowerKelsey";
//echo "Length:".strlen($salt);
$formatting_blowfish_with_salt = $blowfish_hash_format.$salt;
$hash = crypt($password, $formatting_blowfish_with_salt);
echo $hash ."<br>";
echo "Length:".strlen($hash);
//echo "<br>";
//$unique_random_string = md5(uniqid(mt_rand(), true));
//$base64_string = base64_encode($unique_random_string);
//echo $base64_string;





