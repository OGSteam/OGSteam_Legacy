Imports System.IO
Imports System.Net
Imports System.Net.Sockets
Imports System.Threading
''' <summary>
''' Classe d'interface avec un serveur IRC
''' </summary>
''' <remarks></remarks>
Public Class IRCServer
    Implements IDisposable
    Public Event OnServerActionMessage(ByVal sender As Object, ByVal ActionMsg As IrcRawMsg)
    Public Event OnServerStatusChange(ByVal sender As Object, ByVal e As ServerStatusChangeEventArg)
    'Public Event OnLostConnection(ByVal sender As Object, ByVal e As EventArgs)
    Public ServerThread As Thread
#Region " Public Properties "

    ''' <summary>
    ''' Liste des canaux IRC ouvert
    ''' </summary>
    ''' <remarks></remarks>
    Public channels As New Dictionary(Of String, IRCChannel)

    Private pServer As String
    ''' <summary>
    ''' URL du serveur
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property Server() As String
        Get
            Return pServer
        End Get
        Set(ByVal value As String)
            pServer = value
        End Set
    End Property

    Private pPort As String
    ''' <summary>
    ''' Port du serveur (defaut: 6667)
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property Port() As String
        Get
            Return pPort
        End Get
        Set(ByVal value As String)
            pPort = value
        End Set
    End Property

    Private pNick As String
    ''' <summary>
    ''' Nickname souhaité
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property Nick() As String
        Get
            Return pNick
        End Get
        Set(ByVal value As String)
            pNick = value
        End Set
    End Property

    Private pUser As String
    ''' <summary>
    ''' Nom d'utilisateur souhaité 
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property User() As String
        Get
            Return pUser
        End Get
        Set(ByVal value As String)
            pUser = value
        End Set
    End Property

    Private pQuitMessage As String = String.Empty
    ''' <summary>
    ''' Message par defaut lors des QUIT
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property QuitMessage() As String
        Get
            Return pQuitMessage
        End Get
        Set(ByVal value As String)
            pQuitMessage = value
        End Set
    End Property

    Private pMOTD As New Collections.Specialized.StringCollection
    ''' <summary>
    ''' le MOTD du serveur
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property MOTD() As Collections.Specialized.StringCollection
        Get
            Return pMOTD
        End Get
    End Property
    
    Private pStarted As Boolean
    ''' <summary>
    ''' TRUE si le thread de connection est lancé
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property Started() As Boolean
        Get
            Return pStarted
        End Get
    End Property

