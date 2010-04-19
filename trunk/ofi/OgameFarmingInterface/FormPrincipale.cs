using System;
using System.Collections.Generic;
using System.Reflection;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.IO;
using System.Windows.Forms;
using System.Collections.ObjectModel;
using Ogame;
using Maf.Windows.Component ;
using System.Runtime.Serialization;
using System.Xml.Serialization;
using Microsoft.Win32 ;
using System.Diagnostics;
using System.Collections;

namespace OgameFarmingInterface
{
    public partial class FormPrincipale : Form
    {
        // A modifier à chaque nouvelle sortie...
        private static int version_courante = 20070624 ;
        
        #region Initialisation globale

        private FormAffichageRapport formRapport ;

        private FormGestionComptesOGSpy formComptesOGSpy ;

        public void Initialise()
        {
            #region Initialisation DPI
            using ( RegistryKey cp = Registry.CurrentUser.OpenSubKey(@"Control Panel\Desktop\WindowMetrics") )
            {
                if ( cp == null )
                {
                    dpi = 96 ;
                }
                else
                {
                    dpi = System.Convert.ToInt32( cp.GetValue(@"AppliedDPI", "96").ToString() ) ;
                }
            }
            #endregion
            chargePositionEtTaille() ;
            InitializeComponent() ; // Appel de l'initialisation du concepteur.
            initialiseLaMiseAJour() ;
            AfficheMessage( "Prêt." ) ;
            chargePositionEtTaille() ;
            initialiseLeTri() ;
            initialiseResultatsDeSimulations() ;
            initialiseLesAmis() ;
            initialiseLesColonnes() ;
            chargeLesColonnes() ;
            initialiseEspion() ;
            formRapport = new FormAffichageRapport(this) ;
            formRapport.Hote = this ;
            formComptesOGSpy = new FormGestionComptesOGSpy(this) ;
            LesRapports = new ListeDeRapports() ;
            listViewResultatsSelection = -1 ;
            initialiseEmpire() ;
            initialiseFlottePredefinies() ;
            initialiseLUniversConnu() ;
            initialiseRechercheUnivers() ;
            initialiseSimulation() ;
            initialiseLeNavigateur() ;
            initialiseLiaisonServeur() ;
            AnalysePressePapier = true ;
            //anaylserLePressePapier() ;
            tabControlPrincipal.SelectedIndex = 0 ;
        }

        public FormPrincipale()
        {
            Initialise() ;
        }

        public FormPrincipale( string fichierAOuvrir )
        {
            Initialise() ;
            Ouvre( fichierAOuvrir ) ;
        }

        private void initialisePositionEtTaille()
        {
        }

        private void chargePositionEtTaille()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                fs = new FileStream( dossierParametres + @"\position.param", FileMode.Open ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                this.Size = (Size)formatter.Deserialize( fs ) ;
                try
                {
                    checkBoxEnregistrerEnQuittant.Checked = (bool)formatter.Deserialize( fs ) ;
                    this.StartPosition = FormStartPosition.Manual ;
                    this.Location = (Point)formatter.Deserialize( fs ) ;
                }
                catch ( Exception )
                {
                }
            }
            catch ( Exception )
            {
                initialisePositionEtTaille() ;
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        private void sauvegardePositionEtTaille()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                System.IO.Directory.CreateDirectory( dossierParametres ) ;
                fs = new FileStream( dossierParametres + @"\position.param" , FileMode.Create ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                formatter.Serialize( fs, this.Size ) ;
                formatter.Serialize( fs, checkBoxEnregistrerEnQuittant.Checked ) ;
                formatter.Serialize( fs, this.Location ) ;
            }
            catch ( Exception )
            {
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        #endregion

        #region Utils

        static long dpi ;

        public void AfficheMessage( String message )
        {
            toolStripStatusLabel1.Text = message ;
        }

        private void textBoxNombre_TextChanged(object sender, EventArgs e)
        {
            TextBox tb = (sender as TextBox) ;
            if ( tb == null ) return ;

            try
            {
                Convert.ToInt32( tb.Text ) ;
                tb.ForeColor = System.Drawing.SystemColors.WindowText ;
            }
            catch ( Exception )
            {
                tb.ForeColor = Color.Red ;
            }
        }

        #endregion

        #region Gestion de l'espion presse papier
        private void initialiseEspion()
        {
            EspionPressePapier = new ClipboardSpy( this );
            EspionPressePapier.ClipboardChanged += new EventHandler( ClipboardChanged );
        }
        private ClipboardSpy EspionPressePapier ;

        private bool _AnalysePressePapier ;
        public bool AnalysePressePapier
        {
            get { return _AnalysePressePapier ; }
            set { _AnalysePressePapier = value ; }
        }

        private void ClipboardChanged( object sender, EventArgs e )
        {
            if ( AnalysePressePapier )
            {
                anaylserLePressePapier() ;
            }
        }
        private void anaylserLePressePapier()
        {
            try
            {
                if ( System.Windows.Forms.Clipboard.ContainsText( TextDataFormat.Text ) )
                {
                    string texte = Clipboard.GetText( TextDataFormat.Text ) ;
                    if ( texte.Contains( "Matières premières " ) )
                    {
                        toolStripStatusLabel1.Text = "lecture de rapports d'espionnage en cours...";
                        recupererDesRapportsDEspionnage( texte ) ;
                        aEteModifie = true ;
                    }
                    else if ( texte.Contains( "Vue d'ensemble de votre empire" ) )
                    {
                        toolStripStatusLabel1.Text = "lecture de l'empire en cours...";
                        Empire = Ogame.empire.lireEmpire( texte ) ;
                        aEteModifie = true ;
                        miseAJourEmpire( Empire ) ;
                        toolStripStatusLabel1.Text = "" + Empire.Count + " planètes de l'empire lues." ;
                    }
                    else if ( texte.Contains( "Système solaire" ) )
                    {
                        toolStripStatusLabel1.Text = "lecture d'un système en cours...";
                        Systeme s = LUniversConnu.lireSysteme( texte ) ;
                        aEteModifie = true ;
                        toolStripStatusLabel1.Text = "Système " + s.galaxie + ":" + s.systeme + " lu (" + s.NombreDePlanetes() + " planète" + ((s.NombreDePlanetes()!=1)?"s":"") + ")." ;
                        miseAJourDeLAffichageDeLUniversConnu() ;
                    }
                    else
                    {
                        toolStripStatusLabel1.Text = "Le presse papier ne contient rien d'interessant.";
                    }
                }
                else
                {
                    toolStripStatusLabel1.Text = "Aucune donnée valide à lire.";
                }
            }
            catch( Exception e )
            {
                toolStripStatusLabel1.Text = "Erreur : " + e.Message ;
            }
       }
        
        private RapportDEspionnage RapportDejaPresentALaMemeHeureEtAuxMemesCoordonneesQue( RapportDEspionnage Rapport )
        {
            foreach ( RapportDEspionnage RapportRecherche in LesRapports )
            {
                if ( RapportRecherche.Coordonnees.Equals( Rapport.Coordonnees ) )
                {
                    if ( RapportRecherche.DateEtHeure == Rapport.DateEtHeure )
                    {
                        return RapportRecherche ;
                    }
                }
            }
            return null ;
        }

        private void recupererDesRapportsDEspionnage( string texte )
        {
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
            int rapportsDejaPresents = 0 ;
            foreach ( RapportDEspionnage Rapport in Rapports )
            {
                RapportDEspionnage RapportPresent = RapportDejaPresentALaMemeHeureEtAuxMemesCoordonneesQue( Rapport ) ;
                if ( RapportPresent == null )
                {
                    LesRapports.Add(Rapport) ;
                }
                else
                {
                    ++rapportsDejaPresents ;
                }
            }
            MetAJourLAffichageDeLaListe() ;
            toolStripStatusLabel1.Text = "" + Rapports.Count + " rapport" + ((Rapports.Count > 1) ? "s" : "") + " lu" + ((Rapports.Count > 1) ? "s" : "") +
                ( rapportsDejaPresents>0 ? (
                    (rapportsDejaPresents>1)?
                    (" (dont " + rapportsDejaPresents + " étaient déja présents)"):
                    (" (dont 1 était déja présent)")
                ) : "" ) +
                ".";
        }
        #endregion

        #region Gestion de la collection affichée
        [Serializable]
        public class ListeDeRapports : System.Collections.ArrayList
        {
            // Renvoie le rapport le plus récent à ces coordonnées
            public RapportDEspionnage this[Coordonnees c]
            {
                get {
                    RapportDEspionnage leBon = null ;
                    foreach( RapportDEspionnage r in this )
                    {
                        if ( r.Coordonnees.Equals( c ) )
                        {
                            if ( leBon == null )
                            {
                                leBon = r ;
                            }
                            else
                            {
                                if ( leBon.DateEtHeure.Ticks < r.DateEtHeure.Ticks )
                                {
                                    leBon = r ;
                                }
                            }
                        }
                    }
                    return leBon ;
                }
            }
        }
        
        private ListeDeRapports _LesRapports ;
        public ListeDeRapports LesRapports
        {
            get {

                return _LesRapports ;
            }
            set
            {
                _LesRapports = value ;
                MetAJourLAffichageDeLaListe() ;
            }
        }
        private void MetAJourLAffichageDeLaListe()
        {
            for( int i = 0 ; i < LesRapports.Count ; ++i )
            {
                (LesRapports[i] as RapportDEspionnage).Index = i ;
            }
            listViewResultats.BeginUpdate() ;
            listViewResultats.VirtualListSize = LesRapports.Count ;
            listViewResultats.EndUpdate() ;
        }
        #endregion

        #region Gestion du tri par colonnes
        #region Bordel qui sert aux tris
        enum TriOrdre
        {
            ASC, DESC
        }
        class TriRapports : System.Collections.IComparer
        {
            private TriOrdre ordre ;
            private ColonneRapport.fonctionDeTri c ;
            private bool select ;
            public TriRapports( ColonneRapport.fonctionDeTri comp, TriOrdre ordre)
            {
                this.c = comp ;
                this.ordre = ordre ;
                this.select = false ;
            }
            public TriRapports( ColonneRapport.fonctionDeTri comp, TriOrdre ordre, bool selectionSeulement)
            {
                this.c = comp ;
                this.ordre = ordre ;
                this.select = selectionSeulement ;
            }
            public int Compare(object x, object y)
            {
                int comparaison ;
                if ( c != null )
                {
                    if ( select )
                    {
                        if ( (x as RapportDEspionnage).Selected && (y as RapportDEspionnage).Selected )
                        {
                            comparaison = c( (x as RapportDEspionnage), (y as RapportDEspionnage) ) ;
                        }
                        else
                        {
                            comparaison = 0 ;
                        }
                    }
                    else
                    {
                        comparaison = c( (x as RapportDEspionnage), (y as RapportDEspionnage) ) ;
                    }
                }
                else
                {
                    comparaison = 0 ;
                }
                if ( ordre != TriOrdre.ASC )
                    comparaison = -comparaison ;
                if ( comparaison == 0 )
                {
                    comparaison = (x as RapportDEspionnage).Index - (y as RapportDEspionnage).Index ;
                }
                return comparaison ;
            }
        }
        private void listViewResultats_ColumnClick( object sender, ColumnClickEventArgs e )
        {
            ColonneRapport cr = (listViewResultats.Columns[e.Column] as ColonneRapport) ;
            if ( cr != null )
            {
                aEteModifie = true ;
                if ( listViewResultats.SelectedIndices.Count <= 1 )
                {
                    LesRapports.Sort( new TriRapports( cr.Trie, cr.ordreDeTri ) ) ;
                }
                else
                {
                    LesRapports.Sort( new TriRapports( cr.Trie, cr.ordreDeTri, true ) ) ;
                }
                if ( cr.ordreDeTri == TriOrdre.ASC )
                    cr.ordreDeTri = TriOrdre.DESC ;
                else
                    cr.ordreDeTri = TriOrdre.ASC ;
                MetAJourLAffichageDeLaListe() ;
            }
        }
        
        private AffichageEtTri affichageEtTri ;
        private void initialiseLeTri()
        {
            affichageEtTri = new AffichageEtTri() ;
        }

        #endregion

        [Serializable]
        private class AffichageEtTri
        {
            public Univers LUnivers
            {
                get {
                    return FormPrincipale.LUniversConnu ;
                }
                set {
                    FormPrincipale.LUniversConnu = value ;
                }
            }

            public ResultatsDeSimulationMassive ResultatsDesSimulations
            {
                get { return FormPrincipale.resultatsDesSimulations ; }
                set { FormPrincipale.resultatsDesSimulations = value ; }
            }

            public  string afficheNom( RapportDEspionnage rapport )
            {
                return rapport.NomDeLaPlanete ;
            }
            public  int CompareNom( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return r1.NomDeLaPlanete.CompareTo( r2.NomDeLaPlanete ) ;
            }

            public  string afficheDate( RapportDEspionnage rapport )
            {
                return rapport.DateEtHeure.ToString("dd/MM hh:mm") ;
            }
            public  int CompareDate( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return r1.DateEtHeure.CompareTo( r2.DateEtHeure ) ;
            }

            public  string afficheInfos( RapportDEspionnage rapport )
            {
                string Infos = "*" ;
                if ( rapport.FlotteAQuaiEstValide ) Infos += "*" ;
                if ( rapport.DefensesEstValide    ) Infos += "*" ;
                if ( rapport.BatimentsEstValide   ) Infos += "*" ;
                if ( rapport.RecherchesEstValide  ) Infos += "*" ;
                return Infos ;
            }
            public  int CompareInfos( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                int Infos1 = 0 ;
                int Infos2 = 0 ;
                if ( r1.FlotteAQuaiEstValide ) Infos1 += 1 ;
                if ( r1.DefensesEstValide    ) Infos1 += 1 ; 
                if ( r1.BatimentsEstValide   ) Infos1 += 1 ;
                if ( r1.RecherchesEstValide  ) Infos1 += 1 ;
                if ( r2.FlotteAQuaiEstValide ) Infos2 += 1 ;
                if ( r2.DefensesEstValide    ) Infos2 += 1 ; 
                if ( r2.BatimentsEstValide   ) Infos2 += 1 ;
                if ( r2.RecherchesEstValide  ) Infos2 += 1 ;
                return Infos1 - Infos2 ;
            }

            public  string afficheCoordonnees( RapportDEspionnage rapport )
            {
                return rapport.Coordonnees ;
            }
            public  int CompareCoordonnees( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return (int)r1.Coordonnees.Galaxie*100000
                      +(int)r1.Coordonnees.Systeme*100
                      +(int)r1.Coordonnees.Planete
                      -(int)r2.Coordonnees.Galaxie*100000
                      -(int)r2.Coordonnees.Systeme*100
                      -(int)r2.Coordonnees.Planete         ;
            }

            public  string afficheStatus( RapportDEspionnage rapport )
            {
                return Utils.StatusEnChaine(LUnivers[rapport.Coordonnees].Status) ;
            }
            public  int CompareStatus( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return (int)(LUnivers[r1.Coordonnees].Status)
                     - (int)(LUnivers[r2.Coordonnees].Status) ; 
            }

            public  string afficheAlliance( RapportDEspionnage rapport )
            {
                return LUnivers[rapport.Coordonnees].Alliance ;
            }
            public  int CompareAlliance( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return LUnivers[r1.Coordonnees].Alliance.CompareTo( LUnivers[r2.Coordonnees].Alliance ) ;
            }

            public  string afficheJoueur( RapportDEspionnage rapport )
            {
                return LUnivers[rapport.Coordonnees].Joueur ;
            }
            public  int CompareJoueur( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return LUnivers[r1.Coordonnees].Joueur.CompareTo( LUnivers[r2.Coordonnees].Joueur ) ;
            }

            public  string affichePresenceLune( RapportDEspionnage rapport )
            {
                return LUnivers[rapport.Coordonnees].AUneLune ? "M" : "" ;
            }
            public  int ComparePresenceLune( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                int Infos1 = 0 ;
                int Infos2 = 0 ;
                if ( LUnivers[r1.Coordonnees].AUneLune ) Infos1 += 1 ;
                if ( LUnivers[r2.Coordonnees].AUneLune ) Infos2 += 1 ;
                return Infos1 - Infos2 ;
            }

            public  string afficheMetal( RapportDEspionnage rapport )
            {
                return Utils.affEntier( rapport.Ressources.Metal ) ;
            }
            public  int CompareMetal( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return (int)r1.Ressources.Metal - (int)r2.Ressources.Metal ;
            }

            public  string afficheCristal( RapportDEspionnage rapport )
            {
                return Utils.affEntier( rapport.Ressources.Cristal ) ;
            }
            public  int CompareCristal( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return (int)r1.Ressources.Cristal - (int)r2.Ressources.Cristal;
            }

            public  string afficheDeuterium( RapportDEspionnage rapport )
            {
                return Utils.affEntier( rapport.Ressources.Deuterium ) ;
            }
            public  int CompareDeuterium( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return (int)r1.Ressources.Deuterium - (int)r2.Ressources.Deuterium;
            }

            public  string afficheNombreDeGTs( RapportDEspionnage rapport )
            {
                return Utils.affEntier( rapport.Ressources.NombreDeGrandsTransporteurs() ) ;
            }
            public  string afficheNombreDePTs( RapportDEspionnage rapport )
            {
                return Utils.affEntier( rapport.Ressources.NombreDePetitsTransporteurs() ) ;
            }
            public  string afficheNombreDeVBs( RapportDEspionnage rapport )
            {
                return Utils.affEntier( rapport.Ressources.NombreDeVaisseauxDeBataille() ) ;
            }
            public  string afficheTotalRessources( RapportDEspionnage rapport )
            {
                return Utils.affEntier( rapport.Ressources.Total ) ;
            }
            public  int CompareRessources( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return (int)r1.Ressources.Metal+(int)r1.Ressources.Cristal+(int)r1.Ressources.Deuterium
                      -(int)r2.Ressources.Metal-(int)r2.Ressources.Cristal-(int)r2.Ressources.Deuterium;
            }

            public  string afficheRuinesMetal( RapportDEspionnage rapport )
            {
                if ( rapport.FlotteAQuaiEstValide )
                {
                    return Utils.affEntier( rapport.FlotteAQuai.ValeurEnRuines().Metal ) ;
                }
                return "" ;
            }
            public  int CompareRuinesPotentiellesMetal( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.FlotteAQuaiEstValide && ! r2.FlotteAQuaiEstValide ) return  1 ; 
                if ( ! r1.FlotteAQuaiEstValide && r2.FlotteAQuaiEstValide ) return  -1 ; 
                if ( ! r1.FlotteAQuaiEstValide && ! r2.FlotteAQuaiEstValide ) return  0 ; 
                return (int)r1.FlotteAQuai.ValeurEnRuines().Metal
                      -(int)r2.FlotteAQuai.ValeurEnRuines().Metal;
            }

            public  string afficheRuinesCristal( RapportDEspionnage rapport )
            {
                if ( rapport.FlotteAQuaiEstValide )
                {
                    return Utils.affEntier( rapport.FlotteAQuai.ValeurEnRuines().Cristal ) ;
                }
                return "" ;
            }
            public  int CompareRuinesPotentiellesCristal( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.FlotteAQuaiEstValide && ! r2.FlotteAQuaiEstValide ) return  1 ; 
                if ( ! r1.FlotteAQuaiEstValide && r2.FlotteAQuaiEstValide ) return  -1 ; 
                if ( ! r1.FlotteAQuaiEstValide && ! r2.FlotteAQuaiEstValide ) return  0 ; 
                return (int)r1.FlotteAQuai.ValeurEnRuines().Cristal
                      -(int)r2.FlotteAQuai.ValeurEnRuines().Cristal;
            }

            public  string afficheNombreDeRCs( RapportDEspionnage rapport )
            {
                if ( rapport.FlotteAQuaiEstValide )
                {
                    return Utils.affEntier( rapport.FlotteAQuai.ValeurEnRuines().NombreDeRecycleurs() ) ;
                }
                return "" ;
            }
            public  int CompareRuinesPotentielles( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.FlotteAQuaiEstValide && ! r2.FlotteAQuaiEstValide ) return  1 ; 
                if ( ! r1.FlotteAQuaiEstValide && r2.FlotteAQuaiEstValide ) return  -1 ; 
                if ( ! r1.FlotteAQuaiEstValide && ! r2.FlotteAQuaiEstValide ) return  0 ; 
                return (int)r1.FlotteAQuai.ValeurEnRuines().Metal+(int)r1.FlotteAQuai.ValeurEnRuines().Cristal
                      -(int)r2.FlotteAQuai.ValeurEnRuines().Metal-(int)r2.FlotteAQuai.ValeurEnRuines().Cristal;
            }

