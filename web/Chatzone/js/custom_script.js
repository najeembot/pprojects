/* custom java script for java chatzone */
function response_handler(data, status, xhr) {
    document.querySelector("#send_button").innerHTML = data;
    document.querySelector("#chat_message").value = "";
    setTimeout(function() {
        document.querySelector("#send_button").innerHTML = "<i class='fa fa-send'></i>";
        if (data.match(/sent successfully/ig) != null) {
            $(document).ready(function() {
               $("#messages_container").load("get_message.jsp"); 
               $("#messages_container").scrollTop($("#messages_container")[0].scrollHeight);
            });
        }
    }, 3000);
}
$(document).ready(function() {
    var message = "";
    $("#send_message_form").submit(function() {
       message = $("#send_message_form input#chat_message").val();
       $.post("Sendmessage", {message:message}, response_handler);
       return false; 
    });
});
function load_messages() {
    try {
        if (window.XMLHttpRequest) {
            var xhr = new XMLHttpRequest();
        } else {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.querySelector("#messages_container").innerHTML = xhr.responseText;
            }
        }
        xhr.open("POST", "get_message.jsp", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send();
        load_timeout_id = setTimeout(function() {load_messages()}, 1000);
    } catch(errMsg) {
        document.querySelector("#messages_container").innerHTML = '<div class="alert alert-warning alert-dismissable"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errMsg.message+'<div>';
    }
}
