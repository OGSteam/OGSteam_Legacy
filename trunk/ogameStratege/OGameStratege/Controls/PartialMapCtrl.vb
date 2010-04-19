Imports System.Text.RegularExpressions
Public Class PartialMapCtrl
    Inherits System.Windows.Forms.UserControl

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call
        'Add any initialization after the InitializeComponent() call
        Me.SetStyle(ControlStyles.DoubleBuffer _
                 Or ControlStyles.UserPaint _
                 Or ControlStyles.AllPaintingInWmPaint, _
                 True)
        '
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
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents panMap As System.Windows.Forms.Panel
    Friend WithEvents labSystemMouseOn As System.Windows.Forms.Label
    Friend WithEvents nudGalaxy As System.Windows.Forms.NumericUpDown
    Friend WithEvents nudSystem As System.Windows.Forms.NumericUpDown
    Friend WithEvents panBottom As System.Windows.Forms.Panel
    Friend WithEvents chkShowRank As System.Windows.Forms.CheckBox
    Friend WithEvents chkShowSpy As System.Windows.Forms.CheckBox
    Friend WithEvents panUp As System.Windows.Forms.Panel
    Friend WithEvents chkLargeCargo As System.Windows.Forms.CheckBox
    Friend WithEvents tbLargeCargoNeeded As System.Windows.Forms.TextBox
    Friend WithEvents chkRecyclers As System.Windows.Forms.CheckBox
    Friend WithEvents tbRecyclerNeeded As System.Windows.Forms.TextBox
    Friend WithEvents cbFavorites As System.Windows.Forms.ComboBox
    Friend WithEvents btnRefresh As System.Windows.Forms.Button
    Friend WithEvents btnUnZoom As System.Windows.Forms.Button
    Friend WithEvents btnZoom As System.Windows.Forms.Button
    Friend WithEvents tbplanetinfo As System.Windows.Forms.TextBox
    Friend WithEvents chkShowOldSpyReports As System.Windows.Forms.CheckBox
    Friend WithEvents tbSpyHourLessThan As System.Windows.Forms.TextBox
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents tbHighlight As System.Windows.Forms.TextBox
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents tbAttackHourLessThan As System.Windows.Forms.TextBox
    Friend WithEvents chkShowAttack As System.Windows.Forms.CheckBox
    Friend WithEvents chkShowOldAttack As System.Windows.Forms.CheckBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(PartialMapCtrl))
        Me.Label1 = New System.Windows.Forms.Label
        Me.panUp = New System.Windows.Forms.Panel
        Me.tbplanetinfo = New System.Windows.Forms.TextBox
        Me.btnZoom = New System.Windows.Forms.Button
        Me.btnUnZoom = New System.Windows.Forms.Button
        Me.cbFavorites = New System.Windows.Forms.ComboBox
        Me.nudSystem = New System.Windows.Forms.NumericUpDown
        Me.nudGalaxy = New System.Windows.Forms.NumericUpDown
        Me.labSystemMouseOn = New System.Windows.Forms.Label
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.panMap = New System.Windows.Forms.Panel
        Me.panBottom = New System.Windows.Forms.Panel
        Me.Label2 = New System.Windows.Forms.Label
        Me.btnRefresh = New System.Windows.Forms.Button
        Me.tbLargeCargoNeeded = New System.Windows.Forms.TextBox
        Me.chkShowRank = New System.Windows.Forms.CheckBox
        Me.chkShowSpy = New System.Windows.Forms.CheckBox
        Me.chkLargeCargo = New System.Windows.Forms.CheckBox
        Me.chkRecyclers = New System.Windows.Forms.CheckBox
        Me.tbRecyclerNeeded = New System.Windows.Forms.TextBox
        Me.chkShowOldSpyReports = New System.Windows.Forms.CheckBox
        Me.tbSpyHourLessThan = New System.Windows.Forms.TextBox
        Me.tbHighlight = New System.Windows.Forms.TextBox
        Me.tbAttackHourLessThan = New System.Windows.Forms.TextBox
        Me.chkShowAttack = New System.Windows.Forms.CheckBox
        Me.chkShowOldAttack = New System.Windows.Forms.CheckBox
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.panUp.SuspendLayout()
        CType(Me.nudSystem, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.nudGalaxy, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel2.SuspendLayout()
        Me.panMap.SuspendLayout()
        Me.panBottom.SuspendLayout()
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(544, 16)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Universe Map"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panUp
        '
        Me.panUp.Controls.Add(Me.tbplanetinfo)
        Me.panUp.Controls.Add(Me.btnZoom)
        Me.panUp.Controls.Add(Me.btnUnZoom)
        Me.panUp.Controls.Add(Me.cbFavorites)
        Me.panUp.Controls.Add(Me.nudSystem)
        Me.panUp.Controls.Add(Me.nudGalaxy)
        Me.panUp.Controls.Add(Me.labSystemMouseOn)
        Me.panUp.Dock = System.Windows.Forms.DockStyle.Top
        Me.panUp.Location = New System.Drawing.Point(0, 16)
        Me.panUp.Name = "panUp"
        Me.panUp.Size = New System.Drawing.Size(544, 24)
        Me.panUp.TabIndex = 1
        '
        'tbplanetinfo
        '
        Me.tbplanetinfo.Dock = System.Windows.Forms.DockStyle.Fill
        Me.tbplanetinfo.Font = New System.Drawing.Font("Comic Sans MS", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tbplanetinfo.Location = New System.Drawing.Point(168, 0)
        Me.tbplanetinfo.Name = "tbplanetinfo"
        Me.tbplanetinfo.ReadOnly = True
        Me.tbplanetinfo.Size = New System.Drawing.Size(280, 26)
        Me.tbplanetinfo.TabIndex = 13
        Me.tbplanetinfo.TextAlign = System.Windows.Forms.HorizontalAlignment.Center
        '
        'btnZoom
        '
        Me.btnZoom.Dock = System.Windows.Forms.DockStyle.Right
        Me.btnZoom.Location = New System.Drawing.Point(448, 0)
        Me.btnZoom.Name = "btnZoom"
        Me.btnZoom.Size = New System.Drawing.Size(16, 24)
        Me.btnZoom.TabIndex = 12
        Me.btnZoom.Text = "-"
        '
        'btnUnZoom
        '
        Me.btnUnZoom.Dock = System.Windows.Forms.DockStyle.Right
        Me.btnUnZoom.Location = New System.Drawing.Point(464, 0)
        Me.btnUnZoom.Name = "btnUnZoom"
        Me.btnUnZoom.Size = New System.Drawing.Size(16, 24)
        Me.btnUnZoom.TabIndex = 11
        Me.btnUnZoom.Text = "+"
        '
        'cbFavorites
        '
        Me.cbFavorites.Dock = System.Windows.Forms.DockStyle.Left
        Me.cbFavorites.Location = New System.Drawing.Point(88, 0)
        Me.cbFavorites.Name = "cbFavorites"
        Me.cbFavorites.Size = New System.Drawing.Size(80, 21)
        Me.cbFavorites.TabIndex = 10
        Me.cbFavorites.Text = "Favorites"
        '
        'nudSystem
        '
        Me.nudSystem.BackColor = System.Drawing.SystemColors.Control
        Me.nudSystem.Dock = System.Windows.Forms.DockStyle.Left
        Me.nudSystem.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.nudSystem.ForeColor = System.Drawing.SystemColors.HotTrack
        Me.nudSystem.Location = New System.Drawing.Point(40, 0)
        Me.nudSystem.Maximum = New Decimal(New Integer() {499, 0, 0, 0})
        Me.nudSystem.Minimum = New Decimal(New Integer() {1, 0, 0, 0})
        Me.nudSystem.Name = "nudSystem"
        Me.nudSystem.Size = New System.Drawing.Size(48, 22)
        Me.nudSystem.TabIndex = 9
        Me.nudSystem.TextAlign = System.Windows.Forms.HorizontalAlignment.Center
        Me.nudSystem.Value = New Decimal(New Integer() {1, 0, 0, 0})
        '
        'nudGalaxy
        '
        Me.nudGalaxy.BackColor = System.Drawing.SystemColors.Control
        Me.nudGalaxy.Dock = System.Windows.Forms.DockStyle.Left
        Me.nudGalaxy.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.nudGalaxy.ForeColor = System.Drawing.SystemColors.HotTrack
        Me.nudGalaxy.Location = New System.Drawing.Point(0, 0)
        Me.nudGalaxy.Maximum = New Decimal(New Integer() {9, 0, 0, 0})
        Me.nudGalaxy.Minimum = New Decimal(New Integer() {1, 0, 0, 0})
        Me.nudGalaxy.Name = "nudGalaxy"
        Me.nudGalaxy.Size = New System.Drawing.Size(40, 22)
        Me.nudGalaxy.TabIndex = 8
        Me.nudGalaxy.TextAlign = System.Windows.Forms.HorizontalAlignment.Center
        Me.nudGalaxy.UpDownAlign = System.Windows.Forms.LeftRightAlignment.Left
        Me.nudGalaxy.Value = New Decimal(New Integer() {1, 0, 0, 0})
        '
        'labSystemMouseOn
        '
        Me.labSystemMouseOn.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.labSystemMouseOn.Dock = System.Windows.Forms.DockStyle.Right
        Me.labSystemMouseOn.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.labSystemMouseOn.ForeColor = System.Drawing.SystemColors.HotTrack
        Me.labSystemMouseOn.Location = New System.Drawing.Point(480, 0)
        Me.labSystemMouseOn.Name = "labSystemMouseOn"
        Me.labSystemMouseOn.Size = New System.Drawing.Size(64, 24)
        Me.labSystemMouseOn.TabIndex = 2
        Me.labSystemMouseOn.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.panMap)
        Me.Panel2.Dock = System.Windows.Forms.DockStyle.Fill
        Me.Panel2.Location = New System.Drawing.Point(0, 40)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(544, 280)
        Me.Panel2.TabIndex = 2
        '
        'panMap
        '
        Me.panMap.BackColor = System.Drawing.Color.Black
        Me.panMap.Controls.Add(Me.panBottom)
        Me.panMap.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panMap.Location = New System.Drawing.Point(0, 0)
        Me.panMap.Name = "panMap"
        Me.panMap.Size = New System.Drawing.Size(544, 280)
        Me.panMap.TabIndex = 0
        '
        'panBottom
        '
        Me.panBottom.BackgroundImage = CType(resources.GetObject("panBottom.BackgroundImage"), System.Drawing.Image)
        Me.panBottom.Controls.Add(Me.Label2)
        Me.panBottom.Controls.Add(Me.btnRefresh)
        Me.panBottom.Controls.Add(Me.tbLargeCargoNeeded)
        Me.panBottom.Controls.Add(Me.chkShowRank)
        Me.panBottom.Controls.Add(Me.chkShowSpy)
        Me.panBottom.Controls.Add(Me.chkLargeCargo)
        Me.panBottom.Controls.Add(Me.chkRecyclers)
        Me.panBottom.Controls.Add(Me.tbRecyclerNeeded)
        Me.panBottom.Controls.Add(Me.chkShowOldSpyReports)
        Me.panBottom.Controls.Add(Me.tbSpyHourLessThan)
        Me.panBottom.Controls.Add(Me.tbHighlight)
        Me.panBottom.Controls.Add(Me.tbAttackHourLessThan)
        Me.panBottom.Controls.Add(Me.chkShowAttack)
        Me.panBottom.Controls.Add(Me.chkShowOldAttack)
        Me.panBottom.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.panBottom.Location = New System.Drawing.Point(0, 232)
        Me.panBottom.Name = "panBottom"
        Me.panBottom.Size = New System.Drawing.Size(544, 48)
        Me.panBottom.TabIndex = 0
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!)
        Me.Label2.ForeColor = System.Drawing.Color.White
        Me.Label2.Location = New System.Drawing.Point(2, 5)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(44, 12)
        Me.Label2.TabIndex = 3
        Me.Label2.Text = "HighLight"
        '
        'btnRefresh
        '
        Me.btnRefresh.BackColor = System.Drawing.SystemColors.Control
        Me.btnRefresh.Dock = System.Windows.Forms.DockStyle.Right
        Me.btnRefresh.Image = CType(resources.GetObject("btnRefresh.Image"), System.Drawing.Image)
        Me.btnRefresh.Location = New System.Drawing.Point(496, 0)
        Me.btnRefresh.Name = "btnRefresh"
        Me.btnRefresh.Size = New System.Drawing.Size(48, 48)
        Me.btnRefresh.TabIndex = 2
        Me.btnRefresh.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.ToolTip1.SetToolTip(Me.btnRefresh, "Refresh Map")
        Me.btnRefresh.UseVisualStyleBackColor = False
        '
        'tbLargeCargoNeeded
        '
        Me.tbLargeCargoNeeded.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tbLargeCargoNeeded.Location = New System.Drawing.Point(296, 3)
        Me.tbLargeCargoNeeded.Name = "tbLargeCargoNeeded"
        Me.tbLargeCargoNeeded.Size = New System.Drawing.Size(32, 18)
        Me.tbLargeCargoNeeded.TabIndex = 1
        Me.tbLargeCargoNeeded.Text = "20"
        '
        'chkShowRank
        '
        Me.chkShowRank.BackColor = System.Drawing.Color.Transparent
        Me.chkShowRank.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.chkShowRank.ForeColor = System.Drawing.Color.White
        Me.chkShowRank.Location = New System.Drawing.Point(160, 0)
        Me.chkShowRank.Name = "chkShowRank"
        Me.chkShowRank.Size = New System.Drawing.Size(48, 24)
        Me.chkShowRank.TabIndex = 0
        Me.chkShowRank.Text = "Rank"
        Me.chkShowRank.UseVisualStyleBackColor = False
        '
        'chkShowSpy
        '
        Me.chkShowSpy.BackColor = System.Drawing.Color.Transparent
        Me.chkShowSpy.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.chkShowSpy.ForeColor = System.Drawing.Color.White
        Me.chkShowSpy.Location = New System.Drawing.Point(8, 21)
        Me.chkShowSpy.Name = "chkShowSpy"
        Me.chkShowSpy.Size = New System.Drawing.Size(48, 24)
        Me.chkShowSpy.TabIndex = 0
        Me.chkShowSpy.Text = "Spy <"
        Me.chkShowSpy.UseVisualStyleBackColor = False
        '
        'chkLargeCargo
        '
        Me.chkLargeCargo.BackColor = System.Drawing.Color.Transparent
        Me.chkLargeCargo.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.chkLargeCargo.ForeColor = System.Drawing.Color.White
        Me.chkLargeCargo.Location = New System.Drawing.Point(216, 0)
        Me.chkLargeCargo.Name = "chkLargeCargo"
        Me.chkLargeCargo.Size = New System.Drawing.Size(80, 24)
        Me.chkLargeCargo.TabIndex = 0
        Me.chkLargeCargo.Text = "Large Cargo"
        Me.chkLargeCargo.UseVisualStyleBackColor = False
        '
        'chkRecyclers
        '
        Me.chkRecyclers.BackColor = System.Drawing.Color.Transparent
        Me.chkRecyclers.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.chkRecyclers.ForeColor = System.Drawing.Color.White
        Me.chkRecyclers.Location = New System.Drawing.Point(336, 0)
        Me.chkRecyclers.Name = "chkRecyclers"
        Me.chkRecyclers.Size = New System.Drawing.Size(80, 24)
        Me.chkRecyclers.TabIndex = 0
        Me.chkRecyclers.Text = "Recyclers"
        Me.chkRecyclers.UseVisualStyleBackColor = False
        '
        'tbRecyclerNeeded
        '
        Me.tbRecyclerNeeded.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tbRecyclerNeeded.Location = New System.Drawing.Point(416, 3)
        Me.tbRecyclerNeeded.Name = "tbRecyclerNeeded"
        Me.tbRecyclerNeeded.Size = New System.Drawing.Size(32, 18)
        Me.tbRecyclerNeeded.TabIndex = 1
        Me.tbRecyclerNeeded.Text = "20"
        '
        'chkShowOldSpyReports
        '
        Me.chkShowOldSpyReports.BackColor = System.Drawing.Color.Transparent
        Me.chkShowOldSpyReports.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.chkShowOldSpyReports.ForeColor = System.Drawing.Color.White
        Me.chkShowOldSpyReports.Location = New System.Drawing.Point(104, 21)
        Me.chkShowOldSpyReports.Name = "chkShowOldSpyReports"
        Me.chkShowOldSpyReports.Size = New System.Drawing.Size(64, 24)
        Me.chkShowOldSpyReports.TabIndex = 0
        Me.chkShowOldSpyReports.Text = "Older spy"
        Me.chkShowOldSpyReports.UseVisualStyleBackColor = False
        '
        'tbSpyHourLessThan
        '
        Me.tbSpyHourLessThan.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tbSpyHourLessThan.Location = New System.Drawing.Point(56, 24)
        Me.tbSpyHourLessThan.Name = "tbSpyHourLessThan"
        Me.tbSpyHourLessThan.Size = New System.Drawing.Size(24, 18)
        Me.tbSpyHourLessThan.TabIndex = 1
        Me.tbSpyHourLessThan.Text = "24"
        '
        'tbHighlight
        '
        Me.tbHighlight.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tbHighlight.Location = New System.Drawing.Point(48, 3)
        Me.tbHighlight.Name = "tbHighlight"
        Me.tbHighlight.Size = New System.Drawing.Size(96, 18)
        Me.tbHighlight.TabIndex = 1
        Me.ToolTip1.SetToolTip(Me.tbHighlight, "Separate keywor by comma , Sample 'Name1,Name2'")
        '
        'tbAttackHourLessThan
        '
        Me.tbAttackHourLessThan.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tbAttackHourLessThan.Location = New System.Drawing.Point(248, 24)
        Me.tbAttackHourLessThan.Name = "tbAttackHourLessThan"
        Me.tbAttackHourLessThan.Size = New System.Drawing.Size(24, 18)
        Me.tbAttackHourLessThan.TabIndex = 1
        Me.tbAttackHourLessThan.Text = "24"
        '
        'chkShowAttack
        '
        Me.chkShowAttack.BackColor = System.Drawing.Color.Transparent
        Me.chkShowAttack.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.chkShowAttack.ForeColor = System.Drawing.Color.White
        Me.chkShowAttack.Location = New System.Drawing.Point(184, 21)
        Me.chkShowAttack.Name = "chkShowAttack"
        Me.chkShowAttack.Size = New System.Drawing.Size(64, 24)
        Me.chkShowAttack.TabIndex = 0
        Me.chkShowAttack.Text = "Attack <"
        Me.chkShowAttack.UseVisualStyleBackColor = False
        '
        'chkShowOldAttack
        '
        Me.chkShowOldAttack.BackColor = System.Drawing.Color.Transparent
        Me.chkShowOldAttack.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.chkShowOldAttack.ForeColor = System.Drawing.Color.White
        Me.chkShowOldAttack.Location = New System.Drawing.Point(296, 21)
        Me.chkShowOldAttack.Name = "chkShowOldAttack"
        Me.chkShowOldAttack.Size = New System.Drawing.Size(80, 24)
        Me.chkShowOldAttack.TabIndex = 0
        Me.chkShowOldAttack.Text = "Older Attack"
        Me.chkShowOldAttack.UseVisualStyleBackColor = False
        '
        'PartialMapCtrl
        '
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.panUp)
        Me.Controls.Add(Me.Label1)
        Me.Name = "PartialMapCtrl"
        Me.Size = New System.Drawing.Size(544, 320)
        Me.panUp.ResumeLayout(False)
        Me.panUp.PerformLayout()
        CType(Me.nudSystem, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.nudGalaxy, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel2.ResumeLayout(False)
        Me.panMap.ResumeLayout(False)
        Me.panBottom.ResumeLayout(False)
        Me.panBottom.PerformLayout()
        Me.ResumeLayout(False)

    End Sub

#End Region

#Region " Evenements recu "
    Private Sub nudSystem_ValueChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles nudSystem.ValueChanged
        If FirstSystem <> nudSystem.Value Then
            FirstSystem = nudSystem.Value

            doReadSystems()
            Me.panMap.Invalidate()
        End If
    End Sub
    Private Sub nudGalaxy_ValueChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles nudGalaxy.ValueChanged
        doReadSystems()
        Me.panMap.Invalidate()
    End Sub
    Private Sub PartialMapCtrl_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load

        Me.panMap.Height = HeaderSize.Height + PlanetHeight * 15
        '        Console.WriteLine(Me.panMap.Location.ToString)
        '       Console.WriteLine(Me.panMap.Size.ToString)
        'panBottom.Top = HeaderSize.Height + PlanetHeight * 15 + 1
        Me.Height = Label1.Height + panUp.Height + panMap.Height

        If OGameObject.OGameDBEngine.Default Is Nothing Then Return
        MainForm.TopForm.Universes1.LoadCurrentUniverseOptions()
        For Each dbc As OGameObject.DBConfigEntry In OGameObject.OGameDBEngine.Default.GetFavorites
            cbFavorites.Items.Add(dbc.ParamValue)
        Next
        If cbFavorites.Items.Count > 0 Then
            cbFavorites.SelectedIndex = 0
            cbFavorites_Validated(Nothing, Nothing)
        End If
        doReadSystems()
        Me.panMap.Invalidate()

    End Sub


    Private Sub chkShow_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkShowSpy.CheckedChanged, chkShowRank.CheckedChanged, chkRecyclers.CheckedChanged, chkLargeCargo.CheckedChanged, chkShowOldSpyReports.CheckedChanged, chkShowAttack.CheckedChanged, chkShowOldAttack.CheckedChanged
        Me.panMap.Invalidate()
    End Sub

    Private Sub tbLargeCargoNeeded_validated(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tbLargeCargoNeeded.Validated
        If Not IsNumeric(tbLargeCargoNeeded.Text) Then tbLargeCargoNeeded.Text = 1
        If chkLargeCargo.Checked Then
            Me.panMap.Invalidate()
        End If
    End Sub

    Private Sub tbRecyclerNeeded_validate(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tbRecyclerNeeded.Validated
        If Not IsNumeric(tbRecyclerNeeded.Text) Then tbRecyclerNeeded.Text = 1
        If chkRecyclers.Checked Then
            Me.panMap.Invalidate()
        End If
    End Sub

    Private Sub btnRefresh_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnRefresh.Click
        SystemsReaded.Clear()
        doReadSystems()
        MainForm.TopForm.Universes1.SaveCurrentUniverseOption()
    End Sub

    Private Sub btnZoom_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnZoom.Click
        SystemWidth += 4

    End Sub

    Private Sub btnUnZoom_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnUnZoom.Click
        If SystemWidth > 15 Then SystemWidth -= 4
    End Sub

    Private HighlightedWord As Collections.Specialized.StringCollection = New Collections.Specialized.StringCollection
    Private Sub tbHighlight_Validated(ByVal sender As Object, ByVal e As System.EventArgs) Handles tbHighlight.Validated
        HighlightedWord = New Collections.Specialized.StringCollection
        If tbHighlight.Text.Trim <> "" Then
            tbHighlight.Text = tbHighlight.Text.Trim.ToUpper
            For Each s As String In tbHighlight.Text.Split(",")
                HighlightedWord.Add(s)
            Next
            Me.panMap.Invalidate()
        End If
    End Sub

    Private Sub tbSpyHourLessThan_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tbSpyHourLessThan.Validated
        If Not IsNumeric(tbSpyHourLessThan.Text) Then tbSpyHourLessThan.Text = 1
        If chkShowOldSpyReports.Checked OrElse chkShowSpy.Checked Then
            Me.panMap.Invalidate()
        End If
    End Sub

    Private Sub panMap_SizeChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles panMap.SizeChanged
        If Not (_backBuffer Is Nothing) Then
            _backBuffer.Dispose()
            _backBuffer = Nothing
        End If
    End Sub
#End Region

#Region " Evenements envoyés "
    ''' <summary>
    ''' Evenememt: L'utilisateur a cliqué sur une planète
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="planet"></param>
    ''' <remarks></remarks>
    Public Event PlanetSelected(ByVal sender As Object, ByVal planet As OGameObject.Planet)
    ''' <summary>
    ''' Evenement: L'utilisateur a cliqué sur un système
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="Galaxy"></param>
    ''' <remarks></remarks>
    Public Event SystemSelected(ByVal sender As Object, ByVal Galaxy As OGameObject.Galaxy)
    Public Event PlanetInfoRequest(ByVal sender As Object, ByVal planet As OGameObject.Planet)
#End Region

#Region " Propriétés du mappage "
    Private pGalaxy As Integer
    Public Property Galaxy() As Integer
        Get
            Return pGalaxy
        End Get
        Set(ByVal Value As Integer)
            If pGalaxy <> Value Then
                pGalaxy = Value
                Me.panMap.Invalidate()
            End If
        End Set
    End Property

    Private pFirstSytem As Integer = 1
    Public Property FirstSystem() As Integer
        Get
            Return pFirstSytem
        End Get
        Set(ByVal Value As Integer)
            If pFirstSytem <> Value Then
                pFirstSytem = Value
                Me.panMap.Invalidate()
            End If
        End Set
    End Property

    Private pShowGrid As Boolean = False
    Public Property ShowGrid() As Boolean
        Get
            Return pShowGrid
        End Get
        Set(ByVal Value As Boolean)
            pShowGrid = Value
            panMap.Invalidate()
        End Set
    End Property
    Private recordLastSysNumber As Integer
    Public ReadOnly Property SystemsNumber() As Integer
        Get
            Try
                If recordLastSysNumber <> CInt(panMap.Width / SystemWidth) Then
                    recordLastSysNumber = CInt(panMap.Width / SystemWidth)
                    doReadSystems()
                    'Me.panMap.Invalidate()
                End If
                Return recordLastSysNumber
            Catch ex As Exception
                Return 4
            End Try

        End Get
    End Property
#End Region

#Region " Propriétés GDI "
    Public Property MapFont() As Font
        Get
            Return Me.Font
        End Get
        Set(ByVal Value As Font)

        End Set
    End Property

    Private pGridColor As Color = Color.SteelBlue
    Public Property GridColor() As Color
        Get
            Return pGridColor
        End Get
        Set(ByVal Value As Color)
            pGridColor = Value
            panMap.Invalidate()
        End Set
    End Property
#End Region

#Region " Coordonnées et Region de Mapping  "
    Public Function SystemTopLeft(ByVal sys As Integer) As PointF
        If sys < 1 Then Return PointF.Empty
        Return New PointF((sys - FirstSystem) * SystemWidth + 2 + LeftColumnWidth, 2)
    End Function

    Private pSystemWidth As Integer = 20
    Public Property SystemWidth() As Integer
        Get
            Return pSystemWidth
        End Get
        Set(ByVal Value As Integer)
            If pSystemWidth <> Value Then
                pSystemWidth = Value
                Me.panMap.Invalidate()
            End If
        End Set
    End Property

    Private pPlanetHeight As Integer = 15
    Public Property PlanetHeight() As Integer
        Get
            Return pPlanetHeight
        End Get
        Set(ByVal Value As Integer)
            If pPlanetHeight <> Value Then
                pPlanetHeight = Value
                panMap.Invalidate()
            End If
        End Set
    End Property

    Private pLeftColumnWidth As Integer = 32
    Public Property LeftColumnWidth() As Integer
        Get
            Return pLeftColumnWidth
        End Get
        Set(ByVal Value As Integer)
            If pLeftColumnWidth <> Value Then
                pLeftColumnWidth = Value
                panMap.Invalidate()
            End If
        End Set
    End Property

    Public ReadOnly Property HeaderSize() As SizeF
        Get
            Return New SizeF(SystemWidth, SystemWidth)
        End Get
    End Property

    Public Function HeaderRectF(ByVal sys As Integer) As RectangleF
        If sys < 1 Then Return RectangleF.Empty
        Return New RectangleF(SystemTopLeft(sys), HeaderSize)
    End Function

    Public Function PlanetRectF(ByVal sys As Integer, ByVal planetnum As Integer) As RectangleF
        With HeaderRectF(sys)
            Return New RectangleF(.Left, .Height + (planetnum - 1) * PlanetHeight, SystemWidth - 2, PlanetHeight)
        End With
    End Function

    Public Function LeftColumnRectF() As RectangleF
        Return New RectangleF(0, 0, LeftColumnWidth, HeaderSize.Height + SystemsNumber * PlanetHeight)
    End Function
#End Region

#Region " Affichage Map "
    Private _backBuffer As Bitmap
    Private Sub panMap_Paint(ByVal sender As Object, ByVal e As System.Windows.Forms.PaintEventArgs) Handles panMap.Paint
        'If _backBuffer Is Nothing Then
        '_backBuffer = New Bitmap(Me.panMap.ClientSize.Width, Me.panMap.ClientSize.Height)
        'End If

        ' Dim g As Graphics = Graphics.FromImage(_backBuffer)
        'g.Clear(panMap.BackColor)
        PaintGrid(e, e.Graphics)
        PaintHeader(e, e.Graphics)
        'e.Graphics.DrawImageUnscaled(_backBuffer, 0, 0)
        PaintSystems(e, e.Graphics)
        'g.Dispose()
        'e.Graphics.DrawImageUnscaled(_backBuffer, 0, 0)
    End Sub

    Private Sub PaintGrid(ByVal e As System.Windows.Forms.PaintEventArgs, ByVal g As Graphics)
        If Not ShowGrid Then Return
        Dim GridPen As Pen = New Pen(GridColor, 1)
        For i As Integer = 0 To SystemsNumber - 1
            With g
                '                .DrawLine(GridPen, i * SystemWidth, 40, i * SystemWidth, panMap.Height)
                .DrawLine(GridPen, LeftColumnRectF.Width + i * SystemWidth, HeaderSize.Height, LeftColumnRectF.Width + i * SystemWidth, HeaderSize.Height + 15 * PlanetHeight)
            End With
        Next
        GridPen.Dispose()
    End Sub
    Protected Sub PaintHeader(ByVal e As System.Windows.Forms.PaintEventArgs, ByVal g As Graphics)
        Dim mStringFormat As New StringFormat
        mStringFormat.Alignment = StringAlignment.Center
        mStringFormat.LineAlignment = StringAlignment.Center
        g.FillRectangle(Brushes.Black, 0, 0, Me.panMap.Width, HeaderSize.Height)
        For i As Integer = 0 To SystemsNumber - 1
            With g
                If e.ClipRectangle.IntersectsWith(Rectangle.Round(HeaderRectF(i + FirstSystem))) Then _
                    .DrawString(FirstSystem + i, Me.panMap.Font, Brushes.Gold, HeaderRectF(i + FirstSystem), mStringFormat)

            End With
        Next
        For i As Integer = 1 To 15
            With g
                If e.ClipRectangle.IntersectsWith(Rectangle.Round(New RectangleF(0, PlanetRectF(1, i).Top, LeftColumnWidth, PlanetHeight))) Then _
                    .DrawString(i, Me.panMap.Font, Brushes.Yellow, New RectangleF(0, PlanetRectF(1, i).Top, LeftColumnWidth, PlanetHeight), mStringFormat)
            End With
        Next
        mStringFormat.Dispose()
    End Sub
    Protected Sub PaintSystems(ByVal e As System.Windows.Forms.PaintEventArgs, ByVal gr As Graphics)
        For i As Integer = FirstSystem To FirstSystem + SystemsNumber - 1

            Dim g As OGameObject.Galaxy = SystemsReaded.GetSystemIfReaded(nudGalaxy.Value, i)
            If Not g Is Nothing Then
                For Each pla As OGameObject.Planet In g.Planets
                    PaintPlanet(pla, e, gr)
                Next
            End If
        Next
        'PaintPlanet(Galaxy, 10, 10, e)
        'PaintPlanet(Galaxy, 8, 9, e)

    End Sub
    'Private selectedplanetscoord As String
    Private SelectedSystem As Integer = 0
    Private SelectedPlanetNum As Integer = 0
    Protected Sub PaintPlanet(ByVal __Planet As OGameObject.Planet, ByVal e As System.Windows.Forms.PaintEventArgs, ByVal g As Graphics)
        Try

            Dim PlaRect As RectangleF = PlanetRectF(__Planet.System, __Planet.Num)
        If e.ClipRectangle.IntersectsWith(Rectangle.Round(PlaRect)) Then
                '            TimeThisProc("PaintPlanet start")
                Dim RectPen As Pen = Pens.Black
                If HighlightedWord.Count > 0 Then
                    For Each word As String In HighlightedWord
                        If __Planet.Owner.Name.ToUpper.IndexOf(word) > -1 _
                        OrElse __Planet.Owner.Alliance.ToUpper.IndexOf(word) > -1 Then
                            RectPen = Pens.DeepPink
                            Exit For
                        End If
                    Next

                End If
                g.DrawRectangle(RectPen, Rectangle.Round(PlaRect))
                If chkLargeCargo.Checked Then

                    If __Planet.SpyingReports.Count > 0 AndAlso __Planet.SpyingReports.Item(0).GetSpyData.LargeCargoNeeded > tbLargeCargoNeeded.Text Then
                        Dim p As New Pen(Color.LightGreen, 2)
                        g.DrawRectangle(p, Rectangle.Round(PlaRect))
                        p.Dispose()
                    End If
                End If
                If chkRecyclers.Checked Then
                    If __Planet.SpyingReports.Count > 0 AndAlso __Planet.SpyingReports.Item(0).GetSpyData.RecyclerNeeded > tbRecyclerNeeded.Text Then


                        Dim p As New Pen(Color.White, 1)
                        PlaRect.Inflate(-1, -1)
                        g.DrawRectangle(p, Rectangle.Round(PlaRect))
                        p.Dispose()
                        PlaRect.Inflate(1, 1)
                    End If
                End If
                If SelectedSystem = __Planet.System AndAlso SelectedPlanetNum = __Planet.Num Then
                    g.DrawRectangle(Pens.Gold, Rectangle.Round(PlaRect))
                End If

                PlaRect.Inflate(-2, -2)
                Dim b As SolidBrush = Brushes.Black
                With __Planet

                    If __Planet.Name.Trim <> "" Then
                        b = Brushes.DarkBlue

                        If __Planet.Moon.Trim <> "" Then
                            b = Brushes.Crimson
                        End If
                        If .Owner.ShortInactive Then b = Brushes.SaddleBrown
                        If .Owner.LongInactive Then b = Brushes.SandyBrown
                        If .Owner.Vacancy Then b = Brushes.LightBlue
                        If .Owner.Noob Then b = Brushes.LightGreen
                        If Not selectedplanet Is Nothing Then
                            If selectedplanet.Owner.Name <> "" AndAlso selectedplanet.Owner.ID = .Owner.ID Then
                                If .Moon <> "" Then
                                    b = Brushes.Salmon
                                Else
                                    b = Brushes.RoyalBlue
                                End If
                            End If
                        End If
                    End If
                    g.FillRectangle(b, PlaRect)
                    If Not .Owner Is Nothing AndAlso chkShowRank.Checked Then
                        If Not .Owner.RankPoints Is Nothing Then
                            'e.Graphics.DrawEllipse(Pens.Gold, )
                            g.FillEllipse(Brushes.Gold, New RectangleF(PlaRect.X, PlaRect.Y, 5, 5))
                        End If
                        If Not .Owner.RankFlotte Is Nothing Then
                            'e.Graphics.DrawEllipse(Pens.White, New RectangleF(PlaRect.X, PlaRect.Y + 7, 5, 5))
                            g.FillEllipse(Brushes.White, New RectangleF(PlaRect.X + 5, PlaRect.Y, 5, 5))
                        End If
                    End If
                    If chkShowSpy.Checked OrElse chkShowOldSpyReports.Checked Then
                        If .SpyingReports.Count > 0 Then
                            If .SpyingReports.Item(0).DataDate > Now.Subtract(TimeSpan.FromHours(CInt(tbSpyHourLessThan.Text))) AndAlso chkShowSpy.Checked Then
                                b = Brushes.LightGreen
                            End If
                            If .SpyingReports.Item(0).DataDate < Now.Subtract(TimeSpan.FromHours(CInt(tbSpyHourLessThan.Text))) AndAlso chkShowOldSpyReports.Checked Then
                                b = Brushes.LightPink
                            End If
                            g.FillEllipse(b, New RectangleF(PlaRect.X, PlaRect.Y + 5, 5, 5))
                        End If
                    End If
                    If chkShowAttack.Checked OrElse chkShowOldAttack.Checked Then
                        If .AttackReports.Count > 0 Then
                            If .AttackReports.Item(0).DataDate > Now.Subtract(TimeSpan.FromHours(CInt(tbAttackHourLessThan.Text))) AndAlso chkShowAttack.Checked Then
                                b = Brushes.White
                                g.FillEllipse(b, New RectangleF(PlaRect.X + 5, PlaRect.Y + 5, 10, 5))
                            End If
                            If .AttackReports.Item(0).DataDate < Now.Subtract(TimeSpan.FromHours(CInt(tbAttackHourLessThan.Text))) AndAlso chkShowOldAttack.Checked Then
                                b = Brushes.Yellow
                                g.FillEllipse(b, New RectangleF(PlaRect.X + 5, PlaRect.Y + 5, 5, 5))
                            End If

                        End If
                    End If
                End With

            End If
        '                    PaintPlanet(pla.Galaxy, pla.System, pla.Num, e)
            '       TimeThisProc("PaintPlanet end")
        Catch ex As Exception
            Static errorunknown As Integer = 0
            If errorunknown < 3 Then
                Console.WriteLine("PaintPlanet Error:" & vbCrLf & ex.Message & vbCrLf & ex.StackTrace)
                errorunknown += 1
                Beep()
                Beep()
            End If
        End Try

    End Sub
#End Region

#Region " Conversion et Gestion Souris "




    Private Sub panMap_MouseMove(ByVal sender As Object, ByVal e As System.Windows.Forms.MouseEventArgs) Handles panMap.MouseMove
        Dim XPlanet, YPlanet As Integer
        XPlanet = ((e.X - LeftColumnWidth) \ SystemWidth) + 1
        YPlanet = ((e.Y - HeaderSize.Height) \ PlanetHeight) + 1
        If MouseOn(XPlanet, YPlanet) = enMouseOn.Planets Then
            labSystemMouseOn.Text = "[" & XPlanet + FirstSystem - 1 & "," & YPlanet & "]"
            Dim galsys As OGameObject.Galaxy = SystemsReaded.GetSystemIfReaded(nudGalaxy.Value, XPlanet + FirstSystem - 1)
            If Not galsys Is Nothing Then
                Dim pl As OGameObject.Planet = galsys.PlanetNum(YPlanet)
                If pl Is Nothing Then
                    tbplanetinfo.Text = ""
                Else
                    tbplanetinfo.Text = pl.Owner.Name & "     [  " & IIf(pl.Owner.Alliance.Trim = "", "(No Alliance)", pl.Owner.Alliance) & "  ]"
                End If
            End If
        Else
            labSystemMouseOn.Text = ""
        End If

    End Sub
    Private Sub panMap_MouseWheel(ByVal sender As Object, ByVal e As System.Windows.Forms.MouseEventArgs) Handles panMap.MouseWheel
        If e.Delta < 0 AndAlso nudSystem.Value < 490 Then
            nudSystem.Value += 5
        End If
        If e.Delta > 0 AndAlso nudSystem.Value > 6 Then
            nudSystem.Value -= 5
        End If
    End Sub
    Private selectedplanet As OGameObject.Planet
    Private selectedcol As OGameObject.PlanetCol = Nothing
    Private Sub panMap_MouseUp(ByVal sender As Object, ByVal e As System.Windows.Forms.MouseEventArgs) Handles panMap.MouseUp
        Dim XPlanet, YPlanet As Integer
        XPlanet = ((e.X - LeftColumnWidth) \ SystemWidth) + 1
        YPlanet = ((e.Y - HeaderSize.Height) \ PlanetHeight) + 1
        Me.panMap.Focus()
        Select Case MouseOn(XPlanet, YPlanet)
            Case enMouseOn.Planets
                Dim galsys As OGameObject.Galaxy = SystemsReaded.GetSystemIfReaded(nudGalaxy.Value, XPlanet + FirstSystem - 1)
                If Not galsys Is Nothing Then
                    Dim pl As OGameObject.Planet = galsys.PlanetNum(YPlanet)
                    If SelectedSystem <> 0 AndAlso SelectedPlanetNum <> 0 Then
                        Me.panMap.Invalidate(Rectangle.Round(PlanetRectF(SelectedSystem, SelectedPlanetNum)))
                    End If
                    If Not pl Is Nothing Then
                        'TimeThisProc("
                        SelectedSystem = pl.System
                        SelectedPlanetNum = pl.Num
                        selectedplanet = pl
                        If Not selectedcol Is Nothing Then
                            For Each p As OGameObject.Planet In selectedcol
                                If p.Galaxy = nudGalaxy.Value Then panMap.Invalidate(Rectangle.Round(PlanetRectF(p.System, p.Num)))
                            Next
                        End If
                        selectedcol = Nothing
                        selectedcol = SystemsReaded.PlanetForOwner(pl.Owner.ID)
                        For Each p As OGameObject.Planet In selectedcol
                            If p.Galaxy = nudGalaxy.Value Then panMap.Invalidate(Rectangle.Round(PlanetRectF(p.System, p.Num)))
                        Next
                        'Me.panMap.Invalidate(Rectangle.Round(PlanetRectF(SelectedSystem, SelectedPlanetNum)))
                        RaiseEvent PlanetSelected(Me, pl)
                    End If
                End If
            Case enMouseOn.MapHeader
                SelectedSystem = 0
                SelectedPlanetNum = 0
                selectedplanet = Nothing
                '                MsgBox(nudGalaxy.Value & ":" & XPlanet + FirstSystem - 1)
                RaiseEvent SystemSelected(Me, SystemsReaded.GetSystem(nudGalaxy.Value, XPlanet + FirstSystem - 1))
            Case Else
                SelectedSystem = 0
                SelectedPlanetNum = 0
                selectedplanet = Nothing

        End Select
    End Sub
    Private Sub panMap_DoubleClick(ByVal sender As Object, ByVal e As System.EventArgs) Handles panMap.DoubleClick
        If selectedplanet Is Nothing Then Return
        RaiseEvent PlanetInfoRequest(Me, selectedplanet)
    End Sub

    Public Enum enMouseOn
        MapHeader
        LeftColumn
        Planets
        UnderMap
    End Enum
    Protected Function MouseOn(ByVal XPla As Integer, ByVal YPla As Integer) As enMouseOn
        If YPla < 1 Then Return enMouseOn.MapHeader
        If YPla > 15 Then Return enMouseOn.UnderMap
        If XPla < 1 Then Return enMouseOn.LeftColumn
        Return enMouseOn.Planets
    End Function
#End Region

#Region " Accès base de données "
    Public WithEvents SystemsReaded As New OGameObject.GalaxyCol
    Private Sub SystemsReaded_GalaxyReaded(ByVal ReadedGalaxy As OGameObject.Galaxy) Handles SystemsReaded.GalaxyReaded
        'Console.WriteLine("Galaxy : " & ReadedGalaxy.ToString)
        'panMap.SuspendLayout()

        panMap.Invalidate(Rectangle.Round(New RectangleF(SystemTopLeft(ReadedGalaxy.System), New SizeF(SystemWidth, panMap.Height))))
        For Each pl As OGameObject.Planet In ReadedGalaxy.Planets
            'pl.SpyingReports.
            '            panMap.Invalidate(Rectangle.Round(PlanetRectF(pl.System, pl.Num)))
            ' Console.Write(pl.System & ":" & pl.Num & "(" & PlanetRectF(pl.System, pl.Num).ToString & ")")
        Next
        'panMap.ResumeLayout()
        'Console.WriteLine()
    End Sub
    Delegate Sub DelegReadSystems()
    Protected Sub ReadSystems(ByVal state As Object)
        Try
            ' TimeThisProc("readsystem start")
            If readingDB Then Exit Sub

            'Dim startsys As Integer = FirstSystem
            'Dim numsys As Integer = SystemsNumber

            readingDB = True
            '            Console.WriteLine("Reading from DB systems for mapping")
            SyncLock SystemsReaded
                SystemsReaded.ReadSystems(nudGalaxy.Value, nudSystem.Value, nudSystem.Value + SystemsNumber, chkShowSpy.Checked, chkShowRank.Checked)
            End SyncLock
            readingDB = False

            'If startsys <> FirstSystem OrElse numsys <> SystemsNumber Then
            '    ReadSystems(Nothing)
            'Else


            Me.panMap.Invalidate()
            'End If
            'TimeThisProc("readsystem end")
        Catch ex As Exception
            MsgBox(ex.Message & vbCrLf & ex.StackTrace)
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
        End Try

    End Sub
    Private readingDB As Boolean = False
    Public Sub doReadSystems()

        System.Threading.ThreadPool.QueueUserWorkItem(AddressOf Me.ReadSystems)
    End Sub
#End Region

#Region " Les Favoris "
    Private Sub cbFavorites_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbFavorites.SelectedIndexChanged
        Dim GalSysPattern As String = "(?<Galaxy>\d):(?<System>\d+)"
        Dim m As Match = Regex.Match(cbFavorites.Text, GalSysPattern)
        If m.Success Then

            nudGalaxy.Value = m.Groups("Galaxy").Value
            nudSystem.Value = m.Groups("System").Value - (SystemsNumber / 2)
            If cbFavorites.Items.IndexOf(cbFavorites.Text) < 0 Then
                cbFavorites.Items.Insert(0, cbFavorites.Text)
                If Not OGameObject.DBConfigEntry.Exist("FAVORITE", cbFavorites.Text) Then
                    Dim DBC As New OGameObject.DBConfigEntry("FAVORITE", cbFavorites.Text)
                    DBC.InsertUpdate()
                End If
            End If
        End If
        Me.panMap.Invalidate()
    End Sub

    Private Sub cbFavorites_Validated(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbFavorites.Validated
        Dim GalSysPattern As String = "(?<Galaxy>\d):(?<System>\d+)"
        Dim m As Match = Regex.Match(cbFavorites.Text, GalSysPattern)
        If m.Success Then
            nudGalaxy.Value = m.Groups("Galaxy").Value
            nudSystem.Value = m.Groups("System").Value - (SystemsNumber / 2)
            If cbFavorites.Items.IndexOf(cbFavorites.Text) < 0 Then
                cbFavorites.Items.Insert(0, cbFavorites.Text)
                If Not OGameObject.DBConfigEntry.Exist("FAVORITE", cbFavorites.Text) Then
                    Dim DBC As New OGameObject.DBConfigEntry("FAVORITE", cbFavorites.Text)
                    DBC.InsertUpdate()
                End If
            End If
        End If
        Me.panMap.Invalidate()
    End Sub
#End Region



End Class

