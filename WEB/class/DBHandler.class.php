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
		$this->getConnection();
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
		$this->getConnection();
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
			$this->getConnection();
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
			$this->getConnection();
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
			$this->getConnection();
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
		$this->getConnection();
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

	// Récupération de la liste des trajets disponible que l'user n'a pas crée et n'a pas déjà réservé
    public function getListTrip($idUser){
        $this->getConnection();
        error_log("db->getListTrip: start ! ");
       $sql = "SELECT T.id as idTrajet, T.idConducteur, T.dateParcours, T.heureDepart, T.heureArrivee, T.placeDisponible, Ld.lieu as villeDepart, La.lieu as villeArrivee, V.marque as marque, V.modele as modele, V.place as place, V.couleur as couleur, U.nom as nom, U.prenom as prenom FROM Trajet T
				INNER JOIN Lieu Ld ON T.lieuDepart = Ld.id
				INNER JOIN Lieu La ON T.lieuArrivee = La.id
				INNER JOIN Utilisateur U ON T.idConducteur = U.id
				INNER JOIN Voiture V ON U.id = V.id
				WHERE T.status = 'ACTIF'
				AND T.placeDisponible > (SELECT COUNT(*) FROM Reservation R WHERE R.trajet = T.id AND R.status = 'ACTIF')    
				AND T.idConducteur NOT LIKE :idUser
				AND NOT EXISTS (SELECT * FROM Reservation R WHERE R.trajet = T.id AND R.idUtilisateur LIKE :idUser AND R.status LIKE 'ACTIF')
				ORDER BY T.id ASC"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } else {
			return "error with : ".$sql;
		}
        
        $this->closeConnection();
        
        return $result;
        
	}

	public function getTripInfoById($id) {
		$this->getConnection();
		$sql = "SELECT T.dateParcours, T.heureDepart, T.heureArrivee, Ld.lieu as villeDepart, La.lieu as villeArrivee, V.marque as marque, V.modele as modele, V.couleur as couleur, U.nom as nom, U.prenom as prenom FROM Trajet T
		INNER JOIN Lieu Ld ON T.lieuDepart = Ld.id
		INNER JOIN Lieu La ON T.lieuArrivee = La.id
		INNER JOIN Utilisateur U ON T.idConducteur = U.id
		INNER JOIN Voiture V ON U.id = V.id
		WHERE T.id = :idTrajet
		LIMIT 1";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':idTrajet', $id, PDO::PARAM_INT);
		$stmt->execute();

		if($stmt->rowCount() > 0){
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }
        
        $this->closeConnection();
	}

	public function getRole($id){
		$this->getConnection();
		$sql = "SELECT R.nom FROM Role R INNER JOIN Utilisateur U ON U.role = R.id  WHERE U.id = :idUtilisateur LIMIT 1";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':idUtilisateur', $id, PDO::PARAM_INT);
		$stmt->execute();

		if($stmt->rowCount() > 0){
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }
        
        $this->closeConnection();
        
		
	}
    // Fonction de réservation de trajet
		public function reservation($idUser,$idTrip){
			$this->getConnection();
			error_log("db->getMyProfil: start ! ");
			error_log("db->getMyProfil: idUser= ".$idUser);			

			$result = null;
			$result['response'] = "OK";
			$isStillAvailable = false;
			
			$sql = "SELECT placeDisponible FROM Trajet WHERE id = :idTrip AND status = 'ACTIF'";
			
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
				$stmt->execute();
			}
			catch(SQLException $e) {				
				error_log("SQL ERROR : ".$e->getMessage());				
			}
			
			if($stmt->rowCount() > 0){
				$row = $stmt->fetchObject();
				
				if($row->placeDisponible > 0){
					
					$sql2 = "INSERT INTO Reservation (trajet, idUtilisateur, status) VALUES (:idTrip, :idUser, 'ACTIF');";
					
					try{
						$stmt2 = $this->conn->prepare($sql2);
						$stmt2->bindParam(':idUser', $idUser, PDO::PARAM_INT);
						$stmt2->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
						$stmt2->execute();
					}
					catch(SQLException $e) {				
						error_log("SQL ERROR : ".$e->getMessage());		
						$result['response'] = "KO";
					}
					
					$sql3 = "UPDATE Trajet SET placeDisponible = placeDisponible - 1 WHERE id = :idTrip;";
					try{
						$stmt3 = $this->conn->prepare($sql3);
						$stmt3->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
						$stmt3->execute();
					}
					catch(SQLException $e) {				
						error_log("SQL ERROR : ".$e->getMessage());		
						$result['response'] = "KO";
					}
				}
				else{
					
					$result['response'] = "KO_no_place";
					
				}
			}
			
			$this->closeConnection();
			
			return $result;
			
		}
		
		// Fonction de création de Trajet + 2 appels de la fonction de création de Lieu
		public function createTrip($data){
			
			error_log("db->createTrip: start ! ");
			
			$idConducteur = $data['idUser'];
			$placeDisponible = $data['placeDisponible'];
			$dateParcours = $data['dateParcours'];
			$heureDepart = $data['heureDepart'];
            $heureArrivee = $data['heureArrivee'];
            $status = 'ACTIF';
			
            $lieu1 = $this->placeIsCreate($data['lieu1']);
            $lieu2 = $this->placeIsCreate($data['lieu2']);
            

		    // Appel de la fonction création de lieu pour l'ajouter au prochain trajet
            if($lieu1 == false){
                $idLieuDepart = $this->createPlace($data['lieu1']);
                $idLieuDepart = intval($idLieuDepart);
            } else {
                $idLieuDepart = $lieu1["id"];
                $idLieuDepart = intval($idLieuDepart);
            }

            if($lieu2 == false){
                $idLieuArrivee = $this->createPlace($data['lieu2']);
                $idLieuArrivee = intval($idLieuArrivee);
            } else {
                $idLieuArrivee = $lieu2["id"];
                $idLieuArrivee = intval($idLieuArrivee);
            }
			
			$sql = "INSERT INTO `Trajet` (`idConducteur`, `dateParcours`, `heureDepart`, `heureArrivee`, `lieuDepart`, `lieuArrivee`, `placeDisponible`, `status`) 
			VALUES (:idConducteur, :dateParcours, :heureDepart, :heureArrivee, :lieuDepart, :lieuArrivee, :placeDisponible, :stats);";
			
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindValue(':idConducteur', $idConducteur, PDO::PARAM_INT);
				$stmt->bindValue(':dateParcours', $dateParcours, PDO::PARAM_STR);
				$stmt->bindValue(':heureDepart', $heureDepart, PDO::PARAM_STR);
				$stmt->bindValue(':heureArrivee', $heureArrivee, PDO::PARAM_STR);
				$stmt->bindValue(':lieuDepart', $idLieuDepart, PDO::PARAM_INT);
				$stmt->bindValue(':lieuArrivee', $idLieuArrivee, PDO::PARAM_INT);
				$stmt->bindValue(':placeDisponible', $placeDisponible, PDO::PARAM_INT);
                $stmt->bindValue(':stats', $status, PDO::PARAM_STR);
				$stmt->execute();
				
			}
			catch(SQLException $e){
                
                echo 'Problem with: '.$sql;
                print_r($e); 
				$result['response'] = "KO";
				
			}
			
			$this->closeConnection();
			
			return $result;
			
		}
        
        public function placeIsCreate($stringLieu) {
            error_log("db->createPlace: start ! ");
			
            $sql = "SELECT id, lieu FROM Lieu WHERE lieu = :stringLieu";
            try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':stringLieu', $stringLieu, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(SQLException $e){
                error_log("SQL ERROR : ".$e->getMessage());
                return false;
            }
            
			return $result;
			
			
        }
        
		/*
		* Fonction de création de Lieu appelé depuis createTrip afin de créer un Lieu avant de créer un trajet
		* Elle renvoie l'id de la dernière insertion effectuée
		* pratique mais dangereux dans le cas où 2 personnes en même temps font un insert ou un updateCar
		* mais à petite echelle ce risque est faible
		*/
		public function createPlace($lieu){
			
			error_log("db->createPlace: start ! ");
			
			$sql = "INSERT INTO `Lieu` (lieu) VALUES (:lieu);";
			
			try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':lieu', $lieu, PDO::PARAM_STR);
				$stmt->execute();
				$idPlace = $this->conn->lastInsertId();
			}
			catch(SQLException $e){
				
				$result['response'] = "KO";
				
			}

			return $idPlace;
			
		}
		
		/*
		* Fonction de suppression de voyage
		* Il faut créer les notifications pour avertir les users concernés que le voyage a été supprimé
		*/
		public function deleteTrip($idUser, $idTrip){
			$this->getConnection();
			
			$result['response'] = 'OK';
			
			$sql = "UPDATE `Trajet` SET status = 'STOP' WHERE id = :idTrip AND idConducteur = :idUser;";
			
			try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
				$stmt->execute();
				
				deleteReservationOfCreatedTripByUser($idTrip);
			}
			catch(SQLException $e){
				
				$result['response'] = "KO";
				
			}
			
			return $result;
			
		}
		
		/*
		* Fonction de suppression des réservations lié au trajet supprimé
		*/
		public function deleteReservationOfCreatedTripByUser($idTrip){
			
			$sql = "UPDATE `Reservation` SET status = 'STOP' WHERE trajet = :idTrip;";
			
			try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
				$stmt->execute();
				
			}
			catch(SQLException $e){
				
				$result['response'] = "KO";
				
			}
			
			return $result;
			
		}
		
		/*
		* Fonction de restauration de voyage
		* Il faut créer les notifications pour avertir les users concernés que le voyage a été supprimé
		*/
		public function restoreTrip($data){
			
			$idUser = $data['idUser'];
			$idTrip = $data['idTrip'];
			
			$result['response'] = 'OK';
			
			$sql = "UPDATE `Trajet` SET status = 'ACTIF' WHERE id = :idTrip AND idConducteur = :idUser;";
			
			try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
				$stmt->execute();
				
				restoreReservationOfCreatedTripByUser($idTrip);
				
			}
			catch(SQLException $e){
				
				$result['response'] = "KO";
				
			}
			
			return $result;
			
		}
		
		/*
		* Fonction de suppression des réservations lié au trajet supprimé
		*/
		public function restoreReservationOfCreatedTripByUser($idTrip){
			
			$sql = "UPDATE `Reservation` SET status = 'ACTIF' WHERE trajet = :idTrip;";
			
			try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
				$stmt->execute();
				
			}
			catch(SQLException $e){
				
				$result['response'] = "KO";
				
			}
			
			return $result;
			
		}
		
		/*
		* Fonction de suppression de reservation
		* Elle met a jour aussi le nombre de place disponible pour le voyage s'il n'a pas été supprimé
		*/
		public function deleteReservation($idUser, $idTrip, $idConducteur){
			$this->getConnection();			
			$result['response'] = 'OK';
			
			$sql = "UPDATE `Reservation` SET `status` = 'STOP' WHERE trajet = :idTrip AND idUtilisateur = :idUser;
			UPDATE Trajet SET placeDisponible = placeDisponible + 1 WHERE id = :idTrip AND idConducteur = :idConducteur";
			
			try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
				$stmt->bindParam(':idConducteur', $idConducteur, PDO::PARAM_INT);
				$stmt->execute();
			}
			catch(SQLException $e){
				$result['response'] = "KO";
				
			}
						
			return $result;
			
		}
		/*
		* Fonction de restauration de reservation
		* Elle met a jour aussi le nombre de place disponible pour le voyage s'il n'a pas été supprimé
		*/
		public function restoreReservation($data){
			
			$idUser = $data['idUser'];
			$idTrip = $data['idTrip'];
			
			$result['response'] = 'OK';
			
			$sql = "UPDATE `Reservation` SET `status` = 'ACTIF' WHERE trajet = :idTrip AND idUtilisateur = :idUser;
			SELECT placeDisponible FROM Trajet WHERE id = :idTrip AND status = 'ACTIF'";
			
			try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
				$stmt->execute();
			}
			catch(SQLException $e){
				
				$result['response'] = "KO";
				
			}
						
			return $result;
			
        }
		
		// Récupération de la liste des trajets réservé par l'user mais n'a pas crée
		public function getListOfReservedTrips($idUser){
			$this->getConnection();
			error_log("db->getListOfReservedTrips: start ! ");
			
			// IdUser est dans un jsonArray, dans notre cas, dans un array au premier indice du jsonArray
			
			$result = null;
			
			$sql = "SELECT T.idConducteur, T.id, T.dateParcours, T.heureDepart, T.heureArrivee, L.lieu as villeDepart, L2.lieu as villeArrivee, T.placeDisponible FROM `Reservation` R
			INNER JOIN `Trajet` T ON R.trajet = T.id
			INNER JOIN `Lieu` L ON T.lieuDepart = L.id
			INNER JOIN `Lieu` L2 ON T.lieuArrivee = L2.id 
			WHERE R.idUtilisateur = :idUser
            AND T.idConducteur NOT LIKE :idUser
			AND R.status = 'ACTIF'
			AND T.status = 'ACTIF';"; 
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
			$stmt->execute();
			
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$this->closeConnection();
			
			return $result;
			
		}
		
		// Récupération de la liste des trajets crées
		public function getMyListOfCreatedTrips($idUser){
			
			error_log("db->getMyListOfCreatedTrips: start ! ");
			
			// IdUser est dans un jsonArray, dans notre cas, dans un array au premier indice du jsonArray
			//$idUser = $data[0]['idUser']; 
			
			error_log('idUser ' . $idUser);		
			
			$result = null;
			
			$sql = "SELECT T.id, T.dateParcours, T.heureDepart, T.heureArrivee, T.placeDisponible, Ld.lieu as villeDepart, La.lieu as villeArrivee, T.status as status FROM Trajet T
					INNER JOIN Lieu Ld ON T.lieuDepart = Ld.id
					INNER JOIN Lieu La ON T.lieuArrivee = La.id
					WHERE T.status = 'ACTIF'
					AND T.idConducteur = :idUser
					ORDER BY T.id ASC"; 
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
			$stmt->execute();
			
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$this->closeConnection();
			
			return $result;
			
		}
		
		// Fonction de récupération de la liste des personnes qui ont réservé mon trajet
		public function getListOfPersonFromReservedTrip($data){
			
			// IdUser est dans un jsonArray, dans notre cas, dans un array au premier indice du jsonArray
			$idUser = $data[0]['idUser']; 
			$idTrip = $data[0]['Trip']; 
			
			error_log("db->getListOfPersonFromReservedTrip: start ! ");
			error_log("db->getListOfPersonFromReservedTrip: idUser= ".$idUser);	
			
			$result = null;
			
			$sql = "SELECT U.nom, U.prenom FROM `Reservation` R
			INNER JOIN Utilisateur U ON U.id = R.idUtilisateur
			INNER JOIN Trajet T ON T.id = R.trajet
			WHERE T.id = :idTrip
            AND T.idConducteur NOT LIKE :idUser
			AND T.status LIKE 'ACTIF'
			AND R.status LIKE 'ACTIF'";
			
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
				$stmt->execute();
			}
			catch(SQLException $e) {				
				error_log("SQL ERROR : ".$e->getMessage());				
			}
			
			if($stmt->rowCount() > 0){				
				$result = $stmt->fetchObject();				
			}
			else {			
				$result['response'] = "KO";				
			}
			error_log(print_r($result,true));				
			
			$this->closeConnection();
			
			return $result;			
			
		}
} 
