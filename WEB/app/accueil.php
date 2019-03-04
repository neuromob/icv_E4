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
          <h1 class="title">Profil</h1>
        </div>
        <div class="content-box">
        <a href="#" style="float:right;margin-top: -7px;" onclick="window.location.href='parametres.php'">Modifier mon profil</a>
          <div class="grid-info">
            <?php 
              echo "<p class='p-info-profil'><img class='img-icon-profil' src='https://img.icons8.com/android/24/000000/user.png'> ". $user->getNom() ." ".$user->getPrenom()."</p>";
              echo "<p class='p-info-profil'><img class='img-icon-profil' src='https://img.icons8.com/android/24/000000/secured-letter.png'> ". $user->getEmail() ."</p>";
              echo "<p class='p-info-profil'><img class='img-icon-home-profil' src='https://img.icons8.com/android/24/000000/home.png'> ". $user->getVille() ."</p>";
            ?>
          </div>
          <label>S'inscrire :</label>
          <div class="button-input">
            <select type="text" id="select-inscription" name="type-inscription" class="input-box" required>
              <option value="inscription-oui">Oui</option>
              <option value="inscription-non">Non</option>
            </select>
            <button type="button" id="btn-complete-profil" class="btn button-valide" onclick="window.location.href='completeProfile.php'">Compléter son profil</button>
          </div>
          
          
          
         
        </div>
      </div>
      <div class="box shadow">
        <div class="header-box">
          <h1 class="title">Liste des trajets disponibles</h1>
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