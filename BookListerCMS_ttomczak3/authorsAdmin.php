<?php
if (!session_id()) {
    session_start();
}

require 'authenticate.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS - Authors Admin Page</title>
        
        <link href="css/authorsAdmin.css" rel="stylesheet">
    </head>
    <body>
        <h2>Manage Authors</h2>
        <?php
          
        require 'dbConnect.php';
        require 'callQuery.php';
        
        // Query our DB and get all author information
        
        $query = "SELECT * FROM authors
                ORDER BY authorName";

        $errorMsg = "Error fetching author info";

        $result = callQuery($pdo, $query, $errorMsg);

        ?>
        <table>
            
        <?php
        // Step through the result set (PDOStatement object) one
        // row at a time
        while ($row = $result->fetch()) {

            print <<<TABLESTUFF
            <tr>
                <td class="author">$row[authorName]</td>
                <td class="authorid">$row[id]</td>

                <td class="links">
                    <a href="authors/editAuthor.php?authID=$row[id]&authName=$row[authorName]">Edit</a><br>
                    <a href="authors/deleteAuthor.php?authID=$row[id]&authName=$row[authorName]">Delete</a>
                </td>
            </tr>
TABLESTUFF;

        }
        
        
        
        ?>
            
        </table>
    </body>
</html>
