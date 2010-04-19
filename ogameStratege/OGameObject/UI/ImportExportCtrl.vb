''' <summary>
''' Controle UI de gestion de comptes OGspy avec fonctions
''' d'exportation et importation
''' </summary>
''' <remarks>
''' TODO: Annulation lors de l'importation
''' TODO: Exportation des statistiques joueurs
''' TODO: Implémentation des statistiques Alliances
''' </remarks>
Public Class ImportExportCtrl

#Region " Fonctions utilitaires relatif a l'activation et initialisation des controles "

    ''' <summary>
    ''' Grise ou enleve le grisé de tout les controles en une
    ''' seule fois du panneau de gestion des comptes
    ''' </summary>
    ''' <param name="newEnabled">Active Ou Desactive</param>
    ''' <remarks></remarks>
    Protected Sub EnableDisableControls(ByVal newEnabled As Boolean)
        tbAccountName.Enabled = newEnabled
        tbAccountPassword.Enabled = newEnabled
        tbChunkSize.Enabled = newEnabled
        tbFriendlyName.Enabled = newEnabled
        tbServerUrl.Enabled = newEnabled
        chkDefaultAccount.Enabled = newEnabled
        dtpLastExport.Enabled = newEnabled
        dtpLastImport.Enabled = newEnabled
    End Sub

    ''' <summary>
    ''' Initialisation lors du premier affichage
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub ImportExportCtrl_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        ReadAccounts()
        If Not SelectedAccount Is Nothing Then
            'OgameBrowserCtrl1.goUrl(SelectedAccount.OGSServerURL)
            tsButBrowserOgspy_Click(Nothing, Nothing)
        Else
            OgameBrowserCtrl1.goUrl("http://trac.ogsteam.fr/wiki/OGS/ImportExport")
        End If
    End Sub

    ''' <summary>
    ''' Selection/deselection de toutes les boite a cochés "Galaxies"
    ''' </summary>
    ''' <param name="selected"></param>
    ''' <remarks></remarks>
    Protected Sub SelectUnselectGalaxyChkBox(ByVal selected As Boolean)
        chkGal1.Checked = selected
        chkGal2.Checked = selected
        chkGal3.Checked = selected
        chkGal4.Checked = selected
        chkGal5.Checked = selected
        chkGal6.Checked = selected
        chkGal7.Checked = selected
        chkGal8.Checked = selected
        chkGal9.Checked = selected
    End Sub

#End Region

