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
		$sender_id = $_POST['sender'];
		$receiver_1_id = $_POST['receiver1'];
		$receiver_2_id = $_POST['receiver2'];
		$receiver_3_id = $_POST['receiver3'];
		$amount1 = $_POST['amount1'];
		$amount2 = $_POST['amount2'];
		$amount3 = $_POST['amount3'];
		$message = $_POST['exp_message'];
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

			<li class="nav-item"><a class="nav-link" href="transactions.php">Transactions</a></li>

			<li class="nav-item active"><a class="nav-link" href="groups.php">Groups<span class="sr-only">(current)</span></a></li>

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
	<div class="text-primary"><h2 class="font-weight-light">Group Transactions</h2></div>
	<div class="text-danger"><h2 class="font-weight-light">1 Sender & 3 maximum Receivers</h2></div>
	<div class="form-row align-items-center">
	<div class="container">

    <div class="right_bar ">
    <div class="tab-content ">
	<div class="tab-pane fade show active" id="lorem" role="tabpanel">


	<?php
	if (isset($_POST['submit'])){


		if ((!empty($receiver_1_id)) and (!empty($receiver_2_id)) and (!empty($receiver_3_id))) {
			mysqli_query($conn, " insert into groups(sender_id, receiver_id_1, receiver_id_2, receiver_id_3, amount_1, amount_2, amount_3, message, date, status) values ('$sender_id', '$receiver_1_id', '$receiver_2_id', '$receiver_3_id', '$amount1', '$amount2', '$amount3', '$message', '$date', '$status')");
		}
		elseif ((!empty($receiver_1_id)) and (!empty($receiver_2_id))) {
			mysqli_query($conn, " insert into groups(sender_id, receiver_id_1, receiver_id_2, amount_1, amount_2, message, date, status) values ('$sender_id', '$receiver_1_id', '$receiver_2_id', '$amount1', '$amount2', '$message', '$date', '$status')");
		}
		else{
			echo' <p style="color:#ed0c0c;">Please fill at least 2 receiver fields and 2 amount fields</p>';
		}


	}

	?>

	<!-- Ajout d'une dépense -->
	<?php
				$result1 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id_ami=users.id WHERE friends.id='$notre_id'");
				$result2 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id=users.id WHERE friends.id_ami='$notre_id'");

	?>

	<form action="" method="post">


			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">The Sender</label>
			<div class="col-sm-10 form-group text-left">
				<select id="selection" class="form-control" name="sender">
					<option value="">Sender</option>
					<?php
							echo "<option value=\"$notre_id\">"; echo "Me"; echo "</option>";
					$result1 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id_ami=users.id WHERE friends.id='$notre_id'");
					$result2 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id=users.id WHERE friends.id_ami='$notre_id'");
					while($row = mysqli_fetch_array($result1)) {
							$some_id = $row['id'];
							echo "<option value=\"$some_id\">"; echo $row['firstname']; echo " "; echo $row['lastname']; echo "</option>";
					}
					while($row = mysqli_fetch_array($result2)) {
							$some_id = $row['id'];
							echo "<option value=\"$some_id\">"; echo $row['firstname']; echo " "; echo $row['lastname']; echo "</option>";
					}
					?>
				</select>
			</div>
			</div> </div> </div>



			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">The Receivers</label>
			<div class="col-sm-10 form-group text-left">
				<select id="selection" class="form-control" name="receiver1">
					<option value="">Receiver 1</option>

					<?php
							echo "<option value=\"$notre_id\">"; echo "Me"; echo "</option>";
					$result1 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id_ami=users.id WHERE friends.id='$notre_id'");
					$result2 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id=users.id WHERE friends.id_ami='$notre_id'");
					while($row = mysqli_fetch_array($result1)) {
							$some_id = $row['id'];
							echo "<option value=\"$some_id\">"; echo $row['firstname']; echo " "; echo $row['lastname']; echo "</option>";
					}
					while($row = mysqli_fetch_array($result2)) {
							$some_id = $row['id'];
							echo "<option value=\"$some_id\">"; echo $row['firstname']; echo " "; echo $row['lastname']; echo "</option>";
					}
					?>
				</select>
			</div>
			<div class="col-sm-10 form-group text-left">
				<select id="selection" class="form-control" name="receiver2">
					<option value="">Receiver 2</option>
					<?php
							echo "<option value=\"$notre_id\">"; echo "Me"; echo "</option>";
					$result1 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id_ami=users.id WHERE friends.id='$notre_id'");
					$result2 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id=users.id WHERE friends.id_ami='$notre_id'");
					while($row = mysqli_fetch_array($result1)) {
							$some_id = $row['id'];
							echo "<option value=\"$some_id\">"; echo $row['firstname']; echo " "; echo $row['lastname']; echo "</option>";
					}
					while($row = mysqli_fetch_array($result2)) {
							$some_id = $row['id'];
							echo "<option value=\"$some_id\">"; echo $row['firstname']; echo " "; echo $row['lastname']; echo "</option>";
					}
					?>
				</select>
			</div>
			<div class="col-sm-10 form-group text-left">
				<select id="selection" class="form-control" name="receiver3">
					<option value="">Receiver 3</option>

					<?php
							echo "<option value=\"$notre_id\">"; echo "Me"; echo "</option>"; 
					$result1 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id_ami=users.id WHERE friends.id='$notre_id'");
					$result2 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id=users.id WHERE friends.id_ami='$notre_id'");
					while($row = mysqli_fetch_array($result1)) {
							$some_id = $row['id'];
							echo "<option value=\"$some_id\">"; echo $row['firstname']; echo " "; echo $row['lastname']; echo "</option>";
					}
					while($row = mysqli_fetch_array($result2)) {
							$some_id = $row['id'];
							echo "<option value=\"$some_id\">"; echo $row['firstname']; echo " "; echo $row['lastname']; echo "</option>";
					}

					?>
				</select>
			</div>
			</div> </div> </div>



			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">Amounts</label>
			<div class="col-sm-10 form-group text-left">
				<input type="text" name="amount1" class="form-control" placeholder="Amount for receiver 1 in (‎€)">
			</div>
			<div class="col-sm-10 form-group text-left">
				<input type="text" name="amount2" class="form-control" placeholder="Amount for receiver 2 in (‎€)">
			</div>
			<div class="col-sm-10 form-group text-left">
				<input type="text" name="amount3" class="form-control" placeholder="Amount for receiver 3 in (‎€)">
			</div>
			</div> </div> </div>

			<div class="d-flex justify-content-center"> <div class="w-50 p-1"> <div class="d-flex justify-content-center mx-5">
			<label class="sr-only">Message and Date</label>
			<div class="col-sm-10 form-group text-left">
				<input type="text" name="exp_message" class="form-control" placeholder="Message of the transaction">
			</div>
			<div class="col-sm-10 form-group text-left">
				<input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
			</div>
			<div class="col-sm-10 form-group text-left">
				<select id="selection" class="form-control" name="status">
                     <option value="Opened">Opened</option>
                     <option value="Refunded">Refunded</option>
                     <option value="Canceled">Canceled</option>
                   </select>
			</div>
			</div> </div> </div>



			<div class="col-auto my-1"> <button name ="submit" type="submit" class="btn btn-success"> Register </button></div>

			<?php
			echo '<a href="groups.php"><button type="button" class="btn btn-primary">Return to Group transactions </button></a>';
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
