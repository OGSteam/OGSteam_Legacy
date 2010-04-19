<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class OGameSystemUI
    Inherits System.Windows.Forms.UserControl

    'UserControl remplace la méthode Dispose pour nettoyer la liste des composants.
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
        Me.HeaderPanel = New System.Windows.Forms.Panel
        Me.InfoLabel = New System.Windows.Forms.Label
        Me.ToolStrip1 = New System.Windows.Forms.ToolStrip
        Me.ToolStripButton1 = New System.Windows.Forms.ToolStripButton
        Me.GalaxyNumTextBox = New System.Windows.Forms.ToolStripTextBox
        Me.ToolStripSeparator1 = New System.Windows.Forms.ToolStripSeparator
        Me.SystemNumTextBox = New System.Windows.Forms.ToolStripTextBox
        Me.ToolStripButton2 = New System.Windows.Forms.ToolStripButton
        Me.ToolStripSeparator2 = New System.Windows.Forms.ToolStripSeparator
        Me.ToolStripComboBox1 = New System.Windows.Forms.ToolStripComboBox
        Me.FooterPanel = New System.Windows.Forms.Panel
        Me.SystemesLB = New System.Windows.Forms.ListBox
        Me.HeaderPanel.SuspendLayout()
        Me.ToolStrip1.SuspendLayout()
        Me.SuspendLayout()
        '
        'HeaderPanel
        '
        Me.HeaderPanel.Controls.Add(Me.InfoLabel)
        Me.HeaderPanel.Controls.Add(Me.ToolStrip1)
        Me.HeaderPanel.Dock = System.Windows.Forms.DockStyle.Top
        Me.HeaderPanel.Location = New System.Drawing.Point(0, 0)
        Me.HeaderPanel.Name = "HeaderPanel"
        Me.HeaderPanel.Size = New System.Drawing.Size(368, 44)
        Me.HeaderPanel.TabIndex = 0
        '
        'InfoLabel
        '
        Me.InfoLabel.Dock = System.Windows.Forms.DockStyle.Fill
        Me.InfoLabel.Location = New System.Drawing.Point(0, 25)
        Me.InfoLabel.Name = "InfoLabel"
        Me.InfoLabel.Size = New System.Drawing.Size(368, 19)
        Me.InfoLabel.TabIndex = 1
        Me.InfoLabel.Text = "Pas d'information"
        Me.InfoLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'ToolStrip1
        '
        Me.ToolStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ToolStripButton1, Me.GalaxyNumTextBox, Me.ToolStripSeparator1, Me.SystemNumTextBox, Me.ToolStripButton2, Me.ToolStripSeparator2, Me.ToolStripComboBox1})
        Me.ToolStrip1.Location = New System.Drawing.Point(0, 0)
        Me.ToolStrip1.Name = "ToolStrip1"
        Me.ToolStrip1.Size = New System.Drawing.Size(368, 25)
        Me.ToolStrip1.TabIndex = 0
        Me.ToolStrip1.Text = "ToolStrip1"
        '
        'ToolStripButton1
        '
        Me.ToolStripButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButton1.Image = Global.OGSUi.My.Resources.Resources.Arrow_Left
        Me.ToolStripButton1.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripButton1.Name = "ToolStripButton1"
        Me.ToolStripButton1.Size = New System.Drawing.Size(23, 22)
        Me.ToolStripButton1.Text = "ToolStripButton1"
        '
        'GalaxyNumTextBox
        '
        Me.GalaxyNumTextBox.BackColor = Global.OGSUi.My.MySettings.Default.GalaxySystemTextBackColor
        Me.GalaxyNumTextBox.ForeColor = Global.OGSUi.My.MySettings.Default.GalaxySystemTextForeColor
        Me.GalaxyNumTextBox.Name = "GalaxyNumTextBox"
        Me.GalaxyNumTextBox.Size = New System.Drawing.Size(20, 25)
        Me.GalaxyNumTextBox.Text = "1"
        '
        'ToolStripSeparator1
        '
        Me.ToolStripSeparator1.Name = "ToolStripSeparator1"
        Me.ToolStripSeparator1.Size = New System.Drawing.Size(6, 25)
        '
        'SystemNumTextBox
        '
        Me.SystemNumTextBox.BackColor = Global.OGSUi.My.MySettings.Default.GalaxySystemTextBackColor
        Me.SystemNumTextBox.ForeColor = Global.OGSUi.My.MySettings.Default.GalaxySystemTextForeColor
        Me.SystemNumTextBox.Name = "SystemNumTextBox"
        Me.SystemNumTextBox.Size = New System.Drawing.Size(50, 25)
        Me.SystemNumTextBox.Text = "1"
        '
        'ToolStripButton2
        '
        Me.ToolStripButton2.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButton2.Image = Global.OGSUi.My.Resources.Resources.Arrow_Right
        Me.ToolStripButton2.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripButton2.Name = "ToolStripButton2"
        Me.ToolStripButton2.Size = New System.Drawing.Size(23, 22)
        Me.ToolStripButton2.Text = "ToolStripButton2"
        '
        'ToolStripSeparator2
        '
        Me.ToolStripSeparator2.Name = "ToolStripSeparator2"
        Me.ToolStripSeparator2.Size = New System.Drawing.Size(6, 25)
        '
        'ToolStripComboBox1
        '
        Me.ToolStripComboBox1.Name = "ToolStripComboBox1"
        Me.ToolStripComboBox1.Size = New System.Drawing.Size(100, 25)
        Me.ToolStripComboBox1.Text = "Favoris"
        '
        'FooterPanel
        '
        Me.FooterPanel.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.FooterPanel.Location = New System.Drawing.Point(0, 279)
        Me.FooterPanel.Name = "FooterPanel"
        Me.FooterPanel.Size = New System.Drawing.Size(368, 47)
        Me.FooterPanel.TabIndex = 1
        Me.FooterPanel.Visible = False
        '
        'SystemesLB
        '
        Me.SystemesLB.BackColor = Global.OGSUi.My.MySettings.Default.GalaxyLBBackgroundColor
        Me.SystemesLB.DataBindings.Add(New System.Windows.Forms.Binding("BackColor", Global.OGSUi.My.MySettings.Default, "GalaxyLBBackgroundColor", True, System.Windows.Forms.DataSourceUpdateMode.OnPropertyChanged))
        Me.SystemesLB.DataBindings.Add(New System.Windows.Forms.Binding("ForeColor", Global.OGSUi.My.MySettings.Default, "GalaxyLBForeColor", True, System.Windows.Forms.DataSourceUpdateMode.OnPropertyChanged))
        Me.SystemesLB.Dock = System.Windows.Forms.DockStyle.Fill
        Me.SystemesLB.DrawMode = System.Windows.Forms.DrawMode.OwnerDrawFixed
        Me.SystemesLB.ForeColor = Global.OGSUi.My.MySettings.Default.GalaxyLBForeColor
        Me.SystemesLB.FormattingEnabled = True
        Me.SystemesLB.IntegralHeight = False
        Me.SystemesLB.Items.AddRange(New Object() {"1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15"})
        Me.SystemesLB.Location = New System.Drawing.Point(0, 44)
        Me.SystemesLB.Name = "SystemesLB"
        Me.SystemesLB.Size = New System.Drawing.Size(368, 235)
        Me.SystemesLB.TabIndex = 2
        '
        'OGameSystemUI
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.Controls.Add(Me.SystemesLB)
        Me.Controls.Add(Me.FooterPanel)
        Me.Controls.Add(Me.HeaderPanel)
        Me.Name = "OGameSystemUI"
        Me.Size = New System.Drawing.Size(368, 326)
        Me.HeaderPanel.ResumeLayout(False)
        Me.HeaderPanel.PerformLayout()
        Me.ToolStrip1.ResumeLayout(False)
        Me.ToolStrip1.PerformLayout()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents HeaderPanel As System.Windows.Forms.Panel
    Friend WithEvents ToolStrip1 As System.Windows.Forms.ToolStrip
    Friend WithEvents ToolStripButton1 As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripButton2 As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripSeparator1 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents ToolStripSeparator2 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents ToolStripComboBox1 As System.Windows.Forms.ToolStripComboBox
    Friend WithEvents FooterPanel As System.Windows.Forms.Panel
    Friend WithEvents SystemesLB As System.Windows.Forms.ListBox
    Friend WithEvents GalaxyNumTextBox As System.Windows.Forms.ToolStripTextBox
    Friend WithEvents SystemNumTextBox As System.Windows.Forms.ToolStripTextBox
    Friend WithEvents InfoLabel As System.Windows.Forms.Label

End Class
