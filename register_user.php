<?php
session_start();
$username = ""; $email = ""; $password = ""; $cpassword = "";
$msg1 =""; $msg2 =""; $msg3 = ""; $msg4 = "";  $msg5 = ""; $msg6 = "";
require_once ('include/config.php');
require_once ('include/functions.php');
if(isset($_POST['register'])){
    $username = mysqli_real_escape_string($conn, htmlspecialchars($_POST['username'],  ENT_QUOTES, 'utf-8'));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email'],  ENT_QUOTES, 'utf-8'));
    $password = mysqli_real_escape_string($conn, htmlspecialchars($_POST['password'],  ENT_QUOTES, 'utf-8'));
    $cpassword = mysqli_real_escape_string($conn, htmlspecialchars($_POST['cpassword'],  ENT_QUOTES, 'utf-8'));
    $token = bin2hex(openssl_random_pseudo_bytes(40));

    //validation checks

    if(empty($username)){
        $msg1 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Username cannot be empty.</div>";
    }else if(strlen($username)<=3){
        $msg1 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Username must be greater than 3 characters.</div>";

    }else if(usernameCheck($conn, $username)){
        $msg1 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Username already exists.</div>";
    }else if(empty($email)){
        $msg2 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Email is required.</div>";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg2 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Pls enter a valid email address.</div>";
    }else if(emailCheck($conn, $email)){
        $msg2 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Sorry Email is already registered. Try a different one.</div>";
    }else if(empty($password)){
        $msg3 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Pls enter your password.</div>";
    }elseif(strlen($password)<=5){
        $msg3 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Password must be 6 letters and above.</div>";
    }else if(empty($cpassword)){
        $msg4 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Pls re-enter your password.</div>";
    }else if($password !== $cpassword){
        $msg4 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>The two passwords must be the same.</div>";
    }else{
        //All validations passed
        $_SESSION['name'] = $email;

        //insert data into database if all checks are fine
        $hashed_password = Password_Encryption($password);
        $sql = "INSERT INTO admin_panel (username, email, password, token, active) VALUES ('$username', '$email', '$hashed_password', '$token', 'off')";
        $query = mysqli_query($conn, $sql);
        if($query){
            $subject = "Hello " ."$username". "Please activate your account.";
            $message  = "Hi"."$username" . " , here's the link to activate your account:"."http://localhost/movietrailer/register_user/activate.php?token='$token'";
            $headers = "From: Kelseygreat@gmail.com";
            $sendmail = mail($email, $subject, $message, $headers);
              if($sendmail){
                $msg5 = "<div style='font-size: 19px; height: 70px; margin-bottom: 20px; background: #5bc0de; color: #ffffff; text-align: center; 
                -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; padding-top: 10px; padding-bottom: 20px;'>"
                    . 'Registration successful <br> Please check your email for an activation link. do not forget to also check your junk or spam folders.'
                    . "</div>";
            ?>
            "<meta http-equiv='refresh' content='4; login.php' />";
            <?php
              }else{
                  $msg5 = "<div style='font-size: 19px; height: 70px; margin-bottom: 20px; background: #de3744; color: #ffffff; text-align: center; 
                -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;'>"
                      . 'Sorry something went wrong<br> Please try registering again.'
                      ."</div>";
              }
        }else{
            $msg5 = "<div style='font-size: 19px; height: 70px; margin-bottom: 20px; background: #de3744; color: #ffffff; text-align: center; 
                -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;'>"
                . 'Sorry something went wrong<br> Please try again.'
                ."</div>";
        }

        



    }

}

?>


<?php include ('include/header.php'); ?>
<title>Registration Page</title>
<style type="text/css">
    .form-control:focus{
        border-color: #94813c;
        box-shadow: inset 0 8px 4px rgba(92, 84, 210, 0.075), 0 0 8px rgba(11, 54, 88, 0.6);
        color: #5cb85c;
        font-size: 14px;
    }
</style>
<!-- End head section-->
<!-- begin Body section-->
<body style="background: #5bc0de; background-image: linear-gradient(45deg, #ce7373, transparent);">
<div class="container">
    <div class="row">
<div class="col-md-6 col-md-offset-3">
     <div class="jumbotron" style="margin-top: 40px;">
         <?php echo  $msg5; ?>
         <h3 class="text-center" style="margin-top: 50px;">Complete the short form below to register</h3>
         <form action="register_user.php" method="post">
               <div class="form-group">
                   <label for="name">Username</label>
                   <input type="text" id="name" name="username" placeholder="Enter your name" class="form-control" value="<?php echo $username; ?>">
                   <?php echo $msg1; ?>
               </div>
             <div class="form-group">
                 <label for="email">Email</label>
                 <input type="email" id="email" name="email" placeholder="Enter email address" class="form-control" value="<?php echo $email; ?>">
                 <?php echo $msg2; ?>
             </div>

             <div class="form-group">
                 <label for="password">Password</label>
                 <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" value="<?php echo $password; ?>">
                  <small class="text-center" style="color: #5cb85c;">Please use a strong password for account security.</small>
                 <?php echo $msg3; ?>
             </div>

             <div class="form-group">
                 <label for="cpassword">Confirm Password</label>
                 <input type="password" id="cpassword" name="cpassword" placeholder="Enter password again" class="form-control" value="<?php echo $cpassword; ?>">
                 <?php echo $msg4; ?>
             </div>

             <div class="form-group">
                 <input type="submit" value="Register" name="register" class="btn btn-info btn-lg">
             </div>

         </form>
         <p class="text-center">Already Registered? login <a href="login.php">here</a></p>
     </div>
</div>
    </div>
</div>

<!-- end Body section-->
<?php include ('include/footer.php'); ?>
