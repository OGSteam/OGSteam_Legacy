using System;
using System.Collections.Generic;
using System.Windows.Forms;

namespace OgameFarmingInterface
{
    static class Program
    {
        /// <summary>
        /// Point d'entrée principal de l'application.
        /// </summary>
        [STAThread]
        static void Main( string[] args )
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault( false );
            if ( args.Length >= 1 )
            {
                Application.Run( new FormPrincipale(args[0]) ) ;
            }
            else
            {
                Application.Run( new FormPrincipale() ) ;
            }
        }
    }
}