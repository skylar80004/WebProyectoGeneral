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
    <div class="container justify-content-left align-items-left">

      <div class="row">
        <form action="createEnterprise.php">
          <button type="submit" class="btn btn-dark">Agregar Nueva Empresa</button>
        </form>
      </div>
      <br />
      <div class="row">
        <div class="col">
          <table class="table table-striped table-dark">
            <thead >
              <tr>
                  <th>Nombre</th>
                  <th>Origen Del Servicio</th>
                  <th>Destino Del Servicio</th>
                  <th>Télefono</th>
                  <th>Correo Electrónico</th>
                  <th>Dirección Física</th>
                  <th>Contacto en caso de anomalía</th>
                  <th class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                  <td>1</td>
                  <td>News</td>
                  <td>News Cate</td>
                  <td>1</td>
                  <td>News</td>
                  <td>News Cate</td>
                  <td>1</td>
                  <td class="text-center">
                    <a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Editar</a>
                    <a href="enterpriseSchedule.php" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Horario</a>
                  </td>
              </tr>
              <?php

              include 'dbConnection.php';

              $dbConnection = new dbConnection();
              $dbConnection->connect();
              $data = $dbConnection->getEnterprises();
              foreach($data as $row){
                $scheduleRef = 'enterpriseSchedule.php?id='.$row['id'].'&name='.$row['name'];
                $mapRef = 'enterpriseMap.php?lat='.$row['latitude'].'&lng='.$row['longitude'].'&name='.$row['name'];
                $editRef = 'editEnterprise.php?id='.$row['id'];
                $buttonEdit = "<a href=".$editRef." class='btn btn-block btn-info btn-xs' href='#'>Editar</a>";
                $buttonSchedule = "<a href=".$scheduleRef." class='btn btn-block btn-info btn-xs'>Horario</a>";
                $buttonMap = "<a href=".$mapRef." class='btn btn-block btn-info btn-xs'>Mapa</a>";

                echo '<tr>
                        <td>'.$row['name'].'</td>'.
                        '<td>'.$row['origin'].'</td>'.
                        '<td>'.$row['destiny'].'</td>'.
                        '<td>'.$row['phone'].'</td>'.
                        '<td>'.$row['email'].'</td>'.
                        '<td>'.$row['address'].'</td>'.
                        '<td>'.$row['anomalyContact'].'</td>'.
                        '<td>'.
                          $buttonEdit.
                          $buttonSchedule.
                          $buttonMap.
                        '</td>'.
                      '</tr>'
                ;

              }


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
