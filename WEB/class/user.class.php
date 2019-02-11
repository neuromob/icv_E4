<?php
include "DBHandler.class.php";
include "currentUser.class.php";

class User {
    
    
    private $currentUserId;
    private $currentUserNom;
    private $currentUserPrenom;
    private $currentUserEmail;
    private $currentUserMotDePasse;
    private $currentUserPays;
    private $currentUserVille;
    private $currentUserCodePostal;

    public function __construct($result){
        $this->currentUserId = $result["id"];
        $this->currentUserNom = $result["nom"];
        $this->currentUserPrenom = $result["prenom"];
        $this->currentUserEmail = $result["email"];
        $this->currentUserMotDePasse = $result["motDePasse"];
        $this->currentUserPays = $result["pays"];
        $this->currentUserVille = $result["ville"];
        $this->currentUserCodePostal = $result["code_postal"];
        
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
    public function getPays() {
        return $this->currentUserPays;
    }
    public function getVille() {
        return $this->currentUserVille;
    }
    public function getCP() {
        return $this->currentUserCodePostal;
    }
}