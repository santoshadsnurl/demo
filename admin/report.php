<?php

include('session.php');

$file_type = "vnd.ms-excel";
$file_ending = "xls";

$user_report = "report.".$file_ending;

//header info for browser: determines file type ('.doc' or '.xls')

HEADER("Content-Type: application/$file_type");
HEADER("Content-Disposition: attachment; filename=$user_report");
HEADER("Pragma: no-cache");
HEADER("Expires: 0");

//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character

//start of printing column names as names of MySQL fields
$toptitle = "Order Id,Order Date,Name,Phone,Email,Address,Country,City";

FOR ($i = 0; $i <8; $i++)
{
	$t = explode(",", $toptitle);
	ECHO $t[$i] . "\t";
}

PRINT("\n");

$query = "SELECT * FROM orders ORDER BY id DESC";
if($sql_query = $conn->query($query))
{
	WHILE($row = $sql_query->fetch_array(MYSQLI_ASSOC))
	{
		$schema_insert = "";
		$schema_insert .= $row['id'].$sep;
		$schema_insert .= $row['order_date'].$sep;
		$schema_insert .= $row['ship_name'].$sep;
		$schema_insert .= $row['ship_phone'].$sep;
		$schema_insert .= $row['ship_email'].$sep;
		$schema_insert .= $row['ship_address'].$sep;
		$schema_insert .= $row['ship_country'].$sep;
		$schema_insert .= $row['ship_city'].$sep;
		$schema_insert = STR_REPLACE($sep."$", "", $schema_insert);
		$schema_insert = PREG_REPLACE("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		$schema_insert .= "\t";
		PRINT(TRIM($schema_insert));
		PRINT "\n";
	}
}
?>