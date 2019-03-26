<?php
include "../php/sessionIsStarted.php";
include '../class/user.class.php';
include '../php/function.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

$dbh = new DBHandler();
$user = unserialize((base64_decode($_SESSION['userObject'])));
$user = $dbh->refreshUser($user->getId());
$user_serlizer = base64_encode(serialize($user));
$_SESSION['userObject'] = $user_serlizer;
$idUser = $user->getId();
$listTrip = $dbh->getListTrip($idUser);
if($_POST["rangeTrips"]){
  $rangeTrip = $_POST["rangeTrips"];
} else {
  $rangeTrip = 50;
}


?>
<!DOCTYPE html>
<html lang="en" >

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <title>ICV | Accueil</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  </head>
    <!-- AIzaSyApoxRTKTHp7APEAuxXKxthbgCYnl5JH7E -->
  <body>
    <ul class="topNav">
      <li style="float:left"><?php echo "<p class='bvn_Message' style='margin-left:70px'>Bonjour ". $user->getNom() ."</p>"; ?></li>
      <li><a href="../php/logout.php">Déconnexion</a></li>
      <li><input type="text" class="disable" placeholder="Trouver un nouveau trajet" disable></li>
      
      
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
          <h1 class="title">Profil</h1>
        </div>
        <div class="content-box">
        <a href="#" style="float:right;margin-top: -7px;" onclick="window.location.href='parametres.php'">Modifier mon profil</a>
          <div class="grid-info">
            <?php 
              echo "<p class='p-info-profil'><svg class='img-icon-profil' xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 192 192' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,192v-192h192v192z' fill='none'></path><g fill='#153439'><g id='surface1'><path d='M96,0c-35.34375,0 -64,28.65625 -64,64c0,35.34375 28.65625,64 64,64c35.34375,0 64,-28.65625 64,-64c0,-35.34375 -28.65625,-64 -64,-64zM53.25,85.25h85.5c-7.875,15.75 -23.9375,26.75 -42.75,26.75c-18.8125,0 -34.875,-11 -42.75,-26.75zM59,139c-23.8125,6.25 -42.4375,21.125 -51,53h176c-8.5625,-31.875 -27.1875,-46.75 -51,-53c-11.03125,5.90625 -23.625,9.25 -37,9.25c-13.375,0 -25.96875,-3.34375 -37,-9.25z'></path></g></g></g></svg> ". $user->getNom() ." ".$user->getPrenom()."</p>";
              echo "<p class='p-info-profil'><svg class='img-icon-profil' xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 192 192' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,192v-192h192v192z' fill='none'></path><g fill='#153439'><g id='surface1'><path d='M0,24v144h192v-144zM16,40h160v17.5l-80,40l-80,-40zM16,75.5l76.5,38l3.5,1.75l3.5,-1.75l76.5,-38v76.5h-160z'></path></g></g></g></svg> ". $user->getEmail() ."</p>";
              echo "<p class='p-info-profil'><svg class='img-icon-profil' xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 192 192' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,192v-192h192v192z' fill='none'></path><g fill='#153439'><g id='surface1'><path d='M96,31.25l-2,1.25l-92,56l4,7l90,-54.75l90,54.75l4,-7l-30,-18.25v-38.25h-16v28.5l-46,-28zM96,52l-80,48v92h160v-92zM72,104h48v72h-48z'></path></g></g></g></svg> ". $user->getAdresse() ."</p>";
              echo "<p class='p-info-profil'><svg class='img-icon-profil' xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 192 192' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,192v-192h192v192z' fill='none'></path><g fill='#153439'><g id='surface1'><path d='M176,68.8125c0,-44 -30.40625,-68.8125 -76.8125,-68.8125c-46.375,0 -67.1875,24.8125 -67.1875,60c0,5.59375 3.1875,7.1875 0.8125,12.8125c-5.625,9.59374 -12,24.78125 -14.40626,29.59374c-2.40625,5.59375 1.59375,8.78126 5.59375,9.59375c4.8125,1.59375 6.40625,2.40625 10.40625,3.1875c0.78126,11.21874 -4.8125,17.625 3.1875,20c-3.1875,7.21874 3.21875,8 6.40625,12.8125c3.1875,4.8125 0.8125,16.8125 5.59375,21.59375c9.59375,8.8125 29.59375,0.8125 29.59375,18.40625v4h74.40625c0,-24.8125 -0.78125,-46.40625 3.21875,-61.59375c4.78125,-14.40625 19.1875,-33.59374 19.1875,-61.59374zM112,144h-16v-16h16zM112,114.40625h-16c0,-12 4.8125,-20 10.40625,-27.21874c4.78126,-5.59375 8.78126,-10.375 11.1875,-13.59375c2.40625,-3.1875 3.21875,-7.1875 3.21875,-12c0,-5.59375 -1.625,-9.59375 -4,-12.78125c-3.21875,-3.21875 -7.21875,-4.8125 -12.8125,-4.8125c-4.8125,0 -8.8125,1.59375 -12,4c-3.1875,2.40625 -4.8125,6.40625 -4.8125,11.1875h-15.1875v-0.78126c0,-8 2.40625,-15.21874 8.8125,-20c6.375,-4 13.59374,-6.40625 23.1875,-6.40625c10.40625,0 18.40625,2.40625 24,8c4.8125,4.8125 8,12 8,21.59375c0,24.8125 -24,32.8125 -24,52.8125z'></path></g></g></g></svg>". $user->getRole() ."</p>";
            ?>
          </div>
          <label>Voulez-vous participez au système de co-voiturage ?</label>
          <div class="button-input">
            <select type="text" id="select-inscription" name="type-inscription" class="input-box" required>
              <option value="inscription-oui">Oui</option>
              <option value="inscription-non">Non</option>
            </select>
            <button type="button" id="btn-complete-profil" class="btn button-valide" onclick="window.location.href='completeProfile.php'">Compléter son profil</button>
          </div>
          <div class="grid-profile-passager">
            <?php
              echo "<p class='p-info-profil'><svg class='img-icon-profil' xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 192 192' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,192v-192h192v192z' fill='none'></path><g fill='#153439'><g id='surface1'><path d='M96,0l-88,192l88,-21.5l88,21.5zM96,37.5v117l-4,0.75l-56,13.5z'></path></g></g></g></svg>". $user->getLieuDepart()."</p>";
              echo "<svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px'width='56' height='56' viewBox='0 0 224 224' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,224v-224h224v224z' fill='none'></path><g fill='#153439'><g id='surface1'><path d='M112,31.79167v52.20833h-111.125v56h111.125v52.20833l112,-80.20833z'></path></g></g></g></svg>";
              echo "<p class='p-info-profil'><svg class='img-icon-profil' xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 192 192' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,192v-192h192v192z' fill='none'></path><g fill='#153439'><g id='surface1'><path d='M96,0l-88,192l88,-21.5l88,21.5zM96,37.5v117l-4,0.75l-56,13.5z'></path></g></g></g></svg>". $user->getLieuArrivee()."</p>";
            ?>
          </div>
          
          
          
          
         
        </div>
      </div>
      <div id="listeTrajets" class="box shadow">
        <div class="header-box">
          <h1 class="title">Liste des trajets disponibles</h1>
        </div>
        
        <div class="list-group">
        <p class="description-help" style="text-align:center;margin: 5px 0 -24px;">Une liste de trajets des covoitureurs autour de chez vous est généré selon votre profil!</p>
        <form action="" method="POST" style="margin: 1px 14px 3px"> 
          <input type="range" style="vertical-align: bottom" class="range" name="rangeTrips" min="0" max="1000" step="1" value="<?= $rangeTrip ?>"/>
          <output name="result2"><?= $rangeTrip ?> km</output>
          <input type="submit" value="Valider" />
        </form>
        <?php
        if($listTrip["response"] == "KO"){
          echo "<p style='text-align:center'>Aucun trajets n'est disponible pour vous. Veuillez patienter que des utilisateurs proposent de nouveaux trajets pour 
          rentrer en contact avec eux et réserver de nouveaux voyages !</p>";
        } else {
          //echo distanceBetween(43.690407,5.500641,43.285102,5.371231);
          for($i=0;$i<count($listTrip);$i++) {
            $placeDisponible = 0;
            //$infoDistance = $dbh->getDistanceBetweenPoint($listTrip[$i]['villeDepart'],$listTrip[$i]['villeArrivee']);
            //$infoDistance = json_decode($infoDistance, true);
            $infoDistance = distanceBetween($user->getLatitude(),$user->getLongitude(),$listTrip[$i]["latitudeDepart"],$listTrip[$i]["longitudeDepart"]);
            
            if($infoDistance < $rangeTrip) {
              $newDate = date("d-m-Y", strtotime($listTrip[$i]["dateParcours"]));
              $infoConducteur = $dbh->getVehicle($listTrip[$i]["idConducteur"]);
              $idTrajet = $listTrip[$i]["idTrajet"];
              $nbPersonneInscrit = $dbh->getPlaceDispo($idTrajet);
              
              $nbInscrit = intval($nbPersonneInscrit["placeDisponible"]);
              $nbTotal = intval($listTrip[$i]["placeDisponible"]);
              $placeDisponible = $nbTotal - $nbInscrit;
  
              echo "<button type='button' class='collapse'>
                      <p class='creator-trip'>"
                      . $infoConducteur["nom"]." ".$infoConducteur["prenom"]. "<br><br> <span class='info-distance'>Le point de départ est à " . $infoDistance . " km</span>" .
                      "</p>"
                      . $listTrip[$i]['villeDepart'] . " &#x2794; ". $listTrip[$i]['villeArrivee'] .
                      "<br>"
                      .$listTrip[$i]["heureDepart"]." &#x2794; ". $listTrip[$i]["heureArrivee"] .
                      "<br>"
                      .
                      //$infoDistance["rows"][0]["elements"][0]["distance"]["text"].
                      "<p class='date-trip'>". $newDate ."</p>
                    </button>";
              echo "<div class='content'><ul>";
              echo "<li>Nom de l'élève : ". $infoConducteur["nom"]." ".$infoConducteur["prenom"]."</li>";
              echo "<li>Date : ". $listTrip[$i]["dateParcours"] ."</li>";
              echo "<li>Heure de départ : ". $listTrip[$i]["heureDepart"] ."</li>";
              echo "<li>Heure d'arrivée : ". $listTrip[$i]["heureArrivee"] ."</li>";
              echo "<li>Marque : ". $infoConducteur["marque"] ."</li>";
              echo "<li>Modèle : ". $infoConducteur["modele"] ."</li>";
              echo "<li>Couleur : ". $infoConducteur["couleur"] ."</li>";
              echo "<li>Nombre de place : ". $placeDisponible ." / ".$nbTotal."</li>";
              echo "</ul>";
    
              echo "<form method='post' action='reserve.php'><input name='tripToReserve' value=".$idTrajet." hidden/>
              <button type='submit' class='btn button-valide'>Réserver</button>
              
              </form></div>";
            }
          }
        }
        
        
        ?>
        </div>
      </div>
    </div>
    <script src="../js/index.js"></script>
  </body>

</html>