Public Class RemoteDBCtrl
    Inherits System.Windows.Forms.UserControl

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call

    End Sub

    'UserControl overrides dispose to clean up the component list.
    Protected Overloads Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing Then
            If Not (components Is Nothing) Then
                components.Dispose()
            End If
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    Friend WithEvents panMain As System.Windows.Forms.Panel
    Friend WithEvents TabControl1 As System.Windows.Forms.TabControl
    Friend WithEvents GroupBox1 As System.Windows.Forms.GroupBox
    Friend WithEvents cbAccounts As System.Windows.Forms.ComboBox
    Friend WithEvents btnDeleteAccount As System.Windows.Forms.Button
    Friend WithEvents btnAddAccount As System.Windows.Forms.Button
    Friend WithEvents tpUpdate As System.Windows.Forms.TabPage
    Friend WithEvents tpAccounts As System.Windows.Forms.TabPage
    Friend WithEvents panAccountInfo As System.Windows.Forms.Panel
    Friend WithEvents tbFriendlyName As System.Windows.Forms.TextBox
    Friend WithEvents tbOGSServerUrl As System.Windows.Forms.TextBox
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents tbLoginName As System.Windows.Forms.TextBox
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents tbPassword As System.Windows.Forms.TextBox
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents tbLog As System.Windows.Forms.TextBox
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents rtbResult As System.Windows.Forms.RichTextBox
    Friend WithEvents btnSave As System.Windows.Forms.Button
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents btnTestLogin As System.Windows.Forms.Button
    Friend WithEvents GroupBox2 As System.Windows.Forms.GroupBox
    Friend WithEvents GroupBox3 As System.Windows.Forms.GroupBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Panel3 As System.Windows.Forms.Panel
    Friend WithEvents btnExport As System.Windows.Forms.Button
    Friend WithEvents chkExportPlanet As System.Windows.Forms.CheckBox
    Friend WithEvents chkExportSpyReport As System.Windows.Forms.CheckBox
    Friend WithEvents btnSharedResetDate As System.Windows.Forms.Button
    Friend WithEvents dtpExportDate As System.Windows.Forms.DateTimePicker
    Friend WithEvents Panel4 As System.Windows.Forms.Panel
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents chklbExportGalaxy As System.Windows.Forms.CheckedListBox
    Friend WithEvents btnStop As System.Windows.Forms.Button
    Friend WithEvents btnImportDB As System.Windows.Forms.Button
    Friend WithEvents chkDefautRemoteAccount As System.Windows.Forms.CheckBox
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents GroupBox4 As System.Windows.Forms.GroupBox
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents lbbExportPlanetChunkCount As OGameStratege.LabelBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(RemoteDBCtrl))
        Me.panMain = New System.Windows.Forms.Panel
        Me.TabControl1 = New System.Windows.Forms.TabControl
        Me.tpUpdate = New System.Windows.Forms.TabPage
        Me.rtbResult = New System.Windows.Forms.RichTextBox
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.tbLog = New System.Windows.Forms.TextBox
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.GroupBox3 = New System.Windows.Forms.GroupBox
        Me.btnImportDB = New System.Windows.Forms.Button
        Me.GroupBox2 = New System.Windows.Forms.GroupBox
        Me.Panel4 = New System.Windows.Forms.Panel
        Me.chklbExportGalaxy = New System.Windows.Forms.CheckedListBox
        Me.Label4 = New System.Windows.Forms.Label
        Me.Panel3 = New System.Windows.Forms.Panel
        Me.dtpExportDate = New System.Windows.Forms.DateTimePicker
        Me.chkExportPlanet = New System.Windows.Forms.CheckBox
        Me.btnExport = New System.Windows.Forms.Button
        Me.chkExportSpyReport = New System.Windows.Forms.CheckBox
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.Button2 = New System.Windows.Forms.Button
        Me.btnStop = New System.Windows.Forms.Button
        Me.btnSharedResetDate = New System.Windows.Forms.Button
        Me.btnTestLogin = New System.Windows.Forms.Button
        Me.Button1 = New System.Windows.Forms.Button
        Me.tpAccounts = New System.Windows.Forms.TabPage
        Me.btnSave = New System.Windows.Forms.Button
        Me.GroupBox1 = New System.Windows.Forms.GroupBox
        Me.panAccountInfo = New System.Windows.Forms.Panel
        Me.GroupBox4 = New System.Windows.Forms.GroupBox
        Me.lbbExportPlanetChunkCount = New OGameStratege.LabelBox
        Me.chkDefautRemoteAccount = New System.Windows.Forms.CheckBox
        Me.tbFriendlyName = New System.Windows.Forms.TextBox
        Me.tbOGSServerUrl = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.Label2 = New System.Windows.Forms.Label
        Me.tbLoginName = New System.Windows.Forms.TextBox
        Me.Label3 = New System.Windows.Forms.Label
        Me.tbPassword = New System.Windows.Forms.TextBox
        Me.btnAddAccount = New System.Windows.Forms.Button
        Me.cbAccounts = New System.Windows.Forms.ComboBox
        Me.btnDeleteAccount = New System.Windows.Forms.Button
        Me.Button3 = New System.Windows.Forms.Button
        Me.panMain.SuspendLayout()
        Me.TabControl1.SuspendLayout()
        Me.tpUpdate.SuspendLayout()
        Me.Panel1.SuspendLayout()
        Me.GroupBox3.SuspendLayout()
        Me.GroupBox2.SuspendLayout()
        Me.Panel4.SuspendLayout()
        Me.Panel3.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.tpAccounts.SuspendLayout()
        Me.GroupBox1.SuspendLayout()
        Me.panAccountInfo.SuspendLayout()
        Me.GroupBox4.SuspendLayout()
        Me.SuspendLayout()
        '
        'panMain
        '
        Me.panMain.Controls.Add(Me.TabControl1)
        resources.ApplyResources(Me.panMain, "panMain")
        Me.panMain.Name = "panMain"
        '
        'TabControl1
        '
        Me.TabControl1.Controls.Add(Me.tpUpdate)
        Me.TabControl1.Controls.Add(Me.tpAccounts)
        resources.ApplyResources(Me.TabControl1, "TabControl1")
        Me.TabControl1.Name = "TabControl1"
        Me.TabControl1.SelectedIndex = 0
        '
        'tpUpdate
        '
        Me.tpUpdate.Controls.Add(Me.rtbResult)
        Me.tpUpdate.Controls.Add(Me.Splitter1)
        Me.tpUpdate.Controls.Add(Me.tbLog)
        Me.tpUpdate.Controls.Add(Me.Panel1)
        resources.ApplyResources(Me.tpUpdate, "tpUpdate")
        Me.tpUpdate.Name = "tpUpdate"
        '
        'rtbResult
        '
        resources.ApplyResources(Me.rtbResult, "rtbResult")
        Me.rtbResult.Name = "rtbResult"
        '
        'Splitter1
        '
        resources.ApplyResources(Me.Splitter1, "Splitter1")
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.TabStop = False
        '
        'tbLog
        '
        Me.tbLog.BackColor = System.Drawing.Color.Black
        resources.ApplyResources(Me.tbLog, "tbLog")
        Me.tbLog.ForeColor = System.Drawing.Color.Gold
        Me.tbLog.HideSelection = False
        Me.tbLog.Name = "tbLog"
        Me.tbLog.ReadOnly = True
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.GroupBox3)
        Me.Panel1.Controls.Add(Me.GroupBox2)
        Me.Panel1.Controls.Add(Me.Panel2)
        resources.ApplyResources(Me.Panel1, "Panel1")
        Me.Panel1.Name = "Panel1"
        '
        'GroupBox3
        '
        Me.GroupBox3.Controls.Add(Me.btnImportDB)
        resources.ApplyResources(Me.GroupBox3, "GroupBox3")
        Me.GroupBox3.Name = "GroupBox3"
        Me.GroupBox3.TabStop = False
        '
        'btnImportDB
        '
        resources.ApplyResources(Me.btnImportDB, "btnImportDB")
        Me.btnImportDB.Name = "btnImportDB"
        '
        'GroupBox2
        '
        Me.GroupBox2.Controls.Add(Me.Panel4)
        Me.GroupBox2.Controls.Add(Me.Panel3)
        resources.ApplyResources(Me.GroupBox2, "GroupBox2")
        Me.GroupBox2.Name = "GroupBox2"
        Me.GroupBox2.TabStop = False
        '
        'Panel4
        '
        Me.Panel4.Controls.Add(Me.chklbExportGalaxy)
        Me.Panel4.Controls.Add(Me.Label4)
        resources.ApplyResources(Me.Panel4, "Panel4")
        Me.Panel4.Name = "Panel4"
        '
        'chklbExportGalaxy
        '
        Me.chklbExportGalaxy.CheckOnClick = True
        resources.ApplyResources(Me.chklbExportGalaxy, "chklbExportGalaxy")
        Me.chklbExportGalaxy.Items.AddRange(New Object() {resources.GetString("chklbExportGalaxy.Items"), resources.GetString("chklbExportGalaxy.Items1"), resources.GetString("chklbExportGalaxy.Items2"), resources.GetString("chklbExportGalaxy.Items3"), resources.GetString("chklbExportGalaxy.Items4"), resources.GetString("chklbExportGalaxy.Items5"), resources.GetString("chklbExportGalaxy.Items6"), resources.GetString("chklbExportGalaxy.Items7"), resources.GetString("chklbExportGalaxy.Items8")})
        Me.chklbExportGalaxy.Name = "chklbExportGalaxy"
        '
        'Label4
        '
        resources.ApplyResources(Me.Label4, "Label4")
        Me.Label4.Name = "Label4"
        '
        'Panel3
        '
        Me.Panel3.Controls.Add(Me.dtpExportDate)
        Me.Panel3.Controls.Add(Me.chkExportPlanet)
        Me.Panel3.Controls.Add(Me.btnExport)
        Me.Panel3.Controls.Add(Me.chkExportSpyReport)
        resources.ApplyResources(Me.Panel3, "Panel3")
        Me.Panel3.Name = "Panel3"
        '
        'dtpExportDate
        '
        resources.ApplyResources(Me.dtpExportDate, "dtpExportDate")
        Me.dtpExportDate.Format = System.Windows.Forms.DateTimePickerFormat.Custom
        Me.dtpExportDate.Name = "dtpExportDate"
        '
        'chkExportPlanet
        '
        Me.chkExportPlanet.Checked = True
        Me.chkExportPlanet.CheckState = System.Windows.Forms.CheckState.Checked
        resources.ApplyResources(Me.chkExportPlanet, "chkExportPlanet")
        Me.chkExportPlanet.Name = "chkExportPlanet"
        '
        'btnExport
        '
        resources.ApplyResources(Me.btnExport, "btnExport")
        Me.btnExport.Name = "btnExport"
        '
        'chkExportSpyReport
        '
        Me.chkExportSpyReport.Checked = True
        Me.chkExportSpyReport.CheckState = System.Windows.Forms.CheckState.Checked
        resources.ApplyResources(Me.chkExportSpyReport, "chkExportSpyReport")
        Me.chkExportSpyReport.Name = "chkExportSpyReport"
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.Button3)
        Me.Panel2.Controls.Add(Me.Button2)
        Me.Panel2.Controls.Add(Me.btnStop)
        Me.Panel2.Controls.Add(Me.btnSharedResetDate)
        Me.Panel2.Controls.Add(Me.btnTestLogin)
        Me.Panel2.Controls.Add(Me.Button1)
        resources.ApplyResources(Me.Panel2, "Panel2")
        Me.Panel2.Name = "Panel2"
        '
        'Button2
        '
        resources.ApplyResources(Me.Button2, "Button2")
        Me.Button2.Name = "Button2"
        '
        'btnStop
        '
        Me.btnStop.BackColor = System.Drawing.SystemColors.Highlight
        Me.btnStop.ForeColor = System.Drawing.SystemColors.HighlightText
        resources.ApplyResources(Me.btnStop, "btnStop")
        Me.btnStop.Name = "btnStop"
        Me.btnStop.UseVisualStyleBackColor = False
        '
        'btnSharedResetDate
        '
        resources.ApplyResources(Me.btnSharedResetDate, "btnSharedResetDate")
        Me.btnSharedResetDate.Name = "btnSharedResetDate"
        '
        'btnTestLogin
        '
        resources.ApplyResources(Me.btnTestLogin, "btnTestLogin")
        Me.btnTestLogin.Name = "btnTestLogin"
        '
        'Button1
        '
        resources.ApplyResources(Me.Button1, "Button1")
        Me.Button1.Name = "Button1"
        '
        'tpAccounts
        '
        Me.tpAccounts.Controls.Add(Me.btnSave)
        Me.tpAccounts.Controls.Add(Me.GroupBox1)
        resources.ApplyResources(Me.tpAccounts, "tpAccounts")
        Me.tpAccounts.Name = "tpAccounts"
        '
        'btnSave
        '
        resources.ApplyResources(Me.btnSave, "btnSave")
        Me.btnSave.Name = "btnSave"
        '
        'GroupBox1
        '
        Me.GroupBox1.Controls.Add(Me.panAccountInfo)
        Me.GroupBox1.Controls.Add(Me.btnAddAccount)
        Me.GroupBox1.Controls.Add(Me.cbAccounts)
        Me.GroupBox1.Controls.Add(Me.btnDeleteAccount)
        resources.ApplyResources(Me.GroupBox1, "GroupBox1")
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.TabStop = False
        '
        'panAccountInfo
        '
        Me.panAccountInfo.Controls.Add(Me.GroupBox4)
        Me.panAccountInfo.Controls.Add(Me.chkDefautRemoteAccount)
        Me.panAccountInfo.Controls.Add(Me.tbFriendlyName)
        Me.panAccountInfo.Controls.Add(Me.tbOGSServerUrl)
        Me.panAccountInfo.Controls.Add(Me.Label1)
        Me.panAccountInfo.Controls.Add(Me.Label2)
        Me.panAccountInfo.Controls.Add(Me.tbLoginName)
        Me.panAccountInfo.Controls.Add(Me.Label3)
        Me.panAccountInfo.Controls.Add(Me.tbPassword)
        resources.ApplyResources(Me.panAccountInfo, "panAccountInfo")
        Me.panAccountInfo.Name = "panAccountInfo"
        '
        'GroupBox4
        '
        Me.GroupBox4.Controls.Add(Me.lbbExportPlanetChunkCount)
        resources.ApplyResources(Me.GroupBox4, "GroupBox4")
        Me.GroupBox4.Name = "GroupBox4"
        Me.GroupBox4.TabStop = False
        '
        'lbbExportPlanetChunkCount
        '
        Me.lbbExportPlanetChunkCount.Caption = "Exports Planet Chunk Count"
        Me.lbbExportPlanetChunkCount.CaptionWidth = 150
        resources.ApplyResources(Me.lbbExportPlanetChunkCount, "lbbExportPlanetChunkCount")
        Me.lbbExportPlanetChunkCount.Name = "lbbExportPlanetChunkCount"
        Me.lbbExportPlanetChunkCount.ReadOnly = False
        Me.lbbExportPlanetChunkCount.Value = ""
        '
        'chkDefautRemoteAccount
        '
        resources.ApplyResources(Me.chkDefautRemoteAccount, "chkDefautRemoteAccount")
        Me.chkDefautRemoteAccount.Name = "chkDefautRemoteAccount"
        '
        'tbFriendlyName
        '
        resources.ApplyResources(Me.tbFriendlyName, "tbFriendlyName")
        Me.tbFriendlyName.Name = "tbFriendlyName"
        '
        'tbOGSServerUrl
        '
        resources.ApplyResources(Me.tbOGSServerUrl, "tbOGSServerUrl")
        Me.tbOGSServerUrl.Name = "tbOGSServerUrl"
        '
        'Label1
        '
        resources.ApplyResources(Me.Label1, "Label1")
        Me.Label1.Name = "Label1"
        '
        'Label2
        '
        resources.ApplyResources(Me.Label2, "Label2")
        Me.Label2.Name = "Label2"
        '
        'tbLoginName
        '
        resources.ApplyResources(Me.tbLoginName, "tbLoginName")
        Me.tbLoginName.Name = "tbLoginName"
        '
        'Label3
        '
        resources.ApplyResources(Me.Label3, "Label3")
        Me.Label3.Name = "Label3"
        '
        'tbPassword
        '
        resources.ApplyResources(Me.tbPassword, "tbPassword")
        Me.tbPassword.Name = "tbPassword"
        '
        'btnAddAccount
        '
        resources.ApplyResources(Me.btnAddAccount, "btnAddAccount")
        Me.btnAddAccount.Name = "btnAddAccount"
        '
        'cbAccounts
        '
        resources.ApplyResources(Me.cbAccounts, "cbAccounts")
        Me.cbAccounts.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbAccounts.Name = "cbAccounts"
        '
        'btnDeleteAccount
        '
        resources.ApplyResources(Me.btnDeleteAccount, "btnDeleteAccount")
        Me.btnDeleteAccount.Name = "btnDeleteAccount"
        '
        'Button3
        '
        resources.ApplyResources(Me.Button3, "Button3")
        Me.Button3.Name = "Button3"
        Me.Button3.UseVisualStyleBackColor = True
        '
        'RemoteDBCtrl
        '
        Me.Controls.Add(Me.panMain)
        Me.Name = "RemoteDBCtrl"
        resources.ApplyResources(Me, "$this")
        Me.panMain.ResumeLayout(False)
        Me.TabControl1.ResumeLayout(False)
        Me.tpUpdate.ResumeLayout(False)
        Me.tpUpdate.PerformLayout()
        Me.Panel1.ResumeLayout(False)
        Me.GroupBox3.ResumeLayout(False)
        Me.GroupBox2.ResumeLayout(False)
        Me.Panel4.ResumeLayout(False)
        Me.Panel3.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.tpAccounts.ResumeLayout(False)
        Me.GroupBox1.ResumeLayout(False)
        Me.panAccountInfo.ResumeLayout(False)
        Me.panAccountInfo.PerformLayout()
        Me.GroupBox4.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region
    Public Event RemoteAccountChanged(ByVal sender As Object, ByVal remAcc As OGameObject.RemoteAccount)
    Private Sub cbAccounts_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbAccounts.SelectedIndexChanged
        pSHaredDB = Nothing
        If cbAccounts.SelectedItem Is Nothing Then
            panAccountInfo.Enabled = False
            btnDeleteAccount.Enabled = False
            tbFriendlyName.Enabled = False
            tbLoginName.Enabled = False
            tbOGSServerUrl.Enabled = False
            btnDeleteAccount.Enabled = False
            chkDefautRemoteAccount.Enabled = False
            tbPassword.Enabled = False
            RaiseEvent RemoteAccountChanged(Me, Nothing)
        Else
            panAccountInfo.Enabled = True
            tbFriendlyName.Enabled = True
            tbLoginName.Enabled = True
            tbOGSServerUrl.Enabled = True
            btnDeleteAccount.Enabled = True
            chkDefautRemoteAccount.Enabled = True
            tbPassword.Enabled = True

            Dim remAcc As OGameObject.RemoteAccount = cbAccounts.SelectedItem
            tbFriendlyName.Text = remAcc.FriendlyName
            tbLoginName.Text = remAcc.LoginName
            tbOGSServerUrl.Text = remAcc.OGSServerURL
            tbPassword.Text = remAcc.Password
            chkDefautRemoteAccount.Checked = remAcc.DefaultAccount
            btnDeleteAccount.Enabled = True
            dtpExportDate.Value = SelectedAccount.LastSendedInfo
            lbbExportPlanetChunkCount.Value = SelectedAccount.MaxPlanetCountChunk
            RaiseEvent RemoteAccountChanged(Me, remAcc)
        End If
    End Sub

    Private pUniverseDB As OGameObject.UniverseDB = Nothing
    Public Property UniverseDB() As OGameObject.UniverseDB
        Get
            Return pUniverseDB
        End Get
        Set(ByVal Value As OGameObject.UniverseDB)
            TabControl1.Enabled = False
            If Value Is pUniverseDB Then Return
            TabControl1.Enabled = True
            If Value Is Nothing Then

                TabControl1.SelectedIndex = 0
                TabControl1.Enabled = False
                pSHaredDB = Nothing

            Else
                pUniverseDB = Value
                cbAccounts.Items.Clear()
                For Each s As OGameObject.RemoteAccount In pUniverseDB.RemoteAccounts
                    cbAccounts.Items.Add(s)
                    If s.DefaultAccount Then cbAccounts.SelectedItem = s
                Next
                If SelectedAccount Is Nothing Then
                    If pUniverseDB.RemoteAccounts.Count Then
                        cbAccounts.SelectedIndex = 0
                    End If
                End If
            End If
        End Set
    End Property
    Private pSHaredDB As OGameObject.SharingDB = Nothing
    Public ReadOnly Property SharedDB() As OGameObject.SharingDB
        Get
            If pSHaredDB Is Nothing Then
                If cbAccounts.SelectedItem Is Nothing Then
                    If Not Me.DesignMode Then MessageBox.Show(MainForm.TopForm, "No Remote Account selected")
                    TabControl1.SelectedTab = tpAccounts
                    Return Nothing
                End If
                With CType(cbAccounts.SelectedItem, OGameObject.RemoteAccount)


                    pSHaredDB = New OGameObject.SharingDB
                    pSHaredDB.LoginName = .LoginName
                    pSHaredDB.LoginPass = .Password
                    pSHaredDB.URL = .OGSServerURL
                End With
            End If
            Return pSHaredDB
        End Get
    End Property
    Private Sub btnAddAccount_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnAddAccount.Click
        Dim o As New OGameObject.RemoteAccount
        o.FriendlyName = "New Account"
        UniverseDB.RemoteAccounts.Add(o)
        cbAccounts.Items.Add(o)
        cbAccounts.SelectedItem = o
    End Sub

    Public Sub btnSave_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSave.Click
        Dim u As OGameObject.UniversesDBCol = OGameObject.UniversesDBCol.XMLDeSerialize
        If u Is Nothing Then Return
        For Each uni As OGameObject.UniverseDB In u
            If uni.DBFileName = UniverseDB.DBFileName AndAlso uni.UniverseName = UniverseDB.UniverseName Then
                uni.RemoteAccounts.Clear()
                For Each remacc As Object In cbAccounts.Items
                    uni.RemoteAccounts.Add(remacc)
                Next

                cbAccounts.Items.Clear()
                For Each remacc As Object In uni.RemoteAccounts
                    cbAccounts.Items.Add(remacc)
                    If remacc.DefaultAccount Then cbAccounts.SelectedItem = remacc
                Next
            End If
        Next
        u.XMLSerialize()
    End Sub


    Private Sub accountinfo_Validated(ByVal sender As Object, ByVal e As System.EventArgs) _
     Handles tbFriendlyName.Validated, tbLoginName.Validated, tbPassword.Validated, tbOGSServerUrl.Validated, chkDefautRemoteAccount.Validated, lbbExportPlanetChunkCount.Validated
        If cbAccounts.SelectedItem Is Nothing Then Return
        With SelectedAccount
            .FriendlyName = tbFriendlyName.Text
            .LoginName = tbLoginName.Text
            .Password = tbPassword.Text
            .OGSServerURL = tbOGSServerUrl.Text
            .MaxPlanetCountChunk = lbbExportPlanetChunkCount.Value
            .DefaultAccount = chkDefautRemoteAccount.Checked
            dtpExportDate.Value = SelectedAccount.LastSendedInfo

            cbAccounts.Refresh()
        End With
    End Sub
    Public ReadOnly Property SelectedAccount() As OGameObject.RemoteAccount
        Get
            Return cbAccounts.SelectedItem
        End Get
    End Property
    Public Sub AddLogEntry(ByVal Text As String, Optional ByVal NewLined As Boolean = True)
        tbLog.AppendText(Now.ToString("HH:mm") & " " & Text)
        If NewLined Then tbLog.AppendText(vbCrLf)
        tbLog.SelectionStart = tbLog.TextLength - 1
        tbLog.ScrollToCaret()
        Application.DoEvents()

    End Sub
    Private Sub btnTestLogin_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnTestLogin.Click
        If SelectedAccount Is Nothing Then
            MessageBox.Show(MainForm.TopForm, "There is no account information correctly recorded for remote database")
            Exit Sub
        End If
        AddLogEntry("Trying to login on " & SelectedAccount.FriendlyName & ": " & IIf(SharedDB.Login, "Sucessful", "Failed"))
        rtbResult.Text = SharedDB.LastPageReadedData
        btnExport.Enabled = True
    End Sub


    Private Sub btnExport_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnExport.Click
        If SelectedAccount Is Nothing Then Return
        btnStop.Tag = True
        Try

            AddLogEntry("Searching database for update to send")
            Application.DoEvents()
            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            Dim placol As OGameObject.PlanetCol
            Dim SendData As String = ""
            If chkExportPlanet.Checked Then
                Dim reader As Object = Nothing
                AddLogEntry("Retrieving new planets since " & SelectedAccount.LastSendedInfo.ToString)
                'placol = OGameObject.OGameDBEngine.Default.GetUpdatedPlanetSince(SelectedAccount.LastSendedInfo)
                For i As Integer = 0 To chklbExportGalaxy.Items.Count - 1
                    SendData = ""
                    If chklbExportGalaxy.GetItemChecked(i) Then

                        placol = OGameObject.OGameDBEngine.Default.GetUpdatedPlanetSinceChunk(SelectedAccount.LastSendedInfo, reader, i + 1)
                        AddLogEntry("Galaxy " & i + 1 & " : " & placol.Count)
                        While placol.Count
                            If placol.Count Then

                                For Each p As OGameObject.Planet In placol
                                    SendData &= p.ExportString & "<|>"
                                    'If rtbShareLog.TextLength > 14000 Then
                                    '    SharedDB.PostPlanetsXML(rtbShareLog.Text)
                                    '    rtbShareLog.Text = ""
                                    'End If
                                Next
                            Else
                                AddLogEntry("No new planet data found")
                                'MsgBox("No planet updated since " & dtpMinUpdate.Value)
                            End If
                            If chkExportPlanet.Checked Then
                                AddLogEntry("Sending info for " & placol.Count & " planets")
                                Application.DoEvents()
                                If SendData.Length > 0 Then
                                    SharedDB.PostPlanetsXML(SendData)
                                    rtbResult.Text = SharedDB.LastPageReadedData
                                    SendData = ""
                                End If
                            End If

                            placol = OGameObject.OGameDBEngine.Default.GetUpdatedPlanetSinceChunk(SelectedAccount.LastSendedInfo, reader)
                        End While
                    End If
                Next
            End If
            'GC.Collect()
            'AddLogEntry("System : Collecting Memory")
            Dim reportcol As OGameObject.SpyReportCol = Nothing
            Dim ReportExportStr As String = ""
            If chkExportSpyReport.Checked Then
                reportcol = OGameObject.OGameDBEngine.Default.GetSpyReportSince(SelectedAccount.LastSendedInfo)
                If reportcol.Count Then
                    For Each r As OGameObject.SpyReport In reportcol
                        ReportExportStr &= r.ExportString & "<|>"
                    Next
                End If
            End If


            If chkExportSpyReport.Checked Then
                AddLogEntry("Sending " & reportcol.Count & " Spying reports")
                Application.DoEvents()
                If ReportExportStr.Length > 0 Then
                    SharedDB.PostSpyReports(ReportExportStr)
                    rtbResult.AppendText(vbCrLf & SharedDB.LastPageReadedData)
                End If
            End If
            SelectedAccount.LastSendedInfo = Now
            btnSave_Click(Nothing, Nothing)

        Finally
            Me.Cursor = System.Windows.Forms.Cursors.Default
        End Try

    End Sub
    Private Sub btnImportDB_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnImportDB.Click
        Try
            If SharedDB Is Nothing Then Return
            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            AddLogEntry("Importing galaxy data from remote server for imports")
            SharedDB.ImportNew()
            AddLogEntry("Creating local file: " & IO.Path.Combine(Application.StartupPath, "remote_imported.dat"))
            Dim u As New System.IO.StreamWriter(IO.Path.Combine(Application.StartupPath, "remote_imported.dat"), False)
            u.Write(SharedDB.LastPageReadedData)
            u.Close()
            AddLogEntry("Importing data from " & IO.Path.Combine(Application.StartupPath, "remote_imported.dat"))
            OGameObject.OGameDBEngine.Default.ImportFile(IO.Path.Combine(Application.StartupPath, "remote_imported.dat"))

            AddLogEntry("Data importation done.")

        Catch ex As Exception
            AddLogEntry("Error : " & ex.Message)
            Console.WriteLine(ex.Message)
            Console.WriteLine(ex.StackTrace)
            Return
        End Try
        'addlogentry
        Me.Cursor = System.Windows.Forms.Cursors.Default
    End Sub



    Private Sub CheckBox1_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkExportPlanet.CheckedChanged

    End Sub

    Private Sub btnSharedResetDate_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSharedResetDate.Click
        If SelectedAccount Is Nothing Then Return
        SelectedAccount.LastSendedInfo = New Date(2005, 1, 1)
        dtpExportDate.Value = SelectedAccount.LastSendedInfo
    End Sub


    Private Sub RemoteDBCtrl_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        For i As Integer = 0 To chklbExportGalaxy.Items.Count - 1
            chklbExportGalaxy.SetItemChecked(i, True)
        Next
    End Sub



    Private Sub btnDeleteAccount_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnDeleteAccount.Click
        If SelectedAccount Is Nothing Then
            MessageBox.Show(MainForm.TopForm, "There is no selected account")
            Exit Sub
        End If
        cbAccounts.Items.Remove(cbAccounts.SelectedItem)
        btnSave_Click(Nothing, Nothing)
    End Sub
    Private Function ByteArrayToString(ByVal ByteArray As Byte()) As String
        Return System.Text.Encoding.UTF8.GetString(ByteArray)
    End Function
    Private Sub btnStop_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnStop.Click
        'Dim pass As String = "ogsteam"
        'Dim sha1 As New System.Security.Cryptography.SHA1CryptoServiceProvider
        'Dim sha1pass As Byte() = sha1.ComputeHash(System.Text.Encoding.UTF8.GetBytes(pass))
        'Dim md5 As New System.Security.Cryptography.MD5CryptoServiceProvider
        'Dim md5pass As Byte() = md5.ComputeHash(sha1pass)
        'MessageBox.Show(pass & vbCrLf & Hex(md5pass))
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        Dim servinfo As New OGSpyInterface
        servinfo.ShowDialog()
    End Sub

    'Private Sub btnGetStatsPoints_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
    '    rtbResult.Text = SharedDB.Getstats(dtpStats.Value, OGameObject.SharingDB.enTypeStat.points)
    'End Sub

    'Private Sub btnGetStatsFlotte_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
    '    rtbResult.Text = SharedDB.Getstats(dtpStats.Value, OGameObject.SharingDB.enTypeStat.flotte)
    'End Sub


    'Private Sub btnGetStatResearch_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
    '    rtbResult.Text = SharedDB.Getstats(dtpStats.Value, OGameObject.SharingDB.enTypeStat.research)
    'End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        Dim u As New OGameObject.ImportExportForm
        u.ShowDialog()
    End Sub
End Class
