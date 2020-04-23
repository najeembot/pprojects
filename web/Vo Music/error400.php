<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Vo Music | Error400</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico?ri=<?php echo rand(0, 999); ?>">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css?ri=<?php echo rand(0, 999); ?>">

</head>

<body style="background-image:url('./img/bg-img/12.jpg'); background-size:cover; background-repeat:no-repeat; background-position:center; background-attachment:clip;">

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- ***** Navbar Area ***** -->
        <div class="vomusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="vomusicNav">
                        <!-- Nav brand -->
                        <a href="./index.php?ri=<?php echo rand(0, 999); ?>" class="nav-brand"><img src="img/core-img/logo.png?ri=<?php echo rand(0, 999); ?>" alt="./img/core-img/logo.png" style="width:125px !important; height:80px !important;"></a>
                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>
                        <!-- Menu -->
                        <div class="classy-menu">
                            <!-- close btn -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>
                            <div class="classynav">
                                <ul>
                                    <li><a href="./?ri=<?php echo rand(0, 999); ?>">Home</a></li>
                                    <?php
                                      if (@!isset($_COOKIE['login']) and @empty($_COOKIE['login'])) {
                                    ?>
                                    <li><a href="./signup.php?ri=<?php echo rand(0, 999); ?>">Signup</a></li>
                                    <?php
                                      }
                                    ?>
                                </ul>
                                <!-- Login Logout Button -->
                                <?php
                                  if (@isset($_COOKIE['login']) and !@empty($_COOKIE['login'])) {
                                ?>
                                <a href="./logout.php?ri=<?php echo rand(0, 999); ?>" class="btn vomusic-btn header-btn">Logout</a>
                                <?php
                                  } else {
                                ?>
                                <a href="./login.php?ri=<?php echo rand(0, 999); ?>" class="btn vomusic-btn header-btn">Login</a>
                                <?php
                                  }
                                ?>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- ***** Navbar Area ***** -->
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- fb root section area Start ##### -->
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <section>
      <h2 style="color:#fff;" class="text-center">Error 400 Bad Request</h2>
    </section>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <!-- fb section area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <!-- Main Footer Area -->
        <div class="main-footer-area">
            <div class="container">
                <div class="row">
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
                            <!-- Link back to najeemb can't be removed. Template is licensed under CC BY 3.0. -->
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
