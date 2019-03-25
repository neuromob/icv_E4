<?php
include "../php/sessionIsStarted.php";
include '../class/user.class.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$user = unserialize((base64_decode($_SESSION['userObject'])));
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width" />
  <title>ICV | Accueil</title>
  <style type="text/css">
        #maprecap {    
            width: 92%;
            height: 350px;
            margin-top: 10px;
        }
        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {
          padding: 8px;
          text-align: left;
          border-bottom: 1px solid #ddd;
        }

        tr:hover {background-color:#f5f5f5;}
        </style>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/home.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4wS9TPSIExN2MI6WvJMk8-o6CqXEeTC4&language=en&libraries=places"></script>

</head>

<body>
  <ul class="topNav">
    <li style="float:left"><?php echo "<p class='bvn_Message' style='margin-left:5em'>Bonjour ". $user->getNom()."</p>"; ?></li>
    <li><a href="../php/logout.php">Déconnexion</a></li>
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
      <li>
        <a href="accueil.php">
          <i class="far fa-list-alt" aria-hidden="true"></i>
          <span>Liste des trajets</span>
        </a>
      </li>
      <li class="active">
        <a href="newTrajet.php">
          <i class="fa fa-plus" aria-hidden="true"></i>
          <span>Proposer un trajet</span>
        </a>
      </li>
      <li>
        <a href="trajets.php">
          <i class="fa fa-book" aria-hidden="true"></i>
          <span>Trajets et réservations</span>
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
      <div class="box shadow">
        <div class="header-box">
          <h1 class="title">Publier une annonce</h1>
        </div>
        <div class="content-box">
          <fieldset class="fieldset-block-itineraire">
            <div class="header-fieldset">
              <h2>Récapitulatif</h2>
            </div>
            <form action="validation_newTrajet.php" id="recap">
              <?php 
              echo '<pre>';
              print_r($_POST);
              echo '</pre>';
              $dataUserTrip = array(
                'idUser' => $user->getId(),
                'placeDisponible' => intval($_POST["nbPlaces"]),
                'dateParcours' => $_POST["jour-aller"],
                'heureDepart' => "",
                'heureArrivee' => "",
                "lieu1" => "",
                "lieu2" => "",
                "latitude" => $_POST["latitude"],
                "longitude" => $_POST["longitude"]
              );
              //echo "<br>";
              if(isset($_POST["lieuDepart_predefini"])){
                $lieuDepart = $_POST["lieuDepart_predefini"];
                $dataUserTrip['lieu1'] =  $_POST["lieuDepart_predefini"];
              } else {
                //echo "Lieu départ : ". $_POST["lieuDepart_map"];
                $dataUserTrip['lieu1'] =  $_POST["lieuDepart_map"];
              }
              
              //echo "<br>";
              if(isset($_POST["parSemaine"])){
                echo "Période : Par semaines";
                echo "<br>";
                if(isset($_POST["lundi"])){
                  echo "Lundi\t";
                }
                if(isset($_POST["mardi"])){
                  echo "Mardi\t";
                }
                if(isset($_POST["mercredi"])){
                  echo "Mercredi\t";
                }
                if(isset($_POST["jeudi"])){
                  echo "Jeudi\t";
                }
                if(isset($_POST["vendredi"])){
                  echo "Vendredi\t";
                }
                echo "<br>";
                echo "Heure aller : ".$_POST["semaine-heure-aller"]." h ".$_POST["semaine-minute-aller"]."";
                echo "<br>";
                if($_POST["cb-aller-retour"] == "on") {
                  echo "Heure retour : ".$_POST["semaine-heure-retour"]." h ".$_POST["semaine-minute-retour"]."";
                }
              } else {
                //echo "Période : Par dates";
                //echo "<br>";
                //echo "Date aller : ".$_POST["jour-aller"];
                //echo "<br>";
                $heureDepart = $_POST["heure-aller"] . ":" . $_POST["minute-aller"] . ":00";
                //gettype($heureDepart);
                $dataUserTrip['heureDepart'] =  $heureDepart;
                //echo "Heure départ : " . $heureDepart;
                //echo "<br>";
                $heureArrivee = $_POST["heure-arrivee"] . ":" . $_POST["minute-arrivee"] . ":00";
                $dataUserTrip['heureArrivee'] =  $heureArrivee;
                //echo "Heure arrivée : " . $heureArrivee;
                //echo "<br>";
                if($_POST["cb-aller-retour"] == "on") {
                  echo "Date retour : ".$_POST["trip-retour"];
                  echo "<br>";
                  echo "Heure retour : ".$_POST["semaine-heure-retour"]." h ".$_POST["semaine-minute-retour"]."";
                }

              }
              //echo "<br>";
              //echo "Lieu arrivée : ". $_POST["lieuArrivee"];
              $dataUserTrip['lieu2'] =  $_POST["lieuArrivee"];
              
              /*echo "<br>";
              if($_POST["cb-aller-retour"] == "on"){
                echo "Aller-retour.";
              } else {
                echo "Aller simple.";
              }
              echo "<br>";
              echo "Véhicule : ". $_POST["vehicule"];
              echo "<br>";
              echo "Nombre de places proposés : ". $_POST["nbPlaces"];
              echo "<br>";*/

              echo "<table>
                <tr>
                  <th>Lieu départ</th>
                  <th>Lieu arrivée</th>
                  <th>Heure départ</th>
                  <th>Heure arrivée</th>
                  <th>Date</th>
                  <th>Véhicule</th>
                  <th>Place disponible</th>
                </tr>
                <tr>
                  <td>".$dataUserTrip['lieu1']."</td>
                  <td>".$dataUserTrip['lieu2']."</td>
                  <td>".$dataUserTrip['heureDepart']."</td>
                  <td>".$dataUserTrip['heureArrivee']."</td>
                  <td>".$dataUserTrip['dateParcours']."</td>
                  <td>".$_POST["vehicule"]."</td>
                  <td>".$dataUserTrip['placeDisponible']."</td>
                </tr></table>";
              $_SESSION["infoTrip"] = $dataUserTrip;
              ?>
              <button type="button" onclick="window.location.href='validation_newTrajet.php'" style="float:right" class="btn button-valide">Valider le trajet</button>
            </form>
          </fieldset>
        </div>
        <button type="button" onclick="window.location.href='newTrajet.php'" class="btn button-valide">Précédent</button>
        
      </div>
    </div>
    <script  src="../js/index.js"></script>




</body>

</html>
