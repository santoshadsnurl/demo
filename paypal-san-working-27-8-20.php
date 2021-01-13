<?php

error_reporting(0);

/* ini_set('display_errors', 'on');
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

include('config/function.php');

require('mail.php');

/* echo "<pre>";
print_r($_SESSION);
print_r($_REQUEST);
exit; */ 

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

if(isset($_REQUEST['payment_method']) && $_REQUEST['payment_method']!="" && $_REQUEST['shipping_id']!="")
{
	$shipping_id = $_REQUEST['shipping_id'];
	$payment_method = $_REQUEST['payment_method'];
	$sub_total = $newobject->subTotal($conn,$session_id);
	$gross_total = $newobject->getGrossTotal($conn,$session_id);
	$random_str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$shuffle_str = str_shuffle($random_str);
	$scode = substr($shuffle_str,0,10);
	$current_date = @date("Y-m-d",time());
	$_SESSION['token'] = $scode;
	
	$sql_query = "INSERT INTO `orders` SET `user_id`='".$user_id."',`shipping_id`='".$shipping_id."',`sub_total`='".$sub_total."',`total_amount`='".$gross_total."',`token`='".$scode."',`order_date`='".$current_date."'";
	if($sql_insert = $conn->prepare($sql_query))
	{	
		$sql_insert->execute();
		$order_id = mysqli_insert_id($conn);
		$_SESSION['order_id'] = $order_id;
	}
	
	$sql_query = "UPDATE cart SET order_id='".$order_id."',`user_id`='".$user_id."' WHERE session_id = '$session_id' AND status=1";
	if($sql_update = $conn->prepare($sql_query))
	{
		$sql_update->execute();
	}
	
	$sql_query_customize_products = "UPDATE customize_products SET order_id='".$order_id."',`user_id`='".$user_id."' WHERE session_id = '$session_id' AND status=1";
	if($sql_update_customize_products = $conn->prepare($sql_query_customize_products))
	{
		$sql_update_customize_products->execute();
	}
	
	$query_user = "SELECT * FROM users WHERE id='".$_SESSION['user_id']."' AND email='".$_SESSION['user_name']."'";
	if($sql_user = $conn->query($query_user))
	{
		if($sql_user->num_rows>0)
		{
			$result_user = $sql_user->fetch_array(MYSQLI_ASSOC);
			$name = $result_user['fname'].' '.$result_user['lname'];
			$email = $result_user['email'];
			$phone = $result_user['phone_no'];
		}
	}
}
else
{
	echo "<script>document.location.href='".$site_root."cart/'</script>";
	exit;
}

