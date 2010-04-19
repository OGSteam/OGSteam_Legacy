using System;
using System.Collections.Generic;
using System.Reflection;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Collections.ObjectModel;
using Ogame;
using Maf.Windows.Component ;

namespace OgameFarmingInterface
{
    public partial class Form1 : Form
    {
        private ClipboardSpy EspionPressePapier ;

        private FormAffichageRapport formRapport ;

        public Form1()
        {
            InitializeComponent();
            EspionPressePapier = new ClipboardSpy( this );
            EspionPressePapier.ClipboardChanged += new EventHandler( ClipboardChanged );
            formRapport = new FormAffichageRapport() ;
            formRapport.Hote = this ;
            _Rapports = new Collection<RapportDEspionnage>() ;
            toolStripStatusLabel1.Text = "Prêt.";
            LesRapports = new System.Collections.ArrayList() ;
            toolStripMenuItemCopierLesCoordonnees.Enabled = false ;
            listViewResultatsSelection = -1 ;
            analyserLePressePapierEtListerLesPigeons() ;
        }

        void ClipboardChanged( object sender, EventArgs e )
        {
            analyserLePressePapierEtListerLesPigeons();
        }
        
        private System.Collections.ArrayList LesRapports ;
        private Collection<RapportDEspionnage> _Rapports ;

        private void analyserLePressePapierEtListerLesPigeons()
        {
            if ( System.Windows.Forms.Clipboard.ContainsText( TextDataFormat.Text ) )
            {
                string texte = Clipboard.GetText( TextDataFormat.Text );
                string[] separateurs = {
                    "Matières premières "
                };
                string[] morceaux = texte.Split( separateurs, StringSplitOptions.RemoveEmptyEntries );
                Collection<RapportDEspionnage> Rapports = new Collection<RapportDEspionnage>() ;
                foreach ( string s in morceaux )
                {
                    if ( s.StartsWith( "sur " ) )
                    {
                        Rapports.Add( new RapportDEspionnage( s ) );
                    }
                }
                //_LesPigeons.Clear() ;
                foreach ( RapportDEspionnage Rapport in Rapports )
                {
                    if ( ! _Rapports.Contains(Rapport) )
                    {
                        _Rapports.Add(Rapport) ;
                    }
                    else
                    {
                        if ( true ) //TODO: vérifier si le rapport à ajouter est plus récent
                        {
                            _Rapports.Remove(Rapport) ;
                            _Rapports.Add(Rapport) ;
                        }
                    }
                }
                LesRapports = new System.Collections.ArrayList( _Rapports ) ;
                listViewResultats.BeginUpdate() ;
                listViewResultats.VirtualListSize = LesRapports.Count ;
                listViewResultats.EndUpdate() ;
                toolStripStatusLabel1.Text = System.Convert.ToString( Rapports.Count ) + " rapport" + ((Rapports.Count > 1) ? "s" : "") + " lu" + ((Rapports.Count > 1) ? "s" : "") + ".";
            }
            else
            {
                toolStripStatusLabel1.Text = "Aucune donnée valide à lire.";
            }
        }

        #region Bordel qui sert aux tris
        enum TriOrdre
        {
            ASC, DESC
        }
        class TriRapports : System.Collections.IComparer
        {
            private TriOrdre ordre ;
            private Comparateur c ;
            public delegate int Comparateur(RapportDEspionnage r1, RapportDEspionnage r2) ;
            public TriRapports( Comparateur comp, TriOrdre ordre )
            {
                this.c = comp ;
                this.ordre = ordre ;
            }
            public int Compare(object x, object y)
            {
                int comparaison = c( (x as RapportDEspionnage), (y as RapportDEspionnage) );
                if ( ordre != TriOrdre.ASC )
                    comparaison = -comparaison ;
                if ( comparaison == 0 )
                {
                    //TODO: comparer l'heure des rapports
                }
                return comparaison ;
            }
        }
        #endregion

        private int CompareNom( RapportDEspionnage r1, RapportDEspionnage r2 )
        {
            return r1.NomDeLaPlanete.CompareTo( r2.NomDeLaPlanete ) ;
        }

        private int CompareCoordonnees( RapportDEspionnage r1, RapportDEspionnage r2 )
        {
            return (int)r1.Coordonnees.Galaxie*100000
                  +(int)r1.Coordonnees.Systeme*100
                  +(int)r1.Coordonnees.Planete
                  -(int)r2.Coordonnees.Galaxie*100000
                  -(int)r2.Coordonnees.Systeme*100
                  -(int)r2.Coordonnees.Planete         ;
        }

