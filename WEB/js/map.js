

var map; //variable objet map
var marker; //variable objet marker
        
//Fonction appelée pour initialiser / créer la carte.
//Ceci est appelé lorsque la page est chargée.
function initMap() {

    var centerOfMap = new google.maps.LatLng(43.94781243695963, 4.80991138078582);
    //Options de la map.
    var options = {
      center: centerOfMap,
      zoom: 7
    };

    //Créer l'objet de la carte.
    map = new google.maps.Map(document.getElementById('map'), options);
	//on crée l'objet marker
    initMarker(centerOfMap);
    google.maps.event.addListener(map, 'click', function(event) {                
        //Obtenir l'emplacement sur lequel l'utilisateur a cliqué.
        var clickedLocation = event.latLng;
        //Si le marqueur n'a pas été ajouté.
        if(marker === false){
            //Créer le marqueur.
            marker = new google.maps.Marker({
                position: clickedLocation,
                map: map,
                draggable: true 
            });
            
            //Listen les événements de glisser-déposer !
            google.maps.event.addListener(marker, 'dragend', function(event){
                markerLocation();
            });
        } else{
            //Le marqueur a déjà été ajouté, alors change simplement son emplacement.
            marker.setPosition(clickedLocation);
        }
        //Get la position du marqueur.
        markerLocation();
    });
    
}
 
function initMarker(centerOfMap){
	marker = new google.maps.Marker({
        position: centerOfMap,
        map: map,
        draggable: true 
    });
    //Listen les événements de glisser-déposer !
    google.maps.event.addListener(marker, 'dragend', function(event){
        markerLocation();
    });
}
 
//Cette fonction permet d'obtenir l'emplacement actuel du marqueur, puis convertit la position lat/lng en addresse à l'aide la
//fonction convertLngLat
function markerLocation(){
    //Get location.
    var currentLocation = marker.getPosition();
    
    //Convertit location -> adresse string
    convertLngLat(currentLocation.lat(),currentLocation.lng());
}
function convertLngLat(markerLatitude, markerLongitude){
    var geocoder  = new google.maps.Geocoder();             // Créer objet geocoder
    var location  = new google.maps.LatLng(markerLatitude, markerLongitude);    // transformer les coordonnées en un objet      
    geocoder.geocode({'latLng': location}, function (results, status) {
        if(status == google.maps.GeocoderStatus.OK) {
        var add=results[0].formatted_address;         // si adresse trouvée, passer à la fonction de traitement
        console.log("add : "+add);
        document.getElementById('adresse-marker').value = add;

        document.getElementById("adresse-latitude").value = markerLatitude;
        document.getElementById("adresse-longitude").value = markerLongitude;
        }
    });
}

function convertAddress() {
    var geocoder;
    //var jqueryAddress = $("address").val();
    var address = document.getElementById("adresse-marker").value;
	geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        document.getElementById('adresse-marker').value = convertLngLat(results[0].geometry.location.lat(),results[0].geometry.location.lng());
        document.getElementById("adresse-latitude").value = results[0].geometry.location.lat();
        document.getElementById("adresse-longitude").value = results[0].geometry.location.lng();
        map.setCenter(results[0].geometry.location);
        map.setZoom(12);
        marker.setPosition(results[0].geometry.location);
      }
      else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}
        
//Charger la carte une fois le chargement de la page terminé.
google.maps.event.addDomListener(window, 'load', initMap);