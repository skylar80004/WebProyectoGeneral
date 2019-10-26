<?php

include 'dbConnection.php';
$dbConnection = new dbConnection();
$dbConnection->connect();
$dbConnection->insertEnterprise();

 ?>
