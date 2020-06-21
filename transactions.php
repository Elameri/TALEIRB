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
	<div class="text-primary"><h2 class="font-weight-light">Transactions</h2></div>
	<div class="form-row align-items-center">
	<div class="container">

    <div class="right_bar ">
    <div class="tab-content ">
	<div class="tab-pane fade show active" id="lorem" role="tabpanel">

	<table class="table table-bordered">
		<thead>
			  <tr>
				<th>Sender</th>
				<th>Receiver</th>
				<th>Amount (‎€)</th>
				<th>Reason of the transaction</th>
				<th>When</th>
				<th>Status</th>
				<th></th>
			  </tr>
		</thead>

		<?php
			$our_transactions = mysqli_query($conn, "SELECT * FROM transactions WHERE sender_id='$notre_id' OR receiver_id='$notre_id' ORDER BY date DESC");


		?>

		<tbody>

			<?php
				while($row = mysqli_fetch_array($our_transactions)) {

					$sender_id=$row['sender_id'];
					$receiver_id=$row['receiver_id'];
					$full_name_sender = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$sender_id' ");
					$full_name_receiver = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$receiver_id' ");
					$row_sender = mysqli_fetch_array($full_name_sender);
					$row_receiver = mysqli_fetch_array($full_name_receiver);
					echo "<tr>";
					echo "<td>"; echo $row_sender['firstname']; echo " "; echo $row_sender['lastname']; echo "</td>";
					echo "<td>"; echo $row_receiver['firstname']; echo " "; echo $row_receiver['lastname']; echo "</td>";
					echo "<td>"; echo $row['amount'];echo "€";echo "</td>";
					echo "<td>"; echo $row['message'];echo "</td>";
					echo "<td>"; echo $row['date'];echo "</td>";
					echo "<td>"; echo $row['status'];echo "</td>";
					if ($sender_id == $notre_id){
						$le_id = $receiver_id;
					}
					else {
						$le_id = $sender_id;
					}
					echo '<form action="" method="post">';
					echo "<td>"; echo "<button name=\"more\" type=\"submit\" value=\"$le_id\" class=\"btn btn-warning\">More</button>"; echo"</td>";
					echo '</form>';
					echo "</tr>";

				}


				if (isset($_POST['more'])){

					$_SESSION['taleirb_id_the_friend'] = $_POST['more'];
					header ('location: transactions_one_friend.php');

				}

			?>

		</tbody>
	</table>

	<div class="col-auto my-1">
		<a href="add_expenses.php"><button type="submit" class="btn btn-success">Add a Transaction</button></a>
	</div>


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
