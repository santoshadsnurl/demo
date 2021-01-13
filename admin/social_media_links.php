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
		<a href="index.php" title=""><img src="images/logo.jpg" alt="logo" class="img-responsive"></a>
		<h3 class="headn-h3">Admin Panel</h3>
		<div class="bs-example" data-example-id="simple-nav-stacked">
			<ul class="nav nav-pills nav-stacked nav-pills-stacked-example">
				<li role="presentation" class="active"><a href="cms.php">CMS</a></li>
				<li role="presentation"><a href="cms-pages.php">Pages</a></li>
				<li role="presentation"><a href="logo.php">Logo</a></li>
				<li role="presentation"><a href="sliders.php">Banner Slider</a></li>
				<li role="presentation"><a href="social_media_links.php">Social Media Links</a></li>
			</ul>
		</div>
		<div class="develop">
			<div class="row">
			<div class="col-sm-6">
			<p>Developed By: </p>
			</div>
			<div class="col-sm-6"> <a href="javascript:void(0);"><img src="images/footer-logo.jpg" alt="logo" class="img-responsive"></a> </div>
			</div>
		</div>
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
		<h2 class="headn-h2">CMS</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					<h3 class="panel-title">Home Page Banner Image</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-4">
								<button class="btn btn-primary center-block" type="button">Add New</button>
							</div>
							<div class="col-sm-4">
								<button class="btn btn-default pull-right" type="button">Delete</button>
							</div>
						</div>
						<div class="clearfix"></div>
						<table class="table table-bordered" style="margin-top:15px;">
							<thead style="background:#d6d6d7;">
								<tr>
								<th>S.No.</th>
								<th>Title</th>
								<th>Status</th>
								<th>Action</th>
								<th> 
								<label>
								<input type="checkbox">
								</label>
								</th>
								</tr>
							</thead>
							<tbody>
							
								<tr>
								<th scope="row">1</th>
								<td>Mark</td>
								<td><div class="switch center-block" style="margin-left:auto; margin-right:auto; display:table">
								<input id="cmn-toggle-1" class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
								<label for="cmn-toggle-1"></label>
								</div> </td>
								<td><button class="btn btn-primary btn-xs"> <i class="glyphicon glyphicon-edit"></i></button> <button class="btn btn-primary btn-xs"> <i class="glyphicon glyphicon-trash"></i></button> </td>
								<th> 
								<label>
								<input type="checkbox">
								</label>
								</th>
								</tr>

							</tbody>
						</table>
						<div class="bs-example" data-example-id="disabled-active-pagination"> <nav aria-label="..."> <ul class="pagination text-center center-block" style="display:table;"> <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> <li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li> <li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> </ul> </nav> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

</body>
</html>
