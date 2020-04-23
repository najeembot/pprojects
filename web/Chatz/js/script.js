// index page scripts
// global variables
              var gcu;
              var name;
              var username;
              var password;
              var email;
              var phone;
              var sex;
              var profile_picture;
            // asynchronous user search
            $(document).ready(function() {
               $("input#user_search_query").on("input", function(e) {
                   if ($(this).val() != null && $(this).val() != "") {
                      $('div#users').load("../users.php?user_search_query=" + $('#user_search_query').val());
                   } else {
                      $("div#users").load("../users.php");
                   }
               });
            });
            // chat user settings script
            function select_targetc_user(element) {
                $(document).ready(function() {
                  var c_user = element.id;
                  $.post("../c_u.php", {chat_user : c_user}, function() {$("#targetULModuleTitle").html($("#targetULModuleTitle").html()); $('#chat_header').load("index.php #chat_header", function () {$("ul#user_search_query_results").load("index.php #user_search_query_results"); $("#main_communication_holder").load("../get_messages.php", function() {setTimeout(function() {$("#main_communication_holder").scrollTop($("#main_communication_holder")[0].scrollHeight)}, 1000)})}); onlineOffline()});
                });
            }
            
            // send messages script
            function check_send(event) {
                try {
                    if (event.keyCode === 13) {
                        var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
                        var message = document.querySelector("#text_area").innerHTML;
                        xhr.onloadstart = function () {
                            $(document).ready(function() {
                                 $("#attach_prl").show();
                            });
                        } 
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                  $(document).ready(function() {
                                       $('#message_bar').html(xhr.responseText);
                                       $("#text_area").html(null);
                                  });
                            }
                        }
                        xhr.onloadend = function() {
                            $(document).ready(function() {
                                   $("#attach_prl").hide();
                                   $('#scm').fadeOut(7000); 
                                   $("div#main_communication_holder").load("../get_messages.php", function () {setTimeout(function() {$("#main_communication_holder").scrollTop($("#main_communication_holder")[0].scrollHeight)}, 1000)});
                            });
                        }
                        xhr.open("POST", "../send_messages.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send(encodeURI("message="+message));
                    } else if (event.type === "submit") {
                        var ajax = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
                        var smessage = document.querySelector("#message").value;
                        ajax.onloadstart = function () {
                            $(document).ready(function() {
                                 $("#attach_prl").show();
                            });
                        } 
                        ajax.onreadystatechange = function() {
                            if (ajax.readyState == 4 && ajax.status == 200) {
                                  $(document).ready(function() {
                                       $('#message_bar').html(ajax.responseText);
                                       $("#message").val(null);
                                  });
                            }
                        }
                        ajax.onloadend = function() {
                            $(document).ready(function() {
                                   $("#attach_prl").hide();
                                   $('#scm').fadeOut(7000); 
                                   $("div#main_communication_holder").load("../get_messages.php", function () {setTimeout(function() {$("#main_communication_holder").scrollTop($("#main_communication_holder")[0].scrollHeight)}, 1000)});
                            });
                        }
                        ajax.open("POST", "../send_messages.php", true);
                        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        ajax.send(encodeURI("message="+smessage));
                        return false;
                    }
                } catch(e) {
                    $(document).ready(function() {
                       $('#message_bar').html("<span id='scm' style='color:#f00'>" + e.message + "</span>");
                       $('#scm').fadeOut(7000);
                    });
                } 
            }
            function check_attach(event) {
              try {
                   if (event.type === "change") {
                        var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
                        var data = new FormData();
                        var attach_file = document.querySelector("#attach").files[0];
                        var attach_file_size = attach_file.size;
                        var attach_file_calculated_size = (attach_file_size / 1024) / 1024;
                        if (attach_file_calculated_size < 8) {
                            data.append("attach", attach_file);
                            xhr.onloadstart = function () {
                                $(document).ready(function() {
                                    $("#attach_prl").show();
                                });
                            } 
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    $(document).ready(function() {
                                        $('#message_bar').html(xhr.responseText);
                                    });
                                }
                            }
                            xhr.onloadend = function() {
                                $(document).ready(function() {
                                   $("#attach_prl").hide();
                                   $('#scm').fadeOut(7000); 
                                   $("div#main_communication_holder").load("../get_messages.php", function () {setTimeout(function() {$("#main_communication_holder").scrollTop($("#main_communication_holder")[0].scrollHeight)}, 1000)});
                                });
                            }
                            xhr.open("POST", "../send_attachments.php", true);
                            xhr.send(data);
                        } else {
                            throw new Error("Your file size can't be more then 8 Mega Bytes");
                        }
                    }
                } catch(e) {
                    $(document).ready(function() {
                       if (e.message.match(/Your file size can't be more then 8 Mega Bytes/ig) != null) {
                           $('#message_bar').html("<span id='scm' style='color:#000'>" + e.message + "</span>");
                       } else {
                           $('#message_bar').html("<span id='scm' style='color:#f00'>" + e.message + "</span>");
                       }
                       $('#scm').fadeOut(7000);
                    });
                }
            }

	    // message receiving script
            function get_latest_message() {
              try {
               /* important variables
                  for parsing the xml response */
               var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
               var dataAsXML = "", rootE = "", sender = "", senderFname = "", receiver = "", titleData = "", error = "", errorText = "", senderFname = "";
               xhr.onreadystatechange = function() {
                  if (xhr.readyState == 4 && xhr.status == 200) {
                      dataAsXML = xhr.responseXML;
                      rootE = dataAsXML.documentElement;
                      error = rootE.getElementsByTagName("error")[0];
                      if (error != null) {
                          errorText = error.innerHTML;
                          throw new Error(errorText);
                      } else {
                          sender = rootE.getElementsByTagName("sender")[0].childNodes[0].nodeValue;
                          senderFname = rootE.getElementsByTagName("senderFname")[0].childNodes[0].nodeValue;
                          receiver = rootE.getElementsByTagName("receiver")[0].childNodes[0].nodeValue;
                          if (receiver != "") {
                              clearTimeout(onoffTid);
                              document.getElementById(sender).click();
                              document.getElementById("tsc").innerHTML = "<audio src='../sounds/message_received.mp3' autoplay><bgsound src='site_data/sounds/message_received.mp3' /></audio>";
                              titleData = document.querySelector("title").innerHTML;
                              document.querySelector("title").innerHTML = senderFname + " messaged you";
                              setTimeout(function() {document.querySelector("title").innerHTML = titleData;}, 5500);
                              xhr.open("POST", "../delete_latest_message.php", true);
                              xhr.send(null);
                              setTimeout(function() {onlineOffline()}, 1000);
                          }
                      }
                  }
               }
               xhr.open("POST", "../get_latest_message.php", true);
               xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
               xhr.send(null);
			         setTimeout(function() {get_latest_message()}, 5500);
             } catch (errMsg) {
                document.querySelector("#message_bar").innerHTML = "<span id='scm'>"+errMsg.message+"</span>";
             }
            }

            // users status checking script and chat target user details script
            function onlineOffline() {
                try {
                    $(document).ready(function() {
                       $("#chat_header").load("index.php #chat_header");
                       $("div#users").load("../users.php");
                    });
                    onoffTid = setTimeout(function() {onlineOffline()}, 75000);
                } catch(e) {
                    $(document).ready(function() {
                        $("#chat_target_name").css({'color':'#f00', 'font-size':'0.9em'});
                        $("#chat_target_name").html(e.message);
                    });
                }
            }
            $(document).ready(function() {
               onlineOffline();
               $("input#user_search_query").focus(function() {
                  clearTimeout(onoffTid);
               });
               $("#home_main_section #left_sidebar").mouseleave(function() {
                  if ($("input#user_search_query").val() == null || $("input#user_search_query").val() == "") {
                      onlineOffline();
                  }
               });
            });

            // profile edit syntaxes 
			function togglePassShow(element) {
				if (element.checked) {
			        document.querySelector("#edit_password").type = 'password';
				} else if (!element.checked) {
					document.querySelector("#edit_password").type = 'text';
				}
			}
            // edit profile picture syntaxes
            function onChangePP() {
                try {
                  $(document).ready(function() {
                    if ($("#edit_pp").val() != null && $("#edit_pp").val() != "") {
                       var ppf = document.querySelector("#edit_pp").files[0];
                       var calculated_size =  (ppf.size / 1024) / 1024;
                       if (calculated_size <= 2) {
                         if (ppf.type == "image/jpeg" || ppf.type == "image/png" || ppf.type == "image/gif") {
                            if (window.URL) {
                               var url = window.URL.createObjectURL(ppf);
                            } else if (window.webkitURL) {
                               url = window.webkitURL.createObjectURL(ppf);
                            }
                            $("#edit_fileV").html('<a class="th [radius]"><img src="'+url+'" id="edit_img" /></a><p class="text-center"><a onclick="cancel_edit_img();" class="text-center">Cancel</a>&nbsp;|&nbsp;<a onclick="default_edit_img();" class="text-center">Default</a></p>');
                         } else {
                            $("#edit_fileV").html("<p class='text-right'>File type should only be (jpg, png or gif)</p>");
                            $("#edit_fileV p").css('color', '#f00');
                            $("input#edit_pp").get(0).value = "";
                            $("input#edit_pp").get(0).type = "";
                            $("input#edit_pp").get(0).type = "file";
                         }
                    } else {
                         
                         $("#edit_form #edit_fileV").html("<p class='text-right'>File size can't be more then 2 mega bytes</p>");
                         $("#edit_fileV p").css('color', '#f00');
                         $("input#edit_pp").get(0).value = "";
                         $("input#edit_pp").get(0).type = "";
                         $("input#edit_pp").get(0).type = "file";
                   }
                  } else {
                    $("#edit_fileV").html('<a class="th [radius]"><img src="'+url+'" id="edit_img" /></a><p class="text-center"><a onclick="cancel_edit_img();" class="text-center">Cancel</a>&nbsp;|&nbsp;<a onclick="default_edit_img();" class="text-center">Default</a></p>');
                  }
                });
              } catch(errMsg) {
                  $(document).ready(function() {
                     $("#edit_fileV").html("<p class='text-right'>Error: "+errMsg.message+"</p>");
                     $("#edit_fileV p").css('color', '#f00');
                  });
              }
            }
            function cancel_edit_img(element) {
                try {

                    var current_picture = document.querySelector("#edit_form #current_picture").value;
                    document.querySelector("#edit_fileV #edit_img").src = current_picture;
                    document.querySelector("#if_default_picture").value = "";
                    document.getElementById("edit_pp").value = "";
                    document.getElementById("edit_pp").type = "";
                    document.getElementById("edit_pp").type = "file";
                    
                } catch(errMsg) {
                    
                    element.style.color = '#f00';
                    
                }
            }

            function default_edit_img(element) {
              try {
                 var default_picture = "./profile_pictures/default_profile_picture/default.jpeg";
                 document.querySelector("#edit_fileV #edit_img").src = default_picture;
                 document.querySelector("#if_default_picture").value = "true";
                 document.querySelector("#edit_form #edit_pp").value = "";
                 document.querySelector("#edit_form #edit_pp").type = "";
                 document.querySelector("#edit_form #edit_pp").type = "file";

              } catch(errMsg) {
                element.style.color = '#f00';
              }
            }
              /* processing the whole form for submit 
               * asynchronous *
               * responsive *
               * fast *
               using Jquery Ajax */
            function AjaxSubmit() {
                // getting values of inputs if filled
                var name = (document.querySelector("#edit_name").value != null && document.querySelector("#edit_name").value != "" && document.querySelector("#edit_name").value != document.querySelector("#default_name").value) ? "has-value" : "empty";
                var username = (document.querySelector("#edit_username").value != null && document.querySelector("#edit_username").value != "" && document.querySelector("#edit_username").value != document.querySelector("#default_username").value) ? "has-value" : "empty";
                var password = (document.querySelector("#edit_password").value != null && document.querySelector("#edit_password").value != "" && document.querySelector("#edit_password").value != document.querySelector("#default_password").value) ? "has-value" : "empty";
                var email = (document.querySelector("#edit_email").value != null && document.querySelector("#edit_email").value != "" && document.querySelector("#edit_email").value != document.querySelector("#default_email").value) ? "has-value" : "empty";
                var phone = (document.querySelector("#edit_phone").value != null && document.querySelector("#edit_phone").value != "" && document.querySelector("#edit_phone").value != document.querySelector("#default_phone").value) ? "has-value" : "empty";
                var sex = (document.querySelector("#edit_sex").value != null && document.querySelector("#edit_sex").value != "" && document.querySelector("#edit_sex").value != document.querySelector("#default_sex").value) ? "has-value" : "empty";
                var profile_picture = (document.querySelector("#edit_pp").value != null && document.querySelector("#edit_pp").value != "") ? "has-value" : "empty";
                var if_default_picture = (document.querySelector("#if_default_picture").value != null && document.querySelector("#if_default_picture").value == "true") ? "has-value" : "empty";
                if_default_picture = (document.querySelector("#current_picture").value != "./profile_pictures/default_profile_picture/default.jpeg") ? if_default_picture : "empty";
                if (name == "empty" && username == "empty" && password == "empty" && email == "empty" && phone == "empty" && sex == "empty" && profile_picture == "empty" && if_default_picture == "empty") {
                  document.querySelector("#edit_submit_b").value = "No changes!";
                  $(document).ready(function() {
                    $("#edit_submit_b").addClass("warning");
                    setTimeout(function() {
                      $("#edit_submit_b").val("Save");
                      $("#edit_submit_b").removeClass("warning");
                  }, 2000);
                  });
                } else {
                  edit_submit();
                }
                return false;
            }
            function edit_submit() {
                try {
                    $(document).ready(function() {
                      $("#profileSettingsModule").foundation('reveal', 'close');
                    });
                    if (window.XMLHttpRequest) {
                        var xhr = new XMLHttpRequest();
                    } else {
                        xhr = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xhr.onloadstart = function() {
                        $(document).ready(function() {
                            window.scroll(0, 0);
                            $('#loadModule').foundation('reveal', 'open');
                        });
                    }
                    xhr.onloadend = function() {
                      $(document).ready(function() {
                           $("#loadModule").foundation('reveal', 'close');
                      });
                    }
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                          $(document).ready(function() {
                            $("#resultModule").foundation("reveal", "open");
                            $("#resultModule").html($("#resultModule").html()+"<div id='edit_results'>"+xhr.responseText+"</div>");
                            if (xhr.responseText.match(/profile updated successfully/ig) != null) {
                                setTimeout(function() {
                                            $("body#home_page").load("index.php"); 
                                }, 4000);
                            }
                          });
                        }
                    }
                    var data = new FormData();
                    name = (document.querySelector("#edit_name").value != null && document.querySelector("#edit_name").value != "") ? document.querySelector("#edit_name").value : document.querySelector("#default_name").value;
                    username = (document.querySelector("#edit_username").value != null && document.querySelector("#edit_username").value != "") ? document.querySelector("#edit_username").value : document.querySelector("#default_username").value;
                    password = (document.querySelector("#edit_password").value != null && document.querySelector("#edit_password").value != "") ? document.querySelector("#edit_password").value : document.querySelector("#default_password").value;
                    email = (document.querySelector("#edit_email").value != null && document.querySelector("#edit_email").value != "") ? document.querySelector("#edit_email").value : document.querySelector("#default_email").value;
                    phone = (document.querySelector("#edit_phone").value != null && document.querySelector("#edit_phone").value != "") ? document.querySelector("#edit_phone").value : document.querySelector("#default_phone").value;
                    sex = (document.querySelector("#edit_sex").value != null && document.querySelector("#edit_sex").value != "") ? document.querySelector("#edit_sex").value : document.querySelector("#default_sex").value;
                    profile_picture = document.querySelector("#edit_pp").files[0];
                    var old_picture = document.querySelector("#current_picture").value;
                    var if_default_picture = document.querySelector("#if_default_picture").value;
                    data.append("edit_name", name);
                    data.append("edit_username", username);
                    data.append("edit_password", password);
                    data.append("edit_email", email);
                    data.append("edit_phone", phone);
                    data.append("edit_sex", sex);
                    data.append("edit_pp", profile_picture);
                    data.append("old_picture", old_picture);
                    data.append("if_default_picture", if_default_picture);
                    xhr.open("POST", "../update_user_profile.php", true);
                    xhr.send(data);
                } catch(errMsg) {
                    $(document).ready(function() {
                       $("#loadModule").foundation("reveal", "close");
                       $("#resultModule").foundation("reveal", "open");
                       $("#resultModule").html("<div id='edit_results'><p class='im-error'>Error: " + errMsg.message + "</p></div>"); 
                    });
                }
            }
            function back_to_form() {
                try {
                    $(document).ready(function() {
                        $("#resultModule").foundation("reveal", "close");
                        $("#loadModule").foundation("reveal", "close");
                        $("#profileSettingsModule").foundation('reveal', 'open');  
                    });
                } catch(errMsg) {
                   $(document).ready(function() {
                      $("#loadModule").foundation("reveal", "close");
                      $("#profileSettingsModule").foundation('reveal', 'close'); 
                      $("#resultModule").html("<div id='edit_results'><h4><p class='im-error text-center'>Error: " + errMsg.message + "</p></h4></div>");
                    });
                }
            }
            function back_to_login() {
              try {
                document.location = "./";
              } catch(errMsg) {
                $(document).ready(function() {
                    $("#loadModule").foundation("reveal", "close");
                    $("#profileSettingsModule").foundation('reveal', 'close'); 
                    $("#resultModule").html("<div id='edit_results'><h4><p class='im-error text-center'>Error: " + errMsg.message + "</p></h4></div>");
                });
              }
            }
            // group chat syntaxes 
            function group_chat_update() {
                $(document).ready(function() {
                    $("div#main_communication_holder").load("../get_messages.php", function () {setTimeout(function() {$("#main_communication_holder").scrollTop($("#main_communication_holder")[0].scrollHeight)}, 500)});
                });
                gcu = setTimeout(function() {group_chat_update()}, 1000);
            }
