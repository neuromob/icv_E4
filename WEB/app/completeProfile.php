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
          <h1 class="title">Compléter son profil</h1>
        </div>
        <div class="content-box">
            <p style="font-size: 13px;">Voici l'espace qui vous permet de compléter votre profil rentrer dans le système d'inscritption au covoiturage. 
                Vous pouvez proposer un trajet vous permettant de trouver des covoitureur recherchant le même trajet que vous. Ou bien en trouver un, vous permettant de rechercher un covoitureurs potentiels et 
                rentrer en contact avec lui par votre e-mail d'inscritption. 
            </p>
            <p style="font-size: 13px;">Tout apprentis a le droit à refuser de compléter son profil depuis <a href="accueil.php">l'accueil</a>.
            </p>
            <fieldset class="fieldset-block-itineraire">
                <div class="header-fieldset">
                    <h2>Itinéraire</h2>
                </div>
                <form action='valideProfil.php' method="post">
                <div id="type_Trajet">
                    <h2 class="title-itineraire">Veuillez indiquer si vous recherchez ou proposer un trajet (ou les deux)</h2>
                    <label for="type-inscription">Type d'inscription : </label>
                    <select type="text" id="type-inscription" name="type-inscription" class="input-box" required>
                        <option value="">--Veuillez compléter votre choix--</option>
                        <option value="recherche">Je recherche</option>
                        <option value="propose">Je propose</option>
                        <option value="both">Les deux</option>
                    </select>
                </div>
                <div id="type-inscription-propose">
                  <p>Rendez-vous section "publier une annonce" en cliquant sur le bouton validé qui mettra votre profil à jour en tant que conducteur.</p>
                </div>
                <div id="type-inscription-recherche">
                  
                    <div id="lieu_Depart">
                        <h2 class="title-itineraire">Veuillez choisir un lieu de départ</h2>
                        <p class="description-help">Cliquez sur la carte pour sélectionner votre lieu de départ. Faites glisser le marqueur pour changer d'emplacement.</p>
                        
                        <!--map div-->
                        <div id="map"></div>
                        
                        <!--our form-->
                            <label>Lieu de départ : </label>
                            <p class="description-help">Rechercher votre addresse dans la barre ci-dessous ou sélectionner un lieu prédéfini.</p>
                            <div class="button-input">
                                <input type="textbox" name="lieuDepartMap" id="adresse-marker" required>
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
                            <div class="grid-horaire">
                              <label for="heure-depart-cp-profile">Heure départ :</label>
                              <select type="text" name="heure-depart-cp-profile">
                                <option value="00">00</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                              </select>
                              <p>h</p>
                              <select type="text" name="minute-depart-cp-profile">
                                <option value="00">00</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                              </select>
                            </div>
                            <label>Jour(s) de départ : </label>
                            <div id="jour-semaine" class="disable">
                                <div id="jour-lundi" class="item-jour">
                                    <input type="checkbox" id="lundi" name="scales" disable>
                                    <label for="lundi">Lundi</label>
                                </div>
                                <div id="jour-mardi" class="item-jour">
                                    <input type="checkbox" id="mardi" name="scales" disable> 
                                    <label for="mardi">Mardi</label>
                                </div>
                                <div id="jour-mercredi" class="item-jour">
                                    <input type="checkbox" id="mercredi" name="scales" disable>
                                    <label for="mercredi">Mercredi</label>
                                </div>
                                <div id="jour-jeudi" class="item-jour">
                                    <input type="checkbox" id="jeudi" name="scales" disable>
                                    <label for="jeudi">Jeudi</label>
                                </div>
                                <div id="jour-vendredi" class="item-jour">
                                    <input type="checkbox" id="vendredi" name="scales" disable>
                                    <label for="vendredi">Vendredi</label>
                                </div>
                            </div>
                            
                        <script type="text/javascript" src="../js/map.js"></script>
                    </div>
                    <div id="lieu_Arrivee">
                        <h2 class="title-itineraire">Veuillez choisir un lieu d'arrivée</h2>
                        <label>Lieu d'arrivée</label>
                        <select type="text" name="lieuArrivee" class="input-box"value="Lieu d'arrivée'" required>
                            <option value="">--Veuillez choisir un lieu d'arrivée--</option>
                            <option value="Site d'Avignon">Site d'Avignon</option>
                            <option value="Site de Pertuis">Site de Pertuis</option>
                        </select>
                    </div>
                    <div class="grid-horaire">
                      <label for="heure-arrivee-cp-profile">Heure arrivée :</label>
                      <select type="text" name="heure-arrivee-cp-profile">
                        <option value="00">00</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                      </select>
                      <p>h</p>
                      <select type="text" name="minute-arrivee-cp-profile">
                        <option value="00">00</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                      </select>
                    </div>
                    <div id="info-itineraire">
                        <label for="select-aller-retour">[INDISPONIBLE] Aller-retour :</label>
                        <p class="description-help">Si vous choissisez l'option aller-retour cela signifie que vous souhaitez repartir avec le covoitureur le soir pour qu'il vous laisse au lieu de départ.</p>
                        <div class="button-input">
                            <select type="text" id="select-aller-retour" name="select-aller-retour" class="input-box  disable" disabled>
                            <option value="inscription-oui">Aller-retour</option>
                            <option value="inscription-non">Aller simple</option>
                            </select>
                        </div>
                    </div>
                    <button id="validate-profil" type="submit" style="width: 100%" class="btn button-valide">Valider</button>
                  </form>
                </div>
            </fieldset>
            
        </div>
      </div>
    </div>
    <script src="../js/index.js"></script>
  </body>

</html>