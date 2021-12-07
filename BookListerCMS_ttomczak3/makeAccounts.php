<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create CMS Admin Accounts</title>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        error_reporting(-1);
        
        
        // Connect to our DB server and select our DB
        require 'dbConnect.php';
        
        // Drop any existing users table
        try {
            $pdo->exec("DROP TABLE if exists users");
        } catch (PDOException $ex) {
            $error = 'Could not drop table';
            include 'error.html.php';
            throw $ex;
            // exit();
        }
        
        //
        // (Re)create the users table
        //
        try {
            
            $sql = "CREATE TABLE users
                    (
                    uName varchar(255) primary key,
                    pWord varchar(255)
                    )";
                    
            $pdo -> exec($sql);
            
        } catch (PDOException $ex) {
            $error = 'Could not create table';
            include 'error.html.php';
            throw $ex;
            // exit();
        }
        
        //
        // Get user information from the ids.txt file and 
        // insert generated account information into users table
        //
        $fp = fopen("ids.txt", "r");

        while (!feof($fp)) {
                
            // read next line
            $userName = strtolower(trim(fgets($fp, 255)));

            if ($userName != "") {

                // Break up line into two fields
                list($fName, $lName) = explode(" ", $userName);
                
                // Construct the username and password
                //
                // username = first character of first name
                // followed by the last name.
                $userName = substr($fName, 0, 1) . $lName;
                
                // password = 
                // first 4 chars of last name if present,
                // followed by the length of last name, 
                // followed by first name with an uppercase first letter.
                $pWord = substr($lName, 0, 4) . strlen($lName) . ucfirst($fName);

                //echo "<h2 style=\"color:green\">Username: $userName <br> password: $pWord</h2>";

                $md5password = md5($pWord);
                $sha1password = sha1($pWord);
                $hashedPassword = password_hash($pWord, PASSWORD_DEFAULT);
                $anotherHashedPassword = password_hash($pWord, PASSWORD_DEFAULT);
                
                echo "<h2 style=\"color:green\">Username: $userName <br> password: $pWord <br> md5: $md5password <br> sha1: $sha1password<br> 1st new hash: $hashedPassword<br> 2nd new hash: $anotherHashedPassword</h2>";
                
                // 
                // Insert our account data into the users table
                //
                try {

                    $pdo->beginTransaction();

                    $sql = "INSERT INTO users
                            VALUES(?, ?)";

                    $s = $pdo->prepare($sql);

                    $s -> execute([$userName, $hashedPassword]);

                    $pdo -> commit();

                } catch (PDOException $ex) {
                    $pdo -> rollBack(); // Roll back the commit
                    $error = 'Error performing insert of user name';
                    include 'error.html.php';
                    throw $ex;
                    // exit();
                }

            }    
        } // end while not EOF
        ?>
    </body>
</html>
