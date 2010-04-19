Public Class UniversesDatabaseForm
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
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Button5 As System.Windows.Forms.Button
    Friend WithEvents lbUniverses As System.Windows.Forms.ListBox
    Friend WithEvents cmLBUniverses As System.Windows.Forms.ContextMenu
    Friend WithEvents MenuItem1 As System.Windows.Forms.MenuItem
    Friend WithEvents MenuItem2 As System.Windows.Forms.MenuItem
    Friend WithEvents MenuItem3 As System.Windows.Forms.MenuItem
    Friend WithEvents btnProperty As System.Windows.Forms.Button
    Friend WithEvents Button4 As System.Windows.Forms.Button
    Friend WithEvents btndelete As System.Windows.Forms.Button
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(UniversesDatabaseForm))
        Me.lbUniverses = New System.Windows.Forms.ListBox
        Me.cmLBUniverses = New System.Windows.Forms.ContextMenu
        Me.MenuItem1 = New System.Windows.Forms.MenuItem
        Me.MenuItem2 = New System.Windows.Forms.MenuItem
        Me.MenuItem3 = New System.Windows.Forms.MenuItem
        Me.Button1 = New System.Windows.Forms.Button
        Me.btndelete = New System.Windows.Forms.Button
        Me.btnProperty = New System.Windows.Forms.Button
        Me.Button5 = New System.Windows.Forms.Button
        Me.Button4 = New System.Windows.Forms.Button
        Me.SuspendLayout()
        '
        'lbUniverses
        '
        Me.lbUniverses.AccessibleDescription = resources.GetString("lbUniverses.AccessibleDescription")
        Me.lbUniverses.AccessibleName = resources.GetString("lbUniverses.AccessibleName")
        Me.lbUniverses.Anchor = CType(resources.GetObject("lbUniverses.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.lbUniverses.BackColor = System.Drawing.SystemColors.ControlLight
        Me.lbUniverses.BackgroundImage = CType(resources.GetObject("lbUniverses.BackgroundImage"), System.Drawing.Image)
        Me.lbUniverses.ColumnWidth = CType(resources.GetObject("lbUniverses.ColumnWidth"), Integer)
        Me.lbUniverses.ContextMenu = Me.cmLBUniverses
        Me.lbUniverses.Dock = CType(resources.GetObject("lbUniverses.Dock"), System.Windows.Forms.DockStyle)
        Me.lbUniverses.Enabled = CType(resources.GetObject("lbUniverses.Enabled"), Boolean)
        Me.lbUniverses.Font = CType(resources.GetObject("lbUniverses.Font"), System.Drawing.Font)
        Me.lbUniverses.ForeColor = System.Drawing.SystemColors.ControlText
        Me.lbUniverses.HorizontalExtent = CType(resources.GetObject("lbUniverses.HorizontalExtent"), Integer)
        Me.lbUniverses.HorizontalScrollbar = CType(resources.GetObject("lbUniverses.HorizontalScrollbar"), Boolean)
        Me.lbUniverses.ImeMode = CType(resources.GetObject("lbUniverses.ImeMode"), System.Windows.Forms.ImeMode)
        Me.lbUniverses.IntegralHeight = CType(resources.GetObject("lbUniverses.IntegralHeight"), Boolean)
        Me.lbUniverses.ItemHeight = CType(resources.GetObject("lbUniverses.ItemHeight"), Integer)
        Me.lbUniverses.Location = CType(resources.GetObject("lbUniverses.Location"), System.Drawing.Point)
        Me.lbUniverses.Name = "lbUniverses"
        Me.lbUniverses.RightToLeft = CType(resources.GetObject("lbUniverses.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.lbUniverses.ScrollAlwaysVisible = CType(resources.GetObject("lbUniverses.ScrollAlwaysVisible"), Boolean)
        Me.lbUniverses.Size = CType(resources.GetObject("lbUniverses.Size"), System.Drawing.Size)
        Me.lbUniverses.TabIndex = CType(resources.GetObject("lbUniverses.TabIndex"), Integer)
        Me.lbUniverses.Visible = CType(resources.GetObject("lbUniverses.Visible"), Boolean)
        '
        'cmLBUniverses
        '
        Me.cmLBUniverses.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem1, Me.MenuItem2, Me.MenuItem3})
        Me.cmLBUniverses.RightToLeft = CType(resources.GetObject("cmLBUniverses.RightToLeft"), System.Windows.Forms.RightToLeft)
        '
        'MenuItem1
        '
        Me.MenuItem1.Enabled = CType(resources.GetObject("MenuItem1.Enabled"), Boolean)
        Me.MenuItem1.Index = 0
        Me.MenuItem1.Shortcut = CType(resources.GetObject("MenuItem1.Shortcut"), System.Windows.Forms.Shortcut)
        Me.MenuItem1.ShowShortcut = CType(resources.GetObject("MenuItem1.ShowShortcut"), Boolean)
        Me.MenuItem1.Text = resources.GetString("MenuItem1.Text")
        Me.MenuItem1.Visible = CType(resources.GetObject("MenuItem1.Visible"), Boolean)
        '
        'MenuItem2
        '
        Me.MenuItem2.Enabled = CType(resources.GetObject("MenuItem2.Enabled"), Boolean)
        Me.MenuItem2.Index = 1
        Me.MenuItem2.Shortcut = CType(resources.GetObject("MenuItem2.Shortcut"), System.Windows.Forms.Shortcut)
        Me.MenuItem2.ShowShortcut = CType(resources.GetObject("MenuItem2.ShowShortcut"), Boolean)
        Me.MenuItem2.Text = resources.GetString("MenuItem2.Text")
        Me.MenuItem2.Visible = CType(resources.GetObject("MenuItem2.Visible"), Boolean)
        '
        'MenuItem3
        '
        Me.MenuItem3.Enabled = CType(resources.GetObject("MenuItem3.Enabled"), Boolean)
        Me.MenuItem3.Index = 2
        Me.MenuItem3.Shortcut = CType(resources.GetObject("MenuItem3.Shortcut"), System.Windows.Forms.Shortcut)
        Me.MenuItem3.ShowShortcut = CType(resources.GetObject("MenuItem3.ShowShortcut"), Boolean)
        Me.MenuItem3.Text = resources.GetString("MenuItem3.Text")
        Me.MenuItem3.Visible = CType(resources.GetObject("MenuItem3.Visible"), Boolean)
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
        Me.Button1.Visible = CType(resources.GetObject("Button1.Visible"), Boolean)
        '
        'btndelete
        '
        Me.btndelete.AccessibleDescription = resources.GetString("btndelete.AccessibleDescription")
        Me.btndelete.AccessibleName = resources.GetString("btndelete.AccessibleName")
        Me.btndelete.Anchor = CType(resources.GetObject("btndelete.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btndelete.BackgroundImage = CType(resources.GetObject("btndelete.BackgroundImage"), System.Drawing.Image)
        Me.btndelete.Dock = CType(resources.GetObject("btndelete.Dock"), System.Windows.Forms.DockStyle)
        Me.btndelete.Enabled = CType(resources.GetObject("btndelete.Enabled"), Boolean)
        Me.btndelete.FlatStyle = CType(resources.GetObject("btndelete.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btndelete.Font = CType(resources.GetObject("btndelete.Font"), System.Drawing.Font)
        Me.btndelete.Image = CType(resources.GetObject("btndelete.Image"), System.Drawing.Image)
        Me.btndelete.ImageAlign = CType(resources.GetObject("btndelete.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btndelete.ImageIndex = CType(resources.GetObject("btndelete.ImageIndex"), Integer)
        Me.btndelete.ImeMode = CType(resources.GetObject("btndelete.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btndelete.Location = CType(resources.GetObject("btndelete.Location"), System.Drawing.Point)
        Me.btndelete.Name = "btndelete"
        Me.btndelete.RightToLeft = CType(resources.GetObject("btndelete.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btndelete.Size = CType(resources.GetObject("btndelete.Size"), System.Drawing.Size)
        Me.btndelete.TabIndex = CType(resources.GetObject("btndelete.TabIndex"), Integer)
        Me.btndelete.Text = resources.GetString("btndelete.Text")
        Me.btndelete.TextAlign = CType(resources.GetObject("btndelete.TextAlign"), System.Drawing.ContentAlignment)
        Me.btndelete.Visible = CType(resources.GetObject("btndelete.Visible"), Boolean)
        '
        'btnProperty
        '
        Me.btnProperty.AccessibleDescription = resources.GetString("btnProperty.AccessibleDescription")
        Me.btnProperty.AccessibleName = resources.GetString("btnProperty.AccessibleName")
        Me.btnProperty.Anchor = CType(resources.GetObject("btnProperty.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.btnProperty.BackgroundImage = CType(resources.GetObject("btnProperty.BackgroundImage"), System.Drawing.Image)
        Me.btnProperty.Dock = CType(resources.GetObject("btnProperty.Dock"), System.Windows.Forms.DockStyle)
        Me.btnProperty.Enabled = CType(resources.GetObject("btnProperty.Enabled"), Boolean)
        Me.btnProperty.FlatStyle = CType(resources.GetObject("btnProperty.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.btnProperty.Font = CType(resources.GetObject("btnProperty.Font"), System.Drawing.Font)
        Me.btnProperty.Image = CType(resources.GetObject("btnProperty.Image"), System.Drawing.Image)
        Me.btnProperty.ImageAlign = CType(resources.GetObject("btnProperty.ImageAlign"), System.Drawing.ContentAlignment)
        Me.btnProperty.ImageIndex = CType(resources.GetObject("btnProperty.ImageIndex"), Integer)
        Me.btnProperty.ImeMode = CType(resources.GetObject("btnProperty.ImeMode"), System.Windows.Forms.ImeMode)
        Me.btnProperty.Location = CType(resources.GetObject("btnProperty.Location"), System.Drawing.Point)
        Me.btnProperty.Name = "btnProperty"
        Me.btnProperty.RightToLeft = CType(resources.GetObject("btnProperty.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.btnProperty.Size = CType(resources.GetObject("btnProperty.Size"), System.Drawing.Size)
        Me.btnProperty.TabIndex = CType(resources.GetObject("btnProperty.TabIndex"), Integer)
        Me.btnProperty.Text = resources.GetString("btnProperty.Text")
        Me.btnProperty.TextAlign = CType(resources.GetObject("btnProperty.TextAlign"), System.Drawing.ContentAlignment)
        Me.btnProperty.Visible = CType(resources.GetObject("btnProperty.Visible"), Boolean)
        '
        'Button5
        '
        Me.Button5.AccessibleDescription = resources.GetString("Button5.AccessibleDescription")
        Me.Button5.AccessibleName = resources.GetString("Button5.AccessibleName")
        Me.Button5.Anchor = CType(resources.GetObject("Button5.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button5.BackgroundImage = CType(resources.GetObject("Button5.BackgroundImage"), System.Drawing.Image)
        Me.Button5.DialogResult = System.Windows.Forms.DialogResult.OK
        Me.Button5.Dock = CType(resources.GetObject("Button5.Dock"), System.Windows.Forms.DockStyle)
        Me.Button5.Enabled = CType(resources.GetObject("Button5.Enabled"), Boolean)
        Me.Button5.FlatStyle = CType(resources.GetObject("Button5.FlatStyle"), System.Windows.Forms.FlatStyle)
        Me.Button5.Font = CType(resources.GetObject("Button5.Font"), System.Drawing.Font)
        Me.Button5.Image = CType(resources.GetObject("Button5.Image"), System.Drawing.Image)
        Me.Button5.ImageAlign = CType(resources.GetObject("Button5.ImageAlign"), System.Drawing.ContentAlignment)
        Me.Button5.ImageIndex = CType(resources.GetObject("Button5.ImageIndex"), Integer)
        Me.Button5.ImeMode = CType(resources.GetObject("Button5.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Button5.Location = CType(resources.GetObject("Button5.Location"), System.Drawing.Point)
        Me.Button5.Name = "Button5"
        Me.Button5.RightToLeft = CType(resources.GetObject("Button5.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.Button5.Size = CType(resources.GetObject("Button5.Size"), System.Drawing.Size)
        Me.Button5.TabIndex = CType(resources.GetObject("Button5.TabIndex"), Integer)
        Me.Button5.Text = resources.GetString("Button5.Text")
        Me.Button5.TextAlign = CType(resources.GetObject("Button5.TextAlign"), System.Drawing.ContentAlignment)
        Me.Button5.Visible = CType(resources.GetObject("Button5.Visible"), Boolean)
        '
        'Button4
        '
        Me.Button4.AccessibleDescription = resources.GetString("Button4.AccessibleDescription")
        Me.Button4.AccessibleName = resources.GetString("Button4.AccessibleName")
        Me.Button4.Anchor = CType(resources.GetObject("Button4.Anchor"), System.Windows.Forms.AnchorStyles)
        Me.Button4.BackgroundImage = CType(resources.GetObject("Button4.BackgroundImage"), System.Drawing.Image)
        Me.Button4.DialogResult = System.Windows.Forms.DialogResult.Cancel
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
        Me.Button4.Visible = CType(resources.GetObject("Button4.Visible"), Boolean)
        '
        'UniversesDatabaseForm
        '
        Me.AccessibleDescription = resources.GetString("$this.AccessibleDescription")
        Me.AccessibleName = resources.GetString("$this.AccessibleName")
        Me.AutoScaleBaseSize = CType(resources.GetObject("$this.AutoScaleBaseSize"), System.Drawing.Size)
        Me.AutoScroll = CType(resources.GetObject("$this.AutoScroll"), Boolean)
        Me.AutoScrollMargin = CType(resources.GetObject("$this.AutoScrollMargin"), System.Drawing.Size)
        Me.AutoScrollMinSize = CType(resources.GetObject("$this.AutoScrollMinSize"), System.Drawing.Size)
        Me.BackgroundImage = CType(resources.GetObject("$this.BackgroundImage"), System.Drawing.Image)
        Me.ClientSize = CType(resources.GetObject("$this.ClientSize"), System.Drawing.Size)
        Me.ControlBox = False
        Me.Controls.Add(Me.Button4)
        Me.Controls.Add(Me.Button5)
        Me.Controls.Add(Me.btnProperty)
        Me.Controls.Add(Me.btndelete)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.lbUniverses)
        Me.Enabled = CType(resources.GetObject("$this.Enabled"), Boolean)
        Me.Font = CType(resources.GetObject("$this.Font"), System.Drawing.Font)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.SizableToolWindow
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.ImeMode = CType(resources.GetObject("$this.ImeMode"), System.Windows.Forms.ImeMode)
        Me.Location = CType(resources.GetObject("$this.Location"), System.Drawing.Point)
        Me.MaximumSize = CType(resources.GetObject("$this.MaximumSize"), System.Drawing.Size)
        Me.MinimizeBox = False
        Me.MinimumSize = CType(resources.GetObject("$this.MinimumSize"), System.Drawing.Size)
        Me.Name = "UniversesDatabaseForm"
        Me.RightToLeft = CType(resources.GetObject("$this.RightToLeft"), System.Windows.Forms.RightToLeft)
        Me.ShowInTaskbar = False
        Me.StartPosition = CType(resources.GetObject("$this.StartPosition"), System.Windows.Forms.FormStartPosition)
        Me.Text = resources.GetString("$this.Text")
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        Dim d As New CreateUniverseDBForm
        If d.ShowDialog() = Windows.Forms.DialogResult.OK Then
            If Not d.Universe Is Nothing Then
                If UniversesCol.IndexOf(d.Universe) < 0 Then
                    UniversesCol.Add(d.Universe)
                    UniversesCol.XMLSerialize()
                    lbUniverses.Items.Add(d.Universe)
                    lbUniverses.SelectedItem = d.Universe
                End If
            End If

        End If
    End Sub


    Private UniversesCol As OGameObject.UniversesDBCol = Nothing
    Private Sub UniversesDatabaseForm_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        UniversesCol = OGameObject.UniversesDBCol.XMLDeSerialize
        For Each ee As Object In UniversesCol
            lbUniverses.Items.Add(ee)
        Next

    End Sub
    Public Universe As OGameObject.UniverseDB = Nothing
    Private Sub Button5_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button5.Click
        Universe = lbUniverses.SelectedItem
    End Sub

    Private Sub lbUniverses_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbUniverses.SelectedIndexChanged
        btnProperty.Enabled = lbUniverses.SelectedIndex > -1
        btndelete.Enabled = lbUniverses.SelectedIndex > -1
    End Sub

    Private Sub btnProperty_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnProperty.Click
        Dim d As New CreateUniverseDBForm
        d.Universe = lbUniverses.SelectedItem
        If d.ShowDialog() = Windows.Forms.DialogResult.OK Then
            'CType(lbUniverses.SelectedItem, OGameObject.UniverseDB) = d.Universe
            Dim i As Integer = lbUniverses.Items.IndexOf(d.Universe)
            lbUniverses.Items(i) = d.Universe
            If UniversesCol.IndexOf(d.Universe) > -1 Then
                UniversesCol.RemoveAt(UniversesCol.IndexOf(d.Universe))
                UniversesCol.Add(d.Universe)
                UniversesCol.XMLSerialize()
                'lbUniverses.Items.Add(d.Universe)
                lbUniverses.SelectedItem = d.Universe
            End If
        End If

    End Sub

    Private Sub lbUniverses_DoubleClick(ByVal sender As Object, ByVal e As System.EventArgs) Handles lbUniverses.DoubleClick
        If lbUniverses.SelectedItem Is Nothing Then Return
        Universe = lbUniverses.SelectedItem
        Me.DialogResult = Windows.Forms.DialogResult.OK
        Me.Close()
    End Sub

    Private Sub btndelete_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btndelete.Click
        If lbUniverses.SelectedItem Is Nothing Then Return
        With CType(lbUniverses.SelectedItem, OGameObject.UniverseDB)
            If MessageBox.Show(MainForm.TopForm, "Confirmer la suppression du fichier Base de Données : " & vbCrLf & .DBFileName, "Suppression de base de données :", MessageBoxButtons.YesNo) = Windows.Forms.DialogResult.Yes Then
                System.IO.File.Delete(.DBFileName)
                lbUniverses.Items.Remove(lbUniverses.SelectedItem)
                UniversesCol = New OGameObject.UniversesDBCol
                For Each u As Object In lbUniverses.Items
                    UniversesCol.Add(u)
                Next
                UniversesCol.XMLSerialize()
            End If
        End With
    End Sub
End Class
