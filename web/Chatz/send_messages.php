<?php
// sending chat messages
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {

@ob_start();
@session_start();
@require_once "connect_db.php";


// extracting the links out of text making clickable links and putting them back to text message
function txtToLink($text)
{
    /* 
    * decoding html tags
    * replaceing the with regular expression
     */
$text = html_entity_decode($text);
$text = " ".$text;
$text= preg_replace("/(^|[\n ])([\w]*?)([\w]*?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" rel=\"nofollow\" target=\"_BLANK\" style=\"font-weight:bold; color:#008800;\">$3</a>", $text);  
$text= preg_replace("/(^|[\n ])([\w]*?)((www|wap)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" rel=\"nofollow\" target=\"_BLANK\" style=\"font-weight:bold; color:#008800;\">$3</a>", $text);
$text= preg_replace("/(^|[\n ])([\w]*?)((ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"$4://$3\" rel=\"nofollow\" target=\"_BLANK\" style=\"font-weight:bold; color:#008800;\">$3</a>", $text);  
$text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\" rel=\"nofollow\" target=\"_BLANK\" style=\"font-weight:bold; color:#008800;\">$2@$3</a>", $text);  
$text= preg_replace("/(^|[\n ])(mailto:[a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"$2@$3\" rel=\"nofollow\" target=\"_BLANK\" style=\"font-weight:bold; color:#008800;\">$2@$3</a>", $text);  
$text= preg_replace("/(^|[\n ])(skype:[^ \,\"\t\n\r<]*)/i", "$1<a href=\"$2\" rel=\"nofollow\" target=\"_BLANK\" style=\"font-weight:bold; color:#008800;\">$2</a>", $text);  
        return $text;
}

try {
    if (@isset($_SESSION['chat_user']) && !@empty($_SESSION['chat_user'])) {
         if (@isset($_POST['message']) && !@empty($_POST['message'])) {
             $message = @strip_tags($_POST['message']);
             $message = @txtToLink($message);
             $query = ($_SESSION['chat_user'] == "group_chat") ? "INSERT INTO `group_chat` (`id`, `sender`, `message`, `receiver`, `type`, `sent_on`) VALUES (NULL, '".$_COOKIE['username']."', '".@mysqli_real_escape_string($connection->con_link, stripslashes($message))."', '".$_SESSION['chat_user']."', 'text_message', NOW())" : "INSERT INTO `messages` (`id`, `sender`, `message`, `receiver`, `type`, `sent_on`) VALUES (NULL, '".$_COOKIE['username']."', '".@mysqli_real_escape_string($connection->con_link, stripslashes($message))."', '".$_SESSION['chat_user']."', 'text_message', NOW())";
             $log_query = "INSERT INTO `latest_message_log` (`id`, `sender`, `receiver`, `time_sent`) VALUES (NULL, '".$_COOKIE['username']."', '".$_SESSION['chat_user']."', NOW())";
             // updating messages and message log table
             if (@mysqli_query($connection->con_link, $query) && @mysqli_query($connection->con_link, $log_query)) {
                echo "<span id='scm'>Sent successfully.</span>";
             } else {
                throw new Exception("<span id='scm' style='color:#f00;'>Database error occured while sending message.</span>");
             }
         } else {
            throw new Exception("<span id='scm'>Please type in your message.</span>");
         }
    } else {
        throw new Exception("<span id='scm'>Please select a user.</span>");
    }
} catch(Exception $ex) {
    echo $ex->getMessage();
}
}
?>