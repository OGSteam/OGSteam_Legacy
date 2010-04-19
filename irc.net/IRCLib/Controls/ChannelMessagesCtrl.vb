Imports System.Windows.Forms
Public Class ChannelMessagesCtrl


    Private WithEvents pChannel As IRCChannel
    Public Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
        Set(ByVal value As IRCChannel)
            pChannel = value
            If value IsNot Nothing Then

                ChannelNameLabel.Text = value.ChannelName
                TopicLabel.Text = value.Topic
            End If
        End Set
    End Property


    Private Delegate Sub _AddMessage(ByVal msg As String)
    Private Sub AddMessage(ByVal msg As String)
        If Me.InvokeRequired Then
            Dim d As New _AddMessage(AddressOf Me.AddMessage)
            Me.Invoke(d, New Object() {msg})
            Exit Sub
        End If
        MessagesRTB.SelectionProtected = False
        MessagesRTB.SelectionColor = MessagesRTB.ForeColor
        MessagesRTB.AppendText(msg & vbCrLf)
        MessagesRTB.SelectionStart = MessagesRTB.TextLength
        MessagesRTB.ScrollToCaret()
        MessagesRTB.SelectionProtected = True
    End Sub
    Private Delegate Sub _AddTextColor(ByVal msg As String, ByVal Color As System.Drawing.Color)
    Private Sub AddTextColor(ByVal msg As String, ByVal color As System.Drawing.Color)
        If Me.InvokeRequired Then
            Dim d As New _AddTextColor(AddressOf Me.AddTextColor)
            Me.Invoke(d, New Object() {msg, color})
            Exit Sub
        End If
        With MessagesRTB
            .SelectionStart = .TextLength
            .SelectionProtected = False
            .SelectionStart = .TextLength + 1
            .SelectionColor = color
            .SelectedText = msg
            .SelectionProtected = True
        End With
    End Sub
    Private Sub pChannel_OnMessage(ByVal sender As Object, ByVal e As IRCChannelMessageEvent) Handles pChannel.OnMessage
        AddTextColor(e.RawMessage.sendernick & "> ", Drawing.Color.Blue)
        AddMessage(e.RawMessage.AfterCommand.Substring(e.RawMessage.AfterCommand.IndexOf(":") + 1))

    End Sub

    Private Sub SendBtn_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles SendBtn.Click
        If PromptingTextbox.Text.Length <= 0 Then Return
        Channel.Server.SendMessage("PRIVMSG " & Channel.ChannelName & " :" & PromptingTextbox.Text)
        AddTextColor(Channel.Server.Nick & ">> ", Drawing.Color.Green)
        AddMessage(PromptingTextbox.Text)
        PromptingTextbox.Text = ""
    End Sub

    Private Sub PromptingTextbox_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles PromptingTextbox.KeyDown
        If e.KeyCode = Keys.Enter Then
            SendBtn_Click(Nothing, Nothing)
            e.SuppressKeyPress = True
        End If
    End Sub

    Private Sub pChannel_OnNotice(ByVal sender As Object, ByVal e As IRCChannelMessageEvent) Handles pChannel.OnNotice
        AddTextColor(e.RawMessage.sendernick & " --", Drawing.Color.Red)
        AddTextColor(e.RawMessage.text, Drawing.Color.OrangeRed)
        AddMessage("")
    End Sub

    Private Sub pChannel_OnSetTopic(ByVal sender As Object, ByVal e As System.EventArgs) Handles pChannel.OnSetTopic
        AddTextColor("TOPIC:" & pChannel.Topic, Drawing.Color.Green)
        AddMessage("")
        'AddMessage("TOPIC:" & pChannel.Topic)
        TopicLabel.Text = pChannel.Topic
    End Sub

    Private Sub pChannel_OnUserChange(ByVal sender As Object, ByVal e As System.EventArgs) Handles pChannel.OnUserChange
        MsgBox("OnUserChange")
    End Sub

    Private Sub pChannel_OnUserJoin(ByVal sender As Object, ByVal e As UserJoinEventArgs) Handles pChannel.OnUserJoin
        AddTextColor(e.User.ToString, Drawing.Color.Green)
        AddTextColor(" a rejoint ", MessagesRTB.ForeColor)
        AddTextColor(e.Channel.ChannelName, Drawing.Color.Red)
        AddMessage("")
    End Sub

    Private Sub pChannel_OnUserKick(ByVal sender As Object, ByVal e As UserQuitEventArgs) Handles pChannel.OnUserKick
        AddTextColor(e.User.ToString, Drawing.Color.Green)
        AddTextColor(" kicke ", MessagesRTB.ForeColor)
        AddTextColor(e.Channel.Server.raw.UserTarget, Drawing.Color.Red)
        AddMessage(" " & e.Channel.Server.raw.text)
    End Sub

    Private Sub pChannel_OnUserPart(ByVal sender As Object, ByVal e As UserJoinEventArgs) Handles pChannel.OnUserPart
        'AddMessage(e.User.ToString & " a quitté " & e.Channel.ChannelName & " (" & e.Channel.Server.raw.AfterCommand & ")")
        AddTextColor(e.User.ToString, Drawing.Color.OrangeRed)
        AddTextColor(" a quitté ", MessagesRTB.ForeColor)
        AddTextColor(e.Channel.ChannelName, Drawing.Color.Red)
        AddMessage("(PART)" & e.Channel.Server.raw.text)
    End Sub

    Private Sub pChannel_OnUserQuit(ByVal sender As Object, ByVal e As UserQuitEventArgs) Handles pChannel.OnUserQuit
        AddTextColor(e.User.ToString, Drawing.Color.OrangeRed)
        AddTextColor(" a quitté ", MessagesRTB.ForeColor)
        AddTextColor(e.Channel.ChannelName, Drawing.Color.Red)
        AddMessage("(QUIT)" & e.Channel.Server.raw.text)
    End Sub
End Class
