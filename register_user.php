<?php
session_start();
$username = ""; $email = ""; $password = ""; $cpassword = "";
$msg1 =""; $msg2 =""; $msg3 = ""; $msg4 = "";  $msg5 = "";
require_once ('include/config.php');
require_once ('include/functions.php');
if(isset($_POST['register'])){
    $username = mysqli_real_escape_string($conn, htmlspecialchars($_POST['username'],  ENT_QUOTES, 'utf-8'));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email'],  ENT_QUOTES, 'utf-8'));
    $password = mysqli_real_escape_string($conn, htmlspecialchars($_POST['password'],  ENT_QUOTES, 'utf-8'));
    $cpassword = mysqli_real_escape_string($conn, htmlspecialchars($_POST['cpassword'],  ENT_QUOTES, 'utf-8'));

    //validation checks

    if(empty($username)){
        $msg1 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Username cannot be empty.</div>";
    }else if(strlen($username)<=3){
        $msg1 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Username must be greater than 3 characters.</div>";

    }else if(empty($email)){
        $msg2 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Email is required.</div>";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg2 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Pls enter a valid email address.</div>";
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
        $_SESSION['name'] = $username;
        $name = $username;
        $msg5 = "<div style='font-size: 19px; height: 70px; margin-bottom: 20px; background: #5bc0de; color: #ffffff; text-align: center; 
                -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;'>"
            . 'Registration successful <br> Please check your email for an activation link.'
           ."</div>";
        ?>
         "<meta http-equiv='refresh' content='6; register_user.php' />";
       <?php

        //insert data into database


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
     </div>
</div>
    </div>
</div>

<!-- end Body section-->
<?php include ('include/footer.php'); ?>
