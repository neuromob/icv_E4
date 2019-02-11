<?php

class currentUser {
    protected $idUser;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $motDePasse;
    protected $pays;
    protected $ville;
    protected $cp;

    public function __construct($result){
        $this->idUser = $result['id'];
        $this->nom = $result['nom'];
        $this->prenom = $result['prenom'];
        $this->email = $result['email'];
        $this->motDePasse = $result['motDePasse'];
        $this->pays = $result['pays'];
        $this->ville = $result['ville'];
        $this->cp = $result['code_Postal'];
    }

    public function getId(){
        return $this->idUser;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getMotdepasse(){
        return $this->motDePasse;
    }
    public function getPays(){
        return $this->pays;
    }
    public function getVille(){
        return $this->ville;
    }
    public function getCodepostal(){
        return $this->cp;
    }
}