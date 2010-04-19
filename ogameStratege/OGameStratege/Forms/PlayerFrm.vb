Public Class PlayerFrm
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
    Friend WithEvents TabControl1 As System.Windows.Forms.TabControl
    Friend WithEvents tpPlayerInfo As System.Windows.Forms.TabPage
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents Panel3 As System.Windows.Forms.Panel
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents tbID As System.Windows.Forms.TextBox
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents tbname As System.Windows.Forms.TextBox
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents tbAlly As System.Windows.Forms.TextBox
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents TabControl2 As System.Windows.Forms.TabControl
    Friend WithEvents tpNotes As System.Windows.Forms.TabPage
    Friend WithEvents chkShortInactive As System.Windows.Forms.CheckBox
    Friend WithEvents chkLongInactive As System.Windows.Forms.CheckBox
    Friend WithEvents chkVacation As System.Windows.Forms.CheckBox
    Friend WithEvents chkNoob As System.Windows.Forms.CheckBox
    Friend WithEvents tbMainPlanet As System.Windows.Forms.TextBox
    Friend WithEvents tbNote As System.Windows.Forms.TextBox
    Friend WithEvents btnSave As System.Windows.Forms.Button
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents btnCancel As System.Windows.Forms.Button
    Friend WithEvents tpStats As System.Windows.Forms.TabPage
    Friend WithEvents Panel4 As System.Windows.Forms.Panel
    Friend WithEvents dgStatistics As System.Windows.Forms.DataGrid
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents tpPlanets As System.Windows.Forms.TabPage
    Friend WithEvents Panel5 As System.Windows.Forms.Panel
    Friend WithEvents chkBlocked As System.Windows.Forms.CheckBox
    Friend WithEvents Panel6 As System.Windows.Forms.Panel
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents OgsPlayerStatsGraph1 As OGameStratege.OGSPlayerStatsGraph
    Friend WithEvents tpGraphicStats As System.Windows.Forms.TabPage
    Friend WithEvents btnShowPlanets As System.Windows.Forms.Button
    Friend WithEvents Panel7 As System.Windows.Forms.Panel
    Friend WithEvents panPlanetPlanet As System.Windows.Forms.Panel
    Friend WithEvents lbPlanets As System.Windows.Forms.ListBox
    Friend WithEvents btnPlanetDelete As System.Windows.Forms.Button
    Friend WithEvents panPlanetSpyReport As System.Windows.Forms.Panel
    Friend WithEvents panPlanetSpyReportDown As System.Windows.Forms.Panel
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents lbPlanetSpyReport As System.Windows.Forms.ListBox
    Friend WithEvents Panel8 As System.Windows.Forms.Panel
    Friend WithEvents panPlanetAttackReports As System.Windows.Forms.Panel
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents rtbPlanetReport As System.Windows.Forms.RichTextBox
    Friend WithEvents btnPlanetCopy As System.Windows.Forms.Button
    Friend WithEvents btnSpyCopy As System.Windows.Forms.Button
    Friend WithEvents btnSpyDelete As System.Windows.Forms.Button
    Friend WithEvents btnAttackCopy As System.Windows.Forms.Button
    Friend WithEvents btnAttackDelete As System.Windows.Forms.Button
    Friend WithEvents lbPlanetAttacks As System.Windows.Forms.ListBox
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents tpTransfertData As System.Windows.Forms.TabPage
    Friend WithEvents Panel9 As System.Windows.Forms.Panel
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents Button4 As System.Windows.Forms.Button
    Friend WithEvents LabelBox1 As OGameStratege.LabelBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(PlayerFrm))
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.btnCancel = New System.Windows.Forms.Button
        Me.btnSave = New System.Windows.Forms.Button
        Me.TabControl1 = New System.Windows.Forms.TabControl
        Me.tpPlayerInfo = New System.Windows.Forms.TabPage
        Me.Panel3 = New System.Windows.Forms.Panel
        Me.TabControl2 = New System.Windows.Forms.TabControl
        Me.tpNotes = New System.Windows.Forms.TabPage
        Me.tbNote = New System.Windows.Forms.TextBox
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.chkBlocked = New System.Windows.Forms.CheckBox
        Me.chkNoob = New System.Windows.Forms.CheckBox
        Me.chkVacation = New System.Windows.Forms.CheckBox
        Me.chkLongInactive = New System.Windows.Forms.CheckBox
        Me.chkShortInactive = New System.Windows.Forms.CheckBox
        Me.tbMainPlanet = New System.Windows.Forms.TextBox
        Me.Label4 = New System.Windows.Forms.Label
        Me.tbAlly = New System.Windows.Forms.TextBox
        Me.Label3 = New System.Windows.Forms.Label
        Me.tbname = New System.Windows.Forms.TextBox
        Me.Label2 = New System.Windows.Forms.Label
        Me.tbID = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.tpStats = New System.Windows.Forms.TabPage
        Me.dgStatistics = New System.Windows.Forms.DataGrid
        Me.Panel4 = New System.Windows.Forms.Panel
        Me.Button1 = New System.Windows.Forms.Button
        Me.tpPlanets = New System.Windows.Forms.TabPage
        Me.rtbPlanetReport = New System.Windows.Forms.RichTextBox
        Me.Panel8 = New System.Windows.Forms.Panel
        Me.lbPlanetAttacks = New System.Windows.Forms.ListBox
        Me.Label6 = New System.Windows.Forms.Label
        Me.panPlanetAttackReports = New System.Windows.Forms.Panel
        Me.btnAttackCopy = New System.Windows.Forms.Button
        Me.btnAttackDelete = New System.Windows.Forms.Button
        Me.panPlanetSpyReport = New System.Windows.Forms.Panel
        Me.lbPlanetSpyReport = New System.Windows.Forms.ListBox
        Me.Label5 = New System.Windows.Forms.Label
        Me.panPlanetSpyReportDown = New System.Windows.Forms.Panel
        Me.btnSpyCopy = New System.Windows.Forms.Button
        Me.btnSpyDelete = New System.Windows.Forms.Button
        Me.Panel7 = New System.Windows.Forms.Panel
        Me.lbPlanets = New System.Windows.Forms.ListBox
        Me.panPlanetPlanet = New System.Windows.Forms.Panel
        Me.btnPlanetCopy = New System.Windows.Forms.Button
        Me.btnPlanetDelete = New System.Windows.Forms.Button
        Me.Panel5 = New System.Windows.Forms.Panel
        Me.btnShowPlanets = New System.Windows.Forms.Button
        Me.tpGraphicStats = New System.Windows.Forms.TabPage
        Me.OgsPlayerStatsGraph1 = New OGameStratege.OGSPlayerStatsGraph
        Me.Panel6 = New System.Windows.Forms.Panel
        Me.Button2 = New System.Windows.Forms.Button
        Me.Button3 = New System.Windows.Forms.Button
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.tpTransfertData = New System.Windows.Forms.TabPage
        Me.Panel9 = New System.Windows.Forms.Panel
        Me.Label7 = New System.Windows.Forms.Label
        Me.Button4 = New System.Windows.Forms.Button
        Me.LabelBox1 = New OGameStratege.LabelBox
        Me.Panel1.SuspendLayout()
        Me.TabControl1.SuspendLayout()
        Me.tpPlayerInfo.SuspendLayout()
        Me.Panel3.SuspendLayout()
        Me.TabControl2.SuspendLayout()
        Me.tpNotes.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.tpStats.SuspendLayout()
        CType(Me.dgStatistics, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel4.SuspendLayout()
        Me.tpPlanets.SuspendLayout()
        Me.Panel8.SuspendLayout()
        Me.panPlanetAttackReports.SuspendLayout()
        Me.panPlanetSpyReport.SuspendLayout()
        Me.panPlanetSpyReportDown.SuspendLayout()
        Me.Panel7.SuspendLayout()
        Me.panPlanetPlanet.SuspendLayout()
        Me.Panel5.SuspendLayout()
        Me.tpGraphicStats.SuspendLayout()
        Me.Panel6.SuspendLayout()
        Me.tpTransfertData.SuspendLayout()
        Me.Panel9.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.AccessibleDescription = resources.GetString("Panel1.AccessibleDescription")
        Me.Panel1.AccessibleName = resources.GetString("Panel1.AccessibleName")
        Me.Panel1.Anchor = CType(resources.GetObject("Panel1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel1.AutoScroll = CType(resources.GetObject("Panel1.AutoScroll"), Boolean)
        Me.Panel1.AutoScrollMargin = CType(resources.GetObject("Panel1.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel1.AutoScrollMinSize = CType(resources.GetObject("Panel1.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel1.BackgroundImage = CType(resources.GetObject("Panel1.BackgroundImage"), System.Drawing.Image)
        Me.Panel1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Panel1.Controls.Add(Me.btnCancel)
        Me.Panel1.Controls.Add(Me.btnSave)
        Me.Panel1.Dock = CType(resources.GetObject("Panel1.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel1.DockPadding.All = 3
        Me.Panel1.Enabled = CType(resources.GetObject("Panel1.Enabled"), Boolean)
        Me.Panel1.Font = CType(resources.GetObject("Panel1.Font"), System.Drawing.Font)
        Me.Panel1.ImeMode = CType(resources.GetObject("Panel1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel1.Location = CType(resources.GetObject("Panel1.Location"), System.Drawing.Point)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.RightToLeft = CType(resources.GetObject("Panel1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel1.Size = CType(resources.GetObject("Panel1.Size"), System.Drawing.Size)
        Me.Panel1.TabIndex = CType(resources.GetObject("Panel1.TabIndex"), Integer)
        Me.Panel1.Text = resources.GetString("Panel1.Text")
        Me.ToolTip1.SetToolTip(Me.Panel1, resources.GetString("Panel1.ToolTip"))
        Me.Panel1.Visible = CType(resources.GetObject("Panel1.Visible"), Boolean)
        '
        'btnCancel
        '
        Me.btnCancel.AccessibleDescription = resources.GetString("btnCancel.AccessibleDescription")
        Me.btnCancel.AccessibleName = resources.GetString("btnCancel.AccessibleName")
        Me.btnCancel.Anchor = CType(resources.GetObject("btnCancel.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnCancel.BackgroundImage = CType(resources.GetObject("btnCancel.BackgroundImage"), System.Drawing.Image)
        Me.btnCancel.DialogResult = System.Windows.Forms.DialogResult.Cancel
        Me.btnCancel.Dock = CType(resources.GetObject("btnCancel.Dock"), System.Windows.Forms.DockStyle)
        Me.btnCancel.Enabled = CType(resources.GetObject("btnCancel.Enabled"), Boolean)
        Me.btnCancel.FlatStyle = CType(resources.GetObject("btnCancel.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnCancel.Font = CType(resources.GetObject("btnCancel.Font"), System.Drawing.Font)
        Me.btnCancel.Image = CType(resources.GetObject("btnCancel.Image"), System.Drawing.Image)
        Me.btnCancel.ImageAlign = CType(resources.GetObject("btnCancel.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnCancel.ImageIndex = CType(resources.GetObject("btnCancel.ImageIndex"), Integer)
        Me.btnCancel.ImeMode = CType(resources.GetObject("btnCancel.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnCancel.Location = CType(resources.GetObject("btnCancel.Location"), System.Drawing.Point)
        Me.btnCancel.Name = "btnCancel"
        Me.btnCancel.RightToLeft = CType(resources.GetObject("btnCancel.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnCancel.Size = CType(resources.GetObject("btnCancel.Size"), System.Drawing.Size)
        Me.btnCancel.TabIndex = CType(resources.GetObject("btnCancel.TabIndex"), Integer)
        Me.btnCancel.Text = resources.GetString("btnCancel.Text")
        Me.btnCancel.TextAlign = CType(resources.GetObject("btnCancel.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnCancel, resources.GetString("btnCancel.ToolTip"))
        Me.btnCancel.Visible = CType(resources.GetObject("btnCancel.Visible"), Boolean)
        '
        'btnSave
        '
        Me.btnSave.AccessibleDescription = resources.GetString("btnSave.AccessibleDescription")
        Me.btnSave.AccessibleName = resources.GetString("btnSave.AccessibleName")
        Me.btnSave.Anchor = CType(resources.GetObject("btnSave.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnSave.BackgroundImage = CType(resources.GetObject("btnSave.BackgroundImage"), System.Drawing.Image)
        Me.btnSave.Dock = CType(resources.GetObject("btnSave.Dock"), System.Windows.Forms.DockStyle)
        Me.btnSave.Enabled = CType(resources.GetObject("btnSave.Enabled"), Boolean)
        Me.btnSave.FlatStyle = CType(resources.GetObject("btnSave.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnSave.Font = CType(resources.GetObject("btnSave.Font"), System.Drawing.Font)
        Me.btnSave.Image = CType(resources.GetObject("btnSave.Image"), System.Drawing.Image)
        Me.btnSave.ImageAlign = CType(resources.GetObject("btnSave.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnSave.ImageIndex = CType(resources.GetObject("btnSave.ImageIndex"), Integer)
        Me.btnSave.ImeMode = CType(resources.GetObject("btnSave.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnSave.Location = CType(resources.GetObject("btnSave.Location"), System.Drawing.Point)
        Me.btnSave.Name = "btnSave"
        Me.btnSave.RightToLeft = CType(resources.GetObject("btnSave.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnSave.Size = CType(resources.GetObject("btnSave.Size"), System.Drawing.Size)
        Me.btnSave.TabIndex = CType(resources.GetObject("btnSave.TabIndex"), Integer)
        Me.btnSave.Text = resources.GetString("btnSave.Text")
        Me.btnSave.TextAlign = CType(resources.GetObject("btnSave.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnSave, resources.GetString("btnSave.ToolTip"))
        Me.btnSave.Visible = CType(resources.GetObject("btnSave.Visible"), Boolean)
        '
        'TabControl1
        '
        Me.TabControl1.AccessibleDescription = resources.GetString("TabControl1.AccessibleDescription")
        Me.TabControl1.AccessibleName = resources.GetString("TabControl1.AccessibleName")
        Me.TabControl1.Alignment = CType(resources.GetObject("TabControl1.Alignment"), System.Windows.Forms.TabAlignment)
        Me.TabControl1.Anchor = CType(resources.GetObject("TabControl1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.TabControl1.Appearance = CType(resources.GetObject("TabControl1.Appearance"), System.Windows.Forms.TabAppearance)
        Me.TabControl1.BackgroundImage = CType(resources.GetObject("TabControl1.BackgroundImage"), System.Drawing.Image)
        Me.TabControl1.Controls.Add(Me.tpPlayerInfo)
        Me.TabControl1.Controls.Add(Me.tpStats)
        Me.TabControl1.Controls.Add(Me.tpPlanets)
        Me.TabControl1.Controls.Add(Me.tpGraphicStats)
        Me.TabControl1.Controls.Add(Me.tpTransfertData)
        Me.TabControl1.Dock = CType(resources.GetObject("TabControl1.Dock"), System.Windows.Forms.DockStyle)
        Me.TabControl1.Enabled = CType(resources.GetObject("TabControl1.Enabled"), Boolean)
        Me.TabControl1.Font = CType(resources.GetObject("TabControl1.Font"), System.Drawing.Font)
        Me.TabControl1.ImeMode = CType(resources.GetObject("TabControl1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.TabControl1.ItemSize = CType(resources.GetObject("TabControl1.ItemSize"), System.Drawing.Size)
        Me.TabControl1.Location = CType(resources.GetObject("TabControl1.Location"), System.Drawing.Point)
        Me.TabControl1.Name = "TabControl1"
        Me.TabControl1.Padding = CType(resources.GetObject("TabControl1.Padding"), System.Drawing.Point)
        Me.TabControl1.RightToLeft = CType(resources.GetObject("TabControl1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.TabControl1.SelectedIndex = 0
        Me.TabControl1.ShowToolTips = CType(resources.GetObject("TabControl1.ShowToolTips"), Boolean)
        Me.TabControl1.Size = CType(resources.GetObject("TabControl1.Size"), System.Drawing.Size)
        Me.TabControl1.TabIndex = CType(resources.GetObject("TabControl1.TabIndex"), Integer)
        Me.TabControl1.Text = resources.GetString("TabControl1.Text")
        Me.ToolTip1.SetToolTip(Me.TabControl1, resources.GetString("TabControl1.ToolTip"))
        Me.TabControl1.Visible = CType(resources.GetObject("TabControl1.Visible"), Boolean)
        '
        'tpPlayerInfo
        '
        Me.tpPlayerInfo.AccessibleDescription = resources.GetString("tpPlayerInfo.AccessibleDescription")
        Me.tpPlayerInfo.AccessibleName = resources.GetString("tpPlayerInfo.AccessibleName")
        Me.tpPlayerInfo.Anchor = CType(resources.GetObject("tpPlayerInfo.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tpPlayerInfo.AutoScroll = CType(resources.GetObject("tpPlayerInfo.AutoScroll"), Boolean)
        Me.tpPlayerInfo.AutoScrollMargin = CType(resources.GetObject("tpPlayerInfo.AutoScrollMargin"), System.Drawing.Size)
        Me.tpPlayerInfo.AutoScrollMinSize = CType(resources.GetObject("tpPlayerInfo.AutoScrollMinSize"), System.Drawing.Size)
        Me.tpPlayerInfo.BackgroundImage = CType(resources.GetObject("tpPlayerInfo.BackgroundImage"), System.Drawing.Image)
        Me.tpPlayerInfo.Controls.Add(Me.Panel3)
        Me.tpPlayerInfo.Controls.Add(Me.Splitter1)
        Me.tpPlayerInfo.Controls.Add(Me.Panel2)
        Me.tpPlayerInfo.Dock = CType(resources.GetObject("tpPlayerInfo.Dock"), System.Windows.Forms.DockStyle)
        Me.tpPlayerInfo.Enabled = CType(resources.GetObject("tpPlayerInfo.Enabled"), Boolean)
        Me.tpPlayerInfo.Font = CType(resources.GetObject("tpPlayerInfo.Font"), System.Drawing.Font)
        Me.tpPlayerInfo.ImageIndex = CType(resources.GetObject("tpPlayerInfo.ImageIndex"), Integer)
        Me.tpPlayerInfo.ImeMode = CType(resources.GetObject("tpPlayerInfo.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tpPlayerInfo.Location = CType(resources.GetObject("tpPlayerInfo.Location"), System.Drawing.Point)
        Me.tpPlayerInfo.Name = "tpPlayerInfo"
        Me.tpPlayerInfo.RightToLeft = CType(resources.GetObject("tpPlayerInfo.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tpPlayerInfo.Size = CType(resources.GetObject("tpPlayerInfo.Size"), System.Drawing.Size)
        Me.tpPlayerInfo.TabIndex = CType(resources.GetObject("tpPlayerInfo.TabIndex"), Integer)
        Me.tpPlayerInfo.Text = resources.GetString("tpPlayerInfo.Text")
        Me.ToolTip1.SetToolTip(Me.tpPlayerInfo, resources.GetString("tpPlayerInfo.ToolTip"))
        Me.tpPlayerInfo.ToolTipText = resources.GetString("tpPlayerInfo.ToolTipText")
        Me.tpPlayerInfo.Visible = CType(resources.GetObject("tpPlayerInfo.Visible"), Boolean)
        '
        'Panel3
        '
        Me.Panel3.AccessibleDescription = resources.GetString("Panel3.AccessibleDescription")
        Me.Panel3.AccessibleName = resources.GetString("Panel3.AccessibleName")
        Me.Panel3.Anchor = CType(resources.GetObject("Panel3.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel3.AutoScroll = CType(resources.GetObject("Panel3.AutoScroll"), Boolean)
        Me.Panel3.AutoScrollMargin = CType(resources.GetObject("Panel3.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel3.AutoScrollMinSize = CType(resources.GetObject("Panel3.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel3.BackgroundImage = CType(resources.GetObject("Panel3.BackgroundImage"), System.Drawing.Image)
        Me.Panel3.Controls.Add(Me.TabControl2)
        Me.Panel3.Dock = CType(resources.GetObject("Panel3.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel3.Enabled = CType(resources.GetObject("Panel3.Enabled"), Boolean)
        Me.Panel3.Font = CType(resources.GetObject("Panel3.Font"), System.Drawing.Font)
        Me.Panel3.ImeMode = CType(resources.GetObject("Panel3.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel3.Location = CType(resources.GetObject("Panel3.Location"), System.Drawing.Point)
        Me.Panel3.Name = "Panel3"
        Me.Panel3.RightToLeft = CType(resources.GetObject("Panel3.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel3.Size = CType(resources.GetObject("Panel3.Size"), System.Drawing.Size)
        Me.Panel3.TabIndex = CType(resources.GetObject("Panel3.TabIndex"), Integer)
        Me.Panel3.Text = resources.GetString("Panel3.Text")
        Me.ToolTip1.SetToolTip(Me.Panel3, resources.GetString("Panel3.ToolTip"))
        Me.Panel3.Visible = CType(resources.GetObject("Panel3.Visible"), Boolean)
        '
        'TabControl2
        '
        Me.TabControl2.AccessibleDescription = resources.GetString("TabControl2.AccessibleDescription")
        Me.TabControl2.AccessibleName = resources.GetString("TabControl2.AccessibleName")
        Me.TabControl2.Alignment = CType(resources.GetObject("TabControl2.Alignment"), System.Windows.Forms.TabAlignment)
        Me.TabControl2.Anchor = CType(resources.GetObject("TabControl2.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.TabControl2.Appearance = CType(resources.GetObject("TabControl2.Appearance"), System.Windows.Forms.TabAppearance)
        Me.TabControl2.BackgroundImage = CType(resources.GetObject("TabControl2.BackgroundImage"), System.Drawing.Image)
        Me.TabControl2.Controls.Add(Me.tpNotes)
        Me.TabControl2.Dock = CType(resources.GetObject("TabControl2.Dock"), System.Windows.Forms.DockStyle)
        Me.TabControl2.Enabled = CType(resources.GetObject("TabControl2.Enabled"), Boolean)
        Me.TabControl2.Font = CType(resources.GetObject("TabControl2.Font"), System.Drawing.Font)
        Me.TabControl2.ImeMode = CType(resources.GetObject("TabControl2.ImeMode"), System.Windows.Forms.ImeMode)
        Me.TabControl2.ItemSize = CType(resources.GetObject("TabControl2.ItemSize"), System.Drawing.Size)
        Me.TabControl2.Location = CType(resources.GetObject("TabControl2.Location"), System.Drawing.Point)
        Me.TabControl2.Name = "TabControl2"
        Me.TabControl2.Padding = CType(resources.GetObject("TabControl2.Padding"), System.Drawing.Point)
        Me.TabControl2.RightToLeft = CType(resources.GetObject("TabControl2.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.TabControl2.SelectedIndex = 0
        Me.TabControl2.ShowToolTips = CType(resources.GetObject("TabControl2.ShowToolTips"), Boolean)
        Me.TabControl2.Size = CType(resources.GetObject("TabControl2.Size"), System.Drawing.Size)
        Me.TabControl2.TabIndex = CType(resources.GetObject("TabControl2.TabIndex"), Integer)
        Me.TabControl2.Text = resources.GetString("TabControl2.Text")
        Me.ToolTip1.SetToolTip(Me.TabControl2, resources.GetString("TabControl2.ToolTip"))
        Me.TabControl2.Visible = CType(resources.GetObject("TabControl2.Visible"), Boolean)
        '
        'tpNotes
        '
        Me.tpNotes.AccessibleDescription = resources.GetString("tpNotes.AccessibleDescription")
        Me.tpNotes.AccessibleName = resources.GetString("tpNotes.AccessibleName")
        Me.tpNotes.Anchor = CType(resources.GetObject("tpNotes.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tpNotes.AutoScroll = CType(resources.GetObject("tpNotes.AutoScroll"), Boolean)
        Me.tpNotes.AutoScrollMargin = CType(resources.GetObject("tpNotes.AutoScrollMargin"), System.Drawing.Size)
        Me.tpNotes.AutoScrollMinSize = CType(resources.GetObject("tpNotes.AutoScrollMinSize"), System.Drawing.Size)
        Me.tpNotes.BackgroundImage = CType(resources.GetObject("tpNotes.BackgroundImage"), System.Drawing.Image)
        Me.tpNotes.Controls.Add(Me.tbNote)
        Me.tpNotes.Dock = CType(resources.GetObject("tpNotes.Dock"), System.Windows.Forms.DockStyle)
        Me.tpNotes.Enabled = CType(resources.GetObject("tpNotes.Enabled"), Boolean)
        Me.tpNotes.Font = CType(resources.GetObject("tpNotes.Font"), System.Drawing.Font)
        Me.tpNotes.ImageIndex = CType(resources.GetObject("tpNotes.ImageIndex"), Integer)
        Me.tpNotes.ImeMode = CType(resources.GetObject("tpNotes.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tpNotes.Location = CType(resources.GetObject("tpNotes.Location"), System.Drawing.Point)
        Me.tpNotes.Name = "tpNotes"
        Me.tpNotes.RightToLeft = CType(resources.GetObject("tpNotes.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tpNotes.Size = CType(resources.GetObject("tpNotes.Size"), System.Drawing.Size)
        Me.tpNotes.TabIndex = CType(resources.GetObject("tpNotes.TabIndex"), Integer)
        Me.tpNotes.Text = resources.GetString("tpNotes.Text")
        Me.ToolTip1.SetToolTip(Me.tpNotes, resources.GetString("tpNotes.ToolTip"))
        Me.tpNotes.ToolTipText = resources.GetString("tpNotes.ToolTipText")
        Me.tpNotes.Visible = CType(resources.GetObject("tpNotes.Visible"), Boolean)
        '
        'tbNote
        '
        Me.tbNote.AccessibleDescription = resources.GetString("tbNote.AccessibleDescription")
        Me.tbNote.AccessibleName = resources.GetString("tbNote.AccessibleName")
        Me.tbNote.Anchor = CType(resources.GetObject("tbNote.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbNote.AutoSize = CType(resources.GetObject("tbNote.AutoSize"), Boolean)
        Me.tbNote.BackgroundImage = CType(resources.GetObject("tbNote.BackgroundImage"), System.Drawing.Image)
        Me.tbNote.Dock = CType(resources.GetObject("tbNote.Dock"), System.Windows.Forms.DockStyle)
        Me.tbNote.Enabled = CType(resources.GetObject("tbNote.Enabled"), Boolean)
        Me.tbNote.Font = CType(resources.GetObject("tbNote.Font"), System.Drawing.Font)
        Me.tbNote.ImeMode = CType(resources.GetObject("tbNote.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbNote.Location = CType(resources.GetObject("tbNote.Location"), System.Drawing.Point)
        Me.tbNote.MaxLength = CType(resources.GetObject("tbNote.MaxLength"), Integer)
        Me.tbNote.Multiline = CType(resources.GetObject("tbNote.Multiline"), Boolean)
        Me.tbNote.Name = "tbNote"
        Me.tbNote.PasswordChar = CType(resources.GetObject("tbNote.PasswordChar"), Char)
        Me.tbNote.RightToLeft = CType(resources.GetObject("tbNote.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbNote.ScrollBars = CType(resources.GetObject("tbNote.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbNote.Size = CType(resources.GetObject("tbNote.Size"), System.Drawing.Size)
        Me.tbNote.TabIndex = CType(resources.GetObject("tbNote.TabIndex"), Integer)
        Me.tbNote.Text = resources.GetString("tbNote.Text")
        Me.tbNote.TextAlign = CType(resources.GetObject("tbNote.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbNote, resources.GetString("tbNote.ToolTip"))
        Me.tbNote.Visible = CType(resources.GetObject("tbNote.Visible"), Boolean)
        Me.tbNote.WordWrap = CType(resources.GetObject("tbNote.WordWrap"), Boolean)
        '
        'Splitter1
        '
        Me.Splitter1.AccessibleDescription = resources.GetString("Splitter1.AccessibleDescription")
        Me.Splitter1.AccessibleName = resources.GetString("Splitter1.AccessibleName")
        Me.Splitter1.Anchor = CType(resources.GetObject("Splitter1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Splitter1.BackColor = System.Drawing.SystemColors.Highlight
        Me.Splitter1.BackgroundImage = CType(resources.GetObject("Splitter1.BackgroundImage"), System.Drawing.Image)
        Me.Splitter1.Dock = CType(resources.GetObject("Splitter1.Dock"), System.Windows.Forms.DockStyle)
        Me.Splitter1.Enabled = CType(resources.GetObject("Splitter1.Enabled"), Boolean)
        Me.Splitter1.Font = CType(resources.GetObject("Splitter1.Font"), System.Drawing.Font)
        Me.Splitter1.ImeMode = CType(resources.GetObject("Splitter1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Splitter1.Location = CType(resources.GetObject("Splitter1.Location"), System.Drawing.Point)
        Me.Splitter1.MinExtra = CType(resources.GetObject("Splitter1.MinExtra"), Integer)
        Me.Splitter1.MinSize = CType(resources.GetObject("Splitter1.MinSize"), Integer)
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.RightToLeft = CType(resources.GetObject("Splitter1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Splitter1.Size = CType(resources.GetObject("Splitter1.Size"), System.Drawing.Size)
        Me.Splitter1.TabIndex = CType(resources.GetObject("Splitter1.TabIndex"), Integer)
        Me.Splitter1.TabStop = False
        Me.ToolTip1.SetToolTip(Me.Splitter1, resources.GetString("Splitter1.ToolTip"))
        Me.Splitter1.Visible = CType(resources.GetObject("Splitter1.Visible"), Boolean)
        '
        'Panel2
        '
        Me.Panel2.AccessibleDescription = resources.GetString("Panel2.AccessibleDescription")
        Me.Panel2.AccessibleName = resources.GetString("Panel2.AccessibleName")
        Me.Panel2.Anchor = CType(resources.GetObject("Panel2.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel2.AutoScroll = CType(resources.GetObject("Panel2.AutoScroll"), Boolean)
        Me.Panel2.AutoScrollMargin = CType(resources.GetObject("Panel2.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel2.AutoScrollMinSize = CType(resources.GetObject("Panel2.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel2.BackgroundImage = CType(resources.GetObject("Panel2.BackgroundImage"), System.Drawing.Image)
        Me.Panel2.Controls.Add(Me.chkBlocked)
        Me.Panel2.Controls.Add(Me.chkNoob)
        Me.Panel2.Controls.Add(Me.chkVacation)
        Me.Panel2.Controls.Add(Me.chkLongInactive)
        Me.Panel2.Controls.Add(Me.chkShortInactive)
        Me.Panel2.Controls.Add(Me.tbMainPlanet)
        Me.Panel2.Controls.Add(Me.Label4)
        Me.Panel2.Controls.Add(Me.tbAlly)
        Me.Panel2.Controls.Add(Me.Label3)
        Me.Panel2.Controls.Add(Me.tbname)
        Me.Panel2.Controls.Add(Me.Label2)
        Me.Panel2.Controls.Add(Me.tbID)
        Me.Panel2.Controls.Add(Me.Label1)
        Me.Panel2.Dock = CType(resources.GetObject("Panel2.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel2.Enabled = CType(resources.GetObject("Panel2.Enabled"), Boolean)
        Me.Panel2.Font = CType(resources.GetObject("Panel2.Font"), System.Drawing.Font)
        Me.Panel2.ImeMode = CType(resources.GetObject("Panel2.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel2.Location = CType(resources.GetObject("Panel2.Location"), System.Drawing.Point)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.RightToLeft = CType(resources.GetObject("Panel2.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel2.Size = CType(resources.GetObject("Panel2.Size"), System.Drawing.Size)
        Me.Panel2.TabIndex = CType(resources.GetObject("Panel2.TabIndex"), Integer)
        Me.Panel2.Text = resources.GetString("Panel2.Text")
        Me.ToolTip1.SetToolTip(Me.Panel2, resources.GetString("Panel2.ToolTip"))
        Me.Panel2.Visible = CType(resources.GetObject("Panel2.Visible"), Boolean)
        '
        'chkBlocked
        '
        Me.chkBlocked.AccessibleDescription = resources.GetString("chkBlocked.AccessibleDescription")
        Me.chkBlocked.AccessibleName = resources.GetString("chkBlocked.AccessibleName")
        Me.chkBlocked.Anchor = CType(resources.GetObject("chkBlocked.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.chkBlocked.Appearance = CType(resources.GetObject("chkBlocked.Appearance"), System.Windows.Forms.Appearance)
        Me.chkBlocked.BackgroundImage = CType(resources.GetObject("chkBlocked.BackgroundImage"), System.Drawing.Image)
        Me.chkBlocked.CheckAlign = CType(resources.GetObject("chkBlocked.CheckAlign"), System.Drawing.ContentAlignment)
        Me.chkBlocked.Dock = CType(resources.GetObject("chkBlocked.Dock"), System.Windows.Forms.DockStyle)
        Me.chkBlocked.Enabled = CType(resources.GetObject("chkBlocked.Enabled"), Boolean)
        Me.chkBlocked.FlatStyle = CType(resources.GetObject("chkBlocked.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.chkBlocked.Font = CType(resources.GetObject("chkBlocked.Font"), System.Drawing.Font)
        Me.chkBlocked.Image = CType(resources.GetObject("chkBlocked.Image"), System.Drawing.Image)
        Me.chkBlocked.ImageAlign = CType(resources.GetObject("chkBlocked.ImageAlign"), System.Drawing.ContentAlignment)
        Me.chkBlocked.ImageIndex = CType(resources.GetObject("chkBlocked.ImageIndex"), Integer)
        Me.chkBlocked.ImeMode = CType(resources.GetObject("chkBlocked.ImeMode"), System.Windows.Forms.ImeMode)
        Me.chkBlocked.Location = CType(resources.GetObject("chkBlocked.Location"), System.Drawing.Point)
        Me.chkBlocked.Name = "chkBlocked"
        Me.chkBlocked.RightToLeft = CType(resources.GetObject("chkBlocked.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.chkBlocked.Size = CType(resources.GetObject("chkBlocked.Size"), System.Drawing.Size)
        Me.chkBlocked.TabIndex = CType(resources.GetObject("chkBlocked.TabIndex"), Integer)
        Me.chkBlocked.Text = resources.GetString("chkBlocked.Text")
        Me.chkBlocked.TextAlign = CType(resources.GetObject("chkBlocked.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.chkBlocked, resources.GetString("chkBlocked.ToolTip"))
        Me.chkBlocked.Visible = CType(resources.GetObject("chkBlocked.Visible"), Boolean)
        '
        'chkNoob
        '
        Me.chkNoob.AccessibleDescription = resources.GetString("chkNoob.AccessibleDescription")
        Me.chkNoob.AccessibleName = resources.GetString("chkNoob.AccessibleName")
        Me.chkNoob.Anchor = CType(resources.GetObject("chkNoob.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.chkNoob.Appearance = CType(resources.GetObject("chkNoob.Appearance"), System.Windows.Forms.Appearance)
        Me.chkNoob.BackgroundImage = CType(resources.GetObject("chkNoob.BackgroundImage"), System.Drawing.Image)
        Me.chkNoob.CheckAlign = CType(resources.GetObject("chkNoob.CheckAlign"), System.Drawing.ContentAlignment)
        Me.chkNoob.Dock = CType(resources.GetObject("chkNoob.Dock"), System.Windows.Forms.DockStyle)
        Me.chkNoob.Enabled = CType(resources.GetObject("chkNoob.Enabled"), Boolean)
        Me.chkNoob.FlatStyle = CType(resources.GetObject("chkNoob.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.chkNoob.Font = CType(resources.GetObject("chkNoob.Font"), System.Drawing.Font)
        Me.chkNoob.Image = CType(resources.GetObject("chkNoob.Image"), System.Drawing.Image)
        Me.chkNoob.ImageAlign = CType(resources.GetObject("chkNoob.ImageAlign"), System.Drawing.ContentAlignment)
        Me.chkNoob.ImageIndex = CType(resources.GetObject("chkNoob.ImageIndex"), Integer)
        Me.chkNoob.ImeMode = CType(resources.GetObject("chkNoob.ImeMode"), System.Windows.Forms.ImeMode)
        Me.chkNoob.Location = CType(resources.GetObject("chkNoob.Location"), System.Drawing.Point)
        Me.chkNoob.Name = "chkNoob"
        Me.chkNoob.RightToLeft = CType(resources.GetObject("chkNoob.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.chkNoob.Size = CType(resources.GetObject("chkNoob.Size"), System.Drawing.Size)
        Me.chkNoob.TabIndex = CType(resources.GetObject("chkNoob.TabIndex"), Integer)
        Me.chkNoob.Text = resources.GetString("chkNoob.Text")
        Me.chkNoob.TextAlign = CType(resources.GetObject("chkNoob.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.chkNoob, resources.GetString("chkNoob.ToolTip"))
        Me.chkNoob.Visible = CType(resources.GetObject("chkNoob.Visible"), Boolean)
        '
        'chkVacation
        '
        Me.chkVacation.AccessibleDescription = resources.GetString("chkVacation.AccessibleDescription")
        Me.chkVacation.AccessibleName = resources.GetString("chkVacation.AccessibleName")
        Me.chkVacation.Anchor = CType(resources.GetObject("chkVacation.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.chkVacation.Appearance = CType(resources.GetObject("chkVacation.Appearance"), System.Windows.Forms.Appearance)
        Me.chkVacation.BackgroundImage = CType(resources.GetObject("chkVacation.BackgroundImage"), System.Drawing.Image)
        Me.chkVacation.CheckAlign = CType(resources.GetObject("chkVacation.CheckAlign"), System.Drawing.ContentAlignment)
        Me.chkVacation.Dock = CType(resources.GetObject("chkVacation.Dock"), System.Windows.Forms.DockStyle)
        Me.chkVacation.Enabled = CType(resources.GetObject("chkVacation.Enabled"), Boolean)
        Me.chkVacation.FlatStyle = CType(resources.GetObject("chkVacation.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.chkVacation.Font = CType(resources.GetObject("chkVacation.Font"), System.Drawing.Font)
        Me.chkVacation.Image = CType(resources.GetObject("chkVacation.Image"), System.Drawing.Image)
        Me.chkVacation.ImageAlign = CType(resources.GetObject("chkVacation.ImageAlign"), System.Drawing.ContentAlignment)
        Me.chkVacation.ImageIndex = CType(resources.GetObject("chkVacation.ImageIndex"), Integer)
        Me.chkVacation.ImeMode = CType(resources.GetObject("chkVacation.ImeMode"), System.Windows.Forms.ImeMode)
        Me.chkVacation.Location = CType(resources.GetObject("chkVacation.Location"), System.Drawing.Point)
        Me.chkVacation.Name = "chkVacation"
        Me.chkVacation.RightToLeft = CType(resources.GetObject("chkVacation.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.chkVacation.Size = CType(resources.GetObject("chkVacation.Size"), System.Drawing.Size)
        Me.chkVacation.TabIndex = CType(resources.GetObject("chkVacation.TabIndex"), Integer)
        Me.chkVacation.Text = resources.GetString("chkVacation.Text")
        Me.chkVacation.TextAlign = CType(resources.GetObject("chkVacation.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.chkVacation, resources.GetString("chkVacation.ToolTip"))
        Me.chkVacation.Visible = CType(resources.GetObject("chkVacation.Visible"), Boolean)
        '
        'chkLongInactive
        '
        Me.chkLongInactive.AccessibleDescription = resources.GetString("chkLongInactive.AccessibleDescription")
        Me.chkLongInactive.AccessibleName = resources.GetString("chkLongInactive.AccessibleName")
        Me.chkLongInactive.Anchor = CType(resources.GetObject("chkLongInactive.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.chkLongInactive.Appearance = CType(resources.GetObject("chkLongInactive.Appearance"), System.Windows.Forms.Appearance)
        Me.chkLongInactive.BackgroundImage = CType(resources.GetObject("chkLongInactive.BackgroundImage"), System.Drawing.Image)
        Me.chkLongInactive.CheckAlign = CType(resources.GetObject("chkLongInactive.CheckAlign"), System.Drawing.ContentAlignment)
        Me.chkLongInactive.Dock = CType(resources.GetObject("chkLongInactive.Dock"), System.Windows.Forms.DockStyle)
        Me.chkLongInactive.Enabled = CType(resources.GetObject("chkLongInactive.Enabled"), Boolean)
        Me.chkLongInactive.FlatStyle = CType(resources.GetObject("chkLongInactive.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.chkLongInactive.Font = CType(resources.GetObject("chkLongInactive.Font"), System.Drawing.Font)
        Me.chkLongInactive.Image = CType(resources.GetObject("chkLongInactive.Image"), System.Drawing.Image)
        Me.chkLongInactive.ImageAlign = CType(resources.GetObject("chkLongInactive.ImageAlign"), System.Drawing.ContentAlignment)
        Me.chkLongInactive.ImageIndex = CType(resources.GetObject("chkLongInactive.ImageIndex"), Integer)
        Me.chkLongInactive.ImeMode = CType(resources.GetObject("chkLongInactive.ImeMode"), System.Windows.Forms.ImeMode)
        Me.chkLongInactive.Location = CType(resources.GetObject("chkLongInactive.Location"), System.Drawing.Point)
        Me.chkLongInactive.Name = "chkLongInactive"
        Me.chkLongInactive.RightToLeft = CType(resources.GetObject("chkLongInactive.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.chkLongInactive.Size = CType(resources.GetObject("chkLongInactive.Size"), System.Drawing.Size)
        Me.chkLongInactive.TabIndex = CType(resources.GetObject("chkLongInactive.TabIndex"), Integer)
        Me.chkLongInactive.Text = resources.GetString("chkLongInactive.Text")
        Me.chkLongInactive.TextAlign = CType(resources.GetObject("chkLongInactive.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.chkLongInactive, resources.GetString("chkLongInactive.ToolTip"))
        Me.chkLongInactive.Visible = CType(resources.GetObject("chkLongInactive.Visible"), Boolean)
        '
        'chkShortInactive
        '
        Me.chkShortInactive.AccessibleDescription = resources.GetString("chkShortInactive.AccessibleDescription")
        Me.chkShortInactive.AccessibleName = resources.GetString("chkShortInactive.AccessibleName")
        Me.chkShortInactive.Anchor = CType(resources.GetObject("chkShortInactive.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.chkShortInactive.Appearance = CType(resources.GetObject("chkShortInactive.Appearance"), System.Windows.Forms.Appearance)
        Me.chkShortInactive.BackgroundImage = CType(resources.GetObject("chkShortInactive.BackgroundImage"), System.Drawing.Image)
        Me.chkShortInactive.CheckAlign = CType(resources.GetObject("chkShortInactive.CheckAlign"), System.Drawing.ContentAlignment)
        Me.chkShortInactive.Dock = CType(resources.GetObject("chkShortInactive.Dock"), System.Windows.Forms.DockStyle)
        Me.chkShortInactive.Enabled = CType(resources.GetObject("chkShortInactive.Enabled"), Boolean)
        Me.chkShortInactive.FlatStyle = CType(resources.GetObject("chkShortInactive.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.chkShortInactive.Font = CType(resources.GetObject("chkShortInactive.Font"), System.Drawing.Font)
        Me.chkShortInactive.Image = CType(resources.GetObject("chkShortInactive.Image"), System.Drawing.Image)
        Me.chkShortInactive.ImageAlign = CType(resources.GetObject("chkShortInactive.ImageAlign"), System.Drawing.ContentAlignment)
        Me.chkShortInactive.ImageIndex = CType(resources.GetObject("chkShortInactive.ImageIndex"), Integer)
        Me.chkShortInactive.ImeMode = CType(resources.GetObject("chkShortInactive.ImeMode"), System.Windows.Forms.ImeMode)
        Me.chkShortInactive.Location = CType(resources.GetObject("chkShortInactive.Location"), System.Drawing.Point)
        Me.chkShortInactive.Name = "chkShortInactive"
        Me.chkShortInactive.RightToLeft = CType(resources.GetObject("chkShortInactive.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.chkShortInactive.Size = CType(resources.GetObject("chkShortInactive.Size"), System.Drawing.Size)
        Me.chkShortInactive.TabIndex = CType(resources.GetObject("chkShortInactive.TabIndex"), Integer)
        Me.chkShortInactive.Text = resources.GetString("chkShortInactive.Text")
        Me.chkShortInactive.TextAlign = CType(resources.GetObject("chkShortInactive.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.chkShortInactive, resources.GetString("chkShortInactive.ToolTip"))
        Me.chkShortInactive.Visible = CType(resources.GetObject("chkShortInactive.Visible"), Boolean)
        '
        'tbMainPlanet
        '
        Me.tbMainPlanet.AccessibleDescription = resources.GetString("tbMainPlanet.AccessibleDescription")
        Me.tbMainPlanet.AccessibleName = resources.GetString("tbMainPlanet.AccessibleName")
        Me.tbMainPlanet.Anchor = CType(resources.GetObject("tbMainPlanet.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbMainPlanet.AutoSize = CType(resources.GetObject("tbMainPlanet.AutoSize"), Boolean)
        Me.tbMainPlanet.BackgroundImage = CType(resources.GetObject("tbMainPlanet.BackgroundImage"), System.Drawing.Image)
        Me.tbMainPlanet.Dock = CType(resources.GetObject("tbMainPlanet.Dock"), System.Windows.Forms.DockStyle)
        Me.tbMainPlanet.Enabled = CType(resources.GetObject("tbMainPlanet.Enabled"), Boolean)
        Me.tbMainPlanet.Font = CType(resources.GetObject("tbMainPlanet.Font"), System.Drawing.Font)
        Me.tbMainPlanet.ImeMode = CType(resources.GetObject("tbMainPlanet.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbMainPlanet.Location = CType(resources.GetObject("tbMainPlanet.Location"), System.Drawing.Point)
        Me.tbMainPlanet.MaxLength = CType(resources.GetObject("tbMainPlanet.MaxLength"), Integer)
        Me.tbMainPlanet.Multiline = CType(resources.GetObject("tbMainPlanet.Multiline"), Boolean)
        Me.tbMainPlanet.Name = "tbMainPlanet"
        Me.tbMainPlanet.PasswordChar = CType(resources.GetObject("tbMainPlanet.PasswordChar"), Char)
        Me.tbMainPlanet.RightToLeft = CType(resources.GetObject("tbMainPlanet.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbMainPlanet.ScrollBars = CType(resources.GetObject("tbMainPlanet.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbMainPlanet.Size = CType(resources.GetObject("tbMainPlanet.Size"), System.Drawing.Size)
        Me.tbMainPlanet.TabIndex = CType(resources.GetObject("tbMainPlanet.TabIndex"), Integer)
        Me.tbMainPlanet.Text = resources.GetString("tbMainPlanet.Text")
        Me.tbMainPlanet.TextAlign = CType(resources.GetObject("tbMainPlanet.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbMainPlanet, resources.GetString("tbMainPlanet.ToolTip"))
        Me.tbMainPlanet.Visible = CType(resources.GetObject("tbMainPlanet.Visible"), Boolean)
        Me.tbMainPlanet.WordWrap = CType(resources.GetObject("tbMainPlanet.WordWrap"), Boolean)
        '
        'Label4
        '
        Me.Label4.AccessibleDescription = resources.GetString("Label4.AccessibleDescription")
        Me.Label4.AccessibleName = resources.GetString("Label4.AccessibleName")
        Me.Label4.Anchor = CType(resources.GetObject("Label4.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label4.AutoSize = CType(resources.GetObject("Label4.AutoSize"), Boolean)
        Me.Label4.Dock = CType(resources.GetObject("Label4.Dock"), System.Windows.Forms.DockStyle)
        Me.Label4.Enabled = CType(resources.GetObject("Label4.Enabled"), Boolean)
        Me.Label4.Font = CType(resources.GetObject("Label4.Font"), System.Drawing.Font)
        Me.Label4.Image = CType(resources.GetObject("Label4.Image"), System.Drawing.Image)
        Me.Label4.ImageAlign = CType(resources.GetObject("Label4.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label4.ImageIndex = CType(resources.GetObject("Label4.ImageIndex"), Integer)
        Me.Label4.ImeMode = CType(resources.GetObject("Label4.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label4.Location = CType(resources.GetObject("Label4.Location"), System.Drawing.Point)
        Me.Label4.Name = "Label4"
        Me.Label4.RightToLeft = CType(resources.GetObject("Label4.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label4.Size = CType(resources.GetObject("Label4.Size"), System.Drawing.Size)
        Me.Label4.TabIndex = CType(resources.GetObject("Label4.TabIndex"), Integer)
        Me.Label4.Text = resources.GetString("Label4.Text")
        Me.Label4.TextAlign = CType(resources.GetObject("Label4.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label4, resources.GetString("Label4.ToolTip"))
        Me.Label4.Visible = CType(resources.GetObject("Label4.Visible"), Boolean)
        '
        'tbAlly
        '
        Me.tbAlly.AccessibleDescription = resources.GetString("tbAlly.AccessibleDescription")
        Me.tbAlly.AccessibleName = resources.GetString("tbAlly.AccessibleName")
        Me.tbAlly.Anchor = CType(resources.GetObject("tbAlly.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbAlly.AutoSize = CType(resources.GetObject("tbAlly.AutoSize"), Boolean)
        Me.tbAlly.BackgroundImage = CType(resources.GetObject("tbAlly.BackgroundImage"), System.Drawing.Image)
        Me.tbAlly.Dock = CType(resources.GetObject("tbAlly.Dock"), System.Windows.Forms.DockStyle)
        Me.tbAlly.Enabled = CType(resources.GetObject("tbAlly.Enabled"), Boolean)
        Me.tbAlly.Font = CType(resources.GetObject("tbAlly.Font"), System.Drawing.Font)
        Me.tbAlly.ImeMode = CType(resources.GetObject("tbAlly.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbAlly.Location = CType(resources.GetObject("tbAlly.Location"), System.Drawing.Point)
        Me.tbAlly.MaxLength = CType(resources.GetObject("tbAlly.MaxLength"), Integer)
        Me.tbAlly.Multiline = CType(resources.GetObject("tbAlly.Multiline"), Boolean)
        Me.tbAlly.Name = "tbAlly"
        Me.tbAlly.PasswordChar = CType(resources.GetObject("tbAlly.PasswordChar"), Char)
        Me.tbAlly.RightToLeft = CType(resources.GetObject("tbAlly.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbAlly.ScrollBars = CType(resources.GetObject("tbAlly.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbAlly.Size = CType(resources.GetObject("tbAlly.Size"), System.Drawing.Size)
        Me.tbAlly.TabIndex = CType(resources.GetObject("tbAlly.TabIndex"), Integer)
        Me.tbAlly.Text = resources.GetString("tbAlly.Text")
        Me.tbAlly.TextAlign = CType(resources.GetObject("tbAlly.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbAlly, resources.GetString("tbAlly.ToolTip"))
        Me.tbAlly.Visible = CType(resources.GetObject("tbAlly.Visible"), Boolean)
        Me.tbAlly.WordWrap = CType(resources.GetObject("tbAlly.WordWrap"), Boolean)
        '
        'Label3
        '
        Me.Label3.AccessibleDescription = resources.GetString("Label3.AccessibleDescription")
        Me.Label3.AccessibleName = resources.GetString("Label3.AccessibleName")
        Me.Label3.Anchor = CType(resources.GetObject("Label3.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label3.AutoSize = CType(resources.GetObject("Label3.AutoSize"), Boolean)
        Me.Label3.Dock = CType(resources.GetObject("Label3.Dock"), System.Windows.Forms.DockStyle)
        Me.Label3.Enabled = CType(resources.GetObject("Label3.Enabled"), Boolean)
        Me.Label3.Font = CType(resources.GetObject("Label3.Font"), System.Drawing.Font)
        Me.Label3.Image = CType(resources.GetObject("Label3.Image"), System.Drawing.Image)
        Me.Label3.ImageAlign = CType(resources.GetObject("Label3.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label3.ImageIndex = CType(resources.GetObject("Label3.ImageIndex"), Integer)
        Me.Label3.ImeMode = CType(resources.GetObject("Label3.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label3.Location = CType(resources.GetObject("Label3.Location"), System.Drawing.Point)
        Me.Label3.Name = "Label3"
        Me.Label3.RightToLeft = CType(resources.GetObject("Label3.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label3.Size = CType(resources.GetObject("Label3.Size"), System.Drawing.Size)
        Me.Label3.TabIndex = CType(resources.GetObject("Label3.TabIndex"), Integer)
        Me.Label3.Text = resources.GetString("Label3.Text")
        Me.Label3.TextAlign = CType(resources.GetObject("Label3.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label3, resources.GetString("Label3.ToolTip"))
        Me.Label3.Visible = CType(resources.GetObject("Label3.Visible"), Boolean)
        '
        'tbname
        '
        Me.tbname.AccessibleDescription = resources.GetString("tbname.AccessibleDescription")
        Me.tbname.AccessibleName = resources.GetString("tbname.AccessibleName")
        Me.tbname.Anchor = CType(resources.GetObject("tbname.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbname.AutoSize = CType(resources.GetObject("tbname.AutoSize"), Boolean)
        Me.tbname.BackgroundImage = CType(resources.GetObject("tbname.BackgroundImage"), System.Drawing.Image)
        Me.tbname.Dock = CType(resources.GetObject("tbname.Dock"), System.Windows.Forms.DockStyle)
        Me.tbname.Enabled = CType(resources.GetObject("tbname.Enabled"), Boolean)
        Me.tbname.Font = CType(resources.GetObject("tbname.Font"), System.Drawing.Font)
        Me.tbname.ImeMode = CType(resources.GetObject("tbname.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbname.Location = CType(resources.GetObject("tbname.Location"), System.Drawing.Point)
        Me.tbname.MaxLength = CType(resources.GetObject("tbname.MaxLength"), Integer)
        Me.tbname.Multiline = CType(resources.GetObject("tbname.Multiline"), Boolean)
        Me.tbname.Name = "tbname"
        Me.tbname.PasswordChar = CType(resources.GetObject("tbname.PasswordChar"), Char)
        Me.tbname.RightToLeft = CType(resources.GetObject("tbname.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbname.ScrollBars = CType(resources.GetObject("tbname.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbname.Size = CType(resources.GetObject("tbname.Size"), System.Drawing.Size)
        Me.tbname.TabIndex = CType(resources.GetObject("tbname.TabIndex"), Integer)
        Me.tbname.Text = resources.GetString("tbname.Text")
        Me.tbname.TextAlign = CType(resources.GetObject("tbname.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbname, resources.GetString("tbname.ToolTip"))
        Me.tbname.Visible = CType(resources.GetObject("tbname.Visible"), Boolean)
        Me.tbname.WordWrap = CType(resources.GetObject("tbname.WordWrap"), Boolean)
        '
        'Label2
        '
        Me.Label2.AccessibleDescription = resources.GetString("Label2.AccessibleDescription")
        Me.Label2.AccessibleName = resources.GetString("Label2.AccessibleName")
        Me.Label2.Anchor = CType(resources.GetObject("Label2.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label2.AutoSize = CType(resources.GetObject("Label2.AutoSize"), Boolean)
        Me.Label2.Dock = CType(resources.GetObject("Label2.Dock"), System.Windows.Forms.DockStyle)
        Me.Label2.Enabled = CType(resources.GetObject("Label2.Enabled"), Boolean)
        Me.Label2.Font = CType(resources.GetObject("Label2.Font"), System.Drawing.Font)
        Me.Label2.Image = CType(resources.GetObject("Label2.Image"), System.Drawing.Image)
        Me.Label2.ImageAlign = CType(resources.GetObject("Label2.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label2.ImageIndex = CType(resources.GetObject("Label2.ImageIndex"), Integer)
        Me.Label2.ImeMode = CType(resources.GetObject("Label2.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label2.Location = CType(resources.GetObject("Label2.Location"), System.Drawing.Point)
        Me.Label2.Name = "Label2"
        Me.Label2.RightToLeft = CType(resources.GetObject("Label2.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label2.Size = CType(resources.GetObject("Label2.Size"), System.Drawing.Size)
        Me.Label2.TabIndex = CType(resources.GetObject("Label2.TabIndex"), Integer)
        Me.Label2.Text = resources.GetString("Label2.Text")
        Me.Label2.TextAlign = CType(resources.GetObject("Label2.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label2, resources.GetString("Label2.ToolTip"))
        Me.Label2.Visible = CType(resources.GetObject("Label2.Visible"), Boolean)
        '
        'tbID
        '
        Me.tbID.AccessibleDescription = resources.GetString("tbID.AccessibleDescription")
        Me.tbID.AccessibleName = resources.GetString("tbID.AccessibleName")
        Me.tbID.Anchor = CType(resources.GetObject("tbID.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbID.AutoSize = CType(resources.GetObject("tbID.AutoSize"), Boolean)
        Me.tbID.BackgroundImage = CType(resources.GetObject("tbID.BackgroundImage"), System.Drawing.Image)
        Me.tbID.Dock = CType(resources.GetObject("tbID.Dock"), System.Windows.Forms.DockStyle)
        Me.tbID.Enabled = CType(resources.GetObject("tbID.Enabled"), Boolean)
        Me.tbID.Font = CType(resources.GetObject("tbID.Font"), System.Drawing.Font)
        Me.tbID.ImeMode = CType(resources.GetObject("tbID.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbID.Location = CType(resources.GetObject("tbID.Location"), System.Drawing.Point)
        Me.tbID.MaxLength = CType(resources.GetObject("tbID.MaxLength"), Integer)
        Me.tbID.Multiline = CType(resources.GetObject("tbID.Multiline"), Boolean)
        Me.tbID.Name = "tbID"
        Me.tbID.PasswordChar = CType(resources.GetObject("tbID.PasswordChar"), Char)
        Me.tbID.ReadOnly = True
        Me.tbID.RightToLeft = CType(resources.GetObject("tbID.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbID.ScrollBars = CType(resources.GetObject("tbID.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbID.Size = CType(resources.GetObject("tbID.Size"), System.Drawing.Size)
        Me.tbID.TabIndex = CType(resources.GetObject("tbID.TabIndex"), Integer)
        Me.tbID.Text = resources.GetString("tbID.Text")
        Me.tbID.TextAlign = CType(resources.GetObject("tbID.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbID, resources.GetString("tbID.ToolTip"))
        Me.tbID.Visible = CType(resources.GetObject("tbID.Visible"), Boolean)
        Me.tbID.WordWrap = CType(resources.GetObject("tbID.WordWrap"), Boolean)
        '
        'Label1
        '
        Me.Label1.AccessibleDescription = resources.GetString("Label1.AccessibleDescription")
        Me.Label1.AccessibleName = resources.GetString("Label1.AccessibleName")
        Me.Label1.Anchor = CType(resources.GetObject("Label1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label1.AutoSize = CType(resources.GetObject("Label1.AutoSize"), Boolean)
        Me.Label1.Dock = CType(resources.GetObject("Label1.Dock"), System.Windows.Forms.DockStyle)
        Me.Label1.Enabled = CType(resources.GetObject("Label1.Enabled"), Boolean)
        Me.Label1.Font = CType(resources.GetObject("Label1.Font"), System.Drawing.Font)
        Me.Label1.Image = CType(resources.GetObject("Label1.Image"), System.Drawing.Image)
        Me.Label1.ImageAlign = CType(resources.GetObject("Label1.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label1.ImageIndex = CType(resources.GetObject("Label1.ImageIndex"), Integer)
        Me.Label1.ImeMode = CType(resources.GetObject("Label1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label1.Location = CType(resources.GetObject("Label1.Location"), System.Drawing.Point)
        Me.Label1.Name = "Label1"
        Me.Label1.RightToLeft = CType(resources.GetObject("Label1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label1.Size = CType(resources.GetObject("Label1.Size"), System.Drawing.Size)
        Me.Label1.TabIndex = CType(resources.GetObject("Label1.TabIndex"), Integer)
        Me.Label1.Text = resources.GetString("Label1.Text")
        Me.Label1.TextAlign = CType(resources.GetObject("Label1.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label1, resources.GetString("Label1.ToolTip"))
        Me.Label1.Visible = CType(resources.GetObject("Label1.Visible"), Boolean)
        '
        'tpStats
        '
        Me.tpStats.AccessibleDescription = resources.GetString("tpStats.AccessibleDescription")
        Me.tpStats.AccessibleName = resources.GetString("tpStats.AccessibleName")
        Me.tpStats.Anchor = CType(resources.GetObject("tpStats.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tpStats.AutoScroll = CType(resources.GetObject("tpStats.AutoScroll"), Boolean)
        Me.tpStats.AutoScrollMargin = CType(resources.GetObject("tpStats.AutoScrollMargin"), System.Drawing.Size)
        Me.tpStats.AutoScrollMinSize = CType(resources.GetObject("tpStats.AutoScrollMinSize"), System.Drawing.Size)
        Me.tpStats.BackgroundImage = CType(resources.GetObject("tpStats.BackgroundImage"), System.Drawing.Image)
        Me.tpStats.Controls.Add(Me.dgStatistics)
        Me.tpStats.Controls.Add(Me.Panel4)
        Me.tpStats.Dock = CType(resources.GetObject("tpStats.Dock"), System.Windows.Forms.DockStyle)
        Me.tpStats.Enabled = CType(resources.GetObject("tpStats.Enabled"), Boolean)
        Me.tpStats.Font = CType(resources.GetObject("tpStats.Font"), System.Drawing.Font)
        Me.tpStats.ImageIndex = CType(resources.GetObject("tpStats.ImageIndex"), Integer)
        Me.tpStats.ImeMode = CType(resources.GetObject("tpStats.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tpStats.Location = CType(resources.GetObject("tpStats.Location"), System.Drawing.Point)
        Me.tpStats.Name = "tpStats"
        Me.tpStats.RightToLeft = CType(resources.GetObject("tpStats.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tpStats.Size = CType(resources.GetObject("tpStats.Size"), System.Drawing.Size)
        Me.tpStats.TabIndex = CType(resources.GetObject("tpStats.TabIndex"), Integer)
        Me.tpStats.Text = resources.GetString("tpStats.Text")
        Me.ToolTip1.SetToolTip(Me.tpStats, resources.GetString("tpStats.ToolTip"))
        Me.tpStats.ToolTipText = resources.GetString("tpStats.ToolTipText")
        Me.tpStats.Visible = CType(resources.GetObject("tpStats.Visible"), Boolean)
        '
        'dgStatistics
        '
        Me.dgStatistics.AccessibleDescription = resources.GetString("dgStatistics.AccessibleDescription")
        Me.dgStatistics.AccessibleName = resources.GetString("dgStatistics.AccessibleName")
        Me.dgStatistics.AlternatingBackColor = System.Drawing.Color.GhostWhite
        Me.dgStatistics.Anchor = CType(resources.GetObject("dgStatistics.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.dgStatistics.BackColor = System.Drawing.Color.GhostWhite
        Me.dgStatistics.BackgroundColor = System.Drawing.Color.Lavender
        Me.dgStatistics.BackgroundImage = CType(resources.GetObject("dgStatistics.BackgroundImage"), System.Drawing.Image)
        Me.dgStatistics.BorderStyle = System.Windows.Forms.BorderStyle.None
        Me.dgStatistics.CaptionBackColor = System.Drawing.Color.RoyalBlue
        Me.dgStatistics.CaptionFont = CType(resources.GetObject("dgStatistics.CaptionFont"), System.Drawing.Font)
        Me.dgStatistics.CaptionForeColor = System.Drawing.Color.White
        Me.dgStatistics.CaptionText = resources.GetString("dgStatistics.CaptionText")
        Me.dgStatistics.CaptionVisible = False
        Me.dgStatistics.DataMember = ""
        Me.dgStatistics.Dock = CType(resources.GetObject("dgStatistics.Dock"), System.Windows.Forms.DockStyle)
        Me.dgStatistics.Enabled = CType(resources.GetObject("dgStatistics.Enabled"), Boolean)
        Me.dgStatistics.FlatMode = True
        Me.dgStatistics.Font = CType(resources.GetObject("dgStatistics.Font"), System.Drawing.Font)
        Me.dgStatistics.ForeColor = System.Drawing.Color.MidnightBlue
        Me.dgStatistics.GridLineColor = System.Drawing.Color.RoyalBlue
        Me.dgStatistics.HeaderBackColor = System.Drawing.Color.MidnightBlue
        Me.dgStatistics.HeaderFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgStatistics.HeaderForeColor = System.Drawing.Color.Lavender
        Me.dgStatistics.ImeMode = CType(resources.GetObject("dgStatistics.ImeMode"), System.Windows.Forms.ImeMode)
        Me.dgStatistics.LinkColor = System.Drawing.Color.Teal
        Me.dgStatistics.Location = CType(resources.GetObject("dgStatistics.Location"), System.Drawing.Point)
        Me.dgStatistics.Name = "dgStatistics"
        Me.dgStatistics.ParentRowsBackColor = System.Drawing.Color.Lavender
        Me.dgStatistics.ParentRowsForeColor = System.Drawing.Color.MidnightBlue
        Me.dgStatistics.RightToLeft = CType(resources.GetObject("dgStatistics.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.dgStatistics.SelectionBackColor = System.Drawing.Color.Teal
        Me.dgStatistics.SelectionForeColor = System.Drawing.Color.PaleGreen
        Me.dgStatistics.Size = CType(resources.GetObject("dgStatistics.Size"), System.Drawing.Size)
        Me.dgStatistics.TabIndex = CType(resources.GetObject("dgStatistics.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.dgStatistics, resources.GetString("dgStatistics.ToolTip"))
        Me.dgStatistics.Visible = CType(resources.GetObject("dgStatistics.Visible"), Boolean)
        '
        'Panel4
        '
        Me.Panel4.AccessibleDescription = resources.GetString("Panel4.AccessibleDescription")
        Me.Panel4.AccessibleName = resources.GetString("Panel4.AccessibleName")
        Me.Panel4.Anchor = CType(resources.GetObject("Panel4.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel4.AutoScroll = CType(resources.GetObject("Panel4.AutoScroll"), Boolean)
        Me.Panel4.AutoScrollMargin = CType(resources.GetObject("Panel4.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel4.AutoScrollMinSize = CType(resources.GetObject("Panel4.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel4.BackgroundImage = CType(resources.GetObject("Panel4.BackgroundImage"), System.Drawing.Image)
        Me.Panel4.Controls.Add(Me.Button1)
        Me.Panel4.Dock = CType(resources.GetObject("Panel4.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel4.Enabled = CType(resources.GetObject("Panel4.Enabled"), Boolean)
        Me.Panel4.Font = CType(resources.GetObject("Panel4.Font"), System.Drawing.Font)
        Me.Panel4.ImeMode = CType(resources.GetObject("Panel4.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel4.Location = CType(resources.GetObject("Panel4.Location"), System.Drawing.Point)
        Me.Panel4.Name = "Panel4"
        Me.Panel4.RightToLeft = CType(resources.GetObject("Panel4.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel4.Size = CType(resources.GetObject("Panel4.Size"), System.Drawing.Size)
        Me.Panel4.TabIndex = CType(resources.GetObject("Panel4.TabIndex"), Integer)
        Me.Panel4.Text = resources.GetString("Panel4.Text")
        Me.ToolTip1.SetToolTip(Me.Panel4, resources.GetString("Panel4.ToolTip"))
        Me.Panel4.Visible = CType(resources.GetObject("Panel4.Visible"), Boolean)
        '
        'Button1
        '
        Me.Button1.AccessibleDescription = resources.GetString("Button1.AccessibleDescription")
        Me.Button1.AccessibleName = resources.GetString("Button1.AccessibleName")
        Me.Button1.Anchor = CType(resources.GetObject("Button1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button1.BackgroundImage = CType(resources.GetObject("Button1.BackgroundImage"), System.Drawing.Image)
        Me.Button1.Dock = CType(resources.GetObject("Button1.Dock"), System.Windows.Forms.DockStyle)
        Me.Button1.Enabled = CType(resources.GetObject("Button1.Enabled"), Boolean)
        Me.Button1.FlatStyle = CType(resources.GetObject("Button1.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.Button1.Font = CType(resources.GetObject("Button1.Font"), System.Drawing.Font)
        Me.Button1.Image = CType(resources.GetObject("Button1.Image"), System.Drawing.Image)
        Me.Button1.ImageAlign = CType(resources.GetObject("Button1.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Button1.ImageIndex = CType(resources.GetObject("Button1.ImageIndex"), Integer)
        Me.Button1.ImeMode = CType(resources.GetObject("Button1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Button1.Location = CType(resources.GetObject("Button1.Location"), System.Drawing.Point)
        Me.Button1.Name = "Button1"
        Me.Button1.RightToLeft = CType(resources.GetObject("Button1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Button1.Size = CType(resources.GetObject("Button1.Size"), System.Drawing.Size)
        Me.Button1.TabIndex = CType(resources.GetObject("Button1.TabIndex"), Integer)
        Me.Button1.Text = resources.GetString("Button1.Text")
        Me.Button1.TextAlign = CType(resources.GetObject("Button1.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Button1, resources.GetString("Button1.ToolTip"))
        Me.Button1.Visible = CType(resources.GetObject("Button1.Visible"), Boolean)
        '
        'tpPlanets
        '
        Me.tpPlanets.AccessibleDescription = resources.GetString("tpPlanets.AccessibleDescription")
        Me.tpPlanets.AccessibleName = resources.GetString("tpPlanets.AccessibleName")
        Me.tpPlanets.Anchor = CType(resources.GetObject("tpPlanets.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tpPlanets.AutoScroll = CType(resources.GetObject("tpPlanets.AutoScroll"), Boolean)
        Me.tpPlanets.AutoScrollMargin = CType(resources.GetObject("tpPlanets.AutoScrollMargin"), System.Drawing.Size)
        Me.tpPlanets.AutoScrollMinSize = CType(resources.GetObject("tpPlanets.AutoScrollMinSize"), System.Drawing.Size)
        Me.tpPlanets.BackgroundImage = CType(resources.GetObject("tpPlanets.BackgroundImage"), System.Drawing.Image)
        Me.tpPlanets.Controls.Add(Me.rtbPlanetReport)
        Me.tpPlanets.Controls.Add(Me.Panel8)
        Me.tpPlanets.Controls.Add(Me.panPlanetSpyReport)
        Me.tpPlanets.Controls.Add(Me.Panel7)
        Me.tpPlanets.Controls.Add(Me.Panel5)
        Me.tpPlanets.Dock = CType(resources.GetObject("tpPlanets.Dock"), System.Windows.Forms.DockStyle)
        Me.tpPlanets.Enabled = CType(resources.GetObject("tpPlanets.Enabled"), Boolean)
        Me.tpPlanets.Font = CType(resources.GetObject("tpPlanets.Font"), System.Drawing.Font)
        Me.tpPlanets.ImageIndex = CType(resources.GetObject("tpPlanets.ImageIndex"), Integer)
        Me.tpPlanets.ImeMode = CType(resources.GetObject("tpPlanets.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tpPlanets.Location = CType(resources.GetObject("tpPlanets.Location"), System.Drawing.Point)
        Me.tpPlanets.Name = "tpPlanets"
        Me.tpPlanets.RightToLeft = CType(resources.GetObject("tpPlanets.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tpPlanets.Size = CType(resources.GetObject("tpPlanets.Size"), System.Drawing.Size)
        Me.tpPlanets.TabIndex = CType(resources.GetObject("tpPlanets.TabIndex"), Integer)
        Me.tpPlanets.Text = resources.GetString("tpPlanets.Text")
        Me.ToolTip1.SetToolTip(Me.tpPlanets, resources.GetString("tpPlanets.ToolTip"))
        Me.tpPlanets.ToolTipText = resources.GetString("tpPlanets.ToolTipText")
        Me.tpPlanets.Visible = CType(resources.GetObject("tpPlanets.Visible"), Boolean)
        '
        'rtbPlanetReport
        '
        Me.rtbPlanetReport.AccessibleDescription = resources.GetString("rtbPlanetReport.AccessibleDescription")
        Me.rtbPlanetReport.AccessibleName = resources.GetString("rtbPlanetReport.AccessibleName")
        Me.rtbPlanetReport.Anchor = CType(resources.GetObject("rtbPlanetReport.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.rtbPlanetReport.AutoSize = CType(resources.GetObject("rtbPlanetReport.AutoSize"), Boolean)
        Me.rtbPlanetReport.BackColor = System.Drawing.Color.Black
        Me.rtbPlanetReport.BackgroundImage = CType(resources.GetObject("rtbPlanetReport.BackgroundImage"), System.Drawing.Image)
        Me.rtbPlanetReport.BulletIndent = CType(resources.GetObject("rtbPlanetReport.BulletIndent"), Integer)
        Me.rtbPlanetReport.Dock = CType(resources.GetObject("rtbPlanetReport.Dock"), System.Windows.Forms.DockStyle)
        Me.rtbPlanetReport.Enabled = CType(resources.GetObject("rtbPlanetReport.Enabled"), Boolean)
        Me.rtbPlanetReport.Font = CType(resources.GetObject("rtbPlanetReport.Font"), System.Drawing.Font)
        Me.rtbPlanetReport.ForeColor = System.Drawing.Color.WhiteSmoke
        Me.rtbPlanetReport.ImeMode = CType(resources.GetObject("rtbPlanetReport.ImeMode"), System.Windows.Forms.ImeMode)
        Me.rtbPlanetReport.Location = CType(resources.GetObject("rtbPlanetReport.Location"), System.Drawing.Point)
        Me.rtbPlanetReport.MaxLength = CType(resources.GetObject("rtbPlanetReport.MaxLength"), Integer)
        Me.rtbPlanetReport.Multiline = CType(resources.GetObject("rtbPlanetReport.Multiline"), Boolean)
        Me.rtbPlanetReport.Name = "rtbPlanetReport"
        Me.rtbPlanetReport.ReadOnly = True
        Me.rtbPlanetReport.RightMargin = CType(resources.GetObject("rtbPlanetReport.RightMargin"), Integer)
        Me.rtbPlanetReport.RightToLeft = CType(resources.GetObject("rtbPlanetReport.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.rtbPlanetReport.ScrollBars = CType(resources.GetObject("rtbPlanetReport.ScrollBars"), System.Windows.Forms.RichTextBoxScrollBars)
        Me.rtbPlanetReport.Size = CType(resources.GetObject("rtbPlanetReport.Size"), System.Drawing.Size)
        Me.rtbPlanetReport.TabIndex = CType(resources.GetObject("rtbPlanetReport.TabIndex"), Integer)
        Me.rtbPlanetReport.Text = resources.GetString("rtbPlanetReport.Text")
        Me.ToolTip1.SetToolTip(Me.rtbPlanetReport, resources.GetString("rtbPlanetReport.ToolTip"))
        Me.rtbPlanetReport.Visible = CType(resources.GetObject("rtbPlanetReport.Visible"), Boolean)
        Me.rtbPlanetReport.WordWrap = CType(resources.GetObject("rtbPlanetReport.WordWrap"), Boolean)
        Me.rtbPlanetReport.ZoomFactor = CType(resources.GetObject("rtbPlanetReport.ZoomFactor"), Single)
        '
        'Panel8
        '
        Me.Panel8.AccessibleDescription = resources.GetString("Panel8.AccessibleDescription")
        Me.Panel8.AccessibleName = resources.GetString("Panel8.AccessibleName")
        Me.Panel8.Anchor = CType(resources.GetObject("Panel8.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel8.AutoScroll = CType(resources.GetObject("Panel8.AutoScroll"), Boolean)
        Me.Panel8.AutoScrollMargin = CType(resources.GetObject("Panel8.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel8.AutoScrollMinSize = CType(resources.GetObject("Panel8.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel8.BackgroundImage = CType(resources.GetObject("Panel8.BackgroundImage"), System.Drawing.Image)
        Me.Panel8.Controls.Add(Me.lbPlanetAttacks)
        Me.Panel8.Controls.Add(Me.Label6)
        Me.Panel8.Controls.Add(Me.panPlanetAttackReports)
        Me.Panel8.Dock = CType(resources.GetObject("Panel8.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel8.Enabled = CType(resources.GetObject("Panel8.Enabled"), Boolean)
        Me.Panel8.Font = CType(resources.GetObject("Panel8.Font"), System.Drawing.Font)
        Me.Panel8.ImeMode = CType(resources.GetObject("Panel8.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel8.Location = CType(resources.GetObject("Panel8.Location"), System.Drawing.Point)
        Me.Panel8.Name = "Panel8"
        Me.Panel8.RightToLeft = CType(resources.GetObject("Panel8.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel8.Size = CType(resources.GetObject("Panel8.Size"), System.Drawing.Size)
        Me.Panel8.TabIndex = CType(resources.GetObject("Panel8.TabIndex"), Integer)
        Me.Panel8.Text = resources.GetString("Panel8.Text")
        Me.ToolTip1.SetToolTip(Me.Panel8, resources.GetString("Panel8.ToolTip"))
        Me.Panel8.Visible = CType(resources.GetObject("Panel8.Visible"), Boolean)
        '
        'lbPlanetAttacks
        '
        Me.lbPlanetAttacks.AccessibleDescription = resources.GetString("lbPlanetAttacks.AccessibleDescription")
        Me.lbPlanetAttacks.AccessibleName = resources.GetString("lbPlanetAttacks.AccessibleName")
        Me.lbPlanetAttacks.Anchor = CType(resources.GetObject("lbPlanetAttacks.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbPlanetAttacks.BackgroundImage = CType(resources.GetObject("lbPlanetAttacks.BackgroundImage"), System.Drawing.Image)
        Me.lbPlanetAttacks.ColumnWidth = CType(resources.GetObject("lbPlanetAttacks.ColumnWidth"), Integer)
        Me.lbPlanetAttacks.Dock = CType(resources.GetObject("lbPlanetAttacks.Dock"), System.Windows.Forms.DockStyle)
        Me.lbPlanetAttacks.Enabled = CType(resources.GetObject("lbPlanetAttacks.Enabled"), Boolean)
        Me.lbPlanetAttacks.Font = CType(resources.GetObject("lbPlanetAttacks.Font"), System.Drawing.Font)
        Me.lbPlanetAttacks.HorizontalExtent = CType(resources.GetObject("lbPlanetAttacks.HorizontalExtent"), Integer)
        Me.lbPlanetAttacks.HorizontalScrollbar = CType(resources.GetObject("lbPlanetAttacks.HorizontalScrollbar"), Boolean)
        Me.lbPlanetAttacks.ImeMode = CType(resources.GetObject("lbPlanetAttacks.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbPlanetAttacks.IntegralHeight = CType(resources.GetObject("lbPlanetAttacks.IntegralHeight"), Boolean)
        Me.lbPlanetAttacks.ItemHeight = CType(resources.GetObject("lbPlanetAttacks.ItemHeight"), Integer)
        Me.lbPlanetAttacks.Location = CType(resources.GetObject("lbPlanetAttacks.Location"), System.Drawing.Point)
        Me.lbPlanetAttacks.Name = "lbPlanetAttacks"
        Me.lbPlanetAttacks.RightToLeft = CType(resources.GetObject("lbPlanetAttacks.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbPlanetAttacks.ScrollAlwaysVisible = CType(resources.GetObject("lbPlanetAttacks.ScrollAlwaysVisible"), Boolean)
        Me.lbPlanetAttacks.Size = CType(resources.GetObject("lbPlanetAttacks.Size"), System.Drawing.Size)
        Me.lbPlanetAttacks.TabIndex = CType(resources.GetObject("lbPlanetAttacks.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.lbPlanetAttacks, resources.GetString("lbPlanetAttacks.ToolTip"))
        Me.lbPlanetAttacks.Visible = CType(resources.GetObject("lbPlanetAttacks.Visible"), Boolean)
        '
        'Label6
        '
        Me.Label6.AccessibleDescription = resources.GetString("Label6.AccessibleDescription")
        Me.Label6.AccessibleName = resources.GetString("Label6.AccessibleName")
        Me.Label6.Anchor = CType(resources.GetObject("Label6.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label6.AutoSize = CType(resources.GetObject("Label6.AutoSize"), Boolean)
        Me.Label6.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label6.Dock = CType(resources.GetObject("Label6.Dock"), System.Windows.Forms.DockStyle)
        Me.Label6.Enabled = CType(resources.GetObject("Label6.Enabled"), Boolean)
        Me.Label6.Font = CType(resources.GetObject("Label6.Font"), System.Drawing.Font)
        Me.Label6.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label6.Image = CType(resources.GetObject("Label6.Image"), System.Drawing.Image)
        Me.Label6.ImageAlign = CType(resources.GetObject("Label6.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label6.ImageIndex = CType(resources.GetObject("Label6.ImageIndex"), Integer)
        Me.Label6.ImeMode = CType(resources.GetObject("Label6.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label6.Location = CType(resources.GetObject("Label6.Location"), System.Drawing.Point)
        Me.Label6.Name = "Label6"
        Me.Label6.RightToLeft = CType(resources.GetObject("Label6.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label6.Size = CType(resources.GetObject("Label6.Size"), System.Drawing.Size)
        Me.Label6.TabIndex = CType(resources.GetObject("Label6.TabIndex"), Integer)
        Me.Label6.Text = resources.GetString("Label6.Text")
        Me.Label6.TextAlign = CType(resources.GetObject("Label6.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label6, resources.GetString("Label6.ToolTip"))
        Me.Label6.Visible = CType(resources.GetObject("Label6.Visible"), Boolean)
        '
        'panPlanetAttackReports
        '
        Me.panPlanetAttackReports.AccessibleDescription = resources.GetString("panPlanetAttackReports.AccessibleDescription")
        Me.panPlanetAttackReports.AccessibleName = resources.GetString("panPlanetAttackReports.AccessibleName")
        Me.panPlanetAttackReports.Anchor = CType(resources.GetObject("panPlanetAttackReports.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.panPlanetAttackReports.AutoScroll = CType(resources.GetObject("panPlanetAttackReports.AutoScroll"), Boolean)
        Me.panPlanetAttackReports.AutoScrollMargin = CType(resources.GetObject("panPlanetAttackReports.AutoScrollMargin"), System.Drawing.Size)
        Me.panPlanetAttackReports.AutoScrollMinSize = CType(resources.GetObject("panPlanetAttackReports.AutoScrollMinSize"), System.Drawing.Size)
        Me.panPlanetAttackReports.BackgroundImage = CType(resources.GetObject("panPlanetAttackReports.BackgroundImage"), System.Drawing.Image)
        Me.panPlanetAttackReports.Controls.Add(Me.btnAttackCopy)
        Me.panPlanetAttackReports.Controls.Add(Me.btnAttackDelete)
        Me.panPlanetAttackReports.Dock = CType(resources.GetObject("panPlanetAttackReports.Dock"), System.Windows.Forms.DockStyle)
        Me.panPlanetAttackReports.Enabled = CType(resources.GetObject("panPlanetAttackReports.Enabled"), Boolean)
        Me.panPlanetAttackReports.Font = CType(resources.GetObject("panPlanetAttackReports.Font"), System.Drawing.Font)
        Me.panPlanetAttackReports.ImeMode = CType(resources.GetObject("panPlanetAttackReports.ImeMode"), System.Windows.Forms.ImeMode)
        Me.panPlanetAttackReports.Location = CType(resources.GetObject("panPlanetAttackReports.Location"), System.Drawing.Point)
        Me.panPlanetAttackReports.Name = "panPlanetAttackReports"
        Me.panPlanetAttackReports.RightToLeft = CType(resources.GetObject("panPlanetAttackReports.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.panPlanetAttackReports.Size = CType(resources.GetObject("panPlanetAttackReports.Size"), System.Drawing.Size)
        Me.panPlanetAttackReports.TabIndex = CType(resources.GetObject("panPlanetAttackReports.TabIndex"), Integer)
        Me.panPlanetAttackReports.Text = resources.GetString("panPlanetAttackReports.Text")
        Me.ToolTip1.SetToolTip(Me.panPlanetAttackReports, resources.GetString("panPlanetAttackReports.ToolTip"))
        Me.panPlanetAttackReports.Visible = CType(resources.GetObject("panPlanetAttackReports.Visible"), Boolean)
        '
        'btnAttackCopy
        '
        Me.btnAttackCopy.AccessibleDescription = resources.GetString("btnAttackCopy.AccessibleDescription")
        Me.btnAttackCopy.AccessibleName = resources.GetString("btnAttackCopy.AccessibleName")
        Me.btnAttackCopy.Anchor = CType(resources.GetObject("btnAttackCopy.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnAttackCopy.BackgroundImage = CType(resources.GetObject("btnAttackCopy.BackgroundImage"), System.Drawing.Image)
        Me.btnAttackCopy.DialogResult = System.Windows.Forms.DialogResult.Cancel
        Me.btnAttackCopy.Dock = CType(resources.GetObject("btnAttackCopy.Dock"), System.Windows.Forms.DockStyle)
        Me.btnAttackCopy.Enabled = CType(resources.GetObject("btnAttackCopy.Enabled"), Boolean)
        Me.btnAttackCopy.FlatStyle = CType(resources.GetObject("btnAttackCopy.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnAttackCopy.Font = CType(resources.GetObject("btnAttackCopy.Font"), System.Drawing.Font)
        Me.btnAttackCopy.Image = CType(resources.GetObject("btnAttackCopy.Image"), System.Drawing.Image)
        Me.btnAttackCopy.ImageAlign = CType(resources.GetObject("btnAttackCopy.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnAttackCopy.ImageIndex = CType(resources.GetObject("btnAttackCopy.ImageIndex"), Integer)
        Me.btnAttackCopy.ImeMode = CType(resources.GetObject("btnAttackCopy.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnAttackCopy.Location = CType(resources.GetObject("btnAttackCopy.Location"), System.Drawing.Point)
        Me.btnAttackCopy.Name = "btnAttackCopy"
        Me.btnAttackCopy.RightToLeft = CType(resources.GetObject("btnAttackCopy.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnAttackCopy.Size = CType(resources.GetObject("btnAttackCopy.Size"), System.Drawing.Size)
        Me.btnAttackCopy.TabIndex = CType(resources.GetObject("btnAttackCopy.TabIndex"), Integer)
        Me.btnAttackCopy.Text = resources.GetString("btnAttackCopy.Text")
        Me.btnAttackCopy.TextAlign = CType(resources.GetObject("btnAttackCopy.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnAttackCopy, resources.GetString("btnAttackCopy.ToolTip"))
        Me.btnAttackCopy.Visible = CType(resources.GetObject("btnAttackCopy.Visible"), Boolean)
        '
        'btnAttackDelete
        '
        Me.btnAttackDelete.AccessibleDescription = resources.GetString("btnAttackDelete.AccessibleDescription")
        Me.btnAttackDelete.AccessibleName = resources.GetString("btnAttackDelete.AccessibleName")
        Me.btnAttackDelete.Anchor = CType(resources.GetObject("btnAttackDelete.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnAttackDelete.BackgroundImage = CType(resources.GetObject("btnAttackDelete.BackgroundImage"), System.Drawing.Image)
        Me.btnAttackDelete.DialogResult = System.Windows.Forms.DialogResult.Cancel
        Me.btnAttackDelete.Dock = CType(resources.GetObject("btnAttackDelete.Dock"), System.Windows.Forms.DockStyle)
        Me.btnAttackDelete.Enabled = CType(resources.GetObject("btnAttackDelete.Enabled"), Boolean)
        Me.btnAttackDelete.FlatStyle = CType(resources.GetObject("btnAttackDelete.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnAttackDelete.Font = CType(resources.GetObject("btnAttackDelete.Font"), System.Drawing.Font)
        Me.btnAttackDelete.Image = CType(resources.GetObject("btnAttackDelete.Image"), System.Drawing.Image)
        Me.btnAttackDelete.ImageAlign = CType(resources.GetObject("btnAttackDelete.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnAttackDelete.ImageIndex = CType(resources.GetObject("btnAttackDelete.ImageIndex"), Integer)
        Me.btnAttackDelete.ImeMode = CType(resources.GetObject("btnAttackDelete.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnAttackDelete.Location = CType(resources.GetObject("btnAttackDelete.Location"), System.Drawing.Point)
        Me.btnAttackDelete.Name = "btnAttackDelete"
        Me.btnAttackDelete.RightToLeft = CType(resources.GetObject("btnAttackDelete.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnAttackDelete.Size = CType(resources.GetObject("btnAttackDelete.Size"), System.Drawing.Size)
        Me.btnAttackDelete.TabIndex = CType(resources.GetObject("btnAttackDelete.TabIndex"), Integer)
        Me.btnAttackDelete.Text = resources.GetString("btnAttackDelete.Text")
        Me.btnAttackDelete.TextAlign = CType(resources.GetObject("btnAttackDelete.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnAttackDelete, resources.GetString("btnAttackDelete.ToolTip"))
        Me.btnAttackDelete.Visible = CType(resources.GetObject("btnAttackDelete.Visible"), Boolean)
        '
        'panPlanetSpyReport
        '
        Me.panPlanetSpyReport.AccessibleDescription = resources.GetString("panPlanetSpyReport.AccessibleDescription")
        Me.panPlanetSpyReport.AccessibleName = resources.GetString("panPlanetSpyReport.AccessibleName")
        Me.panPlanetSpyReport.Anchor = CType(resources.GetObject("panPlanetSpyReport.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.panPlanetSpyReport.AutoScroll = CType(resources.GetObject("panPlanetSpyReport.AutoScroll"), Boolean)
        Me.panPlanetSpyReport.AutoScrollMargin = CType(resources.GetObject("panPlanetSpyReport.AutoScrollMargin"), System.Drawing.Size)
        Me.panPlanetSpyReport.AutoScrollMinSize = CType(resources.GetObject("panPlanetSpyReport.AutoScrollMinSize"), System.Drawing.Size)
        Me.panPlanetSpyReport.BackgroundImage = CType(resources.GetObject("panPlanetSpyReport.BackgroundImage"), System.Drawing.Image)
        Me.panPlanetSpyReport.Controls.Add(Me.lbPlanetSpyReport)
        Me.panPlanetSpyReport.Controls.Add(Me.Label5)
        Me.panPlanetSpyReport.Controls.Add(Me.panPlanetSpyReportDown)
        Me.panPlanetSpyReport.Dock = CType(resources.GetObject("panPlanetSpyReport.Dock"), System.Windows.Forms.DockStyle)
        Me.panPlanetSpyReport.Enabled = CType(resources.GetObject("panPlanetSpyReport.Enabled"), Boolean)
        Me.panPlanetSpyReport.Font = CType(resources.GetObject("panPlanetSpyReport.Font"), System.Drawing.Font)
        Me.panPlanetSpyReport.ImeMode = CType(resources.GetObject("panPlanetSpyReport.ImeMode"), System.Windows.Forms.ImeMode)
        Me.panPlanetSpyReport.Location = CType(resources.GetObject("panPlanetSpyReport.Location"), System.Drawing.Point)
        Me.panPlanetSpyReport.Name = "panPlanetSpyReport"
        Me.panPlanetSpyReport.RightToLeft = CType(resources.GetObject("panPlanetSpyReport.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.panPlanetSpyReport.Size = CType(resources.GetObject("panPlanetSpyReport.Size"), System.Drawing.Size)
        Me.panPlanetSpyReport.TabIndex = CType(resources.GetObject("panPlanetSpyReport.TabIndex"), Integer)
        Me.panPlanetSpyReport.Text = resources.GetString("panPlanetSpyReport.Text")
        Me.ToolTip1.SetToolTip(Me.panPlanetSpyReport, resources.GetString("panPlanetSpyReport.ToolTip"))
        Me.panPlanetSpyReport.Visible = CType(resources.GetObject("panPlanetSpyReport.Visible"), Boolean)
        '
        'lbPlanetSpyReport
        '
        Me.lbPlanetSpyReport.AccessibleDescription = resources.GetString("lbPlanetSpyReport.AccessibleDescription")
        Me.lbPlanetSpyReport.AccessibleName = resources.GetString("lbPlanetSpyReport.AccessibleName")
        Me.lbPlanetSpyReport.Anchor = CType(resources.GetObject("lbPlanetSpyReport.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbPlanetSpyReport.BackgroundImage = CType(resources.GetObject("lbPlanetSpyReport.BackgroundImage"), System.Drawing.Image)
        Me.lbPlanetSpyReport.ColumnWidth = CType(resources.GetObject("lbPlanetSpyReport.ColumnWidth"), Integer)
        Me.lbPlanetSpyReport.Dock = CType(resources.GetObject("lbPlanetSpyReport.Dock"), System.Windows.Forms.DockStyle)
        Me.lbPlanetSpyReport.Enabled = CType(resources.GetObject("lbPlanetSpyReport.Enabled"), Boolean)
        Me.lbPlanetSpyReport.Font = CType(resources.GetObject("lbPlanetSpyReport.Font"), System.Drawing.Font)
        Me.lbPlanetSpyReport.HorizontalExtent = CType(resources.GetObject("lbPlanetSpyReport.HorizontalExtent"), Integer)
        Me.lbPlanetSpyReport.HorizontalScrollbar = CType(resources.GetObject("lbPlanetSpyReport.HorizontalScrollbar"), Boolean)
        Me.lbPlanetSpyReport.ImeMode = CType(resources.GetObject("lbPlanetSpyReport.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbPlanetSpyReport.IntegralHeight = CType(resources.GetObject("lbPlanetSpyReport.IntegralHeight"), Boolean)
        Me.lbPlanetSpyReport.ItemHeight = CType(resources.GetObject("lbPlanetSpyReport.ItemHeight"), Integer)
        Me.lbPlanetSpyReport.Location = CType(resources.GetObject("lbPlanetSpyReport.Location"), System.Drawing.Point)
        Me.lbPlanetSpyReport.Name = "lbPlanetSpyReport"
        Me.lbPlanetSpyReport.RightToLeft = CType(resources.GetObject("lbPlanetSpyReport.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbPlanetSpyReport.ScrollAlwaysVisible = CType(resources.GetObject("lbPlanetSpyReport.ScrollAlwaysVisible"), Boolean)
        Me.lbPlanetSpyReport.Size = CType(resources.GetObject("lbPlanetSpyReport.Size"), System.Drawing.Size)
        Me.lbPlanetSpyReport.TabIndex = CType(resources.GetObject("lbPlanetSpyReport.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.lbPlanetSpyReport, resources.GetString("lbPlanetSpyReport.ToolTip"))
        Me.lbPlanetSpyReport.Visible = CType(resources.GetObject("lbPlanetSpyReport.Visible"), Boolean)
        '
        'Label5
        '
        Me.Label5.AccessibleDescription = resources.GetString("Label5.AccessibleDescription")
        Me.Label5.AccessibleName = resources.GetString("Label5.AccessibleName")
        Me.Label5.Anchor = CType(resources.GetObject("Label5.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label5.AutoSize = CType(resources.GetObject("Label5.AutoSize"), Boolean)
        Me.Label5.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label5.Dock = CType(resources.GetObject("Label5.Dock"), System.Windows.Forms.DockStyle)
        Me.Label5.Enabled = CType(resources.GetObject("Label5.Enabled"), Boolean)
        Me.Label5.Font = CType(resources.GetObject("Label5.Font"), System.Drawing.Font)
        Me.Label5.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label5.Image = CType(resources.GetObject("Label5.Image"), System.Drawing.Image)
        Me.Label5.ImageAlign = CType(resources.GetObject("Label5.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label5.ImageIndex = CType(resources.GetObject("Label5.ImageIndex"), Integer)
        Me.Label5.ImeMode = CType(resources.GetObject("Label5.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label5.Location = CType(resources.GetObject("Label5.Location"), System.Drawing.Point)
        Me.Label5.Name = "Label5"
        Me.Label5.RightToLeft = CType(resources.GetObject("Label5.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label5.Size = CType(resources.GetObject("Label5.Size"), System.Drawing.Size)
        Me.Label5.TabIndex = CType(resources.GetObject("Label5.TabIndex"), Integer)
        Me.Label5.Text = resources.GetString("Label5.Text")
        Me.Label5.TextAlign = CType(resources.GetObject("Label5.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label5, resources.GetString("Label5.ToolTip"))
        Me.Label5.Visible = CType(resources.GetObject("Label5.Visible"), Boolean)
        '
        'panPlanetSpyReportDown
        '
        Me.panPlanetSpyReportDown.AccessibleDescription = resources.GetString("panPlanetSpyReportDown.AccessibleDescription")
        Me.panPlanetSpyReportDown.AccessibleName = resources.GetString("panPlanetSpyReportDown.AccessibleName")
        Me.panPlanetSpyReportDown.Anchor = CType(resources.GetObject("panPlanetSpyReportDown.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.panPlanetSpyReportDown.AutoScroll = CType(resources.GetObject("panPlanetSpyReportDown.AutoScroll"), Boolean)
        Me.panPlanetSpyReportDown.AutoScrollMargin = CType(resources.GetObject("panPlanetSpyReportDown.AutoScrollMargin"), System.Drawing.Size)
        Me.panPlanetSpyReportDown.AutoScrollMinSize = CType(resources.GetObject("panPlanetSpyReportDown.AutoScrollMinSize"), System.Drawing.Size)
        Me.panPlanetSpyReportDown.BackgroundImage = CType(resources.GetObject("panPlanetSpyReportDown.BackgroundImage"), System.Drawing.Image)
        Me.panPlanetSpyReportDown.Controls.Add(Me.btnSpyCopy)
        Me.panPlanetSpyReportDown.Controls.Add(Me.btnSpyDelete)
        Me.panPlanetSpyReportDown.Dock = CType(resources.GetObject("panPlanetSpyReportDown.Dock"), System.Windows.Forms.DockStyle)
        Me.panPlanetSpyReportDown.Enabled = CType(resources.GetObject("panPlanetSpyReportDown.Enabled"), Boolean)
        Me.panPlanetSpyReportDown.Font = CType(resources.GetObject("panPlanetSpyReportDown.Font"), System.Drawing.Font)
        Me.panPlanetSpyReportDown.ImeMode = CType(resources.GetObject("panPlanetSpyReportDown.ImeMode"), System.Windows.Forms.ImeMode)
        Me.panPlanetSpyReportDown.Location = CType(resources.GetObject("panPlanetSpyReportDown.Location"), System.Drawing.Point)
        Me.panPlanetSpyReportDown.Name = "panPlanetSpyReportDown"
        Me.panPlanetSpyReportDown.RightToLeft = CType(resources.GetObject("panPlanetSpyReportDown.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.panPlanetSpyReportDown.Size = CType(resources.GetObject("panPlanetSpyReportDown.Size"), System.Drawing.Size)
        Me.panPlanetSpyReportDown.TabIndex = CType(resources.GetObject("panPlanetSpyReportDown.TabIndex"), Integer)
        Me.panPlanetSpyReportDown.Text = resources.GetString("panPlanetSpyReportDown.Text")
        Me.ToolTip1.SetToolTip(Me.panPlanetSpyReportDown, resources.GetString("panPlanetSpyReportDown.ToolTip"))
        Me.panPlanetSpyReportDown.Visible = CType(resources.GetObject("panPlanetSpyReportDown.Visible"), Boolean)
        '
        'btnSpyCopy
        '
        Me.btnSpyCopy.AccessibleDescription = resources.GetString("btnSpyCopy.AccessibleDescription")
        Me.btnSpyCopy.AccessibleName = resources.GetString("btnSpyCopy.AccessibleName")
        Me.btnSpyCopy.Anchor = CType(resources.GetObject("btnSpyCopy.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnSpyCopy.BackgroundImage = CType(resources.GetObject("btnSpyCopy.BackgroundImage"), System.Drawing.Image)
        Me.btnSpyCopy.DialogResult = System.Windows.Forms.DialogResult.Cancel
        Me.btnSpyCopy.Dock = CType(resources.GetObject("btnSpyCopy.Dock"), System.Windows.Forms.DockStyle)
        Me.btnSpyCopy.Enabled = CType(resources.GetObject("btnSpyCopy.Enabled"), Boolean)
        Me.btnSpyCopy.FlatStyle = CType(resources.GetObject("btnSpyCopy.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnSpyCopy.Font = CType(resources.GetObject("btnSpyCopy.Font"), System.Drawing.Font)
        Me.btnSpyCopy.Image = CType(resources.GetObject("btnSpyCopy.Image"), System.Drawing.Image)
        Me.btnSpyCopy.ImageAlign = CType(resources.GetObject("btnSpyCopy.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnSpyCopy.ImageIndex = CType(resources.GetObject("btnSpyCopy.ImageIndex"), Integer)
        Me.btnSpyCopy.ImeMode = CType(resources.GetObject("btnSpyCopy.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnSpyCopy.Location = CType(resources.GetObject("btnSpyCopy.Location"), System.Drawing.Point)
        Me.btnSpyCopy.Name = "btnSpyCopy"
        Me.btnSpyCopy.RightToLeft = CType(resources.GetObject("btnSpyCopy.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnSpyCopy.Size = CType(resources.GetObject("btnSpyCopy.Size"), System.Drawing.Size)
        Me.btnSpyCopy.TabIndex = CType(resources.GetObject("btnSpyCopy.TabIndex"), Integer)
        Me.btnSpyCopy.Text = resources.GetString("btnSpyCopy.Text")
        Me.btnSpyCopy.TextAlign = CType(resources.GetObject("btnSpyCopy.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnSpyCopy, resources.GetString("btnSpyCopy.ToolTip"))
        Me.btnSpyCopy.Visible = CType(resources.GetObject("btnSpyCopy.Visible"), Boolean)
        '
        'btnSpyDelete
        '
        Me.btnSpyDelete.AccessibleDescription = resources.GetString("btnSpyDelete.AccessibleDescription")
        Me.btnSpyDelete.AccessibleName = resources.GetString("btnSpyDelete.AccessibleName")
        Me.btnSpyDelete.Anchor = CType(resources.GetObject("btnSpyDelete.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnSpyDelete.BackgroundImage = CType(resources.GetObject("btnSpyDelete.BackgroundImage"), System.Drawing.Image)
        Me.btnSpyDelete.DialogResult = System.Windows.Forms.DialogResult.Cancel
        Me.btnSpyDelete.Dock = CType(resources.GetObject("btnSpyDelete.Dock"), System.Windows.Forms.DockStyle)
        Me.btnSpyDelete.Enabled = CType(resources.GetObject("btnSpyDelete.Enabled"), Boolean)
        Me.btnSpyDelete.FlatStyle = CType(resources.GetObject("btnSpyDelete.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnSpyDelete.Font = CType(resources.GetObject("btnSpyDelete.Font"), System.Drawing.Font)
        Me.btnSpyDelete.Image = CType(resources.GetObject("btnSpyDelete.Image"), System.Drawing.Image)
        Me.btnSpyDelete.ImageAlign = CType(resources.GetObject("btnSpyDelete.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnSpyDelete.ImageIndex = CType(resources.GetObject("btnSpyDelete.ImageIndex"), Integer)
        Me.btnSpyDelete.ImeMode = CType(resources.GetObject("btnSpyDelete.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnSpyDelete.Location = CType(resources.GetObject("btnSpyDelete.Location"), System.Drawing.Point)
        Me.btnSpyDelete.Name = "btnSpyDelete"
        Me.btnSpyDelete.RightToLeft = CType(resources.GetObject("btnSpyDelete.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnSpyDelete.Size = CType(resources.GetObject("btnSpyDelete.Size"), System.Drawing.Size)
        Me.btnSpyDelete.TabIndex = CType(resources.GetObject("btnSpyDelete.TabIndex"), Integer)
        Me.btnSpyDelete.Text = resources.GetString("btnSpyDelete.Text")
        Me.btnSpyDelete.TextAlign = CType(resources.GetObject("btnSpyDelete.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnSpyDelete, resources.GetString("btnSpyDelete.ToolTip"))
        Me.btnSpyDelete.Visible = CType(resources.GetObject("btnSpyDelete.Visible"), Boolean)
        '
        'Panel7
        '
        Me.Panel7.AccessibleDescription = resources.GetString("Panel7.AccessibleDescription")
        Me.Panel7.AccessibleName = resources.GetString("Panel7.AccessibleName")
        Me.Panel7.Anchor = CType(resources.GetObject("Panel7.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel7.AutoScroll = CType(resources.GetObject("Panel7.AutoScroll"), Boolean)
        Me.Panel7.AutoScrollMargin = CType(resources.GetObject("Panel7.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel7.AutoScrollMinSize = CType(resources.GetObject("Panel7.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel7.BackgroundImage = CType(resources.GetObject("Panel7.BackgroundImage"), System.Drawing.Image)
        Me.Panel7.Controls.Add(Me.lbPlanets)
        Me.Panel7.Controls.Add(Me.panPlanetPlanet)
        Me.Panel7.Dock = CType(resources.GetObject("Panel7.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel7.Enabled = CType(resources.GetObject("Panel7.Enabled"), Boolean)
        Me.Panel7.Font = CType(resources.GetObject("Panel7.Font"), System.Drawing.Font)
        Me.Panel7.ImeMode = CType(resources.GetObject("Panel7.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel7.Location = CType(resources.GetObject("Panel7.Location"), System.Drawing.Point)
        Me.Panel7.Name = "Panel7"
        Me.Panel7.RightToLeft = CType(resources.GetObject("Panel7.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel7.Size = CType(resources.GetObject("Panel7.Size"), System.Drawing.Size)
        Me.Panel7.TabIndex = CType(resources.GetObject("Panel7.TabIndex"), Integer)
        Me.Panel7.Text = resources.GetString("Panel7.Text")
        Me.ToolTip1.SetToolTip(Me.Panel7, resources.GetString("Panel7.ToolTip"))
        Me.Panel7.Visible = CType(resources.GetObject("Panel7.Visible"), Boolean)
        '
        'lbPlanets
        '
        Me.lbPlanets.AccessibleDescription = resources.GetString("lbPlanets.AccessibleDescription")
        Me.lbPlanets.AccessibleName = resources.GetString("lbPlanets.AccessibleName")
        Me.lbPlanets.Anchor = CType(resources.GetObject("lbPlanets.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbPlanets.BackColor = System.Drawing.SystemColors.Info
        Me.lbPlanets.BackgroundImage = CType(resources.GetObject("lbPlanets.BackgroundImage"), System.Drawing.Image)
        Me.lbPlanets.ColumnWidth = CType(resources.GetObject("lbPlanets.ColumnWidth"), Integer)
        Me.lbPlanets.Dock = CType(resources.GetObject("lbPlanets.Dock"), System.Windows.Forms.DockStyle)
        Me.lbPlanets.Enabled = CType(resources.GetObject("lbPlanets.Enabled"), Boolean)
        Me.lbPlanets.Font = CType(resources.GetObject("lbPlanets.Font"), System.Drawing.Font)
        Me.lbPlanets.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbPlanets.HorizontalExtent = CType(resources.GetObject("lbPlanets.HorizontalExtent"), Integer)
        Me.lbPlanets.HorizontalScrollbar = CType(resources.GetObject("lbPlanets.HorizontalScrollbar"), Boolean)
        Me.lbPlanets.ImeMode = CType(resources.GetObject("lbPlanets.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbPlanets.IntegralHeight = CType(resources.GetObject("lbPlanets.IntegralHeight"), Boolean)
        Me.lbPlanets.ItemHeight = CType(resources.GetObject("lbPlanets.ItemHeight"), Integer)
        Me.lbPlanets.Location = CType(resources.GetObject("lbPlanets.Location"), System.Drawing.Point)
        Me.lbPlanets.Name = "lbPlanets"
        Me.lbPlanets.RightToLeft = CType(resources.GetObject("lbPlanets.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbPlanets.ScrollAlwaysVisible = CType(resources.GetObject("lbPlanets.ScrollAlwaysVisible"), Boolean)
        Me.lbPlanets.Size = CType(resources.GetObject("lbPlanets.Size"), System.Drawing.Size)
        Me.lbPlanets.TabIndex = CType(resources.GetObject("lbPlanets.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.lbPlanets, resources.GetString("lbPlanets.ToolTip"))
        Me.lbPlanets.Visible = CType(resources.GetObject("lbPlanets.Visible"), Boolean)
        '
        'panPlanetPlanet
        '
        Me.panPlanetPlanet.AccessibleDescription = resources.GetString("panPlanetPlanet.AccessibleDescription")
        Me.panPlanetPlanet.AccessibleName = resources.GetString("panPlanetPlanet.AccessibleName")
        Me.panPlanetPlanet.Anchor = CType(resources.GetObject("panPlanetPlanet.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.panPlanetPlanet.AutoScroll = CType(resources.GetObject("panPlanetPlanet.AutoScroll"), Boolean)
        Me.panPlanetPlanet.AutoScrollMargin = CType(resources.GetObject("panPlanetPlanet.AutoScrollMargin"), System.Drawing.Size)
        Me.panPlanetPlanet.AutoScrollMinSize = CType(resources.GetObject("panPlanetPlanet.AutoScrollMinSize"), System.Drawing.Size)
        Me.panPlanetPlanet.BackgroundImage = CType(resources.GetObject("panPlanetPlanet.BackgroundImage"), System.Drawing.Image)
        Me.panPlanetPlanet.Controls.Add(Me.btnPlanetCopy)
        Me.panPlanetPlanet.Controls.Add(Me.btnPlanetDelete)
        Me.panPlanetPlanet.Dock = CType(resources.GetObject("panPlanetPlanet.Dock"), System.Windows.Forms.DockStyle)
        Me.panPlanetPlanet.Enabled = CType(resources.GetObject("panPlanetPlanet.Enabled"), Boolean)
        Me.panPlanetPlanet.Font = CType(resources.GetObject("panPlanetPlanet.Font"), System.Drawing.Font)
        Me.panPlanetPlanet.ImeMode = CType(resources.GetObject("panPlanetPlanet.ImeMode"), System.Windows.Forms.ImeMode)
        Me.panPlanetPlanet.Location = CType(resources.GetObject("panPlanetPlanet.Location"), System.Drawing.Point)
        Me.panPlanetPlanet.Name = "panPlanetPlanet"
        Me.panPlanetPlanet.RightToLeft = CType(resources.GetObject("panPlanetPlanet.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.panPlanetPlanet.Size = CType(resources.GetObject("panPlanetPlanet.Size"), System.Drawing.Size)
        Me.panPlanetPlanet.TabIndex = CType(resources.GetObject("panPlanetPlanet.TabIndex"), Integer)
        Me.panPlanetPlanet.Text = resources.GetString("panPlanetPlanet.Text")
        Me.ToolTip1.SetToolTip(Me.panPlanetPlanet, resources.GetString("panPlanetPlanet.ToolTip"))
        Me.panPlanetPlanet.Visible = CType(resources.GetObject("panPlanetPlanet.Visible"), Boolean)
        '
        'btnPlanetCopy
        '
        Me.btnPlanetCopy.AccessibleDescription = resources.GetString("btnPlanetCopy.AccessibleDescription")
        Me.btnPlanetCopy.AccessibleName = resources.GetString("btnPlanetCopy.AccessibleName")
        Me.btnPlanetCopy.Anchor = CType(resources.GetObject("btnPlanetCopy.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnPlanetCopy.BackgroundImage = CType(resources.GetObject("btnPlanetCopy.BackgroundImage"), System.Drawing.Image)
        Me.btnPlanetCopy.DialogResult = System.Windows.Forms.DialogResult.Cancel
        Me.btnPlanetCopy.Dock = CType(resources.GetObject("btnPlanetCopy.Dock"), System.Windows.Forms.DockStyle)
        Me.btnPlanetCopy.Enabled = CType(resources.GetObject("btnPlanetCopy.Enabled"), Boolean)
        Me.btnPlanetCopy.FlatStyle = CType(resources.GetObject("btnPlanetCopy.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnPlanetCopy.Font = CType(resources.GetObject("btnPlanetCopy.Font"), System.Drawing.Font)
        Me.btnPlanetCopy.Image = CType(resources.GetObject("btnPlanetCopy.Image"), System.Drawing.Image)
        Me.btnPlanetCopy.ImageAlign = CType(resources.GetObject("btnPlanetCopy.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnPlanetCopy.ImageIndex = CType(resources.GetObject("btnPlanetCopy.ImageIndex"), Integer)
        Me.btnPlanetCopy.ImeMode = CType(resources.GetObject("btnPlanetCopy.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnPlanetCopy.Location = CType(resources.GetObject("btnPlanetCopy.Location"), System.Drawing.Point)
        Me.btnPlanetCopy.Name = "btnPlanetCopy"
        Me.btnPlanetCopy.RightToLeft = CType(resources.GetObject("btnPlanetCopy.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnPlanetCopy.Size = CType(resources.GetObject("btnPlanetCopy.Size"), System.Drawing.Size)
        Me.btnPlanetCopy.TabIndex = CType(resources.GetObject("btnPlanetCopy.TabIndex"), Integer)
        Me.btnPlanetCopy.Text = resources.GetString("btnPlanetCopy.Text")
        Me.btnPlanetCopy.TextAlign = CType(resources.GetObject("btnPlanetCopy.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnPlanetCopy, resources.GetString("btnPlanetCopy.ToolTip"))
        Me.btnPlanetCopy.Visible = CType(resources.GetObject("btnPlanetCopy.Visible"), Boolean)
        '
        'btnPlanetDelete
        '
        Me.btnPlanetDelete.AccessibleDescription = resources.GetString("btnPlanetDelete.AccessibleDescription")
        Me.btnPlanetDelete.AccessibleName = resources.GetString("btnPlanetDelete.AccessibleName")
        Me.btnPlanetDelete.Anchor = CType(resources.GetObject("btnPlanetDelete.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnPlanetDelete.BackgroundImage = CType(resources.GetObject("btnPlanetDelete.BackgroundImage"), System.Drawing.Image)
        Me.btnPlanetDelete.DialogResult = System.Windows.Forms.DialogResult.Cancel
        Me.btnPlanetDelete.Dock = CType(resources.GetObject("btnPlanetDelete.Dock"), System.Windows.Forms.DockStyle)
        Me.btnPlanetDelete.Enabled = CType(resources.GetObject("btnPlanetDelete.Enabled"), Boolean)
        Me.btnPlanetDelete.FlatStyle = CType(resources.GetObject("btnPlanetDelete.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnPlanetDelete.Font = CType(resources.GetObject("btnPlanetDelete.Font"), System.Drawing.Font)
        Me.btnPlanetDelete.Image = CType(resources.GetObject("btnPlanetDelete.Image"), System.Drawing.Image)
        Me.btnPlanetDelete.ImageAlign = CType(resources.GetObject("btnPlanetDelete.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnPlanetDelete.ImageIndex = CType(resources.GetObject("btnPlanetDelete.ImageIndex"), Integer)
        Me.btnPlanetDelete.ImeMode = CType(resources.GetObject("btnPlanetDelete.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnPlanetDelete.Location = CType(resources.GetObject("btnPlanetDelete.Location"), System.Drawing.Point)
        Me.btnPlanetDelete.Name = "btnPlanetDelete"
        Me.btnPlanetDelete.RightToLeft = CType(resources.GetObject("btnPlanetDelete.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnPlanetDelete.Size = CType(resources.GetObject("btnPlanetDelete.Size"), System.Drawing.Size)
        Me.btnPlanetDelete.TabIndex = CType(resources.GetObject("btnPlanetDelete.TabIndex"), Integer)
        Me.btnPlanetDelete.Text = resources.GetString("btnPlanetDelete.Text")
        Me.btnPlanetDelete.TextAlign = CType(resources.GetObject("btnPlanetDelete.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnPlanetDelete, resources.GetString("btnPlanetDelete.ToolTip"))
        Me.btnPlanetDelete.Visible = CType(resources.GetObject("btnPlanetDelete.Visible"), Boolean)
        '
        'Panel5
        '
        Me.Panel5.AccessibleDescription = resources.GetString("Panel5.AccessibleDescription")
        Me.Panel5.AccessibleName = resources.GetString("Panel5.AccessibleName")
        Me.Panel5.Anchor = CType(resources.GetObject("Panel5.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel5.AutoScroll = CType(resources.GetObject("Panel5.AutoScroll"), Boolean)
        Me.Panel5.AutoScrollMargin = CType(resources.GetObject("Panel5.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel5.AutoScrollMinSize = CType(resources.GetObject("Panel5.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel5.BackgroundImage = CType(resources.GetObject("Panel5.BackgroundImage"), System.Drawing.Image)
        Me.Panel5.Controls.Add(Me.btnShowPlanets)
        Me.Panel5.Dock = CType(resources.GetObject("Panel5.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel5.Enabled = CType(resources.GetObject("Panel5.Enabled"), Boolean)
        Me.Panel5.Font = CType(resources.GetObject("Panel5.Font"), System.Drawing.Font)
        Me.Panel5.ImeMode = CType(resources.GetObject("Panel5.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel5.Location = CType(resources.GetObject("Panel5.Location"), System.Drawing.Point)
        Me.Panel5.Name = "Panel5"
        Me.Panel5.RightToLeft = CType(resources.GetObject("Panel5.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel5.Size = CType(resources.GetObject("Panel5.Size"), System.Drawing.Size)
        Me.Panel5.TabIndex = CType(resources.GetObject("Panel5.TabIndex"), Integer)
        Me.Panel5.Text = resources.GetString("Panel5.Text")
        Me.ToolTip1.SetToolTip(Me.Panel5, resources.GetString("Panel5.ToolTip"))
        Me.Panel5.Visible = CType(resources.GetObject("Panel5.Visible"), Boolean)
        '
        'btnShowPlanets
        '
        Me.btnShowPlanets.AccessibleDescription = resources.GetString("btnShowPlanets.AccessibleDescription")
        Me.btnShowPlanets.AccessibleName = resources.GetString("btnShowPlanets.AccessibleName")
        Me.btnShowPlanets.Anchor = CType(resources.GetObject("btnShowPlanets.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnShowPlanets.BackgroundImage = CType(resources.GetObject("btnShowPlanets.BackgroundImage"), System.Drawing.Image)
        Me.btnShowPlanets.Dock = CType(resources.GetObject("btnShowPlanets.Dock"), System.Windows.Forms.DockStyle)
        Me.btnShowPlanets.Enabled = CType(resources.GetObject("btnShowPlanets.Enabled"), Boolean)
        Me.btnShowPlanets.FlatStyle = CType(resources.GetObject("btnShowPlanets.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnShowPlanets.Font = CType(resources.GetObject("btnShowPlanets.Font"), System.Drawing.Font)
        Me.btnShowPlanets.Image = CType(resources.GetObject("btnShowPlanets.Image"), System.Drawing.Image)
        Me.btnShowPlanets.ImageAlign = CType(resources.GetObject("btnShowPlanets.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnShowPlanets.ImageIndex = CType(resources.GetObject("btnShowPlanets.ImageIndex"), Integer)
        Me.btnShowPlanets.ImeMode = CType(resources.GetObject("btnShowPlanets.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnShowPlanets.Location = CType(resources.GetObject("btnShowPlanets.Location"), System.Drawing.Point)
        Me.btnShowPlanets.Name = "btnShowPlanets"
        Me.btnShowPlanets.RightToLeft = CType(resources.GetObject("btnShowPlanets.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnShowPlanets.Size = CType(resources.GetObject("btnShowPlanets.Size"), System.Drawing.Size)
        Me.btnShowPlanets.TabIndex = CType(resources.GetObject("btnShowPlanets.TabIndex"), Integer)
        Me.btnShowPlanets.Text = resources.GetString("btnShowPlanets.Text")
        Me.btnShowPlanets.TextAlign = CType(resources.GetObject("btnShowPlanets.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnShowPlanets, resources.GetString("btnShowPlanets.ToolTip"))
        Me.btnShowPlanets.Visible = CType(resources.GetObject("btnShowPlanets.Visible"), Boolean)
        '
        'tpGraphicStats
        '
        Me.tpGraphicStats.AccessibleDescription = resources.GetString("tpGraphicStats.AccessibleDescription")
        Me.tpGraphicStats.AccessibleName = resources.GetString("tpGraphicStats.AccessibleName")
        Me.tpGraphicStats.Anchor = CType(resources.GetObject("tpGraphicStats.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tpGraphicStats.AutoScroll = CType(resources.GetObject("tpGraphicStats.AutoScroll"), Boolean)
        Me.tpGraphicStats.AutoScrollMargin = CType(resources.GetObject("tpGraphicStats.AutoScrollMargin"), System.Drawing.Size)
        Me.tpGraphicStats.AutoScrollMinSize = CType(resources.GetObject("tpGraphicStats.AutoScrollMinSize"), System.Drawing.Size)
        Me.tpGraphicStats.BackgroundImage = CType(resources.GetObject("tpGraphicStats.BackgroundImage"), System.Drawing.Image)
        Me.tpGraphicStats.Controls.Add(Me.OgsPlayerStatsGraph1)
        Me.tpGraphicStats.Controls.Add(Me.Panel6)
        Me.tpGraphicStats.Dock = CType(resources.GetObject("tpGraphicStats.Dock"), System.Windows.Forms.DockStyle)
        Me.tpGraphicStats.Enabled = CType(resources.GetObject("tpGraphicStats.Enabled"), Boolean)
        Me.tpGraphicStats.Font = CType(resources.GetObject("tpGraphicStats.Font"), System.Drawing.Font)
        Me.tpGraphicStats.ImageIndex = CType(resources.GetObject("tpGraphicStats.ImageIndex"), Integer)
        Me.tpGraphicStats.ImeMode = CType(resources.GetObject("tpGraphicStats.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tpGraphicStats.Location = CType(resources.GetObject("tpGraphicStats.Location"), System.Drawing.Point)
        Me.tpGraphicStats.Name = "tpGraphicStats"
        Me.tpGraphicStats.RightToLeft = CType(resources.GetObject("tpGraphicStats.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tpGraphicStats.Size = CType(resources.GetObject("tpGraphicStats.Size"), System.Drawing.Size)
        Me.tpGraphicStats.TabIndex = CType(resources.GetObject("tpGraphicStats.TabIndex"), Integer)
        Me.tpGraphicStats.Text = resources.GetString("tpGraphicStats.Text")
        Me.ToolTip1.SetToolTip(Me.tpGraphicStats, resources.GetString("tpGraphicStats.ToolTip"))
        Me.tpGraphicStats.ToolTipText = resources.GetString("tpGraphicStats.ToolTipText")
        Me.tpGraphicStats.Visible = CType(resources.GetObject("tpGraphicStats.Visible"), Boolean)
        '
        'OgsPlayerStatsGraph1
        '
        Me.OgsPlayerStatsGraph1.AccessibleDescription = resources.GetString("OgsPlayerStatsGraph1.AccessibleDescription")
        Me.OgsPlayerStatsGraph1.AccessibleName = resources.GetString("OgsPlayerStatsGraph1.AccessibleName")
        Me.OgsPlayerStatsGraph1.Anchor = CType(resources.GetObject("OgsPlayerStatsGraph1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.OgsPlayerStatsGraph1.AutoScroll = CType(resources.GetObject("OgsPlayerStatsGraph1.AutoScroll"), Boolean)
        Me.OgsPlayerStatsGraph1.AutoScrollMargin = CType(resources.GetObject("OgsPlayerStatsGraph1.AutoScrollMargin"), System.Drawing.Size)
        Me.OgsPlayerStatsGraph1.AutoScrollMinSize = CType(resources.GetObject("OgsPlayerStatsGraph1.AutoScrollMinSize"), System.Drawing.Size)
        Me.OgsPlayerStatsGraph1.BackgroundImage = CType(resources.GetObject("OgsPlayerStatsGraph1.BackgroundImage"), System.Drawing.Image)
        Me.OgsPlayerStatsGraph1.Dock = CType(resources.GetObject("OgsPlayerStatsGraph1.Dock"), System.Windows.Forms.DockStyle)
        Me.OgsPlayerStatsGraph1.Enabled = CType(resources.GetObject("OgsPlayerStatsGraph1.Enabled"), Boolean)
        Me.OgsPlayerStatsGraph1.Font = CType(resources.GetObject("OgsPlayerStatsGraph1.Font"), System.Drawing.Font)
        Me.OgsPlayerStatsGraph1.GraphType = OGameStratege.OGSPlayerStatsGraph.StatsGraphType.Points
        Me.OgsPlayerStatsGraph1.ImeMode = CType(resources.GetObject("OgsPlayerStatsGraph1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.OgsPlayerStatsGraph1.Location = CType(resources.GetObject("OgsPlayerStatsGraph1.Location"), System.Drawing.Point)
        Me.OgsPlayerStatsGraph1.Name = "OgsPlayerStatsGraph1"
        Me.OgsPlayerStatsGraph1.Player = Nothing
        Me.OgsPlayerStatsGraph1.RightToLeft = CType(resources.GetObject("OgsPlayerStatsGraph1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.OgsPlayerStatsGraph1.Size = CType(resources.GetObject("OgsPlayerStatsGraph1.Size"), System.Drawing.Size)
        Me.OgsPlayerStatsGraph1.TabIndex = CType(resources.GetObject("OgsPlayerStatsGraph1.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.OgsPlayerStatsGraph1, resources.GetString("OgsPlayerStatsGraph1.ToolTip"))
        Me.OgsPlayerStatsGraph1.Visible = CType(resources.GetObject("OgsPlayerStatsGraph1.Visible"), Boolean)
        '
        'Panel6
        '
        Me.Panel6.AccessibleDescription = resources.GetString("Panel6.AccessibleDescription")
        Me.Panel6.AccessibleName = resources.GetString("Panel6.AccessibleName")
        Me.Panel6.Anchor = CType(resources.GetObject("Panel6.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel6.AutoScroll = CType(resources.GetObject("Panel6.AutoScroll"), Boolean)
        Me.Panel6.AutoScrollMargin = CType(resources.GetObject("Panel6.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel6.AutoScrollMinSize = CType(resources.GetObject("Panel6.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel6.BackgroundImage = CType(resources.GetObject("Panel6.BackgroundImage"), System.Drawing.Image)
        Me.Panel6.Controls.Add(Me.Button2)
        Me.Panel6.Controls.Add(Me.Button3)
        Me.Panel6.Dock = CType(resources.GetObject("Panel6.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel6.Enabled = CType(resources.GetObject("Panel6.Enabled"), Boolean)
        Me.Panel6.Font = CType(resources.GetObject("Panel6.Font"), System.Drawing.Font)
        Me.Panel6.ImeMode = CType(resources.GetObject("Panel6.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel6.Location = CType(resources.GetObject("Panel6.Location"), System.Drawing.Point)
        Me.Panel6.Name = "Panel6"
        Me.Panel6.RightToLeft = CType(resources.GetObject("Panel6.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel6.Size = CType(resources.GetObject("Panel6.Size"), System.Drawing.Size)
        Me.Panel6.TabIndex = CType(resources.GetObject("Panel6.TabIndex"), Integer)
        Me.Panel6.Text = resources.GetString("Panel6.Text")
        Me.ToolTip1.SetToolTip(Me.Panel6, resources.GetString("Panel6.ToolTip"))
        Me.Panel6.Visible = CType(resources.GetObject("Panel6.Visible"), Boolean)
        '
        'Button2
        '
        Me.Button2.AccessibleDescription = resources.GetString("Button2.AccessibleDescription")
        Me.Button2.AccessibleName = resources.GetString("Button2.AccessibleName")
        Me.Button2.Anchor = CType(resources.GetObject("Button2.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button2.BackgroundImage = CType(resources.GetObject("Button2.BackgroundImage"), System.Drawing.Image)
        Me.Button2.Dock = CType(resources.GetObject("Button2.Dock"), System.Windows.Forms.DockStyle)
        Me.Button2.Enabled = CType(resources.GetObject("Button2.Enabled"), Boolean)
        Me.Button2.FlatStyle = CType(resources.GetObject("Button2.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.Button2.Font = CType(resources.GetObject("Button2.Font"), System.Drawing.Font)
        Me.Button2.Image = CType(resources.GetObject("Button2.Image"), System.Drawing.Image)
        Me.Button2.ImageAlign = CType(resources.GetObject("Button2.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Button2.ImageIndex = CType(resources.GetObject("Button2.ImageIndex"), Integer)
        Me.Button2.ImeMode = CType(resources.GetObject("Button2.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Button2.Location = CType(resources.GetObject("Button2.Location"), System.Drawing.Point)
        Me.Button2.Name = "Button2"
        Me.Button2.RightToLeft = CType(resources.GetObject("Button2.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Button2.Size = CType(resources.GetObject("Button2.Size"), System.Drawing.Size)
        Me.Button2.TabIndex = CType(resources.GetObject("Button2.TabIndex"), Integer)
        Me.Button2.Text = resources.GetString("Button2.Text")
        Me.Button2.TextAlign = CType(resources.GetObject("Button2.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Button2, resources.GetString("Button2.ToolTip"))
        Me.Button2.Visible = CType(resources.GetObject("Button2.Visible"), Boolean)
        '
        'Button3
        '
        Me.Button3.AccessibleDescription = resources.GetString("Button3.AccessibleDescription")
        Me.Button3.AccessibleName = resources.GetString("Button3.AccessibleName")
        Me.Button3.Anchor = CType(resources.GetObject("Button3.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button3.BackgroundImage = CType(resources.GetObject("Button3.BackgroundImage"), System.Drawing.Image)
        Me.Button3.Dock = CType(resources.GetObject("Button3.Dock"), System.Windows.Forms.DockStyle)
        Me.Button3.Enabled = CType(resources.GetObject("Button3.Enabled"), Boolean)
        Me.Button3.FlatStyle = CType(resources.GetObject("Button3.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.Button3.Font = CType(resources.GetObject("Button3.Font"), System.Drawing.Font)
        Me.Button3.Image = CType(resources.GetObject("Button3.Image"), System.Drawing.Image)
        Me.Button3.ImageAlign = CType(resources.GetObject("Button3.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Button3.ImageIndex = CType(resources.GetObject("Button3.ImageIndex"), Integer)
        Me.Button3.ImeMode = CType(resources.GetObject("Button3.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Button3.Location = CType(resources.GetObject("Button3.Location"), System.Drawing.Point)
        Me.Button3.Name = "Button3"
        Me.Button3.RightToLeft = CType(resources.GetObject("Button3.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Button3.Size = CType(resources.GetObject("Button3.Size"), System.Drawing.Size)
        Me.Button3.TabIndex = CType(resources.GetObject("Button3.TabIndex"), Integer)
        Me.Button3.Text = resources.GetString("Button3.Text")
        Me.Button3.TextAlign = CType(resources.GetObject("Button3.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Button3, resources.GetString("Button3.ToolTip"))
        Me.Button3.Visible = CType(resources.GetObject("Button3.Visible"), Boolean)
        '
        'tpTransfertData
        '
        Me.tpTransfertData.AccessibleDescription = resources.GetString("tpTransfertData.AccessibleDescription")
        Me.tpTransfertData.AccessibleName = resources.GetString("tpTransfertData.AccessibleName")
        Me.tpTransfertData.Anchor = CType(resources.GetObject("tpTransfertData.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tpTransfertData.AutoScroll = CType(resources.GetObject("tpTransfertData.AutoScroll"), Boolean)
        Me.tpTransfertData.AutoScrollMargin = CType(resources.GetObject("tpTransfertData.AutoScrollMargin"), System.Drawing.Size)
        Me.tpTransfertData.AutoScrollMinSize = CType(resources.GetObject("tpTransfertData.AutoScrollMinSize"), System.Drawing.Size)
        Me.tpTransfertData.BackgroundImage = CType(resources.GetObject("tpTransfertData.BackgroundImage"), System.Drawing.Image)
        Me.tpTransfertData.Controls.Add(Me.Panel9)
        Me.tpTransfertData.Dock = CType(resources.GetObject("tpTransfertData.Dock"), System.Windows.Forms.DockStyle)
        Me.tpTransfertData.Enabled = CType(resources.GetObject("tpTransfertData.Enabled"), Boolean)
        Me.tpTransfertData.Font = CType(resources.GetObject("tpTransfertData.Font"), System.Drawing.Font)
        Me.tpTransfertData.ImageIndex = CType(resources.GetObject("tpTransfertData.ImageIndex"), Integer)
        Me.tpTransfertData.ImeMode = CType(resources.GetObject("tpTransfertData.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tpTransfertData.Location = CType(resources.GetObject("tpTransfertData.Location"), System.Drawing.Point)
        Me.tpTransfertData.Name = "tpTransfertData"
        Me.tpTransfertData.RightToLeft = CType(resources.GetObject("tpTransfertData.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tpTransfertData.Size = CType(resources.GetObject("tpTransfertData.Size"), System.Drawing.Size)
        Me.tpTransfertData.TabIndex = CType(resources.GetObject("tpTransfertData.TabIndex"), Integer)
        Me.tpTransfertData.Text = resources.GetString("tpTransfertData.Text")
        Me.ToolTip1.SetToolTip(Me.tpTransfertData, resources.GetString("tpTransfertData.ToolTip"))
        Me.tpTransfertData.ToolTipText = resources.GetString("tpTransfertData.ToolTipText")
        Me.tpTransfertData.Visible = CType(resources.GetObject("tpTransfertData.Visible"), Boolean)
        '
        'Panel9
        '
        Me.Panel9.AccessibleDescription = resources.GetString("Panel9.AccessibleDescription")
        Me.Panel9.AccessibleName = resources.GetString("Panel9.AccessibleName")
        Me.Panel9.Anchor = CType(resources.GetObject("Panel9.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel9.AutoScroll = CType(resources.GetObject("Panel9.AutoScroll"), Boolean)
        Me.Panel9.AutoScrollMargin = CType(resources.GetObject("Panel9.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel9.AutoScrollMinSize = CType(resources.GetObject("Panel9.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel9.BackgroundImage = CType(resources.GetObject("Panel9.BackgroundImage"), System.Drawing.Image)
        Me.Panel9.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Panel9.Controls.Add(Me.LabelBox1)
        Me.Panel9.Controls.Add(Me.Button4)
        Me.Panel9.Controls.Add(Me.Label7)
        Me.Panel9.Dock = CType(resources.GetObject("Panel9.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel9.Enabled = CType(resources.GetObject("Panel9.Enabled"), Boolean)
        Me.Panel9.Font = CType(resources.GetObject("Panel9.Font"), System.Drawing.Font)
        Me.Panel9.ImeMode = CType(resources.GetObject("Panel9.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel9.Location = CType(resources.GetObject("Panel9.Location"), System.Drawing.Point)
        Me.Panel9.Name = "Panel9"
        Me.Panel9.RightToLeft = CType(resources.GetObject("Panel9.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel9.Size = CType(resources.GetObject("Panel9.Size"), System.Drawing.Size)
        Me.Panel9.TabIndex = CType(resources.GetObject("Panel9.TabIndex"), Integer)
        Me.Panel9.Text = resources.GetString("Panel9.Text")
        Me.ToolTip1.SetToolTip(Me.Panel9, resources.GetString("Panel9.ToolTip"))
        Me.Panel9.Visible = CType(resources.GetObject("Panel9.Visible"), Boolean)
        '
        'Label7
        '
        Me.Label7.AccessibleDescription = resources.GetString("Label7.AccessibleDescription")
        Me.Label7.AccessibleName = resources.GetString("Label7.AccessibleName")
        Me.Label7.Anchor = CType(resources.GetObject("Label7.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label7.AutoSize = CType(resources.GetObject("Label7.AutoSize"), Boolean)
        Me.Label7.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label7.Dock = CType(resources.GetObject("Label7.Dock"), System.Windows.Forms.DockStyle)
        Me.Label7.Enabled = CType(resources.GetObject("Label7.Enabled"), Boolean)
        Me.Label7.Font = CType(resources.GetObject("Label7.Font"), System.Drawing.Font)
        Me.Label7.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label7.Image = CType(resources.GetObject("Label7.Image"), System.Drawing.Image)
        Me.Label7.ImageAlign = CType(resources.GetObject("Label7.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label7.ImageIndex = CType(resources.GetObject("Label7.ImageIndex"), Integer)
        Me.Label7.ImeMode = CType(resources.GetObject("Label7.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label7.Location = CType(resources.GetObject("Label7.Location"), System.Drawing.Point)
        Me.Label7.Name = "Label7"
        Me.Label7.RightToLeft = CType(resources.GetObject("Label7.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label7.Size = CType(resources.GetObject("Label7.Size"), System.Drawing.Size)
        Me.Label7.TabIndex = CType(resources.GetObject("Label7.TabIndex"), Integer)
        Me.Label7.Text = resources.GetString("Label7.Text")
        Me.Label7.TextAlign = CType(resources.GetObject("Label7.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label7, resources.GetString("Label7.ToolTip"))
        Me.Label7.Visible = CType(resources.GetObject("Label7.Visible"), Boolean)
        '
        'Button4
        '
        Me.Button4.AccessibleDescription = resources.GetString("Button4.AccessibleDescription")
        Me.Button4.AccessibleName = resources.GetString("Button4.AccessibleName")
        Me.Button4.Anchor = CType(resources.GetObject("Button4.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button4.BackgroundImage = CType(resources.GetObject("Button4.BackgroundImage"), System.Drawing.Image)
        Me.Button4.Dock = CType(resources.GetObject("Button4.Dock"), System.Windows.Forms.DockStyle)
        Me.Button4.Enabled = CType(resources.GetObject("Button4.Enabled"), Boolean)
        Me.Button4.FlatStyle = CType(resources.GetObject("Button4.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.Button4.Font = CType(resources.GetObject("Button4.Font"), System.Drawing.Font)
        Me.Button4.Image = CType(resources.GetObject("Button4.Image"), System.Drawing.Image)
        Me.Button4.ImageAlign = CType(resources.GetObject("Button4.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Button4.ImageIndex = CType(resources.GetObject("Button4.ImageIndex"), Integer)
        Me.Button4.ImeMode = CType(resources.GetObject("Button4.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Button4.Location = CType(resources.GetObject("Button4.Location"), System.Drawing.Point)
        Me.Button4.Name = "Button4"
        Me.Button4.RightToLeft = CType(resources.GetObject("Button4.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Button4.Size = CType(resources.GetObject("Button4.Size"), System.Drawing.Size)
        Me.Button4.TabIndex = CType(resources.GetObject("Button4.TabIndex"), Integer)
        Me.Button4.Text = resources.GetString("Button4.Text")
        Me.Button4.TextAlign = CType(resources.GetObject("Button4.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Button4, resources.GetString("Button4.ToolTip"))
        Me.Button4.Visible = CType(resources.GetObject("Button4.Visible"), Boolean)
        '
        'LabelBox1
        '
        Me.LabelBox1.AccessibleDescription = resources.GetString("LabelBox1.AccessibleDescription")
        Me.LabelBox1.AccessibleName = resources.GetString("LabelBox1.AccessibleName")
        Me.LabelBox1.Anchor = CType(resources.GetObject("LabelBox1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.LabelBox1.AutoScroll = CType(resources.GetObject("LabelBox1.AutoScroll"), Boolean)
        Me.LabelBox1.AutoScrollMargin = CType(resources.GetObject("LabelBox1.AutoScrollMargin"), System.Drawing.Size)
        Me.LabelBox1.AutoScrollMinSize = CType(resources.GetObject("LabelBox1.AutoScrollMinSize"), System.Drawing.Size)
        Me.LabelBox1.BackgroundImage = CType(resources.GetObject("LabelBox1.BackgroundImage"), System.Drawing.Image)
        Me.LabelBox1.Caption = "Search"
        Me.LabelBox1.CaptionWidth = 50
        Me.LabelBox1.Dock = CType(resources.GetObject("LabelBox1.Dock"), System.Windows.Forms.DockStyle)
        Me.LabelBox1.Enabled = CType(resources.GetObject("LabelBox1.Enabled"), Boolean)
        Me.LabelBox1.Font = CType(resources.GetObject("LabelBox1.Font"), System.Drawing.Font)
        Me.LabelBox1.ImeMode = CType(resources.GetObject("LabelBox1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.LabelBox1.Location = CType(resources.GetObject("LabelBox1.Location"), System.Drawing.Point)
        Me.LabelBox1.Name = "LabelBox1"
        Me.LabelBox1.ReadOnly = False
        Me.LabelBox1.RightToLeft = CType(resources.GetObject("LabelBox1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.LabelBox1.Size = CType(resources.GetObject("LabelBox1.Size"), System.Drawing.Size)
        Me.LabelBox1.TabIndex = CType(resources.GetObject("LabelBox1.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.LabelBox1, resources.GetString("LabelBox1.ToolTip"))
        Me.LabelBox1.Value = ""
        Me.LabelBox1.Visible = CType(resources.GetObject("LabelBox1.Visible"), Boolean)
        '
        'PlayerFrm
        '
        Me.AccessibleDescription = resources.GetString("$this.AccessibleDescription")
        Me.AccessibleName = resources.GetString("$this.AccessibleName")
        Me.AutoScaleBaseSize = CType(resources.GetObject("$this.AutoScaleBaseSize"), System.Drawing.Size)
        Me.AutoScroll = CType(resources.GetObject("$this.AutoScroll"), Boolean)
        Me.AutoScrollMargin = CType(resources.GetObject("$this.AutoScrollMargin"), System.Drawing.Size)
        Me.AutoScrollMinSize = CType(resources.GetObject("$this.AutoScrollMinSize"), System.Drawing.Size)
        Me.BackgroundImage = CType(resources.GetObject("$this.BackgroundImage"), System.Drawing.Image)
        Me.ClientSize = CType(resources.GetObject("$this.ClientSize"), System.Drawing.Size)
        Me.Controls.Add(Me.TabControl1)
        Me.Controls.Add(Me.Panel1)
        Me.Enabled = CType(resources.GetObject("$this.Enabled"), Boolean)
        Me.Font = CType(resources.GetObject("$this.Font"), System.Drawing.Font)
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.ImeMode = CType(resources.GetObject("$this.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Location = CType(resources.GetObject("$this.Location"), System.Drawing.Point)
        Me.MaximumSize = CType(resources.GetObject("$this.MaximumSize"), System.Drawing.Size)
        Me.MinimumSize = CType(resources.GetObject("$this.MinimumSize"), System.Drawing.Size)
        Me.Name = "PlayerFrm"
        Me.RightToLeft = CType(resources.GetObject("$this.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.StartPosition = CType(resources.GetObject("$this.StartPosition"), System.Windows.Forms.FormStartPosition)
        Me.Text = resources.GetString("$this.Text")
        Me.ToolTip1.SetToolTip(Me, resources.GetString("$this.ToolTip"))
        Me.Panel1.ResumeLayout(False)
        Me.TabControl1.ResumeLayout(False)
        Me.tpPlayerInfo.ResumeLayout(False)
        Me.Panel3.ResumeLayout(False)
        Me.TabControl2.ResumeLayout(False)
        Me.tpNotes.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.tpStats.ResumeLayout(False)
        CType(Me.dgStatistics, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel4.ResumeLayout(False)
        Me.tpPlanets.ResumeLayout(False)
        Me.Panel8.ResumeLayout(False)
        Me.panPlanetAttackReports.ResumeLayout(False)
        Me.panPlanetSpyReport.ResumeLayout(False)
        Me.panPlanetSpyReportDown.ResumeLayout(False)
        Me.Panel7.ResumeLayout(False)
        Me.panPlanetPlanet.ResumeLayout(False)
        Me.Panel5.ResumeLayout(False)
        Me.tpGraphicStats.ResumeLayout(False)
        Me.Panel6.ResumeLayout(False)
        Me.tpTransfertData.ResumeLayout(False)
        Me.Panel9.ResumeLayout(False)
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
            btnSave.Enabled = True
            If pPlayer Is Nothing Then
                resetData()
                btnSave.Enabled = False
                Return
            End If

            tbID.Text = pPlayer.ID
            tbname.Text = pPlayer.Name
            Me.Text = "Player window for " & pPlayer.Name & " [ " & pPlayer.Alliance & " ]"
            tbAlly.Text = pPlayer.Alliance
            tbMainPlanet.Text = pPlayer.MainPlanetCoords
            tbNote.Text = pPlayer.Note
            chkShortInactive.Checked = pPlayer.ShortInactive
            chkLongInactive.Checked = pPlayer.LongInactive
            chkBlocked.Checked = pPlayer.Blocked
            chkNoob.Checked = pPlayer.Noob
            chkVacation.Checked = pPlayer.Vacancy

        End Set
    End Property

    Public Sub resetData()
        tbID.Text = ""
        tbAlly.Text = ""
        tbname.Text = ""
        chkLongInactive.Checked = False
        chkNoob.Checked = False
        chkShortInactive.Checked = False
        chkVacation.Checked = False
        chkBlocked.Checked = False
        tbMainPlanet.Text = ""
        tbNote.Text = ""
    End Sub
    Public Sub ApplyDataToPlayer()
        If Player Is Nothing Then Return
        With Player
            .Name = tbname.Text
            .Alliance = tbAlly.Text
            .Note = tbNote.Text
            .ShortInactive = chkShortInactive.Checked
            .LongInactive = chkLongInactive.Checked
            .MainPlanetCoords = tbMainPlanet.Text
            .Blocked = chkBlocked.Checked
            .Vacancy = chkVacation.Checked
            .Noob = chkNoob.Checked
        End With
    End Sub
    Private Sub btnCancel_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnCancel.Click
        Me.DialogResult = Windows.Forms.DialogResult.Cancel
        Me.Close()
    End Sub

    Private Sub btnSave_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSave.Click
        If Not Player Is Nothing Then
            ApplyDataToPlayer()
            Player.UpdateInsertandGetID()
            Me.DialogResult = Windows.Forms.DialogResult.OK
            Me.Close()
        Else
            MessageBox.Show("Zarbi , normalement tu dois pas pouvoir appuyer sur ce bouton....")
        End If
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        Dim request As String = "SELECT PR.DATADATE,PR.RANK," & _
"   P.NAME,P.ALLIANCE," & _
"   PR.POINTS," & _
"   PF.RANK as FlotteRank,PF.POINTS as FlottePoints," & _
"   PS.RANK as SearchRank,PS.Points as SearchPoints" & _
"    FROM PLAYERSRANK PR" & _
"    LEFT JOIN PLAYERS P ON P.ID=PR.PLAYER_ID" & _
"    LEFT JOIN PLAYERSFLOTTE PF ON (PF.PLAYER_ID=PR.PLAYER_ID AND PF.DATADATE=PR.DATADATE)" & _
"    LEFT JOIN PLAYERSRESEARCH PS ON (PS.PLAYER_ID=PR.PLAYER_ID AND PS.DATADATE=PR.DATADATE)" & _
"WHERE PR.PLAYER_ID = '" & Player.ID & "'" & _
"ORDER BY PR.DATADATE DESC"
        dgStatistics.SetDataBinding(OGameObject.OGameDBEngine.Default.SQLCommand(request), "")
    End Sub


    'Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click


    '    With ZedGraphControl1.GraphPane
    '        .PaneFill = New ZedGraph.Fill(Color.Black)
    '        .FontSpec.FontColor = Color.Gold
    '        .Title = "Evolution Statistique de " & Player.Name

    '        Dim listGlobal As New ZedGraph.PointPairList
    '        Dim ListFlotte As New ZedGraph.PointPairList
    '        Dim ListResearch As New ZedGraph.PointPairList
    '        Dim request As String = "SELECT PR.DATADATE,PR.RANK," & _
    '"   P.NAME,P.ALLIANCE," & _
    '"   PR.POINTS," & _
    '"   PF.RANK as FlotteRank,PF.POINTS as FlottePoints," & _
    '"   PS.RANK as SearchRank,PS.Points as SearchPoints" & _
    '"    FROM PLAYERSRANK PR" & _
    '"    LEFT JOIN PLAYERS P ON P.ID=PR.PLAYER_ID" & _
    '"    LEFT JOIN PLAYERSFLOTTE PF ON (PF.PLAYER_ID=PR.PLAYER_ID AND PF.DATADATE=PR.DATADATE)" & _
    '"    LEFT JOIN PLAYERSRESEARCH PS ON (PS.PLAYER_ID=PR.PLAYER_ID AND PS.DATADATE=PR.DATADATE)" & _
    '"WHERE PR.PLAYER_ID = '" & Player.ID & "'" & _
    '"ORDER BY PR.DATADATE ASC"
    '        For Each dr As DataRow In OGameObject.OGameDBEngine.Default.SQLCommand(request).Rows
    '            Dim xd As New ZedGraph.XDate(CDate(dr("DATADATE")))
    '            If Not dr("POINTS") Is DBNull.Value Then
    '                listGlobal.Add(xd.XLDate, CDbl(dr("POINTS")))
    '            End If
    '            If Not dr("FlottePoints") Is DBNull.Value Then
    '                ListFlotte.Add(xd.XLDate, CDbl(dr("FlottePoints")))
    '            End If
    '            If Not dr("SearchPoints") Is DBNull.Value Then
    '                ListResearch.Add(xd.XLDate, CDbl(dr("SearchPoints")))
    '            End If
    '        Next
    '        .XAxis.Title = "Date des statistiques"
    '        .XAxis.IsShowGrid = True
    '        .AxisFill = New ZedGraph.Fill(Color.White, Color.SteelBlue, 45.0F)
    '        .XAxis.Color = Color.White
    '        .XAxis.ScaleFontSpec.FontColor = Color.White
    '        .XAxis.TitleFontSpec.FontColor = Color.White

    '        .YAxis.Title = "Points globaux"
    '        .YAxis.Color = Color.LightGreen
    '        .YAxis.ScaleFontSpec.FontColor = Color.LightGreen
    '        .YAxis.TitleFontSpec.FontColor = Color.LightGreen

    '        .Y2Axis.Title = "Points Flotte"
    '        .Y2Axis.IsVisible = True
    '        .Y2Axis.Color = Color.LightSalmon
    '        .Y2Axis.ScaleFontSpec.FontColor = Color.LightSalmon
    '        .Y2Axis.TitleFontSpec.FontColor = Color.LightSalmon

    '        Dim mycurve As ZedGraph.LineItem
    '        mycurve = .AddCurve("Global", listGlobal, Color.Green)
    '        mycurve.Line.Width = 1.5F
    '        mycurve.Line.IsSmooth = True
    '        mycurve.Line.SmoothTension = 0.5F
    '        'mycurve.Line.Fill = New ZedGraph.Fill(Color.White, Color.FromArgb(60, 190, 50), 90.0F)
    '        mycurve.Line.StepType = ZedGraph.StepType.ForwardStep

    '        mycurve = .AddCurve("Flotte", ListFlotte, Color.Red, ZedGraph.SymbolType.Circle)
    '        mycurve.IsY2Axis = True

    '        mycurve = .AddCurve("Recherche", ListResearch, Color.Blue, ZedGraph.SymbolType.Diamond)

    '        'mycurve.IsY2Axis = True
    '        mycurve.YAxisIndex = 1
    '        Dim YAxis3 As New ZedGraph.YAxis("Recherche")
    '        YAxis3.Color = Color.LightBlue
    '        YAxis3.ScaleFontSpec.FontColor = Color.LightBlue
    '        YAxis3.TitleFontSpec.FontColor = Color.LightBlue

    '        .YAxisList.Add(YAxis3)
    '        'YAxis3.ScaleFormatAuto = True
    '        'YAxis3.ScaleMagAuto = True
    '        'YAxis3.MinAuto = True
    '        'YAxis3.MaxAuto = True

    '        .XAxis.Type = ZedGraph.AxisType.Date
    '        .AxisChange(CreateGraphics())
    '    End With


    '    ZedGraphControl1.Invalidate()
    'End Sub

    Private Sub PlayerFrm_Paint(ByVal sender As Object, ByVal e As System.Windows.Forms.PaintEventArgs) Handles MyBase.Paint
        '        ZedGraphControl1.GraphPane.Draw(e.Graphics)
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        OgsPlayerStatsGraph1.GraphType = OGSPlayerStatsGraph.StatsGraphType.Points
        OgsPlayerStatsGraph1.Player = Player
        OgsPlayerStatsGraph1.ShowStats()
    End Sub

    Private Sub btnShowPlanets_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnShowPlanets.Click
        If Player Is Nothing Then Return
        lbPlanets.Items.Clear() ' nettoyage de la liste avant de remettre les objets
        For Each p As OGameObject.Planet In Player.Planets
            p.ToStringFormat = OGameObject.Planet.enToStringFormat.CoordsName
            lbPlanets.Items.Add(p)
        Next
    End Sub


    Private Sub lbPlanets_SelectedIndexChanged_1(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbPlanets.SelectedIndexChanged

        lbPlanetSpyReport.Items.Clear()
        lbPlanetAttacks.Items.Clear()
        rtbPlanetReport.Text = ""

        btnPlanetDelete.Enabled = Not lbPlanets.SelectedItem Is Nothing
        btnPlanetCopy.Enabled = btnPlanetDelete.Enabled

        If lbPlanets.SelectedItem Is Nothing Then
            Return
        End If

        Dim selectedPlanet As OGameObject.Planet = lbPlanets.SelectedItem

        For Each spr As OGameObject.SpyReport In selectedPlanet.SpyingReports
            spr.ToStringType = OGameObject.SpyReport.enToStringType.DescDatePlayerName
            lbPlanetSpyReport.Items.Add(spr)
        Next

        For Each attack As OGameObject.AttackReport In selectedPlanet.AttackReports
            lbPlanetAttacks.Items.Add(attack)
        Next
    End Sub

    Private Sub lbPlanetSpyReport_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbPlanetSpyReport.SelectedIndexChanged
        rtbPlanetReport.Text = ""
        btnSpyDelete.Enabled = Not lbPlanetSpyReport.SelectedItem Is Nothing
        btnSpyCopy.Enabled = btnSpyDelete.Enabled

        If lbPlanetSpyReport.SelectedItem Is Nothing Then
            Return
        End If

        rtbPlanetReport.Text = CType(lbPlanetSpyReport.SelectedItem, OGameObject.SpyReport).RawReport

    End Sub

    Private Sub lbPlanetAttacks_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbPlanetAttacks.SelectedIndexChanged
        rtbPlanetReport.Text = ""
        btnAttackDelete.Enabled = Not lbPlanetAttacks.SelectedItem Is Nothing
        btnAttackCopy.Enabled = btnAttackDelete.Enabled

        If lbPlanetAttacks.SelectedItem Is Nothing Then
            Return
        End If

        rtbPlanetReport.Text = CType(lbPlanetAttacks.SelectedItem, OGameObject.AttackReport).RawReport

    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        OgsPlayerStatsGraph1.GraphType = OGSPlayerStatsGraph.StatsGraphType.Rank
        OgsPlayerStatsGraph1.Player = Player
        OgsPlayerStatsGraph1.ShowStats()
    End Sub
End Class
