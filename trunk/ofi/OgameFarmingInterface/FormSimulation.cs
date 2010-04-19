using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using Ogame ;
using System.Collections.ObjectModel;
using System.Text.RegularExpressions;
using System.IO ;

namespace OgameFarmingInterface
{
    public partial class FormSimulation : Form
    {
        private void chargePositionEtTaille()
        {
            FileStream fs = null ;
            try
            {
                String dossierParametres = Environment.GetFolderPath( Environment.SpecialFolder.ApplicationData ) ;
                dossierParametres += @"\Mackila\OgameFarmingInterface" ;
                fs = new FileStream( dossierParametres + @"\positionSimu.param", FileMode.Open ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                this.Size = (Size)formatter.Deserialize( fs ) ;
            }
            catch ( Exception )
            {
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
                fs = new FileStream( dossierParametres + @"\positionSimu.param" , FileMode.Create ) ;
                System.Runtime.Serialization.Formatters.Binary.BinaryFormatter formatter = new System.Runtime.Serialization.Formatters.Binary.BinaryFormatter();
                formatter.Serialize( fs, this.Size ) ;
            }
            catch ( Exception )
            {
            }
            finally
            {
                if ( fs != null ) fs.Close();
            }
        }
        
        public RapportDEspionnage _Defenseur ;
        public RapportDEspionnage Defenseur
        {
            get { return _Defenseur ; }
            set
            {
                _Defenseur = new RapportDEspionnage(value) ;
                bindingDefensesDefenseur.Clear() ;
                bindingDefensesDefenseur.Insert(0, _Defenseur.Defenses) ;
                bindingFlotteDefenseur.Clear() ;
                bindingFlotteDefenseur.Insert(0, _Defenseur.FlotteAQuai) ;
                bindingRecherchesDefenseur.Clear() ;
                bindingRecherchesDefenseur.Insert(0, _Defenseur.Recherches) ;
                bindingRessourcesDefenseur.Clear() ;
                bindingRessourcesDefenseur.Insert(0, _Defenseur.Ressources) ;
                MiseAJourAffichageDefenseur() ;
            }
        }
        public RapportDEspionnage _Attaquant ;
        public RapportDEspionnage Attaquant
        {
            get { return _Attaquant ; }
            set
            {
                _Attaquant = new RapportDEspionnage(value) ;
                bindingFlotteAttaquant.Clear() ;
                bindingFlotteAttaquant.Insert(0, Attaquant.FlotteAQuai) ;
                bindingRecherchesAttaquant.Clear() ;
                bindingRecherchesAttaquant.Insert(0,  Attaquant.Recherches) ;
                MiseAJourAffichageCoordonneesAttaquant() ;
            }
        }
        public Flotte FlotteAttaquant
        {
            get { return Attaquant.FlotteAQuai ; }
            set
            {
                Attaquant.FlotteAQuai = new Flotte(value) ;
                bindingFlotteAttaquant.Clear() ;
                bindingFlotteAttaquant.Insert(0, Attaquant.FlotteAQuai) ;
                comboBoxVitesse_MiseAJour() ;
            }
        }
        private void comboBoxVitesse_MiseAJour()
        {
            comboBoxVitesse.SelectedIndex = 10 - (Attaquant.FlotteAQuai.RatioVitesseFlotte / 10) ;
        }
        private void comboBoxVitesse_TextChanged(object sender, EventArgs e)
        {
            Attaquant.FlotteAQuai.RatioVitesseFlotte = 100 - (10 * comboBoxVitesse.SelectedIndex ) ;
        }

        public Technologie TechnologieAttaquant
        {
            get { return Attaquant.Recherches ; }
            set
            {
                Attaquant.Recherches = new Technologie(value) ;
                bindingRecherchesAttaquant.Clear() ;
                bindingRecherchesAttaquant.Insert(0,  Attaquant.Recherches) ;
            }
        }
        public Coordonnees CoordonneesAttaquant
        {
            get { return Attaquant.Coordonnees ; }
            set
            {
                Attaquant.Coordonnees = new Coordonnees(value) ;
                MiseAJourAffichageCoordonneesAttaquant() ;
            }
        }

        private Collection<TextBox> TextBoxesFlotteAttaquant ;
        private Collection<TextBox> TextBoxesFlotteDefenseur ;
        private Collection<TextBox> TextBoxesDefenses ;
        private Collection<TextBox> TextBoxesResultats ;
        private Collection<TextBox> TextBoxesTechnologieAttaquant ;

        public FormSimulation()
        {
            InitializeComponent() ;
            chargePositionEtTaille() ;

            // Affectation Tag Défenses
            tbDefMissileDefenseur   .Tag = tbPertesDefMissileDefenseur    ;
            tbDefLaserLegDefenseur  .Tag = tbPertesDefLaserLegDefenseur   ;
            tbDefLaserLourdDefenseur.Tag = tbPertesDefLaserLourdDefenseur ;
            tbDefGaussDefenseur     .Tag = tbPertesDefGaussDefenseur      ;
            tbDefIonsDefenseur      .Tag = tbPertesDefIonsDefenseur       ;
            tbDefPlasmaDefenseur    .Tag = tbPertesDefPlasmaDefenseur     ;
            tbDefPBDefenseur        .Tag = tbPertesDefPBDefenseur         ;
            tbDefGBDefenseur        .Tag = tbPertesDefGBDefenseur         ;
            // Affectation Tag flotte en défense
            tbPTDefenseur.Tag    = tbPertesPTDefenseur    ;
            tbGTDefenseur.Tag    = tbPertesGTDefenseur    ;
            tbCleDefenseur.Tag   = tbPertesCleDefenseur   ;
            tbCLDefenseur.Tag    = tbPertesCLDefenseur    ;
            tbCRDefenseur.Tag    = tbPertesCRDefenseur    ;
            tbVBDefenseur.Tag    = tbPertesVBDefenseur    ;
            tbVCDefenseur.Tag    = tbPertesVCDefenseur    ;
            tbRCDefenseur.Tag    = tbPertesRCDefenseur    ;
            tbSondeDefenseur.Tag = tbPertesSondeDefenseur ;
            tbSatDefenseur.Tag   = tbPertesSatDefenseur   ;
            tbBDefenseur.Tag     = tbPertesBDefenseur     ;
            tbDDefenseur.Tag     = tbPertesDDefenseur     ;
            tbBattleDefenseur.Tag= tbPertesBattleDefenseur;
            tbEDLMDefenseur.Tag  = tbPertesEDLMDefenseur  ;
            // Affectation Tag flotte en attaque
            tbPTAttaquant.Tag    = tbPertesPTAttaquant    ;
            tbGTAttaquant.Tag    = tbPertesGTAttaquant    ;
            tbCleAttaquant.Tag   = tbPertesCleAttaquant   ;
            tbCLAttaquant.Tag    = tbPertesCLAttaquant    ;
            tbCRAttaquant.Tag    = tbPertesCRAttaquant    ;
            tbVBAttaquant.Tag    = tbPertesVBAttaquant    ;
            tbVCAttaquant.Tag    = tbPertesVCAttaquant    ;
            tbRCAttaquant.Tag    = tbPertesRCAttaquant    ;
            tbSondeAttaquant.Tag = tbPertesSondeAttaquant ;
            tbBAttaquant.Tag     = tbPertesBAttaquant     ;
            tbDAttaquant.Tag     = tbPertesDAttaquant     ;
            tbBattleAttaquant.Tag= tbPertesBattleAttaquant;
            tbEDLMAttaquant.Tag  = tbPertesEDLMAttaquant  ;

            // Intialisation collection Flotte Attaquante
            TextBoxesFlotteAttaquant = new Collection<TextBox>() ;
            TextBoxesFlotteAttaquant.Add(tbPTAttaquant   ) ;
            TextBoxesFlotteAttaquant.Add(tbGTAttaquant   ) ;
            TextBoxesFlotteAttaquant.Add(tbCleAttaquant  ) ;
            TextBoxesFlotteAttaquant.Add(tbCLAttaquant   ) ;
            TextBoxesFlotteAttaquant.Add(tbCRAttaquant   ) ;
            TextBoxesFlotteAttaquant.Add(tbVBAttaquant   ) ;
            TextBoxesFlotteAttaquant.Add(tbVCAttaquant   ) ;
            TextBoxesFlotteAttaquant.Add(tbRCAttaquant   ) ;
            TextBoxesFlotteAttaquant.Add(tbSondeAttaquant) ;
            TextBoxesFlotteAttaquant.Add(tbBAttaquant    ) ;
            TextBoxesFlotteAttaquant.Add(tbDAttaquant    ) ;
            TextBoxesFlotteAttaquant.Add(tbBattleAttaquant) ;
            TextBoxesFlotteAttaquant.Add(tbEDLMAttaquant ) ;
            // Initialisation collection Flotte Défenseur
            TextBoxesFlotteDefenseur = new Collection<TextBox>() ;
            TextBoxesFlotteDefenseur.Add(tbPTDefenseur   ) ;
            TextBoxesFlotteDefenseur.Add(tbGTDefenseur   ) ;
            TextBoxesFlotteDefenseur.Add(tbCleDefenseur  ) ;
            TextBoxesFlotteDefenseur.Add(tbCLDefenseur   ) ;
            TextBoxesFlotteDefenseur.Add(tbCRDefenseur   ) ;
            TextBoxesFlotteDefenseur.Add(tbVBDefenseur   ) ;
            TextBoxesFlotteDefenseur.Add(tbVCDefenseur   ) ;
            TextBoxesFlotteDefenseur.Add(tbRCDefenseur   ) ;
            TextBoxesFlotteDefenseur.Add(tbSondeDefenseur) ;
            TextBoxesFlotteDefenseur.Add(tbSatDefenseur  ) ;
            TextBoxesFlotteDefenseur.Add(tbBDefenseur    ) ;
            TextBoxesFlotteDefenseur.Add(tbDDefenseur    ) ;
            TextBoxesFlotteDefenseur.Add(tbBattleDefenseur) ;
            TextBoxesFlotteDefenseur.Add(tbEDLMDefenseur ) ;
            // Initialisation collection Défense
            TextBoxesDefenses = new Collection<TextBox>() ;
            TextBoxesDefenses.Add(tbDefMissileDefenseur   ) ;
            TextBoxesDefenses.Add(tbDefLaserLegDefenseur  ) ;
            TextBoxesDefenses.Add(tbDefLaserLourdDefenseur) ;
            TextBoxesDefenses.Add(tbDefGaussDefenseur     ) ;
            TextBoxesDefenses.Add(tbDefIonsDefenseur      ) ;
            TextBoxesDefenses.Add(tbDefPlasmaDefenseur    ) ;
            TextBoxesDefenses.Add(tbDefPBDefenseur        ) ;
            TextBoxesDefenses.Add(tbDefGBDefenseur        ) ;
            // Initialisation collection Résultats
            TextBoxesResultats = new Collection<TextBox>() ;
            TextBoxesResultats.Add(tbPertesDefMissileDefenseur   ) ;
            TextBoxesResultats.Add(tbPertesDefLaserLegDefenseur  ) ;
            TextBoxesResultats.Add(tbPertesDefLaserLourdDefenseur) ;
            TextBoxesResultats.Add(tbPertesDefIonsDefenseur      ) ;
            TextBoxesResultats.Add(tbPertesDefGaussDefenseur     ) ;
            TextBoxesResultats.Add(tbPertesDefPlasmaDefenseur    ) ;
            TextBoxesResultats.Add(tbPertesDefPBDefenseur        ) ;
            TextBoxesResultats.Add(tbPertesDefGBDefenseur        ) ;
            TextBoxesResultats.Add(tbPertesPTDefenseur   ) ;
            TextBoxesResultats.Add(tbPertesGTDefenseur   ) ;
            TextBoxesResultats.Add(tbPertesCleDefenseur  ) ;
            TextBoxesResultats.Add(tbPertesCLDefenseur   ) ;
            TextBoxesResultats.Add(tbPertesCRDefenseur   ) ;
            TextBoxesResultats.Add(tbPertesVBDefenseur   ) ;
            TextBoxesResultats.Add(tbPertesVCDefenseur   ) ;
            TextBoxesResultats.Add(tbPertesRCDefenseur   ) ;
            TextBoxesResultats.Add(tbPertesSondeDefenseur) ;
            TextBoxesResultats.Add(tbPertesSatDefenseur  ) ;
            TextBoxesResultats.Add(tbPertesBDefenseur    ) ;
            TextBoxesResultats.Add(tbPertesDDefenseur    ) ;
            TextBoxesResultats.Add(tbPertesEDLMDefenseur ) ;
            TextBoxesResultats.Add(tbPertesPTAttaquant   ) ;
            TextBoxesResultats.Add(tbPertesGTAttaquant   ) ;
            TextBoxesResultats.Add(tbPertesCleAttaquant  ) ;
            TextBoxesResultats.Add(tbPertesCLAttaquant   ) ;
            TextBoxesResultats.Add(tbPertesCRAttaquant   ) ;
            TextBoxesResultats.Add(tbPertesVBAttaquant   ) ;
            TextBoxesResultats.Add(tbPertesVCAttaquant   ) ;
            TextBoxesResultats.Add(tbPertesRCAttaquant   ) ;
            TextBoxesResultats.Add(tbPertesSondeAttaquant) ;
            TextBoxesResultats.Add(tbPertesBAttaquant    ) ;
            TextBoxesResultats.Add(tbPertesDAttaquant    ) ;
            TextBoxesResultats.Add(tbPertesEDLMAttaquant ) ;
            // Initialisation collection Technos attaquant
            TextBoxesTechnologieAttaquant = new Collection<TextBox>() ;
            TextBoxesTechnologieAttaquant.Add(tbArmesAttaquant      ) ;
            TextBoxesTechnologieAttaquant.Add(tbBouclierAttaquant   ) ;
            TextBoxesTechnologieAttaquant.Add(tbProtectionAttaquant ) ;
            TextBoxesTechnologieAttaquant.Add(tbCombustionAttaquant ) ;
            TextBoxesTechnologieAttaquant.Add(tbImpulsionAttaquant  ) ;
            TextBoxesTechnologieAttaquant.Add(tbHyperespaceAttaquant) ;

            Defenseur = new RapportDEspionnage() ;
            Attaquant = new RapportDEspionnage() ;
            FlotteAttaquant = new Flotte(true) ;
            TechnologieAttaquant = new Technologie() ;
            CoordonneesAttaquant = new Coordonnees() ;

            // Bindings
            bindingDefensesDefenseur.Insert(0, Defenseur.Defenses) ;
            bindingFlotteAttaquant.Insert(0, FlotteAttaquant) ;
            bindingFlotteDefenseur.Insert(0, Defenseur.FlotteAQuai) ;
            bindingRecherchesAttaquant.Insert(0, TechnologieAttaquant) ;
            bindingRecherchesDefenseur.Insert(0, Defenseur.Recherches) ;
            
            comboBoxVitesse_MiseAJour() ;

            InitialiseResultats() ;
        }

        private void buttonLancerLaSimulation_Click(object sender, EventArgs e)
        {
            // Controls
            InhibeTousLesControlsPourUneSimulation() ;

            // Data
            initialieLesMinEtMax() ;

            // Lancement
            #if true
            backgroundWorkerSimulation.RunWorkerAsync((object)textBoxOptionSimuNombreIterations.Text) ;
            #else
            backgroundWorkerSimulation_DoWork(null, (object)textBoxOptionSimuNombreIterations.Text) ;
            backgroundWorkerSimulation_RunWorkerCompleted(null, new RunWorkerCompletedEventArgs(null, null, false) ) ;
            #endif
        }

        #region Gestion de l'affichage

        private void InitialiseResultats()
        {
            foreach( TextBox tb in TextBoxesResultats )
            {
                tb.Text = "" ;
                tb.BackColor = System.Drawing.SystemColors.Control ;
            }
        }

        private void MiseAJourAffichageCoordonneesAttaquant()
        {
            tbCoordonneesAttaquant.Text = CoordonneesAttaquant ;
        }

        private void MiseAJourAffichageDefenseur()
        {
            tbCoordonneesDefenseur.Text = Defenseur.Coordonnees ;
            /*foreach( TextBox tb in TextBoxesFlotteDefenseur )
            {
                tbEntierAvecBinding_Leave(tb, null) ;
            }
            foreach( TextBox tb in TextBoxesDefenses )
            {
                tbEntierAvecBinding_Leave(tb, null) ;
            }
            tbEntierAvecBinding_Leave(tbArmesDefenseur, null) ;
            tbEntierAvecBinding_Leave(tbBouclierDefenseur, null) ;
            tbEntierAvecBinding_Leave(tbProtectionDefenseur, null) ;*/
        }

        private void tbCoordonneesAttaquant_Validated(object sender, EventArgs e)
        {
            CoordonneesAttaquant = new Coordonnees(tbCoordonneesAttaquant.Text) ;
            FlotteAttaquant.CoordonneesDeDepart = CoordonneesAttaquant ;
        }

        private void tbCoordonneesDefenseur_Validated(object sender, EventArgs e)
        {
            Defenseur.Coordonnees = new Coordonnees(tbCoordonneesDefenseur.Text) ;
        }
    

        // Renvoie false si le contenu n'est pas valide
        private bool valideTexteEntier( TextBox tb )
        {
            String s = " " ;
            s += tb.Text ;
            s = s.Replace(" ", "") ; // Ceci est un espace.
            s = s.Replace(" ", "") ; // /!\ Attention ceci n'est PAS un espace !!!!
            if ( s == "" )
            {
                tb.ForeColor = System.Drawing.SystemColors.WindowText ;
                return false ;
            }
            try
            {
                System.Convert.ToUInt32( s ) ;
                tb.ForeColor = System.Drawing.SystemColors.WindowText ;
                return true ;
            }
            catch ( Exception )
            {
                tb.ForeColor = Color.Red ;
                return false ;
            }
        }

        private void textBoxTechno_TextChanged(object sender, EventArgs e)
        {
            TextBox tbSource = (sender as TextBox) ;
            if ( tbSource == null ) return ;
            
            valideTexteEntier( tbSource ) ;
            tbEntierAvecBinding_Leave(tbSource, null) ;
        }

        private void textBoxSource_TextChanged(object sender, EventArgs e)
        {
            TextBox tbSource = (sender as TextBox) ;
            if ( tbSource == null ) return ;
            
            if ( ! valideTexteEntier( tbSource ) ) return ;
            
            TextBox tbResultat = (tbSource.Tag as TextBox) ;
            if ( tbResultat == null ) return ;
            
            uint valeur = 0 ;
            try
            {
                string s = "" ;
                s += tbSource.Text ;
                s = s.Replace(" ", "") ; // Ceci est un espace.
                s = s.Replace(" ", "") ; // /!\ Attention ceci n'est PAS un espace !!!!
                valeur = System.Convert.ToUInt32( s ) ;
            }
            catch ( Exception )
            {
            }
            tbResultat.Tag = valeur ;

            tbEntierAvecBinding_Leave(tbSource, null) ;
        }

        // Renvoie false si le contenu n'est pas valide
        private bool valideTexteResultat( TextBox tb )
        {
            return true ;
        }

        private void textBoxResultat_TextChanged_Attaquant(object sender, EventArgs e)
        {
            TextBox tbResultat = (sender as TextBox) ;
            if ( tbResultat == null ) return ;

            if ( ! valideTexteResultat( tbResultat ) ) return ;

            uint valeurSource ;
            valeurSource = 0 ;
            try
            {
                valeurSource = (uint)tbResultat.Tag ;
            }
            catch ( Exception )
            {
                return ;
            }
            double valeur = 0.0 ;
            try
            {
                valeur = System.Convert.ToDouble( tbResultat.Text.Replace(" ", "") ) ;
            }
            catch ( Exception )
            {
            }
            double rapport ;
            if ( valeurSource != 0 )
            {
                rapport = valeur/valeurSource ;
            }
            else
            {
                tbResultat.BackColor = System.Drawing.SystemColors.Control ;
                tbResultat.ForeColor = System.Drawing.SystemColors.Control ;
                return ;
            }
            tbResultat.ForeColor = System.Drawing.SystemColors.WindowText ;

            Color CouleurRienPerdu     = new Color() ;
            Color CouleurPerduEnPartie = new Color() ;
            Color CouleurToutPerdu     = new Color() ;
            double rapportPertesPartie = 0.80 ;
            CouleurRienPerdu     = Color.FromArgb(   0, 255,   0 ) ;
            CouleurPerduEnPartie = Color.FromArgb( 255, 255,   0 ) ;
            CouleurToutPerdu     = Color.FromArgb( 255,   0,   0 ) ;
            tbResultat.BackColor = Utils.calculeLaCouleur(rapport, rapportPertesPartie, CouleurRienPerdu, CouleurPerduEnPartie, CouleurToutPerdu) ;
        }

        private void textBoxResultat_TextChanged_Defenseur(object sender, EventArgs e)
        {
            TextBox tbResultat = (sender as TextBox) ;
            if ( tbResultat == null ) return ;

            if ( ! valideTexteResultat( tbResultat ) ) return ;

            uint valeurSource ;
            valeurSource = 0 ;
            try
            {
                valeurSource = (uint)tbResultat.Tag ;
            }
            catch ( Exception )
            {
                return ;
            }
            double valeur = 0.0 ;
            try
            {
                valeur = System.Convert.ToDouble( tbResultat.Text.Replace(" ", "") ) ;
            }
            catch ( Exception )
            {
            }
            double rapport ;
            if ( valeurSource != 0 )
            {
                rapport = valeur/valeurSource ;
            }
            else
            {
                tbResultat.BackColor = System.Drawing.SystemColors.Control ;
                tbResultat.ForeColor = System.Drawing.SystemColors.Control ;
                return ;
            }
            tbResultat.ForeColor = System.Drawing.SystemColors.WindowText ;

            Color CouleurRienPerdu     = new Color() ;
            Color CouleurPerduEnPartie = new Color() ;
            Color CouleurToutPerdu     = new Color() ;
            double rapportPertesPartie = 0.20 ;
            CouleurRienPerdu     = Color.FromArgb( 255,   0,   0 ) ;
            CouleurPerduEnPartie = Color.FromArgb( 255, 255,   0 ) ;
            CouleurToutPerdu     = Color.FromArgb(   0, 255,   0 ) ;
            tbResultat.BackColor = Utils.calculeLaCouleur(rapport, rapportPertesPartie, CouleurRienPerdu, CouleurPerduEnPartie, CouleurToutPerdu) ;
        }

        private string affEntier( uint entier )
        {
            return String.Format("{0:#' '###' '###' '##0}", entier).Trim() ;
        }

        private string affEntier( long entier )
        {
            return String.Format("{0:#' '###' '###' '##0}", entier).Trim() ;
        }

        private string affLong( long entier )
        {
            return String.Format("{0:#' '###' '###' '##0}", entier).Trim() ;
        }

        private string affStat( uint stat, int it )
        {
            return String.Format("{0:#' '###' '###' '##0.00}", (double)stat / it ).Trim() ;
        }

        private string affStat( double stat )
        {
            return String.Format("{0:#' '###' '###' '##0.00}", stat ).Trim() ;
        }

        private string affPourcent( uint stat, int it )
        {
            return String.Format("{0:0.00}", (double)stat / it ).Trim() ;
        }

        private bool valideTexteCoordonnees( TextBox tb )
        {
            try
            {
                Coordonnees c = new Coordonnees(tb.Text) ;
                tb.ForeColor = System.Drawing.SystemColors.WindowText ;
                return true ;
            }
            catch ( Exception )
            {
                tb.ForeColor = Color.Red ;
                return false ;
            }
        }

        private void tbCoordonnees_Validating( object sender, CancelEventArgs e )
        {
            TextBox tbCoor = (sender as TextBox) ;
            if ( tbCoor == null ) return ;

            if ( !valideTexteCoordonnees( tbCoor ) )
            {
                tbCoor.Text = "1:1:1" ;
            }
        }

        private void tbCoordonneesDefenseur_TextChanged(object sender, EventArgs e)
        {
            TextBox tbCoor = (sender as TextBox) ;
            if ( tbCoor == null ) return ;

            valideTexteCoordonnees( tbCoor ) ;
        }

        private void tbCoordonneesAttaquant_TextChanged(object sender, EventArgs e)
        {
            TextBox tbCoor = (sender as TextBox) ;
            if ( tbCoor == null ) return ;

            valideTexteCoordonnees( tbCoor ) ;
        }

        private void tbEntierAvecBinding_Validating( object sender, CancelEventArgs e )
        {
            TextBox tb = (sender as TextBox) ;
            if ( tb == null ) return ;

            if ( !valideTexteEntier( tb ) )
            {
                tb.Text = "0" ;
            }
        }

        private void tbEntierAvecBinding_Enter( object sender, EventArgs e )
        {
            TextBox tb = (sender as TextBox) ;
            if ( tb == null ) return ;

            if ( tb.Text == "0" )
            {
                tb.Text = "" ;
            }
            tb.ForeColor = System.Drawing.SystemColors.WindowText ;
        }

        private void tbEntierAvecBinding_Leave( object sender, EventArgs e )
        {
            TextBox tb = (sender as TextBox) ;
            if ( tb == null ) return ;

            if ( tb.Text == "0" || tb.Text == "" )
            {
                tb.ForeColor = System.Drawing.SystemColors.Control ;
            }
            else
            {
                tb.ForeColor = System.Drawing.SystemColors.WindowText ;
            }
        }

        #endregion

        #region Variables de simulation

        StatistiquesDeSimulation Stats ;

        RapportDEspionnage defenseur ;
        RapportDEspionnage attaquant ;

        RapportDEspionnage StatsDefenseur ;
        RapportDEspionnage StatsAttaquant ;
        
        RapportDEspionnage MaxDefenseur ;
        RapportDEspionnage MaxAttaquant ;
        RapportDEspionnage MinDefenseur ;
        RapportDEspionnage MinAttaquant ;
        
        int boucle ;

        #endregion 

        #region Gestion du thread de travail

        Exception exception = null ;

        private void backgroundWorkerSimulation_DoWork(object sender, DoWorkEventArgs e)
        {
            try
            {
                Stats = new StatistiquesDeSimulation() ;
                defenseur = this.Defenseur ;
                attaquant = new RapportDEspionnage() ;
                attaquant.FlotteAQuai = FlotteAttaquant ;
                attaquant.Recherches = TechnologieAttaquant ;
                attaquant.Coordonnees = CoordonneesAttaquant ;
                try
                {
                    boucle = Convert.ToInt32((string)e.Argument) ;
                }
                catch( Exception )
                {
                    boucle = 100 ;
                }
                StatsDefenseur = new RapportDEspionnage() ;
                StatsAttaquant = new RapportDEspionnage() ;

                for ( int i = boucle ; i > 0 ; --i )
                {
                    if ( backgroundWorkerSimulation.CancellationPending )
                    {
                        return ;
                    }

                    Simulateur simu = new Simulateur( attaquant, defenseur ) ;
                    ResultatDeCombat rc = simu.Simuler() ;
                    Stats.AjouteUnResultat( rc ) ;

                    backgroundWorkerSimulation.ReportProgress( (boucle - i)*100/boucle ) ;

                    // Stats par type d'unité
                    StatsDefenseur.FlotteAQuai += simu.Defenseur.FlotteAQuai ;
                    StatsDefenseur.Defenses    += simu.Defenseur.Defenses    ;
                    StatsAttaquant.FlotteAQuai += simu.Attaquant.FlotteAQuai ;

                    // Calculs des min et max par unité
                    metAJourLesMinEtMax(simu.Attaquant, simu.Defenseur) ;
                }
            }
            catch ( Exception ex )
            {
                exception = ex ;
                //MessageBox.Show(ex.Message + "@" + ex.TargetSite + "\n" + ex.StackTrace, "Erreur pendant la simulation") ;
            }
            finally
            {
            }
        }

        private void backgroundWorkerSimulation_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            textBoxOptionSimuNombreIterations.Text = "" + e.ProgressPercentage + "%" ;
        }

