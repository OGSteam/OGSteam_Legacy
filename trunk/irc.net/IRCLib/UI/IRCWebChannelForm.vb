Public Class IRCWebChannelForm

    Private WithEvents pChannel As IRCChannel
    Public Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
        Set(ByVal value As IRCChannel)
            pChannel = value
            If value Is Nothing Then Return
            Me.Text = value.ChannelName & " - " & value.Topic
            pChannel.Form = Me
            WebChannelMessageCtrl1.Channel = value
        End Set
    End Property

    Private Sub WebChannelMessageCtrl1_Enter(ByVal sender As Object, ByVal e As System.EventArgs) Handles WebChannelMessageCtrl1.Enter
        ' WebChannelMessageCtrl1.UpdateChannelInfo()
    End Sub

End Class