<?php

require '../authenticate.php';

$authorID = sanitizeString(INPUT_GET, 'authID');

if (!isset($authorID)) {
    // author id not sent via GET so redirect back to authorsAdmin.php
    header("Location: authorsAdmin.php");
}

$authorName = sanitizeString(INPUT_GET, 'authName');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Author - CMS</title>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        error_reporting(-1);
        
        $confirmDelete = sanitizeString(INPUT_POST, 'confirmDelete');
        
        if (isset($confirmDelete)) {  // form has been submitted
            
            require '../dbConnect.php';
            
            // Delete books by author first
            try {
                
                $pdo->beginTransaction();

                $sql = "DELETE from bookstuff
                        WHERE authorId=?";

                $s = $pdo->prepare($sql);

                $s->execute([$authorID]);
                // Note: that value(s) passed to execute() method must be
                // inside an array.

                // Delete author
                $s = $pdo->prepare("DELETE FROM authors WHERE id=?");
                $s->execute([$authorID]);

                $pdo->commit();
                
            } catch (PDOException $ex) {
                $pdo->rollBack();
                $error = "Error performing delete of author $authorName";
                include '../error.html.php';
                throw $ex;
                //exit();
            }
            
            // Check if the deletions worked...
            if ($s->rowCount()) {
                echo "<h3>Author $authorName was successfully deleted</h3>";
            } else {
                echo "<h3>Author $authorName was NOT deleted</h3>";
            }
            
            ?>
            
        <a href="../authorsAdmin.php">Return to Managing Authors</a>
        <a href="../index.php">Display Updated Book List</a>
        
            <?php
        } else { // Display the delete confirmation form
            
            ?>
        <br><br>
        <h3>Are you sure you want to delete <?= $authorName ?> and all associated books?</h3>
        
        <br>
        <form action="" method="post">
            <input type="hidden" name="authID" value="<?= $authorID ?>">
            <input type="hidden" name="authName" value="<?= $authorName ?>">
            <input type="submit" name="confirmDelete" value="Yes">
            
            <a href="../authorsAdmin.php"><input type="button" value="No"></a>
        </form>
        
        
        <?php
            
        }
        ?>
    </body>
</html>
