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
          <form action="recap_newTrajet.php" method="post">
            <fieldset class="fieldset-block-itineraire">
              <div class="header-fieldset">
                  <h2>Itinéraire</h2>
              </div>
              <div id="lieu_Depart">
                <h2 class="title-itineraire">Veuillez choisir un lieu de départ</h2>
                <p class="description-help">Cliquez sur la carte pour sélectionner votre lieu de départ. Faites glisser le marqueur pour changer d'emplacement.</p>
                
                <!--map div-->
                <div id="map"></div>
                
                <!--our form-->
                    <label>Lieu de départ : </label>
                    <p class="description-help">Rechercher votre addresse de départ dans la barre ci-dessous ou sélectionner un lieu prédéfini.</p>
                    <div class="button-input">
                        <input type="textbox" name="lieuDepart_map" id="adresse-marker">
                        <input type="textbox" name='latitude' id="adresse-latitude" hidden>
                        <input type="textbox" name='longitude' id="adresse-longitude" hidden>
                        <button type="button" class="btn button-valide" onclick="convertAddress()">Confirmer</button>
                    </div>
                    <div class="lieu-depart-cfa">
                        <label style="margin-top: 17px;">Ou </label>
                        <input type="checkbox" id="predefini_checkbox"/>
                        <select type="text" name="lieuDepart_predefini" class="input-box" id="lieuDepart_predefini" disabled>
                            <option value="default">--Veuillez choisir un lieu prédéfini--</option>
                            <option value="Site d'Avignon">Site d'Avignon</option>
                            <option value="Site de Pertuis">Site de Pertuis</option>
                        </select>
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
                </div>
              </fieldset>
              <fieldset class="fieldset-block-itineraire">
                <div id="newtrajet-fieldset" class="header-fieldset">
                    <h2>Date et horaire</h2>
                    <label class="disable" for="cb-aller-retour"><input type="checkbox" id="cb-aller-retour" class="disable" name="cb-aller-retour" disabled/>Aller-retour</label>
                </div>
                <div class="content-box">
                  <div class="btn-group">
                    <button type="button" data-section="date_precise" class="button-content button-active">Date précise<input type="checkbox" class="checkbox-type-date" name="parDate" checked/></button>
                    <button type="button" data-section="semaine_alternance" class="disable" class="button-content" disabled>Semaine alternance<input type="checkbox" class="checkbox-type-date" name="parSemaine" disabled/></button>
                  </div>
                  <div class="content-section default-content" id="semaine_alternance">
                    <div id="date-horaire">
                      <label>Jours de covoiturage : </label>
                      <div id="jour-semaine">
                          <div id="jour-lundi" class="item-jour">
                              <input type="checkbox" id="lundi" name="lundi">
                              <label for="lundi">Lundi</label>
                          </div>
                          <div id="jour-mardi" class="item-jour">
                              <input type="checkbox" id="mardi" name="mardi">
                              <label for="mardi">Mardi</label>
                          </div>
                          <div id="jour-mercredi" class="item-jour">
                              <input type="checkbox" id="mercredi" name="mercredi">
                              <label for="mercredi">Mercredi</label>
                          </div>
                          <div id="jour-jeudi" class="item-jour">
                              <input type="checkbox" id="jeudi" name="jeudi">
                              <label for="jeudi">Jeudi</label>
                          </div>
                          <div id="jour-vendredi" class="item-jour">
                              <input type="checkbox" id="vendredi" name="vendredi">
                              <label for="vendredi">Vendredi</label>
                          </div>
                      </div>
                      <label for="heure-depart">Heure de départ de l'aller :</label>
                      <div class="grid-semaine-horaire">
                        <select type="text" name="semaine-heure-aller">
                          <option value="0">00</option>
                          <option value="1">01</option>
                          <option value="2">02</option>
                          <option value="3">03</option>
                          <option value="4">04</option>
                          <option value="5">05</option>
                          <option value="6">06</option>
                          <option value="7">07</option>
                          <option value="8">08</option>
                          <option value="9">09</option>
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
                        <select type="text" name="semaine-minute-aller">
                          <option value="0">00</option>
                          <option value="1">10</option>
                          <option value="2">20</option>
                          <option value="3">30</option>
                          <option value="4">40</option>
                          <option value="5">50</option>
                        </select>
                      </div>
                      <div id="heure-semaine-retour">
                        <label for="heure-depart">Heure de départ du retour :</label>
                        <div class="grid-semaine-horaire">
                          <select type="text" name="semaine-heure-retour">
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
                          <select type="text" name="semaine-minute-retour">
                            <option value="0">00</option>
                            <option value="1">10</option>
                            <option value="2">20</option>
                            <option value="3">30</option>
                            <option value="4">40</option>
                            <option value="5">50</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="content-section" id="date_precise">
                    <div id="heure-newtrajet-aller">
                      <label for="heure-depart">Date de l'aller :</label>
                      <div class="grid-horaire">
                        <input type="date" id="date-aller" name="jour-aller"
                          min="<?php echo date('Y-m-d'); ?>" required>
                        <select type="text" name="heure-aller" required>
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
                        <select type="text" name="minute-aller" required>
                          <option value="00">00</option>
                          <option value="10">10</option>
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="40">40</option>
                          <option value="50">50</option>
                        </select>
                      </div>
                      <div class="grid-horaire">
                        <label for="heure-arrivee">Heure d'arrivée : </label>
                        <select type="text" name="heure-arrivee" required>
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
                          <select type="text" name="minute-arrivee" required>
                            <option value="00">00</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                          </select>
                        </div>
                    </div>
                    <div id="heure-newtrajet-retour">
                      <label for="heure-depart">Date du retour :</label>
                      <div class="grid-horaire">
                        <input type="date" id="date-aller" name="trip-retour"
                          min="<?php echo date('Y-m-d'); ?>" >
                        <select type="text" name="heure-retour">
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
                        <select type="text" name="minute-retour">
                          <option value="00">00</option>
                          <option value="10">10</option>
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="40">40</option>
                          <option value="50">50</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                
                <script type="text/javascript" src="../js/map.js"></script>
              </fieldset>
              <fieldset class="fieldset-block-itineraire">
                <div id="newtrajet-fieldset" class="header-fieldset">
                    <h2>Véhicule</h2>
                </div>
                <div id="vehicule">
                  <label>Véhicule : </label>
                  <select type="text"  name="vehicule" required>
                    <option value="default">--Veuillez choisir votre véhicule--</option>
                    <?php 
                      $voiture = $user->getMarque();
                      $modele= $user->getModele();
                      $gov = htmlspecialchars($voiture. " " . $modele);
                      echo '<option value="' .$gov. '">'.$user->getMarque()." ".$user->getModele().'</option>';
                    ?>
                  </select>
                  <label>Nombre de places proposées : </label>
                  <input type="number" max="<?php echo htmlentities($user->getNbPLace()); ?>" min="1" value="<?php echo htmlentities($user->getNbPLace()); ?>" name="nbPlaces" required/>
                </div>
              </fieldset>
            <button type="submit" style="width:100%" class="btn button-valide">Suivant</button>
          </form>
        </div>
        
      </div>
    </div>

    <script  src="../js/index.js"></script>




</body>

</html>
