<a href="index.php" title=""><img src="images/logo.png" alt="logo" class="img-responsive"></a>
<h3 class="headn-h3">Admin Panel</h3>
<div class="bs-example" data-example-id="simple-nav-stacked">
	<ul class="nav nav-pills nav-stacked nav-pills-stacked-example">
		<li role="presentation" <?php if($urls == 'customers') { ?> class="active" <?php } ?>><a href="customers.php">Customers</a></li>
		<li role="presentation" <?php if($urls == 'users_mgmt' || $urls == 'users') { ?> class="active" <?php } ?>><a href="users_mgmt.php">Add/Edit Customer</a></li>
		<li role="presentation" <?php if($urls == 'subscribers_mgmt' || $urls == 'subscribers') { ?> class="active" <?php } ?>><a href="subscribers_mgmt.php">Manage Subscribers</a></li>
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