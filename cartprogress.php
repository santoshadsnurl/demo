<?php

include('config/function.php');  

/* echo $site_root;
echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
exit; */

if(isset($_REQUEST['product_id']) && $_REQUEST['proceed']=="delete")
{
	$product_id = $_REQUEST['product_id'];
	$query_delete = "DELETE FROM cart WHERE product_id='$product_id' AND session_id='$session_id'";
	if($sql_delete=$conn->query($query_delete))
	{
		echo "<script>document.location.href='".$site_root."cart/';</script>";			
	}
}

if(isset($_REQUEST['product_id']) && $_REQUEST['product_quantity']!="" && $_REQUEST['proceed']=="update")
{
	$product_quantity = $_REQUEST['product_quantity'];
	$product_id = $_REQUEST['product_id'];
	$product_price = $newobject->getInfo($conn,"products","sale_price",$product_id);
	$total_price = $product_price*$product_quantity;
	$query_up = "UPDATE cart SET product_quantity='".$product_quantity."',total_price='".$total_price."' WHERE product_id = '$product_id' AND session_id='$session_id'";
	if($sql_up = $conn->prepare($query_up))
	{
		$sql_up->execute();	
		echo number_format($newobject->subTotal($conn,$session_id),2).'~'." Quantity Updated Successfully !";
		exit;
	}
}

if(isset($_REQUEST['product_id']) && $_REQUEST['product_quantity']!="" && $_REQUEST['proceed']=="add")
{
	/* echo "<pre>";
	print_r($_REQUEST);
	exit; */
	$product_id = $_REQUEST['product_id'];
	$product_quantity = $_REQUEST['product_quantity'];
	$product_size = $_REQUEST['product_size'];
	$product_color = $_REQUEST['product_color'];
	$product_material = $_REQUEST['product_material'];
	$hot = $newobject->getInfo($conn,"products","hot",$product_id);
	if($hot == 1)
	{
		$product_price = $newobject->getInfo($conn,"products","special_price",$product_id);
	}
	else
	{
		$product_price = $newobject->getInfo($conn,"products","sale_price",$product_id);
	}
	$available_quantity = $newobject->getInfo($conn,"products","quantity",$product_id);
	if($available_quantity>0)
	{
		$qyery_dup = "SELECT * FROM cart WHERE session_id='$session_id' && product_id ='$product_id' && status='1'";
		if($sql_select = $conn->query($qyery_dup))
		{
			if($sql_select->num_rows>0)
			{
				$result_dup = $sql_select->fetch_array(MYSQLI_ASSOC);
				$cart_quantity = $result_dup['product_quantity'];
				$new_quantity = $cart_quantity+$product_quantity;
				$total_price = $product_price*$new_quantity;
				$query_update = "UPDATE cart SET product_quantity='".$new_quantity."',total_price='".$total_price."',product_price='".$product_price."' WHERE session_id='$session_id' && product_id ='$product_id'";
				if($sql_update = $conn->prepare($query_update))
				{
					$sql_update->execute();			
				}
			}
			else
			{
				$total_price = $product_price*$product_quantity;
				$query_insert = "INSERT INTO cart SET product_id='".$product_id."',session_id='".$session_id."',product_quantity='".$product_quantity."',product_size='".$product_size."',product_color='".$product_color."',product_material='".$product_material."',product_price='".$product_price."',total_price='".$total_price."',status=1";
				if($sql_insert = $conn->prepare($query_insert))
				{
					$sql_insert->execute();
				}
			}
			$carthtml = '';
			$total_item = $newobject->gettotalitem($conn,$session_id);
			$total_subtotal = $newobject->subTotal($conn,$session_id);
			//echo $total_item.'~'." Added to Cart !".'~'.$total_subtotal.'~'.$site_root;
			$cart_session = $newobject->getconrecords($conn,"cart", "session_id = '$session_id'");
			$carthtml .='<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
						<div class="items-cart-inner">
						  <div class="basket"><img src="'.$site_root.'assets/images/icon/cart.png" alt=""></div>
						  <div class="basket-item-count"><span class="count">'.$newobject->gettotalitem($conn,$session_id).'</span> </div>
						  <div class="total-price-basket"> <span class="total-price"> <span class="sign"> &#x20b9; </span><span class="value" >'.number_format($newobject->subTotal($conn,$session_id),2).'</span> </span> </div>
						</div>
						</a>
						<ul class="dropdown-menu">
						  <li>
							<div class="cart-item product-summary">';
							while($result_cart = $cart_session->fetch_array(MYSQLI_ASSOC))
							{
								$product_id_cart = $result_cart['product_id'];
								$cart_quantity = $result_cart['product_quantity'];
								$title = $newobject->getInfo($conn,"products",$arabic."title",$product_id_cart);
								$price = $newobject->getInfo($conn,"products","sale_price",$product_id_cart);
								$image = $newobject->getInfo($conn,"products","image",$product_id_cart);
								$alias = $newobject->getInfo($conn,"products","alias",$product_id_cart);
							  $carthtml .='<div class="row">
								<div class="col-xs-4">
							<div class="image"><a href=""'.$site_root.'"detail/"'.$alias.'"/"><img src="'.$site_root.'uploads/products/'.$image.'" alt=""></a></div>
								</div>
								<div class="col-xs-7">
								  <h3 class="name"><a href=""'.$site_root.'"detail/"'.$alias.'"/"><img src=""'.$site_root.'"uploads/products/"'.$image.'"" alt="">'.$title.'</a></h3>
								  <div class="price">'.$cart_quantity.' x &#x20b9;'.$price.'</div>
								</div>
								<div class="col-xs-1 action"> <a href="javascript:void(0);" onClick="DeleteProduct('.$product_id_cart.');"><i class="fa fa-trash"></i></a> </div>
							  </div>';
							}
							$carthtml .='</div>
							<div class="clearfix"></div>
							<hr>
							<div class="clearfix cart-total">
							  <div class="pull-right"> <span class="text">Sub Total :</span><span class="price" id="totalvalues"> &#x20b9; '.number_format($newobject->subTotal($conn,$session_id),2).'</span> </div>
							  <div class="clearfix"></div>
							  <a href="'.$site_root.'cart/" class="btn btn-upper btn-primary btn-block m-t-20">Proceed</a> </div>
							
						  </li>
						</ul>';
						echo $carthtml;
		}
	}
	else
	{
		echo " Out Of Stock !";
	}
}

?>