<?php
session_start();
include("kipi_pdoInc.php");
// $_SESSION["email"] = "visitor";
?>
 
<?php

if(isset($_POST['email']) && isset($_POST['pwd'])){
    // $email=preg_replace("/^([\w\.\-]){1,64}\@([\w\.\-]){1,64}$/","",$_POST['email']);
    $email=$_POST['email'];
    $pwd = preg_replace("/[^A-Za-z0-9]/", "", $_POST['pwd']);
    if($email != NULL && $pwd != NULL){
        $sth = $dbh->prepare('SELECT * FROM user where email = ?');
        $sth->execute(array($email));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        
        // 比對密碼
        if($row['pwd'] == md5($pwd)){
            $_SESSION['account'] = htmlspecialchars($row['account']);
            
              echo '<meta http-equiv=REFRESH CONTENT=0;url=kipi_PersonalPage.php>';
        }
        else{
            echo 'Wrong email or password!';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <!-- <link rel="stylesheet" href="css/normalize.css" /> -->
    <link rel="stylesheet" href="style.css" />
    <style>
        .header {
            padding: 170px 30px 130px;
            background-image: url(./sky.png);
            background-size: cover;
            background-position-y: -600px;
        }

        .contact {
            padding: 80px 0 150px;
            /*padding: 上 左右 下;*/
        }

        .contact-form {
            width: 50%;
            margin: 50px auto 0;
            /*margin: 上 左右 下*/
            /*padding-left: 200px;*/
            /*離左邊多少*/
        }

            .contact-form input[type=text] {
                display: block;
                width: 100%;
                margin-bottom: 10px;
                margin-top:30px;
                /*中間空多少*/
                padding: 15px;
                /*內距多少*/
                border: 1px solid rgba(255,255,255,0.4);
                border-radius: 0;
                /*數字越大，角就會越圓*/
                background-color: rgba(255,255,255,0.05);
                color: #fff;
            }
             .contact-form input[type=email] {
                display: block;
                width: 100%;
                margin-bottom: 10px;
                margin-top:30px;
                /*中間空多少*/
                padding: 15px;
                /*內距多少*/
                border: 1px solid rgba(255,255,255,0.4);
                border-radius: 0;
                /*數字越大，角就會越圓*/
                background-color: rgba(255,255,255,0.05);
                color: #fff;
            }

            .contact-form input[type=password] {
                display: block;
                width: 100%;
                margin-bottom: 10px;
                margin-top:5px;
                /*中間空多少*/
                padding: 15px;
                /*內距多少*/
                border: 1px solid rgba(255,255,255,0.4);
                border-radius: 0;
                /*數字越大，角就會越圓*/
                background-color: rgba(255,255,255,0.05);
                color: #fff;
            }

            /*.contact-form textarea {
                height: 150px;
            }*/
            .contact-form input[type=submit] {
                display: block;
                width: 200px;
                margin: 40px auto 0;
                padding: 15px;
                border: 1px solid rgba(255,255,255,0.4);
                border-radius: 5px;
                background-color: transparent;
                color: tomato;
                font-size: 0.9em;
                font-weight: bold;
                padding-left: 1em;
                /*color: rgba(255,255,255,0.6);*/
                cursor: pointer;
                /*變成有一個手在那邊*/
            }
            .contact-form input[type=button] {
                display: block;
                width: 200px;
                margin: 40px auto 0;
                padding: 15px;
                border: 1px solid rgba(255,255,255,0.4);
                border-radius: 5px;
                background-color: transparent;
                color: tomato;
                font-size: 0.9em;
                font-weight: bold;
                padding-left: 1em;
                /*color: rgba(255,255,255,0.6);*/
                cursor: pointer;
                /*變成有一個手在那邊*/
            }

                .contact-form input[type=submit]:hover {
                    background-color: rgba(255,255,255,0.05);
                    /*hover 就是滑鼠碰到的時候會變顏色*/
                }

                .contanct-form input[type=button]:hover {
                    background-color: rgba(255,255,255,0.05)
                }




        .button {
            display: inline-block;
            width: 200px;
            padding: 20px;
            border-radius: 4px;
            background-color: #afa58d;
            color: #fff;
            text-decoration: none;
            letter-spacing: 1px;
            font-size: 1.2rem;
        }

        .button:hover {
                opacity: 0.9;
            }



        p {
            font-family: Arial;
            font-size: 20pt;
            color: #FF4500;
            /*color: #000000;*/
        }

        h2 {
            font-family: Arial;
            font-size: 50pt;
            color: #FF4500;

            /*color: #000000;*/
        }
        ::placeholder {
            color: tomato;
            font-size: 0.9em;
            font-weight: bold;
            padding-left: 1em;
        }

        
    </style>
</head>
<body>
    <header id="header">
        <div class="logo">
            <a href="aboutus3.php">
                Kipi
                <span>
                    By Pao&Jenny
                </span>
            </a>

        </div>

    </header>
   <!-- <section class="contact" id="contact">-->

        <!--<h2 class="heading" align="center"><p>LOGIN</p></h2>-->
    <header class="header">
        <!--<p class="site-title-sub" align="center">Master's Favorite</p>
    <h1 class="site-title" align="center">Life is Trip</h1>
    <p class="site-description" align="center">Welcome to My Web</p>-->
        <form class="contact-form" align="center" action="Kipi_login.php" method="post">
            <h2 class="heading" align="center"><p>LOGIN</p></h2>
            <input type="email" name="email" placeholder="EMAIL"><br /><br />
            <input type="password" name="pwd" placeholder="PASSWORD">
            <input type="submit" value="LOGIN">
            <!--<input type="submit" value="Register">-->
            <input type="button" value="Register" onclick="self.location.href= ' ./register.php '  ">
           

        </form>
    </header>
      
</body>
</html>







