Public Class OGSpyInterface
    Inherits System.Windows.Forms.Form

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call

    End Sub

    'Form overrides dispose to clean up the component list.
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
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents Panel3 As System.Windows.Forms.Panel
    Friend WithEvents TabControl1 As System.Windows.Forms.TabControl
    Friend WithEvents TabPage1 As System.Windows.Forms.TabPage
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents cbAccounts As System.Windows.Forms.ComboBox
    Friend WithEvents tbResult As System.Windows.Forms.RichTextBox
    Friend WithEvents lbbServerName As OGameStratege.LabelBox
    Friend WithEvents lbbVersion As OGameStratege.LabelBox
    Friend WithEvents lbbImport As OGameStratege.LabelBox
    Friend WithEvents lbbExport As OGameStratege.LabelBox
    Friend WithEvents TabPage2 As System.Windows.Forms.TabPage
    Friend WithEvents ServerPlayerStatsInfoCtrl1 As OGameStratege.ServerPlayerStatsInfoCtrl
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents btnPoints As System.Windows.Forms.Button
    Friend WithEvents btnFlotte As System.Windows.Forms.Button
    Friend WithEvents Button5 As System.Windows.Forms.Button
    Friend WithEvents Button6 As System.Windows.Forms.Button
    Friend WithEvents btnResearch As System.Windows.Forms.Button
    Friend WithEvents tpKyser As System.Windows.Forms.TabPage
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents cbKyserCommand As System.Windows.Forms.ComboBox
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents cbKyserPost As System.Windows.Forms.ComboBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(OGSpyInterface))
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.Button1 = New System.Windows.Forms.Button
        Me.cbAccounts = New System.Windows.Forms.ComboBox
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.tbResult = New System.Windows.Forms.RichTextBox
        Me.Panel3 = New System.Windows.Forms.Panel
        Me.TabControl1 = New System.Windows.Forms.TabControl
        Me.TabPage1 = New System.Windows.Forms.TabPage
        Me.lbbImport = New OGameStratege.LabelBox
        Me.lbbVersion = New OGameStratege.LabelBox
        Me.lbbServerName = New OGameStratege.LabelBox
        Me.lbbExport = New OGameStratege.LabelBox
        Me.TabPage2 = New System.Windows.Forms.TabPage
        Me.btnPoints = New System.Windows.Forms.Button
        Me.Button2 = New System.Windows.Forms.Button
        Me.ServerPlayerStatsInfoCtrl1 = New OGameStratege.ServerPlayerStatsInfoCtrl
        Me.btnFlotte = New System.Windows.Forms.Button
        Me.Button5 = New System.Windows.Forms.Button
        Me.Button6 = New System.Windows.Forms.Button
        Me.btnResearch = New System.Windows.Forms.Button
        Me.tpKyser = New System.Windows.Forms.TabPage
        Me.Label1 = New System.Windows.Forms.Label
        Me.cbKyserCommand = New System.Windows.Forms.ComboBox
        Me.Button3 = New System.Windows.Forms.Button
        Me.Label2 = New System.Windows.Forms.Label
        Me.cbKyserPost = New System.Windows.Forms.ComboBox
        Me.Panel1.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.Panel3.SuspendLayout()
        Me.TabControl1.SuspendLayout()
        Me.TabPage1.SuspendLayout()
        Me.TabPage2.SuspendLayout()
        Me.tpKyser.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.Button1)
        Me.Panel1.Controls.Add(Me.cbAccounts)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(584, 24)
        Me.Panel1.TabIndex = 0
        '
        'Button1
        '
        Me.Button1.Dock = System.Windows.Forms.DockStyle.Left
        Me.Button1.Location = New System.Drawing.Point(200, 0)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(75, 24)
        Me.Button1.TabIndex = 1
        Me.Button1.Text = "Connect"
        '
        'cbAccounts
        '
        Me.cbAccounts.Dock = System.Windows.Forms.DockStyle.Left
        Me.cbAccounts.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbAccounts.Location = New System.Drawing.Point(0, 0)
        Me.cbAccounts.Name = "cbAccounts"
        Me.cbAccounts.Size = New System.Drawing.Size(200, 21)
        Me.cbAccounts.TabIndex = 0
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.tbResult)
        Me.Panel2.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.Panel2.Location = New System.Drawing.Point(0, 174)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(584, 120)
        Me.Panel2.TabIndex = 1
        '
        'tbResult
        '
        Me.tbResult.Dock = System.Windows.Forms.DockStyle.Fill
        Me.tbResult.Location = New System.Drawing.Point(0, 0)
        Me.tbResult.Name = "tbResult"
        Me.tbResult.Size = New System.Drawing.Size(584, 120)
        Me.tbResult.TabIndex = 0
        Me.tbResult.Text = "RichTextBox1"
        '
        'Panel3
        '
        Me.Panel3.Controls.Add(Me.TabControl1)
        Me.Panel3.Dock = System.Windows.Forms.DockStyle.Fill
        Me.Panel3.Location = New System.Drawing.Point(0, 24)
        Me.Panel3.Name = "Panel3"
        Me.Panel3.Size = New System.Drawing.Size(584, 150)
        Me.Panel3.TabIndex = 2
        '
        'TabControl1
        '
        Me.TabControl1.Controls.Add(Me.TabPage1)
        Me.TabControl1.Controls.Add(Me.TabPage2)
        Me.TabControl1.Controls.Add(Me.tpKyser)
        Me.TabControl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.TabControl1.Location = New System.Drawing.Point(0, 0)
        Me.TabControl1.Name = "TabControl1"
        Me.TabControl1.SelectedIndex = 0
        Me.TabControl1.Size = New System.Drawing.Size(584, 150)
        Me.TabControl1.TabIndex = 0
        '
        'TabPage1
        '
        Me.TabPage1.Controls.Add(Me.lbbImport)
        Me.TabPage1.Controls.Add(Me.lbbVersion)
        Me.TabPage1.Controls.Add(Me.lbbServerName)
        Me.TabPage1.Controls.Add(Me.lbbExport)
        Me.TabPage1.Location = New System.Drawing.Point(4, 22)
        Me.TabPage1.Name = "TabPage1"
        Me.TabPage1.Size = New System.Drawing.Size(576, 124)
        Me.TabPage1.TabIndex = 0
        Me.TabPage1.Text = "Connection"
        '
        'lbbImport
        '
        Me.lbbImport.Caption = "Import"
        Me.lbbImport.CaptionWidth = 80
        Me.lbbImport.Location = New System.Drawing.Point(0, 48)
        Me.lbbImport.Name = "lbbImport"
        Me.lbbImport.ReadOnly = False
        Me.lbbImport.Size = New System.Drawing.Size(288, 18)
        Me.lbbImport.TabIndex = 2
        Me.lbbImport.Value = ""
        '
        'lbbVersion
        '
        Me.lbbVersion.Caption = "Version"
        Me.lbbVersion.CaptionWidth = 80
        Me.lbbVersion.Location = New System.Drawing.Point(0, 24)
        Me.lbbVersion.Name = "lbbVersion"
        Me.lbbVersion.ReadOnly = False
        Me.lbbVersion.Size = New System.Drawing.Size(288, 18)
        Me.lbbVersion.TabIndex = 1
        Me.lbbVersion.Value = ""
        '
        'lbbServerName
        '
        Me.lbbServerName.Caption = "Server Name"
        Me.lbbServerName.CaptionWidth = 80
        Me.lbbServerName.Location = New System.Drawing.Point(0, 0)
        Me.lbbServerName.Name = "lbbServerName"
        Me.lbbServerName.ReadOnly = False
        Me.lbbServerName.Size = New System.Drawing.Size(288, 18)
        Me.lbbServerName.TabIndex = 0
        Me.lbbServerName.Value = ""
        '
        'lbbExport
        '
        Me.lbbExport.Caption = "Export"
        Me.lbbExport.CaptionWidth = 80
        Me.lbbExport.Location = New System.Drawing.Point(0, 72)
        Me.lbbExport.Name = "lbbExport"
        Me.lbbExport.ReadOnly = False
        Me.lbbExport.Size = New System.Drawing.Size(288, 18)
        Me.lbbExport.TabIndex = 2
        Me.lbbExport.Value = ""
        '
        'TabPage2
        '
        Me.TabPage2.Controls.Add(Me.btnPoints)
        Me.TabPage2.Controls.Add(Me.Button2)
        Me.TabPage2.Controls.Add(Me.ServerPlayerStatsInfoCtrl1)
        Me.TabPage2.Controls.Add(Me.btnFlotte)
        Me.TabPage2.Controls.Add(Me.Button5)
        Me.TabPage2.Controls.Add(Me.Button6)
        Me.TabPage2.Controls.Add(Me.btnResearch)
        Me.TabPage2.Location = New System.Drawing.Point(4, 22)
        Me.TabPage2.Name = "TabPage2"
        Me.TabPage2.Size = New System.Drawing.Size(576, 124)
        Me.TabPage2.TabIndex = 1
        Me.TabPage2.Text = "Statistics"
        '
        'btnPoints
        '
        Me.btnPoints.Enabled = False
        Me.btnPoints.Location = New System.Drawing.Point(312, 64)
        Me.btnPoints.Name = "btnPoints"
        Me.btnPoints.Size = New System.Drawing.Size(64, 23)
        Me.btnPoints.TabIndex = 2
        Me.btnPoints.Text = "Points"
        '
        'Button2
        '
        Me.Button2.Location = New System.Drawing.Point(312, 16)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(240, 23)
        Me.Button2.TabIndex = 1
        Me.Button2.Text = "Read Server Stats Info"
        '
        'ServerPlayerStatsInfoCtrl1
        '
        Me.ServerPlayerStatsInfoCtrl1.Dock = System.Windows.Forms.DockStyle.Left
        Me.ServerPlayerStatsInfoCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.ServerPlayerStatsInfoCtrl1.Name = "ServerPlayerStatsInfoCtrl1"
        Me.ServerPlayerStatsInfoCtrl1.Size = New System.Drawing.Size(296, 124)
        Me.ServerPlayerStatsInfoCtrl1.TabIndex = 0
        '
        'btnFlotte
        '
        Me.btnFlotte.Enabled = False
        Me.btnFlotte.Location = New System.Drawing.Point(384, 64)
        Me.btnFlotte.Name = "btnFlotte"
        Me.btnFlotte.Size = New System.Drawing.Size(64, 23)
        Me.btnFlotte.TabIndex = 2
        Me.btnFlotte.Text = "Flotte"
        '
        'Button5
        '
        Me.Button5.Location = New System.Drawing.Point(312, 16)
        Me.Button5.Name = "Button5"
        Me.Button5.Size = New System.Drawing.Size(240, 23)
        Me.Button5.TabIndex = 1
        Me.Button5.Text = "Read Server Stats Info"
        '
        'Button6
        '
        Me.Button6.Enabled = False
        Me.Button6.Location = New System.Drawing.Point(384, 64)
        Me.Button6.Name = "Button6"
        Me.Button6.Size = New System.Drawing.Size(64, 23)
        Me.Button6.TabIndex = 2
        Me.Button6.Text = "Points"
        '
        'btnResearch
        '
        Me.btnResearch.Enabled = False
        Me.btnResearch.Location = New System.Drawing.Point(456, 64)
        Me.btnResearch.Name = "btnResearch"
        Me.btnResearch.Size = New System.Drawing.Size(64, 23)
        Me.btnResearch.TabIndex = 2
        Me.btnResearch.Text = "Research"
        '
        'tpKyser
        '
        Me.tpKyser.Controls.Add(Me.Button3)
        Me.tpKyser.Controls.Add(Me.cbKyserCommand)
        Me.tpKyser.Controls.Add(Me.Label1)
        Me.tpKyser.Controls.Add(Me.cbKyserPost)
        Me.tpKyser.Controls.Add(Me.Label2)
        Me.tpKyser.Location = New System.Drawing.Point(4, 22)
        Me.tpKyser.Name = "tpKyser"
        Me.tpKyser.Size = New System.Drawing.Size(576, 124)
        Me.tpKyser.TabIndex = 2
        Me.tpKyser.Text = "Kyser"
        '
        'Label1
        '
        Me.Label1.Location = New System.Drawing.Point(0, 8)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(96, 16)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "action="
        '
        'cbKyserCommand
        '
        Me.cbKyserCommand.Location = New System.Drawing.Point(48, 8)
        Me.cbKyserCommand.Name = "cbKyserCommand"
        Me.cbKyserCommand.Size = New System.Drawing.Size(352, 21)
        Me.cbKyserCommand.TabIndex = 1
        '
        'Button3
        '
        Me.Button3.Location = New System.Drawing.Point(152, 72)
        Me.Button3.Name = "Button3"
        Me.Button3.Size = New System.Drawing.Size(120, 23)
        Me.Button3.TabIndex = 2
        Me.Button3.Text = "Kyser Debug"
        '
        'Label2
        '
        Me.Label2.Location = New System.Drawing.Point(0, 32)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(96, 16)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "(post)"
        '
        'cbKyserPost
        '
        Me.cbKyserPost.Location = New System.Drawing.Point(48, 32)
        Me.cbKyserPost.Name = "cbKyserPost"
        Me.cbKyserPost.Size = New System.Drawing.Size(352, 21)
        Me.cbKyserPost.TabIndex = 1
        '
        'OGSpyInterface
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(584, 294)
        Me.Controls.Add(Me.Panel3)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.Panel1)
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.Name = "OGSpyInterface"
        Me.Text = "OGSpy Interface"
        Me.Panel1.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.Panel3.ResumeLayout(False)
        Me.TabControl1.ResumeLayout(False)
        Me.TabPage1.ResumeLayout(False)
        Me.TabPage2.ResumeLayout(False)
        Me.tpKyser.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub OGSpyInterface_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        If OGameObject.OGameDBEngine.Default Is Nothing Then Return
        cbAccounts.Items.Clear()
        For Each s As OGameObject.RemoteAccount In OGameObject.OGameDBEngine.Default.Universe.RemoteAccounts
            cbAccounts.Items.Add(s)
            If s.DefaultAccount Then cbAccounts.SelectedItem = s
        Next
        If cbAccounts.SelectedItem Is Nothing Then
            If OGameObject.OGameDBEngine.Default.Universe.RemoteAccounts.Count Then
                cbAccounts.SelectedIndex = 0
            End If
        End If
    End Sub
    Private pSHaredDB As OGameObject.SharingDB = Nothing
    Public ReadOnly Property SharedDB() As OGameObject.SharingDB
        Get
            If pSHaredDB Is Nothing Then
                If cbAccounts.SelectedItem Is Nothing Then
                    If Not Me.DesignMode Then MessageBox.Show(MainForm.TopForm, "No Remote Account selected")
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
    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        If cbAccounts.SelectedItem Is Nothing Then Return
        With CType(cbAccounts.SelectedItem, OGameObject.RemoteAccount)
            If SharedDB.Login() Then
                lbbServerName.Value = SharedDB.servername
                lbbVersion.Value = SharedDB.serverversion
                lbbImport.Value = IIf(SharedDB.authorized_toimport, "Allowed", "Forbiden")
                lbbExport.Value = IIf(SharedDB.authorized_toexport, "Allowed", "Forbiden")
            End If
            tbResult.Text = SharedDB.LastPageReadedData
        End With
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        ServerPlayerStatsInfoCtrl1.OGSPYStatInfo = SharedDB.GetStatsInfo
        tbResult.Text = SharedDB.LastPageReadedData
    End Sub

    Private Sub ServerPlayerStatsInfoCtrl1_StatDataSelected(ByVal sender As ServerPlayerStatsInfoCtrl, ByVal thedate As String, ByVal StatsAvail As String) Handles ServerPlayerStatsInfoCtrl1.StatDataSelected
        btnFlotte.Enabled = True
        btnPoints.Enabled = True
        btnResearch.Enabled = True
    End Sub

    Private Sub btnPoints_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnPoints.Click
        tbResult.Text = SharedDB.GetstatsFromDateString(ServerPlayerStatsInfoCtrl1.StatDateValue, OGameObject.SharingDB.enTypeStat.points)
    End Sub

    Private Sub btnFlotte_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnFlotte.Click
        tbResult.Text = SharedDB.GetstatsFromDateString(ServerPlayerStatsInfoCtrl1.StatDateValue, OGameObject.SharingDB.enTypeStat.flotte)
    End Sub

    Private Sub btnResearch_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnResearch.Click
        tbResult.Text = SharedDB.GetstatsFromDateString(ServerPlayerStatsInfoCtrl1.StatDateValue, OGameObject.SharingDB.enTypeStat.research)
    End Sub

    Private Sub cbAccounts_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbAccounts.SelectedIndexChanged
        pSHaredDB = Nothing
    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        If cbKyserCommand.Items.IndexOf(cbKyserCommand.Text) < 0 Then
            cbKyserCommand.Items.Add(cbKyserCommand.Text)
        End If
        If cbKyserPost.Items.IndexOf(cbKyserPost.Text) < 0 Then
            cbKyserPost.Items.Add(cbKyserPost.Text)
        End If
        tbResult.Text = SharedDB.POST(cbKyserCommand.Text, cbKyserPost.Text)
    End Sub
End Class
