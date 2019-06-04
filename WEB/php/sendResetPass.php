<?php
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
    <p>Veuillez entrer ci-dessous votre e-mail d'inscription ([...]@formation-technologique.fr), un mail vous sera envoyé pour réinitialiser votre mot de passe.</p>
    <input type='email' name='emailToSend' placeholder='monemail@formation-technologique.fr' style='text-align:center'/>
    <button type='submit' id='btnConnexion' class='btn btn-block' name='sendReset' value='Envoyer le mot de passe'>Envoyer l'email de réinitialisation</button>
  </form>
</body>
</html>";
if($_POST){
    $dbh = new DBHandler();
}



?>