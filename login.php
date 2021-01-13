<?php 

include('config/function.php');

$response = "";

if(isset($_REQUEST['submitsignin']))
{
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$query_selectlogin = "SELECT * FROM users WHERE email='".$email."' AND password='".$password."'";
	if($sql_selectlogin = $conn->query($query_selectlogin))
	{
		if($sql_selectlogin->num_rows>0)
		{
			$result = $sql_selectlogin->fetch_array(MYSQLI_ASSOC);
			$status = $result['status'];
			$_SESSION['user_id'] = $result['id'];
			$_SESSION['user_name'] = $result['email'];
			if($newobject->gettotalitem($conn,$session_id)>0)
			{
				echo "<script>document.location.href='".$site_root."checkout-to-ship/';</script>";
				exit;
			}
			else
			{
				echo "<script>document.location.href='".$site_root."my-account/';</script>";
				exit;
			}
		}
		else
		{
			$response = "Incorrect Email Or Password...";
		}
	}
}

include 'include/header.php';
?>
<!-- ===== HERO ====== -->
<section class="bg_login">
  <div class="login-form from_logins">
    <div class="loginpanel">
      <div class="login_left">
        <div class="rmnstore">
          <h4> One stop shop for your needs</h4>
          <ul>
            <li>Wide Collection of our Products</li>
            <li> Best Quality of Products &amp; Service By Ramanta  Store</li>
            <li> Fast and On-time Delivery for all products</li>
          </ul>
        </div>
      </div>
      <div class="login_right">
        <form name="signinfrm" id="signinfrm" method="post"   onsubmit="validate(...)">
          <h2 class="text-center">login to ramanta Store </h2>
			<?php if(isset($_SESSION['response_success']) && !empty($_SESSION['response_success'])) { ?>
			<div class="alert alert-success" style="text-align:center;"><?php  echo $_SESSION['response_success']; unset($_SESSION['response_success']); ?></div>
			<?php } ?>
			<?php if($response!="") { ?>
			<div class="alert alert-danger" style="text-align:center;"><?php  echo $response; ?></div>
			<?php } ?>
          <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Email address" required="required">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
          </div>
          <div class="clearfix"> <a href="<?php echo $site_root; ?>forgot-password/" class="pull-right forgotpwd">Forgot Password?</a> </div>
          <div class="form-group">
            <button type="submit" name="submitsignin" class="btn btn-block btn-blues high" id="btnbtnbtn" >Login</button>
          </div>
          <p class="text-center logincreate">New to Ramanta Store? <a href="<?php echo $site_root; ?>signup/">Create an Account</a></p>
        </form>
      </div>
      <div class="login_clip"> <img src="<?php echo $site_root; ?>assets/images/login_clip.png" alt="login help icon" class="img-responsive login_img"> </div>
    </div>
  </div>
</section>
<?php include 'include/footer.php';?>




<script>

$(document).ready(function() 
{
	$('#signinfrm').bootstrapValidator(
	{
	
		feedbackIcons: 
		{
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh',
		
		},
		
		

			  
		fields: 
		{
			email: 
			{
				validators: 
				{
					notEmpty: 
					{
						message: 'Please Enter Email Address'
					},
					emailAddress: 
					{
						message: 'Please Enter Valid Email Address'
					}
				}
			},
			password: 
			{
				validators: 
				{
					notEmpty: 
					{
						message: 'Please Enter Password'
					}
				}
			},
		}
	})
});


</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> <!-- or use local jquery -->

<script>
  $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
</script>








