<?php

include('session.php');

/* set blank */

$id = "";
$name = "";
$email = "";
$phone = "";
$country = "";
$city = "";
$address = "";

if(isset($_REQUEST['id']) && !empty($_REQUEST['id']))
{
	$id = trim($_REQUEST['id']);
}
else
{
	echo "<script>document.location.href='orders_mgmt.php';</script>";
	exit();	
}

$query_select="SELECT * FROM `orders` WHERE id='$id'";

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
		<h2 class="headn-h2">Customers</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					<h3 class="panel-title">Buyer Details</h3>
					</div>
					<div class="panel-body">
					<div class="clearfix"></div>
					<table class="table">
					<?php 
					if($sql_select=$conn->query($query_select))	  
					{
						if($sql_select->num_rows>0)
						{
							$result=$sql_select->fetch_array(MYSQLI_ASSOC);
							$shipping_id = $result['shipping_id'];
							$name = $newobject->getdata($conn,"shipping_address","fname","id",$shipping_id);
							$phone_no = $newobject->getdata($conn,"shipping_address","phone_no","id",$shipping_id);
							$house_no = $newobject->getdata($conn,"shipping_address","house_no","id",$shipping_id);
							$street_no = $newobject->getdata($conn,"shipping_address","street_no","id",$shipping_id);
							$land_mark = $newobject->getdata($conn,"shipping_address","land_mark","id",$shipping_id);
							$pin_code = $newobject->getdata($conn,"shipping_address","pin_code","id",$shipping_id);
							?>
							<tr>
								<th scope="col" width="100%" style="text-align:center;"><font size="4">Shipping Information</font></th>
							</tr>
							<tr style="font-size:12px;">
								<tr>
								<td>
									<table style="width:80%">
										<tr>
											<td width="30%" align="center"><strong>Customer Name</strong></td>
											<td align="center"><?php echo $name;?></td>
										</tr>
									</table>
									</td>
								</tr>
								<tr>
									<td>
										<table style="width:80%">
											<tr>
												<td width="30%" align="center"><strong>Mobile</strong></td>
												<td align="center"><?php echo $phone_no;?></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<table style="width:80%">
											<tr>	
												<td width="30%" align="center"><strong>Street Number</strong></td>
												<td align="center"><?php echo $street_no;?></td>
											</tr>
										</table>
									</td>
								</tr>
									<tr>
										<td>
											<table style="width:80%">
												<tr>
													<td width="30%" align="center"><strong>House Number</strong></td>
													<td align="center"><?php echo $house_no; ?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table style="width:80%">
												<tr>
													<td width="30%" align="center"><strong>Land Mark</strong></td>
													<td align="center"><?php echo $land_mark; ?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table style="width:80%">
												<tr>
													<td width="30%" align="center"><strong>Pin Code</strong></td>
													<td align="center"><?php echo $pin_code; ?></td>
												</tr>
											</table>
										</td>
									</tr>
								</tr>
								</tbody>
								<?php 
							}
						}  
						?>
						</table> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

</body>
</html>
