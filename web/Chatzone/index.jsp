<%@page import="java.sql.*, java.io.*, org.apache.commons.lang3.*, javax.servlet.http.Cookie" contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><% out.println((session.getAttribute("username") != null && session.getAttribute("username").toString() != "") ? "Home" : "Login"); %> | Chatzone</title>
        <link rel="icon" type="image/x-icon" href="images/site_icon.ico" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/custom_style.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
        <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/custom_script.js"></script>
    </head>
    <%
        // checking if user is logged in or logged out
        if (session.getAttribute("username") != null && !session.getAttribute("username").toString().isEmpty()) {
    %>
    <body id="home_page" onload="load_messages()">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main_navbarc"> 
                    <span class="sr-only">Toggle navigation</span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                </button>
                <a href="#" class="navbar-brand">Visit us in</a>
            </div>
            <div class="collapse navbar-collapse" id="main_navbarc">
              <ul class="nav navbar-nav">
                <li><a href='https://www.facebook.com/java_chatzone' class="fa fa-2x fa-facebook-square"></a></li>
                <li><a href='https://www.twitter.com/java_chatzone' class="fa fa-2x fa-twitter-square"></a></li>
                <li><a href='https://www.plus.google.com/java_chatzone' class="fa fa-2x fa-google-plus-square"></a></li>
                <li><a href='https://www.pinterest.com/java_chatzone' class="fa fa-2x fa-pinterest-square"></a></li>
                <li><a href='https://www.instagram.com/java_chatzone' class="fa fa-2x fa-instagram"></a></li>
                <li><a href='https://www.vimeo.com/java_chatzone' class="fa fa-2x fa-vimeo"></a></li>
                <li><a href='https://www.weibo.com/java_chatzone' class="fa fa-2x fa-weibo"></a></li>
                <li><a href='https://www.wechat.com/java_chatzone' class="fa fa-2x fa-wechat"></a></li>
                <li><a href='https://www.whatsapp.com/java_chatzone' class="fa fa-2x fa-whatsapp"></a></li>
                <li><a href='https://www.linkedin.com/java_chatzone' class="fa fa-2x fa-linkedin-square"></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation" class="dropdown-header"><% out.println(session.getAttribute("username").toString()); %></li>
                        <li><a href="Logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp&nbsp&nbsp&nbsp;Logout</a></li>
                    </ul>
                </li>
              </ul>
            </div>
        </nav>
        <div class="page-header">
            <h2 class="text text-primary text-capitalize text-center"><b>Chatzone</b></h2>
            <h3 class="text text-info text-center">Join the chatroom</h3>
        </div>
        <div class="container">
           <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body" id="messages_container">
                        <%@include file="get_message.jsp" %>
                    </div>
                    <div class="panel-footer">
                        <form role="form" id="send_message_form" action="./" method="POST">
                            <div class="input-group">
                                <input type="text" name="chat_message" class="form-control" placeholder="Enter your message" id="chat_message" maxlength="700" required /><span class="input-group-btn"><button class="btn btn-primary" type="submit" title="Send" id="send_button"><i class="fa fa-send"></i></button></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                    <br />
                    <br />
                    <ol class="breadcrumb text-center"><li>&copy; Copy right 2013 all rights reserved.</li><li><a href="https://www.twitter.com/najeemjosh">Designed by Najeem Josh</a></li></ol>
    </body>
    <%
        } else {
    %>
    <body id="login_page">
        <div class='container'>
            <br />
            <div class="row">
                <div class="col-md-4 pull-left">
                    <img src="images/login_site_logo.png" class='img-responsive' />
                    <h1 class="text text-info text-uppercase text-nowrap"><b>Chatzone</b></h1>
                </div>
                <div class="col-md-4 pull-right">
                    <br />
                    <br />
                    <br />
                    <h2 class="text text-primary text-capitalize text-nowrap text-center">Login</h2>
                    <br />
                    <br />
                    <form role="form" action="./" method="POST">
                      <div class="form-group form-group-lg">
                          <label for="username">Full Name</label><br />
                          <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" />
                      </div>
                      <div class="form-group form-group-lg">
                          <label for="email">Email</label><br />
                          <input type="email" name="email" class="form-control" placeholder="Enter your email" />
                      </div>
                      <div class="form-group form-group-lg">
                          <label for="password">Password</label><br />
                          <input type="password" name="password" class="form-control" placeholder="Enter your password" />
                      </div>
                        <p class="help-block">Enter your login credentials.</p>
                        <button type="submit" value="Login" class="btn btn-primary btn-block btn-lg">Login</button>
                   </form>
                   <br />
                   <div class="row" id="login_results">
                       <%
                          try {
                              if (request.getParameter("full_name") != null && request.getParameter("email") != null && request.getParameter("password") != null) {
                                  // setting important variables
                                  String full_name = (String) request.getParameter("full_name");
                                  String email = (String) request.getParameter("email");
                                  String password = (String) request.getParameter("password");
                                  if (!full_name.isEmpty() && !email.isEmpty() && !password.isEmpty()) {
                                      // logging the user
                                      session.setAttribute("username", full_name);
                                      response.sendRedirect("./");
                                  } else {
                                      out.println("<div class='alert alert-warning alert-dismissable'><button class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields are required</div>");
                                  }
                              }
                          } catch(Exception ex) {
                              out.println("<div class='alert alert-danger alert-dismissable'><button class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" + ex.getMessage() + "</div>");
                          }
                       %>
                   </div> 
                </div>
            </div>
            <br />
            <br />
            <br />
        </div>
    </body>
    <%
        }
    %>
</html>
