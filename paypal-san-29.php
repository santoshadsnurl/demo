<?php

include('config/function.php');

$totalitem = $newobject->gettotalitem($conn,$session_id);

if($totalitem<=0)
{
	echo "<script>document.location.href='".$site_root."cart/';</script>";
	exit;
}

if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
{
	$user_id = $_SESSION['user_id'];
}
else
{
	echo "<script>document.location.href='".$site_root."cart/';</script>";
	exit;
}

if(isset($_REQUEST['shipping_id']) && $_REQUEST['shipping_id']!="")
{
	$shipping_id = $_REQUEST['shipping_id'];
	$sub_total = $newobject->subTotal($conn,$session_id);
	$random_str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$shuffle_str = str_shuffle($random_str);
	$scode = substr($shuffle_str,0,10);
	$current_date = @date("Y-m-d",time());
	$_SESSION['token'] = $scode;
	
	$sql_query = "INSERT INTO `orders` SET `user_id`='".$user_id."',`shipping_id`='".$shipping_id."',`sub_total`='".$sub_total."',`total_amount`='".$sub_total."',`token`='".$scode."'";
	if($sql_insert = $conn->prepare($sql_query))
	{	
		$sql_insert->execute();
		$order_id = mysqli_insert_id($conn);
		$_SESSION['order_id'] = $order_id;
	}
	
	$sql_query = "UPDATE cart SET order_id='".$order_id."' WHERE session_id = '$session_id' AND status=1";
	if($sql_update = $conn->prepare($sql_query))
	{
		$sql_update->execute();
	}
	
	$query_user = "SELECT * FROM users WHERE id='".$_SESSION['user_id']."' AND email='".$_SESSION['user_name']."'";
	if($sql_user = $conn->query($query_user))
	{
		if($sql_user->num_rows>0)
		{
			$result_user = $sql_user->fetch_array(MYSQLI_ASSOC);
			$name = $result_user['fname'];
			$email = $result_user['email'];
			$phone = $result_user['phone_no'];
		}
	}
	
	$MERCHANT_KEY = "FIqAFacE";
	$SALT = "3ioh3uid7W";
	$PAYU_BASE_URL = "https://secure.payu.in";
	$action = "";
	$formError = 0;
	$hash = "";
	$txnid = $scode;
	$productinfo = "New Order";
	$posted = array('key'=>$MERCHANT_KEY,'txnid'=>$txnid,'amount'=>$sub_total,'productinfo'=>$productinfo,'firstname'=>$name,'email'=>$email);
	$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
	$hashVarsSeq = explode('|', $hashSequence);
	$hash_string = '';	
	foreach($hashVarsSeq as $hash_var) 
	{
		$hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
		$hash_string .= '|';
	}
	$hash_string .= $SALT;
	$hash = strtolower(hash('sha512', $hash_string));
	$action = $PAYU_BASE_URL . '/_payment';
}
else
{
	echo "<script>document.location.href='".$site_root."cart/'</script>";
	exit;
}

?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<style>
form{opacity:0;}
</style>
<script>
var hash = "<?php echo $hash ?>";
function submitPayuForm() 
{
	if(hash == '') 
	{
		return;
	}
	else
	{
		var payuForm = document.forms.payuForm;
		payuForm.submit();
	}
}

$("document").ready(function() 
{
	setTimeout(function() 
	{
	$("#btn").trigger('click');
submitPayuForm();
	});
});

</script>
</head>
<body>
<img src="<?php echo $site_root; ?>assets/images/load.gif" style="display:block;margin:0 auto;">
<form action="<?php echo $action; ?>" method="post" name="payuForm">
<input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>">
<input type="hidden" name="txnid" value="<?php echo $txnid ?>">
<input type="hidden" name="hash" value="<?php echo $hash ?>">
<input type="hidden" name="amount" value="<?php echo $sub_total; ?>">
<input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>">
<input type="hidden" name="firstname" value="<?php echo $name; ?>">
<input type="hidden" name="email" value="<?php echo $email; ?>">
<input type="hidden" name="phone" value="<?php echo $phone; ?>">
<input type="hidden" name="surl" value="<?php echo $site_root; ?>success/">
<input type="hidden" name="furl" value="<?php echo $site_root; ?>failure/">
<input type="hidden" name="service_provider" value="payu_paisa">
<?php if(!$hash) { ?>
<input type="submit1" value="Submit" id="btn1">
<?php } ?>
</form>
</body>
</html>