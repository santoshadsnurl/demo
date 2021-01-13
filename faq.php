<?php include('config/function.php'); ?>
<?php include 'include/header.php';?>
<div class="body-content bg-gray innerpagenor">
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="<?php echo $site_root; ?>">Home</a></li>
				<li class='active'>FAQ</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->
	<div class="container">
		<div class="checkout-box faq-page">
			<div class="row">
				<div class="col-md-12">
					<h2 class="heading-title">Frequently Asked Questions</h2>
					<div class="panel-group checkout-steps" id="accordion">
					<?php echo $newobject->getInfo($conn,"pages","description",5); ?>
					</div><!-- /.checkout-steps -->
				</div>
			</div><!-- /.row -->
		</div><!-- /.checkout-box -->
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	</div><!-- /.container -->
</div><!-- /.body-content -->
<?php include 'include/footer.php';?>