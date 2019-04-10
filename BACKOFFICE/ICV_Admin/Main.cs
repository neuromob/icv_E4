using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ICV_Admin
{
    public static class Main
    {
        public static User CurrentUser
        {
            get;
            set;
        }
        public class Filiere
        {
            public int ID;
            public string Nom;
            public string Type;
            public int NbrEleve;

            public Filiere(int ID, string Nom, string Type, int NbrEleve)
            {

                this.ID = ID;
                this.Nom = Nom;
                this.Type = Type;
                this.NbrEleve = NbrEleve;

            }

        }

        public class Eleve
        {

            public int ID;
            public string Nom;
            public string Prenom;
            public string Email;
            public int Adresse;
            public int Voiture;
            public string Role;
            public int Filiere;
            public int LieuDepart;
            public int LieuArrivee;
            public int Status;

            public Eleve(int ID, string Nom, string Prenom, string Email, int Adresse, int Voiture, string Role, int Filiere, int LieuDepart, int LieuArrivee, int Status)
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
}