#Region " Propriétés utilitaires "

    ''' <summary>
    ''' Raccourci pour l'univers selecttioné par défaut
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks>OGameDBEngine.Default.Universe</remarks>
    Protected ReadOnly Property UniverseDB() As UniverseDB
        Get
            Return OGameDBEngine.Default.Universe
        End Get
    End Property

    ''' <summary>
    ''' Compte sélectionné de la liste du Panneau de gestion des comptes
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Protected ReadOnly Property SelectedAccount() As RemoteAccount
        Get
            Return lbComptes.SelectedItem
        End Get
    End Property

    ''' <summary>
    '''  Renvoie le compte identique dans la list du panneau de gestion des comptes
    ''' </summary>
    ''' <param name="tempRemoteAccount"></param>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks>utilisé pour mettre a jour le compte en question en vue d'une sauvegarde</remarks>
    Public ReadOnly Property StoredRemoteAccount(ByVal tempRemoteAccount As RemoteAccount) As RemoteAccount
        Get
            For Each u As RemoteAccount In lbComptes.Items
                If u.FriendlyName = tempRemoteAccount.FriendlyName Then Return u
            Next
            Return Nothing
        End Get
    End Property

    ''' <summary>
    ''' Convertit les case a cocher des galaxies en chaines de caractères
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Private ReadOnly Property GalaxyChecked() As String
        Get
            Dim retval As New Text.StringBuilder
            If chkGal1.Checked Then retval.Append("1")
            If chkGal2.Checked Then retval.Append("2")
            If chkGal3.Checked Then retval.Append("3")
            If chkGal4.Checked Then retval.Append("4")
            If chkGal5.Checked Then retval.Append("5")
            If chkGal6.Checked Then retval.Append("6")
            If chkGal7.Checked Then retval.Append("7")
            If chkGal8.Checked Then retval.Append("8")
            If chkGal9.Checked Then retval.Append("9")
            Return retval.ToString
        End Get
    End Property

    ''' <summary>
    ''' Drapeau de demande d'arret d'action Export/Import
    ''' </summary>
    ''' <remarks></remarks>
    Private stopAction As Boolean = False

    ''' <summary>
    ''' le serveur OGSpy en cours , déclaré pour attraper
    ''' les evenements de la classe
    ''' </summary>
    ''' <remarks></remarks>
    Private WithEvents _ogspy As OGSpy

#End Region

#Region " Evenements Clicks des différents boutons "

    ''' <summary>
    ''' Sauvegarde des comptes
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsbSaveComptes_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsbSaveComptes.Click
        If SelectedAccount Is Nothing Then Return
        With SelectedAccount
            .DefaultAccount = chkDefaultAccount.Checked
            .FriendlyName = tbFriendlyName.Text
            .LastSendedInfo = dtpLastExport.Value
            .LastUpdatedInfo = dtpLastImport.Value
            .LoginName = tbAccountName.Text
            .MaxPlanetCountChunk = tbChunkSize.Text
            .OGSServerURL = tbServerUrl.Text
            .Password = tbAccountPassword.Text
            lbComptes.Refresh()

        End With
        SaveAccounts()
        tsbSaveComptes.Enabled = False
    End Sub

    ''' <summary>
    ''' Ajout d'un nouveau compte via le formulaire
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsButAddCompte_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsButAddCompte.Click
        Dim o As New OGameObject.RemoteAccount
        o.FriendlyName = "Nouveau Compte Alliance"
        UniverseDB.RemoteAccounts.Add(o)
        lbComptes.Items.Add(o)
        lbComptes.SelectedItem = o
    End Sub

    ''' <summary>
    ''' Test un compte en affichant le formulaire d'information OGSPY
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsButTestCompte_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsButTestCompte.Click
        Dim o As New OGSpy
        o.Login(SelectedAccount.OGSServerURL, SelectedAccount.LoginName, SelectedAccount.Password)
        Dim u As New OGSpyInfoForm
        u.Info = o.Info
        u.ShowDialog()
    End Sub

    ''' <summary>
    ''' Suppression du compte selectionné dans la liste du panneau de gestion des comptes
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsButRemoveCompte_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsButRemoveCompte.Click
        If SelectedAccount Is Nothing Then
            Console.WriteLine("Suppression de compte OGSPY impossible: Aucun n'est selectionné")
            Exit Sub
        End If
        lbComptes.Items.Remove(lbComptes.SelectedItem)
        SaveAccounts()
    End Sub

    ''' <summary>
    ''' Annullation de l'action d'exportation/importation en cours
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsButCancel_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsButCancel.Click
        stopAction = True
    End Sub

    ''' <summary>
    ''' Lecture des statistiques OGS connus
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub btnRefreshStatsOGS_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnRefreshStatsOGS.Click
        Me.UseWaitCursor = True
        lbStatistiquesOGS.DataSource = OGameObject.OGameDBEngine.Default.StatisticsDate
        lbStatistiquesOGS.DisplayMember = "DATADATE"
        Me.UseWaitCursor = False
    End Sub

    ''' <summary>
    ''' Telechargement du listing des Statistiques Joueurs connu
    ''' par le serveur OGSPY
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub btnLoadStatOGSpy_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnLoadStatOGSpy.Click
        If tscbComptes.SelectedItem Is Nothing Then Return

        Me.UseWaitCursor = True
        lbStatistiquesOGSpy.Items.Clear()

        Dim o As New OGSpy
        o.Login(tscbComptes.SelectedItem)


        For Each u As Object In o.GetStatsAvailable
            lbStatistiquesOGSpy.Items.Add(u)
        Next

        Me.UseWaitCursor = False
    End Sub

    Private Shared Function StrToByteArray(ByVal str As String) As Byte()
        Dim encoding As New System.Text.ASCIIEncoding
        Return encoding.GetBytes(str)
    End Function 'StrToByteArray

    ''' <summary>
    ''' Lancement d'un browser internes sur l'adresse du serveur
    ''' ogspy selectionné
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsButBrowserOgspy_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsButBrowserOgspy.Click
        'System.Diagnostics.Process.Start(CType(tscbComptes.SelectedItem, RemoteAccount).OGSServerURL)
        Try

        
            If SelectedAccount Is Nothing Then Return
            OgameBrowserCtrl1.tscbURL.Text = SelectedAccount.OGSServerURL
            Dim postdata As String
            postdata = "action=login_web&goto=&login=" & SelectedAccount.LoginName & "&password=" & SelectedAccount.Password
            OgameBrowserCtrl1.WebBrowser1.Navigate(SelectedAccount.OGSServerURL, "", StrToByteArray(postdata), "Content-Type: application/x-www-form-urlencoded")
            tcImportExport.SelectedTab = tpBrowser
            OgameBrowserCtrl1.WebBrowser1.Focus()
        Catch ex As Exception
            ShowException(ex)
        End Try
    End Sub

    ''' <summary>
    ''' Selection de toutes la galaxies
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub btnSelectAllGalaxy_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSelectAllGalaxy.Click
        SelectUnselectGalaxyChkBox(True)
    End Sub

    ''' <summary>
    ''' Deselection de toutes les galaxies
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub btnUnselectAllGalaxy_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnUnselectAllGalaxy.Click
        SelectUnselectGalaxyChkBox(False)
    End Sub

    ''' <summary>
    ''' Evenement Importation des données du serveur ogspy
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks>multithreaded</remarks>
    Private Sub tsButImport_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsButImport.Click
        Dim impdata As New ThreadedImportData
        impdata.RemoteAcc = tscbComptes.SelectedItem
        If chkImportAll.Checked Then
            impdata.DateToImport = New Date(2005, 1, 1)
        Else
            impdata.DateToImport = dtpLastImport2.Value
        End If
        impdata.ImportSpy = chkImportSpyReport.Checked
        If chkImportAll.Checked Then
            impdata.galaxytoimport = "123456789"
        Else
            impdata.galaxytoimport = GalaxyChecked
        End If

        System.Threading.ThreadPool.QueueUserWorkItem(AddressOf Me.doimportFromServer, impdata)
    End Sub

    ''' <summary>
    ''' Evenement Exportation des données vers le serveur ogspy
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsButExport_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsButExport.Click
        Me.UseWaitCursor = True
        _ogspy = New OGSpy(tscbComptes.SelectedItem)
        AddHandler _ogspy.ExportedPlanet, AddressOf Me.exportedplanet
        Dim ted As New ThreadedExportData
        ted.exportplanets = chkExportPlanets.Checked
        ted.exportspy = chkExportSpyReport.Checked
        ted.sincedate = dtpLastExport2.Value
        If chkGal1.Checked Then ted.Galaxies &= "1"
        If chkGal2.Checked Then ted.Galaxies &= "2"
        If chkGal3.Checked Then ted.Galaxies &= "3"
        If chkGal4.Checked Then ted.Galaxies &= "4"
        If chkGal5.Checked Then ted.Galaxies &= "5"
        If chkGal6.Checked Then ted.Galaxies &= "6"
        If chkGal7.Checked Then ted.Galaxies &= "7"
        If chkGal8.Checked Then ted.Galaxies &= "8"
        If chkGal9.Checked Then ted.Galaxies &= "9"
        System.Threading.ThreadPool.QueueUserWorkItem(AddressOf Me.doExportToServer, ted)

    End Sub

    ''' <summary>
    ''' Importation des statistiques joueurs du serveur OGSPY
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub btnImportOGSpyStat_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnImportOGSpyStat.Click
        Me.UseWaitCursor = True
        PreparControlsForExportImport(True)
        unthreadedStatInfo = lbStatistiquesOGSpy.SelectedItem
        BackgroundWorker1.RunWorkerAsync(New OGSpy(tscbComptes.SelectedItem))
    End Sub

    Private unthreadedStatInfo As OGSpyStat

#End Region
    Private Sub BackgroundWorker1_DoWork(ByVal sender As Object, ByVal e As System.ComponentModel.DoWorkEventArgs) Handles BackgroundWorker1.DoWork
        _ogspy = e.Argument
        ''dim 
        AddLog("-> Importation des statistiques <-")
        AddLog("Importation des statistiques Flotte du " & unthreadedStatInfo.Date)
        _ogspy.ImportStatsAndInsert(unthreadedStatInfo.Date, "flotte")
        AddLog("Importation des statistiques Flotte fini")
        AddLog("Importation des statistiques Recherche du " & unthreadedStatInfo.Date)
        _ogspy.ImportStatsAndInsert(unthreadedStatInfo.Date, "research")
        AddLog("Importation des statistiques Recherche fini")
        AddLog("Importation des statistiques Points du " & unthreadedStatInfo.Date)
        _ogspy.ImportStatsAndInsert(unthreadedStatInfo.Date, "points")
        AddLog("Importation des statistiques Recherche fini")
        AddLog("-> Importation des statistiques fini <-")
    End Sub

    Private Sub BackgroundWorker_RunWorkerCompleted(ByVal sender As Object, ByVal e As System.ComponentModel.RunWorkerCompletedEventArgs) Handles BackgroundWorker1.RunWorkerCompleted, BackgroundWorker2.RunWorkerCompleted
        Me.UseWaitCursor = False
        PreparControlsForExportImport(False)
        btnRefreshStatsOGS_Click(Nothing, Nothing)
    End Sub

#Region " Evénements UI du controle "
    ''' <summary>
    ''' Mise a jour du compte edité
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub AccountInfo_Controls__Validated(ByVal sender As Object, ByVal e As System.EventArgs) _
     Handles tbFriendlyName.Validated, tbAccountName.Validated, tbAccountPassword.Validated, _
             tbChunkSize.Validated, tbServerUrl.Validated, chkDefaultAccount.Validated, _
             dtpLastExport.Validated, dtpLastImport.Validated

        If SelectedAccount Is Nothing Then Return

        With SelectedAccount
            .DefaultAccount = chkDefaultAccount.Checked
            .FriendlyName = tbFriendlyName.Text
            .LastSendedInfo = dtpLastExport.Value
            .LastUpdatedInfo = dtpLastImport.Value
            .LoginName = tbAccountName.Text
            .MaxPlanetCountChunk = tbChunkSize.Text
            .OGSServerURL = tbServerUrl.Text
            .Password = tbAccountPassword.Text
            lbComptes.Refresh()
            tsbSaveComptes.Enabled = True
        End With
    End Sub

    ''' <summary>
    ''' Réaction au changement de compte selectionné
    ''' dans la liste du panneau de gestion des comptes
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub lbComptes_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbComptes.SelectedIndexChanged
        tsbCopyCompte.Enabled = SelectedAccount IsNot Nothing
        tsButRemoveCompte.Enabled = SelectedAccount IsNot Nothing
        tsButTestCompte.Enabled = SelectedAccount IsNot Nothing
        EnableDisableControls(SelectedAccount IsNot Nothing)
        tscbComptes.SelectedItem = SelectedAccount
        If SelectedAccount Is Nothing Then Return

        EnableDisableControls(True)

        With SelectedAccount
            chkDefaultAccount.Checked = .DefaultAccount
            tbFriendlyName.Text = .FriendlyName
            dtpLastExport.Value = .LastSendedInfo
            dtpLastImport.Value = .LastUpdatedInfo
            tbAccountName.Text = .LoginName
            tbChunkSize.Text = .MaxPlanetCountChunk
            tbServerUrl.Text = .OGSServerURL
            tbAccountPassword.Text = .Password
        End With
    End Sub

    ''' <summary>
    ''' Des/activation de la date lors du cochage de 'Tout Exporter'
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub chkExportAll_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkExportAll.CheckedChanged
        dtpLastExport2.Enabled = Not chkExportAll.Checked
    End Sub

    ''' <summary>
    ''' Des/activation de la date lors du cochage de 'Tout importer'
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub chkImportAll_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkImportAll.CheckedChanged
        dtpLastImport2.Enabled = Not chkImportAll.Checked
    End Sub


    ''' <summary>
    ''' Action du menu "Selectionner toutes les galaxies"
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsmiSelectAllGalaxy_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles tsmiSelectAllGalaxy.Click
        SelectUnselectGalaxyChkBox(True)
    End Sub

    ''' <summary>
    ''' Action du menu "DeSelectionner toutes les galaxies"
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tsmiUnselectAllGalaxy_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles tsmiUnselectAllGalaxy.Click
        SelectUnselectGalaxyChkBox(False)
    End Sub

    ''' <summary>
    ''' Evenement aprés Selection d'une statistiques dans la liste des
    ''' statistiques joueurs ogspy
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub lbStatistiquesOGSpy_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbStatistiquesOGSpy.SelectedIndexChanged
        btnImportOGSpyStat.Enabled = lbStatistiquesOGSpy.SelectedItems.Count > 0
    End Sub

    ''' <summary>
    ''' Evenement aprés Selection d'une statistiques dans la liste des
    ''' statistiques joueurs OGS
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub lbStatistiquesOGS_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbStatistiquesOGS.SelectedIndexChanged
        btnExportStatsToOGSpy.Enabled = lbStatistiquesOGS.SelectedItems.Count > 0
    End Sub

    ''' <summary>
    ''' Changement de Selection du compte dans la liste du panneau
    ''' Export/Import
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub tscbComptes_SelectedIndexChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles tscbComptes.SelectedIndexChanged

        If tscbComptes.SelectedItem Is Nothing Then
            flpExport.Enabled = False
            flpImport.Enabled = False
            Return
        End If

        With CType(tscbComptes.SelectedItem, RemoteAccount)
            dtpLastExport2.Value = .LastSendedInfo
            dtpLastImport2.Value = .LastUpdatedInfo
            chkExportPlanets.Checked = .ExportPlanets
            chkImportPlanets.Checked = .ImportPlanets
            chkExportSpyReport.Checked = .ExportSpy
            chkImportSpyReport.Checked = .ImportSpy
            flpExport.Enabled = True
            flpImport.Enabled = True
        End With

    End Sub

#End Region

#Region " Fonction de gestion des comptes "
    ''' <summary>
    ''' Fonction delegate Sans arguments pour multithreading
    ''' </summary>
    ''' <remarks></remarks>
    Delegate Sub dlgSubNoArgs()

    ''' <summary>
    ''' Lecture des comptes stockés dans le fichier par defaut des comptes
    ''' </summary>
    ''' <remarks></remarks>
    Public Sub ReadAccounts()
        If Me.InvokeRequired Then
            Dim d As New dlgSubNoArgs(AddressOf Me.ReadAccounts)
            Me.Invoke(d)
            Exit Sub
        End If
        Dim u As OGameObject.UniversesDBCol = OGameObject.UniversesDBCol.XMLDeSerialize
        For Each uni As OGameObject.UniverseDB In u
            If uni.DBFileName = UniverseDB.DBFileName AndAlso uni.UniverseName = UniverseDB.UniverseName Then
                lbComptes.Items.Clear()
                tscbComptes.Items.Clear()
                For Each remacc As Object In uni.RemoteAccounts
                    lbComptes.Items.Add(remacc)
                    tscbComptes.Items.Add(remacc)
                    If remacc.DefaultAccount Then lbComptes.SelectedItem = remacc
                Next
            End If
        Next
    End Sub

    ''' <summary>
    ''' Sauvegarde des comptes de la liste du panneau de gestion de comptes
    ''' dans le fichier par defaut stocké sur le disque dur
    ''' </summary>
    ''' <remarks></remarks>
    Protected Sub SaveAccounts()
        If Me.InvokeRequired Then
            Dim d As New dlgSubNoArgs(AddressOf Me.SaveAccounts)
            Me.Invoke(d)
            Exit Sub
        End If
        Dim u As OGameObject.UniversesDBCol = OGameObject.UniversesDBCol.XMLDeSerialize
        If u Is Nothing Then Return
        For Each uni As OGameObject.UniverseDB In u
            If uni.DBFileName = UniverseDB.DBFileName AndAlso uni.UniverseName = UniverseDB.UniverseName Then
                uni.RemoteAccounts.Clear()
                For Each remacc As Object In lbComptes.Items
                    uni.RemoteAccounts.Add(remacc)
                Next

                lbComptes.Items.Clear()
                tscbComptes.Items.Clear()
                For Each remacc As Object In uni.RemoteAccounts
                    lbComptes.Items.Add(remacc)
                    tscbComptes.Items.Add(remacc)
                    If remacc.DefaultAccount Then lbComptes.SelectedItem = remacc
                Next
            End If
        Next
        u.XMLSerialize()
    End Sub

