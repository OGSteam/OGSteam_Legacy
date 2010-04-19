<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ChannelUserList
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
        Me.panHeader = New System.Windows.Forms.Panel
        Me.ChannelNameLabel = New System.Windows.Forms.Label
        Me.panFooter = New System.Windows.Forms.Panel
        Me.InfoLabel = New System.Windows.Forms.Label
        Me.UsersListBox = New System.Windows.Forms.ListBox
        Me.panHeader.SuspendLayout()
        Me.panFooter.SuspendLayout()
        Me.SuspendLayout()
        '
        'panHeader
        '
        Me.panHeader.Controls.Add(Me.ChannelNameLabel)
        Me.panHeader.Dock = System.Windows.Forms.DockStyle.Top
        Me.panHeader.Location = New System.Drawing.Point(0, 0)
        Me.panHeader.Name = "panHeader"
        Me.panHeader.Size = New System.Drawing.Size(166, 27)
        Me.panHeader.TabIndex = 1
        '
        'ChannelNameLabel
        '
        Me.ChannelNameLabel.Dock = System.Windows.Forms.DockStyle.Fill
        Me.ChannelNameLabel.Font = New System.Drawing.Font("Comic Sans MS", 11.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.ChannelNameLabel.Location = New System.Drawing.Point(0, 0)
        Me.ChannelNameLabel.Name = "ChannelNameLabel"
        Me.ChannelNameLabel.Size = New System.Drawing.Size(166, 27)
        Me.ChannelNameLabel.TabIndex = 0
        Me.ChannelNameLabel.Text = "#OGSTRATEGE"
        Me.ChannelNameLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panFooter
        '
        Me.panFooter.Controls.Add(Me.InfoLabel)
        Me.panFooter.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.panFooter.Location = New System.Drawing.Point(0, 180)
        Me.panFooter.Name = "panFooter"
        Me.panFooter.Size = New System.Drawing.Size(166, 22)
        Me.panFooter.TabIndex = 3
        '
        'InfoLabel
        '
        Me.InfoLabel.Dock = System.Windows.Forms.DockStyle.Fill
        Me.InfoLabel.Font = New System.Drawing.Font("Comic Sans MS", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.InfoLabel.Location = New System.Drawing.Point(0, 0)
        Me.InfoLabel.Name = "InfoLabel"
        Me.InfoLabel.Size = New System.Drawing.Size(166, 22)
        Me.InfoLabel.TabIndex = 1
        Me.InfoLabel.Text = "0 Users"
        Me.InfoLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'UsersListBox
        '
        Me.UsersListBox.Dock = System.Windows.Forms.DockStyle.Fill
        Me.UsersListBox.FormattingEnabled = True
        Me.UsersListBox.IntegralHeight = False
        Me.UsersListBox.Location = New System.Drawing.Point(0, 27)
        Me.UsersListBox.Name = "UsersListBox"
        Me.UsersListBox.Size = New System.Drawing.Size(166, 153)
        Me.UsersListBox.Sorted = True
        Me.UsersListBox.TabIndex = 4
        '
        'ChannelUserList
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.Controls.Add(Me.UsersListBox)
        Me.Controls.Add(Me.panFooter)
        Me.Controls.Add(Me.panHeader)
        Me.Name = "ChannelUserList"
        Me.Size = New System.Drawing.Size(166, 202)
        Me.panHeader.ResumeLayout(False)
        Me.panFooter.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents panHeader As System.Windows.Forms.Panel
    Friend WithEvents panFooter As System.Windows.Forms.Panel
    Friend WithEvents ChannelNameLabel As System.Windows.Forms.Label
    Friend WithEvents InfoLabel As System.Windows.Forms.Label
    Friend WithEvents UsersListBox As System.Windows.Forms.ListBox

End Class
