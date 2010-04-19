Imports System.Text.RegularExpressions
Public Class Universes
    Inherits System.Windows.Forms.UserControl

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call
        Me.SetStyle(ControlStyles.DoubleBuffer _
                 Or ControlStyles.UserPaint _
                 Or ControlStyles.AllPaintingInWmPaint, _
                 True)

        ' This enables mouse support such as the Mouse Wheel
        setstyle(ControlStyles.UserMouse, True)

        ' This will repaint the control whenever it is resized
        setstyle(ControlStyles.ResizeRedraw, True)

        Me.UpdateStyles()
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
    Friend WithEvents lblTitle As System.Windows.Forms.Label
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents tpRanking As System.Windows.Forms.TabPage
    Friend WithEvents gbRankType As System.Windows.Forms.GroupBox
    Friend WithEvents tpGalaxy As System.Windows.Forms.TabPage
    Friend WithEvents Timer1 As System.Timers.Timer
    Friend WithEvents labHelp As System.Windows.Forms.Label
    Friend WithEvents PictureBox2 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox3 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox1 As System.Windows.Forms.PictureBox
    Friend WithEvents dgPlayerRanking As System.Windows.Forms.DataGrid
    Public WithEvents rbPointsx As System.Windows.Forms.RadioButton
    Public WithEvents rbFlotte As System.Windows.Forms.RadioButton
    Public WithEvents rbResearch As System.Windows.Forms.RadioButton
    Friend WithEvents PanGalaxyUpper As System.Windows.Forms.Panel
    Friend WithEvents panGalaxyDownLeft As System.Windows.Forms.Panel
    Friend WithEvents labGalaxySystemTitle As System.Windows.Forms.Label
    Friend WithEvents labGalaxyDataInfo As System.Windows.Forms.Label
    Friend WithEvents ComboBox1 As System.Windows.Forms.ComboBox
    Friend WithEvents splitGalaxyDownLeftRight As System.Windows.Forms.Splitter
    Friend WithEvents panGalaxyDownRight As System.Windows.Forms.Panel
    Friend WithEvents panGalaxyPlanetInfo As System.Windows.Forms.Panel
    Friend WithEvents sbGalaxy As System.Windows.Forms.StatusBar
    Friend WithEvents nudGalaxy As System.Windows.Forms.NumericUpDown
    Friend WithEvents nudSystem As System.Windows.Forms.NumericUpDown
    Friend WithEvents lbGalaxyPlanets As System.Windows.Forms.ListBox
    Friend WithEvents lbGalaxyPlanetSpy As System.Windows.Forms.ListBox
    Friend WithEvents lbGalaxyPlanetAttacks As System.Windows.Forms.ListBox
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents Panel4 As System.Windows.Forms.Panel
    Friend WithEvents rtbGalaxyReport As System.Windows.Forms.RichTextBox
    Friend WithEvents btnDeleteRank As System.Windows.Forms.Button
    Friend WithEvents ogamelinkfr As System.Windows.Forms.LinkLabel
    Friend WithEvents LinkLabel1 As System.Windows.Forms.LinkLabel
    Friend WithEvents LinkLabel2 As System.Windows.Forms.LinkLabel
    Friend WithEvents LinkLabel3 As System.Windows.Forms.LinkLabel
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents nudAttackLimit As System.Windows.Forms.NumericUpDown
    Friend WithEvents nudSpyLimit As System.Windows.Forms.NumericUpDown
    Friend WithEvents cbGalSearch As System.Windows.Forms.ComboBox
    Friend WithEvents btnGalSearch As System.Windows.Forms.Button
    Friend WithEvents labGalaxyNum As System.Windows.Forms.Label
    Friend WithEvents labSystemNum As System.Windows.Forms.Label
    Friend WithEvents sfdExport As System.Windows.Forms.SaveFileDialog
    Friend WithEvents tpRemoteDB As System.Windows.Forms.TabPage

    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents panGalaxyMiddleright As System.Windows.Forms.Panel
    Friend WithEvents PanGalaxyUp As System.Windows.Forms.Panel
    Friend WithEvents panRank As System.Windows.Forms.Panel
    Friend WithEvents PanRankFilter As System.Windows.Forms.Panel
    Friend WithEvents btnGoToOGSHomeSite As System.Windows.Forms.Button
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents Label8 As System.Windows.Forms.Label
    Friend WithEvents Label9 As System.Windows.Forms.Label
    Friend WithEvents Label10 As System.Windows.Forms.Label
    Friend WithEvents Label11 As System.Windows.Forms.Label
    Friend WithEvents lbGalPlayerPoint As System.Windows.Forms.Label
    Friend WithEvents lbGalPlayerFlotte As System.Windows.Forms.Label
    Friend WithEvents lbGalPlayerResearch As System.Windows.Forms.Label
    Friend WithEvents Panel3 As System.Windows.Forms.Panel
    Friend WithEvents Label12 As System.Windows.Forms.Label
    Friend WithEvents Label13 As System.Windows.Forms.Label
    Friend WithEvents Label14 As System.Windows.Forms.Label
    Friend WithEvents Panel5 As System.Windows.Forms.Panel
    Friend WithEvents btnChangeView As System.Windows.Forms.Button
    Friend WithEvents lbGalPlayerName As System.Windows.Forms.Label
    Friend WithEvents lbGalPlayerAlly As System.Windows.Forms.Label
    Friend WithEvents tpDBStuff As System.Windows.Forms.TabPage

    Friend WithEvents lbGalPlayerPoint2 As System.Windows.Forms.Label
    Friend WithEvents lbGalPlayerFlotte2 As System.Windows.Forms.Label
    Friend WithEvents lbGalPlayerResearch2 As System.Windows.Forms.Label
    Friend WithEvents cmGalaxie As System.Windows.Forms.ContextMenu
    Friend WithEvents MenuItem1 As System.Windows.Forms.MenuItem
    Friend WithEvents miGalImportSpyRep As System.Windows.Forms.MenuItem
    Friend WithEvents miGalEditPlayer As System.Windows.Forms.MenuItem
    Friend WithEvents tpMap As System.Windows.Forms.TabPage
    Friend WithEvents rtbGalPlayerNote As System.Windows.Forms.RichTextBox
    Friend WithEvents panMain As System.Windows.Forms.Panel
    Friend WithEvents TabControl1 As System.Windows.Forms.TabControl
    Friend WithEvents tcReports As System.Windows.Forms.TabControl
    Friend WithEvents tpAlliancePlayer As System.Windows.Forms.TabPage
    Friend WithEvents tpReportSpyings As System.Windows.Forms.TabPage
    Friend WithEvents tpReportsAttack As System.Windows.Forms.TabPage

    Friend WithEvents tpStatistics As System.Windows.Forms.TabPage
    Friend WithEvents tpReports As System.Windows.Forms.TabPage
    Friend WithEvents PartialMapCtrl1 As OGameStratege.PartialMapCtrl
    Friend WithEvents panGalaxyLeftDown As System.Windows.Forms.Panel
    Friend WithEvents labGalaxyRequieredTransport As System.Windows.Forms.Label

    Friend WithEvents LastAttacksCtrl1 As OGameStratege.LastAttacksCtrl
    Friend WithEvents PlayersStatsCtrl1 As OGameStratege.PlayersStatsCtrl
    Friend WithEvents tpEmpire As System.Windows.Forms.TabPage
    Friend WithEvents EmpireCtrl1 As OGameStratege.EmpireCtrl
    Friend WithEvents Map1 As OGameStratege.Map
    Friend WithEvents PlayerAllianceSubPanel1 As OGameStratege.PlayerAllianceSubPanel
    Friend WithEvents btnCheckUpdate As System.Windows.Forms.Button
    Friend WithEvents LastSpyingCtrl1 As OGameStratege.LastSpyingCtrl
    Friend WithEvents btnLoadStatistics As System.Windows.Forms.Button
    Friend WithEvents Splitter3 As System.Windows.Forms.Splitter
    Friend WithEvents OgsPlayerStatsGraph1 As OGameStratege.OGSPlayerStatsGraph
    Friend WithEvents tcDBStuff As System.Windows.Forms.TabControl
    Friend WithEvents tpBougeTaBase As System.Windows.Forms.TabPage
    Friend WithEvents DbStuffCtrl1 As OGameStratege.DBStuffCtrl
    Friend WithEvents tpCleanDatabase As System.Windows.Forms.TabPage
    Friend WithEvents CleanDatabaseCtrl1 As OGameStratege.CleanDatabaseCtrl
    Friend WithEvents Panel6 As System.Windows.Forms.Panel
    Friend WithEvents rtbGalReport2 As System.Windows.Forms.RichTextBox
    Friend WithEvents tbPlanetExtraInfo As System.Windows.Forms.TextBox
    Friend WithEvents ImportExportCtrl1 As OGameObject.ImportExportCtrl
    Public WithEvents rbAlliResearch As System.Windows.Forms.RadioButton
    Public WithEvents rbAlliFlotte As System.Windows.Forms.RadioButton
    Public WithEvents rbAlliPoints As System.Windows.Forms.RadioButton
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents btnPhallange As System.Windows.Forms.Button

    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Universes))
        Dim Spydata1 As OGameObject.spydata = New OGameObject.spydata
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.Button1 = New System.Windows.Forms.Button
        Me.lblTitle = New System.Windows.Forms.Label
        Me.panMain = New System.Windows.Forms.Panel
        Me.TabControl1 = New System.Windows.Forms.TabControl
        Me.tpGalaxy = New System.Windows.Forms.TabPage
        Me.panGalaxyDownRight = New System.Windows.Forms.Panel
        Me.Panel4 = New System.Windows.Forms.Panel
        Me.OgsPlayerStatsGraph1 = New OGameStratege.OGSPlayerStatsGraph
        Me.Splitter3 = New System.Windows.Forms.Splitter
        Me.rtbGalaxyReport = New System.Windows.Forms.RichTextBox
        Me.panGalaxyMiddleright = New System.Windows.Forms.Panel
        Me.rtbGalPlayerNote = New System.Windows.Forms.RichTextBox
        Me.Panel3 = New System.Windows.Forms.Panel
        Me.Label12 = New System.Windows.Forms.Label
        Me.Label13 = New System.Windows.Forms.Label
        Me.Label14 = New System.Windows.Forms.Label
        Me.lbGalPlayerName = New System.Windows.Forms.Label
        Me.lbGalPlayerAlly = New System.Windows.Forms.Label
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.Label9 = New System.Windows.Forms.Label
        Me.Label8 = New System.Windows.Forms.Label
        Me.Label10 = New System.Windows.Forms.Label
        Me.Label11 = New System.Windows.Forms.Label
        Me.lbGalPlayerPoint = New System.Windows.Forms.Label
        Me.lbGalPlayerFlotte = New System.Windows.Forms.Label
        Me.lbGalPlayerResearch = New System.Windows.Forms.Label
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.sbGalaxy = New System.Windows.Forms.StatusBar
        Me.panGalaxyPlanetInfo = New System.Windows.Forms.Panel
        Me.Label5 = New System.Windows.Forms.Label
        Me.nudAttackLimit = New System.Windows.Forms.NumericUpDown
        Me.Label4 = New System.Windows.Forms.Label
        Me.lbGalaxyPlanetAttacks = New System.Windows.Forms.ListBox
        Me.lbGalaxyPlanetSpy = New System.Windows.Forms.ListBox
        Me.nudSpyLimit = New System.Windows.Forms.NumericUpDown
        Me.splitGalaxyDownLeftRight = New System.Windows.Forms.Splitter
        Me.panGalaxyDownLeft = New System.Windows.Forms.Panel
        Me.rtbGalReport2 = New System.Windows.Forms.RichTextBox
        Me.Panel6 = New System.Windows.Forms.Panel
        Me.tbPlanetExtraInfo = New System.Windows.Forms.TextBox
        Me.panGalaxyLeftDown = New System.Windows.Forms.Panel
        Me.labGalaxyRequieredTransport = New System.Windows.Forms.Label
        Me.Panel5 = New System.Windows.Forms.Panel
        Me.lbGalPlayerResearch2 = New System.Windows.Forms.Label
        Me.lbGalPlayerFlotte2 = New System.Windows.Forms.Label
        Me.lbGalPlayerPoint2 = New System.Windows.Forms.Label
        Me.btnChangeView = New System.Windows.Forms.Button
        Me.lbGalaxyPlanets = New System.Windows.Forms.ListBox
        Me.cmGalaxie = New System.Windows.Forms.ContextMenu
        Me.miGalEditPlayer = New System.Windows.Forms.MenuItem
        Me.MenuItem1 = New System.Windows.Forms.MenuItem
        Me.miGalImportSpyRep = New System.Windows.Forms.MenuItem
        Me.PanGalaxyUp = New System.Windows.Forms.Panel
        Me.labGalaxyDataInfo = New System.Windows.Forms.Label
        Me.labGalaxySystemTitle = New System.Windows.Forms.Label
        Me.PanGalaxyUpper = New System.Windows.Forms.Panel
        Me.btnGalSearch = New System.Windows.Forms.Button
        Me.cbGalSearch = New System.Windows.Forms.ComboBox
        Me.ComboBox1 = New System.Windows.Forms.ComboBox
        Me.nudGalaxy = New System.Windows.Forms.NumericUpDown
        Me.labGalaxyNum = New System.Windows.Forms.Label
        Me.nudSystem = New System.Windows.Forms.NumericUpDown
        Me.labSystemNum = New System.Windows.Forms.Label
        Me.btnPhallange = New System.Windows.Forms.Button
        Me.tpMap = New System.Windows.Forms.TabPage
        Me.Map1 = New OGameStratege.Map
        Me.tpReports = New System.Windows.Forms.TabPage
        Me.tcReports = New System.Windows.Forms.TabControl
        Me.tpAlliancePlayer = New System.Windows.Forms.TabPage
        Me.PlayerAllianceSubPanel1 = New OGameStratege.PlayerAllianceSubPanel
        Me.tpReportsAttack = New System.Windows.Forms.TabPage
        Me.LastAttacksCtrl1 = New OGameStratege.LastAttacksCtrl
        Me.tpReportSpyings = New System.Windows.Forms.TabPage
        Me.LastSpyingCtrl1 = New OGameStratege.LastSpyingCtrl
        Me.tpStatistics = New System.Windows.Forms.TabPage
        Me.PlayersStatsCtrl1 = New OGameStratege.PlayersStatsCtrl
        Me.tpDBStuff = New System.Windows.Forms.TabPage
        Me.tcDBStuff = New System.Windows.Forms.TabControl
        Me.tpBougeTaBase = New System.Windows.Forms.TabPage
        Me.DbStuffCtrl1 = New OGameStratege.DBStuffCtrl
        Me.tpCleanDatabase = New System.Windows.Forms.TabPage
        Me.CleanDatabaseCtrl1 = New OGameStratege.CleanDatabaseCtrl
        Me.tpRemoteDB = New System.Windows.Forms.TabPage
        Me.ImportExportCtrl1 = New OGameObject.ImportExportCtrl
        Me.tpRanking = New System.Windows.Forms.TabPage
        Me.btnLoadStatistics = New System.Windows.Forms.Button
        Me.panRank = New System.Windows.Forms.Panel
        Me.dgPlayerRanking = New System.Windows.Forms.DataGrid
        Me.PanRankFilter = New System.Windows.Forms.Panel
        Me.btnDeleteRank = New System.Windows.Forms.Button
        Me.gbRankType = New System.Windows.Forms.GroupBox
        Me.Label3 = New System.Windows.Forms.Label
        Me.Label1 = New System.Windows.Forms.Label
        Me.rbAlliPoints = New System.Windows.Forms.RadioButton
        Me.rbAlliFlotte = New System.Windows.Forms.RadioButton
        Me.rbAlliResearch = New System.Windows.Forms.RadioButton
        Me.rbPointsx = New System.Windows.Forms.RadioButton
        Me.rbFlotte = New System.Windows.Forms.RadioButton
        Me.rbResearch = New System.Windows.Forms.RadioButton
        Me.tpEmpire = New System.Windows.Forms.TabPage
        Me.EmpireCtrl1 = New OGameStratege.EmpireCtrl
        Me.PictureBox3 = New System.Windows.Forms.PictureBox
        Me.PictureBox2 = New System.Windows.Forms.PictureBox
        Me.PictureBox1 = New System.Windows.Forms.PictureBox
        Me.ogamelinkfr = New System.Windows.Forms.LinkLabel
        Me.LinkLabel1 = New System.Windows.Forms.LinkLabel
        Me.LinkLabel2 = New System.Windows.Forms.LinkLabel
        Me.LinkLabel3 = New System.Windows.Forms.LinkLabel
        Me.Label2 = New System.Windows.Forms.Label
        Me.btnGoToOGSHomeSite = New System.Windows.Forms.Button
        Me.btnCheckUpdate = New System.Windows.Forms.Button
        Me.labHelp = New System.Windows.Forms.Label
        Me.Timer1 = New System.Timers.Timer
        Me.sfdExport = New System.Windows.Forms.SaveFileDialog
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog
        Me.Panel1.SuspendLayout()
        Me.panMain.SuspendLayout()
        Me.TabControl1.SuspendLayout()
        Me.tpGalaxy.SuspendLayout()
        Me.panGalaxyDownRight.SuspendLayout()
        Me.Panel4.SuspendLayout()
        Me.panGalaxyMiddleright.SuspendLayout()
        Me.Panel3.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.panGalaxyPlanetInfo.SuspendLayout()
        CType(Me.nudAttackLimit, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.nudSpyLimit, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.panGalaxyDownLeft.SuspendLayout()
        Me.Panel6.SuspendLayout()
        Me.panGalaxyLeftDown.SuspendLayout()
        Me.Panel5.SuspendLayout()
        Me.PanGalaxyUp.SuspendLayout()
        Me.PanGalaxyUpper.SuspendLayout()
        CType(Me.nudGalaxy, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.nudSystem, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.tpMap.SuspendLayout()
        Me.tpReports.SuspendLayout()
        Me.tcReports.SuspendLayout()
        Me.tpAlliancePlayer.SuspendLayout()
        Me.tpReportsAttack.SuspendLayout()
        Me.tpReportSpyings.SuspendLayout()
        Me.tpStatistics.SuspendLayout()
        Me.tpDBStuff.SuspendLayout()
        Me.tcDBStuff.SuspendLayout()
        Me.tpBougeTaBase.SuspendLayout()
        Me.tpCleanDatabase.SuspendLayout()
        Me.tpRemoteDB.SuspendLayout()
        Me.tpRanking.SuspendLayout()
        Me.panRank.SuspendLayout()
        CType(Me.dgPlayerRanking, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.PanRankFilter.SuspendLayout()
        Me.gbRankType.SuspendLayout()
        Me.tpEmpire.SuspendLayout()
        CType(Me.PictureBox3, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.Timer1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Panel1.Controls.Add(Me.Button1)
        Me.Panel1.Controls.Add(Me.lblTitle)
        resources.ApplyResources(Me.Panel1, "Panel1")
        Me.Panel1.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Panel1.Name = "Panel1"
        '
        'Button1
        '
        resources.ApplyResources(Me.Button1, "Button1")
        Me.Button1.BackColor = System.Drawing.SystemColors.Control
        Me.Button1.ForeColor = System.Drawing.SystemColors.ControlText
        Me.Button1.Name = "Button1"
        Me.Button1.UseVisualStyleBackColor = False
        '
        'lblTitle
        '
        resources.ApplyResources(Me.lblTitle, "lblTitle")
        Me.lblTitle.BackColor = System.Drawing.Color.Black
        Me.lblTitle.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.lblTitle.ForeColor = System.Drawing.Color.Red
        Me.lblTitle.Name = "lblTitle"
        Me.lblTitle.Tag = "blink"
        '
        'panMain
        '
        resources.ApplyResources(Me.panMain, "panMain")
        Me.panMain.Controls.Add(Me.TabControl1)
        Me.panMain.Controls.Add(Me.PictureBox3)
        Me.panMain.Controls.Add(Me.PictureBox2)
        Me.panMain.Controls.Add(Me.PictureBox1)
        Me.panMain.Controls.Add(Me.ogamelinkfr)
        Me.panMain.Controls.Add(Me.LinkLabel1)
        Me.panMain.Controls.Add(Me.LinkLabel2)
        Me.panMain.Controls.Add(Me.LinkLabel3)
        Me.panMain.Controls.Add(Me.Label2)
        Me.panMain.Controls.Add(Me.btnGoToOGSHomeSite)
        Me.panMain.Controls.Add(Me.btnCheckUpdate)
        Me.panMain.Controls.Add(Me.labHelp)
        Me.panMain.Name = "panMain"
        '
        'TabControl1
        '
        Me.TabControl1.Controls.Add(Me.tpGalaxy)
        Me.TabControl1.Controls.Add(Me.tpMap)
        Me.TabControl1.Controls.Add(Me.tpReports)
        Me.TabControl1.Controls.Add(Me.tpDBStuff)
        Me.TabControl1.Controls.Add(Me.tpRemoteDB)
        Me.TabControl1.Controls.Add(Me.tpRanking)
        Me.TabControl1.Controls.Add(Me.tpEmpire)
        resources.ApplyResources(Me.TabControl1, "TabControl1")
        Me.TabControl1.Name = "TabControl1"
        Me.TabControl1.SelectedIndex = 0
        '
        'tpGalaxy
        '
        Me.tpGalaxy.Controls.Add(Me.panGalaxyDownRight)
        Me.tpGalaxy.Controls.Add(Me.splitGalaxyDownLeftRight)
        Me.tpGalaxy.Controls.Add(Me.panGalaxyDownLeft)
        Me.tpGalaxy.Controls.Add(Me.PanGalaxyUpper)
        resources.ApplyResources(Me.tpGalaxy, "tpGalaxy")
        Me.tpGalaxy.Name = "tpGalaxy"
        Me.tpGalaxy.UseVisualStyleBackColor = True
        '
        'panGalaxyDownRight
        '
        resources.ApplyResources(Me.panGalaxyDownRight, "panGalaxyDownRight")
        Me.panGalaxyDownRight.Controls.Add(Me.Panel4)
        Me.panGalaxyDownRight.Controls.Add(Me.Splitter1)
        Me.panGalaxyDownRight.Controls.Add(Me.sbGalaxy)
        Me.panGalaxyDownRight.Controls.Add(Me.panGalaxyPlanetInfo)
        Me.panGalaxyDownRight.Name = "panGalaxyDownRight"
        '
        'Panel4
        '
        Me.Panel4.BackColor = System.Drawing.Color.Transparent
        Me.Panel4.Controls.Add(Me.OgsPlayerStatsGraph1)
        Me.Panel4.Controls.Add(Me.Splitter3)
        Me.Panel4.Controls.Add(Me.rtbGalaxyReport)
        Me.Panel4.Controls.Add(Me.panGalaxyMiddleright)
        resources.ApplyResources(Me.Panel4, "Panel4")
        Me.Panel4.Name = "Panel4"
        '
        'OgsPlayerStatsGraph1
        '
        resources.ApplyResources(Me.OgsPlayerStatsGraph1, "OgsPlayerStatsGraph1")
        Me.OgsPlayerStatsGraph1.GraphType = OGameStratege.OGSPlayerStatsGraph.StatsGraphType.Points
        Me.OgsPlayerStatsGraph1.Name = "OgsPlayerStatsGraph1"
        Me.OgsPlayerStatsGraph1.Player = Nothing
        '
        'Splitter3
        '
        Me.Splitter3.BackColor = System.Drawing.SystemColors.Highlight
        resources.ApplyResources(Me.Splitter3, "Splitter3")
        Me.Splitter3.Name = "Splitter3"
        Me.Splitter3.TabStop = False
        '
        'rtbGalaxyReport
        '
        Me.rtbGalaxyReport.BackColor = System.Drawing.Color.PeachPuff
        resources.ApplyResources(Me.rtbGalaxyReport, "rtbGalaxyReport")
        Me.rtbGalaxyReport.Name = "rtbGalaxyReport"
        Me.rtbGalaxyReport.ReadOnly = True
        '
        'panGalaxyMiddleright
        '
        Me.panGalaxyMiddleright.BackColor = System.Drawing.Color.Transparent
        Me.panGalaxyMiddleright.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panGalaxyMiddleright.Controls.Add(Me.rtbGalPlayerNote)
        Me.panGalaxyMiddleright.Controls.Add(Me.Panel3)
        Me.panGalaxyMiddleright.Controls.Add(Me.Panel2)
        resources.ApplyResources(Me.panGalaxyMiddleright, "panGalaxyMiddleright")
        Me.panGalaxyMiddleright.Name = "panGalaxyMiddleright"
        '
        'rtbGalPlayerNote
        '
        resources.ApplyResources(Me.rtbGalPlayerNote, "rtbGalPlayerNote")
        Me.rtbGalPlayerNote.Name = "rtbGalPlayerNote"
        Me.rtbGalPlayerNote.ReadOnly = True
        '
        'Panel3
        '
        Me.Panel3.BackColor = System.Drawing.SystemColors.Control
        Me.Panel3.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Panel3.Controls.Add(Me.Label12)
        Me.Panel3.Controls.Add(Me.Label13)
        Me.Panel3.Controls.Add(Me.Label14)
        Me.Panel3.Controls.Add(Me.lbGalPlayerName)
        Me.Panel3.Controls.Add(Me.lbGalPlayerAlly)
        resources.ApplyResources(Me.Panel3, "Panel3")
        Me.Panel3.Name = "Panel3"
        '
        'Label12
        '
        resources.ApplyResources(Me.Label12, "Label12")
        Me.Label12.Name = "Label12"
        '
        'Label13
        '
        resources.ApplyResources(Me.Label13, "Label13")
        Me.Label13.Name = "Label13"
        '
        'Label14
        '
        resources.ApplyResources(Me.Label14, "Label14")
        Me.Label14.Name = "Label14"
        '
        'lbGalPlayerName
        '
        Me.lbGalPlayerName.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        resources.ApplyResources(Me.lbGalPlayerName, "lbGalPlayerName")
        Me.lbGalPlayerName.Name = "lbGalPlayerName"
        '
        'lbGalPlayerAlly
        '
        Me.lbGalPlayerAlly.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        resources.ApplyResources(Me.lbGalPlayerAlly, "lbGalPlayerAlly")
        Me.lbGalPlayerAlly.Name = "lbGalPlayerAlly"
        '
        'Panel2
        '
        Me.Panel2.BackColor = System.Drawing.SystemColors.Control
        Me.Panel2.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Panel2.Controls.Add(Me.Label9)
        Me.Panel2.Controls.Add(Me.Label8)
        Me.Panel2.Controls.Add(Me.Label10)
        Me.Panel2.Controls.Add(Me.Label11)
        Me.Panel2.Controls.Add(Me.lbGalPlayerPoint)
        Me.Panel2.Controls.Add(Me.lbGalPlayerFlotte)
        Me.Panel2.Controls.Add(Me.lbGalPlayerResearch)
        resources.ApplyResources(Me.Panel2, "Panel2")
        Me.Panel2.Name = "Panel2"
        '
        'Label9
        '
        resources.ApplyResources(Me.Label9, "Label9")
        Me.Label9.Name = "Label9"
        '
        'Label8
        '
        resources.ApplyResources(Me.Label8, "Label8")
        Me.Label8.Name = "Label8"
        '
        'Label10
        '
        resources.ApplyResources(Me.Label10, "Label10")
        Me.Label10.Name = "Label10"
        '
        'Label11
        '
        resources.ApplyResources(Me.Label11, "Label11")
        Me.Label11.Name = "Label11"
        '
        'lbGalPlayerPoint
        '
        Me.lbGalPlayerPoint.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        resources.ApplyResources(Me.lbGalPlayerPoint, "lbGalPlayerPoint")
        Me.lbGalPlayerPoint.Name = "lbGalPlayerPoint"
        '
        'lbGalPlayerFlotte
        '
        Me.lbGalPlayerFlotte.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        resources.ApplyResources(Me.lbGalPlayerFlotte, "lbGalPlayerFlotte")
        Me.lbGalPlayerFlotte.Name = "lbGalPlayerFlotte"
        '
        'lbGalPlayerResearch
        '
        Me.lbGalPlayerResearch.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        resources.ApplyResources(Me.lbGalPlayerResearch, "lbGalPlayerResearch")
        Me.lbGalPlayerResearch.Name = "lbGalPlayerResearch"
        '
        'Splitter1
        '
        Me.Splitter1.BackColor = System.Drawing.SystemColors.Highlight
        resources.ApplyResources(Me.Splitter1, "Splitter1")
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.TabStop = False
        '
        'sbGalaxy
        '
        resources.ApplyResources(Me.sbGalaxy, "sbGalaxy")
        Me.sbGalaxy.Name = "sbGalaxy"
        Me.sbGalaxy.SizingGrip = False
        '
        'panGalaxyPlanetInfo
        '
        Me.panGalaxyPlanetInfo.BackColor = System.Drawing.Color.Transparent
        Me.panGalaxyPlanetInfo.Controls.Add(Me.Label5)
        Me.panGalaxyPlanetInfo.Controls.Add(Me.nudAttackLimit)
        Me.panGalaxyPlanetInfo.Controls.Add(Me.Label4)
        Me.panGalaxyPlanetInfo.Controls.Add(Me.lbGalaxyPlanetAttacks)
        Me.panGalaxyPlanetInfo.Controls.Add(Me.lbGalaxyPlanetSpy)
        Me.panGalaxyPlanetInfo.Controls.Add(Me.nudSpyLimit)
        resources.ApplyResources(Me.panGalaxyPlanetInfo, "panGalaxyPlanetInfo")
        Me.panGalaxyPlanetInfo.Name = "panGalaxyPlanetInfo"
        '
        'Label5
        '
        resources.ApplyResources(Me.Label5, "Label5")
        Me.Label5.Name = "Label5"
        '
        'nudAttackLimit
        '
        resources.ApplyResources(Me.nudAttackLimit, "nudAttackLimit")
        Me.nudAttackLimit.Minimum = New Decimal(New Integer() {1, 0, 0, 0})
        Me.nudAttackLimit.Name = "nudAttackLimit"
        Me.nudAttackLimit.Value = New Decimal(New Integer() {10, 0, 0, 0})
        '
        'Label4
        '
        resources.ApplyResources(Me.Label4, "Label4")
        Me.Label4.BackColor = System.Drawing.SystemColors.Control
        Me.Label4.Name = "Label4"
        '
        'lbGalaxyPlanetAttacks
        '
        resources.ApplyResources(Me.lbGalaxyPlanetAttacks, "lbGalaxyPlanetAttacks")
        Me.lbGalaxyPlanetAttacks.BackColor = System.Drawing.SystemColors.Control
        Me.lbGalaxyPlanetAttacks.ForeColor = System.Drawing.SystemColors.ControlText
        Me.lbGalaxyPlanetAttacks.Name = "lbGalaxyPlanetAttacks"
        '
        'lbGalaxyPlanetSpy
        '
        resources.ApplyResources(Me.lbGalaxyPlanetSpy, "lbGalaxyPlanetSpy")
        Me.lbGalaxyPlanetSpy.BackColor = System.Drawing.SystemColors.Control
        Me.lbGalaxyPlanetSpy.ForeColor = System.Drawing.Color.SeaGreen
        Me.lbGalaxyPlanetSpy.Name = "lbGalaxyPlanetSpy"
        '
        'nudSpyLimit
        '
        resources.ApplyResources(Me.nudSpyLimit, "nudSpyLimit")
        Me.nudSpyLimit.Minimum = New Decimal(New Integer() {1, 0, 0, 0})
        Me.nudSpyLimit.Name = "nudSpyLimit"
        Me.nudSpyLimit.Value = New Decimal(New Integer() {10, 0, 0, 0})
        '
        'splitGalaxyDownLeftRight
        '
        resources.ApplyResources(Me.splitGalaxyDownLeftRight, "splitGalaxyDownLeftRight")
        Me.splitGalaxyDownLeftRight.Name = "splitGalaxyDownLeftRight"
        Me.splitGalaxyDownLeftRight.TabStop = False
        '
        'panGalaxyDownLeft
        '
        resources.ApplyResources(Me.panGalaxyDownLeft, "panGalaxyDownLeft")
        Me.panGalaxyDownLeft.Controls.Add(Me.rtbGalReport2)
        Me.panGalaxyDownLeft.Controls.Add(Me.Panel6)
        Me.panGalaxyDownLeft.Controls.Add(Me.panGalaxyLeftDown)
        Me.panGalaxyDownLeft.Controls.Add(Me.Panel5)
        Me.panGalaxyDownLeft.Controls.Add(Me.lbGalaxyPlanets)
        Me.panGalaxyDownLeft.Controls.Add(Me.PanGalaxyUp)
        Me.panGalaxyDownLeft.Name = "panGalaxyDownLeft"
        '
        'rtbGalReport2
        '
        Me.rtbGalReport2.BackColor = System.Drawing.Color.DimGray
        resources.ApplyResources(Me.rtbGalReport2, "rtbGalReport2")
        Me.rtbGalReport2.ForeColor = System.Drawing.Color.White
        Me.rtbGalReport2.Name = "rtbGalReport2"
        Me.rtbGalReport2.ReadOnly = True
        '
        'Panel6
        '
        Me.Panel6.BackColor = System.Drawing.Color.Transparent
        Me.Panel6.Controls.Add(Me.tbPlanetExtraInfo)
        resources.ApplyResources(Me.Panel6, "Panel6")
        Me.Panel6.Name = "Panel6"
        '
        'tbPlanetExtraInfo
        '
        resources.ApplyResources(Me.tbPlanetExtraInfo, "tbPlanetExtraInfo")
        Me.tbPlanetExtraInfo.Name = "tbPlanetExtraInfo"
        Me.tbPlanetExtraInfo.ReadOnly = True
        '
        'panGalaxyLeftDown
        '
        Me.panGalaxyLeftDown.BackColor = System.Drawing.Color.Transparent
        Me.panGalaxyLeftDown.Controls.Add(Me.labGalaxyRequieredTransport)
        resources.ApplyResources(Me.panGalaxyLeftDown, "panGalaxyLeftDown")
        Me.panGalaxyLeftDown.Name = "panGalaxyLeftDown"
        '
        'labGalaxyRequieredTransport
        '
        resources.ApplyResources(Me.labGalaxyRequieredTransport, "labGalaxyRequieredTransport")
        Me.labGalaxyRequieredTransport.ForeColor = System.Drawing.Color.Yellow
        Me.labGalaxyRequieredTransport.Name = "labGalaxyRequieredTransport"
        '
        'Panel5
        '
        Me.Panel5.Controls.Add(Me.lbGalPlayerResearch2)
        Me.Panel5.Controls.Add(Me.lbGalPlayerFlotte2)
        Me.Panel5.Controls.Add(Me.lbGalPlayerPoint2)
        Me.Panel5.Controls.Add(Me.btnChangeView)
        resources.ApplyResources(Me.Panel5, "Panel5")
        Me.Panel5.Name = "Panel5"
        '
        'lbGalPlayerResearch2
        '
        Me.lbGalPlayerResearch2.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        resources.ApplyResources(Me.lbGalPlayerResearch2, "lbGalPlayerResearch2")
        Me.lbGalPlayerResearch2.Name = "lbGalPlayerResearch2"
        '
        'lbGalPlayerFlotte2
        '
        Me.lbGalPlayerFlotte2.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        resources.ApplyResources(Me.lbGalPlayerFlotte2, "lbGalPlayerFlotte2")
        Me.lbGalPlayerFlotte2.Name = "lbGalPlayerFlotte2"
        '
        'lbGalPlayerPoint2
        '
        Me.lbGalPlayerPoint2.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        resources.ApplyResources(Me.lbGalPlayerPoint2, "lbGalPlayerPoint2")
        Me.lbGalPlayerPoint2.Name = "lbGalPlayerPoint2"
        '
        'btnChangeView
        '
        Me.btnChangeView.BackColor = System.Drawing.SystemColors.ControlLight
        resources.ApplyResources(Me.btnChangeView, "btnChangeView")
        Me.btnChangeView.Name = "btnChangeView"
        Me.btnChangeView.UseVisualStyleBackColor = False
        '
        'lbGalaxyPlanets
        '
        Me.lbGalaxyPlanets.BackColor = System.Drawing.Color.Black
        Me.lbGalaxyPlanets.BorderStyle = System.Windows.Forms.BorderStyle.None
        Me.lbGalaxyPlanets.ContextMenu = Me.cmGalaxie
        resources.ApplyResources(Me.lbGalaxyPlanets, "lbGalaxyPlanets")
        Me.lbGalaxyPlanets.ForeColor = System.Drawing.Color.White
        Me.lbGalaxyPlanets.Items.AddRange(New Object() {resources.GetString("lbGalaxyPlanets.Items"), resources.GetString("lbGalaxyPlanets.Items1"), resources.GetString("lbGalaxyPlanets.Items2"), resources.GetString("lbGalaxyPlanets.Items3"), resources.GetString("lbGalaxyPlanets.Items4"), resources.GetString("lbGalaxyPlanets.Items5"), resources.GetString("lbGalaxyPlanets.Items6"), resources.GetString("lbGalaxyPlanets.Items7"), resources.GetString("lbGalaxyPlanets.Items8"), resources.GetString("lbGalaxyPlanets.Items9"), resources.GetString("lbGalaxyPlanets.Items10"), resources.GetString("lbGalaxyPlanets.Items11"), resources.GetString("lbGalaxyPlanets.Items12"), resources.GetString("lbGalaxyPlanets.Items13"), resources.GetString("lbGalaxyPlanets.Items14")})
        Me.lbGalaxyPlanets.Name = "lbGalaxyPlanets"
        '
        'cmGalaxie
        '
        Me.cmGalaxie.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.miGalEditPlayer, Me.MenuItem1, Me.miGalImportSpyRep})
        '
        'miGalEditPlayer
        '
        resources.ApplyResources(Me.miGalEditPlayer, "miGalEditPlayer")
        Me.miGalEditPlayer.Index = 0
        '
        'MenuItem1
        '
        Me.MenuItem1.Index = 1
        resources.ApplyResources(Me.MenuItem1, "MenuItem1")
        '
        'miGalImportSpyRep
        '
        resources.ApplyResources(Me.miGalImportSpyRep, "miGalImportSpyRep")
        Me.miGalImportSpyRep.Index = 2
        '
        'PanGalaxyUp
        '
        Me.PanGalaxyUp.BackColor = System.Drawing.Color.Transparent
        Me.PanGalaxyUp.Controls.Add(Me.labGalaxyDataInfo)
        Me.PanGalaxyUp.Controls.Add(Me.labGalaxySystemTitle)
        resources.ApplyResources(Me.PanGalaxyUp, "PanGalaxyUp")
        Me.PanGalaxyUp.Name = "PanGalaxyUp"
        '
        'labGalaxyDataInfo
        '
        Me.labGalaxyDataInfo.BackColor = System.Drawing.Color.Transparent
        resources.ApplyResources(Me.labGalaxyDataInfo, "labGalaxyDataInfo")
        Me.labGalaxyDataInfo.ForeColor = System.Drawing.Color.Goldenrod
        Me.labGalaxyDataInfo.Name = "labGalaxyDataInfo"
        '
        'labGalaxySystemTitle
        '
        Me.labGalaxySystemTitle.BackColor = System.Drawing.Color.Transparent
        resources.ApplyResources(Me.labGalaxySystemTitle, "labGalaxySystemTitle")
        Me.labGalaxySystemTitle.ForeColor = System.Drawing.Color.Gold
        Me.labGalaxySystemTitle.Name = "labGalaxySystemTitle"
        '
        'PanGalaxyUpper
        '
        resources.ApplyResources(Me.PanGalaxyUpper, "PanGalaxyUpper")
        Me.PanGalaxyUpper.Controls.Add(Me.btnGalSearch)
        Me.PanGalaxyUpper.Controls.Add(Me.cbGalSearch)
        Me.PanGalaxyUpper.Controls.Add(Me.ComboBox1)
        Me.PanGalaxyUpper.Controls.Add(Me.nudGalaxy)
        Me.PanGalaxyUpper.Controls.Add(Me.labGalaxyNum)
        Me.PanGalaxyUpper.Controls.Add(Me.nudSystem)
        Me.PanGalaxyUpper.Controls.Add(Me.labSystemNum)
        Me.PanGalaxyUpper.Controls.Add(Me.btnPhallange)
        Me.PanGalaxyUpper.Name = "PanGalaxyUpper"
        '
        'btnGalSearch
        '
        resources.ApplyResources(Me.btnGalSearch, "btnGalSearch")
        Me.btnGalSearch.Name = "btnGalSearch"
        '
        'cbGalSearch
        '
        Me.cbGalSearch.BackColor = System.Drawing.Color.Gray
        resources.ApplyResources(Me.cbGalSearch, "cbGalSearch")
        Me.cbGalSearch.ForeColor = System.Drawing.Color.Yellow
        Me.cbGalSearch.Name = "cbGalSearch"
        '
        'ComboBox1
        '
        resources.ApplyResources(Me.ComboBox1, "ComboBox1")
        Me.ComboBox1.Name = "ComboBox1"
        '
        'nudGalaxy
        '
        resources.ApplyResources(Me.nudGalaxy, "nudGalaxy")
        Me.nudGalaxy.Maximum = New Decimal(New Integer() {9, 0, 0, 0})
        Me.nudGalaxy.Minimum = New Decimal(New Integer() {1, 0, 0, 0})
        Me.nudGalaxy.Name = "nudGalaxy"
        Me.nudGalaxy.Value = New Decimal(New Integer() {1, 0, 0, 0})
        '
        'labGalaxyNum
        '
        Me.labGalaxyNum.BackColor = System.Drawing.Color.Transparent
        Me.labGalaxyNum.ForeColor = System.Drawing.Color.Yellow
        resources.ApplyResources(Me.labGalaxyNum, "labGalaxyNum")
        Me.labGalaxyNum.Name = "labGalaxyNum"
        '
        'nudSystem
        '
        resources.ApplyResources(Me.nudSystem, "nudSystem")
        Me.nudSystem.Maximum = New Decimal(New Integer() {499, 0, 0, 0})
        Me.nudSystem.Minimum = New Decimal(New Integer() {1, 0, 0, 0})
        Me.nudSystem.Name = "nudSystem"
        Me.nudSystem.Value = New Decimal(New Integer() {1, 0, 0, 0})
        '
        'labSystemNum
        '
        Me.labSystemNum.BackColor = System.Drawing.Color.Transparent
        Me.labSystemNum.ForeColor = System.Drawing.Color.Yellow
        resources.ApplyResources(Me.labSystemNum, "labSystemNum")
        Me.labSystemNum.Name = "labSystemNum"
        '
        'btnPhallange
        '
        resources.ApplyResources(Me.btnPhallange, "btnPhallange")
        Me.btnPhallange.Name = "btnPhallange"
        '
        'tpMap
        '
        Me.tpMap.Controls.Add(Me.Map1)
        resources.ApplyResources(Me.tpMap, "tpMap")
        Me.tpMap.Name = "tpMap"
        Me.tpMap.UseVisualStyleBackColor = True
        '
        'Map1
        '
        resources.ApplyResources(Me.Map1, "Map1")
        Me.Map1.Name = "Map1"
        '
        'tpReports
        '
        Me.tpReports.Controls.Add(Me.tcReports)
        resources.ApplyResources(Me.tpReports, "tpReports")
        Me.tpReports.Name = "tpReports"
        Me.tpReports.UseVisualStyleBackColor = True
        '
        'tcReports
        '
        Me.tcReports.Controls.Add(Me.tpAlliancePlayer)
        Me.tcReports.Controls.Add(Me.tpReportsAttack)
        Me.tcReports.Controls.Add(Me.tpReportSpyings)
        Me.tcReports.Controls.Add(Me.tpStatistics)
        resources.ApplyResources(Me.tcReports, "tcReports")
        Me.tcReports.Name = "tcReports"
        Me.tcReports.SelectedIndex = 0
        '
        'tpAlliancePlayer
        '
        Me.tpAlliancePlayer.Controls.Add(Me.PlayerAllianceSubPanel1)
        resources.ApplyResources(Me.tpAlliancePlayer, "tpAlliancePlayer")
        Me.tpAlliancePlayer.Name = "tpAlliancePlayer"
        '
        'PlayerAllianceSubPanel1
        '
        resources.ApplyResources(Me.PlayerAllianceSubPanel1, "PlayerAllianceSubPanel1")
        Me.PlayerAllianceSubPanel1.Name = "PlayerAllianceSubPanel1"
        '
        'tpReportsAttack
        '
        Me.tpReportsAttack.Controls.Add(Me.LastAttacksCtrl1)
        resources.ApplyResources(Me.tpReportsAttack, "tpReportsAttack")
        Me.tpReportsAttack.Name = "tpReportsAttack"
        '
        'LastAttacksCtrl1
        '
        resources.ApplyResources(Me.LastAttacksCtrl1, "LastAttacksCtrl1")
        Me.LastAttacksCtrl1.Name = "LastAttacksCtrl1"
        '
        'tpReportSpyings
        '
        Me.tpReportSpyings.Controls.Add(Me.LastSpyingCtrl1)
        resources.ApplyResources(Me.tpReportSpyings, "tpReportSpyings")
        Me.tpReportSpyings.Name = "tpReportSpyings"
        '
        'LastSpyingCtrl1
        '
        resources.ApplyResources(Me.LastSpyingCtrl1, "LastSpyingCtrl1")
        Me.LastSpyingCtrl1.Name = "LastSpyingCtrl1"
        '
        'tpStatistics
        '
        Me.tpStatistics.Controls.Add(Me.PlayersStatsCtrl1)
        resources.ApplyResources(Me.tpStatistics, "tpStatistics")
        Me.tpStatistics.Name = "tpStatistics"
        '
        'PlayersStatsCtrl1
        '
        resources.ApplyResources(Me.PlayersStatsCtrl1, "PlayersStatsCtrl1")
        Me.PlayersStatsCtrl1.Name = "PlayersStatsCtrl1"
        '
        'tpDBStuff
        '
        Me.tpDBStuff.Controls.Add(Me.tcDBStuff)
        resources.ApplyResources(Me.tpDBStuff, "tpDBStuff")
        Me.tpDBStuff.Name = "tpDBStuff"
        Me.tpDBStuff.UseVisualStyleBackColor = True
        '
        'tcDBStuff
        '
        resources.ApplyResources(Me.tcDBStuff, "tcDBStuff")
        Me.tcDBStuff.Controls.Add(Me.tpBougeTaBase)
        Me.tcDBStuff.Controls.Add(Me.tpCleanDatabase)
        Me.tcDBStuff.Multiline = True
        Me.tcDBStuff.Name = "tcDBStuff"
        Me.tcDBStuff.SelectedIndex = 0
        '
        'tpBougeTaBase
        '
        Me.tpBougeTaBase.Controls.Add(Me.DbStuffCtrl1)
        resources.ApplyResources(Me.tpBougeTaBase, "tpBougeTaBase")
        Me.tpBougeTaBase.Name = "tpBougeTaBase"
        '
        'DbStuffCtrl1
        '
        resources.ApplyResources(Me.DbStuffCtrl1, "DbStuffCtrl1")
        Me.DbStuffCtrl1.Name = "DbStuffCtrl1"
        '
        'tpCleanDatabase
        '
        Me.tpCleanDatabase.Controls.Add(Me.CleanDatabaseCtrl1)
        resources.ApplyResources(Me.tpCleanDatabase, "tpCleanDatabase")
        Me.tpCleanDatabase.Name = "tpCleanDatabase"
        '
        'CleanDatabaseCtrl1
        '
        resources.ApplyResources(Me.CleanDatabaseCtrl1, "CleanDatabaseCtrl1")
        Me.CleanDatabaseCtrl1.Name = "CleanDatabaseCtrl1"
        '
        'tpRemoteDB
        '
        Me.tpRemoteDB.Controls.Add(Me.ImportExportCtrl1)
        resources.ApplyResources(Me.tpRemoteDB, "tpRemoteDB")
        Me.tpRemoteDB.Name = "tpRemoteDB"
        Me.tpRemoteDB.UseVisualStyleBackColor = True
        '
        'ImportExportCtrl1
        '
        resources.ApplyResources(Me.ImportExportCtrl1, "ImportExportCtrl1")
        Me.ImportExportCtrl1.Name = "ImportExportCtrl1"
        '
        'tpRanking
        '
        Me.tpRanking.Controls.Add(Me.btnLoadStatistics)
        Me.tpRanking.Controls.Add(Me.panRank)
        Me.tpRanking.Controls.Add(Me.PanRankFilter)
        Me.tpRanking.Controls.Add(Me.gbRankType)
        resources.ApplyResources(Me.tpRanking, "tpRanking")
        Me.tpRanking.Name = "tpRanking"
        Me.tpRanking.UseVisualStyleBackColor = True
        '
        'btnLoadStatistics
        '
        resources.ApplyResources(Me.btnLoadStatistics, "btnLoadStatistics")
        Me.btnLoadStatistics.Name = "btnLoadStatistics"
        '
        'panRank
        '
        resources.ApplyResources(Me.panRank, "panRank")
        Me.panRank.Controls.Add(Me.dgPlayerRanking)
        Me.panRank.Name = "panRank"
        '
        'dgPlayerRanking
        '
        Me.dgPlayerRanking.AlternatingBackColor = System.Drawing.Color.White
        Me.dgPlayerRanking.BackColor = System.Drawing.Color.White
        Me.dgPlayerRanking.BackgroundColor = System.Drawing.Color.Ivory
        Me.dgPlayerRanking.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.dgPlayerRanking.CaptionBackColor = System.Drawing.Color.DarkSlateBlue
        resources.ApplyResources(Me.dgPlayerRanking, "dgPlayerRanking")
        Me.dgPlayerRanking.CaptionForeColor = System.Drawing.Color.Lavender
        Me.dgPlayerRanking.CaptionVisible = False
        Me.dgPlayerRanking.DataMember = ""
        Me.dgPlayerRanking.FlatMode = True
        Me.dgPlayerRanking.ForeColor = System.Drawing.Color.Black
        Me.dgPlayerRanking.GridLineColor = System.Drawing.Color.Wheat
        Me.dgPlayerRanking.HeaderBackColor = System.Drawing.Color.CadetBlue
        Me.dgPlayerRanking.HeaderFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgPlayerRanking.HeaderForeColor = System.Drawing.Color.Black
        Me.dgPlayerRanking.LinkColor = System.Drawing.Color.DarkSlateBlue
        Me.dgPlayerRanking.Name = "dgPlayerRanking"
        Me.dgPlayerRanking.ParentRowsBackColor = System.Drawing.Color.Ivory
        Me.dgPlayerRanking.ParentRowsForeColor = System.Drawing.Color.Black
        Me.dgPlayerRanking.ReadOnly = True
        Me.dgPlayerRanking.SelectionBackColor = System.Drawing.Color.Wheat
        Me.dgPlayerRanking.SelectionForeColor = System.Drawing.Color.DarkSlateBlue
        '
        'PanRankFilter
        '
        resources.ApplyResources(Me.PanRankFilter, "PanRankFilter")
        Me.PanRankFilter.Controls.Add(Me.btnDeleteRank)
        Me.PanRankFilter.Name = "PanRankFilter"
        '
        'btnDeleteRank
        '
        resources.ApplyResources(Me.btnDeleteRank, "btnDeleteRank")
        Me.btnDeleteRank.Name = "btnDeleteRank"
        '
        'gbRankType
        '
        Me.gbRankType.Controls.Add(Me.Label3)
        Me.gbRankType.Controls.Add(Me.Label1)
        Me.gbRankType.Controls.Add(Me.rbAlliPoints)
        Me.gbRankType.Controls.Add(Me.rbAlliFlotte)
        Me.gbRankType.Controls.Add(Me.rbAlliResearch)
        Me.gbRankType.Controls.Add(Me.rbPointsx)
        Me.gbRankType.Controls.Add(Me.rbFlotte)
        Me.gbRankType.Controls.Add(Me.rbResearch)
        resources.ApplyResources(Me.gbRankType, "gbRankType")
        Me.gbRankType.Name = "gbRankType"
        Me.gbRankType.TabStop = False
        '
        'Label3
        '
        resources.ApplyResources(Me.Label3, "Label3")
        Me.Label3.Name = "Label3"
        '
        'Label1
        '
        resources.ApplyResources(Me.Label1, "Label1")
        Me.Label1.Name = "Label1"
        '
        'rbAlliPoints
        '
        resources.ApplyResources(Me.rbAlliPoints, "rbAlliPoints")
        Me.rbAlliPoints.Name = "rbAlliPoints"
        '
        'rbAlliFlotte
        '
        resources.ApplyResources(Me.rbAlliFlotte, "rbAlliFlotte")
        Me.rbAlliFlotte.Name = "rbAlliFlotte"
        '
        'rbAlliResearch
        '
        resources.ApplyResources(Me.rbAlliResearch, "rbAlliResearch")
        Me.rbAlliResearch.Name = "rbAlliResearch"
        '
        'rbPointsx
        '
        Me.rbPointsx.Checked = True
        resources.ApplyResources(Me.rbPointsx, "rbPointsx")
        Me.rbPointsx.Name = "rbPointsx"
        Me.rbPointsx.TabStop = True
        '
        'rbFlotte
        '
        resources.ApplyResources(Me.rbFlotte, "rbFlotte")
        Me.rbFlotte.Name = "rbFlotte"
        '
        'rbResearch
        '
        resources.ApplyResources(Me.rbResearch, "rbResearch")
        Me.rbResearch.Name = "rbResearch"
        '
        'tpEmpire
        '
        Me.tpEmpire.Controls.Add(Me.EmpireCtrl1)
        resources.ApplyResources(Me.tpEmpire, "tpEmpire")
        Me.tpEmpire.Name = "tpEmpire"
        Me.tpEmpire.UseVisualStyleBackColor = True
        '
        'EmpireCtrl1
        '
        resources.ApplyResources(Me.EmpireCtrl1, "EmpireCtrl1")
        Me.EmpireCtrl1.FoundData = Spydata1
        Me.EmpireCtrl1.Name = "EmpireCtrl1"
        Me.EmpireCtrl1.Player = Nothing
        '
        'PictureBox3
        '
        Me.PictureBox3.BackColor = System.Drawing.Color.Transparent
        resources.ApplyResources(Me.PictureBox3, "PictureBox3")
        Me.PictureBox3.Name = "PictureBox3"
        Me.PictureBox3.TabStop = False
        '
        'PictureBox2
        '
        resources.ApplyResources(Me.PictureBox2, "PictureBox2")
        Me.PictureBox2.BackColor = System.Drawing.Color.Transparent
        Me.PictureBox2.Name = "PictureBox2"
        Me.PictureBox2.TabStop = False
        '
        'PictureBox1
        '
        resources.ApplyResources(Me.PictureBox1, "PictureBox1")
        Me.PictureBox1.Cursor = System.Windows.Forms.Cursors.Hand
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.TabStop = False
        '
        'ogamelinkfr
        '
        resources.ApplyResources(Me.ogamelinkfr, "ogamelinkfr")
        Me.ogamelinkfr.BackColor = System.Drawing.Color.Transparent
        Me.ogamelinkfr.LinkColor = System.Drawing.Color.LightBlue
        Me.ogamelinkfr.Name = "ogamelinkfr"
        Me.ogamelinkfr.TabStop = True
        '
        'LinkLabel1
        '
        resources.ApplyResources(Me.LinkLabel1, "LinkLabel1")
        Me.LinkLabel1.BackColor = System.Drawing.Color.Transparent
        Me.LinkLabel1.LinkColor = System.Drawing.Color.LightBlue
        Me.LinkLabel1.Name = "LinkLabel1"
        Me.LinkLabel1.TabStop = True
        Me.LinkLabel1.UseMnemonic = False
        '
        'LinkLabel2
        '
        resources.ApplyResources(Me.LinkLabel2, "LinkLabel2")
        Me.LinkLabel2.BackColor = System.Drawing.Color.Transparent
        Me.LinkLabel2.LinkColor = System.Drawing.Color.LightBlue
        Me.LinkLabel2.Name = "LinkLabel2"
        Me.LinkLabel2.TabStop = True
        '
        'LinkLabel3
        '
        resources.ApplyResources(Me.LinkLabel3, "LinkLabel3")
        Me.LinkLabel3.BackColor = System.Drawing.Color.Transparent
        Me.LinkLabel3.LinkColor = System.Drawing.Color.LightBlue
        Me.LinkLabel3.Name = "LinkLabel3"
        Me.LinkLabel3.TabStop = True
        '
        'Label2
        '
        resources.ApplyResources(Me.Label2, "Label2")
        Me.Label2.BackColor = System.Drawing.Color.Transparent
        Me.Label2.ForeColor = System.Drawing.Color.Linen
        Me.Label2.Name = "Label2"
        '
        'btnGoToOGSHomeSite
        '
        resources.ApplyResources(Me.btnGoToOGSHomeSite, "btnGoToOGSHomeSite")
        Me.btnGoToOGSHomeSite.Name = "btnGoToOGSHomeSite"
        '
        'btnCheckUpdate
        '
        resources.ApplyResources(Me.btnCheckUpdate, "btnCheckUpdate")
        Me.btnCheckUpdate.Name = "btnCheckUpdate"
        '
        'labHelp
        '
        resources.ApplyResources(Me.labHelp, "labHelp")
        Me.labHelp.BackColor = System.Drawing.Color.Transparent
        Me.labHelp.ForeColor = System.Drawing.Color.MistyRose
        Me.labHelp.Name = "labHelp"
        '
        'Timer1
        '
        Me.Timer1.Enabled = True
        Me.Timer1.Interval = 500
        Me.Timer1.SynchronizingObject = Me
        '
        'sfdExport
        '
        Me.sfdExport.DefaultExt = "dat"
        resources.ApplyResources(Me.sfdExport, "sfdExport")
        '
        'OpenFileDialog1
        '
        Me.OpenFileDialog1.DefaultExt = "dat"
        resources.ApplyResources(Me.OpenFileDialog1, "OpenFileDialog1")
        '
        'Universes
        '
        Me.Controls.Add(Me.panMain)
        Me.Controls.Add(Me.Panel1)
        Me.Name = "Universes"
        resources.ApplyResources(Me, "$this")
        Me.Panel1.ResumeLayout(False)
        Me.panMain.ResumeLayout(False)
        Me.panMain.PerformLayout()
        Me.TabControl1.ResumeLayout(False)
        Me.tpGalaxy.ResumeLayout(False)
        Me.panGalaxyDownRight.ResumeLayout(False)
        Me.Panel4.ResumeLayout(False)
        Me.panGalaxyMiddleright.ResumeLayout(False)
        Me.Panel3.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.panGalaxyPlanetInfo.ResumeLayout(False)
        CType(Me.nudAttackLimit, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.nudSpyLimit, System.ComponentModel.ISupportInitialize).EndInit()
        Me.panGalaxyDownLeft.ResumeLayout(False)
        Me.Panel6.ResumeLayout(False)
        Me.Panel6.PerformLayout()
        Me.panGalaxyLeftDown.ResumeLayout(False)
        Me.Panel5.ResumeLayout(False)
        Me.PanGalaxyUp.ResumeLayout(False)
        Me.PanGalaxyUpper.ResumeLayout(False)
        CType(Me.nudGalaxy, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.nudSystem, System.ComponentModel.ISupportInitialize).EndInit()
        Me.tpMap.ResumeLayout(False)
        Me.tpReports.ResumeLayout(False)
        Me.tcReports.ResumeLayout(False)
        Me.tpAlliancePlayer.ResumeLayout(False)
        Me.tpReportsAttack.ResumeLayout(False)
        Me.tpReportSpyings.ResumeLayout(False)
        Me.tpStatistics.ResumeLayout(False)
        Me.tpDBStuff.ResumeLayout(False)
        Me.tcDBStuff.ResumeLayout(False)
        Me.tpBougeTaBase.ResumeLayout(False)
        Me.tpCleanDatabase.ResumeLayout(False)
        Me.tpRemoteDB.ResumeLayout(False)
        Me.tpRanking.ResumeLayout(False)
        Me.panRank.ResumeLayout(False)
        CType(Me.dgPlayerRanking, System.ComponentModel.ISupportInitialize).EndInit()
        Me.PanRankFilter.ResumeLayout(False)
        Me.gbRankType.ResumeLayout(False)
        Me.gbRankType.PerformLayout()
        Me.tpEmpire.ResumeLayout(False)
        CType(Me.PictureBox3, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.Timer1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub

#End Region
    Public Event ImportedSystem(ByVal sender As Object, ByVal SystemCoords As String)
    Public Event ImportedLines(ByVal sender As Object, ByVal lines As Integer)
    Public Event ImportedResult(ByVal sender As Object, ByVal PlanetUpdated As Integer, ByVal PlanetAdded As Integer, ByVal PlayerUpdated As Integer, ByVal PlayerAdded As Integer)
    Public Event ScanModeRequest(ByVal sender As Object)
    Public Event MessageEvent(ByVal message As String, ByVal EventInfo As OGameObject.enOGSEventType)

    Public Shared SpyBitmap As System.Drawing.Bitmap = New System.Drawing.Bitmap(New System.Drawing.Bitmap(TextFileResourceStream("letnum_info_001.gif")), 12, 12)
    Public Shared AttackBitmap As System.Drawing.Bitmap = New System.Drawing.Bitmap(New System.Drawing.Bitmap(TextFileResourceStream("letnum_question_002.gif")), 12, 12)
    Private Sub Timer1_Elapsed(ByVal sender As System.Object, ByVal e As System.Timers.ElapsedEventArgs) Handles Timer1.Elapsed
        If lblTitle.Tag = "blink" Then
            If Not lblTitle.ForeColor.Equals(System.Drawing.Color.Red) Then
                lblTitle.ForeColor = System.Drawing.Color.Red
            Else
                lblTitle.ForeColor = System.Drawing.Color.LightPink
            End If
        End If
    End Sub
    Private WithEvents pOgameDB As OGameObject.OGameDBEngine

    Public Property OGameDB() As OGameObject.OGameDBEngine
        Get
            Return pOgameDB
        End Get
        Set(ByVal Value As OGameObject.OGameDBEngine)
            pOgameDB = Value
            If Not pOgameDB Is Nothing AndAlso Not pOgameDB.Universe Is Nothing Then
                lblTitle.Text = pOgameDB.Universe.ToString
                lblTitle.Tag = ""
                lblTitle.ForeColor = System.Drawing.Color.LightGreen
                TabControl1.Enabled = True


            Else
                ComboBox1.Items.Clear()
                lblTitle.Text = "No Database Selected"
                lblTitle.Tag = "blink"
                lblTitle.ForeColor = System.Drawing.Color.Red
                TabControl1.Enabled = False
            End If
        End Set
    End Property
    Private Shared staticSplash As Splash = Nothing
    Public Shared Sub SplashMessage(ByVal Message As String)
        If staticSplash Is Nothing Then


            staticSplash = New Splash
            'u.Parent = Me
            'staticSplash.Owner = Application.d .FindForm
            staticSplash.TopMost = True
        End If
        staticSplash.Message = Message
        staticSplash.Show()
        staticSplash.Refresh()
    End Sub

    Public Shared Sub SplashClose()
        If staticSplash Is Nothing Then Return
        staticSplash.Close()
        staticSplash = Nothing
    End Sub

    Public Sub OpenUniverse(ByVal UniDB As OGameObject.UniverseDB)
        If Not OGameDB Is Nothing Then
            OGameDB.Close()
            OGameDB = Nothing
        End If
        OGameDB = New OGameObject.OGameDBEngine(UniDB)

        'cbExportImportRemoteAccounts.Items.Clear()
        'For Each s As OGameObject.RemoteAccount In UniDB.RemoteAccounts
        '    cbExportImportRemoteAccounts.Items.Add(s)
        '    If s.DefaultAccount Then cbExportImportRemoteAccounts.SelectedItem = s
        'Next
        'If SelectedAccount Is Nothing Then
        '    If UniDB.RemoteAccounts.Count Then
        '        cbExportImportRemoteAccounts.SelectedIndex = 0
        '    End If
        'End If
        '        SplashMessage("Opening Database and retrieving basic data")
        If OGameDB.Open() Then
            RaiseEvent OnDatabaseOpen(OGameDB)
            labHelp.Visible = False
            TabControl1.Visible = True
            For Each dbc As OGameObject.DBConfigEntry In OGameDB.GetFavorites
                ComboBox1.Items.Add(dbc.ParamValue)
            Next
            If ComboBox1.Items.Count > 0 Then
                ComboBox1.SelectedIndex = 0
                ComboBox1_Validated(Nothing, Nothing)
            End If
            rtbGalaxyReport.Text = OGameDB.DBStatistic
            Application.DoEvents()
            If OGameObject.OGameDBEngine.Default.Universe.MyPlayerID <> 0 Then
                EmpireCtrl1.Player = OGameObject.Player.FromPlayerID(OGameObject.OGameDBEngine.Default.Universe.MyPlayerID)
            End If

        End If
        'SplashClose()
    End Sub

    Public Event OnDatabaseOpen(ByVal OgameDB As OGameObject.OGameDBEngine)
    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        Dim d As New UniversesDatabaseForm
        d.Owner = Me.FindForm
        d.TopMost = True
        d.StartPosition = FormStartPosition.CenterParent
        If d.ShowDialog() = DialogResult.OK Then
            SaveCurrentUniverseOption()
            OpenUniverse(d.Universe)
            LoadCurrentUniverseOptions()
        End If
    End Sub

    Public Sub SaveCurrentUniverseOption()
        If Not OGameDB Is Nothing AndAlso Not OGameDB.Universe Is Nothing AndAlso Not Map1.PartialMapCtrl1 Is Nothing Then
            Dim UniCol As OGameObject.UniversesDBCol = OGameObject.UniversesDBCol.XMLDeSerialize
            Dim LastUni As OGameObject.UniverseDB = UniCol.RegisteredUniverse(OGameDB.Universe)
            If Not LastUni Is Nothing Then
                LastUni.map_ShowRank = Map1.PartialMapCtrl1.chkShowRank.Checked
                LastUni.map_ShowSpy = Map1.PartialMapCtrl1.chkShowSpy.Checked
                LastUni.map_ShowSpyNumber = Map1.PartialMapCtrl1.tbSpyHourLessThan.Text
                LastUni.map_ShowAttack = Map1.PartialMapCtrl1.chkShowAttack.Checked
                LastUni.map_ShowAttackNumber = Map1.PartialMapCtrl1.tbAttackHourLessThan.Text
                LastUni.map_ShowRecycler = Map1.PartialMapCtrl1.chkRecyclers.Checked
                LastUni.map_ShowRecyclerNumber = Map1.PartialMapCtrl1.tbRecyclerNeeded.Text
                LastUni.map_ShowLargeCargo = Map1.PartialMapCtrl1.chkLargeCargo.Checked
                LastUni.map_ShowLargeCargoNumber = Map1.PartialMapCtrl1.tbLargeCargoNeeded.Text
                UniCol.Save()
            End If
        End If
    End Sub

    Public Sub LoadCurrentUniverseOptions()
        If OGameDB.Universe Is Nothing Then Return
        With OGameDB.Universe
            If Map1.PartialMapCtrl1 Is Nothing Then Return
            Map1.PartialMapCtrl1.chkShowRank.Checked = .map_ShowRank
            Map1.PartialMapCtrl1.chkShowSpy.Checked = .map_ShowSpy
            Map1.PartialMapCtrl1.tbSpyHourLessThan.Text = .map_ShowSpyNumber
            Map1.PartialMapCtrl1.chkShowAttack.Checked = .map_ShowAttack
            Map1.PartialMapCtrl1.tbAttackHourLessThan.Text = .map_ShowAttackNumber
            Map1.PartialMapCtrl1.chkRecyclers.Checked = .map_ShowRecycler
            Map1.PartialMapCtrl1.tbRecyclerNeeded.Text = .map_ShowRecyclerNumber
            Map1.PartialMapCtrl1.chkLargeCargo.Checked = .map_ShowLargeCargo
            Map1.PartialMapCtrl1.tbLargeCargoNeeded.Text = .map_ShowLargeCargoNumber
        End With
    End Sub

    Private Sub Universes_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        TabControl1.Dock = DockStyle.Fill
        '        cbSearchIn.SelectedIndex = 0
        '        RichTextBox1.Rtf = TextFileResource("texavery.rtf")
        Dim oguc As OGameObject.UniversesDBCol = OGameObject.UniversesDBCol.XMLDeSerialize
        If Not oguc Is Nothing Then
            For Each ogu As OGameObject.UniverseDB In oguc
                If ogu.DefaultUniverse Then
                    OpenUniverse(ogu)
                    Exit For
                End If
            Next
        End If
    End Sub

    Private Sub PictureBox1_Click_1(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles PictureBox1.Click
        System.Diagnostics.Process.Start("http://firebird.sourceforge.net/")
    End Sub

    Private Sub ogamelinkfr_LinkClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.LinkLabelLinkClickedEventArgs) Handles ogamelinkfr.LinkClicked, LinkLabel1.LinkClicked, LinkLabel2.LinkClicked, LinkLabel3.LinkClicked
        System.Diagnostics.Process.Start(CType(sender, LinkLabel).Text)
    End Sub

#Region " Rank tab related procedures "
    Private Sub btnDeleteRank_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnDeleteRank.Click
        Dim MsgbMessage As String = "Are you sure you want to remove all data for  "

        If rbAlliPoints.Checked Then
            MsgbMessage &= "Alliance Points Ranking Statistics"
        ElseIf rbAlliFlotte.Checked Then
            MsgbMessage &= "Alliance Flotte Ranking Statistics"
        ElseIf rbAlliResearch.Checked Then
            MsgbMessage &= "Alliance Research Ranking Statistics"
        ElseIf rbPointsx.Checked Then
            MsgbMessage &= "Players Points Ranking Statistics"
        ElseIf rbFlotte.Checked Then
            MsgbMessage &= "Players Flotte Ranking Statistics"
        Else
            MsgbMessage &= "Players Research Ranking Statistics"
        End If

        MsgbMessage &= " ?"

        If MessageBox.Show(MainForm.TopForm, _
            MsgbMessage, _
            "OGame Stratege: Database purge", _
            MsgBoxStyle.YesNo, _
            MessageBoxIcon.Exclamation, _
            MessageBoxDefaultButton.Button2) <> MsgBoxResult.Yes Then Return

        Dim RowsAffected As Integer = 0

        If rbAlliPoints.Checked Then
            RowsAffected = OGameDB.DeleteAlliRank
        ElseIf rbAlliFlotte.Checked Then
            RowsAffected = OGameDB.DeleteAlliFlotte
        ElseIf rbAlliResearch.Checked Then
            RowsAffected = OGameDB.DeleteAlliResearch
        ElseIf rbPointsx.Checked Then
            RowsAffected = OGameDB.DeletePlayersRank
        ElseIf rbFlotte.Checked Then
            RowsAffected = OGameDB.DeletePlayersFlotte
        Else
            RowsAffected = OGameDB.DeletePlayersResearch
        End If

        MessageBox.Show(MainForm.TopForm, RowsAffected & " records deleted.", "Statistics Deletion", MsgBoxStyle.OkOnly, MessageBoxIcon.Information)
    End Sub

    Private Sub btnLoadStatistics_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnLoadStatistics.Click
        Dim u As New Splash
        'u.Parent = Me

        If rbAlliResearch.Checked AndAlso Not OGameDB Is Nothing Then
            u.Owner = Me.FindForm
            u.Message = "Retrieving Alliance Research Rank Data"
            u.Show()
            u.Refresh()

            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            dgPlayerRanking.SetDataBinding(OGameDB.AlliRankingResearch, "")
            Me.Cursor = System.Windows.Forms.Cursors.Default
        ElseIf rbAlliFlotte.Checked AndAlso Not OGameDB Is Nothing Then
            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            u.Owner = Me.FindForm
            u.Message = "Retrieving Alliance Flotte Rank data"
            u.Show()
            u.Refresh()

            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            dgPlayerRanking.SetDataBinding(OGameDB.AlliRankingFlotte, "")
            Me.Cursor = System.Windows.Forms.Cursors.Default
        ElseIf rbAlliPoints.Checked AndAlso Not OGameDB Is Nothing Then
            u.Owner = Me.FindForm
            u.Message = "Retrieving Alliance Points Data"
            u.Show()
            u.Refresh()

            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            dgPlayerRanking.SetDataBinding(OGameDB.AlliRankingPoints, "")
            Me.Cursor = System.Windows.Forms.Cursors.Default
        ElseIf rbResearch.Checked AndAlso Not OGameDB Is Nothing Then
            u.Owner = Me.FindForm
            u.Message = "Retrieving Research Rank Data"
            u.Show()
            u.Refresh()

            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            dgPlayerRanking.SetDataBinding(OGameDB.PlayersRankingResearch, "")
            Me.Cursor = System.Windows.Forms.Cursors.Default
        ElseIf rbFlotte.Checked AndAlso Not OGameDB Is Nothing Then
            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            u.Owner = Me.FindForm
            u.Message = "Retrieving Flotte Rank data"
            u.Show()
            u.Refresh()

            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            dgPlayerRanking.SetDataBinding(OGameDB.PlayersRankingFlotte, "")
            Me.Cursor = System.Windows.Forms.Cursors.Default
        ElseIf rbPointsx.Checked AndAlso Not OGameDB Is Nothing Then
            u.Owner = Me.FindForm
            u.Message = "Retrieving Player Points Data"
            u.Show()
            u.Refresh()

            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            dgPlayerRanking.SetDataBinding(OGameDB.PlayersRankingPoints, "")
            Me.Cursor = System.Windows.Forms.Cursors.Default
        End If
        u.Close()
    End Sub
#End Region


    Public Event TitleClicked(ByVal Sender As Object)

    Private Sub lblTitle_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lblTitle.Click
        RaiseEvent TitleClicked(Me)
    End Sub


#Region " Galaxy Tabpage related functions "
    'Les Favoris
    Private Sub ComboBox1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ComboBox1.SelectedIndexChanged
        Dim GalSysPattern As String = "(?<Galaxy>\d):(?<System>\d+)"
        Dim m As Match = Regex.Match(ComboBox1.Text, GalSysPattern)
        If m.Success Then
            nudGalaxy.Value = m.Groups("Galaxy").Value
            nudSystem.Value = m.Groups("System").Value
            If ComboBox1.Items.IndexOf(ComboBox1.Text) < 0 Then
                ComboBox1.Items.Insert(0, ComboBox1.Text)
                If Not OGameObject.DBConfigEntry.Exist("FAVORITE", ComboBox1.Text) Then
                    Dim DBC As New OGameObject.DBConfigEntry("FAVORITE", ComboBox1.Text)
                    DBC.InsertUpdate()
                End If
            End If
        End If

    End Sub
    Private Sub ComboBox1_Validated(ByVal sender As Object, ByVal e As System.EventArgs) Handles ComboBox1.Validated

        Dim GalSysPattern As String = "(?<Galaxy>\d):(?<System>\d+)"
        Dim m As Match = Regex.Match(ComboBox1.Text, GalSysPattern)
        If m.Success Then
            nudGalaxy.Value = m.Groups("Galaxy").Value
            nudSystem.Value = m.Groups("System").Value
            If ComboBox1.Items.IndexOf(ComboBox1.Text) < 0 Then
                ComboBox1.Items.Insert(0, ComboBox1.Text)
                If Not OGameObject.DBConfigEntry.Exist("FAVORITE", ComboBox1.Text) Then
                    Dim DBC As New OGameObject.DBConfigEntry("FAVORITE", ComboBox1.Text)
                    DBC.InsertUpdate()
                End If
            End If
        End If
    End Sub

    Public Enum enShowMode
        Galaxy
        SearchResults
    End Enum
    Private pShowMode As enShowMode = enShowMode.Galaxy
    Public Property ShowMode() As enShowMode
        Get
            Return pShowMode
        End Get
        Set(ByVal Value As enShowMode)
            If Value <> pShowMode Then

                labGalaxyDataInfo.Text = ""
                lbGalaxyPlanetAttacks.Items.Clear()
                lbGalaxyPlanetSpy.Items.Clear()
                lbGalaxyPlanets.Items.Clear()
                lbGalaxyPlanets.Tag = Nothing
                pShowMode = Value

                Select Case Value


                    Case enShowMode.Galaxy
                        lbGalaxyPlanets.DrawMode = DrawMode.OwnerDrawFixed
                        labGalaxySystemTitle.Text = "Galaxy System"
                        nudGalaxy_ValueChanged(Nothing, Nothing)
                        '                        chkExportedData.Enabled = True
                    Case enShowMode.SearchResults
                        '                       chkExportedData.Enabled = False
                        lbGalaxyPlanets.Enabled = True
                        lbGalaxyPlanets.DrawMode = DrawMode.Normal
                        labGalaxySystemTitle.Text = "Search Result"

                        If cbGalSearch.Text <> "" Then
                            '                            Dim u As OGameObject.PlayerCol = 
                            For Each p As OGameObject.Player In OGameDB.SearchPlayers(cbGalSearch.Text)

                                lbGalaxyPlanets.Items.Add(p)
                            Next
                            For Each p As OGameObject.Planet In OGameDB.SearchPlanet(cbGalSearch.Text)
                                p.ToStringFormat = OGameObject.Planet.enToStringFormat.CoordsName
                                lbGalaxyPlanets.Items.Add(p)
                            Next
                        End If


                End Select


            End If
            pShowMode = Value

        End Set
    End Property
    ''' <summary>
    ''' Affiche les infos planètes du systeme choisi
    ''' </summary>
    ''' <param name="GalNum">Numéro de la Galaxie</param>
    ''' <param name="SysNum">Numéro du systeme</param>
    ''' <remarks></remarks>
    Public Sub SetGalaxyView(ByVal GalNum As Integer, ByVal SysNum As Integer)
        lbGalaxyPlanets.SuspendLayout()
        TabControl1.SelectedTab = tpGalaxy
        Application.DoEvents()
        Dim gal As OGameObject.Galaxy = OGameObject.Galaxy.FromCoords(GalNum, SysNum)
        lbGalaxyPlanets.Items.Clear()
        lbGalaxyPlanets.Tag = Nothing
        ShowMode = enShowMode.Galaxy

        If gal Is Nothing Then
            sbGalaxy.Text = "Pas d'info pour  " & nudGalaxy.Value & ":" & nudSystem.Value
            lbGalaxyPlanets.Enabled = False
            For i As Integer = 1 To 14
                lbGalaxyPlanets.Items.Add(i)
            Next
            lbGalaxyPlanets.DrawMode = DrawMode.Normal
        Else

            lbGalaxyPlanets.DrawMode = DrawMode.OwnerDrawFixed
            sbGalaxy.Text = gal.ToString
            lbGalaxyPlanets.Enabled = True
            For Each p As Object In gal.Planets
                lbGalaxyPlanets.Items.Add(p)
            Next
            labGalaxySystemTitle.Text = gal.Coords
            labGalaxyDataInfo.Text = " enregistré le " & gal.DataDate.ToString("MM-dd HH:mm:ss")

        End If
        lbGalaxyPlanets.Tag = gal
        lbGalaxyPlanets_SelectedIndexChanged(Nothing, Nothing)
        lbGalaxyPlanets.ResumeLayout()
    End Sub
    ''' <summary>
    ''' Réaction aux changement de valeur Galaxie/Systeme 
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub nudGalaxy_ValueChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles nudGalaxy.ValueChanged, nudSystem.ValueChanged
        SetGalaxyView(nudGalaxy.Value, nudSystem.Value)
    End Sub


    Private Sub lbGalaxyPlanets_DrawItem(ByVal sender As Object, ByVal e As System.Windows.Forms.DrawItemEventArgs) Handles lbGalaxyPlanets.DrawItem

        If ShowMode = enShowMode.SearchResults Then

        ElseIf ShowMode = enShowMode.Galaxy Then

            'Aucune n'est selectionnée
            If e.Index < 0 Then Return

            Dim bSelected As Boolean = ((e.State And DrawItemState.Selected) = DrawItemState.Selected)
            Dim stringFormat As New StringFormat
            stringFormat.Alignment = StringAlignment.Center
            stringFormat.LineAlignment = StringAlignment.Center

            'Cadre de fond de la ligne
            e.DrawBackground()
            e.DrawFocusRectangle()


            Dim pl As OGameObject.Planet = CType(lbGalaxyPlanets.Items(e.Index), OGameObject.Planet)
            Dim rDraw As New RectangleF(e.Bounds.X, e.Bounds.Y, e.Bounds.Width, e.Bounds.Height)

            'Affichage de la colonne Coordonnée/Lune
            Dim NumStr As String = pl.Num
            If pl.Moon <> "" Then NumStr &= " " & pl.Moon
            e.Graphics.DrawString(NumStr, e.Font, New System.Drawing.SolidBrush(lbGalaxyPlanets.ForeColor), e.Bounds.X, e.Bounds.Y)

            'Affichage du nom de la planète
            Dim rect As New RectangleF(e.Bounds.X + 200, e.Bounds.Y, e.Bounds.Width - 250, e.Bounds.Height)
            e.Graphics.DrawString(pl.Name, e.Font, New System.Drawing.SolidBrush(lbGalaxyPlanets.ForeColor), rect, stringFormat)

            'Affichage du propriétaire
            If pl.Owner.ID <> 0 Then
                rect = New RectangleF(e.Bounds.X + 123, e.Bounds.Y, 78, e.Bounds.Height)
                e.Graphics.DrawString("[ " & pl.Owner.Alliance & " ] ", e.Font, System.Drawing.Brushes.LightGreen, rect, stringFormat)
                '                rect = New RectangleF(e.Bounds.X + 200, e.Bounds.Y, e.Bounds.Width - 250, e.Bounds.Height)
                rect = New RectangleF(e.Bounds.X + 38, e.Bounds.Y, 85, e.Bounds.Height)
                Dim txtName As String = pl.Owner.Name & "(" & _
                        IIf(pl.Owner.ShortInactive, "i", "") & _
                        IIf(pl.Owner.LongInactive, "I", "") & _
                         IIf(pl.Owner.Blocked, "b", "") & _
                         IIf(pl.Owner.Noob, "d", "") & _
                        IIf(pl.Owner.Vacancy, "v", "") & _
                        ")"
                If pl.Owner.Blocked Then
                    e.Graphics.DrawString(txtName, e.Font, System.Drawing.Brushes.Red, rect, stringFormat)
                ElseIf pl.Owner.Vacancy Then
                    e.Graphics.DrawString(txtName, e.Font, System.Drawing.Brushes.DeepSkyBlue, rect, stringFormat)
                ElseIf pl.Owner.Noob Then
                    e.Graphics.DrawString(txtName, e.Font, System.Drawing.Brushes.GreenYellow, rect, stringFormat)
                ElseIf pl.Owner.ShortInactive Or pl.Owner.LongInactive Then
                    e.Graphics.DrawString(txtName, e.Font, System.Drawing.Brushes.LightGray, rect, stringFormat)

                Else
                    e.Graphics.DrawString(pl.Owner.Name, e.Font, System.Drawing.Brushes.Yellow, rect, stringFormat)
                End If
            End If


            If pl.SpyingReports.Count > 0 Then e.Graphics.DrawImage(SpyBitmap, e.Bounds.X + e.Bounds.Width - 16, e.Bounds.Y)
            If pl.AttackReports.Count > 0 Then e.Graphics.DrawImage(AttackBitmap, e.Bounds.X + e.Bounds.Width - 32, e.Bounds.Y)

        End If
    End Sub

    Private Sub lbGalaxyPlanets_DoubleClick(ByVal sender As Object, ByVal e As System.EventArgs) Handles lbGalaxyPlanets.DoubleClick
        If lbGalaxyPlanets.SelectedItem Is Nothing Then Return
        If ShowMode = enShowMode.Galaxy Then miGalEditPlayer_Click(Nothing, Nothing)
    End Sub

    Private Sub lbGalaxyPlanets_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbGalaxyPlanets.SelectedIndexChanged
        rtbGalaxyReport.Text = ""
        tbPlanetExtraInfo.Text = "(Pas d'information)"
        labGalaxyRequieredTransport.Text = ""
        rtbGalPlayerNote.Text = ""
        lbGalaxyPlanetSpy.Items.Clear()
        lbGalaxyPlanetAttacks.Items.Clear()
        rtbGalReport2.Text = "No Report"
        lbGalPlayerFlotte2.Text = "Flotte"
        ToolTip1.SetToolTip(lbGalPlayerFlotte2, "Flotte: ??")
        lbGalPlayerPoint2.Text = "Points"
        ToolTip1.SetToolTip(lbGalPlayerPoint2, "Points: ??")
        lbGalPlayerResearch2.Text = "Research"
        ToolTip1.SetToolTip(lbGalPlayerResearch2, "Research: ??")
        lbGalPlayerFlotte.Text = "??"
        miGalImportSpyRep.Enabled = False
        miGalEditPlayer.Enabled = False
        lbGalPlayerPoint.Text = "??"
        lbGalPlayerResearch.Text = "??"

        If lbGalaxyPlanets.SelectedItem Is Nothing Then Return
        If ShowMode = enShowMode.Galaxy OrElse lbGalaxyPlanets.SelectedItem.GetType.Equals(GetType(OGameObject.Planet)) Then
            miGalImportSpyRep.Enabled = True
            miGalEditPlayer.Enabled = True
            Dim pl As OGameObject.Planet = CType(lbGalaxyPlanets.SelectedItem, OGameObject.Planet)
            tbPlanetExtraInfo.Text = pl.DataDate.ToShortDateString & " ( " & pl.DataSender & ")" & "  PM: " & pl.Owner.MainPlanetCoords

            For Each s As OGameObject.SpyReport In pl.SpyingReports(nudSpyLimit.Value)
                s.ToStringType = OGameObject.SpyReport.enToStringType.DescDatePlayerName
                lbGalaxyPlanetSpy.Items.Add(s)
            Next
            For Each a As OGameObject.AttackReport In pl.AttackReports(nudAttackLimit.Value)
                lbGalaxyPlanetAttacks.Items.Add(a)
            Next

            If pl.SpyingReports.Count Then
                lbGalaxyPlanetSpy.SelectedIndex = 0
                rtbGalReport2.Text = pl.SpyingReports.Item(0).RawReport
                Dim sd As New OGameObject.spydata
                sd.FromPlanetDate(pl.ID, pl.SpyingReports.Item(0).DataDate)
                labGalaxyRequieredTransport.Text = "GT: " & Math.Round(((sd.METAL + sd.CRYSTAL + sd.DEUTERIUM) / 2) / 25000)
            ElseIf pl.AttackReports.Count Then
                lbGalaxyPlanetAttacks.SelectedIndex = 0
            End If
            If Not pl.Owner Is Nothing Then
                OgsPlayerStatsGraph1.Visible = True
                OgsPlayerStatsGraph1.Player = pl.Owner
                lbGalPlayerName.Text = pl.Owner.Name
                lbGalPlayerAlly.Text = pl.Owner.Alliance
                rtbGalPlayerNote.Text = pl.Owner.Note
                Dim rk As OGameObject.PlayerRank = pl.Owner.RankPoints
                If Not rk Is Nothing Then
                    lbGalPlayerPoint.Text = rk.Points & " ( " & rk.Rank & " )"
                    lbGalPlayerPoint2.Text = rk.Rank
                    ToolTip1.SetToolTip(lbGalPlayerPoint2, "Points: " & rk.Points & " ( " & rk.Rank & " )")
                End If
                rk = pl.Owner.RankFlotte
                If Not rk Is Nothing Then
                    lbGalPlayerFlotte.Text = rk.Points & " ( " & rk.Rank & " )"
                    lbGalPlayerFlotte2.Text = rk.Rank
                    ToolTip1.SetToolTip(lbGalPlayerFlotte2, "Flotte: " & rk.Points & " ( " & rk.Rank & " )")

                End If
                rk = pl.Owner.RankResearch
                If Not rk Is Nothing Then
                    lbGalPlayerResearch.Text = rk.Points & " ( " & rk.Rank & " )"
                    lbGalPlayerResearch2.Text = rk.Rank
                    ToolTip1.SetToolTip(lbGalPlayerResearch2, "Research: " & rk.Points & " ( " & rk.Rank & " )")

                End If
            Else
                OgsPlayerStatsGraph1.Visible = False
            End If
        Else
            If lbGalaxyPlanets.SelectedItem.GetType.Equals(GetType(OGameObject.Player)) Then

                Dim pla As OGameObject.Player = CType(lbGalaxyPlanets.SelectedItem, OGameObject.Player)
                sbGalaxy.Text = "Known Informations for " & pla.ToString
                tbPlanetExtraInfo.Text = pla.DataDate.ToShortDateString & " ( " & pla.DataSender & ")"
                For Each pl As OGameObject.Planet In pla.Planets
                    pl.ToStringFormat = OGameObject.Planet.enToStringFormat.CoordsName
                    lbGalaxyPlanetAttacks.Items.Add(pl)
                Next
                Dim rk As OGameObject.PlayerRank = OGameObject.PlayerRank.RankPoints(pla)
                If Not rk Is Nothing Then
                    rtbGalaxyReport.AppendText(vbCrLf & "Ranking Points : " & rk.ToString)
                End If
                rk = OGameObject.PlayerRank.RankFlotte(pla)
                If Not rk Is Nothing Then
                    rtbGalaxyReport.AppendText(vbCrLf & "Ranking Flotte : " & rk.ToString)
                End If
                rk = OGameObject.PlayerRank.RankResearch(pla)
                If Not rk Is Nothing Then
                    rtbGalaxyReport.AppendText(vbCrLf & "Research Flotte : " & rk.ToString)
                End If
            End If
        End If

    End Sub

    Private Sub splitGalaxyDownLeftRight_SplitterMoved(ByVal sender As Object, ByVal e As System.Windows.Forms.SplitterEventArgs) Handles splitGalaxyDownLeftRight.SplitterMoved
        lbGalaxyPlanets.Refresh()
    End Sub


    Private Sub panGalaxyPlanetInfo_SizeChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles panGalaxyPlanetInfo.SizeChanged
        lbGalaxyPlanetAttacks.Width = (panGalaxyPlanetInfo.Width - 18) / 2
        lbGalaxyPlanetSpy.Width = lbGalaxyPlanetAttacks.Width
        lbGalaxyPlanetSpy.Left = 10 + lbGalaxyPlanetAttacks.Width
    End Sub

    Private Sub lbGalaxyPlanetSpy_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbGalaxyPlanetSpy.SelectedIndexChanged
        If Not lbGalaxyPlanetSpy.SelectedItem Is Nothing Then
            If lbGalaxyPlanetSpy.SelectedItem.GetType.Equals(GetType(OGameObject.AttackReport)) Then
                rtbGalaxyReport.Text = CType(lbGalaxyPlanetSpy.SelectedItem, OGameObject.AttackReport).RawReport

            ElseIf lbGalaxyPlanetSpy.SelectedItem.GetType.Equals(GetType(OGameObject.SpyReport)) Then
                rtbGalaxyReport.Text = CType(lbGalaxyPlanetSpy.SelectedItem, OGameObject.SpyReport).RawReport

            End If
        Else
            rtbGalaxyReport.Text = ""
        End If

    End Sub

    Private Sub lbGalaxyPlanetAttacks_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbGalaxyPlanetAttacks.SelectedIndexChanged
        If Not lbGalaxyPlanetAttacks.SelectedItem Is Nothing Then
            If lbGalaxyPlanetAttacks.SelectedItem.GetType.Equals(GetType(OGameObject.AttackReport)) Then
                rtbGalaxyReport.Text = CType(lbGalaxyPlanetAttacks.SelectedItem, OGameObject.AttackReport).RawReport
            ElseIf lbGalaxyPlanetAttacks.SelectedItem.GetType.Equals(GetType(OGameObject.Planet)) Then

                lbGalaxyPlanetSpy.Items.Clear()
                Dim pl As OGameObject.Planet = CType(lbGalaxyPlanetAttacks.SelectedItem, OGameObject.Planet)
                'pl.ToStringFormat=
                For Each a As OGameObject.AttackReport In pl.AttackReports
                    lbGalaxyPlanetSpy.Items.Add(a)
                Next
                For Each s As OGameObject.SpyReport In pl.SpyingReports
                    lbGalaxyPlanetSpy.Items.Add(s)
                Next
                rtbGalaxyReport.Text = "Planet: " & vbTab & pl.ToString
                rtbGalaxyReport.AppendText(vbCrLf & "Owner: " & vbTab & pl.Owner.ToString)
                rtbGalaxyReport.AppendText(vbCrLf & "Known Spying reports : " & pl.SpyingReports.Count)
                rtbGalaxyReport.AppendText(vbCrLf & "Known Attack reports : " & pl.AttackReports.Count)
            End If
        Else
            rtbGalaxyReport.Text = ""
        End If
    End Sub

    Private Sub nudGalaxy_KeyPress(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyPressEventArgs) Handles nudGalaxy.KeyPress, nudSystem.KeyPress
        If e.KeyChar = Chr(&H20) Then e.Handled = True
    End Sub
    Private Sub rtbGalReport2_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rtbGalReport2.TextChanged

        ColorSpyingReport(rtbGalReport2)
    End Sub

    Private Sub btnGalSearch_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnGalSearch.Click
        ShowMode = enShowMode.SearchResults
    End Sub


    Private Sub cbGalSearch_Validated(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbGalSearch.Validated
        ShowMode = enShowMode.Galaxy
        ShowMode = enShowMode.SearchResults
        If cbGalSearch.Items.IndexOf(cbGalSearch.Text) < 0 Then
            cbGalSearch.Items.Insert(0, cbGalSearch.Text)
        End If

    End Sub
    Private Sub WaitCursor()
        Me.Cursor = System.Windows.Forms.Cursors.WaitCursor


    End Sub
    Private Shadows Sub DefaultCursor()
        Me.Cursor = System.Windows.Forms.Cursors.Default
    End Sub

    Private Sub cbGalSearch_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles cbGalSearch.KeyDown
        If cbGalSearch.Text <> "" AndAlso cbGalSearch.Text <> "Search" And e.KeyCode = Keys.Return Then
            e.Handled = True
            ShowMode = enShowMode.SearchResults
        End If
    End Sub

    Private Sub labGalaxySystemTitle_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles labGalaxySystemTitle.Click, labGalaxyNum.Click, labSystemNum.Click
        If ShowMode = enShowMode.Galaxy Then
            ShowMode = enShowMode.SearchResults
        Else
            ShowMode = enShowMode.Galaxy
        End If
    End Sub


#End Region

#Region " OGame Database Events "
    Private Sub pOgameDB_ImportedLines(ByVal sender As Object, ByVal lines As Integer) Handles pOgameDB.ImportedLines
        RaiseEvent ImportedLines(Me, lines)
    End Sub

    Private Sub pOgameDB_ImportedResult(ByVal sender As Object, ByVal PlanetUpdated As Integer, ByVal PlanetAdded As Integer, ByVal PlayerUpdated As Integer, ByVal PlayerAdded As Integer) Handles pOgameDB.ImportedResult
        RaiseEvent ImportedResult(Me, PlanetUpdated, PlanetAdded, PlayerUpdated, PlayerAdded)
    End Sub

    Private Sub pOgameDB_ImportedSystem(ByVal sender As Object, ByVal SystemCoords As String) Handles pOgameDB.ImportedSystem
        RaiseEvent ImportedSystem(Me, SystemCoords)
    End Sub

#End Region


#Region "Global Behaviours "
    Private Sub btnGoToOGSHomeSite_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnGoToOGSHomeSite.Click
        System.Diagnostics.Process.Start("http://www.ogsteam.fr")
    End Sub
#End Region
    Public Sub ModeScan()
        MainForm.ActiveForm.WindowState = FormWindowState.Normal
        Me.ParentForm.Focus()
        Me.Tag = "scanmode"

        MainForm.ActiveForm.Width = lbGalaxyPlanets.Width + 25
        MainForm.ActiveForm.Left = 0
        'MainForm.ActiveForm.TopMost = True
        TabControl1.SelectedTab = tpGalaxy
        MainForm.ActiveForm.Show()

    End Sub
    Public Sub ModeNormal()
        MainForm.ActiveForm.WindowState = FormWindowState.Normal
        Me.ParentForm.Focus()
        Me.Tag = ""
        With MainForm.TopForm.Config
            MainForm.ActiveForm.Left = .WindowsLeft
            MainForm.ActiveForm.Top = .WindowsTop
            MainForm.ActiveForm.Width = .WindowsWidth
            'MainForm.ActiveForm.TopMost = .AlwaysOnTop
            MainForm.ActiveForm.Show()
        End With
    End Sub
    Public Sub ModeMap()
        MainForm.ActiveForm.WindowState = FormWindowState.Normal
        Me.ParentForm.Focus()
        ModeNormal()
        Me.Tag = "mapmode"
        MainForm.ActiveForm.TopMost = False
        TabControl1.SelectedTab = tpMap
        MainForm.ActiveForm.Show()
    End Sub
    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnChangeView.Click
        If Me.Tag = "scanmode" Then
            Me.Tag = ""
            With MainForm.TopForm.Config
                MainForm.ActiveForm.Left = .WindowsLeft
                MainForm.ActiveForm.Top = .WindowsTop

                MainForm.ActiveForm.Width = .WindowsWidth
            End With
        Else
            ModeScan()
        End If
    End Sub
    ''' <summary>
    ''' Lancement de l'edition de joueur lorsque demandé a partir du menu
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub miGalEditPlayer_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles miGalEditPlayer.Click
        Dim PlayerWin As New PlayerFrm
        PlayerWin.Player = CType(lbGalaxyPlanets.SelectedItem, OGameObject.Planet).Owner
        PlayerWin.ShowDialog()
        PlayerWin = Nothing
    End Sub
    ''' <summary>
    '''  Declenchement/relance d'evenement  "informations"
    ''' </summary>
    ''' <param name="message">Le message</param>
    ''' <param name="EventInfo">Le type d'information</param>
    ''' <remarks></remarks>
    Private Sub pOgameDB_EventInformation(ByVal message As String, ByVal EventInfo As OGameObject.enOGSEventType) Handles pOgameDB.EventInformation
        RaiseEvent MessageEvent(message, EventInfo)
    End Sub

    ''' <summary>
    ''' Interception des commandes claviers sur la listbox galaxy
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub lbGalaxyPlanets_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles lbGalaxyPlanets.KeyDown
        Select Case e.KeyCode
            Case Keys.Right
                If nudSystem.Value < 499 Then
                    nudSystem.Value += 1
                End If
            Case Keys.Left
                If nudSystem.Value > 1 Then
                    nudSystem.Value -= 1
                End If
            Case Keys.C
                If e.Control Then
                    Clipboard.SetDataObject(rtbGalReport2.Text, True)
                End If
            Case Keys.Space, Keys.Oemplus
            Case Keys.OemMinus
            Case Keys.Enter, Keys.Return
                TabControl1.SelectedTab = tpReports
                Try
                    e.Handled = True
                    PlayerAllianceSubPanel1.SearchSelectPlayer(CType(lbGalaxyPlanets.SelectedItem, OGameObject.Planet).Owner.Name)
                Catch ex As Exception

                End Try

        End Select
    End Sub
    ''' <summary>
    ''' Appellé lors d'une demande de passage en mode scan (OGS reduit sur la gauche de l'ecran)
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <remarks></remarks>
    Private Sub Map1_ScanModeRequest(ByVal sender As Object) Handles Map1.ScanModeRequest
        ModeScan()
    End Sub

    Private Sub Map1_PlanetInfoRequest(ByVal sender As Object, ByVal planet As OGameObject.Planet) Handles Map1.PlanetInfoRequest
        PlayerAllianceSubPanel1.SelectPlanet(planet)
        TabControl1.SelectedTab = tpReports
        Application.DoEvents()
        tcReports.SelectedTab = tpAlliancePlayer
        Application.DoEvents()
    End Sub
    Public Event QueryCheckForUpdate()
    Private Sub btnCheckUpdate_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnCheckUpdate.Click
        RaiseEvent QueryCheckForUpdate()
    End Sub

    ''' <summary>
    ''' Action pour selection d'un systeme dans l'onglet cartographie
    ''' </summary>
    ''' <param name="Sender"></param>
    ''' <param name="Galaxy"></param>
    ''' <remarks></remarks>
    Private Sub Map1_SystemSelected(ByVal Sender As Object, ByVal Galaxy As OGameObject.Galaxy) Handles Map1.SystemSelected
        SetGalaxyView(Galaxy.Galaxy, Galaxy.System)
    End Sub
End Class
