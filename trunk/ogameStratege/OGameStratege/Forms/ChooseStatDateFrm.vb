Public Class ChooseStatDateFrm
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
    Friend WithEvents ListBox1 As System.Windows.Forms.ListBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Button2 As System.Windows.Forms.Button
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(ChooseStatDateFrm))
        Me.ListBox1 = New System.Windows.Forms.ListBox
        Me.Button1 = New System.Windows.Forms.Button
        Me.Button2 = New System.Windows.Forms.Button
        Me.SuspendLayout()
        '
        'ListBox1
        '
        Me.ListBox1.Anchor = CType(resources.GetObject("ListBox1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.ListBox1.BackgroundImage = CType(resources.GetObject("ListBox1.BackgroundImage"), System.Drawing.Image)
        Me.ListBox1.ColumnWidth = CType(resources.GetObject("ListBox1.ColumnWidth"), Integer)
        Me.ListBox1.Dock = CType(resources.GetObject("ListBox1.Dock"), System.Windows.Forms.DockStyle)
        Me.ListBox1.Enabled = CType(resources.GetObject("ListBox1.Enabled"), Boolean)
        Me.ListBox1.Font = CType(resources.GetObject("ListBox1.Font"), System.Drawing.Font)
        Me.ListBox1.HorizontalExtent = CType(resources.GetObject("ListBox1.HorizontalExtent"), Integer)
        Me.ListBox1.HorizontalScrollbar = CType(resources.GetObject("ListBox1.HorizontalScrollbar"), Boolean)
        Me.ListBox1.ImeMode = CType(resources.GetObject("ListBox1.ImeMode"), System.Windows.Forms.ImeMode)
        Me.ListBox1.IntegralHeight = CType(resources.GetObject("ListBox1.IntegralHeight"), Boolean)
        Me.ListBox1.ItemHeight = CType(resources.GetObject("ListBox1.ItemHeight"), Integer)
        Me.ListBox1.Location = CType(resources.GetObject("ListBox1.Location"), System.Drawing.Point)
        Me.ListBox1.Name = "ListBox1"
        Me.ListBox1.RightToLeft = CType(resources.GetObject("ListBox1.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.ListBox1.ScrollAlwaysVisible = CType(resources.GetObject("ListBox1.ScrollAlwaysVisible"), Boolean)
        Me.ListBox1.Size = CType(resources.GetObject("ListBox1.Size"), System.Drawing.Size)
        Me.ListBox1.TabIndex = CType(resources.GetObject("ListBox1.TabIndex"), Integer)
        Me.ListBox1.Visible = CType(resources.GetObject("ListBox1.Visible"), Boolean)
        '
        'Button1
        '
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
        'Button2
        '
        Me.Button2.Anchor = CType(resources.GetObject("Button2.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button2.BackgroundImage = CType(resources.GetObject("Button2.BackgroundImage"), System.Drawing.Image)
        Me.Button2.DialogResult = System.Windows.Forms.DialogResult.Cancel
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
        Me.Button2.Visible = CType(resources.GetObject("Button2.Visible"), Boolean)
        '
        'ChooseStatDateFrm
        '
        Me.AutoScaleBaseSize = CType(resources.GetObject("$this.AutoScaleBaseSize"), System.Drawing.Size)
        Me.AutoScroll = CType(resources.GetObject("$this.AutoScroll"), Boolean)
        Me.AutoScrollMargin = CType(resources.GetObject("$this.AutoScrollMargin"), System.Drawing.Size)
        Me.AutoScrollMinSize = CType(resources.GetObject("$this.AutoScrollMinSize"), System.Drawing.Size)
        Me.BackgroundImage = CType(resources.GetObject("$this.BackgroundImage"), System.Drawing.Image)
        Me.ClientSize = CType(resources.GetObject("$this.ClientSize"), System.Drawing.Size)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.ListBox1)
        Me.Controls.Add(Me.Button2)
        Me.Enabled = CType(resources.GetObject("$this.Enabled"), Boolean)
        Me.Font = CType(resources.GetObject("$this.Font"), System.Drawing.Font)
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.ImeMode = CType(resources.GetObject("$this.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Location = CType(resources.GetObject("$this.Location"), System.Drawing.Point)
        Me.MaximizeBox = False
        Me.MaximumSize = CType(resources.GetObject("$this.MaximumSize"), System.Drawing.Size)
        Me.MinimizeBox = False
        Me.MinimumSize = CType(resources.GetObject("$this.MinimumSize"), System.Drawing.Size)
        Me.Name = "ChooseStatDateFrm"
        Me.RightToLeft = CType(resources.GetObject("$this.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.StartPosition = CType(resources.GetObject("$this.StartPosition"), System.Windows.Forms.FormStartPosition)
        Me.Text = resources.GetString("$this.Text")
        Me.TopMost = True
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub ChooseStatDateFrm_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        ListBox1.DataSource = OGameObject.OGameDBEngine.Default.StatisticsDate
        ListBox1.DisplayMember = "DATADATE"
    End Sub
    Public ReadOnly Property DataDate() As DateTime
        Get
            If ListBox1.SelectedItem Is Nothing Then Throw New Exception("No Selection in Datetime listbox")
            Return CType(ListBox1.SelectedItem, Data.DataRowView)("DATADATE")
        End Get
    End Property
    Private Sub ListBox1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ListBox1.SelectedIndexChanged
        Button1.Enabled = Not ListBox1.SelectedItem Is Nothing
    End Sub
End Class
