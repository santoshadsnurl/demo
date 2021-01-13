<?php 

include('config/function.php'); 

if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
{
	echo "<script>document.location.href='".$site_root."';</script>";
	exit;
}
else
{
	$query_chkdup = "SELECT * FROM wishlist WHERE user_id = '".$_SESSION['user_id']."'";
}

include 'include/header.php';

?>
<div class="body-content">
  <!-- /.body-content -->
  <div class="container">
    <div class="my-wishlist-page">
      <div class="row">
        <div class="col-md-3 col-12">
          <?php include('include/left.php'); ?>
        </div>
        <div class="col-md-9 col-12 my-wishlist my-order">
		<?php		
		if($sql_chfdup = $conn->query($query_chkdup))
		{
			if($sql_chfdup->num_rows>0)
			{
				?>
          <div class="table-responsive">
            <table class="table">
              <tbody>
			  <?php
			  while($result_wishlist = $sql_chfdup->fetch_array(MYSQLI_ASSOC))
			{
				$product_id_wishlist = $result_wishlist['product_id'];
				$title = $newobject->getInfo($conn,"products","title",$product_id_wishlist);
				$image = $newobject->getInfo($conn,"products","image",$product_id_wishlist);
				$price = $newobject->getInfo($conn,"products","price",$product_id_wishlist);
				?>
                <tr class="wishlistarea">
                  <td >
                    <div class="ordermain ordermainimg ">
                      <div class="col-2">
                        <div class="wishlistitemimg">  <img src="<?php echo $site_root; ?>uploads/products/<?php echo $image; ?>" alt="imga"> </div>
                      </div>
                      <div class="col-7">
                        <div class="product-name"><a href="javascript:void(0);"><?php echo $title; ?></a></div>
                        <div class="price"><i class="fa fa-rupee"></i> <?php echo $price; ?>  <span class="remove_item"> <a href="javascript:void(0);" onClick="removewishlist('<?php echo $product_id_wishlist; ?>');">Remove item</a></span> </div>
                      </div>
                      <div class="col-3">
                        <div class="wishlistdate"> <span>Added 20 October 2019</span> </div>
                        <div class="btnmyorder">
                          <a href="javascript:void(0);" onClick="AddCart('<?php echo $product_id_wishlist; ?>');" class="btn-upper btn btn-default"> Add to cart</a>
                          <a href="javascript:void(0);" onClick="BuyNow('<?php echo $product_id_wishlist; ?>');" class="btn-upper btn btn-default">Buy Now</a>
                        </div>
                      </div>
                    </div></td>
                  </tr>
					<?php
			}
			?>
                      </tbody>
                    </table>
                  </div>
				  <?php 
	}
	else
	{
		?>
		<div class="alert alert-danger" style="text-align:center; margin-top:25px;"><strong><?php echo changelanguage($conn,"There is no product in your wishlist !","لا يوجد منتج في هذه الفئة، فإننا نقوم بإضافة!"); ?></strong></div>
		<?php
	}
}
?>
		</div>
	  </div>
	  <!-- /.row -->
	</div>
	<!-- /.sigin-in-->
  </div>
</div>
<?php include 'include/footer.php';?>