        private int CompareMetal( RapportDEspionnage r1, RapportDEspionnage r2 )
        {
            return (int)r1.Ressources.Metal - (int)r2.Ressources.Metal ;
        }

        private int CompareCristal( RapportDEspionnage r1, RapportDEspionnage r2 )
        {
            return (int)r1.Ressources.Cristal - (int)r2.Ressources.Cristal;
        }

        private int CompareDeuterium( RapportDEspionnage r1, RapportDEspionnage r2 )
        {
            return (int)r1.Ressources.Deuterium - (int)r2.Ressources.Deuterium;
        }

        private int CompareRessources( RapportDEspionnage r1, RapportDEspionnage r2 )
        {
            return (int)r1.Ressources.Metal+(int)r1.Ressources.Cristal+(int)r1.Ressources.Deuterium
                  -(int)r2.Ressources.Metal-(int)r2.Ressources.Cristal-(int)r2.Ressources.Deuterium;
        }

        private int CompareRuinesPotentielles( RapportDEspionnage r1, RapportDEspionnage r2 )
        {
            return (int)r1.FlotteAQuai.Debris.Metal+(int)r1.FlotteAQuai.Debris.Cristal
                  -(int)r2.FlotteAQuai.Debris.Metal-(int)r2.FlotteAQuai.Debris.Cristal;
        }

        private int CompareDefenses( RapportDEspionnage r1, RapportDEspionnage r2 )
        {
            return (int)r1.Defenses.Totales
                  -(int)r2.Defenses.Totales;
        }



        private TriOrdre ordreNom = TriOrdre.ASC;
        private TriOrdre ordreCoordonnees = TriOrdre.ASC;
        private TriOrdre ordreMetal = TriOrdre.ASC;
        private TriOrdre ordreCristal = TriOrdre.ASC;
        private TriOrdre ordreDeut = TriOrdre.ASC;
        private TriOrdre ordreTotalGT = TriOrdre.ASC;
        private TriOrdre ordreTotalPT = TriOrdre.ASC;
        private TriOrdre ordreRuinesPotentielles = TriOrdre.ASC;
        private TriOrdre ordreDefenses = TriOrdre.ASC;
        private void listViewResultats_ColumnClick( object sender, ColumnClickEventArgs e )
        {
            try
            {
                listViewResultats.BeginUpdate() ;
                switch ( e.Column )
                {
                    case 0:
                        LesRapports.Sort( new TriRapports( CompareNom, ordreNom ) );
                        if ( ordreNom == TriOrdre.ASC ) ordreNom = TriOrdre.DESC; else ordreNom = TriOrdre.ASC; 
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                    case 1:
                        LesRapports.Sort( new TriRapports( CompareCoordonnees, ordreCoordonnees ) );
                        if ( ordreCoordonnees == TriOrdre.ASC ) ordreCoordonnees = TriOrdre.DESC; else ordreCoordonnees = TriOrdre.ASC; 
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                    case 2:
                        LesRapports.Sort( new TriRapports( CompareMetal, ordreMetal ) );
                        if ( ordreMetal == TriOrdre.ASC ) ordreMetal = TriOrdre.DESC; else ordreMetal = TriOrdre.ASC;
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                    case 3:
                        LesRapports.Sort( new TriRapports( CompareCristal, ordreCristal ) );
                        if ( ordreCristal == TriOrdre.ASC ) ordreCristal = TriOrdre.DESC; else ordreCristal = TriOrdre.ASC;
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                    case 4:
                        LesRapports.Sort( new TriRapports( CompareDeuterium, ordreDeut ) );
                        if ( ordreDeut == TriOrdre.ASC ) ordreDeut = TriOrdre.DESC; else ordreDeut = TriOrdre.ASC;
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                    case 5:
                        LesRapports.Sort( new TriRapports( CompareRessources, ordreTotalGT ) );
                        if ( ordreTotalGT == TriOrdre.ASC ) ordreTotalGT = TriOrdre.DESC; else ordreTotalGT = TriOrdre.ASC;
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                    case 6:
                        LesRapports.Sort( new TriRapports( CompareRessources, ordreTotalPT ) );
                        if ( ordreTotalPT == TriOrdre.ASC ) ordreTotalPT = TriOrdre.DESC; else ordreTotalPT = TriOrdre.ASC;
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                    case 7: 
                        LesRapports.Sort( new TriRapports( CompareRuinesPotentielles, ordreRuinesPotentielles ) );
                        if ( ordreRuinesPotentielles == TriOrdre.ASC ) ordreRuinesPotentielles = TriOrdre.DESC; else ordreRuinesPotentielles = TriOrdre.ASC;
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                    case 8: 
                        LesRapports.Sort( new TriRapports( CompareDefenses, ordreDefenses ) );
                        if ( ordreDefenses == TriOrdre.ASC ) ordreDefenses = TriOrdre.DESC; else ordreDefenses = TriOrdre.ASC;
                        listViewResultats.VirtualListSize = LesRapports.Count;
                        break;
                }
            }
            finally
            {
                listViewResultats.EndUpdate() ;
            }
        }

