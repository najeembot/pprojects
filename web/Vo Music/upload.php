<?php
@ob_start();
@require_once "connect_db.php";
if (@empty($_COOKIE['login']) and !@isset($_COOKIE['login'])) {
    @header("location: ./login.php?ri=".rand(0,999));
} else {
    $user = $_COOKIE['login'];
}

function setAlbumArtwork($files, $path, $alName) {
  try {
    $albuma_name = $files['name'];
    $albuma_tmpName = $files['tmp_name'];
    $albuma_type = $files['type'];
    $albuma_size = $files['size'];
    $albuma_calculated_size = ($sphoto_size / 1024) / 1024;
    $albuma_error = $files['error'];
    $albumn = $alName;
    if (@is_uploaded_file($albuma_tmpName)) {
      if ($albuma_calculated_size <= 10) {
          switch ($albuma_type) {
              case 'image/jpeg':
                   $current_img = @imagecreatefromjpeg($albuma_tmpName);
                   @imagejpeg($current_img, $path.$albumn.".jpg");
                   @imagedestroy($current_img);
                   return $path.$albumn.".jpg";
                   break;
              case 'image/png':
                   $current_img = @imagecreatefrompng($albuma_tmpName);
                   @imagejpeg($current_img, $path.$albumn.".jpg");
                   @imagedestroy($current_img);
                   return $path.$albumn.".jpg";
                   break;
              case 'image/gif':
                   $current_img = @imagecreatefromgif($albuma_tmpName);
                   @imagejpeg($current_img, $path.$albumn.".jpg");
                   @imagedestroy($current_img);
                   return $path.$albumn.".jpg";
                   break;
              case 'image/bmp':
                   $current_img = @imagecreatefrombmp($albuma_tmpName);
                   @imagejpeg($current_img, $path.$albumn.".jpg");
                   @imagedestroy($current_img);
                   return $path.$albumn.".jpg";
                   break;
              default:
                   throw new Exception("Error: album artwork type must be *PNG, JPG, JPEG, GIF, and BMP*");
                   break;
          }
        } else {
           throw new Exception("Error: album artwork size can not be more then 10 MB");
        }
      } else {
        throw new Exception("Error: album artwork can be only uploaded via HTTP POST");
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
    <!-- The above 4 meta tags *must* come first in the head any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Vo Music | Upload</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico?ri=<?php echo rand(0, 999); ?>">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css?ri=<?php echo rand(0, 999); ?>">

</head>
<body id="upload_page" style="background-color:#ff0;">
  <script type="text/javascript" src="./js/script.js?ri=<?php echo rand(0, 999); ?>"></script>
    <!-- ##### Upload Form Area Start ##### -->
    <div class="upload-form section-padding-0-100">
        <div class="container">
            <br />
            <br />
            <br />
            <div class="row">
                <!-- Section Heading -->
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Upload your audios</h2>
                        <p>Album artwork is an optional field</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Upload Form Area -->
                    <div class="upload-form-area">
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="upload-form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="upload-albumn">Album Name:</label>
                                        <input type="text" class="form-control" id="upload-albumn" name="upload-albumn" placeholder="Enter the album name" value="<?php echo (@isset($_POST['upload-albumn'])) ? $_POST['upload-albumn'] : ''; ?>" list="albums">
                                        <datalist id="albums">
                                        <?php
                                        if ($albums_query = @mysqli_query($connection->con_link, "SELECT DISTINCT `album` FROM `archive` WHERE `uploaded_by` = '".mysqli_real_escape_string($connection->con_link, $user)."'")) {
                                           while ($albums = @mysqli_fetch_assoc($albums_query)) {
                                        ?>
                                           <option><?php echo $albums['album']; ?></option>
                                        <?php
                                           }
                                        } else {
                                           throw new Exception("Error: database error while getting albums");
                                        }
                                        ?>
                                        </datalist>
                                    </div>
                                    <div class="form-group">
                                        <label for="upload-artistn">Artist Name:</label>
                                        <input type="text" class="form-control" id="upload-artistn" name="upload-artistn" placeholder="Enter the artist name" value="<?php echo (@isset($_POST['upload-artistn'])) ? $_POST['upload-artistn'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="upload-dater">Date Released:</label>
                                        <input type="date" class="form-control" id="upload-dater" name="upload-dater" placeholder="Enter the release date" value="<?php echo (@isset($_POST['upload-dater'])) ? $_POST['upload-dater'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="upload-albuma">Album Artwork:</label>
                                        <input type="file" class="form-control" name="upload-albuma" id="upload-albuma" placeholder="Choose your album artwork" value="<?php echo (@isset($_POST['upload-albuma'])) ? $_POST['upload-albuma'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="upload-audiofile">Audio File:</label>
                                        <input type="file" class="form-control" name="upload-audiofile" id="upload-audiofile" placeholder="Choose your audio file" value="<?php echo (@isset($_POST['upload-audiofile'])) ? $_POST['upload-audiofile'] : ''; ?>">
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="submit" class="btn btn-block vomusic-btn mt-15" id="upload-submit" name="upload-submit" value="Upload">
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
                // process the upload
                if (@isset($_POST['upload-submit'])) {
                    $albumn = @htmlentities($_REQUEST['upload-albumn']);
                    $artistn = @htmlentities($_REQUEST['upload-artistn']);
                    $datetime = new DateTime($_REQUEST['upload-dater']);
                    $dater = $datetime->format("Y-m-d H:i:s");
                    $albuma_error = $_FILES['upload-albuma']['error'];
                    $audiofile_name = $_FILES['upload-audiofile']['name'];
                    $audiofile_tmpName = $_FILES['upload-audiofile']['tmp_name'];
                    $allowed = array('audio/mpeg', 'audio/x-mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/aiff', 'audio/mid', 'audio/x-aiff',                                         'audio/x-mpequrl','audio/midi', 'audio/x-mid', 
                                     'audio/x-midi','audio/wav','audio/x-wav','audio/xm','audio/x-aac','audio/basic',
                                     'audio/flac','audio/mp4','audio/x-matroska','audio/ogg','audio/s3m','audio/x-ms-wax',
                                     'application/octet-stream',
                                     'audio/xm'
                               );
                    // checking REAL MIME type
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $audiofile_type = finfo_file($finfo, $audiofile_tmpName);
                    finfo_close($finfo);
                    $audiofile_size = $_FILES['upload-audiofile']['size'];
                    $audiofile_error = $_FILES['upload-audiofile']['error'];
                    if (!@empty($albumn) and !@empty($artistn) and !@empty($dater) and $audiofile_error <= 0) {
                        $sphoto_ext = @substr($sphoto_name, (strripos($sphoto_name, ".")), strlen($sphoto_name));
                        $audiofile_calculated_size = ($sphoto_size / 1024) / 1024;
                        $path = "./".$user."/albums/".$albumn."/";
                        $current_albuma = $path.$albumn.".jpg";
                        if (@file_exists($path) or @mkdir($path, 0777, true)) {
                           if (@is_uploaded_file($audiofile_tmpName)) {
                             if ($audiofile_calculated_size <= 30) {
                               // check to see if REAL MIME type is inside $allowed array
                               if (@in_array($audiofile_type, $allowed)) {
                                 if (@file_exists($path.$audiofile_name) or @move_uploaded_file($audiofile_tmpName, $path.$audiofile_name)) {
                                  if (!@file_exists($current_albuma) or @unlink($current_albuma)) {
                                   if ($albuma_error <= 0) {
                                       $aa_path = setAlbumArtwork($_FILES['upload-albuma'], $path, $albumn);
                                   } else {
                                       if (@file_exists($path.$albumn.".jpg") or @copy("./default_albumartwork.jpg", $path.$albumn.".jpg")) {
                                           $aa_path = $path.$albumn.".jpg";
                                       } else {
                                           throw new Exception("Error: could not setup default album artwork");
                                       }
                                   }
                                   $query = "INSERT INTO `archive` (`id`, `name`, `type`, `path`, `album`, `album_artwork`, `artist`, `date_released`, `date_uploaded`, `uploaded_by`) VALUES (NULL, '".$audiofile_name."', '".$audiofile_type."', '".$path."', '".$albumn."', '".$aa_path."', '".$artistn."', '".$dater."', NOW(), '".$user."')";
                                   if (@mysqli_query($connection->con_link, $query)) {
                                       $connection->notifySubscribers($user, $albumn, $audiofile_name, $path.$audiofile_name);
                                       echo "<h6>Uploaded successfully</h6>";
                                   } else {
                                       throw new Exception("Error: ".@mysqli_error($connection->con_link));
                                   }
                                  } else {
                                     throw new Exception("Error: could not remove old album artwork");
                                  }
                                 } else {
                                   throw new Exception("Error: could not upload audio file");
                                 }
                           } else {
                             throw new Exception("Audio Files' type must only be *MP3, OGG, WAV, AAC, 3GP, 3GP2, WEBM, OPUS, and etc*");
                           }
                         } else {
                           throw new Exception("Audio Files' size can not be more then 30 MB");
                         }
                       } else {
                         throw new Exception("File must be uploaded via HTTP POST method");
                       }
                     } else {
                       throw new Exception("Could not setup album's directory");
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
    <!-- ##### Upload Form Area End ##### -->

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
                            <p><!-- copyright NajeemB all rights reserved -->
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
