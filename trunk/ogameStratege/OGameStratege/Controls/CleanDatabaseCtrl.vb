Public Class CleanDatabaseCtrl
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
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents tpInformation As System.Windows.Forms.TabPage
    Friend WithEvents tpRankings As System.Windows.Forms.TabPage
    Friend WithEvents panCommands As System.Windows.Forms.Panel
    Friend WithEvents lblUniverseName As OGameStratege.LabelBox
    Friend WithEvents lblDBFileName As OGameStratege.LabelBox
    Friend WithEvents lblIsDefault As OGameStratege.LabelBox
    Friend WithEvents lblServerUrl As OGameStratege.LabelBox
    Friend WithEvents gbUniverseInformation As System.Windows.Forms.GroupBox
    Friend WithEvents lbbRemoteAccount As OGameStratege.LabelBox
    Friend WithEvents GroupBox1 As System.Windows.Forms.GroupBox
    Friend WithEvents lbbDataBaseSize As OGameStratege.LabelBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents tcControl As System.Windows.Forms.TabControl
    Friend WithEvents tpPurge As System.Windows.Forms.TabPage
    Friend WithEvents btnSpyDelete As System.Windows.Forms.Button
    Friend WithEvents dtpEraseSpySince As System.Windows.Forms.DateTimePicker
    Friend WithEvents btnPlayerDelete As System.Windows.Forms.Button
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(CleanDatabaseCtrl))
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.tcControl = New System.Windows.Forms.TabControl
        Me.tpInformation = New System.Windows.Forms.TabPage
        Me.GroupBox1 = New System.Windows.Forms.GroupBox
        Me.lbbDataBaseSize = New OGameStratege.LabelBox
        Me.gbUniverseInformation = New System.Windows.Forms.GroupBox
        Me.lbbRemoteAccount = New OGameStratege.LabelBox
        Me.lblServerUrl = New OGameStratege.LabelBox
        Me.lblIsDefault = New OGameStratege.LabelBox
        Me.lblDBFileName = New OGameStratege.LabelBox
        Me.lblUniverseName = New OGameStratege.LabelBox
        Me.panCommands = New System.Windows.Forms.Panel
        Me.Button1 = New System.Windows.Forms.Button
        Me.tpRankings = New System.Windows.Forms.TabPage
        Me.tpPurge = New System.Windows.Forms.TabPage
        Me.dtpEraseSpySince = New System.Windows.Forms.DateTimePicker
        Me.btnSpyDelete = New System.Windows.Forms.Button
        Me.btnPlayerDelete = New System.Windows.Forms.Button
        Me.Label1 = New System.Windows.Forms.Label
        Me.Panel1.SuspendLayout()
        Me.tcControl.SuspendLayout()
        Me.tpInformation.SuspendLayout()
        Me.GroupBox1.SuspendLayout()
        Me.gbUniverseInformation.SuspendLayout()
        Me.panCommands.SuspendLayout()
        Me.tpPurge.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.tcControl)
        Me.Panel1.Controls.Add(Me.Label1)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(640, 328)
        Me.Panel1.TabIndex = 0
        '
        'tcControl
        '
        Me.tcControl.Controls.Add(Me.tpInformation)
        Me.tcControl.Controls.Add(Me.tpRankings)
        Me.tcControl.Controls.Add(Me.tpPurge)
        Me.tcControl.Dock = System.Windows.Forms.DockStyle.Fill
        Me.tcControl.Location = New System.Drawing.Point(0, 23)
        Me.tcControl.Name = "tcControl"
        Me.tcControl.SelectedIndex = 0
        Me.tcControl.Size = New System.Drawing.Size(640, 305)
        Me.tcControl.TabIndex = 1
        '
        'tpInformation
        '
        Me.tpInformation.Controls.Add(Me.GroupBox1)
        Me.tpInformation.Controls.Add(Me.gbUniverseInformation)
        Me.tpInformation.Controls.Add(Me.panCommands)
        Me.tpInformation.DockPadding.All = 4
        Me.tpInformation.Location = New System.Drawing.Point(4, 22)
        Me.tpInformation.Name = "tpInformation"
        Me.tpInformation.Size = New System.Drawing.Size(632, 279)
        Me.tpInformation.TabIndex = 0
        Me.tpInformation.Text = "Informations"
        '
        'GroupBox1
        '
        Me.GroupBox1.Controls.Add(Me.lbbDataBaseSize)
        Me.GroupBox1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.GroupBox1.Location = New System.Drawing.Point(4, 112)
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.Size = New System.Drawing.Size(624, 99)
        Me.GroupBox1.TabIndex = 3
        Me.GroupBox1.TabStop = False
        Me.GroupBox1.Text = "Database Information"
        '
        'lbbDataBaseSize
        '
        Me.lbbDataBaseSize.Caption = "Database Size"
        Me.lbbDataBaseSize.CaptionWidth = 100
        Me.lbbDataBaseSize.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbDataBaseSize.Location = New System.Drawing.Point(3, 16)
        Me.lbbDataBaseSize.Name = "lbbDataBaseSize"
        Me.lbbDataBaseSize.ReadOnly = True
        Me.lbbDataBaseSize.Size = New System.Drawing.Size(618, 18)
        Me.lbbDataBaseSize.TabIndex = 7
        Me.lbbDataBaseSize.Value = ""
        '
        'gbUniverseInformation
        '
        Me.gbUniverseInformation.Controls.Add(Me.lbbRemoteAccount)
        Me.gbUniverseInformation.Controls.Add(Me.lblServerUrl)
        Me.gbUniverseInformation.Controls.Add(Me.lblIsDefault)
        Me.gbUniverseInformation.Controls.Add(Me.lblDBFileName)
        Me.gbUniverseInformation.Controls.Add(Me.lblUniverseName)
        Me.gbUniverseInformation.Dock = System.Windows.Forms.DockStyle.Top
        Me.gbUniverseInformation.Location = New System.Drawing.Point(4, 4)
        Me.gbUniverseInformation.Name = "gbUniverseInformation"
        Me.gbUniverseInformation.Size = New System.Drawing.Size(624, 108)
        Me.gbUniverseInformation.TabIndex = 2
        Me.gbUniverseInformation.TabStop = False
        Me.gbUniverseInformation.Text = "Universe Information"
        '
        'lbbRemoteAccount
        '
        Me.lbbRemoteAccount.Caption = "Remote Accounts"
        Me.lbbRemoteAccount.CaptionWidth = 100
        Me.lbbRemoteAccount.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbRemoteAccount.Location = New System.Drawing.Point(3, 88)
        Me.lbbRemoteAccount.Name = "lbbRemoteAccount"
        Me.lbbRemoteAccount.ReadOnly = True
        Me.lbbRemoteAccount.Size = New System.Drawing.Size(618, 18)
        Me.lbbRemoteAccount.TabIndex = 6
        Me.lbbRemoteAccount.Value = ""
        '
        'lblServerUrl
        '
        Me.lblServerUrl.Caption = "Universe Name"
        Me.lblServerUrl.CaptionWidth = 100
        Me.lblServerUrl.Dock = System.Windows.Forms.DockStyle.Top
        Me.lblServerUrl.Location = New System.Drawing.Point(3, 70)
        Me.lblServerUrl.Name = "lblServerUrl"
        Me.lblServerUrl.ReadOnly = True
        Me.lblServerUrl.Size = New System.Drawing.Size(618, 18)
        Me.lblServerUrl.TabIndex = 5
        Me.lblServerUrl.Value = ""
        '
        'lblIsDefault
        '
        Me.lblIsDefault.Caption = "Is Default"
        Me.lblIsDefault.CaptionWidth = 100
        Me.lblIsDefault.Dock = System.Windows.Forms.DockStyle.Top
        Me.lblIsDefault.Location = New System.Drawing.Point(3, 52)
        Me.lblIsDefault.Name = "lblIsDefault"
        Me.lblIsDefault.ReadOnly = True
        Me.lblIsDefault.Size = New System.Drawing.Size(618, 18)
        Me.lblIsDefault.TabIndex = 4
        Me.lblIsDefault.Value = ""
        '
        'lblDBFileName
        '
        Me.lblDBFileName.Caption = "DB FileName"
        Me.lblDBFileName.CaptionWidth = 100
        Me.lblDBFileName.Dock = System.Windows.Forms.DockStyle.Top
        Me.lblDBFileName.Location = New System.Drawing.Point(3, 34)
        Me.lblDBFileName.Name = "lblDBFileName"
        Me.lblDBFileName.ReadOnly = True
        Me.lblDBFileName.Size = New System.Drawing.Size(618, 18)
        Me.lblDBFileName.TabIndex = 3
        Me.lblDBFileName.Value = ""
        '
        'lblUniverseName
        '
        Me.lblUniverseName.Caption = "Universe Name"
        Me.lblUniverseName.CaptionWidth = 100
        Me.lblUniverseName.Dock = System.Windows.Forms.DockStyle.Top
        Me.lblUniverseName.Location = New System.Drawing.Point(3, 16)
        Me.lblUniverseName.Name = "lblUniverseName"
        Me.lblUniverseName.ReadOnly = True
        Me.lblUniverseName.Size = New System.Drawing.Size(618, 18)
        Me.lblUniverseName.TabIndex = 2
        Me.lblUniverseName.Value = ""
        '
        'panCommands
        '
        Me.panCommands.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panCommands.Controls.Add(Me.Button1)
        Me.panCommands.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.panCommands.Location = New System.Drawing.Point(4, 211)
        Me.panCommands.Name = "panCommands"
        Me.panCommands.Size = New System.Drawing.Size(624, 64)
        Me.panCommands.TabIndex = 0
        '
        'Button1
        '
        Me.Button1.Image = CType(resources.GetObject("Button1.Image"), System.Drawing.Image)
        Me.Button1.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft
        Me.Button1.Location = New System.Drawing.Point(24, 8)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(96, 48)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Refresh"
        Me.Button1.TextAlign = System.Drawing.ContentAlignment.MiddleRight
        '
        'tpRankings
        '
        Me.tpRankings.Location = New System.Drawing.Point(4, 22)
        Me.tpRankings.Name = "tpRankings"
        Me.tpRankings.Size = New System.Drawing.Size(632, 279)
        Me.tpRankings.TabIndex = 3
        Me.tpRankings.Text = "Rankings"
        '
        'tpPurge
        '
        Me.tpPurge.Controls.Add(Me.dtpEraseSpySince)
        Me.tpPurge.Controls.Add(Me.btnSpyDelete)
        Me.tpPurge.Controls.Add(Me.btnPlayerDelete)
        Me.tpPurge.Location = New System.Drawing.Point(4, 22)
        Me.tpPurge.Name = "tpPurge"
        Me.tpPurge.Size = New System.Drawing.Size(632, 279)
        Me.tpPurge.TabIndex = 4
        Me.tpPurge.Text = "Purge"
        '
        'dtpEraseSpySince
        '
        Me.dtpEraseSpySince.CustomFormat = "dddd dd MMMMyyy hh:mm:ss"
        Me.dtpEraseSpySince.Format = System.Windows.Forms.DateTimePickerFormat.Custom
        Me.dtpEraseSpySince.Location = New System.Drawing.Point(384, 16)
        Me.dtpEraseSpySince.Name = "dtpEraseSpySince"
        Me.dtpEraseSpySince.Size = New System.Drawing.Size(224, 20)
        Me.dtpEraseSpySince.TabIndex = 1
        '
        'btnSpyDelete
        '
        Me.btnSpyDelete.Location = New System.Drawing.Point(16, 16)
        Me.btnSpyDelete.Name = "btnSpyDelete"
        Me.btnSpyDelete.Size = New System.Drawing.Size(344, 23)
        Me.btnSpyDelete.TabIndex = 0
        Me.btnSpyDelete.Text = "Effacer les rapports d'espionnages antérieur au"
        '
        'btnPlayerDelete
        '
        Me.btnPlayerDelete.Location = New System.Drawing.Point(16, 56)
        Me.btnPlayerDelete.Name = "btnPlayerDelete"
        Me.btnPlayerDelete.Size = New System.Drawing.Size(344, 23)
        Me.btnPlayerDelete.TabIndex = 0
        Me.btnPlayerDelete.Text = "Effacer les joueurs sans données (ni stats, ni planètes)"
        '
        'Label1
        '
        Me.Label1.BackColor = System.Drawing.Color.Firebrick
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.Font = New System.Drawing.Font("Comic Sans MS", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.ForeColor = System.Drawing.Color.White
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(640, 23)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Warning : Modifications are not reversible"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'CleanDatabaseCtrl
        '
        Me.Controls.Add(Me.Panel1)
        Me.Name = "CleanDatabaseCtrl"
        Me.Size = New System.Drawing.Size(640, 328)
        Me.Panel1.ResumeLayout(False)
        Me.tcControl.ResumeLayout(False)
        Me.tpInformation.ResumeLayout(False)
        Me.GroupBox1.ResumeLayout(False)
        Me.gbUniverseInformation.ResumeLayout(False)
        Me.panCommands.ResumeLayout(False)
        Me.tpPurge.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub CleanDatabaseCtrl_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        dtpEraseSpySince.Value = Now.Subtract(New System.TimeSpan(30, 0, 0, 0))
    End Sub

    Protected Sub LoadUniverseInfo()
        If OGameObject.OGameDBEngine.Default Is Nothing Then Return
        With OGameObject.OGameDBEngine.Default.Universe
            lblUniverseName.Value = .UniverseName
            lblDBFileName.Value = .DBFileName
            lblIsDefault.Value = IIf(.DefaultUniverse, "Yes", "No")
            lblServerUrl.Value = .ServerURL
            lbbRemoteAccount.Value = .RemoteAccounts.Count & " Remote accounts configured"


        End With
        With OGameObject.OGameDBEngine.Default
            Dim fif As New System.IO.FileInfo(.Universe.DBFileName)
            If fif.Exists Then
                lbbDataBaseSize.Value = fif.Length & " bytes "
            End If

        End With

    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        LoadUniverseInfo()
    End Sub


    Private Sub lblPlayerID_Load(ByVal sender As System.Object, ByVal e As System.EventArgs)

    End Sub

    Private Sub btnSpyDelete_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSpyDelete.Click
        If OGameObject.OGameDBEngine.Default Is Nothing Then Return
        If MessageBox.Show(MainForm.TopForm, "Etes-vous sûr de vouloir effacer tout les rapports d'espionnage dont la date est antérieure au " & dtpEraseSpySince.Value.ToString & " ?", "Confirmation de purge des rapports d'espionnage:", MessageBoxButtons.YesNo, MessageBoxIcon.Question) = DialogResult.Yes Then
            With OGameObject.OGameDBEngine.Default
                MessageBox.Show(MainForm.TopForm, .PurgeSpyReportSince(dtpEraseSpySince.Value) & " rapports d'espionnage effacés.", "Purge des rapports d'espionage depuis le " & dtpEraseSpySince.Value.ToString)
            End With
        End If
    End Sub



    Private Sub btnPlayerDelete_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnPlayerDelete.Click

    End Sub
End Class