#End Region
    Private IRCC As TcpClient
    
    Private Writer As StreamWriter
    Private Stream As NetworkStream
    Private Reader As StreamReader
    Public Sub New()
        Nick = "Ricalawaba"
        Server = "irc.sorcery.net"
        Port = "6667"
        User = "IRC .Net Lib :IRCNetLib"

    End Sub
    Private IP As IPAddress
    ''' <summary>
    ''' Resolve le domaine <paramref name=" Server"> </paramref> , et emet un evenement <see cref=" OnServerStatusChange "></see>
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function ResolveDNS() As IPAddress
        Dim AllAddr() As IPAddress = Dns.GetHostAddresses(Server)
        If AllAddr.Length > 0 Then
            IP = AllAddr(0)

            RaiseEvent OnServerStatusChange(Me, New ServerStatusChangeEventArg(ServerStatusChangeEventArg.ServerStatus.HOST_RESOLVED))
        Else
            RaiseEvent OnServerStatusChange(Me, New ServerStatusChangeEventArg(ServerStatusChangeEventArg.ServerStatus.CANT_RESOLVEHOST))
        End If
        Return IP
    End Function

    ''' <summary>
    ''' Lancement du thread de connection et flux avec le serveur IRC
    ''' </summary>
    ''' <remarks></remarks>
    Public Sub Start()
        If Started Or ResolveDNS() Is Nothing Then Return
        ServerThread = New Thread(New ThreadStart(AddressOf connect))
        ServerThread.IsBackground = True
        ServerThread.Start()
        Me.pStarted = True
    End Sub
    ''' <summary>
    ''' Connection et lecture en boucle des messages via <see cref=" FetchData "></see>
    ''' </summary>
    ''' <remarks></remarks>
    Private Sub connect()
        Dim netStream As NetworkStream
        Try
            netStream = New TcpClient(IP.ToString, Port).GetStream
            Reader = New StreamReader(netStream)
            Writer = New StreamWriter(netStream)
            Writer.AutoFlush = True
            SendMessage("NICK " & Nick)
            SendMessage("USER " & User)
            RaiseEvent OnServerStatusChange(Me, New IRCLib.ServerStatusChangeEventArg(ServerStatusChangeEventArg.ServerStatus.CONNECTION_OPENED))
            Try


                While (Me.disposedValue = False)
                    FetchData()
                End While
            Catch ex As IOException

            End Try
            Writer.Dispose()
            Reader.Dispose()
            RaiseEvent OnServerStatusChange(Me, New IRCLib.ServerStatusChangeEventArg(ServerStatusChangeEventArg.ServerStatus.CONNECTION_LOST))
        Catch ex As SocketException
            MsgBox("Impossible de se connecter à " & IP.ToString)
            Return
        End Try

    End Sub
    ''' <summary>
    ''' Lancé lors de toutes reception de ligne de donnée IRC
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="msg"></param>
    ''' <remarks></remarks>
    Public Event OnMessage(ByVal sender As Object, ByVal msg As IrcRawMsg)
    ''' <summary>
    ''' Fin de reception du MOTD du serveur IRC
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnMOTD(ByVal sender As Object, ByVal e As EventArgs)
    ''' <summary>
    ''' PING recu
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnPING(ByVal sender As Object, ByVal e As EventArgs)
    ''' <summary>
    ''' Nouveau Canal IRC
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnChannelNew(ByVal sender As Object, ByVal e As IRCServerChannelEvent)
    ''' <summary>
    ''' Reception du TOPIC d'un channel
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnChannelTopic(ByVal sender As Object, ByVal e As IRCServerChannelEvent)

    ''' <summary>
    ''' Reception des noms d'utilisateurs terminé
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnChannelNamesReceived(ByVal sender As Object, ByVal e As IRCServerChannelEvent)
    ''' <summary>
    ''' Message reçu pour canal
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnChannelMessage(ByVal sender As Object, ByVal e As IRCChannelMessageEvent)
    ''' <summary>
    ''' Notice reçu pour un canal
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnChannelNotice(ByVal sender As Object, ByVal e As IRCChannelMessageEvent)
    ''' <summary>
    ''' Un utilisateur arrive dans le canal
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnChannelJoin(ByVal sender As Object, ByVal e As IRCChannelMessageEvent)
    ''' <summary>
    ''' Un utilisateur part du canal
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Public Event OnChannelPart(ByVal sender As Object, ByVal e As IRCChannelMessageEvent)
    Public Event OnChannelKick(ByVal sender As Object, ByVal e As IRCChannelMessageEvent)
    Public Event OnChannelMode(ByVal sender As Object, ByVal e As IRCChannelMessageEvent)
    ''' <summary>
    ''' Dernière données brutes lu du serveur IRC
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property lastdata() As String
        Get
            Return pdata
        End Get
    End Property

    
    Private pdata As String
    ''' <summary>
    ''' Dernière Message recu du serveur IRC
    ''' </summary>
    ''' <remarks></remarks>
    Public raw As IrcRawMsg
    ''' <summary>
    ''' Lecture en boucle des données provenant du serveur IRC et lance les evenements
    ''' correspondants aux données reçus.
    ''' </summary>
    ''' <remarks>Sort de la boucle sur une Erreur d'E/S en relancant l'exception <see cref=" IOException ">IOException</see></remarks>
    Private Sub FetchData()
        pdata = String.Empty
        Try
            pdata = Reader.ReadLine
        Catch IoEx As IOException
            Throw IoEx
        Catch ex As Exception
            handleException(ex)
        End Try
        raw = Nothing
        If pdata Is String.Empty OrElse pdata Is Nothing Then Return
        'Dim raw As New IrcRawMsg(pdata)
        raw = New IrcRawMsg(pdata)
        Select Case raw.CommandCode
            Case IrcRawMsg.IRCMessageCode.IRCMessage
                Select Case raw.IRCMsg
                    Case IrcRawMsg.IRCMessage.PING
                        RaiseEvent OnPING(Me, New EventArgs)
                        RaiseEvent OnMessage(Me, raw)
                        SendMessage("PONG " & raw.AfterCommand)
                        Return
                    Case IrcRawMsg.IRCMessage.PRIVMSG
                        If raw.Channel IsNot Nothing AndAlso raw.Channel.Length > 1 Then
                            If channels.ContainsKey(raw.LChannel) Then
                                channels(raw.LChannel).PrivMsg(raw)
                                RaiseEvent OnChannelMessage(Me, New IRCChannelMessageEvent(channels(raw.LChannel), raw, ""))
                            End If

                        End If
                    Case IrcRawMsg.IRCMessage.JOIN
                        If raw.Channel IsNot Nothing AndAlso raw.Channel.Length > 1 Then
                            If channels.ContainsKey(raw.LChannel) Then
                                channels(raw.LChannel).Join(raw)
                                RaiseEvent OnChannelJoin(Me, New IRCChannelMessageEvent(channels(raw.LChannel), raw, ""))
                            End If
                        End If
                    Case IrcRawMsg.IRCMessage.PART
                        If raw.Channel IsNot Nothing AndAlso raw.Channel.Length > 1 Then
                            If channels.ContainsKey(raw.LChannel) Then
                                channels(raw.LChannel).Part(raw)
                                RaiseEvent OnChannelPart(Me, New IRCChannelMessageEvent(channels(raw.LChannel), raw, ""))
                            End If
                        End If
                    Case IrcRawMsg.IRCMessage.NOTICE
                        If raw.Channel IsNot Nothing AndAlso raw.Channel.Length > 1 Then
                            If channels.ContainsKey(raw.LChannel) Then
                                channels(raw.LChannel).Notice(raw)
                                RaiseEvent OnChannelNotice(Me, New IRCChannelMessageEvent(channels(raw.LChannel), raw, ""))
                            End If
                        Else
                            For Each c As IRCChannel In channels.Values
                                c.Notice(raw)
                            Next
                        End If

                    Case IrcRawMsg.IRCMessage.QUIT

                        For Each c As IRCChannel In channels.Values
                            c.Quit(raw)
                        Next
                    Case IrcRawMsg.IRCMessage.KICK
                        If raw.Channel IsNot Nothing AndAlso raw.Channel.Length > 1 Then
                            If channels.ContainsKey(raw.LChannel) Then
                                channels(raw.LChannel).Kick(raw)
                                RaiseEvent OnChannelKick(Me, New IRCChannelMessageEvent(channels(raw.LChannel), raw, ""))
                            End If
                        End If
                End Select
            Case IrcRawMsg.IRCMessageCode.RPL_NOTOPIC
                
                If channels.ContainsKey(raw.LChannel) Then
                    channels(raw.LChannel).Topic = String.Empty
                    RaiseEvent OnChannelTopic(Me, New IRCServerChannelEvent(Me, channels(raw.LChannel)))
                Else
                    Dim NewChan As New IRCChannel(raw.Channel, Me)
                    channels.Add(raw.LChannel, NewChan)
                    RaiseEvent OnChannelNew(Me, New IRCServerChannelEvent(Me, NewChan))
                    RaiseEvent OnChannelTopic(Me, New IRCServerChannelEvent(Me, NewChan))
                End If
            Case IrcRawMsg.IRCMessageCode.RPL_TOPIC

                If channels.ContainsKey(raw.LChannel) Then
                    channels(raw.LChannel).Topic = Mid(raw.AfterCommand, raw.AfterCommand.IndexOf(":") + 2)
                    RaiseEvent OnChannelTopic(Me, New IRCServerChannelEvent(Me, channels(raw.LChannel)))
                Else
                    Dim NewChan As New IRCChannel(raw.Channel, Me)
                    NewChan.Topic = Trim(Mid(raw.AfterCommand, raw.AfterCommand.IndexOf(":") + 2))
                    channels.Add(raw.LChannel, NewChan)
                    RaiseEvent OnChannelNew(Me, New IRCServerChannelEvent(Me, NewChan))
                    RaiseEvent OnChannelTopic(Me, New IRCServerChannelEvent(Me, NewChan))
                End If

            Case IrcRawMsg.IRCMessageCode.RPL_NAMREPLY
                'Reception des noms pour un channel
                If channels.ContainsKey(raw.LChannel) Then
                    channels(raw.LChannel).ReceiveNames(raw)
                Else
                    'todo:  MsgBox("Je recois des nom d'user pour " & GetChannel(raw) & " mais.. je ne connais pas ce channel... Putain d'informatique !!")
                End If
            Case IrcRawMsg.IRCMessageCode.RPL_ENDOFNAMES
                'Signal de fin de receptions des noms utilisateurs pour un channel
                If channels.ContainsKey(raw.LChannel) Then
                    channels(raw.LChannel).NameEnded()
                    RaiseEvent OnChannelNamesReceived(Me, New IRCServerChannelEvent(Me, channels(raw.LChannel)))
                Else
                    'todo:  MsgBox("Je recois des nom d'user pour " & GetChannel(raw) & " mais.. je ne connais pas ce channel... Putain d'informatique !!")
                End If
            Case IrcRawMsg.IRCMessageCode.RPL_NOUSERS
                'Il n'y pas d'utilisateurs dans ce channels
            Case IrcRawMsg.IRCMessageCode.RPL_MOTDSTART
                pMOTD.Clear()
            Case IrcRawMsg.IRCMessageCode.RPL_MOTD
                pMOTD.Add(raw.AfterCommand)
            Case IrcRawMsg.IRCMessageCode.RPL_ENDOFMOTD
                RaiseEvent OnMOTD(Me, New EventArgs)
        End Select
        If raw.Command IsNot String.Empty Then
            RaiseEvent OnServerActionMessage(Me, raw)
        End If

        RaiseEvent OnMessage(Me, raw)
    End Sub
    Public Event OnSendMessage(ByVal sender As Object, ByVal msg As String)
    ''' <summary>
    ''' Envoie d'une commande IRC "brute"
    ''' </summary>
    ''' <param name="msg">La ligne de donnée IRC</param>
    ''' <remarks>Emet un Evenement <see cref=" OnSendMessage ">OnSendMessage</see></remarks>
    Public Sub SendMessage(ByVal msg As String)

        'Console.WriteLine(msg)
        Writer.WriteLine(msg)
        RaiseEvent OnSendMessage(Me, msg)
    End Sub
    ''' <summary>
    ''' Gestion interne des exceptions - (Console+MsgBox)
    ''' </summary>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub handleException(ByVal e As Exception)
        Console.WriteLine("Exception: " & e.Message)
        MsgBox(e.Message)
    End Sub


    Private disposedValue As Boolean = False        ' Pour détecter les appels redondants

    ' IDisposable
    Protected Overridable Sub Dispose(ByVal disposing As Boolean)
        If Not Me.disposedValue Then
            If disposing Then
                ' TODO : libérez des ressources non managées en cas d'appel explicite
                If QuitMessage Is String.Empty Then
                    SendMessage("QUIT")
                Else
                    SendMessage("QUIT :" + QuitMessage)
                End If

            End If

            ' TODO : libérez des ressources non managées partagées

        End If
        Me.disposedValue = True

    End Sub

