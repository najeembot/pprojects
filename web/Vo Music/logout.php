<?php
// logging the user out
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./?ri=".rand(0, 999));
} else {
    @ob_start();
    @setcookie("login", "", time() - 1);
    @header("location: ".$_SERVER['HTTP_REFERER']."?ri=".rand(0, 999));
}
// @copyRights NajeemB all rights reserved
?>
