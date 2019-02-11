<?php
include "DBHandler.class.php";
include "currentUser.class.php";

class User {
    
    
    private $currentUserId;
    private $currentUserNom;
    private $currentUserPrenom;
    private $currentUserEmail;
    private $currentUserMotDePasse;

    public function __construct($row){
        while($row) {
            $this->currentUserId = $row['id'];
            $this->currentUserNom = $row['nom'];
            $this->currentUserPrenom = $row['prenom'];
            $this->currentUserEmail = $row['email'];
            $this->currentUserMotDePasse = $row['motDePasse'];
        }
        
    }
    function log_User_Out() {
        if(isset($_SESSION['status'])) {
            unset($_SESSION['status']);
            unset($_SESSION['email']);
            if(isset($_COOKIE[session_name()])) 
                setcookie(session_name(), '', time() - 1000);
                session_destroy();
        }
    }
    
    function confirm_Member() {
        session_start();
        if($_SESSION['status'] !='autorise') header("location: ../login.php");
    }
    
    public function getInfo($result){
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

}