<?php
session_start();
$_SESSION['username'] = null;
$newURL = "welcome.php";
header('Location: '.$newURL);

 ?>
