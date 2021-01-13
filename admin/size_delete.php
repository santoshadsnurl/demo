<?php 

$id = "";

include('session.php');

if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
{
	$id = $_REQUEST['id'];
	$query_delete = "DELETE FROM product_sizes WHERE id='".$id."'";
	if($sql_delete = $conn->query($query_delete))
	{
		echo "<script>document.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
		exit;					
	}
}
else
{
	echo "<script>document.location.href='products_mgmt.php'</script>";
	exit;
}
?>