<?php
// checking for duplication of usernames
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {
@ob_start();
@session_start();
@require_once "connect_db.php";
try {
    if (@isset($_POST['ucheck'])) {
        $ucheck = @strip_tags($_POST['ucheck']);
        if (!@empty($ucheck)) {
            if ($UCquery = @mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".@mysqli_real_escape_string($connection->con_link, $ucheck)."'") or $ECquery = @mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `email` = '".@mysqli_real_escape_string($connection->con_link, $echeck)."'")) {
                if (@mysqli_num_rows($UCquery) > 0 or @mysqli_num_rows($ECquery) > 0) {
                    echo "exists";
                } elseif ($ucheck == "group_chat" or @preg_match($connection->meta_re, $ucheck) == 1) {
					echo "invalid";
				} else {
                    echo "not_exists";
                }
            } else {
                throw new Exception("Database error while checking username.");
            }
        }
    } elseif (@isset($_POST['echeck'])) {
        $echeck = @strip_tags($_POST['echeck']);
        if (!@empty($echeck)) {
            if ($ECquery = @mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `email` = '".@mysqli_real_escape_string($connection->con_link, $echeck)."'")) {
                if (@mysqli_num_rows($ECquery) > 0) {
                    echo "exists";
                } elseif ($connection->validate_email($echeck) === false) {
					echo "invalid";
				} else {
                    echo "not_exists";
                }
            } else {
                throw new Exception("Database error while checking username.");
            }
        }
    } elseif (@isset($_POST['pcheck'])) {
        $pcheck = @strip_tags($_POST['pcheck']);
        if (!@empty($pcheck)) {
            echo $connection->pass_validator($pcheck, true);
        } else {
            throw new Exception("Empty parameter.");
        }
    }
} catch(Exception $ex) {
    echo $ex->getMessage();
}
}
?>