<?php
@ob_start();
@session_start();
@require_once "connect_db.php";
// storing subscribed visitors
try {
 if (@isset($_REQUEST['subscribe-email'])) {
    $subscriber = @htmlentities($_REQUEST['subscribe-email']);
    if ($subscribers = @mysqli_query($connection->con_link, "SELECT * FROM `subscribed` WHERE `email` = '".@mysqli_real_escape_string($connection->con_link, $subscriber)."'")) {
        if (@mysqli_num_rows($subscribers) > 0) {
            throw new Exception("Email already exists in susbscribers list");
         } else {
            if (@mysqli_query($connection->con_link, "INSERT INTO `subscribed` (`id`, `email`, `date_subscribed`) VALUES (NULL, '".@mysqli_real_escape_string($connection->con_link, $subscriber)."', NOW())")) {
                echo "You have successfully subscribed to our music updates";
            } else {
                throw new Exception("Error occured: ".@mysqli_error($connection->con_link));
            }
         }
    } else {
         throw new Exception("Error: ".@mysqli_error($connection->con_link));
    }
 }
} catch(Exception $ex) {
   echo $ex->getMessage();
}
?>
