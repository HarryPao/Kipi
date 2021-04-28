<?php
session_start();
include("kipi_pdoInc.php");

if($_SESSION['account'] == $_SESSION['deleteaccount']){

        $sth2 = $dbh->prepare("SELECT comment_account from comments where id=?");
        $sth2->execute(array($_GET['id']));
        $sth2->bindColumn(1, $host);

        if($sth2->rowCount()>0){
                $sth2->fetch(PDO::FETCH_BOUND);
        }
        if($_SESSION['account'] == $host){

                $sth = $dbh->prepare('DELETE FROM comments WHERE id = ?');
                $sth->execute(array($_GET['id']));
 
                echo "<script type='text/javascript'>";
                echo "alert('The comment has been deleted!');";
                echo "</script>";

                echo '<meta http-equiv=REFRESH CONTENT=0;url=kipi_post.php?id='.$_SESSION['tmp'].'>';  
        }
        else{
                echo "<script type='text/javascript'>";
                echo "alert('You have no permission to this comment!');";
                echo "</script>";

                echo '<meta http-equiv=REFRESH CONTENT=0;url=kipi_post.php?id='.$_SESSION['tmp'].'>';  
        }
}
?>

