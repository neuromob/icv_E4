<?php
session_start(); 
$user = "admin";
$pass = "toor";

if(isset($_POST['connexion'])) {
    if(empty($_POST['email'])) {
        echo "Le champ Pseudo est vide.";
    } else {
        if(empty($_POST['motdepasse'])) {
            echo "Le champ Mot de passe est vide.";
        } else {
            $Email = htmlentities($_POST['email'], ENT_QUOTES, "ISO-8859-1"); 
            $MotDePasse = htmlentities($_POST['motdepasse'], ENT_QUOTES, "ISO-8859-1");
            $dbh = new PDO('mysql:host=192.168.5.59;port=3306;dbname=convoiturage', $user, $pass);
            if(!$dbh){
                echo "Erreur de connexion à la base de données.";
            } else {
                $Requete = $dbh->query("SELECT * FROM membres WHERE email = '".$Email."' AND motdepasse = '".$MotDePasse."'");
                if($Requete->rowCount() == 0) {
                    echo "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
                } else {
                    $_SESSION['email'] = $Email;
                    echo "Vous êtes à présent connecté !";
                }
            }
        }
    }
}
?>
