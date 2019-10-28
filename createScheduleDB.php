<?php
include 'dbConnection.php';
$dbConnection = new dbConnection();
$dbConnection->connect();

try {
  $dbConnection->insertSchedule();
} catch (\Exception $e) {
  $dbConnection->updateSchedule();
}

 ?>
