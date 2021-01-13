<?php

include('../config/function.php');

$response = "";
$error = "";

if(!isset($_REQUEST['link_id']) || empty($_REQUEST['link_id']))
{
	echo "<script>document.location.href='forgot-password.php';</script>";
	exit();
}



if(isset($_POST['submit']))

{

	if(isset($_POST['password'])&& !empty($_POST['password']) && isset($_POST['con_password'])&& !empty($_POST['con_password']))

	{

		$password = mysqli_real_escape_string($conn,$_POST['password']);

		$password = md5($password);

		$id=$_REQUEST['link_id'];

		$id = base64_decode($id);

		$query = "UPDATE `admin` SET `password` = '".$password."' WHERE `id` ='$id'";

		if($sql_update=$conn->prepare($query))

		{

			$sql_update->execute();

			if($sql_update->affected_rows>0)

			{

				$response = "Your password is successfully changed...";

			}

			else

			{

				$error = "Please Try with different password ";

			}

	    } 

    }

}	

?>



<!DOCTYPE HTML>

<html>



<head>

<?php include('includes/head.php'); ?>

<link rel="stylesheet" type="text/css" href="css/login.css" media="screen" />

</head>



<script>

$(document).ready(function()

{

	var form = $("#reset_password");

	var password = $("#password");

	var passerror=$("#passerror");

	var con_password = $("#con_password");

	var conpasserror=$("#conpasserror");	

	password.blur(validatePassword);

	con_password.blur(validatecon_password);

	form.submit(function()

	{

		if(validatePassword() & validatecon_password())

		return true;

		else

		return false;

	});



	function validatePassword()

	{

		if(password.val() == "")

		{

			passerror.text("Please Enter Password");

			return false;

		}

		else

		{

			passerror.text("");

			return true;

		}

	}

	function validatecon_password()

	{

		if(con_password.val() == "")

		{

			conpasserror.text("Please Enter Confirm Password");

			return false;

		}

		else if (password.val() != con_password.val())

		{ 

			conpasserror.text("Please Re-enter password");

			return false; 

		}

		else

		{

			conpasserror.text("");

			return true;

		}

	}

});  

</script>

<style> 

.fnameerror1{ bottom:-12px; z-index2; font-size:11px; color:red; left:92px;}

</style>

</head>

<body>

<div class="wrap">

	<div id="content">

		<div id="main">

			<div class="full_w">

			<div class="entry">

				<div class="sep"></div>

				<?php if($error!="") { ?> 
				<div class="alert alert-danger fade in">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo $error; ?>
				</div>
				<?php } ?>
				<?php if($response!="") { ?> 
				<div class="alert alert-success fade in">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo $response; ?>
				</div>
				<?php } ?>
				
				</div> 

				<form name="reset_password" id="reset_password" action="" method="post">

					<label for="login">Password:</label>

					<input id="password" name="password" type="password"class="text" />

					<div id="passerror"  class="fnameerror1"></div>

					<label for="pass">Confirm Password:</label>

					<input id="con_password" name="con_password" type="password"   class="text" />

					<div id="conpasserror"  class="fnameerror1"></div>

					<div class="sep"></div>

					<button type="submit" name="submit" class="ok">Change</button> <a class="button" href="index.php">Cancel</a>

				</form>

				</div>

			<div class="footer">Designed by &raquo; www.alltoit.com | <a href="">Admin Panel</a></div>

		</div>

	</div>

</div>



</body>

</html>