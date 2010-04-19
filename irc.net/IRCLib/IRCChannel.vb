Imports System.Text.RegularExpressions
''' <summary>
''' Interface avec un canal IRC
''' </summary>
''' <remarks></remarks>
Public Class IRCChannel
#Region " Public Properties "

    Public Event OnUserChange(ByVal sender As Object, ByVal e As EventArgs)
    Public Event OnSetTopic(ByVal sender As Object, ByVal e As EventArgs)
    Public Event OnNameEnded(ByVal sender As Object, ByVal e As EventArgs)
    Public Event OnMessage(ByVal sender As Object, ByVal e As IRCChannelMessageEvent)
    Public Event OnNotice(ByVal sender As Object, ByVal e As IRCChannelMessageEvent)
    Public Event OnUserJoin(ByVal sender As Object, ByVal e As UserJoinEventArgs)
    Public Event OnUserPart(ByVal sender As Object, ByVal e As UserJoinEventArgs)
    Public Event OnUserQuit(ByVal sender As Object, ByVal e As UserQuitEventArgs)
    Public Event OnUserKick(ByVal sender As Object, ByVal e As UserQuitEventArgs)
    Public UsersDic As New Dictionary(Of String, IRCUser)

    Private pIRCMessages As New Collections.Generic.List(Of IrcRawMsg)
    Public ReadOnly Property NewProperty() As Collections.Generic.List(Of IrcRawMsg)
        Get

            Return pIRCMessages
        End Get
    End Property

    Private pTopic As String

    Public Property Topic() As String
        Get
            Return pTopic
        End Get
        Set(ByVal value As String)
            pTopic = value
            RaiseEvent OnSetTopic(Me, New EventArgs)
        End Set
    End Property

    Private pChannelName As String
    Public ReadOnly Property ChannelName() As String
        Get
            Return pChannelName
        End Get
    End Property
    Private WithEvents pServer As IRCLib.IRCServer
    Public ReadOnly Property Server() As IRCLib.IRCServer
        Get
            Return pServer
        End Get
    End Property


    Private WithEvents pForm As System.Windows.Forms.Form
    Public Property Form() As System.Windows.Forms.Form
        Get
            Return pForm
        End Get
        Set(ByVal value As System.Windows.Forms.Form)
            pForm = value
        End Set
    End Property

