<?php

include('session.php');

/* set variable */
$pagename = "Review";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$user_id = "";
$product_id = "";
$rating = "";
$reviews = "";
$status = 1;

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$user_id = $_POST['user_id'];
	$rating = $_POST['rating'];
	$product_id = $_POST['product_id'];
	$reviews = $_POST['reviews'];
	
	if($id!="")
	{
		$query_update="UPDATE reviews SET user_id='".$user_id."',status='".$status."',product_id='".$product_id."',rating='".$rating."',reviews='".$reviews."',date=now() WHERE id='".$id."'";
		if($sql_update=$conn->prepare($query_update))
		{
			$sql_update->execute();
			$_SESSION['response'] = $pagename." Update Successfully.";
		}
	}
	else
	{
		$query_insert="INSERT INTO reviews SET user_id='".$user_id."',product_id='".$product_id."',status='".$status."',rating='".$rating."',reviews='".$reviews."',date=now();";
		if($sql_insert=$conn->prepare($query_insert))
		{
			$sql_insert->execute();
			$id = mysqli_insert_id($conn);
			$_SESSION['response'] = $pagename." Added Successfully.";
		}
	}
	echo "<script>document.location.href='reviews_mgmt.php';</script>";
	exit;
}

/* Listing  */
if($id!="")
{
    $query_select="SELECT * FROM reviews WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$user_id = stripslashes($result['user_id']);
			$status = $result['status'];
			$product_id = $result['product_id'];
			$rating = $result['rating'];
			$reviews = stripslashes($result['reviews']);
			$pagetaskname = " Update ";
		}
		else
		{
			echo "<script>document.location.href='reviews_mgmt.php';</script>";
			exit;
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
		<h2 class="headn-h2">Sales</h2>
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
					<h3 class="panel-title">Reviews</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="reviews" enctype="multipart/form-data">
							<div class="form-group">
								<label>Product</label>
								<select name="product_id" id="product_id" class="form-control">
								<option value="">--Select--</option>
								<?php
								$query = "SELECT * FROM products WHERE status=1 ORDER BY id DESC";
								if($stmt = $conn->query($query))
								{
									while($r = $stmt->fetch_array(MYSQLI_ASSOC))
									{
										?>
										<option value="<?php echo $r['id'];?>" <?php if($r["id"]==$product_id) { echo "selected"; } ?>><?php echo ucwords($r['title']);?></option> 	
										<?php 
									} 
								} 
								?>
								</select>
							</div>
							<div class="form-group">
								<label>Name</label>
								<select name="user_id" id="user_id" class="form-control" required>
								<option value="">--Select--</option>
								<?php
								$query_users = "SELECT * FROM users WHERE status = 1 ORDER BY id DESC";
								if($stmt_users = $conn->query($query_users))
								{
									while($r_users = $stmt_users->fetch_array(MYSQLI_ASSOC))
									{
										?>
										<option value="<?php echo $r_users['id'];?>" <?php if($r_users["id"]==$user_id) { echo "selected"; } ?>><?php echo ucwords($r_users['name']);?></option> 	
										<?php 
									} 
								} 
								?>
								</select>
							</div>
							<div class="form-group">
								<label>Rate</label>
								<input type="text" class="form-control" id="rating" name="rating" value="<?php echo $rating; ?>" maxlength="1">
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Review</label>
										<textarea name="reviews" id="reviews" class="form-control" rows="8" ><?php echo $reviews; ?></textarea>
									</div>
								</div>
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="reviews_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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
$("#reviews").validate(
{
	rules: 
	{
		user_id: 
		{ 
			required:true,
		},
		rating: 
		{ 
			required:true,
			pattern: /^[1-5]*$/
		},
		reviews: 
		{ 
			required:true,
		},
		product_id: 
		{ 
			required:true,
		},
	},
	messages: {
				 product_id:{required:"Please Select Product."},
				 user_id:{required:"Please Enter User Name."},
				 rating:{required:"Please Enter Rate."},
				 reviews:{required:"Please Enter reviews."},
		   }
});
</script>

</body>
</html>
