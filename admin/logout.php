<?php


include('../config/function.php');

$query_update = "UPDATE admin SET last_login=now() WHERE user_name='".$_SESSION['user_name']."'";
if($sql_update = $conn->prepare($query_update))
{
	$sql_update->execute();
}
session_destroy();
header('location:index.php');
exit();

?>

