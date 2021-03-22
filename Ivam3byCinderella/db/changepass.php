<?php

require_once('connectDB.php');
session_start();

//Turn html data to php variables
if(isset($_POST['submit'])) {
	$user_name=$_POST['user_name'];
	$old_user_pass=sha1($_POST['old_user_pass']);
	$new_user_pass=sha1($_POST['new_user_pass']);
	$confirm_new_user_pass=sha1($_POST['confirm_new_user_pass']);

//Compare passwords
	if("$new_user_pass" == "$confirm_new_user_pass") {

//Validate if new user exist  
	        $user_creds=mysqli_query($dbconnect, "SELECT * FROM subscribers WHERE user_name='$user_name' AND user_pass='$old_user_pass'");
	        if(mysqli_num_rows($user_creds)>0) {
			$query = "UPDATE subscribers SET user_pass = '$new_user_pass' WHERE user_name = '$user_name';";
			//Validate if data was saved
			if (!mysqli_query($dbconnect, $query)) {
				echo '<script type="text/javascript">
					alert("ERROR: submitting data fail. please try again later");
					window.location.href="../change-pass.php";
                                        </script>';
			}else {
				echo '<script type="text/javascript">
					alert("SUCESSFULY: have a nice hacking day!!");
                                        window.location.href="../login.php";
                                        </script>';
			}
		//If data was wrong
		}else {
			echo '<script type="text/javascript">
				alert("ERROR: user is not a subscriber");
			        window.location.href="../change-password.php";
				</script>';
		}
	}else {
		echo '<script type="text/javascript">                                                                                  alert("ERROR: password do not macth");
			window.location.href="../change-password.php";
                        </script>';
	}
}
?>
