<?php
$msg = "";
if($_POST['find_hash']) {
    $password = htmlspecialchars($_POST['hash_value'], ENT_QUOTES, 'utf-8');
    $newPass = password_hash($password, PASSWORD_BCRYPT);

    $msg = $newPass;

}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Hashing</title>
</head>
<body>

<form action="" method="post">
    <label for="info">Enter the word to hash</label>
    <input type="text" id="info" name="hash_value" placeholder="Enter input to hash">
    <input type="submit" value="Find Hash" name="find_hash">
</form>

<div style="background: #583273; color: #dddaec; font-size: 20px; width: 675px; margin-top: 20px; height: 30px;" >

    <?php echo $msg; ?>
</div>

</body>
</html>
