<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class WebChannelMessageCtrl
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(WebChannelMessageCtrl))
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.PromptLineCB = New System.Windows.Forms.ComboBox
        Me.SendTextBtn = New System.Windows.Forms.Button
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.ToolStrip1 = New System.Windows.Forms.ToolStrip
        Me.ToolStripDropDownButton1 = New System.Windows.Forms.ToolStripDropDownButton
        Me.VoirLeSourceToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.RechargerLeStyleToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.WebBrowser1 = New System.Windows.Forms.WebBrowser
        Me.Panel1.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.ToolStrip1.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.PromptLineCB)
        Me.Panel1.Controls.Add(Me.SendTextBtn)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.Panel1.Location = New System.Drawing.Point(0, 183)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(310, 22)
        Me.Panel1.TabIndex = 0
        '
        'PromptLineCB
        '
        Me.PromptLineCB.Dock = System.Windows.Forms.DockStyle.Fill
        Me.PromptLineCB.FormattingEnabled = True
        Me.PromptLineCB.Location = New System.Drawing.Point(0, 0)
        Me.PromptLineCB.Name = "PromptLineCB"
        Me.PromptLineCB.Size = New System.Drawing.Size(254, 21)
        Me.PromptLineCB.TabIndex = 1
        '
        'SendTextBtn
        '
        Me.SendTextBtn.AutoSize = True
        Me.SendTextBtn.AutoSizeMode = System.Windows.Forms.AutoSizeMode.GrowAndShrink
        Me.SendTextBtn.Dock = System.Windows.Forms.DockStyle.Right
        Me.SendTextBtn.Location = New System.Drawing.Point(254, 0)
        Me.SendTextBtn.Name = "SendTextBtn"
        Me.SendTextBtn.Size = New System.Drawing.Size(56, 22)
        Me.SendTextBtn.TabIndex = 0
        Me.SendTextBtn.Text = "Envoyer"
        Me.SendTextBtn.UseMnemonic = False
        Me.SendTextBtn.UseVisualStyleBackColor = True
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.ToolStrip1)
        Me.Panel2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel2.Location = New System.Drawing.Point(0, 0)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(310, 21)
        Me.Panel2.TabIndex = 1
        '
        'ToolStrip1
        '
        Me.ToolStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ToolStripDropDownButton1})
        Me.ToolStrip1.Location = New System.Drawing.Point(0, 0)
        Me.ToolStrip1.Name = "ToolStrip1"
        Me.ToolStrip1.Size = New System.Drawing.Size(310, 25)
        Me.ToolStrip1.TabIndex = 0
        Me.ToolStrip1.Text = "ToolStrip1"
        '
        'ToolStripDropDownButton1
        '
        Me.ToolStripDropDownButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripDropDownButton1.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.VoirLeSourceToolStripMenuItem, Me.RechargerLeStyleToolStripMenuItem})
        Me.ToolStripDropDownButton1.Image = CType(resources.GetObject("ToolStripDropDownButton1.Image"), System.Drawing.Image)
        Me.ToolStripDropDownButton1.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripDropDownButton1.Name = "ToolStripDropDownButton1"
        Me.ToolStripDropDownButton1.Size = New System.Drawing.Size(29, 22)
        Me.ToolStripDropDownButton1.Text = "ToolStripDropDownButton1"
        '
        'VoirLeSourceToolStripMenuItem
        '
        Me.VoirLeSourceToolStripMenuItem.Name = "VoirLeSourceToolStripMenuItem"
        Me.VoirLeSourceToolStripMenuItem.Size = New System.Drawing.Size(172, 22)
        Me.VoirLeSourceToolStripMenuItem.Text = "Voir le source"
        '
        'RechargerLeStyleToolStripMenuItem
        '
        Me.RechargerLeStyleToolStripMenuItem.Name = "RechargerLeStyleToolStripMenuItem"
        Me.RechargerLeStyleToolStripMenuItem.Size = New System.Drawing.Size(172, 22)
        Me.RechargerLeStyleToolStripMenuItem.Text = "Recharger le style"
        '
        'WebBrowser1
        '
        Me.WebBrowser1.AllowNavigation = False
        Me.WebBrowser1.AllowWebBrowserDrop = False
        Me.WebBrowser1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.WebBrowser1.Location = New System.Drawing.Point(0, 21)
        Me.WebBrowser1.MinimumSize = New System.Drawing.Size(20, 20)
        Me.WebBrowser1.Name = "WebBrowser1"
        Me.WebBrowser1.Size = New System.Drawing.Size(310, 162)
        Me.WebBrowser1.TabIndex = 2
        Me.WebBrowser1.Url = New System.Uri("", System.UriKind.Relative)
        Me.WebBrowser1.WebBrowserShortcutsEnabled = False
        '
        'WebChannelMessageCtrl
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.Controls.Add(Me.WebBrowser1)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.Panel1)
        Me.Name = "WebChannelMessageCtrl"
        Me.Size = New System.Drawing.Size(310, 205)
        Me.Panel1.ResumeLayout(False)
        Me.Panel1.PerformLayout()
        Me.Panel2.ResumeLayout(False)
        Me.Panel2.PerformLayout()
        Me.ToolStrip1.ResumeLayout(False)
        Me.ToolStrip1.PerformLayout()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents WebBrowser1 As System.Windows.Forms.WebBrowser
    Friend WithEvents PromptLineCB As System.Windows.Forms.ComboBox
    Friend WithEvents SendTextBtn As System.Windows.Forms.Button
    Friend WithEvents ToolStrip1 As System.Windows.Forms.ToolStrip
    Friend WithEvents ToolStripDropDownButton1 As System.Windows.Forms.ToolStripDropDownButton
    Friend WithEvents VoirLeSourceToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents RechargerLeStyleToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem

End Class
