<?php
// protecting for spam bots with captcha
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {
@ob_start();
@session_start();
@require_once "connect_db.php";
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="msvalidate.01" content="A2175D7DBFD9B1668012448807EFABC8" />
    <meta name="google-site-verification" content="Ot7digfb6ZQJppEQGIqDM2Gt2Dld4149wcyI26ZOdD8" />
    <meta name="yandex-verification" content="9b3d2af6e3081d2d" />
    <title>Chatz - Secure Checkpoint</title>
    <link rel="icon" type="image/x-icon" href="img/site_icon.ico" />
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
    <body id="secure_checkpoint_page">
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <noscript>Sorry your browser doesn't support javascript or your browser scripting might be disabled</noscript>
        <div class="row">
            <div class="large-6 medium-6 large-offset-3 medium-offset-3 columns">
            <br />
            <br />
                <h1 class="text-center"><b style="background-color:#f90; opacity:0.8;">Not a spam-bot!</b></h1>
                <br />
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <img src="img/captcha.php" id="captcha" alt="img/captcha.php" title="Secure Captcha" style="width:100%;" />
                <input type="text" name="secure" id="secure" placeholder="Type the security code above" />
                <input type="submit" value="Done" id="sb" class="button radius expand" />
                </form>
                <br />
                <div id="results">
                <?php 
                  try {
                     if (@isset($_POST['secure'])) {
                        $securein = @strip_tags($_POST['secure']);
                        if (!@empty($securein)) {
                            if ($securein == $_SESSION['secure']) {
                                $vfc = @str_shuffle("ABCDEFGHIGKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".rand(0, 5000));
                                @setcookie("sitename", @strip_tags($_GET['sitename']));
                                @setcookie("username", $_COOKIE['reg_pending'], strtotime("+ 1 year"));
                                @mysqli_query($connection->con_link, "UPDATE `users` SET `status` = 'online', `verificationc` = '".$vfc."' WHERE `username` = '".$_COOKIE['reg_pending']."'") or die("<p style='font-size:1.1em; color:#f00;'>Error updating database.<p>");

                ?>
                <h3 class="text-center" style="background-color:#f90; opacity:0.8;">Copy and save this verification code below for future uses such as account recovery, password reset, and etc.</h3>
                <br />
                <center><h4 class="text-center" id="svfc"><b style="color:#fff; word-break:break-all; word-wrap:break-word;"><code><?php echo $vfc; ?></code></b></h4></center>
                <script type="text/javascript">
                let url = window.location.href;
                let sitename = url.slice(url.indexOf("?sitename=") + 10);
                setTimeout(function() {
                           window.location.href = "./"+sitename;}, 30 * 1000);
                </script>
                <?php
                            } else {
                                throw new Exception("<h4 style='color:#f00;'>Code mismatched.</h4>");
                            }
                        } else {
                            throw new Exception("<h4 style='color:#f00;'>Please enter the captcha code.</h4>");
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
<!-- @copyRights NajeemB all rights reserved -->
<?php 
}
?>