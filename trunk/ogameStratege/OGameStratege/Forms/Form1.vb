
Public Class MainForm
    Inherits System.Windows.Forms.Form
    Declare Function OpenIcon Lib "user32" (ByVal hwnd As Long) As Long
    Declare Function SetForegroundWindow Lib "user32" (ByVal hwnd As Long) As Long
    Declare Function SetClipboardViewer Lib "user32" Alias "SetClipboardViewer" (ByVal hwnd As Integer) As IntPtr
    Declare Function ChangeClipboardChain Lib "user32" Alias "ChangeClipboardChain" (ByVal hwnd As Integer, ByVal hWndNext As IntPtr) As Boolean
    Declare Auto Function SendMessage Lib "User32" (ByVal HWnd As IntPtr, ByVal Msg As Integer, ByVal wParam As IntPtr, ByVal lParam As IntPtr) As Long
    Protected Friend Config As Config = OGameStratege.Config.XMLDeSerialize
    Friend WithEvents lbbProxy As OGameStratege.LabelBox
    Friend WithEvents tpIEBrowser As System.Windows.Forms.TabPage
    Friend WithEvents OgameBrowserCtrl1 As OGameObject.OgameBrowserCtrl
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents BackgroundWorker1 As System.ComponentModel.BackgroundWorker
    Public Shared TopForm As MainForm = Nothing
