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
	<?php include('includes/customer-left.php'); ?>
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
							$user_id = $result['user_id'];
							$name = $newobject->getdata($conn,"users","name","id",$user_id);
							$email = $newobject->getdata($conn,"users","email","id",$user_id);
							$phone = $newobject->getdata($conn,"users","phone_no","id",$user_id);
							$country = $newobject->getdata($conn,"users","country","id",$user_id);
							$city = $newobject->getdata($conn,"users","city","id",$user_id);
							$address = $newobject->getdata($conn,"users","address","id",$user_id);
							?>
							<tr>
								<th scope="col" width="50%" style="text-align:center;"><font size="4">Billing Information</font></th>
								<th scope="col" width="50%" style="text-align:center;"><font size="4">Shipping Information</font></th>
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
										<td>
											<table style="width:80%">
												<tr>	
													<td width="30%" align="center"><strong>Customer Name</strong></td>
													<td align="center"><?php echo $result['ship_name'];?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table style="width:80%">
												<tr>
													<td width="30%" align="center"><strong>Mobile</strong></td>
													<td align="center"><?php echo $phone;?></td>
												</tr>
											</table>
										</td>
										<td>
											<table style="width:80%">
												<tr>	
													<td width="30%" align="center"><strong>Mobile</strong></td>
													<td align="center"><?php echo $result['ship_phone'];?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table style="width:80%">
												<tr>
													<td width="30%" align="center"><strong>Country</strong></td>
													<td align="center"><?php echo $country; ?></td>
												</tr>
											</table>
										</td>
										<td>
											<table style="width:80%">
												<tr>	
													<td width="30%" align="center"><strong>Country</strong></td>
													<td align="center"><?php echo $result['ship_country'];?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table style="width:80%">
												<tr>
													<td width="30%" align="center"><strong>City</strong></td>
													<td align="center"><?php echo $city; ?></td>
												</tr>
											</table>
										</td>
										<td>
											<table style="width:80%">
												<tr>	
													<td width="30%" align="center"><strong>City</strong></td>
													<td align="center"><?php echo $result['ship_city'];?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table style="width:80%">
												<tr>
													<td width="30%" align="center"><strong>Address</strong></td>
													<td align="center"><?php echo $address; ?></td>
												</tr>
											</table>
										</td>
										<td>
											<table style="width:80%">
												<tr>	
													<td width="30%" align="center"><strong>Address</strong></td>
													<td align="center"><?php echo $result['ship_address'];?></td>
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
