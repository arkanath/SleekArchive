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
$query='CREATE TABLE IF NOT EXISTS entries (id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,trash int(11) DEFAULT 0, heading text,entry text,created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updated TIMESTAMP)';
$con->query($query);
$query='SELECT * FROM entries';
$res = $con->query($query);
if($res->num_rows==0)
{

	$entry = '<h3 style="text-align: center;">Welcome to SleekArchive!</h3><div><br></div><div>Since there are no entries right now, let&apos;s talk about how to use this application.</div><div><span style="line-height: 1.42857143;"><br></span></div><div><span style="line-height: 1.42857143;">If you can see this page, we assume you have already succeeded in hosting this application on your server.&nbsp;</span></div><div><span style="line-height: 1.42857143;"><br></span></div><div><span style="line-height: 1.42857143;"><i>Some points to note before you start using <b>SleekArchive</b>:</i>&nbsp;</span></div><div><span style="line-height: 1.42857143;"><br></span></div><div><ol><li><span style="line-height: 1.42857143;">Your edits&nbsp;are saved automatically.</span></li><li><span style="line-height: 1.42857143;">You can see the last update time and the date of creation on the top right of this card.</span></li><li><span style="line-height: 1.42857143;">The time of the client is used for update and create time (<i>not the server on which it is hosted</i>)</span></li><li><span style="line-height: 1.42857143;">You must NOT disclose your password to others (unless you want to, of course)</span></li><li><span style="line-height: 1.42857143;">The text is not encrypted before being stored on your server, hence it&apos;s your responsibility to keep your server unaccessible to others.&nbsp;</span></li></ol><div><span style="line-height: 1.42857143;">That&apos;s it. You are good to go. Make a new entry by clicking the pencil button on the bottom right of the screen. Delete this note by clicking the icon on bottom right of this entry card.</span></div></div>';

	$query="INSERT INTO entries (heading,entry) values ('Hello There!','".htmlspecialchars($entry,ENT_QUOTES)."')";
	
	$con->query($query) or die(mysqli_error($con));
	$query="SELECT id from entries ORDER by id DESC";
	$res = $con->query($query);
	$row = mysqli_fetch_array($res,MYSQLI_ASSOC);
	$handle = fopen("entries/".$row['id'].".entry", 'w+') or die("Unable to open file!");
	fwrite($handle, $entry) or die("Unable to write to file!");
	fclose($handle);
	
}

?>
