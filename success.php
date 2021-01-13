<?php

include('config/function.php');

/* echo "<pre>";
print_r($_REQUEST);
print_r($_SESSION);
echo "</pre>";
exit; */

$Msg = "";
$order_id = "";
$name = "";

if(isset($_REQUEST['txnid']) && !empty($_REQUEST['txnid']))
{
	$token = $_REQUEST['txnid'];
	$select_order = "SELECT * FROM `orders` WHERE token ='$token'";
	if($sql_select_order = $conn->query($select_order))
	{
		if($sql_select_order->num_rows > 0)
		{
			$result_order =  $sql_select_order->fetch_array(MYSQLI_ASSOC);
			$order_id = $result_order['id'];
			$user_id = $result_order['user_id'];
			$query = "SELECT * FROM users WHERE id='".$user_id."'";
			if($sql_query = $conn->query($query))
			{
				if($sql_query->num_rows>0)
				{
					$result = $sql_query->fetch_array(MYSQLI_ASSOC);
					$name = $result['fname'];
				}
			}
		}
		else
		{
			$Msg = "Your Token has Mismatched!";
		}
	}
}
else
{
	$Msg = "Your Session Has Expired!";
}

include('include/header.php'); 

?>

<section class="cstmr-lgn">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="success-d">
					<div class="succes-content">
					<h1>Hi <?php echo ucfirst($name); ?> ! Your Order has been received</h1>
					<p>Thank you for placing your order!</p>
					<p class="fnt-sz">Your order number is <?php echo $order_id; ?>
					You will receive a confirmation email with 
					details of your order <br>
					and a link to track its progress.
					</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- product section strat here -->
<?php include('include/footer.php'); ?>
<!-- footer start here -->
