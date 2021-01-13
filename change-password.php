<?php include('config/function.php'); ?>
<?php 

include 'include/header.php';

$response = "";
$error = "";

if(isset($_POST['changepassword']))
{
	if(isset($_POST['password'])&& !empty($_POST['password']) && isset($_POST['cpassword'])&& !empty($_POST['cpassword']))
	{
		$old_password = md5($_POST['old_password']);
		$password = md5($_POST['password']);
		$cpassword = md5($_POST['cpassword']);
		$query_pass = "SELECT id FROM users WHERE id='".$_SESSION['user_id']."' AND password='".$old_password."'";
		if($sql_query_pass = $conn->query($query_pass))
		{
			if($sql_query_pass->num_rows>0)
			{
				if($password == $cpassword)
				{
					$query = "UPDATE `users` SET `password` = '".$password."' WHERE `id` ='".$_SESSION['user_id']."'";
					if($sql_update = $conn->prepare($query))
					{
						$sql_update->execute();
						if($sql_update->affected_rows>0)
						{
							$response = "Your password is successfully changed!";
						}
					}
				}
				else
				{
					$error = "Both password should be same!";
				}
			}
			else
			{
				$error = "Old password not matched!";
			}
		}
    }
}

?>
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
            <h3> Change Password </h3>
			<?php if($response!="") { ?>
			<div class="alert alert-success" style="text-align:center;"><?php  echo $response; ?></div>
			<?php } ?>
			<?php if($error!="") { ?>
			<div class="alert alert-danger" style="text-align:center;"><?php  echo $error; ?></div>
			<?php } ?>
            <div class="login-form  changepass-form">
              <form action="" method="post">
                <p class="loginsubtitle">Use the form below to change the password for your Dearpet account.</p>
                <div class="form-group">
                  <label>Current Password:</label>
                  <input type="password" name="old_password" class="form-control"  required="required">
                </div>
                <div class="form-group">
                  <label>New Password:</label>
                  <input type="password" class="form-control" name="password" required="required">
                </div>
                <div class="form-group">
                  <label>Re-enter New Password</label>
                  <input type="password" class="form-control" name="cpassword" required="required">
                </div>
                <div class="ps_cart">
                  <button type="submit" name="changepassword" class="btn btn-main ">Save Changes </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.sigin-in-->
  </div>
</div>
<?php include 'include/footer.php';?>