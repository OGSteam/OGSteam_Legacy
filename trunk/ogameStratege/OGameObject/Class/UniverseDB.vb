Imports System.IO
Imports System.Xml
Imports System.Xml.Serialization


''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : UniverseDB
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Information fichier et options d'une base de données univers
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class UniverseDB

    Private _ServerUrl As String
    Public Property ServerURL() As String
        Get
            Return _ServerUrl
        End Get
        Set(ByVal Value As String)
            _ServerUrl = Value
        End Set
    End Property

    Private p_UniverseName As String
    Public Property UniverseName() As String
        Get
            Return p_UniverseName
        End Get
        Set(ByVal Value As String)
            p_UniverseName = Value
        End Set
    End Property

    Private p_DBFileName As String
    Public Property DBFileName() As String
        Get
            Return p_DBFileName
        End Get
        Set(ByVal Value As String)
            p_DBFileName = Value
        End Set
    End Property
    Private pExportFile As String = ""
    Public Property ExportFile() As String
        Get
            Return pExportFile
        End Get
        Set(ByVal Value As String)
            pExportFile = Value
        End Set
    End Property
    Private pImportFile As String = ""
    Public Property ImportFile() As String
        Get
            Return pImportFile
        End Get
        Set(ByVal Value As String)
            pImportFile = Value
        End Set
    End Property
    Public DefaultUniverse As Boolean = False
    Public MyPlayerID As Integer = 0
    Public Enum enDefaultValue
        Yes
        No
        Ask
    End Enum
    Public PlayerChangeDetectionKeepData As enDefaultValue = enDefaultValue.Ask
    Public OgameAccounts As New OgameAccountInfoCol
    Public RemoteAccounts As New RemoteAccountCol
    Public map_ShowRank As Boolean = False
    Public map_ShowSpy As Boolean = False
    Public map_ShowSpyNumber As String = "24"
    Public map_ShowAttack As Boolean = False
    Public map_ShowAttackNumber As String = "24"
    Public map_ShowLargeCargo As Boolean = False
    Public map_ShowLargeCargoNumber As String = "20"
    Public map_ShowRecycler As Boolean = False
    Public map_ShowRecyclerNumber As String = "20"

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Langage des templates de détection de l'univers
    ''' </summary>
    ''' <remarks>
    ''' Par defaut FR
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	28/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public template_lang As String = "fr"

    Public Overrides Function ToString() As String
        Return UniverseName & " (" & ServerURL & ") "
    End Function
    ''' <summary>
    ''' Sauvegarde des infos univers (incluant les comptes)
    ''' </summary>
    ''' <remarks></remarks>
    Public Sub Save()
        Dim thecol As UniversesDBCol = UniversesDBCol.Load
        Dim newcol As New UniversesDBCol
        For Each udb As UniverseDB In thecol

            If udb.DBFileName = Me.DBFileName Then
                udb = Me
            End If
            newcol.Add(udb)
        Next
        newcol.Save()
    End Sub
    ''' <summary>
    ''' Mise à jour des données d'un compte et sauvegarde
    ''' </summary>
    ''' <param name="Racc">Le compte à metre a jour</param>
    ''' <remarks>Se base sur le FriendlyName pour reconnaitre le compte</remarks>
    Public Sub UpdateAccountAndSave(ByVal Racc As RemoteAccount)
        For i As Integer = 0 To RemoteAccounts.Count - 1
            If Me.RemoteAccounts(i).FriendlyName = Racc.FriendlyName Then
                Me.RemoteAccounts(i) = Racc
                Exit For
            End If
        Next
        Save()
    End Sub
End Class






