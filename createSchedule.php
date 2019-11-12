<?php
session_start();
if (isset($_GET['Message'])) {
    print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
$_SESSION['enterpriseId'] = $_GET['id'];
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

    <title>Horario</title>
  </head>
  <body>
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
    <div class="container">
      <div class="row">
        <h2><?php echo 'Ingrese la información del horario de '.$_GET['name'] ?></h2>
      </div>
      <br />
      <form id="login-form" class="form" action="createScheduleDB.php" method="post">
      <div class="row">
        <div class="col">
            <div class="form-group">
              <label for="exampleInputEmail1">Lunes(abre)</label>
              <input type="text" class="form-control" name="mondayStart" id="mondayStart" placeholder="Ejemplo: 5:00 am">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Lunes(cierra)</label>
              <input type="text" class="form-control" name="mondayFinish" id="mondayFinish" placeholder="Ejemplo:10:00 pm">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Martes(abre)</label>
              <input type="text" class="form-control" name="tuesdayStart" id="enterpriseDestiny" placeholder="Ejemplo: 5:00 am">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Martes(cierra)</label>
              <input type="text" class="form-control" name="tuesdayFinish" id="enterprisePhone" placeholder="Ejemplo: 5:00 am">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Miércoles(abre)</label>
              <input type="text" class="form-control" name="wednesdayStart" id="wednesdayStart" placeholder="Ejemplo: 5:00 am">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Miércoles(cierra)</label>
              <input type="text" class="form-control" name="wednesdayFinish" id="wednesdayFinish" placeholder="Ejemplo: 5:00 am">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Jueves(abre)</label>
              <input type="text" class="form-control" name="thursdayStart" id="thursdayStart" placeholder="Ejemplo: 5:00 am">
            </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label for="exampleInputPassword1">Jueves(cierra)</label>
            <input type="text" class="form-control" name="thursdayFinish" id="thursdayFinish" placeholder="Ejemplo: 5:00 am">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Viernes(abre)</label>
            <input type="text" class="form-control" name="fridayStart" id="fridayStart" placeholder="Ejemplo: 5:00 am">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Viernes(cierra)</label>
            <input type="text" class="form-control" name="fridayFinish" id="fridayFinish" placeholder="Ejemplo: 5:00 am">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Sábado(abre)</label>
            <input type="text" class="form-control" name="saturdayStart" id="saturdayStart" placeholder="Ejemplo: 5:00 am">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Sábado(cierra)</label>
            <input type="text" class="form-control" name="saturdayFinish" id="saturdayFinish" placeholder="Ejemplo: 5:00 am">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Domingo(abre)</label>
            <input type="text" class="form-control" name="sundayStart" id="sundayStart" placeholder="Ejemplo: 5:00 am">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Domingo(cierra)</label>
            <input type="text" class="form-control" name="sundayFinish" id="sundayFinish" placeholder="Ejemplo: 5:00 am">
          </div>
        </div>
      </div>
      <div class="col-12">
        <button type="submit" class="btn  btn-block btn-primary">Agregar horario</button>
      </div>

    </form>
    </div>
    <br />
  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
