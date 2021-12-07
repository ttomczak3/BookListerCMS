<?php
    
if (!session_id()) {
    session_start();
}

require 'sanitize.php';
// Save any value in $_GET['url'] that was passed into this in a session
// variable we will call targetURL
$url = sanitizeString(INPUT_GET, 'url');

if (isset($url)) {
    // persist the pass-in url that came from authenticate.php's code
    $_SESSION['targetURL'] = $url;
} else { // nothing was passed in $_GET['url']
    $_SESSION['targetURL'] = "adminPage.php";
}

// If the login form has been submitted, try to authenticate
// the user based on our DB users table
//
$clickIt = sanitizeString(INPUT_POST, 'clickIt');

if (isset($clickIt)) {
    
    // process the form data
    
    // acquire the username and password from the form
    $uName = trim(sanitizeString(INPUT_POST, 'userName'));
    $pWord = trim(sanitizeString(INPUT_POST, 'passWord'));
    
    //echo "<h2>\$uName = $uName *** \$pWord = $pWord</h2>";
    
    if ($uName == "" || $pWord == "") {
        echo "<h3 style=\"color:red\">Please enter both a username and password</h3>\n";
    } else {
        
        require 'dbConnect.php';
        require 'callQuery.php';
        
        $query = "SELECT pWord from users
                WHERE uName='$uName'";

        $errorMsg = "Error fetching user account info";

        $password= callQuery($pdo, $query, $errorMsg)->fetchColumn();
        //echo "\$password = $password";

        // Check and see if we have a password match
        if (password_verify($pWord, $password)) {

            // authenticate the user since we have a match
            $_SESSION['authenticated'] = true;

            // Redirect the user to the page they came from OR
            // to adminPage.php if they came here directly.
            header("Location: $_SESSION[targetURL]");

        } else { // passwords don't match
            echo "<h3 style=\"color:red\">Invalid credentials</h3>\n";
        }
        
    }
    
} else {  // login form not submitted
    
    $logOut = sanitizeString(INPUT_GET, 'logOut');
    
    // check if user wishes to log out
    if (isset($logOut) && $logOut == 1) {

        // log out the user
        unset($_SESSION['authenticated']);

    }
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BookLister CMS Admin Login Page</title>
    </head>
    <body>
        <h2 id="myh2">Please login to gain administrative access</h2>
        
        <form action="" method="post">
            <label for="userName">Username:</label>
            <input type="text" placeholder="Username" name="userName" id="userName">
            <br><br>
            
            <label for="passWord">Password:</label>
            <input type="password" placeholder="Password" name="passWord" id="passWord">
            <br><br>
            
            <input type="submit" name="clickIt" value="Log In">
        </form>
    </body>
</html>
