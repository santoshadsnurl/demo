<?php 

include('config/function.php');

if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
{
	echo "<script>document.location.href='".$site_root."';</script>";
	exit;
}
else
{
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
}

?>
<?php include 'include/header.php';?>

<div class="body-content"> 
  <!-- /.body-content -->
  <div class="container">
    <div class="my-wishlist-page ">
      <div class="row">
        <div class="col-md-3 col-12">
          <?php include('include/left.php'); ?>
        </div>
        <div class="col-md-9 profileinfo manage-address">
          <div class="bordarea">
            <h3>Manage Address </h3>
            <div class="profilelist">
              <div class="row">
                <div class="col-md-11 col-xs-12">
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
              <div class="row viewdataadds">
                <div class="col-sm-6 col-xs-12">
                  <div class="street">
                    <h4>Home</h4>
                    <div class="street_aj">
                      <label class="radio">
                        <input type="radio" checked="checked" name="shipping_id" value="8">
                        <span class="checkround"></span> </label>
                    </div>
                    <div class="st_ajs">
                      <p>Mohit Kapoor </p>
                      <p><span>Mobile :</span>+91- 9876543210</p>
                      <p><span>Address :</span> C-12, dgfdhgf1563, moti nagar<br>
                        basti - 110093</p>
                      <div class="removes">
                        <button class="btn btn-boder"  data-toggle="modal" data-target="#modelReturn"> Edit </button>
                        <button class="btn btn-boder btn-remove"> Remove </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                  <div class="street">
                    <h4>Office</h4>
                    <div class="street_aj">
                      <label class="radio">
                        <input type="radio" name="shipping_id" value="9">
                        <span class="checkround"></span> </label>
                    </div>
                    <div class="st_ajs">
                      <p>Mohit Kapoor </p>
                      <p><span>Mobile :</span>+91- 9876543210</p>
                      <p><span>Address :</span> C-12, dgfdhgf1563, moti nagar<br>
                        basti - 110093</p>
                      <div class="removes">
                        <button class="btn btn-boder"  data-toggle="modal" data-target="#modelReturn2"> Edit </button>
                        <button class="btn btn-boder btn-remove"> Remove </button>
                      </div>
                    </div>
                  </div>
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





<div class="modal fade model_design" id="modelReturn" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Address </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      

        
      
        
              <div class="row">
                <div class="col-md-11 col-xs-12">
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
                      <button type="submit" name="submit_shipping" class="btn btn-warning">Update Address</button>
                    </div>
                  </form>
                </div>
              </div>
       
    
    

      </div>
    </div>
  </div>
</div>



<div class="modal fade model_design" id="modelReturn2" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Address </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      

        
      
        
              <div class="row">
                <div class="col-md-11 col-xs-12">
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
                      <button type="submit" name="submit_shipping" class="btn btn-warning">Update Address</button>
                    </div>
                  </form>
                </div>
              </div>
       
    
    

      </div>
    </div>
  </div>
</div>







<?php include 'include/footer.php';?>

