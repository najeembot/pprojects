package servlets;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.sql.*;
import java.io.*;
import org.apache.commons.lang3.*;


@WebServlet(name = "Sendmessage", urlPatterns = {"/Sendmessage"})
public class Sendmessage extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        try (PrintWriter out = response.getWriter()) {
            
        }
    }


    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
            // basic objects and variables
            PrintWriter out = response.getWriter();
            Connection con = null;
            PreparedStatement send_pstmt = null;
            try {
                if (request.getParameter("message") != null) {
                    String message = (String) request.getParameter("message");
                    if (!message.isEmpty()) {
                        message = StringEscapeUtils.escapeHtml4(message);
                        if (message.length() <= 700) {
                            // inserting the message into database
                            Class.forName("com.mysql.jdbc.Driver");
                            con = DriverManager.getConnection("jdbc:mysql://localhost/chatzone", "root", "");
                            send_pstmt = con.prepareStatement("INSERT INTO `chat` VALUES (NULL, ?, ?, NOW())");
                            send_pstmt.setString(1, request.getSession().getAttribute("username").toString());
                            send_pstmt.setString(2, message);
                            send_pstmt.executeUpdate();
                            out.println("Sent successfully");
                        } else {
                            out.println("Message length error");
                        }
                    } else {
                        out.println("Message emtpy");
                    }
                }
                
            } catch(Exception ex) {
                out.println(ex.getMessage());
            } finally {
                if (con != null) {
                    try {
                      con.close();
                    } catch(Exception ex) {
                        out.println(ex.getMessage());
                    }
                }
            }
    }

    @Override
    public String getServletInfo() {
        return "Short description";
    }

}
