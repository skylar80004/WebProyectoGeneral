<?php
  session_start();
  if (isset($_GET['Message'])) {
      print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
  }
  include 'dbConnection.php';
  $dbConnection = new dbConnection();
  $dbConnection->connect();
  $enterpriseData = $dbConnection->getEnterprise($_GET['id']);
  $_SESSION["enterpriseId"] = $_GET['id'];

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
      <br />
      <div class="row">
        <div class="col">
          <form id="login-form" class="form" action="editEnterpriseDB.php" method="post">
            <h2>Ingrese los datos para actualizar la empresa</h2>
            <div class="form-group">
              <label for="exampleInputEmail1">Nombre de la empresa</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['name']) ?> type="text" class="form-control" name="enterpriseName" id="enterpriseName" placeholder="Ejemplo: Lumaca">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Sitio origen del servicio</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['origin']) ?> type="text" class="form-control" name="enterpriseOrigin" id="enterpriseOrigin" placeholder="Ejemplo: Cartago">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Sitio destino del servicio</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['destiny']) ?> type="text" class="form-control" name="enterpriseDestiny" id="enterpriseDestiny" placeholder="Ejemplo: San Jose">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Número de Teléfono</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['phone']) ?> type="tel" class="form-control" name="enterprisePhone" id="enterprisePhone" placeholder="Ejemplo: 2551-1234">
              <small id="emailHelp" class="form-text text-muted">Formato: 2222-2222</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Correo Electrónico</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['email']) ?> type="email" class="form-control" name="enterpriseEmail" id="enterpriseEmail" placeholder="Ejemplo: nombre@correo.com">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Dirección física</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['address']) ?> type="text" class="form-control" name="enterpriseAddress" id="enterpriseAddress" placeholder="Ejemplo: Cartago, 100 metros norte de Iglesia del Carmen">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Latitud</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['latitude']) ?> type="text" class="form-control" name="enterpriseLat" id="enterpriseLat" placeholder="Ejemplo: , 10.5">
              <small id="emailHelp" class="form-text text-muted">Puede establecer la ubicación haciendo click en el mapa</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Longitud</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['longitude']) ?> type="text" class="form-control" name="enterpriseLng" id="enterpriseLng" placeholder="Ejemplo: 100.4534">
              <small id="emailHelp" class="form-text text-muted">Puede establecer la ubicación haciendo click en el mapa</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Contacto para reportar anomalías</label>
              <input value= <?php echo htmlspecialchars($enterpriseData['anomalyContact']) ?> type="text" class="form-control" name="anomalyContact" id="anomalyContact" placeholder="Ejemplo: Telefono 2553-0973">
            </div>
            <button type="submit" class="btn btn-primary">Editar Empresa</button>
          </form>
        </div>
        <div class="col">

          <div id="map" class="map map-home" style="margin:12px 0 12px 0;height:600px;"></div>
          <script>

          	let osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
          		osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
          		osm = L.tileLayer(osmUrl, {maxZoom:40 , attribution: osmAttrib});

            let OpenStreetMap_HOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
          	maxZoom: 19,
          	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a> hosted by <a href="https://openstreetmap.fr/" target="_blank">OpenStreetMap France</a>'
          });

          	let map = L.map('map').setView([9.973255, -84.083802], 17).addLayer(OpenStreetMap_HOT);
            let marker;
            map.on('click', function(e){ // When map is clicked, a new marker appears and the inputs for lat and lng are updated

              marker = new L.Marker(e.latlng,{draggable:true});
              map.addLayer(marker);
              let domInputLat = document.getElementById('enterpriseLat');
              let domInputLon = document.getElementById('enterpriseLng');
              domInputLat.value = e.latlng.lat;
              domInputLon.value = e.latlng.lng;

            });
        </script>
        </div>
      </div>
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