        private void backgroundWorkerSimulation_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            if ( exception != null )
            {
                new FormRapportDErreur(exception).Show() ;
            }
            if ( ! e.Cancelled )
            {
                ActiveTousLesControlsApresUneSimulation() ;
                
                if ( Stats.NombreDeSimulations == 0 )
                {
                    textBoxResultat.Text = "Nombre de simulations = 0 !!!!!!" ;
                    return ;
                }

                // Affichage des résultats

                textBoxResultat.Text = "" ;
                textBoxResultat.Text += "Victoire : " + affStat( Stats.NombreDeCombatsGagnes*100.0/Stats.NombreDeSimulations )
                                    + "   Défaite : " + affStat( Stats.NombreDeCombatsPerdus*100.0/Stats.NombreDeSimulations )
                                        + "   Nul : " + affStat( Stats.NombreDeCombatsNuls*100.0/Stats.NombreDeSimulations )
                                             + "\r\n" ;
                textBoxResultat.Text += "Nombre moyen de tours :\r\n   " + affStat( Stats.NombreDeTours ) + "   (min " + Stats.MeilleurCas.NombreDeTours + ", max " + Stats.PireCas.NombreDeTours + ")" ;

                // Affichage des ruines

                textBoxRuines.Text  = "" ;
                textBoxRuines.Text += "" + affEntier(Stats.Ruines.Metal) + " M   " + affEntier(Stats.Ruines.Cristal) + " C   (" + Stats.Ruines.NombreDeRecycleurs() + ")\r\n" ;
                textBoxRuines.Text += "Probabilité de création de lune : " + Stats.Ruines.ProbabiliteDeCreationDeLune() + "%\r\n" ;
                textBoxRuines.Text += "Maximum :\r\n" ;
                textBoxRuines.Text += "" + affEntier(Stats.MeilleurCas.Ruines.Metal) + " M   " + affEntier(Stats.MeilleurCas.Ruines.Cristal) + " C   (" + Stats.MeilleurCas.Ruines.NombreDeRecycleurs() + ")\r\n" ;
                textBoxRuines.Text += "Minimum :\r\n" ;
                textBoxRuines.Text += "" + affEntier(Stats.PireCas.Ruines.Metal) + " M   " + affEntier(Stats.PireCas.Ruines.Cristal) + " C   (" + Stats.PireCas.Ruines.NombreDeRecycleurs() + ")" ;

                // Consommation et temps de parcours

                textBoxConsommation.Text = "" + affEntier(Stats.Consommation.Deuterium) + " D" ;
                textBoxTempsDeTrajet.Text = Utils.affTemps( Stats.TempsDeTrajet ) ;

                // Affichage des résultats par vaisseaux

                buttonSelectionCasMoyen_Click(null, null) ;

                buttonVagueSuivante.Visible = true ;
            }
            else
            {
                Close() ;
            }
        }

