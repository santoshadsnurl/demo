<?php

include('session.php');

/* echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
//exit; */

$current_date = @date("Y-m-d",time());
$lastweek = @gmdate('Y-m-d', strtotime('-1 week'));
$lastmonth = @gmdate('Y-m-d', strtotime('-1 month'));
$lastyear = @gmdate('Y-m-d', strtotime('-1 year'));

/* set blank */
$gen_rep = "";
$id = "";
$total_page = "";
$TotalCnt = "";
$searchInput = "";
$order_status = "";
$strQuery = "";
$order_status = "";

if(isset($_REQUEST['paymentstatus']) && !empty($_REQUEST['changes_oid']))
{
	$chang_st = trim($_REQUEST['changes_oid']);
	$payment_status = trim($_REQUEST['paymentstatus']);
	$update_st = "UPDATE orders SET payment_status = '$payment_status' WHERE id = '$chang_st'";
	if($updatest = $conn->prepare($update_st))
	{
		$updatest->execute();
	}
}

if(isset($_REQUEST['chang_oid']) && !empty($_REQUEST['chang_oid']))
{
	$chang_st = trim($_REQUEST['chang_oid']);
	$status = trim($_REQUEST['status']);
	$update_st = "UPDATE orders SET status = '$status' WHERE id = '$chang_st'";
	if($updatest = $conn->prepare($update_st))
	{
		$updatest->execute();
		if($updatest->affected_rows>0)
		{
			$select_user_info = "SELECT * FROM `orders` WHERE id = '$chang_st'";
			if($sql_user_info = $conn->query($select_user_info))
			{
				if($sql_user_info->num_rows>0)
				{
					$result_user_info = $sql_user_info->fetch_array(MYSQLI_ASSOC);
					$order_id = $result_user_info['id'];	
					$order_date = $result_user_info['order_date'];
					$order_date = date("F m, Y", strtotime($order_date));
					$ship_name = $result_user_info['ship_name'];
					$ship_email = $result_user_info['ship_email'];
					$ship_address = $result_user_info['ship_address'];
					$token = $result_user_info['token'];
					$total_amount = $result_user_info['total_amount'];
					$Message ='<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							</head>
							<body>
							<div align="center">
							  <table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;;color:#444444;border-collapse:collapse">
								<tbody>
								  <tr>
									<td style="padding:0in 0in 0in 0in">
									<div style="border:none;border-bottom:solid #cccccc 3.5pt;padding:0in 0in 1.0pt 0in">
										<p class="MsoNormal">
											<a href="'.$site_root.'" target="_blank">
											<span>
											<img border="0" style="width:150px;height:100px;" src="'.$newobject->logo($conn,"logo","image").'" alt="" class="CToWUd">
											</span>
											</a>
											<em><span style="float:right;padding-top:50px;font-size:22.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333"><b>Shipping Confirmation!</b></span></em>
										</p>
									</div>
									</td>
								  </tr>
								  <tr>
									<td style="padding:0in 0in 0in 0in">
									<p style="margin-top:7.5pt"><strong><span style="font-size:16.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:black">Hello '.$ship_name.',</span></strong><span style="font-size:9.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:black;text-align:right;"><u></u><u></u></span></p>
									  <p><span style="font-size:14.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:black">Your order #'.$order_id.' has shipped.<u></u><u></u></span></p>
									  <p style="margin-top:7.5pt"><strong><span style="font-size:16.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:black">Details</span></strong><span style="font-size:9.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:black;text-align:right;"><u></u><u></u></span></p>
									  <div style="margin-bottom:3.75pt">
										<div>
										  <div style="border:none;border-top:solid #CCCFD5 3.5pt;padding:4.0pt 0in 0in 0in">
											<p style="margin-top:7.5pt"><strong><span style="font-size:16.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:black">Order #'.$order_id.'</span></strong></p>
										  </div>
										  <div style="border:none;border-top:solid #CCCFD5 3.5pt;padding:4.0pt 0in 0in 0in"></div>
										  <div>
											<div style="margin-bottom:3.75pt">
											  <div style="bgcolor="#F4F5F6";border:solid #F4F5F6 1.0pt;padding:8.0pt 8.0pt 8.0pt 8.0pt">
												<table border="0" bgcolor="#F4F5F6" cellspacing="1" cellpadding="0" width="100%" style="padding-left:30px;padding-bottom:20px;width:100.0%">
												  <tbody>
													<tr>
														<td width="44%" rowspan="3" valign="top" style="width:44.0%;border:none;border-right:dotted #cccccc 1.0pt;padding:.75pt .75pt .75pt .75pt"><div style="margin-right:7.5pt">
															  <div>
																<p class="MsoNormal"><em><span style="font-size:14.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333"><strong>Tracking Number:</strong></span></em></p>
															  </div>
															  <div>
																<p class="MsoNormal"><em><span style="font-size:14.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333">'.$token.'</span></em></p>
															  </div>
															   <div style="margin-top:30px;">
																<p class="MsoNormal"><em style="border:solid #323333 2.0pt;padding:15.0pt 35.0pt 10.0pt 35.0pt;background:#323333;"><span style="font-size:20.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333"><b><a style="text-decoration:none;color:#FFFFFF" href="'.$site_root.'track-order.php?track_no='.$token.'"  target="_blank">Track Order</a></b></span></em></p>
															   </div>
															    <div style="margin-top:30px;">
																<p class="MsoNormal"><em style="border:solid #323333 2.0pt;padding:15.0pt 40.0pt 10.0pt 40.0pt;background:#fff;"><span style="font-size:20.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333"><b><a style="text-decoration:none;color:#323333" href="'.$site_root.'order-detail.php?order_id='.$order_id.'"  target="_blank">View Order</a></b></span></em></p>
															   </div>
															</div>
														</td>
													</tr>
												</tbody>
												</table>
												<table border="0" cellspacing="1" cellpadding="0" width="100%" style="padding-left:0px;padding-bottom:20px;width:100.0%">
												  <tbody>
													<tr>
														<td width="44%" rowspan="3" valign="top" style="width:44.0%;border:none;border-right:dotted #cccccc 1.0pt;padding:.75pt .75pt .75pt .75pt"><div style="margin-right:7.5pt">
															  <div style="margin-top:10px;">
																<p class="MsoNormal"><em><span style="font-size:18.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333">We hope to see you again soon.</span></em></p>
															  </div>
															  </br>
															  <div style="margin-top:10px;">
																<p class="MsoNormal"><em><span style="font-size:14.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333"><strong><a style="text-decoration:none;color:#323333" href="'.$site_root.'" target="_blank">ADS N URL</a></strong></span></em></p>
															  </div>
															</div>
														</td>
													</tr>
												</tbody>
												</table>
												<div style="border:none;border-top:solid #CCCFD5 3.5pt;padding:4.0pt 0in 0in 0in"></div>
												<table border="0" cellspacing="1" cellpadding="0" width="100%" style="padding-left:0px;padding-bottom:20px;width:100.0%">
												  <tbody>
													<tr>
														<td width="44%" rowspan="3" valign="top" style="width:44.0%;border:none;border-right:dotted #cccccc 1.0pt;padding:.75pt .75pt .75pt .75pt"><div style="margin-right:7.5pt">
															  <div style="margin-top:10px;">
															  <p class="MsoNormal"><em><span style="font-size:14.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333">By placing your order, you agree to ADS N URL’s Privacy Notice and Terms & Conditions</span></em></p>
															  </div>
															  </br>
															  <div style="margin-top:10px;">
																<p class="MsoNormal"><em><span style="font-size:14.5pt;font-family:&quot;Trebuchet MS&quot;,&quot;sans-serif&quot;;color:#323333">This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message. If you would like to contact us you can do so by visiting our <a style="text-decoration:none;color:#189ED9" href="'.$site_root.'contact-us/" target="_blank">contact us</a> page. View Order Sign</span></em></p>
															  </div>
														</td>
													</tr>
												</tbody>
												</table>
											  </div>
											</div>
										  </div>
										</div>
									  </div></td>
								  </tr>
								</tbody>
							  </table>
							</div>
							</body>
							</html>';
							/* echo  $Message;
							exit;  */
				}
			}
			
			$from = $newobject->getInfo($conn,"admin","contact_id",1);

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: <'.$from.'>' . "\r\n";
			$headers .= 'Bcc: santosh@alltoit.com' . "\r\n";
			$to = $from.",".$ship_email;
			$subject = 'Alaat Order Mail';
			@mail($to, $subject, $Message, $headers);
		}
	}
}

