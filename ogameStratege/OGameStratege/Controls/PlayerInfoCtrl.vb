Public Class PlayerInfoCtrl
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
    Friend WithEvents tpGlobalInfo As System.Windows.Forms.TabPage
    Friend WithEvents panDown As System.Windows.Forms.Panel
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents tbNameAlliance As System.Windows.Forms.TextBox
    Friend WithEvents lvStats As System.Windows.Forms.ListView
    Friend WithEvents chType As System.Windows.Forms.ColumnHeader
    Friend WithEvents chRank As System.Windows.Forms.ColumnHeader
    Friend WithEvents chPoints As System.Windows.Forms.ColumnHeader
    Friend WithEvents lbKnownTechno As System.Windows.Forms.Label
    Friend WithEvents lbStats As System.Windows.Forms.Label
    Friend WithEvents panTechno As System.Windows.Forms.Panel
    Friend WithEvents labelx As System.Windows.Forms.Label
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents Label8 As System.Windows.Forms.Label
    Friend WithEvents TextBox7 As System.Windows.Forms.TextBox
    Friend WithEvents Label9 As System.Windows.Forms.Label
    Friend WithEvents Label10 As System.Windows.Forms.Label
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents lbPlanets As System.Windows.Forms.ListBox
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents lbT_Date As System.Windows.Forms.Label
    Friend WithEvents tbT_Weapon As System.Windows.Forms.TextBox
    Friend WithEvents tbT_Combustion As System.Windows.Forms.TextBox
    Friend WithEvents tbT_Shield As System.Windows.Forms.TextBox
    Friend WithEvents tbT_Hyperspace As System.Windows.Forms.TextBox
    Friend WithEvents tbT_Armor As System.Windows.Forms.TextBox
    Friend WithEvents tbT_Impulsion As System.Windows.Forms.TextBox
    Friend WithEvents tbT_Graviton As System.Windows.Forms.TextBox
    Friend WithEvents chdate As System.Windows.Forms.ColumnHeader
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents rtbPlayerNote As System.Windows.Forms.RichTextBox
    Friend WithEvents btnSave As System.Windows.Forms.Button
    Friend WithEvents tpModify As System.Windows.Forms.TabPage
    Friend WithEvents GroupBox1 As System.Windows.Forms.GroupBox
    Friend WithEvents GroupBox2 As System.Windows.Forms.GroupBox
    Friend WithEvents btnGetFrom As System.Windows.Forms.Button
    Friend WithEvents btnSelectGetFrom As System.Windows.Forms.Button
    Friend WithEvents btnMoveData As System.Windows.Forms.Button
    Friend WithEvents btnSelectTransfertTo As System.Windows.Forms.Button
    Friend WithEvents lbbNewPlayerId As OGameStratege.LabelBox
    Friend WithEvents tbNewPlayerInfo As System.Windows.Forms.TextBox
    Friend WithEvents tbGetFromPlayerInfo As System.Windows.Forms.TextBox
    Friend WithEvents lbbGetFromId As OGameStratege.LabelBox

    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(PlayerInfoCtrl))
        Me.panMain = New System.Windows.Forms.Panel
        Me.TabControl1 = New System.Windows.Forms.TabControl
        Me.tpGlobalInfo = New System.Windows.Forms.TabPage
        Me.btnSave = New System.Windows.Forms.Button
        Me.rtbPlayerNote = New System.Windows.Forms.RichTextBox
        Me.Label2 = New System.Windows.Forms.Label
        Me.lbPlanets = New System.Windows.Forms.ListBox
        Me.Label3 = New System.Windows.Forms.Label
        Me.panTechno = New System.Windows.Forms.Panel
        Me.tbT_Weapon = New System.Windows.Forms.TextBox
        Me.labelx = New System.Windows.Forms.Label
        Me.lbT_Date = New System.Windows.Forms.Label
        Me.tbT_Combustion = New System.Windows.Forms.TextBox
        Me.Label4 = New System.Windows.Forms.Label
        Me.Label5 = New System.Windows.Forms.Label
        Me.tbT_Shield = New System.Windows.Forms.TextBox
        Me.tbT_Hyperspace = New System.Windows.Forms.TextBox
        Me.Label6 = New System.Windows.Forms.Label
        Me.Label7 = New System.Windows.Forms.Label
        Me.tbT_Armor = New System.Windows.Forms.TextBox
        Me.tbT_Impulsion = New System.Windows.Forms.TextBox
        Me.Label8 = New System.Windows.Forms.Label
        Me.TextBox7 = New System.Windows.Forms.TextBox
        Me.Label9 = New System.Windows.Forms.Label
        Me.tbT_Graviton = New System.Windows.Forms.TextBox
        Me.Label10 = New System.Windows.Forms.Label
        Me.lbKnownTechno = New System.Windows.Forms.Label
        Me.lvStats = New System.Windows.Forms.ListView
        Me.chType = New System.Windows.Forms.ColumnHeader
        Me.chRank = New System.Windows.Forms.ColumnHeader
        Me.chPoints = New System.Windows.Forms.ColumnHeader
        Me.chdate = New System.Windows.Forms.ColumnHeader
        Me.lbStats = New System.Windows.Forms.Label
        Me.tbNameAlliance = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.tpModify = New System.Windows.Forms.TabPage
        Me.GroupBox2 = New System.Windows.Forms.GroupBox
        Me.btnGetFrom = New System.Windows.Forms.Button
        Me.tbGetFromPlayerInfo = New System.Windows.Forms.TextBox
        Me.btnSelectGetFrom = New System.Windows.Forms.Button
        Me.lbbGetFromId = New OGameStratege.LabelBox
        Me.GroupBox1 = New System.Windows.Forms.GroupBox
        Me.btnMoveData = New System.Windows.Forms.Button
        Me.tbNewPlayerInfo = New System.Windows.Forms.TextBox
        Me.btnSelectTransfertTo = New System.Windows.Forms.Button
        Me.lbbNewPlayerId = New OGameStratege.LabelBox
        Me.panDown = New System.Windows.Forms.Panel
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.panMain.SuspendLayout()
        Me.TabControl1.SuspendLayout()
        Me.tpGlobalInfo.SuspendLayout()
        Me.panTechno.SuspendLayout()
        Me.tpModify.SuspendLayout()
        Me.GroupBox2.SuspendLayout()
        Me.GroupBox1.SuspendLayout()
        Me.SuspendLayout()
        '
        'panMain
        '
        Me.panMain.AccessibleDescription = resources.GetString("panMain.AccessibleDescription")
        Me.panMain.AccessibleName = resources.GetString("panMain.AccessibleName")
        Me.panMain.Anchor = CType(resources.GetObject("panMain.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.panMain.AutoScroll = CType(resources.GetObject("panMain.AutoScroll"), Boolean)
        Me.panMain.AutoScrollMargin = CType(resources.GetObject("panMain.AutoScrollMargin"), System.Drawing.Size)
        Me.panMain.AutoScrollMinSize = CType(resources.GetObject("panMain.AutoScrollMinSize"), System.Drawing.Size)
        Me.panMain.BackgroundImage = CType(resources.GetObject("panMain.BackgroundImage"), System.Drawing.Image)
        Me.panMain.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panMain.Controls.Add(Me.TabControl1)
        Me.panMain.Controls.Add(Me.panDown)
        Me.panMain.Dock = CType(resources.GetObject("panMain.Dock"), System.Windows.Forms.DockStyle)
        Me.panMain.Enabled = CType(resources.GetObject("panMain.Enabled"), Boolean)
        Me.panMain.Font = CType(resources.GetObject("panMain.Font"), System.Drawing.Font)
        Me.panMain.ImeMode = CType(resources.GetObject("panMain.ImeMode"), System.Windows.Forms.ImeMode)
        Me.panMain.Location = CType(resources.GetObject("panMain.Location"), System.Drawing.Point)
        Me.panMain.Name = "panMain"
        Me.panMain.RightToLeft = CType(resources.GetObject("panMain.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.panMain.Size = CType(resources.GetObject("panMain.Size"), System.Drawing.Size)
        Me.panMain.TabIndex = CType(resources.GetObject("panMain.TabIndex"), Integer)
        Me.panMain.Text = resources.GetString("panMain.Text")
        Me.ToolTip1.SetToolTip(Me.panMain, resources.GetString("panMain.ToolTip"))
        Me.panMain.Visible = CType(resources.GetObject("panMain.Visible"), Boolean)
        '
        'TabControl1
        '
        Me.TabControl1.AccessibleDescription = resources.GetString("TabControl1.AccessibleDescription")
        Me.TabControl1.AccessibleName = resources.GetString("TabControl1.AccessibleName")
        Me.TabControl1.Alignment = CType(resources.GetObject("TabControl1.Alignment"), System.Windows.Forms.TabAlignment)
        Me.TabControl1.Anchor = CType(resources.GetObject("TabControl1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.TabControl1.Appearance = CType(resources.GetObject("TabControl1.Appearance"), System.Windows.Forms.TabAppearance)
        Me.TabControl1.BackgroundImage = CType(resources.GetObject("TabControl1.BackgroundImage"), System.Drawing.Image)
        Me.TabControl1.Controls.Add(Me.tpGlobalInfo)
        Me.TabControl1.Controls.Add(Me.tpModify)
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
        'tpGlobalInfo
        '
        Me.tpGlobalInfo.AccessibleDescription = resources.GetString("tpGlobalInfo.AccessibleDescription")
        Me.tpGlobalInfo.AccessibleName = resources.GetString("tpGlobalInfo.AccessibleName")
        Me.tpGlobalInfo.Anchor = CType(resources.GetObject("tpGlobalInfo.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tpGlobalInfo.AutoScroll = CType(resources.GetObject("tpGlobalInfo.AutoScroll"), Boolean)
        Me.tpGlobalInfo.AutoScrollMargin = CType(resources.GetObject("tpGlobalInfo.AutoScrollMargin"), System.Drawing.Size)
        Me.tpGlobalInfo.AutoScrollMinSize = CType(resources.GetObject("tpGlobalInfo.AutoScrollMinSize"), System.Drawing.Size)
        Me.tpGlobalInfo.BackgroundImage = CType(resources.GetObject("tpGlobalInfo.BackgroundImage"), System.Drawing.Image)
        Me.tpGlobalInfo.Controls.Add(Me.btnSave)
        Me.tpGlobalInfo.Controls.Add(Me.rtbPlayerNote)
        Me.tpGlobalInfo.Controls.Add(Me.Label2)
        Me.tpGlobalInfo.Controls.Add(Me.lbPlanets)
        Me.tpGlobalInfo.Controls.Add(Me.Label3)
        Me.tpGlobalInfo.Controls.Add(Me.panTechno)
        Me.tpGlobalInfo.Controls.Add(Me.lbKnownTechno)
        Me.tpGlobalInfo.Controls.Add(Me.lvStats)
        Me.tpGlobalInfo.Controls.Add(Me.lbStats)
        Me.tpGlobalInfo.Controls.Add(Me.tbNameAlliance)
        Me.tpGlobalInfo.Controls.Add(Me.Label1)
        Me.tpGlobalInfo.Dock = CType(resources.GetObject("tpGlobalInfo.Dock"), System.Windows.Forms.DockStyle)
        Me.tpGlobalInfo.Enabled = CType(resources.GetObject("tpGlobalInfo.Enabled"), Boolean)
        Me.tpGlobalInfo.Font = CType(resources.GetObject("tpGlobalInfo.Font"), System.Drawing.Font)
        Me.tpGlobalInfo.ImageIndex = CType(resources.GetObject("tpGlobalInfo.ImageIndex"), Integer)
        Me.tpGlobalInfo.ImeMode = CType(resources.GetObject("tpGlobalInfo.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tpGlobalInfo.Location = CType(resources.GetObject("tpGlobalInfo.Location"), System.Drawing.Point)
        Me.tpGlobalInfo.Name = "tpGlobalInfo"
        Me.tpGlobalInfo.RightToLeft = CType(resources.GetObject("tpGlobalInfo.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tpGlobalInfo.Size = CType(resources.GetObject("tpGlobalInfo.Size"), System.Drawing.Size)
        Me.tpGlobalInfo.TabIndex = CType(resources.GetObject("tpGlobalInfo.TabIndex"), Integer)
        Me.tpGlobalInfo.Text = resources.GetString("tpGlobalInfo.Text")
        Me.ToolTip1.SetToolTip(Me.tpGlobalInfo, resources.GetString("tpGlobalInfo.ToolTip"))
        Me.tpGlobalInfo.ToolTipText = resources.GetString("tpGlobalInfo.ToolTipText")
        Me.tpGlobalInfo.Visible = CType(resources.GetObject("tpGlobalInfo.Visible"), Boolean)
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
        'rtbPlayerNote
        '
        Me.rtbPlayerNote.AccessibleDescription = resources.GetString("rtbPlayerNote.AccessibleDescription")
        Me.rtbPlayerNote.AccessibleName = resources.GetString("rtbPlayerNote.AccessibleName")
        Me.rtbPlayerNote.Anchor = CType(resources.GetObject("rtbPlayerNote.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.rtbPlayerNote.AutoSize = CType(resources.GetObject("rtbPlayerNote.AutoSize"), Boolean)
        Me.rtbPlayerNote.BackColor = System.Drawing.SystemColors.Control
        Me.rtbPlayerNote.BackgroundImage = CType(resources.GetObject("rtbPlayerNote.BackgroundImage"), System.Drawing.Image)
        Me.rtbPlayerNote.BulletIndent = CType(resources.GetObject("rtbPlayerNote.BulletIndent"), Integer)
        Me.rtbPlayerNote.Dock = CType(resources.GetObject("rtbPlayerNote.Dock"), System.Windows.Forms.DockStyle)
        Me.rtbPlayerNote.Enabled = CType(resources.GetObject("rtbPlayerNote.Enabled"), Boolean)
        Me.rtbPlayerNote.Font = CType(resources.GetObject("rtbPlayerNote.Font"), System.Drawing.Font)
        Me.rtbPlayerNote.ForeColor = System.Drawing.SystemColors.ControlText
        Me.rtbPlayerNote.ImeMode = CType(resources.GetObject("rtbPlayerNote.ImeMode"), System.Windows.Forms.ImeMode)
        Me.rtbPlayerNote.Location = CType(resources.GetObject("rtbPlayerNote.Location"), System.Drawing.Point)
        Me.rtbPlayerNote.MaxLength = CType(resources.GetObject("rtbPlayerNote.MaxLength"), Integer)
        Me.rtbPlayerNote.Multiline = CType(resources.GetObject("rtbPlayerNote.Multiline"), Boolean)
        Me.rtbPlayerNote.Name = "rtbPlayerNote"
        Me.rtbPlayerNote.ReadOnly = True
        Me.rtbPlayerNote.RightMargin = CType(resources.GetObject("rtbPlayerNote.RightMargin"), Integer)
        Me.rtbPlayerNote.RightToLeft = CType(resources.GetObject("rtbPlayerNote.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.rtbPlayerNote.ScrollBars = CType(resources.GetObject("rtbPlayerNote.ScrollBars"), System.Windows.Forms.RichTextBoxScrollBars)
        Me.rtbPlayerNote.Size = CType(resources.GetObject("rtbPlayerNote.Size"), System.Drawing.Size)
        Me.rtbPlayerNote.TabIndex = CType(resources.GetObject("rtbPlayerNote.TabIndex"), Integer)
        Me.rtbPlayerNote.Text = resources.GetString("rtbPlayerNote.Text")
        Me.ToolTip1.SetToolTip(Me.rtbPlayerNote, resources.GetString("rtbPlayerNote.ToolTip"))
        Me.rtbPlayerNote.Visible = CType(resources.GetObject("rtbPlayerNote.Visible"), Boolean)
        Me.rtbPlayerNote.WordWrap = CType(resources.GetObject("rtbPlayerNote.WordWrap"), Boolean)
        Me.rtbPlayerNote.ZoomFactor = CType(resources.GetObject("rtbPlayerNote.ZoomFactor"), Single)
        '
        'Label2
        '
        Me.Label2.AccessibleDescription = resources.GetString("Label2.AccessibleDescription")
        Me.Label2.AccessibleName = resources.GetString("Label2.AccessibleName")
        Me.Label2.Anchor = CType(resources.GetObject("Label2.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label2.AutoSize = CType(resources.GetObject("Label2.AutoSize"), Boolean)
        Me.Label2.BackColor = System.Drawing.SystemColors.Highlight
        Me.Label2.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label2.Dock = CType(resources.GetObject("Label2.Dock"), System.Windows.Forms.DockStyle)
        Me.Label2.Enabled = CType(resources.GetObject("Label2.Enabled"), Boolean)
        Me.Label2.Font = CType(resources.GetObject("Label2.Font"), System.Drawing.Font)
        Me.Label2.ForeColor = System.Drawing.SystemColors.HighlightText
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
        Me.lbPlanets.Items.AddRange(New Object() {resources.GetString("lbPlanets.Items"), resources.GetString("lbPlanets.Items1"), resources.GetString("lbPlanets.Items2"), resources.GetString("lbPlanets.Items3"), resources.GetString("lbPlanets.Items4"), resources.GetString("lbPlanets.Items5"), resources.GetString("lbPlanets.Items6"), resources.GetString("lbPlanets.Items7"), resources.GetString("lbPlanets.Items8")})
        Me.lbPlanets.Location = CType(resources.GetObject("lbPlanets.Location"), System.Drawing.Point)
        Me.lbPlanets.Name = "lbPlanets"
        Me.lbPlanets.RightToLeft = CType(resources.GetObject("lbPlanets.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbPlanets.ScrollAlwaysVisible = CType(resources.GetObject("lbPlanets.ScrollAlwaysVisible"), Boolean)
        Me.lbPlanets.Size = CType(resources.GetObject("lbPlanets.Size"), System.Drawing.Size)
        Me.lbPlanets.TabIndex = CType(resources.GetObject("lbPlanets.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.lbPlanets, resources.GetString("lbPlanets.ToolTip"))
        Me.lbPlanets.Visible = CType(resources.GetObject("lbPlanets.Visible"), Boolean)
        '
        'Label3
        '
        Me.Label3.AccessibleDescription = resources.GetString("Label3.AccessibleDescription")
        Me.Label3.AccessibleName = resources.GetString("Label3.AccessibleName")
        Me.Label3.Anchor = CType(resources.GetObject("Label3.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label3.AutoSize = CType(resources.GetObject("Label3.AutoSize"), Boolean)
        Me.Label3.BackColor = System.Drawing.SystemColors.Highlight
        Me.Label3.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label3.Dock = CType(resources.GetObject("Label3.Dock"), System.Windows.Forms.DockStyle)
        Me.Label3.Enabled = CType(resources.GetObject("Label3.Enabled"), Boolean)
        Me.Label3.Font = CType(resources.GetObject("Label3.Font"), System.Drawing.Font)
        Me.Label3.ForeColor = System.Drawing.SystemColors.HighlightText
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
        'panTechno
        '
        Me.panTechno.AccessibleDescription = resources.GetString("panTechno.AccessibleDescription")
        Me.panTechno.AccessibleName = resources.GetString("panTechno.AccessibleName")
        Me.panTechno.Anchor = CType(resources.GetObject("panTechno.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.panTechno.AutoScroll = CType(resources.GetObject("panTechno.AutoScroll"), Boolean)
        Me.panTechno.AutoScrollMargin = CType(resources.GetObject("panTechno.AutoScrollMargin"), System.Drawing.Size)
        Me.panTechno.AutoScrollMinSize = CType(resources.GetObject("panTechno.AutoScrollMinSize"), System.Drawing.Size)
        Me.panTechno.BackgroundImage = CType(resources.GetObject("panTechno.BackgroundImage"), System.Drawing.Image)
        Me.panTechno.Controls.Add(Me.tbT_Weapon)
        Me.panTechno.Controls.Add(Me.labelx)
        Me.panTechno.Controls.Add(Me.lbT_Date)
        Me.panTechno.Controls.Add(Me.tbT_Combustion)
        Me.panTechno.Controls.Add(Me.Label4)
        Me.panTechno.Controls.Add(Me.Label5)
        Me.panTechno.Controls.Add(Me.tbT_Shield)
        Me.panTechno.Controls.Add(Me.tbT_Hyperspace)
        Me.panTechno.Controls.Add(Me.Label6)
        Me.panTechno.Controls.Add(Me.Label7)
        Me.panTechno.Controls.Add(Me.tbT_Armor)
        Me.panTechno.Controls.Add(Me.tbT_Impulsion)
        Me.panTechno.Controls.Add(Me.Label8)
        Me.panTechno.Controls.Add(Me.TextBox7)
        Me.panTechno.Controls.Add(Me.Label9)
        Me.panTechno.Controls.Add(Me.tbT_Graviton)
        Me.panTechno.Controls.Add(Me.Label10)
        Me.panTechno.Dock = CType(resources.GetObject("panTechno.Dock"), System.Windows.Forms.DockStyle)
        Me.panTechno.Enabled = CType(resources.GetObject("panTechno.Enabled"), Boolean)
        Me.panTechno.Font = CType(resources.GetObject("panTechno.Font"), System.Drawing.Font)
        Me.panTechno.ImeMode = CType(resources.GetObject("panTechno.ImeMode"), System.Windows.Forms.ImeMode)
        Me.panTechno.Location = CType(resources.GetObject("panTechno.Location"), System.Drawing.Point)
        Me.panTechno.Name = "panTechno"
        Me.panTechno.RightToLeft = CType(resources.GetObject("panTechno.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.panTechno.Size = CType(resources.GetObject("panTechno.Size"), System.Drawing.Size)
        Me.panTechno.TabIndex = CType(resources.GetObject("panTechno.TabIndex"), Integer)
        Me.panTechno.Text = resources.GetString("panTechno.Text")
        Me.ToolTip1.SetToolTip(Me.panTechno, resources.GetString("panTechno.ToolTip"))
        Me.panTechno.Visible = CType(resources.GetObject("panTechno.Visible"), Boolean)
        '
        'tbT_Weapon
        '
        Me.tbT_Weapon.AccessibleDescription = resources.GetString("tbT_Weapon.AccessibleDescription")
        Me.tbT_Weapon.AccessibleName = resources.GetString("tbT_Weapon.AccessibleName")
        Me.tbT_Weapon.Anchor = CType(resources.GetObject("tbT_Weapon.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbT_Weapon.AutoSize = CType(resources.GetObject("tbT_Weapon.AutoSize"), Boolean)
        Me.tbT_Weapon.BackgroundImage = CType(resources.GetObject("tbT_Weapon.BackgroundImage"), System.Drawing.Image)
        Me.tbT_Weapon.Dock = CType(resources.GetObject("tbT_Weapon.Dock"), System.Windows.Forms.DockStyle)
        Me.tbT_Weapon.Enabled = CType(resources.GetObject("tbT_Weapon.Enabled"), Boolean)
        Me.tbT_Weapon.Font = CType(resources.GetObject("tbT_Weapon.Font"), System.Drawing.Font)
        Me.tbT_Weapon.ImeMode = CType(resources.GetObject("tbT_Weapon.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbT_Weapon.Location = CType(resources.GetObject("tbT_Weapon.Location"), System.Drawing.Point)
        Me.tbT_Weapon.MaxLength = CType(resources.GetObject("tbT_Weapon.MaxLength"), Integer)
        Me.tbT_Weapon.Multiline = CType(resources.GetObject("tbT_Weapon.Multiline"), Boolean)
        Me.tbT_Weapon.Name = "tbT_Weapon"
        Me.tbT_Weapon.PasswordChar = CType(resources.GetObject("tbT_Weapon.PasswordChar"), Char)
        Me.tbT_Weapon.ReadOnly = True
        Me.tbT_Weapon.RightToLeft = CType(resources.GetObject("tbT_Weapon.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbT_Weapon.ScrollBars = CType(resources.GetObject("tbT_Weapon.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbT_Weapon.Size = CType(resources.GetObject("tbT_Weapon.Size"), System.Drawing.Size)
        Me.tbT_Weapon.TabIndex = CType(resources.GetObject("tbT_Weapon.TabIndex"), Integer)
        Me.tbT_Weapon.Text = resources.GetString("tbT_Weapon.Text")
        Me.tbT_Weapon.TextAlign = CType(resources.GetObject("tbT_Weapon.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbT_Weapon, resources.GetString("tbT_Weapon.ToolTip"))
        Me.tbT_Weapon.Visible = CType(resources.GetObject("tbT_Weapon.Visible"), Boolean)
        Me.tbT_Weapon.WordWrap = CType(resources.GetObject("tbT_Weapon.WordWrap"), Boolean)
        '
        'labelx
        '
        Me.labelx.AccessibleDescription = resources.GetString("labelx.AccessibleDescription")
        Me.labelx.AccessibleName = resources.GetString("labelx.AccessibleName")
        Me.labelx.Anchor = CType(resources.GetObject("labelx.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.labelx.AutoSize = CType(resources.GetObject("labelx.AutoSize"), Boolean)
        Me.labelx.Dock = CType(resources.GetObject("labelx.Dock"), System.Windows.Forms.DockStyle)
        Me.labelx.Enabled = CType(resources.GetObject("labelx.Enabled"), Boolean)
        Me.labelx.Font = CType(resources.GetObject("labelx.Font"), System.Drawing.Font)
        Me.labelx.Image = CType(resources.GetObject("labelx.Image"), System.Drawing.Image)
        Me.labelx.ImageAlign = CType(resources.GetObject("labelx.ImageAlign"), System.Drawing.ContentAlignment)
        Me.labelx.ImageIndex = CType(resources.GetObject("labelx.ImageIndex"), Integer)
        Me.labelx.ImeMode = CType(resources.GetObject("labelx.ImeMode"), System.Windows.Forms.ImeMode)
        Me.labelx.Location = CType(resources.GetObject("labelx.Location"), System.Drawing.Point)
        Me.labelx.Name = "labelx"
        Me.labelx.RightToLeft = CType(resources.GetObject("labelx.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.labelx.Size = CType(resources.GetObject("labelx.Size"), System.Drawing.Size)
        Me.labelx.TabIndex = CType(resources.GetObject("labelx.TabIndex"), Integer)
        Me.labelx.Text = resources.GetString("labelx.Text")
        Me.labelx.TextAlign = CType(resources.GetObject("labelx.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.labelx, resources.GetString("labelx.ToolTip"))
        Me.labelx.Visible = CType(resources.GetObject("labelx.Visible"), Boolean)
        '
        'lbT_Date
        '
        Me.lbT_Date.AccessibleDescription = resources.GetString("lbT_Date.AccessibleDescription")
        Me.lbT_Date.AccessibleName = resources.GetString("lbT_Date.AccessibleName")
        Me.lbT_Date.Anchor = CType(resources.GetObject("lbT_Date.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbT_Date.AutoSize = CType(resources.GetObject("lbT_Date.AutoSize"), Boolean)
        Me.lbT_Date.BackColor = System.Drawing.SystemColors.Info
        Me.lbT_Date.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.lbT_Date.Dock = CType(resources.GetObject("lbT_Date.Dock"), System.Windows.Forms.DockStyle)
        Me.lbT_Date.Enabled = CType(resources.GetObject("lbT_Date.Enabled"), Boolean)
        Me.lbT_Date.Font = CType(resources.GetObject("lbT_Date.Font"), System.Drawing.Font)
        Me.lbT_Date.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbT_Date.Image = CType(resources.GetObject("lbT_Date.Image"), System.Drawing.Image)
        Me.lbT_Date.ImageAlign = CType(resources.GetObject("lbT_Date.ImageAlign"), System.Drawing.ContentAlignment)
        Me.lbT_Date.ImageIndex = CType(resources.GetObject("lbT_Date.ImageIndex"), Integer)
        Me.lbT_Date.ImeMode = CType(resources.GetObject("lbT_Date.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbT_Date.Location = CType(resources.GetObject("lbT_Date.Location"), System.Drawing.Point)
        Me.lbT_Date.Name = "lbT_Date"
        Me.lbT_Date.RightToLeft = CType(resources.GetObject("lbT_Date.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbT_Date.Size = CType(resources.GetObject("lbT_Date.Size"), System.Drawing.Size)
        Me.lbT_Date.TabIndex = CType(resources.GetObject("lbT_Date.TabIndex"), Integer)
        Me.lbT_Date.Text = resources.GetString("lbT_Date.Text")
        Me.lbT_Date.TextAlign = CType(resources.GetObject("lbT_Date.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.lbT_Date, resources.GetString("lbT_Date.ToolTip"))
        Me.lbT_Date.Visible = CType(resources.GetObject("lbT_Date.Visible"), Boolean)
        '
        'tbT_Combustion
        '
        Me.tbT_Combustion.AccessibleDescription = resources.GetString("tbT_Combustion.AccessibleDescription")
        Me.tbT_Combustion.AccessibleName = resources.GetString("tbT_Combustion.AccessibleName")
        Me.tbT_Combustion.Anchor = CType(resources.GetObject("tbT_Combustion.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbT_Combustion.AutoSize = CType(resources.GetObject("tbT_Combustion.AutoSize"), Boolean)
        Me.tbT_Combustion.BackgroundImage = CType(resources.GetObject("tbT_Combustion.BackgroundImage"), System.Drawing.Image)
        Me.tbT_Combustion.Dock = CType(resources.GetObject("tbT_Combustion.Dock"), System.Windows.Forms.DockStyle)
        Me.tbT_Combustion.Enabled = CType(resources.GetObject("tbT_Combustion.Enabled"), Boolean)
        Me.tbT_Combustion.Font = CType(resources.GetObject("tbT_Combustion.Font"), System.Drawing.Font)
        Me.tbT_Combustion.ImeMode = CType(resources.GetObject("tbT_Combustion.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbT_Combustion.Location = CType(resources.GetObject("tbT_Combustion.Location"), System.Drawing.Point)
        Me.tbT_Combustion.MaxLength = CType(resources.GetObject("tbT_Combustion.MaxLength"), Integer)
        Me.tbT_Combustion.Multiline = CType(resources.GetObject("tbT_Combustion.Multiline"), Boolean)
        Me.tbT_Combustion.Name = "tbT_Combustion"
        Me.tbT_Combustion.PasswordChar = CType(resources.GetObject("tbT_Combustion.PasswordChar"), Char)
        Me.tbT_Combustion.ReadOnly = True
        Me.tbT_Combustion.RightToLeft = CType(resources.GetObject("tbT_Combustion.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbT_Combustion.ScrollBars = CType(resources.GetObject("tbT_Combustion.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbT_Combustion.Size = CType(resources.GetObject("tbT_Combustion.Size"), System.Drawing.Size)
        Me.tbT_Combustion.TabIndex = CType(resources.GetObject("tbT_Combustion.TabIndex"), Integer)
        Me.tbT_Combustion.Text = resources.GetString("tbT_Combustion.Text")
        Me.tbT_Combustion.TextAlign = CType(resources.GetObject("tbT_Combustion.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbT_Combustion, resources.GetString("tbT_Combustion.ToolTip"))
        Me.tbT_Combustion.Visible = CType(resources.GetObject("tbT_Combustion.Visible"), Boolean)
        Me.tbT_Combustion.WordWrap = CType(resources.GetObject("tbT_Combustion.WordWrap"), Boolean)
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
        'Label5
        '
        Me.Label5.AccessibleDescription = resources.GetString("Label5.AccessibleDescription")
        Me.Label5.AccessibleName = resources.GetString("Label5.AccessibleName")
        Me.Label5.Anchor = CType(resources.GetObject("Label5.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label5.AutoSize = CType(resources.GetObject("Label5.AutoSize"), Boolean)
        Me.Label5.Dock = CType(resources.GetObject("Label5.Dock"), System.Windows.Forms.DockStyle)
        Me.Label5.Enabled = CType(resources.GetObject("Label5.Enabled"), Boolean)
        Me.Label5.Font = CType(resources.GetObject("Label5.Font"), System.Drawing.Font)
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
        'tbT_Shield
        '
        Me.tbT_Shield.AccessibleDescription = resources.GetString("tbT_Shield.AccessibleDescription")
        Me.tbT_Shield.AccessibleName = resources.GetString("tbT_Shield.AccessibleName")
        Me.tbT_Shield.Anchor = CType(resources.GetObject("tbT_Shield.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbT_Shield.AutoSize = CType(resources.GetObject("tbT_Shield.AutoSize"), Boolean)
        Me.tbT_Shield.BackgroundImage = CType(resources.GetObject("tbT_Shield.BackgroundImage"), System.Drawing.Image)
        Me.tbT_Shield.Dock = CType(resources.GetObject("tbT_Shield.Dock"), System.Windows.Forms.DockStyle)
        Me.tbT_Shield.Enabled = CType(resources.GetObject("tbT_Shield.Enabled"), Boolean)
        Me.tbT_Shield.Font = CType(resources.GetObject("tbT_Shield.Font"), System.Drawing.Font)
        Me.tbT_Shield.ImeMode = CType(resources.GetObject("tbT_Shield.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbT_Shield.Location = CType(resources.GetObject("tbT_Shield.Location"), System.Drawing.Point)
        Me.tbT_Shield.MaxLength = CType(resources.GetObject("tbT_Shield.MaxLength"), Integer)
        Me.tbT_Shield.Multiline = CType(resources.GetObject("tbT_Shield.Multiline"), Boolean)
        Me.tbT_Shield.Name = "tbT_Shield"
        Me.tbT_Shield.PasswordChar = CType(resources.GetObject("tbT_Shield.PasswordChar"), Char)
        Me.tbT_Shield.ReadOnly = True
        Me.tbT_Shield.RightToLeft = CType(resources.GetObject("tbT_Shield.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbT_Shield.ScrollBars = CType(resources.GetObject("tbT_Shield.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbT_Shield.Size = CType(resources.GetObject("tbT_Shield.Size"), System.Drawing.Size)
        Me.tbT_Shield.TabIndex = CType(resources.GetObject("tbT_Shield.TabIndex"), Integer)
        Me.tbT_Shield.Text = resources.GetString("tbT_Shield.Text")
        Me.tbT_Shield.TextAlign = CType(resources.GetObject("tbT_Shield.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbT_Shield, resources.GetString("tbT_Shield.ToolTip"))
        Me.tbT_Shield.Visible = CType(resources.GetObject("tbT_Shield.Visible"), Boolean)
        Me.tbT_Shield.WordWrap = CType(resources.GetObject("tbT_Shield.WordWrap"), Boolean)
        '
        'tbT_Hyperspace
        '
        Me.tbT_Hyperspace.AccessibleDescription = resources.GetString("tbT_Hyperspace.AccessibleDescription")
        Me.tbT_Hyperspace.AccessibleName = resources.GetString("tbT_Hyperspace.AccessibleName")
        Me.tbT_Hyperspace.Anchor = CType(resources.GetObject("tbT_Hyperspace.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbT_Hyperspace.AutoSize = CType(resources.GetObject("tbT_Hyperspace.AutoSize"), Boolean)
        Me.tbT_Hyperspace.BackgroundImage = CType(resources.GetObject("tbT_Hyperspace.BackgroundImage"), System.Drawing.Image)
        Me.tbT_Hyperspace.Dock = CType(resources.GetObject("tbT_Hyperspace.Dock"), System.Windows.Forms.DockStyle)
        Me.tbT_Hyperspace.Enabled = CType(resources.GetObject("tbT_Hyperspace.Enabled"), Boolean)
        Me.tbT_Hyperspace.Font = CType(resources.GetObject("tbT_Hyperspace.Font"), System.Drawing.Font)
        Me.tbT_Hyperspace.ImeMode = CType(resources.GetObject("tbT_Hyperspace.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbT_Hyperspace.Location = CType(resources.GetObject("tbT_Hyperspace.Location"), System.Drawing.Point)
        Me.tbT_Hyperspace.MaxLength = CType(resources.GetObject("tbT_Hyperspace.MaxLength"), Integer)
        Me.tbT_Hyperspace.Multiline = CType(resources.GetObject("tbT_Hyperspace.Multiline"), Boolean)
        Me.tbT_Hyperspace.Name = "tbT_Hyperspace"
        Me.tbT_Hyperspace.PasswordChar = CType(resources.GetObject("tbT_Hyperspace.PasswordChar"), Char)
        Me.tbT_Hyperspace.ReadOnly = True
        Me.tbT_Hyperspace.RightToLeft = CType(resources.GetObject("tbT_Hyperspace.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbT_Hyperspace.ScrollBars = CType(resources.GetObject("tbT_Hyperspace.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbT_Hyperspace.Size = CType(resources.GetObject("tbT_Hyperspace.Size"), System.Drawing.Size)
        Me.tbT_Hyperspace.TabIndex = CType(resources.GetObject("tbT_Hyperspace.TabIndex"), Integer)
        Me.tbT_Hyperspace.Text = resources.GetString("tbT_Hyperspace.Text")
        Me.tbT_Hyperspace.TextAlign = CType(resources.GetObject("tbT_Hyperspace.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbT_Hyperspace, resources.GetString("tbT_Hyperspace.ToolTip"))
        Me.tbT_Hyperspace.Visible = CType(resources.GetObject("tbT_Hyperspace.Visible"), Boolean)
        Me.tbT_Hyperspace.WordWrap = CType(resources.GetObject("tbT_Hyperspace.WordWrap"), Boolean)
        '
        'Label6
        '
        Me.Label6.AccessibleDescription = resources.GetString("Label6.AccessibleDescription")
        Me.Label6.AccessibleName = resources.GetString("Label6.AccessibleName")
        Me.Label6.Anchor = CType(resources.GetObject("Label6.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label6.AutoSize = CType(resources.GetObject("Label6.AutoSize"), Boolean)
        Me.Label6.Dock = CType(resources.GetObject("Label6.Dock"), System.Windows.Forms.DockStyle)
        Me.Label6.Enabled = CType(resources.GetObject("Label6.Enabled"), Boolean)
        Me.Label6.Font = CType(resources.GetObject("Label6.Font"), System.Drawing.Font)
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
        'Label7
        '
        Me.Label7.AccessibleDescription = resources.GetString("Label7.AccessibleDescription")
        Me.Label7.AccessibleName = resources.GetString("Label7.AccessibleName")
        Me.Label7.Anchor = CType(resources.GetObject("Label7.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label7.AutoSize = CType(resources.GetObject("Label7.AutoSize"), Boolean)
        Me.Label7.Dock = CType(resources.GetObject("Label7.Dock"), System.Windows.Forms.DockStyle)
        Me.Label7.Enabled = CType(resources.GetObject("Label7.Enabled"), Boolean)
        Me.Label7.Font = CType(resources.GetObject("Label7.Font"), System.Drawing.Font)
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
        'tbT_Armor
        '
        Me.tbT_Armor.AccessibleDescription = resources.GetString("tbT_Armor.AccessibleDescription")
        Me.tbT_Armor.AccessibleName = resources.GetString("tbT_Armor.AccessibleName")
        Me.tbT_Armor.Anchor = CType(resources.GetObject("tbT_Armor.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbT_Armor.AutoSize = CType(resources.GetObject("tbT_Armor.AutoSize"), Boolean)
        Me.tbT_Armor.BackgroundImage = CType(resources.GetObject("tbT_Armor.BackgroundImage"), System.Drawing.Image)
        Me.tbT_Armor.Dock = CType(resources.GetObject("tbT_Armor.Dock"), System.Windows.Forms.DockStyle)
        Me.tbT_Armor.Enabled = CType(resources.GetObject("tbT_Armor.Enabled"), Boolean)
        Me.tbT_Armor.Font = CType(resources.GetObject("tbT_Armor.Font"), System.Drawing.Font)
        Me.tbT_Armor.ImeMode = CType(resources.GetObject("tbT_Armor.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbT_Armor.Location = CType(resources.GetObject("tbT_Armor.Location"), System.Drawing.Point)
        Me.tbT_Armor.MaxLength = CType(resources.GetObject("tbT_Armor.MaxLength"), Integer)
        Me.tbT_Armor.Multiline = CType(resources.GetObject("tbT_Armor.Multiline"), Boolean)
        Me.tbT_Armor.Name = "tbT_Armor"
        Me.tbT_Armor.PasswordChar = CType(resources.GetObject("tbT_Armor.PasswordChar"), Char)
        Me.tbT_Armor.ReadOnly = True
        Me.tbT_Armor.RightToLeft = CType(resources.GetObject("tbT_Armor.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbT_Armor.ScrollBars = CType(resources.GetObject("tbT_Armor.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbT_Armor.Size = CType(resources.GetObject("tbT_Armor.Size"), System.Drawing.Size)
        Me.tbT_Armor.TabIndex = CType(resources.GetObject("tbT_Armor.TabIndex"), Integer)
        Me.tbT_Armor.Text = resources.GetString("tbT_Armor.Text")
        Me.tbT_Armor.TextAlign = CType(resources.GetObject("tbT_Armor.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbT_Armor, resources.GetString("tbT_Armor.ToolTip"))
        Me.tbT_Armor.Visible = CType(resources.GetObject("tbT_Armor.Visible"), Boolean)
        Me.tbT_Armor.WordWrap = CType(resources.GetObject("tbT_Armor.WordWrap"), Boolean)
        '
        'tbT_Impulsion
        '
        Me.tbT_Impulsion.AccessibleDescription = resources.GetString("tbT_Impulsion.AccessibleDescription")
        Me.tbT_Impulsion.AccessibleName = resources.GetString("tbT_Impulsion.AccessibleName")
        Me.tbT_Impulsion.Anchor = CType(resources.GetObject("tbT_Impulsion.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbT_Impulsion.AutoSize = CType(resources.GetObject("tbT_Impulsion.AutoSize"), Boolean)
        Me.tbT_Impulsion.BackgroundImage = CType(resources.GetObject("tbT_Impulsion.BackgroundImage"), System.Drawing.Image)
        Me.tbT_Impulsion.Dock = CType(resources.GetObject("tbT_Impulsion.Dock"), System.Windows.Forms.DockStyle)
        Me.tbT_Impulsion.Enabled = CType(resources.GetObject("tbT_Impulsion.Enabled"), Boolean)
        Me.tbT_Impulsion.Font = CType(resources.GetObject("tbT_Impulsion.Font"), System.Drawing.Font)
        Me.tbT_Impulsion.ImeMode = CType(resources.GetObject("tbT_Impulsion.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbT_Impulsion.Location = CType(resources.GetObject("tbT_Impulsion.Location"), System.Drawing.Point)
        Me.tbT_Impulsion.MaxLength = CType(resources.GetObject("tbT_Impulsion.MaxLength"), Integer)
        Me.tbT_Impulsion.Multiline = CType(resources.GetObject("tbT_Impulsion.Multiline"), Boolean)
        Me.tbT_Impulsion.Name = "tbT_Impulsion"
        Me.tbT_Impulsion.PasswordChar = CType(resources.GetObject("tbT_Impulsion.PasswordChar"), Char)
        Me.tbT_Impulsion.ReadOnly = True
        Me.tbT_Impulsion.RightToLeft = CType(resources.GetObject("tbT_Impulsion.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbT_Impulsion.ScrollBars = CType(resources.GetObject("tbT_Impulsion.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbT_Impulsion.Size = CType(resources.GetObject("tbT_Impulsion.Size"), System.Drawing.Size)
        Me.tbT_Impulsion.TabIndex = CType(resources.GetObject("tbT_Impulsion.TabIndex"), Integer)
        Me.tbT_Impulsion.Text = resources.GetString("tbT_Impulsion.Text")
        Me.tbT_Impulsion.TextAlign = CType(resources.GetObject("tbT_Impulsion.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbT_Impulsion, resources.GetString("tbT_Impulsion.ToolTip"))
        Me.tbT_Impulsion.Visible = CType(resources.GetObject("tbT_Impulsion.Visible"), Boolean)
        Me.tbT_Impulsion.WordWrap = CType(resources.GetObject("tbT_Impulsion.WordWrap"), Boolean)
        '
        'Label8
        '
        Me.Label8.AccessibleDescription = resources.GetString("Label8.AccessibleDescription")
        Me.Label8.AccessibleName = resources.GetString("Label8.AccessibleName")
        Me.Label8.Anchor = CType(resources.GetObject("Label8.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label8.AutoSize = CType(resources.GetObject("Label8.AutoSize"), Boolean)
        Me.Label8.Dock = CType(resources.GetObject("Label8.Dock"), System.Windows.Forms.DockStyle)
        Me.Label8.Enabled = CType(resources.GetObject("Label8.Enabled"), Boolean)
        Me.Label8.Font = CType(resources.GetObject("Label8.Font"), System.Drawing.Font)
        Me.Label8.Image = CType(resources.GetObject("Label8.Image"), System.Drawing.Image)
        Me.Label8.ImageAlign = CType(resources.GetObject("Label8.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label8.ImageIndex = CType(resources.GetObject("Label8.ImageIndex"), Integer)
        Me.Label8.ImeMode = CType(resources.GetObject("Label8.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label8.Location = CType(resources.GetObject("Label8.Location"), System.Drawing.Point)
        Me.Label8.Name = "Label8"
        Me.Label8.RightToLeft = CType(resources.GetObject("Label8.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label8.Size = CType(resources.GetObject("Label8.Size"), System.Drawing.Size)
        Me.Label8.TabIndex = CType(resources.GetObject("Label8.TabIndex"), Integer)
        Me.Label8.Text = resources.GetString("Label8.Text")
        Me.Label8.TextAlign = CType(resources.GetObject("Label8.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label8, resources.GetString("Label8.ToolTip"))
        Me.Label8.Visible = CType(resources.GetObject("Label8.Visible"), Boolean)
        '
        'TextBox7
        '
        Me.TextBox7.AccessibleDescription = resources.GetString("TextBox7.AccessibleDescription")
        Me.TextBox7.AccessibleName = resources.GetString("TextBox7.AccessibleName")
        Me.TextBox7.Anchor = CType(resources.GetObject("TextBox7.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.TextBox7.AutoSize = CType(resources.GetObject("TextBox7.AutoSize"), Boolean)
        Me.TextBox7.BackgroundImage = CType(resources.GetObject("TextBox7.BackgroundImage"), System.Drawing.Image)
        Me.TextBox7.Dock = CType(resources.GetObject("TextBox7.Dock"), System.Windows.Forms.DockStyle)
        Me.TextBox7.Enabled = CType(resources.GetObject("TextBox7.Enabled"), Boolean)
        Me.TextBox7.Font = CType(resources.GetObject("TextBox7.Font"), System.Drawing.Font)
        Me.TextBox7.ImeMode = CType(resources.GetObject("TextBox7.ImeMode"), System.Windows.Forms.ImeMode)
        Me.TextBox7.Location = CType(resources.GetObject("TextBox7.Location"), System.Drawing.Point)
        Me.TextBox7.MaxLength = CType(resources.GetObject("TextBox7.MaxLength"), Integer)
        Me.TextBox7.Multiline = CType(resources.GetObject("TextBox7.Multiline"), Boolean)
        Me.TextBox7.Name = "TextBox7"
        Me.TextBox7.PasswordChar = CType(resources.GetObject("TextBox7.PasswordChar"), Char)
        Me.TextBox7.ReadOnly = True
        Me.TextBox7.RightToLeft = CType(resources.GetObject("TextBox7.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.TextBox7.ScrollBars = CType(resources.GetObject("TextBox7.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.TextBox7.Size = CType(resources.GetObject("TextBox7.Size"), System.Drawing.Size)
        Me.TextBox7.TabIndex = CType(resources.GetObject("TextBox7.TabIndex"), Integer)
        Me.TextBox7.Text = resources.GetString("TextBox7.Text")
        Me.TextBox7.TextAlign = CType(resources.GetObject("TextBox7.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.TextBox7, resources.GetString("TextBox7.ToolTip"))
        Me.TextBox7.Visible = CType(resources.GetObject("TextBox7.Visible"), Boolean)
        Me.TextBox7.WordWrap = CType(resources.GetObject("TextBox7.WordWrap"), Boolean)
        '
        'Label9
        '
        Me.Label9.AccessibleDescription = resources.GetString("Label9.AccessibleDescription")
        Me.Label9.AccessibleName = resources.GetString("Label9.AccessibleName")
        Me.Label9.Anchor = CType(resources.GetObject("Label9.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label9.AutoSize = CType(resources.GetObject("Label9.AutoSize"), Boolean)
        Me.Label9.Dock = CType(resources.GetObject("Label9.Dock"), System.Windows.Forms.DockStyle)
        Me.Label9.Enabled = CType(resources.GetObject("Label9.Enabled"), Boolean)
        Me.Label9.Font = CType(resources.GetObject("Label9.Font"), System.Drawing.Font)
        Me.Label9.Image = CType(resources.GetObject("Label9.Image"), System.Drawing.Image)
        Me.Label9.ImageAlign = CType(resources.GetObject("Label9.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label9.ImageIndex = CType(resources.GetObject("Label9.ImageIndex"), Integer)
        Me.Label9.ImeMode = CType(resources.GetObject("Label9.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label9.Location = CType(resources.GetObject("Label9.Location"), System.Drawing.Point)
        Me.Label9.Name = "Label9"
        Me.Label9.RightToLeft = CType(resources.GetObject("Label9.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label9.Size = CType(resources.GetObject("Label9.Size"), System.Drawing.Size)
        Me.Label9.TabIndex = CType(resources.GetObject("Label9.TabIndex"), Integer)
        Me.Label9.Text = resources.GetString("Label9.Text")
        Me.Label9.TextAlign = CType(resources.GetObject("Label9.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label9, resources.GetString("Label9.ToolTip"))
        Me.Label9.Visible = CType(resources.GetObject("Label9.Visible"), Boolean)
        '
        'tbT_Graviton
        '
        Me.tbT_Graviton.AccessibleDescription = resources.GetString("tbT_Graviton.AccessibleDescription")
        Me.tbT_Graviton.AccessibleName = resources.GetString("tbT_Graviton.AccessibleName")
        Me.tbT_Graviton.Anchor = CType(resources.GetObject("tbT_Graviton.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbT_Graviton.AutoSize = CType(resources.GetObject("tbT_Graviton.AutoSize"), Boolean)
        Me.tbT_Graviton.BackgroundImage = CType(resources.GetObject("tbT_Graviton.BackgroundImage"), System.Drawing.Image)
        Me.tbT_Graviton.Dock = CType(resources.GetObject("tbT_Graviton.Dock"), System.Windows.Forms.DockStyle)
        Me.tbT_Graviton.Enabled = CType(resources.GetObject("tbT_Graviton.Enabled"), Boolean)
        Me.tbT_Graviton.Font = CType(resources.GetObject("tbT_Graviton.Font"), System.Drawing.Font)
        Me.tbT_Graviton.ImeMode = CType(resources.GetObject("tbT_Graviton.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbT_Graviton.Location = CType(resources.GetObject("tbT_Graviton.Location"), System.Drawing.Point)
        Me.tbT_Graviton.MaxLength = CType(resources.GetObject("tbT_Graviton.MaxLength"), Integer)
        Me.tbT_Graviton.Multiline = CType(resources.GetObject("tbT_Graviton.Multiline"), Boolean)
        Me.tbT_Graviton.Name = "tbT_Graviton"
        Me.tbT_Graviton.PasswordChar = CType(resources.GetObject("tbT_Graviton.PasswordChar"), Char)
        Me.tbT_Graviton.ReadOnly = True
        Me.tbT_Graviton.RightToLeft = CType(resources.GetObject("tbT_Graviton.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbT_Graviton.ScrollBars = CType(resources.GetObject("tbT_Graviton.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbT_Graviton.Size = CType(resources.GetObject("tbT_Graviton.Size"), System.Drawing.Size)
        Me.tbT_Graviton.TabIndex = CType(resources.GetObject("tbT_Graviton.TabIndex"), Integer)
        Me.tbT_Graviton.Text = resources.GetString("tbT_Graviton.Text")
        Me.tbT_Graviton.TextAlign = CType(resources.GetObject("tbT_Graviton.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbT_Graviton, resources.GetString("tbT_Graviton.ToolTip"))
        Me.tbT_Graviton.Visible = CType(resources.GetObject("tbT_Graviton.Visible"), Boolean)
        Me.tbT_Graviton.WordWrap = CType(resources.GetObject("tbT_Graviton.WordWrap"), Boolean)
        '
        'Label10
        '
        Me.Label10.AccessibleDescription = resources.GetString("Label10.AccessibleDescription")
        Me.Label10.AccessibleName = resources.GetString("Label10.AccessibleName")
        Me.Label10.Anchor = CType(resources.GetObject("Label10.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label10.AutoSize = CType(resources.GetObject("Label10.AutoSize"), Boolean)
        Me.Label10.Dock = CType(resources.GetObject("Label10.Dock"), System.Windows.Forms.DockStyle)
        Me.Label10.Enabled = CType(resources.GetObject("Label10.Enabled"), Boolean)
        Me.Label10.Font = CType(resources.GetObject("Label10.Font"), System.Drawing.Font)
        Me.Label10.Image = CType(resources.GetObject("Label10.Image"), System.Drawing.Image)
        Me.Label10.ImageAlign = CType(resources.GetObject("Label10.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Label10.ImageIndex = CType(resources.GetObject("Label10.ImageIndex"), Integer)
        Me.Label10.ImeMode = CType(resources.GetObject("Label10.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Label10.Location = CType(resources.GetObject("Label10.Location"), System.Drawing.Point)
        Me.Label10.Name = "Label10"
        Me.Label10.RightToLeft = CType(resources.GetObject("Label10.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Label10.Size = CType(resources.GetObject("Label10.Size"), System.Drawing.Size)
        Me.Label10.TabIndex = CType(resources.GetObject("Label10.TabIndex"), Integer)
        Me.Label10.Text = resources.GetString("Label10.Text")
        Me.Label10.TextAlign = CType(resources.GetObject("Label10.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.Label10, resources.GetString("Label10.ToolTip"))
        Me.Label10.Visible = CType(resources.GetObject("Label10.Visible"), Boolean)
        '
        'lbKnownTechno
        '
        Me.lbKnownTechno.AccessibleDescription = resources.GetString("lbKnownTechno.AccessibleDescription")
        Me.lbKnownTechno.AccessibleName = resources.GetString("lbKnownTechno.AccessibleName")
        Me.lbKnownTechno.Anchor = CType(resources.GetObject("lbKnownTechno.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbKnownTechno.AutoSize = CType(resources.GetObject("lbKnownTechno.AutoSize"), Boolean)
        Me.lbKnownTechno.BackColor = System.Drawing.SystemColors.Highlight
        Me.lbKnownTechno.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.lbKnownTechno.Dock = CType(resources.GetObject("lbKnownTechno.Dock"), System.Windows.Forms.DockStyle)
        Me.lbKnownTechno.Enabled = CType(resources.GetObject("lbKnownTechno.Enabled"), Boolean)
        Me.lbKnownTechno.Font = CType(resources.GetObject("lbKnownTechno.Font"), System.Drawing.Font)
        Me.lbKnownTechno.ForeColor = System.Drawing.SystemColors.HighlightText
        Me.lbKnownTechno.Image = CType(resources.GetObject("lbKnownTechno.Image"), System.Drawing.Image)
        Me.lbKnownTechno.ImageAlign = CType(resources.GetObject("lbKnownTechno.ImageAlign"), System.Drawing.ContentAlignment)
        Me.lbKnownTechno.ImageIndex = CType(resources.GetObject("lbKnownTechno.ImageIndex"), Integer)
        Me.lbKnownTechno.ImeMode = CType(resources.GetObject("lbKnownTechno.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbKnownTechno.Location = CType(resources.GetObject("lbKnownTechno.Location"), System.Drawing.Point)
        Me.lbKnownTechno.Name = "lbKnownTechno"
        Me.lbKnownTechno.RightToLeft = CType(resources.GetObject("lbKnownTechno.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbKnownTechno.Size = CType(resources.GetObject("lbKnownTechno.Size"), System.Drawing.Size)
        Me.lbKnownTechno.TabIndex = CType(resources.GetObject("lbKnownTechno.TabIndex"), Integer)
        Me.lbKnownTechno.Text = resources.GetString("lbKnownTechno.Text")
        Me.lbKnownTechno.TextAlign = CType(resources.GetObject("lbKnownTechno.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.lbKnownTechno, resources.GetString("lbKnownTechno.ToolTip"))
        Me.lbKnownTechno.Visible = CType(resources.GetObject("lbKnownTechno.Visible"), Boolean)
        '
        'lvStats
        '
        Me.lvStats.AccessibleDescription = resources.GetString("lvStats.AccessibleDescription")
        Me.lvStats.AccessibleName = resources.GetString("lvStats.AccessibleName")
        Me.lvStats.Alignment = CType(resources.GetObject("lvStats.Alignment"), System.Windows.Forms.ListViewAlignment)
        Me.lvStats.Anchor = CType(resources.GetObject("lvStats.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lvStats.BackColor = System.Drawing.SystemColors.Info
        Me.lvStats.BackgroundImage = CType(resources.GetObject("lvStats.BackgroundImage"), System.Drawing.Image)
        Me.lvStats.Columns.AddRange(New System.Windows.Forms.ColumnHeader() {Me.chType, Me.chRank, Me.chPoints, Me.chdate})
        Me.lvStats.Dock = CType(resources.GetObject("lvStats.Dock"), System.Windows.Forms.DockStyle)
        Me.lvStats.Enabled = CType(resources.GetObject("lvStats.Enabled"), Boolean)
        Me.lvStats.Font = CType(resources.GetObject("lvStats.Font"), System.Drawing.Font)
        Me.lvStats.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lvStats.FullRowSelect = True
        Me.lvStats.GridLines = True
        Me.lvStats.HeaderStyle = System.Windows.Forms.ColumnHeaderStyle.Nonclickable
        Me.lvStats.ImeMode = CType(resources.GetObject("lvStats.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lvStats.LabelWrap = CType(resources.GetObject("lvStats.LabelWrap"), Boolean)
        Me.lvStats.Location = CType(resources.GetObject("lvStats.Location"), System.Drawing.Point)
        Me.lvStats.Name = "lvStats"
        Me.lvStats.RightToLeft = CType(resources.GetObject("lvStats.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lvStats.Size = CType(resources.GetObject("lvStats.Size"), System.Drawing.Size)
        Me.lvStats.TabIndex = CType(resources.GetObject("lvStats.TabIndex"), Integer)
        Me.lvStats.Text = resources.GetString("lvStats.Text")
        Me.ToolTip1.SetToolTip(Me.lvStats, resources.GetString("lvStats.ToolTip"))
        Me.lvStats.View = System.Windows.Forms.View.Details
        Me.lvStats.Visible = CType(resources.GetObject("lvStats.Visible"), Boolean)
        '
        'chType
        '
        Me.chType.Text = resources.GetString("chType.Text")
        Me.chType.TextAlign = CType(resources.GetObject("chType.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.chType.Width = CType(resources.GetObject("chType.Width"), Integer)
        '
        'chRank
        '
        Me.chRank.Text = resources.GetString("chRank.Text")
        Me.chRank.TextAlign = CType(resources.GetObject("chRank.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.chRank.Width = CType(resources.GetObject("chRank.Width"), Integer)
        '
        'chPoints
        '
        Me.chPoints.Text = resources.GetString("chPoints.Text")
        Me.chPoints.TextAlign = CType(resources.GetObject("chPoints.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.chPoints.Width = CType(resources.GetObject("chPoints.Width"), Integer)
        '
        'chdate
        '
        Me.chdate.Text = resources.GetString("chdate.Text")
        Me.chdate.TextAlign = CType(resources.GetObject("chdate.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.chdate.Width = CType(resources.GetObject("chdate.Width"), Integer)
        '
        'lbStats
        '
        Me.lbStats.AccessibleDescription = resources.GetString("lbStats.AccessibleDescription")
        Me.lbStats.AccessibleName = resources.GetString("lbStats.AccessibleName")
        Me.lbStats.Anchor = CType(resources.GetObject("lbStats.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbStats.AutoSize = CType(resources.GetObject("lbStats.AutoSize"), Boolean)
        Me.lbStats.BackColor = System.Drawing.SystemColors.Highlight
        Me.lbStats.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.lbStats.Dock = CType(resources.GetObject("lbStats.Dock"), System.Windows.Forms.DockStyle)
        Me.lbStats.Enabled = CType(resources.GetObject("lbStats.Enabled"), Boolean)
        Me.lbStats.Font = CType(resources.GetObject("lbStats.Font"), System.Drawing.Font)
        Me.lbStats.ForeColor = System.Drawing.SystemColors.HighlightText
        Me.lbStats.Image = CType(resources.GetObject("lbStats.Image"), System.Drawing.Image)
        Me.lbStats.ImageAlign = CType(resources.GetObject("lbStats.ImageAlign"), System.Drawing.ContentAlignment)
        Me.lbStats.ImageIndex = CType(resources.GetObject("lbStats.ImageIndex"), Integer)
        Me.lbStats.ImeMode = CType(resources.GetObject("lbStats.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbStats.Location = CType(resources.GetObject("lbStats.Location"), System.Drawing.Point)
        Me.lbStats.Name = "lbStats"
        Me.lbStats.RightToLeft = CType(resources.GetObject("lbStats.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbStats.Size = CType(resources.GetObject("lbStats.Size"), System.Drawing.Size)
        Me.lbStats.TabIndex = CType(resources.GetObject("lbStats.TabIndex"), Integer)
        Me.lbStats.Text = resources.GetString("lbStats.Text")
        Me.lbStats.TextAlign = CType(resources.GetObject("lbStats.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.lbStats, resources.GetString("lbStats.ToolTip"))
        Me.lbStats.Visible = CType(resources.GetObject("lbStats.Visible"), Boolean)
        '
        'tbNameAlliance
        '
        Me.tbNameAlliance.AccessibleDescription = resources.GetString("tbNameAlliance.AccessibleDescription")
        Me.tbNameAlliance.AccessibleName = resources.GetString("tbNameAlliance.AccessibleName")
        Me.tbNameAlliance.Anchor = CType(resources.GetObject("tbNameAlliance.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbNameAlliance.AutoSize = CType(resources.GetObject("tbNameAlliance.AutoSize"), Boolean)
        Me.tbNameAlliance.BackgroundImage = CType(resources.GetObject("tbNameAlliance.BackgroundImage"), System.Drawing.Image)
        Me.tbNameAlliance.Dock = CType(resources.GetObject("tbNameAlliance.Dock"), System.Windows.Forms.DockStyle)
        Me.tbNameAlliance.Enabled = CType(resources.GetObject("tbNameAlliance.Enabled"), Boolean)
        Me.tbNameAlliance.Font = CType(resources.GetObject("tbNameAlliance.Font"), System.Drawing.Font)
        Me.tbNameAlliance.ImeMode = CType(resources.GetObject("tbNameAlliance.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbNameAlliance.Location = CType(resources.GetObject("tbNameAlliance.Location"), System.Drawing.Point)
        Me.tbNameAlliance.MaxLength = CType(resources.GetObject("tbNameAlliance.MaxLength"), Integer)
        Me.tbNameAlliance.Multiline = CType(resources.GetObject("tbNameAlliance.Multiline"), Boolean)
        Me.tbNameAlliance.Name = "tbNameAlliance"
        Me.tbNameAlliance.PasswordChar = CType(resources.GetObject("tbNameAlliance.PasswordChar"), Char)
        Me.tbNameAlliance.ReadOnly = True
        Me.tbNameAlliance.RightToLeft = CType(resources.GetObject("tbNameAlliance.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbNameAlliance.ScrollBars = CType(resources.GetObject("tbNameAlliance.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbNameAlliance.Size = CType(resources.GetObject("tbNameAlliance.Size"), System.Drawing.Size)
        Me.tbNameAlliance.TabIndex = CType(resources.GetObject("tbNameAlliance.TabIndex"), Integer)
        Me.tbNameAlliance.Text = resources.GetString("tbNameAlliance.Text")
        Me.tbNameAlliance.TextAlign = CType(resources.GetObject("tbNameAlliance.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbNameAlliance, resources.GetString("tbNameAlliance.ToolTip"))
        Me.tbNameAlliance.Visible = CType(resources.GetObject("tbNameAlliance.Visible"), Boolean)
        Me.tbNameAlliance.WordWrap = CType(resources.GetObject("tbNameAlliance.WordWrap"), Boolean)
        '
        'Label1
        '
        Me.Label1.AccessibleDescription = resources.GetString("Label1.AccessibleDescription")
        Me.Label1.AccessibleName = resources.GetString("Label1.AccessibleName")
        Me.Label1.Anchor = CType(resources.GetObject("Label1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Label1.AutoSize = CType(resources.GetObject("Label1.AutoSize"), Boolean)
        Me.Label1.BackColor = System.Drawing.SystemColors.Highlight
        Me.Label1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label1.Dock = CType(resources.GetObject("Label1.Dock"), System.Windows.Forms.DockStyle)
        Me.Label1.Enabled = CType(resources.GetObject("Label1.Enabled"), Boolean)
        Me.Label1.Font = CType(resources.GetObject("Label1.Font"), System.Drawing.Font)
        Me.Label1.ForeColor = System.Drawing.SystemColors.HighlightText
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
        'tpModify
        '
        Me.tpModify.AccessibleDescription = resources.GetString("tpModify.AccessibleDescription")
        Me.tpModify.AccessibleName = resources.GetString("tpModify.AccessibleName")
        Me.tpModify.Anchor = CType(resources.GetObject("tpModify.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tpModify.AutoScroll = CType(resources.GetObject("tpModify.AutoScroll"), Boolean)
        Me.tpModify.AutoScrollMargin = CType(resources.GetObject("tpModify.AutoScrollMargin"), System.Drawing.Size)
        Me.tpModify.AutoScrollMinSize = CType(resources.GetObject("tpModify.AutoScrollMinSize"), System.Drawing.Size)
        Me.tpModify.BackgroundImage = CType(resources.GetObject("tpModify.BackgroundImage"), System.Drawing.Image)
        Me.tpModify.Controls.Add(Me.GroupBox2)
        Me.tpModify.Controls.Add(Me.GroupBox1)
        Me.tpModify.Dock = CType(resources.GetObject("tpModify.Dock"), System.Windows.Forms.DockStyle)
        Me.tpModify.Enabled = CType(resources.GetObject("tpModify.Enabled"), Boolean)
        Me.tpModify.Font = CType(resources.GetObject("tpModify.Font"), System.Drawing.Font)
        Me.tpModify.ImageIndex = CType(resources.GetObject("tpModify.ImageIndex"), Integer)
        Me.tpModify.ImeMode = CType(resources.GetObject("tpModify.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tpModify.Location = CType(resources.GetObject("tpModify.Location"), System.Drawing.Point)
        Me.tpModify.Name = "tpModify"
        Me.tpModify.RightToLeft = CType(resources.GetObject("tpModify.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tpModify.Size = CType(resources.GetObject("tpModify.Size"), System.Drawing.Size)
        Me.tpModify.TabIndex = CType(resources.GetObject("tpModify.TabIndex"), Integer)
        Me.tpModify.Text = resources.GetString("tpModify.Text")
        Me.ToolTip1.SetToolTip(Me.tpModify, resources.GetString("tpModify.ToolTip"))
        Me.tpModify.ToolTipText = resources.GetString("tpModify.ToolTipText")
        Me.tpModify.Visible = CType(resources.GetObject("tpModify.Visible"), Boolean)
        '
        'GroupBox2
        '
        Me.GroupBox2.AccessibleDescription = resources.GetString("GroupBox2.AccessibleDescription")
        Me.GroupBox2.AccessibleName = resources.GetString("GroupBox2.AccessibleName")
        Me.GroupBox2.Anchor = CType(resources.GetObject("GroupBox2.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.GroupBox2.BackgroundImage = CType(resources.GetObject("GroupBox2.BackgroundImage"), System.Drawing.Image)
        Me.GroupBox2.Controls.Add(Me.btnGetFrom)
        Me.GroupBox2.Controls.Add(Me.tbGetFromPlayerInfo)
        Me.GroupBox2.Controls.Add(Me.btnSelectGetFrom)
        Me.GroupBox2.Controls.Add(Me.lbbGetFromId)
        Me.GroupBox2.Dock = CType(resources.GetObject("GroupBox2.Dock"), System.Windows.Forms.DockStyle)
        Me.GroupBox2.Enabled = CType(resources.GetObject("GroupBox2.Enabled"), Boolean)
        Me.GroupBox2.Font = CType(resources.GetObject("GroupBox2.Font"), System.Drawing.Font)
        Me.GroupBox2.ImeMode = CType(resources.GetObject("GroupBox2.ImeMode"), System.Windows.Forms.ImeMode)
        Me.GroupBox2.Location = CType(resources.GetObject("GroupBox2.Location"), System.Drawing.Point)
        Me.GroupBox2.Name = "GroupBox2"
        Me.GroupBox2.RightToLeft = CType(resources.GetObject("GroupBox2.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.GroupBox2.Size = CType(resources.GetObject("GroupBox2.Size"), System.Drawing.Size)
        Me.GroupBox2.TabIndex = CType(resources.GetObject("GroupBox2.TabIndex"), Integer)
        Me.GroupBox2.TabStop = False
        Me.GroupBox2.Text = resources.GetString("GroupBox2.Text")
        Me.ToolTip1.SetToolTip(Me.GroupBox2, resources.GetString("GroupBox2.ToolTip"))
        Me.GroupBox2.Visible = CType(resources.GetObject("GroupBox2.Visible"), Boolean)
        '
        'btnGetFrom
        '
        Me.btnGetFrom.AccessibleDescription = resources.GetString("btnGetFrom.AccessibleDescription")
        Me.btnGetFrom.AccessibleName = resources.GetString("btnGetFrom.AccessibleName")
        Me.btnGetFrom.Anchor = CType(resources.GetObject("btnGetFrom.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnGetFrom.BackgroundImage = CType(resources.GetObject("btnGetFrom.BackgroundImage"), System.Drawing.Image)
        Me.btnGetFrom.Dock = CType(resources.GetObject("btnGetFrom.Dock"), System.Windows.Forms.DockStyle)
        Me.btnGetFrom.Enabled = CType(resources.GetObject("btnGetFrom.Enabled"), Boolean)
        Me.btnGetFrom.FlatStyle = CType(resources.GetObject("btnGetFrom.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnGetFrom.Font = CType(resources.GetObject("btnGetFrom.Font"), System.Drawing.Font)
        Me.btnGetFrom.Image = CType(resources.GetObject("btnGetFrom.Image"), System.Drawing.Image)
        Me.btnGetFrom.ImageAlign = CType(resources.GetObject("btnGetFrom.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnGetFrom.ImageIndex = CType(resources.GetObject("btnGetFrom.ImageIndex"), Integer)
        Me.btnGetFrom.ImeMode = CType(resources.GetObject("btnGetFrom.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnGetFrom.Location = CType(resources.GetObject("btnGetFrom.Location"), System.Drawing.Point)
        Me.btnGetFrom.Name = "btnGetFrom"
        Me.btnGetFrom.RightToLeft = CType(resources.GetObject("btnGetFrom.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnGetFrom.Size = CType(resources.GetObject("btnGetFrom.Size"), System.Drawing.Size)
        Me.btnGetFrom.TabIndex = CType(resources.GetObject("btnGetFrom.TabIndex"), Integer)
        Me.btnGetFrom.Text = resources.GetString("btnGetFrom.Text")
        Me.btnGetFrom.TextAlign = CType(resources.GetObject("btnGetFrom.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnGetFrom, resources.GetString("btnGetFrom.ToolTip"))
        Me.btnGetFrom.Visible = CType(resources.GetObject("btnGetFrom.Visible"), Boolean)
        '
        'tbGetFromPlayerInfo
        '
        Me.tbGetFromPlayerInfo.AccessibleDescription = resources.GetString("tbGetFromPlayerInfo.AccessibleDescription")
        Me.tbGetFromPlayerInfo.AccessibleName = resources.GetString("tbGetFromPlayerInfo.AccessibleName")
        Me.tbGetFromPlayerInfo.Anchor = CType(resources.GetObject("tbGetFromPlayerInfo.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbGetFromPlayerInfo.AutoSize = CType(resources.GetObject("tbGetFromPlayerInfo.AutoSize"), Boolean)
        Me.tbGetFromPlayerInfo.BackgroundImage = CType(resources.GetObject("tbGetFromPlayerInfo.BackgroundImage"), System.Drawing.Image)
        Me.tbGetFromPlayerInfo.Dock = CType(resources.GetObject("tbGetFromPlayerInfo.Dock"), System.Windows.Forms.DockStyle)
        Me.tbGetFromPlayerInfo.Enabled = CType(resources.GetObject("tbGetFromPlayerInfo.Enabled"), Boolean)
        Me.tbGetFromPlayerInfo.Font = CType(resources.GetObject("tbGetFromPlayerInfo.Font"), System.Drawing.Font)
        Me.tbGetFromPlayerInfo.ImeMode = CType(resources.GetObject("tbGetFromPlayerInfo.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbGetFromPlayerInfo.Location = CType(resources.GetObject("tbGetFromPlayerInfo.Location"), System.Drawing.Point)
        Me.tbGetFromPlayerInfo.MaxLength = CType(resources.GetObject("tbGetFromPlayerInfo.MaxLength"), Integer)
        Me.tbGetFromPlayerInfo.Multiline = CType(resources.GetObject("tbGetFromPlayerInfo.Multiline"), Boolean)
        Me.tbGetFromPlayerInfo.Name = "tbGetFromPlayerInfo"
        Me.tbGetFromPlayerInfo.PasswordChar = CType(resources.GetObject("tbGetFromPlayerInfo.PasswordChar"), Char)
        Me.tbGetFromPlayerInfo.ReadOnly = True
        Me.tbGetFromPlayerInfo.RightToLeft = CType(resources.GetObject("tbGetFromPlayerInfo.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbGetFromPlayerInfo.ScrollBars = CType(resources.GetObject("tbGetFromPlayerInfo.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbGetFromPlayerInfo.Size = CType(resources.GetObject("tbGetFromPlayerInfo.Size"), System.Drawing.Size)
        Me.tbGetFromPlayerInfo.TabIndex = CType(resources.GetObject("tbGetFromPlayerInfo.TabIndex"), Integer)
        Me.tbGetFromPlayerInfo.Text = resources.GetString("tbGetFromPlayerInfo.Text")
        Me.tbGetFromPlayerInfo.TextAlign = CType(resources.GetObject("tbGetFromPlayerInfo.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbGetFromPlayerInfo, resources.GetString("tbGetFromPlayerInfo.ToolTip"))
        Me.tbGetFromPlayerInfo.Visible = CType(resources.GetObject("tbGetFromPlayerInfo.Visible"), Boolean)
        Me.tbGetFromPlayerInfo.WordWrap = CType(resources.GetObject("tbGetFromPlayerInfo.WordWrap"), Boolean)
        '
        'btnSelectGetFrom
        '
        Me.btnSelectGetFrom.AccessibleDescription = resources.GetString("btnSelectGetFrom.AccessibleDescription")
        Me.btnSelectGetFrom.AccessibleName = resources.GetString("btnSelectGetFrom.AccessibleName")
        Me.btnSelectGetFrom.Anchor = CType(resources.GetObject("btnSelectGetFrom.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnSelectGetFrom.BackgroundImage = CType(resources.GetObject("btnSelectGetFrom.BackgroundImage"), System.Drawing.Image)
        Me.btnSelectGetFrom.Dock = CType(resources.GetObject("btnSelectGetFrom.Dock"), System.Windows.Forms.DockStyle)
        Me.btnSelectGetFrom.Enabled = CType(resources.GetObject("btnSelectGetFrom.Enabled"), Boolean)
        Me.btnSelectGetFrom.FlatStyle = CType(resources.GetObject("btnSelectGetFrom.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnSelectGetFrom.Font = CType(resources.GetObject("btnSelectGetFrom.Font"), System.Drawing.Font)
        Me.btnSelectGetFrom.Image = CType(resources.GetObject("btnSelectGetFrom.Image"), System.Drawing.Image)
        Me.btnSelectGetFrom.ImageAlign = CType(resources.GetObject("btnSelectGetFrom.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnSelectGetFrom.ImageIndex = CType(resources.GetObject("btnSelectGetFrom.ImageIndex"), Integer)
        Me.btnSelectGetFrom.ImeMode = CType(resources.GetObject("btnSelectGetFrom.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnSelectGetFrom.Location = CType(resources.GetObject("btnSelectGetFrom.Location"), System.Drawing.Point)
        Me.btnSelectGetFrom.Name = "btnSelectGetFrom"
        Me.btnSelectGetFrom.RightToLeft = CType(resources.GetObject("btnSelectGetFrom.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnSelectGetFrom.Size = CType(resources.GetObject("btnSelectGetFrom.Size"), System.Drawing.Size)
        Me.btnSelectGetFrom.TabIndex = CType(resources.GetObject("btnSelectGetFrom.TabIndex"), Integer)
        Me.btnSelectGetFrom.Text = resources.GetString("btnSelectGetFrom.Text")
        Me.btnSelectGetFrom.TextAlign = CType(resources.GetObject("btnSelectGetFrom.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnSelectGetFrom, resources.GetString("btnSelectGetFrom.ToolTip"))
        Me.btnSelectGetFrom.Visible = CType(resources.GetObject("btnSelectGetFrom.Visible"), Boolean)
        '
        'lbbGetFromId
        '
        Me.lbbGetFromId.AccessibleDescription = resources.GetString("lbbGetFromId.AccessibleDescription")
        Me.lbbGetFromId.AccessibleName = resources.GetString("lbbGetFromId.AccessibleName")
        Me.lbbGetFromId.Anchor = CType(resources.GetObject("lbbGetFromId.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbbGetFromId.AutoScroll = CType(resources.GetObject("lbbGetFromId.AutoScroll"), Boolean)
        Me.lbbGetFromId.AutoScrollMargin = CType(resources.GetObject("lbbGetFromId.AutoScrollMargin"), System.Drawing.Size)
        Me.lbbGetFromId.AutoScrollMinSize = CType(resources.GetObject("lbbGetFromId.AutoScrollMinSize"), System.Drawing.Size)
        Me.lbbGetFromId.BackgroundImage = CType(resources.GetObject("lbbGetFromId.BackgroundImage"), System.Drawing.Image)
        Me.lbbGetFromId.Caption = "Old Player ID"
        Me.lbbGetFromId.CaptionWidth = 50
        Me.lbbGetFromId.Dock = CType(resources.GetObject("lbbGetFromId.Dock"), System.Windows.Forms.DockStyle)
        Me.lbbGetFromId.Enabled = CType(resources.GetObject("lbbGetFromId.Enabled"), Boolean)
        Me.lbbGetFromId.Font = CType(resources.GetObject("lbbGetFromId.Font"), System.Drawing.Font)
        Me.lbbGetFromId.ImeMode = CType(resources.GetObject("lbbGetFromId.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbbGetFromId.Location = CType(resources.GetObject("lbbGetFromId.Location"), System.Drawing.Point)
        Me.lbbGetFromId.Name = "lbbGetFromId"
        Me.lbbGetFromId.ReadOnly = False
        Me.lbbGetFromId.RightToLeft = CType(resources.GetObject("lbbGetFromId.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbbGetFromId.Size = CType(resources.GetObject("lbbGetFromId.Size"), System.Drawing.Size)
        Me.lbbGetFromId.TabIndex = CType(resources.GetObject("lbbGetFromId.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.lbbGetFromId, resources.GetString("lbbGetFromId.ToolTip"))
        Me.lbbGetFromId.Value = ""
        Me.lbbGetFromId.Visible = CType(resources.GetObject("lbbGetFromId.Visible"), Boolean)
        '
        'GroupBox1
        '
        Me.GroupBox1.AccessibleDescription = resources.GetString("GroupBox1.AccessibleDescription")
        Me.GroupBox1.AccessibleName = resources.GetString("GroupBox1.AccessibleName")
        Me.GroupBox1.Anchor = CType(resources.GetObject("GroupBox1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.GroupBox1.BackgroundImage = CType(resources.GetObject("GroupBox1.BackgroundImage"), System.Drawing.Image)
        Me.GroupBox1.Controls.Add(Me.btnMoveData)
        Me.GroupBox1.Controls.Add(Me.tbNewPlayerInfo)
        Me.GroupBox1.Controls.Add(Me.btnSelectTransfertTo)
        Me.GroupBox1.Controls.Add(Me.lbbNewPlayerId)
        Me.GroupBox1.Dock = CType(resources.GetObject("GroupBox1.Dock"), System.Windows.Forms.DockStyle)
        Me.GroupBox1.Enabled = CType(resources.GetObject("GroupBox1.Enabled"), Boolean)
        Me.GroupBox1.Font = CType(resources.GetObject("GroupBox1.Font"), System.Drawing.Font)
        Me.GroupBox1.ImeMode = CType(resources.GetObject("GroupBox1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.GroupBox1.Location = CType(resources.GetObject("GroupBox1.Location"), System.Drawing.Point)
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.RightToLeft = CType(resources.GetObject("GroupBox1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.GroupBox1.Size = CType(resources.GetObject("GroupBox1.Size"), System.Drawing.Size)
        Me.GroupBox1.TabIndex = CType(resources.GetObject("GroupBox1.TabIndex"), Integer)
        Me.GroupBox1.TabStop = False
        Me.GroupBox1.Text = resources.GetString("GroupBox1.Text")
        Me.ToolTip1.SetToolTip(Me.GroupBox1, resources.GetString("GroupBox1.ToolTip"))
        Me.GroupBox1.Visible = CType(resources.GetObject("GroupBox1.Visible"), Boolean)
        '
        'btnMoveData
        '
        Me.btnMoveData.AccessibleDescription = resources.GetString("btnMoveData.AccessibleDescription")
        Me.btnMoveData.AccessibleName = resources.GetString("btnMoveData.AccessibleName")
        Me.btnMoveData.Anchor = CType(resources.GetObject("btnMoveData.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnMoveData.BackgroundImage = CType(resources.GetObject("btnMoveData.BackgroundImage"), System.Drawing.Image)
        Me.btnMoveData.Dock = CType(resources.GetObject("btnMoveData.Dock"), System.Windows.Forms.DockStyle)
        Me.btnMoveData.Enabled = CType(resources.GetObject("btnMoveData.Enabled"), Boolean)
        Me.btnMoveData.FlatStyle = CType(resources.GetObject("btnMoveData.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnMoveData.Font = CType(resources.GetObject("btnMoveData.Font"), System.Drawing.Font)
        Me.btnMoveData.Image = CType(resources.GetObject("btnMoveData.Image"), System.Drawing.Image)
        Me.btnMoveData.ImageAlign = CType(resources.GetObject("btnMoveData.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnMoveData.ImageIndex = CType(resources.GetObject("btnMoveData.ImageIndex"), Integer)
        Me.btnMoveData.ImeMode = CType(resources.GetObject("btnMoveData.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnMoveData.Location = CType(resources.GetObject("btnMoveData.Location"), System.Drawing.Point)
        Me.btnMoveData.Name = "btnMoveData"
        Me.btnMoveData.RightToLeft = CType(resources.GetObject("btnMoveData.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnMoveData.Size = CType(resources.GetObject("btnMoveData.Size"), System.Drawing.Size)
        Me.btnMoveData.TabIndex = CType(resources.GetObject("btnMoveData.TabIndex"), Integer)
        Me.btnMoveData.Text = resources.GetString("btnMoveData.Text")
        Me.btnMoveData.TextAlign = CType(resources.GetObject("btnMoveData.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnMoveData, resources.GetString("btnMoveData.ToolTip"))
        Me.btnMoveData.Visible = CType(resources.GetObject("btnMoveData.Visible"), Boolean)
        '
        'tbNewPlayerInfo
        '
        Me.tbNewPlayerInfo.AccessibleDescription = resources.GetString("tbNewPlayerInfo.AccessibleDescription")
        Me.tbNewPlayerInfo.AccessibleName = resources.GetString("tbNewPlayerInfo.AccessibleName")
        Me.tbNewPlayerInfo.Anchor = CType(resources.GetObject("tbNewPlayerInfo.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbNewPlayerInfo.AutoSize = CType(resources.GetObject("tbNewPlayerInfo.AutoSize"), Boolean)
        Me.tbNewPlayerInfo.BackgroundImage = CType(resources.GetObject("tbNewPlayerInfo.BackgroundImage"), System.Drawing.Image)
        Me.tbNewPlayerInfo.Dock = CType(resources.GetObject("tbNewPlayerInfo.Dock"), System.Windows.Forms.DockStyle)
        Me.tbNewPlayerInfo.Enabled = CType(resources.GetObject("tbNewPlayerInfo.Enabled"), Boolean)
        Me.tbNewPlayerInfo.Font = CType(resources.GetObject("tbNewPlayerInfo.Font"), System.Drawing.Font)
        Me.tbNewPlayerInfo.ImeMode = CType(resources.GetObject("tbNewPlayerInfo.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbNewPlayerInfo.Location = CType(resources.GetObject("tbNewPlayerInfo.Location"), System.Drawing.Point)
        Me.tbNewPlayerInfo.MaxLength = CType(resources.GetObject("tbNewPlayerInfo.MaxLength"), Integer)
        Me.tbNewPlayerInfo.Multiline = CType(resources.GetObject("tbNewPlayerInfo.Multiline"), Boolean)
        Me.tbNewPlayerInfo.Name = "tbNewPlayerInfo"
        Me.tbNewPlayerInfo.PasswordChar = CType(resources.GetObject("tbNewPlayerInfo.PasswordChar"), Char)
        Me.tbNewPlayerInfo.ReadOnly = True
        Me.tbNewPlayerInfo.RightToLeft = CType(resources.GetObject("tbNewPlayerInfo.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbNewPlayerInfo.ScrollBars = CType(resources.GetObject("tbNewPlayerInfo.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbNewPlayerInfo.Size = CType(resources.GetObject("tbNewPlayerInfo.Size"), System.Drawing.Size)
        Me.tbNewPlayerInfo.TabIndex = CType(resources.GetObject("tbNewPlayerInfo.TabIndex"), Integer)
        Me.tbNewPlayerInfo.Text = resources.GetString("tbNewPlayerInfo.Text")
        Me.tbNewPlayerInfo.TextAlign = CType(resources.GetObject("tbNewPlayerInfo.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbNewPlayerInfo, resources.GetString("tbNewPlayerInfo.ToolTip"))
        Me.tbNewPlayerInfo.Visible = CType(resources.GetObject("tbNewPlayerInfo.Visible"), Boolean)
        Me.tbNewPlayerInfo.WordWrap = CType(resources.GetObject("tbNewPlayerInfo.WordWrap"), Boolean)
        '
        'btnSelectTransfertTo
        '
        Me.btnSelectTransfertTo.AccessibleDescription = resources.GetString("btnSelectTransfertTo.AccessibleDescription")
        Me.btnSelectTransfertTo.AccessibleName = resources.GetString("btnSelectTransfertTo.AccessibleName")
        Me.btnSelectTransfertTo.Anchor = CType(resources.GetObject("btnSelectTransfertTo.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnSelectTransfertTo.BackgroundImage = CType(resources.GetObject("btnSelectTransfertTo.BackgroundImage"), System.Drawing.Image)
        Me.btnSelectTransfertTo.Dock = CType(resources.GetObject("btnSelectTransfertTo.Dock"), System.Windows.Forms.DockStyle)
        Me.btnSelectTransfertTo.Enabled = CType(resources.GetObject("btnSelectTransfertTo.Enabled"), Boolean)
        Me.btnSelectTransfertTo.FlatStyle = CType(resources.GetObject("btnSelectTransfertTo.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnSelectTransfertTo.Font = CType(resources.GetObject("btnSelectTransfertTo.Font"), System.Drawing.Font)
        Me.btnSelectTransfertTo.Image = CType(resources.GetObject("btnSelectTransfertTo.Image"), System.Drawing.Image)
        Me.btnSelectTransfertTo.ImageAlign = CType(resources.GetObject("btnSelectTransfertTo.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnSelectTransfertTo.ImageIndex = CType(resources.GetObject("btnSelectTransfertTo.ImageIndex"), Integer)
        Me.btnSelectTransfertTo.ImeMode = CType(resources.GetObject("btnSelectTransfertTo.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnSelectTransfertTo.Location = CType(resources.GetObject("btnSelectTransfertTo.Location"), System.Drawing.Point)
        Me.btnSelectTransfertTo.Name = "btnSelectTransfertTo"
        Me.btnSelectTransfertTo.RightToLeft = CType(resources.GetObject("btnSelectTransfertTo.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnSelectTransfertTo.Size = CType(resources.GetObject("btnSelectTransfertTo.Size"), System.Drawing.Size)
        Me.btnSelectTransfertTo.TabIndex = CType(resources.GetObject("btnSelectTransfertTo.TabIndex"), Integer)
        Me.btnSelectTransfertTo.Text = resources.GetString("btnSelectTransfertTo.Text")
        Me.btnSelectTransfertTo.TextAlign = CType(resources.GetObject("btnSelectTransfertTo.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnSelectTransfertTo, resources.GetString("btnSelectTransfertTo.ToolTip"))
        Me.btnSelectTransfertTo.Visible = CType(resources.GetObject("btnSelectTransfertTo.Visible"), Boolean)
        '
        'lbbNewPlayerId
        '
        Me.lbbNewPlayerId.AccessibleDescription = resources.GetString("lbbNewPlayerId.AccessibleDescription")
        Me.lbbNewPlayerId.AccessibleName = resources.GetString("lbbNewPlayerId.AccessibleName")
        Me.lbbNewPlayerId.Anchor = CType(resources.GetObject("lbbNewPlayerId.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbbNewPlayerId.AutoScroll = CType(resources.GetObject("lbbNewPlayerId.AutoScroll"), Boolean)
        Me.lbbNewPlayerId.AutoScrollMargin = CType(resources.GetObject("lbbNewPlayerId.AutoScrollMargin"), System.Drawing.Size)
        Me.lbbNewPlayerId.AutoScrollMinSize = CType(resources.GetObject("lbbNewPlayerId.AutoScrollMinSize"), System.Drawing.Size)
        Me.lbbNewPlayerId.BackgroundImage = CType(resources.GetObject("lbbNewPlayerId.BackgroundImage"), System.Drawing.Image)
        Me.lbbNewPlayerId.Caption = "New Player ID"
        Me.lbbNewPlayerId.CaptionWidth = 50
        Me.lbbNewPlayerId.Dock = CType(resources.GetObject("lbbNewPlayerId.Dock"), System.Windows.Forms.DockStyle)
        Me.lbbNewPlayerId.Enabled = CType(resources.GetObject("lbbNewPlayerId.Enabled"), Boolean)
        Me.lbbNewPlayerId.Font = CType(resources.GetObject("lbbNewPlayerId.Font"), System.Drawing.Font)
        Me.lbbNewPlayerId.ImeMode = CType(resources.GetObject("lbbNewPlayerId.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbbNewPlayerId.Location = CType(resources.GetObject("lbbNewPlayerId.Location"), System.Drawing.Point)
        Me.lbbNewPlayerId.Name = "lbbNewPlayerId"
        Me.lbbNewPlayerId.ReadOnly = False
        Me.lbbNewPlayerId.RightToLeft = CType(resources.GetObject("lbbNewPlayerId.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbbNewPlayerId.Size = CType(resources.GetObject("lbbNewPlayerId.Size"), System.Drawing.Size)
        Me.lbbNewPlayerId.TabIndex = CType(resources.GetObject("lbbNewPlayerId.TabIndex"), Integer)
        Me.ToolTip1.SetToolTip(Me.lbbNewPlayerId, resources.GetString("lbbNewPlayerId.ToolTip"))
        Me.lbbNewPlayerId.Value = ""
        Me.lbbNewPlayerId.Visible = CType(resources.GetObject("lbbNewPlayerId.Visible"), Boolean)
        '
        'panDown
        '
        Me.panDown.AccessibleDescription = resources.GetString("panDown.AccessibleDescription")
        Me.panDown.AccessibleName = resources.GetString("panDown.AccessibleName")
        Me.panDown.Anchor = CType(resources.GetObject("panDown.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.panDown.AutoScroll = CType(resources.GetObject("panDown.AutoScroll"), Boolean)
        Me.panDown.AutoScrollMargin = CType(resources.GetObject("panDown.AutoScrollMargin"), System.Drawing.Size)
        Me.panDown.AutoScrollMinSize = CType(resources.GetObject("panDown.AutoScrollMinSize"), System.Drawing.Size)
        Me.panDown.BackgroundImage = CType(resources.GetObject("panDown.BackgroundImage"), System.Drawing.Image)
        Me.panDown.Dock = CType(resources.GetObject("panDown.Dock"), System.Windows.Forms.DockStyle)
        Me.panDown.Enabled = CType(resources.GetObject("panDown.Enabled"), Boolean)
        Me.panDown.Font = CType(resources.GetObject("panDown.Font"), System.Drawing.Font)
        Me.panDown.ImeMode = CType(resources.GetObject("panDown.ImeMode"), System.Windows.Forms.ImeMode)
        Me.panDown.Location = CType(resources.GetObject("panDown.Location"), System.Drawing.Point)
        Me.panDown.Name = "panDown"
        Me.panDown.RightToLeft = CType(resources.GetObject("panDown.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.panDown.Size = CType(resources.GetObject("panDown.Size"), System.Drawing.Size)
        Me.panDown.TabIndex = CType(resources.GetObject("panDown.TabIndex"), Integer)
        Me.panDown.Text = resources.GetString("panDown.Text")
        Me.ToolTip1.SetToolTip(Me.panDown, resources.GetString("panDown.ToolTip"))
        Me.panDown.Visible = CType(resources.GetObject("panDown.Visible"), Boolean)
        '
        'PlayerInfoCtrl
        '
        Me.AccessibleDescription = resources.GetString("$this.AccessibleDescription")
        Me.AccessibleName = resources.GetString("$this.AccessibleName")
        Me.AutoScroll = CType(resources.GetObject("$this.AutoScroll"), Boolean)
        Me.AutoScrollMargin = CType(resources.GetObject("$this.AutoScrollMargin"), System.Drawing.Size)
        Me.AutoScrollMinSize = CType(resources.GetObject("$this.AutoScrollMinSize"), System.Drawing.Size)
        Me.BackgroundImage = CType(resources.GetObject("$this.BackgroundImage"), System.Drawing.Image)
        Me.Controls.Add(Me.panMain)
        Me.Enabled = CType(resources.GetObject("$this.Enabled"), Boolean)
        Me.Font = CType(resources.GetObject("$this.Font"), System.Drawing.Font)
        Me.ImeMode = CType(resources.GetObject("$this.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Location = CType(resources.GetObject("$this.Location"), System.Drawing.Point)
        Me.Name = "PlayerInfoCtrl"
        Me.RightToLeft = CType(resources.GetObject("$this.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Size = CType(resources.GetObject("$this.Size"), System.Drawing.Size)
        Me.ToolTip1.SetToolTip(Me, resources.GetString("$this.ToolTip"))
        Me.panMain.ResumeLayout(False)
        Me.TabControl1.ResumeLayout(False)
        Me.tpGlobalInfo.ResumeLayout(False)
        Me.panTechno.ResumeLayout(False)
        Me.tpModify.ResumeLayout(False)
        Me.GroupBox2.ResumeLayout(False)
        Me.GroupBox1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

#Region " Redimensionnement dynamique des controles "

    'Redimensionnement de la grille stat lors du redimensionnement du panneau conteneur
    Private Sub tpGlobalInfo_Resize(ByVal sender As Object, ByVal e As System.EventArgs) Handles tpGlobalInfo.Resize
        'chPoints.Width = lvStats.Width - chRank.Width - chType.Width - 4
    End Sub

#End Region

#Region " AutoFeature "


    Private Sub lbStats_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbStats.Click
        lvStats.Visible = Not lvStats.Visible
    End Sub

    Private Sub PlayerInfoCtrl_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Me.Width = 240
    End Sub

    Private Sub PlayerInfoCtrl_SizeChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.SizeChanged
        Me.Width = 240
    End Sub

    Private Sub lbKnownTechno_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbKnownTechno.Click
        panTechno.Visible = Not panTechno.Visible
    End Sub

    Private Sub Label3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Label3.Click
        lbPlanets.Visible = Not lbPlanets.Visible
    End Sub
#End Region

#Region " Evenements envoyés "
    Public Event PlanetSelected(ByVal sender As Object, ByVal Planet As OGameObject.Planet)

#End Region
    Private pPlayer As OGameObject.Player = Nothing
    Public Property Player() As OGameObject.Player
        Get
            Return pPlayer
        End Get
        Set(ByVal Value As OGameObject.Player)
            rtbPlayerNote.Text = ""
            If Value Is Nothing Then
                panTechno.Visible = False
                lbPlanets.Visible = False
                lvStats.Visible = False
                pPlayer = Nothing
                tbNameAlliance.Text = ""
                btnSave.Visible = False
                Return
            End If

            If Value.Equals(pPlayer) Then Return
            pPlayer = Value
            panTechno.Visible = True
            lbPlanets.Visible = True
            lvStats.Visible = True
            btnSave.Visible = True
            tbNameAlliance.Text = pPlayer.Name & " - " & IIf(pPlayer.Alliance.Trim <> "", "[ " & pPlayer.Alliance & " ]", "(No Alliance)")
            lvStats.Items.Clear()
            lbPlanets.Items.Clear()
            With lvStats.Items.Add("General")
                Dim rk As OGameObject.PlayerRank = pPlayer.RankPoints
                If Not rk Is Nothing Then
                    .SubItems.Add(rk.Rank)
                    .SubItems.Add(rk.Points)
                    .SubItems.Add(rk.DataDate.ToShortDateString)
                Else
                    .SubItems.Add("?")
                    .SubItems.Add("?")
                End If
            End With
            With lvStats.Items.Add("Flotte")
                Dim rk As OGameObject.PlayerRank = pPlayer.RankFlotte
                If Not rk Is Nothing Then
                    .SubItems.Add(rk.Rank)
                    .SubItems.Add(rk.Points)
                    .SubItems.Add(rk.DataDate.ToShortDateString)
                Else
                    .SubItems.Add("?")
                    .SubItems.Add("?")
                End If
            End With
            With lvStats.Items.Add("Research")
                Dim rk As OGameObject.PlayerRank = pPlayer.RankResearch
                If Not rk Is Nothing Then
                    .SubItems.Add(rk.Rank)
                    .SubItems.Add(rk.Points)
                    .SubItems.Add(rk.DataDate.ToShortDateString)
                Else
                    .SubItems.Add("?")
                    .SubItems.Add("?")
                End If
            End With
            Dim LastTechno As OGameObject.spydata = pPlayer.GetLastKnownTechnologie
            If LastTechno Is Nothing Then
                tbT_Armor.Text = "?"
                tbT_Combustion.Text = "?"
                tbT_Graviton.Text = "?"
                tbT_Hyperspace.Text = "?"
                tbT_Impulsion.Text = "?"
                tbT_Shield.Text = "?"
                tbT_Weapon.Text = "?"
                lbT_Date.Text = "No report with technology for this player"
            Else
                With LastTechno
                    tbT_Armor.Text = .T_PROTECT
                    tbT_Combustion.Text = .T_COMBUS
                    tbT_Graviton.Text = .T_GRAVITON
                    tbT_Hyperspace.Text = .T_HYPER
                    tbT_Impulsion.Text = .T_IMPULSE
                    tbT_Shield.Text = .T_SHIELD
                    tbT_Weapon.Text = .T_WEAPON
                    lbT_Date.Text = "On " & .DATADATE.ToShortDateString
                End With
            End If
            rtbPlayerNote.Text = pPlayer.Note
            For Each p As OGameObject.Planet In pPlayer.Planets
                p.ToStringFormat = OGameObject.Planet.enToStringFormat.CoordsName
                lbPlanets.Items.Add(p)
            Next
        End Set
    End Property

    Private Sub lbPlanets_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbPlanets.SelectedIndexChanged
        RaiseEvent PlanetSelected(Me, lbPlanets.SelectedItem)
    End Sub

    Private Sub btnSave_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSave.Click
        Dim PlayerWin As New PlayerFrm
        PlayerWin.Player = Player
        PlayerWin.ShowDialog()
        PlayerWin = Nothing
    End Sub
    Private Sub Label1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Label1.Click
        Dim PlayerWin As New PlayerFrm
        PlayerWin.Player = Player
        PlayerWin.ShowDialog()
        PlayerWin = Nothing
    End Sub

#Region " Modify Panel "


    Private Sub btnSelectTransfertTo_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSelectTransfertTo.Click
        Dim p As OGameObject.Player = OGameObject.Player.FromPlayerID(CInt(lbbNewPlayerId.Value))
        btnMoveData.Enabled = Not p Is Nothing AndAlso Not Player Is Nothing
        If Not p Is Nothing Then
            tbNewPlayerInfo.Text = p.Name & " [ " & p.Alliance & "]" & vbCrLf & _
                                  p.DataDate.ToShortDateString

        End If
    End Sub

    Private Sub btnMoveData_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnMoveData.Click
        OGameObject.OGameDBEngine.Default.MoveDataFromPlayerToPlayer(Player.ID, lbbNewPlayerId.Value)
    End Sub




    Private Sub btnGetFrom_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnGetFrom.Click
        OGameObject.OGameDBEngine.Default.MoveDataFromPlayerToPlayer(CInt(lbbGetFromId.Value), Player.ID)
    End Sub

    Private Sub btnSelectGetFrom_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSelectGetFrom.Click

        Dim p As OGameObject.Player = OGameObject.Player.FromPlayerID(CInt(lbbGetFromId.Value))
        btnGetFrom.Enabled = Not p Is Nothing AndAlso Not Player Is Nothing
        If Not p Is Nothing Then
            tbGetFromPlayerInfo.Text = p.Name & " [ " & p.Alliance & "]" & vbCrLf & _
                                  p.DataDate.ToShortDateString

        End If
    End Sub
#End Region




End Class
