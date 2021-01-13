<?php

include('../config/function.php');

$error = "";
$years = "";
$months = "";
$days = "";
$minutes = "";
$l_attempt = 0;

if(isset($_POST['submit']))
{
	$l_ip = $_SERVER['REMOTE_ADDR'];
	$user_name = $_POST['user_name'];
	$password = md5($_POST['password']);
	$current_dt = @date("Y-m-d H:i:s",time());
	$query_select = "SELECT * FROM attempts WHERE l_user_name='".$user_name."' AND l_status=0";
	if($sql_select=$conn->query($query_select))
	{
		if($sql_select->num_rows>0)
		{
			$result = $sql_select->fetch_array(MYSQLI_ASSOC);
			$l_time = $result['l_time'];
			$l_ip = $result['l_ip'];
			$diff = abs(strtotime($current_dt) - strtotime($l_time)); 
			$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
			$minutes  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
			if($minutes>1)
			{
				$query_update = "UPDATE attempts SET l_attempt=0,l_status=1 WHERE l_user_name='".$user_name."' AND l_ip='".$l_ip."'";
				if($sql_update = $conn->prepare($query_update))
				{
					$sql_update->execute();
				}
			}
			else
			{
				$error = "You Have Been Blocked Try After 24 Hours.";
			}
		}
		else
		{
			$query_select = "SELECT * FROM admin WHERE user_name='".$user_name."' AND password='".$password."'";
			if($sql_select=$conn->query($query_select))
			{
				if($sql_select->num_rows>0)
				{
					$result = $sql_select->fetch_array(MYSQLI_ASSOC);
					$_SESSION['role'] = $result['role'];
					$_SESSION['last_login'] = $result['last_login'];
					$_SESSION['user_name'] = $user_name;
					$query_insert = "INSERT INTO logindetail SET ipaddress='".$l_ip."',logindate='".$current_dt."'";
					if($sql_insert = $conn->prepare($query_insert))
					{
						$sql_insert->execute();
					}
					echo "<script>document.location.href='index.php';</script>";
					exit;
				}
				else
				{
					$query_select = "SELECT * FROM attempts WHERE l_user_name='".$user_name."' AND l_ip='".$l_ip."'";
					if($sql_select=$conn->query($query_select))
					{
						if($sql_select->num_rows>0)
						{
							$result = $sql_select->fetch_array(MYSQLI_ASSOC);
							$l_attempt = $result['l_attempt'];
							$l_attempt = $l_attempt+1;
							if($l_attempt>3)
							{
								$query_update = "UPDATE attempts SET l_status=0 WHERE l_user_name='".$user_name."' AND l_ip='".$l_ip."'";
								if($sql_update = $conn->prepare($query_update))
								{
									$sql_update->execute();
								}
								$error = "You Have Been Blocked Try After 24 Hours.";
							}
							$query_update = "UPDATE attempts SET l_attempt='".$l_attempt."',l_time='".$current_dt."' WHERE l_user_name='".$user_name."' AND l_ip='".$l_ip."'";
							if($sql_update = $conn->prepare($query_update))
							{
								$sql_update->execute();
							}
						}
						else
						{
							
							$query_insert = "INSERT INTO attempts SET l_ip='".$l_ip."',l_attempt=1,l_user_name='".$user_name."',l_time='".$current_dt."',l_status=1";
							if($sql_insert = $conn->prepare($query_insert))
							{
								$sql_insert->execute();
							}
						}
					}
					if($l_attempt==0)
					{
						$l_attempt = 3;
					} 
					elseif($l_attempt==2)
					{
						$l_attempt = 2;
					} 
					else 
					{
						$l_attempt = 1;
					}
					$error = "Invalid Login You Have Only $l_attempt Attempts.";
				}
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
				</div> 
				<form name="login" id="login" method="post">
					<label for="user_name">User Name :</label>
					<input id="user_name" name="user_name" required class="text" />
					<label for="password">Password :</label>
					<input id="password" name="password" type="password"  required class="text" />
					<div class="sep"></div>
					<button type="submit"  name="submit" class="ok">Login</button> <a class="button" href="forgot-password.php">Forgot password</a>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
