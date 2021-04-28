<?php
session_start();
include("kipi_pdoInc.php");
    $sth2 = $dbh->prepare("SELECT comment_account from comments where id=?");
    $sth2->execute(array($_GET['id']));
    $sth2->bindColumn(1, $host);

    if($sth2->rowCount()>0){
        $sth2->fetch(PDO::FETCH_BOUND);
    }
    if($_SESSION['account'] == $host){

        if(isset($_GET['id'])  && isset($_POST['content'])){

            $sth = $dbh->prepare('UPDATE comments SET comment= ? WHERE id = ?  ');
            $sth->execute(array($_POST['content'],(int)$_GET['id']));

            echo "<script type='text/javascript'>";
            echo "alert('The comment has been editted!');";
            echo "</script>";

            echo '<meta http-equiv=REFRESH CONTENT=0;url=kipi_post.php?id='.$_SESSION['tmp'].'>';  
        }
    }
    else{
        echo "<script type='text/javascript'>";
        echo "alert('You have no permission to this comment!');";
        echo "</script>";

        echo '<meta http-equiv=REFRESH CONTENT=0;url=kipi_post.php?id='.$_SESSION['tmp'].'>';  
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>Edit Comment</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
        <h1>Edit Comment</h1>
        <span>
            <!--<a href="kipi_PersonalPage.php">Your Personal Page</a>-->
        </span>
        <form role="form" action="kipi_update_comment.php?id=<?php echo (int)$_GET['id'];?>" method="POST">
            <div class="form-group">

                
                <input type="text" class="form-control" id="content" placeholder="new comment" name="content"  > 
               
              <br>
             	

            </div>
            
            <button type="submit"  class="btn btn-primary">Submit</button>
        </form>
    </div> 

</body>
</html>
