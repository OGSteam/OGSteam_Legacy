''' <summary>
''' Collection d'Alliance
''' </summary>
''' <remarks>01/06/06 ericalens - Création</remarks>
<Serializable()> Public Class AllyCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As Ally
        Get
            Return CType(List(index), Ally)
        End Get
        Set(ByVal Value As Ally)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As Ally) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As Ally) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As Ally)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As Ally)
        List.Remove(value)
    End Sub 'Remove

End Class
