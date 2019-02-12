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

    public function __construct($result){
        $this->currentUserId = $result["id"];
        $this->currentUserNom = $result["nom"];
        $this->currentUserPrenom = $result["prenom"];
        $this->currentUserEmail = $result["email"];
        $this->currentUserMotDePasse = $result["motDePasse"];
        $this->currentUserNumRue = $result["numeroRue"];
        $this->currentUserNomRue = $result["nomRue"];
        $this->currentUserVille = $result["ville"];
        $this->currentUserCodePostal = $result["codePostal"];
        $this->currentUserMarque = $result["marque"];
        $this->currentUserModele = $result["modele"];
        $this->currentUserNbPlace = $result["place"];
        $this->currentUserCouleur = $result["couleur"];        
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
}