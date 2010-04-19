<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class BrowserWindow
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
        Me.OgameBrowserCtrl1 = New OGameObject.OgameBrowserCtrl
        Me.SuspendLayout()
        '
        'OgameBrowserCtrl1
        '
        Me.OgameBrowserCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.OgameBrowserCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.OgameBrowserCtrl1.Name = "OgameBrowserCtrl1"
        Me.OgameBrowserCtrl1.Size = New System.Drawing.Size(512, 272)
        Me.OgameBrowserCtrl1.TabIndex = 0
        '
        'BrowserWindow
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(512, 272)
        Me.Controls.Add(Me.OgameBrowserCtrl1)
        Me.Name = "BrowserWindow"
        Me.Text = "BrowserWindow"
        Me.ResumeLayout(False)

    End Sub
    Public WithEvents OgameBrowserCtrl1 As OGameObject.OgameBrowserCtrl
End Class
