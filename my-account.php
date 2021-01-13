<?php 

include('config/function.php');

if(!isset($_SESSION['user_id']) OR empty($_SESSION['user_id']))
{
	echo "<script>document.location.href='".$site_root."';</script>";
	exit;
}
else
{
	$query = "SELECT * FROM shipping_address WHERE user_id='".$_SESSION['user_id']."'";
	$sql_query_shipadd = $conn->query($query);
}

include 'include/header.php';

if(isset($_REQUEST['account_info']))
{
	$fname = $_REQUEST['fname'];
	$lname = $_REQUEST['lname'];

	$query_update_pro = "UPDATE users SET fname='".$fname."',lname='".$lname."' WHERE id='".$_SESSION['user_id']."'";
	if($sql_update_pro = $conn->prepare($query_update_pro))
	{
		$sql_update_pro->execute();
		if($sql_update_pro->affected_rows==1)
		{
			$news_response = "Update Successfully !";
			echo "<script>popmsz('$news_response');</script>";
		}
	}
}

if(isset($_REQUEST['update_phone']))
{
	$phone_no = $_REQUEST['phone_no'];

	$query_update_pro = "UPDATE users SET phone_no='".$phone_no."' WHERE id='".$_SESSION['user_id']."'";
	if($sql_update_pro = $conn->prepare($query_update_pro))
	{
		$sql_update_pro->execute();
		if($sql_update_pro->affected_rows==1)
		{
			$news_response = "Update Successfully !";
			echo "<script>popmsz('$news_response');</script>";
		}
	}
}

if(isset($_REQUEST['delete_account']))
{
	$password = md5($_POST['password']);
	$query_selectlogin = "SELECT * FROM users WHERE email='".$email."' AND password='".$password."' AND status = '1'";
	if($sql_selectlogin = $conn->query($query_selectlogin))
	{
		if($sql_selectlogin->num_rows>0)
		{
			$query_update_pro = "UPDATE users SET status = '1' WHERE id='".$_SESSION['user_id']."'";
			if($sql_update_pro = $conn->prepare($query_update_pro))
			{
				$sql_update_pro->execute();
				if($sql_update_pro->affected_rows==1)
				{
					$news_response = "Account Removed Successfully !";
					echo "<script>popmsz('$news_response');</script>";
				}
			}
		}
		else
		{
			$news_response = "Password not matched !";
			echo "<script>popmsz('$news_response');</script>";
		}
	}
}

?>
<div class="body-content">
  <!-- /.body-content -->
  <div class="container">
    <div class="my-wishlist-page">
      <div class="row">
        <div class="col-md-3 col-12">
          <?php include 'include/left.php';?>
        </div>
        <div class="col-md-9 profileinfo">
          <div class="bordarea">
            <h3>Personal information </h3>
            <div class="profilelist">
              <ul>
                <li> Name: <span> <?php echo $name; ?> </span> </li>
              </ul>
              <a href="#" data-toggle="modal" data-target="#basicExampleModal"  class="edit_profile btn-blues"> Edit </a> 
			</div>
			<div class="profilelist">
			  <ul>
				<li> Mobile no: <span> <?php echo $phone_no; ?> </span> </li>
			  </ul>
			  <a href="#" data-toggle="modal" data-target="#basicExampleModal3" class="edit_profile btn-blues"> Edit </a> 
			</div>
                    <div class="profilelist">
                      <ul>
                        <li> Deactivated my account </li>
                      </ul>
                      <a href="#" data-toggle="modal" data-target="#basicExampleModal5" class="edit_profile btn-blues btn-danger"> Delete </a> 
					  </div>
                      <div class="profilelist profilefaq">
                        <h4>FAQ</h4>
                        <h5>What happens when i update my email address (or mobile number)?</h5>
                        <p>Your logn email id (or mobile number ) changes, likewise. you'll recive all your account related communication
                        on your updated email address.</p>
                        <h5>When will my Ramanata account be updated with the new email address (or mobile number)?</h5>
                        <p>It happens as soon as you confirm the verification code sent to your email (or mobile) and save the changes.</p>
                        <h5>What happens when i update my email address (or mobile number)?</h5>
                        <p>Your logn email id (or mobile number ) changes, likewise. you'll recive all your account related communication
                        on your updated email address.</p>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.sigin-in-->
            </div>
          </div>
<!-- modal : Edit Name  -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div class="my-wishlist-page buynowpage ">
          <div class="row">
            <div class="col-12 profileinfo manage-address">
              <div class="bordarea">
                <div class="profilelist">
                  <div class="row">
                    <div class="col-12">
						<form action="" method="post">
						<div class="box">
						<h4 class="text-uppercase">Change Name:</h4>
						<div class="form-group row">
						<div class="col-md-8 col-xs-12">
						<input type="text" name="fname" class="form-control" placeholder="First Name*"  required="required">
						</div>
						</div>
						<div class="form-group row">
						<div class="col-md-8 col-xs-12">
						<input type="text" name="lname" class="form-control" placeholder="Last Name*"  required="required">
						</div>
						</div>
						</div>
						<button type="submit" name="account_info" class="btn btn-warning">Submit</button>
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

<!-- modal : Mobile no   -->
<div class="modal fade" id="basicExampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div class="my-wishlist-page buynowpage ">
          <div class="row">
            <div class="col-12 profileinfo manage-address">
              <div class="bordarea">
                <div class="profilelist">
                  <div class="row">
                    <div class="col-12">
						<form action="" method="post">
						<div class="box">
						<h4 class="text-uppercase">Change Mobile Number:</h4>
						<div class="form-group row">
						<div class="col-md-8 col-xs-12">
						<input type="text" name="phone_no" class="form-control" placeholder="Mobile Number*"  required="required">
						</div>
						</div>
						</div>
						<button type="submit" name="update_phone" class="btn btn-warning">Submit</button>
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

<!-- modal : Delete Account   -->
<div class="modal fade" id="basicExampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div class="my-wishlist-page buynowpage">
          <div class="row">
            <div class="col-12 profileinfo manage-address">
              <div class="bordarea">
                <div class="profilelist">
                  <div class="row">
                    <div class="col-12">
                      <form action="" method="post">
                        <div class="box">
                          <h5> Delete your account</h5>
                          <h6>Please enter your password to delete your account:</h6>
                          <div class="form-group row">
                            <div class="col-md-8 col-12">
                              <input type="password" name="password" class="form-control" placeholder="Enter Password*"  required="required">
                            </div>
                          </div>
                        </div>
                        <button type="submit" name="delete_account" class="btn btn-warning">Delete account</button>
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