<?php

include('config/function.php');

if(!isset($_SESSION['user_id']) OR empty($_SESSION['user_id']))
{
	echo "<script>document.location.href='".$site_root."cart/';</script>";
	exit;
}

if(isset($_REQUEST['shipping_id']) && $_REQUEST['shipping_id']!="")
{
	$shipping_id = $_REQUEST['shipping_id'];
}
else
{
	echo "<script>document.location.href='".$site_root."cart/';</script>";
	exit;
}

include 'include/header.php';
$cart_session_mob = $newobject->getconrecords($conn,"cart", "session_id = '$session_id'");

?>

<div class="body-content"> 
  <!-- /.body-content -->
  <div class="container">
    <div class="my-wishlist-page buynowpage ">
      <div class="row">
        <div class="col-xs-12">
          <ul class="speratelink tpsperatelink">
            <li> <a href="<?php echo $site_root; ?>cart/"> cart</a> </li>
            <li> <a href="<?php echo $site_root; ?>checkout/">checkout </a></li>
            <li> <a href="<?php echo $site_root; ?>shipping/"> shipping</a></li>
            <li class="active"><a href="<?php echo $site_root; ?>paypal/"> payment</a></li>
          </ul>
        </div>
        <div class="col-md-9 my-wishlist">
        <div class="select_delivery">
        <div class="d_add">
          <h3>Select Payment Method</h3>
        </div>
        <form name="paypalfrm" id="paypalfrm" action="<?php echo $site_root; ?>paypal/" method="post">
          <input type="hidden" name="shipping_id" id="shipping_id" value="<?php echo $shipping_id; ?>">
          <div class="clearfix"></div>
          <div class="paym_optarea">
            <label>
              <input type="radio" name="payment_method" id="payment_method" value="cod" required/>
              <img src="<?php echo $site_root; ?>assets/images/cod.png" alt="payu" class="paym_opt"/> <strong>Cash on Delivery</strong></label>
            <label>
              <input type="radio" name="payment_method" id="payment_method" checked value="payu" required/>
              <img src="<?php echo $site_root; ?>assets/images/payu.png" alt="payu" class="paym_opt" /> <strong> Payu</strong></label>
          </div>
          </div>
          </div>
          <div class="col-md-3 col-12">
            <div class="sidebarmyaccount sidebarbuynoe">
              <div class="myprofile">
                <div class="pricedetail">
                  <h6> Price Details <span>(<?php echo $cart_session_mob->num_rows; ?> items) </span></h6>
                  <ul>
                    <li> Bag total<span>&#x20b9;<?php echo number_format($newobject->subTotal($conn,$session_id),2); ?></span> </li>
                    <li> Bag Discount<span>&#x20b9;0.00</span> </li>
                    <li> Delivery Charges<span>Free</span> </li>
                    <li> Order Total <span>&#x20b9;<?php echo number_format($newobject->subTotal($conn,$session_id),2); ?></span> </li>
                  </ul>
                  <a href="javascript:void(0);" onClick="javascript:document.getElementById('paypalfrm').submit();" class="btn btn-warning btn-block btn-blues"> Pay Now </a> </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- /.row --> 
    </div>
    <!-- /.sigin-in--> 
    <!-- ======= Recently Viewd ======= --> 
  </div>
</div>
<?php include 'include/footer.php'; ?>
