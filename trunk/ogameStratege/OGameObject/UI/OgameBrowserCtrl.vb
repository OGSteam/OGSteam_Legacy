Imports System.Windows.Forms
Public Class OgameBrowserCtrl
    'Public Hauptframe As Boolean = False
    Public Event HauptframeDocument(ByVal sender As WebBrowser, ByVal Text As String)
    Public Event BrowserDocumentCompleted(ByVal sender As System.Object, ByVal e As System.Windows.Forms.WebBrowserDocumentCompletedEventArgs)
    Public Event BrowserNewWindow(ByVal sender As Object, ByVal url As String)

    Public Event OGameGeneralView(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameBuildings(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameResources(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameLaboratory(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameChantierSpatial(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameFlottes(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameTechnologies(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameGalaxy(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameDefenses(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameAlliance(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameStats(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameResearch(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameMessages(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameBuddyList(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)
    Public Event OGameOptions(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument)

    Private pLogBrowserInfo As Boolean
    Public Property LogBrowserInfo() As Boolean
        Get
            Return pLogBrowserInfo
        End Get
        Set(ByVal value As Boolean)
            pLogBrowserInfo = value
        End Set
    End Property


    Private Sub WebBrowser1_FileDownload(ByVal sender As Object, ByVal e As System.EventArgs) Handles WebBrowser1.FileDownload
        ' Console.WriteLine("File Download")
    End Sub
    Private Sub WebBrowser1_NewWindow(ByVal sender As Object, ByVal e As System.ComponentModel.CancelEventArgs) Handles WebBrowser1.NewWindow
        ''MessageBox.Show()
        'e.Cancel = True
        RaiseEvent BrowserNewWindow(sender, CType(sender, WebBrowser).Url.ToString)
    End Sub
   

    Private Sub WebBrowser1_StatusTextChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles WebBrowser1.StatusTextChanged
        tstlStatus.Text = WebBrowser1.StatusText
    End Sub

    Public Sub goUrl(ByVal URL As String)
        tscbURL.Text = URL
        WebBrowser1.Navigate(URL)
    End Sub
    Private Sub tsbutGo_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsbutGo.Click, tscbURL.SelectedIndexChanged
        Try

            login = False
            WebBrowser1.Navigate(tscbURL.Text)
        Catch ex As Exception
            ShowException(ex, "Echec lors de la navigation")
        End Try

    End Sub

    Private Sub ToolStripComboBox1_KeyUp(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles tscbURL.KeyUp
        If e.KeyCode = Windows.Forms.Keys.Enter Then
            Try
                login = False
                WebBrowser1.Navigate(tscbURL.Text)
            Catch ex As Exception

            End Try
        End If
    End Sub
    Public Event OnHauptFrame(ByVal sender As Object, ByVal html As String, ByVal text As String, ByVal Url As System.Uri)
    Public Event OGameMainFrame(ByVal Frame As HtmlWindow)
    Private Sub WebBrowser1_DocumentCompleted(ByVal sender As System.Object, ByVal e As System.Windows.Forms.WebBrowserDocumentCompletedEventArgs) Handles WebBrowser1.DocumentCompleted
        Try
            If WebBrowser1.Document.Window.Frames.Count > 0 AndAlso WebBrowser1.Document.Window.Frames(0).Document.GetElementById("login_input") IsNot Nothing Then
                ToolStripButtonApplyAccountInfo.Enabled = True
                ToolStripButtonSaveAccountInfo.Enabled = True
            Else
                ToolStripButtonApplyAccountInfo.Enabled = False
                ToolStripButtonSaveAccountInfo.Enabled = False
            End If
        Catch ex As Exception
            ' putain d'adframe de gf avec accés non autorisé obligeant a ce try/catch
        End Try
        Console.WriteLine("Document completed : " & e.Url.ToString)
        Dim clpboardtext As String = ""
        If e.Url.ToString.Contains("ogame.fr") Then
            clpboardtext = WebBrowser1.Document.Body.InnerText
            DoOnHauptFrame(WebBrowser1.Document)
            RaiseEvent OnHauptFrame(Me, _
                                    WebBrowser1.Document.Body.InnerHtml, _
                                    clpboardtext, _
                                    WebBrowser1.Document.Url)
            If clpboardtext.IndexOf("Classement des") > 1 Then
                clpboardtext = WebBrowser1.Document.Body.InnerHtml
                RaiseEvent HauptframeDocument(WebBrowser1, clpboardtext)
            End If

        End If

        RaiseEvent BrowserDocumentCompleted(sender, e)
    End Sub

    Private Sub DoOnHauptFrame(ByRef HTMLDoc As System.Windows.Forms.HtmlDocument)
        Dim Url As String = HTMLDoc.Url.PathAndQuery
        If Url.Contains("page=overview") Then
            HauptFrameToolStripStatusLabel1.Text = "Vue Generale"
            RaiseEvent OGameGeneralView(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=b_building") Then
            HauptFrameToolStripStatusLabel1.Text = "Batiments"
            RaiseEvent OGameBuildings(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=resources") Then
            HauptFrameToolStripStatusLabel1.Text = "Ressources"
            RaiseEvent OGameResources(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=buildings") And Url.Contains("Forschung") Then
            HauptFrameToolStripStatusLabel1.Text = "Laboratoires"
            RaiseEvent OGameLaboratory(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=buildings") And Url.Contains("Flotte") Then
            HauptFrameToolStripStatusLabel1.Text = "Chantier Spatial"
            RaiseEvent OGameChantierSpatial(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=flotten1") Then
            HauptFrameToolStripStatusLabel1.Text = "Flotte"
            RaiseEvent OGameFlottes(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=techtree") Then
            HauptFrameToolStripStatusLabel1.Text = "Technologies"
            RaiseEvent OGameTechnologies(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=galaxy") Then
            HauptFrameToolStripStatusLabel1.Text = "Galaxies"
            RaiseEvent OGameGalaxy(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=allianzen") Then
            HauptFrameToolStripStatusLabel1.Text = "Alliances"
            RaiseEvent OGameAlliance(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=stat") Then
            HauptFrameToolStripStatusLabel1.Text = "Statistiques"
            RaiseEvent OGameStats(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=suche") Then
            HauptFrameToolStripStatusLabel1.Text = "Recherche"
            RaiseEvent OGameResearch(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=messages") Then
            HauptFrameToolStripStatusLabel1.Text = "Messages"
            RaiseEvent OGameMessages(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=buddy") Then
            HauptFrameToolStripStatusLabel1.Text = "Liste des amis"
            RaiseEvent OGameBuddyList(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("page=options") Then
            HauptFrameToolStripStatusLabel1.Text = "Options"
            RaiseEvent OGameOptions(HTMLDoc.Url, HTMLDoc)
        ElseIf Url.Contains("Verteidigung") Then
            HauptFrameToolStripStatusLabel1.Text = "Defenses"
            RaiseEvent OGameDefenses(HTMLDoc.Url, HTMLDoc)
        Else
            HauptFrameToolStripStatusLabel1.Text = HTMLDoc.Url.PathAndQuery
        End If

    End Sub
    Private login As Boolean = False
    Private MainFrame As Boolean = False
    Private Sub WebBrowser1_Navigating(ByVal sender As Object, ByVal e As System.Windows.Forms.WebBrowserNavigatingEventArgs) Handles WebBrowser1.Navigating

        'If e.Url.ToString.Contains("index.php?page=") Then Hauptframe = True
        Try

            If login Then
                login = False
                WebBrowser1.Navigate(e.Url.ToString)
                e.Cancel = True
            End If
            If e.Url.ToString.Contains("login2") Then
                login = True
            End If

            If OGameObject.OGameDBEngine.Default IsNot Nothing Then
                Dim document As System.Windows.Forms.HtmlDocument = CType(sender, WebBrowser).Document
                If document IsNot Nothing And _
        document.All("login") IsNot Nothing And _
        document.All("formular") IsNot Nothing Then
                    'And _
                    '        String.IsNullOrEmpty( _
                    '       document.All("login").GetAttribute("value")) Then
                    'then
                    ' e.Cancel = True
                    MsgBox(e.Url.ToString() & vbCrLf & document.All("login").OuterHtml)
                End If
            End If
        Catch ex As Exception
            OGameObject.ShowException(ex, "browser navigating")
        End Try
    End Sub

    Private Sub tsbutShowHidePanel_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tsbutShowHidePanel.Click
        SplitContainer1.Panel1Collapsed = Not SplitContainer1.Panel1Collapsed
    End Sub


    Private Sub WebBrowser1_Navigated(ByVal sender As Object, ByVal e As System.Windows.Forms.WebBrowserNavigatedEventArgs) Handles WebBrowser1.Navigated
        Console.WriteLine("Navigated:" & e.Url.ToString)
    End Sub
    'Private Sub FillLoginForm(ByVal Window As HtmlWindow, ByVal Univers As String, ByVal login As String, ByVal pass As String)
    '    If (Window.Document.GetElementsByTagName("form").Item("formular") IsNot Nothing) Then
    '        Dim ElemForm As HtmlElement = Window.Document.GetElementsByTagName("form").Item("formular")
    '        Dim UniElm As HtmlElement = ElemForm.All("uni")
    '        Dim UniversTitle As String = ""
    '        For Each UniOption As HtmlElement In UniElm.GetElementsByTagName("option")
    '            If (UniOption.InnerText IsNot Nothing And UniOption.InnerText = Univers) Then
    '                UniOption.DomElement.selected = True
    '            End If
    '        Next
    '        ElemForm.All("login").SetAttribute("value", login)
    '        ElemForm.All("pass").SetAttribute("value", pass)
    '    ElseIf (Window.Frames.Count) Then
    '        For Each frame As HtmlWindow In Window.Frames
    '            FillLoginForm(frame, Univers, login, pass)
    '        Next
    '    End If
    'End Sub
    Public Event OnChangeConfirmStats(ByVal sender As Object, ByVal ConfirmStats As Boolean)
    Private Sub ConfirmerLentreeDesStatistiquesToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ConfirmerLentreeDesStatistiquesToolStripMenuItem.Click
        RaiseEvent OnChangeConfirmStats(Me, ConfirmerLentreeDesStatistiquesToolStripMenuItem.Checked)
    End Sub
    ''' <summary>
    ''' Enregistrement des informations de compte tel qu'affichés dans la page en cours dans la base de donnée
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub ToolStripButton2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButtonSaveAccountInfo.Click
        If OGameObject.OGameDBEngine.Default Is Nothing Then
            MsgBox("Pour enregistrer les informations de login , il est necessaire qu'un des bases de données OGS soit ouverte", , "Enregistrement d'informations de comptes en base de données")
            Exit Sub
        End If
        If MsgBox("Etes vous sur de vouloir enregistrer vos informations de compte OGame dans votre base de donnée OGS ?" & vbCrLf & "(Attention ces données ne sont pas cryptés, et sont lisible sur votre ordinateur par n'importe qui)" & vbCrLf & "Vous pouvez si vous le souhaitez le mot de passe vide, et uniquement rentrez celui-ci à la demande", MsgBoxStyle.YesNo) = MsgBoxResult.No Then
            Exit Sub
        End If

        If WebBrowser1.Document.Window.Frames.Count > 0 AndAlso WebBrowser1.Document.Window.Frames(0).Document.GetElementById("login_input") IsNot Nothing Then
            With WebBrowser1.Document.Window.Frames(0).Document.GetElementById("login_input")
                For Each UniSelect As HtmlElement In .GetElementsByTagName("SELECT")(0).GetElementsByTagName("OPTION")
                    If UniSelect.DomElement.selected Then
                        OGameObject.OGameDBEngine.Default.SetConfig("ogame_uni", UniSelect.DomElement.value)
                        Exit For
                    End If
                Next
                OGameObject.OGameDBEngine.Default.SetConfig("ogame_login", .All("login").DomElement.value)
                OGameObject.OGameDBEngine.Default.SetConfig("ogame_pass", ROT13Encode(.All("pass").DomElement.value))
            End With
        End If

    End Sub

    Private Sub ToolStripButtonApplyAccountInfo_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButtonApplyAccountInfo.Click
        If OGameObject.OGameDBEngine.Default Is Nothing Then
            MsgBox("Pour appliquer les informations de login , il est necessaire qu'un des bases de données OGS soit ouverte", , "Insertion des informations de compte dans la boite de login")
            Exit Sub
        End If
        If WebBrowser1.Document.Window.Frames.Count > 0 AndAlso WebBrowser1.Document.Window.Frames(0).Document.GetElementById("login_input") IsNot Nothing Then
            With WebBrowser1.Document.Window.Frames(0).Document.GetElementById("login_input")
                For Each UniSelect As HtmlElement In .GetElementsByTagName("SELECT")(0).GetElementsByTagName("OPTION")
                    If UniSelect.DomElement.value = OGameObject.OGameDBEngine.Default.GetConfig("ogame_uni") Then
                        UniSelect.DomElement.selected = True
                        Exit For
                    End If
                Next
                .All("login").DomElement.value = OGameObject.OGameDBEngine.Default.GetConfig("ogame_login")
                .All("pass").DomElement.value = ROT13Encode(OGameObject.OGameDBEngine.Default.GetConfig("ogame_pass"))
            End With
        End If

    End Sub
End Class

