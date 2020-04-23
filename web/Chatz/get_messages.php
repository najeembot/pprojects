<center>
<?php
// getting all messages 
@ob_start();
@session_start();
@require_once "connect_db.php";
try {
    if (@isset($_SESSION['chat_user']) && !@empty($_SESSION['chat_user'])) {
        if ($_SESSION['chat_user'] == "group_chat") {
            $messages_query = ($_SESSION['chat_user'] == "group_chat") ? "SELECT * FROM `group_chat`" : "SELECT * FROM `messages` WHERE (`sender` = '".$_COOKIE['username']."' AND `receiver` = '".$_SESSION['chat_user']."') OR (`receiver` = '".$_COOKIE['username']."' AND `sender` = '".$_SESSION['chat_user']."')";
    if ($m_query_run = @mysqli_query($connection->con_link, $messages_query)) {
        while ($m_query_row = @mysqli_fetch_assoc($m_query_run)) {
            $mType = $m_query_row['type'];
            $mSender = $m_query_row['sender'];
            $mReceiver = $m_query_row['receiver'];
            $mSentOn = $m_query_row['sent_on'];
            $mMessage = $m_query_row['message'];
            if ($mType == "text_message") {
            
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_nm_fname = $sender_nm_sd['full_name'];
?>
<p class="sender_f_n"><?php echo $sender_nm_fname; ?></p>
<div class="message">
    <?php
    echo $mMessage;
    ?>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} else {
?>
<div class="i_received">
<?php
$receiver_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$mSender."'"));
$receiver_nm_fname = $receiver_nm_sd['full_name'];
?>
<p class="receiver_f_n"><?php echo $receiver_nm_fname; ?></p>
<div class="message">
    <?php
    echo $mMessage;
    ?>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "image/jpeg" || $mType == "image/png" || $mType == "image/gif" || $mType == "image/bmp" || $mType == "image/psd" || $mType == "image/xbm" || $mType == "image/iff" || $mType == "image/tiff" || $mType == "image/jp2" || $mType == "image/vnd.wap.wbmp" || $mType == "application/x-shockwave-flash" || $mType == "image/x-icon" || $mType == "application/octet-stream") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_nm_fname = $sender_nm_sd['full_name'];
?>
<p class="sender_f_n"><?php echo $sender_nm_fname; ?></p>
<div class="message">
    <img class="images_link_icon" src="<?php echo $mMessage; ?>" alt="<?php echo $mMessage; ?>" />
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} else {
?>
<div class="i_received">
<?php
$receiver_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$mSender."'"));
$receiver_nm_fname = $receiver_nm_sd['full_name'];
?>
<p class="receiver_f_n"><?php echo $receiver_nm_fname; ?></p>
<div class="message">
    <img class="images_link_icon" src="<?php echo $mMessage; ?>" alt="<?php echo $mMessage; ?>" />
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "application/pdf") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_nm_fname = $sender_nm_sd['full_name'];
?>
<p class="sender_f_n"><?php echo $sender_nm_fname; ?></p>
<div class="message">
    <a class="pdf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="pdf_link_icon" src="../img/pdf_icon.png" alt="../img/pdf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="pdf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} else {
?>
<div class="i_received">
<?php
$receiver_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$mSender."'"));
$receiver_nm_fname = $receiver_nm_sd['full_name'];
?>
<p class="receiver_f_n"><?php echo $receiver_nm_fname; ?></p>
<div class="message">
    <a class="pdf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="pdf_link_icon" src="../img/pdf_icon.png" alt="../img/pdf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="pdf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "application/msword") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_nm_fname = $sender_nm_sd['full_name'];
?>
<p class="sender_f_n"><?php echo $sender_nm_fname; ?></p>
<div class="message">
    <a class="wdocf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wdocf_link_icon" src="../img/wdocf_icon.png" alt="../img/wdocf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wdocf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} else {
?>
<div class="i_received">
<?php
$receiver_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$mSender."'"));
$receiver_nm_fname = $receiver_nm_sd['full_name'];
?>
<p class="receiver_f_n"><?php echo $receiver_nm_fname; ?></p>
<div class="message">
    <a class="wdocf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wdocf_link_icon" src="../img/wdocf_icon.png" alt="../img/wdocf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wdocf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_nm_fname = $sender_nm_sd['full_name'];
?>
<p class="sender_f_n"><?php echo $sender_nm_fname; ?></p>
<div class="message">
    <a class="wdocxf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wdocxf_link_icon" src="../img/wdocxf_icon.png" alt="../img/wdocxf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wdocxf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} else {
