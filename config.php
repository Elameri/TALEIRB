
<?php
	$hostname='localhost';
	$username = 'root';
	$password = '';
	$db_name = 'taleirbdb';
	
	// $con = mysql_connect($hostname, $username, $password, $db_name);
	// mysql_select_db("taleirbdb", $con);
	
	
	$conn = mysqli_connect($hostname, $username, $password, $db_name);
?>