        #endregion

        #region Gestion des controls pendant la simulation

        private void InhibeTousLesControlsPourUneSimulation()
        {
            // Controls
            buttonLancerLaSimulation.Enabled = false ;

            foreach( TextBox tb in TextBoxesFlotteAttaquant )
            {
                tb.Enabled = false ;
            }
            foreach( TextBox tb in TextBoxesFlotteDefenseur )
            {
                tb.Enabled = false ;
            }
            foreach( TextBox tb in TextBoxesDefenses )
            {
                tb.Enabled = false ;
            }
            foreach( TextBox tb in TextBoxesResultats )
            {
                tb.Enabled = false ;
                tb.Text = "" ;
                tb.BackColor = System.Drawing.SystemColors.Control ;
            }
            foreach( TextBox tb in TextBoxesTechnologieAttaquant )
            {
                tb.Enabled = false ;
            }
            textBoxMetalDefenseur.Enabled = false ;
            textBoxCristalDefenseur.Enabled = false ;
            textBoxDeuteriumDefenseur.Enabled = false ;
            tbArmesDefenseur.Enabled = false ;
            tbBouclierDefenseur.Enabled = false ;
            tbProtectionDefenseur.Enabled = false ;
            tbCoordonneesAttaquant.Enabled = false ;
            tbCoordonneesDefenseur.Enabled = false ;

            textBoxOptionSimuNombreIterations.ReadOnly = true ;

            buttonSelectionCasPire.Enabled = false ;
            buttonSelectionCasMoyen.Enabled = false ;
            buttonSelectionCasMeilleur.Enabled = false ;

            textBoxResultat.Text = "" ;
            textBoxResultat.Enabled = false ;
            textBoxRuines.Text = "" ;
            textBoxRuines.Enabled = false ;

            textBoxPertes.Text = "" ;
            textBoxPertes.Enabled = false ;

            textBoxPillage.Text = "" ;
            textBoxPillage.Enabled = false ;

            textBoxRentabiliteAvecRecyclage.Text = "" ;
            textBoxRentabiliteAvecRecyclage.Enabled = false ;
            textBoxRentabiliteSansRecyclage.Text = "" ;
            textBoxRentabiliteSansRecyclage.Enabled = false ;

            textBoxConsommation.Text = "" ;
            textBoxConsommation.Enabled = false ;
            textBoxTempsDeTrajet.Text = "" ;
            textBoxTempsDeTrajet.Enabled = false ;
        }

