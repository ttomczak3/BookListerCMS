<?php

$fp = fopen(__dir__ . "/myInfo.txt", "r");

$myPassword = trim(fgets($fp));

// 1. Connect to DB server
// 2. Select our database
// 
// oh, and check for exceptions...
try {
    
    // Create a new instance of a PDO object
    $pdo = new PDO('mysql:host=localhost:3306;dbname=webbooks', 'itsd', $myPassword);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
    
} catch (PDOException $ex) {

    $error = 'Unable to connect to the database server<br><br>' . $ex->getMessage();
    
    if ($closeSelect) {
        echo "</select>";
        $closeSelect = false;
    }
    
    include 'error.html.php';
    throw $ex;   // also show SQL system (syntax) errors  
    //exit();
    
}