using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using static ICV_Admin.Main;

namespace ICV_Admin
{
    class DBHandler
    {
        string connectionString = "SERVER=localhost;PORT=3306;DATABASE=covoiturage_final;UID=root;PWD=;";
        public MySqlConnection connection;

        string salt = "dzjnaihbafgireger%fzfzea$-eza19$*";

        public DBHandler()
        {

            this.connection = new MySqlConnection(connectionString);

        }

        public String encryptPassword(String password)
        {
            String encryptedPassword = null;

            using (SHA1 sha1Hash = SHA1.Create())
            {

                //From String to byte array
                byte[] sourceBytes = Encoding.UTF8.GetBytes(password);
                byte[] hashBytes = sha1Hash.ComputeHash(sourceBytes);
                encryptedPassword = BitConverter.ToString(hashBytes).Replace("-", String.Empty);

            }

            return encryptedPassword;

        }

        public Boolean TryLogin(String identifiant, String password)
        {

            connection.Open();

            string encrytedPassword = encryptPassword(password + this.salt);

            string sql = "SELECT * from Utilisateur WHERE email = @id AND motDePasse = @psswd LIMIT 1";

            MySqlCommand command = new MySqlCommand(sql, connection);

            command.Parameters.AddWithValue("@id", identifiant);
            command.Parameters.AddWithValue("@psswd", encrytedPassword);

            command.Prepare();
            MySqlDataReader reader = command.ExecuteReader();

            // Création de l'objet U de la classe User avec le résultat de la requête et sauvegarde de l'objet dans la classe Main.cs : CurrentUser
            while (reader.Read())
            {
                User U = new User(
                    reader.GetInt32("id"),
                    reader.GetString("nom"),
                    reader.GetString("prenom"),
                    reader.GetString("email"),
                    reader.GetInt32("adresse"),
                    reader.GetInt32("voiture"),
                    reader.GetString("role"),
                    reader.GetInt32("filiere"),
                    reader.GetInt32("lieu_Depart"),
                    reader.GetInt32("lieu_Arrivee"),
                    reader.GetInt32("status")
                    );

                Main.CurrentUser = U;
            }

            connection.Close();

            if (Main.CurrentUser == null)
            {

                return false;

            }

            return true;

        }

        public List<Filiere> GetListeFiliere()
        {

            List<Filiere> listeFiliere = new List<Filiere>();

            connection.Open();

            string sql = "SELECT F.id, F.nom, F.type, COUNT(*) as nombreEleve FROM Utilisateur U LEFT OUTER JOIN Filiere F ON F.id = U.filiere GROUP BY U.filiere ";

            MySqlCommand command = new MySqlCommand(sql, connection);

            command.Prepare();
            MySqlDataReader reader = command.ExecuteReader();

            // Création de l'objet U de la classe User avec le résultat de la requête et sauvegarde de l'objet dans la classe Main.cs : CurrentUser
            while (reader.Read())
            {
                Filiere F = new Filiere(
                    reader.GetInt32("id"),
                    reader.GetString("nom"),
                    reader.GetString("type"),
                    reader.GetInt32("nombreEleve")
                    );

                listeFiliere.Add(F);

            }

            connection.Close();

            return listeFiliere;

        }

        public List<Eleve> GetListeEleve()
        {
            List<Eleve> listeEleve = new List<Eleve>();

            connection.Open();

            string sql = "SELECT * from Utilisateur";

            MySqlCommand command = new MySqlCommand(sql, connection);

            command.Prepare();
            MySqlDataReader reader = command.ExecuteReader();

            // Création de l'objet U de la classe User avec le résultat de la requête et sauvegarde de l'objet dans la classe Main.cs : CurrentUser
            while (reader.Read())
            {
                Eleve E = new Eleve(
                    reader.GetInt32("id"),
                    reader.GetString("nom"),
                    reader.GetString("prenom"),
                    reader.GetString("email"),
                    reader.GetInt32("adresse"),
                    reader.GetInt32("voiture"),
                    reader.GetString("role"),
                    reader.GetInt32("filiere"),
                    reader.GetInt32("lieu_Depart"),
                    reader.GetInt32("lieu_Arrivee"),
                    reader.GetInt32("status")
                    );

                listeEleve.Add(E);

            }

            connection.Close();

            return listeEleve;
        }

        public int GetCompteurConducteur()
        {

            int compteurEleveConducteur = 0;

            connection.Open();

            string sql = "SELECT COUNT(*) as eleveConducteur FROM Utilisateur U INNER JOIN Role R ON R.id = U.role WHERE U.role = 3 OR U.role = 4";

            MySqlCommand command = new MySqlCommand(sql, connection);

            command.Prepare();
            MySqlDataReader reader = command.ExecuteReader();

            while (reader.Read())
            {

                compteurEleveConducteur = reader.GetInt32("eleveConducteur");

            }

            connection.Close();

            return compteurEleveConducteur;
        }

        public int GetCompteurPassager()
        {

            int compteurElevePassager = 0;

            connection.Open();

            string sql = "SELECT COUNT(*) as elevePassager FROM Utilisateur U INNER JOIN Role R ON R.id = U.role WHERE U.role = 2 OR U.role = 4";

            MySqlCommand command = new MySqlCommand(sql, connection);

            command.Prepare();
            MySqlDataReader reader = command.ExecuteReader();

            while (reader.Read())
            {

                compteurElevePassager = reader.GetInt32("elevePassager");

            }

            connection.Close();

            return compteurElevePassager;
        }
    }
}
