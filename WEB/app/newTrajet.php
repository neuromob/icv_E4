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
          <h1 class="title">Publier une annonce</h1>
        </div>
        <div class="content-box">
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
                    <form method="post" style="margin-top:15px">
                        <label>Lieu de départ : </label>
                        <p class="description-help">Rechercher votre addresse de départ dans la barre ci-dessous ou sélectionner un lieu prédéfini.</p>
                        <div class="button-input">
                            <input type="textbox" id="adresse-marker" required>
                            <button type="button" class="btn button-valide" onclick="convertAddress()">Confirmer</button>
                        </div>
                        <div class="lieu-depart-cfa">
                            <label style="margin-top: 17px;">Ou </label>
                            <select type="text" name="lieuDépart" class="input-box"value="Lieu d'arrivée'" required>
                                <option value="">--Veuillez choisir un lieu prédéfini--</option>
                                <option value="avignon">Site d'Avignon</option>
                                <option value="pertuis">Site de Pertuis</option>
                            </select>
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
                      </form>
                    </fieldset>
                    <fieldset class="fieldset-block-itineraire">
                      <div id="newtrajet-fieldset" class="header-fieldset">
                          <h2>Date et horaire</h2>
                          <label for="cb-aller-retour"><input type="checkbox" id="cb-aller-retour" name="cb-aller-retour" value="1" checked/>Aller-retour</label>
                      </div>
                      <div id="date-horaire">
                        <label>Récurrence : </label>
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
                      </div>
                      <div id="heure-newtrajet-aller">
                        <label for="heure-depart">Date de l'aller :</label>
                        <div class="grid-horaire">
                          <input type="date" id="date-aller" name="trip-aller"
                          value="2018-07-22"
                          min="2018-01-01" max="2018-12-31">
                          <select type="text">
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
                          <select type="text">
                            <option value="0">00</option>
                            <option value="1">10</option>
                            <option value="2">20</option>
                            <option value="3">30</option>
                            <option value="4">40</option>
                            <option value="5">50</option>
                          </select>
                        </div>
                      </div>
                      <div id="heure-newtrajet-retour">
                        <label for="heure-depart">Date du retour :</label>
                        <div class="grid-horaire">
                          <input type="date" id="date-aller" name="trip-aller"
                            value="<?php date('Y-m-d'); ?>"
                            min="<?php echo date('Y-m-d'); ?>" max="2018-12-31">
                          <select type="text">
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
                          <select type="text">
                            <option value="0">00</option>
                            <option value="1">10</option>
                            <option value="2">20</option>
                            <option value="3">30</option>
                            <option value="4">40</option>
                            <option value="5">50</option>
                          </select>
                        </div>
                      </div>
                    <script type="text/javascript" src="../js/map.js"></script>
                </div>
            </fieldset>
            <fieldset class="fieldset-block-itineraire">
              <div id="newtrajet-fieldset" class="header-fieldset">
                  <h2>Véhicule</h2>
              </div>
              <div id="vehicule">
                <label>Véhicule : </label>
                <select type="text">
                  <option value="">--Veuillez choisir votre véhicule--</option>
                  <option value="megane">Renault Megane</option>
                  <option value="clio">Renault Clio</option>
                  <option value="c3">Citroën</option>
                </select>
                <label>Nombre de places proposées : </label>
                <input type="number" max="5" min="1" value="3"/>
              </div>
            </fieldset>
            <button type="button" style="width:100%" onclick="window.location.href='newTrajet.1.php'" class="btn button-valide">Suivant</button>
        </div>
        
      </div>
    </div>

    <script  src="../js/index.js"></script>




</body>

</html>
