<ul class="side-nav text-justify" role="navigation" id="user_search_query_results">
<?php
// retrieving the chat users list
@ob_start();
@require_once "connect_db.php";
@session_start();
try {
    if (@isset($_GET['user_search_query']) && !@empty($_GET['user_search_query'])) {
        $userSearchQuery = @strip_tags($_POST['user_search_query']);
        if ($query_run = @mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `full_name` LIKE '%".@mysqli_real_escape_string($connection->con_link, stripslashes($userSearchQuery))."%' AND `site` = '".$_COOKIE['sitename']."' AND `username` <> '".$_COOKIE['username']."'")) {
           if (@mysqli_num_rows($query_run) > 0) {
            while ($query_row = @mysqli_fetch_assoc($query_run)) {
                $Uname = $query_row['username'];
                $Fname = $query_row['full_name'];
                $Plink = $query_row['p_link'];
                $Ron = $query_row['registered_on'];
                $Uid = $query_row['id'];
?>
<li role="menuitem" class='each-user' id="<?php echo $Uname; ?>" onclick="select_targetc_user(this); clearTimeout(gcu);" data-id="<?php echo $Uid; ?>" title="<?php echo $Fname."\nRegistered on: ".$Ron; ?>"><a>
<img src="<?php echo $Plink.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $Plink; ?>" />&nbsp;<?php
echo $Fname; ?>
<?php
if (@isset($_SESSION['chat_user'])) {
    if ($_SESSION['chat_user'] == $Uname) {
?>
&nbsp;<img src="../img/check.png" class="chat-user-added" alt="../img/check.png" />
<?php
    }
}
?>
</a>
</li>
<?php
          }
?>
<li role="menuitem" class="each-user" id="group_chat" onclick="select_targetc_user(this); group_chat_update();" data-id="group" title="Join group chat">
<a><img src="../img/gc.png" alt="../img/gc.png" />&nbsp;Group Chat
<?php
if (@isset($_SESSION['chat_user'])) {
    if ($_SESSION['chat_user'] == "group_chat") {
?>
&nbsp;<img src="../img/check.png" class="chat-user-added" alt="../img/check.png" />
<?php
    }
}
?>
</a>
</li>
<?php
           } else {
             throw new Exception("<br /><br /><h5 class='text-center' style='color:black;'>No users found.</h5>");
           }
        } else {
            throw new Exception("<br /><br /><h5 class='text-center' style='color:red;'>Error while retrieving users data.</h5>");
        }
        
    } else {
        if ($query_run = @mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `site` = '".$_COOKIE['sitename']."' AND `username` <> '".$_COOKIE['username']."' ORDER BY `id` DESC LIMIT 50")) {
          if (@mysqli_num_rows($query_run) > 0) {
            while ($query_row = @mysqli_fetch_assoc($query_run)) {
                $Uname = $query_row['username'];
                $Fname = $query_row['full_name'];
                $Plink = $query_row['p_link'];
                $Ron = $query_row['registered_on'];
                $Uid = $query_row['id'];
?>
<li role="menuitem" class='each-user' id="<?php echo $Uname; ?>" onclick="select_targetc_user(this); clearTimeout(gcu);" data-id="<?php echo $Uid; ?>" title="<?php echo $Fname."\nRegistered on: ".$Ron; ?>"><a>
<img src="<?php echo $Plink.'?id='.strrev(rand(0, 100).str_shuffle('abcdefghijklmnopqrstufwxyz')); ?>" alt="<?php echo $Plink; ?>" />&nbsp;<?php
echo $Fname; ?>
<?php
if (@isset($_SESSION['chat_user'])) {
    if ($_SESSION['chat_user'] == $Uname) {
?>
&nbsp;<img src="../img/check.png" class="chat-user-added" alt="../img/check.png" />
<?php
    }
}
?>
</a>
</li>
<br />
<?php
            }
?>
<li role="menuitem" class="each-user" id="group_chat" onclick="select_targetc_user(this); group_chat_update();" data-id="group" title="Join group chat">
<a><img src="../img/gc.png" alt="../img/gc.png" />&nbsp;Group Chat
<?php
if (@isset($_SESSION['chat_user'])) {
    if ($_SESSION['chat_user'] == "group_chat") {
?>
&nbsp;<img src="../img/check.png" class="chat-user-added" alt="../img/check.png" />
<?php
    }
}
?>
</a>
</li>
<?php
           } else {
             throw new Exception("<br /><br /><h5 class='text-center' style='color:black;'>No users.</h5>");
           }
        } else {
            throw new Exception("<br /><br /><h5 class='text-center' style='color:red;'>Error while retrieving users data.</h5>");
        }
    }
} catch(Exception $ex) {
    echo $ex->getMessage();
}
?>
</ul>
<!-- @copyRights NajeemB all rights reserved -->