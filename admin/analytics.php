<?php

include('../config/function.php'); 

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
	header('location:login.php');
	exit();
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
		<a href="index.php" title=""><img src="images/logo.png" alt="logo" class="img-responsive"></a>
		<h3 class="headn-h3">Admin Panel</h3>
		<div class="bs-example" data-example-id="simple-nav-stacked">
			<ul class="nav nav-pills nav-stacked nav-pills-stacked-example">
				<li role="presentation" class="active"><a href="analytics.php">Analytics</a></li>
				<li role="presentation"><a href="javascript:void(0);">Visitors</a></li>
				<li role="presentation"><a href="javascript:void(0);">Locals</a></li>
				<li role="presentation"><a href="javascript:void(0);">Duration</a></li>
				<li role="presentation"><a href="javascript:void(0);">Pages</a></li>
			</ul>
		</div>
		<div class="develop">
			<div class="row">
			<div class="col-sm-6">
			<p>Developed By: </p>
			</div>
			<div class="col-sm-6"> <a href="javascript:void(0);"><img src="images/logo.png" alt="logo" class="img-responsive"></a> </div>
			</div>
		</div>
	</div>
		<div class="right-section">
		<div class="dashboard-bar">
			<h2 class="headn-h2">Analytics</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						<h3 class="panel-title">Visitors Overview</h3>
						</div>
						<div class="panel-body">
						<div class="row">
							<div class="col-sm-2">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Total Visitors:</h5>
							<a class="counts"  href="#">56 </a>
							</div>
							<div class="col-sm-2">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Unique Visitors:</h5>
							<a class="counts"  href="#">56 </a>
							</div>
							<div class="col-sm-2">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">No Of Visits:</h5>
							<a class="counts"  href="#">56 </a>
							<a href="#">(1.31 Visits/Visitors) </a>
							</div>
							<div class="col-sm-2">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Pages Visited:</h5>
							<a class="counts"  href="#">56 </a>
							<a href="#">(1.31 Pages/Visit) </a>
							</div>
							<div class="col-sm-2">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Hits:</h5>
							<a class="counts"  href="#">56 </a>
							<a href="#">(1.31 Hits/Visit) </a>
							</div>
							<div class="col-sm-2">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Brandwidth:</h5>
							<a class="counts"  href="#">56 MB</a>
							<a href="#">(1.31 KB/Visit) </a>
							</div>
							</div>   
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

</body>
</html>
