<?php

session_start ();
	
if (!empty($_SESSION['taleirb_my_mail'])) {
	header ('location: index.php');
}


if (isset($_POST['submit']))
{     
	include("config.php");
	//session_start();
	$prenom = $_POST['InputFirstName'];
	$nom = $_POST['InputLastName'];
	$pseudo = $_POST['InputPseudo'];
	$mail = $_POST['InputEmail'];
	$mdp = $_POST['InputPassword'];
		
	// on recupere et on compte le numero de users qu'on a avec cet email
	$result = mysqli_query($conn, " select * from users where email = '$mail'");
	$num = mysqli_num_rows($result);
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
		
			<li class="nav-item active">
				<a class="nav-link" href="SignUp.php">Sign Up<span class="sr-only">(current)</span></a>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" href="SignIn.php">Sign In</a>
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

			<h2 class="font-weight-light">Sign Up</h2>

				
					<div class="form-row align-items-center">
					<div class="container">
					
					
					<?php
					if (isset($_POST['submit'])) {
						// si on a deja un utilisateur avec cet email
						if($num == 1){

							echo' <p style="color:#ed0c0c;">Email Already Used</p>';
						}
						else {
							mysqli_query($conn, " insert into users(firstname, lastname, pseudo, email, password) values ('$prenom', '$nom', '$pseudo', '$mail', '$mdp')");

							echo' <p style="color:#21c004;">Registration Successful</p>';
						}
					}
					?>
					
					<form action="" method="post">
					
						  <div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
							<label class="sr-only">First Name</label>
							<div class="col-sm-10">
							  <input type="text" name="InputFirstName" class="form-control" placeholder="First Name">
							</div>
						  </div> </div> </div>
						  
						  <div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
							<label class="sr-only">Last Name</label>
							<div class="col-sm-10">
							  <input type="text" name="InputLastName" class="form-control" placeholder="Last Name">
							</div>
						  </div> </div> </div>
						  
						  <div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
							<label class="sr-only">Pseudo</label>
							<div class="col-sm-10">
							<div class="input-group">
							  <div class="input-group-prepend"><div class="input-group-text">@</div></div>
							  <input type="text" name="InputPseudo" class="form-control" placeholder="Pseudo">
							</div>
							</div>
						  </div> </div> </div>
						  
						  <div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
							<label class="sr-only">Email</label>
							<div class="col-sm-10">
							  <input type="email" name="InputEmail" class="form-control" placeholder="Email">
							</div>
						  </div> </div> </div>

						  <div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
							<label class="sr-only">Password</label>
							<div class="col-sm-10">
							  <input type="password" name="InputPassword" class="form-control" placeholder="Password">
							</div>
						  </div> </div> </div>
						  
						  <!-- <div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5"> -->
							<!-- <label class="sr-only">Confirm Password</label> -->
							<!-- <div class="col-sm-10"> -->
							  <!-- <input type="password" name="InputPassword" class="form-control" placeholder="Confirm Password"> -->
							<!-- </div> -->
						  <!-- </div> </div> </div> -->
						  

						  <div class="col-auto my-1"> <button name ="submit" type="submit" class="btn btn-primary">Register</button></div>
						  
					</form>
					</div>	
					</div>

		<!-- fin du formulaire -->
		
		  </div>
		</div>
	</header>
	<!-- Fin du contenu de la page -->
	





	</body>
</html>