            public  string afficheDefensesTotal( RapportDEspionnage rapport )
            {
                if ( rapport.DefensesEstValide )
                {
                    return System.Convert.ToString( rapport.Defenses.Totales ) ;
                }
                return "" ;
            }
            public  int CompareDefenses( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.DefensesEstValide && ! r2.DefensesEstValide ) return  1 ; 
                if ( ! r1.DefensesEstValide && r2.DefensesEstValide ) return  -1 ; 
                if ( ! r1.DefensesEstValide && ! r2.DefensesEstValide ) return  0 ; 
                return (int)r1.Defenses.Totales
                      -(int)r2.Defenses.Totales;
            }

            public  string afficheDefensesLegeres( RapportDEspionnage rapport )
            {
                if ( rapport.DefensesEstValide )
                {
                    return System.Convert.ToString( rapport.Defenses.Legeres ) ;
                }
                return "" ;
            }
            public  int CompareDefensesLegeres( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.DefensesEstValide && ! r2.DefensesEstValide ) return  1 ; 
                if ( ! r1.DefensesEstValide && r2.DefensesEstValide ) return  -1 ; 
                if ( ! r1.DefensesEstValide && ! r2.DefensesEstValide ) return  0 ; 
                return (int)r1.Defenses.Legeres
                      -(int)r2.Defenses.Legeres;
            }

            public  string afficheDefensesMoyennes( RapportDEspionnage rapport )
            {
                if ( rapport.DefensesEstValide )
                {
                    return System.Convert.ToString( rapport.Defenses.Moyennes ) ;
                }
                return "" ;
            }
            public  int CompareDefensesMoyennes( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.DefensesEstValide && ! r2.DefensesEstValide ) return  1 ; 
                if ( ! r1.DefensesEstValide && r2.DefensesEstValide ) return  -1 ; 
                if ( ! r1.DefensesEstValide && ! r2.DefensesEstValide ) return  0 ; 
                return (int)r1.Defenses.Moyennes
                      -(int)r2.Defenses.Moyennes;
            }

            public  string afficheDefensesLourdes( RapportDEspionnage rapport )
            {
                if ( rapport.DefensesEstValide )
                {
                    return System.Convert.ToString( rapport.Defenses.Lourdes ) ;
                }
                return "" ;
            }
            public  int CompareDefensesLourdes( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.DefensesEstValide && ! r2.DefensesEstValide ) return  1 ; 
                if ( ! r1.DefensesEstValide && r2.DefensesEstValide ) return  -1 ; 
                if ( ! r1.DefensesEstValide && ! r2.DefensesEstValide ) return  0 ; 
                return (int)r1.Defenses.Lourdes
                      -(int)r2.Defenses.Lourdes;
            }

            public  string afficheDefensesPlasmas( RapportDEspionnage rapport )
            {
                if ( rapport.DefensesEstValide )
                {
                    return System.Convert.ToString( rapport.Defenses.LanceursDePlasma ) ;
                }
                return "" ;
            }
            public  int CompareDefensesPlasmas( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.DefensesEstValide && ! r2.DefensesEstValide ) return  1 ; 
                if ( ! r1.DefensesEstValide && r2.DefensesEstValide ) return  -1 ; 
                if ( ! r1.DefensesEstValide && ! r2.DefensesEstValide ) return  0 ; 
                return (int)r1.Defenses.LanceursDePlasma
                      -(int)r2.Defenses.LanceursDePlasma;
            }

            public  string afficheNombreMI( RapportDEspionnage rapport )
            {
                if ( rapport.DefensesEstValide )
                {
                    return System.Convert.ToString( rapport.Defenses.MissilesDInterception ) ;
                }
                return "" ;
            }
            public  int CompareNombreMI( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( r1.DefensesEstValide && ! r2.DefensesEstValide ) return  1 ; 
                if ( ! r1.DefensesEstValide && r2.DefensesEstValide ) return  -1 ; 
                if ( ! r1.DefensesEstValide && ! r2.DefensesEstValide ) return  0 ; 
                return (int)r1.Defenses.MissilesDInterception
                      -(int)r2.Defenses.MissilesDInterception;
            }

            public  string afficheRentabiliteAvecRC( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return Utils.affEntier( s.RentabiliteAttaquantAvecRecyclage.Total ) ;
            }
            public  int CompareRentabiliteAvecRC( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.RentabiliteAttaquantAvecRecyclage.Total
                     - s2.RentabiliteAttaquantAvecRecyclage.Total  ) ;
            }

            public  string afficheGainAvecRC( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return Utils.affEntier( s.GainAttaquantAvecRecyclage.Total ) ;
            }
            public  int CompareGainAvecRC( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.GainAttaquantAvecRecyclage.Total
                     - s2.GainAttaquantAvecRecyclage.Total  ) ;
            }

            public  string afficheRentabiliteSansRC( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return Utils.affEntier( s.RentabiliteAttaquantSansRecyclage.Total ) ;
            }
            public  int CompareRentabiliteSansRC( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.RentabiliteAttaquantSansRecyclage.Total
                     - s2.RentabiliteAttaquantSansRecyclage.Total  ) ;
            }

            public  string afficheGainSansRC( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return Utils.affEntier( s.GainAttaquantSansRecyclage.Total ) ;
            }
            public  int CompareGainSansRC( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.GainAttaquantSansRecyclage.Total
                     - s2.GainAttaquantSansRecyclage.Total  ) ;
            }

            public  string afficheNombreRCMoyen( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return Utils.affEntier( s.Ruines.NombreDeRecycleurs() ) ;
            }
            public  int CompareNombreRCMoyen( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.Ruines.Total
                     - s2.Ruines.Total  ) ;
            }

            public  string afficheNombreRCMax( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return Utils.affEntier( s.MeilleurCas.Ruines.NombreDeRecycleurs() ) ;
            }
            public  int CompareNombreRCMax( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.MeilleurCas.Ruines.Total
                     - s2.MeilleurCas.Ruines.Total ) ;
            }

            public  string afficheMineMetal( RapportDEspionnage rapport )
            {
                if ( ! rapport.BatimentsEstValide ) return "" ;
                return Convert.ToString( rapport.Batiments.MineDeMetal ) ;
            }
            public  int CompareMineMetal( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( !r1.BatimentsEstValide && r2.BatimentsEstValide ) return -1 ;
                if ( r1.BatimentsEstValide && !r2.BatimentsEstValide ) return  1 ;
                if ( !r1.BatimentsEstValide && !r2.BatimentsEstValide ) return  0 ;
                return (int)
                   (   r1.Batiments.MineDeMetal
                     - r2.Batiments.MineDeMetal  ) ;
            }

            public  string afficheMineCristal( RapportDEspionnage rapport )
            {
                if ( ! rapport.BatimentsEstValide ) return "" ;
                return Convert.ToString( rapport.Batiments.MineDeCristal ) ;
            }
            public  int CompareMineCristal( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( !r1.BatimentsEstValide && r2.BatimentsEstValide ) return -1 ;
                if ( r1.BatimentsEstValide && !r2.BatimentsEstValide ) return  1 ;
                if ( !r1.BatimentsEstValide && !r2.BatimentsEstValide ) return  0 ;
                return (int)
                   (   r1.Batiments.MineDeCristal
                     - r2.Batiments.MineDeCristal  ) ;
            }

            public  string afficheMineDeuterium( RapportDEspionnage rapport )
            {
                if ( ! rapport.BatimentsEstValide ) return "" ;
                return Convert.ToString( rapport.Batiments.SynthetiseurDeDeuterium ) ;
            }
            public  int CompareMineDeuterium( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( !r1.BatimentsEstValide && r2.BatimentsEstValide ) return -1 ;
                if ( r1.BatimentsEstValide && !r2.BatimentsEstValide ) return  1 ;
                if ( !r1.BatimentsEstValide && !r2.BatimentsEstValide ) return  0 ;
                return (int)
                   (   r1.Batiments.SynthetiseurDeDeuterium
                     - r2.Batiments.SynthetiseurDeDeuterium  ) ;
            }

            public  string afficheCentraleSolaire( RapportDEspionnage rapport )
            {
                if ( ! rapport.BatimentsEstValide ) return "" ;
                return Convert.ToString( rapport.Batiments.CentraleSolaire ) ;
            }
            public  int CompareCentraleSolaire( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( !r1.BatimentsEstValide && r2.BatimentsEstValide ) return -1 ;
                if ( r1.BatimentsEstValide && !r2.BatimentsEstValide ) return  1 ;
                if ( !r1.BatimentsEstValide && !r2.BatimentsEstValide ) return  0 ;
                return (int)
                   (   r1.Batiments.CentraleSolaire
                     - r2.Batiments.CentraleSolaire ) ;
            }

            public  string afficheSatellites( RapportDEspionnage rapport )
            {
                if ( ! rapport.FlotteAQuaiEstValide ) return "" ;
                return Convert.ToString( rapport.FlotteAQuai.SatellitesSolaires ) ;
            }
            public  int CompareSatellites( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                if ( !r1.FlotteAQuaiEstValide && r2.FlotteAQuaiEstValide ) return -1 ;
                if ( r1.FlotteAQuaiEstValide && !r2.FlotteAQuaiEstValide ) return  1 ;
                if ( !r1.FlotteAQuaiEstValide && !r2.FlotteAQuaiEstValide ) return  0 ;
                return (int)
                   (   r1.FlotteAQuai.SatellitesSolaires
                     - r2.FlotteAQuai.SatellitesSolaires ) ;
            }

            public  string afficheProbabiliteVictoire( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return String.Format("{0:0.00%}", (float)s.NombreDeCombatsGagnes / s.NombreDeSimulations ) ;
            }
            public  int CompareProbabiliteVictoire( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.NombreDeCombatsGagnes
                     - s2.NombreDeCombatsGagnes  ) ;
            }

            public  string afficheProbabiliteNul( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return String.Format("{0:0.00%}", (float)s.NombreDeCombatsNuls / s.NombreDeSimulations ) ;
            }
            public  int CompareProbabiliteNul( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.NombreDeCombatsNuls
                     - s2.NombreDeCombatsNuls  ) ;
            }

            public  string afficheProbabiliteDefaite( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return String.Format("{0:0.00%}", (float)s.NombreDeCombatsPerdus / s.NombreDeSimulations ) ;
            }
            public  int CompareProbabiliteDefaite( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.NombreDeCombatsPerdus
                     - s2.NombreDeCombatsPerdus  ) ;
            }

            public  string afficheNombreDeToursMoyen( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return String.Format("{0:0.00}", s.NombreDeTours ) ;
            }
            public  int CompareNombreDeToursMoyen( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.NombreDeTours
                     - s2.NombreDeTours  ) ;
            }

            public  string afficheConsommation( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return Utils.affEntier( s.Consommation.Deuterium ) ;
            }
            public  int CompareConsommation( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.Consommation.Deuterium
                     - s2.Consommation.Deuterium  ) ;
            }

            public  string afficheTempsDeVolAller( RapportDEspionnage rapport )
            {
                StatistiquesDeSimulation s = ResultatsDesSimulations[rapport.Coordonnees] ;
                if ( s == null ) return "non simulé" ;
                return Utils.affTemps( s.TempsDeTrajet ) ;
            }
            public  int CompareTempsDeVolAller( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                StatistiquesDeSimulation s1 = ResultatsDesSimulations[r1.Coordonnees] ;
                StatistiquesDeSimulation s2 = ResultatsDesSimulations[r2.Coordonnees] ;
                if ( s1 == null && s2 != null ) return -1 ;
                if ( s1 != null && s2 == null ) return  1 ;
                if ( s1 == null && s2 == null ) return  0 ;
                return (int)
                   (   s1.TempsDeTrajet
                     - s2.TempsDeTrajet  ) ;
            }

            public  string afficheCommentaire( RapportDEspionnage rapport )
            {
                return rapport.Commentaire ;
            }
            public  int CompareCommentaire( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return r1.Commentaire.CompareTo( r2.Commentaire ) ;
            }

            public  string afficheContributeur( RapportDEspionnage rapport )
            {
                return rapport.Contributeur ;
            }
            public  int CompareContributeur( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return r1.Contributeur.CompareTo( r2.Contributeur ) ;
            }

        }

        #endregion

        #region Gestion de l'affichage et des évènements de la listview Rapports

        private class ColonneRapport : System.Windows.Forms.ColumnHeader
        {
            private String Description(String titre)
            {
                if ( titre ==             "Nom" ) return "Nom de la planète espionnée" ;
                if ( titre ==            "Date" ) return "Date du rapport" ;
                if ( titre ==           "Infos" ) return "Informations contenues dans le rapport" ;
                if ( titre ==     "Coordonnees" ) return "Coordonnées de la planète espionnée" ;
                if ( titre ==              "()" ) return "Status du joueur" ;
                if ( titre ==         "Res (M)" ) return "Quantité de métal à quai" ;
                if ( titre ==         "Res (C)" ) return "Quantité de cristal à quai" ;
                if ( titre ==         "Res (D)" ) return "Quantité de deutérium à quai" ;
                if ( titre ==             "GTs" ) return "Nombre de GTs nécessaires pour piller au max" ;
                if ( titre ==             "PTs" ) return "Nombre de PTs nécessaires pour piller au max" ;
                if ( titre ==      "Flotte (M)" ) return "Valeur en métal de la flotte à quai recyclée" ;
                if ( titre ==      "Flotte (C)" ) return "Valeur en cristal de la flotte à quai recyclée" ;
                if ( titre ==             "RCs" ) return "Nombre de RCs pour recycler toute la flotte à quai" ;
                if ( titre ==        "Défenses" ) return "Nombre d'unités de défense" ;
                if ( titre ==         "Légères" ) return "Nombre d'unités de défense légères" ;
                if ( titre ==        "Moyennes" ) return "Nombre d'unités de défense moyennes" ;
                if ( titre ==         "Lourdes" ) return "Nombre d'unités de défense lourdes" ;
                if ( titre ==         "Plasmas" ) return "Nombre de lanceurs de plasma" ;
                if ( titre ==      "Total res." ) return "Somme de toutes les ressources à quai" ;
                if ( titre ==      "Mine Métal" ) return "Niveau de la mine de métal" ;
                if ( titre ==    "Mine Cristal" ) return "Niveau de la mine de cristal" ;
                if ( titre ==     "Synth. Deut" ) return "Niveau du synthétiseur de deutérium" ;
                if ( titre ==   "Centrale sol." ) return "Niveau de la centrale solaire" ;
                if ( titre ==      "Satellites" ) return "Nombre de satellites solaires" ;
                if ( titre ==             "VBs" ) return "Nombre de VBs nécessaires pour piller au max" ;
                if ( titre ==             "MIs" ) return "Nombre de missiles d'interception sur la planète" ;
                if ( titre ==            "Cout" ) return "[S] Quantité de carburant nécessaire" ;
                if ( titre ==           "Temps" ) return "[S] Temps de trajet" ;
                if ( titre ==    "Gain avec RC" ) return "[S] Gains avec recyclage (ne compte pas le carburant)" ;
                if ( titre ==    "Gain sans RC" ) return "[S] Gains sans recyclage (ne compte pas le carburant)" ;
                if ( titre ==  "Renta. avec RC" ) return "[S] Rentabilité avec recyclage (carburant compté)" ;
                if ( titre ==  "Renta. sans RC" ) return "[S] Rentabilité sans recyclage (carburant compté)" ;
                if ( titre ==     "RCs (moyen)" ) return "[S] Nombre de recycleurs nécessaires (moyenne)" ;
                if ( titre ==       "RCs (max)" ) return "[S] Nombre de recycleurs nécessaires (max)" ;
                if ( titre ==       "Victoires" ) return "[S] Probabilité de victoire" ;
                if ( titre ==            "Nuls" ) return "[S] Probabilité de match nul" ;
                if ( titre ==        "Défaites" ) return "[S] Probabilité de défaite" ;
                if ( titre ==           "Tours" ) return "[S] Nombre de tours moyen" ;
                if ( titre ==        "Alliance" ) return "Alliance du joueur" ;
                if ( titre ==          "Joueur" ) return "Nom du joueur" ;
                if ( titre ==            "Lune" ) return "Présence d'une lune avec la planète" ;
                if ( titre ==     "Commentaire" ) return "Commentaire personnel" ;
                if ( titre ==    "Contributeur" ) return "Nom de la personne qui a fourni le rapport" ;
                return titre ;
            }
            private String texteParDefaut( RapportDEspionnage rapport )
            {
                return "" ;
            }
            private int triParDefaut( RapportDEspionnage r1, RapportDEspionnage r2 )
            {
                return 0 ;
            }
            private TriOrdre _ordreDeTri ;
            public TriOrdre ordreDeTri
            {
                get { return _ordreDeTri ; }
                set { _ordreDeTri = value ; }
            }
            public ColonneRapport()
            {
                GenereTexte = texteParDefaut ;
                Trie        = triParDefaut   ;
                ordreDeTri = TriOrdre.ASC ;
            }
            public ColonneRapport( ConfigurationColonne configuration )
            {
                litConfiguration( configuration ) ;
            }
            public void litConfiguration( ConfigurationColonne configuration )
            {
                this.Width = configuration.Largeur ;
                this.Text  = configuration.Titre   ;
                this.TextAlign = configuration.Alignement ;
                this.GenereTexte = configuration.Texte ;
                this.Trie = configuration.Tri ;
                this.DisplayIndex = configuration.Index ;
                ordreDeTri = TriOrdre.ASC ;
            }
            public ColonneRapport(int largeur, String titre )
            {
                this.Width = largeur ;
                this.Text  = titre ;
                this.TextAlign = HorizontalAlignment.Right ;
                this.GenereTexte = texteParDefaut ;
                this.Trie = triParDefaut ;
                ordreDeTri = TriOrdre.ASC ;
            }
            public ColonneRapport(int largeur, String titre, generationDuTexte contenu )
            {
                this.Width = largeur ;
                this.Text  = titre ;
                this.TextAlign = HorizontalAlignment.Right ;
                this.GenereTexte = contenu ;
                this.Trie = triParDefaut ;
                ordreDeTri = TriOrdre.ASC ;
            }
            public ColonneRapport(int largeur, String titre, generationDuTexte contenu, fonctionDeTri tri )
            {
                this.Width = largeur ;
                this.Text  = titre ;
                this.TextAlign = HorizontalAlignment.Right ;
                this.GenereTexte = contenu ;
                this.Trie = tri ;
                ordreDeTri = TriOrdre.ASC ;
            }
            public generationDuTexte GenereTexte ;
            public delegate String generationDuTexte( RapportDEspionnage rapport ) ;
            public fonctionDeTri Trie ;
            public delegate int fonctionDeTri( RapportDEspionnage r1, RapportDEspionnage r2 ) ;
            public override String ToString()
            {
                return Description( this.Text ) ;
            }
        }
        private class ColonnesRapport : Collection<ColonneRapport>
        {
            public ColonneRapport RecupereColonneDepuisLaConfiguration( ConfigurationColonne configuration )
            {
                foreach ( ColonneRapport cr in this )
                {
                    if ( cr.Text == configuration.Titre )
                    {
                        cr.litConfiguration( configuration ) ;
                        return cr ;
                    }
                }
                return null ;
            }
        }

        [Serializable]
        private class ConfigurationColonne
        {
            public int Largeur ;
            public String Titre ;
            public HorizontalAlignment Alignement ;
            public ColonneRapport.generationDuTexte Texte ;
            public ColonneRapport.fonctionDeTri Tri ;
            public int Index ;
            public ConfigurationColonne( ColonneRapport cr )
            {
                this.Largeur = cr.Width ;
                this.Titre = cr.Text ;
                this.Alignement = cr.TextAlign ;
                this.Tri = cr.Trie ;
                this.Texte = cr.GenereTexte ;
                this.Index = cr.DisplayIndex ;
            }
        }
        [Serializable]
        private class CollectionConfigurationColonne : Collection<ConfigurationColonne>
        {
        }

        #region Déclaration des colonnes par défaut
        // Colonnes par défaut
        private ColonneRapport Colonne_Nom               ;
        private ColonneRapport Colonne_Date              ;
        private ColonneRapport Colonne_Infos             ;
        private ColonneRapport Colonne_Coordonnees       ;
        private ColonneRapport Colonne_Status            ;
        private ColonneRapport Colonne_ResMetal          ;
        private ColonneRapport Colonne_ResCristal        ;
        private ColonneRapport Colonne_ResDeuterium      ;
        private ColonneRapport Colonne_ResGTs            ;
        private ColonneRapport Colonne_ResPTs            ;
        private ColonneRapport Colonne_FlotteMetal       ;
        private ColonneRapport Colonne_FlotteCristal     ;
        private ColonneRapport Colonne_FlotteRCs         ;
        private ColonneRapport Colonne_DefsTotal         ;
        private ColonneRapport Colonne_DefsLegeres       ;
        private ColonneRapport Colonne_DefsMoyennes      ;
        private ColonneRapport Colonne_DefsLourdes       ;
        private ColonneRapport Colonne_DefsPlasmas       ;
        // Colonnes informations du rapport
        private ColonneRapport Colonne_ResTotal          ;
        private ColonneRapport Colonne_MineMetal         ;
        private ColonneRapport Colonne_MineCristal       ;
        private ColonneRapport Colonne_MineDeuterium     ;
        private ColonneRapport Colonne_CentraleSolaire   ;
        private ColonneRapport Colonne_SatellitesSolaires;
        // Colonnes supplémentaires
        private ColonneRapport Colonne_ResVBs            ;
        private ColonneRapport Colonne_MissInterception  ;
        //private ColonneRapport Colonne_Distance          ;
        private ColonneRapport Colonne_Consommation      ;
        private ColonneRapport Colonne_TempsDeTrajet     ;
        private ColonneRapport Colonne_GainAvecRC        ;
        private ColonneRapport Colonne_GainSansRC        ;
        private ColonneRapport Colonne_RentabiliteAvecRC ;
        private ColonneRapport Colonne_RentabiliteSansRC ;
        private ColonneRapport Colonne_NombreRCMoyen     ;
        private ColonneRapport Colonne_NombreRCMax       ;
        private ColonneRapport Colonne_ProbabiliteVictoire ;
        private ColonneRapport Colonne_ProbabiliteNul    ;
        private ColonneRapport Colonne_ProbabiliteDefaite;
        private ColonneRapport Colonne_NombreDeTours     ;

        private ColonneRapport Colonne_Alliance          ;
        private ColonneRapport Colonne_Joueur            ;
        private ColonneRapport Colonne_AUneLune          ;

        private ColonneRapport Colonne_Commentaire       ;
        private ColonneRapport Colonne_Contributeur      ;
        // Liste de toutes les colonnes possibles
        private ColonnesRapport Colonnes ;
        #endregion

        private void initialiseLesColonnes()
        {
            initialisationColonnesEnCours = true ;

            Colonne_Nom               = new ColonneRapport( 100,            "Nom", affichageEtTri.afficheNom               , affichageEtTri.CompareNom                       ) ;
            Colonne_Date              = new ColonneRapport(  72,           "Date", affichageEtTri.afficheDate              , affichageEtTri.CompareDate                      ) ;
            Colonne_Infos             = new ColonneRapport(  38,          "Infos", affichageEtTri.afficheInfos             , affichageEtTri.CompareInfos                     ) ;
            Colonne_Infos.TextAlign = HorizontalAlignment.Left ;                                                     
            Colonne_Coordonnees       = new ColonneRapport(  79,    "Coordonnees", affichageEtTri.afficheCoordonnees       , affichageEtTri.CompareCoordonnees               ) ;
            Colonne_Coordonnees.TextAlign = HorizontalAlignment.Left ;                                               
            Colonne_Status            = new ColonneRapport(  22,             "()", affichageEtTri.afficheStatus            , affichageEtTri.CompareStatus                    ) ;
            Colonne_ResMetal          = new ColonneRapport(  70,        "Res (M)", affichageEtTri.afficheMetal             , affichageEtTri.CompareMetal                     ) ;
            Colonne_ResCristal        = new ColonneRapport(  70,        "Res (C)", affichageEtTri.afficheCristal           , affichageEtTri.CompareCristal                   ) ;
            Colonne_ResDeuterium      = new ColonneRapport(  70,        "Res (D)", affichageEtTri.afficheDeuterium         , affichageEtTri.CompareDeuterium                 ) ;
            Colonne_ResGTs            = new ColonneRapport(  48,            "GTs", affichageEtTri.afficheNombreDeGTs       , affichageEtTri.CompareRessources                ) ;
            Colonne_ResPTs            = new ColonneRapport(  48,            "PTs", affichageEtTri.afficheNombreDePTs       , affichageEtTri.CompareRessources                ) ;
            Colonne_FlotteMetal       = new ColonneRapport(  70,     "Flotte (M)", affichageEtTri.afficheRuinesMetal       , affichageEtTri.CompareRuinesPotentiellesMetal   ) ;
            Colonne_FlotteCristal     = new ColonneRapport(  70,     "Flotte (C)", affichageEtTri.afficheRuinesCristal     , affichageEtTri.CompareRuinesPotentiellesCristal ) ;
            Colonne_FlotteRCs         = new ColonneRapport(  48,            "RCs", affichageEtTri.afficheNombreDeRCs       , affichageEtTri.CompareRuinesPotentielles        ) ;
            Colonne_DefsTotal         = new ColonneRapport(  64,       "Défenses", affichageEtTri.afficheDefensesTotal     , affichageEtTri.CompareDefenses                  ) ;
            Colonne_DefsLegeres       = new ColonneRapport(  64,        "Légères", affichageEtTri.afficheDefensesLegeres   , affichageEtTri.CompareDefensesLegeres           ) ;
            Colonne_DefsMoyennes      = new ColonneRapport(  64,       "Moyennes", affichageEtTri.afficheDefensesMoyennes  , affichageEtTri.CompareDefensesMoyennes          ) ;
            Colonne_DefsLourdes       = new ColonneRapport(  64,        "Lourdes", affichageEtTri.afficheDefensesLourdes   , affichageEtTri.CompareDefensesLourdes           ) ;
            Colonne_DefsPlasmas       = new ColonneRapport(  64,        "Plasmas", affichageEtTri.afficheDefensesPlasmas   , affichageEtTri.CompareDefensesPlasmas           ) ;

            Colonne_ResTotal          = new ColonneRapport(  64,     "Total res.", affichageEtTri.afficheTotalRessources   , affichageEtTri.CompareRessources                ) ;
            Colonne_MineMetal         = new ColonneRapport(  64,     "Mine Métal", affichageEtTri.afficheMineMetal         , affichageEtTri.CompareMineMetal                 ) ;
            Colonne_MineCristal       = new ColonneRapport(  64,   "Mine Cristal", affichageEtTri.afficheMineCristal       , affichageEtTri.CompareMineCristal               ) ;
            Colonne_MineDeuterium     = new ColonneRapport(  64,    "Synth. Deut", affichageEtTri.afficheMineDeuterium     , affichageEtTri.CompareMineDeuterium             ) ;
            Colonne_CentraleSolaire   = new ColonneRapport(  64,  "Centrale sol.", affichageEtTri.afficheCentraleSolaire   , affichageEtTri.CompareCentraleSolaire           ) ;
            Colonne_SatellitesSolaires= new ColonneRapport(  64,     "Satellites", affichageEtTri.afficheSatellites        , affichageEtTri.CompareSatellites                ) ;

            Colonne_ResVBs            = new ColonneRapport(  48,            "VBs", affichageEtTri.afficheNombreDeVBs       , affichageEtTri.CompareRessources                ) ;
            Colonne_MissInterception  = new ColonneRapport(  60,            "MIs", affichageEtTri.afficheNombreMI          , affichageEtTri.CompareNombreMI                  ) ;

            Colonne_Consommation      = new ColonneRapport(  60,           "Cout", affichageEtTri.afficheConsommation      , affichageEtTri.CompareConsommation              ) ;
            Colonne_TempsDeTrajet     = new ColonneRapport(  60,          "Temps", affichageEtTri.afficheTempsDeVolAller   , affichageEtTri.CompareTempsDeVolAller           ) ;
            Colonne_GainAvecRC        = new ColonneRapport(  60,   "Gain avec RC", affichageEtTri.afficheGainAvecRC        , affichageEtTri.CompareGainAvecRC                ) ;
            Colonne_GainSansRC        = new ColonneRapport(  60,   "Gain sans RC", affichageEtTri.afficheGainSansRC        , affichageEtTri.CompareGainSansRC                ) ;
            Colonne_RentabiliteAvecRC = new ColonneRapport(  60, "Renta. avec RC", affichageEtTri.afficheRentabiliteAvecRC , affichageEtTri.CompareRentabiliteAvecRC         ) ;
            Colonne_RentabiliteSansRC = new ColonneRapport(  60, "Renta. sans RC", affichageEtTri.afficheRentabiliteSansRC , affichageEtTri.CompareRentabiliteSansRC         ) ;
            Colonne_NombreRCMoyen     = new ColonneRapport(  60,    "RCs (moyen)", affichageEtTri.afficheNombreRCMoyen     , affichageEtTri.CompareNombreRCMoyen             ) ;
            Colonne_NombreRCMax       = new ColonneRapport(  60,      "RCs (max)", affichageEtTri.afficheNombreRCMax       , affichageEtTri.CompareNombreRCMax               ) ;
            Colonne_ProbabiliteVictoire=new ColonneRapport(  60,      "Victoires", affichageEtTri.afficheProbabiliteVictoire, affichageEtTri.CompareProbabiliteVictoire      ) ;
            Colonne_ProbabiliteNul    = new ColonneRapport(  60,           "Nuls", affichageEtTri.afficheProbabiliteNul    , affichageEtTri.CompareProbabiliteNul            ) ;
            Colonne_ProbabiliteDefaite= new ColonneRapport(  60,       "Défaites", affichageEtTri.afficheProbabiliteDefaite, affichageEtTri.CompareProbabiliteDefaite        ) ;
            Colonne_NombreDeTours     = new ColonneRapport(  60,          "Tours", affichageEtTri.afficheNombreDeToursMoyen, affichageEtTri.CompareNombreDeToursMoyen        ) ;
            Colonne_Alliance          = new ColonneRapport( 100,       "Alliance", affichageEtTri.afficheAlliance          , affichageEtTri.CompareAlliance                  ) ;
            Colonne_Alliance.TextAlign = HorizontalAlignment.Left ;                                                     
            Colonne_Joueur            = new ColonneRapport( 100,         "Joueur", affichageEtTri.afficheJoueur            , affichageEtTri.CompareJoueur                    ) ;
            Colonne_Joueur.TextAlign = HorizontalAlignment.Left ;                                                     
            Colonne_AUneLune          = new ColonneRapport(  30,           "Lune", affichageEtTri.affichePresenceLune      , affichageEtTri.ComparePresenceLune              ) ;
            Colonne_Commentaire       = new ColonneRapport( 100,    "Commentaire", affichageEtTri.afficheCommentaire       , affichageEtTri.CompareCommentaire               ) ;
            Colonne_Commentaire.TextAlign = HorizontalAlignment.Left ;                                                     
            Colonne_Contributeur      = new ColonneRapport( 100,   "Contributeur", affichageEtTri.afficheContributeur      , affichageEtTri.CompareContributeur              ) ;
            Colonne_Commentaire.TextAlign = HorizontalAlignment.Left ;                                                     

            Colonnes = new ColonnesRapport() ;
            Colonnes.Add( Colonne_Nom               ) ;
            Colonnes.Add( Colonne_Date              ) ;
            Colonnes.Add( Colonne_Infos             ) ;
            Colonnes.Add( Colonne_Coordonnees       ) ;
            Colonnes.Add( Colonne_Status            ) ;
            Colonnes.Add( Colonne_ResMetal          ) ;
            Colonnes.Add( Colonne_ResCristal        ) ;
            Colonnes.Add( Colonne_ResDeuterium      ) ;
            Colonnes.Add( Colonne_ResGTs            ) ;
            Colonnes.Add( Colonne_ResPTs            ) ;
            Colonnes.Add( Colonne_FlotteMetal       ) ;
            Colonnes.Add( Colonne_FlotteCristal     ) ;
            Colonnes.Add( Colonne_FlotteRCs         ) ;
            Colonnes.Add( Colonne_DefsTotal         ) ;
            Colonnes.Add( Colonne_DefsLegeres       ) ;
            Colonnes.Add( Colonne_DefsMoyennes      ) ;
            Colonnes.Add( Colonne_DefsLourdes       ) ;
            Colonnes.Add( Colonne_DefsPlasmas       ) ;
            Colonnes.Add( Colonne_ResTotal          ) ;
            Colonnes.Add( Colonne_MineMetal         ) ;
            Colonnes.Add( Colonne_MineCristal       ) ;
            Colonnes.Add( Colonne_MineDeuterium     ) ;
            Colonnes.Add( Colonne_CentraleSolaire   ) ;
            Colonnes.Add( Colonne_SatellitesSolaires) ;
            Colonnes.Add( Colonne_ResVBs            ) ;
            Colonnes.Add( Colonne_MissInterception  ) ;
            //Colonnes.Add( Colonne_Distance        ) ;
            Colonnes.Add( Colonne_Consommation      ) ;
            Colonnes.Add( Colonne_TempsDeTrajet     ) ;
            Colonnes.Add( Colonne_GainAvecRC        ) ;
            Colonnes.Add( Colonne_GainSansRC        ) ;
            Colonnes.Add( Colonne_RentabiliteAvecRC ) ;
            Colonnes.Add( Colonne_RentabiliteSansRC ) ;
            Colonnes.Add( Colonne_NombreRCMoyen     ) ;
            Colonnes.Add( Colonne_NombreRCMax       ) ;
            Colonnes.Add( Colonne_ProbabiliteVictoire);
            Colonnes.Add( Colonne_ProbabiliteNul    ) ;
            Colonnes.Add( Colonne_ProbabiliteDefaite) ;
            Colonnes.Add( Colonne_NombreDeTours     ) ;
            Colonnes.Add( Colonne_Joueur            ) ;
            Colonnes.Add( Colonne_Alliance          ) ;
            Colonnes.Add( Colonne_AUneLune          ) ;
            Colonnes.Add( Colonne_Commentaire       ) ;
            Colonnes.Add( Colonne_Contributeur      ) ;

            miseAJourDesControlsQuiNecessitentAuMoinsUnRapportDeSelectionne() ;
        }

        private void buttonReinitialiserColonneRapports_Click(object sender, EventArgs e)
        {
            initialisationColonnesEnCours = true ;
            chargeLesColonnesParDefaut() ;
            MetAJourLesColonnesAfficheesDansLaCheckListBox() ;
            initialisationColonnesEnCours = false ;
        }

        private void chargeLesColonnesParDefaut()
        {
            listViewResultats.Columns.Clear() ;
            Colonne_Nom          .Width = 100 ;
            Colonne_Date         .Width =  72 ;
            Colonne_Infos        .Width =  38 ;
            Colonne_Coordonnees  .Width =  79 ;
            Colonne_Status       .Width =  22 ;
            Colonne_ResMetal     .Width =  70 ;
            Colonne_ResCristal   .Width =  70 ;
            Colonne_ResDeuterium .Width =  70 ;
            Colonne_ResGTs       .Width =  48 ;
            Colonne_ResPTs       .Width =  48 ;
            Colonne_FlotteMetal  .Width =  70 ;
            Colonne_FlotteCristal.Width =  70 ;
            Colonne_FlotteRCs    .Width =  48 ;
            Colonne_DefsTotal    .Width =  64 ;
            Colonne_DefsLegeres  .Width =  64 ;
            Colonne_DefsMoyennes .Width =  64 ;
            Colonne_DefsLourdes  .Width =  64 ;
            listViewResultats.Columns.AddRange( new ColonneRapport[] {
                Colonne_Nom           ,
                Colonne_Date          ,
                Colonne_Infos         ,
                Colonne_Coordonnees   ,
                Colonne_Status        ,
                Colonne_ResMetal      ,
                Colonne_ResCristal    ,
                Colonne_ResDeuterium  ,
                Colonne_ResGTs        ,
                Colonne_ResPTs        ,
                Colonne_FlotteMetal   ,
                Colonne_FlotteCristal ,
                Colonne_FlotteRCs     ,
                Colonne_DefsTotal     ,
                Colonne_DefsLegeres   ,
                Colonne_DefsMoyennes  ,
                Colonne_DefsLourdes   
            } ) ; // listViewResultats.Columns.AddRange
            foreach( ColumnHeader c in listViewResultats.Columns )
            {
                c.Width = (int)((float)c.Width * dpi / 96.0) ;
            }
        }

        private void chargeLesColonnes()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                fs = new FileStream( dossierParametres + @"\colonnes.param", FileMode.Open ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                CollectionConfigurationColonne ccr = (CollectionConfigurationColonne)formatter.Deserialize( fs ) ;
                listViewResultats.Columns.Clear() ;
                foreach( ConfigurationColonne cr in ccr )
                {
                    //listViewResultats.Columns.Add( new ColonneRapport(cr) ) ;
                    listViewResultats.Columns.Add( Colonnes.RecupereColonneDepuisLaConfiguration( cr ) ) ;
                }
                for ( int i = 0 ; i < ccr.Count ; ++i )
                {
                    listViewResultats.Columns[i].DisplayIndex = ccr[i].Index ;
                }
            }
            catch ( Exception ex )
            {
                AfficheMessage( "Chargement des colonnes : echec : " + ex.Message ) ;
                chargeLesColonnesParDefaut() ;
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }

            MetAJourLesColonnesAfficheesDansLaCheckListBox();

            initialisationColonnesEnCours = false ;
        }

        private void MetAJourLesColonnesAfficheesDansLaCheckListBox()
        {
            // Mise à jour de l'affichage de la checklistbox qui sert à choisir les colonnes affichées
            ColonnesAfficheesCheckedListBox.Items.Clear();
            foreach (ColonneRapport cr in Colonnes)
            {
                if (listViewResultats.Columns.Contains(cr))
                {
                    ColonnesAfficheesCheckedListBox.Items.Add(cr, true);
                }
                else
                {
                    ColonnesAfficheesCheckedListBox.Items.Add(cr, false);
                }
            }
        }

        private bool initialisationColonnesEnCours ;
        private void ColonnesAfficheesCheckedListBox_ItemCheck(object sender, ItemCheckEventArgs e)
        {
            if ( initialisationColonnesEnCours ) return ;
            if ( e.NewValue == CheckState.Checked )
            {
                listViewResultats.Columns.Add( (ColumnHeader)ColonnesAfficheesCheckedListBox.Items[e.Index] ) ;
            }
            else if ( e.NewValue == CheckState.Unchecked )
            {
                listViewResultats.Columns.Remove( (ColumnHeader)ColonnesAfficheesCheckedListBox.Items[e.Index] ) ;
            }
        }

        private void sauvegardeLesColonnes()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                System.IO.Directory.CreateDirectory( dossierParametres ) ;
                fs = new FileStream( dossierParametres + @"\colonnes.param" , FileMode.Create ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                CollectionConfigurationColonne ccr = new CollectionConfigurationColonne() ;
//                log.Debug( "sauvegardeLesColonnes() :" ) ;
                foreach( ColumnHeader ch in listViewResultats.Columns )
                {
                    ColonneRapport cr = (ch as ColonneRapport ) ;
                    if ( cr != null )
                    {
//                        log.Debug( "  Colonne \"" + cr.Text + "\"" ) ;
                        ccr.Add( new ConfigurationColonne( cr ) ) ;
                    }
                }
                formatter.Serialize( fs, ccr ) ;
//                log.Debug( "sauvergardé." ) ;
            }
            catch ( Exception )
            {
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        private void FormPrincipale_FormClosed(object sender, FormClosedEventArgs e)
        {
        }

        private void listViewResultats_RetrieveVirtualItem( object sender, RetrieveVirtualItemEventArgs e )
        {
            ListViewItem item = new ListViewItem( new string[listViewResultats.Columns.Count] );
            if ( e.ItemIndex < LesRapports.Count )
            {
                RapportDEspionnage Rapport = (LesRapports[e.ItemIndex] as RapportDEspionnage );

                for( int i = 0 ; i < item.SubItems.Count ; ++i )
                {
                    item.SubItems[i].Text = (listViewResultats.Columns[i] as ColonneRapport).GenereTexte( Rapport ) ;
                }

                if ( EstUnAmi( Rapport ) )
                {
                    item.BackColor = Color.DodgerBlue ;
                }
                else
                {
                    long ageEnSecondes = ( DateTime.Now.Ticks - Rapport.DateEtHeure.Ticks ) / 10000000L ;
                    double rapport = (-(double)ageEnSecondes) / (3600*12) + 1 ; 
                    Color CouleurRecent = Color.FromArgb(   0, 255,   0 ) ;
                    Color CouleurMilieu = Color.FromArgb( 255, 255,   0 ) ;
                    Color CouleurAncien = Color.FromArgb( 255,   0,   0 ) ;
                    double rapportDesCouleurs = 0.80 ;
                    item.BackColor = Utils.calculeLaCouleur(rapport, rapportDesCouleurs, CouleurRecent, CouleurMilieu, CouleurAncien) ;
                }
            }
            e.Item = item ;
        }

        private int _listViewResultatsSelection ;
        private int listViewResultatsSelection
        {
            get { return _listViewResultatsSelection ; }
            set
            {
                _listViewResultatsSelection = value ;
                if ( _listViewResultatsSelection >= 0 && _listViewResultatsSelection < LesRapports.Count )
                {
                    RapportDEspionnage r = (LesRapports[listViewResultatsSelection] as RapportDEspionnage) ;
                    AnalysePressePapier = false ;
                    System.Windows.Forms.Clipboard.SetText( "["+r.Coordonnees+"]" ) ;
                    AnalysePressePapier = true ;
                    formRapport.Rapport = r ;
                }
                else
                {
                    _listViewResultatsSelection = -1 ;
                    formRapport.Rapport = null ;
                }
            }
        }

        private void miseAJourDesControlsQuiNecessitentAuMoinsUnRapportDeSelectionne()
        {
            int nombreDeRapports = listViewResultats.SelectedIndices.Count ;
            if ( listViewResultats.VirtualListSize > 0 )
            {
                lancerLaSimulationMassiveToolStripMenuItem.Enabled = true ;
            }
            else
            {
                lancerLaSimulationMassiveToolStripMenuItem.Enabled = false ;
            }
            if ( nombreDeRapports == 1 )
            {
                AfficherLeRapportToolStripMenuItem.Enabled = true ;
            }
            else
            {
                AfficherLeRapportToolStripMenuItem.Enabled = false ;
            }
            EnvoyerEnHautToolStripMenuItem.Enabled = false ;
            envoyerALaFinDeLaListeToolStripMenuItem.Enabled = false ;
            if ( nombreDeRapports > 0 )
            {
                exporterToolStripMenuItem.Enabled = true ;
                toolStripMenuItemCommentaires.Enabled = true ;
                envoyerLesRapportsAuServeurToolStripMenuItem.Enabled = true ;
                copierLeRapportToolStripMenuItem.Enabled = true ;
                copierLeRapportsansfontToolStripMenuItem.Enabled = true ;
                if ( nombreDeRapports > 1 ) 
                {
                    exporterToolStripMenuItem.Text = "Exporter les rapports (fichier)" ;
                    copierLeRapportToolStripMenuItem.Text = "Copier les rapports (forum)" ;
                    copierLeRapportsansfontToolStripMenuItem.Text = "Copier les rapports (sans [font])" ;
                    toolStripMenuItemSupprimerLesRapportsSelectionnes.Text = "Supprimer les rapports" ;
                    toolStripMenuItemSupprimerLesRapportsSelectionnes.Enabled = true ;
                }
                else
                {
                    exporterToolStripMenuItem.Text = "Exporter le rapport (fichier)" ;
                    copierLeRapportToolStripMenuItem.Text = "Copier le rapport (forum)" ;
                    copierLeRapportsansfontToolStripMenuItem.Text = "Copier le rapport (sans [font])" ;
                    EnvoyerEnHautToolStripMenuItem.Enabled = true ;
                    copierLeRapportNormalToolStripMenuItem.Enabled = true ;
                    envoyerALaFinDeLaListeToolStripMenuItem.Enabled = true ;
                    toolStripMenuItemSupprimerLesRapportsSelectionnes.Text = "Supprimer le rapport" ;
                    toolStripMenuItemSupprimerLesRapportsSelectionnes.Enabled = true ;
                }
            }
            else
            {
                exporterToolStripMenuItem.Enabled = false ;
                toolStripMenuItemCommentaires.Enabled = false ;
                envoyerLesRapportsAuServeurToolStripMenuItem.Enabled = false ;
                exporterToolStripMenuItem.Text = "Exporter les rapports (fichier)" ;
                copierLeRapportToolStripMenuItem.Text = "Copier les rapports (forum)" ;
                copierLeRapportsansfontToolStripMenuItem.Text = "Copier les rapports (sans [font])" ;
                copierLeRapportToolStripMenuItem.Enabled = false ;
                copierLeRapportsansfontToolStripMenuItem.Enabled = false ;
                copierLeRapportNormalToolStripMenuItem.Enabled = false ;
                toolStripMenuItemSupprimerLesRapportsSelectionnes.Text = "Supprimer les rapports" ;
                toolStripMenuItemSupprimerLesRapportsSelectionnes.Enabled = false ;
            }
            if ( envoyerLesRapportsAuServeurToolStripMenuItem.Enabled )
            {
                if ( ! serveur.EstConnecte )
                {
                    envoyerLesRapportsAuServeurToolStripMenuItem.Enabled = false ;
                }
                else
                {
                    if ( ! serveur.canImportReports )
                    {
                        envoyerLesRapportsAuServeurToolStripMenuItem.Enabled = false ;
                    }
                }
            }
        }

        private void listViewResultats_ItemSelectionChanged(object sender, ListViewItemSelectionChangedEventArgs e)
        {
            listViewResultatsSelection = e.ItemIndex ;
            RapportDEspionnage Rapport = LesRapports[e.ItemIndex] as RapportDEspionnage ;
            if ( Rapport != null )
            {
                Rapport.Selected = e.IsSelected ;
            }
            miseAJourDesControlsQuiNecessitentAuMoinsUnRapportDeSelectionne() ;
        }

        private void listViewResultats_VirtualItemsSelectionRangeChanged(object sender, ListViewVirtualItemsSelectionRangeChangedEventArgs e)
        {
            // On reaffecte toutes les selections...
            foreach ( RapportDEspionnage Rapport in LesRapports )
            {
                Rapport.Selected = false ;
            }
            for ( int i = 0 ; i < listViewResultats.SelectedIndices.Count ; ++ i )
            {
                RapportDEspionnage Rapport = LesRapports[listViewResultats.SelectedIndices[i]] as RapportDEspionnage ;
                if ( Rapport != null )
                {
                    Rapport.Selected = true ;
                }
            }
            miseAJourDesControlsQuiNecessitentAuMoinsUnRapportDeSelectionne() ;
        }

        private void toolStripMenuItemCopierLesCoordonnees_Click(object sender, EventArgs e)
        {
            recupererLesCoordonneesDuRapportSelectionne() ;
        }

        private void recupererLesCoordonneesDuRapportSelectionne()
        {
            if ( listViewResultatsSelection != -1 )
            {
                AfficheMessage( "Coordonnées ["+listViewResultatsSelection+"] = " + (_LesRapports[listViewResultatsSelection] as RapportDEspionnage).Coordonnees ) ;
            }
        }

        private void supprimeLesRapportsSelectionnes()
        {
            try
            {
                listViewResultats.BeginUpdate() ;
                for ( int i = 0 ; i < LesRapports.Count ; )
                {
                    RapportDEspionnage Rapport = LesRapports[i] as RapportDEspionnage  ;
                    if ( Rapport != null )
                    {
                        if ( Rapport.Selected )
                        {
                            aEteModifie = true ;
                            LesRapports.RemoveAt(i) ;
                            continue ;
                        }
                    }
                    ++i ;
                }
                listViewResultats.SelectedIndices.Clear() ;
                listViewResultatsSelection = -1 ;
                listViewResultats.VirtualListSize = LesRapports.Count ;
            }
            catch( Exception ex )
            {
                listViewResultatsSelection = -1 ;
                AfficheMessage( "Echec de la suppression des rapports : " + ex.Message ) ;
            }
            finally
            {
                listViewResultats.EndUpdate() ;
            }
            listViewResultats.VirtualListSize = LesRapports.Count ;
        }

        private void toolStripMenuItemSupprimerLesRapportsSelectionnes_Click(object sender, EventArgs e)
        {
            supprimeLesRapportsSelectionnes() ;
        }

        private void listViewResultats_KeyDown(object sender, KeyEventArgs e)
        {
            if ( e.KeyCode == Keys.Delete )
            {
                supprimeLesRapportsSelectionnes() ;
            }
            if ( e.KeyCode == Keys.Enter )
            {
                formRapport.Show() ;
            }
            if ( e.KeyCode == Keys.A && e.Control )
            {
                for ( int i = 0 ; i < listViewResultats.VirtualListSize ; ++i )
                {
                    listViewResultats.SelectedIndices.Add( i ) ;
                }
            }
            if ( e.KeyCode == Keys.C && e.Control )
            {
                if ( listViewResultatsSelection != -1 )
                {
                    String aCopier = (_LesRapports[listViewResultatsSelection] as RapportDEspionnage).Texte ;
                    AnalysePressePapier = false ;
                    System.Windows.Forms.Clipboard.SetText( aCopier ) ;
                    AnalysePressePapier = true ;
                    AfficheMessage("Rapport "+(_LesRapports[listViewResultatsSelection] as RapportDEspionnage).Coordonnees+" copié dans le presse papier.") ;
                }
            }
        }

        private void listViewResultats_MouseDoubleClick( object sender, MouseEventArgs e )
        {
            formRapport.Show();
        }

        private void copierToolStripButton_Click(object sender, EventArgs e)
        {
            recupererLesCoordonneesDuRapportSelectionne() ;
        }

        private void EnvoyerEnHautToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if ( listViewResultatsSelection != -1 )
            {
                RapportDEspionnage r = (RapportDEspionnage)LesRapports[listViewResultatsSelection] ;
                LesRapports.RemoveAt(listViewResultatsSelection) ;
                LesRapports.Add(r) ;
                listViewResultats.Refresh() ;
            }
        }

        private void AfficherLeRapportToolStripMenuItem_Click(object sender, EventArgs e)
        {
            formRapport.Show() ;
        }

        private void envoyerALaFinDeLaListeToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if ( listViewResultatsSelection != -1 )
            {
                RapportDEspionnage r = (RapportDEspionnage)LesRapports[listViewResultatsSelection] ;
                LesRapports.RemoveAt(listViewResultatsSelection) ;
                LesRapports.Add(r) ;
                listViewResultats.Refresh() ;
            }
        }

        private void importer( string fichierDepuisLequelImporter )
        {
            FileStream fs = null;
            try
            {
                fs = new FileStream( fichierDepuisLequelImporter, FileMode.Open );
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                ListeDeRapports rapportsImportes = (ListeDeRapports)formatter.Deserialize( fs ) ;
                foreach ( RapportDEspionnage r in rapportsImportes )
                {
                    LesRapports.Add( r ) ;
                }
                aEteModifie = true ;
                MetAJourLAffichageDeLaListe() ;
                AfficheMessage( "" + rapportsImportes.Count + " rapports importés." ) ;
            }
            catch ( Exception ex )
            {
                throw new Exception( "Impossible de charger le fichier : " + ex.Message ) ;
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }
        private void importerToolStripMenuItem_Click( object sender, EventArgs e )
        {
            System.Windows.Forms.OpenFileDialog ouvrir = new System.Windows.Forms.OpenFileDialog() ;
            ouvrir.Title = "Importer les rapports depuis..." ;
            ouvrir.CheckFileExists = true ;
            ouvrir.CheckPathExists = true ;
            ouvrir.Filter = "Fichiers rapports ogame|*.ogr" ;
            if ( ouvrir.ShowDialog(this) == DialogResult.OK )
            {
                string fichierAOuvrir = ouvrir.FileName ;
                try
                {
                    importer( fichierAOuvrir ) ;
                }
                catch ( Exception ex )
                {
                    MessageBox.Show(ex.Message) ;
                }
            }
        }

        private void exporter( string fichierVersLequelExporter )
        {
            Collection<object> trucs = new Collection<object>() ;
            ListeDeRapports rapportsExportes = new ListeDeRapports() ;
            int nombreDeRapportsExportes = 0 ;

            #region chargement du bordel dans le fichier cible (si il existe)
            FileStream fs = null ;
            try
            {
                fs = new FileStream( fichierVersLequelExporter, FileMode.Open );
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                rapportsExportes = (ListeDeRapports)formatter.Deserialize( fs );
                try
                {
                    while ( true )
                    {
                        trucs.Add(formatter.Deserialize( fs )) ;
                    }
                }
                catch ( Exception )
                {
                }
            }
            catch ( Exception )
            {
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
            #endregion
            
            foreach( RapportDEspionnage re in LesRapports )
            {
                if ( re.Selected )
                {
                    rapportsExportes.Add( re ) ;
                    ++nombreDeRapportsExportes ;
                }
            }

            #region Reecriture du fichier cible
            fs = null;
            try
            {
                fs = new FileStream( fichierVersLequelExporter, FileMode.Create ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                formatter.Serialize( fs, rapportsExportes );
                foreach( object o in trucs )
                {
                    formatter.Serialize( fs, o ) ;
                }
            }
            catch ( Exception ex )
            {
                throw new Exception( "Impossible d'enregistrer le fichier : " + ex.Message ) ;
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
            #endregion

            AfficheMessage( "" + nombreDeRapportsExportes + " rapports exportés." ) ;
        }
        private void exporterToolStripMenuItem_Click( object sender, EventArgs e )
        {
            System.Windows.Forms.SaveFileDialog enregistrer = new System.Windows.Forms.SaveFileDialog() ;
            enregistrer.Title = "Exporter les rapports vers..." ;
            enregistrer.CheckPathExists = true ;
            enregistrer.Filter = "Fichiers rapports ogame|*.ogr" ;
            if ( enregistrer.ShowDialog(this) == DialogResult.OK )
            {
                String fichierAEnregistrer = enregistrer.FileName ;
                try
                {
                    exporter( fichierAEnregistrer ) ;
                }
                catch ( Exception ex )
                {
                    AfficheMessage(ex.Message) ;
                }
            }
        }

        #endregion

        #region Gestion de la liste amis (alliances, joueurs et coordonnees)
        
        private class ListeAlliancesAmies : Collection<String>
        {
            public void ReadFromFile( String file )
            {
                StreamReader sr = null ;
                try
                {
                    sr = new StreamReader( file ) ;
                    Clear() ;
                    String ligne ;
                    while ( (ligne = sr.ReadLine()) != null )
                    {
                        Add( ligne.Trim() ) ;
                    }
                }
                catch( Exception )
                {
                }
                finally
                {
                    if ( sr != null ) sr.Close() ;
                }
            }
            public void SaveToFile( String file )
            {
                StreamWriter sw = null ;
                try
                {
                    sw = new StreamWriter( file ) ;
                    foreach( String s in this )
                    {
                        sw.WriteLine( s ) ;
                    }
                }
                catch( Exception )
                {
                }
                finally
                {
                    if ( sw != null ) sw.Close() ;
                }
            }
        }

        private class ListeJoueursAmis : Collection<String>
        {
            public void ReadFromFile( String file )
            {
                StreamReader sr = null ;
                try
                {
                    sr = new StreamReader( file ) ;
                    Clear() ;
                    String ligne ;
                    while ( (ligne = sr.ReadLine()) != null )
                    {
                        Add( ligne.Trim() ) ;
                    }
                }
                catch( Exception )
                {
                }
                finally
                {
                    if ( sr != null ) sr.Close() ;
                }
            }
            public void SaveToFile( String file )
            {
                StreamWriter sw = null ;
                try
                {
                    sw = new StreamWriter( file ) ;
                    foreach( String s in this )
                    {
                        sw.WriteLine( s ) ;
                    }
                }
                catch( Exception )
                {
                }
                finally
                {
                    if ( sw != null ) sw.Close() ;
                }
            }
        }

        private class ListeCoordonneesAmies : Collection<Coordonnees>
        {
            public void ReadFromFile( String file )
            {
                StreamReader sr = null ;
                try
                {
                    sr = new StreamReader( file ) ;
                    Clear() ;
                    String ligne ;
                    while ( (ligne = sr.ReadLine()) != null )
                    {
                        Add( new Coordonnees( ligne.Trim() ) ) ;
                    }
                }
                catch( Exception )
                {
                }
                finally
                {
                    if ( sr != null ) sr.Close() ;
                }
            }
            public void SaveToFile( String file )
            {
                StreamWriter sw = null ;
                try
                {
                    sw = new StreamWriter( file ) ;
                    foreach( Coordonnees c in this )
                    {
                        sw.WriteLine( (String)c ) ;
                    }
                }
                catch( Exception )
                {
                }
                finally
                {
                    if ( sw != null ) sw.Close() ;
                }
            }
        }

        private ListeAlliancesAmies   alliancesAmies   ;
        private ListeJoueursAmis      joueursAmis      ;
        private ListeCoordonneesAmies coordonneesAmies ;

        private void initialiseLesAmis()
        {
            alliancesAmies   = new ListeAlliancesAmies()   ;
            joueursAmis      = new ListeJoueursAmis()      ;
            coordonneesAmies = new ListeCoordonneesAmies() ;
            chargeLesAmis() ;
        }

        private void chargeLesAmis()
        {
            String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
            dossierParametres += @"\Mackila\OgameFarmingInterface" ;
            System.IO.Directory.CreateDirectory( dossierParametres ) ;
            alliancesAmies  .ReadFromFile( dossierParametres + @"\alliancesAmies.txt"   ) ;
            joueursAmis     .ReadFromFile( dossierParametres + @"\joueursAmis.txt"      ) ;
            coordonneesAmies.ReadFromFile( dossierParametres + @"\coordonneesAmies.txt" ) ;
            miseAJourAffichageAmis() ;
        }

        private void sauvegardeLesAmis()
        {
            String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
            dossierParametres += @"\Mackila\OgameFarmingInterface" ;
            System.IO.Directory.CreateDirectory( dossierParametres ) ;
            alliancesAmies  .SaveToFile( dossierParametres + @"\alliancesAmies.txt"   ) ;
            joueursAmis     .SaveToFile( dossierParametres + @"\joueursAmis.txt"      ) ;
            coordonneesAmies.SaveToFile( dossierParametres + @"\coordonneesAmies.txt" ) ;
        }

        private bool EstUnAmi( RapportDEspionnage rapport )
        {
            String alliance = LUniversConnu[rapport.Coordonnees].Alliance ;
            alliance = alliance.Trim() ;
            String joueur = LUniversConnu[rapport.Coordonnees].Joueur ;
            joueur = joueur.Trim() ;
            Coordonnees coordonnees = rapport.Coordonnees ;
            foreach( String s in alliancesAmies )
            {
                if ( s.CompareTo( alliance ) == 0 )
                {
                    return true ;
                }
            }
            foreach( String s in joueursAmis )
            {
                if ( s.CompareTo( joueur ) == 0 )
                {
                    return true ;
                }
            }
            foreach( Coordonnees c in coordonneesAmies )
            {
                if ( c.Equals( coordonnees ) )
                {
                    return true ;
                }
            }
            return false ;
        }

        #region Gestion de l'affichage et des modifications

        private void buttonAjoutCoordonneesAmies_Click(object sender, EventArgs e)
        {
            Coordonnees c = new Coordonnees( textBoxAjoutAmi.Text.Trim() ) ;
            coordonneesAmies.Add( c ) ;
            miseAJourAffichageCoordonneesAmies() ;
            textBoxAjoutAmi.Text = "" ;
        }

        private void buttonAjoutAllianceAmie_Click(object sender, EventArgs e)
        {
            alliancesAmies.Add( textBoxAjoutAmi.Text.Trim() ) ;
            miseAJourAffichageAlliancesAmies() ;
            textBoxAjoutAmi.Text = "" ;
        }

        private void buttonAjoutJoueurAmi_Click(object sender, EventArgs e)
        {
            joueursAmis.Add( textBoxAjoutAmi.Text.Trim() ) ;
            miseAJourAffichageJoueursAmis() ;
            textBoxAjoutAmi.Text = "" ;
        }

        private void miseAJourAffichageAlliancesAmies()
        {
            listBoxAlliancesAmies.Items.Clear() ;
            foreach( String s in alliancesAmies )
            {
                listBoxAlliancesAmies.Items.Add( s ) ;
            }
        }

        private void miseAJourAffichageJoueursAmis()
        {
            listBoxJoueursAmis.Items.Clear() ;
            foreach( String s in joueursAmis )
            {
                listBoxJoueursAmis.Items.Add( s ) ;
            }
        }

        private void miseAJourAffichageCoordonneesAmies()
        {
            listBoxCoordonneesAmies.Items.Clear() ;
            foreach( Coordonnees c in coordonneesAmies )
            {
                listBoxCoordonneesAmies.Items.Add( (String)c ) ;
            }
        }

        private void miseAJourAffichageAmis()
        {
            miseAJourAffichageAlliancesAmies() ;
            miseAJourAffichageJoueursAmis() ;
            miseAJourAffichageCoordonneesAmies() ;
        }

        private void listBoxesAlliance_DoubleClick(object sender, EventArgs e)
        {
            ListBox lb = (sender as ListBox) ;
            if ( lb == null ) return ;

            if ( lb.SelectedIndex >= 0 )
            {
                if ( lb == listBoxAlliancesAmies )
                {
                    alliancesAmies.RemoveAt( lb.SelectedIndex ) ;
                }
                else if ( lb == listBoxJoueursAmis )
                {
                    joueursAmis.RemoveAt( lb.SelectedIndex ) ;
                }
                else if ( lb == listBoxCoordonneesAmies )
                {
                    coordonneesAmies.RemoveAt( lb.SelectedIndex ) ;
                }
                lb.Items.RemoveAt( lb.SelectedIndex ) ;
            }

        }

        #endregion

        #endregion

        #region Gestion des résultats de calculs de simulation massive

        private void initialiseResultatsDeSimulations()
        {
            resultatsDesSimulations = new ResultatsDeSimulationMassive() ;
        }

        private static ResultatsDeSimulationMassive _resultatsDesSimulations = null ;
        public static ResultatsDeSimulationMassive resultatsDesSimulations
        {
            get { return _resultatsDesSimulations ; } 
            set { _resultatsDesSimulations = value ;
            }
        }

        public void EffacerToutesLesSimulations()
        {
            resultatsDesSimulations.Clear() ;
            listViewResultats.Refresh() ;
        }

        public Coordonnees CoordonneesDeLaFlotteAttaquante()
        {
            return new Coordonnees( textBoxFlotteAttaquanteCoordonnees.Text ) ;
        }

        public void EffectuerUneSimulationMassive()
        {
            int NombreDeSimulations = 10 ;
            try
            {
                NombreDeSimulations = Convert.ToInt32( textBoxParamsSimuEnMasseNombreDeSimulations.Text ) ;
            }
            catch ( Exception )
            {
            }
            new FormProgressionSimulationDeMasse(this, NombreDeSimulations).ShowDialog(this) ;
            listViewResultats.Refresh() ;
        }

        private void lancerLaSimulationMassiveToolStripMenuItem_Click(object sender, EventArgs e)
        {
            EffectuerUneSimulationMassive() ;
        }

        #endregion

        #region Gestion chargement/sauvegarde

        private string _nomDuFichierOuvert = "" ;
        private string nomDuFichierOuvert 
        {
            get
            {
                return _nomDuFichierOuvert ;
            }
            set
            {
                _nomDuFichierOuvert = value ;
                if ( _nomDuFichierOuvert == "" )
                {
                    enregistrerToolStripButton.Enabled = false ;
                }
                else
                {
                    enregistrerToolStripButton.Enabled = true ;
                }
            }
        }
        private bool _aEteModifie = false ;
        private bool aEteModifie
        {
            get { return _aEteModifie ; } 
            set {
                if ( !_aEteModifie && value && nomDuFichierOuvert != "" )
                {
                    this.Text += " *";
                }
                if ( !value )
                {
                    this.Text = "Aide au pillage - Mackila - " + nomDuFichierOuvert ;
                }
                _aEteModifie = value ;
            }
        }

        private void nouveauToolStripButton_Click(object sender, EventArgs e)
        {
            LesRapports.Clear() ;
            MetAJourLAffichageDeLaListe() ;
            LUniversConnu = new Univers() ;
            miseAJourDeLAffichageDeLUniversConnu() ;
        }

        private void ouvrirToolStripButton_Click(object sender, EventArgs e)
        {
            System.Windows.Forms.OpenFileDialog ouvrir = new System.Windows.Forms.OpenFileDialog() ;
            ouvrir.CheckFileExists = true ;
            ouvrir.CheckPathExists = true ;
            ouvrir.Filter = "Fichiers rapports ogame|*.ogr" ;
            if ( ouvrir.ShowDialog(this) == DialogResult.OK )
            {
                string fichierAOuvrir = ouvrir.FileName ;
                try
                {
                    Ouvre( fichierAOuvrir ) ;
                    nomDuFichierOuvert = fichierAOuvrir ;
                    this.aEteModifie = false ;
                }
                catch ( Exception ex )
                {
                    MessageBox.Show(ex.Message) ;
                }
            }
        }

        private void Ouvre( string fichierAOuvrir )
        {
            FileStream fs = null;
            try
            {
                fs = new FileStream( fichierAOuvrir, FileMode.Open );
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                LesRapports = (ListeDeRapports)formatter.Deserialize( fs );
                try
                {
                    Empire = (Collection<RapportDEspionnage>)formatter.Deserialize( fs );
                    miseAJourEmpire( Empire );
                    RapportDEspionnage re ;
                    re = (RapportDEspionnage)formatter.Deserialize( fs );
                    textBoxFlotteAttaquanteCoordonnees.Text = re.Coordonnees ;
                    TechnologieDeLaFlotteAttaquante = re.Recherches ;
                    FlotteAttaquante = re.FlotteAQuai ;
                    bindingSourceParametresFlotteAttaquante.Clear() ;
                    bindingSourceParametresFlotteAttaquante.Insert(0, FlotteAttaquante) ;
                    bindingSourceParametresTechnologieAttaquant.Clear() ;
                    bindingSourceParametresTechnologieAttaquant.Insert(0, TechnologieDeLaFlotteAttaquante) ;
                    LUniversConnu = (Univers)formatter.Deserialize( fs ) ;
                    miseAJourDeLAffichageDeLUniversConnu() ;
                    flottesPredefinies = (Collection<RapportDEspionnage>)formatter.Deserialize( fs ) ;
                    miseAJourDeLAffichageDesFlottesPredefinies() ;
                }
                catch ( Exception )
                {
                }
                nomDuFichierOuvert = fichierAOuvrir ;
            }
            catch ( Exception ex )
            {
                throw new Exception( "Impossible de charger le fichier : " + ex.Message ) ;
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        private void enregistrerToolStripButton_Click(object sender, EventArgs e)
        {
            if ( nomDuFichierOuvert != "" )
            {
                try
                {
                    Enregistre( nomDuFichierOuvert ) ;
                    this.aEteModifie = false ;
                    AfficheMessage("Fichier enregistré.") ;
                }
                catch ( Exception ex )
                {
                    AfficheMessage(ex.Message) ;
                }
            }
        }

        private void enregistrerSousToolStripButton_Click( object sender, EventArgs e )
        {
            System.Windows.Forms.SaveFileDialog enregistrer = new System.Windows.Forms.SaveFileDialog() ;
            enregistrer.CheckPathExists = true ;
            enregistrer.Filter = "Fichiers rapports ogame|*.ogr" ;
            if ( enregistrer.ShowDialog(this) == DialogResult.OK )
            {
                String fichierAEnregistrer = enregistrer.FileName ;
                try
                {
                    Enregistre( fichierAEnregistrer ) ;
                    nomDuFichierOuvert = fichierAEnregistrer ;
                    this.aEteModifie = false ;
                }
                catch ( Exception ex )
                {
                    AfficheMessage(ex.Message) ;
                }
            }
        }
        private void Enregistre( String fichierAEnregistrer )
        {
            FileStream fs = null;
            try
            {
                fs = new FileStream( fichierAEnregistrer, FileMode.Create ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                formatter.Serialize( fs, LesRapports );
                formatter.Serialize( fs, Empire );
                #region Récupère les infos utiles dans RapportDEspionnage re
                RapportDEspionnage re = new RapportDEspionnage();
                re.Recherches = TechnologieDeLaFlotteAttaquante;
                re.FlotteAQuai = FlotteAttaquante;
                re.Coordonnees = textBoxFlotteAttaquanteCoordonnees.Text;
                #endregion
                formatter.Serialize( fs, re );
                formatter.Serialize( fs, LUniversConnu );
                formatter.Serialize( fs, flottesPredefinies );
            }
            catch ( Exception ex )
            {
                throw new Exception( "Impossible d'enregistrer le fichier : " + ex.Message ) ;
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        private void FormPrincipale_FormClosing( object sender, FormClosingEventArgs e )
        {
            if ( nomDuFichierOuvert != "" && aEteModifie )
            {
                if ( checkBoxEnregistrerEnQuittant.Checked )
                {
                    try
                    {
                        Enregistre( nomDuFichierOuvert ) ;
                    }
                    catch ( Exception ex )
                    {
                        MessageBox.Show( ex.Message ) ;
                        e.Cancel = true ;
                    }
                }
                else
                {
                    switch (MessageBox.Show("Voulez vous enregistrer le fichier \"" + nomDuFichierOuvert + "\"", "Fermeture", MessageBoxButtons.YesNoCancel, MessageBoxIcon.Question ) ) 
                    {
                        case DialogResult.No :
                            break ;
                        case DialogResult.Yes :
                            try
                            {
                                Enregistre( nomDuFichierOuvert ) ;
                            }
                            catch ( Exception ex )
                            {
                                MessageBox.Show( ex.Message ) ;
                                e.Cancel = true ;
                            }
                            break ;
                        case DialogResult.Cancel :
                            e.Cancel = true ;
                            break ;
                    }
                }
            }
            if ( ! e.Cancel )
            {
                toolStripStatusLabel1.Text = "Fermeture en cours..." ;
                sauvegardeLesParametresServeur() ;
                sauvegardeLesColonnes() ;
                sauvegardePositionEtTaille() ;
                sauvegardeLesAmis() ;
                sauvegardeMiseAJour() ;
            }
        }

        #endregion

        #region divers
        private void ToolStripButton_Click(object sender, EventArgs e)
        {
            new FormAPropos().ShowDialog() ;
        }
        private void imprimerToolStripButton_Click(object sender, EventArgs e)
        {
        }

        private void couperToolStripButton_Click(object sender, EventArgs e)
        {
        }

        private void collerToolStripButton_Click(object sender, EventArgs e)
        {
        }

        private void copierLeRapportToolStripMenuItem_Click( object sender, EventArgs e )
        {
            if ( listViewResultats.SelectedIndices.Count == 0 )
            {
                AfficheMessage("Aucun rapport sélectionné.") ;
            }
            if ( listViewResultats.SelectedIndices.Count == 1 )
            {
                if ( listViewResultatsSelection != -1 )
                {
                    RapportDEspionnage r = (RapportDEspionnage)LesRapports[listViewResultatsSelection] ;
                    AnalysePressePapier = false ;
                    System.Windows.Forms.Clipboard.SetText( Utils.Conversion( r ) ) ;
                    AnalysePressePapier = true ;
                    AfficheMessage("1 rapport copié dans le presse papier.") ;
                }
            }
            else if ( listViewResultats.SelectedIndices.Count > 1 && listViewResultats.SelectedIndices.Count < 20 )
            {
                String s = "" ;
                foreach( int i in listViewResultats.SelectedIndices )
                {
                    RapportDEspionnage r = (RapportDEspionnage)LesRapports[i] ;
                    s += Utils.Conversion( r ) ;
                }
                AnalysePressePapier = false ;
                System.Windows.Forms.Clipboard.SetText( s ) ;
                AnalysePressePapier = true ;
                AfficheMessage("" + listViewResultats.SelectedIndices.Count + " rapports copiés dans le presse papier.") ;
            }
            else
            {
                AfficheMessage("Trop de rapports sélectionnés.") ;
            }
        }

        private void copierLeRapportsansfontToolStripMenuItem_Click( object sender, EventArgs e )
        {
            if ( listViewResultats.SelectedIndices.Count == 0 )
            {
                AfficheMessage("Aucun rapport sélectionné.") ;
            }
            if ( listViewResultats.SelectedIndices.Count == 1 )
            {
                if ( listViewResultatsSelection != -1 )
                {
                    RapportDEspionnage r = (RapportDEspionnage)LesRapports[listViewResultatsSelection] ;
                    AnalysePressePapier = false ;
                    System.Windows.Forms.Clipboard.SetText( Utils.ConversionSansBaliseFont( r ) ) ;
                    AnalysePressePapier = true ;
                    AfficheMessage("1 rapport copié dans le presse papier.") ;
                }
            }
            else if ( listViewResultats.SelectedIndices.Count > 1 && listViewResultats.SelectedIndices.Count < 20 )
            {
                String s = "" ;
                foreach( int i in listViewResultats.SelectedIndices )
                {
                    RapportDEspionnage r = (RapportDEspionnage)LesRapports[i] ;
                    s += Utils.ConversionSansBaliseFont( r ) ;
                }
                AnalysePressePapier = false ;
                System.Windows.Forms.Clipboard.SetText( s ) ;
                AnalysePressePapier = true ;
                AfficheMessage("" + listViewResultats.SelectedIndices.Count + " rapports copiés dans le presse papier.") ;
            }
            else
            {
                AfficheMessage("Trop de rapports sélectionnés.") ;
            }
        }

        #endregion

        #region Gestion empire et flotte attaquante

        public Collection<RapportDEspionnage> Empire ;
        public Flotte FlotteAttaquante ;
        public Technologie TechnologieDeLaFlotteAttaquante ;
        private void initialiseEmpire()
        {
            Empire = new Collection<RapportDEspionnage>() ;
            miseAJourEmpire( Empire ) ;
            FlotteAttaquante = new Flotte(true) ;
            bindingSourceParametresFlotteAttaquante.Insert(0, FlotteAttaquante) ;
            TechnologieDeLaFlotteAttaquante = new Technologie() ;
            bindingSourceParametresTechnologieAttaquant.Insert(0, TechnologieDeLaFlotteAttaquante) ;
            textBoxFlotteAttaquanteCoordonnees.Text = FlotteAttaquante.CoordonneesDeDepart ;
            //miseAJourFlotteAttaquante() ;
            comboBoxVitesse.SelectedItem = comboBoxVitesse.Items[0] ;
        }

        private void miseAJourEmpire( Collection<RapportDEspionnage> empire )
        {
            try
            {
                listViewEmpire.BeginUpdate() ;
                // Initialisation
                listViewEmpire.Items.Clear() ;
                listViewEmpire.Columns.Clear() ;
                // Création des colonnes
                ColumnHeader chEmpireEnTete = new ColumnHeader() ;
                chEmpireEnTete.Text = "" ;
                chEmpireEnTete.Width = (int)(130 * dpi / 96) ;
                listViewEmpire.Columns.Add( chEmpireEnTete ) ;
                foreach( RapportDEspionnage Rapport in empire )
                {
                    ColumnHeader chRapport = new ColumnHeader() ;
                    chRapport.Text = Rapport.NomDeLaPlanete ;
                    chRapport.TextAlign = HorizontalAlignment.Right ;
                    chRapport.Width = (int)(60 * dpi / 96);
                    listViewEmpire.Columns.Add( chRapport ) ;
                }
                // Ajout des lignes
                #region Coordonnées
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Coordonnées" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.Coordonnees ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Petits transporteurs
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Petits transporteurs" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.PetitsTransporteurs.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Grands transporteurs
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Grands transporteurs" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.GrandTransporteurs.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Chasseurs légers
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Chasseurs légers" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.ChasseursLegers.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Chasseurs lourds
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Chasseurs lourds" ;
                    listViewEmpire.Items.Add( i ) ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.ChasseursLourds.ToString() ;
                        ++j ;
                    }
                }
                #endregion
                #region Croiseurs
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Croiseurs" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.Croiseurs.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Vaisseaux de bataille
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Vaisseaux de bataille" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.VaisseauxDeBataille.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Vaisseaux de colonisation
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Vaisseaux de colonisation" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.VaisseauxDeColonisation.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Recycleurs
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Recycleurs" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.Recycleurs.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Sondes d'espionnage
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Sondes d'espionnage" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.SondesDEspionnage.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Bombardiers
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Bombardiers" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.Bombardiers.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Satellites solaires
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Satellites solaires" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.SatellitesSolaires.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Destructeurs
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Destructeurs" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.Destructeurs.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Etoiles de la mort
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Etoiles de la mort" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.EtoilesDeLaMort.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion
                #region Traqueurs
                {
                    ListViewItem i = new ListViewItem( new String[ listViewEmpire.Columns.Count ] ) ;
                    int j = 1 ;
                    i.SubItems[0].Text = "Traqueur" ;
                    foreach( RapportDEspionnage Rapport in empire )
                    {
                        i.SubItems[j].Text = Rapport.FlotteAQuai.Battlecruiser.ToString() ;
                        ++j ;
                    }
                    listViewEmpire.Items.Add( i ) ;
                }
                #endregion

                if ( empire.Count != 0 )
                {
                    textBoxFlotteAttaquanteTechArmes.Text = empire[0].Recherches.Armes.ToString() ;
                    textBoxFlotteAttaquanteTechBoucliers.Text = empire[0].Recherches.Bouclier.ToString();
                    textBoxFlotteAttaquanteTechProtections.Text = empire[0].Recherches.ProtectionDesVaisseauxSpatiaux.ToString();
                    textBoxFlotteAttaquanteTechCombustion.Text = empire[0].Recherches.ReacteurACombustion.ToString();
                    textBoxFlotteAttaquanteTechImpulsion.Text = empire[0].Recherches.ReacteurAImpulsion.ToString();
                    textBoxFlotteAttaquanteTechHyperespace.Text = empire[0].Recherches.PropulsionHyperespace.ToString();
                }
            }
            finally
            {
                listViewEmpire.EndUpdate() ;
            }
        }

        private void miseAJourFlotteAttaquante()
        {
            textBoxFlotteAttaquanteCoordonnees.Text = FlotteAttaquante.CoordonneesDeDepart ;
            bindingSourceParametresFlotteAttaquante.Clear() ;
            bindingSourceParametresFlotteAttaquante.Insert(0, FlotteAttaquante) ;
            bindingSourceParametresTechnologieAttaquant.Clear() ;
            bindingSourceParametresTechnologieAttaquant.Insert(0, TechnologieDeLaFlotteAttaquante) ;
            comboBoxVitesse.SelectedIndex = 10 - (FlotteAttaquante.RatioVitesseFlotte / 10) ;
        }

        private void comboBoxVitesse_TextChanged(object sender, EventArgs e)
        {
            FlotteAttaquante.RatioVitesseFlotte = 100 - (10 * comboBoxVitesse.SelectedIndex ) ;
        }

        private void listViewEmpire_ColumnClick(object sender, ColumnClickEventArgs e)
        {

            if ( e.Column != 0 )
            {
                if ( e.Column-1 < Empire.Count )
                {
                    RapportDEspionnage Rapport = Empire[e.Column-1] ;
                    FlotteAttaquante = Rapport.FlotteAQuai;
                    TechnologieDeLaFlotteAttaquante = Rapport.Recherches;
                    FlotteAttaquante.SatellitesSolaires = 0 ;
                    FlotteAttaquante.CoordonneesDeDepart = Rapport.Coordonnees;
                    miseAJourFlotteAttaquante() ;
                }
            }
            else
            {
                Coordonnees c = FlotteAttaquante.CoordonneesDeDepart ;
                FlotteAttaquante = new Flotte(true) ;
                FlotteAttaquante.CoordonneesDeDepart = c ;
                miseAJourFlotteAttaquante() ;
            }
        }

        #endregion

        #region Gestion flottes prédéfinies

        private Collection<RapportDEspionnage> flottesPredefinies ;

        private void initialiseFlottePredefinies()
        {
            flottesPredefinies = new Collection<RapportDEspionnage>() ;
            metAJoutLEtatDesBoutonsFlottePredefinie() ;
            foreach( ColumnHeader ch in listViewFlottesPersonnalisées.Columns )
            {
                ch.Width = (int)(ch.Width * dpi / 144) ;
            }
        }

        private void miseAJourDeLAffichageDesFlottesPredefinies()
        {
            listViewFlottesPersonnalisées.VirtualListSize = flottesPredefinies.Count ;
            listViewFlottesPersonnalisées.Refresh() ;
        }

        private void buttonAjouterFlottePersonnalisee_Click( object sender, EventArgs e )
        {
            RapportDEspionnage re = new RapportDEspionnage() ;
            re.FlotteAQuai = new Flotte(FlotteAttaquante) ;
            re.FlotteAQuai.CoordonneesDeDepart = textBoxFlotteAttaquanteCoordonnees.Text ;
            re.Recherches = new Technologie(TechnologieDeLaFlotteAttaquante) ;
            flottesPredefinies.Add( re ) ;
            aEteModifie = true ;
            miseAJourDeLAffichageDesFlottesPredefinies() ;
        }

        private void listViewFlottesPersonnalisées_DoubleClick( object sender, EventArgs e )
        {
            buttonChargerFlottePersonnalisee_Click( sender, e ) ;
        }

        private void buttonChargerFlottePersonnalisee_Click( object sender, EventArgs e )
        {
            if ( listViewFlottesPersonnalisées.SelectedIndices.Count == 1 )
            {
                RapportDEspionnage re = new RapportDEspionnage( flottesPredefinies[ listViewFlottesPersonnalisées.SelectedIndices[0] ] ) ;
                FlotteAttaquante = re.FlotteAQuai ;
                TechnologieDeLaFlotteAttaquante = re.Recherches ;
                miseAJourFlotteAttaquante() ;
            }
        }

        private void listViewFlottesPersonnalisées_RetrieveVirtualItem( object sender, RetrieveVirtualItemEventArgs e )
        {
            ListViewItem item = new ListViewItem( new string[listViewFlottesPersonnalisées.Columns.Count] );
            if ( e.ItemIndex < flottesPredefinies.Count )
            {
                RapportDEspionnage Rapport = (flottesPredefinies[e.ItemIndex] as RapportDEspionnage ) ;
                item.SubItems[ 0].Text = Rapport.FlotteAQuai.CoordonneesDeDepart ;
                item.SubItems[ 1].Text = Utils.affEntier( Rapport.FlotteAQuai.PetitsTransporteurs     ) ;
                item.SubItems[ 2].Text = Utils.affEntier( Rapport.FlotteAQuai.GrandTransporteurs      ) ;
                item.SubItems[ 3].Text = Utils.affEntier( Rapport.FlotteAQuai.ChasseursLegers         ) ;
                item.SubItems[ 4].Text = Utils.affEntier( Rapport.FlotteAQuai.ChasseursLourds         ) ;
                item.SubItems[ 5].Text = Utils.affEntier( Rapport.FlotteAQuai.Croiseurs               ) ;
                item.SubItems[ 6].Text = Utils.affEntier( Rapport.FlotteAQuai.VaisseauxDeBataille     ) ;
                item.SubItems[ 7].Text = Utils.affEntier( Rapport.FlotteAQuai.VaisseauxDeColonisation ) ;
                item.SubItems[ 8].Text = Utils.affEntier( Rapport.FlotteAQuai.Recycleurs              ) ;
                item.SubItems[ 9].Text = Utils.affEntier( Rapport.FlotteAQuai.SondesDEspionnage       ) ;
                item.SubItems[10].Text = Utils.affEntier( Rapport.FlotteAQuai.Bombardiers             ) ;
                item.SubItems[11].Text = Utils.affEntier( Rapport.FlotteAQuai.Destructeurs            ) ;
                item.SubItems[12].Text = Utils.affEntier( Rapport.FlotteAQuai.EtoilesDeLaMort         ) ;
                item.SubItems[13].Text = Utils.affEntier( Rapport.FlotteAQuai.Battlecruiser           ) ;
                item.SubItems[14].Text = Rapport.FlotteAQuai.RatioVitesseFlotte.ToString() + "%" ;
                item.SubItems[15].Text = Utils.affEntier( Rapport.Recherches.Armes                          ) ;
                item.SubItems[16].Text = Utils.affEntier( Rapport.Recherches.Bouclier                       ) ;
                item.SubItems[17].Text = Utils.affEntier( Rapport.Recherches.ProtectionDesVaisseauxSpatiaux ) ;
                item.SubItems[18].Text = Utils.affEntier( Rapport.Recherches.ReacteurACombustion            ) ;
                item.SubItems[19].Text = Utils.affEntier( Rapport.Recherches.ReacteurAImpulsion             ) ;
                item.SubItems[20].Text = Utils.affEntier( Rapport.Recherches.PropulsionHyperespace          ) ;
            }
            e.Item = item ;
        }

        private void buttonMonterFlottePersonnalisee_Click( object sender, EventArgs e )
        {
            if ( listViewFlottesPersonnalisées.SelectedIndices.Count == 1 )
            {
                int indiceSelectionne = listViewFlottesPersonnalisées.SelectedIndices[0] ;
                if ( indiceSelectionne > 0 )
                {
                    RapportDEspionnage tmp = flottesPredefinies[indiceSelectionne-1] ;
                    flottesPredefinies[indiceSelectionne-1] = flottesPredefinies[indiceSelectionne] ;
                    flottesPredefinies[indiceSelectionne] = tmp ;
                    aEteModifie = true ;
                    miseAJourDeLAffichageDesFlottesPredefinies() ;
                    listViewFlottesPersonnalisées.SelectedIndices.Clear() ;
                    listViewFlottesPersonnalisées.SelectedIndices.Add(indiceSelectionne-1) ;
                }
            }
        }

        private void buttonSupprimerFlottePersonnalisee_Click( object sender, EventArgs e )
        {
            if ( listViewFlottesPersonnalisées.SelectedIndices.Count == 1 )
            {
                flottesPredefinies.RemoveAt( listViewFlottesPersonnalisées.SelectedIndices[0] ) ;
                aEteModifie = true ;
                miseAJourDeLAffichageDesFlottesPredefinies() ;
            }
        }

        private void buttonDescendreFlottePersonnalisee_Click( object sender, EventArgs e )
        {
            if ( listViewFlottesPersonnalisées.SelectedIndices.Count == 1 )
            {
                int indiceSelectionne = listViewFlottesPersonnalisées.SelectedIndices[0] ;
                if ( indiceSelectionne < flottesPredefinies.Count-1 )
                {
                    RapportDEspionnage tmp = flottesPredefinies[indiceSelectionne+1] ;
                    flottesPredefinies[indiceSelectionne+1] = flottesPredefinies[indiceSelectionne] ;
                    flottesPredefinies[indiceSelectionne] = tmp ;
                    aEteModifie = true ;
                    miseAJourDeLAffichageDesFlottesPredefinies() ;
                    listViewFlottesPersonnalisées.SelectedIndices.Clear() ;
                    listViewFlottesPersonnalisées.SelectedIndices.Add(indiceSelectionne+1) ;
                }
            }
        }

        private void listViewFlottesPersonnalisées_KeyDown( object sender, KeyEventArgs e )
        {
            if ( e.KeyCode == Keys.Delete )
            {
                buttonSupprimerFlottePersonnalisee_Click(null, null) ;
                metAJoutLEtatDesBoutonsFlottePredefinie() ;
            }
            if ( e.KeyCode == Keys.Enter )
            {
                buttonChargerFlottePersonnalisee_Click(null, null) ;
            }
        }

        private void metAJoutLEtatDesBoutonsFlottePredefinie()
        {
            if ( listViewFlottesPersonnalisées.SelectedIndices.Count == 1 )
            {
                buttonChargerFlottePersonnalisee.Enabled = true ;
                buttonMonterFlottePersonnalisee.Enabled = (listViewFlottesPersonnalisées.SelectedIndices[0] > 0) ;
                buttonSupprimerFlottePersonnalisee.Enabled = true ;
                buttonDescendreFlottePersonnalisee.Enabled = (listViewFlottesPersonnalisées.SelectedIndices[0] < flottesPredefinies.Count-1 ) ;
            }
            else
            {
                buttonChargerFlottePersonnalisee.Enabled   = false ;
                buttonMonterFlottePersonnalisee.Enabled    = false ;
                buttonSupprimerFlottePersonnalisee.Enabled = false ;
                buttonDescendreFlottePersonnalisee.Enabled = false ;
            }
        }

        private void listViewFlottesPersonnalisées_ItemSelectionChanged( object sender, ListViewItemSelectionChangedEventArgs e )
        {
            metAJoutLEtatDesBoutonsFlottePredefinie() ;
        }

        private void listViewFlottesPersonnalisées_VirtualItemsSelectionRangeChanged( object sender, ListViewVirtualItemsSelectionRangeChangedEventArgs e )
        {
            metAJoutLEtatDesBoutonsFlottePredefinie() ;
        }


        #endregion

        #region Gestion simulation

        private void initialiseSimulation()
        {
        }

        private void simulerUnCombatToolStripMenuItem_Click(object sender, EventArgs e)
        {
            FormSimulation formSimulation = new FormSimulation() ;
            formSimulation.FlotteAttaquant = FlotteAttaquante ;
            formSimulation.TechnologieAttaquant = TechnologieDeLaFlotteAttaquante ;
            formSimulation.CoordonneesAttaquant = textBoxFlotteAttaquanteCoordonnees.Text ;
            if ( listViewResultatsSelection != -1 )
            {
                formSimulation.Defenseur = (LesRapports[listViewResultatsSelection] as RapportDEspionnage) ;
            }
            formSimulation.Show() ;
        }

        #endregion

        #region Gestion de l'univers connu

        private static Univers _LUniversConnu = null ;
        public static Univers LUniversConnu
        {
            get {
                if ( _LUniversConnu == null ) _LUniversConnu = new Univers() ;
                return _LUniversConnu ;
            }
            set {
                _LUniversConnu = value ;
            }
        }

        private int GalaxieAAfficher ;
        private int SystemeAAfficher ;
        private Systeme LeSystemeAAfficher ;
        private ImageList imagesStatusSystemes ;

        private void initialiseLUniversConnu()
        {
            LUniversConnu = new Univers() ;
            imagesStatusSystemes = new ImageList() ;
            imagesStatusSystemes.Images.Add( global::OgameFarmingInterface.Properties.Resources.RienAAfficher ) ;
            imagesStatusSystemes.Images.Add( global::OgameFarmingInterface.Properties.Resources.InformationsDisponibles ) ;
            listViewUnivers.SmallImageList = imagesStatusSystemes ;
            foreach( ColumnHeader c in listViewSysteme.Columns )
            {
                c.Width = (int)((float)c.Width * dpi / 96.0) ;
            }
            // Génère les onglets
            tabControlUnivers.TabPages.Clear() ;
            tabControlUnivers.TabPages.Add( "Galaxie 1" ) ;
            for( int g = 2 ; g <= Valeurs.maxGalaxie ; ++g )
            {
                tabControlUnivers.TabPages.Add( "  G"+g.ToString() ) ;
            }
            listViewUnivers.VirtualListSize = Valeurs.maxSysteme ;
#if !PINGOUIN
            GalaxieAAfficher = 5 ;
            SystemeAAfficher = 371 ;
#else
            GalaxieAAfficher = 1 ;
            SystemeAAfficher = 1 ;
#endif
            tabControlUnivers.SelectedIndex = GalaxieAAfficher-1 ;

            miseAJourDeLAffichageDeLUniversConnu() ;
        }

        private void tabControlUnivers_Selected(object sender, TabControlEventArgs e)
        {
            miseAJourDeLAffichageDeLUniversConnu() ;
            listViewUnivers.SelectedIndices.Clear() ;
        }

        private void listViewUnivers_SelectedIndexChanged(object sender, EventArgs e)
        {
            if ( listViewUnivers.SelectedIndices.Count > 0 )
            {
                int galaxie = tabControlUnivers.SelectedIndex+1 ;
                int systeme = listViewUnivers.SelectedIndices[0]+1 ;
                GalaxieAAfficher = galaxie ;
                SystemeAAfficher = systeme ;
                miseAJourDeLaGalaxieSpecifiee() ;
            }
        }

        private void miseAJourDeLaGalaxieSpecifiee()
        {
            LeSystemeAAfficher = null ;
            if ( LUniversConnu.GalaxieNonNulle( GalaxieAAfficher ) )
            {
                if ( LUniversConnu[GalaxieAAfficher].SystemeNonNul( SystemeAAfficher ) )
                {
                    LeSystemeAAfficher = LUniversConnu[GalaxieAAfficher,SystemeAAfficher] ;
                }
            }
            groupBoxVueSysteme.Text = "Système " + GalaxieAAfficher + ":" + SystemeAAfficher ;
            listViewSysteme.Refresh() ;
        }

        private void miseAJourDeLAffichageDeLUniversConnu()
        {
            listViewUnivers.Refresh() ;
            miseAJourDeLaGalaxieSpecifiee() ;
        }

        private Color couleurDeFondDUnItemSysteme( DateTime dateDuSysteme )
        {
            long ageEnSecondes = ( DateTime.Now.Ticks - dateDuSysteme.Ticks ) / 10000000L ;
            // 5 jours pour atteindre le rouge, 1 jour pour atteindre le jaune.
            double rapport = (-(double)ageEnSecondes) / (3600*24*5) + 1 ; 
            double rapportDesCouleurs = 0.80 ;
            Color CouleurRecent = Color.FromArgb(   0, 255,   0 ) ;
            Color CouleurMilieu = Color.FromArgb( 255, 255,   0 ) ;
            Color CouleurAncien = Color.FromArgb( 255,   0,   0 ) ;
            return Utils.calculeLaCouleur(rapport, rapportDesCouleurs, CouleurRecent, CouleurMilieu, CouleurAncien) ;
        }

        private void listViewUnivers_RetrieveVirtualItem(object sender, RetrieveVirtualItemEventArgs e)
        {
            int galaxie = tabControlUnivers.SelectedIndex+1 ;
            int systeme = e.ItemIndex+1 ;
            ListViewItem i = new ListViewItem() ;
            i.Text = Convert.ToString( galaxie ) + ":" + systeme ;
            i.ImageIndex = 0 ;
            i.ForeColor = System.Drawing.SystemColors.GrayText ;
            if ( LUniversConnu.GalaxieNonNulle( galaxie ) )
            {
                if ( LUniversConnu[galaxie].SystemeNonNul( systeme ) )
                {
                    i.ImageIndex = 1 ;
                    i.Text += "  " + LUniversConnu[galaxie, systeme].NombreDePlanetes() ;
                    i.Text += (LUniversConnu[galaxie, systeme].NombreDeLunes() > 0) ? " M" : "  " ;
                    i.Text +=  "    "  ;
                    i.ForeColor = System.Drawing.SystemColors.WindowText;
                    i.BackColor = couleurDeFondDUnItemSysteme( LUniversConnu[galaxie, systeme].DateEtHeureDuRapportLePlusRecent() ) ;
                }
            }
            e.Item = i ;
        }

        private void listViewSysteme_RetrieveVirtualItem(object sender, RetrieveVirtualItemEventArgs e)
        {
            ListViewItem i = new ListViewItem( new string[listViewSysteme.Columns.Count] ) ;
            int position = e.ItemIndex+1 ;
            i.Text = position.ToString() ;
            if ( LeSystemeAAfficher != null )
            {
                if ( LeSystemeAAfficher.PlaneteNonNulle( position ) )
                {
                    string status = "" ;
                    i.BackColor = Color.FromArgb(15, 0, 60);
                    #region Ajoute le status au nom
                    switch ( LeSystemeAAfficher[position].Status )
                    {
                        case StatusJoueur.Bloque      :
                            i.ForeColor = Color.Red            ;
                            status = " (b v)" ;
                            break ;
                        case StatusJoueur.Debutant    :
                            i.ForeColor = Color.LightGreen     ;
                            status = " (d)" ;
                            break ;
                        case StatusJoueur.Inactif     :
                            i.ForeColor = Color.LightGray      ;
                            status = " (i)" ;
                            break ;
                        case StatusJoueur.InactifLong :
                            i.ForeColor = Color.DarkGray       ;
                            status = " (i I)" ;
                            break ;
                        case StatusJoueur.Normal      :
                            i.ForeColor = Color.White          ;
                            status = "" ;
                            break ;
                        case StatusJoueur.Vacances    :
                            i.ForeColor = Color.LightSteelBlue ;
                            status = " (v)" ;
                            break ;
                    }
                    #endregion
                    int Galaxie = GalaxieAAfficher ;
                    int Systeme = SystemeAAfficher ;
                    int Planete = position ;
                    RapportDEspionnage rapportLePlusRecent = LesRapports[new Coordonnees((ushort)Galaxie,(ushort)Systeme,(ushort)Planete)] ;
                    i.SubItems[1].Text = LeSystemeAAfficher[position].AUneLune?"M":"" ;
                    if ( rapportLePlusRecent == null )
                    {
                        i.SubItems[2].Text = "" ;
                    }
                    else
                    {
                        string Infos = "*" ;
                        if ( rapportLePlusRecent.FlotteAQuaiEstValide ) Infos += "*" ;
                        if ( rapportLePlusRecent.DefensesEstValide ) Infos += "*" ;
                        if ( rapportLePlusRecent.BatimentsEstValide ) Infos += "*" ;
                        if ( rapportLePlusRecent.RecherchesEstValide ) Infos += "*" ;
                        i.SubItems[2].Text = Infos ;
                    }
                    i.SubItems[3].Text = LeSystemeAAfficher[position].DateEtHeureDeLecture.ToShortDateString() ;
                    i.SubItems[4].Text = LeSystemeAAfficher[position].Nom ;
                    i.SubItems[5].Text = LeSystemeAAfficher[position].Joueur + status ;
                    i.SubItems[6].Text = LeSystemeAAfficher[position].Alliance ;
                }
            }
            e.Item = i ;
        }

        private void simulerUnCombatToolStripMenuSystemeItem_Click(object sender, EventArgs e)
        {
            if ( listViewSysteme.SelectedIndices.Count <= 0 ) return ;
            int Galaxie = GalaxieAAfficher ;
            int Systeme = SystemeAAfficher ;
            int Planete = listViewSysteme.SelectedIndices[0]+1 ;
            RapportDEspionnage rapportLePlusRecent = LesRapports[new Coordonnees((ushort)Galaxie,(ushort)Systeme,(ushort)Planete)] ;
            if ( rapportLePlusRecent == null ) rapportLePlusRecent = new RapportDEspionnage() ;
            FormSimulation formSimulation = new FormSimulation() ;
            formSimulation.FlotteAttaquant = FlotteAttaquante ;
            formSimulation.TechnologieAttaquant = TechnologieDeLaFlotteAttaquante ;
            formSimulation.CoordonneesAttaquant = textBoxFlotteAttaquanteCoordonnees.Text ;
            formSimulation.Defenseur = rapportLePlusRecent ;
            formSimulation.Show() ;
        }

        private void listViewResultatsDeRecherche_DoubleClick( object sender, EventArgs e )
        {
            if ( listViewResultatsDeRecherche.SelectedIndices.Count == 1 )
            {
                formRapport.Show() ;
            }
        }

        private void listViewResultatsDeRecherche_SelectedIndexChanged( object sender, EventArgs e )
        {
            if ( listViewResultatsDeRecherche.SelectedIndices.Count == 1 )
            {
                formRapport.Rapport = LesRapports[new Coordonnees(listViewResultatsDeRecherche.SelectedItems[0].Text)] ;
            }
        }

        private void listViewSysteme_SelectedIndexChanged( object sender, EventArgs e )
        {
            if ( listViewSysteme.SelectedIndices.Count == 1 )
            {
                formRapport.Rapport = LesRapports[
                    new Coordonnees((ushort)( GalaxieAAfficher                     ),
                                    (ushort)( SystemeAAfficher                     ),
                                    (ushort)( listViewSysteme.SelectedIndices[0]+1 ) )
                                                 ] ;
            }
        }

        private void listViewSysteme_MouseDoubleClick( object sender, MouseEventArgs e )
        {
            formRapport.Show() ;
        }

        private void afficherLeRapportToolStripMenuSystemeItem_Click( object sender, EventArgs e )
        {
            if ( listViewSysteme.SelectedIndices.Count == 1 )
            {
                formRapport.Rapport = LesRapports[
                    new Coordonnees((ushort)( GalaxieAAfficher                     ),
                                    (ushort)( SystemeAAfficher                     ),
                                    (ushort)( listViewSysteme.SelectedIndices[0]+1 ) )
                                                 ] ;
                formRapport.Show() ;
            }
        }


        #endregion

        #region Gestion de la recherche dans l'univers connu

        private void initialiseRechercheUnivers()
        {
            derniereRecherche_nom = "" ;
            derniereRecherche_type = typeDeRecherche.Alliance ;
            buttonCopierResultatRecherche.Enabled = false ;
            typeDeLaRecherche = typeDeRecherche.Alliance ;
            nomARechercher = "" ;
            textBoxNomARechercher.Text = nomARechercher ;
            buttonLancerLaRecherche.Enabled = false ;
            foreach( ColumnHeader ch in listViewResultatsDeRecherche.Columns )
            {
                ch.Width = (int)((float)ch.Width * dpi / 96.0) ;
            }
        }

        private enum typeDeRecherche
        {
            Alliance,
            Joueur
        }

        private typeDeRecherche typeDeLaRecherche ;

        private String nomARechercher ;

        private void ajoutePlaneteDansLesResultatsDeRecherche( Planete p )
        {
            ListViewItem i = new ListViewItem( new String[listViewResultatsDeRecherche.Columns.Count] ) ;
            i.SubItems[0].Text = p.coordonnees ;
            i.SubItems[1].Text = p.Joueur      ;
            i.SubItems[2].Text = p.Alliance    ;
            i.SubItems[3].Text = p.AUneLune?"M":"" ;
            listViewResultatsDeRecherche.Items.Add( i ) ;
            buttonCopierResultatRecherche.Enabled = true ;
        }

        private bool RechercheUnivers( Planete p )
        {
            switch ( typeDeLaRecherche  )
            {
                case typeDeRecherche.Alliance :
                    if ( p.Alliance.ToLower().Contains( nomARechercher ) )
                    {
                        ajoutePlaneteDansLesResultatsDeRecherche( p ) ;
                    }
                    break ;
                case typeDeRecherche.Joueur :
                    if ( p.Joueur.ToLower().Contains( nomARechercher ) )
                    {
                        ajoutePlaneteDansLesResultatsDeRecherche( p ) ;
                    }
                    break ;
            }
            return true ;
        }

        private String derniereRecherche_nom ;
        private typeDeRecherche derniereRecherche_type ;

        private void lancerLaRecherche()
        {
            derniereRecherche_type = typeDeLaRecherche ;
            derniereRecherche_nom = nomARechercher ;
            buttonCopierResultatRecherche.Enabled = false ;
            listViewResultatsDeRecherche.Items.Clear() ;
            LUniversConnu.PourChaquePlaneteDeLUnivers_Faire( RechercheUnivers ) ;
        }

        private void buttonLancerLaRecherche_Click( object sender, EventArgs e )
        {
            lancerLaRecherche() ;
        }

        private void textBoxNomARechercher_KeyDown( object sender, KeyEventArgs e )
        {
            if (    e.KeyCode == Keys.Return
                 || e.KeyCode == Keys.Enter   )
            {
                lancerLaRecherche() ;
            }
        }

        private void textBoxNomARechercher_TextChanged( object sender, EventArgs e )
        {
            nomARechercher = textBoxNomARechercher.Text.ToLower() ;
            if ( nomARechercher.Length <= 1 )
            {
                buttonLancerLaRecherche.Enabled = false ;
            }
            else
            {
                buttonLancerLaRecherche.Enabled = true ;
            }
        }

        private void radioButtonChercheAlliance_CheckedChanged( object sender, EventArgs e )
        {
            if ( radioButtonChercheAlliance.Checked )
            {
                typeDeLaRecherche = typeDeRecherche.Alliance ;
            }
        }

        private void radioButtonChercheJoueur_CheckedChanged( object sender, EventArgs e )
        {
            if ( radioButtonChercheJoueur.Checked )
            {
                typeDeLaRecherche = typeDeRecherche.Joueur ;
            }
        }

        private String resultatsDeRecherche()
        {
            StringBuilder r = new StringBuilder() ;
            switch ( derniereRecherche_type )
            {
                case typeDeRecherche.Alliance :
                    r.Append( "Recherche alliance \"" ) ;
                    break ;
                case typeDeRecherche.Joueur :
                    r.Append( "Recherche joueur \"" ) ;
                    break ;
            }
            r.Append( derniereRecherche_nom + "\"\r\n" ) ;
            r.Append( "" + listViewResultatsDeRecherche.Items.Count + " résultats :\r\n" ) ;
            foreach ( ListViewItem i in listViewResultatsDeRecherche.Items )
            {
                r.Append( ("[" + i.SubItems[0].Text + "]").PadRight(11, ' ')
                        + i.SubItems[3].Text.Trim().PadRight(2, ' ')
                        + i.SubItems[1].Text.Trim()
                        + "  ( " + i.SubItems[2].Text.Trim() + " )\r\n" ) ;
            }
            return r.ToString() ;
        }

        private void buttonCopierResultatRecherche_Click( object sender, EventArgs e )
        {
            AnalysePressePapier = false ;
            System.Windows.Forms.Clipboard.SetText( resultatsDeRecherche() ) ;
            AnalysePressePapier = true ;
            AfficheMessage("Résultat de recherche copié dans le presse papier.") ;
        }

        private void listViewResultatsDeRecherche_ColumnClick( object sender, ColumnClickEventArgs e )
        {
            switch ( e.Column )
            {
                case 0 :
                    listViewResultatsDeRecherche.ListViewItemSorter = new ListViewItemComparer_Coordonnees( 0 ) ;
                    break ;
                case 1 :
                    listViewResultatsDeRecherche.ListViewItemSorter = new ListViewItemComparer_Chaine( 1 ) ;
                    break ;
                case 2 :
                    listViewResultatsDeRecherche.ListViewItemSorter = new ListViewItemComparer_Chaine( 2 ) ;
                    break ;
                case 3 :
                    listViewResultatsDeRecherche.ListViewItemSorter = new ListViewItemComparer_Chaine( 3 ) ;
                    break ;
            }
        }

        class ListViewItemComparer_Coordonnees : IComparer
        {
            private int col ;
            public ListViewItemComparer_Coordonnees()
            {
                col = 0 ;
            }
            public ListViewItemComparer_Coordonnees(int column)
            {
                col = column ;
            }
            public int Compare(object x, object y)
            {
                ListViewItem lx = ( x as ListViewItem ) ;
                ListViewItem ly = ( y as ListViewItem ) ;
                if ( lx.SubItems.Count < col || ly.SubItems.Count < col )
                {
                    return lx.Index - ly.Index ;
                }
                Coordonnees cx = new Coordonnees( lx.SubItems[col].Text ) ;
                Coordonnees cy = new Coordonnees( ly.SubItems[col].Text ) ;
                return cx.CompareTo( cy ) ;
            }
        }
        // Implements the manual sorting of items by columns.
        class ListViewItemComparer_Chaine : IComparer
        {
            private int col ;
            public ListViewItemComparer_Chaine()
            {
                col = 0 ;
            }
            public ListViewItemComparer_Chaine(int column)
            {
                col = column ;
            }
            public int Compare(object x, object y)
            {
                ListViewItem lx = ( x as ListViewItem ) ;
                ListViewItem ly = ( y as ListViewItem ) ;
                if ( lx.SubItems.Count < col || ly.SubItems.Count < col )
                {
                    return lx.Index - ly.Index ;
                }
                return String.Compare(lx.SubItems[col].Text, ly.SubItems[col].Text) ;
            }
        }
        #endregion

        #region Gestion de la liaison serveur

        public Ogame.InterfaceServeur serveur ;
        
        private void buttonGereLesComptesOGSpy_Click( object sender, EventArgs e )
        {
            formComptesOGSpy.Show() ;
        }

        private void chargeLesParametresServeurParDefaut()
        {
            textBoxLogin.Text = "Mackila" ;
            textBoxPasse.Text = "" ;
            textBoxURL.Text   = "http://mackila.com/OGSpy/" ;
            checkBoxGardeMDP.Checked = false ;
        }

        private void chargeLesParametresServeur()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                fs = new FileStream( dossierParametres + @"\serveur.param", FileMode.Open ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                textBoxLogin.Text = (String)formatter.Deserialize( fs ) ;
                textBoxPasse.Text = (String)formatter.Deserialize( fs ) ;
                textBoxURL.Text   = (String)formatter.Deserialize( fs ) ;
                checkBoxGardeMDP.Checked = (bool)formatter.Deserialize( fs ) ;
            }
            catch ( Exception )
            {
                chargeLesParametresServeurParDefaut() ;
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        private void sauvegardeLesParametresServeur()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                System.IO.Directory.CreateDirectory( dossierParametres ) ;
                fs = new FileStream( dossierParametres + @"\serveur.param" , FileMode.Create ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                formatter.Serialize( fs, textBoxLogin.Text ) ;
                if ( checkBoxGardeMDP.Checked )
                {
                    formatter.Serialize( fs, textBoxPasse.Text ) ;
                }
                else
                {
                    formatter.Serialize( fs, "" ) ;
                }
                formatter.Serialize( fs, textBoxURL.Text ) ;
                formatter.Serialize( fs, checkBoxGardeMDP.Checked ) ;
            }
            catch ( Exception )
            {
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        private void initialiseLiaisonServeur()
        {
            serveur = new InterfaceServeur() ;
            serveur.onConnect += new InterfaceServeur.InterfaceServeurEvent( this.serveurConnected ) ;
            chargeLesParametresServeur() ;
            // Initialisation de la checkedListBoxSelectionGalaxies
            checkedListBoxSelectionGalaxies.Items.Clear() ;
            for ( int i = 1 ; i <= Ogame.Valeurs.maxGalaxie ; ++i )
            {
                checkedListBoxSelectionGalaxies.Items.Add(
                    Convert.ToString(i)
                ) ;
            }
            if ( Ogame.Valeurs.maxGalaxie <= 9 )
            {
                checkedListBoxSelectionGalaxies.HorizontalScrollbar = false ;
            }
            /*textBoxLogin.Text = "Test" ;
            textBoxPasse.Text = "demonstration" ;
            textBoxURL.Text   = "http://ogspy.ogsteam.fr/" ;*/
            
        }

        public bool galaxieEstSelectionnee( int galaxie )
        {
            return checkedListBoxSelectionGalaxies.CheckedIndices.Contains( galaxie-1 ) ;
        }

        private void serveurConnected( object sender, EventArgs e )
        {
            buttonConnecter.Text = "Déconnecter" ;
            buttonExporter.Enabled = serveur.canExportPlanets ;
            buttonImporter.Enabled = serveur.canImportPlanets ;
            buttonRecupererRapports.Enabled = serveur.canExportReports ;
            buttonEnvoyerRapports.Enabled = serveur.canImportReports ;
            AfficheMessage("Connecté.") ;
        }

        private void buttonConnecter_Click( object sender, EventArgs e )
        {
            if ( ! serveur.EstConnecte )
            {
                sauvegardeLesParametresServeur() ;
                serveur.Login      = textBoxLogin.Text ;
                serveur.MotDePasse = textBoxPasse.Text ;
                serveur.URL        = textBoxURL.Text   ;
                if ( !serveur.Connecte() )
                {
                    AfficheMessage("La connection a échoué. Vérifiez vos identifiants et l'adresse du serveur.") ;
                }
            }
            else
            {
                serveur.Deconnecte() ;
                buttonConnecter.Text = "Connecter" ;
                buttonExporter.Enabled = false ;
                buttonImporter.Enabled = false ;
                buttonRecupererRapports.Enabled = false ;
                buttonEnvoyerRapports.Enabled = false ;
            }
        }

        public int nombreDeGalaxiesSelectionnees()
        {
            int nombreDeGalaxies = 0 ;
            for ( int g = 1 ; g <= Ogame.Valeurs.maxGalaxie ; ++g )
            {
                if ( galaxieEstSelectionnee(g) ) ++nombreDeGalaxies ;
            }
            return nombreDeGalaxies ;
        }

        public int nombreDePlanetesRecuperees = 0 ;

        public InterfaceServeur.ResultatDExportationDePlanetes resultatDExportation ;

        private void buttonExporter_Click(object sender, EventArgs e)
        {
            nombreDePlanetesRecuperees = 0 ;
            new FormProgressionImport(this).ShowDialog(this) ;
            AfficheMessage( "" + nombreDePlanetesRecuperees + " planetes récupérées." ) ;
        }

        private void envoyerLesRapportsAuServeurToolStripMenuItem_Click( object sender, EventArgs e )
        {
            Collection<RapportDEspionnage> rapports = new Collection<RapportDEspionnage>() ;
            foreach( int indice in listViewResultats.SelectedIndices )
            {
                rapports.Add( LesRapports[indice] as RapportDEspionnage ) ;
            }
            InterfaceServeur.ResultatDExportationDeRapports resultat = new InterfaceServeur.ResultatDExportationDeRapports() ;
            resultat += serveur.ExporterLesRapports( rapports ) ;
            if ( resultat.nombreDeRapportsCharges > 0 )
            {
                AfficheMessage( "Merci ! ("+ resultat.nombreDeRapportsCharges+ " rapports chargés sur "+ rapports.Count + " envoyés)" ) ;
            }
            else
            {
                AfficheMessage( "Aucun rapport n'a été récupéré par le serveur ("+resultat.message+")" ) ;
            }
        }

        private void buttonEnvoyerRapports_Click( object sender, EventArgs e )
        {
            MessageBox.Show("Pour envoyer des rapports, sélectionnez les et choisissez 'Envoyer les rapports (OGSpy)' dans le menu contextuel.") ;
        }

        private void buttonImporter_Click(object sender, EventArgs e)
        {
            resultatDExportation = new InterfaceServeur.ResultatDExportationDePlanetes() ;
            new FormProgressionExport(this).ShowDialog(this) ;
            if ( resultatDExportation.message == "" )
            { // réussi
                AfficheMessage( "" + resultatDExportation.planetesSoumises + " planètes soumises avec succès ("+
                    resultatDExportation.planetesAjoutees + " ajoutées, "+
                    resultatDExportation.planetesMiseAJour + " mises à jour, "+
                    resultatDExportation.planetesObsoletes + " obsolètes" +
                    ")." ) ;
            }
            else
            {
                AfficheMessage( resultatDExportation.message ) ;
            }
        }

        public void miseAJourAffichageUnivers()
        {
            listViewSysteme.Refresh() ;
            listViewUnivers.Refresh() ;
        }

        private void buttonRecupererRapports_Click( object sender, EventArgs e )
        {
            Collection<RapportDEspionnage> rapports = null ;
            rapports = serveur.ImporterLesRapportsDepuis( dateTimePickerRecuperationRapports.Value ) ;
            foreach( RapportDEspionnage r in rapports )
            {
                if ( r != null )
                {
                    LesRapports.Add(r) ;
                }
            }
            MetAJourLAffichageDeLaListe() ;
            AfficheMessage( "" + rapports.Count + " rapports récupérés." ) ;
        }


        #endregion

        #region Gestion du menu commentaires

        private void modifierLeCommentaireSurLaSelection( String nouveauCommentaire )
        {
            if ( listViewResultats.SelectedIndices.Count == 0 )
            {
                AfficheMessage("Aucun rapport sélectionné.") ;
            }
            if ( listViewResultats.SelectedIndices.Count == 1 )
            {
                if ( listViewResultatsSelection != -1 )
                {
                    (_LesRapports[listViewResultatsSelection] as RapportDEspionnage).Commentaire = nouveauCommentaire ;
                    listViewResultats.Refresh() ;
                }
            }
            else if ( listViewResultats.SelectedIndices.Count > 1 )
            {
                foreach( int i in listViewResultats.SelectedIndices )
                {
                    RapportDEspionnage r = (RapportDEspionnage)LesRapports[i] ;
                    r.Commentaire = nouveauCommentaire ;
                }
                listViewResultats.Refresh() ;
            }
        }

        private void toolStripTextBoxCommentaire_TextChanged( object sender, EventArgs e )
        {
        }

        private void toolStripMenuItemValideCommentaires_Click( object sender, EventArgs e )
        {
            modifierLeCommentaireSurLaSelection( toolStripTextBoxCommentaire.Text ) ;
        }

        private void toolStripMenuItemCommentaires_DropDownOpened( object sender, EventArgs e )
        {
            if ( listViewResultatsSelection != -1 )
            {
                toolStripTextBoxCommentaire.Text = (_LesRapports[listViewResultatsSelection] as RapportDEspionnage).Commentaire ;
            }
        }

        private void toolStripMenuItemCommentairePredefiniPasRentable_Click( object sender, EventArgs e )
        {
            modifierLeCommentaireSurLaSelection( "Pas rentable" ) ;
        }

        private void toolStripMenuItemCommentairePredefiniCoffre_Click( object sender, EventArgs e )
        {
            modifierLeCommentaireSurLaSelection( "Coffre fort" ) ;
        }

        private void toolStripMenuItemCommentairePredefiniTropPetit_Click( object sender, EventArgs e )
        {
            modifierLeCommentaireSurLaSelection( "Trop petit" ) ;
        }

        private void toolStripMenuItemCommentairePredefiniFlotteAQuai_Click( object sender, EventArgs e )
        {
            modifierLeCommentaireSurLaSelection( "Flotte à quai" ) ;
        }

        private void toolStripMenuItemCommentairePredefiniPille_Click( object sender, EventArgs e )
        {
            modifierLeCommentaireSurLaSelection( "Pillé" ) ;
        }

        private void copierLeRapportNormalToolStripMenuItem_Click( object sender, EventArgs e )
        {
            if ( listViewResultatsSelection != -1 )
            {
                RapportDEspionnage r = (RapportDEspionnage)LesRapports[listViewResultatsSelection] ;
                AnalysePressePapier = false ;
                System.Windows.Forms.Clipboard.SetText( r.Texte ) ;
                AnalysePressePapier = true ;
                AfficheMessage("Rapport "+r.Coordonnees+" copié dans le presse papier.") ;
            }
        }

        #endregion

        #region gestion du navigateur

        private void initialiseLeNavigateur()
        {
            textBoxBarreDAdresse.Text = "home" ;
            afficherLaPageDeDemarrage() ;
            buttonPrecedant.Enabled = webBrowser.CanGoBack ;
            buttonSuivant.Enabled = webBrowser.CanGoForward ;
        }

        private void afficherLaPageDeDemarrage()
        {
            //webBrowser.Navigate( "http://ogame.insomniacs.free.fr/" ) ;
            webBrowser.DocumentText = OgameFarmingInterface.Properties.Resources.PageHome ;
        }

        private void afficherLaPageDArret()
        {
        }

        private void tabPageNavigateur_Click( object sender, EventArgs e )
        {
            
        }

        private void buttonHome_Click( object sender, EventArgs e )
        {
            textBoxBarreDAdresse.Text = "home" ;
            afficherLaPageDeDemarrage() ;
        }

        private void buttonPrecedant_Click( object sender, EventArgs e )
        {
            webBrowser.GoBack() ;
        }

        private void buttonSuivant_Click( object sender, EventArgs e )
        {
            webBrowser.GoForward() ;
        }

        private void buttonArreter_Click( object sender, EventArgs e )
        {
            webBrowser.Stop() ;
            afficherLaPageDArret() ;
        }

        private void buttonActualiser_Click( object sender, EventArgs e )
        {
            webBrowser.Refresh() ;
        }

        private void textBoxBarreDAdresse_KeyDown( object sender, KeyEventArgs e )
        {
            buttonGO_Click(null, null) ;
        }

        private void buttonGO_Click( object sender, EventArgs e )
        {
            if ( textBoxBarreDAdresse.Text == "home" )
            {
                afficherLaPageDeDemarrage() ;
            }
            else
            {
                webBrowser.Navigate( textBoxBarreDAdresse.Text ) ;
            }
        }

        private void webBrowser_Navigated( object sender, WebBrowserNavigatedEventArgs e )
        {
            if ( webBrowser.Url.OriginalString != "about:blank" )
            {
                if ( webBrowser.Url.OriginalString == "http://ogame.insomniacs.free.fr/" )
                {
                    textBoxBarreDAdresse.Text = "home" ;
                }
                else
                {
                    textBoxBarreDAdresse.Text = webBrowser.Url.OriginalString ;
                }
            }
            buttonPrecedant.Enabled = webBrowser.CanGoBack ;
            buttonSuivant.Enabled = webBrowser.CanGoForward ;
        }

        #endregion

        #region gestion de la mise à jour automatique

#if UNIVER_50
        private String URL_installeur = "http://mathieu.manson.free.fr/InstallOgameFarmingInterfaceU50.exe" ;
        private String URL_version = "http://mathieu.manson.free.fr/OFI.txt" ;
#else
        private String URL_installeur = "http://mathieu.manson.free.fr/InstallOgameFarmingInterface.exe" ;
        private String URL_version = "http://mathieu.manson.free.fr/OFI.txt" ;
#endif
        // private int version_courante ; // définie en haut du fichier

        bool mettreAJourAutomatiquement = false ;

        private void sauvegardeMiseAJour()
        {
            FileStream fs = null;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                System.IO.Directory.CreateDirectory( dossierParametres ) ;
                fs = new FileStream( dossierParametres + @"\mise_a_jour.param" , FileMode.Create ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                formatter.Serialize( fs, mettreAJourAutomatiquement ) ;
            }
            catch ( Exception ex )
            {
                throw new Exception( "Impossible d'enregistrer le fichier : " + ex.Message ) ;
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }

        private void initialiseLaMiseAJour()
        {
            uneMiseAJourEstDisponible = false ;
            versionServeur = 0 ;
            buttonLancerMiseAJour.Enabled = false ;
            #region chargement des parametres (si le fichier existe)
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                System.IO.Directory.CreateDirectory( dossierParametres ) ;
                fs = new FileStream( dossierParametres + @"\mise_a_jour.param" , FileMode.Open ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                mettreAJourAutomatiquement = (Boolean)formatter.Deserialize( fs );
            }
            catch ( Exception )
            {
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
            #endregion
            checkBoxMiseAJourAutomatique.Checked = mettreAJourAutomatiquement ;
            if ( mettreAJourAutomatiquement ) 
            {
                buttonVerifierPresenceMiseAJour.Enabled = false ;
                backgroundWorkerTesterMiseAJour.RunWorkerAsync() ;
            }
        }

        private void checkBoxMiseAJourAutomatique_CheckedChanged( object sender, EventArgs e )
        {
            mettreAJourAutomatiquement = checkBoxMiseAJourAutomatique.Checked ;
        }

        private void buttonVerifierPresenceMiseAJour_Click( object sender, EventArgs e )
        {
            if ( ! backgroundWorkerTesterMiseAJour.IsBusy )
            {
                buttonVerifierPresenceMiseAJour.Enabled = false ;
                backgroundWorkerTesterMiseAJour.RunWorkerAsync() ;
            }
        }

        private void buttonLancerMiseAJour_Click( object sender, EventArgs e )
        {
            try
            {
                ProcessStartInfo startInfo = new ProcessStartInfo() ;
                startInfo.WorkingDirectory = Path.GetDirectoryName(System.Reflection.Assembly.GetExecutingAssembly().Location) ;
                startInfo.FileName = startInfo.WorkingDirectory + @"\Updater.exe" ;
                startInfo.Arguments = "\"" + URL_version + "\" \"" + version_courante + "\" \"" + URL_installeur + "\"" ; 
                Process.Start( startInfo ) ;
                Close() ;
            }
            catch( Exception ex )
            {
                AfficheMessage( ex.Message ) ;
            }
        }

        private bool uneMiseAJourEstDisponible ;
        private int versionServeur ;

        private void backgroundWorkerTesterMiseAJour_DoWork( object sender, DoWorkEventArgs e )
        {
            try
            {
                System.Net.WebClient webClient = new System.Net.WebClient() ;
                int version_serveur = Convert.ToInt32(webClient.DownloadString(URL_version)) ;
                if ( version_serveur <= version_courante )
                {
                    uneMiseAJourEstDisponible = false ;
                }
                else
                {
                    uneMiseAJourEstDisponible = true ;
                }
                versionServeur = version_serveur ;
            }
            catch( Exception )
            {
                uneMiseAJourEstDisponible = false ;
            }

        }

        private void backgroundWorkerTesterMiseAJour_RunWorkerCompleted( object sender, RunWorkerCompletedEventArgs e )
        {
            buttonVerifierPresenceMiseAJour.Enabled = true ;
            if ( uneMiseAJourEstDisponible )
            {
                MessageBox.Show( this, "Une nouvelle version est disponible.\r\n\r\n"+
                    "Vous pouvez la télécharger et l'installer depuis l'onglet \"Paramètres\".",
                    "Mise à jour !", MessageBoxButtons.OK, MessageBoxIcon.Information ) ;
                AfficheMessage( "Votre version n'est pas à jour. (serveur=" + versionServeur + ", installée=" + version_courante + ")" ) ;
                buttonLancerMiseAJour.Enabled = true ;
            }
            else
            {
                AfficheMessage( "Votre version est à jour. (serveur=" + versionServeur + ", installée=" + version_courante + ")" ) ;
                buttonLancerMiseAJour.Enabled = false ;
            }
        }

        #endregion

    }
}
