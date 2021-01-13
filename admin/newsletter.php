<?php

include('session.php');

$file_type = "vnd.ms-excel";
$file_ending = "xls";

$user_report = "newletters.".$file_ending;

//header info for browser: determines file type ('.doc' or '.xls')

HEADER("Content-Type: application/$file_type");
HEADER("Content-Disposition: attachment; filename=$user_report");
HEADER("Pragma: no-cache");
HEADER("Expires: 0");

//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character

//start of printing column names as names of MySQL fields
$toptitle = "Email Address";

FOR ($i = 0; $i <1; $i++)
{
	$t = explode(",", $toptitle);
	ECHO $t[$i] . "\t";
}

PRINT("\n");

$query = "SELECT * FROM subscribers";
if($sql_query = $conn->query($query))
{
	WHILE($row = $sql_query->fetch_array(MYSQLI_ASSOC))
	{
		$schema_insert = "";
		$schema_insert = $row['email'].$sep;
		$schema_insert = STR_REPLACE($sep."$", "", $schema_insert);
		$schema_insert = PREG_REPLACE("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		$schema_insert .= "\t";
		PRINT(TRIM($schema_insert));
		PRINT "\n";
	}
}
?>