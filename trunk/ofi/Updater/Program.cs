using System;
using System.Collections.Generic;
using System.Windows.Forms;
using System.IO;

namespace Updater
{
    static class Program
    {
        /// <summary>
        /// Point d'entrée principal de l'application.
        /// </summary>
        [STAThread]
        static void Main(String[] args)
        {
            if ( args.Length != 3 )
            {
                MessageBox.Show( 
                    "Utilisation :\r\n"+
                    "\r\n"+
                    "Updater URL_Version Version_Installée URL_Installeur\r\n"+
                    "\r\n"+
                    "Exemple : Updater http://site.com/version_truc.txt 23 http://site.com/install_truc.exe \r\n"+
                    "version_truc.txt doit contenir uniquement un numéro de version.") ;
                return ;
            }
            if ( args.Length == 3 )
            {
                Application.EnableVisualStyles() ;
                Application.SetCompatibleTextRenderingDefault( false ) ;
                Application.Run( new Form1(args) ) ;
            }
        }
    }
}