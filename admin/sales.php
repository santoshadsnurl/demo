<?php

include('session.php');

$total_sold_item = 0;
$total_order = 0;
$total_revenue = 0;

$query_order = "SELECT * FROM `orders` WHERE payment_status = 'Completed'";
if($sql_order = $conn->query($query_order))
{
	$total_order = $sql_order->num_rows;
	if($total_order>0)
	{
		while($result_order = $sql_order->fetch_array(MYSQLI_ASSOC))
		{
			$order_id = $result_order['id'];
			$total_revenue = ($total_revenue+$result_order['total_amount']);
			$query_cart = "SELECT * FROM `cart` WHERE order_id = '$order_id'";
			if($sql_cart = $conn->query($query_cart))
			{
				if($sql_cart->num_rows>0)
				{
					while($result_cart = $sql_cart->fetch_array(MYSQLI_ASSOC))
					{
						$total_sold_item = ($total_sold_item+$result_cart['product_quantity']);
					}
				}
			}
		}
	}
}

?>

<!DOCTYPE HTML>
<html>

<head>
<?php include('includes/head.php'); ?>
</head>

<body>

<!-- header section start here -->
<?php include('includes/header.php'); ?>
<!-- end here --> 

<!-- Two section start here -->
<div class="container-fluid">
	<div class="left-section">
	<?php include('includes/sales-left.php'); ?>		
	</div>
		<div class="right-section">
		<div class="dashboard-bar">
			<h2 class="headn-h2">Sales</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
				<div class="col-sm-12 col-lg-2 col-md-2 col-xs-2">&nbsp;</div>
				<div class="col-sm-12 col-lg-8 col-md-4 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						<h3 class="panel-title">Sales Overview</h3>
						</div>
						<div class="panel-body">
							<div class="row">
							<div class="col-sm-4">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Total Items Sold:</h5>
							<a class="counts"  href="<?php echo $site_root; ?>admin/orders_mgmt.php"><?php echo $total_sold_item; ?></a>
							</div>
							<div class="col-sm-4">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Total Orders:</h5>
							<a class="counts"  href="<?php echo $site_root; ?>admin/orders_mgmt.php"><?php echo $total_order; ?> </a>
							</div>
							<div class="col-sm-4">
							<h5 class="headn-h5 text-center" style="margin-bottom:7px;">Total Revenue:</h5>
							<a class="counts"  href="<?php echo $site_root; ?>admin/orders_mgmt.php">INR <?php echo $total_revenue; ?> </a>
							</div>
							</div>   
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-lg-2 col-md-2 col-xs-12">&nbsp;</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

</body>
</html>
