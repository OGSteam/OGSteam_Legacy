Imports System.Windows.Forms
Imports System.IO

Public Class editeur
    'On défini les objets qui nous permettrons d'ouvrir les diférents forms
    Dim Frmecho As New Frm_Alerte()
    Dim frm_Nouveauprojet As New frm_Nouveauprojet()
    Dim frm_Licence As New frm_Licence()
    Dim frm_Contributeur As New frm_Contributeur()
    Dim frm_Historique As New frm_Historique()

    'on défini l'objet qui permet d'ouvrir la boite de rechercher de fichier
    Dim OpenFileDialog As New OpenFileDialog

    'on inicialise l'objet folder browser dialogue
    Dim fB As New FolderBrowserDialog

    'on inicialise les variables
    Dim FileName As String
    Dim Filepath As String

    Private Sub ToolStripMenuItem1_Click_1(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripMenuItem1.Click
        frm_Nouveauprojet.ShowDialog()
    End Sub

    Private Sub LicenceToolStripMenuItem_Click_1(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles LicenceToolStripMenuItem.Click
        frm_Licence.ShowDialog()
    End Sub

    Private Sub OuvrirToolStripMenuItem_Click_1(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles OuvrirToolStripMenuItem.Click
        fB.RootFolder = Environment.SpecialFolder.MyDocuments

        fB.Description = "Sélectionnez un projet"

        fB.ShowDialog()

        If Not fB.SelectedPath = String.Empty Then

            Filepath = fB.SelectedPath

            'On ouvre le projet maintenant
            'à venir :p

        End If

        fB.Dispose()
    End Sub

    Private Sub QuiterToolStripMenuItem_Click_1(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles QuiterToolStripMenuItem.Click
        'Quitter l'application
        Global.System.Windows.Forms.Application.Exit()
    End Sub

    Private Sub AuteurcontirbuateurToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles AuteurcontirbuateurToolStripMenuItem.Click
        frm_Contributeur.ShowDialog()
    End Sub

    Private Sub HistoriqueToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles HistoriqueToolStripMenuItem.Click
        frm_Historique.ShowDialog()
    End Sub
End Class