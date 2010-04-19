''' <summary>
''' Collection de statistiques alliances ; AllyRank
''' </summary>
''' <remarks>01/06/06 ericalens : Creation</remarks>
<Serializable()> Public Class AllyRankCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As AllyRank
        Get
            Return CType(List(index), AllyRank)
        End Get
        Set(ByVal Value As AllyRank)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As AllyRank) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As AllyRank) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As AllyRank)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As AllyRank)
        List.Remove(value)
    End Sub 'Remove
End Class
