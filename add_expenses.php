<?php

session_start ();
include("config.php");

if (empty($_SESSION['taleirb_my_mail'])) {
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

			<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

			<li class="nav-item"><a class="nav-link" href="friends.php">Friends</a></li>

			<li class="nav-item active"><a class="nav-link" href="transactions.php">Transactions<span class="sr-only">(current)</span></a></li>
			
			<li class="nav-item"><a class="nav-link" href="groups.php">Groups</a></li>

			<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>

		</ul>
    </div>
	</div>
	</nav>
	<!-- Fin du menu fix -->

	<!-- Début du contenu de la page -->


	<header class="masthead">
	  <div class="container h-100">
		<div class="row h-100 align-items-center">
		  <div class="col-12 text-center">
			<h1 class="font-weight-light">I'm</h1>

				<div class="col-auto my-1"> 
					
					<a href="add_expenses_receiver.php"><button type="submit" class="btn btn-success">The Sender</button></a>
					<a href="add_expenses_sender.php"><button type="button" class="btn btn-primary">The Receiver</button></a>
					
				</div>
		  </div>
		</div>
	  </div>
	</header>


	</body>
</html>
