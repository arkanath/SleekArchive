<?php
@ob_start();
session_start();
$_SESSION['pass'] = '';
header('Location: ./login.php');
?>