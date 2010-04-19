Public Class ChannelCtrl


    Private pChannel As IRCChannel
    Public Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
        Set(ByVal value As IRCChannel)
            pChannel = value
            ChannelUserList1.Channel = value
            ChannelMessagesCtrl1.Channel = value
        End Set
    End Property

    Private Sub AfficheLesUtilisateursToolStripMenuItem_CheckedChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles AfficheLesUtilisateursToolStripMenuItem.CheckedChanged
        If Not AfficheLesUtilisateursToolStripMenuItem.Checked Then
            If ChannelMessagesCtrl1.Visible = False Then Return
            ChannelUserList1.Visible = False
        Else
            ChannelUserList1.Visible = True
        End If
    End Sub

    Private Sub AfficheLaFenetreMessageToolStripMenuItem_CheckedChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles AfficheLaFenetreMessageToolStripMenuItem.CheckedChanged
        If Not AfficheLaFenetreMessageToolStripMenuItem.Checked Then
            If ChannelUserList1.Visible = False Then Return
            ChannelMessagesCtrl1.Visible = False
        Else
            ChannelMessagesCtrl1.Visible = True
        End If
    End Sub

    Private Sub AfficheLesUtilisateursToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles AfficheLesUtilisateursToolStripMenuItem.Click

    End Sub
End Class
