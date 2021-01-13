<?php
include('session.php');
/* set blank */
$id = "";
if(isset($_REQUEST['id']) && !empty($_REQUEST['id']))
{
	$order_id = trim($_REQUEST['id']);
}
else
{
	echo "<script>document.location.href='orders_mgmt.php';</script>";
	exit();	
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
			<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					<h3 class="panel-title">Product Details</h3>
					</div>
					<div class="panel-body">
						<div class="clearfix"></div>
						<table class="table table-bordered" style="margin-top:15px;">
							<thead style="background:#d6d6d7;">
								<tr>
								<th class="width-tb3">Product Name</th>
								<th class="width-tb3">Product Image</th>
								<th class="width-tb3">Product Price</th>
								<th class="width-tb">Order Items</th>
								<th class="width-tb">Sub Total</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$query = "SELECT * FROM `cart` WHERE order_id='$order_id'";
							if($sql_select=$conn->query($query))
							{
								if($sql_select->num_rows>0)
								{
									$ctr=0;
									$gross_total = 0;
									while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
									{
										$id = $result['id'];
										$product_id = $result['product_id'];
										$gross_total = ($gross_total+$result['total_price']);
										$product_title = $newobject->getdata($conn,"products","title","id",$product_id);
										$product_image = $newobject->getdata($conn,"products","image","id",$product_id);
										$price = $newobject->getdata($conn,"products","sale_price","id",$product_id);
										$ctr++;
										?>
										<tr>
										<td><?php echo $product_title; ?></td>
										<td><img src="../uploads/products/<?php echo $product_image; ?>" height="80" width="120"></td>
										<td>INR <?php echo $price; ?></td>
										<td><?php echo $result['product_quantity']; ?></td>
										<td>INR <?php echo $result['total_price']; ?></td>
										</tr>
										<?php 
										}
									}
									else
									{
										?>
										<td  colspan="6" align="center"><font color="red" size="2">Record Not Found</font></td>
										<?php
									}
								}
								?>
							</tbody>
							<?php 
							$query1 = "SELECT * FROM `customize_products` WHERE order_id='$order_id'";
							if($sql_select1=$conn->query($query1))
							{
								if($sql_select1->num_rows>0)
								{
									?>
									<thead style="background:#d6d6d7;">
										<tr>
										<th>Customize Message</th>
										<th>Customize Product Images</th>
										</tr>
									</thead>
									<tbody>
									<?php
									while($result1=$sql_select1->fetch_array(MYSQLI_ASSOC))
									{
										$message = $result1['message'];
										$image = $result1['image'];
										?>
										<tr>
										<td><?php echo $message; ?></td>
										<td><img src="../uploads/customize/<?php echo $image; ?>" height="80" width="120"></td>
										</tr>
										<?php 
									}
									?>
									</tbody>
									<?php
								}
							}
							?>
							<table>
								<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td style="text-align:center;"><strong>Total Order Price:</strong> INR <?php echo $gross_total; ?></td>
								<tr>
							</table>
						</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end here -->
</body>
</html>