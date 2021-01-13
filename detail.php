<?php 
include('config/function.php');
if(isset($_REQUEST['alias']) && $_REQUEST['alias']!="")
{
	$alias = $_REQUEST['alias'];
	$product_id_pro = $newobject->getdata($conn,"products","id","alias",$alias);
	$product_unit_id = $newobject->getdata($conn,"products","unit_id","alias",$alias);
	$sku = $newobject->getdata($conn,"products","sku","alias",$alias);
	$product_title = $newobject->getdata($conn,"products","title","alias",$alias);
	$hot = $newobject->getdata($conn,"products","hot","alias",$alias);
	$product_description = $newobject->getdata($conn,"products","description","alias",$alias);
	$product_price = $newobject->getdata($conn,"products","price","alias",$alias);
	$product_sale_price = $newobject->getdata($conn,"products","sale_price","alias",$alias);
	$product_special_price = $newobject->getdata($conn,"products","special_price","alias",$alias);
	$category_id = $newobject->getdata($conn,"products","category_id","alias",$alias);
	$category_id_check = $newobject->getdata($conn,"products","category_id","alias",$alias);
	$product_image_fetured = $newobject->getdata($conn,"products","image","alias",$alias);
	$product_unit = $newobject->getdata($conn,"units","title","id",$product_unit_id);
	$category_title = $newobject->getdata($conn,"categories","title","id",$category_id);
	$category_alias = $newobject->getdata($conn,"categories","alias","id",$category_id);
	$product_related = $newobject->getconrecords($conn,"products","id!='$product_id_pro' AND category_id = '$category_id'");
	$query_select = "SELECT total_count FROM `most_viewed` WHERE `product_id`='".$product_id_pro."'";
	if($sql_select = $conn->query($query_select))
	{
		$count = 1;
		if($sql_select->num_rows>0)
		{
			$select_result = $sql_select->fetch_array(MYSQLI_ASSOC);
			$count = $select_result['total_count'] + 1;
			$update_query = "UPDATE `most_viewed` SET `total_count`='".$count."' WHERE `product_id`='".$product_id_pro."'";
			if($sql_update = $conn->prepare($update_query))
			{	
				$sql_update->execute();
			}
		}
		else
		{
			$sql_query = "INSERT INTO `most_viewed` SET `product_id`='".$product_id_pro."',`total_count`='".$count."'";
			if($sql_insert = $conn->prepare($sql_query))
			{	
				$sql_insert->execute();
			}
		}
	}
}
else
{
	echo "<script>document.location.href='".$site_root."'</script>";
	exit;
}
include 'include/header.php';
if(isset($_REQUEST['submit_enquery']))
{
	/* echo "<pre>";
	print_r($_REQUEST);
	exit; */
	$name = $_REQUEST['name'];
	$product_id = $_REQUEST['product_id_pro'];
	$phone_number = $_REQUEST['phone_number'];
	$enq_quantity = $_REQUEST['enq_quantity'];
	$message = $_REQUEST['message'];
	$query_insert = "INSERT INTO bulk_order SET name='".$name."',product_id='".$product_id."',enq_quantity='".$enq_quantity."',phone_number='".$phone_number."',message='".$message."'";
	if($sql_insert = $conn->prepare($query_insert))
	{
		$sql_insert->execute();
		$msg =  '<html>
					<head>
						<title>'.$subject.'</title>
					</head>
					<body>
					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
						<tbody>
							<tr>
								<td valign="top" style="padding:0in 0in 0in 0in">
								<div>
									<p align="center" style="margin-top:0in;text-align:center"><img src="'.$site_root.'assets/images/logo.png" alt="Ramanta" class="CToWUd"><u></u><u></u></p>
								</div>
								<div align="center">
								<table border="1" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#fdfdfd;border:solid gainsboro 1.0pt;border-radius:3px!important">
								<tbody>
							</tr>
							<td valign="top" style="border:none;padding:0in 0in 0in 0in">
							<div align="center">
							<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#E46E00;border-radius:3px 3px 0 0!important">
							<tbody>
							<tr>
							<td style="padding:10.0pt .5in 27.0pt .5in">
								<h1 style="margin:0in;margin-bottom:.0001pt;line-height:150%"><span style="font-size:22.5pt;line-height:150%;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:white;font-weight:normal">Contact Us<u></u><u></u></span></h1>
							</td>
							</tr>
						</tbody>
					</table>
						</div>
						</td>
						</tr>
						<tr>
						<td valign="top" style="border:none;padding:0in 0in 0in 0in">
						<div align="center">
						<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in">
						<tbody>
						<tr>
						<td valign="top" style="background:#fdfdfd;padding:0in 0in 0in 0in">
						<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
						<tbody>
						<tr>
						<td valign="top" style="padding:.2in .2in .1in .5in">Name :</td>
						<td valign="top" style="padding:.2in .2in .1in .5in">'.$name.'</td>
						</tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Contact No :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$phone_number.'</td>
						</tr>
						<tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Product Name :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$product_title.'</td>
						</tr>
						<tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Message :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$message.'</td>
						</tr>
							</tbody>
							</table>
							</td>
						</tr>
							</tbody>
							</table>
					</div>
					</td>
					</tr>
					<tr>
						<td valign="top" style="border:none;padding:0in 0in 0in 0in">
							<div align="center">
								<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in">
									<tbody>
										<tr>
											<td valign="top" style="padding:0in 0in 0in 0in">
												<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
													<tbody>
														<tr>
															<td style="padding:0in .5in .5in .5in">
																<p align="center" style="text-align:center;line-height:125%"><span style="font-size:9.0pt;line-height:125%;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#99b1c7"><a href='.$site_root.'>Ramanta</a><u></u><u></u></span></p>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
					</tbody>
					</table>
					</div>
					</td>
					</tr>
					</tbody>
				</table>
			</body>
		</html>';
		/* echo $msg;
		exit; */
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: <contact@ramanta.in/>'. "\r\n";
		//$to  = $ship_email; // note the comma
		$to  = 'contact@ramanta.in'; // note the comma
		$subject = 'New Order'; // subject
		$revert = @mail($to, $subject, $msg, $headers);
		if($revert)
		{
			$news_response = "Enquiry Submited Successfully We will contact you soon!";
			echo "<script>alert('$news_response');</script>";
		}
		else
		{
			echo  '<script>'.'alert("Sorry ! Due to technical issues we are unable to send email.")'.'</script>';
		}
	}
}
if(isset($_POST['submitcontact']))
{	
	$name = trim($_REQUEST['name']);
	$email = trim($_REQUEST['email']);
	$phone = trim($_REQUEST['phone']);
	$comment = trim($_REQUEST['comment']);
	$message =  '<html>
					<head>
						<title>'.$subject.'</title>
					</head>
					<body>
					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
						<tbody>
							<tr>
								<td valign="top" style="padding:0in 0in 0in 0in">
								<div>
									<p align="center" style="margin-top:0in;text-align:center"><img src="'.$site_root.'images/logo.png" alt="Ramanta" class="CToWUd"><u></u><u></u></p>
								</div>
								<div align="center">
								<table border="1" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#fdfdfd;border:solid gainsboro 1.0pt;border-radius:3px!important">
								<tbody>
							</tr>
							<td valign="top" style="border:none;padding:0in 0in 0in 0in">
							<div align="center">
							<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#E46E00;border-radius:3px 3px 0 0!important">
							<tbody>
							<tr>
							<td style="padding:10.0pt .5in 27.0pt .5in">
								<h1 style="margin:0in;margin-bottom:.0001pt;line-height:150%"><span style="font-size:22.5pt;line-height:150%;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:white;font-weight:normal">Contact Us<u></u><u></u></span></h1>
							</td>
							</tr>
						</tbody>
					</table>
						</div>
						</td>
						</tr>
						<tr>
						<td valign="top" style="border:none;padding:0in 0in 0in 0in">
						<div align="center">
						<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in">
						<tbody>
						<tr>
						<td valign="top" style="background:#fdfdfd;padding:0in 0in 0in 0in">
						<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
						<tbody>
						<tr>
						<td valign="top" style="padding:.2in .2in .1in .5in">Name :</td>
						<td valign="top" style="padding:.2in .2in .1in .5in">'.$name.'</td>
						</tr>
						<tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Email :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$email.'</td>
						</tr>
						<tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Contact No :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$phone.'</td>
						</tr>
						<tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Message :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$comment.'</td>
						</tr>
							</tbody>
							</table>
							</td>
						</tr>
							</tbody>
							</table>
					</div>
					</td>
					</tr>
					<tr>
						<td valign="top" style="border:none;padding:0in 0in 0in 0in">
							<div align="center">
								<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in">
									<tbody>
										<tr>
											<td valign="top" style="padding:0in 0in 0in 0in">
												<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
													<tbody>
														<tr>
															<td style="padding:0in .5in .5in .5in">
																<p align="center" style="text-align:center;line-height:125%"><span style="font-size:9.0pt;line-height:125%;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#99b1c7"><a href='.$site_root.'>Ramanta</a><u></u><u></u></span></p>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
					</tbody>
					</table>
					</div>
					</td>
					</tr>
					</tbody>
				</table>
			</body>
		</html>';
		/* echo $message;
		exit; */
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: < contact@ramanta.in >'. "\r\n";
		$to  = "contact@ramanta.in"; // note the comma
		$subject = 'Contact Us'; // subject
		$revert = @mail($to, $subject, $Message, $headers);
		if($revert)
		{
			$news_response = "Hi <strong>$name</strong> , Thank you for contacting us. Our team member will contact you as soon as possible!";
			echo "<script>alert('$news_response');</script>";
		}
		else
		{
			echo  '<script>'.'alert("Sorry ! Due to technical issues we are unable to send email.")'.'</script>';
		}
}
if(isset($_REQUEST['check_aviaibility']))
{
	/* echo "<pre>";
	print_r($_REQUEST);
	exit; */
	$pin_code = $_REQUEST['pin_code'];
	$query_insert = "SELECT pin_code FROM shipping_area WHERE pin_code = '".$pin_code."' AND status = 1";
	if($sql_insert = $conn->query($query_insert))
	{
		if($sql_insert->num_rows>0)
		{
			$news_response = "Shipping Aviailable!";
			echo "<script>alert('$news_response');</script>";
		}
		else
		{
			$news_response = "Shipping Not Aviailable!";
			echo "<script>alert('$news_response');</script>";
		}
	}
}
if(isset($_REQUEST['customize_query']))
{
	/* echo "<pre>";
	print_r($_FILES);
	print_r($_REQUEST);
	exit; */
	$product_id_pro = $_REQUEST['product_id_pro'];
	$message = $_REQUEST['message'];
	if(isset($_FILES['image']) && $_FILES['image']['error']==0)
	{
		$image = $_FILES['image']['name'];
		$time =time();
		$image = $time.$image;
		$logofilename = "uploads/customize/".$image;
		$mv = move_uploaded_file($_FILES['image']['tmp_name'], $logofilename);
		$query_insert="INSERT INTO customize_products SET image='".$image."',product_id='".$product_id_pro."',session_id='".$session_id."',status='1',message='".$message."'";
		if($sql_insert = $conn->query($query_insert))
		{
			$news_response = "Submited Successfully!";
			echo "<script>alert('$news_response');</script>";
		}
	}
}
?>
<div class="container">
  <div class="pd_page_ram">
    <div class="productpage">
      <div class="productleft">
	  	<div class="socialshare">Part Number: <span><?php echo $sku; ?> </span>
       
        </div>
		
        <div class="exzoom hidden" id="exzoom">
          <div class="exzoom_img_box">
            <ul class="exzoom_img_ul">
              <li class="thumbnail-active"> <a href="<?php echo $site_root; ?>uploads/products/<?php echo $product_image_fetured; ?>" class="image"  data-easyzoom-source="<?php echo $site_root; ?>uploads/products/<?php echo $product_image_fetured; ?>"> <img width="90" height="90" src="<?php echo $site_root; ?>uploads/products/<?php echo $product_image_fetured; ?>" class="attachment-shop_thumbnail" alt="62" /> </a> </li>
              <?php 
			$product_image = $newobject->getconrecords($conn,"product_images","product_id = '$product_id_pro'");
			if($product_image->num_rows>0)
			{
				while($product_image_result = $product_image->fetch_array(MYSQLI_ASSOC))
				{
					?>
              <li> <a href="<?php echo $site_root; ?>uploads/product_images/<?php echo $product_image_result['product_image']; ?>" class="image"  data-easyzoom-source="<?php echo $site_root; ?>uploads/product_images/<?php echo $product_image_result['product_image']; ?>"> <img width="90" height="90" src="<?php echo $site_root; ?>uploads/product_images/<?php echo $product_image_result['product_image']; ?>" alt="62" /> </a> </li>
              <?php
				}
			}
			?>
            </ul>
          </div>
          <div class="exzoom_nav scrollbar"></div>
        </div>
        <div class="buybtn">
        <?php 
		if($category_id_check == 8) 
		{ 
			?>
          <?php 
			$qyery_dup = "SELECT * FROM customize_products WHERE session_id='$session_id' && product_id ='$product_id_pro' && status='1'";
			if($sql_select = $conn->query($qyery_dup))
			{
				if($sql_select->num_rows>0)
				{
					?>
          <a href="javascript:void(0);" onClick="BuyNow('<?php echo $product_id_pro; ?>');" class="btn btn-blues">Buy Now</a> <a href="javascript:void(0);" onClick="AddCart('<?php echo $product_id_pro; ?>');" class="btn btn-default btn-blues">Add to cart </a> <a href="javascript:void(0);" class="btn btn-default btn-blues" data-toggle="modal" data-target="#myModalbuybulk">Buy in bulk</a>
          <?php
				}
				else
				{
				?>
          <a href="javascript:void(0);" class="btn btn-blues hover_effect1 btn_cutm"  data-toggle="modal" data-target="#myModalcustomize"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> customize</a>
          <?php
				}
			}
		}
		else
		{
			?>
          <a href="javascript:void(0);" onClick="BuyNow('<?php echo $product_id_pro; ?>');" class="btn btn-blues">Buy Now</a> <a href="javascript:void(0);" onClick="AddCart('<?php echo $product_id_pro; ?>');" class="btn btn-default btn-blues">Add to cart </a> <a href="javascript:void(0);" class="btn btn-default btn-blues" data-toggle="modal" data-target="#myModalbuybulk">Buy in bulk</a>
          <?php
		}
		?>
        </div>
      </div>
      <div class="productright">
        <div class="custom-bread" style="display:none">
          <ol class="breadcrumb">
            <li class="active"><p class="pro_name"><?php echo $product_title; ?></p></li>
          </ol>
        </div>
		        <h1><?php echo $product_title; ?></h1>
        <h1 style="display:none"><?php echo html_entity_decode($newobject->getdata($conn,"products","arabic_title","alias",$alias)); ?></h1>
		<div class="pri_sos">
        <div class="pricing">
		<?php if($hot!=0 && $hot=="") { ?>
		<div class="mrp_price price_equal">
		M.R.P: <i class="fa fa-inr" aria-hidden="true"></i>
		<span class="price_1 a-text-strike"> <?php echo $product_price; ?> </span>
		</div>
			<div class="normal_price price_equal">
		<small>Price:</small> <i class="fa fa-inr" aria-hidden="true"></i>
		<span class="price_1 a-text-strike"><?php echo $product_sale_price; ?></span> 
		</div>
		<div class="price_equal special_price"> 
		Special Price:
		<i class="fa fa-inr" aria-hidden="true"></i>
		<span class="price_1"> <?php echo $product_special_price; ?> </span> 
		</div>
		<div class="discount_price price_equal"> 
		  <small>You Save:	</small>		  
		  (<?php echo number_format((100 - ($product_special_price * (100/$product_price))),0); ?>% Off) </div>
		<?php } else { ?>
		<div class="mrp_price price_equal">
		M.R.P: <i class="fa fa-inr" aria-hidden="true"></i>
		<span class="price_1 a-text-strike"> <?php echo $product_price; ?> </span>
		</div>
			<div class="normal_price price_equal">
		<small>Price:</small> <i class="fa fa-inr" aria-hidden="true"></i>
		<span class="price_1 "><?php echo $product_sale_price; ?></span> 
		</div>
		<div class="discount_price price_equal"> 
		  <small>You Save:	</small>		  
		  (<?php echo number_format((100 - ($product_sale_price * (100/$product_price))),0); ?>% Off) </div>
		<?php } ?>
          <?php if($newobject->getdata($conn,"products","quantity","alias",$alias) !=0) { ?>
          <p class="a-color-success"> In stock</p>
          <?php } else { ?>
          <p class="a-color-danger"> Out of stock </p>
          <?php } ?>
        </div>
		
		
	
		
		
		
		<?php 
		$product_sizes = $newobject->getdata($conn,"products","product_size","alias",$alias);
		if($product_sizes!="")
		{
			$product_sizess = explode(",", $product_sizes);
			if(count($product_sizess) > 1)
			{
				?>
				<div class="ps_size active_roll">
				<h6> Size</h6>
				<ul>
				<?php
				$a=0;
				foreach($product_sizess as $value)
				{
					$a++;
					?>
					<li class="sizecls" id="vldsize<?php echo $a; ?>"><a href="javascript:void(0);" onClick="Addsize('<?php echo $value; ?>');"><?php echo $value; ?></a></li>
					<?php
				}
				?>
				</ul>
				</div>
				<?php
			}
			else
			{
				?>
				<div class="ps_size active_roll2">
				<h6> Size</h6>
				<ul>
				<li class="colcls" id="vldcol1"><a href="javascript:void(0);" onClick="Addsize('<?php echo $product_sizes; ?>');"><?php echo $product_sizes; ?></a></li>
				</ul>
				</div>
				<?php
			}
		}
		?>
		<?php 
		$product_colors = $newobject->getdata($conn,"products","product_color","alias",$alias);
		if($product_colors!="")
		{
			$product_colorss = explode(",", $product_colors);
			if(count($product_colorss) > 1)
			{
				?>
				<div class="ps_size active_roll3">
				<h6> Color</h6>
				<ul>
				<?php
				$a=0;
				foreach($product_colorss as $value)
				{
					$a++;
					?>
					<li class="matcls" id="vldmat<?php echo $a; ?>"><a href="javascript:void(0);" onClick="Addcol('<?php echo $value; ?>');"><?php echo $value; ?></a></li>
					<?php
				}
				?>
				</ul>
				</div>
				<?php
			}
			else
			{
				?>
				<div class="ps_size active_roll4">
				<h6> Color</h6>
				<ul>
				<li class="colcls" id="vldcol1"><a href="javascript:void(0);" onClick="Addcol('<?php echo $product_colors; ?>');"><?php echo $product_colors; ?></a></li>
				</ul>
				</div>
				<?php
			}
		}
		?>
		<?php 
		$product_materials = $newobject->getdata($conn,"products","product_material","alias",$alias);
		if($product_materials!="")
		{
			$product_materialss = explode(",", $product_materials);
			if(count($product_materialss) > 1)
			{
				?>
				<div class="ps_size active_roll5">
				<h6> Material</h6>
				<ul>
				<?php
				$a=0;
				foreach($product_materialss as $value)
				{
					$a++;
					?>
					<li class="colcls" id="vldcol<?php echo $a; ?>"><a href="javascript:void(0);" onClick="Addmat('<?php echo $value; ?>');"><?php echo $value; ?></a></li>
					<?php
				}
				?>
				</ul>
				</div>
				<?php
			}
			else
			{
				?>
				<div class="ps_size active_roll6">
				<h6> Material</h6>
				<ul>
				<li class="colcls" id="vldcol1"><a href="javascript:void(0);" onClick="Addmat('<?php echo $product_materials; ?>');"><?php echo $product_materials; ?></a></li>
				</ul>
				</div>
				<?php
			}
		}
		?>
		</div>
		<input type="hidden" name="product_size" id="product_size" value="">
		<input type="hidden" name="product_material" id="product_material" value="">
		<input type="hidden" name="product_color" id="product_color" value="">
		<div class="pincode-check-panel">
          <div class="pincode-deliveryContainer">
            <h4>Delivery Options <i class="fa fa-truck deliveryIcon"> </i></h4>
            <form autocomplete="off" method="post" action="">
              <input type="number" placeholder="Enter pincode" class="pincode-code" value="" name="pin_code" required>
              <input type="submit" name="check_aviaibility" class="pincode-check pincode-button" value="Check">
            </form>
            <p class="pincode-enterPincode"> Please enter PIN code to check delivery time &amp; Pay on Delivery availability</p>
          </div>
        </div>
        <span class="review"><a href="#">See reviews on this product</a></span>
        <div class="tracking"> <span>10 Days Replacement</span> <span> Free Delivery by Ramanta Store </span> </div>
        <div class="producttabs producttabs_des scrollbar"><?php echo html_entity_decode($newobject->getdata($conn,"products","description","alias",$alias)); ?></div>
      </div>
    </div>
    <div class="detailtabs">
      <ul class="tabs">
        <?php if($newobject->getdata($conn,"products","arabic_description","alias",$alias)!="") { ?>
        <li class="tab-link current " data-tab="tab-1">Overview</li>
        <?php } ?>
        <?php if($newobject->getdata($conn,"products","specification","alias",$alias)!="") { ?>
        <li class="tab-link" data-tab="tab-2">Specification</li>
        <?php } ?>
        <?php if($newobject->getdata($conn,"products","care_instructions","alias",$alias)!="") { ?>
        <li class="tab-link " data-tab="tab-3">Care Instructions</li>
        <?php } ?>
        <li class="tab-link" data-tab="tab-4">Customer Reviews</li>
        <?php if($newobject->getdata($conn,"products","questions","alias",$alias)!="") { ?>
        <li class="tab-link" data-tab="tab-5">Questions & Answers</li>
        <?php } ?>
        <li class="tab-link" data-tab="tab-6">Contact Us</li>
      </ul>
      <div id="tab-1" class="tab-content current "> <?php echo html_entity_decode($newobject->getdata($conn,"products","arabic_description","alias",$alias)); ?> </div>
      <!--tab-->
      <div id="tab-2" class="tab-content"> <?php echo html_entity_decode($newobject->getdata($conn,"products","specification","alias",$alias)); ?> </div>
      <!--tab-->
      <div id="tab-3" class="tab-content "> <?php echo html_entity_decode($newobject->getdata($conn,"products","care_instructions","alias",$alias)); ?> </div>
      <!--tab-->
      <div id="tab-4" class="tab-content">
        <section>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="rates">
                  <h3>Rating &amp; Reviews
                    <button class="btn btn-success">4.5 <i class="fa fa-star"></i></button>
                    <span>18,187 ratings and 2,026 reviews </span></h3>
                  <p>Images uploaded by customers:</p>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="post_btn"> </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="userss">
                  <h3><img src="<?php echo $site_root; ?>assets/images/profile.png"> Ananda rana <span>10 month ago</span>
                    <button class="btn btn-success">4.5 <i class="fa fa-star"></i></button>
                  </h3>
                  <p>A little early to really reviews. Had the watch for a week and it’s keeping time! Looks great but only time will tell how the 
                    finish holds up. So far so good. it’s my everyday watch so it will get a lot of wear! Not sorry i bought it .. o far!</p>
                  <div class="users_main"> <img src="<?php echo $site_root; ?>assets/images/cart/img01.png"> <img src="<?php echo $site_root; ?>assets/images/cart/img03.png"> </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="your_btns"> <img src="<?php echo $site_root; ?>assets/images/thumb1.png" class="spns_btns"> <span class="spn_btn">225</span> <img src="<?php echo $site_root; ?>assets/images/thumb2.png" class="spns_btns"> <span class="spn_btn1">100</span> </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="userss">
                  <h3><img src="<?php echo $site_root; ?>assets/images/profile.png"> Ananda rana <span>10 month ago</span>
                    <button class="btn btn-success">4.5 <i class="fa fa-star"></i></button>
                  </h3>
                  <p>A little early to really reviews. Had the watch for a week and it’s keeping time! Looks great but only time will tell how the 
                    finish holds up. So far so good. it’s my everyday watch so it will get a lot of wear! Not sorry i bought it .. o far!</p>
                  <div class="users_main"> <img src="<?php echo $site_root; ?>assets/images/cart/img01.png"> <img src="<?php echo $site_root; ?>assets/images/cart/img03.png"> </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="your_btns"> <img src="<?php echo $site_root; ?>assets/images/thumb1.png" class="spns_btns"> <span class="spn_btn">225</span> <img src="<?php echo $site_root; ?>assets/images/thumb2.png" class="spns_btns"> <span class="spn_btn1">100</span> </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!--tab-->
      <div id="tab-5" class="tab-content">
        <section>
          <div class="container-fluid"> <?php echo html_entity_decode($newobject->getdata($conn,"products","questions","alias",$alias)); ?> </div>
        </section>
        <div class="footer-post-ques"> <a href="#"> All Question </a> </div>
      </div>
      <!--tab-->
      <div id="tab-6" class="tab-content"> 
        <!-- contact form start here -->
        <div class="profilelist no-border">
          <div class="row">
            <form class="register-form" role="form" name="contactfrm" id="contactfrm" method="post">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="info-title" for="exampleInputName">Your Name <span>*</span></label>
                  <input type="text" class="form-control unicase-form-control text-input" placeholder="<?php echo changelanguage($conn,"Only Alphabets Allowed","فقط الحروف الهجائية المسموح بها"); ?>" id="name" name="name">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
                  <input type="email" class="form-control unicase-form-control text-input" id="email" name="email" placeholder="<?php echo changelanguage($conn,"Valid Email","صحيح البريد الإلكتروني"); ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="info-title" for="exampleInputTitle">Mobile Number <span>*</span></label>
                  <input type="txet" class="form-control unicase-form-control text-input" placeholder="<?php echo changelanguage($conn,"Only Number Allowed","عدد الوحيد الذي سمح"); ?>" id="phone" name="phone">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="info-title" for="exampleInputComments">Your Comments <span>*</span></label>
                  <textarea class="form-control unicase-form-control" name="comment" placeholder="<?php echo changelanguage($conn,"Enter Message","اكتب رسالتك"); ?>"></textarea>
                </div>
              </div>
              <div class="col-md-12 outer-bottom-small m-t-20">
                <button type="submit" name="submitcontact" class="btn btn-blues">Send Message</button>
              </div>
            </form>
          </div>
        </div>
        <!-- contact form start here --> 
      </div>
      <!--tab--> 
    </div>
    <!-- ======= Recently Viewd ======= -->
    <?php 
