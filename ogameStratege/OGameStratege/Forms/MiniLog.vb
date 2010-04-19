Imports OGameObject.Functions.enOGSEventType
Public Class MiniLog
    Inherits System.Windows.Forms.Form
    Public Shared GreenBullet As System.Drawing.Bitmap = New System.Drawing.Bitmap(New System.Drawing.Bitmap(TextFileResourceStream("bullets_diamonds_green_004.gif")), 21, 21)
    Friend WithEvents llTop As System.Windows.Forms.LinkLabel
    Public Shared RedBullet As System.Drawing.Bitmap = New System.Drawing.Bitmap(New System.Drawing.Bitmap(TextFileResourceStream("bullets_diamonds_red_003.gif")), 21, 21)

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
    Friend WithEvents Timer1 As System.Timers.Timer
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents LinkLabel4 As System.Windows.Forms.LinkLabel
    Friend WithEvents PictureBox1 As System.Windows.Forms.PictureBox
    Friend WithEvents LinkLabel1 As System.Windows.Forms.LinkLabel
    Friend WithEvents LinkLabel2 As System.Windows.Forms.LinkLabel
    Friend WithEvents LinkLabel3 As System.Windows.Forms.LinkLabel
    Friend WithEvents TabControl1 As System.Windows.Forms.TabControl
    Friend WithEvents tpAllInfo As System.Windows.Forms.TabPage
    Friend WithEvents rtbLines As System.Windows.Forms.RichTextBox
    Friend WithEvents tpExportImport As System.Windows.Forms.TabPage
    Friend WithEvents lbExportImport As System.Windows.Forms.ListBox
    Friend WithEvents tpDetection As System.Windows.Forms.TabPage
    Friend WithEvents lbDetection As System.Windows.Forms.ListBox
    Friend WithEvents tpNewPlayer As System.Windows.Forms.TabPage
    Friend WithEvents lbNewPlayer As System.Windows.Forms.ListBox
    Friend WithEvents tpPlayerChange As System.Windows.Forms.TabPage
    Friend WithEvents tpMyNote As System.Windows.Forms.TabPage
    Friend WithEvents panMyNoteLeft As System.Windows.Forms.Panel
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents rtbMyNote As System.Windows.Forms.RichTextBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents lbPlayerChange As System.Windows.Forms.ListBox
    Friend WithEvents ImageList1 As System.Windows.Forms.ImageList
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents tpInactives As System.Windows.Forms.TabPage
    Friend WithEvents lbInactive As System.Windows.Forms.ListBox
    Friend WithEvents ContextMenu1 As System.Windows.Forms.ContextMenu
    Friend WithEvents miSaveToFile As System.Windows.Forms.MenuItem
    Friend WithEvents miSendToNote As System.Windows.Forms.MenuItem
    Friend WithEvents miLoadFromFile As System.Windows.Forms.MenuItem
    Friend WithEvents miClear As System.Windows.Forms.MenuItem
    Friend WithEvents OpenFileDialog2 As System.Windows.Forms.OpenFileDialog
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(MiniLog))
        Me.Timer1 = New System.Timers.Timer
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.LinkLabel4 = New System.Windows.Forms.LinkLabel
        Me.PictureBox1 = New System.Windows.Forms.PictureBox
        Me.LinkLabel1 = New System.Windows.Forms.LinkLabel
        Me.LinkLabel2 = New System.Windows.Forms.LinkLabel
        Me.LinkLabel3 = New System.Windows.Forms.LinkLabel
        Me.TabControl1 = New System.Windows.Forms.TabControl
        Me.ContextMenu1 = New System.Windows.Forms.ContextMenu
        Me.miSaveToFile = New System.Windows.Forms.MenuItem
        Me.miLoadFromFile = New System.Windows.Forms.MenuItem
        Me.miSendToNote = New System.Windows.Forms.MenuItem
        Me.miClear = New System.Windows.Forms.MenuItem
        Me.tpAllInfo = New System.Windows.Forms.TabPage
        Me.rtbLines = New System.Windows.Forms.RichTextBox
        Me.tpDetection = New System.Windows.Forms.TabPage
        Me.lbDetection = New System.Windows.Forms.ListBox
        Me.tpNewPlayer = New System.Windows.Forms.TabPage
        Me.lbNewPlayer = New System.Windows.Forms.ListBox
        Me.tpExportImport = New System.Windows.Forms.TabPage
        Me.lbExportImport = New System.Windows.Forms.ListBox
        Me.tpPlayerChange = New System.Windows.Forms.TabPage
        Me.lbPlayerChange = New System.Windows.Forms.ListBox
        Me.tpInactives = New System.Windows.Forms.TabPage
        Me.lbInactive = New System.Windows.Forms.ListBox
        Me.tpMyNote = New System.Windows.Forms.TabPage
        Me.rtbMyNote = New System.Windows.Forms.RichTextBox
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.panMyNoteLeft = New System.Windows.Forms.Panel
        Me.Button2 = New System.Windows.Forms.Button
        Me.Button1 = New System.Windows.Forms.Button
        Me.Button3 = New System.Windows.Forms.Button
        Me.ImageList1 = New System.Windows.Forms.ImageList(Me.components)
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog
        Me.OpenFileDialog2 = New System.Windows.Forms.OpenFileDialog
        Me.llTop = New System.Windows.Forms.LinkLabel
        CType(Me.Timer1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.Panel1.SuspendLayout()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.TabControl1.SuspendLayout()
        Me.tpAllInfo.SuspendLayout()
        Me.tpDetection.SuspendLayout()
        Me.tpNewPlayer.SuspendLayout()
        Me.tpExportImport.SuspendLayout()
        Me.tpPlayerChange.SuspendLayout()
        Me.tpInactives.SuspendLayout()
        Me.tpMyNote.SuspendLayout()
        Me.panMyNoteLeft.SuspendLayout()
        Me.SuspendLayout()
        '
        'Timer1
        '
        Me.Timer1.Enabled = True
        Me.Timer1.Interval = 200
        Me.Timer1.SynchronizingObject = Me
        '
        'Panel1
        '
        Me.Panel1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Panel1.Controls.Add(Me.llTop)
        Me.Panel1.Controls.Add(Me.LinkLabel4)
        Me.Panel1.Controls.Add(Me.PictureBox1)
        Me.Panel1.Controls.Add(Me.LinkLabel1)
        Me.Panel1.Controls.Add(Me.LinkLabel2)
        Me.Panel1.Controls.Add(Me.LinkLabel3)
        resources.ApplyResources(Me.Panel1, "Panel1")
        Me.Panel1.Name = "Panel1"
        '
        'LinkLabel4
        '
        Me.LinkLabel4.BackColor = System.Drawing.Color.Black
        resources.ApplyResources(Me.LinkLabel4, "LinkLabel4")
        Me.LinkLabel4.LinkColor = System.Drawing.Color.Orange
        Me.LinkLabel4.Name = "LinkLabel4"
        Me.LinkLabel4.TabStop = True
        Me.ToolTip1.SetToolTip(Me.LinkLabel4, resources.GetString("LinkLabel4.ToolTip"))
        Me.LinkLabel4.UseCompatibleTextRendering = True
        '
        'PictureBox1
        '
        resources.ApplyResources(Me.PictureBox1, "PictureBox1")
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.TabStop = False
        '
        'LinkLabel1
        '
        Me.LinkLabel1.BackColor = System.Drawing.Color.Black
        resources.ApplyResources(Me.LinkLabel1, "LinkLabel1")
        Me.LinkLabel1.ForeColor = System.Drawing.SystemColors.ControlText
        Me.LinkLabel1.LinkColor = System.Drawing.Color.Red
        Me.LinkLabel1.Name = "LinkLabel1"
        Me.LinkLabel1.TabStop = True
        '
        'LinkLabel2
        '
        Me.LinkLabel2.BackColor = System.Drawing.Color.Black
        resources.ApplyResources(Me.LinkLabel2, "LinkLabel2")
        Me.LinkLabel2.LinkColor = System.Drawing.Color.Chartreuse
        Me.LinkLabel2.Name = "LinkLabel2"
        Me.LinkLabel2.TabStop = True
        '
        'LinkLabel3
        '
        Me.LinkLabel3.BackColor = System.Drawing.Color.Black
        resources.ApplyResources(Me.LinkLabel3, "LinkLabel3")
        Me.LinkLabel3.LinkColor = System.Drawing.Color.Orange
        Me.LinkLabel3.Name = "LinkLabel3"
        Me.LinkLabel3.TabStop = True
        Me.ToolTip1.SetToolTip(Me.LinkLabel3, resources.GetString("LinkLabel3.ToolTip"))
        Me.LinkLabel3.UseCompatibleTextRendering = True
        '
        'TabControl1
        '
        Me.TabControl1.ContextMenu = Me.ContextMenu1
        Me.TabControl1.Controls.Add(Me.tpAllInfo)
        Me.TabControl1.Controls.Add(Me.tpDetection)
        Me.TabControl1.Controls.Add(Me.tpNewPlayer)
        Me.TabControl1.Controls.Add(Me.tpExportImport)
        Me.TabControl1.Controls.Add(Me.tpPlayerChange)
        Me.TabControl1.Controls.Add(Me.tpInactives)
        Me.TabControl1.Controls.Add(Me.tpMyNote)
        resources.ApplyResources(Me.TabControl1, "TabControl1")
        Me.TabControl1.HotTrack = True
        Me.TabControl1.ImageList = Me.ImageList1
        Me.TabControl1.Name = "TabControl1"
        Me.TabControl1.SelectedIndex = 0
        '
        'ContextMenu1
        '
        Me.ContextMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.miSaveToFile, Me.miLoadFromFile, Me.miSendToNote, Me.miClear})
        '
        'miSaveToFile
        '
        Me.miSaveToFile.Index = 0
        resources.ApplyResources(Me.miSaveToFile, "miSaveToFile")
        '
        'miLoadFromFile
        '
        Me.miLoadFromFile.Index = 1
        resources.ApplyResources(Me.miLoadFromFile, "miLoadFromFile")
        '
        'miSendToNote
        '
        Me.miSendToNote.Index = 2
        resources.ApplyResources(Me.miSendToNote, "miSendToNote")
        '
        'miClear
        '
        Me.miClear.Index = 3
        resources.ApplyResources(Me.miClear, "miClear")
        '
        'tpAllInfo
        '
        Me.tpAllInfo.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.tpAllInfo.Controls.Add(Me.rtbLines)
        resources.ApplyResources(Me.tpAllInfo, "tpAllInfo")
        Me.tpAllInfo.Name = "tpAllInfo"
        '
        'rtbLines
        '
        Me.rtbLines.BackColor = System.Drawing.Color.PapayaWhip
        Me.rtbLines.ContextMenu = Me.ContextMenu1
        resources.ApplyResources(Me.rtbLines, "rtbLines")
        Me.rtbLines.HideSelection = False
        Me.rtbLines.Name = "rtbLines"
        Me.rtbLines.ReadOnly = True
        Me.rtbLines.Text = ""
        '
        'tpDetection
        '
        Me.tpDetection.Controls.Add(Me.lbDetection)
        resources.ApplyResources(Me.tpDetection, "tpDetection")
        Me.tpDetection.Name = "tpDetection"
        '
        'lbDetection
        '
        Me.lbDetection.BackColor = System.Drawing.SystemColors.Info
        resources.ApplyResources(Me.lbDetection, "lbDetection")
        Me.lbDetection.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbDetection.Name = "lbDetection"
        Me.lbDetection.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        '
        'tpNewPlayer
        '
        Me.tpNewPlayer.Controls.Add(Me.lbNewPlayer)
        resources.ApplyResources(Me.tpNewPlayer, "tpNewPlayer")
        Me.tpNewPlayer.Name = "tpNewPlayer"
        '
        'lbNewPlayer
        '
        Me.lbNewPlayer.BackColor = System.Drawing.SystemColors.Info
        resources.ApplyResources(Me.lbNewPlayer, "lbNewPlayer")
        Me.lbNewPlayer.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbNewPlayer.Name = "lbNewPlayer"
        Me.lbNewPlayer.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        '
        'tpExportImport
        '
        Me.tpExportImport.Controls.Add(Me.lbExportImport)
        resources.ApplyResources(Me.tpExportImport, "tpExportImport")
        Me.tpExportImport.Name = "tpExportImport"
        '
        'lbExportImport
        '
        Me.lbExportImport.BackColor = System.Drawing.SystemColors.Info
        resources.ApplyResources(Me.lbExportImport, "lbExportImport")
        Me.lbExportImport.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbExportImport.Name = "lbExportImport"
        Me.lbExportImport.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        '
        'tpPlayerChange
        '
        Me.tpPlayerChange.Controls.Add(Me.lbPlayerChange)
        resources.ApplyResources(Me.tpPlayerChange, "tpPlayerChange")
        Me.tpPlayerChange.Name = "tpPlayerChange"
        '
        'lbPlayerChange
        '
        Me.lbPlayerChange.BackColor = System.Drawing.SystemColors.Info
        resources.ApplyResources(Me.lbPlayerChange, "lbPlayerChange")
        Me.lbPlayerChange.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbPlayerChange.Name = "lbPlayerChange"
        Me.lbPlayerChange.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        '
        'tpInactives
        '
        Me.tpInactives.Controls.Add(Me.lbInactive)
        resources.ApplyResources(Me.tpInactives, "tpInactives")
        Me.tpInactives.Name = "tpInactives"
        '
        'lbInactive
        '
        Me.lbInactive.BackColor = System.Drawing.SystemColors.Info
        resources.ApplyResources(Me.lbInactive, "lbInactive")
        Me.lbInactive.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbInactive.Name = "lbInactive"
        Me.lbInactive.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        '
        'tpMyNote
        '
        Me.tpMyNote.Controls.Add(Me.rtbMyNote)
        Me.tpMyNote.Controls.Add(Me.Splitter1)
        Me.tpMyNote.Controls.Add(Me.panMyNoteLeft)
        resources.ApplyResources(Me.tpMyNote, "tpMyNote")
        Me.tpMyNote.Name = "tpMyNote"
        '
        'rtbMyNote
        '
        Me.rtbMyNote.ContextMenu = Me.ContextMenu1
        resources.ApplyResources(Me.rtbMyNote, "rtbMyNote")
        Me.rtbMyNote.Name = "rtbMyNote"
        Me.rtbMyNote.Text = ""
        '
        'Splitter1
        '
        Me.Splitter1.BackColor = System.Drawing.SystemColors.Highlight
        resources.ApplyResources(Me.Splitter1, "Splitter1")
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.TabStop = False
        '
        'panMyNoteLeft
        '
        Me.panMyNoteLeft.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panMyNoteLeft.Controls.Add(Me.Button2)
        Me.panMyNoteLeft.Controls.Add(Me.Button1)
        Me.panMyNoteLeft.Controls.Add(Me.Button3)
        resources.ApplyResources(Me.panMyNoteLeft, "panMyNoteLeft")
        Me.panMyNoteLeft.Name = "panMyNoteLeft"
        '
        'Button2
        '
        resources.ApplyResources(Me.Button2, "Button2")
        Me.Button2.Name = "Button2"
        '
        'Button1
        '
        resources.ApplyResources(Me.Button1, "Button1")
        Me.Button1.Name = "Button1"
        '
        'Button3
        '
        resources.ApplyResources(Me.Button3, "Button3")
        Me.Button3.Name = "Button3"
        '
        'ImageList1
        '
        Me.ImageList1.ImageStream = CType(resources.GetObject("ImageList1.ImageStream"), System.Windows.Forms.ImageListStreamer)
        Me.ImageList1.TransparentColor = System.Drawing.Color.Transparent
        Me.ImageList1.Images.SetKeyName(0, "")
        Me.ImageList1.Images.SetKeyName(1, "")
        '
        'OpenFileDialog2
        '
        resources.ApplyResources(Me.OpenFileDialog2, "OpenFileDialog2")
        '
        'llTop
        '
        Me.llTop.BackColor = System.Drawing.Color.Black
        resources.ApplyResources(Me.llTop, "llTop")
        Me.llTop.LinkColor = System.Drawing.Color.Cyan
        Me.llTop.Name = "llTop"
        Me.llTop.TabStop = True
        Me.ToolTip1.SetToolTip(Me.llTop, resources.GetString("llTop.ToolTip"))
        Me.llTop.UseCompatibleTextRendering = True
        '
        'MiniLog
        '
        resources.ApplyResources(Me, "$this")
        Me.ControlBox = False
        Me.Controls.Add(Me.TabControl1)
        Me.Controls.Add(Me.Panel1)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.SizableToolWindow
        Me.MaximizeBox = False
        Me.Name = "MiniLog"
        Me.ShowInTaskbar = False
        Me.TopMost = True
        CType(Me.Timer1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.Panel1.ResumeLayout(False)
        Me.Panel1.PerformLayout()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.TabControl1.ResumeLayout(False)
        Me.tpAllInfo.ResumeLayout(False)
        Me.tpDetection.ResumeLayout(False)
        Me.tpNewPlayer.ResumeLayout(False)
        Me.tpExportImport.ResumeLayout(False)
        Me.tpPlayerChange.ResumeLayout(False)
        Me.tpInactives.ResumeLayout(False)
        Me.tpMyNote.ResumeLayout(False)
        Me.panMyNoteLeft.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Delegate Sub dlgAddLine(ByVal TextLine As String, ByVal EventInfo As OGameObject.enOGSEventType)
    Public Sub AddLine(ByVal TextLine As String, ByVal EventInfo As OGameObject.enOGSEventType)
        Try

            If Me.InvokeRequired Then
                Dim d As New dlgAddLine(AddressOf Me.AddLine)
                Me.Invoke(d, New Object() {TextLine, EventInfo})
                Exit Sub
            End If
            Select Case EventInfo

                Case AttackDetected, MoonChanged
                    lbDetection.Items.Add(TextLine)
                    tpDetection.ImageIndex = IIf(tpDetection.ImageIndex <> 0, 0, 1)
                Case Export_Planet, Export_Spyreport, Export_Stats, Import_Planet, Import_Stats, Import_Stats
                    lbExportImport.Items.Add(TextLine)
                    tpExportImport.ImageIndex = IIf(tpExportImport.ImageIndex <> 0, 0, 1)
                Case PlayerStatusChanged, PlayerChangeAlly
                    lbPlayerChange.Items.Add(TextLine)
                    tpPlayerChange.ImageIndex = IIf(tpPlayerChange.ImageIndex <> 0, 0, 1)
                Case NewPlayer, MainPlanetDetected
                    lbNewPlayer.Items.Add(TextLine)
                    tpNewPlayer.ImageIndex = IIf(tpNewPlayer.ImageIndex <> 0, 0, 1)
                Case NewInactivePlayer
                    lbInactive.Items.Add(TextLine)
                    tpInactives.ImageIndex = IIf(tpInactives.ImageIndex <> 0, 0, 1)

            End Select
            rtbLines.AppendText(TextLine & vbCrLf)
            If rtbLines.TextLength > 50000 Then
                rtbLines.Text = rtbLines.Text.Substring(rtbLines.TextLength - 50000)
            End If

            rtbLines.SelectionStart = rtbLines.TextLength - 1
            rtbLines.ScrollToCaret()
            '        labCaption.Tag = 10
        Catch ex As Exception

        End Try

    End Sub

 
    Public Sub SetGreenBullet()
        PictureBox1.Image = GreenBullet
    End Sub
    Public Sub SetRedBullet()
        PictureBox1.Image = RedBullet
    End Sub
    Private Sub MiniLog_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        With MainForm.TopForm.Config
            Me.Width = .MoniteurWidth
            Me.Height = .MoniteurHeight
        End With
        Me.Location = New Point(Screen.PrimaryScreen.WorkingArea.Width - Me.Width, Screen.PrimaryScreen.WorkingArea.Height - Me.Height)
        OpenFileDialog2.InitialDirectory = Application.StartupPath
    End Sub

    Private Sub LinkLabel1_LinkClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.LinkLabelLinkClickedEventArgs) Handles LinkLabel1.LinkClicked
        Me.Hide()
    End Sub
    Public Event ShowMyDady()
    Private Sub LinkLabel2_LinkClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.LinkLabelLinkClickedEventArgs) Handles LinkLabel2.LinkClicked
        'Me.ParentForm.Activate()
        RaiseEvent ShowMyDady()
    End Sub
    Public Event RequestScanMode(ByVal sender As Object)
    Private Sub LinkLabel3_LinkClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.LinkLabelLinkClickedEventArgs) Handles LinkLabel3.LinkClicked
        'rtbLines.Text = ""
        RaiseEvent ShowMyDady()
        RaiseEvent RequestScanMode(Me)
    End Sub
    Public Event RequestMapMode(ByVal sender As Object)
    Private Sub LinkLabel4_LinkClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.LinkLabelLinkClickedEventArgs) Handles LinkLabel4.LinkClicked
        RaiseEvent ShowMyDady()
        RaiseEvent RequestMapMode(Me)
    End Sub


    Private Sub rtbLines_LinkClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.LinkClickedEventArgs) Handles rtbLines.LinkClicked
        System.Diagnostics.Process.Start(e.LinkText)
    End Sub

    Private Sub PictureBox1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles PictureBox1.Click
        If PictureBox1.Image.Equals(RedBullet) Then
            PictureBox1.Image = GreenBullet
        Else
            PictureBox1.Image = RedBullet
        End If
    End Sub

    Private Sub TabControl1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles TabControl1.SelectedIndexChanged

        TabControl1.SelectedTab.ImageIndex = -1
        If TabControl1.SelectedTab.Equals(tpMyNote) Then
            miSendToNote.Enabled = False
        Else
            miSendToNote.Enabled = True
        End If
    End Sub

    Private Sub MenuItem1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles miSaveToFile.Click
        Dim filecontent As String = "<------ " & Now.ToString & " ------>" & vbCrLf
        If TabControl1.SelectedTab.Equals(tpNewPlayer) Then
            filecontent &= ">>>>>>>>>>>>>> OGS Log : New Players <<<<<<<<<<<<<" & vbCrLf
            For Each line As String In lbNewPlayer.Items
                filecontent &= line & vbCrLf
            Next
            Functions.SaveTextToFile(filecontent, System.IO.Path.Combine(Application.StartupPath, "newplayer-" & Now.ToString("yyyyMMddHHmmss") & ".log"))
        End If

        If TabControl1.SelectedTab.Equals(tpAllInfo) Then
            filecontent &= ">>>>>>>>>>>>>> OGS Log : All Info <<<<<<<<<<<<<" & vbCrLf
            filecontent &= rtbLines.Text
            Functions.SaveTextToFile(filecontent, System.IO.Path.Combine(Application.StartupPath, "allinfo-" & Now.ToString("yyyyMMddHHmmss") & ".log"))
        End If

        If TabControl1.SelectedTab.Equals(tpInactives) Then
            filecontent &= ">>>>>>>>>>>>>> OGS Log : Inactives Players <<<<<<<<<<<<<" & vbCrLf
            For Each line As String In lbInactive.Items
                filecontent &= line & vbCrLf
            Next
            Functions.SaveTextToFile(filecontent, System.IO.Path.Combine(Application.StartupPath, "inactive-" & Now.ToString("yyyyMMddHHmmss") & ".log"))
        End If
        If TabControl1.SelectedTab.Equals(tpMyNote) Then
            If OGameObject.OGameDBEngine.Default Is Nothing Then
                Functions.SaveTextToFile(rtbMyNote.Text, System.IO.Path.Combine(Application.StartupPath, "GlobalNote.txt"))
            Else
                Functions.SaveTextToFile(rtbMyNote.Text, System.IO.Path.Combine(Application.StartupPath, "GlobalNote-" & OGameObject.OGameDBEngine.Default.Universe.UniverseName & ".txt"))
            End If
        End If

        If TabControl1.SelectedTab.Equals(tpDetection) Then
            filecontent &= ">>>>>>>>>>>>>> OGS Log : Detection <<<<<<<<<<<<<" & vbCrLf
            For Each line As String In lbDetection.Items
                filecontent &= line & vbCrLf
            Next
            Functions.SaveTextToFile(filecontent, System.IO.Path.Combine(Application.StartupPath, "detect-" & Now.ToString("yyyyMMddHHmmss") & ".log"))

        End If
        If TabControl1.SelectedTab.Equals(tpExportImport) Then
            filecontent &= ">>>>>>>>>>>>>> OGS Log : export/Import <<<<<<<<<<<<<" & vbCrLf
            For Each line As String In lbExportImport.Items
                filecontent &= line & vbCrLf
            Next
            Functions.SaveTextToFile(filecontent, System.IO.Path.Combine(Application.StartupPath, "exportimport-" & Now.ToString("yyyyMMddHHmmss") & ".log"))
            lbExportImport.Items.Clear()
        End If

        If TabControl1.SelectedTab.Equals(tpPlayerChange) Then
            filecontent &= ">>>>>>>>>>>>>> OGS Log : Player Changes <<<<<<<<<<<<<" & vbCrLf
            For Each line As String In lbExportImport.Items
                filecontent &= line & vbCrLf
            Next
            Functions.SaveTextToFile(filecontent, System.IO.Path.Combine(Application.StartupPath, "playerchanges-" & Now.ToString("yyyyMMddHHmmss") & ".log"))
            lbExportImport.Items.Clear()
            lbPlayerChange.Items.Clear()
        End If

    End Sub

    Private Sub miClear_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles miClear.Click
        If TabControl1.SelectedTab.Equals(tpNewPlayer) Then
            lbNewPlayer.Items.Clear()
        End If
        If TabControl1.SelectedTab.Equals(tpDetection) Then
            lbDetection.Items.Clear()
        End If
        If TabControl1.SelectedTab.Equals(tpExportImport) Then
            lbExportImport.Items.Clear()
        End If
        If TabControl1.SelectedTab.Equals(tpPlayerChange) Then
            lbPlayerChange.Items.Clear()
        End If
        If TabControl1.SelectedTab.Equals(tpAllInfo) Then
            rtbLines.Text = ""
        End If
        If TabControl1.SelectedTab.Equals(tpInactives) Then
            lbInactive.Items.Clear()
        End If
        If TabControl1.SelectedTab.Equals(tpMyNote) Then
            rtbMyNote.Text = ""
        End If
    End Sub

    Private Sub miLoadFromFile_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles miLoadFromFile.Click
        If TabControl1.SelectedTab.Equals(tpNewPlayer) Then
            OpenFileDialog2.FileName = "newplayer-*.log"
            If OpenFileDialog2.ShowDialog = Windows.Forms.DialogResult.OK Then
                Dim content As String = Functions.GetFileContents(OpenFileDialog2.FileName)
                If content.Length > 0 Then
                    Dim lines() As String = Microsoft.VisualBasic.Split(content, vbCrLf)
                    For Each line As String In lines
                        lbNewPlayer.Items.Add(line)
                    Next
                End If
            End If
        End If
        If TabControl1.SelectedTab.Equals(tpAllInfo) Then
            OpenFileDialog2.FileName = "allinfo-*.log"
            If OpenFileDialog2.ShowDialog = Windows.Forms.DialogResult.OK Then
                rtbLines.Text = Functions.GetFileContents(OpenFileDialog2.FileName)
            End If
        End If
        If TabControl1.SelectedTab.Equals(tpInactives) Then
            OpenFileDialog2.FileName = "inactive-*.log"
            If OpenFileDialog2.ShowDialog = Windows.Forms.DialogResult.OK Then
                Dim content As String = Functions.GetFileContents(OpenFileDialog2.FileName)
                If content.Length > 0 Then
                    Dim lines() As String = Microsoft.VisualBasic.Split(content, vbCrLf)
                    For Each line As String In lines
                        lbInactive.Items.Add(line)
                    Next
                End If
            End If
        End If
        If TabControl1.SelectedTab.Equals(tpDetection) Then
            OpenFileDialog2.FileName = "detect-*.log"
            If OpenFileDialog2.ShowDialog = Windows.Forms.DialogResult.OK Then
                Dim content As String = Functions.GetFileContents(OpenFileDialog2.FileName)
                If content.Length > 0 Then
                    Dim lines() As String = Microsoft.VisualBasic.Split(content, vbCrLf)
                    For Each line As String In lines
                        lbDetection.Items.Add(line)
                    Next
                End If
            End If
        End If
        If TabControl1.SelectedTab.Equals(tpExportImport) Then
            OpenFileDialog2.FileName = "exportimport-*.log"
            If OpenFileDialog2.ShowDialog = Windows.Forms.DialogResult.OK Then
                Dim content As String = Functions.GetFileContents(OpenFileDialog2.FileName)
                If content.Length > 0 Then
                    Dim lines() As String = Microsoft.VisualBasic.Split(content, vbCrLf)
                    For Each line As String In lines
                        lbExportImport.Items.Add(line)
                    Next
                End If
            End If
        End If
        If TabControl1.SelectedTab.Equals(tpPlayerChange) Then
            OpenFileDialog2.FileName = "playerchanges-*.log"
            If OpenFileDialog2.ShowDialog = Windows.Forms.DialogResult.OK Then
                Dim content As String = Functions.GetFileContents(OpenFileDialog2.FileName)
                If content.Length > 0 Then
                    Dim lines() As String = Microsoft.VisualBasic.Split(content, vbCrLf)
                    For Each line As String In lines
                        lbPlayerChange.Items.Add(line)
                    Next
                End If
            End If


        End If
        If TabControl1.SelectedTab.Equals(tpMyNote) Then
            If OGameObject.OGameDBEngine.Default Is Nothing Then
                rtbMyNote.Text = Functions.GetFileContents(System.IO.Path.Combine(Application.StartupPath, "GlobalNote.txt"))
            Else
                rtbMyNote.Text = Functions.GetFileContents(System.IO.Path.Combine(Application.StartupPath, "GlobalNote-" & OGameObject.OGameDBEngine.Default.Universe.UniverseName & ".txt"))
            End If
        End If
    End Sub

    Private Sub miSendToNote_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles miSendToNote.Click
        If TabControl1.SelectedTab.Equals(tpNewPlayer) Then
            For Each l As String In lbNewPlayer.SelectedItems
                rtbMyNote.Text &= l & vbCrLf
            Next
        End If
        If TabControl1.SelectedTab.Equals(tpAllInfo) Then
            rtbMyNote.Text &= rtbLines.SelectedText & vbCrLf
        End If
        If TabControl1.SelectedTab.Equals(tpInactives) Then
            For Each l As String In lbInactive.SelectedItems
                rtbMyNote.Text &= l & vbCrLf
            Next
        End If

        If TabControl1.SelectedTab.Equals(tpDetection) Then
            For Each l As String In lbDetection.SelectedItems
                rtbMyNote.Text &= l & vbCrLf
            Next

        End If
        If TabControl1.SelectedTab.Equals(tpExportImport) Then
            For Each l As String In lbExportImport.SelectedItems
                rtbMyNote.Text &= l & vbCrLf
            Next

        End If
        If TabControl1.SelectedTab.Equals(tpPlayerChange) Then
            For Each l As String In lbPlayerChange.SelectedItems
                rtbMyNote.Text &= l & vbCrLf
            Next
        End If
    End Sub

    Private Sub llTop_LinkClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.LinkLabelLinkClickedEventArgs) Handles llTop.LinkClicked
        Me.TopMost = Not Me.TopMost
        Me.ShowInTaskbar = Not Me.TopMost
    End Sub
End Class
