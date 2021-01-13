<a href="index.php" title=""><img src="images/logo.png" alt="logo" class="img-responsive"></a>
<h3 class="headn-h3">Admin Panel</h3>
<div class="bs-example" data-example-id="simple-nav-stacked">
	<ul class="nav nav-pills nav-stacked nav-pills-stacked-example">
		<li role="presentation" <?php if($urls == 'cms') { ?> class="active" <?php } ?>><a href="cms.php">CMS</a></li>
		<li role="presentation" <?php if($urls == 'cms-pages' || $urls == 'pages') { ?> class="active" <?php } ?>><a href="cms-pages.php">Pages</a></li>
		<li role="presentation" <?php if($urls == 'logo' || $urls == 'logo') { ?> class="active" <?php } ?>><a href="logo.php">Logo</a></li>
		<li role="presentation" <?php if($urls == 'sliders_mgmt' || $urls == 'sliders') { ?> class="active" <?php } ?>><a href="sliders_mgmt.php">Banner Slider</a></li>
		<!--<li role="presentation" <?php if($urls == 'social_links_mgmt' || $urls == 'social_links') { ?> class="active" <?php } ?>><a href="social_links_mgmt.php">Social Media Links</a></li>
		<li role="presentation" <?php if($urls == 'faqs_mgmt' || $urls == 'faqs') { ?> class="active" <?php } ?>><a href="faqs_mgmt.php">FAQs Management</a></li>
		<li role="presentation" <?php if($urls == 'com_info_mgmt' || $urls == 'com_info') { ?> class="active" <?php } ?>><a href="com_info_mgmt.php">Quick Links</a></li>-->
		<li role="presentation" <?php if($urls == 'shop_online_mgmt' || $urls == 'shop_online') { ?> class="active" <?php } ?>><a href="shop_online_mgmt.php">Help</a></li>
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