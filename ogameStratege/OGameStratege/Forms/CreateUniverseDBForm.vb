Public Class CreateUniverseDBForm
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
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents cbServersUrl As System.Windows.Forms.ComboBox
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents tbUniverseName As System.Windows.Forms.TextBox
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents tbDatabaseFileName As System.Windows.Forms.TextBox
    Friend WithEvents btnOk As System.Windows.Forms.Button
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents lblFile As System.Windows.Forms.Label
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents chkDefaultUniverse As System.Windows.Forms.CheckBox
    Friend WithEvents GroupBox1 As System.Windows.Forms.GroupBox
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents cbDetectNameChangeKeep As System.Windows.Forms.ComboBox
    Friend WithEvents tbTemplateLang As System.Windows.Forms.TextBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(CreateUniverseDBForm))
        Me.Label1 = New System.Windows.Forms.Label
        Me.cbServersUrl = New System.Windows.Forms.ComboBox
        Me.Label2 = New System.Windows.Forms.Label
        Me.tbUniverseName = New System.Windows.Forms.TextBox
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog
        Me.Label3 = New System.Windows.Forms.Label
        Me.Button1 = New System.Windows.Forms.Button
        Me.tbDatabaseFileName = New System.Windows.Forms.TextBox
        Me.btnOk = New System.Windows.Forms.Button
        Me.Button3 = New System.Windows.Forms.Button
        Me.lblFile = New System.Windows.Forms.Label
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.chkDefaultUniverse = New System.Windows.Forms.CheckBox
        Me.GroupBox1 = New System.Windows.Forms.GroupBox
        Me.cbDetectNameChangeKeep = New System.Windows.Forms.ComboBox
        Me.Label4 = New System.Windows.Forms.Label
        Me.tbTemplateLang = New System.Windows.Forms.TextBox
        Me.GroupBox1.SuspendLayout()
        Me.SuspendLayout()
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
        'cbServersUrl
        '
        Me.cbServersUrl.AccessibleDescription = resources.GetString("cbServersUrl.AccessibleDescription")
        Me.cbServersUrl.AccessibleName = resources.GetString("cbServersUrl.AccessibleName")
        Me.cbServersUrl.Anchor = CType(resources.GetObject("cbServersUrl.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.cbServersUrl.BackgroundImage = CType(resources.GetObject("cbServersUrl.BackgroundImage"), System.Drawing.Image)
        Me.cbServersUrl.Dock = CType(resources.GetObject("cbServersUrl.Dock"), System.Windows.Forms.DockStyle)
        Me.cbServersUrl.Enabled = CType(resources.GetObject("cbServersUrl.Enabled"), Boolean)
        Me.cbServersUrl.Font = CType(resources.GetObject("cbServersUrl.Font"), System.Drawing.Font)
        Me.cbServersUrl.ImeMode = CType(resources.GetObject("cbServersUrl.ImeMode"), System.Windows.Forms.ImeMode)
        Me.cbServersUrl.IntegralHeight = CType(resources.GetObject("cbServersUrl.IntegralHeight"), Boolean)
        Me.cbServersUrl.ItemHeight = CType(resources.GetObject("cbServersUrl.ItemHeight"), Integer)
        Me.cbServersUrl.Items.AddRange(New Object() {resources.GetString("cbServersUrl.Items"), resources.GetString("cbServersUrl.Items1"), resources.GetString("cbServersUrl.Items2"), resources.GetString("cbServersUrl.Items3")})
        Me.cbServersUrl.Location = CType(resources.GetObject("cbServersUrl.Location"), System.Drawing.Point)
        Me.cbServersUrl.MaxDropDownItems = CType(resources.GetObject("cbServersUrl.MaxDropDownItems"), Integer)
        Me.cbServersUrl.MaxLength = CType(resources.GetObject("cbServersUrl.MaxLength"), Integer)
        Me.cbServersUrl.Name = "cbServersUrl"
        Me.cbServersUrl.RightToLeft = CType(resources.GetObject("cbServersUrl.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.cbServersUrl.Size = CType(resources.GetObject("cbServersUrl.Size"), System.Drawing.Size)
        Me.cbServersUrl.TabIndex = CType(resources.GetObject("cbServersUrl.TabIndex"), Integer)
        Me.cbServersUrl.Text = resources.GetString("cbServersUrl.Text")
        Me.ToolTip1.SetToolTip(Me.cbServersUrl, resources.GetString("cbServersUrl.ToolTip"))
        Me.cbServersUrl.Visible = CType(resources.GetObject("cbServersUrl.Visible"), Boolean)
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
        'tbUniverseName
        '
        Me.tbUniverseName.AccessibleDescription = resources.GetString("tbUniverseName.AccessibleDescription")
        Me.tbUniverseName.AccessibleName = resources.GetString("tbUniverseName.AccessibleName")
        Me.tbUniverseName.Anchor = CType(resources.GetObject("tbUniverseName.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbUniverseName.AutoSize = CType(resources.GetObject("tbUniverseName.AutoSize"), Boolean)
        Me.tbUniverseName.BackgroundImage = CType(resources.GetObject("tbUniverseName.BackgroundImage"), System.Drawing.Image)
        Me.tbUniverseName.Dock = CType(resources.GetObject("tbUniverseName.Dock"), System.Windows.Forms.DockStyle)
        Me.tbUniverseName.Enabled = CType(resources.GetObject("tbUniverseName.Enabled"), Boolean)
        Me.tbUniverseName.Font = CType(resources.GetObject("tbUniverseName.Font"), System.Drawing.Font)
        Me.tbUniverseName.ImeMode = CType(resources.GetObject("tbUniverseName.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbUniverseName.Location = CType(resources.GetObject("tbUniverseName.Location"), System.Drawing.Point)
        Me.tbUniverseName.MaxLength = CType(resources.GetObject("tbUniverseName.MaxLength"), Integer)
        Me.tbUniverseName.Multiline = CType(resources.GetObject("tbUniverseName.Multiline"), Boolean)
        Me.tbUniverseName.Name = "tbUniverseName"
        Me.tbUniverseName.PasswordChar = CType(resources.GetObject("tbUniverseName.PasswordChar"), Char)
        Me.tbUniverseName.RightToLeft = CType(resources.GetObject("tbUniverseName.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbUniverseName.ScrollBars = CType(resources.GetObject("tbUniverseName.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbUniverseName.Size = CType(resources.GetObject("tbUniverseName.Size"), System.Drawing.Size)
        Me.tbUniverseName.TabIndex = CType(resources.GetObject("tbUniverseName.TabIndex"), Integer)
        Me.tbUniverseName.Text = resources.GetString("tbUniverseName.Text")
        Me.tbUniverseName.TextAlign = CType(resources.GetObject("tbUniverseName.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbUniverseName, resources.GetString("tbUniverseName.ToolTip"))
        Me.tbUniverseName.Visible = CType(resources.GetObject("tbUniverseName.Visible"), Boolean)
        Me.tbUniverseName.WordWrap = CType(resources.GetObject("tbUniverseName.WordWrap"), Boolean)
        '
        'OpenFileDialog1
        '
        Me.OpenFileDialog1.CheckFileExists = False
        Me.OpenFileDialog1.DefaultExt = "FDB"
        Me.OpenFileDialog1.Filter = resources.GetString("OpenFileDialog1.Filter")
        Me.OpenFileDialog1.Title = resources.GetString("OpenFileDialog1.Title")
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
        'tbDatabaseFileName
        '
        Me.tbDatabaseFileName.AccessibleDescription = resources.GetString("tbDatabaseFileName.AccessibleDescription")
        Me.tbDatabaseFileName.AccessibleName = resources.GetString("tbDatabaseFileName.AccessibleName")
        Me.tbDatabaseFileName.Anchor = CType(resources.GetObject("tbDatabaseFileName.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbDatabaseFileName.AutoSize = CType(resources.GetObject("tbDatabaseFileName.AutoSize"), Boolean)
        Me.tbDatabaseFileName.BackgroundImage = CType(resources.GetObject("tbDatabaseFileName.BackgroundImage"), System.Drawing.Image)
        Me.tbDatabaseFileName.Dock = CType(resources.GetObject("tbDatabaseFileName.Dock"), System.Windows.Forms.DockStyle)
        Me.tbDatabaseFileName.Enabled = CType(resources.GetObject("tbDatabaseFileName.Enabled"), Boolean)
        Me.tbDatabaseFileName.Font = CType(resources.GetObject("tbDatabaseFileName.Font"), System.Drawing.Font)
        Me.tbDatabaseFileName.ImeMode = CType(resources.GetObject("tbDatabaseFileName.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbDatabaseFileName.Location = CType(resources.GetObject("tbDatabaseFileName.Location"), System.Drawing.Point)
        Me.tbDatabaseFileName.MaxLength = CType(resources.GetObject("tbDatabaseFileName.MaxLength"), Integer)
        Me.tbDatabaseFileName.Multiline = CType(resources.GetObject("tbDatabaseFileName.Multiline"), Boolean)
        Me.tbDatabaseFileName.Name = "tbDatabaseFileName"
        Me.tbDatabaseFileName.PasswordChar = CType(resources.GetObject("tbDatabaseFileName.PasswordChar"), Char)
        Me.tbDatabaseFileName.RightToLeft = CType(resources.GetObject("tbDatabaseFileName.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbDatabaseFileName.ScrollBars = CType(resources.GetObject("tbDatabaseFileName.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbDatabaseFileName.Size = CType(resources.GetObject("tbDatabaseFileName.Size"), System.Drawing.Size)
        Me.tbDatabaseFileName.TabIndex = CType(resources.GetObject("tbDatabaseFileName.TabIndex"), Integer)
        Me.tbDatabaseFileName.Text = resources.GetString("tbDatabaseFileName.Text")
        Me.tbDatabaseFileName.TextAlign = CType(resources.GetObject("tbDatabaseFileName.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbDatabaseFileName, resources.GetString("tbDatabaseFileName.ToolTip"))
        Me.tbDatabaseFileName.Visible = CType(resources.GetObject("tbDatabaseFileName.Visible"), Boolean)
        Me.tbDatabaseFileName.WordWrap = CType(resources.GetObject("tbDatabaseFileName.WordWrap"), Boolean)
        '
        'btnOk
        '
        Me.btnOk.AccessibleDescription = resources.GetString("btnOk.AccessibleDescription")
        Me.btnOk.AccessibleName = resources.GetString("btnOk.AccessibleName")
        Me.btnOk.Anchor = CType(resources.GetObject("btnOk.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnOk.BackgroundImage = CType(resources.GetObject("btnOk.BackgroundImage"), System.Drawing.Image)
        Me.btnOk.DialogResult = System.Windows.Forms.DialogResult.OK
        Me.btnOk.Dock = CType(resources.GetObject("btnOk.Dock"), System.Windows.Forms.DockStyle)
        Me.btnOk.Enabled = CType(resources.GetObject("btnOk.Enabled"), Boolean)
        Me.btnOk.FlatStyle = CType(resources.GetObject("btnOk.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnOk.Font = CType(resources.GetObject("btnOk.Font"), System.Drawing.Font)
        Me.btnOk.Image = CType(resources.GetObject("btnOk.Image"), System.Drawing.Image)
        Me.btnOk.ImageAlign = CType(resources.GetObject("btnOk.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnOk.ImageIndex = CType(resources.GetObject("btnOk.ImageIndex"), Integer)
        Me.btnOk.ImeMode = CType(resources.GetObject("btnOk.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnOk.Location = CType(resources.GetObject("btnOk.Location"), System.Drawing.Point)
        Me.btnOk.Name = "btnOk"
        Me.btnOk.RightToLeft = CType(resources.GetObject("btnOk.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnOk.Size = CType(resources.GetObject("btnOk.Size"), System.Drawing.Size)
        Me.btnOk.TabIndex = CType(resources.GetObject("btnOk.TabIndex"), Integer)
        Me.btnOk.Text = resources.GetString("btnOk.Text")
        Me.btnOk.TextAlign = CType(resources.GetObject("btnOk.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.btnOk, resources.GetString("btnOk.ToolTip"))
        Me.btnOk.Visible = CType(resources.GetObject("btnOk.Visible"), Boolean)
        '
        'Button3
        '
        Me.Button3.AccessibleDescription = resources.GetString("Button3.AccessibleDescription")
        Me.Button3.AccessibleName = resources.GetString("Button3.AccessibleName")
        Me.Button3.Anchor = CType(resources.GetObject("Button3.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button3.BackgroundImage = CType(resources.GetObject("Button3.BackgroundImage"), System.Drawing.Image)
        Me.Button3.DialogResult = System.Windows.Forms.DialogResult.Cancel
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
        'lblFile
        '
        Me.lblFile.AccessibleDescription = resources.GetString("lblFile.AccessibleDescription")
        Me.lblFile.AccessibleName = resources.GetString("lblFile.AccessibleName")
        Me.lblFile.Anchor = CType(resources.GetObject("lblFile.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lblFile.AutoSize = CType(resources.GetObject("lblFile.AutoSize"), Boolean)
        Me.lblFile.Dock = CType(resources.GetObject("lblFile.Dock"), System.Windows.Forms.DockStyle)
        Me.lblFile.Enabled = CType(resources.GetObject("lblFile.Enabled"), Boolean)
        Me.lblFile.Font = CType(resources.GetObject("lblFile.Font"), System.Drawing.Font)
        Me.lblFile.Image = CType(resources.GetObject("lblFile.Image"), System.Drawing.Image)
        Me.lblFile.ImageAlign = CType(resources.GetObject("lblFile.ImageAlign"), System.Drawing.ContentAlignment)
        Me.lblFile.ImageIndex = CType(resources.GetObject("lblFile.ImageIndex"), Integer)
        Me.lblFile.ImeMode = CType(resources.GetObject("lblFile.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lblFile.Location = CType(resources.GetObject("lblFile.Location"), System.Drawing.Point)
        Me.lblFile.Name = "lblFile"
        Me.lblFile.RightToLeft = CType(resources.GetObject("lblFile.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lblFile.Size = CType(resources.GetObject("lblFile.Size"), System.Drawing.Size)
        Me.lblFile.TabIndex = CType(resources.GetObject("lblFile.TabIndex"), Integer)
        Me.lblFile.Text = resources.GetString("lblFile.Text")
        Me.lblFile.TextAlign = CType(resources.GetObject("lblFile.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.lblFile, resources.GetString("lblFile.ToolTip"))
        Me.lblFile.Visible = CType(resources.GetObject("lblFile.Visible"), Boolean)
        '
        'chkDefaultUniverse
        '
        Me.chkDefaultUniverse.AccessibleDescription = resources.GetString("chkDefaultUniverse.AccessibleDescription")
        Me.chkDefaultUniverse.AccessibleName = resources.GetString("chkDefaultUniverse.AccessibleName")
        Me.chkDefaultUniverse.Anchor = CType(resources.GetObject("chkDefaultUniverse.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.chkDefaultUniverse.Appearance = CType(resources.GetObject("chkDefaultUniverse.Appearance"), System.Windows.Forms.Appearance)
        Me.chkDefaultUniverse.BackgroundImage = CType(resources.GetObject("chkDefaultUniverse.BackgroundImage"), System.Drawing.Image)
        Me.chkDefaultUniverse.CheckAlign = CType(resources.GetObject("chkDefaultUniverse.CheckAlign"), System.Drawing.ContentAlignment)
        Me.chkDefaultUniverse.Dock = CType(resources.GetObject("chkDefaultUniverse.Dock"), System.Windows.Forms.DockStyle)
        Me.chkDefaultUniverse.Enabled = CType(resources.GetObject("chkDefaultUniverse.Enabled"), Boolean)
        Me.chkDefaultUniverse.FlatStyle = CType(resources.GetObject("chkDefaultUniverse.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.chkDefaultUniverse.Font = CType(resources.GetObject("chkDefaultUniverse.Font"), System.Drawing.Font)
        Me.chkDefaultUniverse.Image = CType(resources.GetObject("chkDefaultUniverse.Image"), System.Drawing.Image)
        Me.chkDefaultUniverse.ImageAlign = CType(resources.GetObject("chkDefaultUniverse.ImageAlign"), System.Drawing.ContentAlignment)
        Me.chkDefaultUniverse.ImageIndex = CType(resources.GetObject("chkDefaultUniverse.ImageIndex"), Integer)
        Me.chkDefaultUniverse.ImeMode = CType(resources.GetObject("chkDefaultUniverse.ImeMode"), System.Windows.Forms.ImeMode)
        Me.chkDefaultUniverse.Location = CType(resources.GetObject("chkDefaultUniverse.Location"), System.Drawing.Point)
        Me.chkDefaultUniverse.Name = "chkDefaultUniverse"
        Me.chkDefaultUniverse.RightToLeft = CType(resources.GetObject("chkDefaultUniverse.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.chkDefaultUniverse.Size = CType(resources.GetObject("chkDefaultUniverse.Size"), System.Drawing.Size)
        Me.chkDefaultUniverse.TabIndex = CType(resources.GetObject("chkDefaultUniverse.TabIndex"), Integer)
        Me.chkDefaultUniverse.Text = resources.GetString("chkDefaultUniverse.Text")
        Me.chkDefaultUniverse.TextAlign = CType(resources.GetObject("chkDefaultUniverse.TextAlign"), System.Drawing.ContentAlignment)
        Me.ToolTip1.SetToolTip(Me.chkDefaultUniverse, resources.GetString("chkDefaultUniverse.ToolTip"))
        Me.chkDefaultUniverse.Visible = CType(resources.GetObject("chkDefaultUniverse.Visible"), Boolean)
        '
        'GroupBox1
        '
        Me.GroupBox1.AccessibleDescription = resources.GetString("GroupBox1.AccessibleDescription")
        Me.GroupBox1.AccessibleName = resources.GetString("GroupBox1.AccessibleName")
        Me.GroupBox1.Anchor = CType(resources.GetObject("GroupBox1.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.GroupBox1.BackgroundImage = CType(resources.GetObject("GroupBox1.BackgroundImage"), System.Drawing.Image)
        Me.GroupBox1.Controls.Add(Me.cbDetectNameChangeKeep)
        Me.GroupBox1.Controls.Add(Me.Label4)
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
        'cbDetectNameChangeKeep
        '
        Me.cbDetectNameChangeKeep.AccessibleDescription = resources.GetString("cbDetectNameChangeKeep.AccessibleDescription")
        Me.cbDetectNameChangeKeep.AccessibleName = resources.GetString("cbDetectNameChangeKeep.AccessibleName")
        Me.cbDetectNameChangeKeep.Anchor = CType(resources.GetObject("cbDetectNameChangeKeep.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.cbDetectNameChangeKeep.BackgroundImage = CType(resources.GetObject("cbDetectNameChangeKeep.BackgroundImage"), System.Drawing.Image)
        Me.cbDetectNameChangeKeep.Dock = CType(resources.GetObject("cbDetectNameChangeKeep.Dock"), System.Windows.Forms.DockStyle)
        Me.cbDetectNameChangeKeep.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbDetectNameChangeKeep.Enabled = CType(resources.GetObject("cbDetectNameChangeKeep.Enabled"), Boolean)
        Me.cbDetectNameChangeKeep.Font = CType(resources.GetObject("cbDetectNameChangeKeep.Font"), System.Drawing.Font)
        Me.cbDetectNameChangeKeep.ImeMode = CType(resources.GetObject("cbDetectNameChangeKeep.ImeMode"), System.Windows.Forms.ImeMode)
        Me.cbDetectNameChangeKeep.IntegralHeight = CType(resources.GetObject("cbDetectNameChangeKeep.IntegralHeight"), Boolean)
        Me.cbDetectNameChangeKeep.ItemHeight = CType(resources.GetObject("cbDetectNameChangeKeep.ItemHeight"), Integer)
        Me.cbDetectNameChangeKeep.Items.AddRange(New Object() {resources.GetString("cbDetectNameChangeKeep.Items"), resources.GetString("cbDetectNameChangeKeep.Items1"), resources.GetString("cbDetectNameChangeKeep.Items2")})
        Me.cbDetectNameChangeKeep.Location = CType(resources.GetObject("cbDetectNameChangeKeep.Location"), System.Drawing.Point)
        Me.cbDetectNameChangeKeep.MaxDropDownItems = CType(resources.GetObject("cbDetectNameChangeKeep.MaxDropDownItems"), Integer)
        Me.cbDetectNameChangeKeep.MaxLength = CType(resources.GetObject("cbDetectNameChangeKeep.MaxLength"), Integer)
        Me.cbDetectNameChangeKeep.Name = "cbDetectNameChangeKeep"
        Me.cbDetectNameChangeKeep.RightToLeft = CType(resources.GetObject("cbDetectNameChangeKeep.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.cbDetectNameChangeKeep.Size = CType(resources.GetObject("cbDetectNameChangeKeep.Size"), System.Drawing.Size)
        Me.cbDetectNameChangeKeep.TabIndex = CType(resources.GetObject("cbDetectNameChangeKeep.TabIndex"), Integer)
        Me.cbDetectNameChangeKeep.Text = resources.GetString("cbDetectNameChangeKeep.Text")
        Me.ToolTip1.SetToolTip(Me.cbDetectNameChangeKeep, resources.GetString("cbDetectNameChangeKeep.ToolTip"))
        Me.cbDetectNameChangeKeep.Visible = CType(resources.GetObject("cbDetectNameChangeKeep.Visible"), Boolean)
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
        'tbTemplateLang
        '
        Me.tbTemplateLang.AccessibleDescription = resources.GetString("tbTemplateLang.AccessibleDescription")
        Me.tbTemplateLang.AccessibleName = resources.GetString("tbTemplateLang.AccessibleName")
        Me.tbTemplateLang.Anchor = CType(resources.GetObject("tbTemplateLang.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.tbTemplateLang.AutoSize = CType(resources.GetObject("tbTemplateLang.AutoSize"), Boolean)
        Me.tbTemplateLang.BackgroundImage = CType(resources.GetObject("tbTemplateLang.BackgroundImage"), System.Drawing.Image)
        Me.tbTemplateLang.Dock = CType(resources.GetObject("tbTemplateLang.Dock"), System.Windows.Forms.DockStyle)
        Me.tbTemplateLang.Enabled = CType(resources.GetObject("tbTemplateLang.Enabled"), Boolean)
        Me.tbTemplateLang.Font = CType(resources.GetObject("tbTemplateLang.Font"), System.Drawing.Font)
        Me.tbTemplateLang.ImeMode = CType(resources.GetObject("tbTemplateLang.ImeMode"), System.Windows.Forms.ImeMode)
        Me.tbTemplateLang.Location = CType(resources.GetObject("tbTemplateLang.Location"), System.Drawing.Point)
        Me.tbTemplateLang.MaxLength = CType(resources.GetObject("tbTemplateLang.MaxLength"), Integer)
        Me.tbTemplateLang.Multiline = CType(resources.GetObject("tbTemplateLang.Multiline"), Boolean)
        Me.tbTemplateLang.Name = "tbTemplateLang"
        Me.tbTemplateLang.PasswordChar = CType(resources.GetObject("tbTemplateLang.PasswordChar"), Char)
        Me.tbTemplateLang.RightToLeft = CType(resources.GetObject("tbTemplateLang.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.tbTemplateLang.ScrollBars = CType(resources.GetObject("tbTemplateLang.ScrollBars"), System.Windows.Forms.ScrollBars)
        Me.tbTemplateLang.Size = CType(resources.GetObject("tbTemplateLang.Size"), System.Drawing.Size)
        Me.tbTemplateLang.TabIndex = CType(resources.GetObject("tbTemplateLang.TabIndex"), Integer)
        Me.tbTemplateLang.Text = resources.GetString("tbTemplateLang.Text")
        Me.tbTemplateLang.TextAlign = CType(resources.GetObject("tbTemplateLang.TextAlign"), System.Windows.Forms.HorizontalAlignment)
        Me.ToolTip1.SetToolTip(Me.tbTemplateLang, resources.GetString("tbTemplateLang.ToolTip"))
        Me.tbTemplateLang.Visible = CType(resources.GetObject("tbTemplateLang.Visible"), Boolean)
        Me.tbTemplateLang.WordWrap = CType(resources.GetObject("tbTemplateLang.WordWrap"), Boolean)
        '
        'CreateUniverseDBForm
        '
        Me.AccessibleDescription = resources.GetString("$this.AccessibleDescription")
        Me.AccessibleName = resources.GetString("$this.AccessibleName")
        Me.AutoScaleBaseSize = CType(resources.GetObject("$this.AutoScaleBaseSize"), System.Drawing.Size)
        Me.AutoScroll = CType(resources.GetObject("$this.AutoScroll"), Boolean)
        Me.AutoScrollMargin = CType(resources.GetObject("$this.AutoScrollMargin"), System.Drawing.Size)
        Me.AutoScrollMinSize = CType(resources.GetObject("$this.AutoScrollMinSize"), System.Drawing.Size)
        Me.BackgroundImage = CType(resources.GetObject("$this.BackgroundImage"), System.Drawing.Image)
        Me.ClientSize = CType(resources.GetObject("$this.ClientSize"), System.Drawing.Size)
        Me.Controls.Add(Me.tbTemplateLang)
        Me.Controls.Add(Me.GroupBox1)
        Me.Controls.Add(Me.chkDefaultUniverse)
        Me.Controls.Add(Me.lblFile)
        Me.Controls.Add(Me.Button3)
        Me.Controls.Add(Me.btnOk)
        Me.Controls.Add(Me.tbDatabaseFileName)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.tbUniverseName)
        Me.Controls.Add(Me.cbServersUrl)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Label3)
        Me.Enabled = CType(resources.GetObject("$this.Enabled"), Boolean)
        Me.Font = CType(resources.GetObject("$this.Font"), System.Drawing.Font)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.ImeMode = CType(resources.GetObject("$this.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Location = CType(resources.GetObject("$this.Location"), System.Drawing.Point)
        Me.MaximizeBox = False
        Me.MaximumSize = CType(resources.GetObject("$this.MaximumSize"), System.Drawing.Size)
        Me.MinimizeBox = False
        Me.MinimumSize = CType(resources.GetObject("$this.MinimumSize"), System.Drawing.Size)
        Me.Name = "CreateUniverseDBForm"
        Me.RightToLeft = CType(resources.GetObject("$this.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.ShowInTaskbar = False
        Me.StartPosition = CType(resources.GetObject("$this.StartPosition"), System.Windows.Forms.FormStartPosition)
        Me.Text = resources.GetString("$this.Text")
        Me.ToolTip1.SetToolTip(Me, resources.GetString("$this.ToolTip"))
        Me.TopMost = True
        Me.GroupBox1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        If OpenFileDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
            tbDatabaseFileName.Text = OpenFileDialog1.FileName
        End If
    End Sub


    Private Sub cbServersUrl_TextChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbServersUrl.TextChanged, tbUniverseName.TextChanged
        lblFile.Text = cbServersUrl.Text.Trim.Replace("http://www.ogame.", "").Replace(".", "_") & "_" & tbUniverseName.Text.Trim.Replace(".", "_").Replace(" ", "_") & ".FDB"
        tbDatabaseFileName.Text = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), lblFile.Text)
        If Not Universe Is Nothing Then
            Universe.template_lang = cbServersUrl.Text.Trim.Replace("http://www.ogame.", "")
            tbTemplateLang.Text = Universe.template_lang
        End If
    End Sub


    Private pUniverse As OGameObject.UniverseDB = Nothing
    Public Property Universe() As OGameObject.UniverseDB
        Get
            Return pUniverse
        End Get
        Set(ByVal Value As OGameObject.UniverseDB)
            pUniverse = Value
            If Not Value Is Nothing Then
                tbUniverseName.Text = Universe.UniverseName
                cbServersUrl.Text = Universe.ServerURL
                tbDatabaseFileName.Text = pUniverse.DBFileName
                chkDefaultUniverse.Checked = Universe.DefaultUniverse
                cbDetectNameChangeKeep.SelectedIndex = IIf(Value.PlayerChangeDetectionKeepData = OGameObject.UniverseDB.enDefaultValue.Yes, 0, IIf(Value.PlayerChangeDetectionKeepData = OGameObject.UniverseDB.enDefaultValue.No, 1, 2))
                tbTemplateLang.Text = Universe.template_lang
            End If
        End Set
    End Property

    Private Sub btnOk_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnOk.Click
        If pUniverse Is Nothing Then pUniverse = New OGameObject.UniverseDB
        Universe.DBFileName = tbDatabaseFileName.Text
        Universe.UniverseName = tbUniverseName.Text
        Universe.ServerURL = cbServersUrl.Text
        Universe.DefaultUniverse = chkDefaultUniverse.Checked
        Universe.template_lang = tbTemplateLang.Text
        Select Case cbDetectNameChangeKeep.SelectedIndex
            Case 0
                Universe.PlayerChangeDetectionKeepData = OGameObject.UniverseDB.enDefaultValue.Yes
            Case 1
                Universe.PlayerChangeDetectionKeepData = OGameObject.UniverseDB.enDefaultValue.No
            Case Else
                Universe.PlayerChangeDetectionKeepData = OGameObject.UniverseDB.enDefaultValue.Ask
        End Select
    End Sub
End Class
