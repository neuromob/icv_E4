using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;

namespace ICV_Admin
{
    /// <summary>
    /// Logique d'interaction pour home.xaml
    /// </summary>
    public partial class home : Window
    {
        public home()
        {
            InitializeComponent();
            InitializeUser();
            
        }

        private void InitializeUser()
        {
            Username.Content = Main.CurrentUser.Nom;
            
        }

        private void InitializeFiliere()
        {
            filiere_Listbox.Items.Add("TEST");

        }

        private void ListBox_SelectionChanged(object sender, SelectionChangedEventArgs e)
        {

        }
    }
}
