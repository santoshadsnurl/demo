<?php include('config/function.php'); ?>
<?php include 'include/header.php';?>
<?php 
$discount_image = $newobject->getallrecords($conn,"discount","ORDER BY id DESC");
$discount_images = $newobject->getallrecords($conn,"discount","ORDER BY id DESC");
$news_response = "";
if(isset($_REQUEST['subcribe']))
{
	$email = $_REQUEST['email'];
	$query_select_newsletters = "SELECT email FROM subscribers WHERE email='".$email."'";
	if($sql_insert_newsletters = $conn->query($query_select_newsletters))
	{
		if($sql_insert_newsletters->num_rows>0)
		{
			$news_response = "This user already exist !";
			echo "<script>alert('$news_response');</script>";
		}
		else
		{
			$query_insert = "INSERT INTO subscribers SET email='".$email."',date=now()";
			if($sql_insert = $conn->prepare($query_insert))
			{
				$sql_insert->execute();
				$news_response = "Thank you for your subscription !";
				echo "<script>alert('$news_response');</script>";
			}
		}
	}
}
?>
<!-- ===== HERO ====== -->
<?php 
if($sliders_image->num_rows>0)
{
	?>
<div id="hero">
  <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
    <?php
		while($sliders_image_result = $sliders_image->fetch_array(MYSQLI_ASSOC))
		{
			?>
    <div class="item" style="background-image: url(<?php echo $sliders_image_result['image']; ?>);">
      <div class="container">
        <div class="caption bg-color vertical-center text-left">
          <div class="big-text fadeInDown-1"> <?php echo $sliders_image_result['title']; ?> </div>
          <div class="excerpt fadeInDown-2 hidden-xs"> <span><?php echo $sliders_image_result['offer']; ?></span> </div>
          <div class="button-holder fadeInDown-3" style="opacity: 1; top: 0px;"> <a href="<?php echo $sliders_image_result['order_no']; ?>" class="btn-lg btn btn-uppercase btn-warning btn-blues shop-now-button">Shop Now</a> </div>
        </div>
        <!-- /.caption --> 
      </div>
      <!-- /.container-fluid --> 
    </div>
    <?php
		}
		?>
  </div>
  <!-- /.owl-carousel --> 
</div>
<?php
}
?>
<!-- ======= INFO BOXES ======= -->
<div class="info-boxes wow fadeInUp">
  <div class="info-boxes-inner">
    <div class="container">
      <div class="info-boxes-outer">
        <div class="row">
          <div class="col-md-6 col-sm-4 col-lg-3">
            <div class="media info-box">
              <div class="media-left"> <img src="assets/images/icon/icon-shopping.png" class="media-object"> </div>
              <div class="media-body">
                <h4 class="info-box-heading"> Free shipping</h4>
                <h6 class="text"> Free shipping to any where in India</h6>
              </div>
            </div>
          </div>
          <!-- .col -->
          <div class="hidden-md col-sm-4 col-lg-3">
            <div class="media info-box">
              <div class="media-left"> <img src="assets/images/icon/icon-money.png" class="media-object"> </div>
              <div class="media-body">
                <h4 class="info-box-heading"> 100% Money back</h4>
                <h6 class="text"> Easy Return &amp; Refund Process </h6>
              </div>
            </div>
          </div>
          <!-- .col -->
          <div class="col-md-6 col-sm-3 col-lg-3">
            <div class="media info-box">
              <div class="media-left"> <img src="assets/images/icon/icon-center.png" class="media-object"> </div>
              <div class="media-body">
                <h4 class="info-box-heading"> Help Center</h4>
                <h6 class="text">Quick Support </h6>
              </div>
            </div>
          </div>
          <!-- .col -->
          <div class="hidden-md col-sm-4 col-lg-3">
            <div class="media info-box">
              <div class="media-left"> <img src="assets/images/icon/icon-payment.png" class="media-object"> </div>
              <div class="media-body">
                <h4 class="info-box-heading"> Payment Method </h4>
                <h6 class="text">We use tursted & secure payment gateways </h6>
              </div>
            </div>
          </div>
          <!-- .col --> 
        </div>
        <!-- /.row --> 
      </div>
    </div>
  </div>
  <!-- /.info-boxes-inner --> 
