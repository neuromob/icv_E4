<?php
include "../php/sessionIsStarted.php";
include '../class/user.class.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

$dbh = new DBHandler();
$user = unserialize((base64_decode($_SESSION['userObject'])));

$listTrip = $dbh->getListTrip();

?>
<!DOCTYPE html>
<html lang="en" >

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <title>ICV | Accueil</title>

    <style type="text/css">
          #map{ width:700px; height: 500px; }
        </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/home.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApoxRTKTHp7APEAuxXKxthbgCYnl5JH7E"></script>
  </head>

  <body>
    <ul class="topNav">
      <li style="float:left"><?php echo "<p class='bvn_Message' style='margin-left:70px'>Bonjour ". $user->getNom() ."</p>"; ?></li>
      <li><a href="../php/logout.php">Déconnexion</a></li>
      <li><input type="text" placeholder="Trouver un nouveau trajet"></li>
    </ul>
      
    <div class="leftMenu">
        <div class="hamburger active">
            <span></span>
            <span></span>
            <span></span>
          </div>
      
      <ul class="leftMenuList">
        <div class="header">
          <h3 id="title-header-menu">ICV</h3>
        </div>
        <li class="active">
          <a href="accueil.php">
            <i class="far fa-list-alt" aria-hidden="true"></i>
            <span>Liste des trajets</span>
          </a>
        </li>
        
        <li>
          <a href="trajets.php">
            <i class="fa fa-car" aria-hidden="true"></i>
            <span>Mes trajets</span>
          </a>
        </li>
        <li>
          <a href="newTrajet.php">
            <i class="fa fa-map-pin" aria-hidden="true"></i>
            <span>Créer un nouveau trajet</span>
          </a>
        </li>
        <li>
          <a href="parametres.php">
            <i class="fa fa-wrench" aria-hidden="true"></i>
            <span>Paramètres</span>
          </a>
        </li>
        <hr>
        <i id="message-leftMenu" style="color: gray">Messages</i>
        <li>
          <a href="messages.php">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <span>Mes messages</span>
          </a>
        </li>
      </ul>
    </div>
    
    <div class="main">
      <div id="profil" class="box shadow">
        <div class="header-box">
          <h1>Profil</h1>
          <label class="switch">
            <input type="checkbox" onclick="show_checked()" name="profile" checked>
            <span class="slider round"></span>
          </label>
        </div>
        <div class="content-box">
          <div id="lieu_Depart">
            <h2>Veuillez choisir un lieu de départ</h2>
            <p>Cliquez sur un emplacement sur la carte pour sélectionner votre lieu de départ. Faites glisser le marqueur pour changer d'emplacement</p>
            
            <!--map div-->
            <div id="map"></div>
            
            <!--our form-->
            <form method="post" style="margin-top:5px">
                <label>Latitude</label>
                <input type="text" id="lat" class="input-box" readonly="yes"><br>
                <label>Longitude</label>
                <input type="text" id="lng" class="input-box" readonly="yes">
            </form>
            
            <script type="text/javascript" src="../js/map.js"></script>
          </div>
          <div id="separator"></div>
          <div id="lieu_Arrivee">
            <h2>Veuillez choisir un lieu d'arrivée</h2>
            <label>Lieu d'arrivée</label>
            <select type="text" name="lieuDépart" class="input-box" value="Lieu d'arrivée'">
              <option value="">--Veuillez choisir un lieu d'arrivée--</option>
              <option value="avignon">Avignon</option>
              <option value="pertuis">Pertuis</option>
            </select>
          </div>
        </div>
      </div>
      <script>
      function show_checked(){
        if($('input[name=profile]').is(':checked')==true){
          $('#profil').removeClass("unactive");
        } else {
          $('#profil').addClass("unactive");
        }
      }
    </script>
      <div class="box shadow" style="margin-bottom: 5em;">
        <div class="header-box">
          <h1>Liste des trajets disponibles</h1>
        </div>
        
        <div class="list-group">
        <?php
        for($i=0;$i<count($listTrip);$i++) {
          echo "<button class='collapse'>". $listTrip[$i]['villeDepart'] . " &#x2794; ". $listTrip[$i]['villeArrivee'] ."<span style='text-align:right'>Hello</span></button>";
          echo "<div class='content'><ul>";
          echo "<li>Nom de l'élève : ". $listTrip[$i]["nom"]." ".$listTrip[$i]["prenom"]."</li>";
          echo "<li>Date : ". $listTrip[$i]["dateParcours"] ."</li>";
          echo "<li>Heure de départ : ". $listTrip[$i]["heureDepart"] ."</li>";
          echo "<li>Heure d'arrivée : ". $listTrip[$i]["heureArrivee"] ."</li>";
          echo "<li>Marque : ". $listTrip[$i]["marque"] ."</li>";
          echo "<li>Modèle : ". $listTrip[$i]["modele"] ."</li>";
          echo "<li>Couleur : ". $listTrip[$i]["couleur"] ."</li>";
          echo "<li>Nombre de place : ". $listTrip[$i]["place"] ."</li>";
          echo "<li>Nombre de place restante : ". $listTrip[$i]["placeDisponible"] ."</li>";
          echo "</ul></div>";
          
        }
        
        ?>
        </div>
      </div>
    </div>
    <script src="../js/index.js"></script>
  </body>

</html>