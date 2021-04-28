<?php
session_start();
include("Kipi_pdoInc.php");
?>

<?php
$resultStr = '';

        
        if(isset($_POST['pwd']) && isset($_POST['job']) && isset($_POST['education']) && isset($_POST['intro']) && isset($_FILES['image'])){

            $sth = $dbh->prepare("UPDATE user SET pwd = md5(?), job = ?, education = ?, intro = ?, profile_img = ? WHERE account = ?");
      
            if(isset($_FILES['image'])){
                $fp = fopen($_FILES['image']['tmp_name'], 'rb');
            }
 
            $sth->bindParam(1, $_POST['pwd']);
            $sth->bindParam(2, $_POST['job']);
            $sth->bindParam(3, $_POST['education']);
            $sth->bindParam(4, $_POST['intro']);
            $sth->bindParam(5, $fp, PDO::PARAM_LOB);
            $sth->bindParam(6, $_SESSION['account']);

            $dbh->beginTransaction();
            $sth->execute();
            //$dbh->commit();
                
            $resultStr = '更改成功';
            echo  '<meta http-equiv=REFRESH CONTENT=0;url=kipi_PersonalPage.php>';
        }

?>




<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Kipi - Edit</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'><link rel="stylesheet" href="./register_style.css">

</head>

<body>
<!-- partial:index.partial.html -->
<div class="container">
  <?php echo $resultStr;?>
  <form action="kipi_EditProfile.php" method="POST" enctype="multipart/form-data">
    <div class="row">
      <h4>Password</h4>
      <div class="input-group input-group-icon">
        <input type="password" name="pwd" placeholder="New Password"/>
        <div class="input-icon"><i class="fa fa-key"></i></div>
      </div>
    </div>
    <div class="row">
      <h4>About Me</h4>
      <div class="input-group">
        <label style="color: #333333;">Upload a profile image:</label>
        <input type="file" name="image"><br><br>
        <div class="input-group input-group-icon">
          <input type="text" name="job" placeholder="Job"/>
          <div class="input-icon"><i class="fa fa-desktop"></i></div>
        </div>
        <div class="input-group input-group-icon">
          <input type="text" name="education" placeholder="Education"/>
          <div class="input-icon"><i class="fa fa-book"></i></div>
        </div>
        <textarea rows="5"  name="intro" placeholder="Introduce yourself..."></textarea>
      </div>

    <div class="row">
      <div class="col-submit">
        <div class="input-group">
          <br>

          <input type="submit" value="Submit">

        </div>
      </div>
    </div>
  </form>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="./register_script.js"></script>

</body>
</html>
