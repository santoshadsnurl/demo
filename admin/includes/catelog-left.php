<a href="index.php" title=""><img src="images/logo.png" alt="logo" class="img-responsive"></a>
<h3 class="headn-h3">Admin Panel</h3>
<div class="bs-example" data-example-id="simple-nav-stacked">
	<ul class="nav nav-pills nav-stacked nav-pills-stacked-example">
		<li role="presentation" <?php if($urls == 'catalog') { ?> class="active" <?php } ?>><a href="catalog.php">Catalog</a></li>
		<li role="presentation" <?php if($urls == 'categories_mgmt' || $urls == 'categories') { ?> class="active" <?php } ?>><a href="categories_mgmt.php">Categories</a></li>
		<li role="presentation" <?php if($urls == 'sub_categories_mgmt' || $urls == 'sub_categories') { ?> class="active" <?php } ?>><a href="sub_categories_mgmt.php">Sub Categories</a></li>
		<li role="presentation" <?php if($urls == 'sub_sub_categories_mgmt' || $urls == 'sub_sub_categories') { ?> class="active" <?php } ?>><a href="sub_sub_categories_mgmt.php">Sub Sub Categories</a></li>
		<li role="presentation" <?php if($urls == 'attributes_mgmt' || $urls == 'attributes') { ?> class="active" <?php } ?>><a href="attributes_mgmt.php">Add a Product Attributes</a></li>
	    <li role="presentation" <?php if($urls == 'discount_mgmt' || $urls == 'discount') { ?> class="active" <?php } ?>><a href="discount_mgmt.php">Discount Management</a></li>
		<li role="presentation" <?php if($urls == 'products_mgmt' || $urls == 'products') { ?> class="active" <?php } ?>><a href="products_mgmt.php">Add a Product</a></li>
		<li role="presentation" <?php if($urls == 'shipping_area_mgmt' || $urls == 'shipping_area') { ?> class="active" <?php } ?>><a href="shipping_area_mgmt.php">Add Pin Code</a></li>
		<li role="presentation" <?php if($urls == 'reviews_mgmt' || $urls == 'reviews') { ?> class="active" <?php } ?>><a href="reviews_mgmt.php">Product Review</a></li>
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