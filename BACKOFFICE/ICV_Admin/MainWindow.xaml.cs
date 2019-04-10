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
            try
            {
                DBHandler db = new DBHandler();
                Boolean isConnected = db.TryLogin(textBoxLogin.Text, textBoxPassword.Password.ToString());

                if (isConnected)
                {

                    this.Hide();

                    home accueil = new home();
                    accueil.Show();
                    this.Close();

                }
                else
                {

                    MessageBox.Show("Identifiants incorrect !", "Erreur de connexion", MessageBoxButton.OK, MessageBoxImage.Error);

                }


            }
            catch (Exception ex)
            {
                MessageBox.Show("Impossible d'établir une connexion ! " + ex);
            }
        }
    }
}
