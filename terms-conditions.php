<?php include('config/function.php'); ?>
<?php include 'include/header.php';?>
<div class="body-content bg-gray innerpagenor">
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="<?php echo $site_root; ?>">Home</a></li>
				<li class='active'><?php echo $newobject->getInfo($conn,"pages","title",12); ?></li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->
  <div class="container">
    <div class="terms-conditions-page">
      <div class="row">
        <div class="col-md-12 terms-conditions">
          <h2 class="heading-title"><?php echo $newobject->getInfo($conn,"pages","title",12); ?></h2>
          <div class="">
            <?php echo $newobject->getInfo($conn,"pages","description",12); ?>
            <h3>Contact Us</h3>
            <p>If you have any questions about this Agreement, please contact us filling this <a href="<?php echo $site_root; ?>contact/" class='contact-form'>contact form</a></p>
          </div>
        </div>
      </div>
      <!-- /.row --> 
    </div>
  </div>
  <!-- /.container --> 
</div>
<!-- /.body-content -->
<?php include 'include/footer.php';?>
