<?php
include '../class/DBHandler.class.php';
session_start();
echo $_SESSION["code"];
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
    <p>Un mail contenant un code vous à été envoyé à l'adresse mail : ". $_SESSION["mail"] .", veuillez le saisir.</p>
    <input type='text' name='code' placeholder='Veuillez entrer le code' style='text-align:center'/>
    <button type='submit' id='btnConnexion' class='btn btn-block' name='sendReset'>Envoyer l'email de réinitialisation</button>
  </form>
</body>
</html>";
if($_POST){
    $dbh = new DBHandler();
    if(isset($_POST["code"])){
      if($_POST["code"] == $_SESSION["code"]){
        echo "Code correspondant";
        
        header ('location : resetPassword.php');
      } else {
        echo "NOP";
      }
      
    } else {
      echo "vide";
    }
}



?>