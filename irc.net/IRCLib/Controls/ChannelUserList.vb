Public Class ChannelUserList


    Private WithEvents pChannel As IRCChannel
    Public Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
        Set(ByVal value As IRCChannel)
            pChannel = value
            If value IsNot Nothing Then
                ChannelNameLabel.Text = pChannel.ChannelName
                InfoLabel.Text = pChannel.UsersDic.Count & " users"
            End If
        End Set
    End Property

    Private Sub pChannel_OnNameEnded(ByVal sender As Object, ByVal e As System.EventArgs) Handles pChannel.OnNameEnded
        If Me.InvokeRequired Then
            Dim d As New EventHandler(AddressOf Me.pChannel_OnNameEnded)
            Me.Invoke(d, New Object() {sender, e})
            Exit Sub
        End If
        UsersListBox.Items.Clear()
        UsersListBox.BeginUpdate()
        For Each u As IRCUser In pChannel.UsersDic.Values
            UsersListBox.Items.Add(u)
        Next

        UsersListBox.EndUpdate()
        InfoLabel.Text = pChannel.UsersDic.Count & " users"
    End Sub
    Public Event OnUserDbleClick(ByVal sender As Object, ByVal e As EventArgs)
    Private Sub UsersListBox_DoubleClick(ByVal sender As Object, ByVal e As System.EventArgs) Handles UsersListBox.DoubleClick
        If UsersListBox.SelectedItem IsNot Nothing Then
            RaiseEvent OnUserDbleClick(Me, New ChannelUserListEventArgs(UsersListBox.SelectedItem))
        End If
    End Sub

    Private Sub pChannel_OnUserJoin(ByVal sender As Object, ByVal e As UserJoinEventArgs) Handles pChannel.OnUserJoin
        If Me.InvokeRequired Then
            Dim d As New EventHandler(Of UserJoinEventArgs)(AddressOf Me.pChannel_OnUserJoin)
            Me.Invoke(d, New Object() {sender, e})
            Exit Sub
        End If
        UsersListBox.Items.Add(e.User)
    End Sub

    Private Sub pChannel_OnUserKick(ByVal sender As Object, ByVal e As UserQuitEventArgs) Handles pChannel.OnUserKick
        If Me.InvokeRequired Then
            Dim d As New EventHandler(Of UserJoinEventArgs)(AddressOf Me.pChannel_OnUserPart)
            Me.Invoke(d, New Object() {sender, e})
            Exit Sub
        End If
        If UsersListBox.Items.Contains(e.User) Then
            UsersListBox.Items.Remove(e.User)
        End If
    End Sub

    Private Sub pChannel_OnUserPart(ByVal sender As Object, ByVal e As UserJoinEventArgs) Handles pChannel.OnUserPart
        If Me.InvokeRequired Then
            Dim d As New EventHandler(Of UserJoinEventArgs)(AddressOf Me.pChannel_OnUserPart)
            Me.Invoke(d, New Object() {sender, e})
            Exit Sub
        End If
        If UsersListBox.Items.Contains(e.User) Then
            UsersListBox.Items.Remove(e.User)
        End If
    End Sub

    Private Sub pChannel_OnUserQuit(ByVal sender As Object, ByVal e As UserQuitEventArgs) Handles pChannel.OnUserQuit
        If Me.InvokeRequired Then
            Dim d As New EventHandler(Of UserQuitEventArgs)(AddressOf Me.pChannel_OnUserQuit)
            Me.Invoke(d, New Object() {sender, e})
            Exit Sub
        End If
        If UsersListBox.Items.Contains(e.User) Then
            UsersListBox.Items.Remove(e.User)
        End If
    End Sub
End Class

Public Class ChannelUserListEventArgs
    Inherits EventArgs

    Private pUser As IRCUser
    Public ReadOnly Property User() As IRCUser
        Get
            Return pUser
        End Get
    End Property
    Public Sub New()

    End Sub
    Public Sub New(ByVal AnUser As IRCUser)
        pUser = AnUser
    End Sub
End Class