?>
<div class="i_received">
<?php
$receiver_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$mSender."'"));
$receiver_nm_fname = $receiver_nm_sd['full_name'];
?>
<p class="receiver_f_n"><?php echo $receiver_nm_fname; ?></p>
<div class="message">
    <a class="wdocxf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wdocxf_link_icon" src="../img/wdocxf_icon.png" alt="../img/wdocxf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wdocxf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php 
            } elseif ($mType == "text/plain") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_nm_fname = $sender_nm_sd['full_name'];
?>
<p class="sender_f_n"><?php echo $sender_nm_fname; ?></p>
<div class="message">
    <a class="textf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="textf_link_icon" src="../img/textf_icon.png" alt="../img/textf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="textf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} else {
?>
<div class="i_received">
<?php
$receiver_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$mSender."'"));
$receiver_nm_fname = $receiver_nm_sd['full_name'];
?>
<p class="receiver_f_n"><?php echo $receiver_nm_fname; ?></p>
<div class="message">
    <a class="textf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="textf_link_icon" src="../img/textf_icon.png" alt="../img/textf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="textf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "audio/mp3") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_nm_fname = $sender_nm_sd['full_name'];
?>
<p class="sender_f_n"><?php echo $sender_nm_fname; ?></p>
<div class="message">
    <a class="mp3f_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="mp3f_link_icon" src="../img/mp3f_icon.png" alt="../img/mp3f_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="mp3f_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} else {
?>
<div class="i_received">
<?php
$receiver_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$mSender."'"));
$receiver_nm_fname = $receiver_nm_sd['full_name'];
?>
<p class="receiver_f_n"><?php echo $receiver_nm_fname; ?></p>
<div class="message">
    <a class="mp3f_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="mp3f_link_icon" src="../img/mp3f_icon.png" alt="../img/mp3f_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="mp3f_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "audio/wav") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_nm_fname = $sender_nm_sd['full_name'];
?>
<p class="sender_f_n"><?php echo $sender_nm_fname; ?></p>
<div class="message">
    <a class="wavf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wavf_link_icon" src="../img/wavf_icon.png" alt="../img/wavf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wavf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} else {
?>
<div class="i_received">
<?php
$receiver_nm_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$mSender."'"));
$receiver_nm_fname = $receiver_nm_sd['full_name'];
?>
<p class="receiver_f_n"><?php echo $receiver_nm_fname; ?></p>
<div class="message">
    <a class="wavf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wavf_link_icon" src="../img/wavf_icon.png" alt="../img/wavf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wavf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php 
                    }
                 }
               }
    } else {
        throw new Exception("An error occured while retrieving messages from database.");
    }
        } else {
           $messages_query = ($_SESSION['chat_user'] == "group_chat") ? "SELECT * FROM `group_chat`" : "SELECT * FROM `messages` WHERE (`sender` = '".$_COOKIE['username']."' AND `receiver` = '".$_SESSION['chat_user']."') OR (`receiver` = '".$_COOKIE['username']."' AND `sender` = '".$_SESSION['chat_user']."')";
    if ($m_query_run = @mysqli_query($connection->con_link, $messages_query)) {
        while ($m_query_row = @mysqli_fetch_assoc($m_query_run)) {
            $mType = $m_query_row['type'];
            $mSender = $m_query_row['sender'];
            $mReceiver = $m_query_row['receiver'];
            $mSentOn = $m_query_row['sent_on'];
            $mMessage = $m_query_row['message'];
            if ($mType == "text_message") {
            
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_p_img = $sender_pp_sd['p_link'];
$sender_p_fname = $sender_pp_sd['full_name'];
?>
<img class="sender_p_p" src="<?php echo $sender_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $sender_p_img; ?>" title="<?php echo $sender_p_fname; ?>" />
<div class="message">
    <?php
    echo $mMessage;
    ?>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} elseif ($mSender == $_SESSION['chat_user']) {
?>
<div class="i_received">
<?php
$receiver_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_SESSION['chat_user']."'"));
$receiver_p_img = $receiver_pp_sd['p_link'];
$receiver_p_fname = $receiver_pp_sd['full_name'];
?>
<img class="receiver_p_p" src="<?php echo $receiver_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $receiver_p_img; ?>" title="<?php echo $receiver_p_fname; ?>" />
<div class="message">
    <?php
    echo $mMessage;
    ?>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "image/jpeg" || $mType == "image/png" || $mType == "image/gif" || $mType == "image/bmp" || $mType == "image/psd" || $mType == "image/xbm" || $mType == "image/iff" || $mType == "image/tiff" || $mType == "image/jp2" || $mType == "image/vnd.wap.wbmp" || $mType == "application/x-shockwave-flash" || $mType == "image/x-icon" || $mType == "application/octet-stream") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_p_img = $sender_pp_sd['p_link'];
$sender_p_fname = $sender_pp_sd['full_name'];
?>
<img class="sender_p_p" src="<?php echo $sender_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $sender_p_img; ?>" title="<?php echo $sender_p_fname; ?>" />
<div class="message">
    <img class="images_link_icon" src="<?php echo $mMessage; ?>" alt="<?php echo $mMessage; ?>" />
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} elseif ($mSender == $_SESSION['chat_user']) {
?>
<div class="i_received">
<?php
$receiver_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_SESSION['chat_user']."'"));
$receiver_p_img = $receiver_pp_sd['p_link'];
$receiver_p_fname = $receiver_pp_sd['full_name'];
?>
<img class="receiver_p_p" src="<?php echo $receiver_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $receiver_p_img; ?>" title="<?php echo $receiver_p_fname; ?>" />
<div class="message">
    <img class="images_link_icon" src="<?php echo $mMessage; ?>" alt="<?php echo $mMessage; ?>" />
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "application/pdf") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_p_img = $sender_pp_sd['p_link'];
$sender_p_fname = $sender_pp_sd['full_name'];
?>
<img class="sender_p_p" src="<?php echo $sender_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $sender_p_img; ?>" title="<?php echo $sender_p_fname; ?>" />
<div class="message">
    <a class="pdf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="pdf_link_icon" src="../img/pdf_icon.png" alt="../img/pdf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="pdf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} elseif ($mSender == $_SESSION['chat_user']) {
