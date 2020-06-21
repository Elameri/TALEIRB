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
	<?php
	$full_name_the_friend = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$the_friend_id'");
	$row_full_name = mysqli_fetch_array($full_name_the_friend);
	$first_name = $row_full_name['firstname'];
	$last_name = $row_full_name['lastname'];

	$somme = 0;
	echo "<h2 class=\"font-weight-light\" style=\"color:darkblue\">Transactions with : $first_name $last_name</h2>";

	$full_sum_amnt = mysqli_query($conn, "SELECT status, sender_id, receiver_id, amount FROM transactions WHERE (sender_id='$the_friend_id') OR (receiver_id='$the_friend_id')");
	while($row_sum_amnt = mysqli_fetch_array($full_sum_amnt)) {
		$sndr_id = $row_sum_amnt['sender_id'];
		$rcvr_id = $row_sum_amnt['receiver_id'];
		$the_amnt = $row_sum_amnt['amount'];

		if ($row_sum_amnt['status'] == 'Opened'){
			if ($sndr_id == $the_friend_id) {
				$somme = $somme - $the_amnt;
			}
			if ($rcvr_id == $the_friend_id) {
				$somme = $somme + $the_amnt;
			}
	}
}

	if ($somme >= 0){
		echo "<h2 class=\"font-weight-light\" style=\"color:green\"> current balance with	$first_name $last_name : $somme €</h2>";
	}

	else{
		echo "<h2 class=\"font-weight-light\" style=\"color:red\"> current balance with $first_name $last_name : $somme €</h2>";
	}





	?>
	<div class="form-row align-items-center">
	<div class="container">

    <div class="right_bar ">
    <div class="tab-content ">
	<div class="tab-pane fade show active" id="lorem" role="tabpanel">

	<table class="table table-bordered">
		<thead>
			  <tr>
				<th><div style="color:black">Sender<div></th>
				<th><div style="color:black">Receiver<div></th>
				<th><div style="color:black">Amount (‎€)<div></th>
				<th><div style="color:forestgreen">Creation Message<div> <div style="color:black">or<div> <div style="color:red">Closing Message<div></th>
				<th><div style="color:forestgreen">Creation Date<div> <div style="color:black">or<div> <div style="color:red">Closing Date<div></th>
				<th><div style="color:black">Status<div></th>
				<th></th>
			  </tr>
		</thead>


		<?php
			$our_transactions = mysqli_query($conn, "SELECT * FROM transactions WHERE (sender_id='$notre_id' AND receiver_id='$the_friend_id') OR (sender_id='$the_friend_id' AND receiver_id='$notre_id') ORDER BY date DESC ");
			$grp_transactions = mysqli_query($conn, "SELECT * FROM groups WHERE (sender_id='$notre_id' AND (receiver_id_1='$the_friend_id' OR receiver_id_2='$the_friend_id' OR receiver_id_3='$the_friend_id')) OR (sender_id='$the_friend_id' AND (receiver_id_1='$notre_id' OR receiver_id_2='$notre_id' OR receiver_id_3='$notre_id'))");
		?>

		<tbody>

			<?php

			//transactions simple
				while($row = mysqli_fetch_array($our_transactions)) {

					$sender_id=$row['sender_id'];
					$receiver_id=$row['receiver_id'];
					$id_transac=$row['transac_id'];
					$full_name_sender = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$sender_id' ");
					$full_name_receiver = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$receiver_id' ");
					$row_sender = mysqli_fetch_array($full_name_sender);
					$row_receiver = mysqli_fetch_array($full_name_receiver);

				if ($row['status'] == 'Opened'){
					echo "<tr>";
					echo "<td>"; echo $row_sender['firstname']; echo " "; echo $row_sender['lastname']; echo "</td>";
					echo "<td>"; echo $row_receiver['firstname']; echo " "; echo $row_receiver['lastname']; echo "</td>";
					echo "<td>"; echo $row['amount'];echo "€";echo "</td>";
					echo "<td style='color:forestgreen'>"; echo $row['message'];echo "</td>";
					echo "<td style='color:forestgreen'>"; echo $row['date'];echo "</td>";
					echo "<td style='color:forestgreen'>"; echo $row['status'];echo "</td>";

					$transac_id=$row['transac_id'];

					echo '<form action="" method="post">';
					echo "<td>"; echo "<button name=\"change\" type=\"submit\" value=\"$transac_id\" class=\"btn btn-warning\">Change</button>"; echo"</td>";
					echo '</form>';
					echo "</tr>";
				}
			}

				if (isset($_POST['change'])){

					$_SESSION['taleirb_id_transac'] = $_POST['change'];
					header ('location: change_or_cancel.php');

				}

			// 	//tableau des transactions
			//  				while($row = mysqli_fetch_array($grp_transactions)) {
			//
			//  					$sender_id=$row['sender_id'];
			//  					$receiver_id_1=$row['receiver_id_1'];
			//  					$receiver_id_2=$row['receiver_id_2'];
			//  					$receiver_id_3=$row['receiver_id_3'];
			//  					if (($receiver_id_1 == $notre_id) or ($receiver_id_1 == $notre_id)){
			//  						$receiver_id=$receiver_id_1;
			// 						$amount=$row['amount_1'];
			//  					}
			//  					elseif (($receiver_id_3 == $notre_id) or ($receiver_id_2 == $notre_id)){
			//  						$receiver_id=$receiver_id_2;
			// 						$amount=$row['amount_2'];
			//  					}
			//  					elseif (($receiver_id_3 == $notre_id) or ($receiver_id_3 == $notre_id)){
			//  						$receiver_id=$receiver_id_3;
			// 						$amount=$row['amount_3'];
			//  					}
			//
			//  					$id_transac=$row['transac_grp_id'];
			//  					$full_name_sender = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$sender_id' ");
			//  					$full_name_receiver = mysqli_query($conn, "SELECT firstname, lastname FROM users WHERE id='$receiver_id' ");
			//  					$row_sender = mysqli_fetch_array($full_name_sender);
			//  					$row_receiver = mysqli_fetch_array($full_name_receiver);
			//
			//  				if ($row['status'] == 'Opened'){
			//  					echo "<tr>";
			//  					echo "<td>";echo"<i>"; echo $row_sender['firstname']; echo " "; echo $row_sender['lastname']; echo"</i>"; echo "</td>";
			//  					echo "<td>";echo"<i>"; echo $row_receiver['firstname']; echo " "; echo $row_receiver['lastname']; echo"(group sent)"; echo"</i>"; echo "</td>";
			//  					echo "<td>";echo"<i>"; echo $amount;echo "€"; echo"</i>"; echo "</td>";
			//  					echo "<td style='color:forestgreen'>"; echo"<i>" ; echo $row['message']; echo"</i>"; echo "</td>";
			//  					echo "<td style='color:forestgreen'>"; echo"<i>" ; echo $row['date']; echo"</i>"; echo "</td>";
			//  					echo "<td style='color:forestgreen'>"; echo"<i>" ; echo $row['status']; echo"</i>"; echo "</td>";
			//
			//  					$transac_grp_id=$row['transac_grp_id'];
			//
			//  					echo '<form action="" method="post">';
			//  					echo "<td>"; echo "<button name=\"change\" type=\"submit\" value=\"$transac_id\" class=\"btn btn-warning\">Change</button>"; echo"</td>";
			//  					echo '</form>';
			//  					echo "</tr>";
			//  				}
			//  			}
			//
			//  				if (isset($_POST['change'])){
			//
			//  					$_SESSION['taleirb_id_transac'] = $_POST['change'];
			//  					header ('location: change_or_cancel.php');
			// 				}
			// ?>


		</tbody>
	</table>

	<div class="col-auto my-1">
		<a href="closed_transaction_one_friend.php"><button type="submit" class="btn btn-primary">Show closed transactions</button></a>
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
