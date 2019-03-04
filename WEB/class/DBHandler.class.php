<?php
class DBHandler {
    
    protected $randomSalt = 'dzjnaihbafgireger%fzfzea$-eza19$*';

    /* CFA
    private $serverName = '192.168.5.60';*/
    /* HOME */
    private $host = 'localhost';
    private $database = 'covoiturage_final';
    private $login = 'admin';
    private $password = 'toor';
    private $port = '3306';
    public $conn;


    public function __construct() {

        $this->getConnection();
    }
    
   // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->database", $this->login, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }catch(PDOException $exception){
            error_log("Connection error: " . $exception->getMessage());
        }

        return $this->conn;
    }
    public function verify_User_and_Pass($user, $pass) {
        $rows = array();
        $stmt = $this->conn->prepare("SELECT * FROM Utilisateur WHERE email = ? AND motDePasse = ?");
        $stmt -> bindParam(1, $user, PDO::PARAM_STR);
        $password = sha1($pass.$this->randomSalt);
        $stmt -> bindParam(2, $password, PDO::PARAM_STR);
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

    public function refreshUser($userId) {
        return new User($this->getAllInfo($userId));
    }

    public function update_User($newUserData, $id, $oldPassword){
        $sql = "UPDATE Utilisateur 
                SET nom = ?, prenom = ?, email = ?, motDePasse = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        $stmt -> bindParam(1, $newUserData["nom"], PDO::PARAM_STR);
        $stmt -> bindParam(2, $newUserData["prenom"], PDO::PARAM_STR);
        $stmt -> bindParam(3, $newUserData["email"], PDO::PARAM_STR);
        if(empty($newUserData["mdp"])){
            $stmt -> bindParam(4, $oldPassword, PDO::PARAM_STR);
        } else {
            $passwordHashed = sha1($newUserData["mdp"].$this->randomSalt);
            if(sha1($newUserData["oldMdp"].$this->randomSalt) == $oldPassword){
                $stmt -> bindParam(4, $passwordHashed, PDO::PARAM_STR);
                unset($_SESSION["authentified"]);
            } else {
                return false;
            }
        }
        $stmt -> bindParam(5, $id, PDO::PARAM_INT);
        $stmt -> execute();
        $this->updateCar($newUserData, $id);
        $this->updateAdress($newUserData, $id);
        return true;
    }
    
    // Fo,ction de récupération des information du véhicule de l'user s'il en a un
		public function getVehicle($data){
			
			error_log("db->getVehicle: start ! ");
			
			$idUser = $data['idUser'];
			
			$result = null;
			
			$sql = "SELECT V.id, V.marque, V.modele, V.place, V.couleur FROM `Voiture` V
			INNER JOIN `Utilisateur` U ON U.voiture = V.id
			WHERE U.id = :idUser;"; 
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
			$stmt->execute();
			
			if($stmt->rowCount() > 0){
				
				$result = $stmt->fetchObject();
				
			}
			else{
				
				$result['response'] = "KO";
				
			}
			
			$this->closeConnection();
			
			return $result;
			
		}	
    // Fonction de modification d'information véhicule depuis les paramètres
		public function updateCar($data, $idUser){

			$marque = $data['marque'];
			$modele = $data['modele'];
			$couleur = $data['couleur'];
			$place = $data['nbPLace'];

			$sql = "UPDATE `Voiture` V INNER JOIN `Utilisateur` U ON V.id = U.voiture SET V.modele = :modele, V.marque = :marque, V.place = :place, V.couleur = :couleur WHERE U.id = :idUser;";

			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':marque', $marque, PDO::PARAM_STR);
				$stmt->bindParam(':modele', $modele, PDO::PARAM_STR);
				$stmt->bindParam(':place', $place, PDO::PARAM_INT);
				$stmt->bindParam(':couleur', $couleur, PDO::PARAM_STR);
				$stmt->execute();
			}
			catch(SQLException $e) {
				error_log("SQL ERROR : ".$e->getMessage());
				return false;
			}
			
			return true;
		}

		// Fonction de modification des coordonnées depuis les paramètres
		public function updateAdress($data, $idUser){

			$nomRue = $data['nomRue'];
			$numeroRue = $data['numRue'];
			$ville = $data['ville'];
			$codePostal = $data['codePostal'];
			
			$sql = "UPDATE `Adresse` A INNER JOIN `Utilisateur` U ON A.id = U.adresse SET A.numeroRue = :numeroRue, A.nomRue = :nomRue, A.ville = :ville, A.codePostal = :codePostal WHERE U.id = :idUser;";

			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':numeroRue', $numeroRue, PDO::PARAM_STR);
				$stmt->bindParam(':nomRue', $nomRue, PDO::PARAM_STR);
				$stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
				$stmt->bindParam(':codePostal', $codePostal, PDO::PARAM_STR);
				$stmt->execute();
			}
			catch(SQLException $e) {
				error_log("SQL ERROR : ".$e->getMessage());
				return false;			
			}
			
			return true;
		}
    
    public function getAllInfo($id) {
        $sql = "SELECT Utilisateur.id,Utilisateur.nom,Utilisateur.prenom,Utilisateur.email,Utilisateur.motDePasse,Adresse.numeroRue,Adresse.nomRue,Adresse.codePostal,Adresse.ville,Voiture.marque,Voiture.modele,Voiture.place,Voiture.couleur FROM Utilisateur
                INNER JOIN Adresse ON Utilisateur.adresse = Adresse.id
                INNER JOIN Voiture ON Utilisateur.voiture = Voiture.id
                WHERE Utilisateur.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindParam(1, $id);
        $stmt -> execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData;
    }

    public function get_DB(){
        if ($this->pdo instanceof PDO) {
            return $this->conn;
        }
    }

// Fermeture de connection
    public function closeConnection(){
        
        return $this->conn=null;
        
    }

// Récupération de la liste des trajets disponible
    public function getListTrip(){
        
        error_log("db->getListTrip: start ! ");
                
        $sql = "SELECT T.id, T.dateParcours, T.heureDepart, T.heureArrivee, T.placeDisponible, Ld.lieu as villeDepart, La.lieu as villeArrivee, U.nom as nom, U.prenom as prenom, V.marque as marque, V.modele as modele, V.couleur as couleur, V.place as place 
                FROM Trajet T
                INNER JOIN Lieu Ld ON T.lieuDepart = Ld.id
                INNER JOIN Lieu La ON T.lieuArrivee = La.id
                INNER JOIN Utilisateur U ON T.idConducteur = U.id
                INNER JOIN Voiture V ON U.voiture = V.id
                WHERE T.status = 'ACTIF'
                AND T.placeDisponible > (SELECT count(*) FROM Reservation R WHERE R.trajet = T.id AND R.status = 'ACTIF')
                ORDER BY T.id ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }
        
        $this->closeConnection();
        
        return $result;
        
    }
} 
