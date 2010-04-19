using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

using Ogame;

namespace OgameFarmingInterface
{
    public partial class FormAffichageRapport : Form
    {
        FormPrincipale fp ;
        public FormAffichageRapport(FormPrincipale f)
        {
            InitializeComponent();
            fp = f ;
        }

        private RapportDEspionnage _Rapport ;
        public RapportDEspionnage Rapport
        {
            get { return _Rapport ; }
            set
            {
                _Rapport = value ;
                MetAJourLAffichage() ;
            }
        }

        private void MetAJourLAffichage()
        {
            if ( Rapport != null )
            {
                webBrowserAffichageRapport.DocumentText = Utils.ConversionEnHTML( Rapport ) ;
            }
            else
            {
                webBrowserAffichageRapport.DocumentText = "" ;
            }
        }

        private void FormAffichageRapport_FormClosing( object sender, FormClosingEventArgs e )
        {
            e.Cancel = true ;
            Hide() ;
        }

        private Form _Hote ;
        public Form Hote {
        get { return _Hote ;}
        set { _Hote = value ;}
        }

        private void buttonFermer_Click( object sender, EventArgs e )
        {
            Hide() ;
        }

        private void buttonCopier_Click( object sender, EventArgs e )
        {
            fp.AnalysePressePapier = false ;
            System.Windows.Forms.Clipboard.SetText( Rapport.Texte ) ;
            fp.AnalysePressePapier = true ;
        }

    }
}