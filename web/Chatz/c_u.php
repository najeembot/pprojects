<?php
// setting the target chat user session
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {
   @ob_start();
   @require_once "connect_db.php";
   @session_start();
   if (@isset($_POST['chat_user']) && !@empty($_POST['chat_user'])) {
      $_SESSION['chat_user'] = @strip_tags($_POST['chat_user']);
   }
}
// @copyRights NajeemB all rights reserved
?>