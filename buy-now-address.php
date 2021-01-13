<?php 
include('config/function.php');
include 'include/header.php';
?>
<div class="body-content"> 
  
  <!-- /.body-content -->
  <div class="container">
    <div class="my-wishlist-page buynowpage ">
      <div class="row">
        <div class="col-xs-12">
          <ul class="speratelink tpsperatelink">
            <li class="active"><a href="login.php"> Sign in</a> </li>
            <li  class="active"> <a href="buy-now.php">Bag </a></li>
            <li class="active" <a href="buy-now-and-confirm.php"> address</a>
            </li>
            <li class="lastlist"><a href="#"> payment</a></li>
          </ul>
        </div>
        <div class="col-md-9 profileinfo manage-address">
          <div class="bordarea">
            <div class="profilelist">
              <div class="row">
                <div class="col-md-11 col-xs-12">
                  <form action="#" method="post">
                    <div class="box">
                      <h4 class="text-uppercase">Contact Details</h4>
                      <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                          <input type="text" class="form-control" placeholder="First Name*"  required="required">
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <input type="text" class="form-control" placeholder="last Name*"  required="required">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                          <input type="email" class="form-control" placeholder="Email Address*"  required="required">
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <input type="text" class="form-control" placeholder="Mobile No*"  required="required">
                        </div>
                      </div>
                    </div>
                    <div class="box">
                      <h4 class="text-uppercase">Address</h4>
                      <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                          <input type="text" class="form-control" placeholder="pin code*"  required="required">
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <input type="text" class="form-control" placeholder="state*"  required="required">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class=" col-xs-12">
                          <textarea type="email" class="form-control address" placeholder="Address (House No, Building, Street, area)*"  required="required"> </textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                          <input type="text" class="form-control" placeholder="Locality/Town**"  required="required">
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <select  class="form-control">
                            <option selected>Address Type</option>
                            <option value="1">home</option>
                            <option value="2">Office</option>
                            <option value="3">work</option>
                            <option value="4">room</option>
                          </select>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-warning">Add address</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-12">
          <div class="sidebarmyaccount sidebarbuynoe">
            <div class="myprofile">
              <div class="pricedetail apply_coup">
                <h3>Delivery Estimated </h3>
                <div class="buy_watch"> <img src="assets/images/watch_buy.png"> <span>Estimated delivery by 19 mar 2020 </span> </div>
                <h6> Price Details <span>(1 items) </span></h6>
                <ul>
                  <li> Bag total<span>304</span> </li>
                  <li> Bag Discount<span>100</span> </li>
                  <li> Order Total <span>304</span> </li>
                  <li> Delivery charges<span>Free</span> </li>
                  <li> Total <span>204</span> </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row --> 
      
    </div>
    <!-- /.sigin-in--> 
    
    <!-- ======= Recently Viewd ======= --> 
  </div>
</div>
<?php include 'include/footer.php';?>
