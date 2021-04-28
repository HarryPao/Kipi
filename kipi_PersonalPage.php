<?php
session_start();
include('kipi_pdoInc.php');
$_SESSION['posts'];
$_SESSION['search'] = $_SESSION['account'];
?>

<?php
	if(isset($_POST['search'])){
		$_SESSION['search'] = htmlspecialchars($_POST['search']);
	}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <style >
      
         input{
                display: block;
                width: 50%;
                /*padding-left: 550px;*/
                margin-left: 400px;
                margin-bottom: 10px;
                margin-top:30px;
                /*中間空多少*/
                padding: 15px;
                /*內距多少*/
                border: 1px solid rgba(255,255,255,0.4);
                border-radius: 0;
                /*數字越大，角就會越圓*/
                /*background-color: rgba(255,255,255,0.05);*/
                background-color: rgb(250, 250, 250);
                
                color: #ADADAD;
            }
            body{
                padding-left: 550px;
            }
            h10 {
                margin-left: 400px;
                font-family: Arial;
                font-size: 30pt;
                color: #000000;

            }
    </style>
</head>
<body>
	<!-- <h2 class="heading" align="center">Search</h2> -->
	<br><br><br>
	<form action="kipi_PersonalPage.php" method="POST" >
        <h10> Search:</h10><input type="search" name="search" class="light-table-filter" data-table="order-table" placeholder="搜尋名稱">
        <hr>
     </form>  
</body>
</html>


<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Kipi-my profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="./kipi_PersonalPage_style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<header>

	<div class="container">
		<div class="profile">
			<div class="profile-image">
			<?php
				$sth = $dbh->prepare("SELECT profile_img, intro from user where account=?");
				$sth->execute(array($_SESSION['search']));
				$sth->bindColumn(1, $lob, PDO::PARAM_LOB);
				$sth->bindColumn(2, $intro);
				$row = $sth->fetch(PDO::FETCH_BOUND);
				echo  '<img src="data:image/jpeg;base64,'.base64_encode( $lob ).'" height="135" width="135" alt=\'\'>';
			?>
			</div>
			<div class="profile-user-settings">
				<h1 class="profile-user-name"><?php echo $_SESSION['search'];?></h1>
				<?php
					if($_SESSION['search'] == $_SESSION['account']){
						echo '<button class="btn profile-edit-btn"><a href = "kipi_EditProfile.php">Edit Profile</a></button>';
						echo '<button class="btn profile-edit-btn"><a href = "kipi_UploadPhoto.php">Post</a></button>';
						echo '<button class="btn profile-settings-btn" aria-label="profile settings"><i class="fas fa-cog" aria-hidden="true"></i></button>';
					}
				?>

			</div>
			<div class="profile-stats">
				<ul>
					<li><span class="profile-stat-count"><?php echo $_SESSION['posts'];?></span> posts</li>
					<li><span class="profile-stat-count">188</span> followers</li>
					<li><span class="profile-stat-count">206</span> following</li>
				</ul>
			</div>
			<div class="profile-bio">
				<?php
					$sth = $dbh->prepare("SELECT intro from user where account=?");
					$sth->execute(array($_SESSION['search']));
					$sth->bindColumn(1, $intro);
					$new_intro = htmlspecialchars($intro);

					echo '<p><span class="profile-real-name">'.$_SESSION['search'].'</span> '.$new_intro.'</p>';
				?>
				
			</div>
		</div>
		<!-- End of profile section -->
	</div>
	<!-- End of container -->

</header>

<main>

	<div class="container">

		
		<div class="gallery">

			<?php
				$sth = $dbh->prepare("SELECT photo, likes, comments, id from post where user_account=?");
				$sth->execute(array($_SESSION['search']));
				$sth->bindColumn(1, $lob, PDO::PARAM_LOB);
				$sth->bindColumn(2, $likes);
				$sth->bindColumn(3, $comments);
				$sth->bindColumn(4, $id);

				$_SESSION['posts'] = 0;
				$posts = 0;

				while($row = $sth->fetch(PDO::FETCH_BOUND) ){
					
					$posts++;
					$_SESSION['posts'] = $posts;

			    	echo'<div class="gallery-item" tabindex="0">';
 
					echo   '<a href="kipi_post.php?id='.$id.'"><img src="data:image/jpeg;base64,'.base64_encode( $lob ).'" class=\'gallery-image\' alt=\'\'></a>';

/*				echo   '<div class="gallery-item-info">
							<ul>
							
								<li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i> '.$likes.'</li>
								<li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i> '.$comments.'</li>	
							</ul>
						</div>
						*/
					echo '</div>';
				}
			?>

		</div>
		<!-- End of gallery -->

		<!--<div class="loader"></div>-->

	</div>
	<!-- End of container -->

</main>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
