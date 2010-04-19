Public Class IRCChannelForm

    Private WithEvents pChannel As IRCChannel
    Public Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
        Set(ByVal value As IRCChannel)
            pChannel = value
            '
            ChannelCtrl1.Channel = value
            Me.Text = value.ChannelName & " : " & value.Topic
            pChannel.Form = Me
        End Set
    End Property

End Class