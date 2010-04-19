<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ImportExportForm
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
        Me.ImportExportCtrl1 = New OGameObject.ImportExportCtrl
        Me.SuspendLayout()
        '
        'ImportExportCtrl1
        '
        Me.ImportExportCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.ImportExportCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.ImportExportCtrl1.Name = "ImportExportCtrl1"
        Me.ImportExportCtrl1.Size = New System.Drawing.Size(690, 554)
        Me.ImportExportCtrl1.TabIndex = 0
        '
        'ImportExportForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(690, 554)
        Me.Controls.Add(Me.ImportExportCtrl1)
        Me.Name = "ImportExportForm"
        Me.ShowIcon = False
        Me.Text = "OGS - Exportation et Importation"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents ImportExportCtrl1 As OGameObject.ImportExportCtrl
End Class
