<?php 

include('config/function.php'); 

include 'include/header.php';

if(isset($_REQUEST['alias']) && $_REQUEST['alias']!="")
{
	$aliass = $_REQUEST['alias'];
}
else
{
	echo "<script>document.location.href='".$site_root."'</script>";
	exit;
}

?>
<div class="body-content bg-gray innerpagenor">
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="<?php echo $site_root; ?>">Home</a></li>
				<li class='active'><?php echo $newobject->getdata($conn,"shop_online",$arabic."title","alias",$aliass); ?></li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->
  <div class="container">
    <div class="terms-conditions-page">
      <div class="row">
        <div class="col-md-12 terms-conditions">
          <h2 class="heading-title"><?php echo $newobject->getdata($conn,"shop_online",$arabic."title","alias",$aliass); ?></h2>
          <div class="">
            <?php echo $newobject->getdata($conn,"shop_online",$arabic."description","alias",$aliass); ?>
            <h3>Contact Us</h3>
            <p>If you have any questions about this Agreement, please contact us filling this <a href="contact.php" class='contact-form'>contact form</a></p>
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
