<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start(); 
include 'class/user.class.php';
$message = "";
echo "session : " . $_SESSION["tentative"];
if(isset($_SESSION["tentative"])){
  $nbEssaiRestant = 4 - $_SESSION["tentative"];
} else {
  $nbEssaiRestant = 4;
  $_SESSION["tentative"] = 0;
  echo "session : " . $_SESSION["tentative"];
}

  if(isset($_POST['connexion'])) {
    if(empty($_POST['email'])) {
      $message = "<div id='error_Mail_MSG'>Le champ E-mail est vide.</div>";
    } else {
        if(empty($_POST['motdepasse'])) {
          $message = "<div id='error_Mdp_MSG'>Le champ Mot de passe est vide.</div>";
        } else {
            $Email = htmlentities($_POST['email'], ENT_QUOTES, "ISO-8859-1"); 
            $MotDePasse = htmlentities($_POST['motdepasse'], ENT_QUOTES, "ISO-8859-1");
            $dbh = new DBHandler();
            $userVerified = $dbh->loginUser($Email,$MotDePasse, $_SESSION["tentative"]);
            var_dump($userVerified);
            if($userVerified["response"] == "OK") {
              echo "<div id='success_MSG'>Vous êtes à présent connecté !</div>";
              $user = new User($userVerified);
              $user_serlizer = base64_encode(serialize($user));
              $_SESSION["userObject"] = $user_serlizer;
              $_SESSION["authentified"] = true;
              
              header('Location: app/accueil.php');
            } else if ($userVerified["response"] == "KO_ban24"){
              echo "<div id='error_MSG'>Vous avez dépasé le nombre de tentatives maximales. Votre compté est bloqué pendants 24h.</div>";
            } else if ($userVerified["response"] == "KO") { 
                echo "tentative : " .$_SESSION["tentative"];
                $message = "<div id='error_MSG'>Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.</div>"; 
                $_SESSION["tentative"] = $_SESSION["tentative"] + 1;
                //header('Location: index.php');
            } else {
              echo "Erreur système";
            }
            
            //$result = $user->login($Email,$MotDePasse);
            // if(is_array($result)){
            //     $_SESSION['name'] = $result['nom'];
            //     $_SESSION['mail'] = $result['email'];
            //     echo "<div id='success_MSG'>Vous êtes à présent connecté !</div>";
            //     header('Location: app/accueil.php');
            // } else {
            //     echo $result;
            // }
            
        }
    }
  } 
  /*
  echo "<div id='error_MSG'>Vous avez dépasé le nombre de tentatives maximales. Votre compté est bloqué pendants 24h.</div>";
  echo "<script>
    document.getElementById('email').disabled = true;
    document.getElementById('motdepasse').disabled = true;
  </script>";*/


echo "<html>
<head>
  <meta charset='utf-8' />
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>ICV | Login</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='css/style.css' />
   <script type='text/javascript' src='js/jquery-3.3.1.min.js'></script>
</head>
<body class='main'>
  <form class='login' id='loginForm' method='POST'>
    <input type='text' id='email' class='input-box' name='email' placeholder='Entrez votre e-mail' /> 
    <input type='password' id='motdepasse' class='input-box' name='motdepasse' placeholder='Entrez votre mot de passe'/>
    <a href='php/sendResetPass.php'>Mot de passe oublié.</a>
    <button type='submit' id='btnConnexion' class='btn btn-block' name='connexion' value='Connexion'>Se connecter</button>
    <p style='font-size:13px;font-style:italic;color:grey;text-align:right;margin: -9px 0 -11px;'>Il vous reste : ". $nbEssaiRestant ." essaies</p>
  </form>
  <script>
    
  $(document).ready(function(){
    $('#errorModal').hide();
  });
    $('#btnConnexion').on('click', function(){
      $('#errorModal').show();
    })
  </script>
</body>
</html>";

  

echo "<div id='errorModal' class='modal'>

<!-- Modal content -->
<div class='modal-content'>
  <span class='close'>&times;</span>
  ".$message ."
  </div>

</div>";


?>
