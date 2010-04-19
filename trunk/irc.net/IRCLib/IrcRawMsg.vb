Imports System.Text.RegularExpressions
''' <summary>
''' Message IRC Brut et analyse
''' </summary>
''' <remarks></remarks>
Public Class IrcRawMsg

#Region " Enumération des messages IRC "
    ''' <summary>
    ''' Type de messages "texte"
    ''' </summary>
    ''' <remarks></remarks>
    Public Enum IRCMessage
        JOIN
        KICK
        PING
        PONG
        MODE
        NICK
        NOTICE
        PART
        PRIVMSG
        QUIT
    End Enum
    ''' <summary>
    ''' Type de messages "numériques"
    ''' </summary>
    ''' <remarks></remarks>
    Public Enum IRCMessageCode
        IRCMessage = -1
        unknown = 0
        RPL_AWAY = 301
        RPL_USERHOST = 302
        RPL_ISON = 303
        RPL_UNAWAY = 305
        RPL_NOWAWAY = 306

        RPL_WHOISUSER = 311
        RPL_WHOISSERVER = 312
        RPL_WHOISOPERATOR = 313
        RPL_WHOWASUSER = 314
        RPL_ENDOFWHO = 315
        RPL_WHOISIDLE = 317
        RPL_ENDOFWHOIS = 318
        RPL_WHOISCHANNELS = 319

        RPL_LISTSTART = 321
        RPL_LIST = 322
        RPL_LISTEND = 323

        RPL_CHANNELMODEIS = 324
        RPL_NOTOPIC = 331
        RPL_TOPIC = 332 ':WHF.OGameNet.net 332 Ricalawaba #OGStratege : OGSTeam / OGSpy / OGS Outils Windows pour Ogame - || http://www.ogsteam.fr || en cas de probleme : http://ogs.servebbs.net || OGSProut || autojoin vital ! || OGSNux aussi, n'oublions pas
        RPL_TOPICSET = 333 ':WHF.OGameNet.net 333 Ricalawaba #OGStratege Bousteur 1174758041
        RPL_INVITING = 341
        RPL_VERSION = 351
        RPL_WHOREPLY = 352
        RPL_NAMREPLY = 353 ':WHF.OGameNet.net 353 Ricalawaba = #OGStratege :Ricalawaba @OGSHelp irnine94 Atipo +Jonathan developpement Psychocolat +Julia AerialCss @Bousteur @BelBlonde +BlAcKbUrRy +Akryus @Ralt +CaLi` @Eggy|bot @Master @Aeris +Sgnos +[Synode|away] @Fitz @Erreur32 @ChanServ +Maxou|offfff
        RPL_LINKS = 364
        RPL_ENDOFLINKS = 365
        RPL_ENDOFNAMES = 366

        RPL_BANLIST = 367
        RPL_ENDOFBANLIST = 368
        RPL_ENDOFWHOWAS = 369
        RPL_INFO = 371
        RPL_ENDOFINFO = 374
        RPL_MOTD = 372
        RPL_MOTDSTART = 375
        RPL_ENDOFMOTD = 376
        RPL_YOUREOPER = 381
        RPL_TIME = 391
        RPL_USERSSTART = 392
        RPL_USERS = 393
        RPL_ENDOFUSERS = 394
        RPL_NOUSERS = 395

        ERR_NOSUCHNICK = 401
        ERR_NOSUCHSERVER = 402
        ERR_NOSUCHCHANNEL = 403
        ERR_CANNOTSENDTOCHAN = 404
        ERR_TOOMANYCHANNELS = 405
        ERR_WASNOSUCHNICK = 406
        ERR_TOOMANYTARGETS = 407
        ERR_NOORIGIN = 409
        ERR_NORECIPIENT = 411
        ERR_NOTEXTTOSEND = 412
        ERR_UNKNOWNCOMMAND = 421
        ERR_NOMOTD = 422
        ERR_NOADMININFO = 423
        ERR_FILEERROR = 424
        ERR_NONICKNAMEGIVEN = 431
        ERR_ERRONEUSNICKNAME = 432
        ERR_NICKNAMEINUSE = 433
        ERR_NICKCOLLISION = 436
        ERR_USERNOTINCHANNEL = 441
        ERR_NOTONCHANNEL = 442
        ERR_USERONCHANNEL = 443
        ERR_NOLOGIN = 444
        ERR_USERSDISABLED = 446
        ERR_NOTREGISTERED = 451
        ERR_NEEDMOREPARAMS = 461
        ERR_ALREADYREGISTRED = 462
        ERR_YOUREBANNEDCREEP = 465
        ERR_KEYSET = 467
        ERR_CHANNELISFULL = 471
        ERR_UNKNOWNMODE = 472
        ERR_INVITEONLYCHAN = 473
        ERR_BANNEDFROMCHAN = 474
        ERR_BADCHANNELKEY = 475
        ERR_NOPRIVILEGES = 481
        ERR_CHANOPRIVSNEEDED = 482
        ERR_UMODEUNKNOWNFLAG = 501

    End Enum
#End Region

