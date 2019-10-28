window.onload = function(){

  let osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
  osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  osm = L.tileLayer(osmUrl, {maxZoom:40 , attribution: osmAttrib});

  let OpenStreetMap_HOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
   maxZoom: 19,
   attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a> hosted by <a href="https://openstreetmap.fr/" target="_blank">OpenStreetMap France</a>'
 });
 let urlString = window.location.href;
 let url = new URL(urlString);
 let lat = url.searchParams.get("lat");
 let lng = url.searchParams.get("lng");
 let name = url.searchParams.get("name");
 let latF = parseFloat(lat);
 let lngF = parseFloat(lng);

 let map = L.map('map').setView([latF, lngF], 17).addLayer(OpenStreetMap_HOT);
 let marker = new L.Marker([latF,lngF],{draggable:false});
 map.addLayer(marker);

 let h3 = document.getElementById("nameh3");
 h3.innerText  = "Ubicación de " + name;


}
