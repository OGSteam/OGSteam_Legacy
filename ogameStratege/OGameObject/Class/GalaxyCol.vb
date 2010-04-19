
Imports FirebirdSql.Data.FirebirdClient
Imports System.IO
Imports System.Xml



''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : GalaxyCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Collection typés de systeme (Galaxy)
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class GalaxyCol
    Inherits CollectionBase
    Public Event GalaxyReaded(ByVal ReadedGalaxy As Galaxy)
    Default Public Property Item(ByVal index As Integer) As Galaxy
        Get
            Return CType(List(index), Galaxy)
        End Get
        Set(ByVal Value As Galaxy)
            List(index) = Value
        End Set
    End Property
    Public Function PlanetForOwner(ByVal OwnerID As Integer) As PlanetCol
        Dim retval As PlanetCol = New PlanetCol
        For Each g As Galaxy In list
            For Each p As Planet In g.Planets
                If p.Owner.ID = OwnerID Then
                    retval.Add(p)
                End If
            Next
        Next
        Return retval
    End Function
    Public Function GetSystemIfReaded(ByVal Gal As Integer, ByVal Sys As Integer) As Galaxy
        For Each g As Galaxy In list
            If g.Galaxy = Gal AndAlso g.System = Sys Then Return g
        Next
        Return Nothing
    End Function
    Public Function ReadSystems(ByVal Gal As Integer, ByVal StartSys As Integer, ByVal EndSys As Integer, Optional ByVal readspy As Boolean = False, Optional ByVal readrank As Boolean = False) As Boolean
        If Gal < 0 OrElse Gal > 9 OrElse StartSys < 0 OrElse StartSys > 499 OrElse EndSys < 0 OrElse EndSys > 499 OrElse EndSys < StartSys Then Return False
        For i As Integer = StartSys To EndSys
            Dim g As Galaxy = GetSystem(Gal, i, readspy, readrank)
            'If Not g Is Nothing Then RaiseEvent GalaxyReaded(g)
        Next
    End Function
    Public Function GetSystem(ByVal Gal As Integer, ByVal Sys As Integer, Optional ByVal readspy As Boolean = False, Optional ByVal readrank As Boolean = False) As Galaxy
        Dim gu As Galaxy = GetSystemIfReaded(Gal, Sys)
        If gu Is Nothing Then
            gu = Galaxy.FromCoords(Gal, Sys)
            If Not gu Is Nothing Then
                Add(gu)
                If readspy OrElse readrank Then
                    For Each p As Planet In gu.Planets
                        Dim dummy As Object
                        If readspy Then dummy = p.SpyingReports
                        If readrank AndAlso Not p.Owner Is Nothing Then
                            dummy = p.Owner.RankPoints
                            dummy = p.Owner.RankFlotte
                            dummy = p.Owner.RankResearch
                        End If
                    Next
                End If
                RaiseEvent GalaxyReaded(gu)
            End If
        End If

        Return gu
    End Function
    Public Function Add(ByVal value As Galaxy) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As Galaxy) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As Galaxy)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As Galaxy)
        List.Remove(value)
    End Sub 'Remove
    Public Function MEMXMLSerialize() As String
        Dim s As New Xml.Serialization.XmlSerializer(GetType(GalaxyCol))

        ' Writing the XML file to disk requires a TextWriter.
        Dim writer As New StringWriter

        ' Serialize the object, and close the StreamWriter.
        s.Serialize(writer, Me)
        writer.Close()
        Return writer.ToString
        'Return True
    End Function
    Public Function XMLSerialize(ByVal XMLFilePathName As String) As Boolean
        Try
            ' Create a new XmlSerializer instance.
            If XMLFilePathName = "" Then
                XMLFilePathName = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "galaxyexport.xml")

            End If

            Dim s As New Xml.Serialization.XmlSerializer(GetType(GalaxyCol))

            ' Writing the XML file to disk requires a TextWriter.
            Dim writer As New StreamWriter(XMLFilePathName)

            ' Serialize the object, and close the StreamWriter.
            s.Serialize(writer, Me)
            writer.Close()
            Return True
        Catch x As System.InvalidOperationException
            System.Windows.Forms.MessageBox.Show(x.Message)
            Throw New Exception("Galaxy serialization", x)
        End Try
    End Function
    Public Shared Function XMLDeSerialize(ByVal XMLFilePathName As String) As GalaxyCol
        Try
            If XMLFilePathName = "" Then
                XMLFilePathName = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "universesdb.xml")
            End If

            Dim fs As New IO.FileStream(XMLFilePathName, FileMode.Open)
            Dim w As New Xml.Serialization.XmlSerializer(GetType(GalaxyCol))
            Dim g As GalaxyCol = CType(w.Deserialize(fs), GalaxyCol)

            fs.Close()
            Return g

        Catch x As Exception
            Windows.Forms.MessageBox.Show(x.Message & vbCrLf & x.StackTrace)

        End Try
        Return Nothing
    End Function
End Class