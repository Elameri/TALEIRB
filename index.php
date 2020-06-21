<?php

	//include("config.php");
	session_start();

		
	if (!empty($_SESSION['taleirb_my_mail'])) {
			$login_session=$_SESSION['taleirb_my_mail'];
	}
	//$login_session=$_SESSION['taleirb_my_mail'];
	//echo $login_session;
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<title> Taleirb </title>
		
		<!-- css -->
		<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">

	</head>
	
	<body>
	
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
		<div class="container">
    <a class="navbar-brand" href="#"><img src="logt.png" alt="Logo" width="10%" height="10%"></a>

    <div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
				<a class="nav-link" href="index.php">Home
					<span class="sr-only">(current)</span>
				</a>
			</li>
			
			<?php
			if (!empty($login_session)) {
				echo '<li class="nav-item"><a class="nav-link" href="friends.php">Friends</a></li>';
				echo '<li class="nav-item"><a class="nav-link" href="transactions.php">Transactions</a></li>';
				echo '<li class="nav-item"><a class="nav-link" href="groups.php">Groups</a></li>';
				echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
			}
			else {
				echo '<li class="nav-item"><a class="nav-link" href="SignUp.php">Sign Up</a></li>';
				echo '<li class="nav-item"><a class="nav-link" href="SignIn.php">Sign In</a></li>';
			}
			?>

		
		
		</ul>
    </div>
	</div>
	</nav>

<!-- Full Page Image Header with Vertically Centered Content -->
<header class="masthead">
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-12 text-center">
		<img src="logof.png" alt="Logo de Taleirb" width="300" height="300">
        <h1 class="font-weight-light">TALEIRB</h1>
        <p class="lead">Organise expenses with your friends/partners</p>
		
			<?php
			if (!empty($login_session)) {
				echo $login_session;
			}
			?>
		
			<div class="col-auto my-1"> 
				<?php
				if (!empty($login_session)) {
					echo '<a href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a>';
				}
				else {
					echo ' <a href="SignIn.php"><button type="submit" class="btn btn-primary">Sign In</button></a>';
					echo ' <a href="SignUp.php"><button type="button" class="btn btn-primary">Sign Up</button></a>';
				}
				?>
			</div>
      </div>
    </div>
  </div>
</header>



	</body>
</html>