if($product_related->num_rows>0)
{
	?>
    <section class="section featured-product eletronic-product wow fadeInUp rowarea">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 headtitle">
            <h3 class="section-title"> Similiar Products <span>check the similiar deal </span></h3>
            <a href="<?php echo $site_root; ?>categories/<?php echo $category_alias; ?>" class="btn-lg btn btn-uppercase btn-warning shop-now-button pull-right btn-blues">View all</a> </div>
        </div>
        <div class="row">
          <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
            <?php
		while($result_product = $product_related->fetch_array(MYSQLI_ASSOC))
		{
			?>
            <div class="item item-carousel">
              <div class="products">
                <div class="product">
                  <div class="product-image"> <a href="<?php echo $site_root; ?>detail/<?php echo $result_product['alias']; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $result_product['image']; ?>" alt="essentials product"></a> 
                    <!-- /.image --> 
                  </div>
                  <!-- /.product-image -->
                  <div class="product-info text-center">
                    <h3 class="name"><a href="<?php echo $site_root; ?>detail/<?php echo $result_product['alias']; ?>/"><?php echo $result_product['title']; ?></a></h3>
                    <!-- /.product-price --> 
                  </div>
                  <!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                          <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i class="fa fa-shopping-cart"></i> </button>
                          <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                        </li>
                        <li class="lnk wishlist"> <a class="add-to-cart" href="#" title="Wishlist"> <i class="icon fa fa-heart"></i> </a> </li>
                      </ul>
                    </div>
                    <!-- /.action --> 
                  </div>
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
              </div>
              <!-- /.products --> 
            </div>
            <!-- /.item -->
            <?php
		}
		?>
          </div>
          <!-- /.home-owl-carousel --> 
        </div>
      </div>
    </section>
    <?php 
}
?>
    <?php 
