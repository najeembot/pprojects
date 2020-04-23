<?php
// @copyRight allrights reserved NajeemB
@ob_start();
@session_start();
@require_once "connect_db.php";
$email = @trim(strip_tags($_GET['refererEmail']));
$svfec = @trim(mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT `verificationc` FROM `users` WHERE `email` = '".mysqli_real_escape_string($connection->con_link, $email)."'"))['verificationc']);
$cvfec = @trim(strip_tags($_GET['vfec']));
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="msvalidate.01" content="A2175D7DBFD9B1668012448807EFABC8" />
    <meta name="google-site-verification" content="Ot7digfb6ZQJppEQGIqDM2Gt2Dld4149wcyI26ZOdD8" />
    <meta name="yandex-verification" content="9b3d2af6e3081d2d" />
    <title>Chatz - <?php echo (@isset($_SESSION['passReset']) && !@empty($_SESSION['passReset'])) ? "Password Reset" : "Forgot Password" ?></title>
    <link rel="icon" type="image/x-icon" href="img/site_icon.ico" />
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
    <?php if (@isset($_GET['vfec']) and !@empty($cvfec) and $svfec == $cvfec) { // sending the response based on the referer ?>
    <body id="password_reset_page">
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <noscript>Sorry your browser doesn't support javascript or your browser scripting might be disabled</noscript>
        <div class="row">
            <div class="large-6 medium-6 large-offset-3 medium-offset-3 columns">
            <br />
            <br />
                <h1 class="text-center" style="color:#fff;"><b>Reset your password</b></h1>
                <br />
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="password" name="new_password" id="new_password" placeholder="Enter your new Password" />
                <input type="password" name="cnew_password" id="cnew_password" placeholder="Confirm your new Password" />
                <input type="submit" value="Verify" id="sb" class="button radius expand" />
                </form>
                <br />
                <div id="results">
                <?php 
                  try {
                     if (@isset($_POST['new_password']) and @isset($_POST['cnew_password'])) {
                        $newpass = @strip_tags($_POST['new_password']);
                        $cnewpass = @strip_tags($_POST['cnew_password']);
                        if (!@empty($newpass) and !@empty($cnewpass)) {
                            if ($connection->pass_validator($newpass)) {
                                if (@strcmp($newpass, $cnewpass) == 0) {
                                    $enpass = @md5($newpass);
                                    $tpass = @strrev(rand(0, 9).$newpass.rand(0, 9));
                                    if (@mysqli_query($connection->con_link, "UPDATE `users` SET `password` = '".$enpass."', `temp_password` = '".$tpass."' WHERE `email` = '".$email."'")) {
                                        echo "<h4 class='text-center' style='color:#fff;'>Password has been reset successfully.</h4>";
                                    } else {
                                        throw new Exception("<h4 style='color:#f00;'>Error updating database.</h4>");
                                    }
                                } else {
                                    throw new Exception("<h4 style='color:#f00;'>Passwords do not match.</h4>");
                                }
                            } else {
                                throw new Exception("<h4 style='color:#f00;'>Passwords must be at least 8 characters long and can not be only numbers or alphabets.</h4>");
                            }
                        } else {
                            throw new Exception("<h4 style='color:#f00;'>All fields are required.</h4>");
                        }
                     } 
                  } catch(Exception $ex) {
                     echo $ex->getMessage();
                  }
                ?>
                </div>
         </div>
    </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
    </body>
    <?php } else { ?>
    <body id="topass_reset_page">
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <noscript>Sorry your browser doesn't support javascript or your browser scripting might be disabled</noscript>
        <div class="row">
            <div class="large-6 medium-6 large-offset-3 medium-offset-3 columns">
            <br />
            <br />
                <h1 class="text-center" style="color:#fff"><b>Enter your verification details</b></h1>
                <br />
                <?php if (@function_exists('mail')) { ?>
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="byEmail">
                <input type="hidden" id="vf_method" name="vf_method" value="email" />
                <input type="text" id="vfu" name="vfu" placeholder="Enter your username first" />
                <input type="text" name="vf" id="vf" placeholder="Enter your email to verify" />
                <input type="submit" value="Verify" id="sb" class="button radius expand" />
                </form>
                <?php } else { ?>
                 <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="byVfkey">
                 <input type="hidden" name="vf_method" id="vf_method" value="vfKey" />
                 <input type="text" name="vfu" id="vfu" placeholder="Enter your username to verify" />
                 <input type="text" name="vf" id="vf" placeholder="Enter your verification code" />
                 <input type="submit" value="Verify" id="sb" class="button radius expand" />
                 </form>
                 <?php } ?>
                <br />
                <div id="results">
                <?php 
                  try {
                        if (@isset($_POST['vfu']) && @isset($_POST['vf'])) {
                            $vfu = @strip_tags($_POST['vfu']);
                            $vf = @strip_tags($_POST['vf']);
                         if (@!empty($vfu) and @!empty($vf)) {
                            $vf_method = $_POST['vf_method'];
                            switch ($vf_method) {
                                    case 'email':
                                        $query = "SELECT * FROM `users` WHERE `email`='".@mysqli_real_escape_string($connection->con_link, $vf)."' AND `username` = '".@mysqli_real_escape_string($connection->con_link, $vfu)."'";
                                        $query_run = @mysqli_query($connection->con_link, $query);
                                        if (@is_resource($query_run) or @mysqli_num_rows($query_run) == 1) {
                                        // setting mail variables
                                        $vfc = str_shuffle("ABCDEFGHIGKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".rand(0, 5000));
                                        $to = $vf;
                                        $subject = "Password Reset Link";
                                        $message = "
                                            <html>
                                            <head>
                                            <title>Password Reset Email</title>
                                            </head>
                                            <body>
                                            <center><h1 style='color:#ff9000; font-size:38px;'>Chatz</h1></center><br />
                                            <center><img src='http://chatz3.ml/img/login_site_logo.png' style='width:90; height:90;' /></center><br />
                                            <center><h2><b>Here is your password reset link</b></h2></center>
                                            <center><h4>Click or copy and paste this link into your browser to reset your password.</h4></center>
                                            <br />
                                            <center><i><a href='http://www.chatz3.ml/pass_reset.php?vfec=".$vfc."&refererEmail=".$vf."' target='_BLANK'>http://www.chatz3.ml/pass_reset.php?vfec=".$vfc."&refererEmail=".$vf."</a></i></center>
                                            
                                            </body></html>";
                                            // the Content-type header for HTML mail
                                            $headers = "From: No reply\r\n";
                                            $headers .= "Reply-To: noreply@chatz3.ml\r\n";
                                            $headers .= "MIME-Version: 1.0\r\n";
                                            $headers .= "Content-Type: text/html; charset: ISO-8859-1\r\n";
                                            if (@mail($to, $subject, $message, $headers)) { // sending a nice html email
                                                if (@mysqli_query($connection->con_link, "UPDATE `users` SET `verificationc` = '".$vfc."' WHERE `email` = '".$to."'")) {
                                                    echo "<h4 class='text-center' style='color:#fff'>Password reset link has been sent.</h4>";
                                                } else {
                                                    throw new Exception("<h4 style='color:#f00;'>Error updating table.</h4>");
                                                }
                                            } else {
                                                throw new Exception("<h4 style='color:#f00;'>Error sending email.</h4>");
                                            }   
                                            } else {
                                                throw new Exception("<h4 style='color:#f00;'>Incorrect verification details.</h4>");
                                            }
                                    break;
                                    case 'vfKey':
                                        if (@mysqli_num_rows(mysqli_query($connection->con_link, "SELECT `verificationc` FROM `users` WHERE `verificationc` = '".@mysqli_real_escape_string($connection->con_link, $vf)."' AND `username` = '".mysqli_real_escape_string($connection->con_link, $vf_username)."'")) == 1) {
                                            $uemail = @mysqli_fetch_array(mysqli_query($connection->con_link, "SELECT `email` FROM `users` WHERE `verificationc` = '".@mysqli_real_escape_string($connection->con_link, $vf)."'"))['email'];
                                            @header("location: ./pass_reset.php?vfec=".$vf."&refererEmail=".$uemail);
                                        } else {
                                            throw new Exception("<h4 style='color:#f00;'>Incorrect verification details.</h4>");
                                        }
                                    break;
                                    default:
                                        throw new Exception("<h4 style='color:#f00;'>Invalid Method.</h4>");
                                    break;          
                            }
                          } else {
                              throw new Exception("<h4>Please enter your username and email.</h4>");
                          }
                        } 
                  } catch(Exception $ex) {
                     echo $ex->getMessage();
                  }
                ?>
                </div>
         </div>
    </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
    </body>
</html>
<?php 
}
?>