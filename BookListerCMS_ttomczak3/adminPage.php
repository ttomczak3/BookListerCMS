<?php
session_start();

/*

Maintaining State

http: is stateless (data is not remembered from one page access to another)

Ways to maintain state:
o cookies
o sessions
o database
o server-side files
o GET/POST data
o hidden form fields

*/

// Use session data to check if the user trying to access
// this page is authenticated.  If not, we'll redirect them
// to our login page.
require 'authenticate.php';

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Books CMS Admin Page</title>
    </head>
    <body>
    
        <h2>Books Site Content Management System</h2>
        
        <ul>
            <li><a href="booksAdmin.php">Manage Books</a></li>
            <li><a href="authorsAdmin.php">Manage Authors</a></li>
        </ul>
        
        <a href="login.php?logOut=1">Log Out</a>
    </body>
</html>
