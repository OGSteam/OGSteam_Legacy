using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using Ogame ;

namespace OgameFarmingInterface
{
    public partial class FormProgressionSimulationDeMasse : Form
    {
        private int nombreDeSimulations ;
        private FormPrincipale fp ;
        private ResultatsDeSimulationMassive rsm ;
        private bool modeSelection ;
        private Collection<int> indexASimuler ;

        public FormProgressionSimulationDeMasse(FormPrincipale formPrincipale,int nombreDeSimulations)
        {
            indexASimuler = new Collection<int>() ;
            modeSelection = false ;
            this.fp = formPrincipale ;
            this.nombreDeSimulations = nombreDeSimulations ;
            InitializeComponent() ;
            fp.AnalysePressePapier = false ;
            if ( fp.listViewResultats.SelectedIndices.Count > 1 )
            {
                modeSelection = true ;
                foreach ( int i in fp.listViewResultats.SelectedIndices )
                {
                    indexASimuler.Add(i) ;
                }
            }
            backgroundWorkerSimulationsEnMasse.RunWorkerAsync() ;
        }

        private void backgroundWorkerSimulationsEnMasse_DoWork(object sender, DoWorkEventArgs e)
        {
            try
            {
                rsm = new ResultatsDeSimulationMassive() ;
                RapportDEspionnage attaquant = new RapportDEspionnage() ;
                attaquant.Recherches = fp.TechnologieDeLaFlotteAttaquante ;
                attaquant.FlotteAQuai = fp.FlotteAttaquante ;
                attaquant.Coordonnees = fp.CoordonneesDeLaFlotteAttaquante() ;
                int i = 0 ;
                if ( modeSelection )
                {
                    foreach( int j in indexASimuler )
                    {
                        if ( backgroundWorkerSimulationsEnMasse.CancellationPending ) return ;
                        RapportDEspionnage defenseur = (RapportDEspionnage)fp.LesRapports[j] ;
                        Simulateur simu = new Simulateur( attaquant, defenseur ) ;
                        StatistiquesDeSimulation stats = simu.Simuler(nombreDeSimulations) ;
                        rsm[defenseur.Coordonnees] = stats ;
                        ++i ;
                        backgroundWorkerSimulationsEnMasse.ReportProgress( i * 100 / indexASimuler.Count ) ;
                    }
                }
                else
                {
                    foreach( RapportDEspionnage defenseur in fp.LesRapports )
                    {
                        if ( backgroundWorkerSimulationsEnMasse.CancellationPending ) return ;
                        Simulateur simu = new Simulateur( attaquant, defenseur ) ;
                        StatistiquesDeSimulation stats = simu.Simuler(nombreDeSimulations) ;
                        rsm[defenseur.Coordonnees] = stats ;
                        ++i ;
                        backgroundWorkerSimulationsEnMasse.ReportProgress( i * 100 / fp.LesRapports.Count ) ;
                    }
                }
            }
            catch ( Exception )
            {
            }
        }

        private void backgroundWorkerSimulationsEnMasse_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            progressBarAvancementSimulations.Value = e.ProgressPercentage ;
        }

        private void backgroundWorkerSimulationsEnMasse_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            fp.AnalysePressePapier = true ;
            FormPrincipale.resultatsDesSimulations = rsm ;
            Close() ;
        }

        private void buttonAnnulerSimulations_Click(object sender, EventArgs e)
        {
            backgroundWorkerSimulationsEnMasse.CancelAsync() ;
        }
    }
}