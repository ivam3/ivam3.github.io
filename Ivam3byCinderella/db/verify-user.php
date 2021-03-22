<?php

require_once('connectDB.php');
session_start();

//Turn html data to php variables
if(isset($_POST['login'])) {
	$user_name=$_POST['user_name'];
	$user_pass=sha1($_POST['user_pass']);

//Validate if new user exist  
	$user_creds=mysqli_query($dbconnect, "SELECT * FROM subscribers WHERE user_name='$user_name' AND user_pass='$user_pass'");
	if(mysqli_num_rows($user_creds)>0) {
		$_SESSION['user_name'] = $user_name;
		header('Location: ../index.php');

//Insert data into database
	}else {
		echo '<script type="text/javascript">
			alert("ERROR: user is not a subscriber");
			window.location.href="../login.php";
                        </script>';
	}
}
?>
