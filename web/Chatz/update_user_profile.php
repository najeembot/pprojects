<?php
// code for asynchronous user profile table update
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {
@ob_start();
@session_start();
@require_once "connect_db.php";

// uploading new profile picture and removing the old one

function updateProfilePicture($profilePic, $username, $oldPath) 
{
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treating it invalid.
    if (
        !@isset($profilePic['error']) ||
        @is_array($profilePic['error'])
    ) {
        throw new Exception("<h4><p class='im-error text-center'>Invalid parameters.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
    }

    // Checking $profilePic['error'] value.
    switch ($profilePic['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new Exception("<h4><p class='im-error text-center'>No file sent.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new Exception("<h4><p class='j-error text-center'>Exceeded filesize limit.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
        default:
            throw new Exception("<h4><p class='im-error text-center'>Unknown errors.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
    }

    // checking filesize here.
    $attach_calculated_size = ($profilePic['size'] / 1024) / 1024;
    if ($attach_calculated_size >= 8) {
        throw new Exception("<h4><p class='j-error text-center'>Exceeded filesize limit.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
    }

    // NOT TRUSTING $profilePic['mime'] VALUE !!
    // Check MIME Type by my self.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = @array_search(
        $finfo->file($profilePic['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ),
        true
    )) {
        throw new Exception("<h4><p class='j-error text-center'>File type should only be (jpg, png, or gif).</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
    }

    // processing the picture replace 
    if (@strcasecmp($oldPath, "./profile_pictures/default_profile_picture/default.jpeg") != 0) {
        if (@file_exists($oldPath)) {
            if (!@unlink($oldPath)) {
                throw new Exception("<h4><p class='im-error text-center'>Error removing old picture.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
            } 
        } 
    }

    // naming it uniquely.
    // obtaining safe unique name from its binary data.
    if (!@move_uploaded_file($profilePic['tmp_name'], $new_path = @sprintf('./profile_pictures/%s.%s', sha1_file($profilePic['tmp_name']), $ext))) {
        throw new Exception("<h4><p class='im-error text-center'>Failed to move uploaded file.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
    }

    return $new_path;
}

// updating the user profile 
try {
    if (@isset($_COOKIE['username']) && !@empty($_COOKIE['username'])) {
        if (@isset($_POST['edit_name']) and @isset($_POST['edit_username']) and @isset($_POST['edit_password']) and @isset($_POST['edit_email']) and @isset($_POST['edit_phone']) and @isset($_POST['edit_sex'])) {
            // defining important variables
            $ename = @strip_tags($_POST['edit_name']);
            $eusername = @strip_tags($_POST['edit_username']);
            $epassword = @strip_tags($_POST['edit_password']);
            $etpassword = @strrev(rand(0, 9).$epassword.rand(0, 9));
            $eemail = @strip_tags($_POST['edit_email']);
            $ephone = @strip_tags($_POST['edit_phone']);
            $esex = @strip_tags($_POST['edit_sex']);
            $enc_epass = @md5($epassword);
            if (!@empty($ename) and !@empty($eusername) and !@empty($epassword) and !@empty($eemail) and !@empty($ephone) and !@empty($esex)) {
                // validations
                if (@preg_match($connection->meta_re, $ename) != 1) {
                    if ($connection->validate_email($eemail)) {
                       if (@preg_match($connection->phone_re, $ephone) != 1) {
                           if ($esex == "male" || $esex == "female" || $esex == "other") {
                              if ($eusername == $_COOKIE['username'] || @mysqli_num_rows(mysqli_query($connection->con_link, "SELECT * FROM `users` WHERE `username` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."'")) <= 0) {
                                if ($eusername != "group_chat" and @preg_match($connection->meta_re, $eusername) != 1) {
                                 if ($connection->pass_validator($epassword)) {
                                    if (@isset($_FILES['edit_pp']['tmp_name']) && !@empty($_FILES['edit_pp']['tmp_name'])) {
                                        $oldpath = @strip_tags($_POST['old_picture']);
                                        $newpath = @updateProfilePicture($_FILES['edit_pp'], $eusername, $oldpath);
                                        $update_query = "UPDATE `users` SET `full_name` = '".mysqli_real_escape_string($connection->con_link, $ename)."', `sex` = '".$esex."', `email` = '".@mysqli_real_escape_string($connection->con_link, $eemail)."', `phone` = '".@mysqli_real_escape_string($connection->con_link, $ephone)."', `username` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."', `password` = '".@mysqli_real_escape_string($connection->con_link, $enc_epass)."', `temp_password` = '".$etpassword."', `p_link` = '".$newpath."' WHERE `username` = '".$_COOKIE['username']."'";
                                      
                                    } elseif (@isset($_POST['if_default_picture']) && @$_POST['if_default_picture'] == "true") {
                                      $oldpath = @strip_tags($_POST['old_picture']);
                                      $newpath = "./profile_pictures/default_profile_picture/default.jpeg";
                                      $update_query = "UPDATE `users` SET `full_name` = '".mysqli_real_escape_string($connection->con_link, $ename)."', `sex` = '".$esex."', `email` = '".@mysqli_real_escape_string($connection->con_link, $eemail)."', `phone` = '".@mysqli_real_escape_string($connection->con_link, $ephone)."', `username` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."', `password` = '".@mysqli_real_escape_string($connection->con_link, $enc_epass)."', `temp_password` = '".$etpassword."', `p_link` = '".$newpath."' WHERE `username` = '".$_COOKIE['username']."'";
                                      if (@strcasecmp($oldpath, "./profile_pictures/default_profile_picture/default.jpeg") != 0) {
                                          if (@file_exists($oldpath)) {
                                              @unlink($oldpath) or exit("<h4><p class='im-error text-center'>Error while removing old picture.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
                                          }
                                      }
                                    } else {
                                        $oldpath = @strip_tags($_POST['old_picture']);
                                        $update_query = "UPDATE `users` SET `full_name` = '".@mysqli_real_escape_string($connection->con_link, $ename)."', `sex` = '".$esex."', `email` = '".@mysqli_real_escape_string($connection->con_link, $eemail)."', `phone` = '".@mysqli_real_escape_string($connection->con_link, $ephone)."', `username` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."', `password` = '".@mysqli_real_escape_string($connection->con_link, $enc_epass)."', `temp_password` = '".$etpassword."' WHERE `username` = '".$_COOKIE['username']."'";
                                    }
                                    // processing the data and updating the database
                                    if (@mysqli_query($connection->con_link, $update_query) && @mysqli_query($connection->con_link, "UPDATE `messages` SET `sender` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."' WHERE `sender` = '".$_COOKIE['username']."'") && @mysqli_query($connection->con_link, "UPDATE `messages` SET `receiver` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."' WHERE `receiver` = '".$_COOKIE['username']."'") && @mysqli_query($connection->con_link, "UPDATE `latest_message_log` SET `sender` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."' WHERE `sender` = '".$_COOKIE['username']."'") && @mysqli_query($connection->con_link, "UPDATE `latest_message_log` SET `receiver` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."' WHERE `receiver` = '".$_COOKIE['username']."'") && @mysqli_query($connection->con_link, "UPDATE `group_chat` SET `sender` = '".@mysqli_real_escape_string($connection->con_link, $eusername)."' WHERE `sender` = '".$_COOKIE['username']."'")) {
                                        @setcookie("username", $eusername, strtotime("+ 1 year"));
                                        echo "<p id='update_success_message' class='text-center'>Profile updated successfully.</p>";
                                    } else {
                                        throw new Exception("<h4><p class='im-error text-center'>Error occured while saving data.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
                                    }
                                  
                                 } else {
                                    throw new Exception("<h4><p class='im-error text-center'>Passwords must be at least 8 characters long and can not be only numbers, alphabets and should contain at least one UpperCase and one LowerCase letter.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
                                 }
                } else {
                   throw new Exception("<h4><p class='im-error text-center'>Invalid username.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
                }
                              } else {
                                 throw new Exception("<h4><p class='j-error text-center'>Username already taken.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>"); 
                              }
                           } else {
                              throw new Exception("<h4><p class='j-error text-center'>No specified gender found.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
                           }
                       } else {
                            throw new Exception("<h4><p class='im-error text-center'>Invalid phone.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
                       }
                    } else {
                        throw new Exception("<h4><p class='im-error text-center'>Invalid email.</p><h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
                    }
                } else {
                    throw new Exception("<h4><p class='im-error text-center'>Invalid name.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
                }
            } else {
                throw new Exception("<h4><p class='j-error text-center'>All fields are required.</p></h4><br /><span class='back-to-form' title='Back to form' onclick='back_to_form()'>Back</span>");
            }
        }
    } else {
        throw new Exception("<h4><p class='j-error text-center'>Please login.</p></h4><br /><span class='back-to-form' title='Back to login' onclick='back_to_login()'>Back</span>");
    }
} catch(Exception $ex) {
    echo $ex->getMessage();
}
}
/* @copyRights NajeemB all rights reserved */
?>