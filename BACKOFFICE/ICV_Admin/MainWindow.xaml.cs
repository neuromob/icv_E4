using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace ICV_Admin
{
    /// <summary>
    /// Logique d'interaction pour MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        delegate void MainDelagate(string str);
        

        public MainWindow()
        {
            InitializeComponent();

           /* Button2 = new Button
            {
                Content = "Bouton deux",
                Width = 200,
                Height = 100
            };
            Button2.Click += Button2_Click;

            GridWindow.Children.Add(Button2);

            FirstEvent += (str) =>
            {
                Label1.Content = str;
            };
            */

        }

        private void ButtonLogin_Click(object sender, RoutedEventArgs e)
        {
            Login();
        }

       private void ButtonQuit_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        private void GridWindow_KeyDown(object sender, KeyEventArgs e)
        {
            if(e.Key == Key.Enter)
            {
                Login();
            }
        }

        private void Login()
        {
            MySqlConnection connection = null;
            string connectionString = null;
            List<User> tempList = new List<User>();

            string salt = "dzjnaihbafgireger%fzfzea$-eza19$*";

            connectionString = "SERVER=localhost;PORT=3306;DATABASE=covoiturage;UID=root;PWD=;";
            connection = new MySqlConnection(connectionString);
            try
            {
                connection.Open();
                string password = textBoxPassword.Password.ToString() + salt;

                using (SHA1 sha1Hash = SHA1.Create())
                {
                    //From String to byte array
                    byte[] sourceBytes = Encoding.UTF8.GetBytes(password);
                    byte[] hashBytes = sha1Hash.ComputeHash(sourceBytes);
                    password = BitConverter.ToString(hashBytes).Replace("-", String.Empty);

                }
                MySqlCommand cmd = new MySqlCommand("SELECT * from utilisateur WHERE email='" + textBoxLogin.Text + "' AND motDePasse='" + password + "'", connection);

                MySqlDataReader reader = cmd.ExecuteReader();

                string login = null;

                while (reader.Read())
                {
                    User U = new User { ID = (int)reader["id"], Nom = (string)reader["nom"], Prenom = (string)reader["prenom"], Email = (string)reader["email"], Adresse = (int)reader["adresse"], Voiture = (int)reader["voiture"], Role = (string)reader["role"], Filiere = (int)reader["filiere"], LieuDepart = (int)reader["lieu_Depart"], LieuArrivee = (int)reader["lieu_Arrivee"], Status = (int)reader["status"] };
                    Main.CurrentUser = U;
                    tempList.Add(U);
                }
                connection.Close();

                if (Main.CurrentUser == null)
                {
                    MessageBox.Show("Invalid username or password!", "Error login", MessageBoxButton.OK, MessageBoxImage.Error);
                    return;
                }

                this.Hide();

                home accueil = new home();
                accueil.Show();
                this.Close();


            }
            catch (Exception ex)
            {
                MessageBox.Show("Can not open connection ! " + ex);
            }
        }
    }
}
