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
            InitializeFiliere();
            frame.NavigationService.Navigate(new PageFiliere());
            ButtonFiliere.IsEnabled = false;
        }

        private void InitializeUser()
        {
            Username.Content = "Bienvenue " + Main.CurrentUser.Nom;
            
        }

        private void InitializeFiliere()
        {

        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {

        }

   
        private void AddEleve_Navigated(object sender, System.Windows.Navigation.NavigationEventArgs e)
        {
        }

        private void Button_Click_1(object sender, RoutedEventArgs e)
        {

        }

        private void Button_Click_2(object sender, RoutedEventArgs e)
        {
            ButtonFiliere.IsEnabled = false;
            ButtonApprentis.IsEnabled = true;
            frame.NavigationService.Navigate(new PageFiliere());
            return;
        }

        private void Button_Click_3(object sender, RoutedEventArgs e)
        {
            ButtonApprentis.IsEnabled = false;
            ButtonFiliere.IsEnabled = true;
            frame.NavigationService.Navigate(new PageApprentis());
            return;
        }
    }
}
