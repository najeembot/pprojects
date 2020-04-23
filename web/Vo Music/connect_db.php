<?php

// database connection class
class Db_connect extends Exception {
    public $con_link = "";
    public function __construct($host, $user, $pass) {
        try {
            if ($this->connect($host, $user, $pass)) {
                return true;
            } else {
                throw new Exception("Error: Couldn't connect to database. ".@mysqli_error($this->con_link));
            }
        } catch (Exception $ex) {
            echo "<p style='font-family:Arial, Sans-serif; font-style:normal; font-size:0.9em; color:red;'>".$ex->getMessage()."</p>";
        }
    }
    public function connect($host, $user, $pass) {
        if ($this->con_link = @mysqli_connect($host, $user, $pass)) {
            return true;
        } else {
            return false;
        }
    }

    public function db_select($link, $db_name) {
        try {
            if (@mysqli_select_db($link, $db_name)) {
                return true;
            } else {
                throw new Exception("Error: Failed to select database. ".@mysqli_error($this->con_link));
            }
        } catch (Exception $ex) {
            echo "<p style='font-family:Arial, Sans-serif; font-style:normal; font-size:0.9em; color:red;'>".$ex->getMessage()."</p>";
        }
    }
    public function udValidator($data, $type) {
     if ($type === 'echeck') {
        $echeck = $data;
        if (!@empty($echeck)) {
            if ($ECquery = @mysqli_query($this->con_link, "SELECT * FROM `users` WHERE `email` = '".@mysqli_real_escape_string($this->con_link, $echeck)."'")) {
                if (@mysqli_num_rows($ECquery) > 0) {
                    return false;
                } else {
                    return true;
                }
            } else {
                throw new Exception("Database error while checking email");
            }
        } else {
           throw new Exception("Empty parameter");
        }
      } elseif ($type === 'pcheck') {
        $pcheck = $data;
        if (!@empty($pcheck)) {
          if (@!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/", $pcheck)) {
              return false;
          } else {
              return true;
          }
        } else {
            throw new Exception("Empty parameter");
        }
      }
    }
    public function notifySubscribers($notifier, $albumn, $audiofn, $audiofp) {
      $body = <<<EOD
        <html lang="en">
        <head>
        <title>Vo Music | Notification</title>
        <link rel="stylesheet" type="text/css" href="http://www.vomusic.cf/style.css" />
        <link rel="icon" href="http://www.vomusic.cf/img/core-img/favicon.ico" />
        </head>
        <body style="background-color:#5271FF; padding:8px;">
        <div class="row">
        <div class="col-4"><h1 style="color:#fff;">Vo Music</h1></div>
        <div class="col-4"><img src="http://www.vomusic.cf/img/core-img/logo.png" alt="./img/core-img/logo.png" title="Vo Music" style="width:300px; height:300px; border-top-right-radius:9px; -moz-border-top-right-radius:9px; -webkit-border-top-right-radius:9px; -o-border-top-right-radius:9px; -ms-border-top-right-radius:9px; border-bottom-right-radius:9px; -moz-border-bottom-right-radius:9px; -webkit-border-bottom-right-radius:9px; -o-border-bottom-right-radius:9px; -ms-border-bottom-right-radius:9px;"/></div>
        </div>
        <div class="row">
        <div class="col-3" style="color#fff;"><h2>{$notifier} has uploaded new music</h2></div>
        </div>
        <div class="row">
        <div class="col-6" style="color:#E9E9E9;">
        <h3><p>Album Name: {$albumn}<br /><a href="http://www.vomusic.cf/{$audiofp}" alt="http://www.vomusic.cf/{$audiofp}" title="{$audiofn}">{$audiofn}</a></p></h3>
        </div>
        </div>
        </body>
        </html>
      EOD;
      // the Content-type header for HTML mail
      $subject = 'Notification';
      $headers = "From: No reply\r\n";
      $headers .= "Reply-To: noreply@vomusic.cf.ml\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset: ISO-8859-1\r\n";
      $subscribers = @mysqli_query($this->con_link, "SELECT * FROM `subscribed` ORDER BY `id`");
      if (@mysqli_num_rows($subscribers) > 0) {
          while ($subscriber = @mysqli_fetch_assoc($subscribers)) {
                 $to = $subscriber['email'];
                 if (@mail($to, $subject, $body, $headers)) {
                     return true;
                 } else {
                     throw new Exception("Error: failed to notify the subscriber");
                 }
          }
      }
    }
}
$connection = new Db_connect('sql210.unaux.com', 'unaux_25289364', 'uetxepvqw');
$connection->db_select($connection->con_link, 'unaux_25289364_vomusic');

// @copyRights NajeemB all rights reserved
?>
