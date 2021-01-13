<?php 
include('config/function.php');
$query = "SELECT * FROM `cart` WHERE session_id='$session_id'";
if($sql_query = $conn->query($query))
{
	if($sql_query->num_rows>0)
	{
		$tax_total = 0; 
		while($result_per = $sql_query->fetch_array(MYSQLI_ASSOC))
		{
			$product_id = $result_per['product_id'];
			$tax_percentage = $newobject->getInfo($conn,"products","tax",$product_id);
			$hot = $newobject->getInfo($conn,"products","hot",$product_id);
			if($hot!=0 && $hot!="") {
				$price = $newobject->getInfo($conn,"products","special_price",$product_id);
			}
			else
			{
				$price = $newobject->getInfo($conn,"products","sale_price",$product_id);
			}
			$tax_amount = $price*$tax_percentage/100;
			$tax_total = $tax_total+$tax_amount;
		}
		return $tax_total;
	}
}
?>