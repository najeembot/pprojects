<?php
@ob_start();
@require_once "connect_db.php";
if (!@empty($_COOKIE['login']) and @isset($_COOKIE['login'])) {
    @header("location: ./");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Vo Music | Signup</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico?ri=<?php echo rand(0, 999); ?>">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css?ri=<?php echo rand(0, 999); ?>">

</head>

<body id="signup_page" style="background-color:#ff0;">
  <script type="text/javascript" src="./js/script.js?ri=<?php echo rand(0, 999); ?>"></script>

    <!-- ##### Login Form Area Start ##### -->
    <div class="login-form section-padding-0-100">
        <div class="container">
            <br />
            <br />
            <br />
            <div class="row">
                <!-- Section Heading -->
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Login to your account</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Login Form Area -->
                    <div class="login-form-area">
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="login-form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="login-email">Email*:</label>
                                        <input type="email" class="form-control" id="login-email" name="login-email" placeholder="Enter your email" value="<?php if (@isset($_POST['login-email'])) {echo $_POST['login-email'];} ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="login-password">Password*:</label>
                                        <input type="password" class="form-control" id="login-password" name="login-password" placeholder="Enter your password here" value="<?php if (@isset($_POST['login-password'])) {echo $_POST['login-password'];} ?>">
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="submit" class="btn btn-block vomusic-btn mt-15" id="login-submit" name="login-submit" value="Login">
                                    </div>
                                    <br />
                                    <br />
                                    <br />
                                    <div class="form-group text-center">
                                      <a href="./signup.php?ri=<?php echo rand(0, 999); ?>" class="form-control text-primary">No account yet</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="row">
              <div class="col-12 text-center">
              <?php
              try {
                // process the login
                if (@isset($_POST['login-submit'])) {
                       $email = @htmlentities($_REQUEST['login-email']);
                       $password = @htmlentities($_REQUEST['login-password']);
                       $password = @md5($password);
                    if (!@empty($email) and !@empty($password)) {
                        if ($login_result = @mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `email` = '".@mysqli_real_escape_string($connection->con_link, $email)."' AND `password` = '".@mysqli_real_escape_string($connection->con_link, $password)."'")) {
                            if (@mysqli_num_rows($login_result) > 0) {
                               $user = @mysqli_fetch_assoc($login_result)['full_name'];
                               @setcookie("login", $user, strtotime("+ 1 year"));
                               @header("location: ./".$user."/?ri=".rand(0, 999));
                             } else {
                               throw new Exception("Invalid username/password combination");
                             }
                        } else {
                             throw new Exception("Error: ".@mysqli_error($connection->con_link));
                        }
                    } else {
                        throw new Exception("All fields are required");
                    }
                 }
               } catch(Exception $ex) {
                  echo "<h6>".$ex->getMessage()."</h6>";
               }
              ?>
              </div>
            </div>
        </div>
    </div>
    <!-- ##### Login Form Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <!-- Main Footer Area -->
        <div class="main-footer-area">
            <div class="container">
                <div class="row">
                  <!-- Single Footer Widget -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget mb-70">
                            <a href="./?ri=<?php echo rand(0, 999); ?>" class="footer-logo"><img src="img/core-img/logo.png?ri=<?php echo rand(0, 999); ?>" alt="img/core-img/logo.png" style="width:100px; height:100px;"></a>
                            <p>Search, Download, and Enjoy Music.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copwrite Area -->
        <div class="copywrite-area">
            <div class="container h-100">
                <div class="row h-100 align-items-center flex-wrap">
                    <!-- Copywrite Text -->
                    <div class="col-12 col-md-6">
                        <div class="copywrite-text">
                            <p><!-- @copyright NajeemB all rights reserved -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Powered by <a href="http://www.najeemb18.ml?ri=<?php echo rand(0, 999); ?>" target="_blank">NajeemB</a>
<!-- Link back to najeemb can't be removed.  -->
</p>
                        </div>
                    </div>
                    <!-- Footer Social Icon -->
                    <div class="col-12 col-md-6">
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->
    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- Active js -->
    <script src="js/active.js?ri=<?php echo rand(0, 999); ?>"></script>
</body>
</html>
