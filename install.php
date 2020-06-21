<?php


$conn=mysqli_connect('localhost', 'root', '');

$db = 'taleirbdb';

$sql = "CREATE DATABASE $db";

if (mysqli_connect_errno($conn)) {
 echo "Echec lors de la connexion à MySQL : " .
mysqli_connect_error();
}

if ($conn->query($sql) == TRUE) {
	echo "Database created successfully<br>";
} else {
	echo "Error creating database: " . $conn->error . "<br>";
}

mysqli_select_db($conn, $db);

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'taleirbdb';

$conn=mysqli_connect($host, $user, $password, $db);


$TbUser = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;";


$TbAmis = "CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(255) NOT NULL,
  `id_ami` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$TbTransactions = "CREATE TABLE IF NOT EXISTS `transactions` (
  `transac_id` int(255) NOT NULL AUTO_INCREMENT,
  `sender_id` int(255) NOT NULL,
  `receiver_id` int(255) NOT NULL,
  `message` varchar(500) NOT NULL,
  `amount` decimal(65,2) NOT NULL,
  `date` varchar(500) NOT NULL,
  `status` varchar(255) NOT NULL,
  `closing_msg` varchar(500) NOT NULL,
  `closing_date` varchar(255) NOT NULL,
  KEY `transac_id` (`transac_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;";

$TbGroups = "CREATE TABLE IF NOT EXISTS `groups` (
  `transac_grp_id` int(255) NOT NULL AUTO_INCREMENT,
  `sender_id` int(255) NOT NULL,
  `receiver_id_1` int(255) NOT NULL,
  `receiver_id_2` int(255) NOT NULL,
  `receiver_id_3` int(255) NOT NULL,
  `amount_1` decimal(65,2) NOT NULL,
  `amount_2` decimal(65,2) NOT NULL,
  `amount_3` decimal(65,2) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  KEY `transac_grp_id` (`transac_grp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;";


mysqli_query($conn, $TbUser);
mysqli_query($conn, $TbAmis);
mysqli_query($conn, $TbTransactions);
mysqli_query($conn, $TbGroups);

echo "Tables created successfully<br>";

// Creation des utilisateurs

$add_users="INSERT INTO `users` (`id`, `firstname`, `lastname`, `pseudo`, `email`, `password`) VALUES
(1, 'Tester', 'TESTER', 'test', 'tester@gmail.com', 'mdp'),
(2, 'Elon', 'MUSK', 'emusk', 'emusk@gmail.com', 'azerty'),
(3, 'Larry', 'PAGE', 'lpage', 'lpage@gmail.com', 'azerty'),
(4, 'Bill', 'GATES', 'bgates', 'bgates@gmail.com', 'azerty')";


$res=mysqli_query($conn,$add_users);

if ($res) {
    echo "1st table successfully filled <br>";
} else {
    echo "Error filling table 1: " . mysqli_error($conn)." <br>";
}


// Creation des friendship


$add_friends="INSERT INTO `friends` (`id`, `id_ami`) VALUES
(1, 2),
(1, 4)";


$res=mysqli_query($conn,$add_friends);

if ($res) {
    echo "2nd table successfully filled <br>";
} else {
    echo "Error filling table 2: " . mysqli_error($conn)." <br>";
}



// Creation des Transactions

$add_trans="INSERT INTO `transactions` (`transac_id`, `sender_id`, `receiver_id`, `message`, `amount`, `date`, `status`, `closing_msg`, `closing_date`) VALUES
(1, 1, 2, 'Small 1', '8.00', '2020-05-01', 'Opened', '', ''),
(2, 4, 1, 'Small 2', '7.50', '2020-05-16', 'Opened', '', ''),
(3, 2, 1, 'Small 3', '3.50', '2020-05-17', 'Opened', '', ''),
(4, 1, 4, 'Big 1', '90.00', '2020-05-20', 'Refunded', 'payed with paypal', '2020-05-28')";


$res=mysqli_query($conn,$add_trans);

if ($res) {
    echo "3rd table successfully filled <br>";
} else {
    echo "Error filling table 3: " . mysqli_error($conn)." <br>";
}



// Creation des transactions de grps


$add_grp="INSERT INTO `groups` (`transac_grp_id`, `sender_id`, `receiver_id_1`, `receiver_id_2`, `receiver_id_3`, `amount_1`, `amount_2`, `amount_3`, `message`, `date`, `status`) VALUES
(1, 0, 2, 4, 0, '4.00', '2.50', '0.00', 'Thing 1', '2020-05-27', 'Opened'),
(2, 1, 2, 4, 0, '2.00', '6.30', '0.00', 'Thing 2', '2020-05-28', 'Opened')";


$res=mysqli_query($conn,$add_grp);

if ($res) {
    echo "4th table successfully filled <br>";
} else {
    echo "Error filling table 4: " . mysqli_error($conn)." <br>";
}


?>
