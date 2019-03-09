<?php
include "DBHandler.class.php";
include "currentUser.class.php";

class User {
    
    private $currentUserId;
    private $currentUserNom;
    private $currentUserPrenom;
    private $currentUserEmail;
    private $currentUserMotDePasse;
    private $currentUserNumRue;
    private $currentUserNomRue;
    private $currentUserVille;
    private $currentUserCodePostal;
    private $currentUserMarque;
    private $currentUserModele;
    private $currentUserNbPlace;
    private $currentUserCouleur;
    private $currentRole;
    private $currentLieuDepart;
    private $currentLieuArrivee;

    public function __construct($result){
        $this->currentUserId = (int) $result["id"];
        $this->currentUserNom = (string) $result["nom"];
        $this->currentUserPrenom = (string) $result["prenom"];
        $this->currentUserEmail = (string) $result["email"];
        $this->currentUserMotDePasse = (string) $result["motDePasse"];
        $this->currentUserNumRue = (int) $result["numeroRue"];
        $this->currentUserNomRue = (string) $result["nomRue"];
        $this->currentUserVille = (string) $result["ville"];
        $this->currentUserCodePostal = (int) $result["codePostal"];
        $this->currentUserMarque = (string) $result["marque"];
        $this->currentUserModele = (string) $result["modele"];
        $this->currentUserNbPlace = (int) $result["place"];
        $this->currentUserCouleur = (string) $result["couleur"];        
        $this->currentRole = (string) $result["role"];        
        $this->currentLieuDepart = (string) $result["lieuDepart"];        
        $this->currentLieuArrivee = (string) $result["lieuArrivee"];        
    }
    public function log_User_Out() {
        if(isset($_SESSION['status'])) {
            unset($_SESSION['status']);
            unset($_SESSION['email']);
            if(isset($_COOKIE[session_name()])) 
                setcookie(session_name(), '', time() - 1000);
                session_destroy();
        }
    }
    
    public function confirm_Member() {
        if(isset($_SESSION['userObject'])) return header("location: ../index.php");
    }
    
    public function getInfo($result){
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function getAllInfo(){
        $allInfo = array($this->currentUserId,$this->currentUserNom,$this->currentUserPrenom,$this->currentUserEmail,$this->currentUserEmail,$this->currentUserMotDePasse,$this->currentUserNumRue,$this->currentUserNomRue,$this->currentUserVille,$this->currentUserCodePostal,$this->currentUserMarque,$this->currentUserModele,$this->currentUserNbPlace,$this->currentUserCouleur);
        return $allInfo;
    }
    public function getId() {
        return $this->currentUserId;        
    }
    public function getNom() {
        return $this->currentUserNom;
    }
    public function getPrenom() {
        return $this->currentUserPrenom;
    }
    public function getEmail() {
        return $this->currentUserEmail;
    }
    public function getMDP() {
        return $this->currentUserMotDePasse;
    }
    public function getVille() {
        return $this->currentUserVille;
    }
    public function getNomRue() {
        return $this->currentUserNomRue;
    }
    public function getNumRue() {
        return $this->currentUserNumRue;
    }
    public function getCP() {
        return $this->currentUserCodePostal;
    }
    public function getMarque() {
        return $this->currentUserMarque;
    }
    public function getModele() {
        return $this->currentUserModele;
    }
    public function getNbPLace() {
        return $this->currentUserNbPlace;
    }
    public function getCouleur() {
        return $this->currentUserCouleur;
    }
    public function getRole() {
        return $this->currentRole;
    }
    public function getLieuDepart() {
        return $this->currentLieuDepart;
    }
    public function getLieuArrivee() {
        return $this->currentLieuArrivee;
    }
}