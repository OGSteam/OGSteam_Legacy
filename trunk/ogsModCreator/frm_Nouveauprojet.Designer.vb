<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class frm_Nouveauprojet
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
        Me.Label1 = New System.Windows.Forms.Label
        Me.txt_Chemin = New System.Windows.Forms.TextBox
        Me.Button1 = New System.Windows.Forms.Button
        Me.Label2 = New System.Windows.Forms.Label
        Me.Button2 = New System.Windows.Forms.Button
        Me.Label3 = New System.Windows.Forms.Label
        Me.txt_Nommod = New System.Windows.Forms.TextBox
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Location = New System.Drawing.Point(12, 9)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(80, 13)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Nouveau projet"
        '
        'txt_Chemin
        '
        Me.txt_Chemin.Location = New System.Drawing.Point(136, 60)
        Me.txt_Chemin.Name = "txt_Chemin"
        Me.txt_Chemin.Size = New System.Drawing.Size(272, 20)
        Me.txt_Chemin.TabIndex = 1
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(414, 60)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(169, 20)
        Me.Button1.TabIndex = 2
        Me.Button1.Text = "Browse"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Location = New System.Drawing.Point(12, 63)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(104, 13)
        Me.Label2.TabIndex = 3
        Me.Label2.Text = "Chemin du répertoire"
        '
        'Button2
        '
        Me.Button2.Location = New System.Drawing.Point(15, 86)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(568, 29)
        Me.Button2.TabIndex = 4
        Me.Button2.Text = "Créer"
        Me.Button2.UseVisualStyleBackColor = True
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Location = New System.Drawing.Point(12, 33)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(112, 13)
        Me.Label3.TabIndex = 5
        Me.Label3.Text = "Nom du nouveau mod"
        '
        'txt_Nommod
        '
        Me.txt_Nommod.Location = New System.Drawing.Point(136, 31)
        Me.txt_Nommod.Name = "txt_Nommod"
        Me.txt_Nommod.Size = New System.Drawing.Size(447, 20)
        Me.txt_Nommod.TabIndex = 6
        '
        'frm_Nouveauprojet
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(595, 127)
        Me.Controls.Add(Me.txt_Nommod)
        Me.Controls.Add(Me.Label3)
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.txt_Chemin)
        Me.Controls.Add(Me.Label1)
        Me.Name = "frm_Nouveauprojet"
        Me.Text = "nouveau"
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents txt_Chemin As System.Windows.Forms.TextBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents txt_Nommod As System.Windows.Forms.TextBox
End Class
