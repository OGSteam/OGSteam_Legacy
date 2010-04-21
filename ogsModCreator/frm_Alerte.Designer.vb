<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Frm_Alerte
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
        Me.lblecho = New System.Windows.Forms.Label
        Me.SuspendLayout()
        '
        'lblecho
        '
        Me.lblecho.AutoSize = True
        Me.lblecho.Location = New System.Drawing.Point(25, 16)
        Me.lblecho.Name = "lblecho"
        Me.lblecho.Size = New System.Drawing.Size(0, 13)
        Me.lblecho.TabIndex = 0
        '
        'Frm_Alerte
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(292, 91)
        Me.Controls.Add(Me.lblecho)
        Me.Name = "Frm_Alerte"
        Me.Text = "Alerte"
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents lblecho As System.Windows.Forms.Label
End Class