?>
<div class="i_received">
<?php
$receiver_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_SESSION['chat_user']."'"));
$receiver_p_img = $receiver_pp_sd['p_link'];
$receiver_p_fname = $receiver_pp_sd['full_name'];
?>
<img class="receiver_p_p" src="<?php echo $receiver_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $receiver_p_img; ?>" title="<?php echo $receiver_p_fname; ?>" />
<div class="message">
    <a class="pdf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="pdf_link_icon" src="../img/pdf_icon.png" alt="../img/pdf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="pdf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "application/msword") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_p_img = $sender_pp_sd['p_link'];
$sender_p_fname = $sender_pp_sd['full_name'];
?>
<img class="sender_p_p" src="<?php echo $sender_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $sender_p_img; ?>" title="<?php echo $sender_p_fname; ?>" />
<div class="message">
    <a class="wdocf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wdocf_link_icon" src="../img/wdocf_icon.png" alt="../img/wdocf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wdocf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} elseif ($mSender == $_SESSION['chat_user']) {
?>
<div class="i_received">
<?php
$receiver_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_SESSION['chat_user']."'"));
$receiver_p_img = $receiver_pp_sd['p_link'];
$receiver_p_fname = $receiver_pp_sd['full_name'];
?>
<img class="receiver_p_p" src="<?php echo $receiver_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $receiver_p_img; ?>" title="<?php echo $receiver_p_fname; ?>" />
<div class="message">
    <a class="wdocf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wdocf_link_icon" src="../img/wdocf_icon.png" alt="../img/wdocf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wdocf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_p_img = $sender_pp_sd['p_link'];
$sender_p_fname = $sender_pp_sd['full_name'];
?>
<img class="sender_p_p" src="<?php echo $sender_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $sender_p_img; ?>" title="<?php echo $sender_p_fname; ?>" />
<div class="message">
    <a class="wdocxf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wdocxf_link_icon" src="../img/wdocxf_icon.png" alt="../img/wdocxf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wdocxf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} elseif ($mSender == $_SESSION['chat_user']) {
?>
<div class="i_received">
<?php
$receiver_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_SESSION['chat_user']."'"));
$receiver_p_img = $receiver_pp_sd['p_link'];
$receiver_p_fname = $receiver_pp_sd['full_name'];
?>
<img class="receiver_p_p" src="<?php echo $receiver_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $receiver_p_img; ?>" title="<?php echo $receiver_p_fname; ?>" />
<div class="message">
    <a class="wdocxf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wdocxf_link_icon" src="../img/wdocxf_icon.png" alt="../img/wdocxf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wdocxf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php 
            } elseif ($mType == "text/plain") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_p_img = $sender_pp_sd['p_link'];
