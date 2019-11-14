<?php

  include 'dbConnection.php';
  $dbConnection = new dbConnection();
  $dbConnection->connect();

  $json = file_get_contents('php://input');
  // Converts it into a PHP object
  $data = json_decode($json);
  $queryNumber = $data->queryNumber;


  if($queryNumber == 1){

    $enterpriseName = $data->enterpriseName;
    $enterpriseID = $data->enterpriseID;
    $dbConnection->getAllRoutesFromEnterprise($enterpriseName,$enterpriseID);

  }
  else if($queryNumber == 3){
    $destiny = $data->destiny;
    $dbConnection->getRoutesByDestiny($destiny);
  }
  else if($queryNumber == 4){
    $dbConnection->getAllRoutes();
  }
 ?>
