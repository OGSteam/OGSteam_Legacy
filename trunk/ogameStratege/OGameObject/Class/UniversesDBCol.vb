Imports System.IO


''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : UniversesDBCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Collection typés d'UniversesDB
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class UniversesDBCol
    Inherits CollectionBase
    Public Function Save() As Boolean
        Return XMLSerialize()
    End Function
    Public Function XMLSerialize(Optional ByVal XMLFilePathName As String = "") As Boolean
        Try
            ' Create a new XmlSerializer instance.
            If XMLFilePathName = "" Then
                XMLFilePathName = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "universesdb.xml")

            End If

            Dim s As New Xml.Serialization.XmlSerializer(GetType(UniversesDBCol))

            ' Writing the XML file to disk requires a TextWriter.
            Dim writer As New StreamWriter(XMLFilePathName)

            ' Serialize the object, and close the StreamWriter.
            s.Serialize(writer, Me)
            writer.Close()
            Return True
        Catch x As System.InvalidOperationException
            System.Windows.Forms.MessageBox.Show(x.Message)
            Throw New Exception("UniversesDB serialization", x)
        End Try
    End Function
    Public Shared Function Load() As UniversesDBCol
        Return XMLDeSerialize()
    End Function

    Public Shared Function XMLDeSerialize(Optional ByVal XMLFilePathName As String = "") As UniversesDBCol
        Try
            If XMLFilePathName = "" Then
                XMLFilePathName = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "universesdb.xml")
            End If

            Dim fs As New IO.FileStream(XMLFilePathName, FileMode.Open)
            Dim w As New Xml.Serialization.XmlSerializer(GetType(UniversesDBCol))
            Dim g As UniversesDBCol = CType(w.Deserialize(fs), UniversesDBCol)

            fs.Close()
            Return g

        Catch x As Exception
            Return New UniversesDBCol
            System.Windows.Forms.MessageBox.Show(x.Message)
            Throw New Exception("Account deserialization error", x)
        End Try
    End Function

    Public ReadOnly Property RegisteredUniverse(ByVal uniSearched As UniverseDB) As UniverseDB
        Get
            For Each u As UniverseDB In list
                If u.UniverseName = uniSearched.UniverseName Then
                    Return u
                End If
            Next
            Return Nothing
        End Get
    End Property
    Default Public Property Item(ByVal index As Integer) As UniverseDB
        Get
            Return CType(List(index), UniverseDB)
        End Get
        Set(ByVal Value As UniverseDB)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As UniverseDB) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As UniverseDB) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As UniverseDB)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As UniverseDB)
        List.Remove(value)
    End Sub 'Remove
End Class