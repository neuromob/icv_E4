<?php
include '../class/DBHandler.class.php';
session_start();
echo "<html>
<head>
  <meta http-equiv='content-type' content='text/html; charset=utf-8' />
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>ICV | Login</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='../css/style.css' />
   <script type='text/javascript' src='../js/jquery-3.3.1.min.js'></script>
</head>
<body class='main'>
  <form class='login' id='loginForm' method='POST'>
    <p>Vous pouvez maintenant réinitialiser votre mot de passe</p>
    <label for='password'>Entrez un nouveau mot de passe</label>
    <input type='text' name='password' placeholder='Veuillez entrer le code' style='text-align:center'/>
    <label for='passwordRepeat'>Entrez le mot de passe à nouveau</label>
    <input type='password' name='passwordRepeat' placeholder='Veuillez entrer le code' style='text-align:center'/>
    <button type='submit' id='btnConnexion' class='btn btn-block' name='sendReset'>Envoyer l'email de réinitialisation</button>
  </form>
</body>
</html>";
if($_POST){
    $dbh = new DBHandler();
    echo $_POST["password"];
    echo $_POST["passwordRepeat"];
}



?>