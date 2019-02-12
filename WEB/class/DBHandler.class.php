<?php
class DBHandler {
    private $pdo;
    protected $randomSalt = 'dzjnaihbafgireger%fzfzea$-eza19$*';

    private $database = 'covoiturage';
    private $serverName = '192.168.5.60';
    private $login = 'admin';
    private $password = 'toor';
    private $port = '3306';


    public function __construct() {
    try{        
        $conn = new PDO("mysql:host=$this->serverName;port=$this->port;dbname=$this->database", $this->login, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }   catch(PDOException $e) {
            print "Connexion à la base de donnée impossible  : " .$e->getMessage() . "";
            die();
            }
        $this->pdo = $conn;
        
    }
    
    public function verify_User_and_Pass($user, $pass) {
        $rows = array();
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE email = ? AND motDePasse = ?");
        $stmt -> bindParam(1, $user);
        $password = sha1($pass.$this->randomSalt);
        $stmt -> bindParam(2, $password);
        $stmt -> execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($rows['email'] == $user){
            $idVerified = $rows["id"];
            $userData = $this->getAllInfo($idVerified);
            return $userData;
        }
        else {
            return null;
        }
    }

    public function update_User($newUserData, $id){
        $sql = "UPDATE Utilisateur 
                SET nom = ?, prenom = ?, email = ?, motDePasse = ?
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        var_dump($newUserData);
        
        $stmt -> bindParam(1, $newUserData[0]);
        $stmt -> bindParam(2, $newUserData[1]);
        $stmt -> bindParam(3, $newUserData[2]);
        $passwordHashed = sha1($newUserData[3].$this->randomSalt);
        $stmt -> bindParam(4, $passwordHashed);

        $stmt -> bindParam(5, $id);
        $stmt -> execute();
    }
    
    public function getAllInfo($id) {
        $sql = "SELECT Utilisateur.id,Utilisateur.nom,Utilisateur.prenom,Utilisateur.email,Utilisateur.motDePasse,Adresse.numeroRue,Adresse.nomRue,Adresse.codePostal,Adresse.ville,Voiture.marque,Voiture.modele,Voiture.place,Voiture.couleur FROM Utilisateur
                INNER JOIN Adresse ON Utilisateur.adresse = Adresse.id
                INNER JOIN Voiture ON Utilisateur.voiture = Voiture.id
                WHERE Utilisateur.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindParam(1, $id);
        $stmt -> execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData;
    }

    public function get_DB(){
        if ($this->pdo instanceof PDO) {
            return $this->pdo;
        }
    }
    

} 
// else {
//     $Requete = $stmt->query("SELECT * FROM Utilisateur WHERE email = '".$Email."' AND motDePasse = '".$MotDePasse."'");
//     while ($row = $Requete->fetch(PDO::FETCH_NUM)) {
//         $_SESSION["name"] = $row[1];
//       }
//     if($Requete->rowCount() == 0) {
//         echo "<div id='error_MSG'>Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.</div>";
//     } else {
//         $_SESSION['email'] = $Email;
//         echo "<div id='success_MSG'>Vous êtes à présent connecté !</div>";
//         header('Location: app/accueil.php');
//     }
// }