<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class OGSpyInfoForm
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
        Me.SplitContainer1 = New System.Windows.Forms.SplitContainer
        Me.PictureBox1 = New System.Windows.Forms.PictureBox
        Me.Label8 = New System.Windows.Forms.Label
        Me.Label7 = New System.Windows.Forms.Label
        Me.Label6 = New System.Windows.Forms.Label
        Me.Label5 = New System.Windows.Forms.Label
        Me.Label4 = New System.Windows.Forms.Label
        Me.Label3 = New System.Windows.Forms.Label
        Me.Label2 = New System.Windows.Forms.Label
        Me.Label1 = New System.Windows.Forms.Label
        Me.btnQuit = New System.Windows.Forms.Button
        Me.btnRefresh = New System.Windows.Forms.Button
        Me.tbImportSys = New System.Windows.Forms.TextBox
        Me.tbImportStat = New System.Windows.Forms.TextBox
        Me.tbExportStat = New System.Windows.Forms.TextBox
        Me.tbImportSpy = New System.Windows.Forms.TextBox
        Me.tbExportSpy = New System.Windows.Forms.TextBox
        Me.tbExportSys = New System.Windows.Forms.TextBox
        Me.tbServerVersion = New System.Windows.Forms.TextBox
        Me.tbServerName = New System.Windows.Forms.TextBox
        Me.SplitContainer1.Panel1.SuspendLayout()
        Me.SplitContainer1.Panel2.SuspendLayout()
        Me.SplitContainer1.SuspendLayout()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'SplitContainer1
        '
        Me.SplitContainer1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.SplitContainer1.Location = New System.Drawing.Point(0, 0)
        Me.SplitContainer1.Name = "SplitContainer1"
        '
        'SplitContainer1.Panel1
        '
        Me.SplitContainer1.Panel1.Controls.Add(Me.PictureBox1)
        Me.SplitContainer1.Panel1.Controls.Add(Me.Label8)
        Me.SplitContainer1.Panel1.Controls.Add(Me.Label7)
        Me.SplitContainer1.Panel1.Controls.Add(Me.Label6)
        Me.SplitContainer1.Panel1.Controls.Add(Me.Label5)
        Me.SplitContainer1.Panel1.Controls.Add(Me.Label4)
        Me.SplitContainer1.Panel1.Controls.Add(Me.Label3)
        Me.SplitContainer1.Panel1.Controls.Add(Me.Label2)
        Me.SplitContainer1.Panel1.Controls.Add(Me.Label1)
        '
        'SplitContainer1.Panel2
        '
        Me.SplitContainer1.Panel2.Controls.Add(Me.btnQuit)
        Me.SplitContainer1.Panel2.Controls.Add(Me.btnRefresh)
        Me.SplitContainer1.Panel2.Controls.Add(Me.tbImportSys)
        Me.SplitContainer1.Panel2.Controls.Add(Me.tbImportStat)
        Me.SplitContainer1.Panel2.Controls.Add(Me.tbExportStat)
        Me.SplitContainer1.Panel2.Controls.Add(Me.tbImportSpy)
        Me.SplitContainer1.Panel2.Controls.Add(Me.tbExportSpy)
        Me.SplitContainer1.Panel2.Controls.Add(Me.tbExportSys)
        Me.SplitContainer1.Panel2.Controls.Add(Me.tbServerVersion)
        Me.SplitContainer1.Panel2.Controls.Add(Me.tbServerName)
        Me.SplitContainer1.Size = New System.Drawing.Size(373, 279)
        Me.SplitContainer1.SplitterDistance = 153
        Me.SplitContainer1.TabIndex = 0
        '
        'PictureBox1
        '
        Me.PictureBox1.Image = Global.OGameObject.My.Resources.Resources.ogsteam_small
        Me.PictureBox1.Location = New System.Drawing.Point(7, 229)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(135, 38)
        Me.PictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox1.TabIndex = 1
        Me.PictureBox1.TabStop = False
        '
        'Label8
        '
        Me.Label8.AutoSize = True
        Me.Label8.Location = New System.Drawing.Point(3, 190)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(93, 13)
        Me.Label8.TabIndex = 0
        Me.Label8.Text = "Import Statistiques"
        '
        'Label7
        '
        Me.Label7.AutoSize = True
        Me.Label7.Location = New System.Drawing.Point(3, 164)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(94, 13)
        Me.Label7.TabIndex = 0
        Me.Label7.Text = "Export Statistiques"
        '
        'Label6
        '
        Me.Label6.AutoSize = True
        Me.Label6.Location = New System.Drawing.Point(4, 138)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(94, 13)
        Me.Label6.TabIndex = 0
        Me.Label6.Text = "Import Espionages"
        '
        'Label5
        '
        Me.Label5.AutoSize = True
        Me.Label5.Location = New System.Drawing.Point(4, 112)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(95, 13)
        Me.Label5.TabIndex = 0
        Me.Label5.Text = "Export Espionages"
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Location = New System.Drawing.Point(4, 87)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(82, 13)
        Me.Label4.TabIndex = 0
        Me.Label4.Text = "Import  Systeme"
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Location = New System.Drawing.Point(4, 61)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(80, 13)
        Me.Label3.TabIndex = 0
        Me.Label3.Text = "Export Systeme"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Location = New System.Drawing.Point(4, 35)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(42, 13)
        Me.Label2.TabIndex = 0
        Me.Label2.Text = "Version"
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Location = New System.Drawing.Point(4, 9)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(84, 13)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Nom du Serveur"
        '
        'btnQuit
        '
        Me.btnQuit.BackgroundImage = Global.OGameObject.My.Resources.Resources.arrow_forward_24
        Me.btnQuit.BackgroundImageLayout = System.Windows.Forms.ImageLayout.None
        Me.btnQuit.Location = New System.Drawing.Point(107, 229)
        Me.btnQuit.Name = "btnQuit"
        Me.btnQuit.Size = New System.Drawing.Size(84, 47)
        Me.btnQuit.TabIndex = 1
        Me.btnQuit.Text = "Quitter"
        Me.btnQuit.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.btnQuit.UseVisualStyleBackColor = True
        '
        'btnRefresh
        '
        Me.btnRefresh.BackgroundImage = Global.OGameObject.My.Resources.Resources.redo_24
        Me.btnRefresh.BackgroundImageLayout = System.Windows.Forms.ImageLayout.None
        Me.btnRefresh.Enabled = False
        Me.btnRefresh.Location = New System.Drawing.Point(12, 229)
        Me.btnRefresh.Name = "btnRefresh"
        Me.btnRefresh.Size = New System.Drawing.Size(84, 47)
        Me.btnRefresh.TabIndex = 1
        Me.btnRefresh.Text = "Actualiser"
        Me.btnRefresh.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.btnRefresh.UseVisualStyleBackColor = True
        '
        'tbImportSys
        '
        Me.tbImportSys.Location = New System.Drawing.Point(44, 84)
        Me.tbImportSys.Name = "tbImportSys"
        Me.tbImportSys.ReadOnly = True
        Me.tbImportSys.Size = New System.Drawing.Size(115, 20)
        Me.tbImportSys.TabIndex = 0
        '
        'tbImportStat
        '
        Me.tbImportStat.Location = New System.Drawing.Point(44, 187)
        Me.tbImportStat.Name = "tbImportStat"
        Me.tbImportStat.ReadOnly = True
        Me.tbImportStat.Size = New System.Drawing.Size(115, 20)
        Me.tbImportStat.TabIndex = 0
        '
        'tbExportStat
        '
        Me.tbExportStat.Location = New System.Drawing.Point(44, 161)
        Me.tbExportStat.Name = "tbExportStat"
        Me.tbExportStat.ReadOnly = True
        Me.tbExportStat.Size = New System.Drawing.Size(115, 20)
        Me.tbExportStat.TabIndex = 0
        '
        'tbImportSpy
        '
        Me.tbImportSpy.Location = New System.Drawing.Point(44, 135)
        Me.tbImportSpy.Name = "tbImportSpy"
        Me.tbImportSpy.ReadOnly = True
        Me.tbImportSpy.Size = New System.Drawing.Size(115, 20)
        Me.tbImportSpy.TabIndex = 0
        '
        'tbExportSpy
        '
        Me.tbExportSpy.Location = New System.Drawing.Point(44, 109)
        Me.tbExportSpy.Name = "tbExportSpy"
        Me.tbExportSpy.ReadOnly = True
        Me.tbExportSpy.Size = New System.Drawing.Size(115, 20)
        Me.tbExportSpy.TabIndex = 0
        '
        'tbExportSys
        '
        Me.tbExportSys.Location = New System.Drawing.Point(44, 54)
        Me.tbExportSys.Name = "tbExportSys"
        Me.tbExportSys.ReadOnly = True
        Me.tbExportSys.Size = New System.Drawing.Size(115, 20)
        Me.tbExportSys.TabIndex = 0
        '
        'tbServerVersion
        '
        Me.tbServerVersion.Location = New System.Drawing.Point(12, 32)
        Me.tbServerVersion.Name = "tbServerVersion"
        Me.tbServerVersion.ReadOnly = True
        Me.tbServerVersion.Size = New System.Drawing.Size(168, 20)
        Me.tbServerVersion.TabIndex = 0
        '
        'tbServerName
        '
        Me.tbServerName.Location = New System.Drawing.Point(12, 6)
        Me.tbServerName.Name = "tbServerName"
        Me.tbServerName.ReadOnly = True
        Me.tbServerName.Size = New System.Drawing.Size(168, 20)
        Me.tbServerName.TabIndex = 0
        '
        'OGSpyInfoForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(373, 279)
        Me.Controls.Add(Me.SplitContainer1)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.Fixed3D
        Me.Name = "OGSpyInfoForm"
        Me.ShowIcon = False
        Me.Text = "Informations sur le serveur OGSpy"
        Me.TopMost = True
        Me.SplitContainer1.Panel1.ResumeLayout(False)
        Me.SplitContainer1.Panel1.PerformLayout()
        Me.SplitContainer1.Panel2.ResumeLayout(False)
        Me.SplitContainer1.Panel2.PerformLayout()
        Me.SplitContainer1.ResumeLayout(False)
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents SplitContainer1 As System.Windows.Forms.SplitContainer
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents tbServerVersion As System.Windows.Forms.TextBox
    Friend WithEvents tbServerName As System.Windows.Forms.TextBox
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents Label8 As System.Windows.Forms.Label
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents btnRefresh As System.Windows.Forms.Button
    Friend WithEvents tbImportSys As System.Windows.Forms.TextBox
    Friend WithEvents tbImportStat As System.Windows.Forms.TextBox
    Friend WithEvents tbExportStat As System.Windows.Forms.TextBox
    Friend WithEvents tbImportSpy As System.Windows.Forms.TextBox
    Friend WithEvents tbExportSpy As System.Windows.Forms.TextBox
    Friend WithEvents tbExportSys As System.Windows.Forms.TextBox
    Friend WithEvents btnQuit As System.Windows.Forms.Button
    Friend WithEvents PictureBox1 As System.Windows.Forms.PictureBox
End Class
