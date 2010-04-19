using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace OgameFarmingInterface
{
    public partial class FormRapportDErreur : Form
    {
        public FormRapportDErreur()
        {
            InitializeComponent();
            textBox1.Text = "Mackila est un gros boulet qui n'a pas passé l'exception à la fenetre d'affichage d'erreur :o !" ;
        }

        public FormRapportDErreur(Exception ex)
        {
            InitializeComponent();
            textBox1.Text = ex.Message + "\r\n" +
                "\r\n" +
                ex.StackTrace ;
        }

        private void buttonFermer_Click( object sender, EventArgs e )
        {
            Close() ;
        }

        private void buttonCopier_Click( object sender, EventArgs e )
        {
            System.Windows.Forms.Clipboard.SetText( textBox1.Text ) ;
        }
    
    }
}