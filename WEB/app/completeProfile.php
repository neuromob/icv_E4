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
    <title>ICV | Compléter son profil</title>

    <style type="text/css">
        #map {    
            width: 92%;
            height: 350px;
            margin-top: 10px;
        }
        </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/home.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4wS9TPSIExN2MI6WvJMk8-o6CqXEeTC4&language=en&libraries=places"></script>
  </head>
    <!-- AIzaSyApoxRTKTHp7APEAuxXKxthbgCYnl5JH7E -->
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
        <li>
          <a href="accueil.php">
            <i class="far fa-list-alt" aria-hidden="true"></i>
            <span>Liste des trajets</span>
          </a>
        </li>
        <li>
          <a href="newTrajet.php">
            <i class="fa fa-map-pin" aria-hidden="true"></i>
            <span>Proposer un trajet</span>
          </a>
        </li>
        <li>
          <a href="trajets.php">
            <i class="fa fa-car" aria-hidden="true"></i>
            <span>Trajets publiés</span>
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
          <h1 class="title">Compléter son profil</h1>
        </div>
        <div class="content-box">
            <p style="font-size: 13px;">Voici l'espace qui vous permet de compléter votre profil rentrer dans le système d'inscritption au covoiturage. 
                Vous pouvez proposer un trajet vous permettant de trouver des covoitureur recherchant le même trajet que vous. Ou bien en trouver un, vous permettant de rechercher un covoitureurs potentiels et 
                rentrer en contact avec lui par votre e-mail d'inscritption. 
            </p>
            <p style="font-size: 13px;">Tout apprentis a le droit à refuser de compléter son profil depuis l'accueil.
            </p>
            <fieldset class="fieldset-block-itineraire">
                <div class="header-fieldset">
                    <h2>Itinéraire</h2>
                </div>
                <div id="type_Trajet">
                    <h2 class="title-itineraire">Veuillez indiquer si vous recherchez ou proposer un trajet (ou les deux)</h2>
                    <label for="type-inscription">Type d'inscription : </label>
                    <select type="text" name="type-inscription" class="input-box" required>
                        <option value="">--Veuillez compléter votre choix--</option>
                        <option value="recherche">Je recherche</option>
                        <option value="pertuis">Je propose</option>
                        <option value="pertuis">Les deux</option>
                    </select>
                </div>
                <div id="lieu_Depart">
                    <h2 class="title-itineraire">Veuillez choisir un lieu de départ</h2>
                    <p class="description-help">Cliquez sur la carte pour sélectionner votre lieu de départ. Faites glisser le marqueur pour changer d'emplacement.</p>
                    
                    <!--map div-->
                    <div id="map"></div>
                    
                    <!--our form-->
                    <form method="post" style="margin-top:15px">
                        <label>Lieu de départ : </label>
                        <p class="description-help">Rechercher votre addresse dans la barre ci-dessous ou sélectionner un lieu prédéfini.</p>
                        <div class="button-input">
                            <input type="textbox" id="adresse-marker" required>
                            <button type="button" class="btn button-valide" onclick="convertAddress()">Confirmer</button>
                        </div>
                        <div class="lieu-depart-cfa">
                            <label style="margin-top: 17px;">Ou </label>
                            <input type="checkbox" id="predefini_checkbox"/>
                        <select type="text" name="lieuDepart_predefini" class="input-box" id="lieuDepart_predefini" disabled>
                            <option value="default">--Veuillez choisir un lieu prédéfini--</option>
                            <option value="avignon">Site d'Avignon</option>
                            <option value="pertuis">Site de Pertuis</option>
                        </select>
                        </div>
                        <label for="heure-depart">Heure de départ :</label>
                        <input type="time" name="heure-depart" min="8:00" max="19:00" required/>
                        <label>Jour(s) de départ : </label>
                        <div id="jour-semaine">
                            <div id="jour-lundi" class="item-jour">
                                <input type="checkbox" id="lundi" name="scales">
                                <label for="lundi">Lundi</label>
                            </div>
                            <div id="jour-mardi" class="item-jour">
                                <input type="checkbox" id="mardi" name="scales">
                                <label for="mardi">Mardi</label>
                            </div>
                            <div id="jour-mercredi" class="item-jour">
                                <input type="checkbox" id="mercredi" name="scales">
                                <label for="mercredi">Mercredi</label>
                            </div>
                            <div id="jour-jeudi" class="item-jour">
                                <input type="checkbox" id="jeudi" name="scales">
                                <label for="jeudi">Jeudi</label>
                            </div>
                            <div id="jour-vendredi" class="item-jour">
                                <input type="checkbox" id="vendredi" name="scales">
                                <label for="vendredi">Vendredi</label>
                            </div>
                            
                        </div>
                        
                    </form>
                    
                    <script type="text/javascript" src="../js/map.js"></script>
                </div>
                <div id="lieu_Arrivee">
                    <h2 class="title-itineraire">Veuillez choisir un lieu d'arrivée</h2>
                    <label>Lieu d'arrivée</label>
                    <select type="text" name="lieuDépart" class="input-box"value="Lieu d'arrivée'" required>
                        <option value="">--Veuillez choisir un lieu d'arrivée--</option>
                        <option value="avignon">Site d'Avignon</option>
                        <option value="pertuis">Site de Pertuis</option>
                    </select>
                </div>
                <div id="info-itineraire">
                    <label for="select-aller-retour">Aller-retour :</label>
                    <p class="description-help">Si vous choissisez l'option aller-retour cela signifie que vous souhaitez repartir avec le covoitureur le soir pour qu'il vous laisse au lieu de départ.</p>
                    <div class="button-input">
                        <select type="text" id="select-aller-retour" name="select-aller-retour" class="input-box" required>
                        <option value="inscription-oui">Aller-retour</option>
                        <option value="inscription-non">Aller simple</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <button type="button" id="ajouter-itineraire"></button>
            <button type="button" style="width: 100%" class="btn button-valide" onclick="window.location.href='#'">Valider</button>
        </div>
      </div>
    </div>
    <script src="../js/index.js"></script>
  </body>

</html>