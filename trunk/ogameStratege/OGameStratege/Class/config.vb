
Imports System.IO
Imports System.Xml.Serialization
Imports System.ComponentModel


''' -----------------------------------------------------------------------------
''' Project	 : OGameStratege
''' Class	 : Config
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Interface sur le fichier de configuration d'OGS
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	27/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class Config
    Public Enum enDefaultAnswer
        Yes
        No
        Ask
    End Enum
    Public Function XMLSerialize() As Boolean
        Try
            ' Create a new XmlSerializer instance.
            Dim XMLFilePathName As String = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "OGameStrategeConfig.xml")



            Dim s As New Xml.Serialization.XmlSerializer(GetType(Config))

            ' Writing the XML file to disk requires a TextWriter.
            Dim writer As New StreamWriter(XMLFilePathName)

            ' Serialize the object, and close the StreamWriter.
            s.Serialize(writer, Me)
            writer.Close()
        Catch x As System.InvalidOperationException
            'MsgBox(x.Message)
            Throw New Exception("Config serialization Error", x)
            'Throw New Exception("Check class OGameAccount, all derrived classes " + _
            '"must be listed with the [ XmlInclude" + _
            '"(GetType(derrivedClass)) ] attribute!")
        End Try
    End Function
    Public Shared Function XMLDeSerialize() As Config
        Try

            Dim XMLFilePathName As String = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "OGameStrategeConfig.xml")


            Dim fs As New IO.FileStream(XMLFilePathName, FileMode.Open)
            Dim w As New Xml.Serialization.XmlSerializer(GetType(Config))
            Dim g As Config = CType(w.Deserialize(fs), Config)

            fs.Close()
            'TraceLine("Accounts: " & g.List.Count & " accounts.", OGame.TraceCategory.ProgramInformation)
            Return g

        Catch x As Exception
            Return New Config
        End Try
    End Function
    Private pClipboardMonitoring As Boolean = True
    <Description("Monitor Clipboard / Surveille le presse papiers"), Category("Behaviors")> _
    Public Property ClipboardMonitoring() As Boolean
        Get
            Return pClipboardMonitoring
        End Get
        Set(ByVal Value As Boolean)
            pClipboardMonitoring = Value
        End Set
    End Property

    Private pOwnerName As String = "Default"
    <Description("Nom fourni lors des detections de données ogame"), Category("Detection")> _
    Public Property OwnerName() As String
        Get
            Return pOwnerName
        End Get
        Set(ByVal Value As String)
            pOwnerName = Value
        End Set
    End Property

    Private p_HideTitleBar As Boolean = False
    <Description("Hide the title bar/ Cache la barre de titre"), Category("Behaviors")> _
     Public Property HideTitleBar() As Boolean
        Get
            Return p_HideTitleBar
        End Get
        Set(ByVal Value As Boolean)
            p_HideTitleBar = Value
        End Set
    End Property


    Public AutoCheckOGSUpdate As Boolean = True
    Public URLOGSCheckUpdate As String = "http://ogsteam.fr/ogsversion.xml"
    Public ShowCurrentDevUpdate As Boolean = False
    Public PlayerNameChangeDefaultValue As enDefaultAnswer = enDefaultAnswer.Ask
    Public WAVDetectClipboard As String = ""
    Public WAVDetectGalaxy As String = ""
    Public WAVDetectStats As String = ""
    Public WAVDetectEspio As String = ""
    Public WAVDetectAttack As String = ""
    Public WindowsTop As Integer
    Public WindowsLeft As Integer
    Public WindowsWidth As Integer
    Public WindowsHeight As Integer
    Public MoniteurWidth As Integer = 480
    Public MoniteurHeight As Integer = 144
    Private p_AlwaysOnTop As Boolean = False

    Private pProxyUrl As String = ""
    Public Property ProxyURL() As String
        Get
            Return pProxyUrl
        End Get
        Set(ByVal Value As String)
            pProxyUrl = Value
            OGameObject.SharingDB.proxyurl = Value
        End Set
    End Property
    <Description("Always on Top / Fenètre principale par dessus les autres"), Category("Detection")> _
     Public Property AlwaysOnTop() As Boolean
        Get
            Return p_AlwaysOnTop
        End Get
        Set(ByVal Value As Boolean)
            p_AlwaysOnTop = Value
        End Set
    End Property

    Private p_HideMenu As Boolean = False
    <Description("Hide menu / Cache le menu"), Category("Behaviors")> _
     Public Property HideMenu() As Boolean
        Get
            Return p_HideMenu
        End Get
        Set(ByVal Value As Boolean)
            p_HideMenu = Value
        End Set
    End Property
    Private pDBServertype As Integer = 1
    <Description("Mode de fonctionnement de firebird " & vbCrLf & "1 = embedded , 3 = Server"), Category("Local Server")> _
    Public Property DBServertype() As Integer
        Get
            Return pDBServertype
        End Get
        Set(ByVal Value As Integer)
            pDBServertype = Value
        End Set
    End Property
    Private pHideFromTaskBar As Boolean = False
    <Description("Hide OGS entry from taskbar"), Category("Behaviors")> _
    Public Property HideFromTaskBar() As Boolean
        Get
            Return pHideFromTaskBar
        End Get
        Set(ByVal Value As Boolean)
            pHideFromTaskBar = Value
        End Set
    End Property
    Private pEnableSound As Boolean = False
    <Description("Enable / Disable sound  "), Category("Behaviors")> _
    Public Property EnableSound() As Boolean
        Get
            Return pEnableSound
        End Get
        Set(ByVal Value As Boolean)
            pEnableSound = Value
        End Set
    End Property

    Private pServerName As String = "localhost"
    <Description("Nom du serveur firebird " & vbCrLf & "(si servertype est différent de 1)"), Category("Local Server")> _
    Public Property ServerName() As String
        Get
            Return pServerName
        End Get
        Set(ByVal Value As String)
            pServerName = Value
        End Set
    End Property

    <Description("Mode Debug" & vbCrLf & "Un fichier ogs_debug.txt est cree, a n'utiliser que quand il y a un probleme que vous n'arrivez pas a résoudre"), Category("Debug")> _
    Private pDebugMode As Boolean = False
    Public Property DebugMode() As Boolean
        Get
            Return pDebugMode
        End Get
        Set(ByVal Value As Boolean)
            pDebugMode = Value
        End Set
    End Property

    Protected Overrides Sub Finalize()
        Me.XMLSerialize()
        MyBase.Finalize()
    End Sub
End Class
