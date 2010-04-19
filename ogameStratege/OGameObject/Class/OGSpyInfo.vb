Imports System.Text.RegularExpressions
''' <summary>
''' Classe de stockage des informations des droits OGSpy au Login
''' </summary>
''' <remarks></remarks>
Public Class OGSpyInfo
    Public IsConnected As Boolean = False
    Public ExportSysAuth As Boolean = False
    Public ImportSysAuth As Boolean = False
    Public ExportSpyAuth As Boolean = False
    Public ImportSpyAuth As Boolean = False
    Public ExportRankAuth As Boolean = False
    Public ImportRankAuth As Boolean = False
    Public ErrorString As String
    Public ServerName As String
    Public ServerVersion As String

    ''' <summary>
    ''' Fonction de detection des droits et de connexion
    ''' </summary>
    ''' <param name="HTMLString">La page HTML du login</param>
    ''' <remarks></remarks>
    Public Sub analyse(ByVal HTMLString As String)
        reset()
        Try
            If HTMLString.IndexOf(My.Resources.ogspy_loginfailed) > 0 Then
                IsConnected = False
                ErrorString = "OGSpy login failed:" & My.Resources.ogspy_loginfailed
            ElseIf HTMLString.IndexOf(My.Resources.ogspy_loginsuccess) < 0 Then
                ErrorString = "OGSpy login tag not found"
                Exit Sub
            End If

            IsConnected = True

            Dim m As Match = Regex.Match(HTMLString, My.Resources.ogspy_info_regx, RegexOptions.IgnorePatternWhitespace Or RegexOptions.Multiline Or RegexOptions.Singleline)
            If Not m.Success Then
                ErrorString = "Erreur lors de la lecture des informations de droits"
                Exit Sub
            End If
            With m
                ServerName = .Groups("servername").Value
                ServerVersion = .Groups("serverVersion").Value
                ExportSysAuth = (.Groups("ExportSysAuth").Value = "1")
                ImportSysAuth = (.Groups("ImportSysAuth").Value = "1")
                ExportSpyAuth = (.Groups("ExportSpyAuth").Value = "1")
                ImportSpyAuth = (.Groups("ImportSpyAuth").Value = "1")

                ExportRankAuth = (.Groups("ExportRankAuth").Value = "1")
                ImportRankAuth = (.Groups("ImportRankAuth").Value = "1")
            End With


        Catch ex As Exception
            IsConnected = False
            ErrorString = ex.Message
        End Try

    End Sub

    ''' <summary>
    ''' Force les Valeurs par défaut / 0
    ''' </summary>
    ''' <remarks></remarks>
    Protected Sub reset()
        IsConnected = False
        ExportSysAuth = False
        ImportSysAuth = False
        ExportSpyAuth = False
        ImportSpyAuth = False
        ExportRankAuth = False
        ImportRankAuth = False
        ErrorString = String.Empty
        ServerName = String.Empty
        ServerVersion = String.Empty
    End Sub
End Class
