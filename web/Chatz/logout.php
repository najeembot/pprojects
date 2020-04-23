<?php
// logging the user out
@ob_start();
@session_start();
@require_once "connect_db.php";
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {
    if (@isset($_GET['logout']) and !@empty($_GET['logout'])) {
        $logout = @strip_tags($_GET['logout']);
        $temp_uname = $_COOKIE['username'];
        if ($logout === 'site') {
            @setcookie("sitename", "", time() - 1);
            @session_destroy();
            @header("location: ./");
        } elseif ($logout === 'user') {
            @setcookie("username", "", time() - 1);
            @session_destroy();
            @mysqli_query($connection->con_link, "UPDATE `users` SET `status` = 'offline', `temp_password` = 'password' WHERE `username` = '".$temp_uname."'") or die("<p style='font-size:1.1em; color:#f00;'>Error updating database.<p>");
            @header("location: ./");
        }
    }  
}
// @copyRights NajeemB all rights reserved
?>