        private void ActiveTousLesControlsApresUneSimulation()
        {
            // Mise à jour de l'état des controls
            foreach( TextBox tb in TextBoxesFlotteAttaquant )
            {
                tb.Enabled = true ;
            }
            foreach( TextBox tb in TextBoxesFlotteDefenseur )
            {
                tb.Enabled = true ;
            }
            foreach( TextBox tb in TextBoxesDefenses )
            {
                tb.Enabled = true ;
            }
            foreach( TextBox tb in TextBoxesResultats )
            {
                tb.Enabled = true ;
            }
            foreach( TextBox tb in TextBoxesTechnologieAttaquant )
            {
                tb.Enabled = true ;
            }
            textBoxMetalDefenseur.Enabled = true ;
            textBoxCristalDefenseur.Enabled = true ;
            textBoxDeuteriumDefenseur.Enabled = true ;
            tbArmesDefenseur.Enabled = true ;
            tbBouclierDefenseur.Enabled = true ;
            tbProtectionDefenseur.Enabled = true ;
            tbCoordonneesAttaquant.Enabled = true ;
            tbCoordonneesDefenseur.Enabled = true ;

            textBoxOptionSimuNombreIterations.ReadOnly = false ;
            textBoxOptionSimuNombreIterations.Text = Convert.ToString( boucle ) ;
            buttonLancerLaSimulation.Enabled = true ;

            buttonSelectionCasPire.Enabled = true ;
            buttonSelectionCasMoyen.Enabled = true ;
            buttonSelectionCasMeilleur.Enabled = true ;

            textBoxResultat.Enabled = true ;
            textBoxRuines.Enabled = true ;
            textBoxPertes.Enabled = true ;
            textBoxPillage.Enabled = true ;
            textBoxRentabiliteAvecRecyclage.Enabled = true ;
            textBoxRentabiliteSansRecyclage.Enabled = true ;

            textBoxConsommation.Enabled = true ;
            textBoxTempsDeTrajet.Enabled = true ;
        }

        #endregion

        #region Gestion des résultats min et max par type de vaisseaux

