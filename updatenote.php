<?php
	date_default_timezone_set('UTC');
	include 'functions.php';
	include 'credentials.php';
	$pass=$_POST['pass'];
	if($pass!=APPPASSWORD)
	{
		die('Password Incorrect');
	}
	include 'db_connect.php';
	$id = $_POST['id'];
	$heading = $_POST['heading'];
	$entry = $_POST['entry'];
	$now = $_POST['now'];
	$seconds = $now;
	$query="SELECT * from entries WHERE id=".$id;
	$res = $con->query($query);
	$row = mysqli_fetch_array($res,MYSQLI_ASSOC);
	// die(date("Y-m-d H:i:s", $seconds));
	$handle = fopen("entries/".$id.".entry", 'w+') or die("Unable to open file!");
	$str = fread($handle, filesize($id.".entry"));
	if(htmlspecialchars($heading,ENT_QUOTES)==$row['heading'] && $entry==$str)
	{
		die('Last Updated '.formatDateTime(strtotime($row['updated'])));
	}
	fwrite($handle, $entry) or die("Unable to write to file!");
	fclose($handle);
	$query="UPDATE entries SET heading = '".htmlspecialchars($heading,ENT_QUOTES)."', entry = '".htmlspecialchars($entry,ENT_QUOTES)."', updated = '".date("Y-m-d H:i:s", $seconds)."' WHERE id=".$id;
	if($con->query($query)) echo die('Last Updated '.formatDateTime(strtotime(date("Y-m-d H:i:s", $seconds))));
	else echo mysqli_error($con);
?>