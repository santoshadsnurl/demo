<?php
	
include('session.php');

/* set variable */
$pagename = "CSV";
$pagetaskname = " Submit ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";


/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$path = rand().$_FILES['csv']['name'];
	$ret = move_uploaded_file($_FILES['csv']['tmp_name'],$path);
	$csvfile = fopen($path,'r');
	$theData = fgets($csvfile);
	$i = 0;
	$insert_csv="";
	while (!feof($csvfile)) 
	{
		$csv_data[] = fgets($csvfile, 1024);
		$csv_array = explode(",", $csv_data[$i]);
		$insert_csv = array();
		$insert_csv['email'] = $csv_array[0];
		$query_insert="INSERT INTO subscribers(email,date) VALUES ('".$insert_csv['email']."',now())";
		if($sql_insert=$conn->prepare($query_insert))
		{
			$sql_insert->execute();
			$id = mysqli_insert_id($conn);
			$_SESSION['response'] = $pagename." Uploaded Successfully.";
		} 
		$i++;
	}

	fclose($csvfile);
	echo "<script>document.location.href='subscribers_mgmt.php';</script>";
	exit;
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
					<div class="alert alert-danger fade in" style="margin:10px 10px 10px 10px;">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $msg; ?>
					</div>
					<?php } ?>
					<div class="panel-heading">
					<h3 class="panel-title">Compose Mail</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="subscribers" enctype="multipart/form-data">
							<div class="form-group">
								<label>Add CSV File</label>
								<input class="btn btn-default" type="file" id="csv" title="Please Upload CSV File" name="csv" value="" required/>
								<span class="red" style="color:red;"><font size="2" width="bold"></font></span>	
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

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
<script>
$("#subscribers").validate(
{
	rules: 
	{
		
	},
	messages: {

		   }
});
</script>

</body>
</html>
