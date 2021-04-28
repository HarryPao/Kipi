<?php
    include('kipi_pdoInc.php');
    session_start();
?>
<?php
function showMsg($row){
    
  $msg = htmlspecialchars($row['comment']);
  $msg = str_replace("\n", "<br>", $msg);
 
  echo '<div>Comment by:   '.$row['comment_account'].'</div>';
  echo '<div>'.$row['time'].'</div><br>';
  echo '<div>'.$msg.'</div><br>';

if( $_SESSION['account']==$row['comment_account']){     
      $_SESSION['deleteaccount'] = $row['comment_account']; 
      $_SESSION['tmp'] = $_GET['id'];
      echo '<a class="btn btn-danger mybtn" href="kipi_delete_comment.php?id='.$row['id'].'">Delete</a>  <a class="btn btn-primary mybtn" href="kipi_update_comment.php?id='.$row['id'].'">Edit</a><br>';
      echo '<br><br><br>';
    }
  
}
?>

<?php
  if(isset($_GET['id']) &&  isset($_POST['content'])){ 
      $sth = $dbh->prepare( 'INSERT INTO comments ( comment_account, comment, ip ,post_id ) VALUES (? ,?, ?, ?)' );
      $sth->execute(array(
          $_SESSION['account'],
          $_POST['content'],
          $_SERVER['REMOTE_ADDR'],
          (int)$_GET['id']
      ));           
      echo '<meta http-equiv=REFRESH CONTENT=0;url=kipi_post.php?id='.(int)$_GET['id'].'>';      
  }
?>

<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="UTF-8">
    <title>Kipi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="./kipi_PersonalPage_style.css">
    <style type="text/css">
      .head{
        background-color:#778B79; color:white; font-weight:bold; font-size:30px;
        text-align:center; padding:10px;
      }    
      .content{
        width:1000px; margin-left:auto; margin-right:auto;
      }
      .box{
        width:480px; padding:10px; margin:10px; background-color:white; font-size:15px;
        display:inline-block; vertical-align:top;
        text-align:center;
      }
      .comment{
        width:480px; padding:10px; margin:10px; background-color:white; font-size:15px;
        display:inline-block; vertical-align:top;
      }
    </style>

  </head>
  <body style="margin:0px; background-color:#eeeeee;">

    <main>
          <div class="head">
            <div>Kipi
              <a href="kipi_PersonalPage.php">My Personal Page</a>
            </div>
          </div>
            <div class="content">
              <?php
			            $sth = $dbh->prepare("SELECT photo, likes, content from post where id=?");
                  $sth->execute(array($_GET['id']));
                  $sth->bindColumn(1, $lob, PDO::PARAM_LOB);
                  $sth->bindColumn(2, $likes);
                  $sth->bindColumn(3, $content);
             
                  

                  if($sth->rowCount()>0){
                    $sth->fetch(PDO::FETCH_BOUND);
                    $new_content = htmlspecialchars($content);

                    echo '<div class="box">';
				            echo   '<img src="data:image/jpeg;base64,'.base64_encode( $lob ).'" class=\'gallery-image\' alt=\'\'>';
                    echo  '</div>';

                    echo '<div class="box">';
                    echo '<div class="post-content">'.$new_content.'</div>';
                    echo '</div>';
                  }
              ?>

              <div class="comment">  
                <?php
                  if(isset($_GET['id'])){
                  $sth = $dbh->prepare('SELECT * from comments WHERE post_id = ? ORDER BY id ');
                  $sth->execute(array((int)$_GET['id']));

                    if($sth->rowCount() >=0){
                      while($row = $sth->fetch(PDO::FETCH_ASSOC)){
                        showMsg($row);               
                      }
                    }
                  }
                ?>
              </div>
              <div class="box">
                <form action="kipi_post.php?id=<?php echo (int)$_GET['id'];?>" method="post">
                  Comment：<br><br>
                  <textarea name="content" placeholder="Say something to the owner..."></textarea><br>
                  <input type="submit" value="comment">
                </form>
              </div>
              <?php
                $sth = $dbh->prepare("SELECT user_account from post where id=?");
                $sth->execute(array($_GET['id']));
                $sth->bindColumn(1, $host);
         
                if($sth->rowCount()>0){
                  $sth->fetch(PDO::FETCH_BOUND);
                }
                
                if($_SESSION['account'] == $host){

                  $_SESSION['deleteaccount'] = $host; 
                  $_SESSION['tmp'] = $_GET['id'];

                  echo '<div class="box">';
                  echo '<a class="btn btn-danger mybtn" href="kipi_delete_post.php?id='.$_GET['id'].'">Delete post</a>     <a class="btn btn-primary mybtn" href="kipi_update_post.php?id='.$_GET['id'].'">Edit post</a><br>';
                  echo '</div>'; }
              ?>
            </div>
    </main>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>