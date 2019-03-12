var map; //variable objet map
var marker; //variable objet marker
var depart;
var arrivee;
        
//Fonction appelée pour initialiser / créer la carte.
//Ceci est appelé lorsque la page est chargée.
function initMap() {

    var centerOfMap = new google.maps.LatLng(43.94781243695963, 4.80991138078582);
    var gmap = new google.maps.Map(document.getElementById('maprecap'), {
        zoom: 10, //le zoom de départ
        center: centerOfMap, //le centre de la map au chargement
        mapTypeId: google.maps.MapTypeId.ROADMAP, //le type de map, ROADMAP correspond à la version par défaut des versions précédentes
        streetViewControl: false, //si on souhaite désactiver les contrôle StreetView
        panControl: false //si on souhaite masquer les contrôles de déplacement
      });
    //Options de la map.
    var options = {
        zoom: 10, //le zoom de départ
        center: centerOfMap, //le centre de la map au chargement
        mapTypeId: google.maps.MapTypeId.ROADMAP, //le type de map, ROADMAP correspond à la version par défaut des versions précédentes
        streetViewControl: false, //si on souhaite désactiver les contrôle StreetView
        panControl: false //si on souhaite masquer les contrôles de déplacement
    };
    

    var polyline = new google.maps.Polyline({
        strokeColor: '#2222FF', //on définit la couleur
        strokeOpacity: 0.5, //l'opacité
        strokeWeight: 3, //l'épaisseur du trait,
        map: gmap //la map à laquelle rattacher la polyline
      });

    //on peut extraire un objet renfermant tous les points d'une Polyline
    //cet objet nous sera utile pour calculer la distance de l'itinéraire
    var path = polyline.getPath();

    //bounds renferme les limites de la map
    var bounds = new google.maps.LatLngBounds();

    //Créer l'objet de la carte.
    map = new google.maps.Map(document.getElementById('maprecap'), options);
         
    
    marker.setPosition(clickedLocation);
    map.setCenter(clickedLocation);

    newPosition = initDepartArrivee();
    var newCenter = newPosition[0];
    gmap.setCenter(newCenter);

    //...et on pose un marqueur dessus
    new google.maps.Marker({
      position: newCenter,
      map: gmap
    });

    //on ajoute le nouveau point à notre path, le Polyline associé se met automatiquement à jour
    path.push(newCenter);

    //on affiche la longueur du path dans notre div
    //c'est ici qu'intervient la librairie Geometry, qui va gérer automatiquement tous les calculs nécessaires

    var pathLength = parseInt(google.maps.geometry.spherical.computeLength(path)) / 1000;
    //computeLength nous renvoie des mètres que l'on transforme en kilomètres
    console.log(pathLength);
    //on étend la zone "bounds" en lui demandant d'inclure le nouveau point
    bounds.extend(newCenter);
    //on demande en suite à la map de s'adapter à cette zone
    gmap.fitBounds(bounds);
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

function initDepartArrivee() {
    startLat = 43.94781243695963;
    startLng = 4.80991138078582;
    endLat = 64.94781243695963;
    endLng = 8.80991138078582;
    depart = new google.maps.LatLng(startLat, startLng);
    arrivee = new google.maps.LatLng(endLat, endLng);
    return [depart, arrivee];
}
 
//Cette fonction permet d'obtenir l'emplacement actuel du marqueur, puis convertit la position lat/lng en addresse à l'aide la
//fonction convertLngLat
function markerLocation(){
    //Get location.
    var currentLocation = marker.getPosition();
    
    //Convertit location -> adresse string
    convertLngLat(currentLocation.lat(),currentLocation.lng());
}
     
//Charger la carte une fois le chargement de la page terminé.
google.maps.event.addDomListener(window, 'load', initMap);