<a href="index.php" title=""><img src="images/logo.png" alt="logo" class="img-responsive"></a>
<h3 class="headn-h3">Admin Panel</h3>
<div class="bs-example" data-example-id="simple-nav-stacked">
	<ul class="nav nav-pills nav-stacked nav-pills-stacked-example">
		<li role="presentation" <?php if($urls == 'index') { ?> class="active" <?php } ?>><a href="index.php">Dashboard</a></li>
		<li role="presentation" <?php if($urls == 'edit-admin-profile') { ?> class="active" <?php } ?>><a href="edit-admin-profile.php">Edit Admin Profile</a></li>
		<li role="presentation" <?php if($urls == 'login-info') { ?> class="active" <?php } ?>><a href="login-info.php">Login Info</a></li>
		<li role="presentation" <?php if($urls == 'admin-info') { ?> class="active" <?php } ?>><a href="admin-info.php">Add Admins</a></li>
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