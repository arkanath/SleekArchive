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
	$query="DELETE from entries WHERE id=".$id;
	
	if($con->query($query)) echo 1;
	else echo mysqli_error($con);
?>