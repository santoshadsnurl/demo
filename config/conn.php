<?php

session_start();

$session_id = session_id();

if($_SERVER['HTTP_HOST'] == 'localhost')
{
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$dbName = 'masterro_ramanta';
}
else
{
	$host = 'localhost';
	$username = 'masterro_ramanta';
	$password = 'masterro_ramanta';
	$dbName = 'masterro_ramanta';
}

$conn = new mysqli($host,$username,$password,$dbName);
if($conn->connect_errno)
{
	echo $conn->connect_error;
}

$site_root = 'http://'.$_SERVER['HTTP_HOST'].'/ramanta/';

if(!isset($_SESSION['arabic']) && !isset($_SESSION['english']))
{
	$_SESSION['arabic'] = "";
	$_SESSION['english'] = 1;
	unset($_SESSION['arabic']);
}

function changelanguage($conn,$text1,$text2)
{
	if(isset($_SESSION['arabic']))
	{
		echo $text2;
	}
	else
	{
		echo $text1;
	}
}

if(isset($_SESSION['arabic'])) { $arabic = 'arabic_'; } else { $arabic =''; }


?>