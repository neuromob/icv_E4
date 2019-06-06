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
    <p>".$_SESSION["question"]."</p>
    <input type='text' name='reponse' placeholder='Veuillez entrer votre réponse' style='text-align:center'/>
    <button type='submit' id='btnConnexion' class='btn btn-block' name='sendReset'>Envoyer l'email de réinitialisation</button>
  </form>
</body>
</html>";
if($_POST){
    $dbh = new DBHandler();
    if(isset($_POST["reponse"])){
      if($_POST["reponse"] == $_SESSION["reponse"]){
        echo "OK";
        $code = $dbh -> GetUniqueKey(6);
        //sendMail($code); Pour l'envoi du code par mail
        $_SESSION["code"] = $code;
        header('Location: sendPassReset.php');
      } else {
        echo "<script>alert('La réponse n'est pas correct. Veuillez entrer la réponse enregistré lors de l'inscription');</script>";
      }
      
    } else {
      echo "vide";
    }
}



?>