if($most_viewed_products->num_rows>0)
{
	?>
    <!-- ======= Recently Viewd ======= -->
    <section class="section featured-product eletronic-product wow fadeInUp rowarea">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 headtitle">
            <h3 class="section-title"> MOST VIEWD <span>CHECK MOST VIEWED ITEMS</span></h3>
          </div>
          <div class="row">
            <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
              <?php
		while($result_most_viewed_products = $most_viewed_products->fetch_array(MYSQLI_ASSOC))
		{
			?>
              <div class="item item-carousel">
                <div class="products">
                  <div class="product">
                    <div class="product-image"> <a href="<?php echo $site_root; ?>detail/<?php echo $result_most_viewed_products['alias']; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $result_most_viewed_products['image']; ?>" alt="essentials product"></a> 
                      <!-- /.image --> 
                    </div>
                    <!-- /.product-image -->
                    <div class="product-info text-center">
                      <h3 class="name"><a href="<?php echo $site_root; ?>detail/<?php echo $result_most_viewed_products['alias']; ?>/"><?php echo $result_most_viewed_products['title']; ?></a></h3>
                      <!-- /.product-price --> 
                    </div>
                    <!-- /.product-info -->
                    <div class="cart clearfix animate-effect">
                      <div class="action">
                        <ul class="list-unstyled">
                          <li class="add-cart-button btn-group">
                            <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i class="fa fa-shopping-cart"></i> </button>
                            <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                          </li>
                          <li class="lnk wishlist"> <a class="add-to-cart" href="#" title="Wishlist"> <i class="icon fa fa-heart"></i> </a> </li>
                        </ul>
                      </div>
                      <!-- /.action --> 
                    </div>
                    <!-- /.cart --> 
                  </div>
                  <!-- /.product --> 
                </div>
                <!-- /.products --> 
              </div>
              <?php
		}
		?>
            </div>
            <!-- /.home-owl-carousel --> 
          </div>
        </div>
      </div>
    </section>
    <?php
}
?>
  </div>
