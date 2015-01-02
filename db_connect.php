<?php

// Create connection
$conn = new mysqli(HOSTDB, USERDB, PASSWORDDB);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS ".DATABASEDB;
if ($conn->query($sql) === TRUE) {
} else {
	echo "Error creating database: " . $conn->error;
}
$conn->close();
$con = new mysqli(HOSTDB, USERDB, PASSWORDDB, DATABASEDB);
if (mysqli_connect_errno($con)){
	echo 'Could not connect: ' . mysqli_connect_error();
}
$con->query("SET NAMES 'utf8';");
// If you are connecting via TCP/IP rather than a UNIX socket remember to add the port number as a parameter.
$query='CREATE TABLE IF NOT EXISTS entries (id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,trash int(11) DEFAULT 0, heading text,entry text,created TIMESTAMP ,updated TIMESTAMP)';
$con->query($query);
$query='SELECT * FROM entries';
$res = $con->query($query);
if($res->num_rows==0)
{

	$entry = 'Welcome to SleekArchive!

Since there are no entries right now, let&#039;s talk about how to use this application.

If you can see this page, we assume you have already succeeded in hosting this application on your server.

Some points to note before you start using SleekArchive:

1. Your edits are saved automatically. 
2. You can see the last update time and the date of creation on the top right of this card.
3. You must NOT disclose your password to others (unless you want to, of course)
4. The text is not encrypted before being stored on your server, hence it&#039;s your responsibility to keep your server unaccessible to others.

That&#039;s it. You are good to go. Make a new entry by clicking the pencil button on the bottom right of the screen. Delete this note by clicking the icon on bottom right of this entry card.';

	$query="INSERT INTO entries (heading,entry) values ('Hello There!','".$entry."')";
	if($con->query($query))
	{

	}
	else
	{
		die(mysqli_error($con));
	}
}

?>
