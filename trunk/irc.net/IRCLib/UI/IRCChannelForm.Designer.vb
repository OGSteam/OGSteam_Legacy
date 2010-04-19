<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class IRCChannelForm
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
        Me.ChannelCtrl1 = New IRCLib.ChannelCtrl
        Me.SuspendLayout()
        '
        'ChannelCtrl1
        '
        Me.ChannelCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.ChannelCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.ChannelCtrl1.Name = "ChannelCtrl1"
        Me.ChannelCtrl1.Size = New System.Drawing.Size(582, 265)
        Me.ChannelCtrl1.TabIndex = 0
        '
        'IRCChannelForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(582, 265)
        Me.Controls.Add(Me.ChannelCtrl1)
        Me.Name = "IRCChannelForm"
        Me.Text = "IRCChannelForm"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents ChannelCtrl1 As IRCLib.ChannelCtrl
End Class
