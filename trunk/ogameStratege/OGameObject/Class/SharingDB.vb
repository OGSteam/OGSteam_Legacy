Imports System.IO
Imports System.Net

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : SharingDB
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Interface avec OGSpy
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class SharingDB
    Private UserAgent As String = "OGSClient " & System.Windows.Forms.Application.ProductVersion & " (" & OGameDBEngine.OGSVersion & ")"

    Public request As System.Net.HttpWebRequest
    Public response As System.Net.HttpWebResponse
    Public Shared proxyurl As String = ""
    Public cookies As CookieContainer = Nothing
    Private pLastPageReadedData As String = ""
    Public ReadOnly Property LastPageReadedData() As String
        Get
            Return pLastPageReadedData
        End Get
    End Property

    Public URL As String
    Public LoginName As String
    Public LoginPass As String
    Private plogged As Boolean = False
    Public Property Logged() As Boolean
        Get
            Return plogged
        End Get
        Set(ByVal Value As Boolean)
            If Value <> plogged Then
                If Value Then
                    Login()
                Else
                    'Logout()
                End If
                plogged = Value
            End If
        End Set
    End Property

    Public servername As String = ""
    Public serverversion As String = ""
    Public authorized_toimport As Boolean = False
    Public authorized_toexport As Boolean = False

    Public Function Login() As Boolean
        authorized_toexport = False
        authorized_toimport = False
        plogged = False
        cookies = New CookieContainer
        If Trim(PostURL(URL & "?action=login&name=" & LoginName & "&ogsversion=" & OGameDBEngine.OGSVersion, "pass=" & Me.LoginPass)).Replace(vbCr, "").IndexOf("OGame Stratege SharingDB") > -1 Then

            authorized_toexport = LastPageReadedData.IndexOf("You are authorised to export to the server") > -1
            authorized_toimport = LastPageReadedData.IndexOf("You are authorised to import from the server ") > -1

            Dim patternserver As String = "(?:<!--\s*Servername\s*=\s*(?<ServerName>[^>]*)\s*-->)"
            With System.Text.RegularExpressions.Regex.Match(LastPageReadedData, patternserver)
                If .Success Then
                    servername = .Groups("ServerName").Value
                End If

            End With
            patternserver = "(?:<!--\s*ServerVersion\s*=\s*(?<ServerVersion>[^>]*)\s*-->)"
            With System.Text.RegularExpressions.Regex.Match(LastPageReadedData, patternserver)
                If .Success Then
                    serverversion = .Groups("ServerVersion").Value
                End If

            End With
            plogged = True
            Return True
        End If
        plogged = False
        Return False
    End Function

    Public Function GetStatsInfo() As String
        If Not plogged Then Login()
        Return PostURL(URL & "?action=getstatsinfo", "")
    End Function
    Public Enum enTypeStat
        points
        flotte
        research
    End Enum
    Public Function POST(ByVal action As String, ByVal postdata As String) As String
        Return PostURL(URL & "?action=" & action, _
                        postdata)
    End Function
    Public Function GetstatsFromDateString(ByVal WhichDate As String, ByVal typestat As enTypeStat) As String
        If Not plogged Then Login()
        Dim stat As String = ""
        Select Case typestat
            Case enTypeStat.flotte
                stat = "flotte"
            Case enTypeStat.points
                stat = "points"
            Case enTypeStat.research
                stat = "research"
        End Select
        Return PostURL(URL & "?action=getstats", _
                "date=" & WhichDate & "&type=" & stat)
    End Function

    Public Function Getstats(ByVal WhichDate As Date, ByVal typestat As enTypeStat) As String
        If Not plogged Then Login()
        Dim stat As String = ""
        Select Case typestat
            Case enTypeStat.flotte
                stat = "flotte"
            Case enTypeStat.points
                stat = "points"
            Case enTypeStat.research
                stat = "research"
        End Select
        Return PostURL(URL & "?action=getstats", _
                "date=" & WhichDate.ToString("yyyy-MM-dd HH:mm:ss") & "&type=" & stat)
    End Function
    'public function 
    Public Function ImportReportFor(ByVal galnum As Integer, ByVal sysnum As Integer, ByVal PlanetNum As Integer, Optional ByVal Count As Integer = 20) As String
        If Not plogged Then Login()
        Return PostURL(URL & "?action=reportsfor&galnum=" & galnum & "&sysnum=" & sysnum & "&num=" & PlanetNum & "&count=" & Count, "")
    End Function
    Public Function LastGalaxyReports(ByVal galnum As Integer, ByVal sysnum As Integer) As String
        If Not plogged Then Login()
        Return PostURL(URL & "?action=reportsforsystem&galnum=" & galnum & "&sysnum=" & sysnum, "")
    End Function

    Public Function ImportReportSince(ByVal sincedate As String) As Boolean
        If Not plogged Then Login()
        Return PostURL(URL & "?action=spyreport&since=" & sincedate, "").IndexOf("Denied") < 0
    End Function
    Public Function ImportNew(Optional ByVal galnum As String = "", Optional ByVal sysnum As String = "", Optional ByVal sincedate As String = "") As Boolean
        If Not plogged Then Login()
        Return PostURL(URL & "?action=fbimport&galnum=" & galnum & "&sysnum=" & "&sincedate=" & sincedate, "").IndexOf("Denied") < 0
    End Function
    Public Function ImportGalaxyNumber(ByVal gal As Integer, ByVal sincedate As String) As Boolean
        If Not plogged Then Login()
        Return PostURL(URL & "?action=updatedgalaxy", "galnum=" & gal & "&sincedate=" & sincedate).IndexOf("Denied") < 0
    End Function
    Public Function ImportGalaxy(ByVal gal As Integer, ByVal sys As Integer) As Boolean
        If Not plogged Then Login()
        Return PostURL(URL & "?action=importgalaxy", "gal=" & gal & "&sys=" & sys).IndexOf("Denied") < 0
    End Function
    Public Function PostPlanetsXML(ByVal xml As String) As Boolean
        If Not plogged Then Login()
        Return PostURL(URL & "?action=postplanets", xml, Nothing).IndexOf("Thanks") > -1

    End Function
    Public Function PostSpyReports(ByVal RawData As String) As Boolean
        If Not plogged Then Login()
        Return PostURL(URL & "?action=postspyingreports", RawData, Nothing).IndexOf("Thanks") > -1
    End Function
    Public Function PostRankPoints(ByVal rawdata As String) As Boolean
        If Not plogged Then Login()
        Return PostURL(URL & "?action=postrankpoints", rawdata, Nothing).IndexOf("Thanks") > -1
    End Function
    Public Function PostRankFlotte(ByVal rawdata As String) As String
        If Not plogged Then Login()
        Return PostURL(URL & "?action=postrankflotte", rawdata, Nothing).IndexOf("Thanks") > -1
    End Function
    Public Function PostRankResearch(ByVal rawdata As String) As String
        If Not plogged Then Login()
        Return PostURL(URL & "?action=postrankresearch", rawdata, Nothing).IndexOf("Thanks") > -1
    End Function
    'Public Function GetUniverseList() As Collections.Specialized.StringCollection
    '    Dim Universes() As String = Split(GetURL(URL & "?action=universelist"), vbLf)
    '    Dim retval As New Collections.Specialized.StringCollection
    '    For Each s As String In Universes
    '        If (Trim(s) <> "") Then retval.Add(Trim(s))
    '    Next
    '    Return retval
    'End Function
    Public Shared Function StrToByteArray(ByVal str As String) As Byte()
        Dim encoding As System.Text.Encoding = System.Text.Encoding.GetEncoding("iso8859-1")
        Return encoding.GetBytes(str)
    End Function
    Private CurrentlyLogin As Boolean = True
    Public Function PostURL(ByVal PostedURL As String, ByVal PostDATA As String, Optional ByVal ContentType As String = "application/x-www-form-urlencoded") As String
        request = WebRequest.Create(PostedURL)
        request.CookieContainer = cookies
        request.UserAgent = UserAgent
        request.KeepAlive = False
        request.Method = "POST"
        request.ContentType = ContentType '"application/x-www-form-urlencoded"
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
            System.Windows.Forms.MessageBox.Show(e1.Message & vbCrLf & e1.StackTrace)

        End Try
        Try
            response = request.GetResponse

            cookies.Add(response.Cookies)
            pLastPageReadedData = Str4Strm(response.GetResponseStream)
            Return pLastPageReadedData
        Catch ex As Exception
            System.Windows.Forms.MessageBox.Show(ex.Message & vbCrLf & ex.StackTrace)
        End Try
        Return ""
    End Function
    Public Function GetURL(ByVal GettedURL As String, Optional ByVal DebugPageName As String = "") As String

        Try

            request = WebRequest.Create(GettedURL)
            request.UserAgent = Me.UserAgent
            request.KeepAlive = False
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

End Class