        private void listViewResultats_RetrieveVirtualItem( object sender, RetrieveVirtualItemEventArgs e )
        {
            ListViewItem i = new ListViewItem( new string[12] );
            if ( e.ItemIndex <= LesRapports.Count )
            {
                RapportDEspionnage Rapport = (LesRapports[e.ItemIndex] as RapportDEspionnage );
                int grandsTransporteurs = (int)(Rapport.Ressources.Metal + Rapport.Ressources.Cristal + Rapport.Ressources.Deuterium) / 50000 + 1;
                int petitsTransporteurs = (int)(Rapport.Ressources.Metal + Rapport.Ressources.Cristal + Rapport.Ressources.Deuterium) / 10000 + 1;
                i.SubItems[0].Text = Rapport.NomDeLaPlanete;
                i.SubItems[1].Text = Rapport.Coordonnees;
                i.SubItems[2].Text = System.Convert.ToString( Rapport.Ressources.Metal );
                i.SubItems[3].Text = System.Convert.ToString( Rapport.Ressources.Cristal );
                i.SubItems[4].Text = System.Convert.ToString( Rapport.Ressources.Deuterium );
                i.SubItems[5].Text = System.Convert.ToString( grandsTransporteurs );
                i.SubItems[6].Text = System.Convert.ToString( petitsTransporteurs );
                i.SubItems[7].Text = System.Convert.ToString( Rapport.FlotteAQuai.Debris.Metal ) + "M/" + Rapport.FlotteAQuai.Debris.Cristal + "C" ;
                i.SubItems[8].Text = System.Convert.ToString( Rapport.Defenses.Totales );
                i.SubItems[9].Text = System.Convert.ToString( Rapport.Defenses.Legeres );
                i.SubItems[10].Text = System.Convert.ToString( Rapport.Defenses.Moyennes );
                i.SubItems[11].Text = System.Convert.ToString( Rapport.Defenses.Lourdes );
            }
            e.Item = i ;
        }

        private int listViewResultatsSelection ;
        private void listViewResultats_KeyUp(object sender, KeyEventArgs e)
        {
        }

        private void listViewResultats_ItemSelectionChanged(object sender, ListViewItemSelectionChangedEventArgs e)
        {
            listViewResultatsSelection = e.ItemIndex ;
            formRapport.Rapport = (LesRapports[listViewResultatsSelection] as RapportDEspionnage);
            toolStripMenuItemCopierLesCoordonnees.Enabled = true;
        }

        private void toolStripMenuItemCopierLesCoordonnees_Click(object sender, EventArgs e)
        {
            toolStripStatusLabel1.Text = "Coordonnées ["+listViewResultatsSelection+"] = " + (LesRapports[listViewResultatsSelection] as RapportDEspionnage).Coordonnees ;
        }

        private void listViewResultats_KeyDown(object sender, KeyEventArgs e)
        {
            if ( e.KeyCode == Keys.Delete )
            {
                try
                {
                    if ( listViewResultatsSelection != -1 )
                    {
                        LesRapports.RemoveAt(listViewResultatsSelection) ;
                    }
                    if ( listViewResultatsSelection >= LesRapports.Count )
                    {
                        listViewResultatsSelection = -1 ;
                        toolStripMenuItemCopierLesCoordonnees.Enabled = false ;
                    }
                }
                catch(Exception)
                {
                    listViewResultatsSelection = -1 ;
                    toolStripMenuItemCopierLesCoordonnees.Enabled = false ;
                }
                listViewResultats.VirtualListSize = LesRapports.Count ;
            }
            if ( e.KeyCode == Keys.Enter )
            {
                MetAJourLaVueDuRapport() ;
            }
        }

        private void toolStripButton_AfficheRapport_Click( object sender, EventArgs e )
        {
            formRapport.Show() ;
        }

        private void listViewResultats_MouseDoubleClick( object sender, MouseEventArgs e )
        {
            MetAJourLaVueDuRapport() ;
        }

        private void MetAJourLaVueDuRapport()
        {
            if ( listViewResultatsSelection != -1 )
            {
                formRapport.Rapport = (LesRapports[listViewResultatsSelection] as RapportDEspionnage);
            }
            else
            {
                formRapport.Rapport = null;
            }
            formRapport.Show();
            formRapport.BringToFront();
        }
    }
}
