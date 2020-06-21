<?php

	session_start ();
	include("config.php");

	if (empty($_SESSION['taleirb_my_mail'])) {
		header ('location: index.php');
	}
	
	//récuperer notre email qui est l'email de la session
	$mail_session=$_SESSION['taleirb_my_mail'];
	$pseudo_session=$_SESSION['taleirb_pseudo'];
	
	if (isset($_SESSION['taleirb_id_the_friend'])){
		$the_friend_id=$_SESSION['taleirb_id_the_friend'];
	}
	
	if (isset($_SESSION['taleirb_id_transac'])){
		$transac_id=$_SESSION['taleirb_id_transac'];
	}
	
	

	//récuperer notre id
	$result = mysqli_query($conn, "SELECT id FROM users WHERE email='$mail_session'");
	$row = mysqli_fetch_array($result);  // rend le resultat de la query un tableau utilisable de données
	$notre_id = $row['id'];     // prend la case qu'on veut


	if (isset($_POST['submit']))
	{
		$status = $_POST['status'];
		$message = $_POST['explicatif_message'];
		$date = $_POST['date'];
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
	<?php
	
	$une_transaction = mysqli_query($conn, "SELECT sender_id, receiver_id, message, amount FROM transactions WHERE transac_id='$transac_id'");
	$row_transaction = mysqli_fetch_array($une_transaction);
	$sender = $row_transaction['sender_id'];
	$receiver = $row_transaction['receiver_id'];
	$msg = $row_transaction['message'];
	$amnt = $row_transaction['amount'];
	
	$full_name_sender = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$sender'");
	$row_full_name_s = mysqli_fetch_array($full_name_sender);
	$s_f_name = $row_full_name_s['firstname'];
	$s_l_name = $row_full_name_s['lastname'];
	
	$full_name_receiver = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$receiver'");
	$row_full_name_r = mysqli_fetch_array($full_name_receiver);
	$r_f_name = $row_full_name_r['firstname'];
	$r_l_name = $row_full_name_r['lastname'];
	
	
			
	echo "<div class=\"text-success\"><h2 class=\"font-weight-light\">Close this Transaction : </h2></div>";
	echo "<h2 class=\"font-weight-light\" style=\"color:red\">$s_f_name $s_l_name paid $amnt ‎€ for $r_f_name $r_l_name</h2>";
	echo "<h2 class=\"font-weight-light\" style=\"color:red\">for $msg</h2>";
	?>
	
	<div class="form-row align-items-center">
	<div class="container">

    <div class="right_bar ">
    <div class="tab-content ">
	<div class="tab-pane fade show active" id="lorem" role="tabpanel">


	<?php
	if (isset($_POST['submit'])){
			
		if (!empty($message)) {
		mysqli_query($conn, "UPDATE transactions SET status = '$status', closing_msg = '$message', closing_date = '$date' WHERE transac_id = '$transac_id'");
		//mysqli_query($conn, " insert into transactions(sender_id, receiver_id, message, amount, date) values ('$notre_id', '$receiver_id', '$message', '$amount', '$date')");
		echo' <p style="color:#21c004;">Transaction closed successfully</p>';
		}
		
	}

	?>

	<!-- Ajout d'une dépense -->

	<form action="" method="post">


			<div class="form-group">
				<div class="d-flex justify-content-center"> <div class="w-51 p-1"> <div class="d-flex justify-content-center mx-5">
                   <!--<label for="selection">liste</label>-->
                   <select id="selection" class="form-control" name="status">
                     <optgroup label="Close this transaction by">
                       <option value="Canceled">Cancellation</option>
                       <option value="Refunded">Refund</option>
                     </optgroup>
                   </select>
				</div> </div> </div>
            </div>

			
			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">Closing Message</label>
			<div class="col-sm-10 form-group text-left">
				<input type="text" name="explicatif_message" class="form-control" placeholder="Closing Message">
			</div>
			</div> </div> </div>


			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">Closing Date</label>
			<div class="col-sm-10 form-group text-left">
				<!--<label for="Date">Date :</label>-->
				<input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
			</div>
			</div> </div> </div>

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
