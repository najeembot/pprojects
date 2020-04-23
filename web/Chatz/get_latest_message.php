<?php
// getting the latest message from log table
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {
@ob_start();
@require_once "connect_db.php";
@session_start();
@header("Content-type:text/xml");
echo "<?xml version='1.0' encoding='utf-8' standalone='yes'?>";
echo "<response>";
try {
    $query = "SELECT * FROM `latest_message_log` WHERE `receiver` = '".$_COOKIE['username']."' ORDER BY `id` DESC LIMIT 1";
    if ($query_run = @mysqli_query($connection->con_link, $query)) {
        $query_row = @mysqli_fetch_assoc($query_run);
        $sender = $query_row['sender'];
        $receiver = $query_row['receiver'];
        if ($queryfn_run = @mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$sender."'")) {
            $queryfn_row = @mysqli_fetch_assoc($queryfn_run);
            $senderFname = $queryfn_row['full_name'];
            echo "<senderFname>".$senderFname."</senderFname>";
        } else {
            throw new Exception("Error occured while obtaining sender full name.");
        }
        echo "<sender>".$sender."</sender>";
        echo "<receiver>".$receiver."</receiver>";
    } else {
        throw new Exception("Error occured while checking new messages.");
    }
} catch(Exception $ex) {
    echo "<error>";
    echo $ex->getMessage();
    echo "</error>";
}
echo "</response>";
}
/* @copyRights NajeemB all rights reserved */
?>