<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include "../php/sessionIsStarted.php";
include '../class/user.class.php';
$dbh = new DBHandler();
$user = unserialize((base64_decode($_SESSION['userObject'])));

if(!isset($_SESSION)) 
  { 
      session_start();
  }
if(isset($_POST) && !empty($_POST["nom"])){
  $newUserData = array();
  foreach($_POST as $key => $value){
    $newUserData[$key] = $value;
  }
  $oldPassIsCorrect = $dbh->update_User($newUserData, $user->getId(), $user->getMDP());
  if($oldPassIsCorrect) {
    header("Location: parametres.php?");
  } else {
    header("Location: parametres.php?modifyMode=1&oldPassIsIncorrect=1");
  }
  $user = $dbh->refreshUser($user->getId());
  $user_serlizer = base64_encode(serialize($user));
  $_SESSION['userObject'] = $user_serlizer;
  
}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
<style type="text/css">
        #mapParam {    
            width: 92%;
            height: 350px;
            margin-top: 10px;
        }
        </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width" />
  <title>ICV | Accueil</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/home.css">
  <link rel="stylesheet" href="../css/parametre.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4wS9TPSIExN2MI6WvJMk8-o6CqXEeTC4&language=en&libraries=places"></script>
  <script type="text/javascript" src="../js/map_parametre.js"></script>
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
      <li class="active">
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
      <div class="my-profil">
        <?php if(!isset($_GET["modifyMode"])) : ?>
            <a type='button' href='parametres.php?modifyMode=1'>Saisir / Modifier informations</a>
            <table>
            <thead><tr><th colspan='2'>Mes informations personnelles</th></tr></thead>
            <tr><th>Nom</th><td><?= $user->getNom() ?></td></tr>
            <tr><th>Prénom</th><td><?= $user->getPrenom() ?></td></tr>
            <tr><th>E-mail</th><td><?= $user->getEmail() ?></td></tr>
            <tr><th>Mot de passe</th><td>*************</td></tr>
            <tr><th>Adresse</th><td><?= $user->getAdresse() ?></td></tr>
            <tr><th>Marque</th><td><?= $user->getMarque() ?></td></tr>
            <tr><th>Modèle</th><td><?= $user->getModele() ?></td></tr>
            <tr><th>Nombre de place</th><td><?= $user->getNbPLace() ?></td></tr>
            <tr><th>Couleur véhicule</th><td><?= $user->getCouleur() ?></td></tr>
            </table>          
          <?php else : ?>
            <?php if(isset($_GET["oldPassIsIncorrect"])) : ?>
              Votre ancien mot de passe est incorrect. Il doit être correct pour pouvoir modifier votre mot de passe sinon laissez les champs vides.
            <?php endif; ?>            
            <a type='button' href='parametres.php?'>Annuler la modification</a>
            <form method='POST' name='changeUserData' action='parametres.php?'>
            <table>
            <thead><tr><th colspan='2'>Mes informations personnelles</th></tr></thead>
            <tr><th>Nom</th><td><input type='text' name='nom' style='width:100%' value="<?=$user->getNom()?>"required/></td></tr>
            <tr><th>Prénom</th><td><input type='text' name='prenom' style='width:100%' value="<?= $user->getPrenom() ?>"required/></td></tr>
            <tr><th>E-mail</th><td><?=$user->getEmail()?></td></tr>
            <tr><th>Ancien mot de passe</th><td><input type='text' name='oldMdp' style='width:100%' value=''/></td></tr>
            <tr><th>Mot de passe</th><td><input type='text' name='mdp' style='width:100%' value=''/></td></tr>
            <tr><th>Adresse</th><td><div class='button-input'>
            <input type='textbox' name='adresseParam' id='adresseParam' value="<?= $user->getAdresse() ?>" required/>
            <input type='textbox' name='latitude' id='latitudeParam' hidden>
            <input type='textbox' name='longitude' id='longitudeParam' hidden>
            <button type='button' class='btn button-valide' onclick='convertAddress()'>Confirmer</button>
            </div>
            <tr><th></th><td><div id='mapParam'></div></td></tr>
            <input id='adresseParam-latitude' hidden><input id='adresseParam-longitude' hidden>
            <tr><th>Marque</th><td><input type='text' name='marque' style='width:100%' value="<?= $user->getMarque() ?>"required/></td></tr>
            <tr><th>Modèle</th><td><input type='text' name='modele' style='width:100%' value="<?= $user->getModele() ?>"required/></td></tr>
            <tr><th>Nombre de place</th><td><input type='text' name='nbPLace' style='width:100%' value="<?= $user->getNbPLace() ?>"required/></td></tr>
            <tr><th>Couleur véhicule</th><td><input type='text' name='couleur' style='width:100%' value="<?= $user->getCouleur() ?>"required/></td></tr>
            </table>
            <button type='submit' value='OK' style='margin: 15px 5px 15px'> Valider</button>
            </form>            
        <?php endif;?>                  
    </div>
  </div>

  
    <script  src="../js/index.js"></script>




</body>

</html>