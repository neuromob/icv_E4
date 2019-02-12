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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/home.css">
  <link rel="stylesheet" href="../css/parametre.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
    <div class="my-profil">
      <?php
        $dbh = new DBHandler();
        if(!isset($_GET["modifyMode"])){
          echo "<a type='button' href='parametres.php?modifyMode=1'>Saisir / Modifier informations</a>";
          echo "<table>";
          echo "<tr><th>Nom</th><td>". $user->getNom() ."</td></tr>
          <tr><th>Prénom</th><td>". $user->getPrenom() ."</td></tr>
          <tr><th>E-mail</th><td>". $user->getEmail() ."</td></tr>
          <tr><th>Mot de passe</th><td>*************</td></tr>
          <tr><th>Numéro</th><td>". $user->getNumRue() ."</td></tr>
          <tr><th>Nom rue</th><td>". $user->getNomRue() ."</td></tr>
          <tr><th>Ville</th><td>". $user->getVille() ."</td></tr>
          <tr><th>Code postal</th><td>". $user->getCP() ."</td></tr>
          <tr><th>Marque</th><td>". $user->getMarque() ."</td></tr>
          <tr><th>Modèle</th><td>". $user->getModele() ."</td></tr>
          <tr><th>Nombre de place</th><td>". $user->getNbPLace() ."</td></tr>
          <tr><th>Couleur véhicule</th><td>". $user->getCouleur() ."</td></tr>";
          
          echo "</table>";
        } else {
          
          echo "<form method='POST' name='changeUserData' action='parametres.php?'>";
          echo "<table>";
          echo "<thead><tr><th>Mon profil</th></tr></thead>
          <tr><th>Nom</th><td><input type='text' name='nom' style='width:100%' value='".$user->getNom()."'/></td></tr>
          <tr><th>Prénom</th><td><input type='text' name='prenom' style='width:100%' value='". $user->getPrenom() ."'/></td></tr>
          <tr><th>E-mail</th><td><input type='text' name='email' style='width:100%' value='". $user->getEmail() ."'/></td></tr>
          <tr><th>Mot de passe</th><td><input type='text' name='mdp' style='width:100%' value=''/></td></tr>
          <tr><th>Numéro</th><td><input type='text' name='numRue' style='width:100%' value='". $user->getNumRue() ."'/></td></tr>
          <tr><th>Nom rue</th><td><input type='text' name='nomRue' style='width:100%' value='". $user->getNomRue() ."'/></td></tr>
          <tr><th>Ville</th><td><input type='text' name='ville' style='width:100%' value='". $user->getVille() ."'/></td></tr>
          <tr><th>Code postal</th><td><input type='text' name='codePostal' style='width:100%' value='". $user->getCP() ."'/></td></tr>
          <tr><th>Marque</th><td><input type='text' name='marque' style='width:100%' value='". $user->getMarque() ."'/></td></tr>
          <tr><th>Modèle</th><td><input type='text' name='modele' style='width:100%' value='". $user->getModele() ."'/></td></tr>
          <tr><th>Nombre de place</th><td><input type='text' name='nbPLace' style='width:100%' value='". $user->getNbPLace() ."'/></td></tr>
          <tr><th>Couleur véhicule</th><td><input type='text' name='couleur' style='width:100%' value='". $user->getCouleur() ."'/></td></tr>";
          echo "</table>";
          echo "<button type='submit' value='OK'> Valider</button>";
          echo "</form>";
        }
        
        if(isset($_POST)){
          $newUserData = array();
          
          foreach($_POST as $value){
            $newUserData[] = $value;
          }
          $dbh->update_User($newUserData, $user->getId());
        } else {
          echo "nopost";
        }

      ?>
  </div>
  
    <script  src="../js/index.js"></script>




</body>

</html>
