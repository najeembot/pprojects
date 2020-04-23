<?php
// sending chat attachments
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {

@ob_start();
@session_start();
@require_once "connect_db.php";

@header('Content-Type: text/plain; charset=utf-8');

try {
   if (@isset($_SESSION['chat_user']) and !@empty($_SESSION['chat_user'])) {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treating it invalid.
    if (
        !@isset($_FILES['attach']['error']) ||
        @is_array($_FILES['attach']['error'])
    ) {
        throw new RuntimeException("<span id='scm' style='color:#f00;'>Invalid parameters.</span>");
    }

    // Checking $_FILES['attach']['error'] value.
    switch ($_FILES['attach']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException("<span id='scm' style='color:#f00;'>No file sent.</span>");
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException("<span id='scm'>Exceeded filesize limit.</span>");
        default:
            throw new RuntimeException("<span id='scm' style='color:#f00;'>Unknown errors.<span>");
    }

    // checking filesize here.
    $attach_calculated_size = ($_FILES['attach']['size'] / 1024) / 1024;
    if ($attach_calculated_size >= 8) {
        throw new RuntimeException("<span id='scm'>Exceeded filesize limit.</span>");
    }

    // NOT TRUSTING $_FILES['attach']['mime'] VALUE !!
    // Check MIME Type by my self.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = @array_search(
        $finfo->file($_FILES['attach']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'psd' => 'image/psd',
            'ico' => 'image/x-icon',
            'iff' => 'image/iff',
            'tiff' => 'image/tiff',
            'swf' => 'application/x-shockwave-flash',
            'swc' => 'application/x-shockwave-flash',
            'wbmp' => 'image/vnd.wap.wbmp',
            'xbm' => 'image/xbm',
            'jp2' => 'image/jp2',
            'jpc' => 'application/octet-stream'
        ),
        true
    )) {
        throw new RuntimeException("<span id='scm'>Invalid file format.</span>");
    }

    // naming it uniquely.
    // obtaining safe unique name from its binary data.
    $attach_path = @sprintf('./attach_temp/%s.%s', sha1_file($_FILES['attach']['tmp_name']), $ext);
    if (!@move_uploaded_file(
        $_FILES['attach']['tmp_name'],
        $attach_temp_path = @sprintf('./'.$_COOKIE['sitename'].'/attach_temp/%s.%s',
            sha1_file($_FILES['attach']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException("<span id='scm' style='color:#f00;'>Failed to move sent file.</span>");
    }
    // updating database upon successfull upload
    
    $attach_type = $_FILES['attach']['type'];
    $query = ($_SESSION['chat_user'] == "group_chat") ? "INSERT INTO `group_chat` (`id`, `sender`, `message`, `receiver`, `type`, `sent_on`) VALUES (NULL, '".$_COOKIE['username']."', '".$attach_path."', '".$_SESSION['chat_user']."', '".$attach_type."', NOW())" : "INSERT INTO `messages` (`id`, `sender`, `message`, `receiver`, `type`, `sent_on`) VALUES (NULL, '".$_COOKIE['username']."', '".$attach_path."', '".$_SESSION['chat_user']."', '".$attach_type."', NOW())";
    $log_query = "INSERT INTO `latest_message_log` (`id`, `sender`, `receiver`, `time_sent`) VALUES (NULL, '".$_COOKIE['username']."', '".$_SESSION['chat_user']."', NOW())";
    if (!@mysqli_query($connection->con_link, $query) or !@mysqli_query($connection->con_link, $log_query)) {
    	throw new RuntimeException("<span id='scm' style='color:#f00;'>Database error occured while sending file.</span>");  
    }
    echo "<span id='scm'>Sent successfully.</span>";

} else {
        throw new RuntimeException("<span id='scm'>Please select a user.</span>");
}

} catch (RuntimeException $ex) {

    echo $ex->getMessage();

}
}
// @copyRights all rights reserved
?>