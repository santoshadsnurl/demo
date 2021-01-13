<?php

include('config/function.php');

/* echo "<pre>";
print_r($_REQUEST);
print_r($_SESSION);
//exit;
 */
$product_id = "";
$product_alias = "";
$user_id = $_SESSION['user_id'];

if(isset($_REQUEST['product_id']) && $_REQUEST['product_id']!="" && $_REQUEST['action']!="")
{
	$product_id = $_REQUEST['product_id'];
	$action = $_REQUEST['action'];
	if($action=="add")
	{
		$query_chkdup = "SELECT * FROM wishlist WHERE product_id='".$product_id."' AND user_id = '".$user_id."'";
		if($sql_chfdup = $conn->query($query_chkdup))
		{
			if($sql_chfdup->num_rows>0)
			{
				echo "Product Already Present in your Wishlist!";
				exit;
			}
			else
			{
				$query_insert = "INSERT INTO wishlist SET product_id = '".$product_id."',user_id = '".$user_id."',date = now()";
				if($sql_insert = $conn->prepare($query_insert))
				{
					$sql_insert->execute();
					if($sql_insert->affected_rows>0)
					{	
						echo "Product Successfully Added to Wishlist!";
						exit;
					}
				}
			}
		}
	}
	else if($action=="delete")
	{
		$query_insert = "DELETE FROM wishlist WHERE product_id = '".$product_id."' AND user_id = '".$user_id."'";
		if($sql_insert = $conn->query($query_insert))
		{
			echo "Product Successfully Deleted to Wishlist!";
			exit;
		}
	}
	else
	{
		echo "Something went wrong!";
		exit;
	}
}
else
{
	echo "Product ID dose not matched!";
	exit;
}

?>