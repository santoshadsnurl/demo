<?php
	
include('session.php');

/* set variable */

$pagename = "Subscribers";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$email = "";
$name = "";
$city = "";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$email = addslashes(trim($_POST['email']));
	$name = $_POST['name'];
	$city = $_POST['city'];

	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	
	$query_duplicate = "SELECT * FROM subscribers WHERE email='".$email."' $checkDuplicate";
	if($sql_duplicate = $conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Email is already exist, please try another.";
		}
		else
		{
			if($id!="")
			{
				$query_update = "UPDATE subscribers SET email='".$email."',city='".$city."',name='".$name."',date=now() WHERE id='".$id."'";
	
				if($sql_update = $conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";		
				}
			}
			else
			{
				$query_insert = "INSERT INTO subscribers SET email='".$email."',city='".$city."',name='".$name."',date=now()";
				if($sql_insert = $conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$_SESSION['response'] = $pagename." Added Successfully.";
				}
			}
			echo "<script>document.location.href='subscribers_mgmt.php';</script>";
			exit;
		}
	}
}



/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM subscribers WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$email = stripslashes($result['email']);
			$name = $result['name'];
			$city = $result['city'];
			$pagetaskname = " Update ";
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
	<?php include('includes/customer-left.php'); ?>	
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
		<h2 class="headn-h2">Customers</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-md-6 col-lg-offset-3 col-xs-12">
				<div class="panel panel-default">
					<?php if($msg!="") { ?> 
					<div class="alert alert-danger fade in f">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $msg; ?>
					</div>
					<?php } ?>
					<div class="panel-heading">
					<h3 class="panel-title">Subscribers</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="subscribers" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control" id="name" name="name" title="Please Enter User Name" value="<?php echo $name; ?>"/>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" id="email" name="email" title="Please Enter Email" value="<?php echo $email; ?>">
							</div>
							<div class="form-group">
								<label>City</label>
								<input type="text" class="form-control" id="city" name="city" title="Please Enter City" value="<?php echo $city; ?>"/>
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="subscribers_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="lib/ToggleSwitch.css"/>
<script src="lib/ToggleSwitch.js"></script>
<script>
	$(function(){
		$("#status").toggleSwitch();
		$("#myonoffswitch2").toggleSwitch();
	});
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'https://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
<script>
$("#subscribers").validate(
{
	rules: 
	{
		name: 
		{ 
			required:true,
		},
		email: 
		{
			required: true,
			email: true
		},		  
		city:
		{
			required:true
		},
	},
	messages: {

		   }
});
</script>

</body>
</html>