// signup page scripts

$(document).ready(function() {
              // validating fullName
              $("input#full_name").on("input", function() {
                if ($(this).val() != null && $(this).val() != "") {
                   var meta_re = /[!@#$%^&*(){}\\\/\"':<>~?,+=\[\]]/ig;
                   if (meta_re.test($(this).val())) {
                      $("#fullNameV").css('color', '#f00');
                      $("#fullNameV").html("Invalid name");
                   } else {
                      $("#fullNameV").html("<img src='img/sinput_valid.png' alt='Ok' width='30' height='30' />");
                   }
                } else {
                    $("#fullNameV").html(null);
                }
              });
              
              // validating email
              $("input#email").on("input", function() {
                if ($(this).val() != null && $(this).val() != "") {
                    var echeck = $(this).val();
                    $.post("../userdata_check.php", {echeck : echeck}, function (data, status) {
                        if (data == "exists") {
                            $("#emailV").css('color', '#f00');
                            $("#emailV").html("Email already registered");
                        } else if (data == "invalid") {
							$("#emailV").css('color', '#f00');
                            $("#emailV").html("Invalid email");
						} else if (data == "not_exists") {
                            $("#emailV").html("<img src='img/sinput_valid.png' alt='Ok' width='30' height='30' />");
                        } else {
                            $("#emailV").css('color', '#f00');
                            $("#emailV").html(data);
                        }
                    });
                } else {
                    $("#emailV").html(null);
                }
              });
              // validating phone
              $("input#phone").on("input", function() {
                if ($(this).val() != null && $(this).val() != "") {                    
                   if ($(this).val().match(/\+[0-9]{2}[0-9]{10}/im))  {
                      $("#phoneV").html("<img src='img/sinput_valid.png' alt='Ok' width='30' height='30' />");
                   } else {
                      $("#phoneV").css('color', '#f00');
                      $("#phoneV").html("Please enter a valid phone number like +31636363634.");
                   }
                } else {
                    $("#phoneV").html(null);
                }
              });
              // validating username 
              $("#username").on("input", function() {
                if ($(this).val() != null && $(this).val() != "") {
                    var ucheck = $(this).val();
                    $.post("../userdata_check.php", {ucheck : ucheck}, function (data, status) {
                        if (data == "exists") {
                            $("#usernameV").css('color', '#f00');
                            $("#usernameV").html("Already taken");
                        } else if (data == "invalid") {
							$("#usernameV").css('color', '#f00');
                            $("#usernameV").html("Invalid username");
						} else if (data == "not_exists") {
                            $("#usernameV").html("<img src='img/sinput_valid.png' alt='Ok' width='30' height='30' />");
                        } else {
                            $("#usernameV").css('color', '#f00');
                            $("#usernameV").html(data);
                        }
                    });
                } else {
                    $("#usernameV").html(null);
                }
              });
              // validating password 
              $("input#password").on("input", function() {
                 if ($(this).val() != null && $(this).val() != "") {
                     var pcheck = $(this).val();
                     $.post("../userdata_check.php", {pcheck : pcheck}, function (data, status) {
                        if (data == "Your Password Must Contain At Least 8 Characters!") {
                            $("#password").css("border", "2px solid #f00");
                            $("#passwordV").css('color', '#f00');
                            $('#passwordV').html("Weak");
                        } else if (data == "Your Password Must Contain At Least 1 Number!") {
							$("#password").css("border", "2px solid #ff0");
                            $("#passwordV").css('color', '#ff0');
                            $("#passwordV").html("Fair");
						} else if (data == "Your Password Must Contain At Least 1 Capital Letter!") {
                            $("#password").css("border", "2px solid #ff0");
                            $("#passwordV").css('color', '#ff0');
                            $("#passwordV").html("Fair");
                        } else if (data == "Your Password Must Contain At Least 1 Lowercase Letter!") {
                            $("#password").css("border", "2px solid #ff0");
                            $("#passwordV").css('color', '#ff0');
                            $("#passwordV").html("Fair");
                        } else if (data == "Too long password!") {
                            $("#password").css("border", "2px solid #ff0");
                            $("#passwordV").css('color', '#ff0');
                            $("#passwordV").html("Fair");
                        } else if (data == "Please Check You've Entered Or Confirmed Your Password!") {
                            $("#password").css("border", "2px solid #f00");
                            $("#passwordV").css('color', '#f00');
                            $("#passwordV").html("Please enter your password.");
                        } else if (data == "Ok") {
                            $("#password").css("border", "2px solid #008800");
                            $("#passwordV").css('color', '#0f0');
                            $("#passwordV").html("<img src='img/sinput_valid.png' alt='Ok' width='30' height='30' />");
                        }
                    });
                 } else {
                     $("#password").css("border", "2px solid #ccc");
                     $("#passwordV").css('color', '#000');
                     $("#passwordV").html(null);
                 }
              });
              // validating password confirmation
              $("input#con_password").on("input", function() {
                 var pass = ($("input#password").val() != null && $("input#password").val() != "") ? $("input#password").val() : false; 
                 var con_password = ($(this).val() != null && $(this).val() != "") ? $(this).val() : false;
                 if (pass != false && con_password != false) {
                     if (con_password == pass) {
                         $("#con_passwordV").html("<img src='img/sinput_valid.png' alt='Ok' width='30' height='30' />");
                     } else {
                         $("#con_passwordV").css('color', '#f00');
                         $("#con_passwordV").html("Passwords do not match");
                     }
                 } else {
                    $("#con_passwordV").html(null);
                 }
              });
           });

/* @copyRights NajeemB all rights reserved */
