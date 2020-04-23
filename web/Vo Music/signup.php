<?php
@ob_start();
@require_once "connect_db.php";
if (!@empty($_COOKIE['login']) and @isset($_COOKIE['login'])) {
    @header("location: ".$_SERVER['HTTP_REFERER']."?ri=".rand(0,999));
}
function setArchivePhoto($files, $path) {
  try {
    $aphoto_name = $files['name'];
    $aphoto_tmpName = $files['tmp_name'];
    $aphoto_type = $files['type'];
    $aphoto_size = $files['size'];
    $aphoto_calculated_size = ($sphoto_size / 1024) / 1024;
    $aphoto_error = $files['error'];
    if (@is_uploaded_file($aphoto_tmpName)) {
      if ($aphoto_calculated_size <= 10) {
          switch ($aphoto_type) {
              case 'image/jpeg':
                   $current_img = @imagecreatefromjpeg($aphoto_tmpName);
                   @imagejpeg($current_img, $path."archive_photo_.jpg");
                   @imagedestroy($current_img);
                   return $path."archive_photo_.jpg";
                   break;
              case 'image/png':
                   $current_img = @imagecreatefrompng($aphoto_tmpName);
                   @imagejpeg($current_img, $path."archive_photo_.jpg");
                   @imagedestroy($current_img);
                   return $path."archive_photo_.jpg";
                   break;
              case 'image/gif':
                   $current_img = @imagecreatefromgif($aphoto_tmpName);
                   @imagejpeg($current_img, $path."archive_photo_.jpg");
                   @imagedestroy($current_img);
                   return $path."archive_photo_.jpg";
                   break;
              case 'image/bmp':
                   $current_img = @imagecreatefrombmp($aphoto_tmpName);
                   @imagejpeg($current_img, $path."archive_photo_.jpg");
                   @imagedestroy($current_img);
                   return $path."archive_photo_.jpg";
                   break;
              default:
                   throw new Exception("Error: archive photo type must be *PNG, JPG, JPEG, GIF, and BMP*");
                   break;
          }
        } else {
           throw new Exception("Error: archive photo size can not be more then 10 MB");
        }
      } else {
        throw new Exception("Error: archive photo can be only uploaded via HTTP POST");
      }
  } catch(Exception $ex) {
     echo "<h4>".$ex->getMessage()."</h4>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="msvalidate.01" content="A2175D7DBFD9B1668012448807EFABC8" />
    <meta name="yandex-verification" content="8f14d15b639c0950" />
    <meta name="google-site-verification" content="hdQshf8j1uYDtvJlP510U_v43vaKGE4s94haGzURKfY" />
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
    <!-- ##### Signup Form Area Start ##### -->
    <div class="signup-form section-padding-0-100">
        <div class="container">
            <br />
            <br />
            <br />
            <div class="row">
                <!-- Section Heading -->
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Create an account</h2>
                        <p>Your email address will not be published. Required fields are marked.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Signup Form Area -->
                    <div class="signup-form-area">
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="signup-form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="signup-name">Full Name*:</label>
                                        <input type="text" class="form-control" id="signup-name" name="signup-name" placeholder="Enter your full name here" value="<?php if (@isset($_POST['signup-name'])) { echo $_POST['signup-name'];} ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="signup-email">Email*:</label>
                                        <input type="email" class="form-control" id="signup-email" name="signup-email" placeholder="someone@somedomain.com" value="<?php if (@isset($_POST['signup-email'])) { echo $_POST['signup-email'];} ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="signup-password">Password*:</label>
                                        <input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Enter your password here" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="signup-password">Confirm Password*:</label>
                                        <input type="password" class="form-control" id="signup-conpassword" name="signup-conpassword" placeholder="Reenter your password here" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="signup-photo">Account Photo*:</label>
                                        <input type="file" class="form-control" name="signup-photo" id="signup-photo" placeholder="Choose a background photo for your archive" value="<?php if (@isset($_POST['signup-photo'])) { echo $_POST['signup-photo'];} ?>">
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="submit" class="btn btn-block vomusic-btn mt-15" id="signup-submit" name="signup-submit" value="Signup">
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
                // process the signup
                if (@isset($_POST['signup-submit'])) {
                    $fname = @htmlentities($_REQUEST['signup-name']);
                    $email = @htmlentities($_REQUEST['signup-email']);
                    $password = @htmlentities($_REQUEST['signup-password']);
                    $conpassword = @htmlentities($_REQUEST['signup-conpassword']);
                    $aphoto_error = $_FILES['signup-photo']['error'];
                    if (!@empty($fname) and !@empty($email) and !@empty($password) and !@empty($conpassword)) {
                        if ($connection->udValidator($email, 'echeck')) {
                            if ($connection->udValidator($password, 'pcheck')) {
                                if (@strcasecmp($password, $conpassword) == 0) {
                                    $password = @md5($password);
                                    $path = "./".$fname."/";
                                    if (@file_exists($path) or @mkdir($path, 0777, true)) {
                                       if (@file_exists($path."index.php") or @copy("./cArchive.php", $path."index.php")) {
                                          // checking if it is default profile photo or uploading profile photo
                                          if ($aphoto_error <= 0) {
                                            if ($aphoto = setArchivePhoto($_FILES['signup-photo'], $path)) {
                                                $query = "INSERT INTO `users` VALUES (NULL, '".@mysqli_real_escape_string($connection->con_link, $fname)."', '".@mysqli_real_escape_string($connection->con_link, $email)."', '".@mysqli_real_escape_string($connection->con_link, $password)."', '".$aphoto."', NOW())";
                                            } else {
                                                throw new Exception("Error: could not setup archive photo");
                                            }
                                          } else {
                                            if (@file_exists($path."archive_photo_.jpg") or @copy("./cDefaultProfilePhoto.jpg", $path."archive_photo_.jpg")) {
                                                $aphoto = $path."archive_photo_.jpg";
                                                $query = "INSERT INTO `users` VALUES (NULL, '".@mysqli_real_escape_string($connection->con_link, $fname)."', '".@mysqli_real_escape_string($connection->con_link, $email)."', '".@mysqli_real_escape_string($connection->con_link, $password)."', '".$aphoto."', NOW())"; 
                                            } else {
                                                throw new Exception("Error: could not setup archive photo");
                                            }
                                          }
                                          if (@mysqli_query($connection->con_link, $query)) {
                                              echo "<h6>Signed up successfully</h6>";
                                              @setcookie("login", $fname, strtotime("+ 1 year"));
                                          ?>
                                              <script type="text/javascript">
                                                setTimeout(function() {window.location = "<?php echo "./".$fname."/?ri=".rand(0,999); ?>";}, 4000);
                                              </script>
                                          <?php
                                          } else {
                                             throw new Exception("Error: ".@mysqli_error($connection->con_link));
                                          }
                                         } else {
                                           throw new Exception("Error: couldn't setup user files");
                                         }
                                    } else {
                                      throw new Exception("Error: couldn't create user directory");
                                    }
                               } else {
                                   throw new Exception("Passwords do not match");
                               }
                            } else {
                             throw new Exception("Your password must contain at least 8 characters (1 number, 1 uppercase letter, 1 lowercase letter, and 1 symbol)");
                           }
                         } else {
                            throw new Exception("Email address already exists");
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
    <!-- ##### Signup Form Area End ##### -->

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
