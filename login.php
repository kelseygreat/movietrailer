<?php
session_start();
$username = ""; $email = ""; $password = "";
 $msg1 =""; $msg2 = ""; $msg3 = ""; $msg4='';
require_once ('include/config.php');
require_once ('include/functions.php');
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email'],  ENT_QUOTES, 'utf-8'));
    $password = mysqli_real_escape_string($conn, htmlspecialchars($_POST['password'],  ENT_QUOTES, 'utf-8'));

    //validation checks
    if(empty($email)){
        $msg1 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Email is required.</div>";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg1 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Pls enter a valid email address.</div>";
    }else if(!emailCheck($conn, $email)){
        $msg1 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Sorry Email is not yet registered.</div>";
    }else if(empty($password)){
        $msg2 = "<div class='alert-danger alert-dismissable text-center' style='font-size: 16px;'>Pls enter your password.</div>";
    }else{
        $_SESSION['name'] = $email;
        //check for email and password match and log user in
        $checkUserAccountStatus = checkUserAccountActiveStatus($conn, $email);
         if($checkUserAccountStatus){
        $foundAccount = loginCheck($conn, $email, $password);
        if($foundAccount){
            $msg3 = "<div style='font-size: 15px; height: 70px; margin-bottom: 40px; background: #5bc0de; color: #ffffff; text-align: center; 
                -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; padding-top: 5px;'>"
                . 'Login successful.<br>You are being redirected to your account\'s dashboard'
                ."</div>";
            ?>
            "<meta http-equiv='refresh' content='2; dashboard.php' />";
            <?php
        }else{
            $msg3 = "<div style='font-size: 19px; height: 70px; margin-bottom: 20px; background: #de3744; color: #ffffff; text-align: center; 
                -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; padding-top: 10px;'>"
                . 'Invalid Email or Password combination<br> Please try again.'
                ."</div>";
        }

    }else{
             $msg3 = "<div style='font-size: 19px; height: 70px; margin-bottom: 20px; background: #de3744; color: #ffffff; text-align: center; 
                -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; padding-top: 25px;'>"
                 . 'Account Confirmation is required.'
                 ."</div>";
         }
    }

}

?>


<?php include ('include/header.php'); ?>
<title>Login Page</title>
<style type="text/css">
    .form-control:focus{
        border-color: #94813c;
        box-shadow: inset 0 8px 4px rgba(92, 84, 210, 0.075), 0 0 8px rgba(11, 54, 88, 0.6);
        color: #5cb85c;
        font-size: 14px;
    }
    .logo{
        width: 150px;
        height: 150px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        margin-bottom: -30px;
    }
</style>
<!-- End head section-->
<!-- begin Body section-->
<body style="background: #5bc0de; background-image: linear-gradient(90deg, #ce7373, transparent);">
<div class="container">
    <div class="row">
<div class="col-md-6 col-md-offset-3">
     <div class="jumbotron" style="margin-top: 40px;">
         <?php echo  $msg3; ?>
         <p class="text-center"><img src="images/logo.jpg" alt="Login Image" title="Login page" class="logo"></p>
         <h3 class="text-center" style="margin-top: 50px;">Login </h3>
         <form action="login.php" method="post">
             <div class="form-group">
                 <label for="email">Email</label>
                 <input type="email" id="email" name="email" placeholder="Enter email address" class="form-control" value="<?php echo $email; ?>">
                 <?php echo $msg1; ?>
             </div>

             <div class="form-group">
                 <label for="password">Password</label>
                 <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" value="<?php echo $password; ?>">
                 <?php echo $msg2; ?>
             </div>
             <div class="form-group">
                 <input type="submit" value="Login" name="login" class="btn btn-info btn-lg">
             </div>
             <p class="text-center" style="color: #c47a7d;">Not yet registered? Click <a href="register_user.php">here</a> to register. </p>

         </form>
     </div>
</div>
    </div>
</div>

<!-- end Body section-->
<?php include ('include/footer.php'); ?>
