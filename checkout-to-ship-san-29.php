<?php 

include('config/function.php');

if(!isset($_SESSION['user_id']) OR empty($_SESSION['user_id']))
{
	echo "<script>document.location.href='".$site_root."checkout/';</script>";
	exit;
}
else
{
	$query = "SELECT * FROM shipping_address WHERE user_id='".$_SESSION['user_id']."'";
	$sql_query_shipadd = $conn->query($query);
}

if($newobject->gettotalitem($conn,$session_id)>0)
{
	$cart_session = $newobject->getconrecords($conn,"cart", "session_id = '$session_id'");
}
else	
{
	echo "<script>document.location.href='".$site_root."cart/';</script>";
	exit;
}

include 'include/header.php';
$cart_session_mob = $newobject->getconrecords($conn,"cart", "session_id = '$session_id'");

if(isset($_REQUEST['submit_shipping']))
{
	$fname = $_REQUEST['fname'];
	$lname = $_REQUEST['lname'];
	$phone_no = $_REQUEST['phone_no'];
	$alt_phone_no = $_REQUEST['alt_phone_no'];
	$city = $_REQUEST['city'];
	$street_no = $_REQUEST['street_no'];
	$house_no = $_REQUEST['house_no'];
	$pin_code = $_REQUEST['pin_code'];
	$land_mark = $_REQUEST['land_mark'];
	$address_type = $_REQUEST['address_type'];
	
	$query_insert = "INSERT INTO shipping_address SET user_id='".$_SESSION['user_id']."',fname='".$fname."',lname='".$lname."',phone_no='".$phone_no."',alt_phone_no='".$alt_phone_no."',city='".$city."',street_no='".$street_no."',pin_code='".$pin_code."',house_no='".$house_no."',land_mark='".$land_mark."',address_type='".$address_type."'";
	if($sql_insert = $conn->prepare($query_insert))
	{
		$sql_insert->execute();
	}
				
}

?>
<div class="body-content"> 
  <!-- /.body-content -->
  <div class="container">
    <div class="my-wishlist-page buynowpage ">
      <div class="row">
        <div class="col-xs-12">
          <ul class="speratelink tpsperatelink">
            <li> <a href="<?php echo $site_root; ?>cart/"> cart</a> </li>
            <li>  <a href="<?php echo $site_root; ?>checkout/">checkout </a></li>
            <li class="active"> <a href="<?php echo $site_root; ?>shipping/"> shipping</a></li>
            <li class="lastlist"><a href="<?php echo $site_root; ?>paypal/"> payment</a></li>
          </ul>
        </div>
        <div class="col-md-9 my-wishlist">
          <div class="select_delivery">
            <div class="d_add">
              <h3>Select delivery address</h3>
              <p>Default Address</p>
            </div>
            <div class="bt_add"> <a data-toggle="modal" data-target="#basicExampleModal" class="btn-upper btn btn-boder">Add a New Address</a> </div>
			<form name="paypalfrm" id="paypalfrm" action="<?php echo $site_root; ?>paypal/" method="post">
			<div class="clearfix"></div>
			<?php
			if($sql_query_shipadd->num_rows>0)
			{
				?>
				<div class="row">
					<?php
					$srl = 0;
					while($result_shipadd = $sql_query_shipadd->fetch_array(MYSQLI_ASSOC))
					{
						$srl++;
						?>
						<div class="col-xs-6">
						<div class="street">
						<div class="street_aj">
						<label class="radio">
						<input type="radio" <?php if($srl==1) { ?> checked="checked" <?php } ?> name="shipping_id" value="<?php echo $result_shipadd['id']; ?>">
						<span class="checkround"></span> </label>
						</div>
						<div class="st_ajs">
						<p><?php echo $result_shipadd['house_no']; ?>, <?php echo $result_shipadd['street_no']; ?>, <?php echo $result_shipadd['land_mark']; ?><br>
						<?php echo $result_shipadd['city']; ?> - <?php echo $result_shipadd['pin_code']; ?></p>
						<p>Mobile: <?php echo $result_shipadd['phone_no']; if($result_shipadd['alt_phone_no']!="") { echo "/".$result_shipadd['alt_phone_no']; } ?></p>
						<p>• Pay on Delivery available</p>
						<p>• Payment Gateway intergration</p>
						<!--<div class="removes">
						<button class="btn btn-boder"> Remove </button>
						<button class="btn btn-boder"> Edit </button>
						</div>-->
						</div>
						</div>
						</div>
						<?php 
					}
					?>
				</div>
				<?php
			}
			?>
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
                <a href="javascript:void(0);" onClick="javascript:document.getElementById('paypalfrm').submit();" class="btn btn-warning btn-block btn-blues"> Proceed to pay </a> </div>
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
<!-- modal : Add Address -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div class="my-wishlist-page buynowpage ">
          <div class="row">
            <div class="col-xs-12 profileinfo manage-address">
              <div class="bordarea">
                <div class="profilelist">
                  <div class="row">
                    <div class="col-xs-12">
                      <form name="shippingfrm" action="" method="post">
                        <div class="box">
                          <h4 class="text-uppercase">Contact Details</h4>
                          <div class="form-group row">
                            <div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="fname" placeholder="First Name*"  required="required">
                            </div>
                            <div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="lname" placeholder="last Name*"  required="required">
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="phone_no" placeholder="Mobile No*"  required="required">
                            </div>
							<div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="alt_phone_no" placeholder="Alternate Mobile No*"  required="required">
                            </div>
                          </div>
                        </div>
                        <div class="box">
                          <h4 class="text-uppercase">Address</h4>
                          <div class="form-group row">
                            <div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="pin_code" placeholder="Pin Code*"  required="required">
                            </div>
                            <div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="house_no" placeholder="Flat, House no., Building..*"  required="required">
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="street_no" placeholder="Area, Colony, Street, Village*"  required="required">
                            </div>
                            <div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="land_mark" placeholder="Landmark*"  required="required">
                            </div>
                          </div>
						   <div class="form-group row">
                            <div class="col-md-6 col-xs-12">
                              <input type="text" class="form-control" name="city" placeholder="City/Town*"  required="required">
                            </div>
                            <div class="col-md-6 col-xs-12">
                              <select class="form-control" name="address_type">
                                <option value="">Address Type</option>
                                <option value="Home">Home</option>
                                <option value="Office">Office</option>
                                <option value="Work">Work</option>
                              </select>
                            </div>
                          </div>
                          <button type="submit" name="submit_shipping" class="btn btn-warning">Add address</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row --> 
        </div>
        <!-- /.sigin-in--> 
      </div>
    </div>
  </div>
</div>
<?php include 'include/footer.php';?>