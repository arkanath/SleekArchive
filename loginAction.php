<?php
@ob_start();
session_start();
$_SESSION['pass'] = $_POST['pass'];
header('Location: ./index.php');
?>