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
    <title>Chatz - Login</title>
    <link rel="icon" type="image/x-icon" href="img/site_icon.ico" />
    <link rel="stylesheet" href="css/foundation.css?ec=1" />
    <link rel="stylesheet" href="css/style.css?ec=1" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="js/script.js?ec=1"></script>
  </head>
<?php
if (@isset($_COOKIE['sitename']) && @isset($_COOKIE['username'])) {
    @header("location: ./".$_COOKIE['sitename']);
}
if (!@isset($_COOKIE['sitename']) and @empty($_COOKIE['sitename'])) {
?>
  <body id="enter_page">
     <div class="row">
      <div class="large-8 medium-8 large-offset-2 medium-offset-2 columns">
                <br />
                <h1 id="enter_chatfor_logo" class="text-center"><b>Chatz</b></h1>
                <img src="img/login_site_logo.png" id="site_enter_logo" />
                <h4 id="enter_title" class="text-center">Choose Your Site</h4><br />
                <form id="enter_form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <label>Chatz/sitename: 
                    <input type="text" name="sitename" list="sites" maxlength="50" placeholder=" Enter sitename here " required id="sitename" class="radius" />
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
                    </label>
                    <label>Username: 
                    <input type="text" name="username" maxlength="50" placeholder=" Enter username here " required id="username" class="radius" />
                    </label>
                    <br />
                    <input type="submit" value="Enter" id="enter_button" class="button expand radius" />
                </form>
                <br />
                <div id="enter_results">
                    <?php
                        if (@isset($_POST['sitename']) && @isset($_POST['username'])) {
                            // user data variables
                            $sitename = @strip_tags($_POST['sitename']);
                            $username = @strip_tags($_POST['username']);
                            if (@!empty($sitename) and @!empty($username)) {
                                $enter_query = "SELECT `site` FROM `users` WHERE `site` = '".@mysqli_real_escape_string($connection->con_link, $sitename)."' AND `username` = '".@mysqli_real_escape_string($connection->con_link, $username)."'";
                                if ($query_run = @mysqli_query($connection->con_link, $enter_query)) {
                                    if (@mysqli_num_rows($query_run) > 0) {
                                        @setcookie("sitename", $sitename, strtotime("+ 1 year"));
                                        @setcookie("temp", $username, strtotime("+ 1 year"));
                                        @header("location: ./");
                                    } else {
                                        echo "<p style='font-size:1em;'>Invalid username@sitename.</p>";
                                    }
                                } else {
                                    echo "<p style='font-size:1em; color:#f00;'>Error while querying database.</p>".mysqli_error($connection->con_link);
                                }
                            } else {
                                echo "<p style='font-size:1em;'>All fields are required.</p>";
                            }
                        }
                    ?>
                </div>
                <br />
                <hr />
                <br />
                <a href="/signup.php" id="signup_link" style="font-size: 18px; font-weight: bold; color:#ff9000 !important;">Not yet registered</a>
                <br />
                <br />
                <br />
     </div>
    </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
<?php
} elseif (!@isset($_COOKIE['username']) and @empty($_COOKIE['username'])) {
?>
  <body id="login_page">
     <div class="row">
       <div class="large-3 medium-3 large-offset-9 medium-offset-9 columns">
           <ul class="breadcrumbs">
  <li><a href="./logout.php?logout=site">Change site</a></li>
  <li class="current"><a href="#"><b style="color:#f90;"><?php echo $_COOKIE['sitename']; ?></b></a></li>
</ul>
       </div>
     </div>
     <div class="row">
      <div class="large-8 medium-8 large-offset-2 medium-offset-2 columns">
                <br />
                <h1 id="login_chatfor_logo" class="text-center"><b>Chatz</b></h1>
                <img src="img/login_site_logo.png" id="site_login_logo" />
                <h4 id="login_title" class="text-center">Login Here</h4><br />
                <form id="login_form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <label>Login password:
                    <input type="password" name="password" maxlength="50" placeholder=" Enter password here " required id="password" class="radius" />
                    </label>
                    <br />
                    <br />
                    <input type="submit" value="Login" id="login_button" class="button expand radius" />
                </form>
                <br />
                <div id="login_results">
                    <?php
                        if (@isset($_POST['password'])) {
                            // user data variables
                            $password = @md5(strip_tags($_POST['password']));
                            $username = $_COOKIE['temp'];
                            $sitename = $_COOKIE['sitename'];
                            if (@!empty($password)) {
                                $login_query = "SELECT `username` FROM `users` WHERE `username` = '".$username."' AND `password` = '".@mysqli_real_escape_string($connection->con_link, $password)."'";
                                if ($query_run = @mysqli_query($connection->con_link, $login_query)) {
                                    if (@mysqli_num_rows($query_run) > 0) {
                                        @setcookie("username", $username, strtotime("+ 1 year"));
                                        @header("location: ./".$sitename);
                                    } else {
                                        echo "<p style='font-size:1em;'>Please enter the correct password.</p>";
                                    }
                                } else {
                                    echo "<p style='font-size:1em; color:#f00;'>Error while querying database.</p>".mysqli_error($connection->con_link);
                                }
                            } else {
                                echo "<p style='font-size:1em;'>Please enter your password.</p>";
                            }
                        }
                    ?>
                </div>
                <br />
                <hr />
                <br />
                <a href="/pass_reset.php" id="forgotp_link" style="font-size: 18px; font-weight:bolder; color:#fff;">Forgot password</a>
                <br />
                <br />
                <br />
     </div>
    </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
<?php
} else {
    @header("location: ./".$_COOKIE['sitename']);
}
?>
  <!-- @copyRights NajeemB all rights reserved -->
</html>
	