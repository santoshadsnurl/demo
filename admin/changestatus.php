<?php
include('../config/conn.php');
if(isset($_REQUEST['Action']) && ($_REQUEST['Action']=="Update"))
{
	$status = $_REQUEST['status'];
	$id = $_REQUEST['id'];
	$table = $_REQUEST['table'];
	$qr_status = "UPDATE $table SET status='".$status."' WHERE id='".$id."'";
	if($sql_status =$conn->prepare($qr_status))
	{
		$sql_status->execute();
	}
	echo "Status has been updated";
}
else
{
	echo "Request Not Found!";
}
?>