</div>
<?php 
$dod = $newobject->getconlimit($conn,"products","hot = 1","ORDER BY id DESC","LIMIT 1");
if($dod->num_rows>0)
{
	?>
<!-- ======= dealofday  ======= -->
<section class="dealofday">
  <div class="container"> 
    <!-- ======= WIDE PRODUCTS ======= -->
    <div class="wide-banners wow fadeInUp outer-bottom-xs">
      <div class="row">
        <div class="col-xs-12 headtitle">
          <h3 class="section-title">Ramanta Deals Of The Day <span>Deals Refresh Every 8 Hours</span></h3>
          <!--<a href="category-detail.php" class="btn-lg btn btn-uppercase btn-warning btn-blues  shop-now-button pull-right">View all</a> --> 
        </div>
      </div>
      <div class="row">
        <?php $dod_result = $dod->fetch_array(MYSQLI_ASSOC);?>
        <div class="col-md-6 col-sm-6">
          <div class="wide-banner wide-banner1 cnt-strip">
            <div class="image"> <a class="linkup" href="<?php echo $site_root; ?>detail/<?php echo $dod_result['alias']; ?>/"><img class="img-responsive" src="<?php echo $site_root; ?>uploads/products/<?php echo $dod_result['image']; ?>" alt="Deals offer"></a>
              <div class="widecontent">
                <h4 class="widecontenttitle"> <?php echo $dod_result['title']; ?> <span> Starting from <small class="widecontentprice"> <?php echo $dod_result['sale_price']; ?>&#x20b9; </small> </span></h4>
                <div class="price_dd">
                <span class="f_price"> Rs.<?php echo $dod_result['special_price']; ?> </span>
                <span  class="o_price">Rs.<?php echo $dod_result['sale_price']; ?></span>                
                <span  class="o_price1">Rs.<?php echo $dod_result['price']; ?></span>  
                <span class="o_discount"><?php echo round (100 - $dod_result['special_price'] * (100/$dod_result['price']),0); ?>% off</span>
                </div>
                <a href="javascript:void(0);" onClick="BuyNow('<?php echo $dod_result['id']; ?>');" class="btn-lg btn btn-uppercase btn-warning btn-blues  shop-now-button">shop now </a> </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="row">
            <?php 
				$dod1 = $newobject->getconlimit($conn,"products","hot = 1","ORDER BY id","LIMIT 4");
				if($dod1->num_rows>0)
				{
					while($dod_result1 = $dod1->fetch_array(MYSQLI_ASSOC))
					{
						?>
						<div class="col-md-6 col-sm-6">
						  <div class="wide-banner cnt-strip mb30">
							<div class="image"> <a class="linkup"  href="<?php echo $site_root; ?>detail/<?php echo $dod_result1['alias']; ?>/"><img class="img-responsive" src="<?php echo $site_root; ?>uploads/products/<?php echo $dod_result1['image']; ?>" alt="Deals offer"></a>
							  <div class="widecontent">
								<h4 class=" widecontenttitle2"><?php echo $dod_result1['title']; ?> <span> Starting from <small class="widecontentprice"> <?php echo $dod_result1['sale_price']; ?>&#x20b9; </small> </span> </h4>
									 <div class="price_dd price_dd2">
							<span class="f_price"> Rs.<?php echo $dod_result1['special_price']; ?> </span>
							<span  class="o_price">Rs.<?php echo $dod_result1['sale_price']; ?></span>                
							<span  class="o_price1">Rs.<?php echo $dod_result1['price']; ?></span>  
							<span class="o_discount"><?php echo round (100 - $dod_result1['special_price'] * (100/$dod_result1['price']),0); ?>% off</span>
							</div>
								<a href="javascript:void(0);" onClick="BuyNow('<?php echo $dod_result1['id']; ?>');" class="btn-lg btn btn-uppercase btn-warning btn-blues  shop-now-button">shop now </a> </div>
							</div>
						  </div>
						</div>
						<?php 
						}
					}
					?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
}
?>
<div class="container">
  <?php 
$sub_categories = $newobject->getcondrecords($conn,"sub_categories","featured = 1","ORDER BY order_no");
if($sub_categories->num_rows>0)
{
	while($sub_categories_result = $sub_categories->fetch_array(MYSQLI_ASSOC))
	{
		$sub_category_id = $sub_categories_result['id'];
		$products = $newobject->getconrecords($conn,"products","sub_category_id = '$sub_category_id'");
		if($products->num_rows>0)
		{
			?>
  <!-- =======   ELECTRONIC PRODUCT ======= -->
  <section class="section featured-product eletronic-product wow fadeInUp">
    <div class="row">
      <div class="col-xs-12 headtitle">
        <h3 class="section-title"> <?php echo $sub_categories_result['title']; ?> <span>check the latest deal on your  product </span></h3>
        <a href="<?php echo $site_root; ?>sub-categories/<?php echo $sub_categories_result['alias']; ?>/" class="btn-lg btn btn-uppercase btn-warning btn-blues  shop-now-button pull-right">View all</a> </div>
    </div>
    <div class="row">
      <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
        <?php
					while($products_result = $products->fetch_array(MYSQLI_ASSOC))
					{
						?>
        <div class="item item-carousel">
          <div class="products">
            <div class="product">
              <div class="product-image"> <a href="<?php echo $site_root; ?>detail/<?php echo $products_result['alias']; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $products_result['image']; ?>" alt="essentials product"></a> </div>
              <div class="product-info text-left">
                <h3 class="name"><a href="<?php echo $site_root; ?>detail/<?php echo $products_result['alias']; ?>/"><?php echo $products_result['title']; ?> </a></h3>
                <div class="product-price"> <span class="price"> &#x20b9; <?php echo $products_result['price']; ?> </span> <span class="price-before-discount"> <?php echo $products_result['sale_price']; ?></span> </div>
              </div>
              <div class="cart clearfix animate-effect">
                <div class="action">
                  <ul class="list-unstyled">
                    <li class="add-cart-button btn-group">
                      <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i class="fa fa-shopping-cart"></i> </button>
                      <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                    </li>
                    <li class="lnk wishlist"> <a class="add-to-cart" href="#" title="Wishlist"> <i class="icon fa fa-heart"></i> </a> </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
					}
					?>
      </div>
    </div>
  </section>
  <?php
		}
	}
}
?>

    
    <!-- ======= short ads  ======= -->
  <div class="wide-banners wow fadeInUp outer-bottom-xs">
    <div class="row">
    
