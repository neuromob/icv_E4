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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
      <div class="list-group">
        <?php
          $listTrip = $dbh->getListTrip();
          var_dump($listTrip);
        ?>
        <button class="collapse">Paris - Bordeaux</button>
        <div class="content">
          <ul>
            <li>Nom de l'élève : Alexandre Jean</li>
            <li>Véhicule : Lamborghini Aventador</li>
            <li>Couleur du véhicule : Rouge</li>
            <li>Date et heure de départ : 29/01/2019 - 15h35</li>
            <li>Date et heure d'arrivée : 29/01/2019 - 17h MAAAXXX</li>
            <li>Lieu de RDV : [Magasin "Au hasard"] 40 av Clichy, 75018 PARIS</li>
            <li>Lieu de dépôt : [Mairie de Bordeaux] Place Pey Berland, 33000 Bordeaux</li>
            <li>Nombre de place : 4</li>
            <li>Nombre de place restante : 2</li>
            <li>Commentaire : "Wallah le paris - bordeaux on le fait en 2h !"</li>
          </ul>
        </div>
        <button class="collapse">Marseille - Pertuis</button>
        <div class="content">
            <ul>
                <li>Nom de l'élève : Alexandre Jean</li>
            <li>Véhicule : Lamborghini Aventador</li>
            <li>Couleur du véhicule : Rouge</li>
            <li>Date et heure de départ : 29/01/2019 - 15h35</li>
            <li>Date et heure d'arrivée : 29/01/2019 - 17h MAAAXXX</li>
            <li>Lieu de RDV : [Magasin "Au hasard"] 40 av Clichy, 75018 PARIS</li>
            <li>Lieu de dépôt : [Mairie de Bordeaux] Place Pey Berland, 33000 Bordeaux</li>
            <li>Nombre de place : 4</li>
            <li>Nombre de place restante : 2</li>
            <li>Commentaire : "Wallah le paris - bordeaux on le fait en 2h !"</li>
              </ul>
        </div>
        <button class="collapse">Avignon - Pertuis</button>
        <div class="content">
            <ul>
              <li>Nom de l'élève : Alexandre Jean</li>
              <li>Véhicule : Lamborghini Aventador</li>
              <li>Couleur du véhicule : Rouge</li>
              <li>Date et heure de départ : 29/01/2019 - 15h35</li>
              <li>Date et heure d'arrivée : 29/01/2019 - 17h MAAAXXX</li>
              <li>Lieu de RDV : [Magasin "Au hasard"] 40 av Clichy, 75018 PARIS</li>
              <li>Lieu de dépôt : [Mairie de Bordeaux] Place Pey Berland, 33000 Bordeaux</li>
              <li>Nombre de place : 4</li>
              <li>Nombre de place restante : 2</li>
              <li>Commentaire : "Wallah le paris - bordeaux on le fait en 2h !"</li>
            </ul>
        </div>
        <button class="collapse">Manosque - Pertuis</button>
        <div class="content">
            <ul>
              <li>Nom de l'élève : Alexandre Jean</li>
              <li>Véhicule : Lamborghini Aventador</li>
              <li>Couleur du véhicule : Rouge</li>
              <li>Date et heure de départ : 29/01/2019 - 15h35</li>
              <li>Date et heure d'arrivée : 29/01/2019 - 17h MAAAXXX</li>
              <li>Lieu de RDV : [Magasin "Au hasard"] 40 av Clichy, 75018 PARIS</li>
              <li>Lieu de dépôt : [Mairie de Bordeaux] Place Pey Berland, 33000 Bordeaux</li>
              <li>Nombre de place : 4</li>
              <li>Nombre de place restante : 2</li>
              <li>Commentaire : "Wallah le paris - bordeaux on le fait en 2h !"</li>
            </ul>
        </div>
        <button class="collapse">Marseille - Avignon</button>
        <div class="content">
            <ul>
              <li>Nom de l'élève : Alexandre Jean</li>
              <li>Véhicule : Lamborghini Aventador</li>
              <li>Couleur du véhicule : Rouge</li>
              <li>Date et heure de départ : 29/01/2019 - 15h35</li>
              <li>Date et heure d'arrivée : 29/01/2019 - 17h MAAAXXX</li>
              <li>Lieu de RDV : [Magasin "Au hasard"] 40 av Clichy, 75018 PARIS</li>
              <li>Lieu de dépôt : [Mairie de Bordeaux] Place Pey Berland, 33000 Bordeaux</li>
              <li>Nombre de place : 4</li>
              <li>Nombre de place restante : 2</li>
              <li>Commentaire : "Wallah le paris - bordeaux on le fait en 2h !"</li>
            </ul>
        </div>
        <button class="collapse">Venasque - Aix-en-Provence</button>
        <div class="content">
            <ul>
              <li>Nom de l'élève : Alexandre Jean</li>
              <li>Véhicule : Lamborghini Aventador</li>
              <li>Couleur du véhicule : Rouge</li>
              <li>Date et heure de départ : 29/01/2019 - 15h35</li>
              <li>Date et heure d'arrivée : 29/01/2019 - 17h MAAAXXX</li>
              <li>Lieu de RDV : [Magasin "Au hasard"] 40 av Clichy, 75018 PARIS</li>
              <li>Lieu de dépôt : [Mairie de Bordeaux] Place Pey Berland, 33000 Bordeaux</li>
              <li>Nombre de place : 4</li>
              <li>Nombre de place restante : 2</li>
              <li>Commentaire : "Wallah le paris - bordeaux on le fait en 2h !"</li>
            </ul>
        </div>
      </div>
    </div>
    <script src="../js/index.js"></script>
  </body>

</html>