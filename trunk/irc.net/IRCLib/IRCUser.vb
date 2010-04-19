''' <summary>
''' Utilisateur identifié sur un canal IRC
''' </summary>
''' <remarks></remarks>
Public Class IRCUser

    Private pLastEventDT As Date = Now
    Public Property LastEventDT() As Date
        Get
            Return pLastEventDT
        End Get
        Set(ByVal value As Date)
            pLastEventDT = value
        End Set
    End Property

    Private pLastEventMsg As IrcRawMsg
    Public Property LastEventMsg() As IrcRawMsg
        Get
            Return pLastEventMsg
        End Get
        Set(ByVal value As IrcRawMsg)
            pLastEventMsg = value
            LastEventDT = Now
        End Set
    End Property

    Private pUserHost As String
    Public Property UserHost() As String
        Get
            Return pUserHost
        End Get
        Set(ByVal value As String)
            pUserHost = value
        End Set
    End Property

    Public Function IsOped() As Boolean
        Return Nick.StartsWith("@")
    End Function
    Public Function IsVoiced() As Boolean
        Return Nick.StartsWith("+")
    End Function
    Private pNick As String
    Public Property Nick() As String
        Get
            Return pNick
        End Get
        Set(ByVal value As String)
            pNick = value
        End Set
    End Property

    Public Overrides Function ToString() As String
        Return Nick
    End Function

    Public Sub New(ByVal iNick As String)
        Nick = iNick
    End Sub

End Class


