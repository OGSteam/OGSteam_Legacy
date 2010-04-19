Public Class Form1
    Private WithEvents server As IRCLib.IRCServer
    ''' <summary>
    ''' Se connecte au serveur
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub ToolStripButton1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton1.Click
        If server Is Nothing Then
            server = New IRCLib.IRCServer
            server.Server = cbServerUrl.Text
            server.Port = cbServerPort.Text
            server.Start()
            Timer1.Start()
            ToolStripButton2.Enabled = True
        End If
    End Sub
#Region "Affichage des Informations "
    Delegate Sub _ShowMsg(ByVal msg As String)
    Public Sub ShowMsg(ByVal msg As String)
        If msg Is Nothing OrElse msg Is String.Empty OrElse msg.Trim.Length = 0 Then Return
        If Me.InvokeRequired Then
            Dim d As New _ShowMsg(AddressOf ShowMsg)
            Me.Invoke(d, New Object() {msg})
            Exit Sub
        End If
        RichTextBox1.AppendText(msg & vbCrLf)
        RichTextBox1.SelectionStart = RichTextBox1.TextLength
        RichTextBox1.ScrollToCaret()
        btnStatus.Image = My.Resources.bullets_diamonds_green_004
        btnStatus.Tag = Now
    End Sub
    Public Sub ShowStatus(ByVal msg As String)
        If msg Is Nothing OrElse msg Is String.Empty OrElse msg.Trim.Length = 0 Then Return
        If Me.InvokeRequired Then
            Dim d As New _ShowMsg(AddressOf ShowStatus)
            Me.Invoke(d, New Object() {msg})
            Exit Sub
        End If
        labStatus.Text = msg
        btnStatus.Image = My.Resources.bullets_diamonds_green_004
        btnStatus.Tag = Now
    End Sub
#End Region
#Region " Evenements recu du serveur "

    Private Sub server_OnChannelNew(ByVal sender As Object, ByVal e As IRCLib.IRCServerChannelEvent) Handles server.OnChannelNew
        If Me.InvokeRequired Then
            Dim d As New EventHandler(Of IRCLib.IRCServerChannelEvent)(AddressOf Me.server_OnChannelNew)
            Dim parms() As Object = New Object() {sender, e}
            Me.Invoke(d, parms)
            Exit Sub
        End If
        Dim p As New IRCLib.IRCChannelForm

        'Dim p As New IRCLib.IRCWebChannelForm
        p.Channel = e.Channel
        p.Show()

    End Sub

    Private Sub server_OnChannelTopic(ByVal sender As Object, ByVal e As IRCLib.IRCServerChannelEvent) Handles server.OnChannelTopic
        ShowStatus("Topic")
    End Sub
    Private Sub server_OnMOTD(ByVal sender As Object, ByVal e As System.EventArgs) Handles server.OnMOTD
        'MsgBox("MOTD recu : " & CType(sender, IRCLib.IRCServer).MOTD.ToString)
    End Sub
    Private Sub server_OnServerActionMessage(ByVal Sender As Object, ByVal ActionMsg As IRCLib.IrcRawMsg) Handles server.OnServerActionMessage
        Select Case ActionMsg.CommandCode
            Case IRCLib.IrcRawMsg.IRCMessageCode.IRCMessage
                ShowStatus("IRCM " & ActionMsg.IRCMsg.ToString)
            Case Else
                ShowStatus("IRCM " & ActionMsg.CommandCode.ToString)
        End Select

    End Sub
    Private Sub server_OnMessage(ByVal sender As Object, ByVal msg As IRCLib.IrcRawMsg) Handles server.OnMessage
        If micShowFullMessage.Checked Then
            ShowMsg(msg.RawMessage)
        Else
            ShowMsg(msg.AfterCommand)
        End If

    End Sub

    Private Sub server_OnSendMessage(ByVal sender As Object, ByVal msg As String) Handles server.OnSendMessage
        ShowMsg(msg)
    End Sub
#End Region

    ''' <summary>
    ''' Deconnecte du serveur
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub ToolStripButton2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton2.Click
        If server IsNot Nothing Then
            server.Dispose()
            server = Nothing
            ToolStripButton2.Enabled = False
        End If
    End Sub
#Region " Promptline "
    ''' <summary>
    ''' Prend en charge l'appui sur la touche Enter dans la boite de prompt
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub PromptLine_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles PromptLine.KeyDown
        If e.KeyCode = Keys.Enter Then
            SendButton_Click(Nothing, Nothing)
            e.SuppressKeyPress = True
        End If
    End Sub
    ''' <summary>
    ''' Envoi le message de la barre de prompt si non vide
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub SendButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles SendButton.Click
        If PromptLine.Text = "" Then Return
        server.SendMessage(PromptLine.Text)
        PromptLine.Text = ""
    End Sub
#End Region
    ''' <summary>
    ''' Change l'icone de la barre en fonction du delai du dernier envoi du serveur
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub Timer1_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Timer1.Tick
        If btnStatus.Image Is My.Resources.bullets_diamonds_red_003 Then Return
        If DateDiff(DateInterval.Second, CType(btnStatus.Tag, Date), Now) > 1 Then
            btnStatus.Image = My.Resources.bullets_diamonds_red_003
        End If
    End Sub

    Private Sub server_OnPING(ByVal sender As Object, ByVal e As System.EventArgs) Handles server.OnPING
        If micBeepOnPïngPong.Checked Then Beep()
    End Sub

    Private Sub MainContextMenu_Opening(ByVal sender As System.Object, ByVal e As System.ComponentModel.CancelEventArgs) Handles MainContextMenu.Opening
        If server Is Nothing Then
            ContextMenuTitle.Enabled = False
            ContextMenuTitle.Text = "(Non Connecté)"
        Else
            ContextMenuTitle.Text = server.Server
            ChannelsComboBox.Items.Clear()
            For Each c As Object In server.channels.Values
                ChannelsComboBox.Items.Add(c)
            Next c

        End If
    End Sub

    Private Sub ChannelsComboBox_SelectedIndexChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles ChannelsComboBox.SelectedIndexChanged
        If ChannelsComboBox.SelectedItem Is Nothing Then Return
        With CType(ChannelsComboBox.SelectedItem, IRCLib.IRCChannel)
            If .Form IsNot Nothing Then
                .Form.Show()
                .Form.Focus()
            End If
        End With
    End Sub

    Private Sub ShowAllChannelsFormBtn_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ShowAllChannelsFormBtn.Click
        If server Is Nothing Then Return
        For Each c As IRCLib.IRCChannel In server.channels.Values
            Try
                If c.Form IsNot Nothing Then
                    c.Form.Show()
                    c.Form.Focus()
                End If
            Catch ex As Exception
                'au cas ou la form aurait été fermé
            End Try
        Next
    End Sub

    Private Sub Form1_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Me.Text = cbServerUrl.Text & " - IRCLib .Net"
    End Sub

    Private Sub cbServerUrl_TextChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbServerUrl.TextChanged
        Me.Text = cbServerUrl.Text & " - IRCLib .Net"
    End Sub

    Private Sub ToolStripButton3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton3.Click
        Dim f As New IRCLib.IRCWebChannelForm
        f.ShowDialog()
    End Sub
End Class
