<?php

include('session.php');

/*  set variable */
$pagename = "Admin";

/* set var blank */
$id = "";	
$response = "";	
$error = "";
$user_name = "";
$name = "";
$contact_id ="";
$password ="";
$role ="";

if(isset($_REQUEST['submit']) && $_REQUEST['submit']=="update")
{
	$name = addslashes(trim($_POST['name']));
	$user_name = addslashes(trim($_POST['user_name']));
	$contact_id = addslashes(trim($_POST['contact_id']));
	$password = md5($_POST['password']);
	$role = addslashes(trim($_POST['role']));
	$query_select = "SELECT user_name FROM admin WHERE user_name='".$user_name."'";
	if($sql_query = $conn->query($query_select))
	{
		if($sql_query->num_rows>0)
		{
			$error = "This User Name is already exist!";
		}
		else
		{
			$query_insert = "INSERT INTO admin SET user_name='".$user_name."',contact_id='".$contact_id."',name='".$name."',password='".$password."',role='".$role."',status=1,last_login=now()";
			if($sql_insert = $conn->prepare($query_insert))
			{
				$sql_insert->execute();
				if($sql_insert->affected_rows>0)
				{
					$response = $pagename." Update Successfully.";
				}
				else
				{
					$error = "Please Try Again.";
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
					<?php if($response!="") { ?> 
					<div class="alert alert-success fade in f">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $response; ?>
					</div>
					<?php } ?>
					<?php if($error!="") { ?> 
					<div class="alert alert-danger fade in f">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $error; ?>
					</div>
					<?php } ?>
					<div class="panel-heading">
						<h3 class="panel-title">Add Admin</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form class="frm-clls" method="post" name="<?php echo strtolower($pagename); ?>" id="admin" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control" id="name" name="name" >
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Email</label>
								<input type="email" class="form-control" id="contact_id" name="contact_id" >
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Username</label>
								<input type="text" class="form-control" id="user_name" name="user_name" >
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<input type="password" class="form-control" name="password">
							</div>
							<div class="form-group">
							<label for="exampleInputPassword1">Role</label>
								<select name="role" id="role" class="form-control">
								<option value="">--Select--</option> 
								<option value="admin">Admin</option>
								<option value="editor">Editor</option>
								<option value="guest">Guest</option>
								</select>
							</div>
							<button type="submit" name="submit" value="update" class="btn btn-primary">Update</button>
							<a href="index.php" class="btn btn-primary pull-right">Cancel</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
<script>
$("#admin").validate(
{
	rules: 
	{
		user_name: 
		{ 
			required:true,
		},
		contact_id: 
		{ 
			required:true,
		},
		password: 
		{ 
			required:true,
		}, 
		role: 
		{ 
			required:true,
		}, 		
		name:
		{
			required: true,
		}
	},
	messages: {
				 user_name:{required:"Please Enter User Name."},
				 contact_id:{required:"Please Enter Contact ID."},
				 password:{required:"Please Enter Password."},
				 name:{required:"Please Enter Name."},
				 role:{required:"Please Enter Role."},
		   }
});
</script>

</body>
</html>
