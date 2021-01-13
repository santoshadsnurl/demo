<?php include('config/function.php'); ?>
<?php include 'include/header.php';?>

<div class="body-content bg-gray innerpagenor">
<div class="breadcrumb">
  <div class="container">
    <div class="breadcrumb-inner">
      <ul class="list-inline list-unstyled">
        <li><a href="<?php echo $site_root; ?>">Home</a></li>
        <li class='active'><?php echo $newobject->getInfo($conn,"pages","title",2); ?></li>
      </ul>
    </div>
  </div>
</div>
<div class="container">
<div class="contact-page">
  <div class="row">
    <div class="col-md-12">
      <div class=""> <?php echo $newobject->getInfo($conn,"pages","description",2); ?> </div>
    </div>
    

      </div>
  </div>
</div>

</div>
<!-- /.body-content -->

<?php include 'include/footer.php';?>
