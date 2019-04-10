using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ICV_Admin
{
    public class User
    {
        public int ID{get; set;}
        public string Nom{get; set;}
        public string Prenom {get; set;}
        public string Email {get; set;}
        public int Adresse{get; set;}
        public int Voiture{get; set;}
        public string Role {get; set;}
        public int Filiere{get; set;}
        public int LieuDepart{get; set;}
        public int LieuArrivee{get; set;}
        public int Status{get; set;}

        public User(int ID, string Nom, string Prenom, string Email, int Adresse, int Voiture, string Role, int Filiere, int LieuDepart, int LieuArrivee, int Status)
        {

            this.ID = ID;
            this.Nom = Nom;
            this.Prenom = Prenom;
            this.Email = Email;
            this.Adresse = Adresse;
            this.Voiture = Voiture;
            this.Role = Role;
            this.Filiere = Filiere;
            this.LieuDepart = LieuDepart;
            this.LieuArrivee = LieuArrivee;
            this.Status = Status;

        }
    }
}