</div>
<div class="totop"> <a href="#">Back to top</a> </div>
<!-- customize popup-->
<div class="modal fade" id="myModalcustomize" role="dialog">
  <div class="modal-dialog">
    <form name="customizefrm" method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="product_id_pro" value="<?php echo $product_id_pro; ?>">
      <div class="modal-content custoproduct">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Customize your product </h4>
        </div>
        <div class="modal-body">
          <h5 class="modal-title">Upload Image </h5>
          <div class="row">
            <div class="col-sm-4 imgUp">
              <div class="imagePreview"></div>
              <label class="btn btn-primary"> Upload
                <input type="file" class="uploadFile img" required name="image" style="width: 0px;height: 0px;overflow: hidden;">
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <h5 class="modal-title">Your Text </h5>
              <textarea class="form-control" name="message" required> </textarea>
              <div class="btn_submitpd">
                <button type="button" class="btn btn-border btn-default"  data-dismiss="modal">cancel</button>
                <button type="submit" name="customize_query" class="btn btn-default btn-blues">Submit </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- post a question popup  --> 
<!-- bulk Order  popup-->
<div class="modal fade" id="myModalbuybulk" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content bulkbuy">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Bulk Order Details </h4>
      </div>
      <div class="modal-body"> 
        <!-- contact form start here -->
        <div class="bulkordercontact no-border">
          <div class="row">
            <form name="enqueryfrm" method="post" action="">
              <input type="hidden" name="product_id_pro" value="<?php echo $product_id_pro; ?>">
              <div class="post_form">
                <div class="form-group">
                  <input type="text" name="name" class="form-control"   placeholder="Enter Your Name" required>
                </div>
                <div class="form-group">
                  <input type="text" name="phone_number" class="form-control" placeholder="Enter Your Phone Number" required>
                </div>
                <div class="form-group">
                  <input type="number" name="enq_quantity" class="form-control" placeholder="Enter Product Quantity" required>
                </div>
                <div class="form-group">
                  <textarea type="text" name="message" class="form-control"  placeholder="Enter Your Enquiry" required></textarea>
                </div>
                <div class="sunmit">
                  <button type="submit" name="submit_enquery"  class="btn btn-blues">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- contact form start here --> 
      </div>
    </div>
  </div>