#End Region

#Region " Delegate pour acces inter-thread "


    Delegate Sub dlgPreparControlsForExportImport(ByVal PreparForAction As Boolean)
    Private Sub PreparControlsForExportImport(ByVal PreparForAction As Boolean)
        If Me.InvokeRequired Then
            Dim d As New dlgPreparControlsForExportImport(AddressOf PreparControlsForExportImport)
            Me.Invoke(d, New Object() {PreparForAction})
            Exit Sub
        End If
        tsButImport.Enabled = Not PreparForAction
        tsButExport.Enabled = Not PreparForAction
        tsButExportImport.Enabled = Not PreparForAction
        tsButCancel.Enabled = PreparForAction
        flpGalaxies.Enabled = Not PreparForAction
        flpExport.Enabled = Not PreparForAction
        flpImport.Enabled = Not PreparForAction
    End Sub

    Delegate Sub dlgAddLog(ByVal logtext As String)
    ''' <summary>
    ''' Ajoute un texte a rtbLogExportImport , thread-safe
    ''' </summary>
    ''' <param name="LogText">Le Texte à enregistrer</param>
    ''' <remarks></remarks>
    Protected Sub AddLog(ByVal LogText As String)
        If Me.rtbLogExportImport.InvokeRequired Then
            Dim d As New dlgAddLog(AddressOf Me.AddLog)
            Me.Invoke(d, New Object() {LogText})
            Exit Sub
        End If
        rtbLogExportImport.AppendText(LogText & vbCrLf)
        rtbLogExportImport.Select(rtbLogExportImport.TextLength - 1, 0)
        rtbLogExportImport.ScrollToCaret()
    End Sub


#End Region

#Region " Importation des données "
    ''' <summary>
    ''' structure utilisé pour passer les variables 
    ''' à la fonction de multithread d'importation
    ''' </summary>
    ''' <remarks></remarks>
    Protected Structure ThreadedImportData
        Dim galaxytoimport As String
        Dim DateToImport As Date
        Dim ImportSpy As Boolean
        Dim RemoteAcc As RemoteAccount
    End Structure
    Protected Sub doimportFromServer(ByVal state As Object)
        Try
            Dim impdata As ThreadedImportData = state
            UseWaitCursor = True
            PreparControlsForExportImport(True)
            Dim o As New OGSpy(impdata.RemoteAcc)
            AddLog("Importation des planètes de " & impdata.RemoteAcc.FriendlyName)
            AddLog("-> Galaxies: " & impdata.galaxytoimport)
            AddLog("-> depuis: " & impdata.DateToImport.ToString)
            For Each c As Char In impdata.galaxytoimport.ToCharArray
                If stopAction Then Exit For
                AddLog("---1- Importation de la galaxie " & c)
                Dim FirebirdImportFile As String = _
                    o.PreFormattedOGSpyImportFileContent(c, impdata.DateToImport)
                If stopAction Then Exit For
                AddLog("  -2- Création du fichier d'importation ")
                Dim u As New System.IO.StreamWriter(IO.Path.Combine(System.Windows.Forms.Application.StartupPath, "remote_imported.dat"), False)
                u.Write(FirebirdImportFile)
                u.Close()
                If stopAction Then Exit For
                AddLog("  -3- Insertion dans OGS")
                OGameObject.OGameDBEngine.Default.ImportFile2(IO.Path.Combine(System.Windows.Forms.Application.StartupPath, "remote_imported.dat"))
                AddLog(" --Resultat- " & OGameDBEngine.Default.LastImportResult.ToString)
            Next

            If impdata.ImportSpy Then
                AddLog("- Importation des rapports d'espionages")
                o.ImportReport(impdata.DateToImport)
            End If
            If Not stopAction Then
                impdata.RemoteAcc.LastUpdatedInfo = Now
                UniverseDB.UpdateAccountAndSave(impdata.RemoteAcc)

                Me.Invoke(New dlgSubNoArgs(AddressOf Me.ReadAccounts))
                'StoredRemoteAccount(impdata.RemoteAcc).LastUpdatedInfo = impdata.DateToImport
                'SaveAccounts()
            End If
        Catch ex As Exception
            AddLog(ex.Message & vbCrLf & ex.StackTrace)
        End Try
        PreparControlsForExportImport(False)
        UseWaitCursor = False
    End Sub

