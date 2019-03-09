<?php
include "../php/sessionIsStarted.php";
include '../class/user.class.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$dbh = new DBHandler();
$user = unserialize((base64_decode($_SESSION['userObject'])));
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width" />
  <title>ICV | Accueil</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/home.css">
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      table-layout:auto;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    td {
      margin-left: 10px;
      padding-left: 1em;
    }

    tr:hover {background-color:#f5f5f5;}
  </style>
      
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
</head>

<body>
  <ul class="topNav">
    <li style="float:left"><?php echo "<p class='bvn_Message' style='margin-left:5em'>Bonjour ". $user->getNom() ."</p>"; ?></li>
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
      <li>
        <a href="newTrajet.php">
          <i class="fa fa-plus" aria-hidden="true"></i>
          <span>Proposer un trajet</span>
        </a>
      </li>
      <li class="active">
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
        <h1 id='title-trip' class="title">Trajets et réservations</h1>
      </div>
      <div class="content-box">
        <div class="btn-group">
          <button type="button" data-section="trip-publied" class="button-content button-active">Trajets publiés</button>
          <button type="button" data-section="trip-reserved" class="button-content">Trajets reservés</button>
          <button type="button" data-section="trip-archived" class="button-content">Trajets archivés</button>
        </div>
        <div class="content-section default-content" id="trip-publied">
          <?php
          $listOfCreatedTrip = $dbh->getMyListOfCreatedTrips($user->getId());
          $lengthCreatedTrip = count($listOfCreatedTrip);
              echo $placeDisponible["placeDisponible"];
          if($lengthCreatedTrip >= 1){
            if($_GET["modifyMode"] == 1){
              echo "<table>
              <tr>
                <th>Date</th>
                <th>Heure départ</th>
                <th>Heure arrivée</th>
                <th>Lieu de départ</th>
                <th>Lieu d'arrivée</th>
                <th>Place disponible</th>
                <th>Status</th>
                <th>Action</th>
              </tr>";
              
            }else {
              echo "<table>
              <tr>
                <th>id</th>
                <th>Date</th>
                <th>Heure départ</th>
                <th>Heure arrivée</th>
                <th>Lieu de départ</th>
                <th>Lieu d'arrivée</th>
                <th>Place disponible</th>
                <th>Status</th>
                <th>Action</th>
              </tr>";
              for($i=0;$i<$lengthCreatedTrip;$i++) { 
                /* $listOfCreatedTrip[$i]["placeDisponible"] = colonne placeDisponible (table 'Trajet') : Place proposé lors de la création d'un trajet
                  * $nbPersonneInscrit["placeDisponible"] = nombre de colonnne trajet (table 'Reservation') présente selon un id de trajet donné (ici boucle
                  sur toute les jeux de résultats de listOfCreatedTrip).
                  * Soustraction du nombre de place disponible (place proposé) moins le nombre de personnes étant inscrit au trajet pour
                  * connaitre le nombre de place restant.
                  */
                  $nbPersonneInscrit = $dbh->getPlaceDispo($listOfCreatedTrip[$i]["id"]);
                  $placeDisponible = 0;
                  $nbInscrit = intval($nbPersonneInscrit["placeDisponible"]);
                  $nbTotal = intval($listOfCreatedTrip[$i]["placeDisponible"]);
                  $placeDisponible = $nbTotal - $nbInscrit ;

                echo "<tr>
                <td>".$listOfCreatedTrip[$i]["id"]."</td>
                <td>".$listOfCreatedTrip[$i]["dateParcours"]."</td>
                <td>".$listOfCreatedTrip[$i]["heureDepart"]."</td>
                <td>".$listOfCreatedTrip[$i]["heureArrivee"]."</td>
                <td>".$listOfCreatedTrip[$i]["villeDepart"]."</td>
                <td>".$listOfCreatedTrip[$i]["villeArrivee"]."</td>
                <td style='text-align:center'>". $placeDisponible ." / ". $listOfCreatedTrip[$i]["placeDisponible"] ."</td>
                <td>".$listOfCreatedTrip[$i]["status"]."</td>
                <td>
                <form action='stopTrajet.php' method='post'><input name='idPersonnalTrip' value=". $listOfCreatedTrip[$i]['id'] ." hidden/>
                <button type='button' onclick=\"window.location.href='trajets.php?modifyMode=1'\" style='padding: 3px 5px 5px;height: 25px' type='button' class='btn button-modify disable' disabled>Modifier</button>
                <button type='submit' style='padding: 3px 5px 5px;height: 25px' type='button' class='btn button-annuler'>Annuler</button></form></td>
                </tr>";
              }
              echo "</table>";
            }
          } else {
            echo "<p>Vous n'avez aucun trajet prévu. </p>";
            echo "<p>Pour proposer un trajet, cliquez sur :</p>";
            echo "<button type='button' onclick=\"window.location.href='newTrajet.php'\" class='btn button-valide'>Proposer un trajet</button>";  
          }
          
          
          ?>
         </div>
        <div class="content-section" id="trip-reserved">
        <?php
          $listOfReservedTrip = $dbh->getListOfReservedTrips($user->getId());
          $lengthOfReservedTrip = count($listOfReservedTrip);
          if($lengthOfReservedTrip >= 1){
            echo "<table>
            <tr>
              <th>Date</th>
              <th>Heure départ</th>
              <th>Heure arrivée</th>
              <th>Lieu de départ</th>
              <th>Lieu d'arrivée</th>
              <th>Conducteur</th>
              <th>Voiture</th>
              <th>Action</th>
            </tr>";
            for($i=0;$i<$lengthOfReservedTrip;$i++) {
              echo "<tr>
              <td>".$listOfReservedTrip[$i]["dateParcours"]."</td>
              <td>".$listOfReservedTrip[$i]["heureDepart"]."</td>
              <td>".$listOfReservedTrip[$i]["heureArrivee"]."</td>
              <td>".$listOfReservedTrip[$i]["villeDepart"]."</td>
              <td>".$listOfReservedTrip[$i]["villeArrivee"]."</td>";
              $infoConducteur = $dbh->getAllInfo($listOfReservedTrip[$i]["idConducteur"]);
              echo "<td>".$infoConducteur["nom"]." ". $infoConducteur["prenom"] ."</td>
              <td>".$infoConducteur["marque"]." ". $infoConducteur["modele"] ." ". $infoConducteur["couleur"]. "</td>
              <td><form action='stopReservation.php' method='POST'><input name='idTrip' value=".$listOfReservedTrip[$i]["id"]." hidden/><input name='idConducteur' value=".$listOfReservedTrip[$i]["idConducteur"]." hidden/><button type='submit' style='padding: 3px 5px 5px;height: 25px' type='button' class='btn button-annuler'>Annuler</button></form></td>
              </tr>";
            }
            echo "</table>";
          } else {
            echo "<p>Vous n'avez aucun trajet reservé. </p>";
            echo "<p>Pour reservé un trajet, retournez à la liste des trajets dans l'accueil en cliquant ci-dessous :</p>";
            echo "<button type='button' onclick=\"window.location.href='accueil.php#listeTrajets'\" class='btn button-valide'>Rechercher un trajet</button>";  
          }
          
          
          ?>
        </div>
        <div class="content-section" id="trip-archived">
          <p>Retrouvez ici les anciens trajets que nous avons archivés.</p>
        </div>
      </div>
    </div>
    <!--./box-->
  </div>
  <!--./main-->
  
  

    <script  src="../js/index.js"></script>




</body>

</html>
