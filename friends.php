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


	<?php

	//$res= mysqli_query($conn, " SELECT * FROM users WHERE email='$mail_session'");
	//$row = mysqli_fetch_array($res);
	//echo $row['id'];

	// la table friends ne doit pas avoir de clé primaire
	if ((isset($_POST['submit']) and  (!empty($_POST['mail']))) or (isset($_POST['submit']) and  (!empty($_POST['pseudo']))))

	{
		$mail_ami = $_POST['mail'];
		$pseudo_ami = $_POST['pseudo'];

		if (!empty($mail_ami)) {
		//à partir du mail: récuperer l'id, le prenom et le nom du nouvel ami
		$result = mysqli_query($conn, "SELECT id FROM users WHERE email='$mail_ami'");
		$row = mysqli_fetch_array($result);
		$idami = $row['id'];
		$num = mysqli_num_rows($result);
		}

		if (!empty($pseudo_ami)) {
		//à partir du pseudo: récuperer l'id, le prenom et le nom du nouvel ami
		$result = mysqli_query($conn, "SELECT id FROM users WHERE pseudo='$pseudo_ami'");
		$row = mysqli_fetch_array($result);
		$idami = $row['id'];
		$num = mysqli_num_rows($result);
		}

		if($num != 0){
			//insérer id et id_ami dans la base de données friends
			mysqli_query($conn, " insert into friends(id, id_ami) values ('$notre_id', '$idami')");
			echo "<meta http-equiv='refresh' content='0'>";
		}

		else{
			echo' <p style="color:#ed0c0c;">This person is not a user of TALEIRB yet. Invite him !</p>';
		}

	}




	?>



    <div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">

			<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

			<li class="nav-item active"><a class="nav-link" href="friends.php">Friends<span class="sr-only">(current)</span></a></li>

			<li class="nav-item"><a class="nav-link" href="Transactions.php">Transactions</a></li>

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



	if (isset($_SESSION['taleirb_somme'])){

		$sm_totale = $_SESSION['taleirb_somme'];

		if ($sm_totale >= 0){
			echo "<h2 class=\"font-weight-light\" style=\"color:green\">Total Balance: $sm_totale</h2>";
		}

		else{
			echo "<h2 class=\"font-weight-light\" style=\"color:red\">Total Balance: $sm_totale</h2>";
		}
	}

	echo "<h2 class=\"font-weight-light\" style=\"color:darkblue\">Friends</h2>";

	?>

	<!--<h2 class="font-weight-light">Friends</h2>-->
	<div class="form-row align-items-center">
	<div class="container">

    <div class="right_bar ">
    <div class="tab-content ">
	<div class="tab-pane fade show active" id="lorem" role="tabpanel">

	<table class="table table-bordered">
		<thead>
			  <tr>
				<th>@Pseudo</th>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Balance</th>
				<th></th>
			  </tr>
		</thead>


			<?php
				$result1 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id_ami=users.id WHERE friends.id='$notre_id'");
				$result2 = mysqli_query($conn, "SELECT DISTINCT users.id, firstname, pseudo, lastname FROM users JOIN friends ON friends.id=users.id WHERE friends.id_ami='$notre_id'");

			?>

		<tbody>

			<?php

				$somme_totale = 0;

				while($row = mysqli_fetch_array($result1)) {
					echo "<tr>";
					echo "<td>"; echo $row['pseudo']; echo "</td>";
					echo "<td>"; echo $row['firstname']; echo "</td>";
					echo "<td>"; echo $row['lastname']; echo "</td>";

					$psd1=$row['pseudo'];
					$somme = 0;

					$id_frnd = $row['id'];


					$full_sum_amnt = mysqli_query($conn, "SELECT sender_id, receiver_id, amount, status FROM transactions WHERE (sender_id='$id_frnd') OR (receiver_id='$id_frnd')");
					while($row_sum_amnt = mysqli_fetch_array($full_sum_amnt)) {
						$sndr_id = $row_sum_amnt['sender_id'];
						$rcvr_id = $row_sum_amnt['receiver_id'];
						$the_amnt = $row_sum_amnt['amount'];

						if ($row_sum_amnt['status'] == 'Opened'){
							if ($sndr_id == $id_frnd) {
								$somme = $somme - $the_amnt;

							}
							if ($rcvr_id == $id_frnd) {
								$somme = $somme + $the_amnt;
							}
						}
					}


					if ($somme >= 0) {
						echo "<td style='color:forestgreen'>"; echo $somme;echo "€"; echo "</td>";
					}
					else {
						echo "<td style='color:red'>"; echo $somme;echo "€"; echo "</td>";
					}

					$somme_totale = $somme_totale + $somme;

					echo '<form action="" method="post">';
					echo "<input type=\"hidden\" name=\"somme_avec\" value = \"$somme\"/>";
					echo "<td>"; echo "<a><button name = \"delete\" type=\"submit\" value = \"$psd1\" class=\"btn btn-danger\">Delete</button></a>"; echo"</td>";
					echo '</form>';
					echo "</tr>";
				}

				while($row = mysqli_fetch_array($result2)) {
					echo "<tr>";
					echo "<td>"; echo $row['pseudo']; echo "</td>";
					echo "<td>"; echo $row['firstname']; echo "</td>";
					echo "<td>"; echo $row['lastname']; echo "</td>";

					$psd2=$row['pseudo'];
					$somme = 0;

					$id_frnd = $row['id'];
					$full_sum_amnt = mysqli_query($conn, "SELECT sender_id, receiver_id, amount, status FROM transactions WHERE (sender_id='$id_frnd') OR (receiver_id='$id_frnd')");
					while($row_sum_amnt = mysqli_fetch_array($full_sum_amnt)) {
						$sndr_id = $row_sum_amnt['sender_id'];
						$rcvr_id = $row_sum_amnt['receiver_id'];
						$the_amnt = $row_sum_amnt['amount'];

						if ($row_sum_amnt['status'] == 'Opened'){
							if ($sndr_id == $id_frnd) {
								$somme = $somme - intval($the_amnt);
							}
							if ($rcvr_id == $id_frnd) {
								$somme = $somme + $the_amnt;
							}
						}
					}
					if ($somme >= 0) {
						echo "<td style='color:forestgreen'>"; echo $somme;echo "€"; echo "</td>";
					}
					else {
						echo "<td style='color:red'>"; echo $somme;echo "€"; echo "</td>";
					}

					$somme_totale = $somme_totale + $somme;

					echo '<form action="" method="post">';
					echo "<input type=\"hidden\" name=\"somme_avec\" value = \"$somme\"/>";
					echo "<td>"; echo "<a><button name = \"delete\" type=\"submit\" value = \"$psd2\" class=\"btn btn-danger\">Delete</button></a>"; echo"</td>";
					echo '</form>';
					echo "</tr>";

					$_SESSION['taleirb_somme'] = $somme_totale;
				}


				if (isset($_POST['delete'])){
					$psd = $_POST['delete'];
					$sum_with = $_POST['somme_avec'];

					$id_psd_row = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM users WHERE pseudo='$psd' "));
					$id_psd = $id_psd_row['id'];
					if ($sum_with == 0){
						mysqli_query($conn, "DELETE FROM friends WHERE ((id = '$notre_id' AND id_ami = '$id_psd') OR (id = '$id_psd' AND id_ami = '$notre_id'))");
						echo "<meta http-equiv='refresh' content='0'>";
					}
					else {
						echo' <p style="color:#ed0c0c;">To delete a friend the balance must be 0€</p>';
					}

				}
			?>






			  <!--
			  <tr>
				<td>Théophile</td>
				<td>Cathelineau</td>
				<td style="color:#21c004;">+33€</td>
			  </tr>
			  -->
		</tbody>
	</table>



	</div>
	</div>
    </div>

	</div>
	</div>
	<!-- fin du formulaire -->


	<div class="container">
	<div class="d-flex justify-content-center">
	<form action="" method="post">
	<div class= "form-row align-items-center">




		<div class="col-sm-4">
		  <label class="sr-only" for="InlineFormInputPseudo">Pseudo</label>
		  <div class="input-group">
			<div class="input-group-prepend"><div class="input-group-text">@</div></div>
			<input type="text" name="pseudo" class="form-control" placeholder="Pseudo">
		  </div>
		</div>

		<div>
		  <label class="sr-only" for="InlineInputEmail">Email</label>
		  <input type="email" name="mail" class="form-control" placeholder="Email">
		</div>


		<div class="col-auto my-1">
		  <button name="submit" type="submit" class="btn btn-primary">Add friend</button>
		</div>



	</div>
	</form>
	</div>
	</div>








	<!-- fin du contenu de la page -->
	</div>
	</div>
	</header>




	</body>
</html>
