<?php

require_once('connectDB.php');

//Turn html data to php variables
if(isset($_POST['submit'])) {
	$user_name=$_POST['user_name'];
	$user_email=$_POST['user_email'];
	$user_pass=sha1($_POST['user_pass']);
	$confirm_pass=sha1($_POST['confirm_pass']);

	//Compare passwords
	if($user_pass == $confirm_pass) {

//Validate if new user exist  
		$newuser_creds=mysqli_query($dbconnect, "SELECT * FROM subscribers WHERE user_name='$user_name' OR user_email='$user_email'");
		if(mysqli_num_rows($newuser_creds)>0) {
			echo '<script type="text/javascript">
			alert("ERROR: subscriber already exists!!");
                        window.location.href="../login.php";</script>';
//Insert data into database
		}else {
			$query = "INSERT IGNORE INTO subscribers (user_name, user_email, user_pass)
				VALUES ('$user_name', '$user_email', '$user_pass')";
//Validate if data was saved
			if (!mysqli_query($dbconnect, $query)) {
				echo '<script type="text/javascript">
                                alert("ERROR: submitting data fail. please try again later");
                                window.location.href="../login.php";
                                </script>';
//			die("ERROR: submitting data fail. Please contact us on https://t.me/Ivam3_Bot");
			}else {
                                echo '<script type="text/javascript">
				alert("SUCESSFULY: have a nice hacking day!!");
                                window.location.href="../login.php";</script>';
			}
		}
	}else {
		echo '<script type="text/javascript">
			alert("ERROR: password do not match");
                        window.location.href="../login.php";</script>';
	}
}

?>
