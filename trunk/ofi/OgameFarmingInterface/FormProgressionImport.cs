using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using Ogame ;
using System.Collections.ObjectModel;

namespace OgameFarmingInterface
{
    public partial class FormProgressionImport : Form
    {
        private FormPrincipale fp ;

        public FormProgressionImport(FormPrincipale formPrincipale)
        {
            fp = formPrincipale ;
            InitializeComponent() ;
            this.
            fp.AnalysePressePapier = false ;
            backgroundWorkerImportation.RunWorkerAsync() ;
        }

        private int RecupereEtAjouteLesPlanetesDeLaGalaxie( int galaxie )
        {
            int nombreDePlanetesRecuperees = 0 ;
            log.Debug("ImporteLaGalaxie("+galaxie+")") ;
            Collection<Planete> planetesRecuperees = fp.serveur.ImporteLaGalaxie(galaxie) ;
            foreach( Planete p in planetesRecuperees )
            {
                if ( backgroundWorkerImportation.CancellationPending )
                {
                    return nombreDePlanetesRecuperees ;
                }
                if ( p.DateEtHeureDeLecture.Ticks > FormPrincipale.LUniversConnu[p.coordonnees].DateEtHeureDeLecture.Ticks )
                {
                    FormPrincipale.LUniversConnu[p.coordonnees] = p ;
                    ++nombreDePlanetesRecuperees ;
                }
            }
            return nombreDePlanetesRecuperees ;
        }

        int nombreDePlanetesRecuperees = 0 ;
        
        private void backgroundWorkerImportation_DoWork( object sender, DoWorkEventArgs e )
        {
            try
            {
                nombreDePlanetesRecuperees = 0 ;
                float progression = 100.0f/fp.nombreDeGalaxiesSelectionnees() ;
                int progressionTotale = 0 ;
                for ( int g = 1 ; g <= Ogame.Valeurs.maxGalaxie ; ++g )
                {
                    if ( fp.galaxieEstSelectionnee(g) )
                    {
                        nombreDePlanetesRecuperees += RecupereEtAjouteLesPlanetesDeLaGalaxie(g) ;
                        if ( backgroundWorkerImportation.CancellationPending ) return ;
                        progressionTotale = (int)(progressionTotale + progression) ;
                        backgroundWorkerImportation.ReportProgress(progressionTotale) ;
                    }
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message) ;
            }
        }

        private void backgroundWorkerImportation_ProgressChanged( object sender, ProgressChangedEventArgs e )
        {
            progressBarAvancementSimulations.Value = e.ProgressPercentage ;
        }

        private void backgroundWorkerImportation_RunWorkerCompleted( object sender, RunWorkerCompletedEventArgs e )
        {
            fp.AnalysePressePapier = true ;
            fp.nombreDePlanetesRecuperees = nombreDePlanetesRecuperees ;
            fp.miseAJourAffichageUnivers() ;
            Close() ;
        }

        private void buttonAnnulerSimulations_Click( object sender, EventArgs e )
        {
            backgroundWorkerImportation.CancelAsync() ;
            buttonAnnulerSimulations.Text = "Annulé" ;
            buttonAnnulerSimulations.Enabled = false ;
        }

    }
}