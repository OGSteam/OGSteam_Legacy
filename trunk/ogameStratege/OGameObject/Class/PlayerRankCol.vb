

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : PlayerRankCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Collection typés de statistiques joueurs
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class PlayerRankCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As PlayerRank
        Get
            Return CType(List(index), PlayerRank)
        End Get
        Set(ByVal Value As PlayerRank)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As PlayerRank) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As PlayerRank) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As PlayerRank)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As PlayerRank)
        List.Remove(value)
    End Sub 'Remove
End Class