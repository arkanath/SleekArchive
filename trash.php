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

	<!-- <link rel="stylesheet" type="text/css" href="css/normalize.css" /> -->
	<link rel="stylesheet" type="text/css" href="css/toggle-switch.css" />
	<link href="css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="themes/default.css" />
	<link rel="stylesheet" type="text/css" href="css/page.css" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.popline.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.popline.link.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.popline.blockquote.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.popline.decoration.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.popline.list.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.popline.justify.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.popline.blockformat.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.popline.social.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.popline.backcolor.js"></script>

	<script>
		var app_pass = '<?php echo APPPASSWORD;?>';
	</script>
</head>
<body style="background:#FF7043;">
	<h1 style="text-align:center; font-weight:500;">Trash</h1>
	<?php
		if($search!='')
		{
			echo '<h1 style="text-align:center; font-weight:300;"> Search results for '.$search.'. <span style="cursor:pointer;font-weight:700;" onclick="window.location=\'trash.php\'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span></h1>';
		}
	?>
	<form action="trash.php" method="POST">
		<h2 style="text-align:center; font-weight:300;"><input onfocus="updateidhead(this);" class="searchtrash" style="background:inherit; text-align:center; width:70%;" name="search" id="search" type="text" placeholder="Search"></h2>
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
			$filename = "./entries/".$row["id"].".entry";
			$handle = fopen($filename, "r");
			$contents = fread($handle, filesize($filename));
			$entryfinal = $contents;
			fclose($handle);
			echo '<div id="note'.$row['id'].'" class="notecard">
		<div class="innernote">
			<div class="created">'.formatDate(strtotime($row['created'])).'</div>
			<br>
			<div id="lastupdated'.$row['id'].'" class="lastupdated">Last Updated '.formatDateTime(strtotime($row['updated'])).'</div>
			<h1><input onfocus="updateidhead(this);" id="inp'.$row['id'].'" type="text" placeholder="Entry Heading" value="'.$row['heading'].'"></input> </h1>
			<hr>
			<div class="noteentry" onload="initials(this);" onfocus="updateident(this);" id="entry'.$row['id'].'" data-ph="Entry Text" contenteditable="true">'.$entryfinal.'</div>
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
	<script>
	$(".noteentry").popline();
	</script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58163502-1', 'auto');
  ga('send', 'pageview');

</script>
</html>
