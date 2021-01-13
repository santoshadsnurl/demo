<?php
	
include('session.php');

/* set variable */

$pagename = "Shipping";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$shipping_carge = "";
$price_upto = "";
$status = "";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{

	$shipping_carge = addslashes(trim($_POST['shipping_carge']));
	$price_upto = addslashes(trim($_POST['price_upto']));
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0;	}

	if($id!="")
	{
		$query_update="UPDATE shipping SET shipping_carge='".$shipping_carge."',price_upto='".$price_upto."' WHERE id='".$id."'";
		if($sql_update=$conn->prepare($query_update))
		{
			$sql_update->execute();
			$_SESSION['response'] = $pagename." Update Successfully.";	
		}
	}
	else
	{
		$query_insert="INSERT INTO shipping SET shipping_carge='".$shipping_carge."',price_upto='".$price_upto."',status='1'";
		if($sql_insert=$conn->prepare($query_insert))
		{
			$sql_insert->execute();
			$id = mysqli_insert_id($conn);
			$_SESSION['response'] = $pagename." Added Successfully.";
		}
	}
	echo "<script>document.location.href='shipping_mgmt.php';</script>";
	exit;
}

/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM shipping WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$shipping_carge = stripslashes($result['shipping_carge']);
			$price_upto = stripslashes($result['price_upto']);
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
		<?php include('includes/catelog-left.php'); ?>
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
		<h2 class="headn-h2">Catalog</h2>
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
					<h3 class="panel-title">Shipping Charge</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="shipping" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Shipping Charge</label>
								<input type="text" class="form-control" id="shipping_carge" name="shipping_carge" value="<?php echo $shipping_carge; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Below Amount</label>
								<input type="text" class="form-control" id="price_upto" name="price_upto" value="<?php echo $price_upto; ?>">
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="shipping_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="lib/ToggleSwitch.css"/>
<script src="lib/ToggleSwitch.js"></script>
<script>
	$(function(){
		$("#status").toggleSwitch();
		$("#myonoffswitch2").toggleSwitch();
	});
</script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>

<script>

$("#shipping").validate(

{
	rules: 
	{
		shipping_carge: 
		{ 
			required:true,
		},
		price_upto: 
		{ 
			required:true,
		}

	},

	messages: {

				 shipping_carge:{required:"Please Enter Shipping Carge."},
				 price_upto:{required:"Please Enter Below Price."},
		   }

});

</script>

</body>
</html>
