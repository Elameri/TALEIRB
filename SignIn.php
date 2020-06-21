<?php

session_start ();
	
if (!empty($_SESSION['taleirb_my_mail'])) {
	header ('location: index.php');
}

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
	
	<!-- Début du menu fix -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
	<div class="container">
    <a class="navbar-brand" href="#"><img src="logt.png" alt="Logo" width="10%" height="10%"></a>
    <div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
		
			<li class="nav-item">
				<a class="nav-link" href="index.php">Home</a>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" href="SignUp.php">Sign Up</a>
			</li>
		
			<li class="nav-item active">
				<a class="nav-link" href="SignIn.php">Sign In<span class="sr-only">(current)</span></a>
			</li>
			
		</ul>
    </div>
	</div>
	</nav>
	<!-- Fin du menu fix -->

	<!-- Début du contenu de la page -->
	<header class="masthead">
		<div class="row h-100 align-items-center">
		  <div class="col-12 text-center">
		  
				<!-- début du formulaire -->
					<h2 class="font-weight-light">Sign In</h2>

							
							<div class="form-row align-items-center">
							<div class="container">
									<form action="" method="post">
									
									  <div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
										<label for="InputEmail" class="sr-only">Email</label>
										<div class="col-sm-10">
										  <input type="email" class="form-control" name="InputEmail" placeholder="Email">
										</div>
									  </div> </div> </div>
									  
									  <div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
										<label for="InputPassword" class="sr-only">Password</label>
										<div class="col-sm-10">
										  <input type="password" class="form-control" name="InputPassword" placeholder="Password">
										</div>
									  </div> </div> </div>

									  <div class="col-auto my-1"> <button name="submit" type="submit" class="btn btn-primary">Sign In</button></div>
									
									</form>
							</div>
							</div>
				<!-- fin du formulaire -->
				
		  </div>
		</div>  
	</header>
	<!-- fin du contenu de la page -->
		
	
	
    <?php
    if (isset($_POST['submit']))
    {     
		include("config.php");
		//session_start();
		$mail=$_POST['InputEmail'];
		$pass=$_POST['InputPassword'];
		$_SESSION['taleirb_my_mail']=$mail; 
		
		$query = mysqli_query($conn, "SELECT firstname FROM users WHERE email='$mail' and password='$pass'");
		
		if (mysqli_num_rows($query) != 0) {
			echo "<script language='javascript' type='text/javascript'> location.href='index.php' </script>";   
		}
		else {
			echo "<script type='text/javascript'>alert('User Name Or Password Invalid!')</script>";
		}
		
		
		$query2 = mysqli_query($conn, "SELECT pseudo FROM users WHERE email='$mail' and password='$pass'");
		$row = mysqli_fetch_array($query2);
		$_SESSION['taleirb_pseudo'] = $row['pseudo'];
    }
    ?>


	</body>
</html>