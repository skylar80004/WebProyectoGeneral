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

    <title>Hello, world!</title>
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

    <div class="container">
      <div class="row">
        <form>
          <h2>Ingrese la información de la nueva empresa de transporte</h2>
          <div class="form-group">
            <label for="exampleInputEmail1">Nombre de la empresa</label>
            <input type="text" class="form-control" id="enterpriseName" placeholder="Ejemplo: Lumaca">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Sitio origen del servicio</label>
            <input type="text" class="form-control" id="enterpriseOrigin" placeholder="Ejemplo: Cartago">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Número de Teléfono</label>
            <input type="tel" class="form-control" id="enterprisePhone" placeholder="Ejemplo: 2551-1234">
            <small id="emailHelp" class="form-text text-muted">Formato: 2222-2222</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Correo Electrónico</label>
            <input type="email" class="form-control" id="enterpriseOrigin" placeholder="Ejemplo: nombre@correo.com">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Dirección física</label>
            <input type="text" class="form-control" id="enterpriseOrigin" placeholder="Ejemplo: Cartago, 100 metros norte de Iglesia del Carmen">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Dirección física</label>
            <input type="text" class="form-control" id="enterpriseOrigin" placeholder="Ejemplo: Cartago, 100 metros norte de Iglesia del Carmen">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
