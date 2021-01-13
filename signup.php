<?php 

include('config/function.php');

$response = "";

if((isset($_REQUEST['submitregister'])))
{
	/* echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";
	exit; */
	$fname = trim($_REQUEST['fname']);
	$lname = trim($_REQUEST['lname']);
	$email = trim($_REQUEST['email']);
	$gender = trim($_REQUEST['gender']);
	$phone_no = trim($_REQUEST['phone_no']);
	$password = md5($_REQUEST['password']);

	$query_select = "SELECT email FROM users WHERE email='".$email."'";
	if($sql_select = $conn->query($query_select))
	{
		if($sql_select->num_rows>0)
		{
			$response = "This Email already exist please try with different...";
		}
		else
		{
			$query="INSERT INTO users SET fname='".$fname."',lname='".$lname."',gender='".$gender."',email='".$email."',password='".$password."',phone_no='".$phone_no."'";
			if($sql_insert = $conn->prepare($query))
			{
				$sql_insert->execute();
				if($sql_insert->affected_rows>0)
				{
					$_SESSION['response_success'] = "You have successfully registered please log in !";
					echo "<script>document.location.href='".$site_root."login/';</script>";
					exit;
				}
				else
				{
					$response = "Please Try Again";
				}
			}
		}	
	}
}

include 'include/header.php';
?>
<!-- ===== HERO ====== -->
<section class="bg_login">
  <div class="login-form signup-form">
    <form name="registerfrm" id="registerfrm" method="post" novalidate="novalidate">
      <h2 class="text-center">signup to ramanta Store</h2>
      <p class="loginsubtitle">We never share your personal details.</p>
		<?php if($response!="") { ?>
		<div class="alert alert-danger" style="text-align:center;"><?php  echo $response; ?></div>
		<?php } ?>
		<div class="form-group">
			<input type="text" class="form-control" pattern="[A-Z a-z]{1,}" placeholder="First Name" id="fname" name="fname" required=""/>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" pattern="[A-Z a-z]{1,}" placeholder="Last Name" id="lname" name="lname" required=""/>
		</div>
		<div class="form-group">
			<select class="form-control" name="gender">
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			</select>
		</div>
		<div class="form-group">
			<input type="email" class="form-control" placeholder="Email Id" name="email" id="email" required="">
		</div>
		<div class="form-group">
			<input type="text" placeholder="Phone Number" class="form-control" id="phone_no" name="phone_no" required=""/>
		</div>
		<div class="form-group item">
			<input type="password" class="form-control" id="password" name="password" placeholder="Password" required=""/>
		</div>
      <div class="form-group">
        <button type="submit" name="submitregister" class="btn btn-blues btn-block high">Signup</button>
      </div>
      <p class="text-center logincreate"> Exsiting user? <a href="<?php $site_root; ?>login/">Login</a></p>
    </form>
  </div>
</section>
<script type="text/javascript">
$(document).ready(function() 
{
	$('#registerfrm').bootstrapValidator(
	{
		feedbackIcons: 
		{
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: 
		{
			fname: 
			{
				validators: 
				{
					notEmpty: 
					{
						message: 'Please Enter First Name'
					}
				}
			},
			lname: 
			{
				validators: 
				{
					notEmpty: 
					{
						message: 'Please Enter Last Name'
					}
				}
			},
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
			phone_no: 
			{
				validators: 
				{
					notEmpty: 
					{
						message: 'Please Enter Mobile Number'
					}
				}
			}
		}
	})
});
</script>
<?php include 'include/footer.php';?>