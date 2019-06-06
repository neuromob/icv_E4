<?php
include '../class/DBHandler.class.php';
session_start(); 
echo "<html>
<head>
  <meta charset='utf-8' />
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>ICV | Login</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='../css/style.css' />
   <script type='text/javascript' src='../js/jquery-3.3.1.min.js'></script>
</head>
<body class='main'>
  <form class='login' id='loginForm' method='POST'>
    <p>Veuillez entrer ci-dessous votre e-mail d'inscription ([...]@formation-technologique.fr)</p>
    <input type='email' name='emailToSend' placeholder='monemail@formation-technologique.fr' style='text-align:center'/>
    <button type='submit' id='btnConnexion' class='btn btn-block' value='Envoyer le mot de passe'>Valider</button>
  </form>
</body>
</html>";
if($_POST){
    $dbh = new DBHandler();
    if(isset($_POST["emailToSend"])){
      $result = $dbh->getQuestionRep($_POST["emailToSend"]);
      var_dump($result);
      if($result["response"] == "KO") {
        echo "<script>alert(\"Soit le compte attribué à cette adresse n'existe soit vous n'avez pas défini de question secrète\")</script>";
      } else {
        $_SESSION["mail"] = $_POST["emailToSend"];
        $_SESSION["question"] = $result["question"];
        $_SESSION["reponse"] = $result["reponse"];
        header('Location: repQuestion.php');
      }
    }
}



?>