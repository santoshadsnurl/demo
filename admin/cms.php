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
	<?php include('includes/cms-left.php'); ?>	
	</div>
		<div class="right-section">
		<div class="dashboard-bar">
			<h2 class="headn-h2">CMS</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
				<div class="col-sm-12 col-lg-2 col-md-2 col-xs-2">&nbsp;</div>
				<div class="col-sm-12 col-lg-8 col-md-4 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						<h3 class="panel-title">CMS Overview</h3>
						</div>
						<div class="panel-body">
						<div class="row">
							<div class="col-sm-4">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Total Pages:</h5>
							<a class="counts"  href="<?php echo $site_root; ?>admin/cms-pages.php"><?php echo $newobject->getnumrows($conn,"pages"); ?> </a>
							</div>
							<div class="col-sm-4">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Total Banners:</h5>
							<a class="counts" href="<?php echo $site_root; ?>admin/sliders_mgmt.php"><?php echo $newobject->getnumrows($conn,"sliders"); ?> </a>
							</div>
							<div class="col-sm-4">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Social Media Links:</h5>
							<a class="counts"  href="<?php echo $site_root; ?>admin/social_links_mgmt.php"><?php echo $newobject->getnumrows($conn,"social_links"); ?> </a>
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