if(isset($_REQUEST['d_date']) && !empty($_REQUEST['o_id']))
{
	$chang_st = trim($_REQUEST['o_id']);
	$d_date = trim($_REQUEST['d_date']);
	$update_st = "UPDATE orders SET d_date = '$d_date' WHERE id = '$chang_st'";
	if($updatest = $conn->prepare($update_st))
	{
		$updatest->execute();
	}
}


if(isset($_REQUEST['shipp_method']) && !empty($_REQUEST['change_oid']))
{
	$chang_st = trim($_REQUEST['change_oid']);
	$ship_method = trim($_REQUEST['shipp_method']);
	$update_st = "UPDATE orders SET ship_method = '$ship_method' WHERE id = '$chang_st'";
	if($updatest = $conn->prepare($update_st))
	{
		$updatest->execute();
	}
}

if(isset($_POST['delete_all']) && !empty($_POST['delete_all']))
{ 
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		foreach($_POST['check_status'] as $value)
		{	
			if($sql_deleteall=$conn->query("DELETE FROM orders WHERE id = '".$value."'"))
			{
				$_SESSION['response'] = "Deleted Successfully.";				
			}
	    }
		echo "<script>document.location.href='orders_mgmt.php';</script>";
	    exit();
	}
	else
	{
		$_SESSION['error'] = "Please Select First.";
		echo "<script>document.location.href='orders_mgmt.php';</script>";
	    exit();	
	}
}