        private void initialieLesMinEtMax()
        {
            #region Initialisation des min/max par type de vaisseaux

            MaxDefenseur = new RapportDEspionnage() ;
            MaxAttaquant = new RapportDEspionnage() ;
            MinDefenseur = new RapportDEspionnage() ;
            MinAttaquant = new RapportDEspionnage() ;

            MinDefenseur.FlotteAQuai.PetitsTransporteurs     = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.GrandTransporteurs      = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.ChasseursLegers         = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.ChasseursLourds         = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.Croiseurs               = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.VaisseauxDeBataille     = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.VaisseauxDeColonisation = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.Recycleurs              = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.SondesDEspionnage       = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.SatellitesSolaires      = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.Bombardiers             = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.Destructeurs            = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.Battlecruiser           = uint.MaxValue ;
            MinDefenseur.FlotteAQuai.EtoilesDeLaMort         = uint.MaxValue ;

            MinDefenseur.Defenses.ArtilleriesAIons           = uint.MaxValue ;
            MinDefenseur.Defenses.ArtilleriesLaserLegeres    = uint.MaxValue ;
            MinDefenseur.Defenses.ArtilleriesLaserLourdes    = uint.MaxValue ;
            MinDefenseur.Defenses.CanonsDeGauss              = uint.MaxValue ;
            MinDefenseur.Defenses.GrandBouclier              = uint.MaxValue ;
            MinDefenseur.Defenses.LanceursDeMissiles         = uint.MaxValue ;
            MinDefenseur.Defenses.LanceursDePlasma           = uint.MaxValue ;
            MinDefenseur.Defenses.PetitBouclier              = uint.MaxValue ;

            MinAttaquant.FlotteAQuai.PetitsTransporteurs     = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.GrandTransporteurs      = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.ChasseursLegers         = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.ChasseursLourds         = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.Croiseurs               = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.VaisseauxDeBataille     = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.VaisseauxDeColonisation = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.Recycleurs              = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.SondesDEspionnage       = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.Bombardiers             = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.Destructeurs            = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.Battlecruiser           = uint.MaxValue ;
            MinAttaquant.FlotteAQuai.EtoilesDeLaMort         = uint.MaxValue;

            #endregion
        }

