<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class editeur
    Inherits System.Windows.Forms.Form

    'Form remplace la méthode Dispose pour nettoyer la liste des composants.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Requise par le Concepteur Windows Form
    Private components As System.ComponentModel.IContainer

    'REMARQUE : la procédure suivante est requise par le Concepteur Windows Form
    'Elle peut être modifiée à l'aide du Concepteur Windows Form.  
    'Ne la modifiez pas à l'aide de l'éditeur de code.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(editeur))
        Me.StatusStrip1 = New System.Windows.Forms.StatusStrip
        Me.MenuStrip1 = New System.Windows.Forms.MenuStrip
        Me.Fichier = New System.Windows.Forms.ToolStripDropDownButton
        Me.NouveauToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.ToolStripMenuItem1 = New System.Windows.Forms.ToolStripMenuItem
        Me.OuvrirToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.ToolStripSeparator1 = New System.Windows.Forms.ToolStripSeparator
        Me.QuiterToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.ToolStripDropDownButton1 = New System.Windows.Forms.ToolStripDropDownButton
        Me.LicenceToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.HistoriqueToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.AuteurcontirbuateurToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.Panel = New System.Windows.Forms.Panel
        Me.MenuStrip1.SuspendLayout()
        Me.SuspendLayout()
        '
        'StatusStrip1
        '
        Me.StatusStrip1.Location = New System.Drawing.Point(0, 503)
        Me.StatusStrip1.Name = "StatusStrip1"
        Me.StatusStrip1.Size = New System.Drawing.Size(804, 22)
        Me.StatusStrip1.TabIndex = 0
        Me.StatusStrip1.Text = "StatusStrip1"
        '
        'MenuStrip1
        '
        Me.MenuStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.Fichier, Me.ToolStripDropDownButton1})
        Me.MenuStrip1.Location = New System.Drawing.Point(0, 0)
        Me.MenuStrip1.Name = "MenuStrip1"
        Me.MenuStrip1.Size = New System.Drawing.Size(804, 24)
        Me.MenuStrip1.TabIndex = 3
        Me.MenuStrip1.Text = "MenuStrip1"
        '
        'Fichier
        '
        Me.Fichier.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Text
        Me.Fichier.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.NouveauToolStripMenuItem, Me.OuvrirToolStripMenuItem, Me.ToolStripSeparator1, Me.QuiterToolStripMenuItem})
        Me.Fichier.Image = CType(resources.GetObject("Fichier.Image"), System.Drawing.Image)
        Me.Fichier.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.Fichier.Name = "Fichier"
        Me.Fichier.Size = New System.Drawing.Size(51, 17)
        Me.Fichier.Text = "Fichier"
        '
        'NouveauToolStripMenuItem
        '
        Me.NouveauToolStripMenuItem.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ToolStripMenuItem1})
        Me.NouveauToolStripMenuItem.Name = "NouveauToolStripMenuItem"
        Me.NouveauToolStripMenuItem.Size = New System.Drawing.Size(152, 22)
        Me.NouveauToolStripMenuItem.Text = "&Nouveau"
        '
        'ToolStripMenuItem1
        '
        Me.ToolStripMenuItem1.Name = "ToolStripMenuItem1"
        Me.ToolStripMenuItem1.Size = New System.Drawing.Size(152, 22)
        Me.ToolStripMenuItem1.Text = "Projet"
        '
        'OuvrirToolStripMenuItem
        '
        Me.OuvrirToolStripMenuItem.Name = "OuvrirToolStripMenuItem"
        Me.OuvrirToolStripMenuItem.ShortcutKeys = CType((System.Windows.Forms.Keys.Control Or System.Windows.Forms.Keys.O), System.Windows.Forms.Keys)
        Me.OuvrirToolStripMenuItem.Size = New System.Drawing.Size(152, 22)
        Me.OuvrirToolStripMenuItem.Text = "&Ouvrir"
        '
        'ToolStripSeparator1
        '
        Me.ToolStripSeparator1.Name = "ToolStripSeparator1"
        Me.ToolStripSeparator1.Size = New System.Drawing.Size(149, 6)
        '
        'QuiterToolStripMenuItem
        '
        Me.QuiterToolStripMenuItem.Name = "QuiterToolStripMenuItem"
        Me.QuiterToolStripMenuItem.Size = New System.Drawing.Size(152, 22)
        Me.QuiterToolStripMenuItem.Text = "&Quitter"
        '
        'ToolStripDropDownButton1
        '
        Me.ToolStripDropDownButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Text
        Me.ToolStripDropDownButton1.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.LicenceToolStripMenuItem, Me.HistoriqueToolStripMenuItem, Me.AuteurcontirbuateurToolStripMenuItem})
        Me.ToolStripDropDownButton1.Image = CType(resources.GetObject("ToolStripDropDownButton1.Image"), System.Drawing.Image)
        Me.ToolStripDropDownButton1.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripDropDownButton1.Name = "ToolStripDropDownButton1"
        Me.ToolStripDropDownButton1.Size = New System.Drawing.Size(76, 17)
        Me.ToolStripDropDownButton1.Text = "Information"
        '
        'LicenceToolStripMenuItem
        '
        Me.LicenceToolStripMenuItem.Name = "LicenceToolStripMenuItem"
        Me.LicenceToolStripMenuItem.Size = New System.Drawing.Size(176, 22)
        Me.LicenceToolStripMenuItem.Text = "Licence"
        '
        'HistoriqueToolStripMenuItem
        '
        Me.HistoriqueToolStripMenuItem.Name = "HistoriqueToolStripMenuItem"
        Me.HistoriqueToolStripMenuItem.Size = New System.Drawing.Size(176, 22)
        Me.HistoriqueToolStripMenuItem.Text = "Historique"
        '
        'AuteurcontirbuateurToolStripMenuItem
        '
        Me.AuteurcontirbuateurToolStripMenuItem.Name = "AuteurcontirbuateurToolStripMenuItem"
        Me.AuteurcontirbuateurToolStripMenuItem.Size = New System.Drawing.Size(176, 22)
        Me.AuteurcontirbuateurToolStripMenuItem.Text = "Auteur/contirbuateur"
        '
        'Panel
        '
        Me.Panel.Dock = System.Windows.Forms.DockStyle.Right
        Me.Panel.Location = New System.Drawing.Point(564, 24)
        Me.Panel.Name = "Panel"
        Me.Panel.Size = New System.Drawing.Size(240, 479)
        Me.Panel.TabIndex = 4
        '
        'editeur
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(804, 525)
        Me.Controls.Add(Me.Panel)
        Me.Controls.Add(Me.StatusStrip1)
        Me.Controls.Add(Me.MenuStrip1)
        Me.IsMdiContainer = True
        Me.MainMenuStrip = Me.MenuStrip1
        Me.Name = "editeur"
        Me.Text = "OGS MOD Creator"
        Me.WindowState = System.Windows.Forms.FormWindowState.Maximized
        Me.MenuStrip1.ResumeLayout(False)
        Me.MenuStrip1.PerformLayout()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents StatusStrip1 As System.Windows.Forms.StatusStrip
    Friend WithEvents MenuStrip1 As System.Windows.Forms.MenuStrip
    Friend WithEvents Fichier As System.Windows.Forms.ToolStripDropDownButton
    Friend WithEvents NouveauToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolStripMenuItem1 As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents OuvrirToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolStripSeparator1 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents QuiterToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolStripDropDownButton1 As System.Windows.Forms.ToolStripDropDownButton
    Friend WithEvents LicenceToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents HistoriqueToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents AuteurcontirbuateurToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents Panel As System.Windows.Forms.Panel
End Class
