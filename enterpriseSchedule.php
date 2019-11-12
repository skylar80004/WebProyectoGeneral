<?php
session_start();
 ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

    <title>Empresas de Transporte</title>
  </head>

  <body style="background-color:#FFFFFF">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#"><?php echo $_SESSION["username"]; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a href="changePassword.php" class="nav-link" href="#">Cambiar contraseña <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a href="enterprises.php" class="nav-link" href="#">Empresas<span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </nav>

    <br />
    <div class="container justify-content-center align-items-center">
      <br />
      <div class="row">
        <h3><?php echo $_GET['name']?></h3>
      </div>
      <div class="row">

        <?php
        if($_SESSION['username'] != null){
          $addRef = 'createSchedule.php?id='.$_GET['id'].'&name='.$_GET['name'];
          $updateRef = 'updateSchedule.php?id='.$_GET['id'].'&name='.$_GET['name'];
          $buttonAddRef = "<a href=".$addRef." class='btn  btn-primary btn-xs' href='#'>Crear horario</a>";
          echo $buttonAddRef;
          $buttonUpdateRef = "<a href=".$updateRef." class='btn  btn-primary btn-xs' href='#'>Actualizar horario</a>";
          echo $buttonUpdateRef;

        }


         ?>
      </div>
      <div class="row">
        <div class="col">
          <table class="table table-striped table-dark">
            <thead >
              <tr>
                  <th>Dia</th>
                  <th>Abre</th>
                  <th>Cierra</th>
              </tr>
            </thead>
            <tbody>
              <?php

                include 'dbConnection.php';
                $dbConnection = new dbConnection();
                $dbConnection->connect();
                $data = $dbConnection->getSchedule($_GET['id']);

                $mondayStart = "Sin horario";
                $mondayFinish = "Sin horario";
                $tuesdayStart = "Sin horario";
                $tuesdayFinish  = "Sin horario";
                $wednesdayStart = "Sin horario";
                $wednesdayFinish = "Sin horario";
                $thursdayStart = "Sin horario";
                $thursdayFinish = "Sin horario";
                $fridayStart = "Sin horario";
                $fridayFinish = "Sin horario";
                $saturdayStart = "Sin horario";
                $saturdayFinish = "Sin horario";
                $sundayStart = "Sin horario";
                $sundayFinish = "Sin horario";

                foreach ($data as $row) {

                  if($row['day']== "Lunes" && $row['start']!= null && $row['finish'] != null ){
                    $mondayStart = $row['start'];
                    $mondayFinish = $row['finish'];
                  }
                  if($row['day']== "Martes" && $row['start']!= null && $row['finish'] != null ){
                    $tuesdayStart = $row['start'];
                    $tuesdayFinish = $row['finish'];
                  }
                  if($row['day']== "Miercoles" && $row['start']!= null && $row['finish'] != null ){
                    $wednesdayStart = $row['start'];
                    $wednesdayFinish = $row['finish'];
                  }
                  if($row['day']== "Jueves" && $row['start']!= null && $row['finish'] != null ){
                    $thursdayStart = $row['start'];
                    $thursdayFinish = $row['finish'];
                  }
                  if($row['day']== "Viernes" && $row['start']!= null && $row['finish'] != null ){
                    $fridayStart = $row['start'];
                    $fridayFinish = $row['finish'];
                  }
                  if($row['day']== "Sabado" && $row['start']!= null && $row['finish'] != null ){
                    $saturdayStart = $row['start'];
                    $saturdayFinish = $row['finish'];
                  }
                  if($row['day']== "Sunday" && $row['start']!= null && $row['finish'] != null ){
                    $sundayStart = $row['start'];
                    $sundayFinish = $row['finish'];
                  }
                }

                echo '<tr>'.
                        '<td>Lunes</td>'.
                        '<td>'.$mondayStart.'</td>'.
                        '<td>'.$mondayFinish.'</td>'.
                      '</tr>'.
                      '<tr>'.
                        '<td>Martes</td>'.
                        '<td>'.$tuesdayStart.'</td>'.
                        '<td>'.$tuesdayFinish.'</td>'.
                      '</tr>'.
                      '<tr>'.
                        '<td>Miercoles</td>'.
                        '<td>'.$wednesdayStart.'</td>'.
                        '<td>'.$wednesdayStart.'</td>'.
                      '</tr>'.
                      '<tr>'.
                        '<td>Jueves</td>'.
                        '<td>'.$thursdayStart.'</td>'.
                        '<td>'.$thursdayFinish.'</td>'.
                      '</tr>'.
                      '<tr>'.
                        '<td>Viernes</td>'.
                        '<td>'.$fridayStart.'</td>'.
                        '<td>'.$fridayFinish.'</td>'.
                      '</tr>'.
                      '<tr>'.
                        '<td>Sabado</td>'.
                        '<td>'.$saturdayStart.'</td>'.
                        '<td>'.$saturdayFinish.'</td>'.
                      '</tr>'.
                      '<tr>'.
                        '<td>Domingo</td>'.
                        '<td>'.$sundayStart.'</td>'.
                        '<td>'.$sundayFinish.'</td>'.
                      '</tr>'
                      ;
               ?>
            </tbody>
      </table>
        </div>
</div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
