<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ChannelMessagesCtrl
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
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.TopicLabel = New System.Windows.Forms.Label
        Me.ChannelNameLabel = New System.Windows.Forms.Label
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.PromptingTextbox = New System.Windows.Forms.TextBox
        Me.SendBtn = New System.Windows.Forms.Button
        Me.MessagesRTB = New System.Windows.Forms.RichTextBox
        Me.Panel1.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.TopicLabel)
        Me.Panel1.Controls.Add(Me.ChannelNameLabel)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(402, 18)
        Me.Panel1.TabIndex = 0
        '
        'TopicLabel
        '
        Me.TopicLabel.BackColor = System.Drawing.SystemColors.Info
        Me.TopicLabel.Dock = System.Windows.Forms.DockStyle.Fill
        Me.TopicLabel.ForeColor = System.Drawing.SystemColors.InfoText
        Me.TopicLabel.Location = New System.Drawing.Point(51, 0)
        Me.TopicLabel.Name = "TopicLabel"
        Me.TopicLabel.Size = New System.Drawing.Size(351, 18)
        Me.TopicLabel.TabIndex = 1
        Me.TopicLabel.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'ChannelNameLabel
        '
        Me.ChannelNameLabel.AutoSize = True
        Me.ChannelNameLabel.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.ChannelNameLabel.Dock = System.Windows.Forms.DockStyle.Left
        Me.ChannelNameLabel.Font = New System.Drawing.Font("Comic Sans MS", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.ChannelNameLabel.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.ChannelNameLabel.Location = New System.Drawing.Point(0, 0)
        Me.ChannelNameLabel.Name = "ChannelNameLabel"
        Me.ChannelNameLabel.Size = New System.Drawing.Size(51, 19)
        Me.ChannelNameLabel.TabIndex = 0
        Me.ChannelNameLabel.Text = "#name"
        Me.ChannelNameLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.PromptingTextbox)
        Me.Panel2.Controls.Add(Me.SendBtn)
        Me.Panel2.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.Panel2.Location = New System.Drawing.Point(0, 293)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(402, 20)
        Me.Panel2.TabIndex = 1
        '
        'PromptingTextbox
        '
        Me.PromptingTextbox.Dock = System.Windows.Forms.DockStyle.Fill
        Me.PromptingTextbox.Location = New System.Drawing.Point(0, 0)
        Me.PromptingTextbox.Name = "PromptingTextbox"
        Me.PromptingTextbox.Size = New System.Drawing.Size(327, 20)
        Me.PromptingTextbox.TabIndex = 1
        '
        'SendBtn
        '
        Me.SendBtn.Dock = System.Windows.Forms.DockStyle.Right
        Me.SendBtn.Location = New System.Drawing.Point(327, 0)
        Me.SendBtn.Name = "SendBtn"
        Me.SendBtn.Size = New System.Drawing.Size(75, 20)
        Me.SendBtn.TabIndex = 0
        Me.SendBtn.Text = "Envoyer"
        Me.SendBtn.UseVisualStyleBackColor = True
        '
        'MessagesRTB
        '
        Me.MessagesRTB.Dock = System.Windows.Forms.DockStyle.Fill
        Me.MessagesRTB.Location = New System.Drawing.Point(0, 18)
        Me.MessagesRTB.Name = "MessagesRTB"
        Me.MessagesRTB.Size = New System.Drawing.Size(402, 275)
        Me.MessagesRTB.TabIndex = 2
        Me.MessagesRTB.Text = ""
        '
        'ChannelMessagesCtrl
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.Controls.Add(Me.MessagesRTB)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.Panel1)
        Me.Name = "ChannelMessagesCtrl"
        Me.Size = New System.Drawing.Size(402, 313)
        Me.Panel1.ResumeLayout(False)
        Me.Panel1.PerformLayout()
        Me.Panel2.ResumeLayout(False)
        Me.Panel2.PerformLayout()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents PromptingTextbox As System.Windows.Forms.TextBox
    Friend WithEvents SendBtn As System.Windows.Forms.Button
    Friend WithEvents MessagesRTB As System.Windows.Forms.RichTextBox
    Friend WithEvents TopicLabel As System.Windows.Forms.Label
    Friend WithEvents ChannelNameLabel As System.Windows.Forms.Label

End Class
