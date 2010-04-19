using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Diagnostics;
using System.Runtime.InteropServices;
using System.IO;

/*
Declare Function GetTempPath Lib "kernel32" Alias "GetTempPathA" (ByVal nBufferLength As Long, ByVal lpBuffer As String) As Long

Public Const MAX_PATH = 260

Public Function RecupCheminTemp()
    Dim RepertoireStr As String
    Dim ResltatLng As Long

    RepertoireStr = String(MAX_PATH, 0)
    ResltatLng = GetTempPath(MAX_PATH, RepertoireStr)

    If ResltatLng <> 0 Then
        RecupCheminTemp = Left(RepertoireStr, InStr(RepertoireStr, Chr(0)) - 1)
    Else
        RecupCheminTemp = ""
    End If
End Function

' Puis utilisez ce code dans un Bouton_Click par exemple :

Call MsgBox("Le Chemin du répertoire Temporaire est : " & RecupCheminTemp, vbInformation)
*/
namespace Updater
{
    public partial class Form1 : Form
    {
        private String URL_version = "" ;
        private String URL_install = "" ;
        private int version_courante = 0 ;
        private String nom_installeur = "" ;

        public Form1(String[] args)
        {
            InitializeComponent() ;
            if ( args.Length != 3 )
            {
                Close() ;
            }
            else
            {
                URL_version = args[0] ;
                version_courante = Convert.ToInt32(args[1]) ;
                URL_install = args[2] ;
                int version_serveur = Convert.ToInt32(webClient1.DownloadString(URL_version)) ;
                if ( version_serveur > version_courante )
                {
                    nom_installeur = Path.GetTempPath() + "install_v" + version_serveur + ".exe" ;
                    webClient1.DownloadFileAsync(new Uri(URL_install), nom_installeur ) ;
                }
            }
        }

        private void webClient1_DownloadProgressChanged( object sender, System.Net.DownloadProgressChangedEventArgs e )
        {
            progressBar1.Value = e.ProgressPercentage ;
        }

        private void webClient1_DownloadFileCompleted( object sender, AsyncCompletedEventArgs e )
        {
            ProcessStartInfo startInfo = new ProcessStartInfo() ;
            startInfo.FileName = nom_installeur ;
            startInfo.Arguments = "/silent" ;
            Process p = Process.Start( startInfo ) ;
            Close() ;
        }
    }
}