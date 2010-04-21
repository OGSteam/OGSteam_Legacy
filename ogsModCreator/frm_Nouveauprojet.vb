Imports System.IO
Public Class frm_Nouveauprojet
    'on incialise les diférent objet qu'il y aura dans ce form
    Dim fB As New FolderBrowserDialog
    Dim continuer As New Boolean
    Dim resultat As MsgBoxResult
    Dim FS As FileStream
    Dim SW As StreamWriter


    Private Sub frm_Nouveauprojet_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        txt_Chemin.Text = My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\OGS_modcreator\projets\"
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click

        fB.RootFolder = Environment.SpecialFolder.Desktop

        fB.Description = "Sélectionnez un répertoire"

        fB.ShowDialog()

        If Not fB.SelectedPath = String.Empty Then

            txt_Chemin.Text = fB.SelectedPath

        End If

        fB.Dispose()
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click

        'on met la valeur 1 a continuer pour que plus tard il puissent le mettre a 0 pour arêter les vérification
        continuer = True

        'on vérifie qu'il a remplis le champ pour le répèrtoire
        If (String.IsNullOrEmpty(txt_Chemin.Text) And continuer) Then
            MsgBox("Vous devez choisir un répèrtoire")
            continuer = False
        End If

        'on vérii qu'il a remplis le champ pour le nom du projet
        If (String.IsNullOrEmpty(txt_Nommod.Text) And continuer) Then
            MsgBox("Vous devez nomer le projet")
            continuer = False
        End If

        'on vérifi si le répère toir choisi existe
        If (Directory.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text) And continuer) Then
            resultat = MessageBox.Show("Le répèrtoire choisie existe déja. Voulez vous continuer?", "Alerte", MessageBoxButtons.YesNo, MessageBoxIcon.Exclamation)
            If (resultat = MsgBoxResult.No) Then
                continuer = False
            End If
        End If

        'on vérifi si la vérification précédente
        If (continuer) Then
            'on vérifi qu'il y a pas déja les dociers d'un projet à l'endroit indiquer.
            If ( _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/index.php") Or _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/entete.php") Or _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/pied_de_page.php") Or _
 _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/acceuil.php") Or _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/historique.php") Or _
 _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/install.php") Or _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/update.php") Or _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/uninstall.php") Or _
 _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/info.txt") Or _
            File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/version.txt") _
            ) Then
                resultat = MessageBox.Show("Il y a déja des fichiers d'un mod dans ce répèrtoire, si vous continuer ils seront écraser. souhaitez vous continuer?", "Alerte", MessageBoxButtons.YesNo, MessageBoxIcon.Exclamation)
                If (resultat = MsgBoxResult.Yes) Then
                    'Si l'utilisateur veut procéder a l'écrasemant on effasse les fichier si ils existe
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/index.php")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/index.php")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/entête.php")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/entête.php")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/pied_de_page.php")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/pied_de_page.php")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/acceuil.php")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/acceuil.php")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/historique.php")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/historique.php")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/install.php")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/install.php")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/update.php")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/update.php")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/uninstall.php")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/uninstall.php")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/info.txt")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/info.txt")
                    End If
                    If (File.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text + "/version.txt")) Then
                        File.Delete(txt_Chemin.Text + "\" + txt_Nommod.Text + "/version.txt")
                    End If
                Else
                    continuer = False
                End If
            End If
        End If
        'si Tout est corecte on va commencer à écrire les fichiers Wouhou! party! on y est finalemant!!!
        If (continuer) Then
            'si le docier choisis existe pas, on peut le créé maintenant
            If Not (Directory.Exists(txt_Chemin.Text + "\" + txt_Nommod.Text)) Then
                Directory.CreateDirectory(txt_Chemin.Text + "\" + txt_Nommod.Text)
            End If
            'On créé maintenant les fichiers.
            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/index.php")
            FS.Close()
            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/entete.php")
            FS.Close()
            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/pied_de_page.php")
            FS.Close()

            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/acceuil.php")
            FS.Close()
            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/historique.php")
            FS.Close()

            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/install.php")
            FS.Close()
            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/update.php")
            FS.Close()
            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/uninstall.php")
            FS.Close()

            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/info.txt")
            FS.Close()
            FS = File.Create(txt_Chemin.Text + "\" + txt_Nommod.Text + "/version.txt")
            FS.Close()

            'maintenant on remplis les fichier celon ce qu'il devrais avoir à l'intérieur.

            'Index
            'on défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/index.php") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine("<?php")
            SW.WriteLine("/***********************************************************************")
            SW.WriteLine("* filename	:	index.php")
            SW.WriteLine("* desc.	    :	Fichier principal")
            SW.WriteLine("* package     :	" + txt_Nommod.Text)
            SW.WriteLine("* created	    : 	06/11/2006 ")
            SW.WriteLine(" * *********************************************************************/")
            SW.WriteLine("//On interdis les appels directe")
            SW.WriteLine("if (!defined('IN_SPYOGAME')) die('Hacking attempt');")
            SW.WriteLine()
            SW.WriteLine("//ici on indique le choix des pages")
            SW.WriteLine("switch ($pub_page){")
            SW.WriteLine()
            SW.WriteLine("  case 'accueil':")
            SW.WriteLine("  require_once('accueil.php');")
            SW.WriteLine("  break;")
            SW.WriteLine()
            SW.WriteLine("  case 'historique':")
            SW.WriteLine("  require_once('historique.php');")
            SW.WriteLine("  break;")
            SW.WriteLine()
            SW.WriteLine("  default:")
            SW.WriteLine("  require_once('accueil.php');")
            SW.WriteLine("  break;")
            SW.WriteLine("?>")
            SW.Close()

            'entete
            'on défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/entete.php") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine("<?php")
            SW.WriteLine("/***********************************************************************")
            SW.WriteLine("* filename	:	entete.php")
            SW.WriteLine("* desc.	    :	Entete des pages")
            SW.WriteLine("* package     :	" + txt_Nommod.Text)
            SW.WriteLine("* created	    : 	06/11/2006 ")
            SW.WriteLine(" * *********************************************************************/")
            SW.WriteLine("//On interdis les appels directe")
            SW.WriteLine("if (!defined('IN_SPYOGAME')) die('Hacking attempt');")
            SW.WriteLine()
            SW.WriteLine("echo '<table width=\'100%\'>';")
            SW.WriteLine("echo '<tr>';")
            SW.WriteLine("echo '<td>';")
            SW.WriteLine()
            SW.WriteLine("// Début du menu")
            SW.WriteLine("//acceuil")
            SW.WriteLine("if ($pub_page != 'accueil' And (isset($pub_page))) {")
            SW.WriteLine("  echo '\t\t\t'.'<td class=\'c\' width=\'150\' onclick=\'window.location = \'index.php?action=" + txt_Nommod.Text + "&page=accueil\';\'>';")
            SW.WriteLine("  echo '<a style=\'cursor:pointer\'><font color=\'lime\'>Acceuil</font></a>';")
            SW.WriteLine("  echo '</td>'.'\n';")
            SW.WriteLine("}")
            SW.WriteLine("else {")
            SW.WriteLine("  echo '\t\t\t'.'<th width=\'150\'>';")
            SW.WriteLine("  echo '<a>Acceuil</a>';")
            SW.WriteLine("  echo '</th>'.'\n';")
            SW.WriteLine("}")
            SW.WriteLine()
            SW.WriteLine("// historique")
            SW.WriteLine("if ($pub_page != 'historique' And (isset($pub_page))) {")
            SW.WriteLine("  echo '\t\t\t'.'<td class=\'c\' width=\'150\' onclick=\'window.location = \'index.php?action=" + txt_Nommod.Text + "&page=historique\';\'>';")
            SW.WriteLine("  echo '<a style=\'cursor:pointer\'><font color=\'lime\'>Historique</font></a>';")
            SW.WriteLine("  echo '</td>'.'\n';")
            SW.WriteLine("}")
            SW.WriteLine("else {")
            SW.WriteLine("  echo '\t\t\t'.'<th width=\'150\'>';")
            SW.WriteLine("  echo '<a>Historique</a>';")
            SW.WriteLine("  echo '</th>'.'\n';")
            SW.WriteLine("}")
            SW.WriteLine("echo '</td>';")
            SW.WriteLine("echo '</tr>';")
            SW.WriteLine("echo '<tr>';")
            SW.WriteLine("echo '<td>';")
            SW.WriteLine("?>")
            SW.Close()

            'Pied de page
            'on défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/pied_de_page.php") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine("<?php")
            SW.WriteLine("/***********************************************************************")
            SW.WriteLine("* filename	:	pied_de_page.php")
            SW.WriteLine("* desc.	    :	pied des pages")
            SW.WriteLine("* package     :	" + txt_Nommod.Text)
            SW.WriteLine("* created	    : 	06/11/2006 ")
            SW.WriteLine(" * *********************************************************************/")
            SW.WriteLine("//On interdis les appels directe")
            SW.WriteLine("if (!defined('IN_SPYOGAME')) die('Hacking attempt');")
            SW.WriteLine()
            SW.WriteLine("echo '</td>';")
            SW.WriteLine("echo '</tr>';")
            SW.WriteLine("echo '<tr>';")
            SW.WriteLine("echo '<td>';")
            SW.WriteLine("echo '<p align=\'center\'><a href="">'.$mod.'</a> | Version '.$version.' | auteur | 2006</p>';")
            SW.WriteLine("echo '</td>';")
            SW.WriteLine("echo '</tr>';")
            SW.WriteLine("echo '</table>';")
            SW.WriteLine("?>")
            SW.Close()

            'acceuil
            'on défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/acceuil.php") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine("<?php")
            SW.WriteLine("/***********************************************************************")
            SW.WriteLine("* filename	:	acceuil.php")
            SW.WriteLine("* desc.	    :	page d'acceuil")
            SW.WriteLine("* package     :	" + txt_Nommod.Text)
            SW.WriteLine("* created	    : 	06/11/2006 ")
            SW.WriteLine(" * *********************************************************************/")
            SW.WriteLine("//On interdis les appels directe")
            SW.WriteLine("if (!defined('IN_SPYOGAME')) die('Hacking attempt');")
            SW.WriteLine("require_once('entete.php');")
            SW.WriteLine()
            SW.WriteLine("//code de la page d'acceuil ici")
            SW.WriteLine()
            SW.WriteLine("require_once('pied_de_page.php');")
            SW.WriteLine("?>")
            SW.Close()

            'historique
            'on défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/historique.php") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine("<?php")
            SW.WriteLine("/***********************************************************************")
            SW.WriteLine("* filename	:	historique.php")
            SW.WriteLine("* desc.	    :	historique des versions")
            SW.WriteLine("* package     :	" + txt_Nommod.Text)
            SW.WriteLine("* created	    : 	06/11/2006 ")
            SW.WriteLine(" * *********************************************************************/")
            SW.WriteLine("//On interdis les appels directe")
            SW.WriteLine("if (!defined('IN_SPYOGAME')) die('Hacking attempt');")
            SW.WriteLine("require_once('entete.php');")
            SW.WriteLine()
            SW.WriteLine("echo'<table>';")
            SW.WriteLine("echo'<th colspan=\'2\'>Historique</th>';")
            SW.WriteLine("echo'<th>Version</th><th>Modification</th>';")
            SW.WriteLine()
            SW.WriteLine("//version 0.1 ")
            SW.WriteLine("echo'<tr><th><font color=\'#FF0000\'>0.1</font></th>';")
            SW.WriteLine("echo'<th>';")
            SW.WriteLine("echo'<p style=\'margin-top: 0; margin-bottom: 0\'>-Sortie du Convertisseur de ressources</p>';")
            SW.WriteLine("echo'</th>';")
            SW.WriteLine("echo'</tr>';")
            SW.WriteLine()
            SW.WriteLine("echo'</table>';")
            SW.WriteLine("")
            SW.WriteLine("")
            SW.WriteLine()
            SW.WriteLine("require_once('pied_de_page.php');")
            SW.WriteLine("?>")
            SW.Close()

            'install
            'on défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/install.php") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine("<?php")
            SW.WriteLine("/***********************************************************************")
            SW.WriteLine("* filename	:	install.php")
            SW.WriteLine("* desc.	    :	page d'instalation")
            SW.WriteLine("* package     :	" + txt_Nommod.Text)
            SW.WriteLine("* created	    : 	06/11/2006 ")
            SW.WriteLine(" * *********************************************************************/")
            SW.WriteLine("//On interdis les appels directe")
            SW.WriteLine("if (!defined('IN_SPYOGAME')) die('Hacking attempt');")
            SW.WriteLine()
            SW.WriteLine("global $db;")
            SW.WriteLine()
            SW.WriteLine("// insertion du mod (numéro de version automatique)")
            SW.WriteLine()
            SW.WriteLine("if (file_exists('mod/" + txt_Nommod.Text + "/version.txt')) {")
            SW.WriteLine("  $version_txt = file('mod/" + txt_Nommod.Text + "/version.txt');")
            SW.WriteLine()
            SW.WriteLine("  $query = 'INSERT INTO '.TABLE_MOD.' (id, title, menu, action, root, link, version, active) ';")
            SW.WriteLine("  $query.= 'VALUES \'\', \'" + txt_Nommod.Text + "\', \'" + txt_Nommod.Text + "\', \'" + txt_Nommod.Text + "\', ';")
            SW.WriteLine("  $query.= '\'" + txt_Nommod.Text + "\', \'index.php\', \''.trim($version_txt[1]).'\', \'1\'';")
            SW.WriteLine("  $db->sql_query($query);")
            SW.WriteLine("}")
            SW.WriteLine()
            SW.WriteLine()
            SW.WriteLine("?>")
            SW.Close()

            'update
            'on défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/update.php") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine("<?php")
            SW.WriteLine("/***********************************************************************")
            SW.WriteLine("* filename	:	update.php")
            SW.WriteLine("* desc.	    :	page  de mise a jours du mod")
            SW.WriteLine("* package     :	" + txt_Nommod.Text)
            SW.WriteLine("* created	    : 	06/11/2006 ")
            SW.WriteLine(" * *********************************************************************/")
            SW.WriteLine("//On interdis les appels directe")
            SW.WriteLine("if (!defined('IN_SPYOGAME')) die('Hacking attempt');")
            SW.WriteLine()
            SW.WriteLine("?>")
            SW.Close()

            'uninstall
            'on défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/uninstall.php") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine("<?php")
            SW.WriteLine("/***********************************************************************")
            SW.WriteLine("* filename	:	uninstall.php")
            SW.WriteLine("* desc.	    :	pages de désinstalation")
            SW.WriteLine("* package     :	" + txt_Nommod.Text)
            SW.WriteLine("* created	    : 	06/11/2006 ")
            SW.WriteLine(" * *********************************************************************/")
            SW.WriteLine("//On interdis les appels directe")
            SW.WriteLine("if (!defined('IN_SPYOGAME')) die('Hacking attempt');")
            SW.WriteLine()
            SW.WriteLine("?>")
            SW.Close()

            'Version
            'On défini l'objet pour écrire
            SW = File.AppendText(txt_Chemin.Text + "\" + txt_Nommod.Text + "/version.txt") ' crée ou si existe ajoute
            'on écrit :p
            SW.WriteLine(txt_Nommod.Text)
            SW.WriteLine("0.1")
            SW.Close()

            'On anonce que tout ces dérouler sans pépin et que le projet est créé
            MessageBox.Show("La création de projet a été un succet", "Bravo", MessageBoxButtons.OK, MessageBoxIcon.Information)
            'code pour ouvrir le projet nouvellemant créé

            'On ferme la page maintenant qu'on a terminer
            Me.Close()
        End If
    End Sub
End Class