$sender_p_fname = $sender_pp_sd['full_name'];
?>
<img class="sender_p_p" src="<?php echo $sender_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $sender_p_img; ?>" title="<?php echo $sender_p_fname; ?>" />
<div class="message">
    <a class="textf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="textf_link_icon" src="../img/textf_icon.png" alt="../img/textf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="textf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} elseif ($mSender == $_SESSION['chat_user']) {
?>
<div class="i_received">
<?php
$receiver_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_SESSION['chat_user']."'"));
$receiver_p_img = $receiver_pp_sd['p_link'];
$receiver_p_fname = $receiver_pp_sd['full_name'];
?>
<img class="receiver_p_p" src="<?php echo $receiver_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $receiver_p_img; ?>" title="<?php echo $receiver_p_fname; ?>" />
<div class="message">
    <a class="textf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="textf_link_icon" src="../img/textf_icon.png" alt="../img/textf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="textf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "audio/mp3") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_p_img = $sender_pp_sd['p_link'];
$sender_p_fname = $sender_pp_sd['full_name'];
?>
<img class="sender_p_p" src="<?php echo $sender_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $sender_p_img; ?>" title="<?php echo $sender_p_fname; ?>" />
<div class="message">
    <a class="mp3f_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="mp3f_link_icon" src="../img/mp3f_icon.png" alt="../img/mp3f_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="mp3f_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} elseif ($mSender == $_SESSION['chat_user']) {
?>
<div class="i_received">
<?php
$receiver_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_SESSION['chat_user']."'"));
$receiver_p_img = $receiver_pp_sd['p_link'];
$receiver_p_fname = $receiver_pp_sd['full_name'];
?>
<img class="receiver_p_p" src="<?php echo $receiver_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $receiver_p_img; ?>" title="<?php echo $receiver_p_fname; ?>" />
<div class="message">
    <a class="mp3f_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="mp3f_link_icon" src="../img/mp3f_icon.png" alt="../img/mp3f_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="mp3f_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
}
?>
<?php
            } elseif ($mType == "audio/wav") {
?>
<?php
if ($mSender == $_COOKIE['username']) {
?>
<div class="i_sent">
<?php
$sender_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_COOKIE['username']."'"));
$sender_p_img = $sender_pp_sd['p_link'];
$sender_p_fname = $sender_pp_sd['full_name'];
?>
<img class="sender_p_p" src="<?php echo $sender_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $sender_p_img; ?>" title="<?php echo $sender_p_fname; ?>" />
<div class="message">
    <a class="wavf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wavf_link_icon" src="../img/wavf_icon.png" alt="../img/wavf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wavf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php
} elseif ($mSender == $_SESSION['chat_user']) {
?>
<div class="i_received">
<?php
$receiver_pp_sd = @mysqli_fetch_assoc(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".$_SESSION['chat_user']."'"));
$receiver_p_img = $receiver_pp_sd['p_link'];
$receiver_p_fname = $receiver_pp_sd['full_name'];
?>
<img class="receiver_p_p" src="<?php echo $receiver_p_img.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $receiver_p_img; ?>" title="<?php echo $receiver_p_fname; ?>" />
<div class="message">
    <a class="wavf_link" target="_blank" href="<?php echo $mMessage; ?>"><img class="wavf_link_icon" src="../img/wavf_icon.png" alt="../img/wavf_icon.png" title="<?php echo @substr($mMessage, 12); ?>" /></a>
    <p class="wavf_name"><?php echo @substr($mMessage, 12); ?></p>
</div>
<div class="sent_on">
    <?php
    echo "Sent on ".$mSentOn;
    ?>
</div>
</div>
<br />
<?php 
                    }
                 }
               }
    } else {
        throw new Exception("An error occured while retrieving messages from database.");
    }
    }
    } else {
?>
<style type="text/css">
div#main_communication_holder 
{
   background-image: url(../img/chat_no_user.jpg) !important;
   background-position: center;
   background-size:cover;
   background-repeat: no-repeat;
}
</style>
<?php
    }
} catch(Exception $ex) {
    echo "<p style='font-family:Arial, sans-serif; font-size:2em; color:#f00; text-align:center;'>".$ex->getMessage()."</p>";
}
?>
<!-- @copyRights NajeemB all rights reserved -->
</center>