#End Region

    Public Sub New(ByVal ChanName As String, ByVal IrcServer As IRCLib.IRCServer)
        pChannelName = ChanName
        pServer = IrcServer
    End Sub

    Private NamesReceived As Boolean = False
    Public Sub NameEnded()
        NamesReceived = True
        RaiseEvent OnNameEnded(Me, New EventArgs)
    End Sub
    Public Sub ReceiveNames(ByVal msg As IrcRawMsg)
        If NamesReceived Then
            NamesReceived = False
            UsersDic.Clear()
        End If
        pIRCMessages.Add(msg)
        Dim UsersList() As String
        UsersList = msg.AfterCommand.Substring(msg.AfterCommand.IndexOf(":") + 1).Split(" ")
        For Each User As String In UsersList
            If User.Length > 0 Then
                UsersDic.Add(User, New IRCUser(User))
            End If
        Next User
    End Sub

    Public Sub PrivMsg(ByVal msg As IrcRawMsg)
        pIRCMessages.Add(msg)
        If UsersDic.ContainsKey(msg.sendernick) Then
            UsersDic(msg.sendernick).LastEventMsg = msg
        End If
        Dim Usermsg As String = msg.AfterCommand.Substring(msg.AfterCommand.IndexOf(":") + 1)
        RaiseEvent OnMessage(Me, New IRCChannelMessageEvent(Me, msg, Usermsg))

    End Sub

    Public Sub Notice(ByVal msg As IrcRawMsg)
        pIRCMessages.Add(msg)
        If UsersDic.ContainsKey(msg.sendernick) Then
            UsersDic(msg.sendernick).LastEventMsg = msg
        End If
        'Dim Usermsg As String = msg.AfterCommand.Substring(msg.AfterCommand.IndexOf(":") + 1)
        RaiseEvent OnNotice(Me, New IRCChannelMessageEvent(Me, msg, msg.text))
    End Sub

    Public Sub Join(ByVal msg As IrcRawMsg)
        pIRCMessages.Add(msg)
        Dim m As Match = Regex.Match(msg.RawMessage, ":(?<nick>[^!\s]+)!(?<host>[^\s]+)\s")
        If m.Success Then

            If Not UsersDic.ContainsKey(m.Groups("nick").Value) Then
                Dim usr As New IRCUser(m.Groups("nick").Value)
                usr.LastEventMsg = msg
                UsersDic.Add(m.Groups("nick").Value, usr)
                RaiseEvent OnUserJoin(Me, New UserJoinEventArgs(Me, usr))
            End If
        End If

    End Sub
    Public Sub Part(ByVal msg As IrcRawMsg)
        pIRCMessages.Add(msg)
        Dim m As Match = Regex.Match(msg.RawMessage, ":(?<nick>[^!\s]+)!(?<host>[^\s]+)\s")
        If m.Success Then
            If Not UsersDic.ContainsKey(m.Groups("nick").Value) Then Return
            RaiseEvent OnUserPart(Me, New UserJoinEventArgs(Me, UsersDic(m.Groups("nick").Value)))
            UsersDic.Remove(m.Groups("nick").Value)
        End If
    End Sub
    Public Sub Quit(ByVal msg As IrcRawMsg)
        pIRCMessages.Add(msg)
        Dim m As Match = Regex.Match(msg.RawMessage, ":(?<nick>[^!\s]+)!(?<host>[^\s]+)\s")
        If m.Success Then
            If UsersDic.ContainsKey(m.Groups("nick").Value) Then
                RaiseEvent OnUserQuit(Me, New UserQuitEventArgs(Me, UsersDic(m.Groups("nick").Value)))
                UsersDic.Remove(m.Groups("nick").Value)
            End If
        End If
    End Sub
    Public Sub Kick(ByVal msg As IrcRawMsg)
        pIRCMessages.Add(msg)
        Dim m As Match = Regex.Match(msg.RawMessage, ":(?<nick>[^!\s]+)!(?<host>[^\s]+)\s")
        If m.Success Then
            If UsersDic.ContainsKey(m.Groups("nick").Value) Then
                RaiseEvent OnUserKick(Me, New UserQuitEventArgs(Me, UsersDic(m.Groups("nick").Value)))
                UsersDic.Remove(m.Groups("nick").Value)
            End If
        End If
    End Sub
    Public Overrides Function ToString() As String
        Return ChannelName
    End Function
End Class
Public Class UserJoinEventArgs
    Inherits EventArgs

    Private pChannel As IRCChannel
    Public ReadOnly Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
    End Property

    Private pUser As IRCUser
    Public ReadOnly Property User() As IRCUser
        Get
            Return pUser
        End Get
    End Property

    Sub New(ByVal chan As IRCChannel, ByVal usr As IRCUser)
        MyBase.New()
        pChannel = chan
        pUser = usr
    End Sub
End Class

Public Class UserQuitEventArgs
    Inherits EventArgs

    Private pChannel As IRCChannel
    Public ReadOnly Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
    End Property

    Private pUser As IRCUser
    Public ReadOnly Property User() As IRCUser
        Get
            Return pUser
        End Get
    End Property

    Private pQuitMessage As String = "Not Implemented"
    Public ReadOnly Property QuitMessage() As String
        Get
            Return pQuitMessage
        End Get
    End Property

    Sub New(ByVal chan As IRCChannel, ByVal usr As IRCUser)
        MyBase.New()
        pChannel = chan
        pUser = usr
    End Sub
End Class