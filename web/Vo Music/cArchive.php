<?php
@ob_start();
@require_once "../connect_db.php";
if (@empty($_COOKIE['login']) and !@isset($_COOKIE['login'])) {
    @header("location: ../login.php");
} else {
    $user = $_COOKIE['login'];
    if ($user_data_query = @mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `full_name` = '".$user."'")) {
        $user_archive_p = "../".@mysqli_fetch_assoc($user_data_query)['archive_photo'];
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
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Vo Music | My Archive</title>

    <!-- Favicon -->
    <link rel="icon" href="../img/core-img/favicon.ico?ri=<?php echo rand(0, 999); ?>">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="../style.css?ri=<?php echo rand(0, 999); ?>">

</head>

<body>
  <script type="text/javascript" src="../js/script.js?ri=<?php echo rand(0, 999); ?>"></script>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- ***** Navbar Area ***** -->
        <div class="vomusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="vomusicNav">

                        <!-- Nav brand -->
                        <a href="../index.php?ri=<?php echo rand(0, 999); ?>" class="nav-brand"><img src="../img/core-img/logo.png?ri=<?php echo rand(0, 999); ?>" alt="../img/core-img/logo.png" style="width:125px !important; height:80px !important;"></a>

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

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="../?ri=<?php echo rand(0, 999); ?>">Home</a></li>
                                    <li><a href="#"><?php echo $user; ?></a>
                                        <ul class="dropdown">
                                            <li class="active liactive"><a href="./?ri=<?php echo rand(0, 999); ?>">My Archive</a></li>
                                            <li><a href="../upload.php?ri=<?php echo rand(0, 999); ?>">Upload</a></li>
                                        </ul>
                                    </li>
                                    <li><img src="<?php echo '../'.$user_archive_p."?ri=".rand(0, 999); ?>" alt="<?php echo $user_archive_p; ?>" title="<?php echo $user; ?>" width="60" height="30" /></li>&nbsp&nbsp;
                                    <?php
                                      if (@!isset($_COOKIE['login']) and @empty($_COOKIE['login'])) {
                                    ?>
                                    <li><a href="../signup.php?ri=<?php echo rand(0, 999); ?>">Signup</a></li>
                                    <?php
                                      }
                                    ?>
                                </ul>

                                <!-- Login Logout Button -->
                                <?php
                                  if (@isset($_COOKIE['login']) and !@empty($_COOKIE['login'])) {
                                ?>
                                <a href="../logout.php?ri=<?php echo rand(0, 999); ?>" class="btn vomusic-btn header-btn">Logout</a>
                                <?php
                                  } else {
                                ?>
                                <a href="../login.php?ri=<?php echo rand(0, 999); ?>" class="btn vomusic-btn header-btn">Login</a>
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


    <!-- Modals -->
    <div class="modal fade" id="subscriberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="subscriberModalLabel">Subscription</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <div class="align-self-center mx-auto">
                <button type="button" class="btn btn-primary text-center" onClick="javascript:$('#subscriberModal').modal('hide');">Ok</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ##### Albums Area Start ##### -->
    <br />
    <br />
    <div class="container">
      <div class="row allign-items-center">
        <div class="col-12">
        <br />
        <div class="clearfix"></div>
        <?php
        // getting all the albums and files of user
        try {
           if (!@empty($_COOKIE['login'])) {
               $user = $_COOKIE['login'];
               $page = (@isset($_GET['page'])) ? @intval($_GET['page']) : 1;
               $no_of_records_per_page = 10;
               $offset = ($page-1) * $no_of_records_per_page;
               $total_pages_sql = "SELECT COUNT(*) FROM `archive` WHERE `uploaded_by` = '".$user."'";
               $result = @mysqli_query($connection->con_link, $total_pages_sql);
               $total_rows = @mysqli_fetch_array($result)[0];
               $total_pages = @ceil($total_rows / $no_of_records_per_page);
               if ($alldateq = @mysqli_query($connection->con_link, "SELECT * FROM `archive` WHERE `uploaded_by` = '".$user."' ORDER BY `date_uploaded`, `date_released` ASC LIMIT $offset, $no_of_records_per_page")) {
                 if (@mysqli_num_rows($alldateq) > 0) {
                   while ($result = @mysqli_fetch_assoc($alldateq)) {
                          $afile_name = $result['name'];
                          $afile_path = $result['path'];
                          $album = $result['album'];
                          $albuma = $result['album_artwork'];
                          $artist = $result['artist'];
                          $date_released = $result['date_released'];
                          $type = $result['type'];
        ?>
        <br />
        <div class="media">
        <img class="mr-3 align-self-center" src="<?php echo '../'.$albuma."?ri=".rand(0, 999); ?>" alt="<?php echo $albuma; ?>" width="100" height="100" style="border-radius:5px;">
        <div class="media-body">
        <h4 class="mt-0 mb-1"><?php echo "Album: ".$album; ?></h4>
        <h5 class="mt-0 mb-1"><?php echo "By: ".$artist; ?></h5>
        <a href="<?php echo '../'.$afile_path.$afile_name.'?ri='.rand(0, 999); ?>" title="Download" class="text-primary"><?php echo $afile_name; ?></a>
        <h6><?php echo "Released on: ".$date_released; ?></h6>
        </div>
        </div>
        <br />
        <?php
                   }
                 } else {
                   throw new Exception("No audio files found");
                 }
               } else {
                 throw new Exception("Error: ".@mysqli_error($connection->con_link));
               }
           }
        } catch(Exception $ex) {
        ?>
        <br />
        <br />
        <div class="row">
        <div class="col-12">
          <h3 class="text-center"><?php echo $ex->getMessage(); ?></h3>
        </div>
        </div>
        <br />
        <br />
        <?php
        }
        if ($total_rows > $no_of_records_per_page) {
        ?>
        <br />
        <br />
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item <?php if ($page <= 1) {echo 'disabled';} ?>"><a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=1"; } ?>" class="<?php if ($page > 1) {echo 'text-info';} ?>">First</a></li>
            <li class="breadcrumb-item <?php if ($page <= 1) {echo 'disabled';} ?>"><a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>" class="<?php if ($page > 1) {echo 'text-info';} ?>">Prev</a></li>
            <li class="breadcrumb-item <?php if($page >= $total_pages){ echo 'disabled'; } ?>" aria-current="page"><a href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>" class="<?php if ($page < $total_pages) {echo 'text-info';} ?>">Next</a></li>
            <li class="breadcrumb-item <?php if ($page >= $total_pages) {echo 'disabled';} ?>"><a href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".$total_pages; } ?>" class="<?php if ($page < $total_pages) {echo 'text-info';} ?>">Last</a></li>
          </ol>
        </nav>
        <?php
        }
        ?>
        <div class="clearfix"></div>
        <br />
        </div>
      </div>
    </div>
    <br />
    <br />
    <!-- ##### Albums Area End ##### -->

    <!-- ##### Subscribe Area Start ##### -->
    <section class="subscribe-area">
        <div class="container">
            <div class="row align-items-center">
                <!-- Subscribe Text -->
                <div class="col-12 col-lg-6">
                    <div class="subscribe-text">
                      <h3>Subscribe and get updates</h3>
                      <h6>Get notified by email from our latest music updates</h6>
                    </div>
                </div>
                <!-- Subscribe Form -->
                <div class="col-12 col-lg-6">
                    <div class="subscribe-form text-right">
                        <form onSubmit="subscriber(event);">
                            <input type="email" name="subscribe-email" id="subscribeEmail" placeholder="Your Email">
                            <button type="submit" class="btn vomusic-btn">subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Subscribe Area End ##### -->

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
    <script src="../js/jquery/jquery-2.2.4.min.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- Popper js -->
    <script src="../js/bootstrap/popper.min.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- Bootstrap js -->
    <script src="../js/bootstrap/bootstrap.min.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- All Plugins js -->
    <script src="../js/plugins/plugins.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- Active js -->
    <script src="../js/active.js?ri=<?php echo rand(0, 999); ?>"></script>
</body>

</html>
