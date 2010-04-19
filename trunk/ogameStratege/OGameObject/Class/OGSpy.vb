Imports FirebirdSql.Data.FirebirdClient
Imports System.io
Imports System.net
''' <summary>
''' Classe de communication avec OGSPY 0.302 +
''' </summary>
''' <remarks>
''' todo: Implémentation du proxy
''' </remarks>
Public Class OGSpy
    Private UserAgent As String = "OGSClient " & System.Windows.Forms.Application.ProductVersion & " (" & OGameDBEngine.OGSVersion & ")"
    Public request As System.Net.HttpWebRequest
    Public response As System.Net.HttpWebResponse
    Public Shared proxyurl As String = ""
    Public cookies As CookieContainer = Nothing
    Private pLastPageReadedData As String = ""

    ''' <summary>
    ''' Resultat du dernier accés web
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property LastPageReadedData() As String
        Get
            Return pLastPageReadedData
        End Get
    End Property

#Region " Login / Logout "


    Public Sub Login()
        pOGSpyInfo = New OGSpyInfo
        cookies = New CookieContainer
        PostURL(URL & "?action=login&name=" & AccountName & "&ogsversion=" & OGameDBEngine.OGSVersion, "pass=" & AccountPassword)
        Console.WriteLine("Keepalive:" & request.KeepAlive)
        request.KeepAlive = Not request.KeepAlive
        pOGSpyInfo.analyse(LastPageReadedData)

    End Sub
    ''' <summary>
    ''' Se connecte au serveur OGSPY avec les données passer en paramètres
    ''' </summary>
    ''' <param name="vUrl">URL du serveur OGSpy</param>
    ''' <param name="vAccName">Nom</param>
    ''' <param name="vAccPassword">Mot de passe</param>
    ''' <remarks></remarks>
    Public Sub Login(ByVal vUrl As String, ByVal vAccName As String, ByVal vAccPassword As String)
        URL = vUrl
        AccountName = vAccName
        AccountPassword = vAccPassword
        Login()
    End Sub

    Public Sub Login(ByVal RemoteAcc As RemoteAccount)
        If RemoteAcc Is Nothing Then Throw New Exception("Impossible de se connecter à OGSpy : Le compte distant est nul")
        RemoteAccount = RemoteAcc
        Login()
    End Sub

#End Region

#Region " Informations de compte "

    Private pRemoteAccount As RemoteAccount
    Public Property RemoteAccount() As RemoteAccount
        Get
            If pRemoteAccount Is Nothing Then
                pRemoteAccount = New RemoteAccount
            End If
            Return pRemoteAccount
        End Get
        Set(ByVal value As RemoteAccount)
            pRemoteAccount = value
        End Set
    End Property
    Private pURL As String
    ''' <summary>
    ''' URL du serveur OGSPY
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property URL() As String
        Get
            Return RemoteAccount.OGSServerURL.Trim
        End Get
        Set(ByVal value As String)
            RemoteAccount.OGSServerURL = Trim(value)
        End Set
    End Property


    Private pAccountName As String
    ''' <summary>
    ''' Nom de login
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property AccountName() As String
        Get
            Return Me.RemoteAccount.LoginName
        End Get
        Set(ByVal value As String)
            Me.RemoteAccount.LoginName = value
        End Set
    End Property

    Private pAccountPassword As String
    Public Property AccountPassword() As String
        Get
            Return Me.RemoteAccount.Password
        End Get
        Set(ByVal value As String)
            Me.RemoteAccount.Password = value
        End Set
    End Property
#End Region


    Private pOGSpyInfo As OGSpyInfo
    ''' <summary>
    ''' Info récupéré lors du login a OGSPY, Droits et versions
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public ReadOnly Property Info() As OGSpyInfo
        Get
            If pOGSpyInfo Is Nothing Then pOGSpyInfo = New OGSpyInfo
            Return pOGSpyInfo
        End Get
    End Property

#Region " Importation et Exportation des rapports d'espionages "
    Protected Function ImportReportSince(ByVal sincedate As Date) As Boolean
        If Not Info.IsConnected Then Login()
        Return PostURL(URL & "?action=spyreport&since=" & sincedate.ToString("yyyy-MM-dd HH:mm:ss"), "").IndexOf("Denied") < 0
    End Function
    Public Sub ImportReport(ByVal sincedate As Date)
        ImportReportSince(sincedate)
        Dim mc As System.Text.RegularExpressions.MatchCollection = OGameObject.PlanetRegx.SpyingReportMC(LastPageReadedData)
        If mc.Count AndAlso Not OGameObject.OGameDBEngine.Default Is Nothing Then
            OGameObject.Sound.PlayWaveResource("scifi011.wav")
            Dim savedefaultsender As String = OGameObject.SpyReport.DefaultDataSender
            savedefaultsender = "Server Import"
            For Each s As OGameObject.SpyReport In OGameObject.PlanetRegx.SpyingReportCol(mc)
                'AddExportImportLogEntry("Spy report for " & s.Planet.Coords & " on " & s.DataDate)
            Next
            OGameObject.SpyReport.DefaultDataSender = savedefaultsender
        End If
        '        RaiseEvent MessageEvent(mc.Count & " spying reports imported", OGameObject.Functions.enOGSEventType.Import_Stats)
    End Sub
    Public Function PostSpyReports(ByVal RawData As String) As Boolean
        If Not Info.IsConnected Then Login()
        Return PostURL(URL & "?action=postspyingreports", RawData).IndexOf("[login=0]") = -1
    End Function
#End Region
#Region " Importation/Exportation Stats "
    ''' <summary>
    ''' Recupère le texte des statistiques connus d'un serveur ogspy
    ''' </summary>
    ''' <param name="theDate"></param>
    ''' <param name="StatsType">points,flotte ou research</param>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function ImportStats(ByVal theDate As Date, ByVal StatsType As String) As String
        '        case "points": $ranktable = TABLE_RANK_PLAYER_POINTS; break;
        '        case "flotte": $ranktable = TABLE_RANK_PLAYER_FLEET; break;
        '        case "research": $ranktable = TABLE_RANK_PLAYER_RESEARCH; break;
        If Not Info.IsConnected Then Login()
        Return PostURL(URL & "?action=getstats_player", "date=" & theDate.ToString("yyyy-MM-dd HH:mm:ss") & "&type=" & StatsType)
    End Function
    ''' <summary>
    '''  Envoi des statistiques sur le serveur ogspy
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function ExportStats(ByVal StatsString As String, ByVal StatsType As String) As Boolean
        If Not Info.IsConnected Then Login()
        Dim exportsurl As String = "?action=postrank" & StatsType & "_player"
        Return PostURL(URL & exportsurl, "data=" & StatsString).IndexOf("Merci") > 0
    End Function
