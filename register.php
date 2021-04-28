<?php
session_start();
include("kipi_pdoInc.php");
//$_FILES['profile_img'] = NULL;
?>

<?php
$resultStr = '';

if(isset($_POST['account']) && isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['day'])&& isset($_POST['month'])&& isset($_POST['year'])&& isset($_POST['gender'])&& isset($_POST['job'])&& isset($_POST['education'])&& isset($_POST['intro']) &&isset($_POST['accept'])){
        

        $sth2 = $dbh->prepare('SELECT * FROM user WHERE account= ?  ');
        $sth2->execute(array($_POST['account']));
        $row = $sth2->fetch(PDO::FETCH_ASSOC);
        
        if( isset($row['account'])!= "" ){
           $resultStr = '此帳號已經有人註冊！';
        }
        else{
            if(isset($_POST['day']) &&  isset($_POST['month'])  &&  isset($_POST['year']) ){
              $birthday=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
            }
            $sth = $dbh->prepare(
              "insert into user (account, pwd, email, birthday, gender, job, education, intro, profile_img, nickname, authority) values (?, md5(?), ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          
            if(isset($_FILES['image'])){
              $fp = fopen($_FILES['image']['tmp_name'], 'rb');
            }

            if($_POST['account'] != ''){

                $nickname = 0;
                $authority = 0;
                
                $sth->bindParam(1, $_POST['account']);
                $sth->bindParam(2, $_POST['pwd']);
                $sth->bindParam(3, $_POST['email']);
                $sth->bindParam(4, $birthday);
                $sth->bindParam(5, $_POST['gender']);
                $sth->bindParam(6, $_POST['job']);
                $sth->bindParam(7, $_POST['education']);
                $sth->bindParam(8, $_POST['intro']);
                $sth->bindParam(9, $fp, PDO::PARAM_LOB);
                
                $sth->bindParam(10, $nickname);
                $sth->bindParam(11, $authority);

                $dbh->beginTransaction();
                $sth->execute();
                $dbh->commit();
                
                $resultStr = 'Sign up successfully! Please return to the Login Page and login.';
           
            }
      }      
}

?>




<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Kipi - Sign Up</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'><link rel="stylesheet" href="./register_style.css">

</head>

<body>
<!-- partial:index.partial.html -->
<div class="container">
  <?php echo $resultStr;?>
  <form action="register.php" method="POST" enctype="multipart/form-data">
    <div class="row">
      <h4>Account</h4>
      <div class="input-group input-group-icon">
        <input type="text" name="account" placeholder="Name"/>
        <div class="input-icon"><i class="fa fa-user"></i></div>
      </div>
      <div class="input-group input-group-icon">
        <input type="email" name="email" placeholder="Email"/>
        <div class="input-icon"><i class="fa fa-envelope"></i></div>
      </div>
      <div class="input-group input-group-icon">
        <input type="password" name="pwd" placeholder="password"/>
        <div class="input-icon"><i class="fa fa-key"></i></div>
      </div>
    </div>
    <div class="row">
      <div class="col-half">
        <h4>Birthday</h4>
        <div class="input-group">
          <div class="col-third">
            <input type="text" name="day" placeholder="DD"/>
          </div>
          <div class="col-third">
            <input type="text" name="month" placeholder="MM"/>
          </div>
          <div class="col-third">
            <input type="text" name="year" placeholder="YYYY"/>
          </div>
        </div>
      </div>
      <div class="col-half">
        <h4>Gender</h4>
        <div class="input-group">
          <input type="radio" name="gender" value="male" id="gender-male"/>
          <label for="gender-male">Male</label>
          <input type="radio" name="gender" value="female" id="gender-female"/>
          <label for="gender-female">Female</label>
        </div>
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
      <h4>Terms and Conditions</h4>
      <div class="input-group">
        <input type="checkbox" name="accept" id="terms"/>
        <label for="terms">I accept the terms and conditions for signing up to this service, and hereby confirm I have read the privacy policy.</label>
      </div>
    </div>
    <div class="row">
      <div class="col-submit">
        <div class="input-group">
          <br>

          <input type="submit" value="送出">
           <input type="button" value="Login" onclick="self.location.href= ' ./kipi_login.php '  ">

        </div>
      </div>
    </div>
  </form>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="./register_script.js"></script>

</body>
</html>