if($payment_method=="cod") 
{
	$select_user_info = "SELECT * FROM `orders` WHERE token = '$scode'";
	if($sql_user_info = $conn->query($select_user_info))
	{
		if($sql_user_info->num_rows>0)
		{
			$update_payment_status = "UPDATE `orders` SET `payment_status` ='Pending' WHERE token = '$scode'";
			if($sql_update_payment_status = $conn->prepare($update_payment_status))
			{
				$sql_update_payment_status->execute();
			}
			
			$result_user_info = $sql_user_info->fetch_array(MYSQLI_ASSOC);
			$user_id = $result_user_info['user_id'];
			$shipping_id = $result_user_info['shipping_id'];
			$order_date = $result_user_info['order_date'];
			$order_date = date("F d, Y", strtotime($order_date));
			$total_amount = $result_user_info['total_amount'];
			$token = $result_user_info['token'];			
			$product_id = $newobject->getdata($conn,"cart","product_id","order_id",$order_id);
			$product_name = $newobject->getdata($conn,"products","title","id",$product_id);
			$product_alias = $newobject->getdata($conn,"products","alias","id",$product_id);
			$ship_name = ucwords($newobject->getdata($conn,"shipping_address","fname","id",$shipping_id).' '.$newobject->getdata($conn,"shipping_address","lname","id",$shipping_id));
			$ship_address = ucwords($newobject->getdata($conn,"shipping_address","house_no","id",$shipping_id).' '.$newobject->getdata($conn,"shipping_address","street_no","id",$shipping_id).' '.$newobject->getdata($conn,"shipping_address","city","id",$shipping_id).' '.$newobject->getdata($conn,"shipping_address","pin_code","id",$shipping_id));
		
			$Message ='<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					</head>
					<body>
					<table class="m_7556203267401331m_4361174224093281478MsoNormalTable" style="width:405.0pt" id="m_7556203267401331m_4361174224093281478container" cellspacing="0" cellpadding="0" border="0" width="540" align="center">
					  <tbody>
						<tr>
						  <td style="padding:0cm 0cm 0cm 0cm" id="m_7556203267401331m_4361174224093281478header"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" style="width:375.0pt;margin-left:15.0pt" id="m_7556203267401331m_4361174224093281478content" cellspacing="0" cellpadding="0" border="0" width="500">
							  <tbody>
								<tr>
								  <td style="border:none;border-bottom:solid #eaeaea 1.0pt;padding:7.5pt 0cm 7.5pt 0cm" id="m_7556203267401331m_4361174224093281478logo"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" cellspacing="0" cellpadding="0" border="0">
									  <tbody>
										<tr>
										  <td style="width:187.5pt;padding:0cm 0cm 0cm 0cm" width="250"><p class="MsoNormal"><a href="'.$site_root.'" title="Visit Dearpet" target="_blank"><span style="color:#006699;text-decoration:none"><img id="m_7556203267401331m_4361174224093281478amazonLogo"src="'.$newobject->logo($conn,"logo","image").'" alt="Dearpet" height="100px" width="100px" class="CToWUd" border="0"></span></a><u></u><u></u></p></td>
										  <td style="width:187.5pt;padding:0cm 0cm 0cm 0cm" id="m_7556203267401331m_4361174224093281478title" width="250" valign="top"><p style="text-align:right" align="right"><span style="font-size:15.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Shipping Confirmation<u></u><u></u></span></p></td>
										</tr>
									  </tbody>
									</table></td>
								</tr>
								<tr>
								  <td style="padding:6.75pt 0cm 13.5pt 0cm" id="m_7556203267401331m_4361174224093281478greetingSummary"><p><span style="font-size:13.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#cc6600">Hello '.$name.',</span><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><br>
									  <br>
									  <a href="'.$site_root.'detail/'.$product_alias.'/" target="_blank"><span style="color:#006699;text-decoration:none">"'.$product_name.'"</span></a> has shipped. <u></u><u></u></span></p></td>
								</tr>
								<tr>
								  <td style="padding:0cm 0cm 0cm 0cm"><div style="border:none;border-bottom:solid #eaeaea 1.0pt;padding:0cm 0cm 0cm 0cm">
									  <p style="border:none;padding:0cm"><span style="font-size:13.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#cc6600">Details <u></u><u></u></span></p>
									</div>
									<p><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#666666">Order <a href="#" target="_blank"><span style="color:#006699;text-decoration:none">#'.$order_id.'</span></a> <u></u><u></u></span></p></td>
								</tr>
								<tr>
								  <td style="border:none;border-top:solid #cbcfd4 2.25pt;background:#f6f7f8;padding:0cm 0cm 0cm 0cm" id="m_7556203267401331m_4361174224093281478criticalInfo"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" cellspacing="0" cellpadding="0" border="0">
									  <tbody>
										<tr>
										  <td style="width:167.25pt;padding:8.25pt 13.5pt 10.5pt 6.75pt" id="m_7556203267401331m_4361174224093281478criticalInfo_right" width="223" valign="top"><p><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#666666">Shipped to:</span><b><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><br>
											  '.$ship_name.'<br>
											  '.$ship_address.'<u></u><u></u></span></b></p>
											<table class="m_7556203267401331m_4361174224093281478MsoNormalTable" style="width:100.0%" id="m_7556203267401331m_4361174224093281478costBreakdown" cellspacing="0" cellpadding="0" border="0" width="100%">
											  <tbody>
												<tr>
												  <td style="width:70.0%;padding:0cm 0cm 0cm 0cm" width="100%" valign="top"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" id="m_7556203267401331m_4361174224093281478costBreakdownLeft" cellpadding="0" border="0">
													  <tbody>
														<tr>
														  <td style="width:70.0%;padding:.75pt .75pt .75pt .75pt" width="100%" valign="top"><p class="MsoNormal"><b><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Shipping Charge: </span></b></p>
														  </td>
														</tr>
													  </tbody>
													</table></td>
												  <td style="width:100.0%;padding:0cm 0cm 0cm 0cm" width="100%" valign="top"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" id="m_7556203267401331m_4361174224093281478costBreakdownRight" cellpadding="0" border="0">
													  <tbody>
														<tr>
														  <td style="width:100.0%;padding:.75pt .75pt .75pt .75pt" width="100%" valign="top"><p class="MsoNormal"><b><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">0.00 INR <u></u><u></u></span></b></p></td>
														</tr>
													  </tbody>
													</table></td>
												</tr>
											  </tbody>
											</table>
											<table class="m_7556203267401331m_4361174224093281478MsoNormalTable" style="width:100.0%" id="m_7556203267401331m_4361174224093281478costBreakdown" cellspacing="0" cellpadding="0" border="0" width="100%">
											  <tbody>
												<tr>
												  <td style="width:70.0%;padding:0cm 0cm 0cm 0cm" width="100%" valign="top"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" id="m_7556203267401331m_4361174224093281478costBreakdownLeft" cellpadding="0" border="0">
													  <tbody>
														<tr>
														  <td style="width:70.0%;padding:.75pt .75pt .75pt .75pt" width="100%" valign="top"><p class="MsoNormal"><b><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Payable Total: </span></b></p>
														  </td>
														</tr>
													  </tbody>
													</table></td>
												  <td style="width:100.0%;padding:0cm 0cm 0cm 0cm" width="100%" valign="top"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" id="m_7556203267401331m_4361174224093281478costBreakdownRight" cellpadding="0" border="0">
													  <tbody>
														<tr>
														  <td style="width:100.0%;padding:.75pt .75pt .75pt .75pt" width="100%" valign="top"><p class="MsoNormal"><b><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">'.$total_amount.' INR <u></u><u></u></span></b></p></td>
														</tr>
													  </tbody>
													</table></td>
												</tr>
											  </tbody>
											</table>
											<p class="MsoNormal"><span style="display:none"><u></u>&nbsp;<u></u></span></p>
											</td>
										</tr>
									  </tbody>
									</table></td>
								</tr>
								<tr>
								  <td style="padding:6.75pt 0cm 6.75pt 0cm" id="m_7556203267401331m_4361174224093281478criticalInfo_bottom"></td>
								</tr>
								<tr>
								  <td style="border:none;border-bottom:solid #eaeaea 1.0pt;padding:.75pt 0cm 6.75pt 0cm" id="m_7556203267401331m_4361174224093281478closing"><p><span style="font-size:10.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">We hope to see you again soon.<br>
									  <br>
									  <b>Dearpet</b><u></u><u></u></span></p></td>
								</tr>
								<tr>
								  <td style="border:none;border-bottom:solid #eaeaea 1.0pt;padding:0cm 0cm 0cm 0cm" id="m_7556203267401331m_4361174224093281478marketingContent"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" style="width:375.0pt;background:white;vertical-align:central" align="left" cellspacing="0" cellpadding="0" border="0" width="500">
									  <tbody>
										<tr>
										  <td style="padding:0cm 0cm 0cm 0cm;vertical-align:central"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" style="width:375.0pt;background:white" cellspacing="0" cellpadding="0" border="0" width="500">
											  <tbody>
												<tr>
												  <td style="padding:4.5pt 0cm 0cm 0cm"><p class="MsoNormal"><span style="font-size:13.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#cc6600">Items from Your List <u></u><u></u></span></p></td>
												</tr>
											  </tbody>
											</table></td>
										</tr>
										<tr>
										  <td style="padding:0cm 0cm 0cm 0cm"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" style="width:375.0pt;background:white;vertical-align:central" align="left" cellspacing="0" cellpadding="0" border="0" width="500">
											  <tbody>
												<tr>';
												$select_cart = "SELECT * FROM `cart` WHERE order_id='".$order_id."'";	
												if($sql_select_cart = $conn->query($select_cart))
												{
													if($sql_select_cart->num_rows>0)
													{
														$a = 0;
														while($result = $sql_select_cart->fetch_array(MYSQLI_ASSOC))
														{
															$a++;
															$product_id_cart = $result['product_id'];
															$product_quantity = $result['product_quantity'];
															$product_image = $site_root.'uploads/products/'.$newobject->getdata($conn,"products","image","id",$product_id_cart);
															$product_name = $newobject->getdata($conn,"products","title","id",$product_id_cart);
															$product_alias = $newobject->getdata($conn,"products","alias","id",$product_id_cart);
															$product_price = $newobject->getdata($conn,"products","sale_price","id",$product_id_cart);
															 $Message.='<td style="width:48.0%;padding:0cm 0cm 0cm 0cm" width="48%">
															  <table class="m_7556203267401331m_4361174224093281478MsoNormalTable" cellpadding="0" border="0">
																  <tbody>
																	<tr>
																	  <td style="padding:9.0pt 3.75pt 7.5pt 3.75pt"><p class="MsoNormal" style="text-align:center" align="center"><a href="'.$site_root.'detail/'.$product_alias.'/" target="_blank"><span style="color:#006699;text-decoration:none"><img id="m_7556203267401331m_4361174224093281478_x0000_i1030" src="'.$product_image.'" alt="'.$product_name.'" class="CToWUd" border="0" width="80" height="80"></span></a><u></u><u></u></p></td>
																	  <td style="padding:9.0pt 3.75pt 7.5pt 3.75pt"><table class="m_7556203267401331m_4361174224093281478MsoNormalTable" cellpadding="0" border="0">
																		  <tbody>
																			<tr>
																			  <td style="padding:.75pt .75pt .75pt .75pt"><p class="MsoNormal"><a href="'.$site_root.'detail/'.$product_alias.'/" target="_blank"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#006699;text-decoration:none">'.$product_name.'</span></a> <u></u><u></u></p></td>
																			</tr>';
																			$Message.='<tr>
																			  <td style="padding:.75pt .75pt .75pt .75pt"><p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#888888; line-height: 20px;">Price: '.$product_price.' INR</span><br><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#888888; line-height: 20px;">Quantity: '.$product_quantity.' INR</span></p>
																			  </td>
																			</tr>
																		  </tbody>
																		</table></td>
																	</tr>
																  </tbody>
																</table>
																</td>';
																if($a%2==0) { echo "</tr><tr>"; } 
														}
													}
												}	
												$Message.='</tr>
												<tr>
												  <td colspan="2" style="padding:6.75pt 0cm 0cm 0cm" id="m_7556203267401331m_4361174224093281478footer">
												  <p style="line-height:12.0pt"><span style="font-size:9.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#666666">By placing your order, you agree to Dearpet Privacy Notice and Terms & Conditions</span></a>.<u></u><u></u></span></p>
												  <p style="line-height:12.0pt"><span style="font-size:9.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#666666">This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message. If you would like to contact us you can do so by visiting our <a style="text-decoration:none;color:#189ED9" href="'.$site_root.'contact-us/" target="_blank">contact us</a> page. View Order Sign <u></u><u></u></span></p>
												  </td>
												</tr>
											  </tbody>
											</table></td>
										</tr>
									  </tbody>
									</table>
									</body>
									</html>';
									/* echo  $Message;
									exit;  */
									$sel_cartup = "UPDATE `cart` SET status ='0' WHERE order_id='".$order_id."'";
									if($sql_update = $conn->prepare($sel_cartup))
									{
										$sql_update->execute();
									}

									$sel_discount_applied = "INSERT INTO `discount_applied` SET order_id='".$order_id."',user_id='".$user_id."',applied='1'";
									if($sql_discount_applied = $conn->prepare($sel_discount_applied))
									{
										$sql_discount_applied->execute();
									}
									
									//$to  = $email;
									$to  = "santosh.adsnurl@gmail.com";
									$subject = 'New Order';
									
									$url = 'https://track.delhivery.com/api/cmu/create.json';
									//$url = 'https://staging-express.delhivery.com/api/cmu/create.json';

									$ship_rocket_data = 'format=json&data={
									"pickup_location": {
									"pin": "110033",
									"add": "1179, 4th Floor, Block-B, Mangal Bazar Rd, Jahangirpuri, Delhi, 110033",
									"phone": "9205104267",
									"state": "Delhi",
									"city": "Delhi",
									"country": "India",
									"name": "RAMANTA SURFACE"
									},
									"shipments": [{
									"return_name": "RAMANTA SURFACE",
									"return_pin": "110033",
									"return_city": "Delhi",
									"return_phone": "9205104267",
									"return_add": "1179, 4th Floor, Block-B, Mangal Bazar Rd, Jahangirpuri, Delhi, 110033",
									"return_state": "Delhi",
									"return_country": "India",
									"order": "456779990.'.$order_id.'",
									"phone":"'.$phone.'",
									"products_desc": "'.$product_name.'",
									"cod_amount": "'.$gross_total.'",
									"name": "'.$name.'",
									"country": "India",
									"seller_inv_date": "2018-05-18 06:22:43",
									"order_date": "2018-05-18 06:22:43",
									"total_amount": "'.$gross_total.'",
									"seller_add": "1179, 4th Floor, Block-B, Mangal Bazar Rd, Jahangirpuri, Delhi",
									"seller_cst": "1",
									"add": "'.$ship_address.'",
									"seller_name": "RAMANTA SURFACE",
									"seller_inv": "1",
									"seller_tin": "1",
									"pin": "110059",
									"quantity":"10",
									"payment_mode": "COD",
									"state": "Delhi",
									"city": "New Delhi",
									"client": "RAMANTA SURFACE"
									}]
									}';
									//exit;
									$ch = curl_init( $url );
									//echo "<pre>"; print_r($ship_rocket_data); 
									curl_setopt( $ch, CURLOPT_POSTFIELDS, $ship_rocket_data);

									curl_setopt($ch, CURLOPT_HTTPHEADER, array(
									'Authorization: Token 597729f1b457404ce66b934a526eb71221f5d987',
									'Content-Type: application/json',
									));
									curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
									$result = curl_exec($ch);
									$order_track = json_decode($result);
									//echo "<pre>"; print_r($order_track); exit;
									
									$mail->addAddress($to, $name);
									$mail->addCC('santosh.sharma@adsandurl.com', 'Ramanta');
									$mail->isHTML(true); 
									$mail->Subject = 'New Order';
									$mail->Body    = $Message;
									if(!$mail->send()) 
									{
										/* $sn = 'Mailer error: ' . $mail->ErrorInfo;
										echo  '<script>'.'alert("'.$sn.'")'.'</script>';
										echo "<script>document.location.href='".$site_root."';</script>";
										exit; */
										echo "<script>document.location.href='".$site_root."success-msg/';</script>";
										exit;
									}
									else
									{
										echo "<script>document.location.href='".$site_root."success-msg/';</script>";
										exit;
									}
		}
	}
}

if($payment_method=="payu")
{ 
	$MERCHANT_KEY = "FIqAFacE";
	$SALT = "3ioh3uid7W";
	$PAYU_BASE_URL = "https://secure.payu.in";
	$action = "";
	$formError = 0;
	$hash = "";
	$txnid = $scode;
	$productinfo = "New Order";
	$posted = array('key'=>$MERCHANT_KEY,'txnid'=>$txnid,'amount'=>$gross_total,'productinfo'=>$productinfo,'firstname'=>$name,'email'=>$email);
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
	<input type="hidden" name="amount" value="<?php echo $gross_total; ?>">
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
	<?php
}
?>