#End Region
#Region " Importation / Exportation Systeme/Galaxie "
    ''' <summary>
    ''' L'accés aux données d'importation sur ogspy
    ''' </summary>
    ''' <param name="galnum"></param>
    ''' <param name="sincedate"></param>
    ''' <returns></returns>
    ''' <remarks></remarks>


    Public Function ImportNew(ByVal galnum As String, ByVal sincedate As Date) As Boolean
        If Not Info.IsConnected Then Login()
        Return PostURL(URL & "?action=fbimport&galnum=" & galnum & "&sincedate=" & sincedate.ToString("yyyy-MM-dd HH:mm:ss"), "").IndexOf("Login=0") < 0
    End Function

    ''' <summary>
    ''' Interroge OGSPY pour importation de planètes et 
    ''' Renvoie une chaine correspondant au texte preformaté comme table externe
    ''' de Firebird T_EXTERNAL2.TPL.SQL à partir du format d'OGSpy 0.302
    ''' </summary>
    ''' <param name="galnum">Numéro de galaxie importé</param>
    ''' <param name="sincedate">Date de début de récupération des données</param>
    ''' <returns>Chaine préformaté</returns>
    ''' <remarks></remarks>
    Public Function PreFormattedOGSpyImportFileContent(ByVal galnum As String, ByVal sincedate As Date) As String
        If Not ImportNew(galnum, sincedate) Then Return String.Empty
        Dim Content As New System.Text.StringBuilder
        Dim ogspyP As New OGSpyProtocol
        ogspyP.HTMLData = LastPageReadedData
        For Each row As Collections.Generic.List(Of String) In ogspyP.Items
            If row.Count = ogspyP.Fields.Count Then
                Content.Append(row(ogspyP.Fields("galaxy") - 1))
                Content.Append(row(ogspyP.Fields("system") - 1).PadLeft(3, "0"))
                Content.Append(row(ogspyP.Fields("row") - 1).PadLeft(3, "0"))
                Content.Append(IIf(row(ogspyP.Fields("moon") - 1) = "M", "1", "0"))
                Content.Append(row(ogspyP.Fields("planetname") - 1).PadRight(25, " "))
                Content.Append(row(ogspyP.Fields("playername") - 1).PadRight(50, " "))
                Content.Append(row(ogspyP.Fields("allytag") - 1).PadRight(20, " "))
                Content.Append(IIf(row(ogspyP.Fields("status") - 1).Contains("i"), "1", "0"))
                Content.Append(IIf(row(ogspyP.Fields("status") - 1).Contains("I"), "1", "0"))
                Content.Append(IIf(row(ogspyP.Fields("status") - 1).Contains("b"), "1", "0"))
                Content.Append(IIf(row(ogspyP.Fields("status") - 1).Contains("v"), "1", "0"))
                Content.Append(IIf(row(ogspyP.Fields("status") - 1).Contains("d"), "1", "0"))
                Content.Append(row(ogspyP.Fields("datetime") - 1).PadRight(19, " "))
                Content.Append(row(ogspyP.Fields("sendername") - 1).PadRight(30, " "))
                Content.Append(vbCrLf)
            End If
        Next
        Return Content.ToString
    End Function
    ''' <summary>
    ''' Importation des stats et mise en base de donnée
    ''' </summary>
    ''' <param name="_date">Date de la statistique</param>
    ''' <param name="typestat">points,flotte,research</param>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function ImportStatsAndInsert(ByVal _date As Date, ByVal typestat As String) As Boolean
        OGameDBEngine.NewEventInformation("Importation des statistiques (" & typestat & ") du " & _date.ToShortDateString, enOGSEventType.Import_Stats)
        ImportStats(_date, typestat)
        Dim ogspyP As New OGSpyProtocol
        ogspyP.HTMLData = LastPageReadedData
        Dim minstat, maxstat As Integer
        minstat = -1
        maxstat = -1
        Dim countstat As Integer = 0
        For Each row As Collections.Generic.List(Of String) In ogspyP.Items
            If row.Count = ogspyP.Fields.Count Then
                If minstat = -1 Then minstat = row(ogspyP.Fields("rank") - 1)
                If maxstat = -1 Then maxstat = row(ogspyP.Fields("rank") - 1)
                countstat += 1
                If minstat > row(ogspyP.Fields("rank") - 1) Then minstat = row(ogspyP.Fields("rank") - 1)
                If maxstat < row(ogspyP.Fields("rank") - 1) Then maxstat = row(ogspyP.Fields("rank") - 1)
                PlayerRank.FromOgspy302(row(ogspyP.Fields("playername") - 1), _
                                        row(ogspyP.Fields("allytag") - 1), _
                                        row(ogspyP.Fields("rank") - 1), _
                                        row(ogspyP.Fields("points") - 1), _
                                        typestat, _
                                        row(ogspyP.Fields("sendername") - 1), _
                                        ogspyP.Fields("datetime"))
            End If
        Next
        OGameDBEngine.NewEventInformation("--> " & countstat & " stats (de " & minstat & " à " & maxstat & ")", enOGSEventType.Import_Stats)
        Return True
    End Function
    ''' <summary>
    ''' Protocoled OGSPY 0.302 - Header (1ere ligne ) spécifiant les données envoyés
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Protected Function ExportPlanetsHeader() As String
        Return "data=galaxy=1,system=2,row=3,moon=4,planetname=5,playername=6,allytag=7,status=8,datetime=9,sendername=10"
    End Function

    Public Event ExportedPlanet(ByVal ogspy As OGSpy, ByVal message As String)
    ''' <summary>
    '''  Envoi des données Planètes
    ''' </summary>
    ''' <param name="thetime">Date minimum à partir de laquelle on envoie les données</param>
    ''' <param name="Gal">Galaxie(x) sous forme ce chaine de caractères</param>
    ''' <remarks></remarks>
    Public Sub ExportPlanets(ByVal thetime As DateTime, ByVal Gal As String)
        If Not Info.IsConnected Then Login()
        For i As Integer = 1 To 9
            If Gal.Contains(CStr(i)) Then

                Dim ExportData As String = ExportPlanetsHeader()
                With OGameDBEngine.Default
                    Dim query As String = "DROP PROCEDURE EXPORT_TRANSFERT;"

                    Dim cmd As FbCommand = OGameDBEngine.Default.DBConnection.CreateCommand

                    Try

                        cmd.CommandText = query
                        cmd.ExecuteNonQuery()

                    Catch ex As Exception
                        'ShowException(ex, "Suppression procedure stocké")
                        Console.WriteLine("Suppression procedure stocké : EXPORT_TRANSFERT")
                    End Try
                    'DBConnection.

                    Try

                        OGameDBEngine.Default.SQLScript(TextFileResource("PROC_EXPORT.SQL"))
                    Catch ex As Exception
                        'ShowException(ex, "Création procedure stocké")
                        Console.WriteLine("Creation procedure stocké : EXPORT_TRANSFERT")
                    End Try

                    'La requête proprement dites
                    Try

                        RaiseEvent ExportedPlanet(Me, "Galaxie " & i & " :Interrogation de la base de données..")
                        cmd.CommandText = "SELECT * FROM EXPORT_TRANSFERT(@sincedate,@gal_required)"
                        'Console.WriteLine("Requète:" & cmd.CommandText)
                        cmd.CommandType = CommandType.StoredProcedure
                        cmd.Parameters.Add("@sincedate", FbDbType.TimeStamp).Direction = ParameterDirection.Input
                        cmd.Parameters.Add("@gal_required", FbDbType.Integer).Direction = ParameterDirection.Input
                        cmd.Parameters(0).Value = thetime
                        cmd.Parameters(1).Value = i

                        Dim re As FbDataReader = cmd.ExecuteReader
                        're.
                        With re
                            Dim chunk As Int16 = 0

                            While (.Read)

                                If .Item("dataline") IsNot DBNull.Value AndAlso CStr(.Item("dataline")).Trim.Length > 0 Then
                                    chunk += 1

                                    ExportData &= "<->" & .Item("dataline")
                                    If chunk >= RemoteAccount.MaxPlanetCountChunk Then
                                        PostURL(URL & "?action=postplanets", ExportData)
                                        RaiseEvent ExportedPlanet(Me, chunk & " planètes envoyés." & vbCrLf & LastPageReadedData)
                                        chunk = 0
                                        ExportData = ExportPlanetsHeader()
                                    End If
                                End If
                            End While
                            If chunk <> 0 Then
                                PostURL(URL & "?action=postplanets", ExportData)
                                RaiseEvent ExportedPlanet(Me, chunk & " planètes envoyés." & vbCrLf & LastPageReadedData)
                                chunk = 0
                            End If
                            .Close()

                        End With
                    Catch ex As Exception
                        ShowException(ex, "Exportation Systeme")
                    End Try
                    cmd.Dispose()
                End With
            End If
        Next
    End Sub
#End Region

#Region " Statistiques "
    Public Function GetStatsAvailable() As OGSpyStatCol
        Dim ogspStatCol As New OGSpyStatCol
        ogspStatCol.CreateFromAnswer(GetStatsInfo)
        Return ogspStatCol
    End Function
    Public Function GetStatsInfo() As String
        If Not Info.IsConnected Then Login()
        Return PostURL(URL & "?action=getstatsinfo_player", "")
    End Function
#End Region
#Region " Privé "
    Private Shared Function StrToByteArray(ByVal str As String) As Byte()
        Dim encoding As System.Text.Encoding = System.Text.Encoding.GetEncoding("iso8859-1")
        Return encoding.GetBytes(str)
    End Function
#End Region

#Region " POST/GET "
    ''' <summary>
    ''' Accés WEB via la méthode HTTP POST 
    ''' </summary>
    ''' <param name="PostedURL">L'URL complète</param>
    ''' <param name="PostDATA">Les données transmises</param>
    ''' <param name="ContentType"></param>
    ''' <returns></returns>
    ''' <remarks>25/05 Rica Gestion Exception via ShowException</remarks>
    Public Function PostURL(ByVal PostedURL As String, ByVal PostDATA As String, Optional ByVal ContentType As String = "application/x-www-form-urlencoded") As String
        request = WebRequest.Create(PostedURL)
        request.CookieContainer = cookies
        request.UserAgent = UserAgent
        request.KeepAlive = False
        request.Method = "POST"
        request.ContentType = IIf(ContentType IsNot Nothing, ContentType, "application/x-www-form-urlencoded")
        request.ContentLength = PostDATA.Length
        If proxyurl.Length > 0 Then
            request.Proxy = New WebProxy(proxyurl, True)
        End If
        Try

            Dim myWriter As Stream = request.GetRequestStream
            myWriter.Write(StrToByteArray(PostDATA), 0, PostDATA.Length)
            myWriter.Flush()
            myWriter.Close()
            request.GetRequestStream().Close()
        Catch e1 As Exception
            ShowException(e1, "POSTURL (GetRequestStream): " & PostedURL)
        End Try
        Try
            response = request.GetResponse
            cookies.Add(response.Cookies)
            pLastPageReadedData = Str4Strm(response.GetResponseStream)
            Return pLastPageReadedData
        Catch ex As Exception
            ShowException(ex, "POSTURL (GetResponse) :")
        End Try
        Return ""
    End Function
    Public Function GetURL(ByVal GettedURL As String, Optional ByVal DebugPageName As String = "") As String

        Try

            request = WebRequest.Create(GettedURL)
            request.UserAgent = Me.UserAgent
            request.KeepAlive = True
            request.CookieContainer = cookies
            If proxyurl.Length > 0 Then
                request.Proxy = New WebProxy(proxyurl, True)
            End If
        Catch ex As Exception
            System.Windows.Forms.MessageBox.Show(ex.Message & vbCrLf & ex.StackTrace)
        End Try

        Try
            response = request.GetResponse
            cookies.Add(response.Cookies)

            pLastPageReadedData = (Str4Strm(response.GetResponseStream))
            Return pLastPageReadedData
        Catch ex As Exception

            System.Windows.Forms.MessageBox.Show(ex.Message & vbCrLf & ex.StackTrace)
        End Try
        Return ""
    End Function
#End Region
#Region " Constructeurs "

    ''' <summary>
    ''' Constructeur par defaut
    ''' </summary>
    ''' <remarks></remarks>
    Public Sub New()

    End Sub
    ''' <summary>
    ''' Constructeur spécifique sur un RemoteAccount
    ''' </summary>
    ''' <param name="vRemoteAccount"></param>
    ''' <remarks></remarks>
    Public Sub New(ByVal vRemoteAccount As RemoteAccount)
        If vRemoteAccount Is Nothing Then Throw New Exception("Impossible de se connecter à OGSpy : Le compte distant est nul")
        URL = vRemoteAccount.OGSServerURL
        AccountName = vRemoteAccount.LoginName
        AccountPassword = vRemoteAccount.Password
    End Sub
#End Region
End Class
