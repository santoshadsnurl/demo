<?php 

include('config/function.php');

$response = "";
$error = "";

if(isset($_REQUEST['forgotsubmit']))
{
	$email = $_REQUEST['email'];
	$query = "SELECT * FROM `users` WHERE `email`='$email'";
	$result = mysqli_query($conn,$query) or die(mysql_error());
	if(mysqli_num_rows($result)>0)
	{ 
		$user = mysqli_fetch_assoc($result);
		$from = $newobject->getInfo($conn,"admin","contact_id",1);
		$email = $user['email'];
		$id = $user['id'];
		$linkid = base64_encode($id);
		$link = "<a href='".$site_root."reset-password.php?linkid=".$linkid."'>Click Here</a>";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from. "\r\n";
		$message = "Please click on link to change your password : ".$link;
		
		$retrive = @mail($email,"Forgot Password" , $message, $headers);
		
		if($retrive)
		{
			$response = "A Link Has Been Sent to  '".stripslashes($email)."' Please Check Your Email";
		}
	}
	else
	{
		$error = "Sorry, This Email does not exist.";
	}
}

?>
<?php include('include/header.php'); ?>

<section class="bg_login">
  <div class="login-form">
    <form name="frmforgotsubmit" id="frmforgotsubmit" method="post">
      <h2 class="text-center">Forgot Your Password</h2>
      <?php if($error!="") { ?>
      <div class="alert alert-danger" style="text-align:center;">
        <?php  echo $error; ?>
      </div>
      <?php } ?>
      <?php if($response!="") { ?>
      <div class="alert alert-success" style="text-align:center;">
        <?php  echo $response; ?>
      </div>
      <?php } ?>
      <div class="form-group item">
        <input type="email" class="form-control" id="email" name="email"  placeholder="Enter Your email" required/>
      </div>
      <button type="submit" name="forgotsubmit" class="btn btn-block btn-blues high" id="myBtn">Submit</button>
    </form>
  </div>
</section>
<?php include('include/footer.php'); ?>
<script type="text/javascript">
$(document).ready(function() 
{
	$('#frmforgotsubmit').bootstrapValidator(
	{
		feedbackIcons: 
		{
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
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
			}
		}
	})
});
</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> <!-- or use local jquery -->

<script>
  $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
</script>





