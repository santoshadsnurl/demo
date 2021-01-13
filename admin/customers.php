<?php

include('session.php');

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
			<div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
				<div class="col-sm-12 col-lg-2 col-md-2 col-xs-2">&nbsp;</div>
				<div class="col-sm-12 col-lg-8 col-md-4 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						<h3 class="panel-title">Customers Overview</h3>
						</div>
						<div class="panel-body">
						<div class="row">
							<div class="col-sm-6">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Total Users:</h5>
							<a class="counts"  href="<?php echo $site_root; ?>admin/users_mgmt.php"><?php echo $newobject->getnumrows($conn,"users"); ?> </a>
							</div>
							<div class="col-sm-6">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Total Subscribers:</h5>
							<a class="counts"  href="<?php echo $site_root; ?>admin/subscribers_mgmt.php"><?php echo $newobject->getnumrows($conn,"subscribers"); ?> </a>
							</div>
							</div>   
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-lg-2 col-md-2 col-xs-12">&nbsp;</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

</body>
</html>
