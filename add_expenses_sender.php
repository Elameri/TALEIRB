<?php

	session_start ();
	include("config.php");

	if (empty($_SESSION['taleirb_my_mail'])) {
		header ('location: index.php');
	}
	
	//récuperer notre email qui est l'email de la session
	$mail_session=$_SESSION['taleirb_my_mail'];
	$pseudo_session=$_SESSION['taleirb_pseudo'];

	//récuperer notre id
	$result = mysqli_query($conn, "SELECT id FROM users WHERE email='$mail_session'");
	$row = mysqli_fetch_array($result);  // rend le resultat de la query un tableau utilisable de données
	$notre_id = $row['id'];     // prend la case qu'on veut


	if (isset($_POST['submit']))
	{
		$sender_pseudo = $_POST['sender_pseudo'];
		$sender_email = $_POST['sender_email'];
		$message = $_POST['explicatif_message'];
		$amount = $_POST['amount'];
		$date = $_POST['date'];
		$status = $_POST['status'];
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
	<div class="row h-100 align-items-center">
	<div class="col-12 text-center">

	<!-- début du formulaire -->
	<div class="text-primary"><h2 class="font-weight-light">I'm the receiver of this Transaction</h2></div>
	<div class="form-row align-items-center">
	<div class="container">

    <div class="right_bar ">
    <div class="tab-content ">
	<div class="tab-pane fade show active" id="lorem" role="tabpanel">


	<?php
	if (isset($_POST['submit'])){
		
		if (!empty($sender_email)) {
		//à partir du mail: récuperer l'id
		$result = mysqli_query($conn, "SELECT id FROM users WHERE email='$sender_email'");
		$row = mysqli_fetch_array($result);
		$sender_id = $row['id'];
		}
			
		if (!empty($sender_pseudo)) {
		//à partir du pseudo: récuperer l'id
		$result = mysqli_query($conn, "SELECT id FROM users WHERE pseudo='$sender_pseudo'");
		$row = mysqli_fetch_array($result);
		$sender_id = $row['id'];
		}

		
		if (!empty($sender_id)) {
			$est_ce_un_ami = mysqli_query($conn, " SELECT * FROM friends WHERE ((id = '$notre_id' AND id_ami = '$sender_id') OR (id = '$sender_id' AND id_ami = '$notre_id')) ");
			$num = mysqli_num_rows($est_ce_un_ami);
			
			if($num == 0){

				echo' <p style="color:#ed0c0c;">This person is not a friend of yours. Add him first in the FRIENDS page</p>';
			}
			else {
				mysqli_query($conn, " insert into transactions(sender_id, receiver_id, message, amount, date, status) values ('$sender_id', '$notre_id', '$message', '$amount', '$date', '$status')");
				echo' <p style="color:#21c004;">Transaction added successfully</p>';
			}
		}
		else {
			echo' <p style="color:#ed0c0c;">This person is not a user of TALEIRB yet. Invite him !</p>';
		}
	}

	?>

	<!-- Ajout d'une dépense -->


	<form action="" method="post">

			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">The sender</label>
			<div class="col-sm-10 form-group text-left">
				<input type="text" name="sender_pseudo" class="form-control" placeholder="Sender's @Pseudo">
			</div>
			</div> </div> </div>
			
			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">The Sender</label>
			<div class="col-sm-10 form-group text-left">
				<input type="email" name="sender_email" class="form-control" placeholder="OR Sender's email @address">
			</div>
			</div> </div> </div>
			
			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">Explicatif Message</label>
			<div class="col-sm-10 form-group text-left">
				<input type="text" name="explicatif_message" class="form-control" placeholder="Message of the transaction">
			</div>
			</div> </div> </div>

			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">Amount</label>
			<div class="col-sm-10 form-group text-left">
				<input type="text" name="amount" class="form-control" placeholder="Amount (‎€)">
			</div>
			</div> </div> </div>

			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">Date</label>
			<div class="col-sm-10 form-group text-left">
				<input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
			</div>
			</div> </div> </div>

			<div class="form-group">
				<div class="d-flex justify-content-center"> <div class="w-51 p-1"> <div class="d-flex justify-content-center mx-5">
                   <!--<label for="selection">liste</label>-->
                   <select id="selection" class="form-control" name="status">
                     <option value="Opened">Opened</option>
                     <option value="Refunded">Refunded</option>
                     <option value="Canceled">Canceled</option>
                   </select>
				</div> </div> </div>
            </div>

			<div class="col-auto my-1"> <button name ="submit" type="submit" class="btn btn-success"> Register </button></div>

			<?php
			echo '<a href="transactions.php"><button type="button" class="btn btn-primary">Return to transactions </button></a>';
			?>

	</form>
	</div>
	</div>




<!-- Actualiser la page transactions.php et rediriger l'utilisateur sur cette page -->


	</div>
	</div>
    </div>

	</div>
	</div>
	<!-- fin du formulaire -->



	<!-- fin du contenu de la page -->
	</div>
	</div>
	</header>


	</body>
</html>