</div>
<!-- post a question popup  -->
<div class="modal fade" id="myModalpostques" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Post Your Question</h4>
      </div>
      <div class="modal-body">
        <div class="form-group heree">
          <textarea type="text" class="form-control" id="" placeholder="Write Your Text Here"></textarea>
        </div>
        <p>Your question may be answered by sellers, manufacturers, or who are all part of the Ramanta community.</p>
      </div>
      <div class="modal-footer cansubs">
        <button type="button" class="btn cancels">Cancel</button>
        <button type="button" class="btn btn-blues">Submit</button>
      </div>
    </div>
  </div>
</div>
<?php include 'include/footer.php';?>
<script type="text/javascript">
$(document).ready(function() {
    $('#contactfrm').bootstrapValidator({
		//live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required and cannot be empty'
                    }
                }
            },
            email: {
                validators: {
					notEmpty: {
						message: 'The email required and cannot be empty'
					},
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
			phone: {
                validators: {
                    notEmpty: {
						message: 'The Phone required and cannot be empty'
					},
                    digits: {
						message: 'The Phone must be digits '
					}
                }
            },
			comment: 
			{
				validators: 
				{
					stringLength: 
					{
						min: 10,
						max: 200,
						message:'Please enter at least 10 characters and no more than 200'
					},
					notEmpty: 
					{
						message: 'The message is required and cannot be empty'
					}
				}
			}
        }
    });
});
</script>
<link href="<?php echo $site_root; ?>assets/css/jquery.exzoom.css" rel="stylesheet" />
<link href="<?php echo $site_root; ?>assets/css/jquerysctipttop.css" rel="stylesheet" >
<script src="<?php echo $site_root; ?>assets/js/jquery.exzoom.js"></script> 
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script> 
<script>
    $('.container').imagesLoaded( function() {
  $("#exzoom").exzoom({
        autoPlay: false,
    });
  $("#exzoom").removeClass('hidden')
});
</script> 
<!--  Tabs active--> 
<script>
    $('.producttabs .tabs li').click(function(){
  var tab_id = $(this).attr('data-tab');
  $('.producttabs .tabs li').removeClass('current');
  $('.producttabs .tab-content').removeClass('current');
  $(this).addClass('current');
  $("#"+tab_id).addClass('current');
})
$('.detailtabs .tabs li').click(function(){
  var tab_id = $(this).attr('data-tab');
  $('.detailtabs .tabs li').removeClass('current');
  $('.detailtabs .tab-content').removeClass('current');
  $(this).addClass('current');
  $("#"+tab_id).addClass('current');
})
       </script> 