#End Region

#Region " Exportation des données "
    ''' <summary>
    ''' structure utilisé pour passer les variables
    ''' à la fonction multithread d'exportation
    ''' </summary>
    ''' <remarks></remarks>
    Protected Structure ThreadedExportData
        Dim exportplanets As Boolean
        Dim exportspy As Boolean
        Dim sincedate As Date
        Dim Galaxies As String
    End Structure

    ''' <summary>
    ''' Fonction multithreaded d'exportation des planètes 
    ''' et des rapports d'espionages
    ''' </summary>
    ''' <param name="State"></param>
    ''' <remarks></remarks>
    Private Sub doExportToServer(ByVal State As Object)
        Dim ted As ThreadedExportData = State

        If ted.exportplanets Then _ogspy.ExportPlanets(ted.sincedate, ted.Galaxies)
        If ted.exportspy Then
            AddLog("Collecting espionage report since " & ted.sincedate.ToString)
            Dim reportcol As OGameObject.SpyReportCol
            Dim ReportExportStr As String = ExportSpyHeader()

            reportcol = OGameObject.OGameDBEngine.Default.GetSpyReportSince(ted.sincedate)
            If reportcol.Count Then
                Dim reportcount As Integer = 0
                For Each r As OGameObject.SpyReport In reportcol
                    If r.Planet IsNot Nothing AndAlso ted.Galaxies.Contains(CStr(r.Planet.Galaxy)) Then
                        reportcount += 1
                        ReportExportStr &= "<->" & r.Planet.Coords & "<||>" & _
                                                   r.Planet.Name & "<||>" & _
                                                   r.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "<||>" & _
                                                   r.RawReport
                    End If
                    If reportcount = 50 Then
                        AddLog(reportcount & " rapport envoyés")
                        reportcount = 0
                        _ogspy.PostSpyReports(ReportExportStr)
                        ReportExportStr = ExportSpyHeader()
                        AddLog(_ogspy.LastPageReadedData)
                    End If
                Next
                If reportcount <> 0 Then
                    AddLog(reportcount & " rapport envoyés")
                    reportcount = 0
                    _ogspy.PostSpyReports(ReportExportStr)
                    Console.WriteLine(ReportExportStr)
                    ReportExportStr = ExportSpyHeader()
                    AddLog(_ogspy.LastPageReadedData)
                End If

            End If
            AddLog(reportcol.Count & " rapports d'espionnages envoyés")
        End If
        AddLog("Exportation vers le serveur OGSpy terminé")
        Me.Invoke(New dlgSubNoArgs(AddressOf Me.ExportFinished))
    End Sub
    ''' <summary>
    '''  En-Tete au format ogspy 0.302 de l'exportation
    ''' des rapports d'espionages
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Private Function ExportSpyHeader() As String
        Return "data=coordinates=1,planet=2,datatime=3,report=4"
    End Function
    ''' <summary>
    ''' Handler sur l'evenement ExportPlanets de la classe
    ''' OGSpy
    ''' </summary>
    ''' <param name="og"></param>
    ''' <param name="message"></param>
    ''' <remarks></remarks>
    Private Sub exportedplanet(ByVal og As OGSpy, ByVal message As String)
        AddLog(message)
    End Sub

    ''' <summary>
    ''' Fonction lancé une fois l'exporation fini
    ''' </summary>
    ''' <remarks></remarks>
    Private Sub ExportFinished()
        CType(tscbComptes.SelectedItem, RemoteAccount).LastSendedInfo = Now
        UniverseDB.UpdateAccountAndSave(tscbComptes.SelectedItem)
        ReadAccounts()
        RemoveHandler _ogspy.ExportedPlanet, AddressOf Me.exportedplanet
        Me.UseWaitCursor = False
    End Sub

#End Region

#Region " Exportation des statistiques "
    ''' <summary>
    ''' Evenement click sur le bouton export des statistiques
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub btnExportStatsToOGSpy_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnExportStatsToOGSpy.Click


        If lbStatistiquesOGS.SelectedItem Is Nothing Then
            MsgBox("Aucune statistique selectionnée", "Impossible d'exporter les statistiques")
            Return
        End If
        Me.UseWaitCursor = True
        PreparControlsForExportImport(True)
        unthreadedExportStatsDate = lbStatistiquesOGS.SelectedItem("datadate")
        BackgroundWorker2.RunWorkerAsync(New OGSpy(tscbComptes.SelectedItem))

    End Sub
    Private unthreadedExportStatsDate As Date
    Private Sub BackgroundWorker2_DoWork(ByVal sender As Object, ByVal e As System.ComponentModel.DoWorkEventArgs) Handles BackgroundWorker2.DoWork
        Try
            _ogspy = e.Argument
            AddLog(vbCrLf & "Exportation des statistiques générales")
            _ogspy.ExportStats(OGameDBEngine.Default.ExportPlayerRank(unthreadedExportStatsDate, enRankType.Points), "points")
            AddLog(_ogspy.LastPageReadedData & vbCrLf)
            AddLog("Exportation des statistiques de flotte")
            _ogspy.ExportStats(OGameDBEngine.Default.ExportPlayerRank(unthreadedExportStatsDate, enRankType.Flotte), "flotte")
            AddLog(_ogspy.LastPageReadedData & vbCrLf)
            AddLog("Exportation des statistiques de recherche")
            _ogspy.ExportStats(OGameDBEngine.Default.ExportPlayerRank(unthreadedExportStatsDate, enRankType.Research), "research")
            AddLog(_ogspy.LastPageReadedData & vbCrLf)

            '        MsgBox(lbStatistiquesOGS.SelectedItem("datadate"))
        Catch ex As Exception

        End Try

    End Sub

#End Region

    Public ReadOnly Property DomDocument() As Object
        Get
            Return OgameBrowserCtrl1.WebBrowser1.Document.DomDocument
        End Get
    End Property

    Private Sub OgameBrowserCtrl1_BrowserDocumentCompleted(ByVal sender As Object, ByVal e As System.Windows.Forms.WebBrowserDocumentCompletedEventArgs) Handles OgameBrowserCtrl1.BrowserDocumentCompleted
        With CType(sender, System.Windows.Forms.WebBrowser)
            'Autocompletion du formulaire de Login sur servuer OGSpy
            'si l'url lu correspond au serveur ogspy actuel
            If .Url.ToString = SelectedAccount.OGSServerURL AndAlso _
                .Document.DomDocument.getelementsbytagname("form").item(0).item("action").value = "login_web" Then
                .Document.DomDocument.getelementsbytagname("form").item(0).item("login").value = SelectedAccount.LoginName
                .Document.DomDocument.getelementsbytagname("form").item(0).item("password").value = SelectedAccount.Password
            End If

        End With
    End Sub

    Private Sub btnLogin_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnLogin.Click
        tsButBrowserOgspy_Click(Nothing, Nothing)
    End Sub

    Private Sub btnImport_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnImport.Click
        Dim frm As New OgspyAccountsForm
        If frm.ShowDialog = Windows.Forms.DialogResult.OK Then
            If frm.RemoteAccountSelected IsNot Nothing Then
                Dim o As New OGameObject.RemoteAccount
                With frm.RemoteAccountSelected
                    o.FriendlyName = .FriendlyName
                    o.LoginName = .LoginName
                    o.Password = .Password
                    o.MaxPlanetCountChunk = .MaxPlanetCountChunk
                    o.OGSServerURL = .OGSServerURL
                    UniverseDB.RemoteAccounts.Add(o)
                    lbComptes.Items.Add(o)
                    lbComptes.SelectedItem = o
                    tsbSaveComptes.Enabled = True
                End With
            End If
        End If
    End Sub

End Class
