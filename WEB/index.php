<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start(); 
include 'class/user.class.php';
//84cdd49ab734b3c3935d3d60dc3364526444a976
$randomSalt = "dzjnaihbafgireger%fzfzea$-eza19$*";

echo "<html>
<head>
  <meta charset='utf-8' />
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>ICV | Login</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='css/style.css' />
  <script src='main.js'></script>

  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
</head>
<body class='main'>
  <form class='login' method='POST'>
    <input type='text' class='input-box' name='email' placeholder='Entrez votre e-mail' /> 
    <input type='password' class='input-box' name='motdepasse' placeholder='Entrez votre mot de passe'/>
    <div class='cb_RememberMe'>
      <input type='checkbox' id='remember' name='remember'/>
      <label for='remember'>Se souvenir de moi.</label>
    </div>
    <button type='submit' class='btn btn-block' name='connexion' value='Connexion'>Se connecter</button>
  </form>
</body>
</html>";

if(isset($_POST['connexion'])) {
    
    if(empty($_POST['email'])) {
        echo "<div id='error_Mail_MSG'>Le champ E-mail est vide.</div>";
    } else {
        if(empty($_POST['motdepasse'])) {
            echo "<div id='error_Mdp_MSG'>Le champ Mot de passe est vide.</div>";
        } else {
            $Email = htmlentities($_POST['email'], ENT_QUOTES, "ISO-8859-1"); 
            $MotDePasse = htmlentities($_POST['motdepasse'], ENT_QUOTES, "ISO-8859-1");

            $dbh = new DBHandler();
            $row = $dbh->verify_User_and_Pass($Email,$MotDePasse);
            if(isset($row)) {
              echo "<div id='success_MSG'>Vous êtes à présent connecté !</div>";
              $_SESSION['userObject'] = new User($row);
              header('Location: app/accueil.php');
          } else {
              echo "<div id='error_MSG'>Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.</div>";
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


?>
