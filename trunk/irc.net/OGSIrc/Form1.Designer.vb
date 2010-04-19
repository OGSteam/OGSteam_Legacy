<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Form1
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
        Me.components = New System.ComponentModel.Container
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Form1))
        Me.ToolStripContainer1 = New System.Windows.Forms.ToolStripContainer
        Me.ToolStrip2 = New System.Windows.Forms.ToolStrip
        Me.PromptLine = New System.Windows.Forms.ToolStripTextBox
        Me.SendButton = New System.Windows.Forms.ToolStripButton
        Me.labStatus = New System.Windows.Forms.ToolStripLabel
        Me.btnStatus = New System.Windows.Forms.ToolStripButton
        Me.RichTextBox1 = New System.Windows.Forms.RichTextBox
        Me.MainContextMenu = New System.Windows.Forms.ContextMenuStrip(Me.components)
        Me.ContextMenuTitle = New System.Windows.Forms.ToolStripMenuItem
        Me.ToolStripSeparator1 = New System.Windows.Forms.ToolStripSeparator
        Me.ChannelsComboBox = New System.Windows.Forms.ToolStripComboBox
        Me.ToolStrip1 = New System.Windows.Forms.ToolStrip
        Me.ToolStripButton1 = New System.Windows.Forms.ToolStripButton
        Me.ToolStripButton2 = New System.Windows.Forms.ToolStripButton
        Me.ToolStripSeparator3 = New System.Windows.Forms.ToolStripSeparator
        Me.ToolStripDropDownButton1 = New System.Windows.Forms.ToolStripDropDownButton
        Me.ServeurToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.ToolStripMenuItem1 = New System.Windows.Forms.ToolStripMenuItem
        Me.cbServerUrl = New System.Windows.Forms.ToolStripComboBox
        Me.ToolStripMenuItem2 = New System.Windows.Forms.ToolStripMenuItem
        Me.cbServerPort = New System.Windows.Forms.ToolStripComboBox
        Me.ToolStripMenuItem4 = New System.Windows.Forms.ToolStripMenuItem
        Me.tbNick = New System.Windows.Forms.ToolStripTextBox
        Me.ToolStripMenuItem3 = New System.Windows.Forms.ToolStripMenuItem
        Me.micShowFullMessage = New System.Windows.Forms.ToolStripMenuItem
        Me.micBeepOnPïngPong = New System.Windows.Forms.ToolStripMenuItem
        Me.ToolStripSeparator2 = New System.Windows.Forms.ToolStripSeparator
        Me.ShowAllChannelsFormBtn = New System.Windows.Forms.ToolStripButton
        Me.Timer1 = New System.Windows.Forms.Timer(Me.components)
        Me.ToolStripButton3 = New System.Windows.Forms.ToolStripButton
        Me.ToolStripContainer1.BottomToolStripPanel.SuspendLayout()
        Me.ToolStripContainer1.ContentPanel.SuspendLayout()
        Me.ToolStripContainer1.TopToolStripPanel.SuspendLayout()
        Me.ToolStripContainer1.SuspendLayout()
        Me.ToolStrip2.SuspendLayout()
        Me.MainContextMenu.SuspendLayout()
        Me.ToolStrip1.SuspendLayout()
        Me.SuspendLayout()
        '
        'ToolStripContainer1
        '
        '
        'ToolStripContainer1.BottomToolStripPanel
        '
        Me.ToolStripContainer1.BottomToolStripPanel.Controls.Add(Me.ToolStrip2)
        '
        'ToolStripContainer1.ContentPanel
        '
        Me.ToolStripContainer1.ContentPanel.Controls.Add(Me.RichTextBox1)
        Me.ToolStripContainer1.ContentPanel.Size = New System.Drawing.Size(559, 206)
        Me.ToolStripContainer1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.ToolStripContainer1.Location = New System.Drawing.Point(0, 0)
        Me.ToolStripContainer1.Name = "ToolStripContainer1"
        Me.ToolStripContainer1.Size = New System.Drawing.Size(559, 256)
        Me.ToolStripContainer1.TabIndex = 0
        Me.ToolStripContainer1.Text = "ToolStripContainer1"
        '
        'ToolStripContainer1.TopToolStripPanel
        '
        Me.ToolStripContainer1.TopToolStripPanel.Controls.Add(Me.ToolStrip1)
        '
        'ToolStrip2
        '
        Me.ToolStrip2.Dock = System.Windows.Forms.DockStyle.None
        Me.ToolStrip2.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.PromptLine, Me.SendButton, Me.labStatus, Me.btnStatus})
        Me.ToolStrip2.Location = New System.Drawing.Point(3, 0)
        Me.ToolStrip2.Name = "ToolStrip2"
        Me.ToolStrip2.Size = New System.Drawing.Size(440, 25)
        Me.ToolStrip2.TabIndex = 0
        '
        'PromptLine
        '
        Me.PromptLine.AutoSize = False
        Me.PromptLine.Name = "PromptLine"
        Me.PromptLine.Size = New System.Drawing.Size(300, 25)
        '
        'SendButton
        '
        Me.SendButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.SendButton.Image = Global.IRCTest.My.Resources.Resources.clipart_misc_001
        Me.SendButton.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.SendButton.Name = "SendButton"
        Me.SendButton.Size = New System.Drawing.Size(23, 22)
        Me.SendButton.Text = "ToolStripButton2"
        '
        'labStatus
        '
        Me.labStatus.Alignment = System.Windows.Forms.ToolStripItemAlignment.Right
        Me.labStatus.AutoSize = False
        Me.labStatus.Name = "labStatus"
        Me.labStatus.Size = New System.Drawing.Size(80, 22)
        Me.labStatus.Text = "ToolStripLabel1"
        '
        'btnStatus
        '
        Me.btnStatus.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnStatus.Image = Global.IRCTest.My.Resources.Resources.bullets_diamonds_red_003
        Me.btnStatus.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.btnStatus.Name = "btnStatus"
        Me.btnStatus.Size = New System.Drawing.Size(23, 22)
        Me.btnStatus.Text = "ToolStripButton3"
        '
        'RichTextBox1
        '
        Me.RichTextBox1.BackColor = System.Drawing.SystemColors.InactiveCaptionText
        Me.RichTextBox1.ContextMenuStrip = Me.MainContextMenu
        Me.RichTextBox1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.RichTextBox1.Font = New System.Drawing.Font("Comic Sans MS", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.RichTextBox1.ForeColor = System.Drawing.SystemColors.InfoText
        Me.RichTextBox1.Location = New System.Drawing.Point(0, 0)
        Me.RichTextBox1.Name = "RichTextBox1"
        Me.RichTextBox1.ReadOnly = True
        Me.RichTextBox1.Size = New System.Drawing.Size(559, 206)
        Me.RichTextBox1.TabIndex = 0
        Me.RichTextBox1.Text = ""
        '
        'MainContextMenu
        '
        Me.MainContextMenu.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ContextMenuTitle, Me.ToolStripSeparator1, Me.ChannelsComboBox})
        Me.MainContextMenu.Name = "MainContextMenu"
        Me.MainContextMenu.Size = New System.Drawing.Size(213, 57)
        '
        'ContextMenuTitle
        '
        Me.ContextMenuTitle.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.ContextMenuTitle.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.ContextMenuTitle.Name = "ContextMenuTitle"
        Me.ContextMenuTitle.Size = New System.Drawing.Size(212, 22)
        Me.ContextMenuTitle.Text = "NomServeur"
        '
        'ToolStripSeparator1
        '
        Me.ToolStripSeparator1.Name = "ToolStripSeparator1"
        Me.ToolStripSeparator1.Size = New System.Drawing.Size(209, 6)
        '
        'ChannelsComboBox
        '
        Me.ChannelsComboBox.Name = "ChannelsComboBox"
        Me.ChannelsComboBox.Size = New System.Drawing.Size(152, 21)
        Me.ChannelsComboBox.Text = "Channels"
        '
        'ToolStrip1
        '
        Me.ToolStrip1.Dock = System.Windows.Forms.DockStyle.None
        Me.ToolStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ToolStripButton1, Me.ToolStripButton2, Me.ToolStripSeparator3, Me.ToolStripDropDownButton1, Me.ToolStripSeparator2, Me.ShowAllChannelsFormBtn, Me.ToolStripButton3})
        Me.ToolStrip1.Location = New System.Drawing.Point(3, 0)
        Me.ToolStrip1.Name = "ToolStrip1"
        Me.ToolStrip1.Size = New System.Drawing.Size(176, 25)
        Me.ToolStrip1.TabIndex = 0
        '
        'ToolStripButton1
        '
        Me.ToolStripButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButton1.Image = Global.IRCTest.My.Resources.Resources.bullets_diamonds_green_004
        Me.ToolStripButton1.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripButton1.Name = "ToolStripButton1"
        Me.ToolStripButton1.Size = New System.Drawing.Size(23, 22)
        Me.ToolStripButton1.Text = "ToolStripButton1"
        '
        'ToolStripButton2
        '
        Me.ToolStripButton2.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButton2.Image = Global.IRCTest.My.Resources.Resources.bullets_diamonds_red_003
        Me.ToolStripButton2.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripButton2.Name = "ToolStripButton2"
        Me.ToolStripButton2.Size = New System.Drawing.Size(23, 22)
        Me.ToolStripButton2.Text = "ToolStripButton2"
        '
        'ToolStripSeparator3
        '
        Me.ToolStripSeparator3.Name = "ToolStripSeparator3"
        Me.ToolStripSeparator3.Size = New System.Drawing.Size(6, 25)
        '
        'ToolStripDropDownButton1
        '
        Me.ToolStripDropDownButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripDropDownButton1.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ServeurToolStripMenuItem, Me.ToolStripMenuItem3})
        Me.ToolStripDropDownButton1.Image = Global.IRCTest.My.Resources.Resources.clipart_misc_317
        Me.ToolStripDropDownButton1.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripDropDownButton1.Name = "ToolStripDropDownButton1"
        Me.ToolStripDropDownButton1.Size = New System.Drawing.Size(29, 22)
        Me.ToolStripDropDownButton1.Text = "ToolStripDropDownButton1"
        '
        'ServeurToolStripMenuItem
        '
        Me.ServeurToolStripMenuItem.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ToolStripMenuItem1, Me.cbServerUrl, Me.ToolStripMenuItem2, Me.cbServerPort, Me.ToolStripMenuItem4, Me.tbNick})
        Me.ServeurToolStripMenuItem.Name = "ServeurToolStripMenuItem"
        Me.ServeurToolStripMenuItem.Size = New System.Drawing.Size(152, 22)
        Me.ServeurToolStripMenuItem.Text = "Serveur"
        '
        'ToolStripMenuItem1
        '
        Me.ToolStripMenuItem1.Enabled = False
        Me.ToolStripMenuItem1.Image = Global.IRCTest.My.Resources.Resources.clipart_misc_001
        Me.ToolStripMenuItem1.Name = "ToolStripMenuItem1"
        Me.ToolStripMenuItem1.Size = New System.Drawing.Size(181, 22)
        Me.ToolStripMenuItem1.Text = "serveur"
        '
        'cbServerUrl
        '
        Me.cbServerUrl.Items.AddRange(New Object() {"irc.sorcery.net", "irc.ogamenet.net", "irc.freenode.net"})
        Me.cbServerUrl.Name = "cbServerUrl"
        Me.cbServerUrl.Size = New System.Drawing.Size(121, 21)
        Me.cbServerUrl.Text = "irc.sorcery.net"
        '
        'ToolStripMenuItem2
        '
        Me.ToolStripMenuItem2.Enabled = False
        Me.ToolStripMenuItem2.Image = Global.IRCTest.My.Resources.Resources.clipart_misc_001
        Me.ToolStripMenuItem2.Name = "ToolStripMenuItem2"
        Me.ToolStripMenuItem2.Size = New System.Drawing.Size(181, 22)
        Me.ToolStripMenuItem2.Text = "Port"
        '
        'cbServerPort
        '
        Me.cbServerPort.Name = "cbServerPort"
        Me.cbServerPort.Size = New System.Drawing.Size(121, 21)
        Me.cbServerPort.Text = "6667"
        '
        'ToolStripMenuItem4
        '
        Me.ToolStripMenuItem4.Enabled = False
        Me.ToolStripMenuItem4.Name = "ToolStripMenuItem4"
        Me.ToolStripMenuItem4.Size = New System.Drawing.Size(181, 22)
        Me.ToolStripMenuItem4.Text = "Nick"
        '
        'tbNick
        '
        Me.tbNick.Name = "tbNick"
        Me.tbNick.Size = New System.Drawing.Size(100, 21)
        Me.tbNick.Text = "Ricalawaba"
        '
        'ToolStripMenuItem3
        '
        Me.ToolStripMenuItem3.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.micShowFullMessage, Me.micBeepOnPïngPong})
        Me.ToolStripMenuItem3.Name = "ToolStripMenuItem3"
        Me.ToolStripMenuItem3.Size = New System.Drawing.Size(152, 22)
        Me.ToolStripMenuItem3.Text = "Options"
        '
        'micShowFullMessage
        '
        Me.micShowFullMessage.Checked = True
        Me.micShowFullMessage.CheckOnClick = True
        Me.micShowFullMessage.CheckState = System.Windows.Forms.CheckState.Checked
        Me.micShowFullMessage.Name = "micShowFullMessage"
        Me.micShowFullMessage.Size = New System.Drawing.Size(231, 22)
        Me.micShowFullMessage.Text = "Montrer la totalité du message"
        '
        'micBeepOnPïngPong
        '
        Me.micBeepOnPïngPong.CheckOnClick = True
        Me.micBeepOnPïngPong.Name = "micBeepOnPïngPong"
        Me.micBeepOnPïngPong.Size = New System.Drawing.Size(231, 22)
        Me.micBeepOnPïngPong.Text = "Beep sur les Ping/Pong"
        '
        'ToolStripSeparator2
        '
        Me.ToolStripSeparator2.Name = "ToolStripSeparator2"
        Me.ToolStripSeparator2.Size = New System.Drawing.Size(6, 25)
        '
        'ShowAllChannelsFormBtn
        '
        Me.ShowAllChannelsFormBtn.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ShowAllChannelsFormBtn.Image = CType(resources.GetObject("ShowAllChannelsFormBtn.Image"), System.Drawing.Image)
        Me.ShowAllChannelsFormBtn.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ShowAllChannelsFormBtn.Name = "ShowAllChannelsFormBtn"
        Me.ShowAllChannelsFormBtn.Size = New System.Drawing.Size(23, 22)
        Me.ShowAllChannelsFormBtn.Text = "ToolStripButton3"
        '
        'Timer1
        '
        Me.Timer1.Enabled = True
        '
        'ToolStripButton3
        '
        Me.ToolStripButton3.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButton3.Image = CType(resources.GetObject("ToolStripButton3.Image"), System.Drawing.Image)
        Me.ToolStripButton3.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripButton3.Name = "ToolStripButton3"
        Me.ToolStripButton3.Size = New System.Drawing.Size(23, 22)
        Me.ToolStripButton3.Text = "ToolStripButton3"
        '
        'Form1
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(559, 256)
        Me.Controls.Add(Me.ToolStripContainer1)
        Me.Name = "Form1"
        Me.Text = "IRCLib .Net"
        Me.ToolStripContainer1.BottomToolStripPanel.ResumeLayout(False)
        Me.ToolStripContainer1.BottomToolStripPanel.PerformLayout()
        Me.ToolStripContainer1.ContentPanel.ResumeLayout(False)
        Me.ToolStripContainer1.TopToolStripPanel.ResumeLayout(False)
        Me.ToolStripContainer1.TopToolStripPanel.PerformLayout()
        Me.ToolStripContainer1.ResumeLayout(False)
        Me.ToolStripContainer1.PerformLayout()
        Me.ToolStrip2.ResumeLayout(False)
        Me.ToolStrip2.PerformLayout()
        Me.MainContextMenu.ResumeLayout(False)
        Me.ToolStrip1.ResumeLayout(False)
        Me.ToolStrip1.PerformLayout()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents ToolStripContainer1 As System.Windows.Forms.ToolStripContainer
    Friend WithEvents RichTextBox1 As System.Windows.Forms.RichTextBox
    Friend WithEvents ToolStrip1 As System.Windows.Forms.ToolStrip
    Friend WithEvents ToolStripButton1 As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStrip2 As System.Windows.Forms.ToolStrip
    Friend WithEvents PromptLine As System.Windows.Forms.ToolStripTextBox
    Friend WithEvents ToolStripSeparator1 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents ChannelsComboBox As System.Windows.Forms.ToolStripComboBox
    Friend WithEvents SendButton As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripButton2 As System.Windows.Forms.ToolStripButton
    Friend WithEvents labStatus As System.Windows.Forms.ToolStripLabel
    Friend WithEvents ToolStripDropDownButton1 As System.Windows.Forms.ToolStripDropDownButton
    Friend WithEvents btnStatus As System.Windows.Forms.ToolStripButton
    Friend WithEvents Timer1 As System.Windows.Forms.Timer
    Friend WithEvents ToolStripMenuItem3 As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ServeurToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolStripMenuItem1 As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents cbServerUrl As System.Windows.Forms.ToolStripComboBox
    Friend WithEvents ToolStripMenuItem2 As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents cbServerPort As System.Windows.Forms.ToolStripComboBox
    Friend WithEvents micShowFullMessage As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents micBeepOnPïngPong As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolStripMenuItem4 As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents tbNick As System.Windows.Forms.ToolStripTextBox
    Friend WithEvents MainContextMenu As System.Windows.Forms.ContextMenuStrip
    Public WithEvents ContextMenuTitle As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolStripSeparator3 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents ToolStripSeparator2 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents ShowAllChannelsFormBtn As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripButton3 As System.Windows.Forms.ToolStripButton

End Class