        private void metAJourLesMinEtMax( RapportDEspionnage Attaquant, RapportDEspionnage Defenseur )
        {
            /*            Ressources debris = new Ressources() ;
                        debris = 
                            (attaquant.FlotteAQuai - Attaquant.FlotteAQuai).ValeurEnRuines() +
                            (defenseur.FlotteAQuai - Defenseur.FlotteAQuai).ValeurEnRuines() ;
                        if ( debris.Metal   > MaxDebris.Metal   ) MaxDebris.Metal   = debris.Metal   ;
                        if ( debris.Cristal > MaxDebris.Cristal ) MaxDebris.Cristal = debris.Cristal ;
                        if ( debris.Metal   < MinDebris.Metal   ) MinDebris.Metal   = debris.Metal   ;
                        if ( debris.Cristal < MinDebris.Cristal ) MinDebris.Cristal = debris.Cristal ;

                        Ressources pertesAttaquant = (attaquant.FlotteAQuai - Attaquant.FlotteAQuai).ValeurDAchat() ;
                        Ressources pertesDefenseur = (defenseur.FlotteAQuai - Defenseur.FlotteAQuai).ValeurDAchat() ;
                        if ( MinPertesAttaquant.Total > pertesAttaquant.Total ) MinPertesAttaquant = pertesAttaquant ;
                        if ( MaxPertesAttaquant.Total < pertesAttaquant.Total ) MaxPertesAttaquant = pertesAttaquant ;
                        if ( MinPertesDefenseur.Total > pertesDefenseur.Total ) MinPertesDefenseur = pertesDefenseur ;
                        if ( MaxPertesDefenseur.Total < pertesDefenseur.Total ) MaxPertesDefenseur = pertesDefenseur ;
                        */

            #region Mise à jour min/max par type de vaisseaux
            if ( Defenseur.FlotteAQuai.PetitsTransporteurs     > MaxDefenseur.FlotteAQuai.PetitsTransporteurs     ) MaxDefenseur.FlotteAQuai.PetitsTransporteurs     = Defenseur.FlotteAQuai.PetitsTransporteurs     ;
            if ( Defenseur.FlotteAQuai.GrandTransporteurs      > MaxDefenseur.FlotteAQuai.GrandTransporteurs      ) MaxDefenseur.FlotteAQuai.GrandTransporteurs      = Defenseur.FlotteAQuai.GrandTransporteurs      ;
            if ( Defenseur.FlotteAQuai.ChasseursLegers         > MaxDefenseur.FlotteAQuai.ChasseursLegers         ) MaxDefenseur.FlotteAQuai.ChasseursLegers         = Defenseur.FlotteAQuai.ChasseursLegers         ;
            if ( Defenseur.FlotteAQuai.ChasseursLourds         > MaxDefenseur.FlotteAQuai.ChasseursLourds         ) MaxDefenseur.FlotteAQuai.ChasseursLourds         = Defenseur.FlotteAQuai.ChasseursLourds         ;
            if ( Defenseur.FlotteAQuai.Croiseurs               > MaxDefenseur.FlotteAQuai.Croiseurs               ) MaxDefenseur.FlotteAQuai.Croiseurs               = Defenseur.FlotteAQuai.Croiseurs               ;
            if ( Defenseur.FlotteAQuai.VaisseauxDeBataille     > MaxDefenseur.FlotteAQuai.VaisseauxDeBataille     ) MaxDefenseur.FlotteAQuai.VaisseauxDeBataille     = Defenseur.FlotteAQuai.VaisseauxDeBataille     ;
            if ( Defenseur.FlotteAQuai.VaisseauxDeColonisation > MaxDefenseur.FlotteAQuai.VaisseauxDeColonisation ) MaxDefenseur.FlotteAQuai.VaisseauxDeColonisation = Defenseur.FlotteAQuai.VaisseauxDeColonisation ;
            if ( Defenseur.FlotteAQuai.Recycleurs              > MaxDefenseur.FlotteAQuai.Recycleurs              ) MaxDefenseur.FlotteAQuai.Recycleurs              = Defenseur.FlotteAQuai.Recycleurs              ;
            if ( Defenseur.FlotteAQuai.SondesDEspionnage       > MaxDefenseur.FlotteAQuai.SondesDEspionnage       ) MaxDefenseur.FlotteAQuai.SondesDEspionnage       = Defenseur.FlotteAQuai.SondesDEspionnage       ;
            if ( Defenseur.FlotteAQuai.SatellitesSolaires      > MaxDefenseur.FlotteAQuai.SatellitesSolaires      ) MaxDefenseur.FlotteAQuai.SatellitesSolaires      = Defenseur.FlotteAQuai.SatellitesSolaires      ;
            if ( Defenseur.FlotteAQuai.Bombardiers             > MaxDefenseur.FlotteAQuai.Bombardiers             ) MaxDefenseur.FlotteAQuai.Bombardiers             = Defenseur.FlotteAQuai.Bombardiers             ;
            if ( Defenseur.FlotteAQuai.Destructeurs            > MaxDefenseur.FlotteAQuai.Destructeurs            ) MaxDefenseur.FlotteAQuai.Destructeurs            = Defenseur.FlotteAQuai.Destructeurs            ;
            if ( Defenseur.FlotteAQuai.Battlecruiser           > MaxDefenseur.FlotteAQuai.Battlecruiser           ) MaxDefenseur.FlotteAQuai.Battlecruiser           = Defenseur.FlotteAQuai.Battlecruiser           ;
            if ( Defenseur.FlotteAQuai.EtoilesDeLaMort         > MaxDefenseur.FlotteAQuai.EtoilesDeLaMort         ) MaxDefenseur.FlotteAQuai.EtoilesDeLaMort         = Defenseur.FlotteAQuai.EtoilesDeLaMort         ;

            if ( Defenseur.Defenses.ArtilleriesAIons        > MaxDefenseur.Defenses.ArtilleriesAIons        ) MaxDefenseur.Defenses.ArtilleriesAIons        = Defenseur.Defenses.ArtilleriesAIons        ;
            if ( Defenseur.Defenses.ArtilleriesLaserLegeres > MaxDefenseur.Defenses.ArtilleriesLaserLegeres ) MaxDefenseur.Defenses.ArtilleriesLaserLegeres = Defenseur.Defenses.ArtilleriesLaserLegeres ;
            if ( Defenseur.Defenses.ArtilleriesLaserLourdes > MaxDefenseur.Defenses.ArtilleriesLaserLourdes ) MaxDefenseur.Defenses.ArtilleriesLaserLourdes = Defenseur.Defenses.ArtilleriesLaserLourdes ;
            if ( Defenseur.Defenses.CanonsDeGauss           > MaxDefenseur.Defenses.CanonsDeGauss           ) MaxDefenseur.Defenses.CanonsDeGauss           = Defenseur.Defenses.CanonsDeGauss           ;
            if ( Defenseur.Defenses.GrandBouclier           > MaxDefenseur.Defenses.GrandBouclier           ) MaxDefenseur.Defenses.GrandBouclier           = Defenseur.Defenses.GrandBouclier           ;
            if ( Defenseur.Defenses.LanceursDeMissiles      > MaxDefenseur.Defenses.LanceursDeMissiles      ) MaxDefenseur.Defenses.LanceursDeMissiles      = Defenseur.Defenses.LanceursDeMissiles      ;
            if ( Defenseur.Defenses.LanceursDePlasma        > MaxDefenseur.Defenses.LanceursDePlasma        ) MaxDefenseur.Defenses.LanceursDePlasma        = Defenseur.Defenses.LanceursDePlasma        ;
            if ( Defenseur.Defenses.PetitBouclier           > MaxDefenseur.Defenses.PetitBouclier           ) MaxDefenseur.Defenses.PetitBouclier           = Defenseur.Defenses.PetitBouclier           ;
            
            if ( Attaquant.FlotteAQuai.PetitsTransporteurs     > MaxAttaquant.FlotteAQuai.PetitsTransporteurs     ) MaxAttaquant.FlotteAQuai.PetitsTransporteurs     = Attaquant.FlotteAQuai.PetitsTransporteurs     ;
            if ( Attaquant.FlotteAQuai.GrandTransporteurs      > MaxAttaquant.FlotteAQuai.GrandTransporteurs      ) MaxAttaquant.FlotteAQuai.GrandTransporteurs      = Attaquant.FlotteAQuai.GrandTransporteurs      ;
            if ( Attaquant.FlotteAQuai.ChasseursLegers         > MaxAttaquant.FlotteAQuai.ChasseursLegers         ) MaxAttaquant.FlotteAQuai.ChasseursLegers         = Attaquant.FlotteAQuai.ChasseursLegers         ;
            if ( Attaquant.FlotteAQuai.ChasseursLourds         > MaxAttaquant.FlotteAQuai.ChasseursLourds         ) MaxAttaquant.FlotteAQuai.ChasseursLourds         = Attaquant.FlotteAQuai.ChasseursLourds         ;
            if ( Attaquant.FlotteAQuai.Croiseurs               > MaxAttaquant.FlotteAQuai.Croiseurs               ) MaxAttaquant.FlotteAQuai.Croiseurs               = Attaquant.FlotteAQuai.Croiseurs               ;
            if ( Attaquant.FlotteAQuai.VaisseauxDeBataille     > MaxAttaquant.FlotteAQuai.VaisseauxDeBataille     ) MaxAttaquant.FlotteAQuai.VaisseauxDeBataille     = Attaquant.FlotteAQuai.VaisseauxDeBataille     ;
            if ( Attaquant.FlotteAQuai.VaisseauxDeColonisation > MaxAttaquant.FlotteAQuai.VaisseauxDeColonisation ) MaxAttaquant.FlotteAQuai.VaisseauxDeColonisation = Attaquant.FlotteAQuai.VaisseauxDeColonisation ;
            if ( Attaquant.FlotteAQuai.Recycleurs              > MaxAttaquant.FlotteAQuai.Recycleurs              ) MaxAttaquant.FlotteAQuai.Recycleurs              = Attaquant.FlotteAQuai.Recycleurs              ;
            if ( Attaquant.FlotteAQuai.SondesDEspionnage       > MaxAttaquant.FlotteAQuai.SondesDEspionnage       ) MaxAttaquant.FlotteAQuai.SondesDEspionnage       = Attaquant.FlotteAQuai.SondesDEspionnage       ;
            if ( Attaquant.FlotteAQuai.Bombardiers             > MaxAttaquant.FlotteAQuai.Bombardiers             ) MaxAttaquant.FlotteAQuai.Bombardiers             = Attaquant.FlotteAQuai.Bombardiers             ;
            if ( Attaquant.FlotteAQuai.Destructeurs            > MaxAttaquant.FlotteAQuai.Destructeurs            ) MaxAttaquant.FlotteAQuai.Destructeurs            = Attaquant.FlotteAQuai.Destructeurs            ;
            if ( Attaquant.FlotteAQuai.Battlecruiser           > MaxAttaquant.FlotteAQuai.Battlecruiser           ) MaxAttaquant.FlotteAQuai.Battlecruiser           = Attaquant.FlotteAQuai.Battlecruiser           ;
            if ( Attaquant.FlotteAQuai.EtoilesDeLaMort         > MaxAttaquant.FlotteAQuai.EtoilesDeLaMort         ) MaxAttaquant.FlotteAQuai.EtoilesDeLaMort         = Attaquant.FlotteAQuai.EtoilesDeLaMort         ;

            if ( Defenseur.FlotteAQuai.PetitsTransporteurs     < MinDefenseur.FlotteAQuai.PetitsTransporteurs     ) MinDefenseur.FlotteAQuai.PetitsTransporteurs     = Defenseur.FlotteAQuai.PetitsTransporteurs     ;
            if ( Defenseur.FlotteAQuai.GrandTransporteurs      < MinDefenseur.FlotteAQuai.GrandTransporteurs      ) MinDefenseur.FlotteAQuai.GrandTransporteurs      = Defenseur.FlotteAQuai.GrandTransporteurs      ;
            if ( Defenseur.FlotteAQuai.ChasseursLegers         < MinDefenseur.FlotteAQuai.ChasseursLegers         ) MinDefenseur.FlotteAQuai.ChasseursLegers         = Defenseur.FlotteAQuai.ChasseursLegers         ;
            if ( Defenseur.FlotteAQuai.ChasseursLourds         < MinDefenseur.FlotteAQuai.ChasseursLourds         ) MinDefenseur.FlotteAQuai.ChasseursLourds         = Defenseur.FlotteAQuai.ChasseursLourds         ;
            if ( Defenseur.FlotteAQuai.Croiseurs               < MinDefenseur.FlotteAQuai.Croiseurs               ) MinDefenseur.FlotteAQuai.Croiseurs               = Defenseur.FlotteAQuai.Croiseurs               ;
            if ( Defenseur.FlotteAQuai.VaisseauxDeBataille     < MinDefenseur.FlotteAQuai.VaisseauxDeBataille     ) MinDefenseur.FlotteAQuai.VaisseauxDeBataille     = Defenseur.FlotteAQuai.VaisseauxDeBataille     ;
            if ( Defenseur.FlotteAQuai.VaisseauxDeColonisation < MinDefenseur.FlotteAQuai.VaisseauxDeColonisation ) MinDefenseur.FlotteAQuai.VaisseauxDeColonisation = Defenseur.FlotteAQuai.VaisseauxDeColonisation ;
            if ( Defenseur.FlotteAQuai.Recycleurs              < MinDefenseur.FlotteAQuai.Recycleurs              ) MinDefenseur.FlotteAQuai.Recycleurs              = Defenseur.FlotteAQuai.Recycleurs              ;
            if ( Defenseur.FlotteAQuai.SondesDEspionnage       < MinDefenseur.FlotteAQuai.SondesDEspionnage       ) MinDefenseur.FlotteAQuai.SondesDEspionnage       = Defenseur.FlotteAQuai.SondesDEspionnage       ;
            if ( Defenseur.FlotteAQuai.SatellitesSolaires      < MinDefenseur.FlotteAQuai.SatellitesSolaires      ) MinDefenseur.FlotteAQuai.SatellitesSolaires      = Defenseur.FlotteAQuai.SatellitesSolaires      ;
            if ( Defenseur.FlotteAQuai.Bombardiers             < MinDefenseur.FlotteAQuai.Bombardiers             ) MinDefenseur.FlotteAQuai.Bombardiers             = Defenseur.FlotteAQuai.Bombardiers             ;
            if ( Defenseur.FlotteAQuai.Destructeurs            < MinDefenseur.FlotteAQuai.Destructeurs            ) MinDefenseur.FlotteAQuai.Destructeurs            = Defenseur.FlotteAQuai.Destructeurs            ;
            if ( Defenseur.FlotteAQuai.Battlecruiser           > MinDefenseur.FlotteAQuai.Battlecruiser           ) MinDefenseur.FlotteAQuai.Battlecruiser           = Defenseur.FlotteAQuai.Battlecruiser           ;
            if ( Defenseur.FlotteAQuai.EtoilesDeLaMort         < MinDefenseur.FlotteAQuai.EtoilesDeLaMort         ) MinDefenseur.FlotteAQuai.EtoilesDeLaMort         = Defenseur.FlotteAQuai.EtoilesDeLaMort         ;

            if ( Defenseur.Defenses.ArtilleriesAIons        < MinDefenseur.Defenses.ArtilleriesAIons        ) MinDefenseur.Defenses.ArtilleriesAIons        = Defenseur.Defenses.ArtilleriesAIons        ;
            if ( Defenseur.Defenses.ArtilleriesLaserLegeres < MinDefenseur.Defenses.ArtilleriesLaserLegeres ) MinDefenseur.Defenses.ArtilleriesLaserLegeres = Defenseur.Defenses.ArtilleriesLaserLegeres ;
            if ( Defenseur.Defenses.ArtilleriesLaserLourdes < MinDefenseur.Defenses.ArtilleriesLaserLourdes ) MinDefenseur.Defenses.ArtilleriesLaserLourdes = Defenseur.Defenses.ArtilleriesLaserLourdes ;
            if ( Defenseur.Defenses.CanonsDeGauss           < MinDefenseur.Defenses.CanonsDeGauss           ) MinDefenseur.Defenses.CanonsDeGauss           = Defenseur.Defenses.CanonsDeGauss           ;
            if ( Defenseur.Defenses.GrandBouclier           < MinDefenseur.Defenses.GrandBouclier           ) MinDefenseur.Defenses.GrandBouclier           = Defenseur.Defenses.GrandBouclier           ;
            if ( Defenseur.Defenses.LanceursDeMissiles      < MinDefenseur.Defenses.LanceursDeMissiles      ) MinDefenseur.Defenses.LanceursDeMissiles      = Defenseur.Defenses.LanceursDeMissiles      ;
            if ( Defenseur.Defenses.LanceursDePlasma        < MinDefenseur.Defenses.LanceursDePlasma        ) MinDefenseur.Defenses.LanceursDePlasma        = Defenseur.Defenses.LanceursDePlasma        ;
            if ( Defenseur.Defenses.PetitBouclier           < MinDefenseur.Defenses.PetitBouclier           ) MinDefenseur.Defenses.PetitBouclier           = Defenseur.Defenses.PetitBouclier           ;
            
            if ( Attaquant.FlotteAQuai.PetitsTransporteurs     < MinAttaquant.FlotteAQuai.PetitsTransporteurs     ) MinAttaquant.FlotteAQuai.PetitsTransporteurs     = Attaquant.FlotteAQuai.PetitsTransporteurs     ;
            if ( Attaquant.FlotteAQuai.GrandTransporteurs      < MinAttaquant.FlotteAQuai.GrandTransporteurs      ) MinAttaquant.FlotteAQuai.GrandTransporteurs      = Attaquant.FlotteAQuai.GrandTransporteurs      ;
            if ( Attaquant.FlotteAQuai.ChasseursLegers         < MinAttaquant.FlotteAQuai.ChasseursLegers         ) MinAttaquant.FlotteAQuai.ChasseursLegers         = Attaquant.FlotteAQuai.ChasseursLegers         ;
            if ( Attaquant.FlotteAQuai.ChasseursLourds         < MinAttaquant.FlotteAQuai.ChasseursLourds         ) MinAttaquant.FlotteAQuai.ChasseursLourds         = Attaquant.FlotteAQuai.ChasseursLourds         ;
            if ( Attaquant.FlotteAQuai.Croiseurs               < MinAttaquant.FlotteAQuai.Croiseurs               ) MinAttaquant.FlotteAQuai.Croiseurs               = Attaquant.FlotteAQuai.Croiseurs               ;
            if ( Attaquant.FlotteAQuai.VaisseauxDeBataille     < MinAttaquant.FlotteAQuai.VaisseauxDeBataille     ) MinAttaquant.FlotteAQuai.VaisseauxDeBataille     = Attaquant.FlotteAQuai.VaisseauxDeBataille     ;
            if ( Attaquant.FlotteAQuai.VaisseauxDeColonisation < MinAttaquant.FlotteAQuai.VaisseauxDeColonisation ) MinAttaquant.FlotteAQuai.VaisseauxDeColonisation = Attaquant.FlotteAQuai.VaisseauxDeColonisation ;
            if ( Attaquant.FlotteAQuai.Recycleurs              < MinAttaquant.FlotteAQuai.Recycleurs              ) MinAttaquant.FlotteAQuai.Recycleurs              = Attaquant.FlotteAQuai.Recycleurs              ;
            if ( Attaquant.FlotteAQuai.SondesDEspionnage       < MinAttaquant.FlotteAQuai.SondesDEspionnage       ) MinAttaquant.FlotteAQuai.SondesDEspionnage       = Attaquant.FlotteAQuai.SondesDEspionnage       ;
            if ( Attaquant.FlotteAQuai.Bombardiers             < MinAttaquant.FlotteAQuai.Bombardiers             ) MinAttaquant.FlotteAQuai.Bombardiers             = Attaquant.FlotteAQuai.Bombardiers             ;
            if ( Attaquant.FlotteAQuai.Destructeurs            < MinAttaquant.FlotteAQuai.Destructeurs            ) MinAttaquant.FlotteAQuai.Destructeurs            = Attaquant.FlotteAQuai.Destructeurs            ;
            if ( Attaquant.FlotteAQuai.Battlecruiser           < MinAttaquant.FlotteAQuai.Battlecruiser           ) MinAttaquant.FlotteAQuai.Battlecruiser           = Attaquant.FlotteAQuai.Battlecruiser           ;
            if ( Attaquant.FlotteAQuai.EtoilesDeLaMort         < MinAttaquant.FlotteAQuai.EtoilesDeLaMort         ) MinAttaquant.FlotteAQuai.EtoilesDeLaMort         = Attaquant.FlotteAQuai.EtoilesDeLaMort;
            #endregion
        }

