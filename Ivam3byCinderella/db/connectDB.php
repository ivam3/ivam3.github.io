<?php

require_once('credsDB.php');
$dbconnect=mysqli_connect($server, $user, $pass, $db); //connect with database
if ($dbconnect->connect_error) { //if thorw connection error
	die("Error: Database to host connection: " . dbconnect->connect_error);
}
?>
