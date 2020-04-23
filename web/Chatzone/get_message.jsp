<%@page contentType="text/html" import="java.io.*, java.sql.*;" pageEncoding="UTF-8"%>
<%
     // getting all messages
        Connection con = null;
        Statement stmt = null;
        ResultSet rs = null;
        try {
            Class.forName("com.mysql.jdbc.Driver");
            con = DriverManager.getConnection("jdbc:mysql://localhost/chatzone", "root", "");
            stmt = con.createStatement();
            rs = stmt.executeQuery("SELECT * FROM `chat`");
            out.println("<ul class='list-group'>");
            while (rs.next()) {
                out.println("<li class='list-group-item'><b>"+rs.getString("sender")+"</b>&nbsp;<span class='glyphicon glyphicon-arrow-right'></span>&nbsp;"+rs.getString("message")+"&nbsp;<span class='badge'>"+rs.getString("time_sent")+"</span></li>");
            }
        } catch(Exception ex) {
            out.println("<div class='alert alert-danger alert-dismissable'><button class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+ex.getLocalizedMessage()+"</div>");
        } finally {
            if (con != null) {
                try {
                    con.close();
                } catch(Exception ex) {
                    out.println("<div class='alert alert-danger alert-dismissable'><button class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+ex.getLocalizedMessage()+"</div>");
                }
            }
        }
%>
