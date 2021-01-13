<?php

include('../config/function.php');

$response = "";
$error = "";

if(isset($_POST['contact_id']) && $_POST['contact_id']!="")
{
	$contact_id = mysqli_real_escape_string($conn,$_POST['contact_id']);
	$contact_id = trim($contact_id);
	$query = "SELECT * FROM `admin` WHERE `contact_id`='$contact_id'";
	if($sql_select = $conn->query($query))
	{
		if($sql_select->num_rows>0)
		{  
			$user = $sql_select->fetch_array(MYSQLI_ASSOC);
			$contact_id = $user['contact_id'];
			$from = "info@alltoit.com";
			$id = $user['id'];
			$link_id = base64_encode($id);
			$link = "<a href='".$site_root."admin/reset-password.php?link_id=".$link_id."'>Click Here</a>";
			$headers = "From: <".$from.">\r\n";
			$headers .= "Content-type: text/html\r\n";
			$message = "Please click on link to change your password : ".$link;
			@mail($contact_id,"Forgot Password" , $message, $headers);
			$response = 'A Link Has Been Sent to '.stripslashes($contact_id).' Please Check Your Email';
		}
		else
		{
			$error = "Sorry, This Email id does not exist.";
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
				<form name="forgetpass" id="forgetpass" method="post">
					<label for="name">Enter Your Email Address <span class="red">(required)</span></label>
					<input id="contact_id" name="contact_id" type ="email"class="text err" required />
					<div class="sep"></div>
					<button  class="ok" type="submit" name="submit" >Submit</button> <a class="button" href="index.php">Cancel</a>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
