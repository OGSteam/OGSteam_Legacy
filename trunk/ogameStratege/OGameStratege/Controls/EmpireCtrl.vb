Public Class EmpireCtrl
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
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents panSubMain As System.Windows.Forms.Panel
    Friend WithEvents tcMyEmpire As System.Windows.Forms.TabControl
    Friend WithEvents tpOverview As System.Windows.Forms.TabPage
    Friend WithEvents panWhoAmi As System.Windows.Forms.Panel
    Friend WithEvents panWhoamiHeader As System.Windows.Forms.Panel
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents gbStatistics As System.Windows.Forms.GroupBox
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents lbStatDate As System.Windows.Forms.Label
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents lbGlobalRank As System.Windows.Forms.Label
    Friend WithEvents lbGlobalPoints As System.Windows.Forms.Label
    Friend WithEvents lbFlotteRank As System.Windows.Forms.Label
    Friend WithEvents lbFlottePoints As System.Windows.Forms.Label
    Friend WithEvents Label12 As System.Windows.Forms.Label
    Friend WithEvents Label13 As System.Windows.Forms.Label
    Friend WithEvents lbResearchRank As System.Windows.Forms.Label
    Friend WithEvents lbResearchPoints As System.Windows.Forms.Label
    Friend WithEvents Label16 As System.Windows.Forms.Label
    Friend WithEvents tpPlanets As System.Windows.Forms.TabPage
    Friend WithEvents tbAlliance As System.Windows.Forms.TextBox
    Friend WithEvents tbPlayerName As System.Windows.Forms.TextBox
    Friend WithEvents dgAllRanks As System.Windows.Forms.DataGrid
    Friend WithEvents btnSave As System.Windows.Forms.Button
    Friend WithEvents PanPlanetsHeader As System.Windows.Forms.Panel
    Friend WithEvents panPlanets As System.Windows.Forms.Panel
    Friend WithEvents RichTextBox1 As System.Windows.Forms.RichTextBox
    Public WithEvents PlanetInfoFound As OGameStratege.PlanetCtrl
    Friend WithEvents btnMergeSpyData As System.Windows.Forms.Button
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.panMain = New System.Windows.Forms.Panel
        Me.panSubMain = New System.Windows.Forms.Panel
        Me.tcMyEmpire = New System.Windows.Forms.TabControl
        Me.tpOverview = New System.Windows.Forms.TabPage
        Me.gbStatistics = New System.Windows.Forms.GroupBox
        Me.dgAllRanks = New System.Windows.Forms.DataGrid
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.Label6 = New System.Windows.Forms.Label
        Me.lbStatDate = New System.Windows.Forms.Label
        Me.Label5 = New System.Windows.Forms.Label
        Me.Label7 = New System.Windows.Forms.Label
        Me.lbGlobalRank = New System.Windows.Forms.Label
        Me.lbGlobalPoints = New System.Windows.Forms.Label
        Me.lbFlotteRank = New System.Windows.Forms.Label
        Me.lbFlottePoints = New System.Windows.Forms.Label
        Me.Label12 = New System.Windows.Forms.Label
        Me.Label13 = New System.Windows.Forms.Label
        Me.lbResearchRank = New System.Windows.Forms.Label
        Me.lbResearchPoints = New System.Windows.Forms.Label
        Me.Label16 = New System.Windows.Forms.Label
        Me.Label4 = New System.Windows.Forms.Label
        Me.panWhoAmi = New System.Windows.Forms.Panel
        Me.btnSave = New System.Windows.Forms.Button
        Me.tbAlliance = New System.Windows.Forms.TextBox
        Me.tbPlayerName = New System.Windows.Forms.TextBox
        Me.panWhoamiHeader = New System.Windows.Forms.Panel
        Me.Label3 = New System.Windows.Forms.Label
        Me.Label2 = New System.Windows.Forms.Label
        Me.tpPlanets = New System.Windows.Forms.TabPage
        Me.panPlanets = New System.Windows.Forms.Panel
        Me.PanPlanetsHeader = New System.Windows.Forms.Panel
        Me.PlanetInfoFound = New OGameStratege.PlanetCtrl
        Me.btnMergeSpyData = New System.Windows.Forms.Button
        Me.RichTextBox1 = New System.Windows.Forms.RichTextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.panMain.SuspendLayout()
        Me.panSubMain.SuspendLayout()
        Me.tcMyEmpire.SuspendLayout()
        Me.tpOverview.SuspendLayout()
        Me.gbStatistics.SuspendLayout()
        CType(Me.dgAllRanks, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel1.SuspendLayout()
        Me.panWhoAmi.SuspendLayout()
        Me.panWhoamiHeader.SuspendLayout()
        Me.tpPlanets.SuspendLayout()
        Me.PanPlanetsHeader.SuspendLayout()
        Me.SuspendLayout()
        '
        'panMain
        '
        Me.panMain.Controls.Add(Me.panSubMain)
        Me.panMain.Controls.Add(Me.Label1)
        Me.panMain.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panMain.Location = New System.Drawing.Point(0, 0)
        Me.panMain.Name = "panMain"
        Me.panMain.Size = New System.Drawing.Size(560, 336)
        Me.panMain.TabIndex = 0
        '
        'panSubMain
        '
        Me.panSubMain.Controls.Add(Me.tcMyEmpire)
        Me.panSubMain.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panSubMain.Location = New System.Drawing.Point(0, 16)
        Me.panSubMain.Name = "panSubMain"
        Me.panSubMain.Size = New System.Drawing.Size(560, 320)
        Me.panSubMain.TabIndex = 2
        '
        'tcMyEmpire
        '
        Me.tcMyEmpire.Controls.Add(Me.tpOverview)
        Me.tcMyEmpire.Controls.Add(Me.tpPlanets)
        Me.tcMyEmpire.Dock = System.Windows.Forms.DockStyle.Fill
        Me.tcMyEmpire.Location = New System.Drawing.Point(0, 0)
        Me.tcMyEmpire.Name = "tcMyEmpire"
        Me.tcMyEmpire.SelectedIndex = 0
        Me.tcMyEmpire.Size = New System.Drawing.Size(560, 320)
        Me.tcMyEmpire.TabIndex = 0
        '
        'tpOverview
        '
        Me.tpOverview.Controls.Add(Me.gbStatistics)
        Me.tpOverview.Controls.Add(Me.Label4)
        Me.tpOverview.Controls.Add(Me.panWhoAmi)
        Me.tpOverview.DockPadding.All = 4
        Me.tpOverview.Location = New System.Drawing.Point(4, 22)
        Me.tpOverview.Name = "tpOverview"
        Me.tpOverview.Size = New System.Drawing.Size(552, 294)
        Me.tpOverview.TabIndex = 0
        Me.tpOverview.Text = "Overview"
        '
        'gbStatistics
        '
        Me.gbStatistics.Controls.Add(Me.dgAllRanks)
        Me.gbStatistics.Controls.Add(Me.Panel1)
        Me.gbStatistics.Dock = System.Windows.Forms.DockStyle.Top
        Me.gbStatistics.Location = New System.Drawing.Point(4, 88)
        Me.gbStatistics.Name = "gbStatistics"
        Me.gbStatistics.Size = New System.Drawing.Size(544, 176)
        Me.gbStatistics.TabIndex = 3
        Me.gbStatistics.TabStop = False
        Me.gbStatistics.Text = "Statistics"
        '
        'dgAllRanks
        '
        Me.dgAllRanks.AlternatingBackColor = System.Drawing.Color.GhostWhite
        Me.dgAllRanks.BackColor = System.Drawing.Color.GhostWhite
        Me.dgAllRanks.BackgroundColor = System.Drawing.Color.Lavender
        Me.dgAllRanks.BorderStyle = System.Windows.Forms.BorderStyle.None
        Me.dgAllRanks.CaptionBackColor = System.Drawing.Color.RoyalBlue
        Me.dgAllRanks.CaptionFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgAllRanks.CaptionForeColor = System.Drawing.Color.White
        Me.dgAllRanks.CaptionVisible = False
        Me.dgAllRanks.DataMember = ""
        Me.dgAllRanks.Dock = System.Windows.Forms.DockStyle.Fill
        Me.dgAllRanks.FlatMode = True
        Me.dgAllRanks.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgAllRanks.ForeColor = System.Drawing.Color.MidnightBlue
        Me.dgAllRanks.GridLineColor = System.Drawing.Color.RoyalBlue
        Me.dgAllRanks.GridLineStyle = System.Windows.Forms.DataGridLineStyle.None
        Me.dgAllRanks.HeaderBackColor = System.Drawing.Color.MidnightBlue
        Me.dgAllRanks.HeaderFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgAllRanks.HeaderForeColor = System.Drawing.Color.Lavender
        Me.dgAllRanks.LinkColor = System.Drawing.Color.Teal
        Me.dgAllRanks.Location = New System.Drawing.Point(216, 16)
        Me.dgAllRanks.Name = "dgAllRanks"
        Me.dgAllRanks.ParentRowsBackColor = System.Drawing.Color.Lavender
        Me.dgAllRanks.ParentRowsForeColor = System.Drawing.Color.MidnightBlue
        Me.dgAllRanks.ReadOnly = True
        Me.dgAllRanks.RowHeaderWidth = 15
        Me.dgAllRanks.SelectionBackColor = System.Drawing.Color.Teal
        Me.dgAllRanks.SelectionForeColor = System.Drawing.Color.PaleGreen
        Me.dgAllRanks.Size = New System.Drawing.Size(325, 157)
        Me.dgAllRanks.TabIndex = 1
        '
        'Panel1
        '
        Me.Panel1.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Panel1.Controls.Add(Me.Label6)
        Me.Panel1.Controls.Add(Me.lbStatDate)
        Me.Panel1.Controls.Add(Me.Label5)
        Me.Panel1.Controls.Add(Me.Label7)
        Me.Panel1.Controls.Add(Me.lbGlobalRank)
        Me.Panel1.Controls.Add(Me.lbGlobalPoints)
        Me.Panel1.Controls.Add(Me.lbFlotteRank)
        Me.Panel1.Controls.Add(Me.lbFlottePoints)
        Me.Panel1.Controls.Add(Me.Label12)
        Me.Panel1.Controls.Add(Me.Label13)
        Me.Panel1.Controls.Add(Me.lbResearchRank)
        Me.Panel1.Controls.Add(Me.lbResearchPoints)
        Me.Panel1.Controls.Add(Me.Label16)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Left
        Me.Panel1.Location = New System.Drawing.Point(3, 16)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(213, 157)
        Me.Panel1.TabIndex = 0
        '
        'Label6
        '
        Me.Label6.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label6.Location = New System.Drawing.Point(80, 32)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(56, 15)
        Me.Label6.TabIndex = 5
        Me.Label6.Text = "Rank"
        Me.Label6.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'lbStatDate
        '
        Me.lbStatDate.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbStatDate.Location = New System.Drawing.Point(0, 16)
        Me.lbStatDate.Name = "lbStatDate"
        Me.lbStatDate.Size = New System.Drawing.Size(211, 16)
        Me.lbStatDate.TabIndex = 4
        Me.lbStatDate.Text = "date"
        '
        'Label5
        '
        Me.Label5.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label5.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label5.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label5.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label5.Location = New System.Drawing.Point(0, 0)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(211, 16)
        Me.Label5.TabIndex = 3
        Me.Label5.Text = "Last Known"
        Me.Label5.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label7
        '
        Me.Label7.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label7.Location = New System.Drawing.Point(144, 32)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(56, 15)
        Me.Label7.TabIndex = 5
        Me.Label7.Text = "Points"
        Me.Label7.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'lbGlobalRank
        '
        Me.lbGlobalRank.BackColor = System.Drawing.SystemColors.ControlLight
        Me.lbGlobalRank.Location = New System.Drawing.Point(80, 56)
        Me.lbGlobalRank.Name = "lbGlobalRank"
        Me.lbGlobalRank.Size = New System.Drawing.Size(56, 15)
        Me.lbGlobalRank.TabIndex = 5
        Me.lbGlobalRank.Text = "0"
        Me.lbGlobalRank.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'lbGlobalPoints
        '
        Me.lbGlobalPoints.BackColor = System.Drawing.SystemColors.ControlLight
        Me.lbGlobalPoints.Location = New System.Drawing.Point(144, 56)
        Me.lbGlobalPoints.Name = "lbGlobalPoints"
        Me.lbGlobalPoints.Size = New System.Drawing.Size(56, 15)
        Me.lbGlobalPoints.TabIndex = 5
        Me.lbGlobalPoints.Text = "0"
        Me.lbGlobalPoints.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'lbFlotteRank
        '
        Me.lbFlotteRank.BackColor = System.Drawing.SystemColors.ControlLight
        Me.lbFlotteRank.Location = New System.Drawing.Point(80, 80)
        Me.lbFlotteRank.Name = "lbFlotteRank"
        Me.lbFlotteRank.Size = New System.Drawing.Size(56, 15)
        Me.lbFlotteRank.TabIndex = 5
        Me.lbFlotteRank.Text = "0"
        Me.lbFlotteRank.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'lbFlottePoints
        '
        Me.lbFlottePoints.BackColor = System.Drawing.SystemColors.ControlLight
        Me.lbFlottePoints.Location = New System.Drawing.Point(144, 80)
        Me.lbFlottePoints.Name = "lbFlottePoints"
        Me.lbFlottePoints.Size = New System.Drawing.Size(56, 15)
        Me.lbFlottePoints.TabIndex = 5
        Me.lbFlottePoints.Text = "0"
        Me.lbFlottePoints.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label12
        '
        Me.Label12.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label12.Location = New System.Drawing.Point(8, 56)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(56, 15)
        Me.Label12.TabIndex = 5
        Me.Label12.Text = "Global"
        Me.Label12.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label13
        '
        Me.Label13.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label13.Location = New System.Drawing.Point(8, 80)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(56, 15)
        Me.Label13.TabIndex = 5
        Me.Label13.Text = "Flotte"
        Me.Label13.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'lbResearchRank
        '
        Me.lbResearchRank.BackColor = System.Drawing.SystemColors.ControlLight
        Me.lbResearchRank.Location = New System.Drawing.Point(80, 104)
        Me.lbResearchRank.Name = "lbResearchRank"
        Me.lbResearchRank.Size = New System.Drawing.Size(56, 15)
        Me.lbResearchRank.TabIndex = 5
        Me.lbResearchRank.Text = "0"
        Me.lbResearchRank.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'lbResearchPoints
        '
        Me.lbResearchPoints.BackColor = System.Drawing.SystemColors.ControlLight
        Me.lbResearchPoints.Location = New System.Drawing.Point(144, 104)
        Me.lbResearchPoints.Name = "lbResearchPoints"
        Me.lbResearchPoints.Size = New System.Drawing.Size(56, 15)
        Me.lbResearchPoints.TabIndex = 5
        Me.lbResearchPoints.Text = "0"
        Me.lbResearchPoints.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label16
        '
        Me.Label16.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label16.Location = New System.Drawing.Point(8, 104)
        Me.Label16.Name = "Label16"
        Me.Label16.Size = New System.Drawing.Size(56, 15)
        Me.Label16.TabIndex = 5
        Me.Label16.Text = "Research"
        Me.Label16.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label4
        '
        Me.Label4.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label4.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label4.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label4.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label4.Location = New System.Drawing.Point(4, 72)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(544, 16)
        Me.Label4.TabIndex = 2
        Me.Label4.Text = "Global Information"
        Me.Label4.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panWhoAmi
        '
        Me.panWhoAmi.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panWhoAmi.Controls.Add(Me.btnSave)
        Me.panWhoAmi.Controls.Add(Me.tbAlliance)
        Me.panWhoAmi.Controls.Add(Me.tbPlayerName)
        Me.panWhoAmi.Controls.Add(Me.panWhoamiHeader)
        Me.panWhoAmi.Dock = System.Windows.Forms.DockStyle.Top
        Me.panWhoAmi.Location = New System.Drawing.Point(4, 4)
        Me.panWhoAmi.Name = "panWhoAmi"
        Me.panWhoAmi.Size = New System.Drawing.Size(544, 68)
        Me.panWhoAmi.TabIndex = 0
        '
        'btnSave
        '
        Me.btnSave.Enabled = False
        Me.btnSave.Location = New System.Drawing.Point(256, 40)
        Me.btnSave.Name = "btnSave"
        Me.btnSave.TabIndex = 3
        Me.btnSave.Text = "Save"
        '
        'tbAlliance
        '
        Me.tbAlliance.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbAlliance.Location = New System.Drawing.Point(112, 20)
        Me.tbAlliance.Name = "tbAlliance"
        Me.tbAlliance.Size = New System.Drawing.Size(428, 20)
        Me.tbAlliance.TabIndex = 2
        Me.tbAlliance.Text = ""
        '
        'tbPlayerName
        '
        Me.tbPlayerName.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbPlayerName.Location = New System.Drawing.Point(112, 0)
        Me.tbPlayerName.Name = "tbPlayerName"
        Me.tbPlayerName.Size = New System.Drawing.Size(428, 20)
        Me.tbPlayerName.TabIndex = 1
        Me.tbPlayerName.Text = ""
        '
        'panWhoamiHeader
        '
        Me.panWhoamiHeader.Controls.Add(Me.Label3)
        Me.panWhoamiHeader.Controls.Add(Me.Label2)
        Me.panWhoamiHeader.Dock = System.Windows.Forms.DockStyle.Left
        Me.panWhoamiHeader.Location = New System.Drawing.Point(0, 0)
        Me.panWhoamiHeader.Name = "panWhoamiHeader"
        Me.panWhoamiHeader.Size = New System.Drawing.Size(112, 64)
        Me.panWhoamiHeader.TabIndex = 0
        '
        'Label3
        '
        Me.Label3.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label3.Location = New System.Drawing.Point(0, 20)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(112, 20)
        Me.Label3.TabIndex = 1
        Me.Label3.Text = "Alliance"
        Me.Label3.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label2
        '
        Me.Label2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label2.Location = New System.Drawing.Point(0, 0)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(112, 20)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "Name"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'tpPlanets
        '
        Me.tpPlanets.AutoScroll = True
        Me.tpPlanets.Controls.Add(Me.panPlanets)
        Me.tpPlanets.Controls.Add(Me.PanPlanetsHeader)
        Me.tpPlanets.Location = New System.Drawing.Point(4, 22)
        Me.tpPlanets.Name = "tpPlanets"
        Me.tpPlanets.Size = New System.Drawing.Size(552, 294)
        Me.tpPlanets.TabIndex = 1
        Me.tpPlanets.Text = "Planets"
        '
        'panPlanets
        '
        Me.panPlanets.AutoScroll = True
        Me.panPlanets.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panPlanets.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panPlanets.Location = New System.Drawing.Point(0, 88)
        Me.panPlanets.Name = "panPlanets"
        Me.panPlanets.Size = New System.Drawing.Size(552, 206)
        Me.panPlanets.TabIndex = 1
        '
        'PanPlanetsHeader
        '
        Me.PanPlanetsHeader.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.PanPlanetsHeader.Controls.Add(Me.PlanetInfoFound)
        Me.PanPlanetsHeader.Controls.Add(Me.btnMergeSpyData)
        Me.PanPlanetsHeader.Controls.Add(Me.RichTextBox1)
        Me.PanPlanetsHeader.Dock = System.Windows.Forms.DockStyle.Top
        Me.PanPlanetsHeader.Location = New System.Drawing.Point(0, 0)
        Me.PanPlanetsHeader.Name = "PanPlanetsHeader"
        Me.PanPlanetsHeader.Size = New System.Drawing.Size(552, 88)
        Me.PanPlanetsHeader.TabIndex = 0
        '
        'PlanetInfoFound
        '
        Me.PlanetInfoFound.CaptionVisible = False
        Me.PlanetInfoFound.Dock = System.Windows.Forms.DockStyle.Left
        Me.PlanetInfoFound.Expanded = False
        Me.PlanetInfoFound.Location = New System.Drawing.Point(152, 0)
        Me.PlanetInfoFound.Name = "PlanetInfoFound"
        Me.PlanetInfoFound.Planet = Nothing
        Me.PlanetInfoFound.ReadOnly = True
        Me.PlanetInfoFound.Size = New System.Drawing.Size(192, 84)
        Me.PlanetInfoFound.TabIndex = 2
        '
        'btnMergeSpyData
        '
        Me.btnMergeSpyData.Enabled = False
        Me.btnMergeSpyData.Location = New System.Drawing.Point(360, 24)
        Me.btnMergeSpyData.Name = "btnMergeSpyData"
        Me.btnMergeSpyData.Size = New System.Drawing.Size(168, 23)
        Me.btnMergeSpyData.TabIndex = 1
        Me.btnMergeSpyData.Text = "(Merge Data)"
        '
        'RichTextBox1
        '
        Me.RichTextBox1.Dock = System.Windows.Forms.DockStyle.Left
        Me.RichTextBox1.Location = New System.Drawing.Point(0, 0)
        Me.RichTextBox1.Name = "RichTextBox1"
        Me.RichTextBox1.Size = New System.Drawing.Size(152, 84)
        Me.RichTextBox1.TabIndex = 0
        Me.RichTextBox1.Text = "RichTextBox1"
        '
        'Label1
        '
        Me.Label1.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(560, 16)
        Me.Label1.TabIndex = 1
        Me.Label1.Text = "My Empire"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'EmpireCtrl
        '
        Me.Controls.Add(Me.panMain)
        Me.Name = "EmpireCtrl"
        Me.Size = New System.Drawing.Size(560, 336)
        Me.panMain.ResumeLayout(False)
        Me.panSubMain.ResumeLayout(False)
        Me.tcMyEmpire.ResumeLayout(False)
        Me.tpOverview.ResumeLayout(False)
        Me.gbStatistics.ResumeLayout(False)
        CType(Me.dgAllRanks, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel1.ResumeLayout(False)
        Me.panWhoAmi.ResumeLayout(False)
        Me.panWhoamiHeader.ResumeLayout(False)
        Me.tpPlanets.ResumeLayout(False)
        Me.PanPlanetsHeader.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private pPlayer As OGameObject.Player = Nothing
    Public Property Player() As OGameObject.Player
        Get
            Return pPlayer
        End Get
        Set(ByVal Value As OGameObject.Player)
            pPlayer = Value
            UnHandleCtrl()
            If Value Is Nothing Then Return
            Dim u As New Splash
            u.Owner = MainForm.TopForm

            u.Message = "Retrieving Player and Planet data . . ."
            u.Show()
            Application.DoEvents()
            tbPlayerName.Text = Player.Name
            tbAlliance.Text = Player.Alliance
            With OGameObject.OGameDBEngine.Default.Universe
                RichTextBox1.Text = "DBFileName: " & .DBFileName & vbCrLf & _
                                    "UniverseName: " & .UniverseName & vbCrLf & _
                                    "PlayerID: " & .MyPlayerID


            End With

            For Each pc As PlanetCtrl In Me.panPlanets.Controls
                RemoveHandler pc.EnteringPlanetCtrl, AddressOf Me.PlanetInfoFound_EnteringPlanetCtrl
            Next
            Me.panPlanets.Controls.Clear()
            dgAllRanks.DataSource = pPlayer.AllRanks

            With pPlayer.AllRanks
                If .Rows.Count Then
                    lbStatDate.Text = .Rows(0).Item("DATADATE").ToString
                    lbGlobalRank.Text = .Rows(0).Item("RANK").ToString
                    lbGlobalPoints.Text = .Rows(0).Item("POINTS").ToString
                    lbFlotteRank.Text = .Rows(0).Item("FlotteRank").ToString
                    lbFlottePoints.Text = .Rows(0).Item("FlottePoints").ToString
                    lbResearchRank.Text = .Rows(0).Item("SearchRank").ToString
                    lbResearchPoints.Text = .Rows(0).Item("SearchPoints").ToString

                End If
            End With

            '  PlanetInfoControl1.Planet = pPlayer.Planets.Item(0)
            If pPlayer.Planets.Count Then
                For i As Integer = pPlayer.Planets.Count - 1 To 0 Step -1
                    Dim plan As OGameObject.Planet = pPlayer.Planets.Item(i)
                    Dim pic As New PlanetCtrl
                    pic.Planet = plan
                    If pic.Planet.SpyingReports.Count Then

                    End If
                    pic.Dock = DockStyle.Left
                    'pic.ShowVisibleDataOnly()
                    AddHandler pic.EnteringPlanetCtrl, AddressOf Me.PlanetInfoFound_EnteringPlanetCtrl
                    'pic.updatezorder()
                    Me.panPlanets.Controls.Add(pic)

                Next
            End If
            u.Close()
        End Set
    End Property

    'private sub Read

    Private Sub tbPlayerName_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tbPlayerName.TextChanged
        btnSave.Enabled = tbPlayerName.Text.Trim.Length <> 0
    End Sub

    Private Sub btnSave_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSave.Click
        Dim pl As OGameObject.Player = OGameObject.Player.FromName(tbPlayerName.Text)
        If Not pl Is Nothing Then
            If MessageBox.Show(MainForm.TopForm, pl.ToString, "Is this player yourself ?", MessageBoxButtons.YesNo) = DialogResult.Yes Then
                Application.DoEvents()
                Player = pl
                OGameObject.OGameDBEngine.Default.Universe.MyPlayerID = pl.ID
                OGameObject.OGameDBEngine.Default.Universe.Save()
            End If
        End If
    End Sub
    Public Property FoundData() As OGameObject.spydata
        Get
            Try
                Return PlanetInfoFound.SpyData
            Catch ex As Exception
                Return Nothing
            End Try
        End Get
        Set(ByVal Value As OGameObject.spydata)
            Try
                PlanetInfoFound.SpyData = Value
                If Value Is Nothing Then

                    Return
                End If
                PlanetInfoFound.ShowVisibleDataOnly()
                btnMergeSpyData.Enabled = True
            Catch ex As Exception
                btnMergeSpyData.Enabled = False
            End Try
        End Set
    End Property

    Private Sub PlanetInfoFound_EnteringPlanetCtrl(ByVal planetcontrol As PlanetCtrl)

        btnMergeSpyData.Text = "Merge data on " & planetcontrol.Planet.Name & " - " & planetcontrol.Planet.Coords
        btnMergeSpyData.Tag = planetcontrol
        btnMergeSpyData.Enabled = True
    End Sub

    Protected Sub UnHandleCtrl()
        For Each pc As PlanetCtrl In Me.panPlanets.Controls
            RemoveHandler pc.EnteringPlanetCtrl, AddressOf Me.PlanetInfoFound_EnteringPlanetCtrl
        Next
        Me.panPlanets.Controls.Clear()
    End Sub

    Protected Overrides Sub Finalize()
        UnHandleCtrl()
        MyBase.Finalize()
    End Sub

    Private Sub btnMergeSpyData_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnMergeSpyData.Click
        With CType(btnMergeSpyData.Tag, PlanetCtrl)
            .SpyData.MergeData(PlanetInfoFound.SpyData)
            .FillLabelTextBox()
            .IntelligentExpand()
        End With
    End Sub
End Class
