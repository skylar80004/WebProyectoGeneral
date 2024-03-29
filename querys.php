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
          <h4>Rutas de servicio por empresa</h4>
          <label for="routeNumber">Seleccione el nombre de la empresa</label>
          <select id="selectQueryAllRoutes">
            <?php
              // Get enterprise name and id to print a combo box in the html
              include 'dbConnection.php';
              $dbConnection = new dbConnection();
              $dbConnection->connect();
              $data = $dbConnection->getEnterprises();
              foreach ($data as $row) {
                echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
              }
             ?>
          </select>
          <button id="buttonQueryAllRoutes" type="button" class="btn btn-secondary btn-block">Consultar</button>
          <br>
          <h4>Rutas de servicio con un destino particular</h4>
          <label for="routeNumber">Ingrese el nombre del destino:</label>
          <input id="inputQueryByDestiny" type="text" class="form-control" placeholder="Ejemplo: San José" aria-label="Recipient's username" aria-describedby="basic-addon2">
          <button id="buttonQueryByDestiny" class="btn btn-secondary btn-block">Consultar</button>
          <br>
          <h4>Rutas con algún punto intermedio en común</h4>
          <button id="buttonQueryInCommon" class="btn btn-secondary btn-block">Consultar</button>


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

        </script>
        </div>
      </div>
    </div>

    <script type="text/javascript">


    function checkPointsInCommon(routesArray){
      let pointsArray = [];
      let pointsArrayCompare = [];

      let polylineArray = [];
      let polylinePoint = [];

      let polylineArrayCompare = [];
      let polylinePointCompare = [];
      const compareDistace = 50;

      let markerInCommonOriginal = false;
      let markerInCommonCompare = false;

      for(let i = 0; i < routesArray.length;i++){
        pointsArray = routesArray[i];
        for(let j = 1; j < pointsArray.length;j++){

          let point = pointsArray[j];
          let type = point[0];
          let lat = point[1];
          let lng = point[2];
          let latFloat = parseFloat(lat);
          let lngFloat = parseFloat(lng);
          polylinePoint = [latFloat,lngFloat];
          polylineArray.push(polylinePoint);

          for(let i2 = i+1; i2 < routesArray.length;i2++){
            pointsArrayCompare = routesArray[i2];
            for(let j2 = 1; j2 < pointsArrayCompare.length;j2++){

              let pointCompare = pointsArrayCompare[j2];
              let latCompare = pointCompare[1];
              let lngCompare = pointCompare[2];
              let latFloatCompare = parseFloat(latCompare);
              let lngFloatCompare = parseFloat(lngCompare);

              let latLngOriginal = L.latLng(latFloat, lngFloat);
              let latLngCompare = L.latLng(latFloatCompare, lngFloatCompare);
              polylinePointCompare = [latCompare,lngCompare];
              polylineArrayCompare.push(polylinePointCompare);

              if(latLngOriginal.distanceTo(latLngCompare) <= compareDistace){
                markerInCommonOriginal = true;
                markerInCommonCompare = true;
              }
            }
            if(markerInCommonCompare){

              let color;
              let r = Math.floor(Math.random() * 255);
              let g = Math.floor(Math.random() * 255);
              let b = Math.floor(Math.random() * 255);
              color = "rgb("+r+" ,"+g+","+ b+")";

              let polyLineCompare = L.polyline(polylineArrayCompare,{color:color}).addTo(map);
              polylineArrayCompare = [];
              markerInCommonCompare = false;
            }
            else{
              polylineArrayCompare = [];
            }
          }
        }
        if(markerInCommonOriginal){
          let color;
          let r = Math.floor(Math.random() * 255);
          let g = Math.floor(Math.random() * 255);
          let b = Math.floor(Math.random() * 255);
          color = "rgb("+r+" ,"+g+","+ b+")";

          let polyline = L.polyline(polylineArray,{color:color}).addTo(map);
          polylineArray = [];
          markerInCommonOriginal = false;

        }
        else{
          polylineArray = [];
        }

      }
    }

      // Recibe un array de 3 dimensiones que representa las rutas
      // La primer dimension son las rutas en general
      // la segunda dimension es una ruta especifica
      // La tercera son los puntos de una ruta especifica
      // Ejemplo : [ [ [info], [tipoPunto, 12, 10], [tipoPunto,15,10] ] , [ [tipoPunto,10,10], [tipoPunto,9,10] , [tipoPunto, 11,12] ] ]
      // En este ejemplo , la empresa X tiene dos rutas, la primer ruta tiene 2 puntos y la segunda ruta tiene 3 puntos
      function drawRoutes(routesArray){

        let pointsReady = [];
        let pointsArray = [];

        let polylineArray = [];
        let polylinePoint = [];
        const redColor = '#ff0000';
        const greenColor = '#00ff00';
        const blueColor = '#0000ff';

        console.log(routesArray);
        for(let i = 0 ; i < routesArray.length;i++){
          pointsArray = routesArray[i];

          for(let j = 1 ; j < pointsArray.length;j++){ // Empieza en 1 porque el indice 0 tiene informacion de la ruta como descripcion, a partir del indice 1 salen los puntos

            let point = pointsArray[j];
            let type = point[0];
            let lat = point[1];
            let lng = point[2];
            let latFloat = parseFloat(lat);
            let lngFloat = parseFloat(lng);
            if(j == 1){
              map.panTo(new L.LatLng(latFloat, lngFloat));
            }

            let myCustomColour;

            if(type == "Start"){
              type="Inicial";
              myCustomColour = blueColor;

            }
            else if(type == "Finish"){
              type="Final";
              myCustomColour = redColor;
            }
            else{
              type="Intermedio";
              myCustomColour = greenColor;
            }

            const markerHtmlStyles = `
              background-color: ${myCustomColour};
              width: 3rem;
              height: 3rem;
              display: block;
              left: -1.5rem;
              top: -1.5rem;
              position: relative;
              border-radius: 3rem 3rem 0;
              transform: rotate(45deg);
              border: 1px solid #FFFFFF`;

            const icon = L.divIcon({
              className: "my-custom-pin",
              iconAnchor: [0, 24],
              labelAnchor: [-6, 0],
              popupAnchor: [0, -36],
              html: `<span style="${markerHtmlStyles}" />`
            });

            let marker =  L.marker([latFloat, lngFloat], {
              icon: icon
            }).addTo(map);

            //let marker = L.marker([latFloat,lngFloat]).addTo(map);
            marker.on('mouseover',function(e){

              let routeInfoArray = ((routesArray[i])[0]);
              let routeNumber = routeInfoArray[0];
              let routeCost = routeInfoArray[1];
              let routeDescription = routeInfoArray[2];
              let message = "<b>Ruta número: " + routeNumber + "</b>" +
              "<br> <b>Descripción de la ruta: " + routeDescription + "</b>" +
              "<br> <b>Costo del pasaje: " +routeCost + "</b>" +
              "<br> <b>Tipo de Punto: " + type;
              marker.bindPopup(message).openPopup();
            //  marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
            });

            polylinePoint = [latFloat,lngFloat];
            polylineArray.push(polylinePoint);
            pointsReady.push(L.latLng(latFloat,lngFloat));

          }
          let color;
          let r = Math.floor(Math.random() * 255);
          let g = Math.floor(Math.random() * 255);
          let b = Math.floor(Math.random() * 255);
          color = "rgb("+r+" ,"+g+","+ b+")";

          let polyline = L.polyline(polylineArray,{color:color}).addTo(map);
          polylineArray = [];
          /*
          L.Routing.control({
            waypoints: pointsReady,
            routeWhileDragging: true
          }).addTo(map);
          waypoints = [];
          */
        }
      }

      window.onload = function(){

        // Consulta 1 y 2
        let buttonQueryAllRoutes = document.getElementById("buttonQueryAllRoutes");
        buttonQueryAllRoutes.onclick = function(){

          let selectQueryAllRoutes = document.getElementById("selectQueryAllRoutes");
          let enterpriseName = selectQueryAllRoutes.options[selectQueryAllRoutes.selectedIndex].text;
          let enterpriseID = selectQueryAllRoutes.options[selectQueryAllRoutes.selectedIndex].value;

          let data = {
            queryNumber:1,
            enterpriseName:enterpriseName,
            enterpriseID:enterpriseID
          };

          let xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange  = function(){
            if(this.readyState == 4 && this.status == 200){
               //alert(xhttp.responseText)
               let routesResponse = JSON.parse(xhttp.responseText);
               drawRoutes(routesResponse);

            }
          }
          xhttp.open("POST","queryHandler.php",true);
          xhttp.setRequestHeader("Content-type", "application/json");
          xhttp.send(JSON.stringify(data));
        };

        let buttonQueryByDestiny = document.getElementById("buttonQueryByDestiny");
        buttonQueryByDestiny.onclick = function(){
          let destiny = document.getElementById("inputQueryByDestiny").value;
          let data = {
            destiny:destiny,
            queryNumber:3
          };
          let xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange  = function(){
            if(this.readyState == 4 && this.status == 200){
               let routesResponse = JSON.parse(xhttp.responseText);
               drawRoutes(routesResponse);
            }
          }
          xhttp.open("POST","queryHandler.php",true);
          xhttp.setRequestHeader("Content-type", "application/json");
          xhttp.send(JSON.stringify(data));
        }

        let buttonQueryInCommon = document.getElementById("buttonQueryInCommon");
        buttonQueryInCommon.onclick = function(){

          let data = {
            queryNumber:4
          };

          let xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
              let routesResponse = JSON.parse(xhttp.responseText);
              checkPointsInCommon(routesResponse);
              console.log(routesResponse);
            }
          }
          xhttp.open("POST","queryHandler.php",true);
          xhttp.setRequestHeader("Content-type", "application/json");
          xhttp.send(JSON.stringify(data));
        }


      }

    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
