<?php
@ob_start();
@require_once "connect_db.php";
if (!@empty($_COOKIE['login']) and @isset($_COOKIE['login'])) {
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
    <meta name="msvalidate.01" content="A2175D7DBFD9B1668012448807EFABC8" />
    <meta name="yandex-verification" content="8f14d15b639c0950" />
    <meta name="google-site-verification" content="hdQshf8j1uYDtvJlP510U_v43vaKGE4s94haGzURKfY" />
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Vo Music | Home</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico?ri=<?php echo rand(0, 999); ?>">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css?ri=<?php echo rand(0, 999); ?>">

</head>

<body>
  <script type="text/javascript" src="js/script.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- ##### Preloader ##### -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <!-- Line -->
        <div class="line-preloader"></div>
    </div>
    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- ***** Navbar Area ***** -->
        <div class="vomusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="vomusicNav">

                        <!-- Nav brand -->
                        <a href="./index.php?ri=<?php echo rand(0, 999); ?>" class="nav-brand"><img src="img/core-img/logo.png?ri=<?php echo rand(0, 999); ?>" alt="./img/core-img/logo.png?ri=<?php echo rand(0, 999); ?>" style="width:125px !important; height:80px !important;"></a>

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
                                    <li><a href="./?ri=<?php echo rand(0, 999); ?>">Home</a></li>
                                    <!-- User's settings -->
                                    <?php
                                      if (@isset($_COOKIE['login']) and !@empty($_COOKIE['login'])) {
                                    ?>
                                    <li><a href="#"><?php echo $user; ?></a>
                                        <ul class="dropdown">
                                            <li class="active liactive"><a href="./<?php echo $user.'/?'.rand(0, 999); ?>">My Archive</a></li>
                                            <li><a href="./upload.php?ri=<?php echo rand(0, 999); ?>">Upload</a></li>
                                        </ul>
                                    </li>
                                    <li><img src="<?php echo $user_archive_p."?ri=".rand(0, 999); ?>" alt="<?php echo $user_archive_p; ?>" title="<?php echo $user; ?>" width="60" height="30" /></li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                                    <?php
                                      } else {
                                    ?>
                                    <li><a href="../signup.php?ri=<?php echo rand(0, 999); ?>">Signup</a></li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
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

    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area hero-post-slides owl-carousel">
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/1.jpg?ri=<?php echo rand(0, 999); ?>);">
            <!-- Post Content -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">Get your music & sound hosted here</h2>
                            <p data-animation="fadeInUp" data-delay="300ms">Create your archive, upload, and share your music.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (@empty($_COOKIE['login'])) { ?>
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/2.jpg?ri=<?php echo rand(0, 999); ?>);">
            <!-- Post Content -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">Register</h2>
                            <p data-animation="fadeInUp" data-delay="300ms">Sign up for a free acount and have your music & sound stored with us.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/3.jpg?ri=<?php echo rand(0, 999); ?>);">
            <!-- Post Content -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">Search music & sound</h2>
                            <p data-animation="fadeInUp" data-delay="300ms">Search for whatever music & sound you want through our archive.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/4.jpg?ri=<?php echo rand(0, 999); ?>);">
            <!-- Post Content -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">Music cloud</h2>
                            <p data-animation="fadeInUp" data-delay="300ms">Have a free and simple music cloud share experience with us.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/5.jpg?ri=<?php echo rand(0, 999); ?>);">
            <!-- Post Content -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">Subscribe and get aware of our latest music</h2>
                            <p data-animation="fadeInUp" data-delay="300ms">Get notified by email from our latest updates.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/6.jpg?ri=<?php echo rand(0, 999); ?>);">
            <!-- Post Content -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-slides-content">
                            <h2 data-animation="fadeInUp" data-delay="100ms">Download</h2>
                            <p data-animation="fadeInUp" data-delay="300ms">Choose the sound & music files you want and download them standard or as zip.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/7.jpg?ri=<?php echo rand(0, 999); ?>);">
            <!-- Post Content -->
            <div class="container">
                <div class="row">
                  <div class="col-12">
                      <div class="hero-slides-content">
                        <?php
                        if (@isset($_COOKIE['login'])) { ?>
                        <h2 data-animation="fadeInUp" data-delay="100ms">Logout</h2>
                        <p data-animation="fadeInUp" data-delay="300ms">Sign out of your account.</p>
                        <?php
                        } else { ?>
                        <h2 data-animation="fadeInUp" data-delay="100ms">Login</h2>
                        <p data-animation="fadeInUp" data-delay="300ms">Access and manage your archive.</p>
                        <?php } ?>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

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

    <!-- Search form area start -->
    <!-- ##### Search Form Area Start ##### -->
    <div class="search-form section-padding-0-100">
        <div class="container">
            <br />
            <br />
            <br />
            <div class="row">
                <!-- Section Heading -->
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Search your favorite music</h2>
                        <p>Search your music(song, audio, etc) by name, by album name, or by artist name.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Signup Form Area -->
                    <div class="search-form-area">
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="GET" id="search-form" enctype="application/x-www-form-urlencoded">
                            <div class="row">
                                <div class="col-12">
                                  <div class="input-group input-group-lg">
                                     <input type="search" class="form-control" aria-label="Search input with segmented search by dropdown" placeholder="Enter your search term" name="search-q" id="search-q" />
                                     <div class="input-group-append">
                                       <button type="submit" class="btn btn-primary vomusic-btn-search"><img src="./img/core-img/search.png" /></button>
                                       <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="sr-only">Search by</span>
                                       </button>
                                       <div class="dropdown-menu">
                                         <label class="dropdown-item">By music&nbsp;<input type="radio" name="search-by" id="search-by" value="name" checked="checked" /></label>
                                         <label class="dropdown-item">By album&nbsp;<input type="radio" name="search-by" id="search-by" value="album" /></label>
                                         <label class="dropdown-item">By artist&nbsp;<input type="radio" name="search-by" id="search-by" value="artist" /></label>
                                       </div>
                                     </div>
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
                <div class="list-group">
                <?php
                // getting all the albums and files of user
                try {
                     if (@isset($_GET['search-q']) and @isset($_GET['search-by'])) {
                         $q = @htmlentities($_GET['search-q']);
                         $sby = @htmlentities($_GET['search-by']);
                         $page = (@isset($_GET['page'])) ? @intval($_GET['page']) : 1;
                         $no_of_records_per_page = 10;
                         $offset = ($page-1) * $no_of_records_per_page;
                         $total_pages_sql = "SELECT COUNT(*) FROM `archive` WHERE `".@mysqli_real_escape_string($connection->con_link, $sby)."` LIKE '%".@mysqli_real_escape_string($connection->con_link, $q)."%'";
                         $result = @mysqli_query($connection->con_link, $total_pages_sql);
                         $total_rows = @mysqli_fetch_array($result)[0];
                         $total_pages = @ceil($total_rows / $no_of_records_per_page);
                         if ($alldateq = @mysqli_query($connection->con_link, "SELECT * FROM `archive` WHERE `".@mysqli_real_escape_string($connection->con_link, $sby)."` LIKE '%".@mysqli_real_escape_string($connection->con_link, $q)."%' ORDER BY `date_released`, `date_uploaded` DESC LIMIT $offset, $no_of_records_per_page")) {
                            if (@mysqli_num_rows($alldateq) > 0) {
                                while ($result = @mysqli_fetch_assoc($alldateq)) {
                                       $searched_column = $result[$sby];
                                       switch ($sby) {
                                           case 'name':
                                                $unsearched_columns = array("Album: ".$result['album'], "By: ".$result['artist']);
                                                break;
                                           case 'album':
                                                $unsearched_columns = array("Audio name: ".$result['name'], "By: ".$result['artist']);
                                                break;
                                           case 'artist':
                                                $unsearched_columns = array("Audio name: ".$result['name'], "Album: ".$result['album']);
                                                break;
                                           default:
                                                $unsearched_columns = array("Audio name: ".$result['name'], "Album: ".$result['album'], "By: ".$result['artist']);
                                                break;

                                       }
                                       $albuma = $result['album_artwork'];
                                       $date_released = $result['date_released'];
                                       $type = $result['type'];
                ?>
                <br />
                <a href="<?php echo $result['path'].$result['name']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo $searched_column; ?></h5>
                <img src="<?php echo $albuma; ?>" width="100" height="100" style="border-bottom-left-radius:14px;"/>
                </div>&nbsp&nbsp;
                <p class="mb-1"><?php echo $unsearched_columns[0]; ?></p>
                <p><?php echo $unsearched_columns[1]; ?></p>
                <p><?php echo "Audio type: ".$type; ?></p>
                <p><?php echo "Released on: ".$date_released; ?></p>
                </a>
                <br />
                <?php
                           }
                         } else {
                           throw new Exception("No audio files found");
                         }
                       } else {
                         throw new Exception("Error: ".@mysqli_error($connection->con_link));
                       }
                     } else {
                       $page = (@isset($_GET['page'])) ? @intval($_GET['page']) : 1;
                       $no_of_records_per_page = 10;
                       $offset = ($page-1) * $no_of_records_per_page;
                       $total_pages_sql = "SELECT COUNT(*) FROM `archive` ORDER BY `date_released`, `date_uploaded` LIMIT 6";
                       $result = @mysqli_query($connection->con_link, $total_pages_sql);
                       $total_rows = @mysqli_fetch_array($result)[0];
                       $total_pages = @ceil($total_rows / $no_of_records_per_page);
                       if ($alldateq = @mysqli_query($connection->con_link, "SELECT * FROM `archive` ORDER BY `date_released`, `date_uploaded` LIMIT 6")) {
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
                 <a href="<?php echo $afile_path.$afile_name; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                 <div class="d-flex w-100 justify-content-between">
                 <h5 class="mb-1"><?php echo $afile_name; ?></h5>
                 <img src="<?php echo $albuma; ?>" width="100" height="100" style="border-bottom-left-radius:14px;"/>
                 </div>&nbsp&nbsp;
                 <p class="mb-1"><?php echo "Album: ".$album; ?></p>
                 <p><?php echo "By: ".$artist; ?></p>
                 <p><?php echo "Audio type: ".$type; ?></p>
                 <p><?php echo "Released on: ".$date_released; ?></p>
                 </a>
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
                 </div>
               </div>
            </div>
        </div>
    </div>
    <!-- ##### Search Form Area End ##### -->
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
                        <form onSubmit="subscriber();">
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
<!-- @copyRights all rights reserved NajeemB -->