<div class="col-xs-12">

				<div class="sub-img-banner">
  <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel" >
    <!-- Indicators -->
    <ol class="carousel-indicators">
	<?php 
	if($discount_image->num_rows>0)
	{
		$c = 0; 
		while($sliders_image_result = $discount_image->fetch_array(MYSQLI_ASSOC))
		{
			$c++;
			?>
			<li data-target="#myCarousel" data-slide-to="<?php echo $c; ?>" <?php if($c==1) { ?> class="active" <?php } ?>></li>
			<?php 
		}
	}
	?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
<?php 
	if($discount_images->num_rows>0)
	{
		$c = 0; 
		while($sliders_image_result = $discount_images->fetch_array(MYSQLI_ASSOC))
		{
			$c++;
			?>
      <div class="item <?php if($c==1) { ?>active<?php } ?>">
   <img src="<?php echo $sliders_image_result['image']; ?>" alt="img2" class="img-responsive">
        <div class="carousel-caption pro_code_area">
		      <p><?php echo $sliders_image_result['description']; ?></p>
          <h3><span class="promo_code_home">promo code </span><?php echo $sliders_image_result['code']; ?></h3>
		  
    
        </div>
      </div>
	<?php 
		}
	}
	?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>         
    </div>
  </div>  
    </div>
  </div>
</div>
<!-- ======= New Letter ======= -->
<section class="newletter">
  <div class="container">
    <div class="row">
      <div class="col-md-7 col-xs-12">
        <div class="nltitle">
          <h4> <small><i class="fa fa-envelope-o"> </i> </small> newsletter
            <p>Enter your email to get tips of new products and specials Offers from Ramanta Store </p>
          </h4>
        </div>
      </div>
      <div class="col-md-5 col-xs-12">
        <div class="form-nl">
          <form role="form" name="newletterfrm" id="newletterfrm" method="post">
            <input type="email" name="email" placeholder="Enter your email address">
            <button type="submit" name="subcribe"> submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php 
if($most_viewed_products->num_rows>0)
{
	?>
<!-- ======= Recently Viewd ======= -->
<section class="section featured-product eletronic-product wow fadeInUp rowarea">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 headtitle">
        <h3 class="section-title"> MOST VIEWD <span>CHECK MOST VIEWED ITEMS</span></h3>
      </div>
      <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
        <?php
		while($result_most_viewed_products = $most_viewed_products->fetch_array(MYSQLI_ASSOC))
		{
			?>
        <div class="item item-carousel">
          <div class="products">
            <div class="product">
              <div class="product-image"> <a href="<?php echo $site_root; ?>detail/<?php echo $result_most_viewed_products['alias']; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $result_most_viewed_products['image']; ?>" alt="essentials product"></a> 
                <!-- /.image --> 
              </div>
              <!-- /.product-image -->
              <div class="product-info text-center">
                <h3 class="name"><a href="<?php echo $site_root; ?>detail/<?php echo $result_most_viewed_products['alias']; ?>/"><?php echo $result_most_viewed_products['title']; ?></a></h3>
                <!-- /.product-price --> 
              </div>
              <!-- /.product-info -->
              <div class="cart clearfix animate-effect">
                <div class="action">
                  <ul class="list-unstyled">
                    <li class="add-cart-button btn-group">
                      <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i class="fa fa-shopping-cart"></i> </button>
                      <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                    </li>
                    <li class="lnk wishlist"> <a class="add-to-cart" href="#" title="Wishlist"> <i class="icon fa fa-heart"></i> </a> </li>
                  </ul>
                </div>
                <!-- /.action --> 
              </div>
              <!-- /.cart --> 
            </div>
            <!-- /.product --> 
          </div>
          <!-- /.products --> 
        </div>
        <?php
		}
		?>
      </div>
    </div>
  </div>
</section>
<?php
}
?>
<?php include 'include/footer.php';?>
<script type="text/javascript">
$(document).ready(function() {
    $('#newletterfrm').bootstrapValidator({
		//live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: {
					notEmpty: {
						message: 'The email required and cannot be empty'
					},
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            }
        }
    });
});
</script> 