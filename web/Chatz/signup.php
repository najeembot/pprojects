<?php
@ob_start();
@session_start();
@require_once "connect_db.php";
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="msvalidate.01" content="A2175D7DBFD9B1668012448807EFABC8" />
    <meta name="google-site-verification" content="Ot7digfb6ZQJppEQGIqDM2Gt2Dld4149wcyI26ZOdD8" />
    <meta name="yandex-verification" content="9b3d2af6e3081d2d" />
    <title>Chatz - Signup</title>
    <link rel="icon" type="image/x-icon" href="img/site_icon.ico" />
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/vendor/modernizr.js"></script>
     <script type="text/javascript" src="./js/script.js"></script>
  </head>
    <body id="signup_page">
        <script type="text/javascript" src="Js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <noscript>Sorry your browser doesn't support javascript or your browser scripting might be disabled</noscript>
        <div class="row">
            <div class="large-6 medium-6 large-offset-3 medium-offset-3 columns">
                <br />
                <h1 id="signup_chatfor_logo" class="text-center"><b>Chatz</b></h1>
                <img src="img/login_site_logo.png" id="site_login_logo" />
                <h4 id="signup_title" class="text-center">Signup Here</h4><br />
                <form id="signup_form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <input type="text" name="full_name" maxlength="50" placeholder=" Enter full name here " id="full_name" required class="radius" value="<?php echo (@isset($_POST['full_name'])) ? $_POST['full_name'] : ''; ?>" />
                    <div class="validator" id="fullNameV"></div>
                    <br />
                    <br />
                    <input type="text" name="email" maxlength="50" placeholder=" Enter email here " id="email" required class="radius" value="<?php echo (@isset($_POST['email'])) ? $_POST['email'] : ''; ?>" />
                    <div class="validator" id="emailV"></div>
                    <br />
                    <br />
                    <input type="text" name="phone" maxlength="50" placeholder=" Enter phone here " id="phone" required class="radius" value="<?php echo (@isset($_POST['phone'])) ? $_POST['phone'] : ''; ?>" />
                    <div class="validator" id="phoneV"></div>
                    <br />
                    <br />
                    <label>Sex:
                    <select id="sex" name="sex" class="radius">
                       <?php 
                        $options = array("Male", "Female", "Other");
                        foreach ($options as $option) {
                            if (@isset($_POST['sex']) and @strtolower($option) == @$_POST['sex']) {
                       ?>
                       <option value="<?php echo strtolower($option); ?>" selected><?php echo $option; ?></option>
                       <?php
                            } else {
                       ?>
                       <option value="<?php echo strtolower($option); ?>"><?php echo $option; ?></option>
                       <?php
                            } 
                        }
                       ?>
                    </select>
                    </label>
                    <br />
                    <br />
                    <input type="text" name="sitename" maxlength="50" placeholder=" Enter sitename here " id="sitename" required class="radius" value="<?php echo (@isset($_POST['sitename'])) ? $_POST['sitename'] : ''; ?>" list="sites" />
                    <datalist id="sites">
                       <?php 
                          if ($query_run = @mysqli_query($connection->con_link, "SELECT DISTINCT `site` FROM `users` ORDER BY `site` ASC")) {
                              while ($query_row = @mysqli_fetch_assoc($query_run)) {
                       ?>
                       <option><?php echo $query_row['site']; ?></option>
                       <?php
                              }
                          }
                       ?>
                    </datalist>
                    <br />
                    <br />
                    <input type="text" name="username" maxlength="50" placeholder=" Enter username here " id="username" required class="radius" value="<?php echo (@isset($_POST['username'])) ? $_POST['username'] : ''; ?>" />
                    <div class="validator" id="usernameV"></div>
                    <br />
                    <br />
                    <input type="password" name="password" maxlength="100" placeholder=" Enter password here "  id="password" required class="radius" />
                    <div class="validator" id="passwordV"></div>
                    <br />
                    <br />
                    <input type="password" id="con_password" name="con_password" maxlength="100" placeholder=" Confirm your password " required class="radius" />
                    <div class="validator" id="con_passwordV"></div>
                    <br />
                    <br />
                    <input type="submit" value="Submit" id="signup_button" class="button expand radius" />
                </form>
                <br />
                <div id="signup_results">
                    <?php
                        // processing the whole registeration self processing page
                        try {
                            if (@empty($_COOKIE['username']) && !@isset($_COOKIE['username'])) {
                                if (@isset($_POST['full_name']) && @isset($_POST['email']) && @isset($_POST['phone']) && @isset($_POST['sex']) && @isset($_POST['sitename']) && @isset($_POST['username']) && @isset($_POST['password']) && @isset($_POST['con_password'])) {
                                    // post vars 
                                    $fullName = @strip_tags($_POST['full_name']);
                                    $email = @strip_tags($_POST['email']);
                                    $phone = @strip_tags($_POST['phone']);
                                    $sex = @strip_tags($_POST['sex']);
                                    $siten = @strip_tags($_POST['sitename']);
                                    $username = @strip_tags($_POST['username']);
                                    $password = @strip_tags($_POST['password']);
                                    $con_password = @strip_tags($_POST['con_password']);
                                    $temp_pass = @strrev(rand(0, 9).$password.rand(0, 9));
                                    $default_pfp_path = "./profile_pictures/default_profile_picture/default.jpeg";
                                    $enc_pass = @md5($password);
                                    if (!@empty($fullName) && !@empty($email) && !@empty($phone) && !@empty($sex) && !@empty($siten) && !@empty($username) && !@empty($password) && !@empty($con_password)) {
                                        // validations
                                        if (@preg_match($connection->meta_re, $fullName) != 1) {
                                            if ($connection->validate_email($email)) {
                                                if (@preg_match($connection->phone_re, $phone) != 1) {
                                                    if ($sex == "male" || $sex == "female" || $sex == "other") {
                                                      if ($connection->setDIR("./".$siten."/")) {
                                                        if (@mysqli_num_rows(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".@mysqli_real_escape_string($connection->con_link, $username)."'")) < 1) {
                                                          if (@preg_match($connection->meta_re, $username) != 1) {
                                                            if ($connection->pass_validator($password)) {
                                                                if ($password == $con_password) {
                                                                    $insertion_query = "INSERT INTO `users` (`id`, `full_name`, `sex`, `email`, `phone`, `site`, `username`, `password`, `temp_password`, `status`, `p_link`, `userl_ip`, `registered_on`) VALUES (NULL, '".@mysqli_real_escape_string($connection->con_link, $fullName)."', '".@mysqli_real_escape_string($connection->con_link, $sex)."', '".@mysqli_real_escape_string($connection->con_link, $email)."', '".@mysqli_real_escape_string($connection->con_link, $phone)."', '".@mysqli_real_escape_string($connection->con_link, $siten)."', '".@mysqli_real_escape_string($connection->con_link, $username)."', '".$enc_pass."', '".$temp_pass."', 'reg_pending', '".@mysqli_real_escape_string($connection->con_link, $default_pfp_path)."', '".$connection->getUserIpAddr()."', NOW())"; 
                                                                    if (@mysqli_query($connection->con_link, $insertion_query)) {
                                                                        @setcookie("reg_pending", $username, strtotime("+ 1 year"));
                                                                        @header("location: ./secure_checkpoint.php?sitename=".$siten);
                                                                    } else {
                                                                        throw new Exception("<font color='#f00'>Error occured while processing user data.</font>");
                                                                    }
                                                                    
                                                                } else {
                                                                    throw new Exception("<h5 style='color:#f00'>Passwords do not match.</h5>");
                                                                }
                                                                
                                                            } else {
                                                                throw new Exception("<h5 style='color:#f00'>Passwords must be at least 8 characters long and can not be only numbers, alphabets and should contain at least one UpperCase and one LowerCase letter.</h5>");
                                                            }
                                                          } else {
                                                             throw new Exception("<h5 style='color:#f00'>Invalid username.</h5>");
                                                          }
                                                        } else {
                                                            throw new Exception("<h5 style='color:#f00'>Username already taken.</h5>");
                                                        }
                                                      } else {
                                                          throw new Exception("<h5 style='color:#f00'>Error creating directory/home page.</h5>");
                                                      }
                                                    } else {
                                                        throw new Exception("<h5 style='color:#f00'>No specified gender found.</h5>");
                                                    }
                                                } else {
                                                    throw new Exception("<h5 style='color:#f00'>Invalid phone.</h5>");
                                                }
                                            } else {
                                                throw new Exception("<h5 style='color:#f00'>Invalid email.</h5>");
                                            }
                                        } else {
                                            throw new Exception("<h5 style='color:#f00'>Invalid name.</h5>");
                                        }
                                        
                                    } else {
                                        throw new Exception("<h5 style='color:#f00'>All fields are required.</h5>");
                                    }
                                }
                            } else {
                                throw new Exception("<h5 style='color:#000'>You are already logged in.</h5>");
                            }
                        } catch(Exception $ex) {
                            echo $ex->getMessage();
                        }
                    ?>
                </div>
                <br />
                <br />
            </div>
        </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
    <script>
      $(document).foundation();
    </script>
    </body>
</html>
<!-- @copyRights NajeemB all rights reserved -->