        private void afficheLesResultats( RapportDEspionnage Attaquant, RapportDEspionnage Defenseur, int compte )
        {
            #region Affichage des résultats par type de vaisseaux

            tbPertesPTDefenseur   .Text = affStat( Defenseur.FlotteAQuai.PetitsTransporteurs     ,compte ) ;
            tbPertesGTDefenseur   .Text = affStat( Defenseur.FlotteAQuai.GrandTransporteurs      ,compte ) ;
            tbPertesCleDefenseur  .Text = affStat( Defenseur.FlotteAQuai.ChasseursLegers         ,compte ) ;
            tbPertesCLDefenseur   .Text = affStat( Defenseur.FlotteAQuai.ChasseursLourds         ,compte ) ;
            tbPertesCRDefenseur   .Text = affStat( Defenseur.FlotteAQuai.Croiseurs               ,compte ) ;
            tbPertesVBDefenseur   .Text = affStat( Defenseur.FlotteAQuai.VaisseauxDeBataille     ,compte ) ;
            tbPertesVCDefenseur   .Text = affStat( Defenseur.FlotteAQuai.VaisseauxDeColonisation ,compte ) ;
            tbPertesRCDefenseur   .Text = affStat( Defenseur.FlotteAQuai.Recycleurs              ,compte ) ;
            tbPertesSondeDefenseur.Text = affStat( Defenseur.FlotteAQuai.SondesDEspionnage       ,compte ) ;
            tbPertesSatDefenseur  .Text = affStat( Defenseur.FlotteAQuai.SatellitesSolaires      ,compte ) ;
            tbPertesBDefenseur    .Text = affStat( Defenseur.FlotteAQuai.Bombardiers             ,compte ) ;
            tbPertesDDefenseur    .Text = affStat( Defenseur.FlotteAQuai.Destructeurs            ,compte ) ;
            tbPertesBattleDefenseur.Text= affStat( Defenseur.FlotteAQuai.Battlecruiser           ,compte ) ;
            tbPertesEDLMDefenseur .Text = affStat( Defenseur.FlotteAQuai.EtoilesDeLaMort         ,compte ) ;

            tbPertesDefIonsDefenseur      .Text = affStat( Defenseur.Defenses.ArtilleriesAIons        ,compte ) ;
            tbPertesDefLaserLegDefenseur  .Text = affStat( Defenseur.Defenses.ArtilleriesLaserLegeres ,compte ) ;
            tbPertesDefLaserLourdDefenseur.Text = affStat( Defenseur.Defenses.ArtilleriesLaserLourdes ,compte ) ;
            tbPertesDefGaussDefenseur     .Text = affStat( Defenseur.Defenses.CanonsDeGauss           ,compte ) ;
            tbPertesDefGBDefenseur        .Text = affStat( Defenseur.Defenses.GrandBouclier           ,compte ) ;
            tbPertesDefMissileDefenseur   .Text = affStat( Defenseur.Defenses.LanceursDeMissiles      ,compte ) ;
            tbPertesDefPlasmaDefenseur    .Text = affStat( Defenseur.Defenses.LanceursDePlasma        ,compte ) ;
            tbPertesDefPBDefenseur        .Text = affStat( Defenseur.Defenses.PetitBouclier           ,compte ) ;
            
            tbPertesPTAttaquant   .Text = affStat( Attaquant.FlotteAQuai.PetitsTransporteurs     ,compte ) ;
            tbPertesGTAttaquant   .Text = affStat( Attaquant.FlotteAQuai.GrandTransporteurs      ,compte ) ;
            tbPertesCleAttaquant  .Text = affStat( Attaquant.FlotteAQuai.ChasseursLegers         ,compte ) ;
            tbPertesCLAttaquant   .Text = affStat( Attaquant.FlotteAQuai.ChasseursLourds         ,compte ) ;
            tbPertesCRAttaquant   .Text = affStat( Attaquant.FlotteAQuai.Croiseurs               ,compte ) ;
            tbPertesVBAttaquant   .Text = affStat( Attaquant.FlotteAQuai.VaisseauxDeBataille     ,compte ) ;
            tbPertesVCAttaquant   .Text = affStat( Attaquant.FlotteAQuai.VaisseauxDeColonisation ,compte ) ;
            tbPertesRCAttaquant   .Text = affStat( Attaquant.FlotteAQuai.Recycleurs              ,compte ) ;
            tbPertesSondeAttaquant.Text = affStat( Attaquant.FlotteAQuai.SondesDEspionnage       ,compte ) ;
            tbPertesBAttaquant    .Text = affStat( Attaquant.FlotteAQuai.Bombardiers             ,compte ) ;
            tbPertesDAttaquant    .Text = affStat( Attaquant.FlotteAQuai.Destructeurs            ,compte ) ;
            tbPertesBattleAttaquant.Text= affStat( Attaquant.FlotteAQuai.Battlecruiser           ,compte ) ;
            tbPertesEDLMAttaquant .Text = affStat( Attaquant.FlotteAQuai.EtoilesDeLaMort         ,compte ) ;

            #endregion 
        }

