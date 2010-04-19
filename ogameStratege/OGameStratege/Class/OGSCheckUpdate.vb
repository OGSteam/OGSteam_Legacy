Imports System.Net
Imports System.Xml
Imports System.Xml.XPath


''' -----------------------------------------------------------------------------
''' Project	 : OGameStratege
''' Class	 : OGSCheckUpdate
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Verification de la présence de mise a jour d'OGS
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	27/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class OGSCheckUpdate
    Private UserAgent As String = "OGSClient " & System.Windows.Forms.Application.ProductVersion & " (" & OGameObject.OGameDBEngine.OGSVersion & ")"

    Public request As System.Net.HttpWebRequest
    Public response As System.Net.HttpWebResponse

    Public cookies As CookieContainer = New CookieContainer
    Private pLastPageReadedData As String = ""
    Private last_releasenode As XmlNode
    
    Public ReadOnly Property LastReleaseInfo(ByVal info As String) As String
        Get
            If Not last_releasenode Is Nothing Then
                Dim infonode As XmlNode = last_releasenode.SelectSingleNode("//" & info.ToLower)
                If Not infonode Is Nothing Then
                    Return infonode.InnerText
                End If

            End If
            Return ""
        End Get
    End Property
    Public Function LastReleaseDataString() As String
        Dim retval As String = ""
        retval &= "Description : " & LastReleaseInfo("description") & vbCrLf
        retval &= "Last Version : " & LastReleaseInfo("version") & vbCrLf
        retval &= "Internal Version : " & LastReleaseInfo("internalversion") & vbCrLf
        retval &= "Board Thread : " & LastReleaseInfo("boardthread") & vbCrLf
        retval &= "Archive Size : " & LastReleaseInfo("archivesize") & vbCrLf

        Return retval

    End Function
    Public Event InfoUpdateDone(ByVal sender As Object)
    Public Sub CheckUpdate(Optional ByVal threaded As Boolean = False)
        If Not threaded Then
            doCheckUpdate(Nothing)
        Else
            System.Threading.ThreadPool.QueueUserWorkItem(AddressOf Me.doCheckUpdate)
        End If
    End Sub
    Public Sub doCheckUpdate(ByVal state As Object)
        Try
            'if threaded then
            Dim s As String = GetURL(MainForm.TopForm.Config.URLOGSCheckUpdate)
            Dim xDoc As New XmlDocument
            xDoc.LoadXml(s)
            'Dim olist As XmlNodeList = xDoc.SelectNodes("/")
            last_releasenode = xDoc.SelectSingleNode("//ogswin/lastrelease")
            ' Dim OGSSLastRelease As XmlNode = xDoc.SelectSingleNode("//ogss/lastrelease")
            RaiseEvent InfoUpdateDone(Me)
            'xdoc.d
        Catch ex As Exception
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
        End Try

    End Sub
    Public Function GetURL(ByVal GettedURL As String, Optional ByVal DebugPageName As String = "") As String

        Try

            request = WebRequest.Create(GettedURL)
            request.UserAgent = Me.UserAgent
            request.KeepAlive = True
            request.CookieContainer = cookies
        Catch ex As Exception
            System.Windows.Forms.MessageBox.Show(ex.Message & vbCrLf & ex.StackTrace)
        End Try

        Try
            response = request.GetResponse
            cookies.Add(response.Cookies)

            pLastPageReadedData = (OGameObject.Str4Strm(response.GetResponseStream))
            ' RaiseEvent InfoUpdateDone(Me)
            Return pLastPageReadedData
        Catch ex As Exception
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
        End Try
        Return ""
    End Function


End Class
