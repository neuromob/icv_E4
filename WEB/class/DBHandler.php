<?php

	require 'function.php';

	class Database{

		// Ne pas oublier de changer l'ip après l'avoir vérifié
		// specify your own database credentials
		// private $host = "192.168.5.60";
		private $host = "localhost";
		private $db_name = "covoiturage_final";
		private $username = "admin";
		private $password = "toor";
		public $conn;

		function __construct() {
			
			$this->getConnection();
			
		}
		
		// get the database connection
		public function getConnection(){

			$this->conn = null;

			try{
				$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
				$this->conn->exec("set names utf8");
			}catch(PDOException $exception){
				error_log("Connection error: " . $exception->getMessage());
			}

			return $this->conn;
		}
		
		// Fermeture de connection
		public function closeConnection(){
			
			return $this->conn=null;
			
		}
		
		// Fonction login
		public function loginUser($data){
			
			error_log("/loginUser: start !! ");
		
			$mail = $data['mail'];
			$password = $data['password'];
			
			error_log('mail: '.$mail);
			error_log('password: '.$password);
			
			$sql= "SELECT id, nom, prenom, email FROM Utilisateur WHERE email LIKE :mail AND motDePasse LIKE :password;"; 
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':mail', $mail, PDO::PARAM_STR); 
			$stmt->bindParam(':password', $password, PDO::PARAM_STR); 
			$stmt->execute();
			
			$list = array();
			
			error_log('test result: ' . $stmt->rowCount());
			
			if($stmt->rowCount() == 1){
				
				$list['response'] = 'OK';
				
				while ($row = $stmt->fetchObject()) {
				
				   $list['id'] = $row->id;
				   $list['nom'] = $row->nom;
				   $list['prenom'] = $row->prenom;
				   $list['email'] = $row->email;
				 
					$this->closeConnection();
					
					return $list;
				 
				}
				
			}
			else{
				
				$list['response'] = 'KO';
				
				$this->closeConnection();
				
				return $list;
				
			}
			
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
			
		
		// Récupération de la liste des trajets disponible que l'user n'a pas crée et n'a pas déjà réservé
		public function getListTrip($data){
			
			error_log("db->getListTrip: start ! ");			
			
			$idUser = json_decode($data[0]['idUser']);
			
			$result = null;
			
			$sql = "SELECT T.id, T.dateParcours, T.heureDepart, T.heureArrivee, T.placeDisponible, Ld.lieu as villeDepart, La.lieu as villeArrivee FROM Trajet T
					INNER JOIN Lieu Ld ON T.lieuDepart = Ld.id
					INNER JOIN Lieu La ON T.lieuArrivee = La.id
                    LEFT OUTER JOIN Reservation R ON R.trajet = T.id
					WHERE T.status = 'ACTIF'
                    AND T.placeDisponible > (SELECT COUNT(*) FROM Reservation R WHERE R.trajet = T.id AND R.status = 'ACTIF')	
                    AND T.idConducteur NOT LIKE :idUser
                    AND R.idUtilisateur NOT LIKE :idUser
					ORDER BY T.id ASC"; 
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
			$stmt->execute();
			
			if($stmt->rowCount() > 0){
				
				$result = $stmt->fetchAll();
				
			}
			else{
				
				$result['response'] = "KO";
				
			}
			
			$this->closeConnection();
			
			return $result;
			
		}
		
		// Récupération de la liste des trajets réservé par l'user mais n'a pas crée
		public function getListOfReservedTrips($data){
			
			error_log("db->getListOfReservedTrips: start ! ");
			
			// IdUser est dans un jsonArray, dans notre cas, dans un array au premier indice du jsonArray
			$idUser = $data[0]['idUser']; 
			
			$result = null;
			
			$sql = "SELECT T.idConducteur, T.dateParcours, T.heureDepart, T.heureArrivee, L.lieu as villeDepart, L2.lieu as villeArrivee, T.placeDisponible FROM `Reservation` R
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
			
			$result = $stmt->fetchAll();
			
			$this->closeConnection();
			
			return $result;
			
		}
		
		// Récupération de la liste des trajets crées
		public function getMyListOfCreatedTrips($data){
			
			error_log("db->getMyListOfCreatedTrips: start ! ");
			
			// IdUser est dans un jsonArray, dans notre cas, dans un array au premier indice du jsonArray
			$idUser = $data[0]['idUser']; 
			
			error_log('idUser ' . $idUser);		
			
			$result = null;
			
			$sql = "SELECT T.id, T.dateParcours, T.heureDepart, T.heureArrivee, T.placeDisponible, Ld.lieu as villeDepart, La.lieu as villeArrivee FROM Trajet T
					INNER JOIN Lieu Ld ON T.lieuDepart = Ld.id
					INNER JOIN Lieu La ON T.lieuArrivee = La.id
					WHERE T.status = 'ACTIF'
					AND T.idConducteur = 2
					ORDER BY T.id ASC"; 
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
			$stmt->execute();
			
			$result = $stmt->fetchAll();
			
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
		
		// Fonction récupération d'information concernant un trajet
		public function getTripInfos($data){
			
			$idUser = $data['idUser'];
			$idTrip = $data['idTrip'];

			error_log("db->getMyProfil: start ! ");
			error_log("db->getMyProfil: idUser= ".$idUser);			

			$result = null;
			
			$sql = "SELECT T.id, T.idConducteur, U.nom , T.dateParcours, T.heureDepart, T.heureArrivee, T.placeDisponible, L.lieu as villeDepart, L2.lieu as villeArrivee
			FROM `Trajet` T
			INNER JOIN Utilisateur U ON T.idConducteur = U.id
			INNER JOIN Lieu L ON T.lieuDepart = L.id
			INNER JOIN Lieu L2 ON T.lieuArrivee = L2.id
			WHERE T.id = :idTrip";
			
			try{
				$stmt = $this->conn->prepare($sql);
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
		
		// Fonction de réservation de trajet
		public function reservation($data){
			
			$idUser = $data['idUser'];
			$idTrip = $data['idTrip'];

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
			
			$result['response'] = "OK";
		
			// Appel de la fonction création de lieu pour l'ajouter au prochain trajet
			$idLieuDepart = createPlace($data['lieu1']);
			$idLieuArrivee = createPlace($data['lieu2']);
		
			$sql = "INSERT INTO `Trajet` (idConducteur, dateParcours, heureDepart, heureArrivee, lieuDepart, lieuArrivee, placeDisponible, status) 
			VALUES (:idConducteur, :dateParcours, :heureDepart, :heureArrivee', :lieuDepart, :lieuArrivee, 'ACTIF');";
			
			try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idConducteur', $idConducteur, PDO::PARAM_INT);
				$stmt->bindParam(':dateParcours', $dateParcours, PDO::PARAM_STR);
				$stmt->bindParam(':heureDepart', $heureDepart, PDO::PARAM_STR);
				$stmt->bindParam(':heureArrivee', $heureArrivee, PDO::PARAM_STR);
				$stmt->bindParam(':status', $status, PDO::PARAM_STR);
				$stmt->bindParam(':lieuDepart', $idLieuDepart, PDO::PARAM_INT);
				$stmt->bindParam(':lieuArrivee', $idLieuArrivee, PDO::PARAM_INT);
				$stmt->bindParam(':placeDisponible', $placeDisponible, PDO::PARAM_INT);
				$stmt->execute();
				
			}
			catch(SQLException $e){
				
				$result['response'] = "KO";
				
			}
			
			$this->closeConnection();
			
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
				$idPlace = $conn->lastInsertId();
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
		public function deleteTrip($data){
			
			$idUser = $data['idUser'];
			$idTrip = $data['idTrip'];
			
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
		public function deleteReservation($data){
			
			$idUser = $data['idUser'];
			$idTrip = $data['idTrip'];
			
			$result['response'] = 'OK';
			
			$sql = "UPDATE `Reservation` SET `status` = 'STOP' WHERE trajet = :idTrip AND idUtilisateur = :idUser;
			SELECT placeDisponible FROM Trajet WHERE id = :idTrip AND status = 'STOP'";
			
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
		
		// Fonction de récupération d'information users
		public function getMyProfil($data){
			
			$idUser = $data['idUser'];

			error_log("db->getMyProfil: start ! ");
			error_log("db->getMyProfil: idUser= ".$idUser);			

			$result = null;
			
			$sql = "SELECT U.id, U.nom, U.prenom, U.email, A.numeroRue, A.nomRue, A.codePostal, A.ville, V.marque, V.modele, V.place, V.couleur FROM `Utilisateur` U
			LEFT OUTER JOIN Adresse A ON U.adresse = A.id
			LEFT OUTER JOIN Voiture V ON U.voiture = V.id
			WHERE U.id = :idUser
			LIMIT 1;"; 
			
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
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
		
		// Fonction de modification de MDP depuis les paramètres users
		public function updatePassword($data){
			
			error_log("db->updatePassword: start ! ");
			error_log("db->updatePassword: idUser= ".$idUser);
			
			$idUser = $data['idUser'];
			$oldPwd = $data['>oldPassword'];
			$newPwd = $data['newPassword'];
			
			$result = null;
			
			$sql = "SELECT nom FROM `Utilisateur` WHERE id = :idUser AND motDePasse = :oldPwd";
			
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':oldPwd', $oldPwd, PDO::PARAM_STR);
				$stmt->execute();
			}
			catch(SQLException $e) {				
				error_log("SQL ERROR : ".$e->getMessage());				
			}
			
			if($stmt->rowCount() > 0){				
				
				$sql2 = "UPDATE `Utilisateur` SET motDePasse = :newPwd WHERE id = :idUser";
			
				try{
					$stmt2 = $this->conn->prepare($sql2);
					$stmt2->bindParam(':idUser', $idUser, PDO::PARAM_INT);
					$stmt2->bindParam(':newPwd', $newPwd, PDO::PARAM_STR);
					$stmt2->execute();
				}
				catch(SQLException $e) {				
					error_log("SQL ERROR : ".$e->getMessage());				
				}
				
				if($stmt2->rowCount() > 0){				
				
					$result["response"] = "OK";
				
				}
				else {			
					$result['response'] = "KO";				
				}
				
			}
			else {			
				$result['response'] = "KO";				
			}
			error_log(print_r($result,true));				
			
			$this->closeConnection();
			
			return $result;
			
		}
		
		// Fonction de modification d'information user depuis les paramètres
		public function updateInfoUser($data){
			
			error_log("db->updateMyInfos: start ! ");
			error_log("db->updateMyInfos: idUser= ".$data['idUser']);
			
			$idUser = $data['idUser'];
			$nom = $data['nom'];
			$prenom = $data['prenom'];
			$email = $data['email'];
			
			$marque = $data['marque'];
			$modele = $data['modele'];
			$couleur = $data['couleur'];
			$place = $data['place'];
			
			$nomRue = $data['nomRue'];
			$numeroRue = $data['numeroRue'];
			$ville = $data['ville'];
			$codePostal = $data['codePostal'];
			
			$villeDepart = $data['villeDepart'];
			$villeArrivee = $data['villeArrivee'];
			
			$status = $data['status'];
			$role = $data['role'];
			
			$sql = "UPDATE `Utilisateur` SET nom = :nom, prenom = :prenom, email = :email, role = :role, status_active = :status, villeDepart = : villeDepart, villeArrivee = :villeArrivee WHERE id = :idUser";
			
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
				$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
				$stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				$stmt->bindParam(':villeDepart', $villeDepart, PDO::PARAM_STR);
				$stmt->bindParam(':villeArrivee', $villeArrivee, PDO::PARAM_STR);
				$stmt->bindParam(':status', $status, PDO::PARAM_INT);
				$stmt->bindParam(':role', $role, PDO::PARAM_INT);
				$stmt->execute();
			}
			catch(SQLException $e) {				
				error_log("SQL ERROR : ".$e->getMessage());
				return false;				
			}
			
			return true;
			
		}

		// Fonction de modification d'information véhicule depuis les paramètres
		public function updateCar($data){

			$idUser = $data['idUser'];
			$marque = $data['marque'];
			$modele = $data['modele'];
			$couleur = $data['couleur'];
			$place = $data['place'];
				
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
		public function updatetAdress($data){

			$idUser = $data['idUser'];
			$nomRue = $data['nomRue'];
			$numeroRue = $data['numeroRue'];
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
		
	}
	
?>