<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class TestForm
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
        Me.OGameSystemUI1 = New OGSUi.OGameSystemUI
        Me.SuspendLayout()
        '
        'OGameSystemUI1
        '
        Me.OGameSystemUI1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.OGameSystemUI1.Location = New System.Drawing.Point(0, 0)
        Me.OGameSystemUI1.Name = "OGameSystemUI1"
        Me.OGameSystemUI1.Size = New System.Drawing.Size(292, 266)
        Me.OGameSystemUI1.TabIndex = 0
        '
        'TestForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(292, 266)
        Me.Controls.Add(Me.OGameSystemUI1)
        Me.Name = "TestForm"
        Me.Text = "TestForm"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents OGameSystemUI1 As OGSUi.OGameSystemUI
End Class
