<?php

// database connection class
class Db_connect extends Exception {
    public $con_link = "";
    public $meta_re = "/[-`!#$%^&*(){}':<>~?,+=\[\]\"(\\)(\/)]/i";
    public $email_re = "/^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/i";
    public $phone_re = "\/\+[0-9]{2}+[0-9]{10}\/s";
    private $ppd = "profile_pictures";
    private $atd = "attach_temp";
    private $dppd = "profile_pictures/default_profile_picture";
    private $not_allowedSiteNames = array("./site_data/", "./js/", "./css/", "./img/", "./sounds/", "./fonts/");
    public function __construct($host, $user, $pass) {
        try {
            if ($this->connect($host, $user, $pass)) {
                return true;
            } else {
                throw new Exception("Error: Couldn't connect to database. ".mysqli_error($this->con_link).$current_directory);
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
                throw new Exception("Error: Failed to select database. ".mysqli_error($this->con_link));
            }
        } catch (Exception $ex) {
            echo "<p style='font-family:Arial, Sans-serif; font-style:normal; font-size:0.9em; color:red;'>".$ex->getMessage()."</p>";
        }
    }
    public function pass_validator($pass, $details = false) {
        if (@strlen($pass) < '8') {
            $passwordErr = "Your Password Must Contain At Least 8 Characters!";
        } elseif (strlen($pass) > 50) {
            $passwordErr = "Too long password!";
        }
        elseif(!@preg_match("#[0-9]+#",$pass)) {
            $passwordErr = "Your Password Must Contain At Least 1 Number!";
        }
        elseif(!@preg_match("#[A-Z]+#",$pass)) {
            $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
        }
        elseif(!@preg_match("#[a-z]+#",$pass)) {
            $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
        } 
        elseif (@empty($pass)) {
            $passwordErr = "Please Check You've Entered Or Confirmed Your Password!";
        } else {
            $passwordErr = ($details) ? "Ok" : NULL;
        }
        if ($details) {
            return $passwordErr;
        } else {
            if (!@empty($passwordErr)) {
               return false;
            } else {
               return true;
            }
        }
    }
    public function getUserIpAddr(){
       if(!@empty($_SERVER['HTTP_CLIENT_IP'])){
          //ip from share internet
          $ip = $_SERVER['HTTP_CLIENT_IP'];
       }elseif(!@empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          //ip pass from proxy
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
       }else{
          $ip = $_SERVER['REMOTE_ADDR'];
       }
       return $ip;
    }
    public function validate_email($email){
        if(@preg_match($this->email_re, $email)){
            if(@checkdnsrr(array_pop(explode("@",$email)), "MX")){
              return true;
            } else {
              return false;
            }
        } else {
            return false;
        }   
    }
    public function shortenFn($fname) {
        if (@strpos($fname, 0, " ") >= 7 and @strpos($fname, 0, " ") <= 12) {
              $fname = @substr($fname, 0, strpos($fname, 0, " "))."...";
        } else {
              $fname = @substr($fname, 0, 9)."...";
        }
        return $fname;
    }
    public function setDIR($dirpath, $mode=0777) {
      if (!@in_array($dirpath, $this->not_allowedSiteNames)) {
        if (!@is_dir($dirpath)) {
            if (@mkdir($dirpath, $mode, true)) {
                @file_exists($dirpath."index.php") || @copy("hc.file", $dirpath."index.php");
                @is_dir($dirpath.$this->ppd) || @mkdir($dirpath.$this->ppd, $mode, true);
                @is_dir($dirpath.$this->atd) || @mkdir($dirpath.$this->atd, $mode, true);
                @is_dir($dirpath.$this->dppd) || @mkdir($dirpath.$this->dppd, $mode, true);
                @file_exists($dirpath."profile_pictures/default_profile_picture/default.jpeg") || @copy("dppc.file", $dirpath."profile_pictures/default_profile_picture/default.jpeg");
                return true;
            } else {
                return false;
            }
        } else {
            @file_exists($dirpath."index.php") || @copy("hc.file", $dirpath."index.php");
            @is_dir($dirpath.$this->ppd) || @mkdir($dirpath.$this->ppd, $mode, true);
            @is_dir($dirpath.$this->atd) || @mkdir($dirpath.$this->atd, $mode, true);
            @is_dir($dirpath.$this->dppd) || @mkdir($dirpath.$this->dppd, $mode, true);
            @file_exists($dirpath."profile_pictures/default_profile_picture/default.jpeg") || @copy("dppc.file", $dirpath."profile_pictures/default_profile_picture/default.jpeg");
            return true;
        }    
    } else {
      return false;
    }
  } 
}
$current_directory = @substr(getcwd(), strlen(getcwd()) - 6, strlen(getcwd()));
// Readding config.json file
if ($current_directory === 'htdocs') {
    $json = @file_get_contents("./site_data/backup/config.json");
} else {
    $json = @file_get_contents("../site_data/backup/config.json");
}
$json_data = @json_decode($json, true);
$database_details = $json_data['database_details'];
$connection = new Db_connect($database_details['host_name'], $database_details['username'], $database_details['password']);
$connection->db_select($connection->con_link, $database_details['database_name']);

// @copyRights NajeemB all rights reserved
?>