<!-- upload images {Customize your product}--> 
<script>
	   $(".imgAdd").click(function(){
  $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-4 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
});
$(document).on("click", "i.del" , function() {
	$(this).parent().remove();
});
$(function() {
    $(document).on("change",".uploadFile", function()
    {
    		var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
    });
});
	   </script> 
<script>
var thumbSlider = {
  isAnimated: false,
  init: function () {
    var self = this;
    (this.stageHeight = parseInt($("#thumb-slider-wrapper").height())),
      (this.slides = $(".thumb-slider-slides")),
      (this.slidesHeight = parseInt(this.slides.height()));
    this.execute();
  },
  move: function (el) {
    var newPos,
      currentPos = parseInt(this.slides.css("top")),
      self = this;
    if ($(el).hasClass("thumb-slider-control-up")) {
      if (currentPos !== 0) {
        newPos = currentPos + this.stageHeight;
      }
    } else {
      if (currentPos + this.slidesHeight > this.stageHeight) {
        newPos = currentPos - this.stageHeight;
      }
    }
    this.slides.css("top", newPos + "px");
  },
  execute: function () {
    var self = this;
    $(".thumb-slider-control").on("click", function () {
      if (self.isAnimated === true) return false;
      self.isAnimated = true;
      self.move(this);
      self.slides.one("webkitTransitionEnd transitionend", function (e) {
        self.isAnimated = false;
        console.log("transition beendet");
      });
    });
  }
};
window.onload = function () {
  thumbSlider.init();
};
</script> 






<script>



// Active class detail page
$(document).ready(function(){
  $('.active_roll ul li a').click(function(){
    $('.active_roll ul li a').removeClass("active01");
    $(this).addClass("active01");
});
});




// Active class detail page
$(document).ready(function(){
  $('.active_roll2 ul li a').click(function(){
    $('.active_roll2 ul li a').removeClass("active01");
    $(this).addClass("active01");
	
});
});


// Active class detail page
$(document).ready(function(){
  $('.active_roll3 ul li a').click(function(){
    $('.active_roll3 ul li a').removeClass("active01");
    $(this).addClass("active01");
	
});
});


// Active class detail page
$(document).ready(function(){
  $('.active_roll4 ul li a').click(function(){
    $('.active_roll4 ul li a').removeClass("active01");
    $(this).addClass("active01");
	
});
});


// Active class detail page
$(document).ready(function(){
  $('.active_roll5 ul li a').click(function(){
    $('.active_roll5 ul li a').removeClass("active01");
    $(this).addClass("active01");
	
});
});


// Active class detail page
$(document).ready(function(){
  $('.active_roll6 ul li a').click(function(){
    $('.active_roll6 ul li a').removeClass("active01");
    $(this).addClass("active01");
	
});
});

</script>



