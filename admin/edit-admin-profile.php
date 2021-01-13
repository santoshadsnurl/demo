<?php

include('session.php');

/*  set variable */
$pagename = "Admin";

/* set var blank */
$id = "";	
$msg = "";
$user_name = "";
$contact_id ="";

$query = "SELECT * FROM admin WHERE user_name='".$_SESSION['user_name']."'";
if($sql_query = $conn->query($query))
{
	if($sql_query->num_rows>0)
	{
		$result = $sql_query->fetch_array(MYSQLI_ASSOC);
		$user_name = $result['user_name'];
		$contact_id = $result['contact_id'];
		$id = $result['id'];
	}
}
if(isset($_REQUEST['submit']) && $_REQUEST['submit']=="update")
{
	$user_name = addslashes(trim($_POST['user_name']));
	$contact_id = addslashes(trim($_POST['contact_id']));
	if(isset($_POST['new_password']) && !empty($_POST['new_password']))
	{		
		$password = md5(addslashes(trim($_POST['new_password'])));	
		$password = ",password='$password'";	
	}	
	else	
	{		
		$password = "";	
	}
	$query_update = "UPDATE admin SET user_name='".$user_name."',contact_id='".$contact_id."'$password WHERE id='$id'";
	if($sql_update = $conn->prepare($query_update))
	{
		$sql_update->execute();
		if($sql_update->affected_rows>0)
		{
			unset($_SESSION['user_name']);
			$query = "SELECT * FROM admin ORDER BY id DESC";
			if($sql_query = $conn->query($query))
			{
				if($sql_query->num_rows>0)
				{
					$result = $sql_query->fetch_array(MYSQLI_ASSOC);
					$user_name = $result['user_name'];
					$_SESSION['user_name'] = $user_name;
				}
			}
			$msg = $pagename." Update Successfully.";
		}
	}
}
?>

<!DOCTYPE HTML>
<html>

<head>
<?php include('includes/head.php'); ?>
<script language="javascript" type="text/javascript">
function validate()
{
	var d = document.admin;
	if(d.user_name.value == '')
	{
		alert("Please Enter User Name");
		d.user_name.focus();
		return false; 
	}
	if(d.contact_id.value == '')
	{
		alert("Please Enter Valid Email");
		d.contact_id.focus();
		return false; 
	}
	if(d.new_password.value != '')
	{
		if(d.conform_password.value == '')
		{
			alert("Please Enter Confirm Password");
			d.conform_password.focus();
			return false; 
		}
		
		if(d.new_password.value != d.conform_password.value)
		{
			alert("Both Password must be same");
			d.conform_password.focus();
			return false; 
		}
	}
	return true;
}
</script>
</head>

<body>

<!-- header section start here -->
<?php include('includes/header.php'); ?>
<!-- end here --> 

<!-- Two section start here -->
<div class="container-fluid">
	<div class="left-section">
		<?php include('includes/home-left.php'); ?>
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
		<h2 class="headn-h2">Dashboard</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-md-6 col-lg-offset-3 col-xs-12">
				<div class="panel panel-default">
					<?php if($msg!="") { ?> 
					<div class="alert alert-success fade in f">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $msg; ?>
					</div>
					<?php } ?>
					<div class="panel-heading">
						<h3 class="panel-title">Edit Profile</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form class="frm-clls" method="post" name="<?php echo strtolower($pagename); ?>" id="admin" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $user_name; ?>" >
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Email</label>
								<input type="text" class="form-control" id="contact_id" name="contact_id" value="<?php echo $contact_id; ?>" required/>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<input type="password" class="form-control" id="new_password" name="new_password" value="">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Re-Enter Password</label>
								<input type="password" class="form-control" id="conform_password" name="conform_password" value="">
							</div>
							<button type="submit" name="submit" value="update" onClick="javascript:return validate();" class="btn btn-primary">Update</button>
							<a href="index.php" class="btn btn-primary pull-right">Cancel</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

</body>
</html>