#Region " IDisposable Support "
    ' Ce code a été ajouté par Visual Basic pour permettre l'implémentation correcte du modèle pouvant être supprimé.
    Public Sub Dispose() Implements IDisposable.Dispose
        ' Ne modifiez pas ce code. Ajoutez du code de nettoyage dans Dispose(ByVal disposing As Boolean) ci-dessus.
        Dispose(True)
        GC.SuppressFinalize(Me)
    End Sub
#End Region

End Class
''' <summary>
''' Classe de base des Evenemements IRC
''' </summary>
''' <remarks></remarks>
Public Class IRCServerEvent
    Inherits EventArgs

    Private pServer As IRCServer
    ''' <summary>
    ''' Instance du serveur IRC concerné
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property Server() As IRCServer
        Get
            Return pServer
        End Get
    End Property

    Public Sub New(ByVal Serv As IRCServer)
        pServer = Serv
    End Sub
End Class
''' <summary>
''' Evenement IRC reception de données pour un canal
''' </summary>
''' <remarks></remarks>
Public Class IRCServerChannelEvent
    Inherits IRCServerEvent

    Private pChannel As IRCChannel
    Public ReadOnly Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
    End Property

    Public Sub New(ByVal Serv As IRCServer, ByVal Chan As IRCChannel)
        MyBase.New(Serv)
        pChannel = Chan
    End Sub