#Region " Windows Form Designer generated code "

    Public Sub New()

        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()
        TopForm = Me
        'Add any initialization after the InitializeComponent() call
        Me.SetStyle(ControlStyles.DoubleBuffer _
                 Or ControlStyles.UserPaint _
                 Or ControlStyles.AllPaintingInWmPaint, _
                 True)

        ' This enables mouse support such as the Mouse Wheel
        SetStyle(ControlStyles.UserMouse, True)

        ' This will repaint the control whenever it is resized
        SetStyle(ControlStyles.ResizeRedraw, True)

        Me.UpdateStyles()
        OGameObject.MainAppForm = Me
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
    Friend WithEvents StatusBar1 As System.Windows.Forms.StatusBar
    Friend WithEvents NotifyIcon1 As System.Windows.Forms.NotifyIcon
    Friend WithEvents ContextMenu1 As System.Windows.Forms.ContextMenu
    Friend WithEvents MenuItem1 As System.Windows.Forms.MenuItem
    Friend WithEvents MainMenu1 As System.Windows.Forms.MainMenu
    Friend WithEvents MenuItem2 As System.Windows.Forms.MenuItem
    Friend WithEvents MenuItem3 As System.Windows.Forms.MenuItem
    Friend WithEvents sbpRecords As System.Windows.Forms.StatusBarPanel
    Friend WithEvents sbpStatus As System.Windows.Forms.StatusBarPanel
    Friend WithEvents tabCtrl As System.Windows.Forms.TabControl
    Friend WithEvents cmTemplate As System.Windows.Forms.ContextMenu
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents chkClpbMonitoring As System.Windows.Forms.CheckBox
    Friend WithEvents tpUniverses As System.Windows.Forms.TabPage
    Friend WithEvents tpConfig As System.Windows.Forms.TabPage
    Friend WithEvents miRestore As System.Windows.Forms.MenuItem
    Friend WithEvents sbpClipBoard As System.Windows.Forms.StatusBarPanel
    Friend WithEvents Timer1 As System.Timers.Timer
    Friend WithEvents MenuItem4 As System.Windows.Forms.MenuItem
    Friend WithEvents MenuItem5 As System.Windows.Forms.MenuItem
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents tbDefaultOwner As System.Windows.Forms.TextBox
    Friend WithEvents chkHideTitleBar As System.Windows.Forms.CheckBox
    Friend WithEvents chkHideMenu As System.Windows.Forms.CheckBox
    Friend WithEvents chkAlwaysOnTop As System.Windows.Forms.CheckBox
    Friend WithEvents gbDatabase As System.Windows.Forms.GroupBox
    Friend WithEvents rbDBLocal As System.Windows.Forms.RadioButton
    Friend WithEvents rbDBRemote As System.Windows.Forms.RadioButton
    Friend WithEvents tbDBServer As System.Windows.Forms.TextBox
    Friend WithEvents MenuItem6 As System.Windows.Forms.MenuItem
    Friend WithEvents miShowMinilog As System.Windows.Forms.MenuItem
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents tbSQLQuery As System.Windows.Forms.TextBox
    Friend WithEvents btnSQLQuerySend As System.Windows.Forms.Button
    Friend WithEvents dgSQLQuery As System.Windows.Forms.DataGrid
    Friend WithEvents GroupBox1 As System.Windows.Forms.GroupBox
    Friend WithEvents rbSQLQueryCommand As System.Windows.Forms.RadioButton
    Friend WithEvents rbSQLQueryScript As System.Windows.Forms.RadioButton
    Friend WithEvents chkEnableSound As System.Windows.Forms.CheckBox
    Friend WithEvents Universes1 As OGameStratege.Universes
    Friend WithEvents btnSQLLoad As System.Windows.Forms.Button
    Friend WithEvents ofdSQLOpen As System.Windows.Forms.OpenFileDialog
    Friend WithEvents MenuItem8 As System.Windows.Forms.MenuItem
    Friend WithEvents tpSQLCommand As System.Windows.Forms.TabPage
    Friend WithEvents rtbLog As System.Windows.Forms.RichTextBox
    Friend WithEvents tpTraceLog As System.Windows.Forms.TabPage
    Friend WithEvents chkConfigHideFromTaskbar As System.Windows.Forms.CheckBox
    Friend WithEvents chkAutoCheckUpdate As System.Windows.Forms.CheckBox
    Friend WithEvents btnCheckUpdate As System.Windows.Forms.Button
    Friend WithEvents chkCheckCurrentDevUpdate As System.Windows.Forms.CheckBox
    Friend WithEvents GroupBox2 As System.Windows.Forms.GroupBox
    Friend WithEvents lbbWavClipboard As OGameStratege.LabelBox
    Friend WithEvents lbbWavGalaxy As OGameStratege.LabelBox
    Friend WithEvents lbbWavSpying As OGameStratege.LabelBox
    Friend WithEvents lbbWavAttacks As OGameStratege.LabelBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents Button4 As System.Windows.Forms.Button
    Friend WithEvents Button5 As System.Windows.Forms.Button
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents lbbWavStats As OGameStratege.LabelBox
    Friend WithEvents Button6 As System.Windows.Forms.Button

    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(MainForm))
        Me.StatusBar1 = New System.Windows.Forms.StatusBar
        Me.sbpRecords = New System.Windows.Forms.StatusBarPanel
        Me.sbpStatus = New System.Windows.Forms.StatusBarPanel
        Me.sbpClipBoard = New System.Windows.Forms.StatusBarPanel
        Me.NotifyIcon1 = New System.Windows.Forms.NotifyIcon(Me.components)
        Me.ContextMenu1 = New System.Windows.Forms.ContextMenu
        Me.MenuItem5 = New System.Windows.Forms.MenuItem
        Me.MenuItem8 = New System.Windows.Forms.MenuItem
        Me.MenuItem4 = New System.Windows.Forms.MenuItem
        Me.miRestore = New System.Windows.Forms.MenuItem
        Me.MenuItem1 = New System.Windows.Forms.MenuItem
        Me.MainMenu1 = New System.Windows.Forms.MainMenu(Me.components)
        Me.MenuItem2 = New System.Windows.Forms.MenuItem
        Me.MenuItem3 = New System.Windows.Forms.MenuItem
        Me.MenuItem6 = New System.Windows.Forms.MenuItem
        Me.miShowMinilog = New System.Windows.Forms.MenuItem
        Me.tabCtrl = New System.Windows.Forms.TabControl
        Me.tpUniverses = New System.Windows.Forms.TabPage
        Me.Universes1 = New OGameStratege.Universes
        Me.tpSQLCommand = New System.Windows.Forms.TabPage
        Me.btnSQLLoad = New System.Windows.Forms.Button
        Me.GroupBox1 = New System.Windows.Forms.GroupBox
        Me.rbSQLQueryCommand = New System.Windows.Forms.RadioButton
        Me.rbSQLQueryScript = New System.Windows.Forms.RadioButton
        Me.dgSQLQuery = New System.Windows.Forms.DataGrid
        Me.btnSQLQuerySend = New System.Windows.Forms.Button
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.tbSQLQuery = New System.Windows.Forms.TextBox
        Me.Label2 = New System.Windows.Forms.Label
        Me.tpConfig = New System.Windows.Forms.TabPage
        Me.lbbProxy = New OGameStratege.LabelBox
        Me.Button6 = New System.Windows.Forms.Button
        Me.GroupBox2 = New System.Windows.Forms.GroupBox
        Me.Button1 = New System.Windows.Forms.Button
        Me.lbbWavClipboard = New OGameStratege.LabelBox
        Me.lbbWavGalaxy = New OGameStratege.LabelBox
        Me.lbbWavSpying = New OGameStratege.LabelBox
        Me.lbbWavAttacks = New OGameStratege.LabelBox
        Me.lbbWavStats = New OGameStratege.LabelBox
        Me.Button2 = New System.Windows.Forms.Button
        Me.Button3 = New System.Windows.Forms.Button
        Me.Button4 = New System.Windows.Forms.Button
        Me.Button5 = New System.Windows.Forms.Button
        Me.btnCheckUpdate = New System.Windows.Forms.Button
        Me.gbDatabase = New System.Windows.Forms.GroupBox
        Me.tbDBServer = New System.Windows.Forms.TextBox
        Me.rbDBLocal = New System.Windows.Forms.RadioButton
        Me.rbDBRemote = New System.Windows.Forms.RadioButton
        Me.tbDefaultOwner = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.chkClpbMonitoring = New System.Windows.Forms.CheckBox
        Me.chkHideTitleBar = New System.Windows.Forms.CheckBox
        Me.chkHideMenu = New System.Windows.Forms.CheckBox
        Me.chkAlwaysOnTop = New System.Windows.Forms.CheckBox
        Me.chkEnableSound = New System.Windows.Forms.CheckBox
        Me.chkConfigHideFromTaskbar = New System.Windows.Forms.CheckBox
        Me.chkAutoCheckUpdate = New System.Windows.Forms.CheckBox
        Me.chkCheckCurrentDevUpdate = New System.Windows.Forms.CheckBox
        Me.tpTraceLog = New System.Windows.Forms.TabPage
        Me.rtbLog = New System.Windows.Forms.RichTextBox
        Me.tpIEBrowser = New System.Windows.Forms.TabPage
        Me.OgameBrowserCtrl1 = New OGameObject.OgameBrowserCtrl
        Me.cmTemplate = New System.Windows.Forms.ContextMenu
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.Timer1 = New System.Timers.Timer
        Me.ofdSQLOpen = New System.Windows.Forms.OpenFileDialog
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog
        Me.BackgroundWorker1 = New System.ComponentModel.BackgroundWorker
        CType(Me.sbpRecords, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.sbpStatus, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.sbpClipBoard, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.tabCtrl.SuspendLayout()
        Me.tpUniverses.SuspendLayout()
        Me.tpSQLCommand.SuspendLayout()
        Me.GroupBox1.SuspendLayout()
        CType(Me.dgSQLQuery, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel2.SuspendLayout()
        Me.tpConfig.SuspendLayout()
        Me.GroupBox2.SuspendLayout()
        Me.gbDatabase.SuspendLayout()
        Me.tpTraceLog.SuspendLayout()
        Me.tpIEBrowser.SuspendLayout()
        CType(Me.Timer1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'StatusBar1
        '
        Me.StatusBar1.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.StatusBar1.Location = New System.Drawing.Point(0, 389)
        Me.StatusBar1.Name = "StatusBar1"
        Me.StatusBar1.Panels.AddRange(New System.Windows.Forms.StatusBarPanel() {Me.sbpRecords, Me.sbpStatus, Me.sbpClipBoard})
        Me.StatusBar1.ShowPanels = True
        Me.StatusBar1.Size = New System.Drawing.Size(709, 22)
        Me.StatusBar1.TabIndex = 0
        Me.StatusBar1.Text = "StatusBar1"
        '
        'sbpRecords
        '
        Me.sbpRecords.AutoSize = System.Windows.Forms.StatusBarPanelAutoSize.Contents
        Me.sbpRecords.Name = "sbpRecords"
        Me.sbpRecords.Text = "0 Records"
        Me.sbpRecords.Width = 66
        '
        'sbpStatus
        '
        Me.sbpStatus.Alignment = System.Windows.Forms.HorizontalAlignment.Right
        Me.sbpStatus.AutoSize = System.Windows.Forms.StatusBarPanelAutoSize.Spring
        Me.sbpStatus.Name = "sbpStatus"
        Me.sbpStatus.Text = "Last Action"
        Me.sbpStatus.Width = 527
        '
        'sbpClipBoard
        '
        Me.sbpClipBoard.Alignment = System.Windows.Forms.HorizontalAlignment.Center
        Me.sbpClipBoard.BorderStyle = System.Windows.Forms.StatusBarPanelBorderStyle.Raised
        Me.sbpClipBoard.Name = "sbpClipBoard"
        Me.sbpClipBoard.Text = "Clipboard"
        '
        'NotifyIcon1
        '
        Me.NotifyIcon1.ContextMenu = Me.ContextMenu1
        Me.NotifyIcon1.Icon = CType(resources.GetObject("NotifyIcon1.Icon"), System.Drawing.Icon)
        Me.NotifyIcon1.Text = "OGame Stratege"
        Me.NotifyIcon1.Visible = True
        '
        'ContextMenu1
        '
        Me.ContextMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem5, Me.MenuItem8, Me.MenuItem4, Me.miRestore, Me.MenuItem1})
        '
        'MenuItem5
        '
        Me.MenuItem5.Checked = True
        Me.MenuItem5.Index = 0
        Me.MenuItem5.Text = "Monitor Clipboard"
        '
        'MenuItem8
        '
        Me.MenuItem8.Index = 1
        Me.MenuItem8.Text = "Show / Hide Minilog"
        '
        'MenuItem4
        '
        Me.MenuItem4.Index = 2
        Me.MenuItem4.Text = "-"
        '
        'miRestore
        '
        Me.miRestore.DefaultItem = True
        Me.miRestore.Index = 3
        Me.miRestore.Text = "Restore"
        '
        'MenuItem1
        '
        Me.MenuItem1.DefaultItem = True
        Me.MenuItem1.Index = 4
        Me.MenuItem1.Text = "&Exit"
        '
        'MainMenu1
        '
        Me.MainMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem2, Me.MenuItem6})
        '
        'MenuItem2
        '
        Me.MenuItem2.Index = 0
        Me.MenuItem2.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem3})
        Me.MenuItem2.Text = "&Fichier"
        '
        'MenuItem3
        '
        Me.MenuItem3.Index = 0
        Me.MenuItem3.Text = "&Exit"
        '
        'MenuItem6
        '
        Me.MenuItem6.Index = 1
        Me.MenuItem6.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.miShowMinilog})
        Me.MenuItem6.Text = "Options"
        '
        'miShowMinilog
        '
        Me.miShowMinilog.Index = 0
        Me.miShowMinilog.Text = "Show Minilog"
        '
        'tabCtrl
        '
        Me.tabCtrl.Alignment = System.Windows.Forms.TabAlignment.Bottom
        Me.tabCtrl.Controls.Add(Me.tpUniverses)
        Me.tabCtrl.Controls.Add(Me.tpSQLCommand)
        Me.tabCtrl.Controls.Add(Me.tpConfig)
        Me.tabCtrl.Controls.Add(Me.tpTraceLog)
        Me.tabCtrl.Controls.Add(Me.tpIEBrowser)
        Me.tabCtrl.Dock = System.Windows.Forms.DockStyle.Fill
        Me.tabCtrl.ItemSize = New System.Drawing.Size(59, 18)
        Me.tabCtrl.Location = New System.Drawing.Point(0, 0)
        Me.tabCtrl.Multiline = True
        Me.tabCtrl.Name = "tabCtrl"
        Me.tabCtrl.SelectedIndex = 0
        Me.tabCtrl.Size = New System.Drawing.Size(709, 389)
        Me.tabCtrl.TabIndex = 1
        '
        'tpUniverses
        '
        Me.tpUniverses.Controls.Add(Me.Universes1)
        Me.tpUniverses.Location = New System.Drawing.Point(4, 4)
        Me.tpUniverses.Name = "tpUniverses"
        Me.tpUniverses.Size = New System.Drawing.Size(701, 363)
        Me.tpUniverses.TabIndex = 0
        Me.tpUniverses.Text = "Universes"
        Me.tpUniverses.UseVisualStyleBackColor = True
        '
        'Universes1
        '
        Me.Universes1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.Universes1.Location = New System.Drawing.Point(0, 0)
        Me.Universes1.Name = "Universes1"
        Me.Universes1.OGameDB = Nothing
        Me.Universes1.ShowMode = OGameStratege.Universes.enShowMode.Galaxy
        Me.Universes1.Size = New System.Drawing.Size(701, 363)
        Me.Universes1.TabIndex = 0
        '
        'tpSQLCommand
        '
        Me.tpSQLCommand.Controls.Add(Me.btnSQLLoad)
        Me.tpSQLCommand.Controls.Add(Me.GroupBox1)
        Me.tpSQLCommand.Controls.Add(Me.dgSQLQuery)
        Me.tpSQLCommand.Controls.Add(Me.btnSQLQuerySend)
        Me.tpSQLCommand.Controls.Add(Me.Panel2)
        Me.tpSQLCommand.Location = New System.Drawing.Point(4, 4)
        Me.tpSQLCommand.Name = "tpSQLCommand"
        Me.tpSQLCommand.Size = New System.Drawing.Size(701, 363)
        Me.tpSQLCommand.TabIndex = 3
        Me.tpSQLCommand.Text = "SQL Command"
        Me.tpSQLCommand.UseVisualStyleBackColor = True
        '
        'btnSQLLoad
        '
        Me.btnSQLLoad.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.btnSQLLoad.Location = New System.Drawing.Point(384, 112)
        Me.btnSQLLoad.Name = "btnSQLLoad"
        Me.btnSQLLoad.Size = New System.Drawing.Size(184, 23)
        Me.btnSQLLoad.TabIndex = 5
        Me.btnSQLLoad.Text = "Load Script"
        '
        'GroupBox1
        '
        Me.GroupBox1.Controls.Add(Me.rbSQLQueryCommand)
        Me.GroupBox1.Controls.Add(Me.rbSQLQueryScript)
        Me.GroupBox1.Location = New System.Drawing.Point(8, 104)
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.Size = New System.Drawing.Size(176, 48)
        Me.GroupBox1.TabIndex = 4
        Me.GroupBox1.TabStop = False
        Me.GroupBox1.Text = "SQL Script Options"
        '
        'rbSQLQueryCommand
        '
        Me.rbSQLQueryCommand.Checked = True
        Me.rbSQLQueryCommand.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.rbSQLQueryCommand.Location = New System.Drawing.Point(8, 16)
        Me.rbSQLQueryCommand.Name = "rbSQLQueryCommand"
        Me.rbSQLQueryCommand.Size = New System.Drawing.Size(80, 24)
        Me.rbSQLQueryCommand.TabIndex = 0
        Me.rbSQLQueryCommand.TabStop = True
        Me.rbSQLQueryCommand.Text = "Command"
        '
        'rbSQLQueryScript
        '
        Me.rbSQLQueryScript.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.rbSQLQueryScript.Location = New System.Drawing.Point(96, 16)
        Me.rbSQLQueryScript.Name = "rbSQLQueryScript"
        Me.rbSQLQueryScript.Size = New System.Drawing.Size(64, 24)
        Me.rbSQLQueryScript.TabIndex = 0
        Me.rbSQLQueryScript.Text = "Script"
        '
        'dgSQLQuery
        '
        Me.dgSQLQuery.AlternatingBackColor = System.Drawing.Color.LightGray
        Me.dgSQLQuery.Anchor = CType((((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Bottom) _
                    Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.dgSQLQuery.BackColor = System.Drawing.Color.Gainsboro
        Me.dgSQLQuery.BackgroundColor = System.Drawing.Color.Silver
        Me.dgSQLQuery.BorderStyle = System.Windows.Forms.BorderStyle.None
        Me.dgSQLQuery.CaptionBackColor = System.Drawing.Color.LightSteelBlue
        Me.dgSQLQuery.CaptionFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgSQLQuery.CaptionForeColor = System.Drawing.Color.MidnightBlue
        Me.dgSQLQuery.DataMember = ""
        Me.dgSQLQuery.FlatMode = True
        Me.dgSQLQuery.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgSQLQuery.ForeColor = System.Drawing.Color.Black
        Me.dgSQLQuery.GridLineColor = System.Drawing.Color.DimGray
        Me.dgSQLQuery.GridLineStyle = System.Windows.Forms.DataGridLineStyle.None
        Me.dgSQLQuery.HeaderBackColor = System.Drawing.Color.MidnightBlue
        Me.dgSQLQuery.HeaderFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgSQLQuery.HeaderForeColor = System.Drawing.Color.White
        Me.dgSQLQuery.LinkColor = System.Drawing.Color.MidnightBlue
        Me.dgSQLQuery.Location = New System.Drawing.Point(0, 168)
        Me.dgSQLQuery.Name = "dgSQLQuery"
        Me.dgSQLQuery.ParentRowsBackColor = System.Drawing.Color.DarkGray
        Me.dgSQLQuery.ParentRowsForeColor = System.Drawing.Color.Black
        Me.dgSQLQuery.SelectionBackColor = System.Drawing.Color.CadetBlue
        Me.dgSQLQuery.SelectionForeColor = System.Drawing.Color.White
        Me.dgSQLQuery.Size = New System.Drawing.Size(701, 194)
        Me.dgSQLQuery.TabIndex = 2
        '
        'btnSQLQuerySend
        '
        Me.btnSQLQuerySend.BackColor = System.Drawing.Color.Firebrick
        Me.btnSQLQuerySend.ForeColor = System.Drawing.Color.White
        Me.btnSQLQuerySend.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.btnSQLQuerySend.Location = New System.Drawing.Point(192, 104)
        Me.btnSQLQuerySend.Name = "btnSQLQuerySend"
        Me.btnSQLQuerySend.Size = New System.Drawing.Size(160, 40)
        Me.btnSQLQuerySend.TabIndex = 1
        Me.btnSQLQuerySend.Text = "Je sais ce que fais et j'ai pas peur. Vraiment ?"
        Me.btnSQLQuerySend.UseVisualStyleBackColor = False
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.tbSQLQuery)
        Me.Panel2.Controls.Add(Me.Label2)
        Me.Panel2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel2.Location = New System.Drawing.Point(0, 0)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(701, 96)
        Me.Panel2.TabIndex = 0
        '
        'tbSQLQuery
        '
        Me.tbSQLQuery.Dock = System.Windows.Forms.DockStyle.Fill
        Me.tbSQLQuery.Location = New System.Drawing.Point(0, 23)
        Me.tbSQLQuery.Multiline = True
        Me.tbSQLQuery.Name = "tbSQLQuery"
        Me.tbSQLQuery.Size = New System.Drawing.Size(701, 73)
        Me.tbSQLQuery.TabIndex = 1
        '
        'Label2
        '
        Me.Label2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label2.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.Label2.Location = New System.Drawing.Point(0, 0)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(701, 23)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "A n'utilisez que si vous savez ce que vous faites , vous pouvez cramer votre base" & _
            " si vous faites n'importe quoi la :)"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'tpConfig
        '
        Me.tpConfig.Controls.Add(Me.lbbProxy)
        Me.tpConfig.Controls.Add(Me.Button6)
        Me.tpConfig.Controls.Add(Me.GroupBox2)
        Me.tpConfig.Controls.Add(Me.btnCheckUpdate)
        Me.tpConfig.Controls.Add(Me.gbDatabase)
        Me.tpConfig.Controls.Add(Me.tbDefaultOwner)
        Me.tpConfig.Controls.Add(Me.Label1)
        Me.tpConfig.Controls.Add(Me.chkClpbMonitoring)
        Me.tpConfig.Controls.Add(Me.chkHideTitleBar)
        Me.tpConfig.Controls.Add(Me.chkHideMenu)
        Me.tpConfig.Controls.Add(Me.chkAlwaysOnTop)
        Me.tpConfig.Controls.Add(Me.chkEnableSound)
        Me.tpConfig.Controls.Add(Me.chkConfigHideFromTaskbar)
        Me.tpConfig.Controls.Add(Me.chkAutoCheckUpdate)
        Me.tpConfig.Controls.Add(Me.chkCheckCurrentDevUpdate)
        Me.tpConfig.Location = New System.Drawing.Point(4, 4)
        Me.tpConfig.Name = "tpConfig"
        Me.tpConfig.Size = New System.Drawing.Size(701, 363)
        Me.tpConfig.TabIndex = 1
        Me.tpConfig.Text = "Config"
        Me.tpConfig.UseVisualStyleBackColor = True
        '
        'lbbProxy
        '
        Me.lbbProxy.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lbbProxy.Caption = "Proxy URL"
        Me.lbbProxy.CaptionWidth = 80
        Me.lbbProxy.Location = New System.Drawing.Point(16, 371)
        Me.lbbProxy.Name = "lbbProxy"
        Me.lbbProxy.ReadOnly = False
        Me.lbbProxy.Size = New System.Drawing.Size(420, 18)
        Me.lbbProxy.TabIndex = 8
        Me.ToolTip1.SetToolTip(Me.lbbProxy, "Sous la forme 'http://yourproxy.org:80/'")
        Me.lbbProxy.Value = ""
        '
        'Button6
        '
        Me.Button6.Anchor = CType((System.Windows.Forms.AnchorStyles.Bottom Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.Button6.Image = CType(resources.GetObject("Button6.Image"), System.Drawing.Image)
        Me.Button6.ImageAlign = System.Drawing.ContentAlignment.TopCenter
        Me.Button6.Location = New System.Drawing.Point(549, 285)
        Me.Button6.Name = "Button6"
        Me.Button6.Size = New System.Drawing.Size(144, 64)
        Me.Button6.TabIndex = 7
        Me.Button6.Text = "Save"
        Me.Button6.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.ToolTip1.SetToolTip(Me.Button6, "Save Config")
        '
        'GroupBox2
        '
        Me.GroupBox2.Controls.Add(Me.Button1)
        Me.GroupBox2.Controls.Add(Me.lbbWavClipboard)
        Me.GroupBox2.Controls.Add(Me.lbbWavGalaxy)
        Me.GroupBox2.Controls.Add(Me.lbbWavSpying)
        Me.GroupBox2.Controls.Add(Me.lbbWavAttacks)
        Me.GroupBox2.Controls.Add(Me.lbbWavStats)
        Me.GroupBox2.Controls.Add(Me.Button2)
        Me.GroupBox2.Controls.Add(Me.Button3)
        Me.GroupBox2.Controls.Add(Me.Button4)
        Me.GroupBox2.Controls.Add(Me.Button5)
        Me.GroupBox2.Location = New System.Drawing.Point(8, 176)
        Me.GroupBox2.Name = "GroupBox2"
        Me.GroupBox2.Size = New System.Drawing.Size(520, 152)
        Me.GroupBox2.TabIndex = 6
        Me.GroupBox2.TabStop = False
        Me.GroupBox2.Text = "Sound (set to 'NONE' for silence)"
        '
        'Button1
        '
        Me.Button1.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.Button1.Location = New System.Drawing.Point(424, 24)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(75, 18)
        Me.Button1.TabIndex = 1
        Me.Button1.Text = "Browse"
        '
        'lbbWavClipboard
        '
        Me.lbbWavClipboard.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lbbWavClipboard.Caption = "Clipboard"
        Me.lbbWavClipboard.CaptionWidth = 80
        Me.lbbWavClipboard.Location = New System.Drawing.Point(8, 24)
        Me.lbbWavClipboard.Name = "lbbWavClipboard"
        Me.lbbWavClipboard.ReadOnly = False
        Me.lbbWavClipboard.Size = New System.Drawing.Size(408, 18)
        Me.lbbWavClipboard.TabIndex = 0
        Me.lbbWavClipboard.Value = ""
        '
        'lbbWavGalaxy
        '
        Me.lbbWavGalaxy.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lbbWavGalaxy.Caption = "Galaxy"
        Me.lbbWavGalaxy.CaptionWidth = 80
        Me.lbbWavGalaxy.Location = New System.Drawing.Point(8, 48)
        Me.lbbWavGalaxy.Name = "lbbWavGalaxy"
        Me.lbbWavGalaxy.ReadOnly = False
        Me.lbbWavGalaxy.Size = New System.Drawing.Size(408, 18)
        Me.lbbWavGalaxy.TabIndex = 0
        Me.lbbWavGalaxy.Value = ""
        '
        'lbbWavSpying
        '
        Me.lbbWavSpying.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lbbWavSpying.Caption = "Spying"
        Me.lbbWavSpying.CaptionWidth = 80
        Me.lbbWavSpying.Location = New System.Drawing.Point(8, 72)
        Me.lbbWavSpying.Name = "lbbWavSpying"
        Me.lbbWavSpying.ReadOnly = False
        Me.lbbWavSpying.Size = New System.Drawing.Size(408, 18)
        Me.lbbWavSpying.TabIndex = 0
        Me.lbbWavSpying.Value = ""
        '
        'lbbWavAttacks
        '
        Me.lbbWavAttacks.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lbbWavAttacks.Caption = "Attacks"
        Me.lbbWavAttacks.CaptionWidth = 80
        Me.lbbWavAttacks.Location = New System.Drawing.Point(8, 96)
        Me.lbbWavAttacks.Name = "lbbWavAttacks"
        Me.lbbWavAttacks.ReadOnly = False
        Me.lbbWavAttacks.Size = New System.Drawing.Size(408, 18)
        Me.lbbWavAttacks.TabIndex = 0
        Me.lbbWavAttacks.Value = ""
        '
        'lbbWavStats
        '
        Me.lbbWavStats.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lbbWavStats.Caption = "Stats"
        Me.lbbWavStats.CaptionWidth = 80
        Me.lbbWavStats.Location = New System.Drawing.Point(8, 120)
        Me.lbbWavStats.Name = "lbbWavStats"
        Me.lbbWavStats.ReadOnly = False
        Me.lbbWavStats.Size = New System.Drawing.Size(408, 18)
        Me.lbbWavStats.TabIndex = 0
        Me.lbbWavStats.Value = ""
        '
        'Button2
        '
        Me.Button2.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.Button2.Location = New System.Drawing.Point(424, 48)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(75, 18)
        Me.Button2.TabIndex = 1
        Me.Button2.Text = "Browse"
        '
        'Button3
        '
        Me.Button3.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.Button3.Location = New System.Drawing.Point(424, 72)
        Me.Button3.Name = "Button3"
        Me.Button3.Size = New System.Drawing.Size(75, 18)
        Me.Button3.TabIndex = 1
        Me.Button3.Text = "Browse"
        '
        'Button4
        '
        Me.Button4.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.Button4.Location = New System.Drawing.Point(424, 96)
        Me.Button4.Name = "Button4"
        Me.Button4.Size = New System.Drawing.Size(75, 18)
        Me.Button4.TabIndex = 1
        Me.Button4.Text = "Browse"
        '
        'Button5
        '
        Me.Button5.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.Button5.Location = New System.Drawing.Point(424, 120)
        Me.Button5.Name = "Button5"
        Me.Button5.Size = New System.Drawing.Size(75, 18)
        Me.Button5.TabIndex = 1
        Me.Button5.Text = "Browse"
        '
        'btnCheckUpdate
        '
        Me.btnCheckUpdate.Location = New System.Drawing.Point(408, 104)
        Me.btnCheckUpdate.Name = "btnCheckUpdate"
        Me.btnCheckUpdate.Size = New System.Drawing.Size(120, 23)
        Me.btnCheckUpdate.TabIndex = 5
        Me.btnCheckUpdate.Text = "Check Update"
        '
        'gbDatabase
        '
        Me.gbDatabase.Controls.Add(Me.tbDBServer)
        Me.gbDatabase.Controls.Add(Me.rbDBLocal)
        Me.gbDatabase.Controls.Add(Me.rbDBRemote)
        Me.gbDatabase.Location = New System.Drawing.Point(368, 8)
        Me.gbDatabase.Name = "gbDatabase"
        Me.gbDatabase.Size = New System.Drawing.Size(248, 88)
        Me.gbDatabase.TabIndex = 3
        Me.gbDatabase.TabStop = False
        Me.gbDatabase.Text = "Database Config"
        '
        'tbDBServer
        '
        Me.tbDBServer.Enabled = False
        Me.tbDBServer.Location = New System.Drawing.Point(8, 48)
        Me.tbDBServer.Name = "tbDBServer"
        Me.tbDBServer.Size = New System.Drawing.Size(224, 20)
        Me.tbDBServer.TabIndex = 1
        Me.tbDBServer.Text = "localhost"
        '
        'rbDBLocal
        '
        Me.rbDBLocal.Checked = True
        Me.rbDBLocal.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.rbDBLocal.Location = New System.Drawing.Point(8, 16)
        Me.rbDBLocal.Name = "rbDBLocal"
        Me.rbDBLocal.Size = New System.Drawing.Size(104, 24)
        Me.rbDBLocal.TabIndex = 0
        Me.rbDBLocal.TabStop = True
        Me.rbDBLocal.Text = "Local"
        '
        'rbDBRemote
        '
        Me.rbDBRemote.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.rbDBRemote.Location = New System.Drawing.Point(120, 16)
        Me.rbDBRemote.Name = "rbDBRemote"
        Me.rbDBRemote.Size = New System.Drawing.Size(104, 24)
        Me.rbDBRemote.TabIndex = 0
        Me.rbDBRemote.Text = "Remote"
        '
        'tbDefaultOwner
        '
        Me.tbDefaultOwner.Location = New System.Drawing.Point(72, 104)
        Me.tbDefaultOwner.Name = "tbDefaultOwner"
        Me.tbDefaultOwner.Size = New System.Drawing.Size(96, 20)
        Me.tbDefaultOwner.TabIndex = 2
        Me.tbDefaultOwner.Text = "Default"
        Me.ToolTip1.SetToolTip(Me.tbDefaultOwner, "Name to sign new data inserted in database")
        '
        'Label1
        '
        Me.Label1.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.Label1.Location = New System.Drawing.Point(8, 104)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(64, 20)
        Me.Label1.TabIndex = 1
        Me.Label1.Text = "Owner"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'chkClpbMonitoring
        '
        Me.chkClpbMonitoring.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.chkClpbMonitoring.Location = New System.Drawing.Point(8, 8)
        Me.chkClpbMonitoring.Name = "chkClpbMonitoring"
        Me.chkClpbMonitoring.Size = New System.Drawing.Size(160, 24)
        Me.chkClpbMonitoring.TabIndex = 0
        Me.chkClpbMonitoring.Text = "Monitor Clipboard"
        Me.ToolTip1.SetToolTip(Me.chkClpbMonitoring, "Monitor clipboard data and try to found Ogame Data")
        '
        'chkHideTitleBar
        '
        Me.chkHideTitleBar.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.chkHideTitleBar.Location = New System.Drawing.Point(8, 32)
        Me.chkHideTitleBar.Name = "chkHideTitleBar"
        Me.chkHideTitleBar.Size = New System.Drawing.Size(160, 24)
        Me.chkHideTitleBar.TabIndex = 0
        Me.chkHideTitleBar.Text = "Hide Title Bar"
        Me.ToolTip1.SetToolTip(Me.chkHideTitleBar, "Monitor clipboard data and try to found Ogame Data")
        '
        'chkHideMenu
        '
        Me.chkHideMenu.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.chkHideMenu.Location = New System.Drawing.Point(8, 56)
        Me.chkHideMenu.Name = "chkHideMenu"
        Me.chkHideMenu.Size = New System.Drawing.Size(160, 24)
        Me.chkHideMenu.TabIndex = 0
        Me.chkHideMenu.Text = "Hide Menu"
        Me.ToolTip1.SetToolTip(Me.chkHideMenu, "Monitor clipboard data and try to found Ogame Data")
        '
        'chkAlwaysOnTop
        '
        Me.chkAlwaysOnTop.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.chkAlwaysOnTop.Location = New System.Drawing.Point(184, 8)
        Me.chkAlwaysOnTop.Name = "chkAlwaysOnTop"
        Me.chkAlwaysOnTop.Size = New System.Drawing.Size(160, 24)
        Me.chkAlwaysOnTop.TabIndex = 0
        Me.chkAlwaysOnTop.Text = "AlwaysOnTop"
        Me.ToolTip1.SetToolTip(Me.chkAlwaysOnTop, "Monitor clipboard data and try to found Ogame Data")
        '
        'chkEnableSound
        '
        Me.chkEnableSound.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.chkEnableSound.Location = New System.Drawing.Point(184, 32)
        Me.chkEnableSound.Name = "chkEnableSound"
        Me.chkEnableSound.Size = New System.Drawing.Size(160, 24)
        Me.chkEnableSound.TabIndex = 0
        Me.chkEnableSound.Text = "Enable Sound"
        Me.ToolTip1.SetToolTip(Me.chkEnableSound, "Monitor clipboard data and try to found Ogame Data")
        '
        'chkConfigHideFromTaskbar
        '
        Me.chkConfigHideFromTaskbar.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.chkConfigHideFromTaskbar.Location = New System.Drawing.Point(184, 56)
        Me.chkConfigHideFromTaskbar.Name = "chkConfigHideFromTaskbar"
        Me.chkConfigHideFromTaskbar.Size = New System.Drawing.Size(160, 24)
        Me.chkConfigHideFromTaskbar.TabIndex = 0
        Me.chkConfigHideFromTaskbar.Text = "Hide from Taskbar"
        Me.ToolTip1.SetToolTip(Me.chkConfigHideFromTaskbar, "Monitor clipboard data and try to found Ogame Data")
        '
        'chkAutoCheckUpdate
        '
        Me.chkAutoCheckUpdate.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.chkAutoCheckUpdate.Location = New System.Drawing.Point(240, 104)
        Me.chkAutoCheckUpdate.Name = "chkAutoCheckUpdate"
        Me.chkAutoCheckUpdate.Size = New System.Drawing.Size(160, 24)
        Me.chkAutoCheckUpdate.TabIndex = 0
        Me.chkAutoCheckUpdate.Text = "Auto Check Update"
        '
        'chkCheckCurrentDevUpdate
        '
        Me.chkCheckCurrentDevUpdate.ImeMode = System.Windows.Forms.ImeMode.NoControl
        Me.chkCheckCurrentDevUpdate.Location = New System.Drawing.Point(240, 136)
        Me.chkCheckCurrentDevUpdate.Name = "chkCheckCurrentDevUpdate"
        Me.chkCheckCurrentDevUpdate.Size = New System.Drawing.Size(160, 32)
        Me.chkCheckCurrentDevUpdate.TabIndex = 0
        Me.chkCheckCurrentDevUpdate.Text = "Show OGS Development Version update"
        '
        'tpTraceLog
        '
        Me.tpTraceLog.Controls.Add(Me.rtbLog)
        Me.tpTraceLog.Location = New System.Drawing.Point(4, 4)
        Me.tpTraceLog.Name = "tpTraceLog"
        Me.tpTraceLog.Size = New System.Drawing.Size(701, 363)
        Me.tpTraceLog.TabIndex = 4
        Me.tpTraceLog.Text = "Trace/Log"
        Me.tpTraceLog.UseVisualStyleBackColor = True
        '
        'rtbLog
        '
        Me.rtbLog.BackColor = System.Drawing.Color.Black
        Me.rtbLog.Dock = System.Windows.Forms.DockStyle.Fill
        Me.rtbLog.ForeColor = System.Drawing.Color.Yellow
        Me.rtbLog.Location = New System.Drawing.Point(0, 0)
        Me.rtbLog.Name = "rtbLog"
        Me.rtbLog.Size = New System.Drawing.Size(701, 363)
        Me.rtbLog.TabIndex = 1
        Me.rtbLog.Text = "Salut a tous !!"
        '
        'tpIEBrowser
        '
        Me.tpIEBrowser.Controls.Add(Me.OgameBrowserCtrl1)
        Me.tpIEBrowser.Location = New System.Drawing.Point(4, 4)
        Me.tpIEBrowser.Name = "tpIEBrowser"
        Me.tpIEBrowser.Size = New System.Drawing.Size(701, 363)
        Me.tpIEBrowser.TabIndex = 6
        Me.tpIEBrowser.Text = "IE Browser"
        Me.tpIEBrowser.UseVisualStyleBackColor = True
        '
        'OgameBrowserCtrl1
        '
        Me.OgameBrowserCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.OgameBrowserCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.OgameBrowserCtrl1.LogBrowserInfo = False
        Me.OgameBrowserCtrl1.Name = "OgameBrowserCtrl1"
        Me.OgameBrowserCtrl1.Size = New System.Drawing.Size(701, 363)
        Me.OgameBrowserCtrl1.TabIndex = 0
        '
        'Timer1
        '
        Me.Timer1.Enabled = True
        Me.Timer1.SynchronizingObject = Me
        '
        'ofdSQLOpen
        '
        Me.ofdSQLOpen.Filter = "SQL (*.sql)|*.sql|Text (*.txt)|*.txt|All Files (*.*)|*.*"
        '
        'OpenFileDialog1
        '
        Me.OpenFileDialog1.DefaultExt = "wav"
        Me.OpenFileDialog1.Filter = "WAV Files(*.wav)|*.wav|All Files*.*|*.*"
        Me.OpenFileDialog1.Title = "Choose a sound file"
        '
        'BackgroundWorker1
        '
        '
        'MainForm
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(709, 411)
        Me.Controls.Add(Me.tabCtrl)
        Me.Controls.Add(Me.StatusBar1)
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.Menu = Me.MainMenu1
        Me.Name = "MainForm"
        Me.Text = "OGS OGame Stratege "
        CType(Me.sbpRecords, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.sbpStatus, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.sbpClipBoard, System.ComponentModel.ISupportInitialize).EndInit()
        Me.tabCtrl.ResumeLayout(False)
        Me.tpUniverses.ResumeLayout(False)
        Me.tpSQLCommand.ResumeLayout(False)
        Me.GroupBox1.ResumeLayout(False)
        CType(Me.dgSQLQuery, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel2.ResumeLayout(False)
        Me.Panel2.PerformLayout()
        Me.tpConfig.ResumeLayout(False)
        Me.tpConfig.PerformLayout()
        Me.GroupBox2.ResumeLayout(False)
        Me.gbDatabase.ResumeLayout(False)
        Me.gbDatabase.PerformLayout()
        Me.tpTraceLog.ResumeLayout(False)
        Me.tpIEBrowser.ResumeLayout(False)
        CType(Me.Timer1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub NotifyIcon1_DoubleClick(ByVal sender As Object, ByVal e As System.EventArgs) Handles NotifyIcon1.DoubleClick
        If Me.WindowState = FormWindowState.Minimized Then Me.WindowState = FormWindowState.Normal
        Me.Activate()
    End Sub

    Private Sub MenuItem3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MenuItem3.Click, MenuItem1.Click
        Application.Exit()
    End Sub

    Private Sub miRestore_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles miRestore.Click
        Me.Activate()
    End Sub
    Private hWndClipBoard As IntPtr = IntPtr.Zero

    Private BlinkTime As Integer = 0
    Private IsLoaded As Boolean = False
    Private EndLoaded As Boolean = False
    Public WithEvents WinLog As New MiniLog
    Dim redirect As New RedirectConsoleStream
    Private Sub StartOutputInfo()
        Console.WriteLine(Now.ToString & " " & Application.ProductName & " V: " & Application.ProductVersion)
    End Sub

#Region " Loading and Closing Events "

    Protected Overrides Sub OnHandleCreated(ByVal e As System.EventArgs)
        '------------------------------------------------------------
        '     Date          Developer            Code Change
        '  ---------- -------------------- --------------------------
        '  12/10/2005       G Gilbert            Original code
        '------------------------------------------------------------

        '------------------------------------------------------------
        ' Get all of the active processes for the application
        '------------------------------------------------------------
        Dim CurrentProcesses() As Process
        CurrentProcesses = Process.GetProcessesByName _
                           (Process.GetCurrentProcess.ProcessName)

        '------------------------------------------------------------
        ' If there is no previous copy
        ' of the application running, bail
        '------------------------------------------------------------
        If CurrentProcesses.GetUpperBound(0) <= 0 Then
            ReadConfig()
            Exit Sub
        End If

        '------------------------------------------------------------
        ' Make the prior instance of the application
        ' the active window and terminate this
        ' new instance
        '------------------------------------------------------------
        Dim i As Integer
        Dim Result As Long
        Dim ProcessHandle As Long
        For i = 0 To CurrentProcesses.GetUpperBound(0)
            ProcessHandle = CurrentProcesses(i).MainWindowHandle.ToInt32
            If ProcessHandle <> 0 Then
                '** Restore and activate the copy already running
                Result = OpenIcon(ProcessHandle)
                Result = SetForegroundWindow(ProcessHandle)
            End If
        Next
        End
    End Sub
    Private Sub MainForm_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Universes.SplashMessage("OGS Initialisation")
        Me.Text &= " v" & OGameObject.OGameDBEngine.OGSVersion
        redirect.Control = rtbLog
        redirect.redirectOutput()
        StartOutputInfo()
        IsLoaded = True
        hWndClipBoard = SetClipboardViewer(Me.Handle.ToInt32)
        Timer1.Start()
        WinLog.Show()
        WinLog.TopMost = True

        WinLog.AddLine("OGS " & Application.ProductName & " v" & OGameObject.OGameDBEngine.OGSVersion & " ( " & Application.ProductVersion & " )", OGameObject.Functions.enOGSEventType.ProgramInformation)

        AddHandler OGameObject.GalaxyRegX.OnGalaxyUpdate, AddressOf Me.OnGalaxyDetected
        AddHandler OGameObject.Player.OnCreatePlayer, AddressOf Me.OnPlayerCreated
        AddHandler OGameObject.Player.OnPlayerUpdate, AddressOf Me.OnPlayerUpdated
        AddHandler OGameObject.AttackreportRegex.OnAttackDetected, AddressOf Me.OnAttackReport
        AddHandler OGameObject.PlanetRegx.OnSpyingReportDetected, AddressOf Me.OnSpyingReportDetected
        AddHandler OGameObject.FleetCommandRegx.OnFleetCommandCreate, AddressOf Me.OnFleetCommand
        Universes.SplashClose()

        If Config.AutoCheckOGSUpdate OrElse Config.ShowCurrentDevUpdate Then
            Dim ogscu As New OGSCheckUpdate
            AddHandler ogscu.InfoUpdateDone, AddressOf Me.OGSCUpdateChecked
            ogscu.CheckUpdate(True)
        End If
        Mainformloaded = True
    End Sub
    Private Mainformloaded As Boolean = False
    Private Sub OGSCUpdateChecked(ByVal sender As Object)
        Dim ogscu As OGSCheckUpdate = sender
        If ogscu.LastReleaseInfo("version") > OGameObject.OGameDBEngine.OGSVersion Then
            'MessageBox.Show("OGS Update available" & vbCrLf & ogscu.LastReleaseDataString)
            Dim OGSUForm As New OGSUpdateForm

            OGSUForm.OGSCU = ogscu
            OGSUForm.TopMost = True
            OGSUForm.ShowDialog()
            OGSUForm.Dispose()
        End If
        If Config.ShowCurrentDevUpdate Then

        End If
        RemoveHandler ogscu.InfoUpdateDone, AddressOf Me.OGSCUpdateChecked
    End Sub
    Private Sub SaveConfig()
        If Me.WindowState <> FormWindowState.Maximized AndAlso Me.WindowState <> FormWindowState.Minimized Then
            Config.WindowsTop = Me.Top
            Config.WindowsLeft = Me.Left
            Config.WindowsWidth = Me.Width
            Config.WindowsHeight = Me.Height
        End If
        Config.AlwaysOnTop = chkAlwaysOnTop.Checked
        Config.EnableSound = chkEnableSound.Checked
        Config.ClipboardMonitoring = chkClpbMonitoring.Checked
        Config.AutoCheckOGSUpdate = chkAutoCheckUpdate.Checked
        Config.OwnerName = tbDefaultOwner.Text.Trim
        Config.ShowCurrentDevUpdate = chkCheckCurrentDevUpdate.Checked
        WinLog.AddLine("Recording config file", OGameObject.Functions.enOGSEventType.ProgramInformation)
        If WinLog.Height > 0 AndAlso WinLog.Width > 0 Then
            Config.MoniteurHeight = WinLog.Height
            Config.MoniteurWidth = WinLog.Width
        End If
        Config.XMLSerialize()
    End Sub
    Private Sub MainForm_Closing(ByVal sender As Object, ByVal e As System.ComponentModel.CancelEventArgs) Handles MyBase.Closing
        Universes1.SaveCurrentUniverseOption()
        SaveConfig()
        RemoveHandler OGameObject.GalaxyRegX.OnGalaxyUpdate, AddressOf Me.OnGalaxyDetected
        RemoveHandler OGameObject.Player.OnCreatePlayer, AddressOf Me.OnPlayerCreated
        RemoveHandler OGameObject.Player.OnPlayerUpdate, AddressOf Me.OnPlayerUpdated
        RemoveHandler OGameObject.AttackreportRegex.OnAttackDetected, AddressOf Me.OnAttackReport
        RemoveHandler OGameObject.PlanetRegx.OnSpyingReportDetected, AddressOf Me.OnSpyingReportDetected
        RemoveHandler OGameObject.FleetCommandRegx.OnFleetCommandCreate, AddressOf Me.OnFleetCommand
        WinLog.Close()
        ChangeClipboardChain(Me.Handle.ToInt32, hWndClipBoard)

    End Sub

#End Region

#Region " Clipboard  Monitoring Functions "


    Private alreadyworking As Boolean = False
    Private clpboardtext As String

    Protected Overrides Sub WndProc(ByRef m As System.Windows.Forms.Message)
        Const WM_DRAWCLIPBOARD As Integer = &H308
        Const WM_CHANGECBCHAIN As Integer = &H30D
        If m.Msg = WM_DRAWCLIPBOARD AndAlso Config.ClipboardMonitoring AndAlso Not OGameObject.OGameDBEngine.Default Is Nothing AndAlso Mainformloaded Then

            If Not alreadyworking Then
                alreadyworking = True
                Try

                    Dim d As IDataObject = Clipboard.GetDataObject()
                    Clipboard.GetDataObject()
                    If d Is Nothing Then Return
                    If d.GetDataPresent(DataFormats.Text) Then
                        clpboardtext = CStr(d.GetData(DataFormats.Text))

                        AnalyseData(Nothing)
                    End If
                    If Not hWndClipBoard.Equals(IntPtr.Zero) Then
                        SendMessage(hWndClipBoard, m.Msg, m.WParam, m.LParam)
                    End If
                Catch ex As Exception
                    Console.WriteLine(ex.Message)
                End Try
                alreadyworking = False
            End If
        ElseIf m.Msg = WM_CHANGECBCHAIN Then 'Another clipboard viewer has removed itself...
            If m.WParam.Equals(hWndClipBoard) Then
                hWndClipBoard = m.LParam
            Else
                SendMessage(hWndClipBoard, m.Msg, m.WParam, m.LParam)
            End If


        Else
            MyBase.WndProc(m)
        End If
    End Sub

    Public browsing As Boolean = False
    Private Sub AnalyseData(ByVal state As Object, Optional ByVal Document As System.Windows.Forms.HtmlDocument = Nothing)

        If Not browsing Then
            If Config.WAVDetectClipboard <> "" Then
                OGameObject.Sound.PlayWaveFileAsync(Config.WAVDetectClipboard)
            Else
                OGameObject.Sound.PlayWaveResource("misc003.wav")
            End If
        End If


        'DETECTION D'ATTAQUES


        If Not OGameObject.AttackreportRegex.AttackReportDetect(clpboardtext) Is Nothing Then
            If Config.WAVDetectAttack <> "" Then
                OGameObject.Sound.PlayWaveFileAsync(Config.WAVDetectAttack)
            Else

                OGameObject.Sound.PlayWaveResource("battle025.wav")
            End If

            'alreadyworking = False
            Return
        End If

        'DETECTION DE STATISTIQUES
        Dim mc As System.Text.RegularExpressions.MatchCollection

        mc = OGameObject.PlayersRegex.PlayerPoints(clpboardtext)

        If mc.Count AndAlso Not OGameObject.OGameDBEngine.Default Is Nothing Then

            Dim logmsg As String = "Ranking "
            If Config.WAVDetectStats <> "" Then
                OGameObject.Sound.PlayWaveFileAsync(Config.WAVDetectStats)
            Else
                OGameObject.Sound.PlayWaveResource("bells002.wav")
            End If

            Dim frmRankChoice As New frmSelectRankType
            Dim savetopmost As Boolean = Me.TopMost
            Me.TopMost = False

            Dim HtmlRankPattern As String = "Classement\sdes.*?selected>(?<RankWho>[^<]*?)<.*?selected>(?<RankWhat>[^<]*?)<"
            Dim m As System.Text.RegularExpressions.Match = System.Text.RegularExpressions.Regex.Match(clpboardtext, HtmlRankPattern, System.Text.RegularExpressions.RegexOptions.Singleline)

            If m IsNot Nothing And m.Success Then
                With m
                    If .Groups("RankWho").Value <> "joueurs" Then
                        'Pour bloquer les action statistiques alliance
                        MiniLog.AddLine("Les statistiques alliances ne sont pas mises en base de données", OGameObject.enOGSEventType.StatisticDetected)
                        Return
                        Select Case .Groups("RankWhat").Value
                            Case "Points"
                                Universes1.rbAlliPoints.Checked = True
                                logmsg &= " Points from "
                                frmRankChoice.rbAllyTotalPoints.Checked = True
                            Case "Vaisseaux"
                                Universes1.rbAlliFlotte.Checked = True
                                logmsg &= " Flotte from "
                                frmRankChoice.rbAlliFlottePoints.Checked = True
                            Case "Recherche"
                                Universes1.rbAlliResearch.Checked = True
                                logmsg &= " Research from "
                                frmRankChoice.rbAlliResearchPoints.Checked = True
                        End Select
                    Else
                        Select Case .Groups("RankWhat").Value
                            Case "Points"
                                Universes1.rbPointsx.Checked = True
                                logmsg &= " Points from "
                                frmRankChoice.rbTotalPoints.Checked = True
                            Case "Vaisseaux"
                                Universes1.rbFlotte.Checked = True
                                logmsg &= " Flotte from "
                                frmRankChoice.rbFlottePoints.Checked = True
                            Case "Recherche"
                                Universes1.rbResearch.Checked = True
                                logmsg &= " Research from "
                                frmRankChoice.rbResearchPoints.Checked = True
                        End Select
                    End If
                End With
            End If
            logmsg &= mc.Item(0).Groups("Place").Value & " to " & mc.Item(mc.Count - 1).Groups("Place").Value

            With Now
                If .Hour < 8 Then
                    frmRankChoice.dtpUpdate.Value = New Date(.Year, .Month, .Day, 0, 0, 4, 0)
                    frmRankChoice.rbUpdate1.Checked = True
                ElseIf .Hour < 16 Then
                    frmRankChoice.dtpUpdate.Value = New Date(.Year, .Month, .Day, 8, 0, 4, 0)
                    frmRankChoice.rbUpdate2.Checked = True
                Else
                    frmRankChoice.dtpUpdate.Value = New Date(.Year, .Month, .Day, 16, 0, 4, 0)
                    frmRankChoice.rbUpdate3.Checked = True
                End If
            End With


            If frmSelectRankType.AutoConfirmStatsInsertion OrElse frmRankChoice.ShowDialog = Windows.Forms.DialogResult.OK Then

                With frmRankChoice
                    If .rbFlottePoints.Checked Then
                        Universes1.rbFlotte.Checked = True
                    ElseIf .rbResearchPoints.Checked Then
                        Universes1.rbResearch.Checked = True
                    Else
                        Universes1.rbPointsx.Checked = True
                    End If
                End With
                OGameObject.PlayersRegex.UseThisTime = frmRankChoice.dtpUpdate.Value

                BackgroundWorker1.RunWorkerAsync(mc)
                OgameBrowserCtrl1.ConfirmerLentreeDesStatistiquesToolStripMenuItem.Checked = Not frmSelectRankType.AutoConfirmStatsInsertion
            End If
            Me.TopMost = savetopmost
            alreadyworking = False

            Return
        End If
        'DETECTION DES RAPPORTS D'ESPIONAGES
        mc = OGameObject.PlanetRegx.SpyingReportMC(clpboardtext)
        If mc.Count AndAlso Not OGameObject.OGameDBEngine.Default Is Nothing Then
            If Config.WAVDetectEspio <> "" Then
                OGameObject.Sound.PlayWaveFileAsync(Config.WAVDetectEspio)
            Else
                OGameObject.Sound.PlayWaveResource("scifi011.wav")
            End If
            For Each s As OGameObject.SpyReport In OGameObject.PlanetRegx.SpyingReportCol(mc)
            Next

        End If
        'Retour de flotte
        OGameObject.FleetCommandRegx.FleetCommandSearch(clpboardtext)

        'Panneau Recherche et Message joueur pour coordonnées
        OGameObject.PlayersRegex.DetectMainPlanetCoords(clpboardtext)
        'Les buildings et recherche sur les planètes du joueurs
        Dim sd As OGameObject.spydata = OGameObject.PlanetRegx.EmpireBuildResearchDetection(clpboardtext)
        If Not sd Is Nothing Then

            WinLog.AddLine("User Planet Data detected", OGameObject.Functions.enOGSEventType.UserPlanetData)
            Universes1.EmpireCtrl1.FoundData = sd
        End If
        BlinkTime = 20

    End Sub
    Private Sub BackgroundWorker1_DoWork(ByVal sender As System.Object, ByVal e As System.ComponentModel.DoWorkEventArgs) Handles BackgroundWorker1.DoWork

        Dim rankcol As OGameObject.PlayerRankCol = OGameObject.PlayersRegex.PlayersFromPlayerPointsCol(e.Argument, frmSelectRankType.LastRankType)
        If Not rankcol Is Nothing Then
            WinLog.AddLine("Updated " & e.Argument.Count & " " & frmSelectRankType.LastRankType.ToString & " Statistics : " & e.Argument.Item(0).Groups("Place").Value & " - " & CInt(e.Argument.Item(e.Argument.Count - 1).Groups("Place").Value), OGameObject.Functions.enOGSEventType.StatisticDetected)
        End If
    End Sub
    Private Sub MenuItem5_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MenuItem5.Click
        MenuItem5.Checked = Not MenuItem5.Checked
        Config.ClipboardMonitoring = MenuItem5.Checked
    End Sub

#End Region

    Private Sub ThreadedAnalyseStats(ByVal state As Object)

    End Sub

    Private Sub Timer1_Elapsed(ByVal sender As System.Object, ByVal e As System.Timers.ElapsedEventArgs) Handles Timer1.Elapsed
        If BlinkTime > 0 Then
            BlinkTime = BlinkTime - 1
            If sbpClipBoard.BorderStyle = StatusBarPanelBorderStyle.Raised Then
                sbpClipBoard.BorderStyle = StatusBarPanelBorderStyle.Sunken
            Else
                sbpClipBoard.BorderStyle = StatusBarPanelBorderStyle.Raised
            End If

        End If
    End Sub
#Region " Database Update Event "
    Protected Sub OnGalaxyDetected(ByVal Gal As OGameObject.Galaxy)
        WinLog.AddLine("Updated Galaxy " & Gal.Coords, OGameObject.Functions.enOGSEventType.GalaxyDetected)
    End Sub
    Protected Sub OnPlayerCreated(ByVal Player As OGameObject.Player)
        Static lastPlayerID As Integer
        If lastPlayerID <> Player.ID Then
            lastPlayerID = Player.ID
            WinLog.AddLine("Player added " & Player.ToString, OGameObject.Functions.enOGSEventType.NewPlayer)
        End If
    End Sub

    Protected Sub OnPlayerUpdated(ByVal Player As OGameObject.Player)
        Static lastPlayerID As Integer
        If lastPlayerID <> Player.ID Then
            lastPlayerID = Player.ID
            WinLog.AddLine("Player updated " & Player.ToString, OGameObject.Functions.enOGSEventType.PlayerUpdated)
        End If
    End Sub
    Protected Sub OnAttackReport(ByVal Report As OGameObject.AttackReport)
        WinLog.AddLine("Attack : " & Report.DataDate.ToString("MM-dd HH:mm") & " [" & Report.AttackerPlanet.Coords & "] ON [" & Report.DefenderPlanet.Coords & "]", OGameObject.Functions.enOGSEventType.AttackDetected)
    End Sub
    Protected Sub OnSpyingReportDetected(ByVal Report As OGameObject.SpyReport)
        WinLog.AddLine("Spy: " & Report.DataDate.ToString("MM-dd HH:mm") & " " & Report.Planet.Name & " [" & Report.Planet.Coords & "]", OGameObject.Functions.enOGSEventType.SpyReportDetected)
    End Sub

    Protected Sub OnFleetCommand(ByVal Fc As OGameObject.FleetCommand)
        WinLog.AddLine("Fleet Command : " & Fc.DataDate.ToString("MM-dd HH:mm"), OGameObject.Functions.enOGSEventType.Unclassified)
    End Sub
#End Region

#Region " Config  and Panels Change Events "
    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        If OpenFileDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then

            lbbWavClipboard.Value = OpenFileDialog1.FileName
        End If
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        If OpenFileDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
            lbbWavGalaxy.Value = OpenFileDialog1.FileName
        End If

    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        If OpenFileDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
            lbbWavSpying.Value = OpenFileDialog1.FileName
        End If
    End Sub

    Private Sub Button4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button4.Click
        If OpenFileDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
            lbbWavAttacks.Value = OpenFileDialog1.FileName
        End If
    End Sub


    Private Sub Button5_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button5.Click
        If OpenFileDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
            lbbWavStats.Value = OpenFileDialog1.FileName
        End If

    End Sub


    Private Sub Button6_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button6.Click
        Config.WAVDetectAttack = lbbWavAttacks.Value
        Config.WAVDetectClipboard = lbbWavClipboard.Value
        Config.WAVDetectEspio = lbbWavSpying.Value
        Config.WAVDetectGalaxy = lbbWavGalaxy.Value
        Config.WAVDetectStats = lbbWavStats.Value
        Config.HideFromTaskBar = chkConfigHideFromTaskbar.Checked
        Config.OwnerName = tbDefaultOwner.Text
        Config.HideFromTaskBar = chkConfigHideFromTaskbar.Checked
        Config.HideTitleBar = chkHideTitleBar.Checked
        Config.HideMenu = chkHideMenu.Checked
        Config.AlwaysOnTop = chkAlwaysOnTop.Checked
        Config.ServerName = tbDBServer.Text
        Config.ProxyURL = lbbProxy.Value
        Config.ShowCurrentDevUpdate = chkCheckCurrentDevUpdate.Checked
        If rbDBRemote.Checked Then
            tbDBServer.Enabled = True
            Config.DBServertype = 0
            Config.ServerName = tbDBServer.Text
        Else
            Config.DBServertype = 1

        End If
        Config.XMLSerialize()
    End Sub

    Private Sub lbbWavClipboard_Validated(ByVal sender As Object, ByVal e As System.EventArgs) Handles lbbWavClipboard.Validated, lbbWavGalaxy.Validated, lbbWavAttacks.Validated, lbbWavSpying.Validated, lbbWavStats.Validated
        Config.WAVDetectAttack = lbbWavAttacks.Value
        Config.WAVDetectClipboard = lbbWavClipboard.Value
        Config.WAVDetectEspio = lbbWavSpying.Value
        Config.WAVDetectGalaxy = lbbWavGalaxy.Value
        Config.WAVDetectStats = lbbWavStats.Value
    End Sub
    Private Sub ReadConfig()

        tbDefaultOwner.Text = Config.OwnerName
        chkClpbMonitoring.Checked = Config.ClipboardMonitoring
        MenuItem5.Checked = chkClpbMonitoring.Checked
        chkHideTitleBar.Checked = Config.HideTitleBar
        lbbProxy.Value = Config.ProxyURL

        If Config.HideMenu Then
            Me.Menu = Nothing
            chkHideMenu.Checked = True
        End If
        Me.TopMost = Config.AlwaysOnTop
        Me.chkAlwaysOnTop.Checked = Config.AlwaysOnTop
        chkConfigHideFromTaskbar.Checked = Config.HideFromTaskBar
        Me.ShowInTaskbar = Not Config.HideFromTaskBar
        OGameObject.Player.DefaultDataSender = Config.OwnerName
        OGameObject.Sound.enableSound = Config.EnableSound
        chkEnableSound.Checked = Config.EnableSound
        tbDBServer.Text = Config.ServerName
        chkAutoCheckUpdate.Checked = Config.AutoCheckOGSUpdate
        chkCheckCurrentDevUpdate.Checked = Config.ShowCurrentDevUpdate
        lbbWavAttacks.Value = Config.WAVDetectAttack
        lbbWavClipboard.Value = Config.WAVDetectClipboard
        lbbWavSpying.Value = Config.WAVDetectEspio
        lbbWavGalaxy.Value = Config.WAVDetectGalaxy
        lbbWavStats.Value = Config.WAVDetectStats
        chkCheckCurrentDevUpdate.Checked = Config.ShowCurrentDevUpdate
        If Config.WindowsHeight <> 0 AndAlso Config.WindowsHeight <> 0 AndAlso Config.WindowsTop > 0 AndAlso Config.WindowsLeft > 0 Then
            Me.Top = Config.WindowsTop
            Me.Left = Config.WindowsLeft
            Me.Width = Config.WindowsWidth
            Me.Height = Config.WindowsHeight
        End If
        If Config.DBServertype = 1 Then
            WinLog.AddLine("Using Local Database", OGameObject.Functions.enOGSEventType.ProgramInformation)
            rbDBLocal.Checked = True
        Else
            WinLog.AddLine("Using remote Database on " & Config.ServerName, OGameObject.Functions.enOGSEventType.ProgramInformation)
            rbDBRemote.Checked = True
        End If
    End Sub
    Private Sub chkConfigHideFromTaskbar_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkConfigHideFromTaskbar.CheckedChanged
        Config.HideFromTaskBar = chkConfigHideFromTaskbar.Checked
        Me.ShowInTaskbar = Not Config.HideFromTaskBar
    End Sub

    Private Sub tbDefaultOwner_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tbDefaultOwner.TextChanged
        If Not IsLoaded Then Return
        Config.OwnerName = tbDefaultOwner.Text
    End Sub

    Private Sub chkHideTitleBar_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkHideTitleBar.CheckedChanged
        If Not IsLoaded Then Return
        If chkHideTitleBar.Checked Then

            Config.HideTitleBar = True
            Me.Text = ""
            Me.ControlBox = False
        Else
            Config.HideTitleBar = False
            Me.Text = "OGame Stratege"
            Me.ControlBox = True

        End If
    End Sub

    Private Sub chkHideMenu_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkHideMenu.CheckedChanged
        If Not IsLoaded Then Return
        If chkHideMenu.Checked Then
            Config.HideMenu = True
            Me.Menu = Nothing
        Else
            Config.HideMenu = False
            Me.Menu = MainMenu1
        End If
    End Sub

    Private Sub chkAlwaysOnTop_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkAlwaysOnTop.CheckedChanged
        If Not IsLoaded Then Return
        If chkAlwaysOnTop.Checked Then
            Config.AlwaysOnTop = True
            Me.TopMost = True
            'WinLog.AddLine("Setting TOPMOST to True")
        Else
            Config.AlwaysOnTop = False
            Me.TopMost = False
            'WinLog.AddLine("Setting TOPMOST to False")
        End If
    End Sub

#End Region

    Private Sub WinLog_ShowMyDady() Handles WinLog.ShowMyDady
        Me.WindowState = FormWindowState.Normal
        Me.Activate()
    End Sub

    Private Sub Universes1_OnDatabaseOpen(ByVal OgameDB As OGameObject.OGameDBEngine) Handles Universes1.OnDatabaseOpen
        NotifyIcon1.Text = "OGame Stratege : " & OgameDB.Universe.ToString
        WinLog.AddLine("DB : " & OgameDB.Universe.ToString, OGameObject.Functions.enOGSEventType.ProgramInformation)

    End Sub

    Private Sub rbDBRemote_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rbDBRemote.CheckedChanged
        If rbDBRemote.Checked Then
            tbDBServer.Enabled = True
            Config.DBServertype = 0
            Config.ServerName = tbDBServer.Text
            OGameObject.OGameDBEngine.ServerType = 0
            OGameObject.OGameDBEngine.DataSource = tbDBServer.Text
            Config.XMLSerialize()
        Else
            tbDBServer.Enabled = False
            Config.DBServertype = 1

            OGameObject.OGameDBEngine.ServerType = 1
            OGameObject.OGameDBEngine.DataSource = "localhost"
            Config.XMLSerialize()

        End If
    End Sub


    Private Sub tbDBServer_Validated(ByVal sender As Object, ByVal e As System.EventArgs) Handles tbDBServer.Validated
        Config.ServerName = tbDBServer.Text
        OGameObject.OGameDBEngine.DataSource = tbDBServer.Text
        Config.XMLSerialize()
    End Sub


    Private Sub Universes1_TitleClicked(ByVal Sender As Object) Handles Universes1.TitleClicked
        WinLog.TopMost = True
        If WinLog.Visible = False Then WinLog.Show()
    End Sub


    Private Sub miShowMinilog_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles miShowMinilog.Click
        WinLog.TopMost = True
        If WinLog.Visible = False Then
            WinLog.Show()
        Else
            WinLog.Hide()
        End If
    End Sub

    Private Sub btnSQLQuerySend_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSQLQuerySend.Click
        If OGameObject.OGameDBEngine.Default Is Nothing OrElse tbSQLQuery.Text = "" Then
            MessageBox.Show(MainForm.TopForm, "On dirait pas que tu sais ce que tu fais...")
            Return
        End If

        Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
        Try

            If rbSQLQueryCommand.Checked Then
                dgSQLQuery.SetDataBinding(OGameObject.OGameDBEngine.Default.SQLCommand(tbSQLQuery.Text), "")
            Else
                OGameObject.OGameDBEngine.Default.SQLScript(tbSQLQuery.Text)
            End If
        Catch ex As Exception
            MessageBox.Show(MainForm.TopForm, "Error: " & ex.Message)
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
        End Try
        Me.Cursor = System.Windows.Forms.Cursors.Default
    End Sub

    Private Sub chkEnableSound_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles chkEnableSound.CheckedChanged
        OGameObject.Sound.enableSound = chkEnableSound.Checked
    End Sub



    Delegate Sub dlgStatusText(ByVal text As String)
    Private Sub statustext(ByVal text As String)
        If Me.InvokeRequired Then
            Dim d As New dlgStatusText(AddressOf Me.statustext)
            Me.Invoke(d, New Object() {text})
            Exit Sub
        End If
        sbpStatus.Text = text
    End Sub

    Private Sub Universes1_ImportedLines(ByVal sender As Object, ByVal lines As Integer) Handles Universes1.ImportedLines

        statustext("Importation  " & lines & " lines")
    End Sub

    Private Sub Universes1_ImportedResult(ByVal sender As Object, ByVal PlanetUpdated As Integer, ByVal PlanetAdded As Integer, ByVal PlayerUpdated As Integer, ByVal PlayerAdded As Integer) Handles Universes1.ImportedResult
        WinLog.AddLine("Importation Base de données distante (ogspy) effectuée", OGameObject.Functions.enOGSEventType.EndingTask)
        WinLog.AddLine("Planètes: Ajouté " & PlanetAdded & ", Mise à jour " & PlanetUpdated, OGameObject.Functions.enOGSEventType.Unclassified)
        WinLog.AddLine("Joueurs : Ajouté " & PlayerAdded & ", Mis à jour " & PlayerUpdated, OGameObject.Functions.enOGSEventType.Unclassified)
        statustext("Done")
    End Sub

    Private Sub Universes1_ImportedSystem(ByVal sender As Object, ByVal SystemCoords As String) Handles Universes1.ImportedSystem
        WinLog.AddLine("Imported System " & SystemCoords, OGameObject.Functions.enOGSEventType.Import_Planet)
    End Sub

    Private Sub rtbLog_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs)
        rtbLog.SelectionStart = rtbLog.TextLength
        rtbLog.ScrollToCaret()
    End Sub
    Private Sub ThreadExceptionHandler(ByVal sender As Object, ByVal e As System.Threading.ThreadExceptionEventArgs)
        OGameObject.ShowException(e.Exception, "Unhandled Application Exception")

    End Sub

    Private Sub btnSQLLoad_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSQLLoad.Click
        If ofdSQLOpen.ShowDialog = Windows.Forms.DialogResult.OK Then
            Dim sr As New IO.StreamReader(ofdSQLOpen.FileName)
            tbSQLQuery.Text = sr.ReadToEnd
        End If
    End Sub

    Private Sub NotifyIcon1_MouseDown(ByVal sender As System.Object, ByVal e As System.Windows.Forms.MouseEventArgs) Handles NotifyIcon1.MouseDown

    End Sub

    Private Sub Universes1_MessageEvent(ByVal message As String, ByVal EventInfo As OGameObject.enOGSEventType) Handles Universes1.MessageEvent
        WinLog.AddLine(message, EventInfo)
    End Sub

    Private Sub MenuItem8_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MenuItem8.Click
        If WinLog.Visible Then WinLog.Hide() Else WinLog.Show()
    End Sub

    Private Sub WinLog_RequestMapMode(ByVal sender As Object) Handles WinLog.RequestMapMode
        Universes1.ModeMap()
    End Sub

    Private Sub WinLog_RequestScanMode(ByVal sender As Object) Handles WinLog.RequestScanMode
        Universes1.ModeScan()
    End Sub

    Private Sub btnCheckUpdate_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnCheckUpdate.Click
        Dim ogscu As New OGSCheckUpdate
        ogscu.CheckUpdate()
        Dim OGSUForm As New OGSUpdateForm
        OGSUForm.OGSCU = ogscu
        OGSUForm.ShowDialog()
        OGSUForm.Dispose()


    End Sub

    Private Sub Universes1_QueryCheckForUpdate() Handles Universes1.QueryCheckForUpdate
        Dim ogscu As New OGSCheckUpdate
        ogscu.CheckUpdate()
        Dim OGSUForm As New OGSUpdateForm
        OGSUForm.OGSCU = ogscu
        OGSUForm.ShowDialog()
        OGSUForm.Dispose()

    End Sub



    Private Sub lbbProxy_Validated(ByVal sender As Object, ByVal e As System.EventArgs) Handles lbbProxy.Validated
        OGameObject.SharingDB.proxyurl = lbbProxy.Value
    End Sub
    Public WithEvents BrowserWin As OGameObject.BrowserWindow

    Private Sub OgameBrowserCtrl1_BrowserDocumentCompleted(ByVal sender As Object, ByVal e As System.Windows.Forms.WebBrowserDocumentCompletedEventArgs) Handles OgameBrowserCtrl1.BrowserDocumentCompleted

    End Sub
    Private Sub OgameBrowserCtrl1_BrowserNewWindow(ByVal sender As Object, ByVal url As String) Handles OgameBrowserCtrl1.BrowserNewWindow
        If BrowserWin Is Nothing Then
            BrowserWin = New OGameObject.BrowserWindow
        End If
        BrowserWin.OgameBrowserCtrl1.goUrl(url)
        BrowserWin.Show()
    End Sub



    Private Sub OgameBrowserCtrl1_HauptframeDocument(ByVal sender As System.Windows.Forms.WebBrowser, ByVal WebText As String) Handles OgameBrowserCtrl1.HauptframeDocument
        browsing = True
        clpboardtext = WebText
        AnalyseData(Nothing, sender.Document)
        browsing = False
    End Sub

    Private Sub OgameBrowserCtrl1_OGameGalaxy(ByRef url As System.Uri, ByRef Document As System.Windows.Forms.HtmlDocument) Handles OgameBrowserCtrl1.OGameGalaxy
        Dim gal As OGameObject.Galaxy = OGameObject.GalaxyRegX.GalaxyFromHtml(Document)
        Universes1.nudGalaxy.Value = gal.Galaxy
        Universes1.nudSystem.Value = gal.System
    End Sub


    Private Sub OgameBrowserCtrl1_OnChangeConfirmStats(ByVal sender As Object, ByVal ConfirmStats As Boolean) Handles OgameBrowserCtrl1.OnChangeConfirmStats
        frmSelectRankType.AutoConfirmStatsInsertion = Not ConfirmStats
    End Sub

    Private Sub BrowserWin_Disposed(ByVal sender As Object, ByVal e As System.EventArgs) Handles BrowserWin.Disposed
        BrowserWin = Nothing
    End Sub
End Class
Structure WorkingStats
    Dim mc As System.Text.RegularExpressions.MatchCollection
End Structure