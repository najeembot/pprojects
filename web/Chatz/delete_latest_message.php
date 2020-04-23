<?php
/* @copyRights NajeemB
   all rights reserved
*/
// deleting the latest received message from log
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {
    @ob_start();
    @session_start();
    @require_once "connect_db.php";
    @mysqli_query($connection->con_link, "UPDATE `latest_message_log` SET `sender` = '', `receiver` = '', `time_sent` = ''") || exit("Error updating message log table.");
}
?>