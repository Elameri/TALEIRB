<?php

session_start ();

// Destruction des variables et de la session
session_unset ();
session_destroy ();

// redirection des utilisateurs
header ('location: index.php');
?>