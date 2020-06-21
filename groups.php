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
	<div class="form-row align-items-center">
	<div class="container">

    <div class="right_bar ">
    <div class="tab-content ">
	<div class="tab-pane fade show active" id="lorem" role="tabpanel">

	<table class="table table-bordered">
		<thead>
			  <tr>
				<th>Sender</th>
				<th>Receivers</th>
				<th>Amount (‎€)</th>
				<th>Message</th>
				<th>Date</th>
				<th>Status</th>
			  </tr>
		</thead>

		<?php
			$our_transactions = mysqli_query($conn, "SELECT * FROM groups WHERE sender_id='$notre_id' OR receiver_id_1='$notre_id' OR receiver_id_2='$notre_id' OR receiver_id_3='$notre_id' ORDER BY date ");
			

		?>

		<tbody>

			<?php
				while($row = mysqli_fetch_array($our_transactions)) {
					
					$sender_id=$row['sender_id'];
					$receiver_id_1=$row['receiver_id_1'];
					$receiver_id_2=$row['receiver_id_2'];
					$receiver_id_3=$row['receiver_id_3'];
					
					
					$full_name_sender = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$sender_id' ");
					$full_name_receiver_1 = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$receiver_id_1' ");
					$full_name_receiver_2 = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$receiver_id_2' ");
					$row_sender = mysqli_fetch_array($full_name_sender);
					$row_receiver_1 = mysqli_fetch_array($full_name_receiver_1);
					$row_receiver_2 = mysqli_fetch_array($full_name_receiver_2);
					echo "<tr>";
					echo "<td>"; echo $row_sender['firstname']; echo " "; echo $row_sender['lastname']; echo "</td>";
					
					echo "<td>"; echo $row_receiver_1['firstname']; echo " "; echo $row_receiver_1['lastname']; echo ", "; echo $row_receiver_2['firstname']; echo " "; echo $row_receiver_2['lastname'];
					if (!empty($receiver_id_3)) {
						$full_name_receiver_3 = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$receiver_id_3' ");
						$row_receiver_3 = mysqli_fetch_array($full_name_receiver_3);
						echo ", "; echo $row_receiver_3['firstname']; echo " "; echo $row_receiver_3['lastname'];
					}
					echo "</td>";
					
					echo "<td>"; echo $row['amount_1']; echo "€, "; echo $row['amount_2']; echo "€, "; 
					if (!empty($receiver_id_3)) {
						echo $row['amount_3']; echo "€";
					}
					echo "</td>";
					
					echo "<td>"; echo $row['message'];echo "</td>";
					echo "<td>"; echo $row['date'];echo "</td>";
					echo "<td>"; echo $row['status'];echo "</td>";
					
					echo "</tr>";	
					
				}

				
				if (isset($_POST['more'])){

					$_SESSION['taleirb_id_grp_transac'] = $_POST['more'];
					header ('location: one_grp_transaction.php');
						
				}
				
			?>

		</tbody>
	</table>

	<div class="col-auto my-1">
		<a href="add_expenses_groups.php"><button type="submit" class="btn btn-success">Add a Transaction</button></a>
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
