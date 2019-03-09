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
  <style type="text/css">
        #maprecap {    
            width: 92%;
            height: 350px;
            margin-top: 10px;
        }
        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {
          padding: 8px;
          text-align: left;
          border-bottom: 1px solid #ddd;
        }

        tr:hover {background-color:#f5f5f5;}
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
          <h1 class="title">Compléter son profil</h1>
        </div>
        <div class="content-box">
          <fieldset class="fieldset-block-itineraire">
            <div class="header-fieldset">
              <h2>Vos préférences</h2>
            </div>
              <?php
              $typeInscription = $_POST["type-inscription"];
              if($_POST["lieuDepartMap"]){
                $lieuDepart = $_POST["lieuDepartMap"];
              } else {
                $lieuDepart = $_POST["lieuDepart_predefini"];
              }
              $lieuArrivee = $_POST["lieuArrivee"];
              $heureDepart = $_POST["heure-depart-cp-profile"].":".$_POST["minute-depart-cp-profile"].":00";
              $heureArrivee = $_POST["heure-arrivee-cp-profile"].":".$_POST["minute-arrivee-cp-profile"].":00";
              if(isset($_POST["type-inscription"])){
                if(empty($_POST["type-inscription"])) {
                  echo "Nous avons recontré une erreur lors de la réservation du trajet. Vous allez être redirigez automatiquement ou cliquez ci-dessous.";
                  echo "<br>";
                  echo "<button type=\"button\" onclick=\"window.location.href='accueil.php'\" class=\"btn button-valide\">Retour à l'accueil</button>";
                } else {
                  echo "<h1>Félicitation !</h1>";
                  echo "<p>Vos préférences ont bien été mis à jour, vous pouvez à tout moment les modifier depuis la page d'accueil.</p>";
                  echo "<table>
                  <tr>
                    <th>Type d'inscription</th>
                    <th>Lieu départ</th>
                    <th>Lieu arrivée</th>
                    <th>Heure départ</th>
                    <th>Heure arrivée</th>
                  </tr>
                  <tr>
                    <td>".$typeInscription."</td>
                    <td>".$lieuDepart."</td>
                    <td>".$lieuArrivee."</td>
                    <td>".$heureDepart."</td>
                    <td>".$heureArrivee."</td>
                  </tr></table>";
                  $dataProfile = array("role"=>$typeInscription,"lieuDepart"=>$lieuDepart,"lieuArrivee"=>$lieuArrivee);
                  echo "<button type=\"button\" onclick=\"window.location.href='accueil.php'\" class=\"btn button-valide\">Retourner à l'accueil</button>";
                  $dbh->completeProfile($dataProfile, $user->getId());

                }
                
              } else {
                echo "Nous avons recontré une erreur lors de la réservation du trajet. Vous allez être redirigez automatiquement ou cliquez ci-dessous.";
                  echo "<br>";
                  echo "<button type=\"button\" onclick=\"window.location.href='accueil.php'\" class=\"btn button-valide\">Retour à l'accueil</button>";
                echo "<table>
                <tr>
                  <th>Type d'inscription</th>
                  <th>Lieu départ</th>
                  <th>Lieu arrivée</th>
                  <th>Heure départ</th>
                  <th>Heure arrivée</th>
                </tr>
                <tr>
                  <td>".$typeInscription."</td>
                  <td>".$lieuDepart."</td>
                  <td>".$lieuArrivee."</td>
                  <td>".$heureDepart."</td>
                  <td>".$heureArrivee."</td>
                </tr></table>";
                echo "<button style='margin-top:2em;float:left' type='button' onclick=\"window.location.href='completeProfile.php'\" class='btn button-valide'>Précédent</button>";                
              }
              ?>
          </fieldset>
        </div>
        
        
      </div>
    </div>
    <script  src="../js/index.js"></script>




</body>

</html>