        #endregion

        #region Gestion des cas (pire/moyen/meilleur)

        private void affichePillage(RessourcesLong pillage)
        {
            textBoxPillage.Text = "" + affEntier(pillage.Metal) + " M    " + affEntier(pillage.Cristal) + " C    " + affEntier(pillage.Deuterium) + " D" ;
            
            if( Defenseur.Ressources.Total != 0 )
            {
                textBoxPillage.Text += "    (" + (int)((pillage.Total*100)/(Defenseur.Ressources.Total/2)) + "%)" ;
            }
            else
            {
                textBoxPillage.Text += "    (0%)" ;
            }
        }
       
        private void afficheRentabilites(RessourcesLong rentabiliteAvecRecyclage, RessourcesLong rentabiliteSansRecyclage)
        {
            textBoxRentabiliteAvecRecyclage.Text = "Avec recyclage\r\n";
            textBoxRentabiliteAvecRecyclage.Text += "" + affLong(rentabiliteAvecRecyclage.Metal) + " M\r\n";
            textBoxRentabiliteAvecRecyclage.Text += "" + affLong(rentabiliteAvecRecyclage.Cristal) + " C\r\n";
            textBoxRentabiliteAvecRecyclage.Text += "" + affLong(rentabiliteAvecRecyclage.Deuterium) + " D\r\n";
            textBoxRentabiliteAvecRecyclage.Text += "" + affLong(rentabiliteAvecRecyclage.Total) + " res";
            textBoxRentabiliteSansRecyclage.Text = "Sans recyclage\r\n";
            textBoxRentabiliteSansRecyclage.Text += "" + affLong(rentabiliteSansRecyclage.Metal) + " M\r\n";
            textBoxRentabiliteSansRecyclage.Text += "" + affLong(rentabiliteSansRecyclage.Cristal) + " C\r\n";
            textBoxRentabiliteSansRecyclage.Text += "" + affLong(rentabiliteSansRecyclage.Deuterium) + " D\r\n";
            textBoxRentabiliteSansRecyclage.Text += "" + affLong(rentabiliteSansRecyclage.Total) + " res";
        }

        private void affichePertes(RessourcesLong pertesAttaquant, RessourcesLong pertesDefenseur)
        {
            textBoxPertes.Text  = "Pertes attaquant :\r\n" ;
            textBoxPertes.Text += "  "+affEntier(pertesAttaquant.Metal)+" M    "+affEntier(pertesAttaquant.Cristal)+" C    "+affEntier(pertesAttaquant.Deuterium)+" D\r\n" ;
            textBoxPertes.Text += "Pertes défenseur :\r\n" ;
            textBoxPertes.Text += "  "+affEntier(pertesDefenseur.Metal)+" M    "+affEntier(pertesDefenseur.Cristal)+" C    "+affEntier(pertesDefenseur.Deuterium)+" D" ;
        }

        private void buttonSelectionCasPire_Click( object sender, EventArgs e )
        {
            labelAffichage.Text = "Chaque résultat indique le score le plus interessant pour le défenseur indépendamment du reste du résultat du combat." ;
            labelAffichage.ForeColor = Color.Green ;
            labelPertes.Text = "Pertes totales avantage défenseur" ;
            labelPertes.ForeColor = Color.Green ;
            labelPillage.Text = "Pillage minimum (en cas de victoire)" ;
            labelPillage.ForeColor = Color.Green ;
            labelRentabilite.Text = "Rentabilité (pire cas)" ;
            labelRentabilite.ForeColor = Color.Green ;

            afficheLesResultats( MinAttaquant, MaxDefenseur, 1 ) ;
            afficheRentabilites( Stats.PireCas.RentabiliteAttaquantAvecRecyclage, Stats.PireCas.RentabiliteAttaquantSansRecyclage ) ;
            affichePertes( Stats.PireCas.PertesAttaquant, Stats.PireCas.PertesDefenseur ) ;
            affichePillage( Stats.PireCas.Pillage ) ;
        }

        private void buttonSelectionCasMoyen_Click( object sender, EventArgs e )
        {
            labelAffichage.Text = "Sélection de l'affichage :" ;
            labelAffichage.ForeColor = System.Drawing.SystemColors.WindowText ;
            labelPertes.Text = "Pertes moyenne" ;
            labelPertes.ForeColor = System.Drawing.SystemColors.WindowText ;
            labelPillage.Text = "Pillage moyen (en cas de victoire)" ;
            labelPillage.ForeColor = System.Drawing.SystemColors.WindowText ;
            labelRentabilite.Text = "Rentabilité" ;
            labelRentabilite.ForeColor = System.Drawing.SystemColors.WindowText ;

            afficheLesResultats( StatsAttaquant, StatsDefenseur, boucle ) ;
            afficheRentabilites( Stats.RentabiliteAttaquantAvecRecyclage, Stats.RentabiliteAttaquantSansRecyclage ) ;
            affichePertes( Stats.PertesAttaquant, Stats.PertesDefenseur ) ;
            affichePillage( Stats.Pillage ) ;
        }

        private void buttonSelectionCasMeilleur_Click( object sender, EventArgs e )
        {
            labelAffichage.Text = "Chaque résultat indique le score le plus interessant pour l'attaquant indépendamment du reste du résultat du combat.";
            labelAffichage.ForeColor = Color.Red ;
            labelPertes.Text = "Pertes totales avantage attaquant" ;
            labelPertes.ForeColor = Color.Red ;
            labelPillage.Text = "Pillage maximum (en cas de victoire)" ;
            labelPillage.ForeColor = Color.Red ;
            labelRentabilite.Text = "Rentabilité (meilleur cas)" ;
            labelRentabilite.ForeColor = Color.Red ;

            afficheLesResultats(MaxAttaquant, MinDefenseur, 1) ;
            afficheRentabilites( Stats.MeilleurCas.RentabiliteAttaquantAvecRecyclage, Stats.MeilleurCas.RentabiliteAttaquantSansRecyclage ) ;
            affichePertes( Stats.MeilleurCas.PertesAttaquant, Stats.MeilleurCas.PertesDefenseur ) ;
            affichePillage( Stats.MeilleurCas.Pillage ) ;
        }

        #endregion

        private void FormSimulation_FormClosing(object sender, FormClosingEventArgs e)
        {
            if ( backgroundWorkerSimulation.IsBusy )
            {
                backgroundWorkerSimulation.CancelAsync() ;
                Hide() ;
                e.Cancel = true ;
            }
            sauvegardePositionEtTaille() ;
        }

        private void FormSimulation_MouseDown( object sender, MouseEventArgs e )
        {
            if ( e.Button == MouseButtons.Left )
            {
                Capture = false ;
                const int WM_NCLBUTTONDOWN = 0xA1 ;
                const int HTCAPTION = 2 ;
                Message msg = Message.Create(this.Handle, WM_NCLBUTTONDOWN, new IntPtr(HTCAPTION), IntPtr.Zero) ;
                DefWndProc( ref msg ) ;
            }
        }

        private void buttonVagueSuivante_Click( object sender, EventArgs e )
        {
            foreach( TextBox tb in TextBoxesFlotteDefenseur )
            {
                TextBox resultat = tb.Tag as TextBox ;
                if ( resultat != null )
                {
                    try
                    {
                        double f = Convert.ToDouble( resultat.Text.Replace(" ", "") ) + 0.5 ;
                        tb.Text = Convert.ToString( (int)f ) ;
                    }
                    catch ( Exception )
                    {
                        tb.Text = "0" ;
                    }
                    resultat.BackColor = System.Drawing.SystemColors.Control ;
                }
            }
            foreach( TextBox tb in TextBoxesDefenses )
            {
                TextBox resultat = tb.Tag as TextBox ;
                if ( resultat != null )
                {
                    try
                    {
                        double reste = Convert.ToDouble( resultat.Text.Replace(" ", "") ) ;
                        double pertes = Convert.ToDouble(tb.Text) - reste ;
                        double f = reste + pertes * 0.7 + 0.5 ;
                        tb.Text = Convert.ToString( (int)f ) ;
                    }
                    catch ( Exception )
                    {
                        tb.Text = "0" ;
                    }
                    resultat.BackColor = System.Drawing.SystemColors.Control ;
                }
            }
            textBoxMetalDefenseur.Text     = affEntier( Defenseur.Ressources.Metal     - Stats.Pillage.Metal     ) ;
            textBoxCristalDefenseur.Text   = affEntier( Defenseur.Ressources.Cristal   - Stats.Pillage.Cristal   ) ;
            textBoxDeuteriumDefenseur.Text = affEntier( Defenseur.Ressources.Deuterium - Stats.Pillage.Deuterium ) ;
            buttonVagueSuivante.Visible = false ;
        }

    }
}