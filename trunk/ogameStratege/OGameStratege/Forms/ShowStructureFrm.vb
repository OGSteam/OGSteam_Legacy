Public Class ShowStructureFrm
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
    Friend WithEvents CheckBox1 As System.Windows.Forms.CheckBox
    Friend WithEvents RichTextBox1 As System.Windows.Forms.RichTextBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(ShowStructureFrm))
        Me.CheckBox1 = New System.Windows.Forms.CheckBox
        Me.RichTextBox1 = New System.Windows.Forms.RichTextBox
        Me.SuspendLayout()
        '
        'CheckBox1
        '
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
        'RichTextBox1
        '
        Me.RichTextBox1.Anchor = CType(resources.GetObject("RichTextBox1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.RichTextBox1.AutoSize = CType(resources.GetObject("RichTextBox1.AutoSize"), Boolean)
        Me.RichTextBox1.BackColor = System.Drawing.SystemColors.Info
        Me.RichTextBox1.BackgroundImage = CType(resources.GetObject("RichTextBox1.BackgroundImage"), System.Drawing.Image)
        Me.RichTextBox1.BulletIndent = CType(resources.GetObject("RichTextBox1.BulletIndent"), Integer)
        Me.RichTextBox1.Dock = CType(resources.GetObject("RichTextBox1.Dock"), System.Windows.Forms.DockStyle)
        Me.RichTextBox1.Enabled = CType(resources.GetObject("RichTextBox1.Enabled"), Boolean)
        Me.RichTextBox1.Font = CType(resources.GetObject("RichTextBox1.Font"), System.Drawing.Font)
        Me.RichTextBox1.ForeColor = System.Drawing.SystemColors.InfoText
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
        Me.RichTextBox1.Text = ""
        Me.RichTextBox1.Visible = CType(resources.GetObject("RichTextBox1.Visible"), Boolean)
        Me.RichTextBox1.WordWrap = CType(resources.GetObject("RichTextBox1.WordWrap"), Boolean)
        Me.RichTextBox1.ZoomFactor = CType(resources.GetObject("RichTextBox1.ZoomFactor"), Single)
        '
        'ShowStructureFrm
        '
        Me.AutoScaleBaseSize = CType(resources.GetObject("$this.AutoScaleBaseSize"), System.Drawing.Size)
        Me.AutoScroll = CType(resources.GetObject("$this.AutoScroll"), Boolean)
        Me.AutoScrollMargin = CType(resources.GetObject("$this.AutoScrollMargin"), System.Drawing.Size)
        Me.AutoScrollMinSize = CType(resources.GetObject("$this.AutoScrollMinSize"), System.Drawing.Size)
        Me.BackgroundImage = CType(resources.GetObject("$this.BackgroundImage"), System.Drawing.Image)
        Me.ClientSize = CType(resources.GetObject("$this.ClientSize"), System.Drawing.Size)
        Me.Controls.Add(Me.RichTextBox1)
        Me.Controls.Add(Me.CheckBox1)
        Me.Enabled = CType(resources.GetObject("$this.Enabled"), Boolean)
        Me.Font = CType(resources.GetObject("$this.Font"), System.Drawing.Font)
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.ImeMode = CType(resources.GetObject("$this.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Location = CType(resources.GetObject("$this.Location"), System.Drawing.Point)
        Me.MaximumSize = CType(resources.GetObject("$this.MaximumSize"), System.Drawing.Size)
        Me.MinimumSize = CType(resources.GetObject("$this.MinimumSize"), System.Drawing.Size)
        Me.Name = "ShowStructureFrm"
        Me.RightToLeft = CType(resources.GetObject("$this.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.StartPosition = CType(resources.GetObject("$this.StartPosition"), System.Windows.Forms.FormStartPosition)
        Me.Text = resources.GetString("$this.Text")
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub CheckBox1_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles CheckBox1.CheckedChanged
        Me.TopMost = CheckBox1.Checked
    End Sub

    Private Sub ShowStructureFrm_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        RichTextBox1.Text = OGameObject.Functions.TextFileResource("dbinit.sql")
    End Sub
End Class
