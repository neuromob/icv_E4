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
    $to_email = $_POST["emailToSend"];
    $subject = 'Reinitialisation de mot de passe';
    $message = 'This mail is sent using the PHP mail function';
    $headers = 'From: noreply@passwordreset.com';
    $mail = new PHPMailer(true);

//Send mail using gmail
    if($send_using_gmail){
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 465; 
        $mail->Username = "valentin.poujade@formation-technologique.fr";
        $mail->Password = "Fenetre7";
    }
    //Typical mail data
    $mail->AddAddress($to_email, $to_email);
    $mail->SetFrom("valentin.poujade@formation-technologique.fr", "reset");
    $mail->Subject = $subject;
    $mail->Body = $message;

    try{
        $mail->Send();
        echo "Success!";
    } catch(Exception $e){
        //Something went bad
        echo "Fail - " . $mail->ErrorInfo;
    }
    mail($to_email,$subject,$message,$headers);
} else {
    echo "Une erreur à été recontré !";
}



?>