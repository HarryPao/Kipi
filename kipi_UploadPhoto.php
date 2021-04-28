<?php
    session_start();
    include("kipi_pdoInc.php");
?>


<?php

if(isset($_FILES['image']) && isset($_POST['content'])){

    $likes = 0;
    $comments = 0;

    $sth = $dbh->prepare("insert into post (content, photo, likes, user_account, comments) values (?, ?, ?, ?, ?)");
// You can find more information in the PHP documentation

    $fp = fopen($_FILES['image']['tmp_name'], 'rb');
    
    //$user_account = 0;

    $sth->bindParam(1, $_POST['content']);
    $sth->bindParam(2, $fp, PDO::PARAM_LOB);
    $sth->bindParam(3, $likes);
    $sth->bindParam(4, $_SESSION['account']);

    $sth->bindParam(5, $comments);

    $dbh->beginTransaction();
    $sth->execute();
    $dbh->commit();

    echo  '<meta http-equiv=REFRESH CONTENT=0;url=kipi_PersonalPage.php>';
}
?>

<html>
<head>
	<meta charset="utf-8" />
    <title>UploadPhoto</title>
	<link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="style.css" />
	<style>textarea{vertical-align:top}</style>
	<style>
		 .header {
            padding: 170px 30px 130px;
            background-image: url(4.jpg);
            background-size: cover;
            /*background-position-x: -200px; */

            background-position-y: -300px;
        }

        .contact {
            padding: 80px 0 150px;
            /*padding: 上 左右 下;*/
        }

        .contact-form {
            width: 50%;
            margin: 50px auto 0;
            /*margin: 上 左右 下*/
            padding-left: 600px;
            /*離左邊多少*/
        }

            .contact-form input[type=file] {
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
            .contact-form textarea {
                display: block;
                width: 100%;
                margin-bottom: 10px;
                /*margin-right: -1000px;*/
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
            
           
            .contact-form input[type=submit] {
                display: block;
                width: 200px;
                margin: 40px auto 0;
                padding: 15px;
                border: 1px solid rgba(255,255,255,0.4);
                border-radius: 5px;
                background-color: transparent;
                color: rgb(255, 228, 107);
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

        .site-title-sub {
            margin: 0 0 30px;
            letter-spacing: 1px;
            font-size: 2.2rem;
        }

            .site-title-sub::before,
            .site-title-sub::after {
                content: '';
                display: inline-block;
                width: 140px;
                height: 2px;
                margin: 0 30px;
                background-color: #fff;
                vertical-align: middle;
            }

        .site-title {
            margin: 50px 0 40px;
            font-size: 7.6rem;
        }

        .site-description {
            margin-bottom: 50px;
            color: #888;
            font-size: 1.6rem;
        }

        /*.button {
            display: inline-block;
            width: 200px;
            padding: 20px;
            border-radius: 4px;
            background-color: #afa58d;
            color: #fff;
            text-decoration: none;
            letter-spacing: 1px;
            font-size: 1.2rem;
        }*/

            .button:hover {
                opacity: 0.9;
            }



        p {
            font-family: Arial;
            font-size: 20pt;
            color: rgb(255, 228, 107);
             /*background-color: rgb(255, 228, 107);*/
            /*color: #000000;*/
        }

        h2 {
            font-family: Arial;
            font-size: 50pt;
            color: rgb(255, 228, 107);

            /*color: #000000;*/
        }
       /* ::placeholder {
            color: tomato;
            font-size: 0.9em;
            font-weight: bold;
            padding-left: 1em;
        }*/

	</style>
</head>
<body bgcolor="#ccccff">
<!--<a href="php_pdo_dz_index.php">首頁</a>-->
<header class="header">
		<form class="contact-form" action="kipi_UploadPhoto.php" method="post" enctype="multipart/form-data">
			<h2 class="heading" align="center"><p>Upload Photo</p></h2>
			<!-- 上傳照片：<br> -->
			<input type="file" name="image"><br> 
			<h2 class="heading" align="center"><p>Write Something...</p></h2>
			<!-- 寫些什麼...<br> -->
			<textarea name="content"></textarea><br>
			<input type="submit" value="Post">
		</form>
</header>
<!-- <hr> -->
</body>
</html>