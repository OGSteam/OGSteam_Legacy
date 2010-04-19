using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Diagnostics ;

namespace OgameFarmingInterface
{
    public partial class FormAPropos : Form
    {
        private DateTime DateCompiled()
        {
           System.Version v = System.Reflection.Assembly.GetExecutingAssembly().GetName().Version;
         
           // v.Build is days since Jan. 1, 2000
           // v.Revision*2 is seconds since local midnight
           // (NEVER daylight saving time)
         
           DateTime t = new DateTime( v.Build * TimeSpan.TicksPerDay + v.Revision * TimeSpan.TicksPerSecond * 2 ).AddYears(1999).AddDays(-1);
         
           return t;
        }

        public FormAPropos()
        {
            InitializeComponent() ;
#if !PINGOUIN
            labelVersion.Text = "WIL version (NE PAS DIFFUSER)" ;
#else
            labelVersion.Text = "Publique, "+Ogame.Valeurs.maxGalaxie+":"+Ogame.Valeurs.maxSysteme+":"+Ogame.Valeurs.maxPlanete ;
#endif
            labelDateCompilation.Text += DateCompiled().ToShortDateString() + "-" + DateCompiled().ToShortTimeString() ;
        }

        private void button1_Click(object sender, EventArgs e)
        {
            Close() ;
        }

        private void linkLabel1_LinkClicked( object sender, LinkLabelLinkClickedEventArgs e )
        {
            ProcessStartInfo psi = new ProcessStartInfo("http://mackila.com/phpBB2") ;
            Process.Start( psi ) ;
        }
    }
}