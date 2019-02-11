<?php
include "../php/sessionIsStarted.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
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
  <link rel="stylesheet" href="../css/parametre.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
  <ul class="topNav">
    <li style="float:left"><?php echo "<p class='bvn_Message' style='margin-left:5em'>Bonjour ". $_SESSION['name']."</p>"; ?></li>
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
    <button type="button" onclick="">Saisir / Modifier informations</button><br>
      <?php
      $isModifiable = false;
      $dbh = new PDO('mysql:host=localhost;port=3306;dbname=covoiturage', 'root', '');
      $stmt = "SELECT * FROM utilisateur;";
      $Requete = $dbh->query("SELECT * FROM Utilisateur;");
      echo "<table>";
      while ($row = $Requete->fetch(PDO::FETCH_NUM)) {
          $nom = $row[1];
          $prenom = $row[2];
          $mail = $row[3];
          $motdepasse = $row[4];
          $pays = $row[5];
          $ville = $row[6];
          $codepostal = $row[7];
        }
        if($isModifiable == false){
          echo "<tr><th>Nom</th><td>". $nom ."</td></tr><tr><th>Prénom</th><td>". $prenom ."</td></tr><tr><th>E-mail</th><td>". $mail ."</td></tr><tr><th>Mot de passe</th><td>*************</td></tr><tr><th>Pays</th><td>". $pays ."</td></tr><tr><th>Ville</th><td>". $ville ."</td></tr><tr><th>Code postal</th><td>". $codepostal ."</td></tr>";
        } else {
          echo "<tr><th>Nom</th><td><input type='text' name='nom' style='width:100%'/></td></tr><tr><th>Prénom</th><td>". $prenom ."</td></tr><tr><th>E-mail</th><td>". $mail ."</td></tr><tr><th>Mot de passe</th><td>*************</td></tr><tr><th>Pays</th><td>". $pays ."</td></tr><tr><th>Ville</th><td>". $ville ."</td></tr><tr><th>Code postal</th><td>". $codepostal ."</td></tr>";
        }

      echo "</table>"
      ?>
  </div>
  
    <script  src="../js/index.js"></script>




</body>

</html>
