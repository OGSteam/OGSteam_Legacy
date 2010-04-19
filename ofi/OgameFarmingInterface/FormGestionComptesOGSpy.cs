using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Collections.ObjectModel;
using System.IO;

namespace OgameFarmingInterface
{
    public partial class FormGestionComptesOGSpy : Form
    {
        private FormPrincipale fp ;

        private listeDeParametresOGSpy listeDesComptes ;

        public FormGestionComptesOGSpy(FormPrincipale f)
        {
            fp = f ;
            listeDesComptes = new listeDeParametresOGSpy() ;
            InitializeComponent() ;
            buttonSynchroniser.Enabled = false ;
            chargeComptesOGSpy() ;
            mettreAJourLEtatDesControlesSelonLaSelection() ;
            groupBoxFonctionsAvancees.Hide() ; // TODO: a virer une fois la fonction de synchro OK.
        }

        private void FormGestionComptesOGSpy_FormClosing( object sender, FormClosingEventArgs e )
        {
            sauvegardeComptesOGSpy() ;
            e.Cancel = true ;
            Hide() ;
        }

        private void mettreAJourAffichageListe()
        {
            listView1.VirtualListSize = listeDesComptes.Count ;
            listView1.Refresh() ;
        }

        private void chargeComptesOGSpy()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                fs = new FileStream( dossierParametres + @"\comptes.param", FileMode.Open ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                this.listeDesComptes = (listeDeParametresOGSpy)formatter.Deserialize( fs ) ;
            }
            catch ( Exception )
            {
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
            mettreAJourAffichageListe() ;
        }

        private void sauvegardeComptesOGSpy()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                System.IO.Directory.CreateDirectory( dossierParametres ) ;
                fs = new FileStream( dossierParametres + @"\comptes.param" , FileMode.Create ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                formatter.Serialize( fs, this.listeDesComptes ) ;
            }
            catch ( Exception )
            {
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        private void buttonAjouter_Click( object sender, EventArgs e )
        {
            parametresOGSpy paramsCourants = new parametresOGSpy() ;
            paramsCourants.URL   = fp.textBoxURL.Text   ;
            paramsCourants.login = fp.textBoxLogin.Text ;
            paramsCourants.pass  = fp.textBoxPasse.Text ;
            listeDesComptes.Add( paramsCourants ) ;
            mettreAJourAffichageListe() ;
        }

        private void supprimerLesComptesSelectionnes()
        {
            try
            {
                listView1.BeginUpdate() ;
                for ( int i = 0 ; i < listeDesComptes.Count ; )
                {
                    parametresOGSpy parametres = listeDesComptes[i] ;
                    if ( parametres.Selected )
                    {
                        listeDesComptes.RemoveAt(i) ;
                        continue ;
                    }
                    ++i ;
                }
                listView1.SelectedIndices.Clear() ;
            }
            finally
            {
                listView1.EndUpdate() ;
            }
            mettreAJourAffichageListe() ;
        }

        private void buttonSupprimer_Click( object sender, EventArgs e )
        {
            supprimerLesComptesSelectionnes() ;
        }

        private void chargerLeCompteSelectionne()
        {
            if ( listView1.SelectedIndices.Count == 1 )
            {
                parametresOGSpy parametres = listeDesComptes[ listView1.SelectedIndices[0] ] ;
                fp.textBoxURL.Text   = parametres.URL   ;
                fp.textBoxLogin.Text = parametres.login ;
                fp.textBoxPasse.Text = parametres.pass  ;
            }
        }

        private void buttonCharger_Click( object sender, EventArgs e )
        {
            chargerLeCompteSelectionne() ;
        }

        private void buttonSynchroniser_Click( object sender, EventArgs e )
        {

        }

        private void listView1_RetrieveVirtualItem( object sender, RetrieveVirtualItemEventArgs e )
        {
            ListViewItem item = new ListViewItem( new string[listView1.Columns.Count] );
            if ( e.ItemIndex < listeDesComptes.Count )
            {
                parametresOGSpy parametres = (listeDesComptes[e.ItemIndex] as parametresOGSpy ) ;
                if ( parametres != null )
                {
                    item.SubItems[0].Text = parametres.URL ;
                    item.SubItems[1].Text = parametres.login ;
                    item.SubItems[2].Text = new String('*', parametres.pass.Length ) ;
                }
            }
            e.Item = item ;
        }

        private void mettreAJourLEtatDesControlesSelonLaSelection()
        {
            int nombreDItemsSelectionnes = listView1.SelectedIndices.Count ;
            buttonSynchroniser.Enabled = ( nombreDItemsSelectionnes >= 2 ) ;
            buttonSupprimer.Enabled = ( nombreDItemsSelectionnes >= 1 ) ;
            buttonCharger.Enabled = ( nombreDItemsSelectionnes == 1 ) ;
        }
    
        private void listView1_VirtualItemsSelectionRangeChanged( object sender, ListViewVirtualItemsSelectionRangeChangedEventArgs e )
        {
            // On reaffecte toutes les selections...
            foreach ( parametresOGSpy p in listeDesComptes )
            {
                p.Selected = false ;
            }
            for ( int i = 0 ; i < listView1.SelectedIndices.Count ; ++ i )
            {
                listeDesComptes[ listView1.SelectedIndices[i] ].Selected = true ;
            }
            mettreAJourLEtatDesControlesSelonLaSelection() ;
        }

        private void listView1_ItemSelectionChanged( object sender, ListViewItemSelectionChangedEventArgs e )
        {
            listeDesComptes[e.ItemIndex].Selected = e.IsSelected ;
            mettreAJourLEtatDesControlesSelonLaSelection() ;
        }

        private void listView1_KeyDown( object sender, KeyEventArgs e )
        {
            if ( e.KeyCode == Keys.Delete )
            {
                supprimerLesComptesSelectionnes() ;
            }
            if ( e.KeyCode == Keys.Enter || e.KeyCode == Keys.Return )
            {
                chargerLeCompteSelectionne() ;
            }
        }

        private void listView1_DoubleClick( object sender, EventArgs e )
        {
            chargerLeCompteSelectionne() ;
        }

    }

    [Serializable]
    public class parametresOGSpy
    {
        private String URL_ ;
        public String URL
        {
            get { return URL_ ; }
            set { URL_ = value ; }
        }
        private String login_ ;
        public String login
        {
            get { return login_ ; }
            set { login_ = value ; }
        }
        private String pass_ ;
        public String pass
        {
            get { return pass_ ; }
            set { pass_ = value ; }
        }
        private bool Selected_ ;
        public bool Selected
        {
            get { return Selected_ ; }
            set { Selected_ = value ; }
        }
        public parametresOGSpy()
        {
            Selected = false ;
            URL   = "" ;
            login = "" ;
            pass  = "" ;
        }
        public parametresOGSpy(String u, String l, String p)
        {
            Selected = false ;
            URL = u ;
            login = l ;
            pass = p ;
        }
    }
    [Serializable]
    public class listeDeParametresOGSpy : Collection<parametresOGSpy>
    {
    }

}