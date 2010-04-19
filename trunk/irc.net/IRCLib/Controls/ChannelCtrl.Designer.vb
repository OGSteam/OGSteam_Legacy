<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ChannelCtrl
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
        Me.components = New System.ComponentModel.Container
        Me.ContextMenuStrip1 = New System.Windows.Forms.ContextMenuStrip(Me.components)
        Me.AfficheLesUtilisateursToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.AfficheLaFenetreMessageToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.ChannelUserList1 = New IRCLib.ChannelUserList
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.ChannelMessagesCtrl1 = New IRCLib.ChannelMessagesCtrl
        Me.ContextMenuStrip1.SuspendLayout()
        Me.SuspendLayout()
        '
        'ContextMenuStrip1
        '
        Me.ContextMenuStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.AfficheLesUtilisateursToolStripMenuItem, Me.AfficheLaFenetreMessageToolStripMenuItem})
        Me.ContextMenuStrip1.Name = "ContextMenuStrip1"
        Me.ContextMenuStrip1.Size = New System.Drawing.Size(217, 70)
        '
        'AfficheLesUtilisateursToolStripMenuItem
        '
        Me.AfficheLesUtilisateursToolStripMenuItem.Checked = True
        Me.AfficheLesUtilisateursToolStripMenuItem.CheckOnClick = True
        Me.AfficheLesUtilisateursToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked
        Me.AfficheLesUtilisateursToolStripMenuItem.Name = "AfficheLesUtilisateursToolStripMenuItem"
        Me.AfficheLesUtilisateursToolStripMenuItem.Size = New System.Drawing.Size(216, 22)
        Me.AfficheLesUtilisateursToolStripMenuItem.Text = "Affiche les utilisateurs"
        '
        'AfficheLaFenetreMessageToolStripMenuItem
        '
        Me.AfficheLaFenetreMessageToolStripMenuItem.Checked = True
        Me.AfficheLaFenetreMessageToolStripMenuItem.CheckOnClick = True
        Me.AfficheLaFenetreMessageToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked
        Me.AfficheLaFenetreMessageToolStripMenuItem.Name = "AfficheLaFenetreMessageToolStripMenuItem"
        Me.AfficheLaFenetreMessageToolStripMenuItem.Size = New System.Drawing.Size(216, 22)
        Me.AfficheLaFenetreMessageToolStripMenuItem.Text = "Affiche la Fenètre message"
        '
        'ChannelUserList1
        '
        Me.ChannelUserList1.Channel = Nothing
        Me.ChannelUserList1.Dock = System.Windows.Forms.DockStyle.Left
        Me.ChannelUserList1.Location = New System.Drawing.Point(0, 0)
        Me.ChannelUserList1.Name = "ChannelUserList1"
        Me.ChannelUserList1.Size = New System.Drawing.Size(128, 260)
        Me.ChannelUserList1.TabIndex = 1
        '
        'Splitter1
        '
        Me.Splitter1.Location = New System.Drawing.Point(128, 0)
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.Size = New System.Drawing.Size(8, 260)
        Me.Splitter1.TabIndex = 2
        Me.Splitter1.TabStop = False
        '
        'ChannelMessagesCtrl1
        '
        Me.ChannelMessagesCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.ChannelMessagesCtrl1.Location = New System.Drawing.Point(136, 0)
        Me.ChannelMessagesCtrl1.Name = "ChannelMessagesCtrl1"
        Me.ChannelMessagesCtrl1.Size = New System.Drawing.Size(269, 260)
        Me.ChannelMessagesCtrl1.TabIndex = 3
        '
        'ChannelCtrl
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.Controls.Add(Me.ChannelMessagesCtrl1)
        Me.Controls.Add(Me.Splitter1)
        Me.Controls.Add(Me.ChannelUserList1)
        Me.Name = "ChannelCtrl"
        Me.Size = New System.Drawing.Size(405, 260)
        Me.ContextMenuStrip1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents ContextMenuStrip1 As System.Windows.Forms.ContextMenuStrip
    Friend WithEvents AfficheLesUtilisateursToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents AfficheLaFenetreMessageToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ChannelUserList1 As IRCLib.ChannelUserList
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents ChannelMessagesCtrl1 As IRCLib.ChannelMessagesCtrl

End Class
