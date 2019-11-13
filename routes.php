<?php
session_start();
$param = $_SESSION["username"];
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


    <title>Rutas</title>
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
          <li class="nav-item active">
            <a href="log.php" class="nav-link" href="#">Log<span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </nav>
    <br />
    <div class="container justify-content-left align-items-left">
      <div class="row">
        <div class="col">
          <form id="route-form" class="form">
            <h2>Ingrese la informacion de la nueva ruta</h2>
            <div class="form-group">
              <label for="routeNumber">Número de ruta</label>
              <input type="text" class="form-control" name="routeNumber" id="routeNumber" placeholder="Ejemplo: 1">
            </div>
            <div class="form-group">
              <label for="routeNumber">Descripción de la ruta</label>
              <input type="text" class="form-control" name="routeDescription" id="routeDescription" placeholder="Ejemplo: Ruta de bus desde San Jose hacia Cartago">
            </div>
            <div class="form-group">
              <label for="routeNumber">Costo del pasaje</label>
              <input type="text" class="form-control" name="routeCost" id="routeCost" placeholder="Ejemplo: Ruta de bus desde San Jose hacia Cartago">
            </div>
            <div class="form-group">
              <label for="routeNumber">Duración aproximada del viaje(en minutos)</label>
              <input type="text" class="form-control" name="routeDuration" id="routeDuration" placeholder="Ejemplo: Ruta de bus desde San Jose hacia Cartago">
            </div>
            <div class="form-group">
              <input type="checkbox" name="routeHandicapCheck" id="routeHandicapCheck" value="Si">Cuenta con unidades para el transporte de personas con dispacidad<br>
            </div>
            <button id="buttonAddRoute" type="button" class="btn btn-primary">Agregar ruta</button>
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
          let markersArray = [];
          let marker;

          map.on('click', function(e){ // When map is clicked, a new marker appears and the inputs for lat and lng are updated
            marker = new L.Marker(e.latlng,{draggable:true});
            map.addLayer(marker);
            markersArray.push(L.latLng(e.latlng.lat,e.latlng.lng));

            L.Routing.control({
              waypoints: markersArray,
              routeWhileDragging: true
            }).addTo(map);

          });
        </script>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      window.onload = function(){
        let buttonAddRoute = document.getElementById("buttonAddRoute");
        buttonAddRoute.onclick = function(){


          let urlString = window.location.href;
          let url = new URL(urlString);
          let enterpriseID = url.searchParams.get('id');
          let enterpriseName = url.searchParams.get('name');

          let routeNumber = document.getElementById("routeNumber").value;
          let routeDescription = document.getElementById("routeDescription").value;
          let routeCost = document.getElementById("routeCost").value;
          let routeDuration = document.getElementById("routeDuration").value;
          let routeHandicapCheck = document.getElementById("routeHandicapCheck").checked;

          if(routeHandicapCheck){
            routeHandicapCheck = "Si";
          }
          else{
            routeHandicapCheck = "No";
          }

          let data = {
            routePoints: markersArray,
            routeHandicapCheck: routeHandicapCheck,
            routeNumber: routeNumber,
            routeDescription: routeDescription,
            routeCost: routeCost,
            routeDuration: routeDuration,
            enterpriseID: enterpriseID,
            enterpriseName: enterpriseName
          };

          console.log(data);
          let xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange  = function(){
            if(this.readyState == 4 && this.status == 200){
               alert(xhttp.responseText);
            }
          }
          xhttp.open("POST","createRoute.php",true);
          xhttp.setRequestHeader("Content-type", "application/json");
          xhttp.send(JSON.stringify(data));
        };

      }


    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
