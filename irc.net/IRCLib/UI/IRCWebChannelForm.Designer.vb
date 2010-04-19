<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class IRCWebChannelForm
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
        Me.WebChannelMessageCtrl1 = New IRCLib.WebChannelMessageCtrl
        Me.SuspendLayout()
        '
        'WebChannelMessageCtrl1
        '
        Me.WebChannelMessageCtrl1.Channel = Nothing
        Me.WebChannelMessageCtrl1.CssStyle = "#header {background: black;color:yellow}#messages {background: yellow;color: blac" & _
            "k;padding-right:3px;}"
        Me.WebChannelMessageCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.WebChannelMessageCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.WebChannelMessageCtrl1.Name = "WebChannelMessageCtrl1"
        Me.WebChannelMessageCtrl1.Size = New System.Drawing.Size(292, 266)
        Me.WebChannelMessageCtrl1.TabIndex = 0
        '
        'IRCWebChannelForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(292, 266)
        Me.Controls.Add(Me.WebChannelMessageCtrl1)
        Me.Name = "IRCWebChannelForm"
        Me.Text = "IRCWebChannelForm"
        Me.ResumeLayout(False)

    End Sub
    Public WithEvents WebChannelMessageCtrl1 As IRCLib.WebChannelMessageCtrl
End Class