if(isset($_REQUEST['searchQuery']) && !empty($_REQUEST['searchQuery']))
{
	$searchInput = trim($_REQUEST['searchQuery']);
	$strQuery = "WHERE id LIKE '$searchInput' OR order_date LIKE '$searchInput'";
}

$pageno = 1;
$pageshow = 10;
if(isset($_GET['pageno']) && ($_GET['pageno']>0)) { $pageno = $_GET['pageno']; }
if($sql_count=$conn->query("SELECT * FROM orders $strQuery ORDER BY id DESC"))
{
	if($TotalCnt=$sql_count->num_rows)
	{
 		$total_page=ceil($TotalCnt/$pageshow);	
	}
	else
	{
		$total_page=0;
	}
}
if(!isset($_GET['pageno']) or $_GET['pageno']==1)
{
	$st=0;
	$pageno=1;
}
else
{
	$st=($pageno*$pageshow)-$pageshow;
}
if($total_page>$pageno)
{
	$nx=$pageno+1;
	$next='<a class="active" href="javascript:ShowPage('.$nx.')">Next &raquo;</a>';
}
else
{
	$next="";
}
if($pageno>1)
{
	$pr=($pageno-1);
	$pre='<a class="active" href="javascript:ShowPage('.$pr.')">&laquo; Previous</a>';
}
else
{
	$pre="";
}	
$limitvar = "LIMIT $st,$pageshow";
$query = "SELECT * FROM orders $strQuery ORDER BY id DESC $limitvar";
$start_1 =($st+1);
$start =$st;
$end =($start+$pageshow);
$page="";
if($pageno <= 5)
{
	$startpage = 1;
}
else
{
	$startpage = $pageno-5;
}
if(($total_page - $pageno) <= 5)
{
	$endpage = $total_page;
}
else
{
	$endpage = $pageno+5;
}
for($i=$startpage;$i<=$endpage;$i++)
{
	$page.='<a class="active" href="javascript:ShowPage('.$i.')" > ' . $i .  ' </a>';
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
		<form name="pageinfo" method="get" action="<?php echo $_SERVER['REQUEST_URI'];?>">
			<input type="hidden" name="searchQuery" value="<?php if(isset($_GET['searchQuery'])) { echo $_GET['searchQuery']; } ?>" />
			<input type="hidden" name="pageno" value="<?php if(isset($_GET['pageno'])) { echo $_GET['pageno']; } else{ echo $pageno;} ?>" />
		</form>
		<div class="dashboard-bar">
		<h2 class="headn-h2">Sales</h2>
		</div>
		<div class="main-section">
			<?php if(isset($_SESSION['response'])) { ?> 
			<div class="alert alert-success fade in f">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<?php echo $_SESSION['response']; unset($_SESSION['response']); ?>
			</div>
			<?php } ?>
			<?php if(isset($_SESSION['error'])) { ?> 
			<div class="alert alert-danger fade in f">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
			</div>
			<?php } ?>
			<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					<h3 class="panel-title">Report</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-4">
								<form name="searchform" method="get" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<div class="input-group">
										<input style="border:1px solid #d3d3d3; height:38.5px;" type="text" name="searchQuery" class="form-control" placeholder="Search By Order Id / Date" value="<?php echo $searchInput;?>"  required/>
										<span class="input-group-btn">
										<button class="btn btn-default" type="submit" name="search" value="Search">Search</button>
										</span> 
									</div>
								</form>
								<!-- /input-group --> 
							</div>
							<form id="header" name="header" action="<?php $_SERVER['PHP_SELF'] ?>" method ="post">
							<div class="col-sm-4">
								<a href="report.php"><button class="btn btn-primary center-block" type="button">Export Report</button></a>
							</div>
							<div class="col-sm-4">
								<input type="submit" class="btn btn-default pull-right" name="delete_all" value="Delete" onClick="return confirm('Are you sure? You want to Delete');"/>
							</div>
						</div>
						<div class="clearfix"></div>
						<table class="table table-bordered" style="margin-top:15px;">
							<thead style="background:#d6d6d7;">
								<tr>
								<th>Order Id</th>
								<th>Date of Order</th>
								<th>Date of Delivery</th>
								<th>Payment Status</th>
								<th>Shipping Method</th>
								<th>Status</th>
								<th>Invoice</th>
								<th>Order Description</th>
								<th>Customer Description</th>
								<th><label><input type="checkbox" id="checkAllbox"/></label></th>
								</tr>
							</thead>
							<tbody>
							<?php 
							if($sql_select=$conn->query($query))
							{
								if($sql_select->num_rows>0)
								{
									$ctr=0;
									while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
									{
										$id = $result['id'];
										$ctr++;
										?>
										<tr>
											<td><?php echo $id; ?></td>
											<td><?php echo $result['order_date']; ?></td>
											<td><?php if($result['d_date']=="0000-00-00" || $result['d_date']=="") { ?> 
											<a data-toggle="modal" data-target="#myModal<?php echo $id; ?>"><strong>Add</strong></a>
											<?php } else { echo $result['d_date']; } ?></td>
											<td>
												<strong><?php echo $result['payment_status']; ?></strong>
												<br>
												<select name="payment_status" id="payment_status" class="form-control" onchange ="paymentstatus(this.value,'<?php echo $id; ?>');">
													<option value="">Update</option>
													<option value="Pending">Pending</option> 		
													<option value="Completed">Completed</option> 				
												</select>
											</td>
											<td>
												<strong><?php echo $result['ship_method']; ?></strong>
												<br>
												<select name="ship_method" id="ship_method" class="form-control" onchange ="shipmethod (this.value,'<?php echo $id; ?>');">
													<option value="">Update</option>
													<option value="Delhivery">Delhivery</option> 				
												</select>
											</td>
											<td>
												<strong><?php echo ucfirst($result['status']); ?></strong>
												<br>
												<select name="chang_status" id="chang_status" class="form-control" onchange ="chngstatus (this.value,'<?php echo $id; ?>');">
													<option value="">Change</option>
													<option value="confirmed">Confirmed</option> 		
													<option value="processing">Processing</option> 		
													<option value="shipping">Shipping</option> 		
													<option value="delivered">Delivered</option> 		
												</select>
											</td>
											<td><a href="order_report.php?order_id=<?php echo $id; ?>"><h4  style="text-align:center; margin-top:15%;">Generate</h4></a></td>
											<td><a href="product_detail.php?id=<?php echo $id; ?>"><h4  style="text-align:center; margin-top:15%;">View</h4></a></td>
											<td><a href="buyer_details.php?id=<?php echo $id; ?>"><h4  style="text-align:center; margin-top:15%;">View</h4></a></td>
											<th>
											<label><input type="checkbox" class="checkbox" value="<?php echo $result['id']; ?>" name="check_status[]"></label>
											</th>
										</tr>
										<?php 
									}
								}
								else
								{
									?>
									<td  colspan="8" align="center"><font color="red" size="2">Record Not Found</font></td>
									<?php
								}
							}
							?>
							</tbody>
						</table>
						</form>
						<div class="bs-example" data-example-id="disabled-active-pagination"> 
							<nav aria-label="...">
								<ul class="pagination text-center center-block" style="display:table;"> 
								<?php if($TotalCnt>0) { echo $pre;?>&nbsp;<?php echo $page;?>&nbsp;<?php echo $next; } ?>	
								</ul> 
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

<script>
$("#checkAllbox").change(function () {
    $(".checkbox").prop('checked', $(this).prop("checked"));
});
</script>
<form name="frmchang_oid" id="frmchang_oid" action="" method="post">
<input type="hidden" name="chang_oid" id="chang_oid" value="">
<input type="hidden" name="status" id="status" value="">
</form>
<form name="frmship" id="frmship" action="" method="post">
<input type="hidden" name="change_oid" id="change_oid" value="">
<input type="hidden" name="shipp_method" id="shipp_method" value="">
</form>
<form name="frmpaymentstatus" id="frmpaymentstatus" action="" method="post">
<input type="hidden" name="changes_oid" id="changes_oid" value="">
<input type="hidden" name="paymentstatus" id="paymentstatus" value="">
</form>
<script>
function paymentstatus(paymentstatus,id)
{
	//alert(status);
	//alert(id);
	var person = confirm("Are You Sure To Change Status !");
	if (person == true) 
	{
		document.getElementById('changes_oid').value = id;
		document.getElementById('paymentstatus').value = paymentstatus;
		document.frmpaymentstatus.submit();
	}
	else
	{
		location.reload();
	}
}
</script>
<script>
function chngstatus(status,id)
{
	//alert(status);
	//alert(id);
	var person = confirm("Are You Sure To Change Status !");
	if (person == true) 
	{
		document.getElementById('chang_oid').value = id;
		document.getElementById('status').value = status;
		document.frmchang_oid.submit();
	}
	else
	{
		location.reload();
	}
}
</script>
<script>
function shipmethod(ship_method,id)
{
	//alert(ship_method);
	var person = confirm("Are You Sure Want To Update!");
	if (person == true) 
	{
		document.getElementById('change_oid').value = id;
		document.getElementById('shipp_method').value = ship_method;
		document.frmship.submit();
	}
	else
	{
		location.reload();
	}
}
</script>
<?php
if($sql_select=$conn->query($query))
{
	if($sql_select->num_rows>0)
	{
		while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
		{
			$id = $result['id'];
			?>
			<!-- Modal -->
			<div id="myModal<?php echo $id; ?>" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Date</h4>
				  </div>
				  <form name="frmd" id="frmd" method="post">
				  <div class="modal-body">
					<input type="date" name="d_date" id="d_date" required/>
				  </div>
				  <input type="hidden" name="o_id" id="o_id" value="<?php echo $id; ?>">
				  <div class="modal-footer">
					<button type="submit" class="btn btn-default">Submit</button>
				  </div>
				  </form>
				</div>

			  </div>
			</div>
			<?php 
		}
	}
}
?>

</body>
</html>
