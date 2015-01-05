<?php
	date_default_timezone_set('UTC');
	include 'functions.php';
	include 'credentials.php';
	$pass=$_GET['pass'];
	if($pass!=APPPASSWORD)
	{
		die('Password Incorrect');
	}
	include 'db_connect.php';
	$id = $_GET['id'];
	$heading = $_GET['heading'];
	$entry = $_GET['entry'];
	$now = $_GET['now'];
	$seconds = $now;
	$query="SELECT * from entries WHERE id=".$id;
	$res = $con->query($query);
	$row = mysqli_fetch_array($res,MYSQLI_ASSOC);
	// die(date("Y-m-d H:i:s", $seconds));
	if(htmlspecialchars($heading,ENT_QUOTES)==$row['heading'] && str_replace("'","&apos;",$entry)==$row['entry'])
	{
		die('Last Updated '.formatDateTime(strtotime($row['updated'])));
	}
	 
	$query="UPDATE entries SET heading = '".htmlspecialchars($heading,ENT_QUOTES)."', entry = '".str_replace("'","&apos;",$entry)."', updated = '".date("Y-m-d H:i:s", $seconds)."' WHERE id=".$id;
	if($con->query($query)) echo die('Last Updated '.formatDateTime(strtotime(date("Y-m-d H:i:s", $seconds))));
	else echo mysqli_error($con);
?>