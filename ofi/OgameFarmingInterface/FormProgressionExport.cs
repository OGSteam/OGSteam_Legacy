using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Collections.ObjectModel;
using Ogame ;

namespace OgameFarmingInterface
{
    public partial class FormProgressionExport : Form
    {
        private FormPrincipale fp ;

        public FormProgressionExport(FormPrincipale formPrincipale)
        {
            fp = formPrincipale ;
            fp.AnalysePressePapier = false ;
            InitializeComponent() ;
            resultat = new InterfaceServeur.ResultatDExportationDePlanetes() ;
            backgroundWorkerExportation.RunWorkerAsync() ;
        }

        #region Thread de travail

        InterfaceServeur.ResultatDExportationDePlanetes resultat ;
        float progression ;
        int progressionTotale = 0 ;
        
        private void exporteLesPlanetesDeLaGalaxieDansLaPlageSpecifiee( int galaxie, int systemeDebut, int systemeFin )
        {
            Collection<Planete> cp = new Collection<Planete>() ;
            for ( int s = systemeDebut ; s <= systemeFin ; ++s )
            {
                if ( backgroundWorkerExportation.CancellationPending ) return ;
                if ( FormPrincipale.LUniversConnu[galaxie].SystemeNonNul( s ) )
                {
                    for ( int p = 1 ; p <=15 ; ++p )
                    {
                        Planete pl = FormPrincipale.LUniversConnu[galaxie, s, p] as Planete ;
                        if ( pl != null )
                        {
                            if (    pl.Nom != "Planete inconnue"
                                 && pl.Nom != "Planète inconnue"
                                )
                            {
                                cp.Add( pl ) ;
                            }
                        }
                    }
                }
            }
            if ( backgroundWorkerExportation.CancellationPending ) return ;
            resultat += fp.serveur.ExporterLesPlanetes( cp ) ;
        }

        private void exporteLesPlanetesDeLaGalaxie( int galaxie )
        {
            exporteLesPlanetesDeLaGalaxieDansLaPlageSpecifiee( galaxie,   1, 100 ) ;
            if ( backgroundWorkerExportation.CancellationPending ) return ;
            progressionTotale = (int)(progressionTotale + progression) ;
            backgroundWorkerExportation.ReportProgress(progressionTotale) ;

            exporteLesPlanetesDeLaGalaxieDansLaPlageSpecifiee( galaxie, 101, 200 ) ;
            if ( backgroundWorkerExportation.CancellationPending ) return ;
            progressionTotale = (int)(progressionTotale + progression) ;
            backgroundWorkerExportation.ReportProgress(progressionTotale) ;

            exporteLesPlanetesDeLaGalaxieDansLaPlageSpecifiee( galaxie, 201, 300 ) ;
            if ( backgroundWorkerExportation.CancellationPending ) return ;
            progressionTotale = (int)(progressionTotale + progression) ;
            backgroundWorkerExportation.ReportProgress(progressionTotale) ;

            exporteLesPlanetesDeLaGalaxieDansLaPlageSpecifiee( galaxie, 301, 400 ) ;
            if ( backgroundWorkerExportation.CancellationPending ) return ;
            progressionTotale = (int)(progressionTotale + progression) ;
            backgroundWorkerExportation.ReportProgress(progressionTotale) ;

            exporteLesPlanetesDeLaGalaxieDansLaPlageSpecifiee( galaxie, 401, 499 ) ;
            if ( backgroundWorkerExportation.CancellationPending ) return ;
            progressionTotale = (int)(progressionTotale + progression) ;
            backgroundWorkerExportation.ReportProgress(progressionTotale) ;
        }

        private void backgroundWorkerExportation_DoWork( object sender, DoWorkEventArgs e )
        {
            try
            {
                progression = 20.0f/fp.nombreDeGalaxiesSelectionnees() ;
                progressionTotale = 0 ;
                for ( int g = 1 ; g <= Ogame.Valeurs.maxGalaxie ; ++g )
                {
                    if ( fp.galaxieEstSelectionnee( g ) )
                    {
                        exporteLesPlanetesDeLaGalaxie(g) ;
                        if ( backgroundWorkerExportation.CancellationPending ) return ;
                    }
                }
            }
            catch ( Exception ex )
            {
                MessageBox.Show("Echec de l'exportation : " + ex.Message) ;
            }
        }

        #endregion

        private void backgroundWorkerExportation_ProgressChanged( object sender, ProgressChangedEventArgs e )
        {
            progressBarAvancementSimulations.Value = e.ProgressPercentage ;
        }

        private void backgroundWorkerExportation_RunWorkerCompleted( object sender, RunWorkerCompletedEventArgs e )
        {
            fp.AnalysePressePapier = true ;
            fp.miseAJourAffichageUnivers() ;
            fp.resultatDExportation = resultat ;
            Close() ;
        }

        private void buttonAnnulerSimulations_Click( object sender, EventArgs e )
        {
            backgroundWorkerExportation.CancelAsync() ;
            buttonAnnulerSimulations.Text = "Annulé" ;
            buttonAnnulerSimulations.Enabled = false ;
        }

    }
}