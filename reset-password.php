<?php 

include('config/function.php');

$response = "";
$error = "";

if(!isset($_REQUEST['linkid']) || empty($_REQUEST['linkid']))
{
	echo "<script>document.location.href='".$site_root."forgot-password/';</script>";	
	exit();
}

if(isset($_POST['changepassword']))
{
	if(isset($_POST['password'])&& !empty($_POST['password']) && isset($_POST['cpassword'])&& !empty($_POST['cpassword']))
	{
		$password = md5($_POST['password']);
		$cpassword = md5($_POST['cpassword']);
		if($password == $cpassword)
		{
			$id = $_REQUEST['linkid'];
			$id = base64_decode($id);
			$query = "UPDATE `users` SET `password` = '".$password."' WHERE `id` ='$id'";
			if($sql_update = $conn->prepare($query))
			{
				$sql_update->execute();
				if($sql_update->affected_rows>0)
				{
					$response = "Your password is successfully changed, Please Login Now!";
				}
			}
		}
		else
		{
			$error = "Both password should be same!";
		}
 
    }
}

?>

<?php include('include/header.php'); ?>

<!-- breadcrumb start here -->

<div class="back-img">
	<div class="back-pattern">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="account">
						<h1 class="text-center">Reset Password</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-12 brdcmb">
			<ol class="breadcrumb">
				<li><a href="<?php echo $site_root; ?>">Home</a></li>
				<li class="active">Reset Password</li>
			</ol>
		</div>
	</div>
</div>

<section class="cstmr-lgn">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php if($error!="") { ?>
						<div class="alert alert-danger" style="text-align:center;"><?php  echo $error; ?></div>
						<?php } ?>
						<?php if($response!="") { ?>
						<div class="alert alert-success" style="text-align:center;"><?php  echo $response; ?></div>
						<?php } ?>
						<form name="changepass" id="changepass" method="post" novalidate="novalidate">
							<div class="form-group item">
							<label for="exampleInputEmail1">New Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password" required/>
							</div>
							<div class="form-group item">
							<label for="exampleInputPassword1">Confirm Password</label>
							<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter Confirm Password" required/>
							</div>
							<input type="hidden" name="changepassword" value="changepassword">
							<button type="submit" name="changepassword" class="btn btn-default">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include('include/footer.php'); ?>