#Region " Propriétés publiques "

    Private pTimeStamp As Date = Now
    ''' <summary>
    ''' Date et heure du message 
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property TimeStamp() As Date
        Get
            Return pTimeStamp
        End Get
    End Property

    ''' <summary>
    ''' Stockage du message brut
    ''' </summary>
    ''' <remarks></remarks>
    Private pRawMessage As String
    ''' <summary>
    ''' Propriété readonly du message brut
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property RawMessage() As String
        Get
            Return pRawMessage
        End Get
    End Property
    ''' <summary>
    ''' Prefixe optionnel du message au format ':nick!user@host'
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property Prefix() As String
        Get
            Dim prefM As Match = Regex.Match(pRawMessage, "^:([^\s]+)\s")
            If prefM.Success Then
                Return prefM.Groups(1).Value
            End If
            Return String.Empty
        End Get
    End Property
#End Region

#Region " Données publique "
    Public AfterCommand As String
    Public senderfull As String
    Public sendernick As String
    Public UserTarget As String
    Public text As String
#End Region

#Region " Données privés "
    ''' <summary>
    ''' Stockage du nom du chan aprés analyse
    ''' </summary>
    ''' <remarks></remarks>
    Private _channel As String = Nothing
    ''' <summary>
    ''' hmmm 
    ''' </summary>
    ''' <remarks></remarks>
    Private pCommandCode As IRCMessageCode = IRCMessageCode.unknown
#End Region
  
    Public IRCMsg As IRCMessage
    ''' <summary>
    ''' Analyse la commande et renvoi son type s'il est numérique - renvoie IRCMessage si non numérique  Cf<see cref=" IRCMsg "></see>
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property CommandCode() As IRCMessageCode
        Get
            Dim cmd As String = Command
            If cmd Is String.Empty Then Return IRCMessageCode.unknown
            If IsNumeric(cmd) Then
                Return [Enum].Parse(GetType(IRCMessageCode), cmd)
            Else
                For Each s As String In [Enum].GetNames(GetType(IRCMessage))
                    If s.ToLower = cmd.ToLower Then
                        IRCMsg = [Enum].Parse(GetType(IRCMessage), cmd)
                        Select Case IRCMsg
                            Case IRCMessage.QUIT, IRCMessage.PRIVMSG, IRCMessage.NOTICE
                                Me.text = AfterCommand.Substring(AfterCommand.IndexOf(":") + 1)
                            Case IRCMessage.KICK
                                Me.text = AfterCommand.Substring(AfterCommand.IndexOf(":") + 1)
                                UserTarget = Split(AfterCommand)(1)
                        End Select
                        Return IRCMessageCode.IRCMessage
                    End If
                Next
            End If
            Return IRCMessageCode.unknown
        End Get
    End Property
    Private pCommand As String = Nothing
    ''' <summary>
    ''' Extrait l'eventuel Envoyeur (Nick et host), et renvoi le premier mot/code qui suit
    ''' </summary>
    ''' <value></value>
    ''' <returns>Commande de la ligne de donnée</returns>
    ''' <remarks></remarks>

    Public ReadOnly Property Command() As String
        Get
            If pCommand IsNot Nothing Then Return pCommand
            Dim prefM As Match = Regex.Match(pRawMessage, "^(?::(?<sender>[^\s]+)\s)?(?<cmd>[^\s]+)\s(?<aftercmd>.*?)$")
            If prefM.Success Then
                If prefM.Groups("sender") IsNot Nothing AndAlso prefM.Groups("sender").Value <> "" Then
                    If prefM.Groups("sender").Value.IndexOf(" ") < 0 Then
                        senderfull = prefM.Groups("sender").Value
                    Else
                        senderfull = prefM.Groups("sender").Value.Substring(0, prefM.Groups("sender").Value.IndexOf(" "))
                    End If

                    If senderfull.IndexOf("!") >= 0 Then
                        sendernick = senderfull.Substring(0, senderfull.IndexOf("!"))
                    Else
                        sendernick = senderfull
                    End If
                End If
                AfterCommand = prefM.Groups("aftercmd").Value
                Return prefM.Groups("cmd").Value
            End If

            Return String.Empty
        End Get
    End Property

#Region " Initialisation / Constructeurs "

    ''' <summary>
    ''' Constructeur sur ligne de message IRC Brute
    ''' </summary>
    ''' <param name="msg"></param>
    ''' <remarks></remarks>
    Public Sub New(ByVal msg As String)
        pRawMessage = msg

    End Sub
#End Region

#Region " Fonctions "

    ''' <summary>
    ''' Analyse du nom de channel 
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks>Se base sur le caractère '#'... peut etre optimisé</remarks>
    Public Function Channel() As String
        If _channel Is Nothing Then
            Dim cstart As Integer = AfterCommand.IndexOf("#")
            If cstart < 0 Then
                _channel = String.Empty
                Return _channel
            End If
            Dim cend As Integer = AfterCommand.IndexOf(" ", cstart)
            If cend = -1 Then cend = AfterCommand.Length
            If cstart = 0 Then cstart = 1
            _channel = Trim(Mid(AfterCommand, cstart, cend - cstart + 1))
            If _channel.StartsWith(":") Then _channel = Right(_channel, _channel.Length - 1)
        End If

        Return _channel
    End Function
    ''' <summary>
    ''' Nom du chan en minuscule
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function LChannel() As String
        Return Channel.ToLower
    End Function
#End Region
End Class