End Class
''' <summary>
''' hmmm a definir
''' </summary>
''' <remarks></remarks>
Public Class IRCMessageEvent
    Inherits IRCServerEvent

    Private pMesg As IrcRawMsg
    Public ReadOnly Property RawMessage() As IrcRawMsg
        Get
            Return pMesg
        End Get
    End Property
    Public Sub New(ByVal serv As IRCServer, ByVal msg As IrcRawMsg)
        MyBase.New(serv)
        pMesg = msg
    End Sub
End Class
''' <summary>
''' Evenement recu lors de la reception d'un message sur le chan
''' </summary>
''' <remarks></remarks>
Public Class IRCChannelMessageEvent
    Inherits IRCServerChannelEvent

    Private pUserMessage As String
    Public ReadOnly Property UserMessage() As String
        Get
            Return pUserMessage
        End Get
        
    End Property

    Private pMesg As IrcRawMsg
    Public ReadOnly Property RawMessage() As IrcRawMsg
        Get
            Return pMesg
        End Get
    End Property
    Public Sub New(ByVal chan As IRCChannel, ByVal msg As IrcRawMsg, ByVal UsrMsg As String)
        MyBase.New(chan.Server, chan)
        pMesg = msg
        pUserMessage = UsrMsg

    End Sub
End Class
''' <summary>
''' Evenement "Changement de statut du serveur"
''' </summary>
''' <remarks><see cref="ServerStatusChangeEventArg.ServerStatus">Enumération serverstatus</see></remarks>
Public Class ServerStatusChangeEventArg
    Inherits EventArgs
    ''' <summary>
    ''' Type de changement de statut repertorié
    ''' </summary>
    ''' <remarks></remarks>
    Public Enum ServerStatus
        CONNECTION_OPENED
        CONNECTION_LOST
        HOST_RESOLVED
        CANT_RESOLVEHOST
    End Enum

    Private pStatus As ServerStatus
    Public ReadOnly Property Status() As ServerStatus
        Get
            Return pStatus
        End Get
    End Property
    ''' <summary>
    ''' <seealso cref=" ServerStatus "></seealso>
    ''' </summary>
    ''' <param name="ServerStatus_"></param>
    ''' <remarks></remarks>
    Public Sub New(ByVal ServerStatus_ As ServerStatus)
        MyBase.New()
        pStatus = ServerStatus_
    End Sub
End Class