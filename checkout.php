<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

include('config/function.php');
include 'include/header.php';
$cart_session_mob = $newobject->getconrecords($conn,"cart", "session_id = '$session_id'");

$couponcode = "";
$coupon_code = "";
$Error2Show = "";
$percent = "";

if(isset($_REQUEST['coupon_code']) && $_REQUEST['coupon_code']!="")
{	
	$couponcode = $_REQUEST['couponcode'];
	$percent = $newobject->getdiscount($conn,$couponcode);
	if($percent!=0)	
	{	
		
		$_SESSION['couponcode'] = $couponcode;			
		$_SESSION['Msg2Show'] = "".$percent."% Discount Applied";
        $_SESSION['discount_total'] = $newobject->getGrossTotal($conn,$session_id,1);	
		echo "<script>document.location.href='".$site_root."checkout/'</script>";		
		exit;	
	}	
	else	
	{		
		$Error2Show = "Invalid Promo Code!";
	}
}
?>
<div class="body-content"> 
  <!-- /.body-content -->
  <div class="container">
    <div class="my-wishlist-page buynowpage ">
      <div class="row">
		<?php if($cart_session_mob->num_rows>0) { ?>
        <div class="col-xs-12">
          <ul class="speratelink tpsperatelink">
            <li> <a href="<?php echo $site_root; ?>cart/"> cart</a> </li>
            <li class="active">  <a href="<?php echo $site_root; ?>checkout/">checkout </a></li>
            <li> <a href="<?php echo $site_root; ?>checkout-to-ship/"> shipping</a></li>
            <li class="lastlist"><a href="<?php echo $site_root; ?>paypal/"> payment</a></li>
          </ul>
        </div>
        <div class="col-md-9 my-wishlist">
          <div class="buynowtitle">
            <h4> My Shopping Bag <span> (<?php echo $cart_session_mob->num_rows; ?> item)</span> </h4>
          </div>
          <div class="table-responsive">
          <table class="table">
            <tbody>
			<?php
			$srl = 0;
			while($result_cart = $cart_session_mob->fetch_array(MYSQLI_ASSOC))
			{
				$product_id = $result_cart['product_id'];
				$cart_quantity = $result_cart['product_quantity'];
				$product_size = $result_cart['product_size'];
				$product_color = $result_cart['product_color'];
				$product_material = $result_cart['product_material'];
				$title = $newobject->getInfo($conn,"products",$arabic."title",$product_id);
				$price = $newobject->getInfo($conn,"products","price",$product_id);
				$sale_price = $newobject->getInfo($conn,"products","sale_price",$product_id);
				$image = $newobject->getInfo($conn,"products","image",$product_id);
				$alias = $newobject->getInfo($conn,"products","alias",$product_id);
				$srl++;
				?>
				  <tr class="wishlistarea">
					<td class="col-md-2"><div class="wishlistitemimg"> <a href="<?php echo $site_root; ?>detail/<?php echo $alias; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $image; ?>" alt="imga"></a> </div></td>
					<td class="col-md-8"><div class="product-name"><a href="<?php echo $site_root; ?>detail/<?php echo $alias; ?>/"><?php echo $title; ?></a></div>
					<?php if($product_size!="") { ?>
					<div class="product-name"><b>Size: </b><?php echo $product_size; ?></div>
					<?php } ?>
					<?php if($product_color!="") { ?>
					<div class="product-name"><b>Color: </b><?php echo $product_color; ?></div>
					<?php } ?>
					<?php if($product_material!="") { ?>
					<div class="product-name"><b>Material: </b><?php echo $product_material; ?></div>
					<?php } ?>
					  <div class="descri2"> "Free Delivery by Ramanta Store" </div>
					  <div class="selectdrop">
						<select onChange="UpdateProduct(this.value,'<?php echo $product_id;?>');" name="updateprodid" id="updateprodid<?php echo $srl;?>">
						  <option value="1" <?php if($cart_quantity==1) { ?>selected<?php } ?>>Quantity 1</option>
						  <option value="2" <?php if($cart_quantity==2) { ?>selected<?php } ?>>Quantity 2</option>
						  <option value="3" <?php if($cart_quantity==3) { ?>selected<?php } ?>>Quantity 3</option>
						  <option value="4" <?php if($cart_quantity==4) { ?>selected<?php } ?>>Quantity 4</option>
						  <option value="5" <?php if($cart_quantity==5) { ?>selected<?php } ?>>Quantity 5</option>
						</select>
					  </div>
						<span class="price_off"><a href="<?php echo $site_root; ?>">Continue  Shopping </a></span>    
						<span class="remove_item"><a href="javascript:void(0);" onClick="DeleteProduct('<?php echo $product_id; ?>');"> Remove </a></span> 
						<?php if(isset($_SESSION['user_id']) || !empty($_SESSION['user_id'])) { ?>
						<span class="remove_item " > <a href="javascript:void(0);" onClick="addwishlist(<?php echo $product_id;?>);">Move to wishlist</a></span>
						<?php } else { ?>
						<span class="remove_item "><a href="javascript:void(0);" onClick="wishlist();"> Move to wishlist </a></span>
						<?php } ?>
				  </td>
				  <td class="col-md-2 pricecart"><div class="price"> <i class="fa fa-inr" aria-hidden="true"></i><?php echo $sale_price; ?> <span><i class="fa fa-inr" aria-hidden="true"></i><?php echo $price; ?></span> </div></td>
				</tr>
				<?php 
			}
			?>
              </tbody>
          </table>
        </div>
        </div>
        <div class="col-md-3 col-12">
          <div class="sidebarmyaccount sidebarbuynoe">
            <div class="myprofile">
				<?php if(isset($_SESSION['Msg2Show']) && $_SESSION['Msg2Show']!="") { ?>	
					<font color="green" size="3" style="margin:10%"><b><?php echo $_SESSION['Msg2Show']; unset($_SESSION['Msg2Show']);?></b></font>
					<?php } ?>		
					<?php if($Error2Show!="") { ?>	
					<font color="red" size="3" style="margin:10%"><b><?php echo $Error2Show;?></b></font>	
					<?php } ?>	
              <div class="couponapply">
                <form name="discountfrm" action="" method="post"> 
                  <span> <img src="<?php echo $site_root; ?>assets/images/coupon.png" alt="coupon" ></span>
                  <input type="text" name="couponcode" id="couponcode" placeholder="Apply Coupon" value="<?php if(isset($_SESSION['couponcode'])) { echo $_SESSION['couponcode']; } else { echo $couponcode; } ?>" autocomplete="off" required>
                  <button name="coupon_code" value="coupon_code" id="coupon_code" class="btn btn-boder"> apply </button>
                </form>
              </div>
              <div class="pricedetail">
                <h6> Price Details <span>(<?php echo $cart_session_mob->num_rows; ?> items) </span></h6>
                <ul>
                  <li> Bag Total<span><i class="fa fa-inr" aria-hidden="true"></i><?php echo number_format($newobject->subTotal($conn,$session_id),2); ?></span> </li>
                  <li> Bag Discount<span><i class="fa fa-inr" aria-hidden="true"></i><?php echo number_format($newobject->getGrossTotal($conn,$session_id,1),2); ?></span></span> </li>
                  <li> Tax <span><i class="fa fa-inr" aria-hidden="true"></i><?php echo $newobject->getTax($conn,$session_id); ?></span></span> </li>
                  <li> Delivery Charges<span>Free</span> </li>
                  <li> Order Total <span><i class="fa fa-inr" aria-hidden="true"></i><?php echo number_format($newobject->getGrossTotal($conn,$session_id),2); ?></span> </li>
                </ul>
				<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!="") { ?>
                <a href="<?php echo $site_root; ?>checkout-to-ship/" class="btn btn-warning btn-block btn-blues"> Proceed to buy </a> </div>
				<?php } else { ?>
				<a href="javascript:void(0);" onClick="wishlist();" class="btn btn-warning btn-block btn-blues"> Proceed to buy </a> </div>
				<?php } ?>
            </div>
          </div>
        </div>
		<?php } else { ?>
		<div class="alert alert-danger" style="text-align:center; margin-top:25px;"><strong>Your cart is empty !</strong></div>	
		<?php } ?>
      </div>
      <!-- /.row --> 
    </div>
    <!-- /.sigin-in--> 
<?php 
if($most_viewed_products->num_rows>0)
{
	?>
  <!-- ======= Recently Viewd ======= -->
  <section class="section featured-product eletronic-product wow fadeInUp rowarea">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 headtitle">
          <h3 class="section-title"> You may also like <span>CHECK MOST VIEWED ITEMS</span></h3>
      </div>
      <div class="row">
        <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
		<?php
		while($result_most_viewed_products = $most_viewed_products->fetch_array(MYSQLI_ASSOC))
		{
			?>
          <div class="item item-carousel">
            <div class="products">
              <div class="product">
                <div class="product-image">
                <a href="<?php echo $site_root; ?>detail/<?php echo $result_most_viewed_products['alias']; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $result_most_viewed_products['image']; ?>" alt="essentials product"></a>
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
        <!-- /.home-owl-carousel --> 
      </div>
    </div>
  </section>
  <?php
}
?>
  </div>
</div>
<?php include 'include/footer.php';?>