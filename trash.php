<?php
@ob_start();
session_start();
?>
<?php
	include 'functions.php';
	include 'credentials.php';
	$pass=$_SESSION['pass'];
	$search = $_POST['search'];
	if($pass!=APPPASSWORD)
	{
		die('Password Incorrect');
	}
	include 'db_connect.php';	
?>

<html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
	<title>Trash - <?php echo JOURNAL_NAME;?> - SleekArchive</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="css/animate.css"/>
	<link href='https://fonts.googleapis.com/css?family=Roboto:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link type="text/css" rel="stylesheet" href="css/style.css"/>
	<script src="js/jquery.min.js"></script>
	<script>
		var app_pass = '<?php echo APPPASSWORD;?>';
	</script>
</head>
<body style="background:#FF7043;">
	<h1 style="text-align:center; font-weight:500;">Trash</h1>
	<?php
		if($search!='')
		{
			echo '<h1 style="text-align:center;"> Search results for </h1>';
		}
	?>
	<form action="index.php" method="POST">
		<h2 style="text-align:center; font-weight:300;"><input class="searchtrash" style="background:inherit; text-align:center; width:70%;" name="search" id="search" type="text" placeholder="Search" value="<?php echo $search; ?>"></h2>
	</form>
	<div class="trashbutton" style="bottom:20px; background:white;" onclick="window.location = 'index.php';"><h1 style="text-align:center; font-size:40px; padding-top:20px; margin:0;color:black;"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></h1></div>
	<div class="logoutbutton" style="bottom:120px;" onclick="window.location = 'logout.php';"><h1 style="text-align:center; font-size:40px; padding-top:20px; margin:0;color:white;"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></h1></div>
	<!-- <button class="btn btn-primary" onclick="window.location='login.html';" style="float:right; margin-right:20px;">Log Out</button> -->
	
	<br>
	<?php
		$query = 'SELECT * FROM entries WHERE trash = 1 AND (heading like \'%'.htmlspecialchars($search,ENT_QUOTES).'%\' OR entry like \'%'.htmlspecialchars($search,ENT_QUOTES).'%\') ORDER by id DESC';
		$res = $con->query($query);
		while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
		{
			echo '<div id="note'.$row['id'].'" class="notecard">
		<div class="innernote">
			<div class="created">'.formatDate(strtotime($row['created'])).'</div>
			<br>
			<div id="lastupdated'.$row['id'].'" class="lastupdated">Last Updated '.formatDateTime(strtotime($row['updated'])).'</div>
			<h1><input onfocus="updateidhead(this);" id="inp'.$row['id'].'" type="text" placeholder="Entry Heading" value="'.$row['heading'].'"></input> </h1>
			<hr>
			<textarea onload="initials(this);" onfocus="updateident(this);" id="entry'.$row['id'].'" placeholder="Entry Text">'.$row['entry'].'</textarea>
			<span alt="Permanently Delete" onclick="deletePermanent(\''.$row['id'].'\')" class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>
			<span alt="Restore To Journal" onclick="putBack(\''.$row['id'].'\')" class="glyphicon glyphicon-share pull-right" style="margin-right:20px;" aria-hidden="true"></span>

			<div style="height:30px;"></div>
		</div>
	</div>
	';
		}
	?>
</body>
	
	<script src="js/script.js"></script>
</html>
