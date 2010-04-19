Imports System.Windows.Forms
Public Class OGSUpdateForm
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
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents RichTextBox1 As System.Windows.Forms.RichTextBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents lbInternalVersion As OGameStratege.LabelBox
    Friend WithEvents lbVersion As OGameStratege.LabelBox
    Friend WithEvents CheckBox1 As System.Windows.Forms.CheckBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(OGSUpdateForm))
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.lbInternalVersion = New OGameStratege.LabelBox
        Me.lbVersion = New OGameStratege.LabelBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.CheckBox1 = New System.Windows.Forms.CheckBox
        Me.Button1 = New System.Windows.Forms.Button
        Me.RichTextBox1 = New System.Windows.Forms.RichTextBox
        Me.Panel1.SuspendLayout()
        Me.Panel2.SuspendLayout()
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
        Me.Panel1.Controls.Add(Me.lbInternalVersion)
        Me.Panel1.Controls.Add(Me.lbVersion)
        Me.Panel1.Controls.Add(Me.Label1)
        Me.Panel1.Dock = CType(resources.GetObject("Panel1.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel1.Enabled = CType(resources.GetObject("Panel1.Enabled"), Boolean)
        Me.Panel1.Font = CType(resources.GetObject("Panel1.Font"), System.Drawing.Font)
        Me.Panel1.ImeMode = CType(resources.GetObject("Panel1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel1.Location = CType(resources.GetObject("Panel1.Location"), System.Drawing.Point)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.RightToLeft = CType(resources.GetObject("Panel1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel1.Size = CType(resources.GetObject("Panel1.Size"), System.Drawing.Size)
        Me.Panel1.TabIndex = CType(resources.GetObject("Panel1.TabIndex"), Integer)
        Me.Panel1.Text = resources.GetString("Panel1.Text")
        Me.Panel1.Visible = CType(resources.GetObject("Panel1.Visible"), Boolean)
        '
        'lbInternalVersion
        '
        Me.lbInternalVersion.AccessibleDescription = resources.GetString("lbInternalVersion.AccessibleDescription")
        Me.lbInternalVersion.AccessibleName = resources.GetString("lbInternalVersion.AccessibleName")
        Me.lbInternalVersion.Anchor = CType(resources.GetObject("lbInternalVersion.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbInternalVersion.AutoScroll = CType(resources.GetObject("lbInternalVersion.AutoScroll"), Boolean)
        Me.lbInternalVersion.AutoScrollMargin = CType(resources.GetObject("lbInternalVersion.AutoScrollMargin"), System.Drawing.Size)
        Me.lbInternalVersion.AutoScrollMinSize = CType(resources.GetObject("lbInternalVersion.AutoScrollMinSize"), System.Drawing.Size)
        Me.lbInternalVersion.BackgroundImage = CType(resources.GetObject("lbInternalVersion.BackgroundImage"), System.Drawing.Image)
        Me.lbInternalVersion.Caption = "Internal Version"
        Me.lbInternalVersion.CaptionWidth = 80
        Me.lbInternalVersion.Dock = CType(resources.GetObject("lbInternalVersion.Dock"), System.Windows.Forms.DockStyle)
        Me.lbInternalVersion.Enabled = CType(resources.GetObject("lbInternalVersion.Enabled"), Boolean)
        Me.lbInternalVersion.Font = CType(resources.GetObject("lbInternalVersion.Font"), System.Drawing.Font)
        Me.lbInternalVersion.ImeMode = CType(resources.GetObject("lbInternalVersion.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbInternalVersion.Location = CType(resources.GetObject("lbInternalVersion.Location"), System.Drawing.Point)
        Me.lbInternalVersion.Name = "lbInternalVersion"
        Me.lbInternalVersion.ReadOnly = True
        Me.lbInternalVersion.RightToLeft = CType(resources.GetObject("lbInternalVersion.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbInternalVersion.Size = CType(resources.GetObject("lbInternalVersion.Size"), System.Drawing.Size)
        Me.lbInternalVersion.TabIndex = CType(resources.GetObject("lbInternalVersion.TabIndex"), Integer)
        Me.lbInternalVersion.Value = ""
        Me.lbInternalVersion.Visible = CType(resources.GetObject("lbInternalVersion.Visible"), Boolean)
        '
        'lbVersion
        '
        Me.lbVersion.AccessibleDescription = resources.GetString("lbVersion.AccessibleDescription")
        Me.lbVersion.AccessibleName = resources.GetString("lbVersion.AccessibleName")
        Me.lbVersion.Anchor = CType(resources.GetObject("lbVersion.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbVersion.AutoScroll = CType(resources.GetObject("lbVersion.AutoScroll"), Boolean)
        Me.lbVersion.AutoScrollMargin = CType(resources.GetObject("lbVersion.AutoScrollMargin"), System.Drawing.Size)
        Me.lbVersion.AutoScrollMinSize = CType(resources.GetObject("lbVersion.AutoScrollMinSize"), System.Drawing.Size)
        Me.lbVersion.BackgroundImage = CType(resources.GetObject("lbVersion.BackgroundImage"), System.Drawing.Image)
        Me.lbVersion.Caption = "Version"
        Me.lbVersion.CaptionWidth = 80
        Me.lbVersion.Dock = CType(resources.GetObject("lbVersion.Dock"), System.Windows.Forms.DockStyle)
        Me.lbVersion.Enabled = CType(resources.GetObject("lbVersion.Enabled"), Boolean)
        Me.lbVersion.Font = CType(resources.GetObject("lbVersion.Font"), System.Drawing.Font)
        Me.lbVersion.ImeMode = CType(resources.GetObject("lbVersion.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbVersion.Location = CType(resources.GetObject("lbVersion.Location"), System.Drawing.Point)
        Me.lbVersion.Name = "lbVersion"
        Me.lbVersion.ReadOnly = True
        Me.lbVersion.RightToLeft = CType(resources.GetObject("lbVersion.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbVersion.Size = CType(resources.GetObject("lbVersion.Size"), System.Drawing.Size)
        Me.lbVersion.TabIndex = CType(resources.GetObject("lbVersion.TabIndex"), Integer)
        Me.lbVersion.Value = ""
        Me.lbVersion.Visible = CType(resources.GetObject("lbVersion.Visible"), Boolean)
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
        Me.Label1.Visible = CType(resources.GetObject("Label1.Visible"), Boolean)
        '
        'Panel2
        '
        Me.Panel2.AccessibleDescription = resources.GetString("Panel2.AccessibleDescription")
        Me.Panel2.AccessibleName = resources.GetString("Panel2.AccessibleName")
        Me.Panel2.Anchor = CType(resources.GetObject("Panel2.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Panel2.AutoScroll = CType(resources.GetObject("Panel2.AutoScroll"), Boolean)
        Me.Panel2.AutoScrollMargin = CType(resources.GetObject("Panel2.AutoScrollMargin"), System.Drawing.Size)
        Me.Panel2.AutoScrollMinSize = CType(resources.GetObject("Panel2.AutoScrollMinSize"), System.Drawing.Size)
        Me.Panel2.BackColor = System.Drawing.SystemColors.Control
        Me.Panel2.BackgroundImage = CType(resources.GetObject("Panel2.BackgroundImage"), System.Drawing.Image)
        Me.Panel2.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Panel2.Controls.Add(Me.CheckBox1)
        Me.Panel2.Controls.Add(Me.Button1)
        Me.Panel2.Dock = CType(resources.GetObject("Panel2.Dock"), System.Windows.Forms.DockStyle)
        Me.Panel2.DockPadding.All = 5
        Me.Panel2.Enabled = CType(resources.GetObject("Panel2.Enabled"), Boolean)
        Me.Panel2.Font = CType(resources.GetObject("Panel2.Font"), System.Drawing.Font)
        Me.Panel2.ImeMode = CType(resources.GetObject("Panel2.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Panel2.Location = CType(resources.GetObject("Panel2.Location"), System.Drawing.Point)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.RightToLeft = CType(resources.GetObject("Panel2.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Panel2.Size = CType(resources.GetObject("Panel2.Size"), System.Drawing.Size)
        Me.Panel2.TabIndex = CType(resources.GetObject("Panel2.TabIndex"), Integer)
        Me.Panel2.Text = resources.GetString("Panel2.Text")
        Me.Panel2.Visible = CType(resources.GetObject("Panel2.Visible"), Boolean)
        '
        'CheckBox1
        '
        Me.CheckBox1.AccessibleDescription = resources.GetString("CheckBox1.AccessibleDescription")
        Me.CheckBox1.AccessibleName = resources.GetString("CheckBox1.AccessibleName")
        Me.CheckBox1.Anchor = CType(resources.GetObject("CheckBox1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.CheckBox1.Appearance = CType(resources.GetObject("CheckBox1.Appearance"), System.Windows.Forms.Appearance)
        Me.CheckBox1.BackgroundImage = CType(resources.GetObject("CheckBox1.BackgroundImage"), System.Drawing.Image)
        Me.CheckBox1.CheckAlign = CType(resources.GetObject("CheckBox1.CheckAlign"), System.Drawing.ContentAlignment)
        Me.CheckBox1.Dock = CType(resources.GetObject("CheckBox1.Dock"), System.Windows.Forms.DockStyle)
        Me.CheckBox1.Enabled = CType(resources.GetObject("CheckBox1.Enabled"), Boolean)
        Me.CheckBox1.FlatStyle = CType(resources.GetObject("CheckBox1.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.CheckBox1.Font = CType(resources.GetObject("CheckBox1.Font"), System.Drawing.Font)
        Me.CheckBox1.Image = CType(resources.GetObject("CheckBox1.Image"), System.Drawing.Image)
        Me.CheckBox1.ImageAlign = CType(resources.GetObject("CheckBox1.ImageAlign"), System.Drawing.ContentAlignment)
        Me.CheckBox1.ImageIndex = CType(resources.GetObject("CheckBox1.ImageIndex"), Integer)
        Me.CheckBox1.ImeMode = CType(resources.GetObject("CheckBox1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.CheckBox1.Location = CType(resources.GetObject("CheckBox1.Location"), System.Drawing.Point)
        Me.CheckBox1.Name = "CheckBox1"
        Me.CheckBox1.RightToLeft = CType(resources.GetObject("CheckBox1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.CheckBox1.Size = CType(resources.GetObject("CheckBox1.Size"), System.Drawing.Size)
        Me.CheckBox1.TabIndex = CType(resources.GetObject("CheckBox1.TabIndex"), Integer)
        Me.CheckBox1.Text = resources.GetString("CheckBox1.Text")
        Me.CheckBox1.TextAlign = CType(resources.GetObject("CheckBox1.TextAlign"), System.Drawing.ContentAlignment)
        Me.CheckBox1.Visible = CType(resources.GetObject("CheckBox1.Visible"), Boolean)
        '
        'Button1
        '
        Me.Button1.AccessibleDescription = resources.GetString("Button1.AccessibleDescription")
        Me.Button1.AccessibleName = resources.GetString("Button1.AccessibleName")
        Me.Button1.Anchor = CType(resources.GetObject("Button1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button1.BackgroundImage = CType(resources.GetObject("Button1.BackgroundImage"), System.Drawing.Image)
        Me.Button1.DialogResult = System.Windows.Forms.DialogResult.OK
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
        Me.Button1.Visible = CType(resources.GetObject("Button1.Visible"), Boolean)
        '
        'RichTextBox1
        '
        Me.RichTextBox1.AccessibleDescription = resources.GetString("RichTextBox1.AccessibleDescription")
        Me.RichTextBox1.AccessibleName = resources.GetString("RichTextBox1.AccessibleName")
        Me.RichTextBox1.Anchor = CType(resources.GetObject("RichTextBox1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.RichTextBox1.AutoSize = CType(resources.GetObject("RichTextBox1.AutoSize"), Boolean)
        Me.RichTextBox1.BackColor = System.Drawing.SystemColors.Control
        Me.RichTextBox1.BackgroundImage = CType(resources.GetObject("RichTextBox1.BackgroundImage"), System.Drawing.Image)
        Me.RichTextBox1.BulletIndent = CType(resources.GetObject("RichTextBox1.BulletIndent"), Integer)
        Me.RichTextBox1.Dock = CType(resources.GetObject("RichTextBox1.Dock"), System.Windows.Forms.DockStyle)
        Me.RichTextBox1.Enabled = CType(resources.GetObject("RichTextBox1.Enabled"), Boolean)
        Me.RichTextBox1.Font = CType(resources.GetObject("RichTextBox1.Font"), System.Drawing.Font)
        Me.RichTextBox1.ForeColor = System.Drawing.SystemColors.ControlText
        Me.RichTextBox1.HideSelection = False
        Me.RichTextBox1.ImeMode = CType(resources.GetObject("RichTextBox1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.RichTextBox1.Location = CType(resources.GetObject("RichTextBox1.Location"), System.Drawing.Point)
        Me.RichTextBox1.MaxLength = CType(resources.GetObject("RichTextBox1.MaxLength"), Integer)
        Me.RichTextBox1.Multiline = CType(resources.GetObject("RichTextBox1.Multiline"), Boolean)
        Me.RichTextBox1.Name = "RichTextBox1"
        Me.RichTextBox1.ReadOnly = True
        Me.RichTextBox1.RightMargin = CType(resources.GetObject("RichTextBox1.RightMargin"), Integer)
        Me.RichTextBox1.RightToLeft = CType(resources.GetObject("RichTextBox1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.RichTextBox1.ScrollBars = CType(resources.GetObject("RichTextBox1.ScrollBars"), System.Windows.Forms.RichTextBoxScrollBars)
        Me.RichTextBox1.Size = CType(resources.GetObject("RichTextBox1.Size"), System.Drawing.Size)
        Me.RichTextBox1.TabIndex = CType(resources.GetObject("RichTextBox1.TabIndex"), Integer)
        Me.RichTextBox1.Text = resources.GetString("RichTextBox1.Text")
        Me.RichTextBox1.Visible = CType(resources.GetObject("RichTextBox1.Visible"), Boolean)
        Me.RichTextBox1.WordWrap = CType(resources.GetObject("RichTextBox1.WordWrap"), Boolean)
        Me.RichTextBox1.ZoomFactor = CType(resources.GetObject("RichTextBox1.ZoomFactor"), Single)
        '
        'OGSUpdateForm
        '
        Me.AccessibleDescription = resources.GetString("$this.AccessibleDescription")
        Me.AccessibleName = resources.GetString("$this.AccessibleName")
        Me.AutoScaleBaseSize = CType(resources.GetObject("$this.AutoScaleBaseSize"), System.Drawing.Size)
        Me.AutoScroll = CType(resources.GetObject("$this.AutoScroll"), Boolean)
        Me.AutoScrollMargin = CType(resources.GetObject("$this.AutoScrollMargin"), System.Drawing.Size)
        Me.AutoScrollMinSize = CType(resources.GetObject("$this.AutoScrollMinSize"), System.Drawing.Size)
        Me.BackgroundImage = CType(resources.GetObject("$this.BackgroundImage"), System.Drawing.Image)
        Me.ClientSize = CType(resources.GetObject("$this.ClientSize"), System.Drawing.Size)
        Me.Controls.Add(Me.RichTextBox1)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.Panel1)
        Me.DockPadding.All = 5
        Me.Enabled = CType(resources.GetObject("$this.Enabled"), Boolean)
        Me.Font = CType(resources.GetObject("$this.Font"), System.Drawing.Font)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.ImeMode = CType(resources.GetObject("$this.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Location = CType(resources.GetObject("$this.Location"), System.Drawing.Point)
        Me.MaximizeBox = False
        Me.MaximumSize = CType(resources.GetObject("$this.MaximumSize"), System.Drawing.Size)
        Me.MinimizeBox = False
        Me.MinimumSize = CType(resources.GetObject("$this.MinimumSize"), System.Drawing.Size)
        Me.Name = "OGSUpdateForm"
        Me.RightToLeft = CType(resources.GetObject("$this.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.SizeGripStyle = System.Windows.Forms.SizeGripStyle.Hide
        Me.StartPosition = CType(resources.GetObject("$this.StartPosition"), System.Windows.Forms.FormStartPosition)
        Me.Text = resources.GetString("$this.Text")
        Me.Panel1.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region
    Private alreadyloaded As Boolean = False
    Private Sub OGSUpdateForm_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        lbVersion.Value = OGameObject.OGameDBEngine.OGSVersion
        lbInternalVersion.Value = Application.ProductVersion
        CheckBox1.Checked = MainForm.TopForm.chkAutoCheckUpdate.Checked
        alreadyloaded = True
    End Sub
    Private pOGSCU As OGSCheckUpdate = Nothing
    Public Property OGSCU() As OGSCheckUpdate
        Get
            Return pOGSCU
        End Get
        Set(ByVal Value As OGSCheckUpdate)
            If Not Value Is Nothing Then
                If OGameObject.OGameDBEngine.OGSVersion = Value.LastReleaseInfo("version") Then
                    Label1.Text = "You're using the last official release"
                ElseIf OGameObject.OGameDBEngine.OGSVersion > Value.LastReleaseInfo("version") Then
                    Label1.Text = "You're using a development release"
                Else
                    Label1.Text = "You're using an outdated version. There is a new update available"
                End If
                pOGSCU = Value
                RichTextBox1.Text = ""
                RichTextBox1.Text &= "Description: " & Value.LastReleaseInfo("description") & vbCrLf
                RichTextBox1.Text &= "Version: " & Value.LastReleaseInfo("version") & vbCrLf
                RichTextBox1.Text &= "Internal Version: " & Value.LastReleaseInfo("internalversion") & vbCrLf
                RichTextBox1.Text &= "Board Thread: " & Value.LastReleaseInfo("boardthread") & vbCrLf
                RichTextBox1.Text &= "Download Url: " & Value.LastReleaseInfo("downloadurl") & vbCrLf
                RichTextBox1.Find("Download Url:", RichTextBoxFinds.MatchCase)
                RichTextBox1.SelectionFont = New Font(Me.Font, FontStyle.Underline Or FontStyle.Bold)
                RichTextBox1.SelectionColor = System.Drawing.Color.White
                RichTextBox1.Text &= "Archive size: " & Value.LastReleaseInfo("archivesize") & vbCrLf
                RichTextBox1.Text &= "Comment: " & Value.LastReleaseInfo("comment") & vbCrLf

            End If
        End Set
    End Property

    Private Sub RichTextBox1_LinkClicked(ByVal sender As Object, ByVal e As System.Windows.Forms.LinkClickedEventArgs) Handles RichTextBox1.LinkClicked
        System.Diagnostics.Process.Start(e.LinkText)
    End Sub

    Private Sub CheckBox1_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles CheckBox1.CheckedChanged

        If alreadyloaded Then MainForm.TopForm.chkAutoCheckUpdate.Checked = CheckBox1.Checked
    End Sub
End Class
